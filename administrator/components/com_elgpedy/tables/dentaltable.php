<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
abstract class DentalTable extends JTable {
    
    var $create_time = null;
    var $update_time = null;
    var $user_id = null;
    var $status_id = null;
    
    function __construct($tableName, $tableKey, $db=null) {
        if($db == null)
        {
                $db = ComponentUtils::getPedyDB();
        }
        parent::__construct($tableName, $tableKey, $db);
        $this->update_time = date('Y-m-d h:i:s');
        $this->user_id = JFactory::getUser()->id;
    } 
}
