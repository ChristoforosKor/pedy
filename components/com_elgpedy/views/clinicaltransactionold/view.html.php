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
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewClinicalTransactionOld extends DataCommon
   {
   	   	
		public function render()
		{
			
			$data = $this->state->get('data');
			$this->fields = $data->fields;
			$this->dataClinical = ViewUtils::ClinicalReform($data->data); 
			$this->dataLayout = 'clinicaltransactionold.php';
			
			return parent::render();
		}
		
		
   }
