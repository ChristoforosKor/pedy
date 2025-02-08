<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/controllerpedy.php'; 
require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/factory.php'; 
class ElgPedyControllerAdiologioReport extends ControllerPedy 
{
     public function execute()
     {
        $input = $this->getInput();
        $filters = [];
        $filters['PersonelId'] = $input->getString('PersonelId', '');
        $filters['StartDate'] = ComponentUtils::getDateFormated($input->getString('StartDate', ''), 'd/m/Y', 'Y-m-d');
        $filters['EndDate'] = ComponentUtils::getDateFormated($input->getString('EndDate', ''), 'd/m/Y', 'Y-m-d');
       
        $this->state = new JRegistry();
        $this->state->set('appData', $this->appData);
        $this->state->set('filters', $filters);
        $model = Factory::getModel('elgpedy', 'adiologioreport', $this->state);
        $view =  Factory::getView('elgpedy', 'adiologioreport', $model, $this->appData['format']);
        echo $view->render();
     }
}
