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
  require_once JPATH_COMPONENT_SITE . '/views/clinicaltransaction/view.html.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewMotherChildCare extends DataCommon
   {
		public function render()
		{
			$data = $this->state->get('data') ;
                                         	$fields =  $this -> state ->get('fields') ; // new stdClass(); 
                                                $this -> reformedGroups = ViewUtils::reformGroups ( $fields ['clinical'] -> incidentsGroups );
                                                $this -> incidents = $fields['clinical'] -> incidents;
                                                $this -> incidentsByRel = $fields['clinical'] -> incidentsByRel;
                                                $this -> checkers = $this -> state -> get('checkers', 0);
                                                $this -> doctors = $fields['clinical'] -> doctors;
                                                $this -> clinics = ViewUtils::groupClincsByIsSummed ( $fields['clinical'] -> clinics );
                                                $sumedClinics = array_column( $this -> clinics['summed'], 'ClinicId');                                               
                                                $dataSummed = array_filter( $data['clinical'], function( $val ) use ( $sumedClinics  ) {
                                                        return in_array($val -> ClinicTypeId, $sumedClinics);
                                                });                                                
                                                $notSumedClinics = array_column( $this  -> clinics['notSummed'], 'ClinicId');
                                                $dataWithDoctors = array_filter( $data['clinical'], function( $val ) use ( $notSumedClinics  ) {
                                                        return in_array($val -> ClinicTypeId, $notSumedClinics);
                                                });
                                                $this -> dataClinical = ViewUtils::ClinicalReformDoctors( $dataWithDoctors ); 
                                	$this -> dataClinicalSummed = ViewUtils::ClinicalReform( $dataSummed ); 
                                                $this -> docsDrop = $this -> makeDocsDrop($fields['clinical'] -> doctorsAll);
			$this -> refDate = $this -> state -> get('RefDate','');
			$this -> healthUnitId = $this -> state -> get('HealthUnitId', 0);
                                                $this -> dataLayout = 'motherchildcare.php';
			$this -> dataProlepsis =ViewUtils::ProlepsisReform($data['prolepsis']);
                                                $this -> fields  = new stdClass();
                                                $this -> fields -> doctors = $fields['clinical'] -> doctors;
                                                $this -> fields -> clinics = $fields['clinical']->clinics;
                                                $this -> fields -> prolepsis = $fields['prolepsis'] ;
			return parent::render();			
		}
		
		
                
                
                                private function makeDocsDrop($doctors)
		{
                                              
			$inserted = [];
			$nDSet = false;
			usort( $doctors, [$this, 'sortDoctors'] );
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
                
                                private function sortDoctors($a, $b)
		{
			if ( $a['LastName'] === $b['LastName'] ):
				return 0;
			elseif ( $a['LastName'] > $b['LastName'] ):
				return 1;
			else:
				return -1;
			endif;
		}
   }