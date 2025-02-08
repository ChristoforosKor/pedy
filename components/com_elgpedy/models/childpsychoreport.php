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

class ElgPedyModelChildPsychoReport extends PedyDataEdit
{	
	private static $LAST_OLD_DATE = '2016-08-31'; // last date of old status. 
	private static $FIRST_NEW_DATE = '2016-09-01'; //first date of new status.
                private static $FIRST_NEW_DATE2 = '2018-02-01'; 
	function getState() 
	{
		$state = parent::getState();
		$data = new stdClass();
		$missing = array();
		$from = $state->get('RefDateFrom', '');
		$to = $state->get('RefDateTo', '');
			$whereClause = ' ct.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and ct.HealthUnitId = ' . $state -> get('HealthUnitId'); 
		$data -> d1 = $this -> getDateRanges1($from, $to);
		$data -> d2 = $this -> getDateRanges2($from, $to);
                                $data -> d3 = $this -> getDateRanges3($from, $to);
		if ( count($data -> d1) > 0 ) :
                                    $data -> data = $this -> getOldStatusData($this -> pedyDB, $whereClause . ' and ct.RefDate >= \'' . $data -> d1['start'] . '\' and ct.RefDate <= \'' . $data -> d1['end'] . '\'' );
		endif;
		
		if( count($data -> d2) > 0 ):
                                    $data -> newData = $this -> getNewStatusData($this -> pedyDB, $whereClause . ' and ct.RefDate >= \'' . $data -> d2['start'] . '\' and ct.RefDate <= \'' . $data -> d2['end'] . '\'');
                                    $data -> doctors = $this -> getDoctors($this -> pedyDB, $state -> get('HealthUnitId'), $data -> d2['start'], $data -> d2['end']);
                                endif;
                                
                                if ( count( $data -> d3 ) > 0 ):
                                    $data -> newData3 = $this -> getNewStatusData3($this -> pedyDB, $whereClause . ' and ct.RefDate >= \'' . $data -> d3['start'] . '\' and ct.RefDate <= \'' . $data -> d3['end'] . '\'');
                                    $data -> doctors3 = $this -> getDoctors3($this -> pedyDB, $state -> get('HealthUnitId'), $data -> d3['start'], $data -> d3['end']);
                                endif;
		
		
		
		if($state->get('format') === 'html')
		{
			$data->fields = $this->getFields($state);
			$md = new MissingDates($this->pedyDB);
			$missing = $md->getMissingClinic($state->get('RefDateFrom'),  $state->get('RefDateTo'), $state->get('HealthUnitId'), $data->fields);
			$data->missing = $missing;
		}	
		
		
		
		
		//$dbData = $this -> getData( $state );
		//$data->data = $dbData->data;
		$data -> checker = $this ->getChecker($this -> pedyDB , $state->get('RefDateFrom'), $state->get('RefDateTo'), $state->get('HealthUnitId') );
		
		$state->set('data', $data);
		return $state;
	}
	
