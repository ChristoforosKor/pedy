<?php

/**
 * Functions for manipulating text constants on Joomla! cms .<br/>
 * Currently supports components or modules. <br />
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 2.0.0
 */

    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');
    jimport('joomla.language');
    require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "FileFunctions.php");
    require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS . "XMLJoomlaFunctions.php");
    require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS . "JoomlaUtilities.php");
    require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "Utils.php");



class Languages {

  
    /**
     * This function searches to find the files with text constants for an extension.
     * @param String $extname : Required. The extension name.
     * @param boolean $frontEnd : If true returns the front end text contstants files. Default true.
     * @return 2 dimension  Array with 3 columns : The array hold information about the language file as follow:<br />
     *  1st column folder e.g en-GB, 2nd column is the path of the file, 3d column the language filename.
     */
   public static function getLanguageFilesData($extName, $frontEnd=true) {
        $info = JoomlaUtilities::getExtensionInfo($extName); 
        $extensionLanguagePrivateFiles = self::getExtensionLanguagesPrivateFilesInfo(
                            self::getExtensionLanguagesPrivateFiles($frontEnd, $info["name"], $info["typeFolder"], $info["prefix"])
                        );
        $langs =  JLanguage::getKnownLanguages();
        $langData = self::getLanguagesInfo($langs, $extensionLanguagePrivateFiles) ;
        return $langData;
    }


   

     /**
     * This function returns the folder that holds all the language
     * files for the Joomla! cms, for the front end or the back end
     * depended on user choise.
     * @param bollean $frontEnd whether we want the languages files for the front end or the back end.
     * @return String the path to language folder
     */
    function getLanguagesFolder($frontEnd=true){
        if ($frontEnd)
            return JPATH_SITE . DS . "language";
        else
            return JPATH_ADMINISTRATOR . DS . "language";
    }


     /**
     * This function return the contents of a language *.ini.
     * Empty rows and commented rows are excluded.
     * @param String $inilang : Reuqired.The path to the inifile.
     * @param String $extension : Required. The extension (component, module, plugin) for which we want the language (*.ini) file.
     * @param boolean $frontend : Default true. Whether we want the language file for the back or the front end;
     * @return one dimensional array with one row for each row of the file
     */
    function  getLanguageConstants($langFile)
    {
        $fileFunctions = new FileFunctions();
        return  $fileFunctions->getFileRows($langFile, true, true, true);
    }

    /**
     *
     * function that saves or update the row of language inifile.
     * @param String $filePath the *.ini file path
     * @param array $keys array that contains the labels to be added or updated in the file. if the label exists in the file
     * its value will be updated otherwise it will be added.
     * @param array $values  the values that corresponds to each label.
     */
    function update($filePath,$keys,$values){
        $langContents = str_replace("'","&#039;",file_get_contents ( $filePath ));
        $recs = count($keys);
        $newRows = 0;
        $updatedRows = 0;
        $skipedRows = 0;
        for($row =0 ; $row < $recs; $row ++){
          if ($values[$row] != "" && $keys[$row] != "" ){
              
              $value = str_replace("'","&#039;",Utils::escapeRegChars($values[$row]));
              $key = str_replace("'","&#039;",Utils::escapeRegChars($keys[$row]));
              if (preg_match("'" . $key . "=" . $value ."$'m", $langContents) == 0){
                   $pat = "'" . $key . "=.*'";
                   if(preg_match($pat,$langContents) == 0){
                        $newRow = "\n" . $keys[$row] . "=" . $value;
                        $langContents .= $newRow;
                        $newRows = $newRows + 1;
                    }else{
                        $langContents = preg_replace ($pat , $key ."=" . $value  ,$langContents );
                        $updatedRows = $updatedRows + 1;
                    }
                }
           }else{
               $skipedRows = $skipedRows + 1;
           }
        }
        $this -> storeData($filePath,$langContents);
        return $newRows . ";" . $updatedRows . ";" . $skipedRows;
    }


     /**
     *
     * function that removes  rows of language inifile.\
     * @param String $filePath the *.ini file path
     * @param array $keys array that contains the labels curently in the *.ini file
     * @param array $remIDs  the indexes of the ones that have been marked for removal.
     */

    function remove($filePath,$keys,$remIDs){
        $langContents =  file_get_contents ( $filePath );
         $recs = count($remIDs);
         $matches="";
         $deletedRows = 0;
         for($row =0 ; $row < $recs; $row ++){
           $pat = "/" . $keys[$remIDs[$row]] . "=.*\n*/";
           if(preg_match($pat,$langContents,$matches) != 0){
               $langContents = preg_replace ($pat , ""  ,$langContents );
               $deletedRows = $deletedRows + 1;
            }
        }
        $this -> storeData($filePath,$langContents);
        return $deletedRows;
    }


    /**
     * helper function that rewrites a file with data
     * @param String $filePath the path to the physical file
     * @param String $langContents then actual data of the file
     */
    function storeData($filePath,$langContents){
        $Handle = fopen($filePath, 'w');
        fwrite($Handle, str_replace("&#039;","'",Utils::unEscapeRegChars($langContents)));
        fclose($Handle);
    }



