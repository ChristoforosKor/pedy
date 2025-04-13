<?php
/*------------------------------------------------------------------------
# com_elergon - E-Logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\models;

defined('_JEXEC') or die('Restricted access');
//use elogism\storeimplementation\StorerTable;
use Joomla\CMS\Table\Table;
//use elogism\models\ElModelStore;
use components\com_elpedy\ComUtils;
use JModelBase;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class Prolepsis2129EditSaveData extends JModelBase {   
 
    
      public function setState(Registry $state) {
        $app = Factory::getApplication();
        $user = ComUtils::getCurrentUser();
        
        if ($user->guest) {
            $app->enqueueMessage(Text::_('COM_EL_USER_DISCONNECTED'), 'warning');
            $app->setHeader('Status', 401, true);
            return;
        }
        
        $healthunit_id = trim(ComUtils::getDefaultUnitId());
        if ( empty($healthunit_id)) {
           $app->enqueueMessage(Text::_('COM_EL_USER_NO_UNIT'), 'warning');
           $app->setHeader('Status', 403, true);
           return;
        }
        $tbProlepsis = Table::getInstance('Prolepsis2129');
        $data = $state -> toArray();
        $tbProlepsis -> bind(  $data );
      
        $tbProlepsis -> check();
        $tbProlepsis -> store();
        $id = $tbProlepsis -> id;
        $state -> set('id', $id );
        parent::setState( $state );
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_SUBMIT_SUCCESS'), 'success');
    }
    
    
}
