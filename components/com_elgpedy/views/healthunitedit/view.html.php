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
   class ElgPedyViewHealthUnitEdit extends View
   {
		public function render()
		{
			
			$this->formAction = JRoute::_('index.php?option=com_elgpedy&controller=healthuniteditsave&Itemid=' . $this->state->get('Itemid'),  false);
			$this->form = $this->state->get('form');
			return parent::render();
		}
   }