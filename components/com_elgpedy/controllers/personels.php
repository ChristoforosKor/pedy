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
class ElgPedyControllerPersonels extends Controller
{
     public function execute() {		
        $input = $this->input;
        $this->appData = ComponentUtils::getAppData($input);
	$this->appData['filter_order'] = $input -> getCmd('sort', 'FatherName'); //($order[0]['column'] == '' ? 1 : $order[0]['column']);                
        $this->appData['filter_order_DIR'] = $input -> getCmd('order', 'asc'); //$order[0]['dir'];
	$this -> appData['limit'] = $input -> getInt('limit', 10);
        $this -> appData['limitstart'] = $input -> getInt('offset', 0);   
        $this -> appData['search'] = $input -> getString('search', '');
        $this -> appData['statusId'] = str_replace('.', ',', $input -> getCmd('statusId', 1) );
        
        //tax number come from personel edit page
        $this -> appData['trn'] = $input -> getCmd('trn', '');
        
        // social security nuber come from personnel page
        $this -> appData['amka'] = $input -> getCmd('amka', '');
        
        // whether to search on all helath units or only to thos thwe user has access. Used with validations like amka etc.
        $this -> appData['all'] = $input -> getInt('all', 0);
        
        echo parent::getViewWithModel($this->appData)->render();
    }
}
