<?php
/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

$elgcnt = 0;

$dataClinicalDepartment = ( isset($this->dataClinical[1]) ? $this->dataClinical[1] : [] );
$dataClinicalDepartmentSumed = ( isset($this->dataClinicalSummed[1]) ? $this->dataClinicalSummed[1] : [] );
/** checkers * */
if ($this->checkers > 0):
    $rowClass = 'success';
else :
    $rowClass = 'warning';
endif;
?>

<section id="elgdata">


    <div class="row"><div class="col-md-12">
            <?php
            echo '<table class="table table-hover table-bordered clinicTransaction" ><tbody><tr><th class="info">', JText::_('COM_ELG_PEDY_CHECKER'), '</th><td id="elginc0-4" class="col-md-2 ', $this->checkers, ' editable" data-inputclass="edit-text" >', $this->checkers, '</td></tr></tbody></table></div><div class="clearfix"></div></div><div class="row">';

            foreach ($this->clinics['notSummed'] as $clinic):

                $elgcnt++;
                $totalSum = 0;
                $personelInserted = [];
                $clinicId = $clinic->ClinicId;
                echo '<div class="col-md-12"><table class="table table-hover table-bordered clinicTransaction" >';
                echo getHeader($this->reformedGroups, $clinic, $this->incidents, $this->incidentsByRel);
                echo '<tfoot><tr><td colspan="' . (count($this->incidents) + 2) . '"><button type="button" class="addDoctor btn btn-default">Προσθήκη Ιατρού</button></td> </tr>';
                echo '<tbody id="elgcli', $clinic->ClinicId, '">';
                foreach ($this->doctors as $doctor):
                    $rowSum = 0;
                    if (in_array($doctor['PersonelId'], $personelInserted)):
                        continue;
                    endif;
                    //dataClinical[ClinicalDepartment][ClinicTypeId][PersonelId][ClininicIncidentGroupId] = quantity ,(ClinicalDepartment 1: agonosto, 2: iatropaidagogiko, 3, Therapeutiko tmima efivon

                    if (isset($dataClinicalDepartment[$clinicId] [$doctor['PersonelId']]) || ( $clinicId == $doctor ['ClinicTypeId'] )):
                        if ($clinic->isExclusive === '0'):
                            $clinicIncidents = array_merge($this->incidents, ComponentUtils::getClinicRelIncidents($this->incidentsByRel, $clinicId));
                        else:
                            $clinicIncidents = ComponentUtils::getClinicRelIncidents($this->incidentsByRel, $clinicId);
                        endif;
                        echo pdCSRow($doctor, $clinicIncidents, $clinic->ClinicId, $dataClinicalDepartment, $this->refDate, $this->healthUnitId, $this->reformedGroups);
                    endif;
                    $personelInserted[] = $doctor['PersonelId'];

                endforeach;
                unset($doctor);
                echo '</tbody></table></div>';

                if ($elgcnt % 2 === 0) {
                    echo '</div><hr /><div class="row">';
                }
            endforeach;
            unset($clinic);
            echo '</div>';  ?>
            <hr>
<?php            
               foreach ($this->groupIncidentsFields as $groupName=> $groupData): ?>
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-bordered clinicTransaction" id="clinicGroup<?php echo $groupData['id']; ?>">
                           <thead>
                               <tr class="info">
                                   <th colspan="<?php echo count($groupData['head']) + 1; ?> "><?php echo $groupName; ?></th>
                               </tr>
                               <tr>
                                   <th><?php echo Text::_('COM_ELG_PEDY_CLINIC'); ?></th>
<?php           foreach ($groupData['head'] as $incidentName): ?>
                                   <th><?php echo $incidentName; ?></th>
<?php           endforeach; unset($incidentName); ?>                                   
                               </tr>
                           </thead>
                           <tbody>
<?php           forEach ($groupData['clinicTypes'] as $clinicName => $clinicData): // loop on clinics.?>
                               <tr>
                                   <th><?php echo $clinicName; ?></th>
