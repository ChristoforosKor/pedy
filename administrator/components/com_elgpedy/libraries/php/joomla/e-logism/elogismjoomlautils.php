<?php
/**
 * General Joomla utitlies .<br/>
 * @author Christoforos J. Korifidis
 * @copyright (c) e-logism 2013-2014. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

require_once __DIR__ . '/../../phputils.php';
class ELogismJoomlaUtils extends PHPUtils 
{

    /**
     * Returns Current Languge ID for use in sef e.g. "el".
     * @return Sting language sef indicator
     */
    public static function getLanguageSefTag()
    {
        $languages = JLanguageHelper::getLanguages();
        $lang_code = JFactory::getLanguage()->getTag();
        return $languages[$lang_code]->sef;
    }

    /**
      * This function converts a value to literally "Yes" or "No" or "Not set". The value is converted 
      * according to these rules:
      * 1. If the $conVal is -1 or "" then is converted to "Not set", (Component translatable constant COM_ELG_NOTSET).
      * 2. 0 or false then is converted to "No", (CMS translatable constant JNO).
      * 2. Anything else is converted to "Yes", (CMS translatable constant JYES).
      * @param Mixed $intVal The value we want to convert.      
      * @return String. The litteraly "Yes" or "No" or "Not set".
      */
     public static function getYesNo($conVal) {
        if ($conVal == -1 || $conVal == "") {
            return JText::_('COM_ELG_NOT_SET');
        }
        elseif ($conVal == 0 || $conVal == "" || $conVal === false ) {
            return JText::_('JNO');
        }
        else {
            return JText::_('JYES');
        }
    }
    
    
    /**
     * This function queues errors for showing later in the application and returns the status of the proccess. So if there where really queed errors 
     * it returns TRUE otherwise it returns FALSE.
     * @param Array $errors An Array containing the errors to be queued.
     * @return BOOLEAN The status of the proccess when the proccess has finished. 
     */
    public static function canQueueErrorsMessages($errors = array(), $noErrorMessage='') {
        $status = false;
        $app = JFactory::getApplication();
        if (is_array($errors)) 
        {
            if(count($errors) >0) 
            {
                $cnt = count($errors);
                for ($i = 0; $i < $cnt ; $i++) 
                {
                    if ($errors[$i] instanceof Exception) {
                        $app->enqueueMessage($errors[$i]->getMessage(), 'error');
                        $status = true;
                    }
                    else
                    {
                        $app->enqueueMessage($errors[$i], 'error');
                        $status = true;
                    }
                }
            }
        }
        else 
        {
                $app->enqueueMessage($noErrorMessage);
        }
        return $status;
    }
    
    /**
     * Zpis the contents of a folder.
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
    
    /**
     * Deletes a directory and its contents
     * @param string $dirPath The directory to delete.
     * @throws InvalidArgumentException
     */
     public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            JLog::add("$dirPath must be a directory", JLog::ERROR, 'importer');
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    
    
    
    /**
     * This function returns the pagination object to be used on data lists.
     * @param INT $totalRecords Total number of records retrieved.
     * @param INT $limitStart The current page.
     * @param INT $limit The number of records a page should have.
     * @return JPagination $pagination the paginatoin object.
     */
    public static function getPagination($totalRecords, $limitStart=0, $limit=null) {
        if($limit == null) {
            self::getComponentParams()->get('listLimit', 50);
        }
        $pagination = new JPagination($totalRecords, $limitStart, $limit);
        $pagination->setAdditionalUrlParam('cp', 1);
        return $pagination;
    }
    
    /**
     * Resizes the dimensions of an Image
     * @param String originalFile Path to the original fiel to resize. 
     * @param String destinationFile Full image path where the new resized image will be stored.
     * @param Int width The new width of the image.
     * @param Int height The new height of the image.
     */
    public static function resizeImage($originalFile, $destinationFile, $width, $height) {
      
        $image = new JImage($originalFile);
        
        if($image->getWidth() > 0)
        {
            $properties = JImage::getImageFileProperties($originalFile);
            $resizedImage = $image->resize($width, $height, true);
            $resizedImage->toFile($destinationFile, $properties->type);
        }
    }    
    
    /**
     * Fromats a datetime string 
     * @param String date. The date to be formated.
     * @param Strnig format. The new format of the date.
     * @param type $localeCategory
     * @param type $localerLang
     * @return String. The new formated date.
     */
//    public static function getDateFormated($date='0000-00-00',$format='d/ m/ Y', $localeCategory = null, $localerLang = null) 
//    {
//           if(strtotime($date))   
//        {
//            return date($format, strtotime($date));
//            
//        }
//        else {
//            return JText::_('COM_ELG_NOT_SET');
//        }
//    }
    
    
    
    
    /**
    * rdirect to obect redirect url;
    */
    public static function redirect($redirectUrl, $msg='') {
        if ($redirectUrl != '' ) 
        {
            JFactory::getApplication()->redirect($redirectUrl, $msg);
        }
    }
	
	
}
