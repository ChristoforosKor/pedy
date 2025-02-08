<?php
/**
 * e-logism's com_elgcomponent.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewProlepsisCommunityDataEditSave extends view
   {
		public function render()
		{
			// $data = $this->state->get('data');
			// $struct1 = array();
			// $lHUID = 0;
			// $lCTID = 0;
			// foreach($data as $healthUnit)
			// {
				// if($lHUID != $healthUnit['HealthUnitId'])
				// {
					// $lHUID = $healthUnit['HealthUnitId'];
					// $struct1[$lHUID] = array('unit'=>$healthUnit['HelathUnit'], 'clinics'=>array());
				// }
				// if($lCTID != $healthUnit['ClinicTypeId'])
				// {
					// $struct1[$lHUID]['clinics'][] = array(')
				// }
			// }
			// unset($heathUnit);
			// var_dump($data);
			//$this->dataLayout = 'clinictransactiondataedit.php';
			//$this->formAction = 'index.php?option=com_elgpedy&controller=regionalunitdataeditsave&Itemid=' . $this->state->get('Itemid');
			// return parent::render();
		}
   }