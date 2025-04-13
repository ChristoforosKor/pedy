<?php

namespace components\com_elpedy;

/**
 * @copyright (c) 2018, e-logism  dextera consulting
 * @license http://e-logism.gr/license.pdf
 * 
 */
defined('_JEXEC') or die('Restricted access');

use JDatabaseDriver;
use Joomla\CMS\Factory;

/**
 * Functions specific to component
 * 
 */
class ComUtils {

    public static function getPedyDB() {
        $option = array();
        $option['driver'] = 'pdomysql';
        $option['host'] = 'localhost';
        $option['user'] = 'pedy';
        $option['password'] = 'byzvaG-1wohqe-nukgyx';
        $option['database'] = 'pedy';
        $option['prefix'] = '';
        return JDatabaseDriver::getInstance($option);
    }

    public static function getUserHealthUnits() {


        $app = Factory::getApplication();
        $s = $app->getUserState('userUnits');
        if (isset($s)) {
            if (count($s) > 0) {
                $hasUnits = true;
            } else {
                $hasUnits = false;
            }
        } else {
            $hasUnits = false;
        }
        $db = self::getPedyDB();
        if (!$hasUnits) {

            $query = $db->getQuery(true);
            $db->setQuery($query);

            $query->clear();

            $query->setQuery('call sp_getUserHUId(' . Factory::getUser()->id . ', 0)');

            $hu = $db->loadObjectList();
            $app->setUserState('userUnits', $hu);
        }
        $du = $app->getUserState('defaultUnitId');
        if (!isset($du)) {
            $hud = $app->getUserState('userUnits');

            foreach ($hud as $item) {
                if ($item->HealthUnitId === $item->HUId) {
                    $app->setUserState('defaultUnitId', $item->HealthUnitId);
                    break;
                }
            }
            unset($item);
        }
        return $app->getUserState('userUnits');
    }

    public static function getDefaultUnitId() {
        $app = Factory::getApplication();
        $du = $app->getUserState('defaultUnitId');

        if ($du == null) {
            self::getUserHealthUnits();
            return $app->getUserState('defaultUnitId');
        } else {
            return $du;
        }
    }
    
    public static function getCurrentUser() {
        return Factory::getUser();
    }

}
