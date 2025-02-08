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
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('radio');

class JFormFieldSQLRadio extends JFormFieldRadio {
    public $type = 'SQLRadio';
   
    
    protected function getLayoutData()
    {
                $this -> layout = 'fieldradio';
                $keyField = $this -> getAttribute ('key_field');
                if ( $keyField === ''):
                  $keyField =  'value';
                endif;
                $valueField = $this -> getAttribute ('value_field');
                if ( $valueField === ''):
                  $valueField =  $this -> getAttribute( 'name' );
                endif;
                
                $items['options'] =  array_map (
                        function ( $val ) use ( $keyField, $valueField ) {
                                $item = new stdClass();
                                $item -> value = $val[ $keyField ];
                                $item -> text = $val[ $valueField ];
                                $item -> disable  = false;
                                $item -> class    = '';
                                $item -> selected = false;
                                $item -> checked  = false;
                                return $item;
                        },
                                                        
                        ComponentUtils::getPedyDB()
                        -> setQuery( 
                                $this ->getAttribute( 'query' ) 
                                ) 
                        -> loadAssocList()
                        );
                $data = parent::getLayoutData();        
                if ( is_array( $this -> value ) ):
                    $data['value'] = $this -> findValueFromArray( $items['options'], $this -> value );
                else:
                    $data['value'] = (string) $this -> value;
                endif;
                $data['options'] =  array_merge_recursive( $data['options'], $items['options'] );
                return $data;
    }
    
    protected function findValueFromArray($options, $values) {
        for( $i = count( $options ) -1; $i >=0; $i -- ):
            if ( in_array( $options[ $i ] -> value, $values ) ):
                return $options[ $i ] -> value;
            endif;
        endfor;
    }
    
    protected function getInput() 
    {
        $this -> layout = 'fieldradiolist';
        return parent::getInput();
    }
    
}