<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');
  //JFactory::getApplication()->getUserState('userUnits' ); 
  
 require_once  JPATH_COMPONENT_SITE . '/layouts/partchronomenubehavior.php';
?>
 <div class="form-group">
        <?php echo $this -> commonForm -> getLabel('HealthUnitId'), $this -> commonForm -> getInput('HealthUnitId'); ?>
</div>
<div class="form-group">
        <?php echo $this -> commonForm->getLabel('RefDateFrom'),  $this -> commonForm->getInput('RefDateFrom'); ?>	
</div>
<div class="form-group">
        <?php echo $this -> commonForm->getLabel('RefDateTo'), $this -> commonForm -> getInput('RefDateTo'); ?>
</div>
