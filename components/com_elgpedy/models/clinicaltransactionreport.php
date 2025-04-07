<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';
require_once JPATH_COMPONENT_SITE . '/models/missingdates.php';
 
class ElgPedyModelClinicalTransactionReport extends PedyDataEdit
{
	private static $LAST_OLD_DATE = '2017-12-31'; // last date of old status. 
	private static $FIRST_NEW_DATE = '2018-01-01'; //first date of new status.
    public function getState()
    {
        $data = new stdClass();
		$state = parent::getState();
		$whereClause = ' ct.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and ct.HealthUnitId = ' . $state -> get('HealthUnitId'); 
        /** spliting the date ranges in the time before changed date and the time after it **/
		$from = $state->get('RefDateFrom', '');
		$to = $state->get('RefDateTo', '');
		$data -> checker = $this -> getOldCheckers($this -> pedyDB, $state);
		$districtId = ComponentUtils::getDistrictIdBySelectedUnitId( JFactory::getApplication()->getUserState('lastUnit', 0) );
//		if ( $districtId === '2' ):
//                                  
//			$d1 = $this -> getDateRanges1($from, $to);
//			$d2 = [];
//		else:
         
			$d1 = $this -> getDateRanges1($from, $to);
			$d2 = $this -> getDateRanges2($from, $to);
//		endif;
                
		if ( count($d1) > 0 ) :
			$data -> data = $this -> getOldStatusData($this -> pedyDB, $whereClause . ' and ct.RefDate >= \'' . $d1['start'] . '\' and ct.RefDate <= \'' . $d1['end'] . '\'' );
			$data -> d1 = $d1;
		endif;
		
		if( count($d2) > 0 ):
			$data -> newData = $this -> getNewStatusData($this -> pedyDB, $whereClause . ' and ct.RefDate >= \'' . $d2['start'] . '\' and ct.RefDate <= \'' . $d2['end'] . '\'');
			
			$data -> doctors = $this -> getDoctors($this -> pedyDB, $state -> get('HealthUnitId'));
			$data -> d2 = $d2;
                                
		endif;
	
        if($data->checker ==  null)
        {
			$data->checker = 0;
		}
		
        $data->inClinicGroup = $this->getDataInClinicGroups($this -> pedyDB, $whereClause);        
        if($state->get('format') == 'html')
        {
                $data->fields = new stdClass();
                $this->query->clear();
                $this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s');
                $this->pedyDB->setQuery($this->query);
                $data->incidents = $this->pedyDB->loadObjectList('IncidentId');
                $this->query->clear();
                $this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
                $data->clinics = $this->pedyDB->loadObjectList();
              
                $this->query->clear();
	$this -> query -> setQuery('select cgr.HealthUnitId, cgr.ClinicTypeId, cgr.ClinicIncidentId, cgr.ClinicIncidentGroupId, cg.IncidentGroup, ci.DescEl as ClinicIncident from ClinicIncidentGroupRel cgr inner join ClinicIncidentGroup cg on cgr.ClinicIncidentGroupId = cg.id inner join ClinicIncident ci on ci.ClinicIncidentId = cgr.ClinicIncidentId  where HealthUnitId = ' . $state -> get('HealthUnitId') );
                $this -> pedyDB -> setQuery( $this -> query );
                $data -> fields -> incidentsGroups = $this -> pedyDB -> loadObjectList();	
                
                $data->fields->incidents = $data->incidents;
                $data->fields->clinics = $data->clinics;
                
                
                $md = new MissingDates($this->pedyDB);
                $missing = $md->getMissingClinic($state->get('RefDateFrom'),  $state->get('RefDateTo'), $state->get('HealthUnitId'), $data->fields);
                $data->missing = $missing;
        }
		
        $state->set('data', $data);
        return $state;
    }
	
	private function getOldStatusData($db, $whereClause)
	{
		
		$query = $db -> getQuery(true);
		$query -> clear();
		$query -> select("ct.ClinicDepartmentId, ct.ClinicTypeId, ct.ClinicIncidentId, sum(ct.Quantity) as Quantity, cd.`DescEL` as ClinicDepartment, clt.`DescEL` as Clinic"
                        . ", ci.`DescEL` as ClinicIncident, hu.DescEl as HealthUnit"
                        . ",ct.ClinicIncidentGroupId")
		-> from("ClinicTransaction ct")
		-> innerJoin("HealthUnit hu ON hu.HealthUnitId = ct.HealthUnitId")
		-> leftJoin ("ClinicDepartment cd ON cd.ClinicDepartmentId = ct.ClinicDepartmentId")
		-> innerJoin ("ClinicType clt ON clt.ClinicTypeId = ct.ClinicTypeId")
		-> leftJoin("ClinicIncident ci ON ci.ClinicIncidentId = ct.ClinicIncidentId")
		-> where ( $whereClause . 'and ClinicGroupId = 0 ' )
		-> group('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, ClinicDepartment, Clinic, ClinicIncident,ct.ClinicIncidentGroupId')
		-> order('HealthUnit, ClinicDepartment,  Clinic, ClinicIncident');
		$db -> setQuery( $query );
		return $db -> loadObjectList();
		
	}
	
