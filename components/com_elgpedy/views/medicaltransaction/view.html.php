<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
	defined( '_JEXEC' ) or die( 'Restricted access' );
	require_once __DIR__ . '/../datacommon.php';
   
   class ElgPedyViewMedicalTransaction extends DataCommon
   {
		public function render()
		{
			$data = $this->state->get('data');
			$this->fields = $data->fields;
			$this->dataLabExams =  $data->data['Medical'];
			$this->dataLayout = 'medicaltransaction.php';
			return parent::render();
		}
   }