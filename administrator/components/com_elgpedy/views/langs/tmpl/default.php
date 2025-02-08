<?php
/**
 * @author e-logism
 * @copyright (c) 2011 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.1 2012-02-24
 **/
    defined('_JEXEC') or die('Restricted access');
    include_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS . "JoomlaUtilities.php");
    jimport("joomla.html.html.select");
    jimport("joomla.html.toolbar.button.confirm");
   
  
    $row=0;
    $recs = count($this->filesNames);
    $recsEx = count($this->existsFiles);
    
    JHTML::_('behavior.formvalidation');
?>  
<form method="post" name="adminForm" action="<?php echo JRoute::_("index.php?option=" . JRequest::getVar("option") ) ?>" >
    <div id="editcell">
            <table class="adminlist" >
                <thead>
                    <tr>
                        <th></th>
                        <th><?php echo JText::_('COM_ALUMINCOCC_LANGUAGE'); ?></th>
                        <th><?php echo JText::_('COM_ALUMINCOCC_LANG_FILE'); ?></th>
                        <th><?php if ($this->hasEmpty == 1) echo JText::_('COM_ALUMINCOCC_ACTION') ?></th>
                    </tr>
                </thead>
                <?php if ($recs > 0 && $recsEx > 0) {
                        $k = 0;
                        for ($row = 0; $row < $recs; $row++) {
                ?>
                    <tr class="<?php echo "row" .  $k ?>" >
                        <td class="check-cell" >
                            <?php
                            if( $this->filesNames[$row]["tag"] != "" && $this->filesNames[$row]["isFileWriteable"]){ ?>
                                <input type="radio" id="cb<?php echo $row ?>" name="cid[]" value="<?php echo $row ?>"  onclick="isChecked(this.checked)" />
                                <input type="hidden" name="fl<?php echo $row ?>" id="fl<?php echo $row ?>"  value="<?php echo $this->filesNames[$row]["langPath"]?>"  />
                                <input type="hidden" name="lang<?php echo $row ?>" id="lang<?php echo $row ?>" value="<?php echo $this->filesNames[$row]["tag"]?>"  />
                            <?php }else{  ?>
                                 <input type="hidden" name="lang<?php echo $row ?>" value="<?php echo $this->filesNames[$row]["tag"]?>"  />
                           <?php } ?>
                        </td>
                        <td>
                            <?php
                            if( $this->filesNames[$row]["tag"] != "" && $this->filesNames[$row]["isFileWriteable"]){ ?>
                            <label for="cb<?php echo $row ?>" ><?php echo ($this->filesNames[$row]["tag"]) ?></label>
                            <?php }else { echo ($this->filesNames[$row]["tag"]);} ?>
                        </td>
                        <?php
                        if ($this->filesNames[$row]["langPath"] == "") {
                            if ($this->filesNames[$row]["isDirWriteable"]) {
                                $optsData = array();
                                $optsData[] = array("",JText::_('COM_ALUMINCOCC_SELECT_FILE'));
                                foreach($this->filesNames as $fileName){
                                   if($fileName["langFile"]==$this->filesNames[$row]["langFile"] && $fileName["tag"] != $this->filesNames[$row]["tag"] )
                                        $optsData[] = array($fileName["langPath"], $fileName["fileName"]);
                                }
                                $options = JoomlaUtilities::htmlOptions( $optsData);
                                $dropdown = JHTML::_('select.genericlist', $options, 'tmplLanguage' .$row, 'class="inputbox"', 'value', 'text', "");
                                if($this->canDo->get('core.create'))
                                {
                                    $bar = new JToolBar();
                                    $bar->appendButton("standard","copy",JText::_('COM_ALUMINCOCC_COPY_FILE') , "ddn" . $row, false);
                                }
                                    ?>
                                <td><?php echo "\"<span style=\"font-weight:bold\" >" . $this->filesNames[$row]["fileName"] . "\": </span>" . JText::_('COM_ALUMINCOCC_COPY_LANG_FILE') . "<br />" . $dropdown ?></td>
                                <td class="action-cell" >
                                    <?php
                                        unset($fileName);
                                        if($this->canDo->get('core.create'))
                                        {
                                            echo($bar->render());
                                        }
                                    ?>
                                </td>
                            <?php } else { ?>
                                <td colspan="2" ><?php echo (JText::_("COM_ALUMINCOCC_LANGFOLDER_NOT_WRITEABLE")) ?></td>
                                <?php
                            }
                        } else {
                            if ($this->filesNames[$row]["isFileWriteable"]) {?>
                                <td>
                                    <a href="index.php?option=<?php echo $this->option . "&view=langs&controller=langs&task=langs.edit&lang=" . $this->filesNames[$row]["tag"] . "&fl=" . urlencode($this->filesNames[$row]["langPath"])  ?>"  ><?php echo JPATH::clean($this->filesNames[$row]["fileLabel"], DS) ?></a>
                                </td>
                                <td class="action-cell" >
                                </td>
                                <?php
                                } else {?>
                                <td colspan="2" >
                                <?php
                                    echo JText::_("COM_ALUMINCOCC_LANGFILE_NOT_WRITEABLE");
                                    }
                                ?>
                                </td>

                            <?php }?>
                    </tr>
                <?php $k = 1 - $k;
                    }
                    }?>
            </table>
            <?php
        if ($recs <= 0) {
            JError::raiseWarning(504, JText::_("COM_ALUMINCOCC_NO_FILES_FOUND"));
        } elseif ($recsEx <= 0) {
            JError::raiseWarning(504, JText::_("COM_ALUMINCOCC_NO_EXISTING_FILES_FOUND"));
        }
        ?>
    </div>
     <input type="hidden" name="task" value="" />
     <input type="hidden" name="langDrop" id="langDrop" value="" />
     <input type="hidden" name="fl" id="fl"  value="" />
     <input type="hidden" name="lang"  id="lang" value="" />
     <input type="hidden" name="frontEnd" value="<?php if($this->frontEnd) echo 1; else echo 0; ?>" />
     <input type="hidden" name="boxchecked" value="0" />

     
      <?php echo JHtml::_('form.token'); ?>
 </form>