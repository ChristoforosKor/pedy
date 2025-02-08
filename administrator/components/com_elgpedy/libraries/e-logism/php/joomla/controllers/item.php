<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require __DIR__ . '/default.php';
 /**
  * Controller that check for access view level existance.
  * @package libraries.e-logism.php.joomla
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class ControllerItem extends ControllerDefault
{
      	
    public function __construct($input = null, $app = null) 
    {
        parent::__construct($input, $app);
       
        
        if($input->get('appData', null, 'ARRAY')['Itemid'] === 0)
        {
            throw new Exception(JText::_('COM_ELG_NO_VALID_ACCESS_TYPE_SUPPLIED'));            
        }
    }    
}

