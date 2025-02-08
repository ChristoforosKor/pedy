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
class ElgPedyControllerClinicalTransactionDataEditSaveOld extends QuantityDataEditSave
{
	public function execute() 
	{
		
		$input = $this->getInput();
		$this->formData->ClinicTypeId = $input->getInt('ctid');
        $this->formData->ClinicIncidentId = $input->getInt('iid');		
        $this->state->set('formData', $this->formData);
		try {
		    $this->model->setState($this->state);	
		}
		catch(Exception $e)
		{
			$JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
		}
		echo self::getViewWithModel($this->appData, $this->state)->render();
	}
}
