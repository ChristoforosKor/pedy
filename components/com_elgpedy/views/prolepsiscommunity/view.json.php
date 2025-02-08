<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
 require JPATH_COMPONENT_SITE . '/views/viewutils.php';

 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewProlepsisCommunity extends view
   {
		public function render()
		{
			$this->setLayout('jsondataoutput');
            $data = $this->state->get('data', null);
			$data->data = ViewUtils::ProlepsisReform($data->data);
			$data->mc = 2;
			$this->data = $data;
			return parent::render();
		}
   }