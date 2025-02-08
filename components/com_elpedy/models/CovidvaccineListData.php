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
use elogism\datatemplates\FrmBsTable;
use Joomla\Registry\Registry;
use JModelDatabase;
use components\com_elpedy\ComUtils;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
/**
 * Gets step list data
 * @author E-Logism
 */

class CovidvaccineListData extends JModelDatabase {   
    
    
    public function getState() {
     
        $state = parent::getState();
       
        $id_health_unit =  $state -> get("id_health_unit");
        $ref_date = $state -> get("ref_date");
       // $sectorid = $state ->get ('MunicipalitySectorId', 0);
        $task = $state -> get('task', 'data');
        $dataDB = ComUtils::getPedyDB();
        $query = $dataDB ->getQuery(true);
        $data = [];
      
        if ( $task === 'data') {
            $data["transaction"] = $this ->getVaccineTransation($ref_date, $id_health_unit/*, $sectorid*/, $dataDB, $query);
            $data['bottles'] = $this ->getVaccineBottles($ref_date, $id_health_unit/*, $sectorid*/, $dataDB, $query);
            $data['manufacturers'] = $this ->getManufacturers($id_health_unit, $dataDB);
        }
       
        $state -> set("data", $data);
        parent:: setState($state);
        return $state;
    }
    
    
    public function getVaccineTransation($refDate, $selectedHUID, /*$selectedSectorId,*/ $db, $query) {
        $query -> clear();
        $query -> select ( "ct.CovidVaccineTransactionId, c.CovidVaccineId, c.CovidVaccineDesc, ct.ClinicIncidentGroupId, ct.Quantity,ct.CovidVaccineCompanyId")
                ->from( "CovidVaccine c " )
                -> innerJoin ("CovidVaccineTransaction ct on ct.CovidVaccineId = c.CovidVaccineId and ct.RefDate between " . $db -> quote($refDate . " 00:00:00") . " and "  . $db -> quote($refDate . " 23:59:59") 
                      /* . " and ct.MunicipalitySectorId = " . $selectedSectorId */ . "  and ct.HealthUnitId = " . $selectedHUID );
//      echo $query -> dump();
//      exit;
        return  $db -> setQuery ( $query ) -> loadAssocList("CovidVaccineTransactionId");
   }
    
    public function getVaccineBottles($refDate, $selectedHUID, /*$selectedSectorId,*/ $db, $query) {
        $query -> clear();
        $query -> select ( " CovidVaccineRecRejId, HealthUnitId, CovidVaccineCompanyId, ReceivedQuantity, RejectedQuantity,RefDate")
                ->from( "CovidVaccineRecRej  " )
                -> where ("RefDate between " . $db -> quote($refDate . " 00:00:00") . " and "  . $db -> quote($refDate . " 23:59:59") 
                      . "  and HealthUnitId = " . $selectedHUID );

        return  $db -> setQuery ( $query ) -> loadAssocList();
   }
   
   public function getManufacturers($id_health_unit, $db) {
       $query = $db -> getQuery(true);
       $query -> select ( "vc.CovidVaccineCompanyId, cvhr.HealthUnitId, vc.CovidVaccineCompanyDesc")
               -> from ("CovidVaccineHuCompanyRel cvhr")
               -> innerJoin ("CovidVaccineCompanies vc on vc.CovidVaccineCompanyId = cvhr.CovidVaccineCompanyId");
       if ( $id_health_unit < 26 ) {
            $query -> WHERE ("HealthUnitId = " . $id_health_unit);
       }
       else {
           $query -> WHERE ("HealthUnitId = " . $id_health_unit . " and vc.CovidVaccineCompanyId != 3");
       } 
       return $db -> setQuery($query) -> loadObjectList();
   }
  
   

}
 	 	 	 	 	