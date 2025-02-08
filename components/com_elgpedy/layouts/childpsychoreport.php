<?php
/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */

defined('_JEXEC') or die('Restricted access');
$elgcnt = 0;
$lastDepartmentId = '';
?>
<section id="elgdata">
    <table class="table table-bordered table-striped clinicTransaction">
        <tr>
            <?php
            if ($this->checker == 0):
                $rowClass = 'warning';
            else:
                $rowClass = 'success';
            endif;
            ?>
            <th><?php echo JText::_('COM_ELG_PEDY_CHECKER'); ?></th><td class="<?php echo $rowClass; ?>" id="checkerValue" ><?php echo $this->checker; ?></td>
        </tr>
    </table>
    <?php if (isset($this->dataClinical)): ?>
        <h3><?php echo date('d/m/Y', strtotime($this->d1['start'])) . ' - ' . date('d/m/Y', strtotime($this->d1['end'])); ?></h3>
        <?php foreach ($this->departments as $depName => $depId):
            if ($lastDepartmentId != $depId):
                ?>
                <h4><?php echo $depName;
                $lastDepartmentId = $depId; ?></h4>
                <?php
                echo '<div><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><th></th>';
                foreach ($this->incidents as $incident):
                    if ($incident->DepartmentId == $lastDepartmentId):
                        echo '<th>', $incident->Incident, '</th>';
                    endif;
                endforeach;
                unset($incident);
                echo '</tr></thead><tbody >';
            endif;
            foreach ($this->clinics as $clinic):

                if ($clinic->DepartmentId == $lastDepartmentId):
                    echo '<tr id="elgcli', $clinic->ClinicId, '"><th>', $clinic->Clinic, '</th>';
                    $elgcnt ++;

                    foreach ($this->incidents as $incident):
                        if ($incident->DepartmentId == $lastDepartmentId) :
                            if (isset($this->dataClinical [$lastDepartmentId][$clinic->ClinicId][$incident->IncidentId])):

                                $rowValue = $this->dataClinical[$lastDepartmentId][$clinic->ClinicId][$incident->IncidentId];
                                if ($rowValue > 0):
                                    $rowClass = 'success';
                                else :
                                    $rowClass = 'warning';
                                endif;
                            else:
                                $rowClass = 'warning';
                                $rowValue = 0;
                            endif;
                            echo '<td class="', $rowClass, '" id="elginc', $lastDepartmentId, '-', $clinic->ClinicId, '-', $incident->IncidentId, '" data-inputclass="edit-text">', $rowValue, '</td>';
                        endif;
                    endforeach;
                    unset($incident);
                    echo '</tr>';

                else:  //clinic departmentid
                    $elgcnt = 0;
                endif;

            endforeach;
            unset($clinic);
            echo '</tbody></table>';

        endforeach;
        unset($department);
    endif; //dataClinical
    if (isset($this->newData)):
        ?>
        <h3><?php echo date('d/m/Y', strtotime($this->d2['start'])) . ' - ' . date('d/m/Y', strtotime($this->d2['end'])); ?></h3>
        <?php
        foreach ($this->departments as $depName => $depId):
            if ($lastDepartmentId != $depId):
                ?>
                <h4><?php echo $depName;
                $lastDepartmentId = $depId; ?></h4>

                <?php
            endif;
            foreach ($this->clinics as $clinic):
                if ($clinic->DepartmentId != $lastDepartmentId):
                    continue;
                endif;
                echo '<div><table class="table table-hover table-bordered clinicTransaction" >
				<thead>
					<tr class="info"><td colspan="' . (count($this->incidents) + 1) . '" >' . $clinic->Clinic . '</td></tr>
					<tr class="info">
					<th></th>';
                foreach ($this->incidents as $incident):
                    if ($incident->DepartmentId == $lastDepartmentId):
                        echo '<th>', $incident->Incident, '</th>';
                    endif;
                endforeach;
                unset($incident);
                echo '</tr></thead><tbody >';
                $insertedDoctors = [];
                foreach ($this->doctors as $doctor):
                    if (in_array($doctor['PersonelId'], $insertedDoctors) || $doctor['ClinicDepartmentId'] != $lastDepartmentId):
                        continue;
                    endif;
                    if ($doctor['ClinicTypeId'] != $clinic->ClinicId && !isset($this->newData[$lastDepartmentId][$clinic->ClinicId][$doctor['PersonelId']])
                    ):
                        continue;
                    endif;
                    $insertedDoctors [] = $doctor['PersonelId'];
                    ?>
                    <tr>
                        <th><?php echo $doctor['LastName'] . ' ' . $doctor['FirstName']; ?></th>
                        <?php
                        foreach ($this->incidents as $incident):
                            if ($incident->DepartmentId == $lastDepartmentId):
                                if (isset($this->newData[$lastDepartmentId][$clinic->ClinicId][$doctor['PersonelId']][$incident->IncidentId])):

                                    $rowValue = $this->newData[$lastDepartmentId][$clinic->ClinicId][$doctor['PersonelId']][$incident->IncidentId];
                                    if ($rowValue > 0):
                                        $rowClass = 'success';
                                    else:
                                        $rowClass = 'warning';
                                    endif;
                                else:
                                    $rowClass = 'warning';
                                    $rowValue = 0;
                                endif;
                                ?>
                                <td class="<?php echo $rowClass; ?>"><?php echo $rowValue ?></td>
                                <?php
                            endif;
                        endforeach;
                        unset($incident);
                        ?>
                    </tr>
            <?php endforeach;
            unset($doctor);
            ?>
            </tbody>
            </table>
            <?php
        endforeach;
        unset($clinic);
    endforeach;
    unset($department);
