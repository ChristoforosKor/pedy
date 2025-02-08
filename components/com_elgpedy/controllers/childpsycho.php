<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/data.php';
class ElgPedyControllerChildPsycho extends Data 
{
	
	private static $LAST_OLD_DATE = '2016-08-31'; // last date of old status. 
	private static $LAST_OLD_DATE_2 = '2019-02-01'; 
	public function execute()
	{
	
		if($this -> input -> getString('RefDate') == ''):
			$dt = date('Y-m-d');
		else:
			$dt = ComponentUtils::getDateFormated($this -> input -> getInt('RefDate'), 'Ymd', 'Y-m-d');
		endif;
		if($dt <= self::$LAST_OLD_DATE):
			
			//$this -> appData['controller'] = 'childspychoold';
			$this -> appData['model'] = 'childpsychoold';
			$this -> appData['view'] = 'childpsychoold';
			$this -> appData['layout'] = 'childpsychoold';
                                elseif( $dt < self::$LAST_OLD_DATE_2 ):
                                    $this -> appData['dataLayout'] = 'childpsycho';
                                else:
                                    $this -> appData['dataLayout'] = 'childpsycho2';
                                    
		endif;
		
		parent::execute();
	}
}
