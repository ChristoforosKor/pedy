<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism 
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
 
class QuantityDataEditSave extends Controller{
    protected $formData = null;
	protected $model = null;
	protected $state = null;
    protected $appData = null;
	protected $data = null;
	public function __construct(\JInput $input = null, \JApplicationBase $app = null)
	{
		parent::__construct($input, $app);
		$formData = new stdClass();
		$data = new stdClass();
		$this->appData = ComponentUtils::getAppData($input);
		$this->appData['RefMonth'] = $input->getInt('RefMonth', 0);
		$this->appData['RefYear'] = $input->getInt('RefYear', 0);
		$this->appData['RefDate'] = $input->getString('RefDate', '');
		$formData->RefMonth = $this->appData['RefMonth'];
		$formData->RefYear = $this->appData['RefYear'];
		$formData->HealthUnitId = $input->getInt('HealthUnitId', 0);
        $formData->RefDate = $input->getInt('RefDate', 0);
        $formData->Quantity = $input->getInt('Quantity', 0);
		
		$this->formData = $formData;
		$this->state = new JRegistry($this->appData);
		$data->hid = $input->getString('hid', '');
		$data->Quantity = $input->getInt('Quantity', 0);
		$this->state->set('data',$data );
		$this->model = Factory::getModel($this->appData['componentname'], $this->appData['model'], $this->state);
		
	}
}
