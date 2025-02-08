<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
  require_once JPATH_COMPONENT_SITE . '/views/clinicaltransactionold/view.html.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewMotherChildCareOld extends DataCommon
   {
		public function render()
		{
			
			$data = $this->state->get('data');
			$this->fields =  new stdClass(); 
			$this->fields->clinics = $data->fields->clinics->clinics;
			$this->fields->incidents = $data->fields->clinics->incidents;
			$this->fields->prolepsis = $data->fields->prolepsis;
			$this -> fields -> doctors = $data -> fields -> doctors;
			//$this -> docsDrop = $this -> makeDocsDrop($this -> fields -> doctors);
			$this->dataLayout = 'motherchildcareold.php';
			$this -> refDate = $this -> state -> get('RefDate');
			$this -> healthUnitId = $this -> state -> get('HealthUnitId');
			
			
			$this->dataClinical = ViewUtils::ClinicalReform($data->data->clinics);
			//$this->dataClinical = ViewUtils::ClinicalReformDoctors($data->data -> clinics); 
			$this->dataProlepsis =ViewUtils::ProlepsisReform($data->data->prolepsis);
			return parent::render();			
		}
		
		
   }