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
 
class ElgPedyModelProlepsisCommunity extends PedyDataEdit
{	
	public $medicalActId = '1,2,3,4,6, 7';
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
		$data -> refDate = $state->get('RefDate','');
		$data -> healthUnitId = $state->get('HealthUnitId');
		$state->set('data', $data);
		return $state;
	}
	
	public function getData($state)
	{
		$this->query->clear();
		$this->query->select('  mt.MedicalTransactionId, mt.PatientAmka, mt.UserId, mt.HealthUnitId, MedicalTypeId, MedicalActId, Quantity, RefDate, PersonelId, PatientAttributeInsurance, PatientAttributeOrigination, MunicipalityId, Quantity' )
				->from('#__MedicalTransaction mt')
                ->where( 'StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate= \'' . $state->get('RefDate')  . '\'' 
				. ' and HealthUnitId = ' .  $state->get('HealthUnitId') . ' and MedicalActId in (' . $this->medicalActId . ')');           
		$this->pedyDB->setQuery($this->query);
		//echo $this->query->dump();
		//var_dump($this->pedyDB->loadObjectList());
		return $this->pedyDB->loadObjectList();

	}
	
	public function getFields($state)
	{
		$fields = new stdClass();
		$this->query->clear();
		$this->query->setQuery('select s.* from (select @p1:= '. $this->medicalCategory .' p) parm , vw_lstMedTypeByMedCat s');
		$this->pedyDB->setQuery($this->query);
		$fields->prolepsis = $this->pedyDB->loadObjectList();
		// var_dump($fields);
		$this -> query -> clear();
		$this -> query -> setQuery( " select id, PatientAttributeId, Value from PatientAttributeValue where PatientAttributeId in (1,2) order by PatientAttributeId ");
		$fields -> prolepsisAtttibutesValues = $this -> pedyDB -> loadObjectList();
		$this -> query -> clear();
		$this -> query -> setQuery( " select id, attribute from PatientAttribute where id in (1,2) ");
		$fields -> prolepsisAttributes = $this -> pedyDB -> loadObjectList();
		$this -> query -> clear();
		$this -> query -> setQuery( ' SELECT m.MunicipalityId, m.DescEL  FROM Municipality m inner join HealthUnitMunicipalityRel mr on m.MunicipalityId = mr.MunicipalityId and mr.HealthUnitId =  ' . $state -> get('HealthUnitId') );
		$fields -> municipalities = $this -> pedyDB -> loadObjectList();
		$fields -> doctors = $this -> getDoctors( $this -> pedyDB, $state->get('HealthUnitId') );
		return $fields;
		
	}
	
	
	
	
        
        private function getDoctors($db, $HealthUnitID)
        {
            
		$query = "SELECT distinct cs.MedicalActId, cs.PersonelSpecialityId, p.FirstName, p.LastName, p.PersonelId
					from PersonelHealthUnitHistory phu
					inner join Personel p on  phu.RefHealthUnitId =  $HealthUnitID and p.HealthUnitId = phu.RefHealthUnitId and p.PersonelId = phu.PersonelId and phu.endDate is null and p.StatusId != 3
					INNER JOIN PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and psh.EndDate is null
					inner join pedy.MedicalActSpecialityRel cs on cs.PersonelSpecialityId = psh.SpecialityId
				UNION
					select  cs.MedicalActId, cs.PersonelSpecialityId, p.FirstName, p.LastName, p.PersonelId
					from PersonelAttendanceBook pab
					inner join Personel p on p.PersonelId = pab.PersonelId and p.StatusId != 3 and pab.RefHealthUnitId =  $HealthUnitID 
											and refdate='2017-09-19' and pab.HealthUnitId=p.HealthUnitId and pab.HealthUnitId!= $HealthUnitID
					INNER JOIN PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and psh.EndDate is null
					inner join pedy.MedicalActSpecialityRel cs on cs.PersonelSpecialityId = psh.SpecialityId
				ORDER BY MedicalActId, LastName";
			
/* 		$query = "SELECT distinct cs.MedicalActId, cs.PersonelSpecialityId,  p.FirstName, p.LastName, p.PersonelId
		from PersonelHealthUnitHistory phu 
		inner join Personel p on  phu.RefHealthUnitId =  $HealthUnitID and p.HealthUnitId = phu.HealthUnitId and p.PersonelId = phu.PersonelId and phu.endDate is null and p.StatusId != 3
		INNER JOIN PersonelSpecialityHistory psh on p.PersonelId = psh.PersonelId and psh.EndDate is null
		inner join pedy.MedicalActSpecialityRel cs on cs.PersonelSpecialityId = psh.SpecialityId
		ORDER BY MedicalActId, p.LastName"; */
		return $db -> setQuery($query) -> loadAssocList();
        }
	
	
	
 }
