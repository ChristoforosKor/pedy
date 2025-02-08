<?php

/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
use components\com_elpedy\ComUtils;
/**
 * JTable class father of all pedy application tables
 *
 * @author e-logism
 */
            
class JTablePedy extends JTable {
	
	
	
    function __construct($tableName, $tableKey, $db=null) {
  
        if($db == null):
            $db = ComUtils::getPedyDB();
        endif;
         
        $this -> id_user_modif = JFactory::getUser() -> id;
        $this -> date_modif = date('Y-m-d H:i:s');
        parent::__construct($tableName, $tableKey, $db);
		
    }
    
    
}
