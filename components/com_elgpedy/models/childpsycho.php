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
 
class ElgPedyModelChildPsycho extends PedyDataEdit
{	
	function getState() 
	{
		$state = parent::getState();
		$data = new stdClass();
		$data -> refDate = $state->get('RefDate','');
		$data -> healthUnitId = $state->get('HealthUnitId');
		if($state->get('format') === 'html')
		{
			$data->fields = $this->getFields($state);
		}	
		$data->data = $this->getData($state);
		$state->set('data', $data);
		return $state;
	} 
	
	public function getData($state)
	{
		$this->query->clear();
		$this->query->select('#__ClinicTransaction.ClinicDepartmentId, ClinicTransactionId, #__ClinicTransaction.UserId, #__ClinicTransaction.HealthUnitId, ClinicTypeId, ClinicIncidentId, Quantity, RefDate, PersonelId, ClinicIncidentGroupId, #__ClinicTransaction.EducationId, #__ClinicTransaction.PatientAmka' )
			->from('#__ClinicTransaction')
			->where( ' #__ClinicTransaction.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate= \'' . $state->get('RefDate', '') . '\' and HealthUnitId = ' . $state->get('HealthUnitId') )
			->order('ClinicTypeId, ClinicIncidentId'); 
			// echo $this -> query -> dump();
		$this->pedyDB->setQuery($this->query);
		return $this->pedyDB->loadObjectList();
	}
	
