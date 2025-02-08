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
//require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
																			
require_once JPATH_COMPONENT_SITE . '/controllers/quantitydataeditsave.php';
class ElgPedyControllerMotherChildDataEditSave extends QuantityDataEditSave 
{
	
	public function execute() 
	{
		$input = $this->getInput();
		//$this->formData->MedicalActId = $input->getInt('MedicalActId', 0);
		$this->formData->MedicalTypeId = $input->get('MedicalTypeId', null, 'ARRAY');		
		$this->state->set('formData', $this->formData);
		$this->model->setState($this->state);
		$app = JFactory::getApplication();
		$app->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
		$redUrl = JRoute::_('index.php?option=com_elgpedy&view=motherchilddataedit&RefYear=' . $this->state->get('RefYear') . '&RefMonth=' . $this->state->get('RefMonth'), false);
		
        JFactory::getApplication()->redirect($redUrl);
    }
}
