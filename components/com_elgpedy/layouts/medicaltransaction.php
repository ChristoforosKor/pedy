<?php
/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
?>
<section id="elgdata">

    <div class="clearfix">&nbsp;</div>
    <div class="col-md-6">
        <table class="table table-hover table-bordered" id="medicalTransaction">
            <thead>
                <tr class="info">
                    <td colspan="1" style="vertical-align: middle;"><?php echo JText::_('COM_ELGPEDY_EXAMS'); ?></td>
                    <td colspan="1" style="vertical-align: middle;">Διενέργεια εντός της δομής ΠΦΥ</td>
                    <td colspan="1" style="vertical-align: middle;">Αποστολή δειγμάτων αποκλειστικά στο Κεντρικό Διαγνωστικό Εργαστήριο (Κ.Δ.Ε.)</td>
                    <td colspan="1" style="vertical-align: middle;">Σύνολο</td>
                </tr>
            </thead>
            <tbody id="mt0">
                <?php
                foreach ($this->fields->exams as $exam):
                    if (isset($this->dataLabExams[$exam->MedicalTypeId])) {
                        $rowClass = 'success';
                        $rowClass2 = 'success';
                        $rowValue = $this->dataLabExams[$exam->MedicalTypeId]->Quantity;
                        $rowValue2 = $this->dataLabExams[$exam->MedicalTypeId]->Quantity_KDE;
                    } else {
                        $rowClass = 'warning';
                        $rowClass2 = 'warning';
                        $rowValue = 0;
                        $rowValue2 = 0;
                    }
                    ?>				
                    <tr>
                        <th><?php echo $exam->MedDesc; ?></th>
                        <td class="col-md-4 quan <?php echo $rowClass ?>" id="elgmtid<?php echo $exam->MedicalTypeId; ?>-1" data-inputclass="edit-text" data-quantityid="1"><?php echo $rowValue; ?></td> 
                        <td class="col-md-4 quan <?php echo $rowClass2 ?>" id="elgmtid<?php echo $exam->MedicalTypeId; ?>-2" data-inputclass="edit-text" data-quantityid="2" ><?php echo $rowValue2; ?></td>
                        <td class="col-md-1" readonly><?php echo $rowValue + $rowValue2; ?></td>
                    </tr>
    <?php
endforeach;
unset($exam);
?>
            </tbody>
        </table>
    </div>
</section>
<div class="clearfix">&nbsp;</div>

<script type="text/javascript">

    jQuery(document).ready(function () {
        jQuery('tbody td.quan').editable(
                {
                    url: '<?php echo JRoute::_('index.php?option=com_elgpedy&view=medicaltransactiondataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>',
                    type: 'text',
                    pk: 1,
                    name: 'pk',
                    mode: 'inline',
                    showbuttons: false,
                    savenochange: true,
                    title: 'Click to edit',
                    params: function (params) {
                        var dataSub = {};
                        let idVals = this.id.split('-');
                        
                        dataSub.hid = idVals[0];
                        dataSub.mtid = dataSub.hid.replace('elgmtid', '');
                        let quantities = pedyGetMedicalTransactionQuantity(params, this);
                        
                        dataSub.Quantity = quantities.quantity;
                        dataSub.Quantity_KDE = quantities.quantity_KDE;
                        dataSub.RefDate = moment(document.getElementById('RefDate').value, 'D-M-YYYY').format('YYYYMMDD');
                       
                        dataSub.HealthUnitId = document.getElementById('HealthUnitId').value;
                        this.parentNode.cells[3].textContent =  parseInt(quantities.quantity) + parseInt( quantities.quantity_KDE ) ;
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
        jQuery('#elgdata tbody td.quan').on('shown', function (e, editable) {
            editable.input.clear();
        });
        
        
        
        
        
        function pedyGetMedicalTransactionQuantity(changedData, tdClicked) {
            let quantity;
            let quantity_KDE;
            let quantityType = tdClicked.id.split('-')[1];
            if (quantityType == 1) {
                quantity = changedData.value;
                quantity_KDE = tdClicked.parentNode.cells[2].textContent;
            }
            else {
                quantity_KDE = changedData.value; 
                quantity = tdClicked.parentNode.cells[1].textContent;
            }
            return {quantity: quantity, quantity_KDE: quantity_KDE};         
                
        }
        
    });
</script>
