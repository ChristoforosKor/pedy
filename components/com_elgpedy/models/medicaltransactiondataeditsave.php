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

 
 class ElgPedyModelMedicalTransactionDataEditSave extends PedyDataEditSave
 {
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		$this->table = JTable::getInstance('MedicalTransaction');
	}
	function setState(JRegistry $state) 
	{
		$formData = $state->get('formData');
//                print_r($formData);
//                exit('in');
		$this->initTable($formData);
                $this->table->Quantity = $formData->Quantity;
                $this->table->Quantity_KDE = $formData->Quantity_KDE;   
		$this->table->MedicalTypeId = $formData->MedicalTypeId;
		$this->table->MedicalActId = 5;
		$this->table->store();
	}
 }