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
class ControllerPedy extends Controller
{
    protected $appData = null;
        
    function __construct(\JInput $input = null, \JApplicationBase $app = null) 
	{
		parent::__construct();
		//$app = ;
		$input = JFactory::getApplication()->input;
        $this->appData = ComponentUtils::getAppData($input);
        $healthUnitId = $input->getInt('HealthUnitId', 0);
       
        if($healthUnitId == 0)
        {
//            switch(JFactory::getApplication()->getMenu()->getActive()->id)
//            {
//                case 12
//            }
            
            if(JFactory::getApplication()->getUserState('lastUnit') > 0) {
                $healthUnitId = JFactory::getApplication()->getUserState('lastUnit');
              
            }
            else {
                $healthUnitId =  ComponentUtils::getDefaultUnitId('defaultUnitId');
                JFactory::getApplication()->setUserState('lastUnit', $healthUnitId);
              
            }
        }
        else
        {	
          
            $correctUnit = false;
            $userUnits = ComponentUtils::getUserHUIds();
            foreach($userUnits as $unit)
            {
                    if($unit->HealthUnitId == $healthUnitId)
                    {
							
                            $correctUnit = true;
                            break;
                    }
            }
            unset($unit);
            if($correctUnit == false)
            {
              
                $healthUnitId = ComponentUtils::getDefaultUnitId();
            }
            JFactory::getApplication()->setUserState('lastUnit', $healthUnitId);
          
        }
        
        $this->appData['HealthUnitId'] = $healthUnitId;
        ComponentUtils::toggleMenus($healthUnitId);
	}
}
