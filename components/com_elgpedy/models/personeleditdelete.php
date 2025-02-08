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
use Joomla\CMS\Table\Table;

class ElgPedyModelPersonelEditDelete extends JModelBase
{
	
	function setState(JRegistry $state) 
	{		
		$pId = $state->get('formData')->PersonelId;
		Table::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
		$table = Table::getInstance('Personel');
		$table->makeDelete( [ 'PersonelId' => $pId ] );
		$pH = Table::getInstance( 'PersonelHealthUnitHistory ' );
		
		$pH -> load( $pH-> getLast($pId) );
		$pH -> EndDate = $state -> get('formData') -> EndDate;
		$pH -> statusid = 3;
		$pH -> store ();
                
//		$pS = Table::getInstance( 'PersonelSpecialityHistory ' );
//                               $pS -> load( $pS-> getLast($pId)  );
//		$pS -> EndDate = $state -> get('formData') -> EndDate;
//		$pS -> statusid = 3;
//		$pS -> store ();
	}
	
	private function deleteFromHistory( $personelId )
	{
		
	}
 }
