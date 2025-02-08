<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewChildPsycho extends DataCommon
   {
   	   	
		public function render()
		{
			
			$data = $this->state->get('data');
			$this->fields = $data->fields;
			$this->dataClinical = ViewUtils::ClinicalReformDoctors($data->data); // $this->reform($data->data);
			
			$departments = [];
			foreach($data->fields->incidents as $incident)
			{
				if (!isset($departments[$incident -> DepartmentId])):
					$departments[$incident -> DepartmentId] = [ 'name' => $incident -> Department, 'incidents' => [] ];
				endif;
				$departments[$incident -> DepartmentId]['incidents'] [] = $incident;
			}
			unset($incident);
			
			$this -> departments = $departments;
			$this->dataLayout = 'childpsycho.php';
			$this -> refDate = $data -> refDate;
			$this -> healthUnitId = $data -> healthUnitId;
			$this -> docsDrop = $this -> makeDocsDrop($this -> fields -> doctors);
			return parent::render();
		}
		
		private function makeDocsDrop($doctors)
		{
			$inserted = [];
			$nDSet = false;
			$res = '<select id="docsDrop">';
			foreach($doctors as $doctor):
				if ( $doctor['PersonelId'] === '' and $nDSet === true ):
					continue;
				else:
					$nDSet = true;
				endif;
				if(! in_array($doctor['PersonelId'], $inserted) ):
					$res .= '<option value="' . $doctor['PersonelId'] . '">' . $doctor['LastName'] . ' ' . $doctor['FirstName'] . '</option>';  
				endif;
				$inserted [] = $doctor['PersonelId'];
			endforeach;
			unset($doctor);
			$res .= '</select>';
			return $res;
		}
		
   }
