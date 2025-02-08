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
            
class JTableHealthUnit extends TablePedy 
{
    var $HealthUnitId = null;
	var $HealthUnitTypeId = null;
	var $DescEL = null;
	var $DescShortEL =null;
	var $IsActive = null;
	
    function __construct()
	{
		parent::__construct('HealthUnit', 'HealthUnitId');
	}
	
	public function store($updateNulls = false)
	{
		$oHU = $this->HealthUnitId;
	    //$this->setInactive($this->HealthUnitId);
		parent::store();
		// $db = $this->getDBo();
		// $query = $db->getQuery(true);
		// $query->update('#__Users')->set('HealthUnitId=' . $this->HealthUnitId)->where('HealthUnitId=' . $oHU);
		// $db->setQuery($query);
		// $db->query();
		// $query->clear();
		// $query->update('#__HealthUnitRel')->set('HealthUnitId=' . $this->HealthUnitId . ' where HealthUnitId = '. $oHU);
		// $db->setQuery($query);
		// $db->query();
		// $query->clear();
		// $query->update('#__ClinicTransaction')->set('HealthUnitId=' . $this->HealthUnitId . ' where HealthUnitId = '. $oHU);
		// $db->setQuery($query);
		// $db->query();
		// $query->update('#__MedicalTransaction')->set('HealthUnitId=' . $this->HealthUnitId . ' where HealthUnitId = '. $oHU);
		// $db->setQuery($query);
		// $db->query();

		JFactory::getApplication()->setUserState('userUnits', null);
		ComponentUtils::getUserHUIds();
		return true;		
	}
	
	public function setInactive($HealthUnitId)
	{
		$query = $this->getDBo()->getQuery(true);
		$query->Update($this->getTableName())->set('StatusId='. ComponentUtils::$STATUS_MODIFIED)->where('HealthUnitId=' . $this->getDBo()->quote($HealthUnitId));
		$this->getDBo()->setQuery($query);
		$this->getDbo()->query();
		
		
		$this->HealthUnitId = null;
	}
}
