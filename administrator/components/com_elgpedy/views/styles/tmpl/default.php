<?php
/**
 * @author e-logism
 * @copyright (c) 2011 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 2.0.0 2012-09-10
 * */
defined('_JEXEC') or die('Restricted access');
jimport("joomla.html.editor");
$k = 0;
?>
<form method="post" name="adminForm">
    <div id="editcell">
        <table class="adminlist" >
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo JText::_('COM_ALUMINCOCC_STYLE_FILE'); ?></th>

                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($this->cssFiles as $cssRow) {
                $cssFilePath = $cssRow[1]. DS . $cssRow[0];     
                $cssFile = $cssRow[0];
                ?>
                    <tr class="<?php echo "row" . $k; ?>" >
                        <td class="check-cell" >
                            <input type="radio" id="cb<?php echo $i ?>" name="cid[]" value="<?php echo $i ?>"  onclick="isChecked(this.checked)" />
                        </td>
                        <td>
                            <input type="hidden" id="fl<?php echo $i ?>" value="<?php echo $cssFilePath ?>"/><label for="cb<?php echo $i ?>" ><a href="index.php?option=<?php echo JRequest::getVar("option") . "&amp;view=styleedit&amp;controller=styles&amp;task=edit&amp;frontEnd=" . $this->frontEnd . "&amp;fl=" . urlencode($cssFilePath) . "&amp;ext=" . urlencode($this->ext) ; ?>" ><?php echo $cssFile; ?> </a></label>
                        </td>
                    </tr>
                <?php
                    $k = 1 - $k;
                    $i++;
                    }
                 unset($cssRow);
                ?>
            </tbody>
        </table>
    </div>
        <input type="hidden" name="task" value="" id="task" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="view" value="styleedit" />
        <input type="hidden" name="fl" id="fl" value="" />
        <input type="hidden" name="frontEnd" value="<?php echo ($this->frontEnd); ?>" />
        <input type="hidden" name="ext" value="<?php echo ($this->ext);?>" />
</form>