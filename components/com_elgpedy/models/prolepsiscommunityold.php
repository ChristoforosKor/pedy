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
 
class ElgPedyModelProlepsisCommunityold extends PedyDataEdit
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
		return $fields;
		
	}
 }