<?php               forEach ($groupData['head'] as $incidentName): // loop on all available incidents.
                        /**
                         * we make the cell editable only if the incident belongs to current clinic in loop.
                         */
                        if (isset($groupData['clinicTypes'][$clinicName]['incidents'][$incidentName])):  
                            $clinicTypeId = $groupData['clinicTypes'][$clinicName]['id'];
                            $incidentId = $groupData['clinicTypes'][$clinicName]['incidents'][$incidentName]['id'];
                            $extractedValue = $this->extractValue($groupData['id'], $clinicTypeId, $incidentId);
                            $shownValue = is_numeric($extractedValue) ? $extractedValue: 0;
                            $className = $shownValue > 0 ? 'success' : 'warning';
?>                                 <td class="editableg editable-click <?php echo $className; ?>"  id="elgincg<?php echo $clinicTypeId; ?>-<?php echo $incidentId; ?>-<?php echo $groupData['id']; ?>"><?php echo $shownValue; ?></td>
<?php                   else: ?>
                                   <td style="background-color: silver"></td>
<?php                   endif;
                    endforeach; unset($incidentName); ?>
                               </tr>
<?php           endforeach; unset($clinicName); unset($clinicData);  ?>
                           </tbody>
                    </table>                                
                </div>
            </div>
            <hr>
            <?php endforeach; unset($groupId); unset($groupName); ?> 
            
              

            </section>
            
          
            <div class="clearfix">&nbsp;</div>

            <?php

            function getHeader($groups, $clinic, $incidents, $incidentsRel) {
                $html = '';
                $cCount = 0;
                $clinicId = $clinic->ClinicId;
                if (isset($groups[$clinicId])):
                    $rs = ' rowspan="2" ';
                    $cCount = $cCount + 2;
                else:
                    $rs = '';
                endif;
                if ($clinic->isExclusive === '0'):
                    $clinicIncidents = array_merge($incidents, ComponentUtils::getClinicRelIncidents($incidentsRel, $clinicId));
                else:
                    $clinicIncidents = ComponentUtils::getClinicRelIncidents($incidentsRel, $clinicId);
                endif;
                $html .= '<tr><th  ' . $rs . '  >Ιατρός</th>';
                foreach ($clinicIncidents as $incident):
                    if (isset($groups[$clinic->ClinicId][$incident->IncidentId])):
                        $cs = count($groups[$clinic->ClinicId][$incident->IncidentId]);
                        $csp = ' colspan="' . $cs . '" ';
                    else:
                        $cs = 1;
                        $csp = '';
                    endif;
                    $cCount = $cCount + 1;
                    $html .= '<th ' . ($cs > 1 ? $csp : $rs ) . ' ><a data-yjsg-tip="' . $incident->Tooltip . '" >' . $incident->Incident . '</a></th>';
                endforeach;
                unset($incident);
                $html .= '</tr>';
                if ($rs !== ''):
                    $html .= '<tr>';
                    foreach ($incidents as $incident):
                        if (isset($groups[$clinic->ClinicId][$incident->IncidentId])):
                            $html .= getIncidentHeaderGroup($groups[$clinic->ClinicId][$incident->IncidentId]);
                        endif;
                    endforeach;
                    unset($incident);
                    $html .= '</tr>';
                endif;
                return '<thead><tr class="info"><td colspan="' . ( $cCount + 1 ) . '">' . $clinic->Clinic . '</td></tr>' . $html . '</thead>';
            }

            function pdCSRow($doctor, $incidents, $clinicId, $dataClinicalDepartment, $refDate, $healthUnitId, $groups) {
                $html = '<tr id="cd-' . $clinicId . '-' . $doctor['PersonelId'] . '" ><th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' . $healthUnitId . ', \'' . $refDate . '\',' . $clinicId . ',' . $doctor['PersonelId'] . ', \'' . $doctor['FirstName'] . ' ' . $doctor['LastName'] . '\')"></span> <span> ' . $doctor['FirstName'] . ' ' . $doctor['LastName'] . '</span></th>';

                foreach ($incidents as $incident):
                    $html .= getCells($clinicId,
                            $incident->IncidentId,
                            $doctor['PersonelId'],
                            ( isset($dataClinicalDepartment[$clinicId][$doctor['PersonelId']]) ? $dataClinicalDepartment[$clinicId][$doctor['PersonelId']] : []),
                            getIncidentGroupsIds($groups, $clinicId, $incident->IncidentId)
                    );
                endforeach;
                unset($incident);
                return $html . '</tr>';
            }

            function getIncidentGroupsIds($groups, $clinicId, $incidentId) {
                if (isset($groups [$clinicId] [$incidentId])):
                    return array_keys($groups [$clinicId] [$incidentId]);
                else:
                    return [0];
                endif;
            }

            function getCells($clinicId, $incidentId, $doctorId, $doctorValues, $incidentGroupsIds) {
                $html = '';

                foreach ($incidentGroupsIds as $groupId):
                    if (isset($doctorValues[$incidentId][$groupId])):
                        $rowValue = $doctorValues[$incidentId][$groupId];
                        $rowClass = 'success';
                    else:
                        $rowValue = 0;
                        $rowClass = 'warning';
                    endif;
                    $html .= '<td class=" editable ' . $rowClass . '" id="elginc' . $clinicId . '-' . $incidentId . '-' . $doctorId . '-' . $groupId . '" data-inputclass="edit-text"  >' . $rowValue . '</td>';
                endforeach;
                unset($groupId);
                return $html;
            }

            function getIncidentHeaderGroup($groups) {
                $html = array_reduce($groups, function ($a, $b) {
                    return $a . '<td>' . $b . '</td>';
                }, '');
                return $html;
            }

            function getIncidentDataGroup($incidentGroupId, $rowValue, $clinicId, $incidentId, $doctorId) {
                if ($rowValue > 0):
                    $rowClass = 'success';
                else:
                    $rowClass = 'warning';
                endif;
                return '<td class=" editable ' . $rowClass . '" id="elginc' . $clinicId . '-' . $incidentId . '-' . $doctorId . '-' . $incidentGroupId . '" data-inputclass="edit-text"  >' . $rowValue . '</td>';
            }
            ?>

            <script type="text/javascript">
                var clickedClinic = 0;
                var incidents = <?php echo json_encode($this->incidents); ?>;
                jQuery(document).ready(function () {
                    jQuery('table.clinicTransaction tbody td.editable').editable(
                            {
                                url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=clinicaltransactiondataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
                                type: 'text',
                                pk: 1,
                                name: 'pk',
                                mode: 'inline',
                                showbuttons: false,
                                send: 'always',
                                savenochange: true,
                                title: 'Click to edit',

                                params: function (params) {
                                    var dataSub = {};
                                    dataSub.hid = this.id;
                                    var iidc = this.id.replace('elginc', '');
                                    var parts = iidc.split('-');
                                    var iid = parts[1];
                                    dataSub.iid = iid;
                                    dataSub.ig = parts[3];
                                    dataSub.pid = parts[2];
                                    dataSub.ctid = this.parentNode.parentNode.id.replace('elgcli', '');
                                    dataSub.Quantity = params.value;
                                    dataSub.RefDate = moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
                                    dataSub.HealthUnitId = document.getElementById('HealthUnitId').value;
                                    return dataSub;
                                },
                                validate: function (value) {
                                    if (isNaN(value.replace(' ', ''))) {
                                        jQuery('#modalValidate').modal('show');
                                        return '-';
                                    }
                                },
                                success: elgShowResultMessage
                            });
                                  
                    jQuery('table.clinicTransaction tbody td.editableg').editable({
                        url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=clinicaltransactiondataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
                        type: 'text',
                        pk: 1,
                        name: 'pk',
                        mode: 'inline',
                        showbuttons: false,
                        send: 'always',
                        savenochange: true,
                        title: 'Click to edit',

                        params: function (params) {
                            var dataSub = {};
                            dataSub.hid = this.id;
                            var iidc = this.id.replace('elgincg', '');
                            var parts = iidc.split('-');
                            var iid = parts[1];
                            dataSub.iid = iid; // incidentId
                            dataSub.icg = parts[2]; // clinicGroup
//                            dataSub.pid = parts[1];  //personnelId
                            dataSub.ctid = parts[0]; //Clinic Type id. 
                            dataSub.Quantity = params.value;
                            dataSub.RefDate = moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
                            dataSub.HealthUnitId = document.getElementById('HealthUnitId').value;
                            return dataSub;
                        },
                        validate: function (value) {
                            if (isNaN(value.replace(' ', ''))) {
                                jQuery('#modalValidate').modal('show');
                                return '-';
                            }
                        },
                        success: elgShowResultMessage
                    });
                    
                    elgClearEditable();
                });

                function removeDoctorAsk(healthUnitId, refDate, clinicId, personelId, doctorName) {
                    document.querySelector('#remDocModal .modal-body').textContent = 'Είστε σίγουροι για τη διαγραφή του/της ' + doctorName;
                    document.getElementById('HealthUnitId').value = healthUnitId;
                    document.getElementById('RefDate').value = refDate;
                    document.getElementById('ClinicTypeId').value = clinicId;
                    document.getElementById('PersonelId').value = personelId;
                    document.getElementById('remDocBt').style.display = 'inline';
                    jQuery('#remDocModal').modal();
                }

                function removeDoctor() {
                    var data = {};
                    jQuery.post('index.php?option=com_elgpedy&controller=removedoctorclinictransaction&format=json&Itemid=<?php echo $this->state->get('Itemid'); ?>'
                            , 'PersonelId=' + document.getElementById('PersonelId').value + '&HealthUnitId=' + document.getElementById('HealthUnitId').value + '&RefDate=' + document.getElementById('RefDate').value + '&ClinicTypeId=' + document.getElementById('ClinicTypeId').value + '&PersonelId=' + document.getElementById('PersonelId').value
                            , removeDoctorResponse);

                }

                function removeDoctorResponse(data, status, xhr) {
                    document.getElementById('remDocBt').style.display = 'none';
                    if (data.success == true) {
                        var errors = '';
                        if (typeof data.messages.error !== 'undefined') {
                            errors += removeErrors(data.messages.error);
                        }

                        if (typeof data.messages.warning !== 'undefined') {
                            errors += removeWarnings(data.messages.error);
                        }
                        if (errors !== '') {
                            document.querySelector('#remDocModal .modal-body').innerHTML = errors;
                            return;
                        } else {
                            removeSuccess(data.messages.success, data.data);
                        }
                    } else {
                        alert('Communication error');
                    }

                }

                function removeErrors(errors) {
                    var html = '';
                    html += '<p class="alert alert-danger">';
                    errors.forEach(function (val) {
                        html += val;
                    });
                    html += '</p>';
                    return html;
                }


                function removeWarnings(warnings) {
                    var html = '';
                    html += '<p class="alert alert-warning">';
                    warnings.forEach(function (val) {
                        html += val;
                    });
                    html += '</p>';
                    return html;

                }

                function removeSuccess(messages, data)
                {
                    var html = '<p class="alert alert-success">';
                    messages.forEach(function (val) {
                        html += val;
                    });
                    html += '</p>';
                    document.querySelector('#remDocModal .modal-body').innerHTML = html;
                    var table = document.getElementById('elgcli' + data.ClinicTypeId);
                    table.removeChild(document.getElementById('cd-' + data.ClinicTypeId + '-' + data.PersonelId));
                }

                function addDoctor(e) {
                    clickedClinic = e.target.parentNode.parentNode.parentNode.parentNode.children[2].id;
                    jQuery('#docModal').modal();
                }

                var addDBts = document.querySelectorAll('button.addDoctor');
                for (var i = addDBts.length - 1; i >= 0; i--) {
                    addDBts[i].addEventListener('click', addDoctor);
                }

                function insertDoctor() {
                    var row = document.getElementById(clickedClinic).insertRow();
                    var selectedDoctorId = document.getElementById('docsDrop').value;
                    var selectedDoctor = document.getElementById('docsDrop').options[document.getElementById('docsDrop').selectedIndex].text;
                    var healthUnitId = document.getElementById('HealthUnitId').value;
                    var refDate = moment(document.getElementById('RefDate').value, 'DD/MM/YYYY').format('YYYY-MM-DD');
                    var clinicId = row.parentNode.id.replace('elgcli', '');
                    row.setAttribute('id', 'cd-' + clinicId + '-' + selectedDoctorId);
                    var cells = [];
                    incidents.forEach(function (val) {
                        cells.push('<td data-inputclass="edit-text" id="elginc' + clinicId + '- ' + val.IncidentId + '-' + selectedDoctorId + '" class="warning editable editable-click">0</td>');
                    });
                    //row.innerHTML = '<th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' + healthUnitId + ',\'' + refDate + '\',' + clinicId +',' + selectedDoctorId + ',\'' + selectedDoctor + '\' )" ></span> '+ selectedDoctor+ '</th><td data-inputclass="edit-text" id="elginc1-1-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-2-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-3-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-11-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-12-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td>0</td>';
                    row.innerHTML = '<th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' + healthUnitId + ',\'' + refDate + '\',' + clinicId + ',' + selectedDoctorId + ',\'' + selectedDoctor + '\' )" ></span> ' + selectedDoctor + '</th>' + cells.join('') + '<td>0</td>';
                    makeNewEditable(row);
                }

                function makeNewEditable(row) {
                    jQuery(row).find('td').editable(
                            {
                                url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=clinicaltransactiondataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
                                type: 'text',
                                pk: 1,
                                name: 'pk',
                                mode: 'inline',
                                showbuttons: false,
                                send: 'always',
                                savenochange: true,
                                title: 'Click to edit',

                                params: function (params) {
                                    var dataSub = {};
                                    dataSub.hid = this.id;
                                    var iidc = this.id.replace('elginc', '');
                                    var parts = iidc.split('-');
                                    var iid = parts[1];
                                    dataSub.iid = iid;
                                    dataSub.pid = parts[2];
                                    dataSub.ig = parts[3];
                                    dataSub.ctid = this.parentNode.parentNode.id.replace('elgcli', '');
                                    dataSub.Quantity = params.value;
                                    dataSub.RefDate = moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
                                    dataSub.HealthUnitId = document.getElementById('HealthUnitId').value;
                                    return dataSub;
                                },
                                validate: function (value) {
                                    if (isNaN(value.replace(' ', ''))) {
                                        jQuery('#modalValidate').modal('show');
                                        return '-';
                                    }
                                },
                                success: elgShowResultMessage
                            });
                    elgClearEditable();
                }

            </script>
            <div class="modal fade" id="docModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span>Επιλέξτε</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form">
                                <div class="form-group">
                                    <div class="doctor">
                                        <label for="doctor">Ιατρός</label>
