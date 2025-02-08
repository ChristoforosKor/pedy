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

class JFormFieldUserUnit extends JFormFieldList {

    public $type = 'UserUnit';
    protected function getOptions() {
		
		$app = JFactory::getApplication();
		$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
                $userId = JFactory::getUser()->id;
//		 $items = ComponentUtils::getUserHUIds();
                $db =  ComponentUtils::getPedyDB();
                $query = $db->getQuery(true);
                $db->setQuery($query);
		$query->clear();
                $query->setQuery('call sp_getUserHUId(' . JFactory::getUser()->id . ', 0)');
		$items = $db->loadObjectList();
		
                $options = array();
		if(!empty($items)) {
            foreach($items as  $item) {
                $options[] = JHtml::_('select.option', $item->HealthUnitId, $item->DescEL);      
            }
			unset($item);
	    }
		$options = array_merge(parent::getOptions(), $options);
        return $options;
    }
}