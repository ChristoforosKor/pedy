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

class ProlepsisDeleteData extends JModelBase {   
 
    
      public function setState(Registry $state) {
        $tbProlepsis = Table::getInstance('Prolepsis');
        $tbProlepsis ->delete( $state -> get('id') );
        Factory::getApplication() ->enqueueMessage('Η διαγραφή ήταν επιτυχής', 'success');
    }
}
