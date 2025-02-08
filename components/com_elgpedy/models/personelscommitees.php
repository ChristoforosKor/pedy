<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';

class ElgPedyModelPersonelsCommitees extends PedyDataEdit
{
	function getState() 
	{
		$state = parent::getState();
		$data = new stdClass();
		$query = $this->pedyDB->getQuery(true);
		$query->setQuery('select s.* from (select @p1:= ' . $state->get('HealthUnitId', 0) . ' p) parm , vw_lstDoctorByHU s');
		$this->pedyDB->setQuery($query);
		$data->personels = $this->pedyDB->loadObjectList();
		$query->clear();
		$query->setQuery('select s.* from (select @p1:= ' . $state->get('HealthUnitId', 0) . ' p) parm , vw_lstHealthCommitee s');	
		$data->commitees = $this->pedyDB->loadObjectList(); 
		$query->clear();
		$query->setQuery('select s.* from (select @p1:= ' . $state->get('HealthUnitId', 0) . ' p) parm , vw_PersonelSchedule s;');
		$data->data = $this->pedyDB->loadObjectList(); 
		$state->set('data', $data);
		return $state;	
	}
 }
