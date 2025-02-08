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
$incidentsAllowedId = [1,2 ]; //taktika, ektakta
$incidentsAllowed = array_filter( $this -> fields -> allIncidents, function ( $item ) use ( $incidentsAllowedId )  {
                    return in_array( $item ['ClinicIncidentId'], $incidentsAllowedId );
                }); 
array_unshift( $incidentsAllowed,['ClinicIncidentId' => '','DescEL' =>  'Επιλέξτε']);
$htmlncidentsDrop = 
        array_reduce ( 
                $incidentsAllowed    
                , function( $curry, $item ){
                    return $curry . '<option value="' . $item['ClinicIncidentId'] . '" >' . $item['DescEL'] . '</option>';
                }
                , ''
        );
array_unshift( $this -> fields -> allEducations, ['PersonelEducationId' => '','DescEL' => 'Επιλέξτε'] );                 
$htmlEducationDrop = '<option value="0">ΟΧΙ</option><option value="1">ΝΑΙ</option>';
//        array_reduce(
//                $this -> fields -> allEducations
//                , function ($curry, $item) {
//                  If ( $item['PersonelEducationId'] == 5  || $item['PersonelEducationId'] == '')
//                  {
//                        return $curry . '<option value="' . $item['PersonelEducationId'] . '">' . $item['DescEL']  . '</option>';
//                  }
//                  else
//                  {
//                      return $curry;
//                  }
//                }
//                ,''
//        );
$clientData = [];

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

$lastClinicTypeId = 0;
forEach ( $this -> fields -> clinics['notSummed'] as $clinic ): ?>
<style>
    table.clinicTransaction span.glyphicon-plus-sign:hover {
    cursor: pointer;
}
  </style>
<div class="row child-clinics-2">
    <h3><?php echo  $clinic -> Clinic; ?></h3>
    <table class="table table-hover table-bordered clinicTransaction" id="c<?php echo $clinic -> ClinicId; ?>"  >
        <thead>
            <tr class="info">
                <th>Ιατρός</th>
                <th>A.M.K.A Ασθενή</th>
                <th> Τύπος</th>
                <th>Εκπαίδευση</th>
                <th>Ποσότητα</th>
            </tr>
        </thead>        
        <tfoot>
            <tr><td colspan="5"><button type="button" class="addDoctor btn btn-default">Προσθήκη Ιατρού</button></td> </tr>
        </tfoot>
        <tbody>
            <?php
            $clinicalData = [];
            if ( $lastClinicTypeId !== $clinic -> ClinicId ) :
                $lastClinicTypeId = $clinic -> ClinicId;
              
                   if ( isset( $this -> dataClinical[ $lastClinicTypeId ] ) ): 
              
                    $clinicalData = $this -> dataClinical[ $lastClinicTypeId ];
                endif;
            endif;
            
            foreach ( $this -> fields -> doctors as $doctor ):
                    if (  $clinic -> ClinicId == $doctor ['ClinicTypeId'] ):
                        $dataDoctorIncidents = (isset( $clinicalData [ $doctor['PersonelId'] ] ) ? $clinicalData [ $doctor['PersonelId'] ] : [] );
                    if ( count( $dataDoctorIncidents ) === 0 ) :
                        echo pdCSRow( $doctor, 0 , $clinic->ClinicId, '', 0, '', $htmlncidentsDrop, $htmlEducationDrop);
                    else:
                        foreach ( $dataDoctorIncidents as $amka => $amkaData):
                                    echo pdCSRow( $doctor, $amkaData[1] , $clinic->ClinicId,  $amka, $amkaData[2], $amkaData[0], $htmlncidentsDrop, $htmlEducationDrop);
                                    $clientData['#cd-' . $clinic->ClinicId . '-' . $doctor['PersonelId']  .'-' . $amka] = $amkaData; 
                        endforeach;
                        unset ( $amka );
                        unset( $amkaData );
                    endif;
                endif;
            endforeach;
            unset($doctor);
            ?>
            </tbody>
    </table>
</div>
<?php endforeach; unset($clinic);

//function getIncidentGroupsIds( $groups,  $clinicId, $incidentId)
//{
//    if ( isset( $groups [$clinicId ] [ $incidentId ] ) ):
//        return array_keys ( $groups [$clinicId ] [ $incidentId ] );
//    else:
//        return [0];
//    endif;
//}


