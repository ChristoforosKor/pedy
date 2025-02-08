<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require 'itemcontroller.php';
 
 
 /**
  * Base controller for all views
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */
 
 class ItemControllerView extends ItemController{
        
        protected $paths = null;
        protected $viewName = null;
        protected $view = null;
        
        public function __construct($input = null, $app = null) {
            parent::__construct($input, $app);
            $this->paths = new   SplPriorityQueue();
            $this->paths->insert(JPATH_COMPONENT_SITE . '/layouts', 'normal');
            require_once JPATH_COMPONENT . '/views/' . $this->basicData['view'] . '/view.' . $this->basicData['format'] . '.php';
        }
        
        public function execute() {
            
            $doc = JFactory::getDocument();
            $doc->addStyleSheet('media/' . $this->basicData['option'] . '/css/site.stylesheet.css');
            
            $viewClass = Utils::COMPONENT_NAME . 'View' . $this->basicData['view'];
            parent::execute();
           
            $view = new $viewClass($this->model, $this->paths);
            $view->setLayout($this->basicData['layout']);
            $view->basicData = $this->basicData;
            $this->view = $view;
           
            echo $this->view->render();
        }
        
        protected function setList($defaultOrder) {
            $this->basicData['filters'] += CommonUtils::getListParams($this->getInput(), $this->sessionNamespace, $defaultOrder);
        }
        
        protected function setSessionNamespace() {
            $this->sessionNamespace = $this->basicData['option'] . '.' . $this->basicData['model'];
        }
}
?>
