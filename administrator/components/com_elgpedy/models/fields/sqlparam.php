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


class JFormFieldSQLParam extends JFormFieldList {
    public $type = 'SQLParam';
    protected function getOptions() {
		
        
        $key = $this->element['key_field'] ? (string) $this->element['key_field'] : 'value';
	$value = $this->element['value_field'] ? (string) $this->element['value_field'] : (string) $this->element['name'];
	$query = (string) $this->element['query'];
        if(isset($this->element['params'])) :
            $params = json_decode($this->element['params'], true );
            foreach($params as $paramKey=>$paramValue):
                $query = str_replace('{' . $paramKey . '}', $paramValue, $query);
            endforeach;
            unset($paramKey);
            unset($paramValue);
        endif;
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
        $options = array_merge(parent::getOptions(), $options);
        return $options;
    }
}