function pdCSRow($doctor, $incidentId, $clinicId, $ssn, $educationId, $quantity, $htmlncidentsDrop, $htmlEducationDrop) 
{
    return '<tr id="cd-' . $clinicId . '-' . $doctor['PersonelId']  .'-' . $ssn . '" ><th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(\'cd-' . $clinicId . '-' . $doctor['PersonelId']  .'-' . $ssn . '\' )"></span> <span class="glyphicon glyphicon-plus-sign" onclick="addDoctor(event,' . $doctor['PersonelId'] . ',' . $clinicId . ')"></span> <span> ' . $doctor['LastName']  . ' ' . $doctor['FirstName']  . '</span><div class="messages-element"></div></th>'
    . '<td><input type="text" value="' . $ssn . '" class="ssn form-control" /> </td>'
    . '<td><select   data-initial-id="' .$incidentId . '" class="form-control" >' . $htmlncidentsDrop . '</select></td>'
    . '<td><select data-inital-id="'. $educationId . '"  class="form-control" >' .  $htmlEducationDrop . '</select></td><td><input type="text" value="' . $quantity . '" class="form-control"  /></td></tr>';
   
}
?>

<script type="text/javascript">
    
    var pdDBData = <?php echo json_encode($clientData); ?>;
    var pdBDIncidentsDrop = '<?php echo $htmlncidentsDrop; ?>'; 
    var pdBDEducationDrop = '<?php echo $htmlEducationDrop; ?>';
    
    
    jQuery(document).ready(function () {
       Object.keys(pdDBData).forEach(function(item){
            let row = document.querySelector(item);
            row.cells[2].firstChild.value = pdDBData[item][1];
            row.cells[3].firstChild.value = pdDBData[item][2];
        });
        
        let inputs = document.querySelectorAll('table.clinicTransaction tbody td input');
        for( let j = inputs.length -1; j > -1; j -- ) {
            inputs[j].addEventListener('change', pdSubmitRowValues);
        }
        let selects = document.querySelectorAll('table.clinicTransaction tbody td select');
        for( let j = selects.length -1; j > -1; j -- ) {
            selects[j].addEventListener('change', pdSubmitRowValues);
        }
        
    });
    
    function pdSubmitRowValues( event ) {
        var row = event.target.parentNode.parentNode;
        var cells = row.cells;
        var length = cells.length;
        
        let trainingValue = cells[3].firstChild.value;
         
        for ( let i = 1; i < length; i ++ ) {
            let validateLength = ( cells[i].firstChild.classList.contains('ssn') ? 11: 0);
            let validationError;
            
            if ( i !== 3 && trainingValue == 0) { // Εκπαίδευση δεν είναι υποχρεωτική
                validationError = pdValidateValue( cells[i].firstChild.value.replace(/ /g,''), validateLength );
            }
            else {
                validationError = '';
            }

            if ( validationError !== '') {
                pdShowErrorCell('danger', validationError, cells[i] );
                return false;
            }
            else {
                pdShowValidCell( cells[i] );  
            }
        }
        
       
    
        jQuery.post('<?php echo JRoute::_('index.php?option=com_elgpedy&view=childpsychodataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>'
            , pdGetData2Submit( event.target.parentNode.parentNode )
             , function (response) {
                elgShowMessages( response.messages, row.cells[0] );
             });        
    }   
    
    
     function pdValidateValue ( clearedValue, length ) {
        
        if (clearedValue === '') {            
            return "Το πεδίο είναι υποχρεωτικό"
        }
        
        if ( isNaN( clearedValue) ) {
            return "Συμπληρώστε με αριθμό";
        }
        
        if ( length > 0 ) {
            return pdValidateLength( clearedValue, length);
        }
        else {
          return '';  
        }
    }   
    
    function pdValidateLength( clearedValue, length) {
        if ( clearedValue.length !== length) {
            return "Συμπληρώστε με  " + length + " χαρακτήρες";
        }
        return '';
    }    
    
    function pdShowErrorCell( messageType, messageText, cell ) {
        let messages_element = cell.querySelector('div.elg_messages');
        if ( messages_element === null ) {
          messages_element = document.createElement('div');
          messages_element.setAttribute('class', 'elg_messages');
          cell.appendChild( messages_element );
        }
        elgClearNodeChildren( messages_element );
        elgAppendMessage( messageType, messageText, messages_element);
        cell.classList.add('danger');
    }
    
    function pdShowValidCell(cell) {
        let messages_element = cell.querySelector('div.elg_messages');
        if (  messages_element !== null ) {
            elgClearNodeChildren( messages_element )
        }
        cell.classList.remove('danger');
    }    
    
    function pdGetData2Submit( row ) {
        let data2Submit = {};
        let parts = row.id.replace('cd-', '').split('-');
        data2Submit.did = 0;
        data2Submit.cid = parts[0];
        data2Submit.pid = parts[1];        
        data2Submit.Quantity = row.cells[4].firstChild.value;
        data2Submit.RefDate = moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
        data2Submit.HealthUnitId = document.getElementById('HealthUnitId').value;
        data2Submit.patient_amka = row.cells[1].firstChild.value;
        data2Submit.iid = row.cells[2].firstChild.value;
        data2Submit.education_id = row.cells[3].firstChild.value;
        return data2Submit;
         
    }  
    
    function removeDoctorAsk( rowId ) {
        let idParts = rowId.split('-');
        let row = document.getElementById(rowId);
       
        document.querySelector('#remDocModal .modal-body').textContent = 'Είστε σίγουροι για τη διαγραφή του/της ' + row.cells[0].children[1].textContent;
        document.getElementById('HealthUnitId2').value = document.getElementById('HealthUnitId').value;
        document.getElementById('RefDate2').value = moment(document.getElementById('RefDate').value, 'DD/MM/YYYY').format('YYYY-MM-DD') ;
        document.getElementById('ClinicTypeId').value = idParts[1];
        document.getElementById('PersonelId').value = idParts[2];
        document.getElementById('ssn2').value = idParts[3];
        document.getElementById('row2RemId').value = rowId;
        document.getElementById('remDocBt').style.display = 'inline';
        jQuery('#remDocModal').modal();
    }

    function removeDoctor() {
        var data = {};
        jQuery.post('index.php?option=com_elgpedy&controller=removedoctorclinictransaction&format=json&Itemid=<?php echo $this->state->get('Itemid'); ?>'
                , 'PersonelId=' + document.getElementById('PersonelId').value + '&HealthUnitId=' + document.getElementById('HealthUnitId2').value + '&RefDate=' + document.getElementById('RefDate2').value 
                + '&ClinicTypeId=' + document.getElementById('ClinicTypeId').value + '&ssn=' + document.getElementById('ssn2').value
                + '&row2RemId=' + document.getElementById('row2RemId').value
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
        let row = document.getElementById(data.row2RemId);
        row.parentNode.removeChild(row);
        
    }
    
    var departmentID = null;
    var clickedClinic = null;
    
    
    function addDoctor(e, idDoctor, idClinic) {
       
        if ( idDoctor == null ) {
            clickedClinic = e.target.parentNode.parentNode.parentNode.parentNode.id;       
            jQuery('#docModal').modal();
        }
        else {
            let doctors = document.getElementById('docsDrop');
            doctors.value = idDoctor;
            let docsDropTmp = document.getElementById('docsDrop');
            let selectedDoctor = docsDropTmp.options[document.getElementById('docsDrop').selectedIndex].text;
            let selectedDoctorId = docsDropTmp.value;
            clickedClinic = 'c' + idClinic;
            insertDoctor(selectedDoctorId, selectedDoctor) ;
        }
        
    }

    var addDBts = document.querySelectorAll('button.addDoctor');
    for (var i = addDBts.length - 1; i >= 0; i--) {
        addDBts[i].addEventListener('click', addDoctor);
    }
    
    function insertDoctor(selectedDoctorId, selectedDoctor) {
        
        var row = document.querySelector('#' + clickedClinic + ' tbody').insertRow();
        if ( selectedDoctorId == null ) {
            selectedDoctorId = document.getElementById('docsDrop').value;
            selectedDoctor = document.getElementById('docsDrop').options[document.getElementById('docsDrop').selectedIndex].text;
        }
// var healthUnitId = document.getElementById('HealthUnitId').value;
       // var refDate = moment(document.getElementById('RefDate').value, 'DD/MM/YYYY').format('YYYY-MM-DD');
        var clinicId = row.parentNode.parentNode.id.replace('c', '');
        row.setAttribute('id', 'cd-' + clinicId + '-' + selectedDoctorId +'-0');
        row.setAttribute('data-id', 0);
        row.innerHTML = '<th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(\'cd-' + clinicId +  '-'  + selectedDoctorId + '-0\')"></span> <span class="glyphicon glyphicon-plus-sign" onclick="addDoctor(event,' + selectedDoctorId + ',' + clinicId + ')"></span> <span> ' + selectedDoctor + '</span><div class="messages-element"></div></th>'
        + '<td><input type="text" value="" class="ssn form-control" /> </td><td><select   data-initial-id="0" class="form-control" >' + pdBDIncidentsDrop + '</select></td>'
        +  '<td><select data-inital-id="0"  class="form-control" >' + pdBDEducationDrop + '</select></td><td><input type="text" value="" class="form-control"  /></td>';
          
        let inputs = row.querySelectorAll(' td input');
        for( let j = inputs.length -1; j > -1; j -- ) {
            inputs[j].addEventListener('change', pdSubmitRowValues);
        }
        let selects = row.querySelectorAll('td select');
        for( let j = selects.length -1; j > -1; j -- ) {
            selects[j].addEventListener('change', pdSubmitRowValues);
        }
        
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
<!-- /div -->

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
            <input type="hidden" value="" id="HealthUnitId2" />
            <input type="hidden" value="" id="RefDate2" />
            <input type="hidden" value="" id="ClinicTypeId" />
            <input type="hidden" value="" id="PersonelId" />
            <input type="hidden" value="" id="ssn2" />
            <input type="hidden" value="" id="row2RemId" />
            <div class="modal-footer">
                <button type="btn" id="remDocBt" class="btn btn-danger btn-default pull-left" onclick="removeDoctor()">Διαγραφή</button>          
            </div>
        </div>
    </div>
</div>
<!-- /div -->




