<?php
/**
 * @author e-logism
 * @copyright (c) elogism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 2.0.1 2012-09-12
 **/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');


class ElgPedyControllerStyles extends JController{

    function display($cachable = false,$urlparams = false) {
        JRequest::setVar("view", "styles");

        parent::display($cachable, $urlparams);
    }

    function edit($cacheable=false, $urlparams = false){
        JRequest::setVar("view","styleedit");
        parent::display($cacheable, $urlparams);
    }
    function save($cacheable=false, $urlparams = false){
        $fl = JRequest::getVar("fl","");
        if(JRequest::getVar("frontEnd","1") == "1" ){
            $flPath = JPATH_COMPONENT_SITE;
        }else{
            $flPath = JPATH_COMPONENT_ADMINISTRATOR;
        }
        $app = JFactory::getApplication();
        if($fl != ""){
            $handle = fopen($fl, "w");
            fwrite($handle, JRequest::getVar("extstyle",""));
            fclose($handle);
            $app -> enqueueMessage(JText::_('COM_ALUMINCOCC_FILE_SAVED_SUCCESS'));
        }else{
            $app -> enqueueMessage(JText::_('COM_ALUMINCOCC_ERROR_FILE_NOTGIVEN'));

        }
         parent::display($cacheable, $urlparams);
    }

    function cancel(){
        JRequest::setVar('view','styles');
        parent::display();
    }


}
?>