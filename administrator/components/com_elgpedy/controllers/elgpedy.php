<?php
/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.1 2012-09-12
**/

defined('_JEXEC') or die('Restricted access');

class ElgPedyControllerElgPedy extends JControllerBase 
{
    public function execute() {
       $appData = $this->input->get('appData', null, 'ARRAY');
       $model = Factory::getModel($appData['componentname'], 'about', new JRegistry($appData));
       $view = Factory::getView($appData['componentname'], 'about',  $model);
       $view->setLayout('about');
       $view->render();
    }

}
