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
require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
 
class ControllerData extends Controller{
    protected $formData = null;
    protected $model = null;
    protected $state = null;
    protected $appData = null;
    public function execute() {
        $input = JFactory::getApplication()->input;
        $this->appData = ComponentUtils::getAppData($input);
        $this->appData['RefMonth'] = $input->getInt('RefMonth', 0);
		if($this->appData['RefMonth'] === 0)
		{
			$this->appData['RefMonth'] = date('M');
		}
        $this->appData['RefYear'] = $input->getInt('RefYear', 0);
        if($this->appData['RefYear'] === 0)
		{
			$this->appData['RefYear'] = date('Y');
		}
		$this->appData['model'] = $this->appData['view'];
        echo Controller::getViewWithModel($this->appData)->render();
    }
}
