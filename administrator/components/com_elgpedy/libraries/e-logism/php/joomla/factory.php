<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );

 /**
  * Class with factory methods.
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  */


class Factory
{
    
   

    
    
    /**
     * Factory method that return the proper controller object for the job. If the controler we specify does not exists returns the default controller
     * from e-logism/php/joomla/controller directory.
     * @param string $controllerName The name of the controller we want.
     * @param string $prefix The prefix to the controler name.
     * @param JInput $input The JInput object to pass into the controller constructor.
     * @param JApplicationBase $app The JApplicationBase object to pass into the controller constructor. 
     * @param Array $paths An array with the paths where we will search to find the controller file.
    
     * @return JControllerBase A subclass of the jControllerBase that is our controlles.
     */
    public static function getController($controllerName, $prefix='', JInput $input = null, JApplicationBase $app = null, Array $paths = null)
    {
        $controller = null;
        if($paths === null) 
        {
            $paths = array(JPATH_COMPONENT . '/controllers/');
        }        
        foreach($paths as $path)
        {
            if (file_exists($path . strtolower($controllerName) . '.php'))
            {
                require $path . strtolower($controllerName) . '.php';
                $controller = $prefix . 'Controller' . $controllerName;
                break;
            }
        }
        unset($path);
        return ($controller === null ? self::getDefaultController($input, $app) : new $controller($input, $app));       
    }
    
    /**
     * Foactory method for the default controller e-logism/php/joomla/controller/default.php.
     * @param JInput $input
     * @param JApplicationBase $app
     * @return JController The default controller.
     */
    public static function getDefaultController(JInput $input, JApplicationBase $app)
    {
        require JPATH_COMPONENT_ADMINISTRATOR . '/libraries/e-logism/php/joomla/controllers/default.php';
        return new ControllerDefault($input, $app);    
    }
    
    /**
     * Factory method that return the proper JModel object. If the model we specify does not exists returns a JModelBase object
     * @param string $prefix The prefix to the model name.
     * @param string $modelName The name of the model we want.
     * @param JRegistry $state The JRegistry object to pass into the model constructor.
     * @param array $paths An array with the paths where we will search to find the model file.
     * @return JModel The JModel object created.
     */
    public static function getModel($prefix, $modelName, JRegistry $state = null, Array  $paths = null)
    {
        $model = null;
        if($paths === null)
        {
            $paths = array(JPATH_COMPONENT . '/models/');
        }
        foreach($paths as $path)
        {
            if(file_exists($path  . strtolower($modelName) . '.php'))
            {
                require $path  . strtolower($modelName) . '.php';
                $model = $prefix . 'Model' . $modelName;
                break;
            }
        }
        unset($path);
        return ($model === null ? self::getDefaultModel($state) : new $model($state));
    }
    
    /**
     * Factory method for the default model
     * @param JRegistry $state The JRegistry object passed to objecet contructor
     */
    public static function getDefaultModel(JRegistry $state = null)
    {
        require JPATH_COMPONENT_ADMINISTRATOR .  '/libraries/e-logism/php/joomla/models/default.php';
        return new ModelDefault($state);
    }
    
    
    /**
     * Factory method that return the proper JView object. If the vew we specify does not exists returns the default JView object
     * from the e-logism/php/joomla/views directory.
     * @param string $prefix The prefix to the view name.    
     * @param string $viewName The name of the view we want. 
     * @param JModel $model The JModel object to pass into the view constructor.
     * @param array $paths An array with the paths where we will search to find the view file.
     * @param string $format The format ove the view.
     * @return JView The JView object created.
     */
    public static function getView($prefix, $viewName, JModel $model = null, Array $paths = null, $format = 'html')
    {
        if($paths === null)
        {
            $paths = array(JPATH_COMPONENT . '/views/');
        }
        $view = null;
        foreach($paths as $path)
        {
            if(file_exists($path . strtolower($viewName) ))
            {
                require $path . strtolower($viewName) . '/view.' . $format . '.php';
                $view = $prefix . 'View' . $viewName;
                break;
            }
        }
        unset($path);
        return ($view === null ? self::getDefaultView($model) : new $view($model));
    }
    
    /**
     * Factory for the default view
     * @param JModelBase $model The JModel object passed to the contructor.
     * @return libraries/e-logism/php/joomla/views/view The default view.
     */
    public static function getDefaultView(JModelBase $model)
    {
        require JPATH_COMPONENT_ADMINISTRATOR . '/libraries/e-logism/php/joomla/views/view.php';
        return new View($model);
    }
    
    
}

