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
use components\com_elpedy\ComUtils;
use Joomla\Registry\Registry;
use JModelDatabase;
/**
 * Gets step list data
 * @author E-Logism
 */

class ProlepsisEditData extends JModelDatabase {   
    
    public function getState(): Registry {
        $state = parent::getState();
        $id = $state -> get('id', 0);
        $data = [
            'prolepsisData' => $this -> getItem( $id)
        ];
        $state -> set('data', $data);
        return $state;
    }   
    
    
    public function  getItem($pk=null) {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState('id');
        
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        $query->select('*')
                ->from("#__Prolepsis")
                ->where("id=$pk");
        return $db->setQuery($query)->loadObject();
    }
    
    
    
}
