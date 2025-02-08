<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/joomla/views/itemview.php';
 
 /**
  * Base class for all delete views.
  * @package e-logism.joomla.libraries
  * @subpackage views
  * @author Christoforos J. Korifidis
  * 
  */
 class  ItemViewDelete  extends ItemView
 {
    protected $deleteMessage = '';
  
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
        parent::__construct($model, $paths);
        $this->deleteMessage = JText::_('COM_ELGERGON_DELETE_ASK');
        
    
    }
 }
?>
