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
require_once JPATH_COMPONENT_SITE . '/controllers/data.php';
class ElgPedyControllerProlepsisCommunity extends Data 
{
		private static $LAST_OLD_DATE = '2016-09-30'; // last date of old status. 
	
	public function execute()
	{
		
		$districtId = ComponentUtils::getDistrictIdBySelectedUnitId( JFactory::getApplication()->getUserState('lastUnit', 0) );
		 
		if($this -> input -> getString('RefDate') == ''):
			$dt = date('Y-m-d');
		else:
			$dt = ComponentUtils::getDateFormated($this -> input -> getInt('RefDate'), 'Ymd', 'Y-m-d');
		endif;
		
		if($dt <= self::$LAST_OLD_DATE || $districtId === '2' ):
			
			$this -> appData['controller'] = 'prolepsiscommunityold';
			$this -> appData['model'] = 'prolepsiscommunityold';
			$this -> appData['view'] = 'prolepsiscommunityold';
			$this -> appData['layout'] = 'prolepsiscommunityold';
		endif;
		
		parent::execute();
	}
	
}
