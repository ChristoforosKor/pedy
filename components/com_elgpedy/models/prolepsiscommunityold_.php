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
 
class ElgPedyModelProlepsisCommunityOld extends PedyDataEdit
{	
	public $medicalActId = '1,2,3,4,6';
	public $medicalCategory = 2;
	function getState() 
	{
		$state = parent::getState();
		$data = new stdClass();
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
		$this->query->select(' mt.UserId, mt.HealthUnitId, MedicalTypeId, MedicalActId, Quantity, RefDate' )
				->from('#__MedicalTransaction mt')
                ->where( 'StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate= \'' . $state->get('RefDate')  . '\'' 
				. ' and HealthUnitId = ' .  $state->get('HealthUnitId') . ' and MedicalActId in (' . $this->medicalActId . ')');           
		$this->pedyDB->setQuery($this->query);
		//echo $this->query->dump();
		return $this->pedyDB->loadObjectList();
	}
	
	public function getFields($state)
	{
		$fields = new stdClass();
		$this->query->clear();
		$this->query->setQuery('select s.* from (select @p1:= '. $this->medicalCategory .' p) parm , vw_lstMedTypeByMedCat s');
		$this->pedyDB->setQuery($this->query);
		$fields->prolepsis = $this->pedyDB->loadObjectList();
		$this -> query -> clear();
		$this -> query -> setQuery( " select PatientAttributeId, Value from PatientAttributeValue where PatientAttributeId in (1,2) ");
		$fields -> prolepsisAttibutes = $this -> pedyDB -> loadObjectList();
		$fields -> doctors = $this -> getDoctors( $this -> pedyDB, $state->get('HealthUnitId') );
		return $fields;
		
	}
	
	
	// public function getData($state)
	// {
		// $this->query->clear();
		// $this->query->select('ClinicTransactionId, #__ClinicTransaction.ClinicDepartmentId, #__ClinicTransaction.UserId, #__ClinicTransaction.HealthUnitId, ClinicTypeId, ClinicIncidentId, Quantity, RefDate, #__ClinicTransaction.PersonelId' )
			// ->from('#__ClinicTransaction')
			// ->where( ' #__ClinicTransaction.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate =\'' . $state->get('RefDate','') . '\'  and HealthUnitId = ' . $state->get('HealthUnitId') )
			// ->order('ClinicTypeId, ClinicIncidentId'); 
		// echo $this -> query -> dump();
		// $this->pedyDB->setQuery($this->query);
	
		
		// return $this->pedyDB->loadObjectList();
	// }
	
	public function getFields_($state)
	{
		
		
		$fields = new stdClass();
		$this->query->clear();
		$this->pedyDB->setQuery($this->query);
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
		
                $fields->clinics = $this->pedyDB->loadObjectList();
     
		$this->query->setQuery('select distinct s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s');
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
			//echo $query -> dump();
            $db -> setQuery($query);
            $res =  $db -> loadAssocList();
            return $res;
        }
	
	
	
 }
