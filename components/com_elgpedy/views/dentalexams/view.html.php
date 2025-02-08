<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   class ElgPedyViewDentalExams extends DataCommon
   {
        
   	public function render()
        {
            
            $this->dataLayout = 'dentalexams.php';
            JFactory::getDocument()->addStyleDeclaration('.bootstrap-table .fixed-table-header th{padding-left:0; padding-right:0}  div.select2-container{width:190px}') ;
            JHTML::stylesheet('media/com_elgpedy/css/bootstrap-table.min.css');
            JHTML::stylesheet('media/com_elgpedy/css/select2.css');
            JHTML::stylesheet('media/com_elgpedy/css/select2-bootstrap.css');
            JText::script('COM_ELGPEDY_DATE');
            JText::script('COM_ELG_PEDY_SCHOOL_LEVEL');
            JText::script('COM_ELG_PEDY_SCHOOL');
            JText::script('COM_ELG_PEDY_DATE');
            JText::script('COM_ELG_PEDY_IS_MALE');
            JText::script('COM_ELG_PEDY_NATIONALITY');
            JText::script('COM_ELG_EDIT');
            JText::script('COM_ELG_PEDY_BIRTHDAY');
            JText::script('COM_ELG_PEDY_MOTHER_PROFESSION');
            JText::script('COM_ELG_PEDY_FATHER_PROFESSION');
            JText::script('COM_ELG_DELETE');
            $this->editUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=151', false);
            return parent::render();
        }
   }