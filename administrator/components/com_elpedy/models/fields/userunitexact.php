<?php

/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/

require_once JPATH_SITE . '/components/com_elgpedy/componentutils.php';
JFormHelper::loadFieldClass('list');

class JFormFieldUserUnitExact extends JFormFieldList {

    public $type = 'UserUnitExact';
    protected function getOptions() {
		
        $app = JFactory::getApplication();
        $class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
        $userId = JFactory::getUser()->id;
        $db =  ComponentUtils::getPedyDB();
        $query = $db->getQuery(true);
    
        $query->clear();
        $query -> select ("HealthUnitId, HealthDistrictId") -> from ("Users") ->  where ("isAdmin = 1 and UserId = " . $userId );
        $admin= $db -> setQuery( $query ) -> loadObject();        
        $query -> clear();
        
        if ( $admin != null ) {
            
            $query -> select ("HealthUnitRel.HealthUnitId,HealthUnit.DescEL," . $admin -> HealthUnitId . ",HealthUnit.HealthUnitTypeId")
                -> from ("pedy.HealthUnitRel")
	-> innerJoin ("pedy.HealthUnit on HealthUnitRel.HealthUnitId = HealthUnit.HealthUnitId")
                -> where ("HealthUnit.HealthDistrictId=" .  $admin -> HealthDistrictId);
              
            $q2 = $db ->getQuery(true);
       
            $q2 -> select ("HealthUnitId, DescShortEL," . $admin -> HealthUnitId . ", HealthUnitTypeId")
                    -> from ("pedy.HealthUnit")
                    -> where ("(HealthDistrictId != " . $admin -> HealthDistrictId . " and HealthUnitTypeId=26) or (HealthDistrictId = " . $admin -> HealthDistrictId . " and HealthUnitTypeId=1)") 
                    -> order ("DescEL");
            $query -> union( $q2 ) -> order ("DescEL");
           
        }
        else {
            $query -> select( "HealthUnit.HealthUnitId, HealthUnit.DescEL")
                -> from("Users")
                -> innerJoin("HealthUnit on Users.HealthUnitId = HealthUnit.HealthUnitId")
	-> where("Users.UserId =" . $db -> quote($userId) );
        }
        
        $db->setQuery($query);
        $items = $db->loadObjectList();
			
        $options = [];
        if(!empty($items)) {
            foreach($items as  $item) {
                $options[] = JHtml::_('select.option', $item->HealthUnitId, $item->DescEL);      
            }
            unset($item);
        }
        $options = array_merge(parent::getOptions(), $options);
//        var_dump($options);
//        exit;
        return $options;
    }
}

