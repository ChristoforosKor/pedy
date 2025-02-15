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
class JTableProlepsis2129 extends JTablePedy {
    
    var $id = null;
    var $refDate = null;
    var $samples_to_check = null;
    var $result_ok = null;
    var $result_notok = null;
    var $vials_in_stock = null;
    var $created_at = null;
    var $id_user_modif = null;
    var $date_modif = null;
    
  
    function __construct()
    {
        parent::__construct('Prolepsis2129', 'id');
    }	
   
    
}
