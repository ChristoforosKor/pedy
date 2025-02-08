<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedydataeditsave.php';

 
 class ElgPedyModelPersonelsCommitteesDataDelete extends PedyDataEditSave
 {
	public function __construct(\JRegistry $state = null)
	{
            parent::__construct($state);
            $this->table = JTable::getInstance('PersonelSchedule');
	}
        
	function setState(JRegistry $state) 
	{		
            $oldId = $state->get('formData')->PersonelScheduleId;
            try {
                 $this->table->makeDelete(array('PersonelScheduleId'=>$oldId));                
            }
            catch(Exception $e)
            {
                JFactory::getApplication()->enqueueMessage($e->getMessage());    
            }
            $data = new stdClass();
            $data->data = new stdClass();
            $data->data->oldId =  $oldId;
            $state->set('data', $data);
		
	}
 }
