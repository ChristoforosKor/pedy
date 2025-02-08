<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  require_once JPATH_COMPONENT_SITE . '/views/datacommonreport.php';
  require_once JPATH_COMPONENT_SITE . '/views/clinicaltransaction/view.html.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewMotherChildCareReport extends DataCommonReport
   {
        public function render()
        {
                $data = $this->state->get('data');
	// echo json_encode( $data -> prolepsis);
                $this->clinics = $data->clinics -> fields -> clinics;
                $this->incidents = $data-> clinics -> fields ->  incidents;
                $this -> reformedGroups = ViewUtils::reformGroups ( $data -> clinics -> fields -> incidentsGroups);
                if ( isset( $data -> clinics -> data ) ):
                    $this->dataClinical = ViewUtils::ClinicalReform($data -> clinics -> data);
                endif;
                if (isset($data -> clinics -> newData)):
//                        $this-> newData = ViewUtils::ClinicalReformClinicDoctorRecords($data -> clinics -> newData, $data -> clinics -> doctors); //ViewUtils::ClinicalReformWithDoctors($data -> newData);
//                        $this -> doctors = $data -> clinics -> doctors;
                         
                        
                        $clinics = ViewUtils::groupClincsByIsSummed (  $this->clinics );
                        $sumedClinics = array_column( $clinics['summed'], 'ClinicId');
                        $dataSummed = array_filter($data -> clinics -> newData, function( $val ) use ( $sumedClinics  ) {
                            return in_array($val -> ClinicTypeId, $sumedClinics);
                        });
                        $notSumedClinics = array_column( $clinics['notSummed'], 'ClinicId');           
                        $dataWithDoctors = array_filter( $data -> clinics -> newData, function( $val ) use ( $notSumedClinics  ) {
                            return in_array($val -> ClinicTypeId, $notSumedClinics);
                        });
            
                    $this-> newData = ViewUtils::ClinicalReformClinicDoctorRecords($dataWithDoctors,  $data -> clinics -> doctors); //ViewUtils::ClinicalReformWithDoctors($data -> newData);
                    $this-> newDataSumed = ViewUtils::ClinicalReform( $dataSummed ); //ViewUtils::ClinicalReformClinicDoctorRecords($dataSummed, $data -> doctors); 
                    $this -> doctors =  $data -> clinics -> doctors;
                    $this -> sumedClinics = $clinics['summed']; //( isset($sumedClinics ) ? array_map(function ($val) { return (object) $val; }, $sumedClinics ) : [] );
                    $this -> notSumedClinics = $clinics['notSummed'];
                endif;
                
                $this -> d1 = (isset( $data -> clinics -> d1) ? $data -> clinics -> d1: []);
                $this -> d2 = (isset( $data -> clinics -> d2) ? $data -> clinics -> d2: [] );;
                $this->checker = $data-> clinics -> checker;
            
            
            
//            $this -> fields  = new stdClass;
//            $this -> fields -> prolepsis = 
//            var_dump( $this -> fields -> prolepsis );
            $this->dataLayout = 'clinicaltransactionreport.php';
            $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=112');
            
                
                
            $this->fields =  new stdClass(); 
            

            $this->fields->prolepsis = $data->fields->prolepsis; //$data -> prolepsis;
            $this->dataLayout = 'motherchildcarereport.php';

            $this->dataProlepsis =ViewUtils::ProlepsisReform($data->prolepsis);
            $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=114');
            $this->clinicMissing = $data->clinicMissing;
            $this->prolepsisMissing = $data->prolepsisMissing;
            return parent::render();
        }
   }
