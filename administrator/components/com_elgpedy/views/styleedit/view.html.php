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
 jimport('joomla.filesystem.file');
 require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . "libraries" . DS . "e-logism" . DS . "joomla" . DS . "JoomlaUtilities.php");
 class ElgPedyViewstyleedit extends JView{

     function display($tpl = null) {
        $data = JFile::read(JRequest::getVar("fl"));
        $this->canDo = alumincoccHelper::getActions();
        if (count($errors = $this->get('Errors'))) 
        {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        $this->addToolBar();
        $this->setDocument();
        $this->assignRef('data',$data);
        parent::display($tpl);
     }
     
    /**
    * setting the toolbar.
    */
    protected function addToolBar() 
    {
        JToolBarHelper::title(JText::_('COM_ALUMINCOCC_STYLE_FILE') . ': <small><small>[ ' . JText::_('COM_ALUMINCOCC_EXTNAME') . ' ]</small></small>', 'alumincocc' );
        if ($this->canDo->get('core.edit')) 
        {
            JToolBarHelper::save('styles.save');
        }
        JToolBarHelper::cancel('styles.cancel');
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
        $doc->setTitle(JText::_('COM_ALUMINCOCC_ADMINISTRATION_STYLES_EDIT'));
    }
 }
 ?>