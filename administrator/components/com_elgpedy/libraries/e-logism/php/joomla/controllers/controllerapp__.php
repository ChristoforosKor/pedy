<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require __DIR__ . '/controller.php';
 require __DIR__ . '../factory.php';
 /**
  * Base controller for all controllers.
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class ControllerApp extends Controller{
    
    protected $appData;
    
    public function __construct($input = null, $app = null) {
        parent::__construct($input, $app);
        $this->setinitAppData();
    }
        
    protected function setInitAppData()
    {
        $this->appData = self::initAppData($this->cmsData);
    }
    
    
    /**
     * Initializes controller, view, model to default values other than empty strings. These default values are
     * view: The component's name without the 'com_' prefix.
     * controller : The name of the view 
     * model: The controller's name
     * All the above values take place only when the user has not supplied values for the corresponding variables.
     * @param array $requestData User's requested data as an array.
     * @return array The basic values of joomla cms componet initialized to default values.
     * 
     */
    public static function initAppData(Array $requestData) 
    {
        $a = array_merge(array(), $requestData);
        $a['componentname'] = str_replace('com_', '',$a['option']);
        if($a['view'] === '')
        {
            if ($a['controller'] === 'default')
            {
                $a['view'] = str_replace('com_', '', $a['option']);
            }                
        }
        if($a['controller'] === '' )
        {
            $a['controller'] = $a['view'];                    
            
        }
        
        if($a['model'] === '')
        {
            $a['model'] = $a['controller'];
        }           
        return $a;
    }
           
    /**
     * Strategy method to be executed on the proper subclass.
     */
    public function execute() {
        $controller = Factory::getController($this->appData['controller'], $this->appData['componentname']);
        $controller->execute();
    }
}
?>
