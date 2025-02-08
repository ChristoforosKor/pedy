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
   
   class ElgPedyViewClinicalTransaction extends DataCommon
   {
   	   	
		public function render()
		{
			$data = $this->state->get('data');
                                                $this -> checkers = $this -> state -> get('checkers');
			$fields = $this -> state -> get('fields');
                                                $this -> reformedGroups = ViewUtils::reformGroups ( $fields -> incidentsGroups);
                                                $this -> clinics = ViewUtils::groupClincsByIsSummed ( $fields -> clinics );
                                                $sumedClinics = array_column( $this -> clinics['summed'], 'ClinicId');
                                                $dataSummed = array_filter( $data, function( $val ) use ( $sumedClinics  ) {
                                                        return in_array($val -> ClinicTypeId, $sumedClinics);
                                                });
                                                $notSumedClinics = array_column( $this -> clinics['notSummed'], 'ClinicId');
                                                $dataWithDoctors = array_filter( $data, function( $val ) use ( $notSumedClinics  ) {
                                                        return in_array($val -> ClinicTypeId, $notSumedClinics);
                                                });
                                                
                                                $this -> doctors = $fields -> doctors;
                                                $this -> incidents = $fields -> incidents;
                                                $this -> incidentsByRel = $fields -> incidentsByRel;
                                                $this->dataClinical = ViewUtils::ClinicalReformDoctors( $dataWithDoctors ); 
                        		$this->dataClinicalSummed = ViewUtils::ClinicalReform( $dataSummed ); 
	
                                                $this->dataLayout = 'clinicaltransaction.php';
                                                $this -> docsDrop = $this -> makeDocsDrop($fields -> doctorsAll);
			$this -> refDate = $this -> state -> get('refDate');
			$this -> healthUnitId = $this -> state -> get('healthUnitId');
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
