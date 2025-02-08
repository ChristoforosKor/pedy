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

 
 class ElgPedyModelPersonelsCommiteesDataEditSave extends PedyDataEditSave
 {
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		$this->table = JTable::getInstance('PersonelSchedule');
	}
	function setState(JRegistry $state) 
	{		
		$formData = $state->get('formData');
		$this->table->bind($formData);
		$this->table->store();	
		$formData->PersonelScheduleId = $this->table->PersonelScheduleId;
		$query = $this->pedyDB->getQuery(true);
		$query->select('LastName, FirstName, FromDate, ToDate, PersonelId, ScheduleId, CommitteeId, MemoColor')->from('pedy.vw_PersonelSchedule')->where('ScheduleId =' . $this->table->PersonelScheduleId); 
		$this->pedyDB->setQuery($query);
		$schedule = $this->pedyDB->loadObject();
		$data = new stdClass();
		$data->data = $schedule;
		$state->set('data', $data);
		
	}
 }
