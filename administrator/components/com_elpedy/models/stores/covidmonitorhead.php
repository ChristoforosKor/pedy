<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
                  
require_once JPATH_COMPONENT_ADMINISTRATOR . '/models/stores/pedy.php';

class JTableCovidMonitorHead extends JTablePedy {
    
    function __construct()
    {
        parent::__construct('CovidMonitorHead', 'id');
    }	
   
}
