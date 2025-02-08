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

class CovidmonitorSaveData extends JModelDatabase {   
   
    public function setState(Registry $state) {
        
       $task = $state -> get('task', 'savehead');
        if ( $task === 'savehead') {
            $this -> saveHead($state);
        }
        elseif ( $task === 'savedetails') {
            $this ->saveDetails($state);
        }
        elseif ( $task === 'delete') {
            $this ->deleteRecord($state);
        }
        
    }       
    
    
    
     protected function saveHead(Registry $state) {
        try {
            $tbCovidMonitor = Table::getInstance('covidmonitorhead');
        }
        catch(Exception $e) {
            $e -> getMessage();
            exit;
        }
                
        $data = $state -> toArray();
      
        if ( $data['id']  == 0 ) {
            
            $data['date_inserted']  = date('Y-m-d H:i:s');
        }
        
        $tbCovidMonitor -> bind(  $data );        
        $tbCovidMonitor -> check();
        $tbCovidMonitor -> store();
               
        $state -> set('id', $tbCovidMonitor -> id );
        
        parent::setState( $state );
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
    }       
    
    
    protected function saveDetails($state) {
        $tb = Table::getInstance("covidmonitordetails");
        $data = $state -> toArray();
        
       
        
        if ( $data['idCovidMonitorDetails'] === 0 )
        {
            $data['id'] = null;
        }
        else
        {
            $data['id'] = $data['idCovidMonitorDetails'];
        }
        $tb -> bind($data);
        $tb -> store();
        $state -> set('idCovidMonitorDetails', $tb -> id );
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
               $tb = Table::getInstance("covidmonitordetails");
               $tb -> load($id);
               $tb ->delete();
               Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_DELETE_SUCCESS'), 'success');
        }
         parent::setState( $state );
    }
    
}
