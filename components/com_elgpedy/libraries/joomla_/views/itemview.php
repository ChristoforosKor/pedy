<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/joomla/views/view.php';
 
 /**
  * Base class for all item views.
  * @package e-logism.joomla;
  * @subpackage views
  * @author Christoforos J. Korifidis
  * 
  */
 class  ItemView extends View
 {
    
    /**
     * This function redirect the user to the list associated with this view item if no value or zero value given for the id.
     */  
    
    protected function redirectOnNoId()
    {
      
        if($this->basicData['id'] == 0) 
        {
            CommonUtils::redirect($this->commonUrl . 'view=' . $this->basicData['view'] .'s');
        }
    }
 }
?>
