<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
  
 /**
  * Library model controller that saves data.
  * @package e-logism.joomla;
  * @subpackage models
  * @author Christoforos J. Korifidis
  * 
  * @version 1.1
  */
  
 class ModelSave extends JModelDatabase{ 
     
     /**
      * Contains the values submited by the user. The values are placed under the corresponding names the belong.
      * e.g the data of "table1" exists as properties under $data->table1 and the data of "table2" exists as properties under the $data->table2.
      * The properties that holds the values have the corresponding table fields names e.g. the value of the field "fullname" of the table "table1" 
      * exists on $data->table1->fullname;
      * @var stdClass $data 
      * 
      */
     protected $data = array();
     
     /**
      * Associative array with the table objects that will be bound to the data submited by the users.
      * @var Array $tables. 
      */
     protected $tables = array();
     
     
     function setState(JRegistry $state) {
        $data = $state->get('formData');
        foreach($data as $tableName=>$tableData)
        {
           $this->tables[$tableName] = JTable::getInstance($tableName,'Table');
           $this->tables[$tableName]->bind($tableData);
        }
        unset($tableName);
        unset($tableData);
        $this->data = $data;
        parent::setState($state);       
    }
}
?>