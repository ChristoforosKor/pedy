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

if ($this->checker > 0):
    $rowClass = 'success';
else :
    $rowClass = 'warning';
endif;



echo '<div class="row">
			<div>
				<table class="table table-hover table-bordered clinicTransaction" >
					<tbody>
						<tr>
							<th class="info">', JText::_('COM_ELG_PEDY_CHECKER'), '</th>
							<td id="elginc0-0-4" class="col-md-2 ', $rowClass, '" data-inputclass="edit-text" >', $this->checker, '</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="clearfix"></div>
		</div>';

foreach ($this -> departments as $depId => $department):
    echo '<section class="elgdata" id="d' . $depId . '" >';
    if ($lastDepartmentId != $depId): ?>
        <h3><?php 
        echo $department['name'];
        $lastDepartmentId = $depId;
        $dataClinicalDepartment = ( isset( $this -> dataClinical[ $lastDepartmentId ] ) ? $this -> dataClinical[ $lastDepartmentId ] : [] );
        $dataClinicalDepartmentSumed = ( isset( $this -> dataClinicalSummed[ $lastDepartmentId ]) ? $this -> dataClinicalSummed[ $lastDepartmentId ] : [] );
        ?>
        </h3>
        <?php
    endif;

echo '<div class="clearfix"></div><div class="row">'; 

    foreach ($this->fields->clinics['notSummed'] as $clinic):
        if ($clinic->DepartmentId != $lastDepartmentId):
            continue;
        endif;
        $elgcnt ++;
        $totalSum = 0;
        $clinicId = $clinic -> ClinicId;
        echo '		<div class="col-md-12">
					<table class="table table-hover table-bordered clinicTransaction" >' .

                                                                getHeader( $this -> reformedGroups, $clinic, $this -> fields -> incidents, $lastDepartmentId ).
                                                                                                 '<tfoot>
							<tr><td colspan="' . (count($department['incidents']) + 2) . '"><button type="button" class="addDoctor">+</button></td> </tr>
							
						</tfoot>
						<tbody id="elgcli', $clinicId, '">';

        
        foreach ($this->fields->doctors as $doctor):

            if ( /**isset($dataClinicalDepartment[$clinic->ClinicId] [$doctor['PersonelId']]) || (**/ $clinic->ClinicId == $doctor ['ClinicTypeId']  && $doctor['ClinicDepartmentId'] == $lastDepartmentId  /*)*/):
                echo pdCSRow( $doctor, $this->fields->incidents, $clinic->ClinicId, $dataClinicalDepartment, $this->refDate, $this->healthUnitId, $this->reformedGroups, $lastDepartmentId );
            endif;
        endforeach;
        unset($doctor);

        echo '				</tbody>
					</table>
				</div>';

        if ($elgcnt % 2 === 0) {
            echo '</div><hr /><div class="row">';
        }
    endforeach;
    unset($clinic);
    echo '</div></section><div class="clearfix">&nbsp;</div>';
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////summed
    foreach($this->fields->clinics['summed'] as $clinic):	
	$elgcnt ++;
	$max = 0;
                forEach ( $this -> reformedGroups as $incident ):
                    forEach ( $incident as $groups ):
                        $c = count ( $groups );
                        if ( $c > $max ):
                            $max = $c ; 
                        endif; 
                     endforeach;
                     unset($groups);
                endforeach;
                unset( $incident );
                $colspan = ( $c > 0 ? ($c + 1) :  2 );
	echo '<div class="col-md-6"><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><td colspan="' . $colspan . '"  >', $clinic->Clinic, '</td></tr></thead><tbody id="elgcli', $clinic->ClinicId, '">';
	foreach($this->fields->incidents as $incident):                                
                                $groupsIds = getIncidentGroupsIds( $this -> reformedGroups,  $clinic->ClinicId, $incident -> IncidentId);
                                if ( isset ( $dataClinicalDepartmentSumed[$clinic->ClinicId] ) ):
                                    echo getRowSumed(  $clinic->ClinicId, $incident, $this -> reformedGroups, $dataClinicalDepartmentSumed[$clinic->ClinicId], $groupsIds, ( $max > 0 ? ' colspan="' . $max . '"' : '' ), $lastDepartmentId );
                                endif;
                endforeach;
	unset($incident);
	echo '</tbody></table></div>';
	if($elgcnt % 2 === 0)
	{
		echo '</div><hr /><div class="row">';
	}
 endforeach;
 unset($clinic);
    echo '</div></section><div class="clearfix">&nbsp;</div>';
    echo '<p><span class="comments-title">', JText::_('COM_ELG_PEDY_COMMENTS'), ':</span>', JText::_('COM_ELG_PEDY_FORM_FOOTER_CLINIC'), '</p>';
    echo '</div></section>';
endforeach;
unset($department);
unset($depId);

