<?php
/**
 * @author e-logism
 * @copyright (c) 2011 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.0 2012-02-19
 **/
    defined('_JEXEC') or die('Restricted access');
    jimport("joomla.html.editor");
   
    JHTML::_('behavior.formvalidation');
?>
<form method="post" name="adminForm">
    <div id="editcell">
        <?php
        $editor = new JEditor();
        echo $editor->display("extstyle", $this->data, "80%", "400px", "80", "50", false );
         ?>
    </div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="frontEnd" value="<?php echo JRequest::getVar('frontEnd',"1") ?>" />
    <input type="hidden" name="view" value="styleedit" />
    <input type="hidden" name="fl" value="<?php echo JRequest::getVar("fl") ?>" />
    <input type="hidden" name="ext" value="<?php echo JRequest::getVar("ext","")?>" />

</form>