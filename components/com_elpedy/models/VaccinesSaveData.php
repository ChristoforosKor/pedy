<?php
/*------------------------------------------------------------------------
# com_elergon - E-Logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\models;
defined('_JEXEC') or die('Restricted access');
//use elogism\storeimplementation\StorerTable;
use Joomla\CMS\Table\Table;
//use elogism\models\ElModelStore;
use components\com_elpedy\ComUtils;
use JModelBase;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
class VaccinesSaveData extends JModelBase {   
 
    
      public function setState(Registry $state) {
        $tbVaccinesPatient = Table::getInstance('VaccinePatient');
        $data = $state -> toArray();
        $tbVaccinesPatient -> bind(  $data );
        $tbVaccinesPatient -> check();
        $tbVaccinesPatient -> store();
        
        $id = $tbVaccinesPatient -> id;
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        $query -> select ('vaccine_vaccinestep_id') -> from('Vaccine_Transaction') -> where ('vaccine_patient_id = ' . $id);
        $stored = array_column( $db ->  setQuery ( $query ) ->loadRowList(), 0 );
        $updates = $state -> get( 'v', [] );
        $toDel = array_diff($stored , $updates);
        
        $this -> delVaccines( $db, $toDel, $id );
        $toIns =array_diff( $updates, $stored);
        $this -> insNewVaccines ( $db, $toIns, $id);
        
        $state -> set('id', $id );
        parent::setState( $state );
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
    }
    
    private function delVaccines($db, $vaccines, $patientId)
    {
        if( count( $vaccines )  <= 0 ):
            return null;
        endif;
            $query = $db -> getQuery(true); 
            $query 
                    -> delete ('Vaccine_Transaction') 
                    -> where ( 'vaccine_patient_id = ' . $patientId . ' and vaccine_vaccinestep_id in ('. implode( ',', $vaccines ) . ')' );

            return $db -> setQuery( $query ) -> execute();
        
    }
    
    private function insNewVaccines($db, $vaccines, $patientId)
    {
        if ( count( $vaccines ) <= 0 ):
            return null;
        endif;
           $query = $db -> getQuery(true); 
        $query 
                -> insert ('Vaccine_Transaction')
                -> columns('vaccine_patient_id, vaccine_vaccinestep_id');
        forEach ( $vaccines as $item):
            $query -> values ( $patientId . ', ' .  $item);
        endforeach;
        unset($item);
            return $db -> setQuery( $query ) -> execute();
    }
}
