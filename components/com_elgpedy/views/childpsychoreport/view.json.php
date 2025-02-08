<?php
/**
 * e-logism's com_elgcomponent.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
 require JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewChildPsychoReport extends view
   {
		public function render()
		{
			$this->setLayout('jsondataoutput');
                        $data = $this->state->get('data', null);
                        $data->mc = 5;
			//$data->data = ViewUtils::ClinicalReform($data->data);
			$this->data = $data;
			return parent::render();
		}
   }
