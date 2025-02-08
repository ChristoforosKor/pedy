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
?>
<div class="elg">
	<div class="pedy-form-data">
		<table class="table table-bordered table-striped clinicTransaction">
			<tr>
				<?php 
				
					if($this->checker == 0):
					$rowClass='warning';
					else:
					$rowClass='success';
					endif;
				?>
				<th><?php echo JText::_('COM_ELG_PEDY_CHECKER');?></th><td class="<?php echo $rowClass; ?>" id="checkerValue" ><?php echo $this->checker; ?></td>
			</tr>
		</table>
		<table class="table table-bordered table-striped clinicTransaction">
			<thead>
				<tr>
					<th></th>
					<?php foreach($this->incidents as $incident): ?>
						<th><?php echo $incident->Incident; ?></th>
					<?php endforeach; unset($incident); ?>
				</tr>
			</thead>
			<tbody id="elgRTClinical" >
				<?php foreach($this->clinics as $clinic): ?>
					<tr>
						<th><?php echo $clinic->Clinic; ?></th>
						<?php 
						
						foreach($this->incidents as $incident):
                            
                                                if(isset($this->dataClinical[1][$clinic->ClinicId][$incident->IncidentId])):
                                                    $rowValue= $this->dataClinical[1][$clinic->ClinicId][$incident->IncidentId];
												    if($rowValue > 0 ):
														$rowClass='success';
                                                    else :
                                                        $rowClass='warning';
                                                    endif;
                                                else:
                                                        $rowClass='warning';
                                                        $rowValue= 0;
                                                endif;
                                             //   echo $rowValue;
                                ?>
																																												
                                            <td id="elginc<?php echo $clinic->ClinicId; ?>-<?php echo $incident->IncidentId ;?>"  class="<?php echo $rowClass; ?>"><?php echo 	$rowValue; ?></td>
						<?php endforeach; unset($incident); ?>
					</tr>
				<?php endforeach; unset($clinic); ?>
			</tbody>
		</table>
	</div>
</div>
<div class="clearfix"></div>
<?php include JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; ?>