	private function getOldCheckers($db, $state)
	{
		$query = $db -> getQuery();
		$query -> clear();
		$query -> select('sum(Quantity) as Quantity')
		->from('ClinicTransaction')
		->where('StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= \'' . $state->get('RefDateFrom', '') . '\' and RefDate <= \'' . $state->get('RefDateTo',0 ) . '\' and HealthUnitId = ' . $state->get('HealthUnitId') . ' and ClinicTypeId=0');
		$db -> setQuery( $query );
        return $db -> loadResult();
	}
	
	
	private function getNewStatusData($db, $whereClause)
	{
         
		$query = $db -> getQuery(true);
		$query -> clear();
		$query -> select("ct.ClinicDepartmentId, ct.ClinicTypeId, ct.ClinicIncidentId, sum(ct.Quantity) as Quantity, cd.`DescEL` as ClinicDepartment"
                        . ", clt.`DescEL` as Clinic, ci.`DescEL` as ClinicIncident, hu.DescEl as HealthUnit,p.FirstName, p.LastName, ct.PersonelId"
                        . ", ct.ClinicIncidentGroupId")
		-> from("ClinicTransaction ct")
		-> innerJoin("HealthUnit hu ON hu.HealthUnitId = ct.HealthUnitId")
		-> leftJoin ("ClinicDepartment cd ON cd.ClinicDepartmentId = ct.ClinicDepartmentId")
		-> innerJoin ("ClinicType clt ON clt.ClinicTypeId = ct.ClinicTypeId")
		-> leftJoin("ClinicIncident ci ON ci.ClinicIncidentId = ct.ClinicIncidentId")
		-> leftJoin("Personel p ON p.PersonelId = ct.PersonelId")
		-> where ( $whereClause . ' and ClinicGroupId = 0 ' )
		-> group('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, ClinicDepartment, Clinic, ClinicIncident, p.Firstname, p.LastName, ct.PersonelId, ct.ClinicIncidentGroupId')
		-> order('HealthUnit, ClinicDepartment,  Clinic, ClinicIncident');
		$db -> setQuery( $query );
		return $db -> loadObjectList();
	}
	
        
        private function getDataInClinicGroups($db, $whereClause)
	{
         
		$query = $db -> getQuery(true);
		$query -> clear();
		$query -> select("ct.ClinicDepartmentId, ct.ClinicTypeId, ct.ClinicIncidentId, sum(ct.Quantity) as Quantity, cd.`DescEL` as ClinicDepartment"
                        . ", clt.`DescEL` as Clinic, ci.`DescEL` as ClinicIncident, hu.DescEl as HealthUnit, cg.ClinicGroup, ct.ClinicGroupId")
		-> from("ClinicTransaction ct")
		-> innerJoin("HealthUnit hu ON hu.HealthUnitId = ct.HealthUnitId")
		-> leftJoin ("ClinicDepartment cd ON cd.ClinicDepartmentId = ct.ClinicDepartmentId")
		-> innerJoin ("ClinicType clt ON clt.ClinicTypeId = ct.ClinicTypeId")
		-> leftJoin("ClinicIncident ci ON ci.ClinicIncidentId = ct.ClinicIncidentId")
		-> innerJoin("ClinicGroup cg ON ct.ClinicGroupId = cg.id")
		-> where ( $whereClause . ' and ClinicGroupId = 1 ' )
		-> group('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, ClinicDepartment, Clinic, ClinicIncident, hu.DescEl, ct.ClinicIncidentGroupId, cg.ClinicGroup, ct.ClinicGroupId')
		-> order('HealthUnit, ClinicDepartment,  Clinic, ClinicIncident');
		$db -> setQuery( $query );
		return $db -> loadObjectList();
	}
	
	private function getDateRanges1($from, $to)
	{
		if ($from <= self::$LAST_OLD_DATE):
			
			return ['start' => $from, 'end' => ($to > self::$LAST_OLD_DATE ? self::$LAST_OLD_DATE: $to ) ];
		else:
			return [];
		endif;
	}
	
	private function getDateRanges2($from, $to)
	{
		if ($to <= self::$LAST_OLD_DATE):
			return [];
		else:
			return ['end' => $to, 'start' => ($from > self::$LAST_OLD_DATE ? $from : self::$FIRST_NEW_DATE  ) ];
		endif;
	}
	
	private function getDoctors($db, $HealthUnitID)
	{
		$query = $db -> getQuery(true);
		$query -> select("distinct cs.ClinicTypeId, cs.PersonelSpecialityId,  p.FirstName, p.LastName, p.PersonelId, hc.ClinicDepartmentId")
		-> from("pedy.ClinicSpecialityRel cs") 
		-> innerJoin( "HealthUnitClinicRel hc on cs.ClinicTypeId = hc.ClinicTypeId and hc.HealthUnitID = $HealthUnitID")
		-> innerJoin("Personel p on  p.HealthUnitId = hc.HealthUnitID and p.StatusId != 3")
		-> innerJoin("PersonelHealthUnitHistory phu on p.PersonelId = phu.PersonelId and phu.endDate is null")
		-> innerJoin ("PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and cs.PersonelSpecialityId = psh.SpecialityId and psh.EndDate is null")
		-> order("ClinicTypeId, p.LastName");
		$db -> setQuery($query);
		$res =  $db -> loadAssocList();
		return $res;
	}
}
