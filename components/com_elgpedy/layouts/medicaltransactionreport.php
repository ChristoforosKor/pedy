<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');
?>
<section id="elgdata">
	
	<div class="clearfix">&nbsp;</div>
	<div class="col-md-6">
		<table class="table table-striped table-bordered" id="medicalTransaction">
			<thead>
				<tr class="info">
					<td colspan="1" style="vertical-align: middle;"><?php echo JText::_('COM_ELGPEDY_EXAMS');?></td>
					<td colspan="1" style="vertical-align: middle;">Διενέργεια εντός της δομής ΠΦΥ</td>
                    <td colspan="1" style="vertical-align: middle;">Αποστολή δειγμάτων αποκλειστικά στο Κεντρικό Διαγνωστικό Εργαστήριο (Κ.Δ.Ε.)</td>
                    <td colspan="1" style="vertical-align: middle;">Σύνολο</td>
				</tr>
			</thead>
			<tbody id="mt0">
			<?php
				foreach($this->fields->exams as $exam):
					if(isset($this->dataLabExams[$exam->MedicalTypeId]))
					{	
						$rowClass='success';
						$rowClass2='success';
						$rowValue= $this->dataLabExams[$exam->MedicalTypeId]->Quantity;
						$rowValue2= $this->dataLabExams[$exam->MedicalTypeId]->Quantity_KDE;
					}
					else
					{
						$rowClass='warning';
						$rowClass2='warning';
						$rowValue= 0;
						$rowValue2= 0;
					}			
				?>				
				<tr>
					<th><?php echo $exam->MedDesc; ?></th>
					<td class="col-md-4 <?php echo $rowClass ?>" id="elgmtid<?php echo $exam->MedicalTypeId; ?>" data-inputclass="edit-text" ><?php echo $rowValue;  ?></td>
					<td class="col-md-4 <?php echo $rowClass2 ?>" id="elgmtid<?php echo $exam->MedicalTypeId; ?>" data-inputclass="edit-text" ><?php echo $rowValue2;  ?></td>
					<td class="col-md-1"><?php echo $rowValue + $rowValue2;  ?></td>
				</tr>
			<?php 
				endforeach; 
				unset($exam);
			?>
			</tbody>
		</table>
	</div>
</section>

<div class="clearfix"></div>
<?php include_once JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; ?>
