<?php
/**
 * @author e-logism http://www.e-logism.gr
 * @copyright (C) 2013 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_ADMINISTRATOR . '/components/com_elgpedy/tables/tablepedy.php';
/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
class JTablePersonel extends TablePedy 
{
    var $PersonelId = null;
	var $trn = null;
	var $amka = null;
	var $HealthUnitId =null;
	var $PersonelCategoryId = null;
	var $PersonelEducationId = null;
	var $PersonelSpecialityId = null;
	var $PersonelStatusId = null;
	var $LastName = null;
	var $FirstName = null;
	var $FatherName = null;
	var $PersonelDepartmentId = null;
	var $PersonelPositionId = null;
	var $RefHealthUnitId = null;
	var $RewUnitStartDate = null;
	var $RefUnitEndDate = null;
	
	
    function __construct()
	{
		parent::__construct('Personel', 'PersonelId');
	}
	
	public function store($updateNulls = false)
	{
		
		// if($this->isTRNActive())
		// {
			// JError::RaiseWarning('701', JText::_('COM_ELGPEDY_TRN_ALREADY_EXIST'));
			// return false;
		// }
		// $this->setInactive($this->PersonelId);
		parent::store();
		//exit();
		return true;		
	}
	
	public function makeDelete($keys)
	{
		$this->load($keys);
		$this->StatusId = ComponentUtils::$STATUS_DELETED;		
		parent::store();
	}
	
	// public function isTRNActive()
	// {
		// $db = $this->getDBo();
		// $query = $db->getQuery(true);
		// $db->setQuery($query);
		// $query->select('PersonelId')->from($this->getTableName())->where('StatusId = '. ComponentUtils::$STATUS_ACTIVE . ' and trn = ' . $db->Quote($this->trn) . ' ' . ($this->PersonelId != null ? ' and PersonelId != ' . $this->PersonelId : ''));
		// $r = $db->loadResult();		
		// if($r == null)
		// {
			// return false;
		// }
		// else
		// {
			// return true;
		// }
		
	// }
	
	// public function setInactive($PersonelId)
	// {
		// $query = $this->getDBo()->getQuery(true);
		// $query->Update($this->getTableName())->set('StatusId='. ComponentUtils::$STATUS_MODIFIED)->where('PersonelId=' . $this->getDBo()->quote($PersonelId));
		// $this->getDBo()->setQuery($query);
		// $this->getDbo()->query();
		// echo $query->dump();
		// $this->PersonelId = null;
	// }
}
