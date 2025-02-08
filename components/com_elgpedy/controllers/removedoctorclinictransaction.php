<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism 
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_COMPONENT . '/models/removedoctorclinictransaction.php';

require_once JPATH_COMPONENT . '/views/removedoctorclinictransaction/view.json.php';
				
class ElgPedyControllerRemoveDoctorClinicTransaction extends JControllerBase {
    
     public function execute() {
		$model = new ElgPedyModelRemoveDoctorClinicTransaction();
		try {
			$model -> setState( new JRegistry( $this -> input -> getArray() ) );
			JFactory::getApplication() -> enqueueMessage(JText::_('COM_ELG_DELETE_SUCCESS'), 'success');
		}
		catch(Exception $e) {
			JFactory::getApplication() -> enqueueMessage($e -> getMessage(), 'error');
		}
		echo (new ElgPedyViewRemoveDoctorClinicTransaction($model)) -> render();
    }
  
}
