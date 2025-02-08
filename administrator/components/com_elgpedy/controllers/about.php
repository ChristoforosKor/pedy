<?php
/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.1 2012-09-12
**/

defined('_JEXEC') or die('Restricted access');
require_once __DIR__ . '/libraries/php/joomla/e-logism/contollers/controller.php';
class ElgPedyControllerAbout extends Controller {

    function execute() 
	{
		echo self::getViewWithModel(ComponentUtils::getAppData($this->getInput()))->render();
        // JRequest::setVar('view', 'about');
        // parent::display($cachable);
    }

}
