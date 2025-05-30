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
class ElgPedyControllerPersonelsCommiteesDataEditSave extends Controller
{
	protected $formData = null;
	public function execute() 
	{
		
		$formData = new stdClass();
		$data = new stdClass();
		$input = $this->getInput();
		$appData = ComponentUtils::getAppData($input);
		$state = new JRegistry(ComponentUtils::getAppData($input));
		$formData->PersonelScheduleId = $input->getInt('PersonelScheduleId', 0);
		$formData->PersonelId = $input->getInt('PersonelId', 0);
        $formData->HealthCommitteeId = $input->getInt('HealthCommiteeId', 0);
		$formData->Start = $input->getString('startDateCommitee', '' );
		$formData->End = $input->getString('endDateCommitee', '' );
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
