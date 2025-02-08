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
																			

class ElgPedyControllerPersonelEditSave extends EditSave 
{
	
	public function execute() 
	{
		
		$input = $this->getInput();
		$this -> formData -> pt = $input -> getInt('pt', 0);
		$this->formData->PersonelId = $input->getInt('PersonelId', 0);
		$this->formData->trn = trim($input->getString('trn',''));		
		$this->formData->amka = trim($input->getString('amka',0));	
		$this->formData->HealthUnitId = $input->getInt('HealthUnitId',0);	
		$this->formData->PersonelCategoryId = $input->getInt('PersonelCategoryId',0 );	
		$this->formData->PersonelEducationId = $input->getInt('PersonelEducationId',0);	
		$this->formData->PersonelSpecialityId = $input->getInt('PersonelSpecialityId',0);
		$this->formData->PersonelDepartmentId = $input->getInt('PersonelDepartmentId',0 );
		$this->formData->PersonelPositionId = $input->getInt('PersonelPositionId',0 );
		$this->formData->LastName = trim($input->getString('LastName',''));
		$this->formData->FirstName = trim($input->getString('FirstName',''));
		$this->formData->FatherName = trim($input->getString('FatherName',''));		
		$this -> formData -> RefHealthUnitId = $input -> getInt('RefHealthUnitId', 0);
		$this -> formData -> PersonelStatusId = $input -> getInt('PersonelStatusId', 0);
		$this -> formData -> RefUnitStartDate = ComponentUtils:: getDateFormated($input -> getString('RefUnitStartDate', ''),$inFormat='d/m/Y', $outFormat='Y-m-d');
		$this -> formData -> RefUnitEndDate = trim($input -> getString('RefUnitEndDate', ''));
                // $this -> formData -> StatusId = $input -> getInt('StatusId', 1); // if we explicitly make update to personnel without defining StatusId then we impolicitly make personel active.
		$this->state->set('formData', $this->formData);
		$app = JFactory::getApplication();
		try 
		{
			$this -> model -> setState( $this->state );			
			$redUrl = JRoute::_('index.php?option=com_elgpedy&view=personels&Itemid=' . $this->appData['Itemid'],  false);
			$app -> enqueueMessage( JText::_('COM_ELG_SUBMIT_SUCCESS') );
		}
		catch(Exception $e)
		{
			$app -> enqueueMessage( $e -> getMessage(), 'warning' );
			$redUrl = JRoute::_('index.php?option=com_elgpedy&view=personeledit&Itemid=' . $this->appData['Itemid'] . '&id=' . $this->formData->PersonelId,  false);
		}
		$app -> redirect($redUrl);
    }
}
