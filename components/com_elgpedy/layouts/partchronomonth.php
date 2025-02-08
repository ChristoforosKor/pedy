<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');
  JFactory::getApplication()->getUserState('userUnits' ); 
?>
<script type="text/javascript">
     var unitsUrls = {};
    <?php require JPATH_COMPONENT_SITE . '/layouts/partchronomenubehavior.php'; ?>
    jQuery(document).ready(function(){
        document.getElementById('RefMonth').onchange = elgGetFormData;
        document.getElementById('RefYear').onchange = elgGetFormData;
        document.getElementById('HealthUnitId').onchange = function() {location.href= unitsUrls[this.value] + '&HealthUnitId=' + document.getElementById('HealthUnitId').value + '&RefMonth=' + document.getElementById('RefMonth').value + '&RefYear=' + document.getElementById('RefYear').value;}
    });
   
</script>
<div class="col-sm-3" >
	<label class="control-label"><?php echo JText::_('COM_ELG_PEDY_UNIT'), '</label>',  $this->forms->commonForm->getInput('HealthUnitId'); ?>
</div>
<div class="col-sm-3" >
	<?php echo '<label class="control-label" for="RefYear">', JText::_('COM_ELG_PEDY_YEAR'), '</label>',  $this->forms->commonForm->getInput('RefYear'); ?> 
</div>
<div class="col-sm-3" >
	<?php echo '<label class="control-label" for="RefMonth">', JText::_('COM_ELG_PEDY_MONTH'), '</label>', $this->forms->commonForm->getInput('RefMonth'); ?> 
</div>

