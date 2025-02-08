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
		$this->query->select('#__ClinicTransaction.ClinicDepartmentId, ClinicTransactionId, #__ClinicTransaction.UserId, #__ClinicTransaction.HealthUnitId, ClinicTypeId, ClinicIncidentId, Quantity, RefDate, PersonelId' )
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
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
               
		$fields->clinics = $this->pedyDB->loadObjectList();
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s order by s.DepartmentId');
		 
                $this->pedyDB->setQuery($this->query);
		$fields->incidents = $this->pedyDB->loadObjectList();
		if($fields->clinics == null)
		{
			$fields->clinics = array();
		}
		if($fields->incidents == null)
		{
			$fields->incidents = array();
		}
		 $fields -> doctors = $this -> getDoctors( $this -> pedyDB, $state->get('HealthUnitId') );
		return $fields;
	}
	
	 
        private function getDoctors($db, $HealthUnitID)
        {
            $query = $db -> getQuery(true);
                    $query -> select("distinct cs.ClinicTypeId, cs.PersonelSpecialityId,  p.FirstName, p.LastName, p.PersonelId")
                    -> from("pedy.ClinicSpecialityRel cs") 
                    -> innerJoin( "HealthUnitClinicRel hc on cs.ClinicTypeId = hc.ClinicTypeId and hc.HealthUnitID = $HealthUnitID")
                    -> innerJoin("Personel p on  p.HealthUnitId = hc.HealthUnitID and p.StatusId != 3")
                    -> innerJoin("PersonelHealthUnitHistory phu on p.PersonelId = phu.PersonelId and phu.endDate is null")
                    -> innerJoin ("PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and cs.PersonelSpecialityId = psh.SpecialityId and psh.EndDate is null")
                    -> order("ClinicTypeId, p.LastName");
                    /**
                      $q = "select distinct cs.ClinicTypeId, cs.PersonelSpecialityId,  p.FirstName, p.LastName, p.PersonelId "
                        . " from pedy.ClinicSpecialityRel cs "
                        . " inner join HealthUnitClinicRel hc on cs.ClinicTypeId = hc.ClinicTypeId and hc.HealthUnitID = $HealthUnitID "
                        . " inner join Personel p on  p.HealthUnitId = hc.HealthUnitID and p.StatusId != 3 "
                        . " inner join PersonelHealthUnitHistory phu on p.PersonelId = phu.PersonelId and phu.endDate is null "
                        . " inner join PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and cs.PersonelSpecialityId = psh.SpecialityId and psh.EndDate is null "
                        . " inner join PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and cs.PersonelSpecialityId = psh.SpecialityId and psh.EndDate is null "
                        . " union "
                        . " select ct.ClinicTypeId, 0,  p.FirstName, p.LastName, p.PersonelId "
                        . " from ClinicTransaction ct "
                        . " inner join Personel p  on ct.PersonelId = ct.PersonelId and ct.StatusId = 1 and ct.RefDate = '$refDate' and ct.HealthUnitId = $HealthUnitID "
                        . " order by ClinicTypeId, p.LastName";
                     **/
                    
            $db -> setQuery($query);
            $res =  $db -> loadAssocList();
            return $res;
        }
 }
