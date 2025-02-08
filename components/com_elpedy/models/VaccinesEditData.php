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
use components\com_elpedy\ComUtils;
use Joomla\Registry\Registry;
use JModelDatabase;
/**
 * Gets step list data
 * @author E-Logism
 */

class VaccinesEditData extends JModelDatabase {   
    public function getState(): Registry {
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        $state = parent::getState();
        $id = $state -> get('id', 0);
        $data = [
            'patientData' => $this -> getPatientData( $db, $query, $id),
            'vaccinesTransactions' => $this -> getVaccinesTransactionData($db, $query, $id)
        ];
        $state -> set('data', $data);
        return $state;
    }   
    
    
    private function getPatientData ( $db , $query, $id )
    {
        return $db -> setQuery (
                $query -> clear()
                -> select('id,  HealthUnitId, area_id, school_id, school_class_id, birthday, RefDate,  isMale, nationality_id, father_profession, mother_profession')
                -> from ('Vaccine_Patient')
                -> where ('id =' . $db -> quote ( $id ) )
                ) 
                -> loadAssoc();
    }
    
    private function getVaccinesTransactionData ( $db, $query, $id) 
    {
        return 
                $db -> setQuery ( 
                        $query 
                        -> clear()
                        -> select('vaccine_patient_id, vaccine_vaccinestep_id ')
                        -> from ('Vaccine_Transaction')
                        -> where ( 'vaccine_patient_id = ' . $db -> quote( $id ) )
                        ) 
                -> loadRowList();        
    }
    
}
