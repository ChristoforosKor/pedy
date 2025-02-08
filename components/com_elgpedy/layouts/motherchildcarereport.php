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
$this->missing = $this->clinicMissing;

require JPATH_COMPONENT_SITE . '/layouts/clinicaltransactionreport.php';
echo '<div class="clearfix">&nbsp;</div>';
$this->missing = $this->prolepsisMissing;
require JPATH_COMPONENT_SITE . '/layouts/prolepsiscommunityreportvertical.php';