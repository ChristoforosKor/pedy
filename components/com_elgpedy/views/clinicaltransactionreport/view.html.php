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
   require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
  
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
    class ElgPedyViewClinicalTransactionReport extends  DataCommonReport
    {
        public function render()
        {
            $data = $this->state->get('data');
			
			// $data2 = ViewUtils::ClinicalReformClinicDoctorRecords($data -> newData, $data -> doctors);
			
            $this->clinics = $data->clinics;
            $this->incidents = $data->incidents;
            $this -> reformedGroups = ViewUtils::reformGroups ( $data -> fields -> incidentsGroups);
            if (isset($data -> data)):
                    $this->dataClinical = ViewUtils::ClinicalReform($data -> data);
            endif;
            $this -> incidentsGroups = $data -> fields -> incidentsGroups;
            if (isset($data -> newData)):
                $clinics = ViewUtils::groupClincsByIsSummed ( $data -> fields -> clinics );
                $sumedClinics = array_column( $clinics['summed'], 'ClinicId');
                $dataSummed = array_filter( $data -> newData, function( $val ) use ( $sumedClinics  ) {
                    return in_array($val -> ClinicTypeId, $sumedClinics);
                });
                $notSumedClinics = array_column( $clinics['notSummed'], 'ClinicId');           
                $dataWithDoctors = array_filter( $data -> newData, function( $val ) use ( $notSumedClinics  ) {
                    return in_array($val -> ClinicTypeId, $notSumedClinics);
                });
            
                    $this-> newData = ViewUtils::ClinicalReformClinicDoctorRecords($dataWithDoctors, $data -> doctors); //ViewUtils::ClinicalReformWithDoctors($data -> newData);
                    $this-> newDataSumed = ViewUtils::ClinicalReform( $dataSummed ); //ViewUtils::ClinicalReformClinicDoctorRecords($dataSummed, $data -> doctors); 
                    $this -> doctors = $data -> doctors;
            endif;
            
            $this -> sumedClinics = $clinics['summed']; //( isset($sumedClinics ) ? array_map(function ($val) { return (object) $val; }, $sumedClinics ) : [] );
            $this -> notSumedClinics = $clinics['notSummed']; // ( isset($notSumedClinics ) ? array_map( function ( $val ){ return (object) $val ;}, $notSumedClinics): []  );
            $this -> d1 = $data -> d1;
            $this -> d2 = $data -> d2;
            $this->checker = $data->checker;
            $this->dataLayout = 'clinicaltransactionreport.php';
            $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=112');
            return parent::render();
        }	
    }
