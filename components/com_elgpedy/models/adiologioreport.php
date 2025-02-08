<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class ElgPedyModelAdiologioReport extends JModelDatabase
{
    public function getState()
    {
        $state = parent::getState();
        $data = [];
        $filters = $state->get('filters');
        $dbPedy = ComponentUtils::getPedyDB();
        $data['rafinaAttendance'] = $this->getData($dbPedy, $filters, ComponentUtils::$STATUS_ACTIVE);
        $data['personel'] = $this->getPersonel($dbPedy, JFactory::getUser()->id);
        $forms = [];
        $forms['adiologioReport'] = JForm::getInstance('adiologioReport', ComponentUtils::getDefaultFormPath() . '/adiologioreport.xml');
        $forms['adiologioReport']->bind($filters);
        $state->set('forms', $forms);
        $state->set('data', $data);        
        return $state;
    }
    
    private function getData($db, $filters, $status = 1)
    {
        if($this->isSelectionMade($filters)):
            $query = 'select pr.PersonelID, p.FirstName, p.LastName, pr.StartDate, pr.EndDate, pr.Duration, pr.`Year`, pr.Duration
                , DescEl as PersonelStatus,PersonelAttendanceBookRafinaId, Details
                                  from PersonelAttendanceBookRafina pr
                                  inner join PersonelStatus ps
                                  on pr.PersonelStatusId = ps.PersonelStatusId
                                  inner join Personel p
                                  on p.PersonelId = pr.PersonelId
                                  where  pr.StatusId = ' . $status 
            . (isset($filters['Year']) ? '  and pr.`Year` = ' . $filters['Year'] : '' ) 
            . ($filters['StartDate'] !== '' ? '  and pr.StartDate <= \'' . $filters['EndDate'] . '\'' : '' ) 
            . ($filters['EndDate']  !== '' ? ' and pr.EndDate >= \'' . $filters['StartDate'] . '\'' : '' ) 
            . ($filters['PersonelId'] !== ''  ? '  and pr.PersonelId  in (' . $filters['PersonelId'] . ')' : '' ) ;
            return  $db->setQuery($query)->loadAssocList();
        else:
            return [];
        endif;

    }
    
    private function getPersonel($db, $idUser) {
        return  $db->setQuery("select s.* from (select @P1:= $idUser) parm , pedy.vw_lstPersonelByUser s")->loadAssocList();
    }
    
    private function isSelectionMade($filters)
    {
        if($filters['PersonelId'] > 0 || $filters['EndDate'] !== '' || $filters['StartDate'] !== '' )
            return true;
        else
            return false;
    }
}