<?php echo $this->docsDrop; ?>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal" onclick="insertDoctor()">Εισαγωγή</button>

                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="remDocModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span>Διαγραφή</h4>
                        </div>
                        <div class="modal-body">

                        </div>
                        <input type="hidden" value="" id="HealthUnitId" />
                        <input type="hidden" value="" id="RefDate" />
                        <input type="hidden" value="" id="ClinicTypeId" />
                        <input type="hidden" value="" id="PersonelId" />
                        <div class="modal-footer">
                            <button type="btn" id="remDocBt" class="btn btn-danger btn-default pull-left" onclick="removeDoctor()">Διαγραφή</button>          
                        </div>
                    </div>
                </div>
            </div>



            <?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////Sumed records
            echo '<div class="row" >';
            $sumsCounter = 0;

            foreach ($this->clinics['summed'] as $clinic):

                $elgcnt++;
                $max = 0;

                forEach ($this->reformedGroups as $incident):
                    forEach ($incident as $groups):
                        $c = count($groups);
                        if ($c > $max):
                            $max = $c;
                        endif;
                    endforeach;
                    unset($groups);
                endforeach;
                unset($incident);
                $colspan = ( $c > 0 ? ($c + 1) : 2 );
                $sumsCounter++;

                echo '<div class="col-md-6"><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><td colspan="' . $colspan . '"  >', $clinic->Clinic, '</td></tr></thead><tbody id="elgcli', $clinic->ClinicId, '">';
                if ($clinic->isExclusive === '0'):
                    $clinicIncidents = array_merge($this->incidents, ComponentUtils::getClinicRelIncidents($this->incidentsByRel, $clinic->ClinicId));
                else:
                    $clinicIncidents = ComponentUtils::getClinicRelIncidents($this->incidentsByRel, $clinic->ClinicId);
                endif;
                foreach ($clinicIncidents as $incident):
                    $groupsIds = getIncidentGroupsIds($this->reformedGroups, $clinic->ClinicId, $incident->IncidentId);
                    if (isset($dataClinicalDepartmentSumed[$clinic->ClinicId])):
                        $clinicValues = $dataClinicalDepartmentSumed[$clinic->ClinicId];
                    else:
                        $clinicValues = [];
                    endif;
                    echo getRowSumed($clinic->ClinicId, $incident, $this->reformedGroups, $clinicValues, $groupsIds, ( $max > 0 ? ' colspan="' . $max . '"' : ''));

                endforeach;
                unset($incident);
                echo '</tbody></table></div>';
                if ($sumsCounter === 2) {
                    echo '</div><hr /><div class="row">';
                    $sumsCounter = 0;
                }
            endforeach;
            unset($clinic);

            function getRowSumed($clinicId, $incident, $groups, $clinicValues, $incidentGroupsIds, $colspan) {
                $html = '<tr><th><a data-yjsg-tip="' . $incident->Tooltip . '" >' . $incident->Incident . '</a>';
                $hasGroups = isset($groups[$clinicId][$incident->IncidentId]);
                if ($hasGroups):
                    $html .= '<br />' . trim(
                                    array_reduce($groups[$clinicId][$incident->IncidentId], function ($a, $b) {
                                        return $a . '/ ' . $b[1];
                                    }, '')
                                    , '/') . '';
                endif;
                $html .= '</th>';
                if ($hasGroups):
                    foreach ($incidentGroupsIds as $groupId):
                        if (isset($clinicValues[$incident->IncidentId][$groupId])):
                            $rowValue = $clinicValues[$incident->IncidentId][$groupId];
                            $rowClass = 'success';
                        else:
                            $rowValue = 0;
                            $rowClass = 'warning';
                        endif;
                        $html .= '<td class=" editable ' . $rowClass . '" id="elginc' . $clinicId . '-' . $incident->IncidentId . '-0-' . $groupId . '" data-inputclass="edit-text" >' . $rowValue . '</td>';
                    endforeach;
                    unset($groupId);
                else:
                    if (isset($clinicValues[$incident->IncidentId][0])):
                        $rowValue = $clinicValues[$incident->IncidentId][0];
                        $rowClass = 'success';
                    else:
                        $rowValue = 0;
                        $rowClass = 'warning';
                    endif;
                    $html .= '<td class=" editable ' . $rowClass . '" id="elginc' . $clinicId . '-' . $incident->IncidentId . '-0-0' . '" data-inputclass="edit-text" ' . $colspan . '" >' . $rowValue . '</td>';
                endif;
                $html .= '</tr>';
                return $html;
            }

            echo '</div>
 </section><div class="clearfix">&nbsp;</div><p><span class="comments-title">', JText::_('COM_ELG_PEDY_COMMENTS'), ':</span>', JText::_('COM_ELG_PEDY_FORM_FOOTER_CLINIC'), '</p>';
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('table.clinicTransaction tbody td.editable-summed').editable(
                            {
                                url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=clinicaltransactiondataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
                                type: 'text',
                                pk: 1,
                                name: 'pk',
                                mode: 'inline',
                                showbuttons: false,
                                send: 'always',
                                savenochange: true,
                                title: 'Click to edit',

                                params: function (params) {
                                    var dataSub = {};
                                    dataSub.hid = this.id;
                                    var iidc = this.id.replace('elginc', '');
                                    var parts = iidc.split('-');
                                    var iid = parts[1];
                                    var iq = parts[3];
                                    dataSub.iid = iid;
                                    dataSub.ctid = this.parentNode.parentNode.id.replace('elgcli', '');
                                    dataSub.Quantity = params.value;
                                    dataSub.RefDate = moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
                                    dataSub.HealthUnitId = document.getElementById('HealthUnitId').value;
                                    return dataSub;
                                },
                                validate: function (value) {
                                    if (isNaN(value.replace(' ', ''))) {
                                        jQuery('#modalValidate').modal('show');
                                        return '-';
                                    }
                                },
                                success: elgShowResultMessage
                            });
                    elgClearEditable();
                });
            </script>





