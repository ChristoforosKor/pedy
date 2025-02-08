<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
require_once JPATH_COMPONENT_SITE . '/models/pedydataeditsave.php';

class ElgPedyModelPersonelAttendancyBookSave extends PedyDataEditSave {

    function setState(JRegistry $state) {

        $formData = $state->get('formData');
      //  $submittedPersonelWithDuty = $this ->filterSubmitedByRefHealthUnit($formData -> attendancyData, strval($formData -> HealthUnitId) );
        $oldData = $this ->getExistingData( $formData -> RefDate, $formData -> HealthUnitId );
        $updatedData = [];

      //  foreach ($submittedPersonelWithDuty as $key => $attendancy):
        foreach ( $formData -> attendancyData as $key => $attendancy ):
            foreach ($oldData as $oldItem):
                if ($attendancy['PersonelId'] == $oldItem['PersonelId']):
                    if ($attendancy['finalStatusId'] == $oldItem['PersonelStatusId'] && $attendancy['tmpRefHealthUnitId'] == $oldItem['RefHealthUnitId']):
                        // unset($submittedPersonelWithDuty[$key]);
                        unset ( $formData -> attendancyData[$key]);
                    else:
                        $updatedData[] = $oldItem;
                    endif;
                    break;
                endif;
            endforeach;
        endforeach;
        unset($oldItem);
        unset($key);
        unset($attendancy);

        // if (count($submittedPersonelWithDuty) > 0):
        if ( count($formData -> attendancyData) > 0 ):
            $this->table = JTable::getInstance('PersonelAttendanceBook');
            $this->invalidateOldData($updatedData);
            $this->table->RefDate = $formData->RefDate;
            $this->table->StatusId = ComponentUtils::$STATUS_ACTIVE;
            // $this->insertActiveData($submittedPersonelWithDuty);
            $this -> insertActiveData( $formData -> attendancyData );
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
        else:
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_NO_DATA_NO_UPDATE'), 'info');
        endif;
    }

    /**
     * keep the personnel that has the selected RefHealthUnit from the personnel submitted.
     */
//    private function filterSubmitedByRefHealthUnit( $submittedPersonnel, $RefHealthUnitId)
//    {
//        return array_filter($submittedPersonnel, function($personnel) use($RefHealthUnitId){
//           return ($personnel[ 'tmpRefHealthUnitId'] === $RefHealthUnitId || $personnel['PersonelAttendanceBookId'] === null);
//        });
//    }
    
    private function getExistingData( $RefDate, $RefHealthUnitId )
    {
        $query = $this -> pedyDB -> getQuery( true );
        $query -> select('PersonelAttendanceBookId, PersonelId, HealthUnitId,  PersonelStatusId, RefHealthUnitId')
        -> from('#__PersonelAttendanceBook')
        -> where(
                'RefDate=\'' . $RefDate 
                . '\' and StatusId = ' . ComponentUtils::$STATUS_ACTIVE 
                . ' and ( RefHealthUnitId = ' . $RefHealthUnitId . ' or ( HealthUnitId = ' . $RefHealthUnitId . ' and RefHealthUnitId !=' . $RefHealthUnitId .' ) )'
        );
        $this -> pedyDB -> setQuery( $query ) -> loadAsscoList();        
        return $this -> pedyDB -> loadAssocList();
    }
    
    
    private function invalidateOldData($updData) {
        if (count($updData) > 0) :
            $this->table->StatusId = ComponentUtils::$STATUS_MODIFIED;
            $this->table->PersonelId = null;
            $this->table->PersonelStatusId = null;
            $this->table->HealthUnitId = null;
            $this->table->RefHealthUnitId = null;
            foreach ($updData as $item):
                $this->table->PersonelAttendanceBookId = $item['PersonelAttendanceBookId'];
                $this->table->store();
            endforeach;
            unset($updData);
        endif;
    }

    private function insertActiveData($activeData) {
        foreach ($activeData as $item):
            $this->table->PersonelAttendanceBookId = null;
            $this->table->PersonelId = $item['PersonelId'];
            $this->table->PersonelStatusId = $item['finalStatusId'];
            $this->table->HealthUnitId = $item['HealthUnitId'];
            $this->table->RefHealthUnitId = $item['tmpRefHealthUnitId'];
            $this->table->store();
        endforeach;
        unset($activeData);
    }

}
