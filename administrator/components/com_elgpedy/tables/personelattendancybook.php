<?php
/**
 * @author e-logism http://www.e-logism.gr
 * @copyright (C) 2013 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_COMPONENT_ADMINISTRATOR . '/tables/tablepedy.php';

/**
 * JTable class father of all pedy application tables
 *
 * @author e-logism
 */
      
class JPersonelAttendancyBook extends TablePedy
{
    var $PersonelAttendanceBookId = null;
    var $PersonelId = null;
    var $HealthUnitId = null;
    var $RefDate = null;
    var $PersonelStatusId = null;
	var $RefHealthUnitId = null;
	
    function __construct()
    {
            parent::__construct('PersonelAttendanceBookId', 'PersonelAttendanceBookId');
    }	
    
    protected function checkIfDataExist()
    {
//        return  $this->load(array('StatusId'=>ComponentUtils::$STATUS_ACTIVE,'PersonelAttendanceBookId'=>$this->PersonelAttendanceBookId,'RefDate'=>$this->RefDate,
//        'PersonelId'=>$this->PersonelId,'PersonelStatusId'=>$this->PersonelStatusId));
//      
        return false;
    }
    
    
    
    protected function hasChanged($submitedData)
    {
        if(false /**$this->Quantity == $submitedData['Quantity']**/)
        {
                JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_ARE_SAME_NO_UPDATE'), 'error');
                return false;
        }
        else
        {
                return true;
        }
    }
	
   
	
	
	public function store_($updateNulls = false)
    {
        if(! parent::check())
        {
            return;
        }
        $submitedData =(array('StatusId'=>$this->StatusId, 'RefDate'=>$this->RefDate,
            'PersonelAttendanceBookId'=>$this->PersonelAttendanceBookId, 'PersonelId'=>$this->PersonelId, 'PersonelStatusId'=>$this->PersonelStatusId,
            'UserId'=> $this->UserId, 'AutoDate'=>$this->AutoDate, 'StatusId'=>$this->StatusId
        ));
        if($this->checkIfDataExist())
        {
                if(!$this->hasChanged($submitedData))
                {
                        return false;
                }
                $this->StatusId = ComponentUtils::$STATUS_MODIFIED;
                try
                {
                        $res = parent::store();				
                }
                catch(Exception $e)
                {
                        JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                        return false;
                }			
        }
        else
        {
                if($submitedData['Quantity'] == 0)
                {
                        JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_NO_DATA_NO_UPDATE'), 'info');
                        return false;
                }
        }
        $this->loadSubmited($submitedData);		
        if($this->Quantity == 0)
        {
                $this->insertNewWithStatus(ComponentUtils::$STATUS_DELETED);
        }
        else
        {
                $this->insertNewWithStatus(ComponentUtils::$STATUS_ACTIVE);
        }
    }
	
	private function loadSubmited($submitedData)
	{
            // $this->PersonelAttendanceBookId = $submitedData['PersonelAttendanceBookId'];
            $this->UserId =  $submitedData['UserId'];
            $this->AutoDate =  $submitedData['AutoDate'];
            $this->RefDate = $submitedData['RefDate'];
            $this->PersonelStatusId = $submitedData['PersonelStatusId'];
            $this->RefDate = $submitedData['RefDate'];
	}
	
	private function insertNewWithStatus($statusId)
	{
            $this->PersonelAttendanceBookId = null;
            $this->StatusId = $statusId;
            try
            {
                $res = parent::store();	
                JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
            }
            catch(Exception $e)
            {
                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                return false;
            }
	}
	

}
