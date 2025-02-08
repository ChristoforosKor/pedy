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
																			

class ElgPedyControllerHealthUnitEditSave extends EditSave 
{
	
	public function execute() 
	{
		
		$input = $this->getInput();
		$this->formData->HealthUnitId = $input->getInt('HealthUnitId');
		$this->formData->HealthUnitTypeId = $input->getInt('HealthUnitTypeId',0);		
		$this->formData->amka = $input->getInt('amka',0);		
		$this->formData->HealthUnitId = $input->getInt('HealthUnitId',0);	
		$this->formData->IsActive = $input->getString('IsActive','');
		
		$this->formData->DescEL = $input->getString('DescEL','');
		$this->formData->DescShortEL = $input->getString('DescShortEL','');
		$this->formData->Address = $input->getString('Address','');
		$this->formData->PostalCode = $input->getString('PostalCode','');
		$this->formData->Phone = $input->getString('Phone','');
		$this->formData->Fax = $input->getString('Fax','');
		$this->formData->Email = $input->getString('Email','');
		$this->formData->Personel = $input->getString('Personel','');
		
		
		$this->state->set('formData', $this->formData);
		$this->model->setState($this->state);
		$app = JFactory::getApplication();
		$app->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
		$redUrl = JRoute::_('index.php?option=com_elgpedy&view=healthunits&ItemId=' . $this->appData['Itemid'],  false);
		JFactory::getApplication()->redirect($redUrl);
    }
}