	private function getOldStatusData($db, $whereClause)
	{
		
		$query = $db -> getQuery();
		$query -> clear();
		$query -> select("ct.ClinicDepartmentId, ct.ClinicTypeId, ct.ClinicIncidentId, sum(ct.Quantity) as Quantity, cd.`DescEL` as ClinicDepartment, clt.`DescEL` as Clinic, ci.`DescEL` as ClinicIncident, hu.DescEl as HealthUnit")
		-> from("ClinicTransaction ct")
		-> innerJoin("HealthUnit hu ON hu.HealthUnitId = ct.HealthUnitId")
		-> leftJoin ("ClinicDepartment cd ON cd.ClinicDepartmentId = ct.ClinicDepartmentId")
		-> innerJoin ("ClinicType clt ON clt.ClinicTypeId = ct.ClinicTypeId")
		-> leftJoin("ClinicIncident ci ON ci.ClinicIncidentId = ct.ClinicIncidentId")
		-> where ( $whereClause )
		-> group('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, ClinicDepartment, Clinic, ClinicIncident')
		-> order('HealthUnit, ClinicDepartment,  Clinic, ClinicIncident');
		$db -> setQuery( $query );
		return $db -> loadObjectList();
		
	}
	
	
	private function getNewStatusData($db, $whereClause)
	{
		$query = $db -> getQuery();
		$query -> clear();
		$query -> select(" ct.ClinicDepartmentId, ct.ClinicTypeId, ct.ClinicIncidentId, sum(ct.Quantity) as Quantity, cd.`DescEL` as ClinicDepartment, clt.`DescEL` as Clinic, ci.`DescEL` as ClinicIncident, hu.DescEl as HealthUnit,p.FirstName, p.LastName, ct.PersonelId")
		-> from("ClinicTransaction ct")
		-> innerJoin("HealthUnit hu ON hu.HealthUnitId = ct.HealthUnitId")
		-> leftJoin ("ClinicDepartment cd ON cd.ClinicDepartmentId = ct.ClinicDepartmentId")
		-> innerJoin ("ClinicType clt ON clt.ClinicTypeId = ct.ClinicTypeId")
		-> leftJoin("ClinicIncident ci ON ci.ClinicIncidentId = ct.ClinicIncidentId")
		-> leftJoin("Personel p ON p.PersonelId = ct.PersonelId")
		-> where ( $whereClause )
		-> group('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, ClinicDepartment, Clinic, ClinicIncident, p.Firstname, p.LastName, ct.PersonelId')
		-> order('HealthUnit, ClinicDepartment,  Clinic, ClinicIncident');                                
		$db -> setQuery( $query );
		//echo $query -> dump(); 		 
		return $db -> loadObjectList();
	}
        
        
                private function getNewStatusData3($db, $whereClause)
	{
                        $query = $db -> getQuery();
                        $query -> clear();
                        $query -> select("  ct.ClinicTypeId, ct.ClinicIncidentId, sum(ct.Quantity) as Quantity,  clt.`DescEL` as Clinic, ci.`DescEL` as ClinicIncident, p.FirstName, p.LastName, ct.PersonelId, ct.EducationId as Education  , ct.PatientAmka")
                        -> from("ClinicTransaction ct")
                        -> innerJoin ("ClinicType clt ON clt.ClinicTypeId = ct.ClinicTypeId")
                        -> leftJoin("ClinicIncident ci ON ci.ClinicIncidentId = ct.ClinicIncidentId")
                        -> leftJoin("Personel p ON p.PersonelId = ct.PersonelId")
                       // -> leftjoin("PersonelEducation pe on ct.EducationId = pe.PersonelEducationId")
                        -> where ( $whereClause )
                        -> group('ClinicTypeId, ClinicIncidentId, Clinic, ClinicIncident, p.Firstname, p.LastName, ct.PersonelId,  ct.EducationId, ct.PatientAmka')
                        -> order('Clinic, ClinicIncident, LastName');                                
                        $db -> setQuery( $query );
                        return $db -> loadObjectList();
	}
	
                private function getChecker($db, $from, $to, $healthUnitId )
                {
                    $query = $db -> getQuery();
                    $query -> clear();
                    $query -> select('sum(Quantity) as Quantity')
                    -> from('ClinicTransaction')
                    ->  where('StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= ' . $db -> quote( $from ) . ' and RefDate <= ' . $db -> quote ( $to ) . ' and HealthUnitId = ' . $db -> quote( $healthUnitId ) . ' and ClinicIncidentId = 4');
                    $db -> setQuery( $query );
                    $checker = $db -> loadResult();
                    return ( $checker === null ? 0 : $checker );
                }
	
