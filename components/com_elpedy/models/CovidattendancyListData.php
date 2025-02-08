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

class CovidattendancyListData extends JModelDatabase {   
   
    
    
    public function getState(): Registry {
        $state = parent::getState();
        $dataDB = ComUtils::getPedyDB();
        $id_health_unit =  $state -> get("id_health_unit");
        $ref_date = $state -> get("ref_date");
        
        
        $task = $state -> get('task', 'head');
        if ( $task === 'head')
        {
            $data = $this -> getHeadData($dataDB, $ref_date, $id_health_unit);
           
         }
        elseif ( $task === 'details')
        {
            $data =[];
            $limit_start = $state -> get('limit_start');
            $limit = $state -> get('limit'); 
            $filter_order =$state -> get('filter_order', 'ref_date');
            $filter_orderDir = $state -> get('filter_order_Dir', 'desc');
            $data['details'] = $this ->getDetailsList($id_health_unit, $ref_date, $limit_start, $limit, $filter_order, $filter_orderDir, $dataDB);
            $data['sums'] = $this ->getSums($id_health_unit, $ref_date, $dataDB);
            
        }
        elseif( $task === "item") {
            $id = $state -> get('id', 0); 
            $data = $this ->getDetailItem($dataDB, $id);
        }
       
        
//        if ( ! $this ->checkHealthUnit( $state -> get ( 'id_health_unit', 0 )  ) ):
//            Factory::getApplication() -> enqueueMessage(  Text::_('COM_EL_DATA_PERMISSION_ERROR_100'), 'warning' );
//            return new Registry(['data' => [], 'total' => 0 ] );
//        endif;
        return new Registry($data);
    }
    
    
    private function getDetailsList($id_health_unit, $ref_date, $limit_start, $limit, $filter_order, $filter_orderDir, $db)
    {
        
        $query = $db -> getQuery(true);
        $query -> select(  "ad.id, hospital_prompt, age, id_action, am.attendancy_medium, g.gender, ad.id_covidattendancy, id_treatment,ctr.yesno, country as nationality, residence")
                -> from ( "CovidAttendancyDetails ad ")
                -> innerJoin ( "CovidAttendancyMedium am on ad.id_attendancy_medium = am .id")
                -> innerJoin ("Gender g on ad.id_gender = g.id")
                -> innerJoin("country c on c.id =  ad.id_nationality  and c.enabled ='Y' ")
                -> innerJoin("country_translation ct on  ct.idCountry = c.id and ct.language ='el-GR' ")
                -> innerJoin ("CovidAttendancyHead ah on ah.id = ad.id_covidattendancy")
                -> innerJoin("yesno ctr on ctr.id = ad.id_treatment")
                -> where ( "ah.ref_date =" . $db -> quote( $ref_date  ) . " and id_health_unit = " . $id_health_unit   )
                -> order("ad.date_modif", $filter_order . ' ' . $filter_orderDir ) ;
  
        return  FrmBsTable::getData($db, $query, $limit_start, $limit ) ;
    }
    
    private function getSums($id_health_unit, $ref_date,  $db) {
        
        $query = $db -> getQuery(true);
        $query -> select(  "count(*) as cnt, id_action, id_gender")
           -> from ( "CovidAttendancyDetails ad ")
           -> innerJoin ("CovidAttendancyHead ah on ah.id = ad.id_covidattendancy")
           -> where ( "ah.ref_date =" . $db -> quote( $ref_date  ) . " and id_health_unit = " . $id_health_unit   )
           -> group("id_action, id_gender");
       
        $ret =  $db -> setQuery($query) ->loadAssocList();
        if ( $ret === null ) {
            return [];
        }
        else {
            return $ret;
        }
        
    }
    
    
    
    
    private function getDetailItem($dataDB, $id)
    {
        $query = $dataDB -> getQuery(true);
        $query -> select(  "*")
                -> from ( "CovidAttendancyDetails ad ")
                ->where ("id = " . $id);
  
        return $dataDB -> setQuery( $query ) -> loadAssoc();
    }
    
    private function getHeadData($db, $ref_date, $id_health_unit) {
        $query = $db -> getQuery(true);
        $query -> select(  "*")
                -> from ( "CovidAttendancyHead ch ")
                -> where ( "ch.ref_date =" . $db -> quote( $ref_date  ) . " and ch.id_health_unit = " . $id_health_unit   ) ;
       
        $data =  $db -> setQuery($query)-> loadAssoc();
        $data['id_health_unit'] = $id_health_unit;
        $data['ref_date'] = $ref_date;
        return $data;
    }
    
    private function checkHealthUnit( $HealthUnitId )
    {
        if ( !trim($HealthUnitId) > 0 || !is_numeric( $HealthUnitId ) ):
            return false;
        endif;
    
        $huIds = array_column( ComUtils::getUserHealthUnits(), 'HealthUnitId' );
        if ( !in_array( $HealthUnitId , $huIds) ):
            return false;
        endif;
        return true;
    }
    
    
}
