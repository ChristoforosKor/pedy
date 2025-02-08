<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';
require_once JPATH_COMPONENT_SITE . '/models/queries.php';
use Joomla\Registry\Registry;

class ElgPedyModelClinicalTransaction extends PedyDataEdit {

    function getState() {
        $oldState = parent::getState();
        $newState = new Registry();
        
        if ($oldState->get('format') === 'html') {
            $newState -> set( 'fields', $this -> getFields($oldState) );
        }
        $newState -> set ( 'data',  $this -> getData( $oldState ) );
        $newState -> set ( 'refDate',  $oldState -> get('RefDate', '') );
        $newState -> set ( 'healthUnitId', $oldState -> get('HealthUnitId') );
        $newState -> set ( 'view', $oldState -> get('view') );
        $newState -> set ( 'Itemid', $oldState -> get('Itemid') );
        $newState -> set ( 'forms',  $oldState -> get('forms') );
        $newState -> set ( 'checkers', ComponentUtils::getCheckers( $this -> pedyDB, $oldState -> get('RefDate', ''), $oldState -> get('HealthUnitId') ) );
        return $newState;
        
    }

    public function getData($state) {
        $this->query->clear();
        $this->query->select('ct.ClinicTransactionId, ct.ClinicDepartmentId, ct.UserId, ct.HealthUnitId, ct.ClinicTypeId, ct.ClinicIncidentId, ct.Quantity, ct.RefDate, ct.PersonelId, ct.ClinicIncidentGroupId')
                ->from('#__ClinicTransaction ct')
                ->where(' ct.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and ct.RefDate =\'' . $state->get('RefDate', '') . '\'  and ct.HealthUnitId = ' . $state->get('HealthUnitId'))
                ->order('ClinicTypeId, ClinicIncidentId');
       // echo $this -> query -> dump();
        $this->pedyDB->setQuery($this->query);
        
        return $this->pedyDB->loadObjectList();
    }

