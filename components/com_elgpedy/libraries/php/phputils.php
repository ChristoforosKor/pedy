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
     * 4. nowhitespace: eliminates all white space (not just spaces but also tabs etc) from the data.
     * 5. singlewhitespace: Converts two and more subsequent white space (tab, newline, space ect) to single space.
     * 6. numeric: Convert value to zero if is not numeric
     * 7. trim: Trim spaces.
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
                    case 'siglewhitespace' : $value = preg_replace('/\s{2,}/', ' ', $value);
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
     * Zis the contents of a folder.
     * @param String $sourcePath The path where the files to be zipped resides.
     * @param String $zipFile The name of the ziped fle to be.
     */
    
    public static function zip($sourcePath, $zipFile)
    {
        $zipArchive = new ZipArchive();
        if (!$zipArchive->open($zipFile, ZIPARCHIVE::OVERWRITE)) JLog::add("Failed to create archive\n" . $zipFile);
        $all = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourcePath));
        foreach ($all as $f) 
        {
            $fileName = $f->getFileName();
            if($fileName != "." && $fileName != "..")
            {
                $addPath = str_replace(JPATH_SITE . '/', '', $f->getPathName());
                $res = $zipArchive->addFile($addPath); 
                if(!$res)
                {              
                    JLog::add("Unable to add file: $f", JLog::ERROR, 'importer');
                }
            }
        }             
        if (!$zipArchive->status == ZIPARCHIVE::ER_OK) JLog::add("Failed to write local files to zip\n" . $zipFile);
        $res = $zipArchive->close();
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
    
	/**
     * Formats a datetime string 
     * @param String date. The date to be formated.
     * @param String inFormat. The format of the input date.
     * @param String outFormat. The new format of the date.
     * @param String timezone. The datetime zone to use.
     * @param String $localeCategory. The locale category to infect.
     * @param String $localeLang. The locale lang to use.
     * @return String. The new formated date.
     */
    public static function getDateFormated($date='0000-00-00',$inFormat='Y-m-d', $outFormat='d/m/Y', $timezone='Europe/Athens', $localeCategory = null, $localeLang = null) 
    {
        $d =  DateTime::createFromFormat($inFormat, $date);		
        if($d  === false)
        {
            return '';
        }
        $tz = new DateTimeZone($timezone);
        $d->setTimeZone($tz);
        return $d->format($outFormat);            
    }
    
    /**
     * Returns all dates between two intervals inclusive. 
     * @param String startDate. The start date in the format 'Y-m-d'.
     * @param String endDate. The end date in the format 'Y-m-d'.
     * @param String dateInterval. The date interval that will be the steps to output between the start and end date. Default to step by day ('P1D'). 
     * @return Array . An array of dates string in the form 'Y-m-d'.
     */
    
    public static function getDateRange($startDate, $endDate, $dateInterval = 'P1D')
    {
		$period = new DatePeriod(
			new DateTime($startDate),
			new DateInterval($dateInterval),
			new DateTime($endDate)
		);
		$allDates = array();
		foreach( $period as $date) { 
			$allDates[] = $date->format('Y-m-d'); 
		}
		unset($date);
		return $allDates;
    }
    
    
    /**
     * This function is similar php in_array function so as to serach recursively in multidimensional arrays. Parameters are same as original in_array function.
     * 
     * IS NOT TESTED YET
     * 
     * @param Mixed $needle The value to searh for.
     * @param array $haystack The array into which we will search for the value.
     * @param boolean $strict If true the comparison will takes in considaration the type of th value also, not just the value.
     * @return boolean True is needle found otherwise false
     */
    
    public static function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }
    
    
    /**
     * This is similar to php array_search so as to search recursively in multidimensional arrays. Parameters are same as original array_search function. 
     * 
     * IS NTO TESTED YET
     * 
     * @param Mixed $needle The value to dearch for
     * @param array $haystack The array into which we will search for the value
     * @param boolean $strict. If true the comparison of the value takes in consideration the type of the value also, not just the value.
     * @return The key of the value id found otherwise false.
     */
    public static function recursive_array_search($needle,$haystack, $strict = false) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if(($strict ? $needle===$value : $needle == $value) OR (is_array($value) && recursive_array_search($needle,$value, $strict) !== false)) {
                return $current_key;
            }
        }
        return false;
    }
}
