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
require_once JPATH_COMPONENT_SITE . '/models/pedydataeditsave.php';

 
 class ElgPedyModelProlepsisCommunityDataEditSave extends PedyDataEditSave
 {
	public function __construct(\JRegistry $state = null)
	{
		
		parent::__construct($state);
		
		$this->table = JTable::getInstance('MedicalTransaction');
	
	}
	
	function setState(JRegistry $state) 
	{
		
		$formData = $state->get('formData');
	
		$this->initTable($formData);
		$this -> table -> MedicalTransactionId = $formData -> id;
		$this->table->MedicalActId = $formData->MedicalActId;
		$this->table->Quantity = $formData->Quantity;
		$this->table->MedicalTypeId = $formData->MedicalTypeId;
		$this -> table -> PatientAttributeInsurance = $formData-> PatientAttributeInsurance;
		$this -> table -> PatientAttributeOrigination = $formData -> PatientAttributeOrigination;
		$this -> table -> PersonelId = $formData -> PersonelId;
		$this -> table -> MunicipalityId = $formData -> MunicipalityId;
		$this -> table -> PatientAmka = $formData -> PatientAmka;
		try {		
			$this -> table -> store();
		}
		catch ( Exception $e ) {
			throw new Exception ( $e -> getMessage() );
		}
			
	}
 }	
