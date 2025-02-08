<?php

class ViewUtils {

    /**
     * Reforms model data to be viewed according to old style where doctors area not visible. Only the sums are showing for each exam.
     * @data Array Data retrieved from model.
     * */
    public static function ProlepsisReform($data) {
        $dataProlepsis = array();
        foreach ($data as $item) {

            if (isset($dataProlepsis[$item->MedicalActId])) {
                $dataProlepsis[$item->MedicalActId][$item->MedicalTypeId] = $item->Quantity;
            } else {
                $dataProlepsis[$item->MedicalActId] = array();
                $dataProlepsis[$item->MedicalActId][$item->MedicalTypeId] = $item->Quantity;
            }
        }
        unset($item);
        return $dataProlepsis;
    }

    /**
     * Reforms model data to be viewed according to then new style where doctors area visible. Sums are presented on a per for each exam.
     * @data Array Data retrieved from model.
     * */

    /**
      public static function ProlepsisReformDoctor($data)
      {

      $dataProlepsis = array();

      foreach($data as $item):

      if( !isset ($dataProlepsis [ $item -> MedicalActId ] ) ) :
      $dataProlepsis [ $item -> MedicalActId ] = [];
      endif;
      if( !isset( $dataProlepsis [$item -> MedicalActId] [$item -> PersonelId]) ):
      $dataProlepsis [$item -> MedicalActId] [$item -> PersonelId]= [];
      endif;
      $dataProlepsis [$item -> MedicalActId] [$item -> PersonelId] []= [ $item -> MedicalTransactionId, $item -> PatientAmka, $item -> PatientAttributeInsurance, $item -> PatientAttributeOrigination,  $item -> MedicalTypeId, $item -> MunicipalityId, $item->Quantity  ];
      endforeach;
      unset($item);

      return $dataProlepsis;
      }

     * */
    public static function ClinicalReform($data) {

        $dataClinical = array();

        foreach ($data as $item) {
            if (!isset($dataClinical [$item->ClinicDepartmentId])) :
                $dataClinical [$item->ClinicDepartmentId] = [];
            endif;

            if (!isset($dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId])):
                $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] = [];
            endif;
            if (!isset( $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->ClinicIncidentId])):
                 $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->ClinicIncidentId] = [];
            endif;
            $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->ClinicIncidentId] [$item->ClinicIncidentGroupId] = $item->Quantity;
        }
        unset($item);
        return $dataClinical;
    }
    
      /**
     * @param $data Array An array of objects that contains incidents data (e.g. ClinicalTransaction table)
     * @param $doctors An array containg doctors information
     */
    public static function ClinicalReformClinicDoctorRecords($data, $doctors) {
     
        forEach ($doctors as $dKey => $doctor):
            $doctors[$dKey]['incidents'] = [];
            forEach ($data as $tKey => $record):
                // if the incident if the perticular doctor, clininc we added this info on the doctors array
                if ($doctor['PersonelId'] === $record->PersonelId && $doctor['ClinicDepartmentId'] === $record->ClinicDepartmentId && $doctor['ClinicTypeId'] === $record->ClinicTypeId):
                    if (!isset($doctors[$dKey]['incidents'][$record->ClinicIncidentId])):
                        $doctors[$dKey]['incidents'][$record->ClinicIncidentId] = [];
                    endif;
                    if (!isset($doctors[$dKey]['incidents'][$record->ClinicIncidentId][$record->ClinicIncidentGroupId])):
                        $doctors[$dKey]['incidents'][$record->ClinicIncidentId][$record->ClinicIncidentGroupId] = [];
                    endif;
                        $doctors[$dKey]['incidents'][$record->ClinicIncidentId][$record->ClinicIncidentGroupId]= $record->Quantity;
                    unset($data[$tKey]); // we have matched this inicdent so we remove it for not searching it again/
                endif;
            endforeach;
            unset($tKey);
            unset($record);
        endforeach;
        unset($doctor);
        unset($dKey);

        return self::addExternalClinicDoctorIncident(self::DoctorsClinicIncidents2ClinicDoctorIncidents($doctors), $data);
    }

    public static function ClinicalReformDoctors($data) {
        $dataClinical = array();
        foreach ($data as $item):
            if (!isset($dataClinical [$item->ClinicDepartmentId])) :
                $dataClinical [$item->ClinicDepartmentId] = [];
            endif;

            if (!isset($dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId])):
                $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] = [];
            endif;
            if (!$item->PersonelId > 0):
                $item->PersonelId = 0;
            endif;
            if (!isset($dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId])):
                $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId] = [];
            endif;
            if (!isset($dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId] [$item->ClinicIncidentId])):
                $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId] [$item->ClinicIncidentId] = [];
            endif;
            $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId] [$item->ClinicIncidentId] [$item->ClinicIncidentGroupId] = $item->Quantity;
        endforeach;
        unset($item);
        return $dataClinical;
    }

    public static function ClinicalReformDoctors2($data) {
        $dataClinical = array();
        foreach ($data as $item):
          
            if (!isset($dataClinical [$item->ClinicTypeId])):
                $dataClinical [$item->ClinicTypeId] = [];
            endif;
            if (!$item->PersonelId < 0):
                $item->PersonelId = 0;
            endif;
            if (!isset( $dataClinical[$item->ClinicTypeId] [$item->PersonelId] ) ):
                $dataClinical [$item->ClinicTypeId] [$item->PersonelId] = [];
            endif;           
           $dataClinical [$item->ClinicTypeId] [$item->PersonelId] [$item->PatientAmka]  =  [ $item -> Quantity, $item->ClinicIncidentId, $item -> EducationId ];
        endforeach;
        unset($item);
        return $dataClinical;
    }
    
    
    
    
    public static function ClinicalReformWithDoctors($data) {

        $dataClinical = array();
        foreach ($data as $item) {
            if (!isset($dataClinical [$item->ClinicDepartmentId])) :
                $dataClinical [$item->ClinicDepartmentId] = [];
            endif;

            if (!isset($dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId])):
                $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] = [];
            endif;
            if (!isset($dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId])):
                $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId][$item->PersonelId] = [];
            endif;
            $dataClinical [$item->ClinicDepartmentId] [$item->ClinicTypeId] [$item->PersonelId] [$item->ClinicIncidentId] = $item->Quantity;
        }
        unset($item);

        return $dataClinical;
    }
    
     public static function ClinicalReformWithDoctors3($data) {

        $dataClinical = array();
        foreach ($data as $item) {
          if( !isset( $dataClinical[$item->ClinicTypeId] ) ):
                $dataClinical [$item->ClinicTypeId] = [];
            endif;
            if (!isset( $dataClinical[$item->ClinicTypeId] [$item->PersonelId])):
                $dataClinical [$item->ClinicTypeId][$item->PersonelId] = [];
            endif;
            $dataClinical [$item->ClinicTypeId] [$item->PersonelId]  [$item->PatientAmka]  =  [ $item -> Quantity, $item->ClinicIncident, $item -> Education ];
        }
        unset($item);
        return $dataClinical;
    }

  

    /**
     * @param $data Array Withs doctors and their incidents for the clininc the belong to
     */
    public static function DoctorsClinicIncidents2ClinicDoctorIncidents($data) {
        $res = [];
        foreach ($data as $item):
            if (!isset($res[$item['ClinicDepartmentId']])):
                $res[$item['ClinicDepartmentId']] = [];
            endif;
            if (!isset($res[$item['ClinicDepartmentId']][$item['ClinicTypeId']])):
                $res[$item['ClinicDepartmentId']][$item['ClinicTypeId']] = [];
            endif;
            if (!isset($res[$item['ClinicDepartmentId']][$item['ClinicTypeId']][$item['PersonelId']])):
                $res[$item['ClinicDepartmentId']][$item['ClinicTypeId']][$item['PersonelId']] = $item;
            endif;
        endforeach;
        unset($item);
        return $res;
    }

    public static function addExternalClinicDoctorIncident($doctorsIncidents, $externalIncidents) {
        $doctorsIncidents['error'] = [];
        forEach ($externalIncidents as $incident):
            if (!isset($doctorsIncidents[$incident->ClinicDepartmentId])):
                $doctorsIncidents[$incident->ClinicDepartmentId] = [];
            endif;
            if (!isset($doctorsIncidents[$incident->ClinicDepartmentId][$incident->ClinicTypeId])):
                $doctorsIncidents[$incident->ClinicDepartmentId][$incident->ClinicTypeId] = [];
            endif;
            if (!isset($doctorsIncidents[$incident->ClinicDepartmentId][$incident->ClinicTypeId][$incident->PersonelId])):
                $doctorsIncidents[$incident->ClinicDepartmentId][$incident->ClinicTypeId][$incident->PersonelId] = ['ClinicTypeId' => $incident->ClinicTypeId, 'PersonelId' => $incident->PersonelId, 'FirstName' => $incident->FirstName, 'LastName' => $incident->LastName, 'incidents' => []];
            endif;
            $doctorsIncidents[$incident->ClinicDepartmentId][$incident->ClinicTypeId][$incident->PersonelId]['incidents'][$incident->ClinicIncidentId][] = $incident->Quantity;
        endforeach;
        unset($incident);
        return $doctorsIncidents;
    }

    /**
      public static function ReformClinicDoctor($doctor)
      {
      $res = [];
      foreach($doctors as $doctor):
      if(!isset($doctor['ClinicTypeId'])):
      $res[$doctor['ClinicTypeId']] = [];
      endif;
      $res[$doctor['ClinicTypeId'][$doctor['PersonelId']] = $doctor;
      endforeach;
      unset($doctor);
      return $res;
      }
     * */
    public static function scheduleReform($data) {
        $dataSchedule = array();
        foreach ($data as $event) {
            $dataSchedule[] = array('PersonelScheduleId' => $event->ScheduleId, 'title' => $event->LastName . ' ' . $event->FirstName, 'start' => $event->FromDate,
                'end' => $event->ToDate, 'backgroundColor' => '#' . $event->MemoColor,
                'PersonelId' => $event->PersonelId, 'HealthCommitteeId' => $event->CommitteeId);
        }
        unset($event);
        return $dataSchedule;
    }

    public static function pivotClinicalData($data) {
        $pivot = array();
        $lastCliId = '';
        foreach ($data as $item) {
            if ($item->ClinicTypeId != $lastCliId) {
                $lastCliId = $item->ClinicTypeId;
                $pivot[$lastCliId] = array();
            }
            $pivot[$lastCliId][$item->ClinicIncidentId] = $item->Quantity;
        }
        unset($item);
        return $pivot;
    }

    public static function groupClincsByIsSummed($data) {
        $res = ['summed' => [], 'notSummed' => []];
        foreach ($data as $item):
            if ($item->isSummed === '0'):
                $res['notSummed'][] = $item;
            else:
                $res['summed'][] = $item;
            endif;
        endforeach;
        unset($item);
        return $res;
    }
    
        public static function reformGroups (  $incidentsGroups)
        {
                $res = [];
                foreach ( $incidentsGroups as $item ):
                        if ( !isset( $res[$item -> ClinicTypeId] ) ):
                            $res[$item -> ClinicTypeId] = [];
                        endif;
                        if ( !isset( $res[$item -> ClinicTypeId] [$item -> ClinicIncidentId] ) ):
                            $res[$item -> ClinicTypeId][$item -> ClinicIncidentId] = [];
                        endif;
                        $res[$item -> ClinicTypeId][$item -> ClinicIncidentId] [ $item -> ClinicIncidentGroupId ]= [$item -> ClinicIncident, $item -> IncidentGroup] ;
                endforeach;
                unset( $item );
                return $res;                                        
        }

}
