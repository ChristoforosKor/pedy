<?php

/*------------------------------------------------------------------------
# plg_pedy
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr
----------------------------------**/

require_once JPATH_SITE . '/components/com_elgpedy/componentutils.php';

JFormHelper::loadFieldClass('list');

class JFormFieldSQLRemote extends JFormFieldList {
    public $type = 'SQLRemote';
    protected function getOptions() {
        $class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
        $key = $this->element['key_field'] ? (string) $this->element['key_field'] : 'value';
		$value = $this->element['value_field'] ? (string) $this->element['value_field'] : (string) $this->element['name'];
		$query = (string) $this->element['query'];
        $db = ComponentUtils::getPedyDB();
        $db->setQuery($query);
	$items = $db->loadObjectlist();
	
        if(!empty($items)) {
           
		   $options = array();
            foreach($items as  $item) {
                $options[] = JHtml::_('select.option', $item->$key, $item->$value);
              
            }
            unset($item);
        }
		//$this->query= null;;
		$options = array_merge(parent::getOptions(), $options);
        return $options;
    }
}