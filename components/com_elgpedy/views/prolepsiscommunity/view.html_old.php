<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 // require JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
  require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
  
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewProlepsisCommunity extends DataCommon
   {
		protected $fields;
		public function render()
		{
			$data = $this->state->get('data');
			$data->fields->prolepsis;
			$fieldsView = array();
			$lastActId = 0;
			foreach($data->fields->prolepsis as $field)
			{
				if($lastActId != $field->MedicalActId)
				{
					$lastActId = $field->MedicalActId;
					$fieldsView[$lastActId] = array();
					
				}
				$fieldsView[$lastActId][] = $field;
			}
			unset($field);
			
			$data->fields->prolepsis = $fieldsView;
			$this->fields = $data->fields;
			
			$this -> dataProlepsis = ViewUtils::ProlepsisReform($data->data); //$dataProlepsis;
		
			$this->dataLayout = 'prolepsiscommunity.php';			
			return parent::render();			
		}	
   }