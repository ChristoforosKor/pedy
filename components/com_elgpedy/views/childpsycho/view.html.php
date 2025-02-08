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
                                                $this -> checker = array_reduce( $data -> data , function ( $prev, $cur ){
                                                    return $prev + ( $cur -> ClinicIncidentId ===  '4' ?  $cur -> Quantity  : 0 );
                                                }, 0);
                                             
			$this->fields = $data->fields;
                                            
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
                                                $this -> reformedGroups = ViewUtils::reformGroups ( $this -> fields -> incidentsGroups);
                                                $this -> fields -> clinics = ViewUtils::groupClincsByIsSummed ( $this -> fields -> clinics );
                                                
                                                $sumedClinics = array_column( $this -> fields -> clinics['summed'], 'ClinicId');
                                                $dataSummed = array_filter( $data -> data, function( $val ) use ( $sumedClinics  ) {
                                                        return in_array($val -> ClinicTypeId, $sumedClinics);
                                                });
                                                $notSumedClinics = array_column( $this -> fields -> clinics['notSummed'], 'ClinicId');
                                                $dataWithDoctors = array_filter( $data -> data, function( $val ) use ( $notSumedClinics  ) {
                                                        return in_array($val -> ClinicTypeId, $notSumedClinics);
                                                });
                                               
                                                $this -> dataLayout = $this -> state -> get('dataLayout', 'childpsycho') . '.php'; // 'childpsycho.php';
                                                if ( $this -> dataLayout === 'childpsycho2.php'):
                                                    $this->dataClinical = ViewUtils::ClinicalReformDoctors2( $dataWithDoctors );
                                                else:
                                                    $this->dataClinical = ViewUtils::ClinicalReformDoctors( $dataWithDoctors );
                                                endif;
			 
                        
			$this->dataClinicalSummed = ViewUtils::ClinicalReform( $dataSummed ); 
	                                $this -> docsDrop = $this -> makeDocsDrop($this -> fields -> doctorsAll);
			$this -> refDate = $data -> refDate;
			$this -> healthUnitId = $data -> healthUnitId;
                                               

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