function getHeader ( $groups, $clinic, $incidents, $departmentId ) 
{
    $html = '';
    $cCount = 0;
    if ( isset (  $groups[ $clinic -> ClinicId ] ) ):
        $rs = ' rowspan="2" ';
        $cCount = $cCount + 1; // count( $groups[ $clinic -> ClinicId ] );
    else:
        $rs = '';
    endif;
    $html .=  '<tr><th  ' . $rs . '  >Ιατρός</th>';
    foreach ( $incidents as $incident ):
        if ( $incident -> DepartmentId != $departmentId) :
            continue;
        endif;
        if ( isset($groups[ $clinic -> ClinicId][ $incident -> IncidentId ] ) ):
            $cs = count ( $groups[ $clinic -> ClinicId][ $incident -> IncidentId ] );
            $csp =  ' colspan="' . $cs . '" ';
        else:
            $cs = 1;
            $csp = '';
        endif;
       $cCount = $cCount + 1;
        $html .= '<th ' . ($cs > 1 ? $csp : $rs ) . ' ><a data-yjsg-tip="' . $incident->Tooltip . '" >'  . $incident -> Incident . '</a></th>';
    endforeach;
    unset($incident);
    $html .= '</tr>';
    if ( $rs !== ''):
        $html .=  '<tr>';
        foreach ( $incidents as $incident ):
            if ( $incident -> DepartmentId != $departmentId ):
                continue;
            endif;
            if ( isset($groups[ $clinic -> ClinicId][ $incident -> IncidentId ] ) ):
                $html .=  getIncidentHeaderGroup( $groups[ $clinic -> ClinicId][ $incident -> IncidentId ]  );
            endif;            
        endforeach;
        unset($incident);
        $html .= '</tr>';
    endif;
    return   '<thead><tr class="info"><td colspan="' .  ( $cCount + 1 ) . '">' . $clinic->Clinic . '</td></tr>' . $html . '</thead>';
    
}



function getIncidentGroupsIds( $groups,  $clinicId, $incidentId)
{
    if ( isset( $groups [$clinicId ] [ $incidentId ] ) ):
        return array_keys ( $groups [$clinicId ] [ $incidentId ] );
    else:
        return [0];
    endif;
}

function getIncidentHeaderGroup( $groups ) 
{
        $html =  array_reduce ( $groups, function ($a, $b)  {
            return $a . '<td>' . $b . '</td>';
        }, ''); 
        return $html;
}

function getRowSumed(  $clinicId, $incident, $groups, $clinicValues,  $incidentGroupsIds, $colspan, $departmentId ) 
{
        $html =  '<tr><th><a data-yjsg-tip="' . $incident->Tooltip . '" >'  . $incident->Incident . '</a>';
        $hasGroups = isset($groups[ $clinicId][ $incident -> IncidentId ] );
        if ( $hasGroups ):
            $html .= '<br />(' .  trim( 
                                array_reduce( $groups[ $clinicId ][ $incident -> IncidentId ], function($a, $b){
                               return  $a .  '/' . $b; 
                        },'' )
                    ,'/') . ')';
        endif;
        $html .= '</th>'; 
        if ( $hasGroups ):
            foreach( $incidentGroupsIds as $groupId ):
                if ( isset ( $clinicValues[ $incident -> IncidentId ][ $groupId ] ) ):
                    $rowValue = $clinicValues[ $incident -> IncidentId ][ $groupId ];
                    $rowClass= 'success';
                else:
                    $rowValue = 0;
                    $rowClass= 'warning';
                endif;
                $html .=   '<td class=" editable ' . $rowClass .'" id="elginc' . $departmentId . '-'  . $clinicId . '-' . $incident -> IncidentId . '-0-' .  $groupId . '" data-inputclass="edit-text" >' . $rowValue . '</td>';
            endforeach;
            unset($groupId);
        else:
            if ( isset ( $clinicValues[ $incident -> IncidentId ][ 0 ] ) ):
                    $rowValue = $clinicValues[ $incident -> IncidentId ][ 0 ];
                    $rowClass= 'success';
                else:
                    $rowValue = 0;
                    $rowClass= 'warning';
                endif;
                $html .=   '<td class=" editable ' . $rowClass .'" id="elginc'. $departmentId . '-' . $clinicId . '-' . $incident -> IncidentId . '-0-0' . '" data-inputclass="edit-text" ' . $colspan . '" >' . $rowValue . '</td>';
        endif;
        $html .= '</tr>';
        return $html;
 }

function pdCSRow($doctor, $incidents, $clinicId, $dataClinicalDepartment, $refDate, $healthUnitId, $groups, $departmentId) {
    $html = '<tr id="cd-' . $clinicId . '-' . $doctor['PersonelId'] . '" ><th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' . $healthUnitId . ', \'' . $refDate . '\',' . $clinicId . ',' . $doctor['PersonelId'] . ', \'' . $doctor['FirstName'] . ' ' . $doctor['LastName'] . '\')"></span> <span> ' . $doctor['FirstName'] . ' ' . $doctor['LastName'] . '</span></th>';
    $rowSum = 0;

    foreach ($incidents as $incident):
        if ( $incident -> DepartmentId == $departmentId ):
            $row = getCells( $clinicId, $incident->IncidentId, $doctor['PersonelId'], ( isset( $dataClinicalDepartment[$clinicId][$doctor['PersonelId']] ) ? $dataClinicalDepartment[$clinicId][$doctor['PersonelId']] : [] ), getIncidentGroupsIds( $groups, $clinicId, $incident->IncidentId ), $departmentId); 
            $html .= $row[0];
            $rowSum += $row[1];
        endif;
    endforeach;
    unset($incident);
    return $html . '<td>' . $rowSum . '</td></tr>';
}

