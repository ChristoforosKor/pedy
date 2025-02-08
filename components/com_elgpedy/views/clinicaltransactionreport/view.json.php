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
   class ElgPedyViewClinicalTransactionReport extends View
   {
		public function render()
		{
                    $this->setLayout('jsondataoutput');
                    $data = new stdClass();
                    $data = $this->state->get('data');
                    $data->data = ViewUtils::ClinicalReform($data->data);
                    $data->mc = '1';
                    $this->data = $data;
                    return parent::render();
		}
   }