    /**
     * Helper function for returning the path of the language constants file for a given option.
     *
     * @param boolean $frontEnd wether to search for the front end or the back end section.
     * @param String $language  the language code for which we want the language file
     * @param String $option the extension eg com_mycomponent
     */
//    function getLanguageFilePath($language,$option,$frontEnd =true ){
//       return  $this -> getLanguageFileFolder($language,$option,$frontEnd ) . DS . $language . "." . JRequest::getVar('option') . ".ini";
//    }


    /**
     * Helper function for returning the path of the folder that contains the language file.
     *
     * @param boolean $frontEnd wether to search for the front end or the back end section.
     * @param String $language  the language code for which we want the language file
     * @param String $option the extension eg com_mycomponent
     */
//    function getLanguageFileFolder($language,$option,$frontEnd =true){
//        return  $this -> getLanguagesFolder($frontEnd) . DS . $language ;
//    }

    
    
    
    
     /**
     * This function returns private language files of an extension. The search takes place
     * according to the parameters $extension, $typeFolder and $prefix. If one of these parameters 
     * is missing the search takes place according to JRequest option parameter. 
     * @param boolean $frontEnd : Whether we want the language files for the front-end files or the back-end. Posible values is 0 or 1.
     * @param string $extension: Extenion name without prefix eg "component".
     * @param string $typeFolder: The folder that this type of extenions resides e.g. modules.
     * @param string $prefix: The prefix of the extension for which we want the language files, e.g. "com".
     * @return array. The returned array contains the paths of language files
     */
    public static function getExtensionLanguagesPrivateFiles($frontEnd=true,$extension="", $typeFolder="",$prefix="")
    {
        if($extension == "" || $typeFolder == "" || $prefix == "" )
        {
            $info =  JoomlaUtilities::getExtensionInfo($extension);
        }
        else 
        {
            $info["typeFolder"] = $typeFolder;
            $info["name"] = $extension;
            $info["prefix"] = $prefix;
        }
        if($frontEnd == true)
        {
            $compPath = JPATH_SITE;
        }
        else
        {
            $compPath = JPATH_ADMINISTRATOR;
        }
        $extPath = $compPath .DS . $info["typeFolder"] . DS  . $info["name"] ;
        return JFolder::files($extPath ,".ini",true,true);
       
    }
    
    
    /**
     * This function get an array of languages files and reutrs an array with info about these files.
     * 
     * @param array $languagesFiles: The initial array with the languages files paths.
     * 
     * @return array.  The returned array contains the fields : <br />
     * <ul><li>langTag : the language tag e.g. "el-GR"</li>
     * <li> filePath : the full path to language file</li></ul>
     */
    public static function getExtensionLanguagesPrivateFilesInfo($languagesFiles)
    {
        $langData = array();
        foreach ($languagesFiles as $languageFile) {
            $fileDir = dirname($languageFile);
            $langTag = basename($fileDir);
            $langData[str_replace("/" . $langTag . ".", "", str_replace($fileDir,"", $languageFile))] [$langTag] = array(
                 "file" => $languageFile
                ,"langTag"=>basename($fileDir)
                ,"isFileWriteable" =>is_writable($languageFile)
                ,"isDirWriteable"=>is_writeable($fileDir)) ;
        }
        unset($languageFile);
        return $langData;
    }
    
    
    /**
     * This function returns an array that indicates which languages are installed on your system 
     * and the corresponding language of an extension if that language file exists. If it does not find 
     * a corresponding language for an a extension, it places the en-GB fle as a template.
     *
     * @param array $installedLanguages:  Languages already installed on your system. The format of this array 
     * must be in the form of the returned value of the privateLangaugesFiles function.
     * @param array $currentLanguages: Languages supported from an extension. 
     */
    public static function getLanguagesInfo($installedLanguages, $extensionLanguages)
    {
        $info = array();
        foreach($extensionLanguages as $extensionFileName=>$extensionLanguage )
        {
            foreach($installedLanguages as $installedLanguage)
            {
              
                $langFile = $extensionFileName;
                $tag = $installedLanguage["tag"];
                $langPath = "";
                $fileLabel = "";
                $isDirWriteable = true;
                $isFileWriteable = false;
                if(array_key_exists($tag, $extensionLanguage))
                {
                    $langPath = $extensionLanguage[$tag]["file"];
                    $isDirWriteable = $extensionLanguage[$tag]["isDirWriteable"];
                    $isFileWriteable = $extensionLanguage[$tag]["isFileWriteable"];
                    $fileLabel = str_replace(JPATH_SITE, "", $langPath);
                }
                    
                    $info[] = array(    "tag"=> $tag
                                        , "langPath"=>$langPath
                                        , "langFile" => $langFile
                                        , "fileName" => $tag . "." . $langFile
                                        , "isDirWriteable" =>  $isDirWriteable
                                        , "isFileWriteable" => $isFileWriteable
                                        , "fileLabel" => $fileLabel
                                    );
            }
        }
        unset($extensionLanguage);
        unset($extensionFileName);
        unset($installedLanguage);
        return $info;
    }
}
?>