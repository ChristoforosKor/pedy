<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
class ElgPedyControllerPersonelAttendancyBookSave extends Controller
{
    public function execute() 
    {
        $formData = new stdClass();
        $appInput = $this->input;
        $input = new JInputJSON();
        $formData->RefDate = ComponentUtils::getDateFormated($input->getInt('RefDate'), 'Ymd', 'Y-m-d' );
		
        $formData->HealthUnitId = $input->getInt('HealthUnitId');
        $formData->attendancyData = $input->get('aD', array(), 'ARRAY');
        $appData = ComponentUtils::getAppData($appInput);
        
        
        $state = new JRegistry($appData);
        $state->set('formData', $formData);
        try {
           
            $model = Factory::getModel($appData['componentname'], $appData['model'] );		
            $model->setState($state);	
        }
        catch(Exception $e)
        {
            
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }
        $state2 = array();
        $state2['RefDate'] = $formData->RefDate; 
        $state2['HealthUnitId'] = $formData-> HealthUnitId; 
          
        echo Factory::getView($appData['componentname'], 'personelattendancybook', Factory::getModel($appData['componentname'], 'personelattendancybook', new JRegistry($state2)), 'json')->render();
         				
    }
}
