<?php
/**
 * @author e-logism http://www.e-logism.gr
 * @copyright (C) 2013 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_ADMINISTRATOR . '/components/com_elgpedy/tables/tablepedy.php';
/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
class JTableHealthUnitDetail extends TablePedy 
{
    var $HealthUnitId = null;
	var $Address = null;
	var $PostalCode = null;
	var $Phone =null;
	var $Fax = null;
	var $Email = null;
	var $Personel = null;
	
    function __construct()
	{
		parent::__construct('HealthUnitDetail', 'HealthUnitDetailId');
	}
	
    
    
	public function store($updateNulls = false)
	{
	    $this->setInactive($this->HealthUnitId);
		parent::store();
		return true;		
	}
	
	public function setInactive($HealthUnitId)
	{
		$query = $this->getDBo()->getQuery(true);
		$query->Update($this->getTableName())->set('StatusId='. ComponentUtils::$STATUS_MODIFIED)->where('HealthUnitId=' . $this->getDBo()->quote($HealthUnitId));
		$this->getDBo()->setQuery($query);
		$this->getDbo()->query();
		$this->HealthUnitDetailId = null;
		$this->StatusId = ComponentUtils::$STATUS_ACTIVE;
		
	}
   
}
