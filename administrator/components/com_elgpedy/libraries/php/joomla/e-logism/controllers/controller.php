<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once JPATH_COMPONENT . 'libraries/joomla/e-logism/factory.php';
 
 /**
  * Strategy controller that execute the execute method of the right subclass.
  * @package libraries.e-logism.php.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */

class Controller extends JControllerBase{
        
	/**
	 * 
	 * @Array requestData Holds then basic data for component entry poing as entered by the user after applying them filters for sanitation.
	 * Info about fitlers can be found here http://developer.joomla.org/manual/chap-Joomla_Platform_Manual-Input.html
	 * The data this array holds and their corresponding filters are  :
	 * (The list is in the form VARIABLE - FILTER - DEFAULT_VALUE)
	 * option WORD ''
	 * view WORD ''
	 * model WORD ''
	 * controller WORD ''
	 * layout WORD ''
	 * format WORD 'html'
	 * Itemid INT 0
	 * lang WORD ''
	 * limit WORD 20
	 * limit_start INT 0
	 * filter_order WORD ''
	 * filter_order_Dir CMD ''
	 * id INT 0
	 *   
	 */
	protected $inputData = null;
	
	
	    
	/**
	* Constructor that cheks access levels authorization or throws an error.
	*/
	function __construct(\JInput $input = null, \JApplicationBase $app = null) 
	{
		parent::__construct();
		//self::checkItemId($this->getInput()->getInt('Itemid',0), $this->getApplication());	
		$appData = self::initAppData(self::getFilteredData($this->getInput()));
		$this->getInput()->set('appData', $appData);	
		
	}
    
    
    public function execute() 
	{
		$controller = Factory::getController($this->getInput(), $this->getApplication());
		
		$controller->execute();
	}
	
	
	public static function getViewWithModel($appData)
	{
		return Factory::getView($appData['componentname'], $appData['view'],  Factory::getModel($appData['componentname'], $appData['model'], new JRegistry($appData)));
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
    public static function initAppData(Array $a) 
    {
        //$a = array_merge(array(), $requestData);
        $a['componentname'] = str_replace('com_', '',$a['option']);
        if($a['view'] === '')
        {
            $a['view'] = $a['componentname'];
        }
        if($a['layout'] === '')
        {
            $a['layout'] = $a['view'];
        }
        if ($a['controller'] === '') 
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
         * Gets user's data from the JInput and returns the basic data needed by a joomla component.
         * The data are sanitized by applying on them filters.
         *
         * @param JInput $input User's input
         * @return Array The sanitized data on the form of an array.
         * 
         * @see cmsData
         */
	public static function getFilteredData(JInput $input) {
            
            $o = array();
            $o['option'] = $input->getCMD('option', '');
            $o['view'] = $input->getCMD('view', '');
            $o['model'] = $input->getCMD('model', '');
            $o['controller'] = $input->getCMD('controller', '');
            $o['layout'] = $input->getCMD('layout', '');
            $o['format'] = $input->getCMD('format', 'html');
            $o['Itemid'] = $input->getInt('Itemid', 0);
            $o['lang']= $input->getCMD('lang', '');
            $o['limit'] = $input->getInt('limit', 20);
            $o['limit_start'] = $input->getInt('limit_start', 0);
            $o['filter_order'] = $input->getWord('filter_order', '');
            $o['filter_order_Dir'] = $input->getCMD('filter_order_Dir', '');		
            $o['id'] = $input->getInt('id', 0);
            return $o;
	}
	
	/**
	* Checks for access level authorization based on Itemid
	* @param INT $Itemid The Url Itemid in the users requestData
	* @param JApplicationBase The Application object of the controller.
	* @param STRING $errorUrl For future use. The url to redirect in case of no authorization.
	*/
	// public static function checkItemId($Itemid, $application, $errorUrl='')
	// {
		// if($Itemid === 0)
		// {			
			// JError::raiseError('501', JText::_('COM_ELG_NO_VALID_ACCESS_POINT'));
		// }
		// elseif($application->getMenu()->authorise($Itemid) !== true)
		// {
			// JError::raiseError('501', JText::_('COM_ELG_NO_VALID_ACCESS_POINT'));
		// }					
	// }
	
	
}

