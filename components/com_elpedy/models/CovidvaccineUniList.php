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

class CovidvaccineUniList extends JModelDatabase {   
    
    
    public function getState() {
      
        $state = parent::getState();
        $task = $state -> get('task', 'data');
        $dataDB = ComUtils::getPedyDB();
        $query = $dataDB ->getQuery(true);
        $data = [];
        if ( $task === 'html') {
            $data["attributes"] = $this ->getVaccineAttributes($dataDB, $query);
        }
        $state -> set("data", $data);
        parent:: setState($state);
        return parent::getState();     
    }
    
    
    
    public function getVaccineAttributes( $db, $query) {
        $query -> clear();
        $query -> select ( "CovidVaccineId, CovidVaccineDesc as label, ordering")
                -> from ("CovidVaccine")
                -> order ("ordering");
                
        return $db -> setQuery ( $query ) -> loadAssocList();
    }  
    
    
}
