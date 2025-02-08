<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_COMPONENT_ADMINISTRATOR . '/tables/tablepedy.php';
      
class JTablePersonelSchedule extends TablePedy
{
	var $PersonelScheduleId = null;
        var $PersonelId = null;
	var $HealthCommitteeId = null;
	var $Start = null;
	var $End = null;
       
	
    function __construct()
    {
        parent::__construct('PersonelSchedule', 'PersonelScheduleId');
    }	
   
    protected function checkIfDataExist()
    {
        return  $this->load(array('PersonelScheduleId'=>$this->PersonelScheduleId));
        
    }
    
        public function store($updateNulls = false)
        {
            $submitedData = array('PersonelScheduleId'=>$this->PersonelScheduleId, 'PersonelId'=>$this->PersonelId, 'HealthCommitteeId'=>$this->HealthCommitteeId, 'Start'=>$this->Start,
            'End'=>$this->End, 'UserId'=> $this->UserId, 'AutoDate'=>$this->AutoDate) ;
            if($this->manipulateOld($submitedData))
            {
                $this->insertNewWithStatus(ComponentUtils::$STATUS_ACTIVE);
            }
            
        }
	
        function delete($pk = null) {
            $this->makeDelete(array('PersonelScheduleId'=>$pk));
        }
        
        
        
        private function manipulateOld($submitedData)
        {
            if($this->updateOld())
            {
                $this->loadSubmited($submitedData);
                return true;
            }
            return false;
        }
        
        
        
      
        
        private function updateOld()
        {
            $res = true;
            if($this->checkIfDataExist())
            {
                $this->StatusId = ComponentUtils::$STATUS_MODIFIED;
                try
                {
                    $res = parent::store();				
                }
                catch(Exception $e)
                {
                    JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                }
            }   
            return $res;
        }
        
	 private function loadSubmited($submitedData)
	 {
            $this->PersonelScheduleId = $submitedData['PersonelScheduleId'];
            $this->PersonelId = $submitedData['PersonelId'];
            $this->HealthCommitteeId = $submitedData['HealthCommitteeId'];
            $this->Start = $submitedData['Start'];
            $this->End = $submitedData['End'];
            $this->UserId =  $submitedData['UserId'];
            $this->AutoDate =  $submitedData['AutoDate'];
	 }
	
	 private function insertNewWithStatus($statusId)
	 {
            $this->PersonelScheduleId = null;
            $this->StatusId = $statusId;
            if($statusId == ComponentUtils::$STATUS_DELETED)
            {
                $message = JText::_('COM_ELG_DELETE_SUCCESS');
            }
            else
            {
                $message = JText::_('COM_ELG_SUBMIT_SUCCESS');
            }
            try
            {
                $app = JFactory::getApplication();
                $m = $app->getMessageQueue();
                foreach($m as $ms)
                {
                    unset($ms);
                }
                unset($m);
                $res = parent::store();	
                $app->enqueueMessage( $message);
            }
            catch(Exception $e)
            {
                $app->enqueueMessage($e->getMessage(), 'error');
                return false;
            }
	 }
	
	// public function checkIfChanged()
	// {
		// ////na figi auto molis figi to abstract apo to parent
	// }
}
