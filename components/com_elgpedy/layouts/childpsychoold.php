<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined('_JEXEC') or die('Restricted access'); 
$elgcnt = 0;
$lastDepartmentId = '';

if(isset($this->dataClinical[0][0][4])):
	$rowValue= $this->dataClinical[0][0][4];
	if($rowValue > 0 ):
		$rowClass='success';
	else :
		$rowClass='warning';
	endif;
else:
	$rowClass='warning';
	$rowValue= 0;
endif; 

echo '<div class="row"><div class="col-md-6"><table class="table table-hover table-bordered clinicTransaction" ><tbody><tr><th class="info">', JText::_('COM_ELG_PEDY_CHECKER'), '</th><td id="elginc0-0-4" class="col-md-2 ', $rowClass, '" data-inputclass="edit-text" >', $rowValue, '</td></tr></tbody></table></div><div class="clearfix"></div></div>';
foreach($this->departments as $depName=>$depId):
    if($lastDepartmentId != $depId): ?>
		<h3><?php echo $depName; $lastDepartmentId = $depId; ?></h3>
	<?php
	endif;
	if(isset($this->dataClinical[0][4])):
				
		$rowValue= $this->dataClinical[0][4];
		if($rowValue > 0 ):
			$rowClass='success';
		else :
			$rowClass='warning';
		endif;
	else:
			$rowClass='warning';
			$rowValue= 0;
		endif;
	echo '<section><div class="row">'; 
	foreach($this->fields->clinics as $clinic):	
		if($clinic->DepartmentId == $lastDepartmentId):
			$elgcnt ++;
			echo '<div class="col-md-6"><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><td colspan="2">', $clinic->Clinic, '</td></tr></thead><tbody id="elgcli', $clinic->ClinicId, '">';
			foreach($this->fields->incidents as $incident):
				if($incident->DepartmentId == $lastDepartmentId) :
					if( isset( $this->dataClinical [ $lastDepartmentId ][ $clinic->ClinicId ] [ $incident->IncidentId ] ) ):
						$rowValue= $this->dataClinical[ $lastDepartmentId ][$clinic->ClinicId][$incident->IncidentId];
						if($rowValue > 0 ):
							$rowClass='success';
						else :
							$rowClass='warning';
						endif;
					else:
						$rowClass='warning';
						$rowValue= 0;
					endif;
					
					echo '<tr><th  ><a data-yjsg-tip="', $incident->Tooltip, '" >', $incident->Incident, '</a></th><td class="col-md-2 ', $rowClass, '" id="elginc', $lastDepartmentId, '-', $clinic->ClinicId, '-', $incident->IncidentId, '" data-inputclass="edit-text">', $rowValue, '</td></tr>';		
				endif;
			endforeach;
			unset($incident);
			echo '</tbody></table></div>';
			if($elgcnt % 2 === 0) :
				echo '</div><hr /><div class="row">';
			endif;
		else:  //clinic departmentid
			$elgcnt = 0;
		endif;
	   
	 endforeach;
	 unset($clinic);
	echo '</div></section>';
endforeach; unset($department);
?>

<script type="text/javascript">
	jQuery(document).ready(function(){
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
			
			params: function(paramsIn){
				var dataSub = {};
				dataSub.hid = this.id;
				var iidc = this.id.replace('elginc','');
				var parts = iidc.split('-');
				dataSub.did = parts[0];
				dataSub.cid = parts[1];
				dataSub.iid = parts[2];
				dataSub.Quantity = paramsIn.value;				
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



