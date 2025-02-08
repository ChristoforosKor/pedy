<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once __DIR__ . '/controller.php';
 /**
  * Default controller.
  * @package libraries.e-logism.php.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class ControllerDefault extends  Controller
{
    
    public function execute() {
		echo self::getViewWithModel(ComponentUtils::getAppData($this->getInput()))->render();
    }
}