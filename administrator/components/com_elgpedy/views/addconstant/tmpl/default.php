<?php
/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
    defined('_JEXEC') or die('Restricted access');
    JHTML::_('behavior.formvalidation');
?>
<div>
    <h1><?php echo $this->inilang ?></h1>
     <form action="index.php"  method="post" name="adminForm" id="adminForm">
        <table class="admintable">
            <tr>
                <td width="100" align="right" class="key"><label for="key0" ><?php echo JText::_('COM_ALUMINCOCC_LABEL_FIELD')?></label></td>
                <td>
         <?php if($this -> newLevel != "" ){
                echo "<label>" . $this -> newLevel . "</label>";
                echo "<input class=\"inputbox\" type=\"hidden\" name=\"key\" id=\"key0\" size=\"25\" value=\"" . $this -> newLevel . "\" />";
         }else{
               // echo  "<input class=\"inputbox \" type=\"text\" name=\"key\" id=\"key0\" size=\"25\" value=\"\" />";
         }
         ?>
         </td>
            </tr>
            <tr>
                <td width="100" align="right" class="key"><label for="val0" ><?php echo JText::_('COM_ALUMINCOCC_CONSTANT_FIELD')?></label></td>
                <td><input class="inputbox required" type="text" name="val" id="val0" size="25" value="" /></td>
            </tr>
        </table>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="option" value="<?php echo JRequest::getVar("option")?>" />
            <input type="hidden" name="view" value="langs" />
<!--            <input type="hidden" name="controller" value="langs" />-->
            <input type="hidden" name="lang" value="<?php echo JRequest::getVar("lang")?>" />
            <input type="hidden" name="fl" value="<?php echo JRequest::getVar("fl") ?>" />
    </form>
</div>



