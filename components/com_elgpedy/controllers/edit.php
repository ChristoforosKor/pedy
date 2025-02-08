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
 
class Edit extends Controller{
    
    protected $appData = null;
    public function execute() {
        $input = JFactory::getApplication()->input;
        $this->appData = ComponentUtils::getAppData($input);
        $this->appData['id'] = $input->getInt('id', 0);
        
        echo self::getViewWithModel($this->appData)->render();
    }
}
