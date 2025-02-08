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
 
class ElgPedyModelMedicalTransactionReport extends PedyDataEdit
{	
	//protected HealthUnit
	public $medicalActId = 5;
	public $medicalCategory = 3;
	function getState() 
	{
		$state = parent::getState();
		
		$data = new stdClass();
		$missing = array();
		if($state->get('format') === 'html')
		{
			$data->fields = $this->getFields();
			$md = new MissingDates($this->pedyDB);
			$missing = $md->getMissingMedical($state->get('RefDateFrom'),  $state->get('RefDateTo'), $state->get('HealthUnitId'), $data->fields->exams);
		}		
		
		$data->data = $this->getData($state);		
		$data->missing = $missing;
		$state->set('data', $data);
		return $state;
	}
	
	public function getData($state)
	{
		$data = array('Medical'=>array());
		$this->query->clear();
		$this->query->select('mt.HealthUnitId, MedicalTypeId, sum(Quantity) as Quantity, sum(Quantity_KDE) as Quantity_KDE' )
			->from('#__MedicalTransaction mt')
            ->where( 'StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= \'' . $state->get('RefDateFrom') . '\'  and RefDate <= \'' . $state->get('RefDateTo') . '\' and HealthUnitId = ' . $state->get('HealthUnitId') .
			' and MedicalActId in ( ' . $this->medicalActId  . ') ')
			->group('mt.HealthUnitId, MedicalTypeId');
		$this->pedyDB->setQuery($this->query);
		// echo $this->query->dump();
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
