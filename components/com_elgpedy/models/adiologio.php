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
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';

 
class ElgPedyModeladiologio extends PedyDataEdit
{
	function getState() 
    	{
            $pedyDB = ComponentUtils::getPedyDB();
            $state = parent::getState();
            $form = JForm::getInstance('adiologio',  ComponentUtils::getDefaultFormPath() .'/adiologio.xml'); 
            $healthUnitId = $state->get('HealthUnitId', 0 );
            if($healthUnitId > 0 ):
                $form->setFieldAttribute('PersonelId', 'params', '{"p1":' . $healthUnitId . '}');
            endif;
            if($state->get('id', 0) > 0 ):
                $aD = $this->getAttendancyData($pedyDB, $state->get('id'));
                $form->bind($aD);
            endif;
            $state->set('form', $form);	
            $state->set('personelStatus', $this->getPersonelStatus($pedyDB));
            return $state;
    }

    private function getPersonelStatus($db)
    {
        return $db->setQuery('select PersonelStatusId, DescEL, PersonelStatusGroupId from PersonelStatus order by PersonelStatusGroupId, DescEL')->loadAssocList();                    
    }
   
    private function getAttendancyData($db, $id)
    {
        return $db->setQuery("select PersonelAttendanceBookRafinaId, PersonelId, PersonelStatusId, PersonelStatusGroupId, StartDate, EndDate, Duration, Year, UserId, StatusId, Details from PersonelAttendanceBookRafina where PersonelAttendanceBookRafinaId = $id")->loadAssoc();
    }
 
    
}