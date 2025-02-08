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
        if($this->appData['Itemid'] === 0)
        {
            throw new Exception('COM_ELG_NO_VALID_ACCESS_TYPE_SUPPLIED');            
        }
    }    
		
	
}
?>