    public function getFields($state) {

        $fields = new stdClass();
        $this->query->clear();
        $healthUnitId = $state->get('HealthUnitId');
        $this->pedyDB->setQuery($this->query);
        $this->query->setQuery('select s.* from (select @p1:=' . $healthUnitId . ' p) parm , pedy.vw_lstClinicByHU s');
        $fields->clinics = $this->pedyDB->loadObjectList();
        $this->query->setQuery('select distinct s.* from (select @p1:=' . $healthUnitId . ' p) parm , pedy.vw_lstIncidentByHU s where s.IncidentId<>10');
        $this->pedyDB->setQuery($this->query);
        $fields -> incidents = $this->pedyDB->loadObjectList();
        $fields -> incidentsByRel = $this -> pedyDB 
                -> setQuery("select gr.HealthUnitId, gr.ClinicTypeId, gr.ClinicIncidentId as IncidentId, ci.DescEL as Incident, ci.Tooltip, gr.DepartmentId, d.DescEL as Department, gr.ClinicIncidentGroupId  "
                        . " from   ClinicIncidentGroupRel gr  "
                        . " inner join ClinicIncident ci on ci.ClinicIncidentId = gr.ClinicIncidentId and HealthUnitId = " . $healthUnitId 
                        . " inner join ClinicDepartment d on d.ClinicDepartmentId = gr.DepartmentId "
                        . " group by gr.HealthUnitId, gr.ClinicTypeId, gr.ClinicIncidentId, ci.DescEL, ci.Tooltip, gr.DepartmentId, d.DescEL" )
                -> loadObjectList();
        //$fields -> incidents =  $this -> mergeIncidents( $fields -> incidentsNet, []);
        $this -> query -> setQuery('select cgr.HealthUnitId, cgr.ClinicTypeId, cgr.ClinicIncidentId, cgr.ClinicIncidentGroupId, cg.IncidentGroup, ci.DescEl as ClinicIncident from ClinicIncidentGroupRel cgr inner join ClinicIncidentGroup cg on cgr.ClinicIncidentGroupId = cg.id inner join ClinicIncident ci on ci.ClinicIncidentId = cgr.ClinicIncidentId  where HealthUnitId = ' . $state -> get('HealthUnitId') );
        $this -> pedyDB -> setQuery( $this -> query );
        $fields -> incidentsGroups = $this -> pedyDB -> loadObjectList();
        
        
        if ($fields->clinics == null) {
            $fields->clinics = array();
        }
        if ($fields->incidents == null) {
            $fields->incidents = array();
        }
        
        // $fields->doctors = $this->getDoctors($this->pedyDB, $state->get('HealthUnitId'), $state->get('RefDate', ''));
        $attendacySavedPersonel = $this->getDoctorsFromAttendancyBook($state->get('HealthUnitId'), $state->get('RefDate', ''), []);
        $attendacySavedPersonelAll = $this->getDoctorsFromAttendancyBookAll($state->get('HealthUnitId'), $state->get('RefDate', ''), []);
		
        $doctors =  $this -> getDoctors ( $this -> pedyDB, $state -> get('HealthUnitId'), $state -> get('RefDate','') );
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
                            $attendacySavedPersonelAll
                            ,$doctorsAll
                        ,function ($a, $b){
                        return ( $a['PersonelId'] == $b['PersonelId'] ? 0 : 1 ); }
                )
        );
        return $fields;
    }
    

    private function getDoctors($db, $HealthUnitID, $refDate = null) {

        $query = "
                        select distinct cs2.ClinicTypeId, cs2.PersonelSpecialityId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
                        from pedy.ClinicSpecialityRel cs2 
                        inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $HealthUnitID 
                        inner join PersonelHealthUnitHistory phu2 on phu2.RefHealthUnitID = hc2.HealthUnitID and phu2.startDate <= '$refDate' and ( phu2.endDate >= '$refDate' or phu2.endDate is null or phu2.enddate = '0000-00-00 00:00:00' ) 
                        inner join PersonelSpecialityHistory psh2 on cs2.PersonelSpecialityId = psh2.SpecialityId and psh2.startDate <= '$refDate' and ( psh2.endDate >= '$refDate' or psh2.EndDate is null  or psh2.enddate = '0000-00-00 00:00:00') 
                        and phu2.PersonelId = psh2.PersonelId
                        inner join Personel p2 on p2.PersonelId = phu2.PersonelID and p2.StatusId != 3                        
                        union
                        select ct.ClinicTypeId, 0,  p.FirstName, p.LastName, p.PersonelId, ct.StatusId
                        from ClinicTransaction ct
                        inner join Personel p on ct.PersonelId = p.PersonelId and ct.StatusId = 1 and ct.RefDate = '$refDate' and ct.HealthUnitId = $HealthUnitID
                        ORDER BY LastName ";
        //	echo $query;
        $db->setQuery($query);
        $res = $db->loadAssocList();
        return $res;
    }

    private function getDoctorsAll($HealthUnitID, $refDate = null) {
        $query = "
                select distinct cs2.ClinicTypeId, cs2.PersonelSpecialityId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
                from pedy.ClinicSpecialityRel cs2 
                inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $HealthUnitID 
                inner join PersonelHealthUnitHistory phu2 on phu2.RefHealthUnitID = hc2.HealthUnitID and phu2.startDate <= '$refDate' and ( phu2.endDate >= '$refDate' or phu2.endDate is null or phu2.enddate = '0000-00-00 00:00:00' ) 
                inner join Personel p2 on p2.PersonelId = phu2.PersonelID and p2.StatusId != 3 
				";
        return $this->pedyDB->setQuery($query)->loadAssocList();
    }

    private function getDoctorsFromAttendancyBook($refHealthUnitId, $refDate, $exclude) {
        $q = " 	select distinct cs2.ClinicTypeId, cs2.PersonelSpecialityId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
					from pedy.ClinicSpecialityRel cs2 
					inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $refHealthUnitId 
					inner join PersonelAttendanceBook pab on pab.RefHealthUnitID = hc2.HealthUnitID and pab.refDate = '$refDate' and pab.statusid !=3 and pab.statusid !=2
					inner join Personel p2 on p2.PersonelId = pab.PersonelID and p2.StatusId != 3 
					inner join PersonelSpecialityHistory psh2 on p2.PersonelId=psh2.PersonelId and psh2.startDate <= '$refDate' 
						and ( psh2.endDate >= '$refDate' or psh2.EndDate is null  or psh2.enddate = '0000-00-00 00:00:00') 
				where psh2.SpecialityId=cs2.PersonelSpecialityId and psh2.statusid=1 
					  and p2.PersonelCategoryId<=3" .  ( count($exclude) > 0 ? " and p2.PersonelId not in ( " . implode(",", $exclude) . ") " : "" )
				;	
        // echo $q;
        return $this->pedyDB->setQuery($q)->loadAssocList();
    }

	 private function getDoctorsFromAttendancyBookAll($refHealthUnitId, $refDate, $exclude) {
        $q = " 	select distinct cs2.ClinicTypeId, cs2.PersonelSpecialityId,  p2.FirstName, p2.LastName, p2.PersonelId, p2.statusId 
					from pedy.ClinicSpecialityRel cs2 
					inner join HealthUnitClinicRel hc2 on cs2.ClinicTypeId = hc2.ClinicTypeId and hc2.HealthUnitID = $refHealthUnitId 
					inner join PersonelAttendanceBook pab on pab.RefHealthUnitID = hc2.HealthUnitID and pab.refDate = '$refDate' and pab.statusid !=3 and pab.statusid !=2
					inner join Personel p2 on p2.PersonelId = pab.PersonelID and p2.StatusId != 3 
					inner join PersonelSpecialityHistory psh2 on p2.PersonelId=psh2.PersonelId and psh2.startDate <= '$refDate' 
						and ( psh2.endDate >= '$refDate' or psh2.EndDate is null  or psh2.enddate = '0000-00-00 00:00:00') 
				where psh2.statusid=1 
					  and p2.PersonelCategoryId<=3" .  ( count($exclude) > 0 ? " and p2.PersonelId not in ( " . implode(",", $exclude) . ") " : "" )
				;	
        // echo $q;
        return $this->pedyDB->setQuery($q)->loadAssocList();
    }
}
