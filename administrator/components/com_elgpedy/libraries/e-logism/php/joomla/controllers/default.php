<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 /**
  * Default controller.
  * @package libraries.e-logism.php.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class ControllerDefault extends JControllerBase
{
       
    public function execute() {
       $appData = $this->input->get('appData', null, 'ARRAY');
       $model = Factory::getModel($appData['componentname'], $appData['model'], new JRegistry($appData));
       $view = Factory::getView($appData['view'], $appData['componentname'], $model);
       $view->render();
    }
}
