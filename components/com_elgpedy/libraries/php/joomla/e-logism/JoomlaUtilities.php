<?php

include_once ('XMLJoomlaFunctions.php');
jimport ('joomla.filesystem.file');

/**
 * General Functions.<br/>
 * Created on 2012-02-02 <br/>
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class JoomlaUtilities {

    /**
     * this function returns an array from JHTML options for use in JHTMLSelect object
     * @param array $data the array with the key value pairs from the select list
     */
   public static function htmlOptions($data){
        $options = array();
        foreach($data as $row)
        $options[] = JHTML::_('select.option', $row[0], $row[1]);
        unset($data);
        unset($row);
        return $options;
    }


    /**
     * This function returns info of the extension by its xml file
     * @param String $xmlFile
     * @param String $LogoImage
     * @param String $htmlSource
     * @param Sting $Title
     * @return String The html string containing the info about the component
     */
    static function getInfo($xmlFile, $LogoImage, $htmlSource = null, $Title = null) {

        $html = null;

        $xml = new XmlJoomlaFunctions();
        $xml->LoadFile($xmlFile);

        $Auth = '<b>' . $xml->author . '</b>';
        $UrlAddr = '<a href="http://' . $xml->authorURL . '" target="_blank">' . $xml->authorURL . '</a>';
        $Email = '<a href="mailto:' . $xml->authorEmail . '">' . $xml->authorEmail . '</a>';
        $Logo = '<a href="http://' . $xml->authorURL . '" target="_blank"><img src="' . $LogoImage . '" alt="logo"/></a><br/><br/>';
      
$htmlDescription = <<<htmlDescription
        $Logo
        <h3><a href="http://www.e-logism.gr" title="E-Logism Software Developent" target="_blank" >E-Logism</a> $xml->name</h3>
        <hr align="left" width="30%"><br/>
htmlDescription;
        $html = $htmlDescription;
        $html .=  "Extension: "  . $xml->name . "<br />";
       

        $html .= "Version: " . $xml->version . " (" . $xml->creationDate . ")<br/>";
        $html .= $xml->copyright . "<br/><br/>";
        $html .= "Description: " . $xml->description . "<br/><br/>";
        $html .= "Development by: <a href=\"http://www.e-logism.gr\" title=\"E-Logism Software development\"  target=\"_blank\"  >" . $Auth . "</a><br/>";
        $html .= "Email Address: " . $Email . "<br/>";

        return $html;
    }


    /**styles **/

    /**
     * @param boolean $frontEnd wether to look on the front end or the back end.
     * this function returns an array of css files either in the front or in the backend of the component
     *
     */
    static function getCSSFiles($frontEnd = "1",$extension="" ){
        if($extension == "")
        {
            if($frontEnd == "1")
                $extPath = JPATH_COMPONENT_SITE;
            else
                $extPath = JPATH_COMPONENT_ADMINISTRATOR;
        }else {
            if($frontEnd == "1")
                $extPath = JPATH_SITE . DS . $extension;
            else
                $extPath = JPATH_ADMINISTRATOR . DS . $extension;
        }
       $cssPaths = JFolder::files($extPath,".css",true,true);
       $cssExtFiles = array();
       foreach($cssPaths as $cssPath){
           $cssExtFiles[] = array(str_replace($extPath,"",$cssPath), $extPath);
       }
       unset($cssPath);
       return $cssExtFiles;
    }
    
    
    /**
     *  Adds the paramters Options button for the component. It considers 
     * the acl permission for showing the button or not. It also show the acl configuration 
     * along with the component's parameters.
     */
    static function getOptionsToolbar()
    {
        $component =JComponentHelper::getComponent(JRequest::getWord('option'));
        if (JFactory::getUser()->authorise('core.admin', $component))
        {
            JToolBarHelper::preferences( $component->option);
        }
    }
    
    
        
        
    
    
     /**
     * This function return an array with info about an extenion name. If no info found or 
     * or an error occurs the array returns with empty values.
     * 
     * @param string $extension: The name of the extension in the form com_mycomponent for which
     * we want the metada. If no value supplied it read the option value form the JRequest.
     * @return  array. Returns an array with info about the requested extension.
     *  <br />Curently info returned : <br />
     *      <ul><li>typeFolder</li><li>prefix</li><li>name</li></ul>
     * 
     */
    
    public static function getExtensionInfo($extension ="")
    {
        if ($extension == "" )
        {
            $ext = JRequest::getVar("option","");
        }
        else {
            $ext = $extension;
        }
        $info["typeFolder"] = "";
        $info["prefix"] = "";
        $info["name"] = $ext;
        $pos = strpos($ext,"_");
        if($pos > 0 )
        {
            $prefix = substr($ext,0,$pos);
            $info["prefix"] = $prefix;
            switch($prefix)
            {
                case "com" : $info["typeFolder"] = "components";
                    break;
                case "mod" : $info["typeFolder"] = "modules";
                    break;
                case "plg" : $info["typeFolder"] = "plugins";
                    break;
            }

        }
        return $info;
    }
}?>