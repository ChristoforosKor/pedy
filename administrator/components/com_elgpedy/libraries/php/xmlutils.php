<?php

/**
 * Utilites for xml files<br/>
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.0
 */
class XMLUtils {

    private $xml = null;
    public $name;
    public $creationDate;
    public $author;
    public $authorEmail;
    public $authorUrl;
    public $copyright;
    public $license;
    public $version;
    public $description;

    /**
     * This functions returns data from an xml file based on xqueries expressions given by the argument $queries. It's a wrapper for the getXMLFileProperties 
     * and uses simplexml_load_file function internally. Most of the arguments are the arguments for simplexml_load_file function.
     * @see getXMLProperties. 
     * @see https://php.net/manual/en/function.simplexml-load-file.php
     * 
     * @param string $filePath The full path of the xml file to load. Same argument with that of simplexml_load_file function.
     * @param array $queries An array associative with xqueries we want to run against this xml file. Eahc row in the array is key - value with value being the query expression and key a name for the query
     * @param string $className The returned object type. Same argument with that of the simplexml_load_file function.
     * @param int $options Additional Libxml parameters. Same with that of of the simplexml_load_file function.
     * @param string $ns Namespace prefix or URI. Same with that of of the simplexml_load_file function.
     * @param bool $is_prefix if ns is a prefix or URI. Same with that of of the simplexml_load_file function.
     */
    public static function getXMLFileProperties($filePath, Array $queries = null, $className = 'SimpleXMLElement', $options = 0, $ns = '', $is_prefix = false)
    {
        $xml =  simplexml_load_file($filePath, $className, $options, $ns, $is_prefix);
        return self::getXMLProperties($xml, $queries);
    }
    
    /**
     * This functions returns data from an xml file based on xqueries expressions given by the argument $queries.
     * @param Object $xml An xml object to search. The xml object must be compatible with the xml return by the simplexml_load_file function.
     * @see https://php.net/manual/en/function.simplexml-load-file.php
     * @param array $queries The xqueries we we want to run against the xml file
     * @return Associative array with the xquery as key and the result of the xquery as value
     */
    public static function getXMLProperties(SimpleXMLElement $xml, Array $queries = null) 
    {
        $values = array();
        
        if(is_array($queries))
        {
            foreach($queries as $key=>$value)
            {
                $values[$key] = $xml->xpath($value); 
            }
            unset($key);
            unset($value);
        }
        return $values;
    }


}

?>
