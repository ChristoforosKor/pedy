<?php
/*------------------------------------------------------------------------
# com_ElgComponent e-logism
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Website: http://www.e-logism.gr
 
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');
  
?>
<?php 
if(count($this->missing) > 0 ): ?>
<h3><?php echo JText::_('COM_ELG_PEDY_DAYS_WITH_NO_ACTION'); ?></h3>
<div class="col-md-6 missing-dates">
	<?php foreach($this->missing as $missing):
	 echo ' <a  onclick="goToDetails(\'', ComponentUtils::getDateFormated($missing, 'Y-m-d','Ymd'), '\')" ><span class="label label-danger" >', ComponentUtils::getDateFormated($missing, 'Y-m-d', 'j/n'), '</span></a> ';
	endforeach; unset($missing); ?>
</div>

<?php endif; 


