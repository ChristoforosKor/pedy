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
require_once JPATH_COMPONENT_SITE . '/models/clinicaltransactionold.php'; 
require_once JPATH_COMPONENT_SITE . '/models/prolepsiscommunityold.php'; 
 
class ElgPedyModelMotherChildCareOld extends PedyDataEdit
{	
	private $modelClinics;
	private $modelProlepsis;
	function getState() 
	{
		$state = parent::getState();	
		$this->modelClinics = new ElgPedyModelClinicalTransactionold($state);
		$this->modelProlepsis = new ElgPedyModelProlepsisCommunityold($state);
		$this->modelProlepsis->medicalActId = '1,4';
		$this->modelProlepsis->medicalCategory = 4;
		$data = new stdClass();		
		///$HealthUnitId = $state->get('HealthUnitId');
		if($state->get('format') === 'html')
		{						
			$data->fields = $this->getFields($state);
		}			
		$data->data = $this->getData($state);
		$state->set('data', $data);
		return $state;
	}
	
	private function getData($state)
	{
		$data = new stdClass();
		$data->clinics = $this->modelClinics->getData($state);
		$data->prolepsis =  $this->modelProlepsis->getData($state);		
		return $data;
	}
	
	private function getFields($state)
	{
		$fields = new stdClass();
		$fields->prolepsis = $this->modelProlepsis->getFields($state);
		$fields->clinics = $this->modelClinics->getFields($state);
		return $fields;
	}
 }