endif; //newData

if (isset($this->newData3)):
    ?>
    <h3><?php echo date('d/m/Y', strtotime($this->d3['start'])) . ' - ' . date('d/m/Y', strtotime($this->d3['end'])); ?></h3>
    <?php
    
    foreach ($this->clinics as $clinic):

        echo '<div><table class="table table-hover table-bordered clinicTransaction" >
				<thead>
					<tr class="info"><td colspan="5" >' . $clinic->Clinic . '</td></tr>
					<tr class="info">
					<th>Ιατρός</th><th>ΠΕΡΙΣΤΑΤΙΚΑ</th><th>ΕΚΠΑΙΔΕΥΣΗ</th>';

        echo '</tr></thead><tbody >';
        $clinicSum = 0;
        $clinicSumEducation = 0;
        $insertedDoctors = [];
        foreach ($this->doctors3 as $doctor):

            if ($doctor['ClinicTypeId'] != $clinic->ClinicId
            //    || !isset( $this -> newData3[$clinic -> ClinicId][ $doctor['PersonelId'] ] ) 
            ):
                continue;
            endif;
            
            ?>
            <tr>

                <?php
                                
                if (isset($this->newData3[$clinic->ClinicId][$doctor['PersonelId']])):
                    $sumDoctor = 0;
                    $sumDoctorEducation = 0;
                    foreach ($this->newData3[$clinic->ClinicId][$doctor['PersonelId']] as $doctorData):
                        if ( $doctorData[2] == 1 ):
                            $sumDoctorEducation += pedyGetStrignOr0ToNumb ( $doctorData[0], 1 );
                            $clinicSumEducation += pedyGetStrignOr0ToNumb ( $doctorData[0], 1);
                        else:
                            $sumDoctor += pedyGetStrignOr0ToNumb ( $doctorData[0] );
                            $clinicSum += pedyGetStrignOr0ToNumb ( $doctorData[0] );
                        endif;
                    endforeach;
                    unset($doctorData);
                        ?>
                    <tr>
                        <th>
                            <?php echo $doctor['LastName'] . ' ' . $doctor['FirstName']; ?>
                        </th>
                        <td><?php echo $sumDoctor; ?></td>
                        <td><?php echo $sumDoctorEducation; ?></td>
                    </tr>
                <?php
                
            else:
                ?>
                <tr><th><?php echo $doctor['LastName'] . ' ' . $doctor['FirstName']; ?></th>   
                    <td class="warning" ></td>
                    
                    <td class="warning" ></td></tr>
            <?php endif; ?>
            </tr>
        <?php endforeach;
        unset($doctor);
        ?>
            <tr>
                <th>Σύνολα</th><td><?php echo $clinicSum; ?></td><td><?php echo $clinicSumEducation; ?></td>
            </tr>
        </tbody>
        </table>
        <?php
    endforeach;
    unset($clinic);

endif; //newData2
?>

</section>



<div class="clearfix"></div>
<?php 
function pedyGetStrignOr0ToNumb( $subject, $zeroTransform = 0 )
                {
                    if ( !is_numeric( $subject ) || $subject ==0  )
                    {
                        return $zeroTransform;
                    }
                    else
                    {
                        return (int) $subject;
                    }
                    
                }

include_once JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; ?>