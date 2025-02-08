<?php
/**
 * e-logism's com_elgcomponent.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewClinicalTransactionDataEditSave extends view
   {
		public function render()
		{			
		
			$this->data = $this->state->get('data');
			$this->setLayout('jsondataoutput');
			return parent::render();
		}
   }