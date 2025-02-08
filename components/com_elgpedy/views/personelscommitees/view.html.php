<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  require JPATH_COMPONENT . '/views/datacommon.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewPersonelsCommitees extends DataCommon
   {
		public function render()
		{
			JHTML::script('media/com_elgpedy/js/moment.min.js');
			JHTML::_('bootstrap.framework');
			JHTML::stylesheet('media/com_elgpedy/css/fullcalendar.min.css'); 
			JHTML::stylesheet('media/com_elgpedy/css/fullcalendar.print.css', array('media'=>'print')); 			
			JHTML::script('media/com_elgpedy/js/fullcalendar.min.js');
			JHTML::script('media/com_elgpedy/js/lang-all.js');
			$data = $this->state->get('data');
			$this->personels = $data->personels;
			$this->commitees = $data->commitees;
			$rawData = $data->data;
			$data = array();
			foreach($rawData as $event)
			{
				$data[] = array('PersonelScheduleId'=>$event->ScheduleId, 'title'=>$event->LastName . ' ' . $event->FirstName, 'start'=>$event->FromDate, 'end'=>$event->ToDate, 'backgroundColor'=>'#' . $event->MemoColor);
			}
			$this->data = $data;
			$this->dataLayout = 'personelscommitees.php';
			return parent::render();
		}
   }
