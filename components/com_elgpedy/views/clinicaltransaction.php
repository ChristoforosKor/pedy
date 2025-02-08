<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism 
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/data.php';
class ElgPedyControllerClinicalTransaction extends Data 
{
	private static $LAST_OLD_DATE = '2016-08-31'; // last date of old status. 
	private static $FIRST_NEW_DATE = '2016-09-01'; //first date of new status.
}
