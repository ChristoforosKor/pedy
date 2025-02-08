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
 
class ElgPedyModelMedicalTransaction extends PedyDataEdit
{	
	//protected HealthUnit
	public $medicalActId = 5;
	public $medicalCategory = 3;
	function getState() 
	{
		$state = parent::getState();
		$params = new stdClass();
		$data = new stdClass();
		if($state->get('format') === 'html')
		{
			$data->fields = $this->getFields($params);
		}		
		
		$data->data = $this->getData($state);		
		$state->set('data', $data);
		return $state;
	}
	
	public function getData($state)
	{
		$data = array('Medical'=>array());
		$this->query->clear();
		$this->query->select(' mt.UserId, mt.HealthUnitId, MedicalTypeId, Quantity, Quantity_KDE, RefDate' )
			->from('#__MedicalTransaction mt')
            ->where( 'StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate= \'' . $state->get('RefDate', '') . '\' and HealthUnitId = ' . $state->get('HealthUnitId') .
			' and MedicalActId in ( ' . $this->medicalActId  . ') ');
		$this->pedyDB->setQuery($this->query);
		
		$data['Medical'] =  $this->pedyDB->loadObjectList('MedicalTypeId');			
        return $data;
	}
	
	public function getFields()
	{
		$fields = new stdClass();
		$this->query->clear();
		$this->query->setQuery('select s.* from (select @p1:= '. $this->medicalCategory . ' p) parm , vw_lstMedTypeByMedCat1 s');
		
		$this->pedyDB->setQuery($this->query);
		$fields->exams = $this->pedyDB->loadObjectList();
		if($fields->exams == null)
		{
			$fields->exams = array();
		}
		
		return $fields;
	}
 }
