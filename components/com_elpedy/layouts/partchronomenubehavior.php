<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');
$activeId = 0;
$currentId =$this->state->get('Itemid'); 
$iId = $currentId;
$inTransaction = ($currentId == 112 || $currentId == 114 ||  $currentId== 119  ); // menu ids of transactions pages
$inReview = ( $currentId == 122 || $currentId == 123  || $currentId == 120 );  // menu ids of review pages
foreach(JFactory::getApplication()->getUserState('userUnits') as $unit): 
   
    if ( $unit -> HealthUnitTypeId == 10  &&  $inTransaction ):
        $iId = 114; //spmp
    elseif ( $unit -> HealthUnitTypeId == 10 &&  $inReview ):
         $iId = 122; //review spmp
    elseif ( ( $unit -> HealthUnitTypeId == 13 ||  $unit -> HealthUnitTypeId == 11 ) && $inTransaction ): // kcy, kpcy
        $iId = 119; //kpcy
    elseif  ( ( $unit -> HealthUnitTypeId == 13  ||  $unit -> HealthUnitTypeId == 11 ) && $inReview ):  // kcy, kpcy
        $iId = 123; //review kpcy
    elseif ( $inTransaction ):                        
        $iId = 112; //clinic transactoin
    elseif ( $inReview ):
        $iId = 120;
    endif;
 // echo 'unitsUrls[', $unit->HealthUnitId, '] =\'', JRoute::_('index.php?option=com_elgpedy&Itemid=' . $iId ,false) . '\'; ';
endforeach;