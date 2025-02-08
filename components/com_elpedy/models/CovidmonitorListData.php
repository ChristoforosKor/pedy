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

class CovidmonitorListData extends JModelDatabase {   
    
    
    public function getState() {
        
        $state = parent::getState();
        $id_health_unit =  $state -> get("id_health_unit");
        $ref_date = $state -> get("ref_date");
       
        $limit_start = $state -> get('limit_start');
        $limit = $state -> get('limit'); 
        $filter_order =$state -> get('filter_order', 'ref_date');
        $filter_orderDir = $state -> get('filter_order_Dir', 'desc');
        $task = $state -> get('task', 'head');
        $dataDB = ComUtils::getPedyDB();
        if ( $task === 'head')
        {
            
            $data = $this -> getHeadData($dataDB, $ref_date, $id_health_unit);
            $unitsIds = ComUtils::getUserHealthUnits();
           // $unitsIds =[ ['HealthUnitId' => 137], ['HealthUnitId' => 138] ];
       
            $data['userUnitsClinics'] = $this -> getClinicTypes(array_column($unitsIds, 'HealthUnitId'), $dataDB);
            $data ['personelSpecialities'] = $this -> getPersonelsSpecialities($ref_date, array_column($unitsIds, 'HealthUnitId'), $id_health_unit, $dataDB);
           
        }
        elseif ( $task === 'details')
        {
            $data =[];            
            $data['details'] = $this ->getDetailsList($dataDB, $ref_date,  $id_health_unit, $filter_order, $filter_orderDir, $limit, $limit_start);                 
        }
        elseif( $task === "item") {
            $id = $state -> get('id', 0); 
            $data = $this ->getDetailItem($dataDB, $id);
        }
       return $data;
        
       
    }
    
    private function getPersonelsSpecialities($ref_date, $unitsIds, $selectedHUID, $db) 
    {
      

        if ( count($unitsIds)> 0 )
        {
            $query = $db -> getQuery( true );
            $query -> select(" p.personelId, concat( p.LastName, ' ', p.FirstName  ) as personelName, ps.PersonelSpecialityId, ps.DescEL as personelSpeciality, hh.HealthUnitId, hh.RefHealthUnitId ")
                -> from ("PersonelHealthUnitHistory hh")
                -> innerJoin("Personel p on p.personelId = hh.PersonelId and hh.HealthUnitId in (" . implode(",", $unitsIds ) . ")  and ( hh.EndDate is null or ( hh.StartDate <= " . $db -> quote( $ref_date . " 23:23:59" )  . " and hh.EndDate >= " . $db -> quote($ref_date . " 00:00:00" ) .  ") )" )
                -> innerJoin (" PersonelSpecialityHistory ph on ph.personelId = p.personelId  and ( ph.EndDate is null or ( ph.StartDate <= " . $db -> quote( $ref_date . " 23:23:59") . " and ph.EndDate >= " . $db -> quote ($ref_date . " 00:00:00") ." )  ) " )
                -> innerJoin ("PersonelSpeciality ps on ps.PersonelSpecialityId = ph.SpecialityId" );
                //-> order ("RefHealthUnitId, personelName");
            $q2 = $db ->getQuery(true);
            $q2 -> select ("p.personelId, concat( p.LastName, ' ', p.FirstName ) as personelName, ps.PersonelSpecialityId,  ps.DescEL as personelSpeciality,hh.HealthUnitId, hh.RefHealthUnitId")
            -> from ("PersonelHealthUnitHistory hh")
            -> innerJoin ("Personel p on p.personelId = hh.PersonelId and (hh.HealthUnitId=" .$selectedHUID . "  or hh.RefHealthUnitId= " . $selectedHUID 
              . " and  (hh.EndDate is null or  (hh.StartDate <=  " . $db -> quote( $ref_date . " 23:23:59" ) . "  and hh.EndDate >= "  . $db -> quote ($ref_date . " 00:00:00") . ")))
    inner Join  PersonelSpecialityHistory ph on ph.personelId = p.personelId  and ( ph.EndDate is null or ( ph.StartDate <= " . $db -> quote( $ref_date . " 23:23:59" ) . " and ph.EndDate >= "  . $db -> quote ($ref_date . " 00:00:00") . "))")
            -> innerJoin (" PersonelSpeciality ps on ps.PersonelSpecialityId = ph.SpecialityId ")
            -> order ("RefHealthUnitId, personelName");
            $query -> union( $q2);
//           echo $query -> dump();
//            exit;
            return $db -> setQuery($query) -> loadObjectList();
        }
        else {
            return [];
        }
        
    }
    
    private function getClinicTypes($unitsIds, $db) {
       
        if ( count($unitsIds)> 0 )
        {
             $query = $db -> getQuery(true);
             $query -> select ("hcr.HealthUnitId, ct.ClinicTypeId, DescEL")
                     -> from ("HealthUnitClinicRel hcr inner join ClinicType ct on hcr.ClinicTypeId = ct.ClinicTypeId")
                     -> where ("HealthUnitId in (" .  implode(",", $unitsIds ) . ") " );
             // echo $query -> dump();
             return $db -> setQuery( $query ) -> loadObjectList();
            
        }
        else
        {
            return [];
        }
       
    }

    
    private function getHeadData($db, $ref_date, $id_health_unit ) {
        
        $query = $db -> getQuery(true);
        $query -> select(  "*")
            -> from("CovidMonitorHead h ")
            -> where ( " h.ref_date =" . $db -> quote($ref_date ) . " and h.id_health_unit = " . $id_health_unit   );
       $data =  $db -> setQuery($query)-> loadAssoc();
        if ( $data == null ) {
            $data = [];
        }
        $data['id_health_unit'] = $id_health_unit;
        $data['ref_date'] = $ref_date;
        
       return $data;
       
    }
    
    
    private function getDetailsList($db, $ref_date, $id_health_unit, $filterOrder, $filter_orderDir, $limit, $limit_start) {
       
        $query = $db -> getQuery(true);
        $query -> select(  "m.id, g.gender,  m.age, lc.labCheck, co.outcome")
            -> from ( "CovidMonitorDetails m ")
			-> innerJoin("Gender g on g.id = m.id_gender")
            -> innerJoin("CovidMonitorHead h on h.id = m.id_covidmonitor")
            -> innerJoin ( "CovidLabCheck lc on lc.id = m.id_labcheck")
			-> innerJoin ( "CovidOutcome co on co.id = m.id_outcome")
            -> where ( " h.ref_date =" . $db -> quote( $ref_date ) . " and h.id_health_unit = " . $id_health_unit   )
            -> order("m.date_modif", $filterOrder . ' ' . $filter_orderDir ) ;
   
        return  FrmBsTable::getData($db, $query, $limit_start, $limit  ) ;
       
    }
    
     private function getDetailItem($dataDB, $id)
    {
        $query = $dataDB -> getQuery(true);
        $query -> select(  "*")
                -> from ( "CovidMonitorDetails ad ")
                ->where ("id = " . $id);
 
        return $dataDB -> setQuery( $query ) -> loadAssoc();
    }
    
}
