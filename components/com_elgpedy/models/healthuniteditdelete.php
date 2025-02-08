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


class ElgPedyModelHealthUnitEditDelete extends JModelBase
{
	
	function setState(JRegistry $state) 
	{		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
		$table = JTable::getInstance('HealthUnit');
		$table->makeDelete(array('HealthUnitId'=>$state->get('formData')->HealthUnitId));
	}
 }