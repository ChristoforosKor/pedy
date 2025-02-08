<?php

/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 2.0.0 2012-09-10
 * */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS . "JoomlaUtilities.php");

class ElgPedyViewStyles extends JView {

    function display($tpl = null) {
        $option = JRequest::getVar("ext","");
        $frontEnd = JRequest::getVar("frontEnd", true);
        if($option == "") $option = JRequest::getVar("option");
        $cssFiles = JoomlaUtilities::getCSSFiles($frontEnd, 'components' . DS . $option);
        $this->canDo = alumincoccHelper::getActions();
        if (count($errors = $this->get('Errors'))) 
        {
           JError::raiseError(500, implode('<br />', $errors));
           return false;
        }
        $this->addToolBar();
        $this->setDocument();
        $this->assignRef('cssFiles', $cssFiles);
        $this->assignRef('ext', $option);
        $this->assignRef('frontEnd', $frontEnd);
        parent::display($tpl);
    }
    
        /**
         * setting the toolbar.
         */
        protected function addToolBar() 
        {
            JToolBarHelper::title(JText::_('COM_ALUMINCOCC_CSS') . ': <small><small>[ ' . JText::_('COM_ALUMINCOCC_EXTNAME') . ' ]</small></small>','alumincocc');
            if ($this->canDo->get('core.edit')) 
            {
                JToolBarHelper::editList('styles.edit', 'JTOOLBAR_EDIT');
            }
            if($this->canDo->get('core.admin'))
            {
                JToolBarHelper::divider();
                JoomlaUtilities::getOptionsToolbar();
            }
        }

        
        /**
        * Method to set up the document properties
        *
        * @return void
        */
        protected function setDocument()
        {
            $doc = JFactory::getDocument();
            $doc->setTitle(JText::_('COM_ALUMINCOCC_ADMINISTRATION_STYLES'));
            $script = "Joomla.submitbutton = function(task)
                    {
                        if (task == '')
                        {
                                return false;
                        }
                        else
                        {
                             var action = task.split('.');
                             var found = false;
                             if(action[1] == 'edit')
                             {
                                var radios = $$('td.check-cell input[type=radio]');
                                for(var i = 0 ; i < radios.length; i ++){
                                    if(radios[i].getProperty('checked') == true ){
                                        found = true;
                                        var flElm = $('fl' + radios[i].getProperty('id').replace('cb',''));
                                        var langElm = $('lang' + radios[i].getProperty('id').replace('cb',''));
                                        $('fl').setProperty('value',flElm.getProperty('value'));
                                         
                                    }
                                }
                             }
                             if (found)
                            {
                                   Joomla.submitform(task);
                                   return true;
                            }
                        }
                    }";
            $doc->addScriptDeclaration($script);
            $doc->addStyleSheet('components/com_alumincocc/libraries/e-logism/joomla/styles/styles.css');
        }
}

?>