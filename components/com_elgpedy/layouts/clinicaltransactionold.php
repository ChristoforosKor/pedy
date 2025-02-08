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

if(isset($this->dataClinical[1][0][4])):
			
			$rowValue= $this->dataClinical[1][0][4];
			if($rowValue > 0 ):
				$rowClass='success';
			else :
				$rowClass='warning';
			endif;
		else:
			$rowClass='warning';
			$rowValue= 0;
		endif;
   
echo '<section id="elgdata"><div class="row"><div class="col-md-6"><table class="table table-hover table-bordered clinicTransaction" ><tbody><tr><th class="info">', JText::_('COM_ELG_PEDY_CHECKER'), '</th><td id="elginc0-4" class="col-md-2 ', $rowClass, '" data-inputclass="edit-text" >', $rowValue, '</td></tr></tbody></table></div><div class="clearfix"></div></div><div class="row">'; 
foreach($this->fields->clinics as $clinic):	
	$elgcnt ++;
	
	echo '<div class="col-md-6"><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><td colspan="2">', $clinic->Clinic, '</td></tr></thead><tbody id="elgcli', $clinic->ClinicId, '">';
	foreach($this->fields->incidents as $incident):
	
		if(isset($this->dataClinical[ 1 ][$clinic->ClinicId][$incident->IncidentId])):
			
			$rowValue= $this->dataClinical[ 1 ][$clinic->ClinicId][$incident->IncidentId][''];
			if($rowValue > 0 ):
				$rowClass='success';
			else :
				$rowClass='warning';
			endif;
		else:
			$rowClass='warning';
			$rowValue= 0;
		endif;
		echo '<tr><th  ><a data-yjsg-tip="', $incident->Tooltip, '" >', $incident->Incident, '</a></th><td class="col-md-2 ', $rowClass, '" id="elginc', $clinic->ClinicId, '-', $incident->IncidentId, '" data-inputclass="edit-text">', $rowValue, '</td></tr>';		
	endforeach;
	unset($incident);
	echo '</tbody></table></div>';
	if($elgcnt % 2 === 0)
	{
		echo '</div><hr /><div class="row">';
	}
 endforeach;
 unset($clinic);
 echo '</div>
 </section><div class="clearfix">&nbsp;</div><p><span class="comments-title">', JText::_('COM_ELG_PEDY_COMMENTS'), ':</span>', JText::_('COM_ELG_PEDY_FORM_FOOTER_CLINIC'), '</p>';
 ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('table.clinicTransaction tbody td').editable(
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
			
			params: function(params){
				var dataSub = {};
				dataSub.hid = this.id;
				var iidc = this.id.replace('elginc','');
				var iid = iidc.split('-')[1]
				dataSub.iid = iid;
				dataSub.ctid = this.parentNode.parentNode.id.replace('elgcli', '');
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



