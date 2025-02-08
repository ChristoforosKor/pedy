<?php
/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.0 2012-02-19
 **/
    defined('_JEXEC') or die('Restricted access');
    
    JHTML::_('behavior.formvalidation');
?>
<form onsubmit="return false" class="form-validate" action="index.php?option=<?php echo JRequest::getVar( 'option' ); ?>&view=langedit&controller=langs&lang=<?php echo JRequest::getVar( 'lang' ); ?>" method="post" name="adminForm" id="adminForm">
<div id="editcell">
    <h1><?php echo $this->inilang ?></h1>

        <table class="adminlist">
            <thead>
                    <tr>
                        <th class="check-cell"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->data); ?>);" /></th>
                        <th style="width:30%"><?php echo JText::_('COM_ALUMINCOCC_LANGUAGE'); ?></th>
                        <th style="width:65%" ><?php echo JText::_('COM_ALUMINCOCC_LANG_CONSTANT'); ?></th>
                    </tr>
                </thead>
            <?php
                $k =0;
                $i= 0;
                foreach($this->data as $row){
                    if(trim($row) != ''){
                    $checked = JHTML::_('grid.id', $i, $i  );
                    $datarow = explode("=", $row);
            ?>
            <tr class="<?php echo "row" .  $k ?>" >
                <td style="text-align:center"><?php if ($datarow[0] != "COM_ALUMINCOCC_LBL_LEVEL0" && $datarow[0] != "COM_ALUMINCOCC_LBL_TYPE" && $datarow[0] != "COM_ALUMINCOCC_INPT_SELECT" && $datarow[0] != "COM_ALUMINCOCC_INPT_SEARCH" ) echo $checked; ?></td>
                <td class="key"><label for="val<?php echo $i ?>" ><?php echo $datarow[0] ?></label></td>
                <td><input class="inputbox" type="hidden" name="key[]" value="<?php echo $datarow[0];?>" /><input class="inputbox required" style="width:95%" type="text" name="val[]" id="val<?php echo $row ?>"  value="<?php  echo preg_replace('/"$/',"",preg_replace('/^"/',"",$datarow[1])) ; /** echo str_replace('"',"&quot;",preg_replace('/"$/',"",preg_replace('/^"/',"",$datarow[1]))) ; **/?>" /></td>
            </tr>
          <?php
                $k = 1 - $k;
                $i++;
              }
            }
          ?>

        </table>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="fl" value="<?php echo JRequest::getVar("fl") ?>" />
    </div>
</form>
