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
 require_once (JPATH_COMPONENT . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS .  "Languages.php");
 require_once (JPATH_COMPONENT . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS .  "JoomlaUtilities.php");
 
 class ElgPedyViewlangs extends JView{

      function display($tpl = null) {
        $frontEnd = JRequest::getVar("frontEnd",true);
        $option= JRequest::getVar("option");
        $langFileNames = Languages::getLanguageFilesData($option, true, "com");
      
        $this->canDo = alumincoccHelper::getActions();
        if (count($errors = $this->get('Errors'))) 
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        $this->addToolBar();
        $this->setDocument();        
        $hasEmpty = 0;
        $this->assignref('option',$option);
        $this->assignRef('filesNames', $langFileNames);
        $this->assignRef('frontEnd',$frontEnd);
        $existsFiles = array();
        foreach($langFileNames as $langFileName){
            if($langFileName["langPath"] != "" )
                    $existsFiles[] = array($langFileName["langPath"], $langFileName["fileName"]);
                else
                    $hasEmpty = 1;
        }
        $this->assignRef("existsFiles", $existsFiles);
        $this->assignRef("hasEmpty",$hasEmpty);
        $this->assignRef("canDo",$this->canDo);
        unset($langFileName);
        unset($langFileNames);
        parent::display($tpl);
    }
    
    /**
    * setting the toolbar.
    */
    protected function addToolBar() 
    {
                                        
        JToolBarHelper::title(JText::_('COM_ALUMINCOCC_LANGUAGE') . ': <small><small>[ ' . JText::_('COM_ALUMINCOCC_EXTNAME') . ' ]</small></small>', 'alumincocc');
        if ($this->canDo->get('core.edit')) 
        {
            JToolBarHelper::editList("langs.edit");
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
        $doc->setTitle(JText::_('COM_ALUMINCOCC_ADMINISTRATION_LANGS'));
        $doc->addStyleSheet( 'components/com_alumincocc/libraries/e-logism/joomla/styles/styles.css' );
        $script = "Joomla.submitbutton = function(task)
                    {
                        if (task == '')
                        {
                                return false;
                        }
                        else
                        {
                            var action = task.split('.');
                            if(action[1] == 'edit')
                            {
                                var found = false;
                                var radios = $$('td.check-cell input[type=radio]');
                                for(var i = 0 ; i < radios.length; i ++){
                                    if(radios[i].getProperty('checked') == true ){
                                        found = true;
                                        var flElm = $('fl' + radios[i].getProperty('id').replace('cb',''));
                                        var langElm = $('lang' + radios[i].getProperty('id').replace('cb',''));
                                        $('fl').setProperty('value',flElm.getProperty('value'));
                                        $('lang').setProperty('value',langElm.getProperty('value'));    
                                    }
                                }
                                
                            }else if (task.substr(0,3) == 'ddn')
                            {
                                
                                var langDrop = task.replace('ddn','');
                                if($('tmplLanguage' + langDrop ).get('value')== '') return;
                                $('langDrop').set('value',langDrop);
                                task = 'langs.addLang';
                                found = true;
                            }
                            
                            if (found)
                            {
                                Joomla.submitform(task);
                                return true;
                            }
                        }
                    }";
         $doc -> addScriptDeclaration($script);
    }
/**
 * @todo to tranfer generated to the model somehow.
 * @todo place an index.html file on newly generated languages.
 */              
           }?>