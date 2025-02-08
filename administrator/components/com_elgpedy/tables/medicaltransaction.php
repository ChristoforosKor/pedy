<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
require JPATH_COMPONENT_ADMINISTRATOR . '/tables/tablepedytransaction.php';

/**
 * JTable class father of all pedy application tables
 *
 * @author e-logism
 */
class JTableMedicalTransaction extends TablePedyTransaction {

    var $MedicalTransactionId = null;
    var $MedicalActId = null;
    var $MedicalTypeId = null;
    var $PersonelId = null;
    var $PatientAttributeInsurance = null;
    var $PatientAttributeOrigination = null;
    var $MunicipalityId = null;
    var $PatientAmka = null;
    var $Quantity = null;
    var $Quantity_KDE = null;

    function __construct() {

        parent::__construct('MedicalTransaction', 'MedicalTransactionId');
    }

    protected function checkIfDataExist($submitedData) {
        $data = array_merge(['StatusId' => ComponentUtils::$STATUS_ACTIVE], $submitedData);
        unset($data['Quantity']);
        unset($data['Quantity_KDE']);
        unset($data['AutoDate']);
        return $this->load($data);
    }

    protected function hasChanged($submitedData) {
        if ($this->Quantity == $submitedData['Quantity'] && $this->Quantity_KDE == $submitedData['Quantity_KDE']) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_ARE_SAME_NO_UPDATE'), 'info');
            return false;
        } else {
            return true;
        }
    }

    private function getSubmitedData() {
        $ret = [
            'HealthUnitId' => $this->HealthUnitId
            , 'RefDate' => $this->RefDate
            , 'MedicalActId' => $this->MedicalActId
            , 'MedicalTypeId' => $this->MedicalTypeId
            , 'Quantity' => $this->Quantity
            , 'Quantity_KDE' => $this->Quantity_KDE
            , 'RefDate' => $this->RefDate
          //  , 'UserId' => $this->UserId
            , 'AutoDate' => $this->AutoDate
        ];
        if ($this->PatientAttributeInsurance != null):
            $ret ['PatientAttributeInsurance'] = $this->PatientAttributeInsurance;
        endif;
        if ($this->PatientAttributeOrigination != null):
            $ret ['PatientAttributeOrigination'] = $this->PatientAttributeOrigination;
        endif;
        if ($this->MunicipalityId != null):
            $ret ['MunicipalityId'] = $this->MunicipalityId;
        endif;
        if ($this->PersonelId != null):
            $ret ['PersonelId'] = $this->PersonelId;
        endif;
        if ($this->PatientAmka != null):
            $ret ['PatientAmka'] = $this->PatientAmka;
        endif;
        return $ret;
    }

    public function store($updateNulls = false) {
        if (!parent::check()) {
            return;
        }


        if ($this->MedicalTransactionId > 0) :
            $this->flow2();
            return;
        endif;

//			$quantity = $this ->Quantity;
//			$quentity_kde = $this -> Quantity_KDE;
        $submitedData = $this->getSubmitedData();
// print_r($submitedData);
        $exists = $this->checkIfDataExist($submitedData);


        if ($exists) {
//			echo 2;
            if (!$this->hasChanged($submitedData)) {
//				echo 3;
                return false;
            }
            $this->StatusId = ComponentUtils::$STATUS_MODIFIED;

            try {
//			 echo 4;
                $res = parent::store();
            } catch (Exception $e) {
//				echo 5;
                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                return false;
            }
            //exit();
        } else {
//			echo 6;
//print_r($submitedData);
            if ($submitedData['Quantity'] == 0 && $submitedData['Quantity_KDE'] == 0) {
//				echo 7;
                JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_NO_DATA_NO_UPDATE'), 'error');
                return false;
            }
        }
        $this->loadSubmited($submitedData);
        if ($this->Quantity == 0 && $this->Quantity != null) {
//			echo 8;
            $this->insertNewWithStatus(ComponentUtils::$STATUS_DELETED);
        } elseif ($this->Quantity_KDE == 0 && $this->Quantity_KDE != null) {
//			echo 9;
            $this->insertNewWithStatus(ComponentUtils::$STATUS_DELETED);
        } else {
//			echo '10.';
            $this->insertNewWithStatus(ComponentUtils::$STATUS_ACTIVE);
        }
    }

    private function loadSubmited($submitedData) {
        $this->HealthUnitId = $submitedData['HealthUnitId'];
        $this->RefDate = $submitedData['RefDate'];
        $this->MedicalTypeId = $submitedData['MedicalTypeId'];
        $this->MedicalActId = $submitedData['MedicalActId'];
        $this->Quantity = $submitedData['Quantity'];
        $this->Quantity_KDE = $submitedData['Quantity_KDE'];
     //   $this->UserId = $submitedData['UserId'];
        $this->AutoDate = $submitedData['AutoDate'];
        $this->PatientAttributeInsurance = ( isset($submitedData['PatientAttributeInsurance']) ? $submitedData['PatientAttributeInsurance'] : null );
        $this->PatientAttributeOrigination = ( isset($submitedData['PatientAttributeOrigination']) ? $submitedData['PatientAttributeOrigination'] : null );
        $this->MunicipalityId = ( isset($submitedData['MunicipalityId']) ? $submitedData['MunicipalityId'] : null );
        $this->PersonelId = ( isset($submitedData['PersonelId']) ? $submitedData['PersonelId'] : null );
        $this->PatientAmka = ( isset($submitedData['PatientAmka']) ? $submitedData['PatientAmka'] : null );
    }

    private function insertNewWithStatus($statusId) {
        $this->MedicalTransactionId = null;
        $this->StatusId = $statusId;
        try {
            $res = parent::store();
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    private function flow2() {
        $submitedData = $this->getSubmitedData();
        //$submitedData['MedicalTransactionId'] = $this -> MedicalTransactionId;
        $this->load($this->MedicalTransactionId);
        $this->StatusId = ComponentUtils::$STATUS_MODIFIED;
        parent::store();

        $this->loadSubmited($submitedData);
        $this->insertNewWithStatus(($submitedData['Quantity'] === 0 ? ComponentUtils::$STATUS_DELETED : ComponentUtils::$STATUS_ACTIVE));
        $this->insertNewWithStatus(($submitedData['Quantity_KDE'] === 0 ? ComponentUtils::$STATUS_DELETED : ComponentUtils::$STATUS_ACTIVE));
    }

}
