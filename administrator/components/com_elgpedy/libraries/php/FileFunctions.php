<?php

/**
 * Generics functions for manipulating files .<br/>
 * Created on 2012-02-02 <br/>
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.0.0
 */
class FileFunctions {

    /**
     * This function reads a file row by row and returns an array that its rows corresponds
     * in each row in the file. It is suitable for reding property files.
     * @param String $filePath the path of the file to read
     * @param boolean $rmBlanks wether or not to remove blank rows. Defaults to true.
     * @param boolean $addNewLine whether to add a new line character at the end of array. Defaults to true.
     * @param boolean $rmComments wether or not to return rows that begins with "#" or ";". Defaults to true.
     */
    function getFileRows($filePath, $rmBlanks = true, $adNewLine = true, $rmComments = true) {
        if (!JFile::exists($filePath)) {
            JError::raiseWarning('500', JText::_('FILE_NOT_FOUND') . " : \"" .  JFile::getName($filePath) . "\"");
            return false;

        } else {
            /** FILE_SKIP_EMPTY_LINES not working (php 5.3.1) **/
            if ($rmBlanks && ! $adNewLine){
                $content = file($filePath, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
            }elseif($rmBlanks && $adNewLine){
                $content = file($filePath,FILE_SKIP_EMPTY_LINES);
            }elseif(!$rmBlanks && !$adNewLine){
                $content = file($filePath,FILE_IGNORE_NEW_LINES);
            }else{
                $content = file($filePath);
            }

            if ($rmComments){
                $data = array();
                $recs = count($content);
                for ($row = 0; $row < $recs; $row++) {
                    if (substr($content[$row], 0, 1) != "#" and substr($content[$row], 0, 1) != ";" ) {
                        $data[] = $content[$row];
                    }
                }
                return $data;
            }else{
                return $content;
            }
        }
    }

}

?>
