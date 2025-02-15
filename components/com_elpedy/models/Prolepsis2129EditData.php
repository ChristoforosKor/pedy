<?php

namespace components\com_elpedy\models;
defined('_JEXEC') or die('Restricted access');
use components\com_elpedy\ComUtils;
use Joomla\Registry\Registry;
use JModelDatabase;

class Prolepsis2129EditData extends JModelDatabase {   
    
    public function getState(): Registry {
        $state = parent::getState();
        $id = $state -> get('id', 0);
        $data = [
            'prolepsis2129Data' => $this -> getItem( $id)
        ];
        $state -> set('data', $data);
        return $state;
    }   
    
    
    public function  getItem($pk=null) {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState('id');
        
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        $query->select('*')
                ->from("#__Prolepsis2129")
                ->where("id=$pk");
        return $db->setQuery($query)->loadObject();
    }
    
    
    
}
