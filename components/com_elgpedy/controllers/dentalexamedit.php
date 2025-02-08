<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism 
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/edit.php';
 
class ElgPedyControllerDentalExamEdit extends Edit{
    
     public function execute() {
        $input = $this->getInput();
        $appData = ComponentUtils::getAppData($input);
        $appData['RefMonth'] = $input->getInt('RefMonth', 0);
        if($appData['RefMonth'] === 0)
        {
            $appData['RefMonth'] = date('M');
        }
        $appData['RefYear'] = $input->getInt('RefYear', 0);
        if($appData['RefYear'] === 0)
        {
            $appData['RefYear'] = date('Y');
        }
        $appData['model'] = $appData['view'];
        $appData['school_id'] = $input->getInt('school_id', 0);
        $appData['RefDate'] = $input->getString('RefDate');
        $appData['HealthUnitId'] = $input->getInt('HealthUnitId');
        // $state = new JRegistry($appData);
        //$state->set('appData', );
        //$state->set('school_id', $input->getInt('school_id', 0));
        echo Controller::getViewWithModel($appData)->render();
        //Factory::getView($appData['componentname'], $appData['view'],  Factory::getModel($appData['componentname'], $appData['model'], ($state === null ? new JRegistry($appData) : $state)),$appData['format']);
    }
  
}
