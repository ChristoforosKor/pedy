<?php
/**
 * e-logism's library
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 /**
  * Base class for all views.
  * @package libraries.e-logism.php.joomla;
  * @subpackage views
  * @author Christoforos J. Korifidis
  * 
  */
 class  View extends JViewHTML
{
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
		parent::__construct($model, $paths);
		$paths = new   SplPriorityQueue();
		$paths->insert(JPATH_COMPONENT . '/layouts', 'normal');
		$this->setPaths($paths); 
		$this->setLayout($model->getState()->get('layout'));
	
    }   
}

