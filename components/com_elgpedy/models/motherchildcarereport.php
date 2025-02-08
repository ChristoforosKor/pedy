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
require_once JPATH_COMPONENT_SITE . '/models/clinicaltransactionreport.php'; 
require_once JPATH_COMPONENT_SITE . '/models/prolepsiscommunityreport.php'; 
 
class ElgPedyModelMotherChildCareReport extends PedyDataEdit
{	
	
	private $modelClinics;
	private $modelProlepsis;
                 
	function getState() 
	{
		$state = parent::getState();	
		$this->modelClinics = new ElgPedyModelClinicalTransactionReport($state);
		$this->modelProlepsis = new ElgPedyModelProlepsisCommunityReport($state);
		$this->modelProlepsis->medicalActId = '1,4';
		$this->modelProlepsis->medicalCategory = 4;
		
		$data = new stdClass();		
		$fields = new stdClass();
		$cliSt = $this->modelClinics->getState();
		$cliDB = $cliSt->get('data');
		
		$prolDB = $this->modelProlepsis->getState()->get('data');
                $data->clinics = $cliDB;
                $data->prolepsis = $prolDB->data;
                $data->clinicMissing = $cliDB->missing;
                $data->prolepsisMissing = $prolDB->missing;
                if($state->get('format') == 'html')
               {
//                    $data->checker = $cliSt->get('checker');
//                    $fields->clinics = $cliDB->clinics;
//                    $fields->incidents = $cliDB->incidents;
                    $fields->prolepsis = $prolDB->fields;
                }        
		$data->fields = $fields;
		$state->set('data', $data);
		return $state;
	}
	
	private function getData($state)
	{
		$data = new stdClass();
		
		$data->clinics = $this->modelClinics->getState($state);
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
