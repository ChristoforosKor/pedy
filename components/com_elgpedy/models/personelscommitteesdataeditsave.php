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

 
 class ElgPedyModelPersonelsCommitteesDataEditSave extends PedyDataEditSave
 {
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		$this->table = JTable::getInstance('PersonelSchedule');
	}
	function setState(JRegistry $state) 
	{		
		$formData = $state->get('formData');
                $oldId = $formData->PersonelScheduleId; 
		$this->table->bind($formData);
		$this->table->store();	
		$formData->PersonelScheduleId = $this->table->PersonelScheduleId;
		$query = $this->pedyDB->getQuery(true);
		$query->select('PersonelScheduleId as ScheduleId, LastName, FirstName, start as FromDate, End as ToDate, #__PersonelSchedule.PersonelId, #__PersonelSchedule.HealthCommitteeId as CommitteeId, MemoColor')->from('#__PersonelSchedule')->innerJoin('#__Personel on #__PersonelSchedule.PersonelId = #__Personel.PersonelId')->innerJoin('#__HealthCommittee on #__HealthCommittee.HealthCommitteeId = #__PersonelSchedule.HealthCommitteeId')->where('PersonelScheduleId =' . $this->table->PersonelScheduleId); 
		$this->pedyDB->setQuery($query);
		$schedule = $this->pedyDB->loadObject();
                $schedule->oldId = $oldId; 
		$data = new stdClass();
		$data->data = $schedule;
		$state->set('data', $data);
		
	}
 }
