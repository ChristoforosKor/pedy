<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism.gr  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2014 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/
class Queries {
    
//     public static function getEducationLevels( $db )
//    {
//        $query = 'select id, educationlevel from #__school_educationlevel';
//        $db->setQuery($query);
//        return $db->loadRowList();
//    }
    
    public static function getSchoolData( $db )
    {
        $query = 'select school_id, school_level_id, area_id, description from #__school';
        $db->setQuery($query);
        return $db->loadRowList();
    }
    public static function getSchoolLevelClasses( $db )
    {
        $query = '  select sl.school_level_id, sl.school_level , sc.school_level_class_id, sc.school_level_class 
                    from #__school_level sl
                    inner join #__school_level_class sc on sc.school_level_id = sl.school_level_id ';
        $db->setQuery($query);
        return $db->loadRowList();
    }
    
    public static function getArea( $db )
    {
        $query = 'select area_id, area_type_id, area from #__area order by area';
        $db -> setQuery ( $query );
        return $db->loadRowList();
    }
    
    public static function getAreaType ( $db )
    {
        $query = 'select area_type_id, area_type from #__area_type';
        $db -> setQuery ( $query );
        return $db->loadRowList();
    }
    
    public static function getDentalCondition( $db )
    {
        $query = 'select dental_condition_id, description, dental_condition_code from dental_condition where locale = \'el\' order by ordering, dental_condition_code';
        $db -> setQuery($query);
        return $db->loadRowList();
    }
    
    public static function getDentalMouthCondition($db)
    {
        $query = 'select dental_mouthcondition_id, description from dental_mouthcondition where locale =\'el\' ';
        $db -> setQuery( $query );
        return $db->loadRowList();
    }
    
    public static function getDentalTooth($db)
    {
        $query = 'select dental_tooth_id, dental_rel  from dental_tooth';
        $db -> setQuery( $query );
        return $db->loadRowList();
    }	
	
}