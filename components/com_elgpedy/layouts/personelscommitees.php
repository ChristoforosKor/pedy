<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');  
$ItemId = $this->state->get('Itemid'); 

 ?>
<div class="commitee-memo">
	<?php foreach ($this->commitees as $commity): ?>
		<div>
			<div class="memo"  style="background-color: #<?php echo $commity->MemoColor; ?>" ></div><div><?php echo $commity->Committee; ?></div>
		</div>
	<?php endforeach; 
	unset($commity);?>
</div>	
<div id="personelsComitees">
</div>
<script type="text/javascript">
	
	var elgCalendar;
jQuery(document).ready(function() {
	
	elgCalendar = jQuery('#personelsComitees').fullCalendar({
		
		header: false,
		lang: 'el',
		selectable: true,
		editable: true,
		selectHelper: true,
		select: function(start, end) {
			jQuery('#personelsCommiteesForm #startDateCommitee').val(moment(start).format('YYYY-MM-DD' ));
			jQuery('#personelsCommiteesForm #endDateCommitee').val(moment(end).format('YYYY-MM-DD' ));
			jQuery('#personelsCommiteesForm').modal({});
			 
		},
		eventLimit: true,
		events: <?php echo json_encode($this->data); ?>
	});  	
} );
function elgCommiteeSetEvent(){
	jQuery('#personelsCommiteesForm .modal-body-data').slideUp();
	jQuery('#personelsCommiteesForm .loading-indicator').show();
	var subData = {};
	subData.personelScheduleId = jQuery('#personelScheduleId').val();
  	subData.startDateCommitee = jQuery('#startDateCommitee').val();
	subData.endDateCommitee = jQuery('#endDateCommitee').val();
	subData.PersonelId = jQuery('#PersonelId').val();
	subData.HealthCommiteeId = jQuery('#HealthCommiteeId').val();
	subData.commitee = jQuery('#commitee').val();
	jQuery.post('<?php echo JRoute::_('index.php?option=com_elgpedy&view=personelscommiteesdataeditsave&format=json&Itemid=' .  $this->state->get('Itemid', 0), false);?>'
	, subData
	, 	function(data, textStatus){
			eventData = {
				title: data.data.data.LastName + ' ' + data.data.data.FirstName,
				start: data.data.data.FromDate,
				end: data.data.data.ToDate,
				backgroundColor: '#' + data.data.data.MemoColor
				
			};
			jQuery('#personelsComitees').fullCalendar('renderEvent', eventData, true)
			jQuery('#personelsCommiteesForm .loading-indicator').hide();
			jQuery('#personelsCommiteesForm .modal-body-data').slideDown();	
			
		}
	);
}


</script>
<div class="modal fade" id="personelsCommiteesForm" tabindex="-1" role="dialog" aria-labelledby="<?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS_UPDATE'); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS_UPDATE'); ?></h4>
            </div>
            <div class="modal-body">
				<div class="modal-body-data">
					<input type="hidden" id="personelScheduleId" />
					<input type="hidden" id="startDateCommitee" />
					<input type="hidden" id="endDateCommitee" />
					<label class="control-label"><?php echo JText::_('COM_ELG_PEDY_PERSONEL'); ?></label>
				   <select id="PersonelId" class="form-control">
					<?php
						foreach($this->personels as $personel):
							echo '<option value="', $personel->PersonelId, '">', $personel->LastName, ' ', $personel->FatherName, '</option>';
						endforeach;
						unset($personel);
					?>
				   </select>
				   <label class="control-label" ><?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS'); ?></label>
				   <select id="HealthCommiteeId" class="form-control" >
					<?php
						foreach($this->commitees as $commitee):
							echo '<option value="', $commitee->CommitteeId, '">', $commitee->Committee, '</option>';
						endforeach;
						unset($commitee);
					?>
				   </select>
				</div>
			    <div class="loading-indicator" style="display:none" ><img src="media/com_elgpedy/images/loader_128_128.gif" /></div> 
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" onclick="elgCommiteeSetEvent()" data-dismiss="modal" ><?php echo JText::_('COM_ELG_SUBMIT'); ?></a>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('COM_ELG_CANCEL'); ?></button>
            </div>
		</div>
	</div>
</div>
