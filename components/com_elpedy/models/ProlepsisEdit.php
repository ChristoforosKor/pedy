<?php
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\models;
defined('_JEXEC') or die('Restricted access');
use components\com_elpedy\ComUtils;
use Joomla\Registry\Registry;
use JModelDatabase;
/**
 * Gets step list data
 * @author E-Logism
 */

class ProlepsisEdit extends JModelDatabase {   
    public function getState(): Registry {
        $db = ComUtils::getPedyDB();
        $query = $db -> getQuery(true);
        $state = parent::getState();
        $data = $state -> get( 'data', []) ; 
        $data [ 'VaccinesEdit' ] =  $this -> getVaccinesSteps ( $db, $query );
        $data['schools'] = $this -> getSchoolData( $db, $query );
        $data['levelClasses'] = $this -> getSchoolLevelClasses( $db, $query );
        $data['areas'] = $this -> getArea( $db, $query );
        $data['areaTypes'] = $this -> getAreaType( $db, $query );
        $data['schoolLevels'] = array_values(
                array_unique(
                        array_map(function( $item ) {
                            return [$item[0], $item[1]];
                        }, $data['levelClasses'])
                        , SORT_REGULAR
        ));
        $state -> set('data', $data);
        return $state;
    }   
    
    private function getVaccinesSteps( $db, $query) {
        return 
                $db -> setQuery ( 
                        $query 
                        -> clear()
                        -> select('vvs.idVaccine, vvs.idVaccineStep, vs.VaccineStep, v.Vaccine, vvs.id')
                        -> from ('#__Vaccine_VaccineStep vvs')
                        -> innerJoin ('#__VaccineStep vs on vvs.idVaccineStep = vs.id')
                        -> innerJoin('#__Vaccine v on v.id = vvs.idVaccine')
                        -> order ( 'Vaccine, idVaccineStep')
                        ) -> loadRowList();
        
    }
    
    private function getSchoolData( $db, $query )
    {
        $query -> clear();
        $query -> select ( 'school_id, school_level_id, area_id, description') ->  from ('#__school');
        return $db -> setQuery($query) ->loadRowList();
      
    }
    private function getSchoolLevelClasses( $db, $query )
    {
        $query -> clear();
        $query ->  select ('sl.school_level_id, sl.school_level , sc.school_level_class_id, sc.school_level_class') 
                ->    from ('#__school_level sl')
                ->    innerJoin ('#__school_level_class sc on sc.school_level_id = sl.school_level_id ');
        return $db->setQuery($query)->loadRowList();
     
    }
    
    private function getArea( $db, $query )
    {
        $query -> clear()
       -> select ('area_id, area_type_id, area')
        ->from ('#__area')
        ->order ('area');
        return $db -> setQuery ( $query ) ->loadRowList();
    
    }
    
    private function getAreaType ( $db, $query )
    {
        $query -> clear()
        -> select ('area_type_id, area_type') 
        -> from ('#__area_type');
        return $db -> setQuery ( $query ) ->loadRowList();
    }
    
}
