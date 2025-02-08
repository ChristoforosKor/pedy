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


<div class="clearfix">&nbsp;</div>
<table class="table table-condensed table-borderd">
	<caption><?php echo $key; ?>
	<tr>
	<?php 
		foreach($actDataItem as $actItem): ?>	
		<th><?php echo $actItem['1']; ?> </th>
	<?php endforeach; 
	unset($actItem); ?>
	</tr>
	<tr>
	<?php 
		foreach($actDataItem as $actItem): ?>
		<td id="dpd_<?php echo $actItem['0']; ?>" ><input type="hidden" name="MedicalTypeId[]" value="<?php echo $actItem['0']; ?>" /><input type="text" name="Quantity[]" /></td>
	<?php endforeach; 
	unset($actItem);
	?>
	</tr>
</table>


