<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedy.php';

class ElgPedyModelHealthUnits extends Pedy
{
	function getState() 
	{
		
		$huids = ComponentUtils::getUserHUOnlyIds();
		
		$state = parent::getState();
		$data = new stdClass();
		$query = $this->pedyDB->getQuery(true);
		$columns = array('editcol','HealthUnitId' , 'HealthUnit', 'HealthUnitType', 'Address', 'Phone');
		
		$query->select('count(*)')
		->from('HealthUnit h')->innerJoin('HealthUnitType t on h.HealthUnitTypeId = t.HealthUnitTypeId')
		->innerJoin('HealthUnitDetail d on d.HealthUnitId = h.HealthUnitId and d.StatusId=' . ComponentUtils::$STATUS_ACTIVE)
		->where('h.StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and h.HealthUnitId in (' . implode(',', $huids) . ') ');
		
		$this->pedyDB->setQuery($query);
		$data->recordsTotal = $this->pedyDB->loadResult();
		$data->recordsFiltered = $data->recordsTotal;
		$query->clear('select');
		$query->select("h.HealthUnitId , ifNull(h.DescEL, '') as HealthUnit, ifNull(t.DescEL, '') as HealthUnitType, ifNull(d. Address, '') as Address, ifNull(d.Phone, '') as Phone")
		->order($state->get('filter_order', 0) . ' ' . $state->get('filter_order_Dir', 'asc'), ' limit ' . $state->get('limitstart') . ', '. $state->get('limit'));
		$data->data = $this->pedyDB->loadObjectList();
		$data->healthUnits = $this->pedyDB->loadObjectList();
		$data->draw = $state->get('draw', 0);
		$state->set('data', $data);
		return $state;	
	}
 }