function getCells($clinicId, $incidentId, $doctorId, $doctorValues, $incidentGroupsIds, $departmentId) {
    $html = '';
    $rowSum = 0;
    if ( count( $incidentGroupsIds ) > 1 ):
        $dbg = 1;
    endif;
     foreach ($incidentGroupsIds as $groupId):
        if (isset($doctorValues[$incidentId][$groupId])):
            $rowValue = $doctorValues[$incidentId][$groupId];
            $rowClass = 'success';
        else:
            $rowValue = 0;
            $rowClass = 'warning';
        endif;
        $rowSum += $rowValue;
        $html .= '<td class=" editable ' . $rowClass . '" id="elginc' . $departmentId . '-' . $clinicId . '-' . $incidentId . '-' . $doctorId . '-' . $groupId . '" data-inputclass="edit-text"  >' . $rowValue . '</td>';
    endforeach;
    unset($groupId);
    return [ $html, $rowSum ];
}


?>

<script type="text/javascript">

    jQuery(document).ready(function () {
        jQuery('table.clinicTransaction tbody td').editable(
                {
                    url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=childpsychodataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
                    type: 'text',
                    pk: 1,
                    name: 'pk',
                    mode: 'inline',
                    showbuttons: false,
                    send: 'always',
                    savenochange: true,
                    title: 'Click to edit',

                    params: function (paramsIn) {
                        var dataSub = {};
                        dataSub.hid = this.id;
                        var iidc = this.id.replace('elginc', '');
                        var parts = iidc.split('-');
                        dataSub.did = parts[0]
                        dataSub.cid = parts[1];
                        dataSub.iid = parts[2];
                        dataSub.pid = parts[3];
                        dataSub.ig = parts[4];
                        dataSub.Quantity = paramsIn.value;
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

    function removeDoctorAsk(healthUnitId, refDate, clinicId, personelId, doctorName, deparmtentId) {
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
    var departmentID = null;
    var clickedClinic = null;
    function addDoctor(e) {
        clickedClinic = e.target.parentNode.parentNode.parentNode.parentNode.children[2].id;
        departmentID = e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id.replace('d', '');
        jQuery('#docModal').modal();
    }

    var addDBts = document.querySelectorAll('button.addDoctor');
    for (var i = addDBts.length - 1; i >= 0; i--) {
        addDBts[i].addEventListener('click', addDoctor);
    }
    var departments = <?php echo json_encode($this->departments); ?>;
    function insertDoctor() {
        var row = document.querySelector('#d' + departmentID + ' #' + clickedClinic).insertRow();
        var selectedDoctorId = document.getElementById('docsDrop').value;
        var selectedDoctor = document.getElementById('docsDrop').options[document.getElementById('docsDrop').selectedIndex].text;
        var healthUnitId = document.getElementById('HealthUnitId').value;
        var refDate = moment(document.getElementById('RefDate').value, 'DD/MM/YYYY').format('YYYY-MM-DD');
        var clinicId = row.parentNode.id.replace('elgcli', '');
        row.setAttribute('id', 'cd-' + clinicId + '-' + selectedDoctorId);
        var incidents = departments[departmentID]['incidents'];
        var cells = [];
        incidents.forEach(function (val) {
            cells.push('<td data-inputclass="edit-text" id="elginc' + departmentID + '-' + clinicId + '-' + val.IncidentId + '-' + selectedDoctorId + '" >0</td>');
        });
        //row.innerHTML = '<th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' + healthUnitId + ',\'' + refDate + '\',' + clinicId +',' + selectedDoctorId + ',\'' + selectedDoctor + '\' )" ></span> '+ selectedDoctor+ '</th><td data-inputclass="edit-text" id="elginc1-1-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-2-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-3-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-11-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td data-inputclass="edit-text" id="elginc1-12-' + selectedDoctorId +'" class="warning editable editable-click">0</td><td>0</td>';
        row.innerHTML = '<th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' + healthUnitId + ',\'' + refDate + '\',' + clinicId + ',' + selectedDoctorId + ',\'' + selectedDoctor + '\',' + departmentID + ')" ></span> ' + selectedDoctor + '</th>' + cells.join('') + '<td>0</td>';
        makeNewEditable(row);
    }

    function makeNewEditable(row) {
        jQuery(row).find('td').editable(
                {
                    url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=childpsychodataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
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
                        dataSub.did = parts[0];
                        dataSub.cid = parts[1];
                        dataSub.iid = parts[2];
                        dataSub.pid = parts[3];
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
</div>




