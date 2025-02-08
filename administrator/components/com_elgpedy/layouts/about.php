<?php defined('_JEXEC') or die('Restricted access');
/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.1 2012-02-22
**/
?>

<div>
    <a href="http://<?php echo $this->about->authorUrl ?>" target="_blank" title="<?php echo JText::_("COM_ELGPEDY_ABOUT") ?>" ><img src="<?php echo $this->logoImage ?>" alt="<?php echo JText::_("COM_ELGPEDY_ABOUT") ?>" /></a><br/>
    <h3><?php echo JText::_('COM_ELGPEDY');?></h3>
    <hr align="left" width="30%"><br/>
    <p>
        <?php echo JText::_('COM_ELGPEDY_VERSION') ?>: <?php echo $this->about->version . " (" . $this->about->creationDate . ")" ?><br/>
        <?php echo $this->about->copyright ?><br/><br/>
    </p>
    <p>
        <?php echo JText::_('COM_ELGDESCRIPTION') ?>: <?php echo JText::_('COM_ELGPEDY_DESCRIPTION') ?><br/>
    </p>
    <p>
        <?php echo JText::_("COM_ELGPEDY_DEVELOPED_BY") ?>: <a href="<?php echo $this->about->authorUrl ?>" target="_blank" style="font-weight:bold" ><?php echo $this->about->authorUrl ?></a><br/>
    </p>
    <p>
        <?php echo JText::_("COM_ELGPEDY_EMAIL_ADDRESS") ?>: <a href="mailto:<?php echo $this->about->authorEmail; ?>" ><?php echo $this->about->authorEmail; ?></a><br/>
    </p>
</div>
