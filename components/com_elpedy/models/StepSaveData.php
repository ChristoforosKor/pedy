<?php
/*------------------------------------------------------------------------
# com_elergon - E-Logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elergon\models;
defined('_JEXEC') or die('Restricted access');
use elogism\storeimplementation\StorerTable;
use Joomla\CMS\Table\Table;
use elogism\models\ElModelStore;
use Joomla\Registry\Registry;


class StepSaveData extends ElModelStore {   
    public function __construct( Registry $state = null ) {
        $table =  Table::getInstance( 'ErgonStep' ) ;
        parent::__construct ( new StorerTable ( $table ), $state  );
    }    
}
