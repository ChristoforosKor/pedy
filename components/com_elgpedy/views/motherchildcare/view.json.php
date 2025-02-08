<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
 require_once JPATH_COMPONENT_SITE . '/views/clinicaltransaction/view.html.php';
 require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewMotherChildCare extends View
   {
		public function render()
		{
			$this->setLayout('jsondataoutput');
            $data = new stdClass();
			$data->data = $this->state->get('data');
			$data->data->data->clinics = ViewUtils::ClinicalReform($data->data->data->clinics);
			$data->data->data->prolepsis = ViewUtils::ProlepsisReform($data->data->data->prolepsis);
			$data->mc = 4;
			$this->data = $data;
			return parent::render();
		}
   }