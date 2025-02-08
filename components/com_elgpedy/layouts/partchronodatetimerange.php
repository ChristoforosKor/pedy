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
  require_once JPATH_COMPONENT_SITE . '/layouts/partchronoscripts.php';
?>

<form id="frmRedirect" method="post">
    <div class="col-sm-3" >
            <?php echo '<label class="control-label">', JText::_('COM_ELG_PEDY_UNIT'), '</label>',  $this->forms->commonForm->getInput('HealthUnitId'); ?>
    </div>
    <div class="form-group col-sm-3">
            <?php echo $this->forms->commonForm->getLabel('RefDateFrom'); ?>
            <div class="input-group date form_datetime"  data-date="" data-date-format="dd/mm/yyyy">
                    <?php echo $this->forms->commonForm->getInput('RefDateFrom'); ?>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>	
    </div>
    <div class="form-group col-sm-3">
            <?php echo $this->forms->commonForm->getLabel('RefDateTo'); ?>
            <div class="input-group date form_datetime"  data-date="" data-date-format="dd/mm/yyyy">
                    <?php echo $this->forms->commonForm->getInput('RefDateTo'); ?>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>	
    </div>
</form>
