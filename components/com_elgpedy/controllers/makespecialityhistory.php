<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
class ElgPedyControllerMakeSpecialityHistory extends Controller
{
	public function execute() 
	{
		$appData = ComponentUtils::getAppData($this -> input);
		$model = Factory::getModel($appData['componentname'], $appData['model']);
		$state = new JRegistry($appData);
		$model -> setState($state);
		echo Factory::getView('elgpedy', 'makespecialityhistory', $model, 'json') -> render();
	}
}
