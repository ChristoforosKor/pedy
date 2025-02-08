<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  //require JPATH_COMPONENT . '/views/viewlist.php';
  require JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewPersonels extends View
   {
	public function __construct(\JModel $model) 
        {
            parent::__construct($model);
            
            $doc = JFactory::getDocument();	
            $doc -> addStyleSheet('media/node_modules/bootstrap-table/dist/bootstrap-table.min.css');
            //$doc->addScriptDeclaration('elgview=\'' . $this->escape($this->state->get('view') .'\';elgItemid=' . $this->escape($this->state->get('Itemid')) . ';') . ' function getIdFromTable(src){return src.parentNode.parentNode.id.replace(\'row\',\'\');}');
           
            
            //$doc->addScript('media/com_elgpedy/js/submitions.js');
            JText::script('COM_ELG_EDIT');
            JText::script('COM_ELG_DELETE');
        }	
   }