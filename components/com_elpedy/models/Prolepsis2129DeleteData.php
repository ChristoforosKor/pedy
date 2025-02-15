<?php

namespace components\com_elpedy\models;
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Table\Table;

use JModelBase;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;


class Prolepsis2129DeleteData extends JModelBase {   
 
    
      public function setState(Registry $state) {
        $tbProlepsis = Table::getInstance('Prolepsis2129');
        $tbProlepsis ->delete( $state -> get('id') );
        Factory::getApplication() ->enqueueMessage(Text::_('COM_EL_PEDY_DELETE_SUCCEESS'), 'success');
    }
}
