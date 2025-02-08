<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );

class MissingDates 
{
	private $db = null;
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	public function findMissingMedical($startDate, $endDate, $HealthUnitId, $medicalActIds, $medicalTypeIds)
	{
		$query = $this->db->getQuery(true);
		$query->select('distinct RefDate')
		->from('#__MedicalTransaction') 
		->where('RefDate between \'' . $startDate . '\' and \'' . $endDate . '\'
			and StatusId = 1 and Quantity > 0 and HealthUnitId = '. $HealthUnitId . ' 
			and MedicalActId in (' . implode(',', array_unique($medicalActIds)) . ')  
			and MedicalTypeId in (' . implode(',', array_unique($medicalTypeIds)) . ')')
			->order('RefDate asc');
		$this->db->setQuery($query);
            //    $dbg = $query->dump();
		$existing = $this->db->loadColumn(0);
		$allDates = ComponentUtils::getDateRange($startDate, $endDate);
		return array_diff($allDates, $existing); 
	}
	
	public function getMissingMedical($startDate, $endDate, $HealthUnitId, $paramsData)
	{
		
		$medicalActIds = array(-1);
		$medicalTypeIds = array(-1);
		$results = new stdClass(-1);
		foreach($paramsData as $item)
		{			
                    $medicalActIds[] = $item->MedicalActId;
                    $medicalTypeIds[] = $item->MedicalTypeId;
		}
                unset($item);
		$results->medicalActIds = $medicalActIds;
		$results->medicalTypeIds = $medicalTypeIds;
		return $this->findMissingMedical($startDate, $endDate, $HealthUnitId, $results->medicalActIds, $results->medicalTypeIds);
	}
        
        
        public function findMissingClinic($startDate, $endDate, $HealthUnitId, $ClinicDepartmentIds, $ClinicIds, $ClinicIncidentIds)
        {
            $query = $this->db->getQuery(true);
            $query->select('distinct RefDate')
            ->from('ClinicTransaction')
            ->where('RefDate between \'' . $startDate . '\'  and \'' . $endDate . '\'
            and StatusId = 1 and Quantity > 0 and HealthUnitId = ' . $HealthUnitId . ' 
            and ClinicDepartmentId in (' . implode(',', array_unique($ClinicDepartmentIds)). ')
            and ClinicTypeId in (' . implode(',', array_unique($ClinicIds)) . ')
            and ClinicIncidentId in(' . implode(',', array_unique($ClinicIncidentIds)) . ')')
            ->order('RefDate asc');
            //$dbg = $query->dump();
            $this->db->setQuery($query);
            $existing = $this->db->loadColumn(0);
            $allDates = ComponentUtils::getDateRange($startDate, $endDate);
            return array_diff($allDates, $existing); 
            
        }
        
        public function getMissingClinic($startDate, $endDate, $HealthUnitId, $paramsData)
        {
            $ClinicDepartmentIds = array(-1); 
            $ClinicIds = array(-1);
            $ClinicIncidentIds = array(-1);
            
            foreach($paramsData->clinics as $clinic)
            {
                $ClinicDepartmentIds[] = $clinic->DepartmentId;
                $ClinicIds[] = $clinic->ClinicId;
                
            }
            unset($clinic);
            
            foreach($paramsData->incidents as $incident)
            {
                $ClinicIncidentIds[] = $incident->IncidentId;
            }
            unset($incident);
            return $this->  findMissingClinic($startDate, $endDate, $HealthUnitId, $ClinicDepartmentIds, $ClinicIds, $ClinicIncidentIds);
        }
       
 }
