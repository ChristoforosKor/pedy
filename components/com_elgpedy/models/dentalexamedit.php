<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism  application
  # ------------------------------------------------------------------------
  # author    e-logism
  # copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr


  ----------------------------------* */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';

class ElgPedyModelDentalExamEdit extends PedyDataEdit {

    function getState() {
        $db = $this->pedyDB;
        $state = parent::getState();
        $data = [];

        $forms = $state->get('forms');

        $forms->dentalexamedit = JForm::getInstance('dentalexamedit', ComponentUtils::getDefaultFormPath() . '/dentalexamedit.xml');

        $data['schools'] = Queries::getSchoolData($db);
        $data['levelClasses'] = Queries::getSchoolLevelClasses($db);
        $data['areas'] = Queries::getArea($db);
        $data['areaTypes'] = Queries::getAreaType($db);
        $data['dentalConditions'] = Queries::getDentalCondition($db);
        $data['schoolLevels'] = array_values(
                array_unique(
                        array_map(function( $item ) {
                            return [$item[0], $item[1]];
                        }, $data['levelClasses'])
                        , SORT_REGULAR
        )); // array_unique( array_column( $data['levelClasses'], 0 ) ) ;
        //$data['educationLevels'] = Queries::getEducationLevels($db);



        $data['dentalTooths'] = Queries::getDentalTooth($db);
        $id = $state->get('id', 0);
        if ($id > 0):
            $dentalExam = JTable::getInstance('dentaltransaction');
            $dentalExam->load($id);
            $forms->dentalexamedit->bind($dentalExam);
            $forms->commonForm->setValue('HealthUnitId', null, $dentalExam->health_unit_id);
            //HealthUnitId
            $mouth = $this->getMouthTransaction($db, $id);
            $forms->dentalexamedit->setValue('dental_mouthcondition', null, $mouth);
            $forms->dentalexamedit->setValue('problem_category_2', null, $mouth);
            $forms->dentalexamedit->setValue('problem_category_3', null, $mouth);
            $forms->dentalexamedit->setValue('problem_category_4', null, $mouth);
            $data['toothTransactions'] = $this->getToothTransaction($db, $id);
        else:
            $data['toothTransactions'] = array();
            $forms->dentalexamedit->setValue('school_id', null, $state->get('school_id', 0));
        endif;
        $state->set('data', $data);
        $state->set('forms', $forms);
        return $state;
    }

    private function getMouthTransaction($db, $id) {
        $query = 'select dental_mouthcondition_id from dental_transaction_mouth where dental_transaction_id = ' . $id . ' and status_id = ' . ComponentUtils::$STATUS_ACTIVE;
        $db->setQuery($query);
        return $db->loadColumn();
    }

    private function getToothTransaction($db, $id) {
        $query = 'select dental_tooth_id, dental_condition_id from dental_transaction_tooth where dental_transaction_id = ' . $id . ' and status_id = ' . ComponentUtils::$STATUS_ACTIVE;
        $db->setQuery($query);
        return $db->loadRowList();
    }

}
