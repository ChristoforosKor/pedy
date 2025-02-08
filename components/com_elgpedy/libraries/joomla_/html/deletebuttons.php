<?php
/*------------------------------------------------------------------------
# com_elgalocrm - e-logism job agency
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr
 
----------------------------------**/
    defined('_JEXEC') or die('Restricted access');

?>
<div>
    <form method="post" action="<?php echo $this->deleteFormAction; ?>" >
        <?php echo JHtml::_('form.token'); ?>
        <button style="float:left" ><?php echo JText::_("JYES") ?></button>
    </form>
    <form method="post"  action="<?php echo $this->cancelDeleteFormAction ?>" >
        <button><?php echo JText::_('JNO') ?></button>
    </form>
</div>