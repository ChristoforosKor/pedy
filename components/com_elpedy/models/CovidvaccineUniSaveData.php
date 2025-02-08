<?php
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\models;
defined('_JEXEC') or die('Restricted access');
// use elogism\datatemplates\FrmBsTable;
use Joomla\Registry\Registry;
use JModelDatabase;
use components\com_elpedy\ComUtils;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
/**
 * Gets step list data
 * @author E-Logism
 */

class CovidvaccineUniSaveData extends JModelDatabase {   
   
    public function setState(Registry $state) {
        $task = $state -> get('task');
      
       $this ->getDb();
      
       if ( $task === 'savedetails') {
            $newState = $this -> saveDetails ( $state );
        }
        elseif ( $task === 'savevaccines') {
            $newState = $this -> saveVaccines ( $state );
        }
       
//        $data = $state -> toArray();
//        if ( $data['Quantity'] == 0 ) {
//            $stData =$this -> deleteRecord($data);
//        }
//        else {
//            $stData = $this -> saveRecord($data);
//        }
//        $newState = new Registry($stData);
        parent::setState( $newState );
    }       
    
    
    
    
    protected function saveDetails($state) {
        $data = $state -> toArray();
        if ( $data['Quantity'] == 0 ) {
            $stData =$this -> deleteRecord($data);
        }
        else {
            $stData = $this -> saveRecord($data);
        }
        $newState = new Registry($stData);
        return $newState;
      
    }
    
    protected function saveRecord( $data ) {
        if ( $data['CovidVaccineTransactionId'] === 0 ) {
            $data['CovidVaccineTransactionId'] = null;
        }
        $data['id_user_modif'] = Factory::getUser() -> id;
        $data['date_modif'] =  date('Y-m-d H:i:s');      
//        print_r($data);
        $tb = Table::getInstance("covidvaccineunitransaction");        
        $tb -> bind ( $data );
        $tb -> store();
       // var_dump($tb -> CovidVaccineTransactionId);
        $data['CovidVaccineTransactionId'] = $tb -> CovidVaccineTransactionId;

        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
        return $data;
    }
     
    protected function deleteRecord($data)
    {
        $tb = Table::getInstance("covidvaccineunitransaction");
        $tb -> load($data['CovidVaccineTransactionId'] );
        $tb ->delete();
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_DELETE_SUCCESS'), 'success');
        return $data;
    }
    
    protected function saveVaccines($state) {
        $data = $state -> toArray();
        $db =   ComUtils::getPedyDB();
        $do = new \stdClass();
        $refDate =  $data["RefDate"];       
        $healthUnitId =  $data["HealthUnitId"];
        $covidVaccineCompanyId =  $data["CovidVaccineCompanyId"];

        $query  = $this -> getDb() -> getQuery(true);
        
        $query -> select ("CovidVaccineRecRejId")
                -> from ("#__CovidVaccineUniRecRej")
                -> where ("RefDate = " . $db -> quote ( $refDate ) . " and HealthUnitId = " . $healthUnitId 
                        . " and CovidVaccineCompanyId = " . $covidVaccineCompanyId );
        $covidVaccineRecRejId = $db -> setQuery($query) -> loadResult();
        
        if ( $covidVaccineRecRejId > 0  ) {
            $do -> covidVaccineRecRejId = $covidVaccineRecRejId;
        }
        else {
            $do -> covidVaccineRecRejId = null;
        }
        $do -> HealthUnitId = $healthUnitId;
        $do -> RefDate = $refDate;
        $do -> covidVaccineCompanyId = $covidVaccineCompanyId;
        $do -> ReceivedQuantity = ( $data['ReceivedQuantity'] > -1 ? $data['ReceivedQuantity'] : null);
        $do -> RejectedQuantity = ( $data['RejectedQuantity'] > -1 ? $data['RejectedQuantity'] : null );
        if ( $do -> covidVaccineRecRejId > 0 ) {
            $db -> updateObject('#__CovidVaccineUniRecRej', $do, 'covidVaccineRecRejId');
        }
        else {
            $db ->insertObject('#__CovidVaccineUniRecRej', $do); 
        }
        $data['covidVaccineRecRejId'] =  $do -> covidVaccineRecRejId ;
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
        return new Registry($data);
    }
    
  
}
