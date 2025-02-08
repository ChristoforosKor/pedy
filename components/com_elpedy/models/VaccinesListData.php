<?php
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\models;
defined('_JEXEC') or die('Restricted access');
use elogism\datatemplates\FrmBsTable;
use Joomla\Registry\Registry;
use JModelDatabase;
use components\com_elpedy\ComUtils;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
/**
 * Gets step list data
 * @author E-Logism
 */

class VaccinesListData extends JModelDatabase {   
    public function getState(): Registry {
        $state = parent::getState();
        if ( ! $this ->checkHealthUnit( $state -> get ( 'HealthUnitId', 0 )  ) ):
            Factory::getApplication() -> enqueueMessage(  Text::_('COM_EL_DATA_PERMISSION_ERROR_100'), 'warning' );
            return new Registry(['data' => [], 'total' => 0 ] );
        endif;
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        $query -> select(  'v.id, v.RefDate, v.birthday,  v.isMale, s.description as school, sc.description as schoolClass'  ) 
        -> from ( 'Vaccine_Patient v' )  
        -> innerJoin ( 'school s on v.school_id = s.school_id '
                . ' and v.HealthUnitId = ' . $state -> get ( 'HealthUnitId', 0 ) 
                . ' and  v.RefDate >= ' . $db -> quote( $state -> get ( 'RefDateFrom', 0 ) ) 
                . ' and v.RefDate <=' .$db -> quote ( $state -> get ( 'RefDateTo', 0 ) ) ) 
      
        -> innerJoin ('school_class sc on v.school_class_id = sc.school_class_id' )
        -> order( $state -> get('filter_order', 'RefDate, birthday, school, schoolClass, isMale') . ' ' . $state -> get('filter_order_Dir') ) ;
        
        return new Registry( FrmBsTable::getData($db, $query, $state -> get('limit_start'), $state -> get('limit') ) );
    }
    
    private function checkHealthUnit( $HealthUnitId )
    {
        if ( !trim($HealthUnitId) > 0 || !is_numeric( $HealthUnitId ) ):
            return false;
        endif;
        $huIds = array_column( ComUtils::getUserHealthUnits(), 'HealthUnitId' );
        if ( !in_array( $HealthUnitId , $huIds) ):
            return false;
        endif;
        return true;
    }
}
