<?php

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

class Prolepsis2129ListData extends JModelDatabase {   
    public function getState(): Registry {
        
        $userHU = ComUtils::getUserHealthUnits();
        $userHUIds = array_column($userHU, 'HealthUnitId');
        if (count($userHUIds) === 0 ) return new  Registry( ['res' => [], 'total' => 0] );
        $state = parent::getState();
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        
        $query -> select(  'p.*'  ) 
        -> from ( 'Prolepsis2129 p' )  
        -> order( $state -> get('filter_order', 'RefDate') . ' ' . $state -> get('filter_order_Dir', 'asc') ) ;
        $where = $this->makeWhereClause($state, $db, $userHUIds);
        if ($where !== '') {
            $query->where($where);
        }
        return new Registry( FrmBsTable::getData($db, $query, $state -> get('limit_start'), $state -> get('limit') ) );
    }
    
    private function makeWhereClause ($state, $db, $userHUIds) 
    {   
        
        $healthunit_id = $state->get('healthunit_id', 0);
        if ($healthunit_id === 0 ) {
            $where = ' p.healthunit_id in (' . implode(',', $userHUIds ) . ') '  ;
        }
        else {
            $where = ' p.healthunit_id  = ' . $db->quote($healthunit_id);
        }
//        $where = ' p.healthunit_id in (' . implode(',', $userHUIds ) . ') ';
        $and = ' and ';
        $RefDateFrom = $state->get('RefDateFrom', '');
        $RefDateTo = $state->get('RefDateTo', '');
        
        
        
        if ($RefDateFrom != '' ) {
            $where .= $and . " p.RefDate >= " . $db->quote($RefDateFrom);
            $and = " and ";
        }
        
        if ($RefDateTo != '' ) {
            $where .= $and . " p.RefDate <= " . $db->quote($RefDateTo);
            $and = " and ";
        }
        
        return $where;
    }
  
}
