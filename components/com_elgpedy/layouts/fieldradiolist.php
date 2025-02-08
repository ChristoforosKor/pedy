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
<fieldset id="<?php echo $displayData['id'] ?>" class="<?php $displayData['class']; ?> radio">
    <?php $cnt = count( $displayData['options'] );
                for ( $i= 0; $i < $cnt ; $i ++ ): ?>
       <div class="field-option-row">
        <input type="radio" name="<?php echo $displayData['name'] ?>" 
               value="<?php echo  $displayData['options'][$i] -> value?>" 
               id="<?php echo  $displayData['options'][$i] -> id . $i?>" <?php echo  ( $displayData['options'][$i] -> value === $displayData['value'] ? ' checked="checked"' : '' ) ?> />
        <label for="<?php echo $displayData['options'][$i] -> id . $i ?>"><?php echo $displayData['options'][$i] -> text ?> </label>
       </div>
    <?php
        endfor;
    ?>
</fieldset>