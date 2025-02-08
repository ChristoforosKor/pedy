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
class ElgPedyControllerChildPsychoDataEditSave extends QuantityDataEditSave
{
	private static $LAST_OLD_DATE = '2016-08-31'; // last date of old status. 
	public function __construct(\JInput $input = null, \JApplicationBase $app = null)
	{
		parent::__construct($input, $app);
		if( $this -> input -> getString('RefDate') <= self::$LAST_OLD_DATE):
			$appData = $this -> state -> get('appData');
			$appData['controller'] = 'childpsychodataeditsaveold';
			$appData['model'] = 'childpsychodataeditsaveold';
			$appData['view'] = 'childpsychodataeditsaveold';
			$this -> input -> set('appData', $appData);
			$this -> state -> set('appData', $appData);
			$this->model = Factory::getModel($appData['componentname'], $appData['model'], $this->state);
			//$this -> appData = $appData;
		endif;
	}
	
	public function execute() 
	{
		$input = $this->getInput();
		
		$this->formData->ClinicDepartmentId = $input->getInt('did');
		$this->formData->ClinicTypeId = $input->getInt('cid');
		$this->formData->ClinicIncidentId = $input->getInt('iid');	
		$this->formData->PersonelId = $input->getInt('pid');
                                $this->formData->ClinicIncidentGroupId = $input->getInt('ig', 0);
                                $this -> formData -> PatientAmka = $input -> getInt('patient_amka', 0 );
                                $this -> formData -> EducationId = $input -> getInt('education_id', 0);
		$this->state->set('formData', $this->formData);
		try {
		    $this->model->setState($this->state);	
		}
		catch(Exception $e)
		{
                                         JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
		}
		echo self::getViewWithModel($this->appData, $this->state)->render();
	}
}
