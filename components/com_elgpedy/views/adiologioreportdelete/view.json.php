<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
    defined( '_JEXEC' ) or die( 'Restricted access' );
    require_once JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
   
   class ElgPedyViewAdiologioReportDelete extends View
   {
        public function render()
        {
            $this->setLayout('jsondataoutput');
            return parent::render();
       }
   }
