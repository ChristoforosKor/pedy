<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedydataeditsave.php';

 
 class ElgPedyModelClinicalTransactionDataEditSave extends PedyDataEditSave
 {
	
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		$this->table = JTable::getInstance('ClinicTransaction');
	}
	function setState(JRegistry $state) 
	{
		
		$formData = $state->get('formData');
		$formData -> RefDate = DateTime::createFromFormat( 'Ymd', $formData -> RefDate  ) -> format('Y-m-d');
		$this->initTable($formData);
		$this->table->Quantity = $formData->Quantity;
		$this->table->ClinicTypeId = $formData->ClinicTypeId;
		$this->table->ClinicIncidentId = $formData->ClinicIncidentId;
		$this->table->PersonelId = $formData->PersonelId;
                                $this -> table -> ClinicIncidentGroupId = $formData->ClinicIncidentGroupId; 
                                if ( isset( $formData -> EducationId ) != null )
                                {
                                    $this -> table -> ClinicIncidentGroupId = $formData->EducationId; 
                                }
                                $this->table->store();
 
	}
 }
