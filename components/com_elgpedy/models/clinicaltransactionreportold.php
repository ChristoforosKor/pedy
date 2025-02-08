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
require_once JPATH_COMPONENT_SITE . '/models/missingdates.php';
 
class ElgPedyModelClinicalTransactionReportOld extends PedyDataEdit
{
    public function getState()
    {
        $data = new stdClass();
        $state = parent::getState();
        $this->query->clear();
        $this->query->select('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, sum(Quantity) as Quantity, ClinicDepartment, Clinic, ClinicIncident')
        ->from('vw_ClinicalTransaction')
        ->where('StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= \'' . $state->get('RefDateFrom', '') . '\' and RefDate <= \'' . $state->get('RefDateTo','' ) . '\' and HealthUnitId = ' . $state->get('HealthUnitId'))
        ->group('ClinicDepartmentId,ClinicTypeId, ClinicIncidentId, ClinicDepartment, Clinic, ClinicIncident')
        ->order('HealthUnit, ClinicDepartment,  Clinic, ClinicIncident');
		$this->pedyDB->setQuery($this->query);
		
		$data->data = $this->pedyDB->loadObjectList();		
		$this->query->clear();
		$this->query->select('sum(Quantity) as Quantity')
		->from('ClinicTransaction')
		->where('StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= \'' . $state->get('RefDateFrom', '') . '\' and RefDate <= \'' . $state->get('RefDateTo',0 ) . '\' and HealthUnitId = ' . $state->get('HealthUnitId') . ' and ClinicTypeId=0');
       
        $this->pedyDB->setQuery($this->query);
        $data->checker = $this->pedyDB->loadResult();
        
        if($data->checker ==  null)
        {
			$data->checker = 0;
		}
		
        if($state->get('format') == 'html')
        {
                $this->query->clear();
                $this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstIncidentByHU s');
                $this->pedyDB->setQuery($this->query);
                $data->incidents = $this->pedyDB->loadObjectList();
                $this->query->clear();
                $this->query->setQuery('select s.* from (select @p1:=' . $state->get('HealthUnitId') . ' p) parm , pedy.vw_lstClinicByHU s');
                $data->clinics = $this->pedyDB->loadObjectList();
                $data->fields = new stdClass();
                $data->fields->incidents = $data->incidents;
                $data->fields->clinics = $data->clinics;
                $md = new MissingDates($this->pedyDB);
                $missing = $md->getMissingClinic($state->get('RefDateFrom'),  $state->get('RefDateTo'), $state->get('HealthUnitId'), $data->fields);
                $data->missing = $missing;
        }
        $state->set('data', $data);
        return $state;
    }
}
