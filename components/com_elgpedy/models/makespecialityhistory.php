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


class ElgPedyModelMakeSpecialityHistory extends JModelDatabase
{
	
	function setState(JRegistry $state) 
	{
		
		
		$db = ComponentUtils::getPedyDB();
		$db -> setQuery('CALL make_special_history()') -> execute();
		
		$ids = $db -> setQuery("select PersonelId, count(*) as cnt from PersonelSpecialityHistory group by Personelid") -> loadAssocList();
/* 		foreach($ids as $pid):
			$pids = $db -> setQuery("select id, StartDate, statusId from PersonelSpecialityHistory where PersonelId = ". $pid['PersonelId'] . " order by StartDate desc,id desc") -> loadAssocList();
			$lDate = null;
			foreach($pids as $dates):
				if($lDate != null):
					$db -> setQuery("update PersonelSpecialityHistory set endDate = " . $db -> quote($lDate) . " where id = " .  $dates['id']) -> execute();
				elseif($dates['statusId'] != 1):
					$db -> setQuery("update PersonelSpecialityHistory set endDate = " . $db -> quote($dates['StartDate']) . " where id = " .  $dates['id']) -> execute();
				endif;
				$lDate = $dates['StartDate'];
			endforeach;
			unset($dates);
		endforeach;
		unset($pid); */
		
		$dbls = $db -> setQuery('SELECT PersonelId, SpecialityId, count(*) 
			 FROM PersonelSpecialityHistory
			 group by PersonelId, SpecialityId
			 having count(*) > 1') -> loadAssocList();
			
			
		foreach($dbls as $item):
			$innerIds = $db -> setQuery("select * FROM pedy.PersonelSpecialityHistory where personelid=" . $item['PersonelId'] . " and SpecialityId=" . $item['SpecialityId'] . "  and statusId > 1 order by StartDate, id") -> loadAssocList();
			$minId = $innerIds[0]['id'];
			
			foreach($innerIds  as $innerId):
				if($innerId['id'] != $minId):
					// if($item['PersonelId'] == 3471):
						// echo 'delete from PersonelSpecialityHistory where id = ' . $innerId['id'] . '<br />';
						//echo $minId;
					// endif;
					$db -> setQuery( 'delete from PersonelSpecialityHistory where id = ' . $innerId['id'] ) -> execute();
				endif;
			endforeach;
			unset($innerId);
			// $db -> setQuery("delete from PersonelSpecialityHistory where PersonelId = " . $item['PersonelId'] . ' and SpecialityId = ' . $item['SpecialityId'] . ' and statusid > 1 ') -> execute();
		endforeach;
		unset($item);
		
		foreach($ids as $pid):
			$lDate = null;
			$pids = $db -> setQuery("select id, StartDate, EndDate, statusId from PersonelSpecialityHistory where PersonelId = ". $pid['PersonelId'] . " order by StartDate desc,id desc") -> loadAssocList();

			foreach($pids as $dates):
				if ($lDate != null):
					$db -> setQuery("update PersonelSpecialityHistory set EndDate = " . $db -> quote($lDate) . " where id = " .  $dates['id']) -> execute();					
					$lDate = $dates['StartDate'];
				else:
					$lDate = $dates['StartDate'];
				endif;
			endforeach;
			unset($dates);
		endforeach;
		
		unset($pid);
		$state -> set('data', 'completed');
		parent::setState($state);
	}
 }