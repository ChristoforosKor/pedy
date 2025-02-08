<?php
/**
 * e-logism's com_elgpedy.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  require JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewPersonelEdit extends View
   {
		public function render()
		{
                        $this -> Itemid = $this -> state -> get('Itemid');
			
			$this->formAction = JRoute::_('index.php?option=com_elgpedy&controller=personeleditsave&Itemid=' . $this -> Itemid ,  false);
			$this->form = $this->state->get('form');
			$this -> storedData = $this -> state -> get('storedData');
                        JText::script('COM_ELGPEDY_SEE_RECORDS_FOUND');
                        JText::script('COM_ELG_PEDY_50006_FILL_WITH_N_NUMBERS');
                        JText::script('COM_ELGPEDY_VALIDATE_BEFORE_SUMIT');
			return parent::render();
		}
   }