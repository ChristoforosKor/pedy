<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 require JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
 require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewPersonelsCommittees extends View
   {
        public function render()
        {
            $this->setLayout('jsonflat');
            $this->data = new stdClass();
            $this->data = ViewUtils::scheduleReform($this->state->get('data')->data);
            return parent::render();			
        }
   }