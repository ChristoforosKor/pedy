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
 
class ElgPedyModelClinicalTransactionOld extends PedyDataEdit
{	
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
		$this->query->select('ClinicTransactionId, #__ClinicTransaction.ClinicDepartmentId, #__ClinicTransaction.UserId, #__ClinicTransaction.HealthUnitId, ClinicTypeId, ClinicIncidentId, Quantity, RefDate' )
			->from('#__ClinicTransaction')
			->where( ' #__ClinicTransaction.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate =\'' . $state->get('RefDate','') . '\'  and HealthUnitId = ' . $state->get('HealthUnitId') )
			->order('ClinicTypeId, ClinicIncidentId'); 
			
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
		$this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s');
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
		return $fields;
	}
 }
