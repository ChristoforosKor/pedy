<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_COMPONENT_SITE . '/models/pedy.php';

class PedyDataEdit extends Pedy {

    protected $forms = '';

    public function __construct(\JRegistry $state = null) {
        parent::__construct($state);
        $commonForm = JForm::getInstance('datacommon', ComponentUtils::getDefaultFormPath() . '/datacommon.xml');
		
        $date = ComponentUtils::getDateFormated($state->get('RefDate', ''), 'Y-m-d', 'd/m/Y');      
		if ($date === false || $date === '') {
            $date = date('d/m/Y');
            $state->set('RefDate', date('Y-m-d'));
        }		
        $commonForm->setValue('RefDate', null, $date);
        $date = ComponentUtils::getDateFormated($state->get('RefDateTo', ''), 'Y-m-d', 'd/m/Y');
        if ($date === false) {
            $date = date('t/m/Y');
            $state->set('RefDateTo', date('Y-m-t'));
        }
        $commonForm->setValue('RefDateTo', null, $date);
        $date = ComponentUtils::getDateFormated($state->get('RefDateFrom', ''), 'Y-m-d', 'd/m/Y');
        if ($date === false) {
            $date = date('1/m/Y');
            $state->set('RefDateFrom', date('Y-m-1'));
        }
        $commonForm->setValue('RefDateFrom', null, $date);
        $commonForm->setValue('HealthUnitId', null, $state->get('HealthUnitId'));
        if ($state->get('RefYear', 0) > 0) {
            $commonForm->setValue('RefYear', null, $state->get('RefYear'));
        }
        if ($state->get('RefMonth', 0) > 0) {
            $commonForm->setValue('RefMonth', null, $state->get('RefMonth'));
        }
        $forms = new stdClass();
        $forms->commonForm = $commonForm;
        $state->set('forms', $forms);
    }
}