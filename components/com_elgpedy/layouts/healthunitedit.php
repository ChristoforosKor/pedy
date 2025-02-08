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

<form role="form" method="post"action="<?php echo $this->formAction; ?>">
<fieldset class="col-sm-6">
<legend><?php echo JText::_('COM_ELGPEDY_UNIT_ORGANIC'); ?></legend>
<?php
foreach($this->form->getFieldset('healthunit_organic') as $field):
    if ($field->hidden):
        echo $field->input;
    else:
    ?>
    <div class="form-group">
        <?php echo $field->label, '<br />', $field->input ?>
    
	</div>
    <?php
    endif;
endforeach;
unset($field);
?>
</fieldset>

<fieldset class="col-sm-6">
<legend><?php echo JText::_('COM_ELGPEDY_UNIT_ADDRESS'); ?></legend>
<?php
foreach($this->form->getFieldset('healthunit_address') as $field):
    if ($field->hidden):
        echo $field->input;
    else:
    ?>
    <div class="form-group">
        <?php echo $field->label, '<br />', $field->input ?>
    
	</div>
    <?php
    endif;
endforeach;
unset($field);
?>
</fieldset>
<div class="clearfix">&nbsp;</div>
<div class="form-group">
<button class="btn-primary"><?php echo JText::_('COM_ELG_SUBMIT'); ?></button>
<a href="<?php echo JRoute::_('index.php?option=com_elgpedy&view=healthunits&Itemid=' . $this->state->get('Itemid', 0), false); ?>" class="btn pull-right" ><?php echo JText::_('COM_ELG_CANCEL'); ?></a>
</div>
</form>