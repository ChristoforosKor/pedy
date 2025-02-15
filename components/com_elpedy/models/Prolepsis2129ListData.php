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
        
        $state = parent::getState();
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        
        $query -> select(  'p.*'  ) 
        -> from ( 'Prolepsis2129 p' )  
        -> order( $state -> get('filter_order', 'RefDate') . ' ' . $state -> get('filter_order_Dir', 'asc') ) ;
        $where = $this->makeWhereClause($state, $db);
        if ($where !== '') {
            $query->where($where);
        }
        return new Registry( FrmBsTable::getData($db, $query, $state -> get('limit_start'), $state -> get('limit') ) );
    }
    
    private function makeWhereClause ($state, $db) 
    {   
        $where = '';
        $and = '';
//        $exam_center_id = $state->get('exam_center_id', 0);
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
