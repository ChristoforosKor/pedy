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
class ControllerViewList extends Controller
{
    public function execute() {		
		$input = $this->input;
		$this->appData = ComponentUtils::getAppData($input);
		$order = $input->get('order',null,'ARRAY');
		$search = $input->get('search',null,'ARRAY');
		$this->appData['filter_order'] = ($order[0]['column'] == '' ? 1 : $order[0]['column']);                
		$this->appData['filter_order_Dir'] = $order[0]['dir'];
		$this->appData['limit'] = $input->getInt('length', 10);
		$this->appData['limitstart'] = $input->getInt('start', 0);
		$this->appData['search_value'] = $input->getString('search_value');
		$this->appData['draw'] = $input->getInt('draw');
        echo parent::getViewWithModel($this->appData)->render();
    }
}
