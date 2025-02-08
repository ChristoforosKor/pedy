<?php

//include_once ('Utilities.php');

/**
 * Read values from Joomla 1.5+ Installation XML File<br/>
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.0
 */
class XMLJoomlaFunctions {

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
     * Read XML Installation File
     * @param String $filename the xml instalaltion file
     */
    public function loadFile($filename) {
          
        //$this->xml = new JSimpleXML();
        $this->xml = JFactory::getXMLParser('Simple');
        $this->xml->loadFile($filename);
        $this->name = $this->xml->document->name[0]->data();
        $this->creationDate = $this->xml->document->creationDate[0]->data();
        $this->author = $this->xml->document->author[0]->data();
        $this->authorEmail = $this->xml->document->authorEmail[0]->data();
        $this->authorUrl = $this->xml->document->authorUrl[0]->data();
        $this->copyright = str_replace('(c)', '&copy;', $this->xml->document->copyright[0]->data());
        $this->license = $this->xml->document->license[0]->data();
        $this->version = $this->xml->document->version[0]->data();
        $this->description = $this->xml->document->description[0]->data();
    }


    /**
     *  This functions returns the languages ini files that haw an extension by reading
     *  its install xml file
     * @param String $extName the name of the extension for wich we want the language ini files.
     * @param boolean $frontEnd if true the function will look for the  front end files otherwise for the back end (admin) language files. Default is true
     * @param String $extPrefix the prefix that joomla uses to indicate the type of the extension, e.g. com for components. Default is com.
     * @return Array with the file names. If en error occurs or no files found it returns an empty array.
     */

    public static function getExtensionLanguagesFiles($extName, $frontEnd=true, $extPrefix="com") {
        
        $installXML = simplexml_load_file(JPATH_ADMINISTRATOR . DS . "components" .DS . $extPrefix ."_" . $extName . DS . $extPrefix . "_" . $extName . ".xml");
        $extLangFiles = array();
        if (!$installXML) return $extLangFiles;
        $xRoot = $installXML->getName();
        if ($frontEnd) {
            $xquery = "/" . $xRoot . "/languages/language";
        } else {
            $xquery = "/" . $xRoot . "/administration/languages/language";
        }
        $installFiles = $installXML->xpath($xquery);
        if (count($installFiles)> 0)
        {
            $tmplLang = $installFiles[0]->xpath("@tag");
            $xquery = $xquery . "[@tag='" . $tmplLang[0] . "']";
            $installFiles = $installXML->xpath($xquery);
            $repl = $tmplLang[0] . ".";
            foreach($installFiles as $installFile){
                $extLangFiles[] = str_ireplace($repl ,"",$installFile);
            }
            unset($installFiles);
            unset($installFile);
        }
        
        
        return $extLangFiles;
    }
}

?>
