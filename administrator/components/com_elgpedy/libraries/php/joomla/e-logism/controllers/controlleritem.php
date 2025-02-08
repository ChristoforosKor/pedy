<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 include __DIR__ .'/controllerapp.php';
 /**
  * Base controller for all controllers.
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class ControllerItem extends ControllerApp{
      
	
    protected function __construct($input = null, $app = null) 
    {
		parent::__construct($input, $app);
		$this->checkItemId($appData);
    }    
		
	public function checkItemId($appData, $errorUrl='')
	{
		$errorUrl = 'index.php?option=com_' . $appData['componentname'] . '&view=error&format=' . $appData['format'];
		$app = JFactory::getApplication();
		if($appData['Itemid'] === 0)
		{
			$app->enqueueMessage('COM_ELGERGASIA_NO_VALID_ACCESS_POINT');
			$app->redirect(JRoute::_($errorUrl, false));
		}
		elseif($this->getApplication()->getMenu()->authorise($appData['Itemid']) !== true)
		{
			$app->redirect($errorUrl);			
		}			
	}
}
