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
class ElgPedyModelProlepsisCommunityReport extends PedyDataEdit
{	
	public $medicalActId = '1,2,3,4,6';
	public $medicalActIdNew = 7;
	public $medicalCategory = 2;
	function getState() 
	{
		$state = parent::getState();
		$data = new stdClass();
                $missing = array();
		if($state->get('format') === 'html')
		{
			$data->fields = $this->getFields($state);
                        $md = new MissingDates($this->pedyDB);
                        $missing = $md->getMissingMedical($state->get('RefDateFrom'),  $state->get('RefDateTo'), $state->get('HealthUnitId'), $data->fields->prolepsis);
		}	
		$data->data = $this->getData($state);
		$data -> newData = $this -> getNewData( $state , $this -> pedyDB );
                $data->missing = $missing;
		$state->set('data', $data);
		return $state;
	}
	
	public function getData($state)
	{
		$this->query->clear();
		$this->query->select(' mt.HealthUnitId, MedicalTypeId, MedicalActId, sum(Quantity) as Quantity' )
				->from('#__MedicalTransaction mt')
                ->where( 'StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= \'' . $state->get('RefDateFrom', '') . '\' and RefDate <= \'' . $state->get('RefDateTo','' ) . '\' ' 
				. ' and HealthUnitId = ' .  $state->get('HealthUnitId') . ' and MedicalActId in (' . $this->medicalActId . ')')
				->group( 'HealthUnitId, MedicalTypeId, MedicalActId');      
		$this->pedyDB->setQuery($this->query);
	
		return $this->pedyDB->loadObjectList();
	}
	
	public function getFields($state)
	{
		$fields = new stdClass();
		$this->query->clear();
		$this->query->setQuery('select s.* from (select @p1:= '. $this->medicalCategory .' p) parm , vw_lstMedTypeByMedCat s');
		$this->pedyDB->setQuery($this->query);
		$fields->prolepsis = $this->pedyDB->loadObjectList();
		return $fields;
		
	}
	
	private function getNewData($state, $db)
	{
		$query = "select mt.MedicalTypeId, mt.PatientAmka, mt.MedicalActId, mty.`DescEL` as MedicalType, ma.`DescEL` as MedicalAct
, hu.DescEl as HealthUnit,p.FirstName, p.LastName, mt.PersonelId, pai.`value` as PatientAttributeInsurance, pao.`value` as PatientAttributeOrigination
, mn.DescEL as Municipality,  sum(mt.Quantity) as Quantity
from MedicalTransaction mt
inner join MedicalAct ma on mt.MedicalActId = ma.MedicalActId
inner join MedicalType mty on mt.MedicalTypeId = mty.MedicalTypeId
inner join HealthUnit hu ON hu.HealthUnitId = mt.HealthUnitId
left join Personel p ON p.PersonelId = mt.PersonelId
left join PatientAttributeValue pai on mt.PatientAttributeInsurance = pai.id
left join PatientAttributeValue pao on mt.PatientAttributeOrigination = pao.id
left join Municipality mn on mt.MunicipalityId = mn.MunicipalityId 
where mt.statusId = " . ComponentUtils::$STATUS_ACTIVE . " and RefDate >= " . $db -> quote( $state->get('RefDateFrom', '') ) . " and RefDate <= " . $db -> quote ( $state->get('RefDateTo','' )  )  
. " and mt.HealthUnitId = " .  $state->get('HealthUnitId') . " and mt.MedicalActId in (" . $this->medicalActIdNew . ") " 
. " group by mt.MedicalTypeId, mt.MedicalActId, mty.`DescEL`, ma.`DescEL`
, hu.DescEl,p.FirstName, p.LastName, mt.PersonelId, pai.`value`, pao.`value`, mn.DescEL
 order by MedicalActId, PatientAmka";
		$db -> setQuery( $query );
		return $db -> loadObjectList();
	}
 }
