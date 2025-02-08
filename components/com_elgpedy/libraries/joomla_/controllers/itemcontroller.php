<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 /**
  * Base controller for all items.
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class ItemController extends JControllerBase{
      
        protected $redirectUrl = '';
        protected $basicData = array();
        protected $model = null;
        protected $requestedKeys = array();
        protected $session = null;
        protected $sessionNamespace = '';
        protected $commonUrl;
        
        public function __construct($input = null, $app = null) {
            parent::__construct($input, $app);
            $this->basicData = $this->input->get('basicData', array(), 'ARRAY');
            $this->commonUrl = "index.php?option=" . $this->basicData['option'] . '&Itemid=' . $this->basicData['Itemid'] . '&lang=' . $this->basicData['lang'];
            $this->session = JFactory::getSession();
            require_once JPATH_COMPONENT_SITE . '/models/' . $this->basicData['model']  . '.php';
            $modelClass = Utils::COMPONENT_NAME . 'Model' . $this->basicData['model'];
            $this->model = new $modelClass();  
            $this->setSessionNamespace();
            
        }    
      
        public function execute() {
            $this->model->setState(new JRegistry($this->basicData));
        }
		
		
       
        
        protected function setSessionNamespace(){
            $this->sessionNamespace = $this->basicData['option'] . '.' . $this->basicData['model'];
        }

        /**
         * redirect to object redirect url;
         */
        public function redirect() 
        {
          if ($this->redirectUrl != '' ) 
          {
               CommonUtils::redirect($this->redirectUrl);
          }
        }
}
?>
