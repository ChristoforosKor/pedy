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

class ProlepsisListData extends JModelDatabase {   
    public function getState(): Registry {
        
        $state = parent::getState();
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        
        $query -> select(  'p.id, p.RefDate, e.exam_center, p.vials_received, p.samples_to_hc, p.result_negative, p.result_positive_hpv16, p.result_positive_hpv18, p.result_positive_to_pap_negative'  ) 
        -> from ( 'Prolepsis p' )  
        -> innerJoin ( 'ExamCenter e on e.id = p.exam_center_id') 
        -> order( $state -> get('filter_order', 'RefDate, exam_center') . ' ' . $state -> get('filter_order_Dir', 'asc') ) ;
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
        $exam_center_id = $state->get('exam_center_id', 0);
        $RefDateFrom = $state->get('RefDateFrom', '');
        $RefDateTo = $state->get('RefDateTo', '');
        
        if ($exam_center_id > 0 ) {
            $where .= $and . " p.exam_center_id = " . $db->quote($exam_center_id);
            $and= " and ";
        }
        
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
