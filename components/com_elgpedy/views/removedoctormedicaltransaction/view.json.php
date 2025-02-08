<?php
/**
 * e-logism's com_elgcomponent.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */		
   class ElgPedyViewRemoveDoctorMedicalTransaction extends JViewHTML
   {
		public function render()
		{
			$this->setLayout('jsondataoutput');
			$qu = new SplPriorityQueue();
			$qu -> insert ( JPATH_COMPONENT . '/layouts/', 'normal');
			$this -> setPaths($qu);
            $this -> data = $this -> model -> getState() -> get('data', []) ;
			return parent::render();
		}
   }
