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
// use elogism\datatemplates\FrmBsTable;
use Joomla\Registry\Registry;
use JModelDatabase;
// use components\com_elpedy\ComUtils;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
/**
 * Gets step list data
 * @author E-Logism
 */

class CovidattendancySaveData extends JModelDatabase {   
   
    
    public function setState(Registry $state)
    {
        $task = $state -> get('task', 'savehead');
        if ( $task === 'savehead') {
            $this -> saveHead($state);
        }
        elseif ( $task == 'savedetails') {
            $this ->saveDetails($state);
        }
        elseif ( $task == 'delete') {
            $this ->deleteRecord($state);
        }
    }
    
    protected function saveHead(Registry $state) {
           
        $tbCovidAttendancy = Table::getInstance('covidattendancyhead');
                
        $data = $state -> toArray();
        
        if ( $data['id']  == 0 ) {
            
            $data['date_inserted']  = date('Y-m-d H:i:s');
        }
        
        $tbCovidAttendancy -> bind(  $data );
        
        $tbCovidAttendancy -> check();
        $tbCovidAttendancy -> store();
               
        $state -> set('id', $tbCovidAttendancy -> id );
        parent::setState( $state );
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
    }       
    
    
    protected function saveDetails($state) {
        $tb = Table::getInstance("covidattendancydet");
        $data = $state -> toArray();
        
       
        
        if ( $data['id_covidattendancy_details'] === 0 )
        {
            $data['id'] = null;
        }
        else
        {
            $data['id'] = $data['id_covidattendancy_details'];
        }
      // var_dump($data);
        
        $tb -> bind($data);
        $tb -> store();
        $state -> set('id_covidattendancy_details', $tb -> id );
        parent::setState( $state );
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
    }
    
    protected function deleteRecord($state)
    {
        $id = $state -> get('id', 0);
        if ( $id == 0 ) {
               Factory::getApplication() -> enqueueMessage(Text::_('COM_EL_NO_ID'), 'warning');
        }
        else {
               $tb = Table::getInstance("covidattendancydet");
               $tb -> load($id);
               $tb ->delete();
               Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_DELETE_SUCCESS'), 'success');
        }
         parent::setState( $state );
    }
    
}
