<?php
/**
 * @copyright (C) 2013-2014 e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */

 
 /**
  * Class that holds generic php static utility functions.
  * @package e-logism.php.
  * @subpackage joomla.
  * @author Christoforos J. Korifidis.
  * 
  */


class PHPUtils {
    
   

    
     /**
     * This function gets a value and normalizes it according to given rules. 
     * Normalization rules are given in the array of the function's second argument (see below on the arguments explaination. 
     * @param primitive $value The value to be normalized.
     * @param Array $normRules An associative array that contains the rules for normalization. 
     * Currently the rules that supported are:
     * 1. upper: convert data to upper case.
     * 2. lower: conert data to lower case.
     * 3. nospace: elimenates all spaces from the data.
     * 4. nowhitespace: eliminates all white space (o just spaces but also tabs etc) from the data.
     *  
     * @param String encoding. The encoding to be used when needed on string operations.
     * @return The $value normalized
     * 
    
     */
    
    public static function normData($value, $normRules, $encoding='utf8')
    {
        foreach($normRules as $normRule) {
                switch($normRule) {
                    case 'upper' : $value = mb_strtoupper($value, $encoding);
                        break;
                    case 'lower' : $value = mb_strtolower($value, $encoding);
                        break;
                    case 'nowhitespace' : $value = preg_replace('/\s+/', '', $value);
                        break;
                    case 'nospaces' : $value = str_replace(' ', '',  $value);
                        break;
                    case 'numeric' : $value =(is_numeric($value)? $value: 0);
                        break;
                    case 'trim' : $value = trim($value);
                        break;
                    case 'nogreekaccent' : $value= str_replace('ώ', 'ω', str_replace('ύ', 'υ',str_replace('ί', 'ι', str_replace('ή', 'η', str_replace('έ', 'ε',str_replace('ό', 'ο', str_replace('ά', 'α',  $value)))))));
                        break;
                }
            }
            unset($normRule);
            return $value;
    }
   
    
     /**
     * This function queues errors for showing later in the application and returns the status of the proccess. So if there where really queued errors 
     * it returns TRUE otherwise it returns FALSE.
     * @param Array $errors An Array containing the errors to be queued.
    */
    public static function queueErrorsMessages($errors = array(), $noErrorMessage='') {
        if (is_array($errors)) {
            $app = JFactory::getApplication();
            if(count($errors) >0) {
                $cnt = count($errors);
                for ($i = 0; $i < $cnt ; $i++) {
                    if ($errors[$i] instanceof Exception) {
                        $app->enqueueMessage($errors[$i]->getMessage(), 'Exception');
					}
                    else{
                        $app->enqueueMessage($errors[$i], 'Error');
                    }
                }
            }
        }
    }
    
    
    
    
    
    /**
     * Inserts a new row into a db table and return the new inserted id for that value.
     * Optionally checks if the row exists already exists. If the row exists it returns it's existing id.
     * If en error occurs it return -1.
     * 
     * @param JTable $dbTable The table into which we want to insert the value
     * @param array $values The values of the the row's columns. It must by in the form array("columnName", column Value, array(normRules))
     * @param String $id The name of the id column. Default is id.
     * @param boolean $checkExists If ture it will check if the row already exists. Default is true.
     * @return mixed The value of the id column.
     */
    
    public static function insertNewValue($dbTable, $values=array(), $idColumnName="id", $checkExists=true )
    {
        $cnt = count($values);
        if( $cnt <= 0) 
        {
            return -1;
        }
        $rV = array();
        for($i = $cnt -1; $i>=0; $i--)
        {
            $values[$i][1] = self::normData($values[$i][1], $values[$i][2]);
            $rV[$values[$i][0]] = $values[$i][1];
        }
        
        
        if($checkExists)
        {
            if($dbTable->load($rV))
            {
                return $dbTable->$idColumnName;
            }
        }
        for($i = $cnt -1; $i >=0; $i-- )
        {
            $dbTable->$values[$i][0] = $values[$i][1];
        }
        
        if($dbTable->store())
        {
            return $dbTable->$idColumnName;
        }
        else
        {
            return -1;
        }
        
    }
    
    
    
   public static  function array_group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
    
    public static function getObjectListGrouped($objectList, $key)
    {
        $lType = "";
        $result = array();
        foreach($objectList as $item)
        {
            if($lType != $item->$key)
            {
                $lType = $item->$key;
                $result[$lType] = array();
            }
            $result[$lType][] = $item;
        }
        unset ($item);
        return $result;
    }

    
    public static function isValidDateTimeString($str_dateformat, $str_dt, $str_timezone = null) {
        
        if($str_timezone == null)
        {
        
            $date = DateTime::createFromFormat($str_dateformat, $str_dt);
        }
        else
        {
        
            $date = DateTime::createFromFormat($str_dateformat, $str_dt, new DateTimeZone($str_timezone));
        }
            
        return ($date === false ? false : true);
    }
    
    public static function getMonths1stDate($month=null, $year = null){
        $year = ($year == null)? date('Y'): $year;
        $month = ($month == null)? date('m') :$month;
        return  mktime (0, 0, 0, $month, 1, $year);
    }
    
    public static function getMonthsLasttDate($month=null, $year = null){
        $year = ($year == null)? date('Y'): $year;
        $month = ($month == null)? date('m') + 1 :$month;
        return  mktime(23, 59, 59, $month, 0,   $year);
    }
    
    
   public static function getWeekRange($date) {
        $ts = strtotime($date);
        $start = (date('w', $ts) == 6) ? $ts : strtotime('last saturday', $ts);
        return array(date('Y-m-d', $start),
                 date('Y-m-d', strtotime('next friday', $start)));
    }
    
    public static function getCallType($intCallType)
    {
        if($intCallType == 2)
        {
            return JText::_('COM_ELG_ERGON_PROJECT_CALL_OUTGOING');
        }elseif($intCallType == 1)
        {
            return JText::_('COM_ELG_ERGON_PROJECT_CALL_INCOMING');
        }
    }
    
    
    
}
