<?php
/*------------------------------------------------------------------------
# com_elgalocrm - e-logism library.
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr 
----------------------------------**/
    defined('_JEXEC') or die('Restricted access');
?>
<div class="elg-column <?php echo $this->buttonsClasses[$htmlIndex] ?>" >
    <div class="formelm" >
        <button type="<?php echo $this->buttonsTypes[$htmlIndex] ?>" onclick="<?php echo $this->buttonsActions[$htmlIndex]; ?>" >
            <?php echo $this->buttonsTexts[$htmlIndex] ; ?>
        </button>
    </div>
</div>
<div class="elg-column <?php echo $this->linksClasses[$htmlIndex] ?>" >
    <div class="formelm returnTo" >
            <a href ="<?php echo $this->linksUrls[$htmlIndex] ?>" ><?php echo $this->linksTexts[$htmlIndex]; ?></a>
    </div>
</div>

