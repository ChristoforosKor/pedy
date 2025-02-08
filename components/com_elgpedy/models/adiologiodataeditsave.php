<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );


class ElgPedyModeladiologioDataEditSave extends JModelBase
{
	
	function setState(JRegistry $state) 
	{
		$formData = $state->get('formData');
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
		$table1 = JTable::getInstance('personelattendancebookrafina');
		
		$table1->bind($formData); 
		$table1->StatusId=componentutils::$STATUS_ACTIVE;
		$table1->store();
	}
 }