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
 }
