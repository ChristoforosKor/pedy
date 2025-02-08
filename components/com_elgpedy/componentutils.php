<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once __DIR__ . '/libraries/php/joomla/e-logism/elogismjoomlautils.php';
 /**
  * Class f that holds static functions used by e-logism's components.
  * @package e-logism.joomla;
  * @author Christoforos J. Korifidis
  * 
  */


class ComponentUtils  extends ELogismJoomlaUtils
{
        public static $STATUS_ACTIVE = 1;
        public static $STATUS_MODIFIED = 2;
        public static $STATUS_DELETED = 3;
    
	public static function getAppData(JInput $input)
	{
		return $input->get('appData', array(), 'ARRAY');
	}
	
	public static function getDefaultFormPath()
	{
		return JPATH_COMPONENT_SITE . '/models/forms';
	}
	
	public static function getPedyDB()
	{
		$option = array();
		$option['driver']   = 'mysqli'; 		
		$option['host']     = 'localhost';
		$option['user']     = 'pedy';
		$option['password'] = 'byzvaG-1wohqe-nukgyx';
		$option['database'] = 'pedy';
		$option['prefix']   = ''; 
		return JDatabase::getInstance( $option );
	}
	
	public static function getDistrictIdBySelectedUnitId( $selectedUnitId) {
		return self::getPedyDB() ->setQuery("select HealthDistrictId from pedy.HealthUnit where HealthUnitId = $selectedUnitId ") -> loadResult();
	}
		
	public static function getUserHUIds()
	{
		
		
		$app = JFactory::getApplication();
		$s = $app->getUserState('userUnits');
		if(isset($s))
		{
			if(count($s) > 0)
			{
				$hasUnits = true;
			}
			else
			{
				$hasUnits = false;
			}
		}
		else
		{
			$hasUnits = false;
		}
		$db = self::getPedyDB();
		if(!$hasUnits)
		{
			
			$query = $db->getQuery(true);
			$db->setQuery($query);
			
			$query->clear();
		
			$query->setQuery('call sp_getUserHUId(' . JFactory::getUser()->id . ', 0)');
			
			$hu = $db->loadObjectList();
			$app->setUserState('userUnits', $hu );
		}
		$du = $app->getUserState('defaultUnitId');
		if(!isset($du))
		{
			$hud = $app->getUserState('userUnits');
			
			foreach($hud as $item)
			{
				if($item->HealthUnitId === $item->HUId)
				{
					$app->setUserState('defaultUnitId', $item->HealthUnitId);
					break;
				}
			}
			unset($item);
		}
		return $app->getUserState('userUnits');
	}
		
	public static function getDefaultUnitId()
	{
		$app =JFactory::getApplication();
		$du = $app->getUserState('defaultUnitId');  
		
		if($du == null)
		{
			self::getUserHUIds();
			return  $app->getUserState('defaultUnitId');  
		}
		else
		{
			return $du;
		}
		
	}
	
	public static function getUserHUOnlyIds()
	{
		$hs = self::getUserHUIds();
		$huids = array();
		foreach($hs as $value)
		{
			$huids[] = $value->HealthUnitId;	
		}
		return $huids;
	}
public static function toggleMenus($HealthUnitId) 
	{
		$healthUnitTypeId = self::getHealthUnitType($HealthUnitId);
		$menu = JFactory::getApplication()->getMenu();
		$item = JFactory::getApplication() -> getMenu() -> getItem(112);
		$document = JFactory::getDocument();   
		switch ($healthUnitTypeId):
		
                                                case 10:   //spmp
				$style = ".item112 {display: none!important} .item114{display: block!important} .item119{display: none!important}";
			break;
                                                case 11: // kpcy
                                                case 13: // kcy
			
				$style = ".item112 {display: none!important} .item114{display: none!important} .item119{display: block!important}";
                                                break;
			default:
				$style = ".item112 {display: block!important} .item114{display: none!important} .item119{display: none!important}";
		endswitch;
	
		 $document->addStyleDeclaration ($style);
	}
	
	public static function getHealthUnitType($HealthUnitId)
	{
            $res = null;
            foreach(JFactory::getApplication()->getUserState('userUnits') as $userUnit)
            {
                    if($userUnit->HealthUnitId ==  $HealthUnitId)
                    {
                            $res = $userUnit->HealthUnitTypeId;
                    }
            } 
            unset($userUnit);
            return $res;
	}
        
        
        public static function getClinicsRelInicidents(array $incidents, array $clinics) :array 
        {
            $res = [];
            forEach( $clinics  as $clinic):
                $res = array_merge($res, self::getClinicRelIncidents($incidents, $clinic -> ClinicId) );
            endforeach;
            unset($clinic);
            return $res;
        }
        
        public static function getClinicRelIncidents( array $incidents, string $clinicId ) : array
        {
            return array_filter ( $incidents, function ( $val ) use ( $clinicId) {
                return $val -> ClinicTypeId === $clinicId;
            });
        }
        
        public static function getCheckers($db, $from, $healthUnitId, $to = null)
        {
            if ( $to === null ):
                $to = $from;
            endif;
            $query = $db -> getQuery();
            $query -> clear();
            $query -> select('sum(Quantity) as Quantity')
            -> from('ClinicTransaction')
            ->  where('StatusId = ' . ComponentUtils::$STATUS_ACTIVE . ' and RefDate >= ' . $db -> quote( $from ) . ' and RefDate <= ' . $db -> quote ( $to ) . ' and HealthUnitId = ' . $db -> quote( $healthUnitId ) . ' and ClinicIncidentId = 4');
            $db -> setQuery( $query );
            $checker = $db -> loadResult();
            return ( $checker === null ? 0 : $checker );
        }
}
