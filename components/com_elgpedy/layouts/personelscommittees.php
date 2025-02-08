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
 <!-- script type="application/javascript" src="media/com_elgpedy/js/personelcomittees.js" ></script -->
 <!-- script type="application/javascript" src="media/com_elgpedy/js/jquery.modal.min.js" ></script -->
<div class="committee-memo row">
	<?php foreach ($this->committees as $commity): ?>
		<div class="col-md-4">
			<div class="memo"  style="background-color: #<?php echo $commity->MemoColor; ?>" ></div><div><?php echo $commity->Committee; ?></div>
		</div>
	<?php endforeach; 
	unset($commity);?>
</div>	
<div id="personelsComittees">
</div>

<div id="comF">
</div>
<div class="modal fade" id="personelsCommitteesForm" tabindex="-1" role="dialog" aria-labelledby="<?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS_UPDATE'); ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS_UPDATE'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="modal-body-data">
				<div id="updateSection">
                                    <p class="text-danger" style="display:none" id="committeeMesage"><?php echo JText::_('COM_ELGPEDY_VALIDATE_SCHEDULE'); ?></p>
					<input type="hidden" id="PersonelScheduleId" />
					<input type="hidden" id="StartDateCommittee" />
					<input type="hidden" id="EndDateCommittee" />
                                    <div class="form-group">
                                        <label class="control-label"><?php echo JText::_('COM_ELG_PEDY_PERSONEL'); ?></label>
                                        <select id="PersonelId" class="form-control">
                                            <option value=""><?php echo JText::_('COM_ELG_SELECT'); ?></option>
                                                <?php
						foreach($this->personels as $personel):
							echo '<option value="', $personel->PersonelId, '">', $personel->LastName, ' ', $personel->FirstName, '</option>';
						endforeach;
						unset($personel);
                                                ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" ><?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS'); ?></label>
                                        <select id="HealthCommitteeId" class="form-control" >
                                            <option value=""><?php echo JText::_('COM_ELG_SELECT'); ?></option>
                                            <?php
						foreach($this->committees as $committee):
							echo '<option value="', $committee->CommitteeId, '">', $committee->Committee, '</option>';
						endforeach;
						unset($committee);
                                            ?>
                                        </select>
                                    </div>  
                                   
				</div>
                                <div style="display:none" id="committeeDelSection">
                                    <strong><?php echo JText::_('COM_ELG_PEDY_PERSONELSCOMMITESS_DELETE'); ?></strong>
                                    <p>
                                        <span id="delTitle"></span><br />
                                        <span id="delDates"></span>
                                    </p>
                                   
                                </div>
                                <div style="display:none" id="resultMessageSection">
                                    <p id="resultMessage"></p>                                   
                                </div>
                </div>
                                <div class="loading-indicator" style="display:none" ><img src="media/com_elgpedy/images/loader_128_128.gif" /></div> 
                    </div>
            <div class="modal-footer">
                <div class="buttons">
                    <button class="btn btn-danger pull-left" type="button" onclick="elgCommitteeAskDel()" style="display:none" id="committeAskDel"><?php echo JText::_('COM_ELG_DELETE'); ?></button>
                    <button class="btn btn-primary" type="button" onclick="elgCommitteeSetEvent()"  ><?php echo JText::_('COM_ELG_SUBMIT'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('COM_ELG_CANCEL'); ?></button>
                </div>
                <div class="buttons-del" style="display:none" >
                    <button type="button" class="btn btn-danger" onclick="elgCommitteeDelEvent()"><?php echo JText::_('JYES'); ?></button>
                    <button type="button" class="btn btn-primary" onclick="elgCommitteeCloseDel()"><?php echo JText::_('JNO'); ?></button>
                </div>
                <div class="buttons-result">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('COM_ELG_OK'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
	var saveUrl  =  '<?php echo JRoute::_('index.php?option=com_elgpedy&view=personelscommitteesdataeditsave&format=json&Itemid=' .  $this->state->get('Itemid', 0), false);?>';
	var deleteUrl = '<?php echo JRoute::_('index.php?option=com_elgpedy&view=personelscommitteesdatadelete&format=json&Itemid=' .  $this->state->get('Itemid', 0), false);?>';
</script>
<script type="application/javascript" src="media/com_elgpedy/js/personelcomittees.js" ></script>
