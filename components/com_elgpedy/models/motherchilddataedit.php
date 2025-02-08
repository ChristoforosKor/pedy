<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';
require_once JPATH_COMPONENT_SITE . '/models/clinictransactiondataedit.php';
require_once JPATH_COMPONENT_SITE . '/models/medicaltransactiondataedit.php';
 
 class ElgPedyModelMotherChildDataEdit extends PedyDataEdit
 {
	public $medicalCategory = 4;
	function getState() 
	{
		$state = parent::getState();
		$clinicModel = new ElgPedyModelClinicTransactionDataEdit($state);
		$clinicModel->medicalCategory = $this->medicalCategory;
		$mcState = $clinicModel->getState();
		$clinicFields = $mcState->get('dataFields');
		$medicalModel = new ElgPedyModelMedicalTransactionDataEdit($state);
		$medicalModel->medicalActId = '24,25,26';
		$mmState = $medicalModel->getState();
		
		
		$forms = new stdClass();
		$forms->commonForm = $this->commonForm;
		$state->set('forms', $forms);
		if($state->get('RefMonth',0 ) > 0 && $state->get('RefYear',0 ) && $this->HealthUnit->HealthUnitId)
        {
			$this->query->clear();
            $this->query->select(' mt.UserId, mt.HealthUnitId, MedicalTypeId, Quantity, RefYear, RefMonth' )
				->from('#__MedicalTransaction mt')
                ->where( 'StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefYear= ' . $state->get('RefYear', 0) . ' and RefMonth = ' . $state->get('RefMonth',0 ) . ' and HealthUnitId = ' . $this->HealthUnit->HealthUnitId );
            ;
            $this->data->data = $this->pedyDB->loadObjectList();
        }
        else 
        {
            $this->data->data = array();
        }
		$this->data->mc = $this->medicalCategoryId;
		return $state;
	}
 }