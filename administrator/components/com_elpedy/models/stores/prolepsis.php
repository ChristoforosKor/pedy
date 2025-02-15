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
class JTableProlepsis extends JTablePedy {
    
    var $id = null;
    var $RefDate = null;
    var $exam_center_id = null;
    var $created_at = null;
    var $updated_at = null;
    var $vials_received = null;
    var $samples_received = null;
    var $vials_in_stock = null;
    var $result_negative = null;
    var $result_positive_hpv16 = null;
    var $result_positive_hpv18 = null;
    var $result_positive_ascsus = null;
    var $result_positive_to_pap_negative = null;
    
  
    function __construct()
    {
        parent::__construct('Prolepsis', 'id');
    }	
   
    
}
