<?php
/**
 * @author e-logism
 * @copyright (c) elogism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.1 2012-09-12
 **/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controllerform');
require_once JPATH_COMPONENT . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS ."Languages.php";

class ElgPedyControllerlangs extends JControllerForm{


    function edit($key=null,$urlVal = null){
        JRequest::setVar('view','langedit');
        parent::display();
    }

    function cancel($key=null){
        JRequest::setVar('view','langs');
        JRequest::setVar('task','');
        parent::display();
    }

    function save($key=null, $urlVal = null){
        $language =  JRequest::getVar('lang','');
        $keys = JRequest::getVar('key', false, '', 'array');
        $values = JRequest::getVar('val',false,'','array');
        $cnt = count($values);
        for($i = 0; $i < $cnt; $i ++)
        {
            $values[$i] = '"' . $values[$i] . '"';
        }
        $langs = new Languages();
        $filePath = JRequest::getVar("fl");
        $results = explode(";",$langs -> update($filePath,$keys,$values));
        $app = JFactory::getApplication();
        if($results[0] > 0 || $results[1] > 0){
            $message = "<div style=\"margin-left:30px;text-indent:0\" >";
            if ($results[0] > 0 )$message .= JText::_('COM_ALUMINCOCC_NEW_ROWS') . ': ' . $results[0] . '<br />';
            if ($results[1] > 0) $message .= JText :: _('COM_ALUMINCOCC_UPDATES_ROWS') . ': ' . $results[1] . '<br />';
            $message .= "</div >";
            $app -> enqueueMessage($message);
        }
        if($results[2] > 0){
            $warningMessage .= JText::_('COM_ALUMINCOCC_SKIPED_ROWS'). ': ' . $results[2];
            JError::raiseWarning('101',$warningMessage);
        }
        JRequest::setVar('view','langedit');
        JRequest::setVar('task','edit');
        parent::display();
   }

    function add(){
        JRequest::setVar("view","addconstant");
        parent::display();
    }

    function addLang(){
        JRequest::setVar("view","langs");
        $dnum = str_replace("tmplLanguage", "", JRequest::getVar('langDrop',''));
        $tmplLangFile = JRequest::getVar('tmplLanguage' . $dnum);
        $tmplTag = basename(dirname($tmplLangFile));
        $langTag = JRequest::getVar('lang' . $dnum);
        $newFile = str_replace($tmplTag, $langTag, $tmplLangFile);
        $newDir =  dirname($newFile);
        if(!file_exists($newDir)) mkdir($newDir);
        copy($tmplLangFile, $newFile);
        parent::display();
    }

    function remove(){
        $remIDs = JRequest::getVar('cid',false,'','array');
        $langs = new Languages();
        $language = JRequest::getVar('lang','');
        $keys = JRequest::getVar('key', false, '', 'array');
        $filePath =   JRequest::getVar("fl","");
        $results = $langs -> remove($filePath,$keys,$remIDs);
        if($results > 0){
            $app = JFactory::getApplication();
            $message = JText::_('COM_ALUMINCOCC_DELETED_ROWS') . ': ' . $results . '<br />';
            $app -> enqueueMessage($message);
        }
        parent::display();
    }
}
?>