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
/**
  * @package pedy.site
  * @subpackage models
  * 
  */

class ElgPedyModelPersonelAttendancyBook extends PedyDataEdit
{
	// private $storeElseWhere = [];
	function getState() 
	{
		
            $state = parent::getState();
            $data = new stdClass();
            $query = $this->pedyDB->getQuery(true);
            $this->pedyDB->setQuery($query);
			$refDate =  $this->pedyDB->Quote($state->get('RefDate')) ;		
			$healthUnitID =  $state->get('HealthUnitId', 0);
	 
 
		$qs = "select distinct pab.`PersonelAttendanceBookId` AS `PersonelAttendanceBookId` , pab.`RefDate` AS `RefDate`
		 ,  pab.RefHealthUnitId as tmpRefHealthUnitId
		, rhu.DescEL as tmpRefHealthUnit 
		, pab.HealthUnitId , hu.DescEL as HealthUnit 
		, p.PersonelId, p.LastName, p.FirstName, p.FatherName 
		 , pst.PersonelStatusGroupId 
		 , pe.DescEL as PersonelEducation 
		 , ps.DescEl as PersonelSpeciality 
		 , pst.PersonelStatusId as tempStatusId 
		 , pst.DescEL as tmpStatus 
		 , pab.PersonelStatusId as dutyStatusId
		 , psta.DescEl as dutyStatus 
		 from PersonelAttendanceBook pab
		 inner join HealthUnit rhu ON pab.RefHealthUnitId = rhu.HealthUnitId and ( pab.RefHealthUnitId = $healthUnitID or pab.HealthUNitId = $healthUnitID ) and pab.`StatusId` = 1 and pab.`RefDate` =$refDate 
		 inner join HealthUnit hu ON pab.HealthUnitId = hu.HealthUnitId 
		 inner join Personel p  on p.PersonelId = pab.PersonelId
		 inner join PersonelStatus psta ON pab.PersonelStatusId = psta.PersonelStatusId 
		 left join PersonelStatus pst on p.PersonelStatusId = pst.PersonelStatusId 
		 left join PersonelEducation pe on pe.PersonelEducationId = p.PersonelEducationId 
		 inner join PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and psh.StartDate <= $refDate and ( psh.EndDate >=$refDate or psh.EndDate is null or psh.EndDate = '0000-00-00 00:00:00' ) 
		 inner join PersonelSpeciality ps on ps.PersonelSpecialityId = psh.SpecialityId 
		 order by `LastName` , `FirstName` ";
//echo $qs;
		$query->setQuery(' select PersonelStatusId, description from vw_lstPersonelAttendanceStatus');
		$data->attendancyStatus = $this->pedyDB->loadObjectList();
		$query->clear();
		$query->setQuery('call sp_getUserHUId(' . JFactory::getUser()->id .', 1)');	
		$data->attendancyHealthUnit = $this->pedyDB->loadObjectList(); 
		$query->clear();
		$query->setQuery($qs);
		$storedData = $this -> pedyDB -> loadAssocList();  //stored data
		
			
		$qs = "select null AS `PersonelAttendanceBookId` , null AS `RefDate`
		 , rhu.`HealthUnitId` as tmpRefHealthUnitId
		 , rhu.`DescEL` as `tmpRefHealthUnit` 
		 , phu.HealthUnitId , hu.DescEL as HealthUnit 
		 , phu.PersonelId, p.LastName, p.FirstName, p.FatherName 
		 , pst.PersonelStatusGroupId 
		 , pe.DescEL as PersonelEducation 
		 , ps.DescEl as PersonelSpeciality 
		 , pst.PersonelStatusId as dutyStatusId 
		 , pst.DescEL as dutyStatus 
		 , phu.PersonelStatusId 
		 , psta.DescEl as PersonelStatus 
		 from PersonelHealthUnitHistory phu
		inner join `Personel` p  on p.`PersonelId` = phu.`PersonelId` and  phu.RefHealthUnitId = $healthUnitID  " . 
		( count( $storedData ) > 0 ? " and p.PersonelId not in (" . implode(',',array_column($storedData, "PersonelId") ) . ") " : '' ) . "
		and phu.StartDate <= $refDate  and ( phu.EndDate >=$refDate or phu.EndDate is null or phu.EndDate = '0000-00-00 00:00:00' )  and phu.statusId != 3  
		inner join HealthUnit hu ON phu.HealthUnitId = hu.HealthUnitId 
		inner join HealthUnit rhu ON phu.RefHealthUnitId = rhu.HealthUnitId 
		left join PersonelStatus psta ON phu.PersonelStatusId = psta.PersonelStatusId 
		left join PersonelStatus pst on p.PersonelStatusId = pst.PersonelStatusId 
		left join PersonelEducation pe on pe.PersonelEducationId = p.PersonelEducationId 
		inner join PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and psh.StartDate <= $refDate and ( psh.EndDate >=$refDate or psh.EndDate is null or psh.EndDate = '0000-00-00 00:00:00' ) 
		inner join PersonelSpeciality ps on ps.PersonelSpecialityId = psh.SpecialityId
		left join PersonelAttendanceBook pab on pab.PersonelId = p.PersonelId and pab.refDate = $refDate
		where pab.PersonelAttendanceBookId is null
		order by `LastName` , `FirstName`";
			$query -> setQuery( $qs ); 
			$this -> pedyDB -> setQuery ( $query );			
            $unstoredHUData =  $this -> pedyDB -> loadAssocList();
			//$unstoredHUPersonel = array_column( $unsetoredHUData, 'PersonelId');
			//$qs = "select pab.PersonelId from PersonelAttendancyBook where refDate = '$refDate' and personelId not in( " . implode( ',', array_column( $unstoredHUPersonel) ) . ") ";
			//$storedElseWhere  = $db -> setQuery ( $qs )-> loadRowList();
			//array_diff(
			$data -> attendancyData = array_merge($unstoredHUData, $storedData); 
			$state->set('data', $data);
            return $state;	
	}
	
	
 }