	public function getFields($state)
	{	
		$fields = new stdClass();
		$this->query->clear();
		$this->pedyDB->setQuery($this->query);
                                if ( $state -> get('dataLayout') === 'childpsycho2' ):
                                    $this->query->setQuery('select distinct s.ClinicId, s.Clinic, s.Tooltip, s.isSummed, s.isExclusive  from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
                                else:
                                    $this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
                                endif;
		$fields->clinics = $this->pedyDB->loadObjectList();
                                
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s order by s.DepartmentId');
		$this->pedyDB->setQuery($this->query);
		$fields->incidents = $this->pedyDB->loadObjectList();
                                $this -> query -> setQuery( "select ClinicIncidentId, DescEL from #__ClinicIncident");
                                $fields -> allIncidents = $this -> pedyDB -> setQuery( $this -> query ) -> loadAssocList();
                                $this -> query -> setQuery( "select PersonelEducationId, DescEL from #__PersonelEducation order by DescEL");
                                $fields -> allEducations = $this -> pedyDB -> setQuery( $this -> query ) -> loadAssocList();
                                $this -> query -> setQuery('select cgr.HealthUnitId, cgr.ClinicTypeId, cgr.ClinicIncidentId, cgr.ClinicIncidentGroupId, cg.IncidentGroup from ClinicIncidentGroupRel cgr inner join ClinicIncidentGroup cg on cgr.ClinicIncidentGroupId = cg.id  where HealthUnitId = ' . $state -> get('HealthUnitId') );
                                $this -> pedyDB -> setQuery( $this -> query );
                                $fields -> incidentsGroups = $this -> pedyDB -> loadObjectList();
                
                
		if($fields->clinics == null):
                                    $fields->clinics = array();
		endif;
		if($fields->incidents == null):
                                    $fields->incidents = array();
		endif;
                                $attendacySavedPersonel = $this->getDoctorsFromAttendancyBook($state->get('HealthUnitId'), $state->get('RefDate', ''), []);
                                if ( $state -> get('dataLayout') === 'childpsycho2' ):
                                    $doctors =  $this -> getDoctors2 ( $this -> pedyDB, $state -> get('HealthUnitId'), $state -> get('RefDate','') );
                                else:    
                                    $doctors =  $this -> getDoctors ( $this -> pedyDB, $state -> get('HealthUnitId'), $state -> get('RefDate','') );
                                endif;
                                $fields -> doctors = array_merge (
                                            $doctors,
                                            array_udiff(
                                                    $attendacySavedPersonel
                                                    ,$doctors
                                                ,function ($a, $b){
                                                return ( $a['PersonelId'] == $b['PersonelId'] ? 0 : 1 ); }
                                                )
                                            );
                                $doctorsAll  = $this->getDoctorsAll($state->get('HealthUnitId'), $state->get('RefDate', ''));
                                $fields -> doctorsAll = array_merge (
                                            $doctorsAll,
                                            array_udiff(
                                                    $attendacySavedPersonel
                                                    ,$doctorsAll
                                                ,function ($a, $b){
                                                return ( $a['PersonelId'] == $b['PersonelId'] ? 0 : 1 ); }
                                        )
                                );
                
                                return $fields;
	}
	
	 
        private function getDoctors($db, $HealthUnitID, $refDate = null)
        {
                $query = "
                        select distinct  hc2.ClinicDepartmentId, cs2.ClinicTypeId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
                        from pedy.ClinicSpecialityRel cs2 
                        inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $HealthUnitID 
                        inner join PersonelHealthUnitHistory phu2 on phu2.RefHealthUnitID = hc2.HealthUnitID and phu2.startDate <= '$refDate' and ( phu2.endDate >= '$refDate' or phu2.endDate is null or phu2.enddate = '0000-00-00 00:00:00' ) 
                        inner join PersonelSpecialityHistory psh2 on cs2.PersonelSpecialityId = psh2.SpecialityId and psh2.startDate <= '$refDate' and ( psh2.endDate >= '$refDate' or psh2.EndDate is null  or psh2.enddate = '0000-00-00 00:00:00') 
                        and phu2.PersonelId = psh2.PersonelId
                        inner join Personel p2 on p2.PersonelId = phu2.PersonelID and p2.StatusId != 3                        
                        union
                        select ct.ClinicDepartmentId, ct.ClinicTypeId,  p.FirstName, p.LastName, p.PersonelId, ct.StatusId
                        from ClinicTransaction ct
                        inner join Personel p on ct.PersonelId = p.PersonelId and ct.StatusId = 1 and ct.RefDate = '$refDate' and ct.HealthUnitId = $HealthUnitID
                        ORDER BY LastName ";
     
            $db->setQuery($query);
            $res = $db->loadAssocList();
            return $res;
        }
        
        private function getDoctors2($db, $HealthUnitID, $refDate = null)
        {
                $query = "
                        select distinct  cs2.ClinicTypeId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
                        from pedy.ClinicSpecialityRel cs2 
                        inner join PersonelHealthUnitHistory phu2 on phu2.RefHealthUnitID = " . $HealthUnitID . " and phu2.startDate <= '$refDate' and ( phu2.endDate >= '$refDate' or phu2.endDate is null or phu2.enddate = '0000-00-00 00:00:00' ) 
                        inner join PersonelSpecialityHistory psh2 on cs2.PersonelSpecialityId = psh2.SpecialityId and psh2.startDate <= '$refDate' and ( psh2.endDate >= '$refDate' or psh2.EndDate is null  or psh2.enddate = '0000-00-00 00:00:00') 
                        and phu2.PersonelId = psh2.PersonelId
                        inner join Personel p2 on p2.PersonelId = phu2.PersonelID and p2.StatusId != 3                        
                        union
                        select ct.ClinicTypeId,  p.FirstName, p.LastName, p.PersonelId, ct.StatusId
                        from ClinicTransaction ct
                        inner join Personel p on ct.PersonelId = p.PersonelId and ct.StatusId = 1 and ct.RefDate = '$refDate' and ct.HealthUnitId = $HealthUnitID
                        ORDER BY LastName ";
     
            $db->setQuery($query);
            $res = $db->loadAssocList();
            return $res;
        }
        
         private function getDoctorsFromAttendancyBook($refHealthUnitId, $refDate, $exclude) {
        $q = " 	select distinct cs2.ClinicTypeId, cs2.PersonelSpecialityId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
                                                from pedy.ClinicSpecialityRel cs2 
                                                inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $refHealthUnitId 
                                                inner join PersonelAttendanceBook pab on pab.RefHealthUnitID = hc2.HealthUnitID and pab.refDate = '$refDate' and pab.statusid !=3 
                                                inner join Personel p2 on p2.PersonelId = pab.PersonelID and p2.StatusId != 3 " .
                ( count($exclude) > 0 ? " and p2.PersonelId not in ( " . implode(",", $exclude) . ") " : "" );
        // echo $q;
        return $this->pedyDB->setQuery($q)->loadAssocList();
    }
    
    private function getDoctorsAll($HealthUnitID, $refDate = null) {
        $query = "
                select distinct cs2.ClinicTypeId, cs2.PersonelSpecialityId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
                from pedy.ClinicSpecialityRel cs2 
                inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $HealthUnitID 
                inner join PersonelHealthUnitHistory phu2 on phu2.RefHealthUnitID = hc2.HealthUnitID and phu2.startDate <= '$refDate' and ( phu2.endDate >= '$refDate' or phu2.endDate is null or phu2.enddate = '0000-00-00 00:00:00' ) 
                inner join Personel p2 on p2.PersonelId = phu2.PersonelID and p2.StatusId != 3 ";
             return $this->pedyDB->setQuery($query)->loadAssocList();
    }
 }
