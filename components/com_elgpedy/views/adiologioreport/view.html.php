<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
    defined( '_JEXEC' ) or die( 'Restricted access' );
    require_once JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
   
   class ElgPedyViewAdiologioReport extends View
   {
        public function render()
        {
                $data = $this->state->get('data');
                $this->rafinaData = $data['rafinaAttendance'];
                $this->rafinaForm = $this->state->get('forms')['adiologioReport'];
                $this->personelData = $data['personel'];
                $this->setLayout('adiologioreport');    
                JHtml::script('media/com_elgpedy/js/moment.min.js');
                JHTML::stylesheet('media/com_elgpedy/css/bootstrap-table.min.css');
                JHTML::stylesheet('media/com_elgpedy/css/select2.css');
                JHTML::stylesheet('media/com_elgpedy/css/select2-bootstrap.css');
                JText::script('COM_ELG_PEDY_PERSONEL');
                $this->editURL = JRoute::_('index.php?Itemid=156');
                $doc = JFactory::getDocument();
                $doc->addScriptDeclaration("var delUrl = '" . JRoute::_('?option=com_elgpedy&view=adiologioreportdelete&Itemid=158&format=json&id=#') . "'");
                return parent::render();
        }
   }
