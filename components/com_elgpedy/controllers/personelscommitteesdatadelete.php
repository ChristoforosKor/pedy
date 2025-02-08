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
class ElgPedyControllerPersonelsCommitteesDataDelete extends Controller
{
	public function execute() 
	{
	    $formData = new stdClass();
            $input = $this->getInput();
            $appData = ComponentUtils::getAppData($input);
            $appData['format'] = 'json';
            $state = new JRegistry(ComponentUtils::getAppData($input));
            $formData->PersonelScheduleId = $input->getInt('PersonelScheduleId', 0);     
            $state->set('formData', $formData);
            try {	
                $model = Factory::getModel($appData['componentname'], $appData['model'] );		
                $model->setState($state);	
            }
            catch(Exception $e)
            {
                    JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            }
            echo  self::getViewWithModel($appData, $state)->render();				
    }
}
