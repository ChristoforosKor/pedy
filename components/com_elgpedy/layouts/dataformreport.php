<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');
JText::script('COM_ELG_PEDY_NEW_SUBMITION');
JText::script('COM_ELG_PEDY_EDIT_DATA');
?>
 <h2><?php echo JFactory::getApplication()->getMenu()->getActive()->title;?></h2>
<div class="clearfix">&nbsp;</div>
<script type="text/javascript"src="media/com_elgpedy/js/bootstrap-editable.min.js"></script>
<div class="elg" >
	<div class="clearfix">&nbsp;</div>
        <div>
                <?php require $this->header; ?>
        </div>
        <div class="clearfix">&nbsp;</div>
        <div class="pedy-form-data" >
            <?php require $this->dataLayout; ?>
            <div class="clearfix"></div>
        </div>
        <div class="loading-indicator" style="display:none" ><img src="media/com_elgpedy/images/loader_128_128.gif" /></div> 
   
</div>
	
<div class="modal fade" id="modalValidate" tabindex="-1" role="dialog" aria-labelledby="ΠΡΟΣΟΧΗ!!!" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">ΛΑΘΟΣ ΔΕΔΟΜΕΝΑ</h4>
            </div>
            <div class="modal-body">
                <h3>Παρακαλώ καταχωρείστε μόνο αριθμούς</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- button type="button" class="btn btn-primary">Save changes</button -->
        </div>
    </div>
  </div>
<form id="sdtForm" method="post" action="<?php echo $this->submitUrl; ?>" >
	<input name="HealthUnitId" type="hidden" id="detHUID"  />
	<input name="RefDate"  type="hidden" id="detRefDate" />
</form>
<script type="text/javascript">
	function goToDetails(refDate){
		document.getElementById('detHUID').value = document.getElementById('HealthUnitId');
		document.getElementById('detRefDate').value = refDate;
		document.getElementById('sdtForm').submit();
	}
</script>