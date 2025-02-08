<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');

/**

 * @todo Αποθήκευση αρχικών προτάσεων
 * @todo Αποθήκευση τροποποιήσεων ήδη αποθηεκκυμένων προτάσεων
 * @todo Να εμφανίσω το error στην περίπτωση που δεν έχω δικαίωμα πρόσβασης. 
 */
?>
<script type="text/javascript" src="media/node_modules/bootstrap-table/dist/bootstrap-table.min.js"></script>
<script type="text/javascript" src="media/com_elgpedy/js/select2.js"></script>


<section id="elgdata"  >
   
    <div class="clearfix"></div>
    <span style="display:none" id="uncommittedContainer" class="badge">Προς αποθήκευση <span class="badge alert-danger" id="uncommitted" >0</span></span><br />
    <table id="atTable"></table>
    <div class="clearfix"></div>
    <button type="button" class="btn btn-primary hidden-print" id="btnSave"><?php echo JText::_('COM_ELG_SAVE'); ?></button>

</section>
<script type="application/javascript">   

    var unContainer = document.getElementById('uncommittedContainer');
    var unCommittedBadge = document.getElementById('uncommitted');
    var optStatuses = <?php echo json_encode($this->optStatus); ?>;
    var optHealthUnits = <?php echo json_encode($this->optHUs); ?>;
</script>
<script type="application/javascript" src="media/com_elgpedy/js/personelattendancebook.js" ></script>
