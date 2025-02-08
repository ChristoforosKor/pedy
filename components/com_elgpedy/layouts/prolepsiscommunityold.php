<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');  
$elgcnt =0;
$lastActId = 0;
$tbo=0;
$act7 = [];

echo '<section id="elgdata"><div class="row">'; 


 foreach($this->fields->prolepsis as $item):
	
		if ( $item[0] -> MedicalActId == 7):
			$act7[] = $item;
			continue;
		endif;
		$tbo ++;
		if(count($item) > 0 ) :
		$elgcnt ++;
		echo '<div class="col-md-6"><table class="table table-hover table-bordered " id="prolepsisTransaction"  ><thead><tr class="info"><td colspan="2">', $item[0]->ActDesc, '</td></tr></thead><tbody id="elgmedactid', $item[0]->MedicalActId, '">';
		foreach($item  as $value):
			
			if(isset($this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId]))
			{
				$rowValue= $this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId];
				if($this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId] > 0)
				{
					$rowClass='success';					
				}
				else
				{
					$rowClass='warning';
				}
			}
			else
			{
				$rowClass='warning';
				$rowValue= 0;
			}
			echo '<tr><th>', $value->MedDesc, '</th><td class="col-md-2 ', $rowClass, '" id="elgmedtid', $value->MedicalActId, '-', $value->MedicalTypeId, '" data-inputclass="edit-text" tabindex="', $tbo, '" >', $rowValue, '</td></tr>';		
		endforeach;
		unset($value);
		echo '</tbody></table></div>';
	endif;
	if($elgcnt % 2 === 0)
	{
		echo '</div><hr /><div class="row">';
	}
 endforeach;
 unset($item);
 
 echo '</div></section>';
 
 
 /////////////////////////////////////////////////////////////////////////////////////////
 // echo '<section id="elgdata"><div class="row"><div class="col-md-12"><table class="table table-hover table-bordered clinicTransaction" ><tbody><tr><th class="info">', JText::_('COM_ELG_PEDY_CHECKER'), '</th><td id="elginc0-4" class="col-md-2 ', $rowClass, '" data-inputclass="edit-text" >', $act7, '</td></tr></tbody></table></div><div class="clearfix"></div></div><div class="row">'; 
// foreach( $this -> prolepsisAttibutes as attr):
/* if ( isset( $act7[0][0] ) ):	
	//echo json_encode($act7);
	
	$elgcnt ++;
	$totalSum = 0;
	echo '<div class="col-md-12"><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><td colspan="' . (count( $act7[0] ) + 4) .'">', $act7[0][0]->ActDesc, '</td></tr></thead>';
        echo '<tfoot><tr><td colspan="' . (count($act7[0]) + 4) .'"><button type="button" class="addDoctor">+</button></td> </tr>';
        echo '<tbody id="elgcli', $clinic->ClinicId, '">';
	echo '<tr><th>', Φυσικοθεραπευτής/τρια, '</th><th>Ασφαλιστικός Φορέας Ασθενούς</th><th>Προέλευση Ασθενούς</th>';
        $personelInserted = [];
		foreach ($act7[0] as  $med):
		    echo '<th  ><a>', $med->MedDesc, '</a></th>';
        endforeach;
        unset($incident);
        echo '<th>Σύνολα</th></tr>';
		echo 1;
        foreach($this -> fields -> doctors as $doctor):
            echo 2;
			$rowSum = 0;
			if( in_array($doctor['PersonelId'], $personelInserted) ):
				echo 2;
				continue;
			endif;
			echo 3;
			$this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId]
 			if(isset( $this -> dataProlepsis[ 1 ][$clinic -> ClinicId][ $doctor['PersonelId'] ])   ):
			   echo 4;
			   getRowPolepsis($doctor, $this -> fields -> incidents, $clinic -> ClinicId, $this -> dataProlepsis[ 1 ], $this -> refDate, $this -> healthUnitId);
            elseif($clinic -> ClinicId == $doctor ['ClinicTypeId'] ):
				echo 5;
				getRowPolepsis($doctor, $this -> fields -> incidents, $clinic -> ClinicId, $this -> dataProlepsis[ 1 ], $this -> refDate, $this -> healthUnitId);
             endif;
			$personelInserted[] =  $doctor['PersonelId'];
			echo 6;
        endforeach;
        unset($doctor);
        echo '</tbody></table></div>';
        
	if($elgcnt % 2 === 0)
	{
		echo '</div><hr /><div class="row">';
	}
  endif; */
// echo '</div></section>'
 /**<div class="clearfix">&nbsp;</div><p><span class="comments-title">', JText::_('COM_ELG_PEDY_COMMENTS'), ':</span>', JText::_('COM_ELG_PEDY_FORM_FOOTER_CLINIC'), '</p>';
 function getRowPolepsis($doctor, $incidents , $ClinicId,  $clinicalData, $refDate, $healthUnitId)
	{
		$rowSum = 0;
		
		echo '<tr id="cd-' . $ClinicId . '-' . $doctor['PersonelId'] . '" ><th><span class="glyphicon glyphicon-minus-sign" onclick="removeDoctorAsk(' . $healthUnitId, ',\'' . $refDate, '\',' . $ClinicId, ',' . $doctor['PersonelId'] , ', \'' , $doctor['FirstName'], ' ', $doctor['LastName'], '\')"></span> <span> ', $doctor['FirstName'], ' ', $doctor['LastName'], '</span></th>';   
		foreach($incidents as $incident):
			$rowSum  += getCell($ClinicId, $incident -> IncidentId,  $doctor['PersonelId'], $clinicalData[$ClinicId][$doctor['PersonelId']] );
		endforeach; 
        unset($incident);
		echo '<td>' . $rowSum . '</td></tr>';
	}
 **/
 ?>
  
 
<script type="text/javascript">
	jQuery(document).ready(function(){
		
		jQuery('#elgdata tbody td').editable(
		{
			url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=prolepsiscommunitydataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
			type: 'text',
			pk: 1,
			name: 'pk',			
			mode: 'inline',
			showbuttons: false,
			savenochange: true,
			title: 'Click to edit',
			
			
			params: function(params){
				var dataSub = {};				
				dataSub.hid = this.id;
				var t = dataSub.hid.replace('elgmedtid','');
				dataSub.actid = t.charAt(0);
				dataSub.mtid = t.replace(dataSub.actid + '-', '');
				dataSub.Quantity = params.value;
                dataSub.RefDate =moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
				dataSub.HealthUnitId = document.getElementById('HealthUnitId').value;
				return dataSub;
			},
			validate: function(value) {
				if(isNaN(value.replace(' ', ''))){
					jQuery('#modalValidate').modal('show');
					return '-';
				}
				
			},
			success: elgShowResultMessage			
		});
		elgClearEditable();
	});
	
</script>



