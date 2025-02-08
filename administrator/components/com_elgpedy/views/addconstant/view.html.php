<?php
/*------------------------------------------------------------------------
# com_alumincocc - e-logism library
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.com
# Technical Support: http://www.e-logism.gr/index.php?main_page=contact_us&zenid=5q08u7hbg8f4eitc4hb8dfmlq5
 
----------------------------------**/

 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 jimport( 'joomla.application.component.view');
 class ElgPedyViewAddConstant extends JView {

    

    function display($tpl = null) {
        $option = JRequest::getVar("option");
        $request_url = "option=" . $option . "&view=langs&controller=langs&task=edit";
        $inilang = JRequest::getVar('lang', '');
        $filePath =  JRequest::getVar("fl","");
        $langContents = file_get_contents($filePath);
        $pat = "/LBL_LEVEL\d+/";
        $maxLevel = 0;
         $this->canDo = alumincoccHelper::getActions();
        if (count($errors = $this->get('Errors'))) 
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        $this->addToolBar();
        $this->setDocument(); 
        if (preg_match_all($pat, $langContents, $matches) != 0) {
            foreach ($matches[0] as $mtc) {
                $newLevel = str_replace("LBL_LEVEL", "", $mtc);
                if ($newLevel > $maxLevel)
                    $maxLevel = $newLevel;
            }
        }
        $newLevel = "LBL_LEVEL" . ($maxLevel + 1);
        $this->assignRef('request_url', $request_url);
        $this->assignRef('newLevel', $newLevel);
        $this->assignRef('inilang', $inilang);
        parent::display();
    }
    
     /**
    * setting the toolbar.
    */
    protected function addToolBar() 
    {
                                        
       JToolBarHelper::title(JText::_('COM_ALUMINCOCC_ADD_LANG_CONSTANT') . ': <small><small>[ ' . JText::_('COM_ALUMINCOCC_EXTNAME') . ' ]</small></small>', substr(JRequest::getWord("option"), 4));
        
        
        if($this->canDo->get('core.delete'))
        {
            JToolBarHelper::deleteList(JText::_('COM_ALUMINCOCC_DELETE_CONSTANT_CONFIRM'),'langs.remove');
        }
        if($this->canDo->get('core.edit'))
        {
            JToolBarHelper::save('langs.save');
        }
        JToolBarHelper::cancel('langs.cancel');
    }
    
    
    /**
     * Method to set up the document properties
    *
    * @return void
    */
    protected function setDocument()
    {
        $doc = JFactory::getDocument();
        $doc->setTitle(JText::_('COM_ALUMINCOCC_ADMINISTRATION_LANGS_ADD_CONSTANT'));
        $doc->addStyleSheet( 'components/alumincocc/libraries/e-logism/joomla/styles/styles.css' );
        $script = "function submitbutton(pressbutton) {\n
                        if (pressbutton == 'cancel') {\n
                           submitform(pressbutton);\n
                       }else{\n
                          var f = document.adminForm;\n
                           if (document.formvalidator.isValid(f)) {\n
                               submitform(pressbutton);\n
                           }else {\n
                               var msg = new Array();\n
                               msg.push('" . JText::_("ERROR_INVALID_INPUT") . "');\n
                               alert (msg);\n
                           }\n
                       }\n
                    }";
        $doc->addScriptDeclaration($script);
    }

 
}
/**
  
 * * @todo When adding new constant the user must be able to define his own language key.
 **/
?>