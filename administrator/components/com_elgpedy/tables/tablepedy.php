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
 * JTable class father of all pedy application tables
 *
 * @author e-logism
 */
            
class TablePedy extends JTable {
	var $AutoDate = null;
	var $StatusId = null;
	var $UserId = null;
	
	
    function __construct($tableName, $tableKey, $db=null) {
		if($db == null)
		{
			$db = ComponentUtils::getPedyDB();
		}
        parent::__construct($tableName, $tableKey, $db);
		$this->AutoDate = date('Y-m-d H:i:s');
		$this->UserId = JFactory::getUser()->id;
    } 
	
	
	
	
	public function makeDelete($keys)
	{
		$this->load($keys);
		$this->StatusId = ComponentUtils::$STATUS_MODIFIED;		
		parent::store();		
		foreach($keys as $key=>$value)
		{
			$this->$key = null;
		}
		$this->AutoDate = date('Y-m-d H:i:s');
		$this->StatusId = ComponentUtils::$STATUS_DELETED;
		$this->UserId = JFactory::getUser()->id;
		parent::store();
	}
}
