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

 
 class ElgPedyModelMotherChildDataEditSave extends PedyDataEditSave
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
		$this->table->MedicalActId = $formData->MedicalActId;
		$quantities = $formData->Quantity;
		$qc = count($quantities);
		if($qc > 0 )
		{
			$typeIds = $formData->MedicalTypeId;
			for($i = $qc -1; $i >=0; $i--)
			{
				if($quantities[$i] > 0)
				{
					$this->table->MedicalTypeId = $typeIds[$i];
					$this->table->Quantity = $quantities[$i];
					//$this->table->MedicalTransactionId = $formData->MedicalTransactionId;
					$this->table->store();
				}
			}
		}
	}
 }