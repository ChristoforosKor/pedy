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
 class ElgPedyViewLangEdit extends JView{
      
      function display($tpl = null) {
        $option= JRequest::getVar("option");
        $request_url = "option=" . $option . "&view=langedit&controller=langs";
        $this->canDo = alumincoccHelper::getActions();
        if (count($errors = $this->get('Errors'))) 
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        $this->addToolBar();
        $this->setDocument(); 
        
        $langs = new Languages();
        $inilang =  JRequest::getVar('lang','');
        $tmplFile = Jrequest::getVar('fl','');
        $data = $langs->getLanguageConstants($tmplFile, $option,JRequest::getVar('frontEnd',"1"));
        if($data != false){
            $request_url .= "&task=langs.edit";
            $this->assignRef('request_url',$request_url);
            $this->assignRef('inilang',$inilang);
            $this->assignRef('data',$data);
            parent::display($tpl);
        }else{
            echo "<strong>" . JText::_("COM_ALUMINCOCC_NO_LANGUAGE_SELECTED") . "</strong>";
            }
    }
 
    /**
    * setting the toolbar.
    */
    protected function addToolBar() 
    {
                                        
        JToolBarHelper::title(JText::_('COM_ALUMINCOCC_LANG_CONSTANTS') . ': <small><small>[ ' . JText::_('COM_ALUMINCOCC_EXTNAME') . ' ]</small></small>', 'alumincocc');
       
        if($this->canDo->get('core.delete'))
        {
            JToolBarHelper::deleteList(JText::_('COM_ALUMINCOCC_DELETE_CONSTANT_CONFIRM'),'langs.remove');
        }
        if($this->canDo->get('core.edit'))
        {
            JToolBarHelper::save('langs.save');
        }
        if($this->canDo->get('core.create'))
        {
            JToolBarHelper::addNewX('langs.add');
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
        $doc->setTitle(JText::_('COM_ALUMINCOCC_ADMINISTRATION_LANGS_EDIT'));
        $doc->addStyleSheet( 'components/alumincocc/libraries/e-logism/joomla/styles/styles.css' );
        
    }

 }
 
 
 
  
/**
 * @todo When is empty a string not to be consider as validation error and making red borders.
 */
?>
