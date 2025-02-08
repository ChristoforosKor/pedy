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
require_once JPATH_COMPONENT_SITE . '/controllers/editsave.php';
																			

class ElgPedyControlleradiologioDataEditSave extends EditSave 
{
	
	public function execute() 
	{
		
		$input = $this->getInput();
                $this->formData->PersonelAttendanceBookRafinaId = $input->getInt('PersonelAttendanceBookRafinaId',0);
		$this->formData->PersonelId = $input->getInt('PersonelId',0);
		$this->formData->PersonelStatusId = $input->getInt('PersonelStatusId', 0);
        $this->formData->PersonelStatusGroupId = $input->getInt('PersonelStatusGroupId', 0);		
		$this->formData->StartDate = ComponentUtils::getDateFormated($input->getString('StartDate',''), 'd/m/Y', 'Y-m-d');		
		$this->formData->EndDate = ComponentUtils::getDateFormated($input->getString('EndDate',''), 'd/m/Y', 'Y-m-d');
		$this->formData->Details = $input->getString('Details','');		
		$this->formData->Duration = $input->getString('Duration','');
		$this->formData->Year = $input->getString('Year','');
		
		
	
		
		
		$this->state->set('formData', $this->formData);
		$this->model->setState($this->state);
		$app = JFactory::getApplication();
		$app->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
		$redUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=156',  false);
		$app->redirect($redUrl);
    }
}
