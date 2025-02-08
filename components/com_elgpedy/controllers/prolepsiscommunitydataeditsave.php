<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/quantitydataeditsave.php';
class ElgPedyControllerProlepsisCommunityDataEditSave extends QuantityDataEditSave
{
	public function execute() 
	{
		$input = $this->getInput();
		$this -> formData -> id = $input -> getInt('id', 0);
		$this -> formData -> MedicalActId = $input->getInt('actid');
                $this -> formData -> MedicalTypeId = $input->getInt('mtid');
		$this -> formData -> PatientAttributeInsurance = $input -> getInt('pai', null);
		$this -> formData -> PatientAttributeOrigination = $input -> getInt('pao', null);
		$this -> formData -> PersonelId = $input -> getInt('pid', null);
		$this -> formData -> MunicipalityId = $input -> getInt('munic', null);
		$this -> formData -> PatientAmka = str_replace('.', '', str_replace( '_', '', str_replace( '-', '', $input -> getCmd('amka', null) ) ) );
		$this->state->set('formData', $this->formData);		
		try {			
		    $this->model->setState($this->state);	
		}
		catch(Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
		}
		echo  self::getViewWithModel($this->appData, $this->state)->render();				
    }
}
