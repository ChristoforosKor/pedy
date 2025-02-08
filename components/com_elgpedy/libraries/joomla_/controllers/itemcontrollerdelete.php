<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require 'itemcontrollerview.php';
 
 
 /**
  * Base controller for all views
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */
 
 class ItemControllerDelete extends ItemControllerView{
        
       
        
        public function __construct($input = null, $app = null) 
        {
            parent::__construct($input = null, $app = null);
            $inp = $this->getInput();
            $this->basicData['delPrev'] = $inp->getWord('delPrev','');
            $this->redirectUrl = '';
        }
}
?>
