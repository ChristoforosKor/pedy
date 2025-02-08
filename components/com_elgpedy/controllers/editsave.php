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
 
class EditSave extends Controller{
    protected $formData = null;
	protected $model = null;
	protected $state = null;
    protected $appData = null;
	public function __construct(\JInput $input = null, \JApplicationBase $app = null)
	{
		parent::__construct($input, $app);
		$this->formData = new stdClass();
        $this->appData = ComponentUtils::getAppData($input);
       	$this->state = new JRegistry($this->appData);
		$this->model = Factory::getModel($this->appData['componentname'], $this->appData['model']);
	}
}