	public function getFields($state)
	{
                                $fields = new stdClass();
		$this->query->clear();
		$this->pedyDB->setQuery($this->query);
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
                	$fields->clinics = $this->pedyDB->loadObjectList();
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s order by s.DepartmentId');
	                $this->pedyDB->setQuery($this->query);
		$fields->incidents = $this->pedyDB->loadObjectList();
		if($fields->clinics == null):
                                    $fields->clinics = array();
		endif;
		if($fields->incidents == null):
                                    $fields->incidents = array();
		endif;
		return $fields;
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
		else :
			return ['end' => ( $to < self::$FIRST_NEW_DATE2 ?$to :  date_format( date_modify( date_create( self::$FIRST_NEW_DATE2 ), '-1 day' ), 'Y-m-d'  ) ) , 'start' => ($from > self::$LAST_OLD_DATE ? $from : self::$FIRST_NEW_DATE  ) ];
		endif;
	}
        
                
                private function getDateRanges3($from, $to)
	{
		if ($to < self::$FIRST_NEW_DATE2):
			return [];
		else:
			return [ 'end' => $to, 'start' => ( $from >= self::$FIRST_NEW_DATE  ? $from : $FIRST_NEW_DATE ) ];
		endif;
	}
	
	private function getDoctors($db, $HealthUnitID, $from, $to)
	{
		$query = $db -> getQuery(true);
		$query -> select("distinct hc.ClinicDepartmentId, cs.ClinicTypeId, cs.PersonelSpecialityId,  p.FirstName, p.LastName, p.PersonelId")
		-> from("pedy.ClinicSpecialityRel cs")
		-> innerJoin( "HealthUnitClinicRel hc on cs.ClinicTypeId = hc.ClinicTypeId and hc.HealthUnitID = $HealthUnitID")
		-> innerJoin("Personel p on  p.HealthUnitId = hc.HealthUnitID and p.StatusId != 3")
		-> innerJoin("PersonelHealthUnitHistory phu on p.PersonelId = phu.PersonelId and phu.endDate is null")
		-> innerJoin ("PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and cs.PersonelSpecialityId = psh.SpecialityId and psh.EndDate is null")
		-> order("ClinicTypeId, LastName");
                                $q2 = $db -> getQuery(true);
                                $q2 -> select ( 'ct.ClinicDepartmentId, ct.ClinicTypeId, 0,  p.FirstName, p.LastName, p.PersonelId')
                                        -> from ( ' ClinicTransaction ct ')
                                        -> innerJoin ( 'Personel p on ct.PersonelId = p.PersonelId and ct.StatusId = 1 and  ct.RefDate >= ' . $db -> quote( $from ) . ' and ct.RefDate <= ' . $db -> quote ( $to ) .  ' and ct.HealthUnitId = ' . $db -> quote( $HealthUnitID ) );
		$query -> union ( $q2 );
                                $db -> setQuery($query);
		$res =  $db -> loadAssocList();
		return $res;
	}
        
                
	private function getDoctors3($db, $HealthUnitID, $from, $to)
	{
		$query = $db -> getQuery(true);
		$query -> select("distinct cs.ClinicTypeId,   p.FirstName, p.LastName, p.PersonelId")
		-> from("pedy.ClinicSpecialityRel cs")
		-> innerJoin( "HealthUnitClinicRel hc on cs.ClinicTypeId = hc.ClinicTypeId and hc.HealthUnitID = $HealthUnitID")
		-> innerJoin("Personel p on  p.HealthUnitId = hc.HealthUnitID and p.StatusId != 3")
		-> innerJoin("PersonelHealthUnitHistory phu on p.PersonelId = phu.PersonelId and phu.endDate is null")
		-> innerJoin ("PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and cs.PersonelSpecialityId = psh.SpecialityId and psh.EndDate is null")
		-> order("ClinicTypeId, LastName");
                                $q2 = $db -> getQuery(true);
                                $q2 -> select ( ' distinct ct.ClinicTypeId,  p.FirstName, p.LastName, p.PersonelId')
                                        -> from ( ' ClinicTransaction ct ')
                                        -> innerJoin ( 'Personel p on ct.PersonelId = p.PersonelId and ct.StatusId = 1 and  ct.RefDate >= ' . $db -> quote( $from ) . ' and ct.RefDate <= ' . $db -> quote ( $to ) .  ' and ct.HealthUnitId = ' . $db -> quote( $HealthUnitID ) );
		$query -> union ( $q2 );
                                $db -> setQuery($query);
		$res =  $db -> loadAssocList();
		return $res;
	}
 }
