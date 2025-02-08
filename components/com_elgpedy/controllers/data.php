<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
// require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php'; 
require_once JPATH_COMPONENT_SITE . '/controllers/controllerpedy.php'; 
class Data extends ControllerPedy
{
    protected $formData = null;
    protected $model = null;
    protected $state = null;
    public function execute() {
		
		 $input = $this->getInput(); //$app->input;
        $this->appData['RefDate'] =  ComponentUtils::getDateFormated(($input -> getInt('RefDate', 0) === 0 ? date('Ymd') : $input -> getInt('RefDate', 0)), 'Ymd', 'Y-m-d');
	$this->appData['RefDateTo'] =  ComponentUtils::getDateFormated(($input -> getInt('RefDateTo', 0) === 0 ? date('Ymd'): $input -> getInt('RefDateTo', 0)), 'Ymd', 'Y-m-d');
        $this->appData['RefDateFrom'] =  ComponentUtils::getDateFormated(($input->getInt('RefDateFrom',0) ===0 ? date('Ymd'): $input->getInt('RefDateFrom',0)), 'Ymd', 'Y-m-d');
        $this->appData['start'] = $input->getString('start', '');
        $this->appData['end'] = $input->getString('end', '');
        if($this->appData['model'] == ''):
			$this->appData['model'] = $this->appData['view'];
        endif;
       
        $this->appData['RefMonth'] = $input->getInt('RefMonth', 0);
        $this->appData['RefYear'] = $input->getInt('RefYear', 0);
        if($this->appData['RefMonth'] == 0 || $this->appData['RefYear'] == 0)
        {
                $d =  date_create(date('Y-m-1')); 
                $this->appData['RefMonth'] = $d->format('m');
                $this->appData['RefYear'] = $d->format('Y');
        }
		//var_dump($this -> appData);
		if($input -> getCmd('ctype', '') == 'input' ): 
			
			$this -> input -> set( ($input -> getCmd('inputVar', '') === '' ? $input -> getCmd('view') . '.' . $input -> getCmd('format') . '.' . $input -> getCmd('layout'): $input -> getCmd('inputVar', '')), Controller::getViewWithModel($this->appData)->render() ) ;
		else:
			echo Controller::getViewWithModel($this->appData)->render();
		endif;
    }	
}
