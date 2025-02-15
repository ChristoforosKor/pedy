<?php
namespace elogism;
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/

defined('_JEXEC') or die('Restricted access');

use elogism\controllers\ElJoomlaControllerFactory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;
use elogism\FileUtils;
use Joomla\CMS\Form\Form;

/**
 * Component initializer. It sanitate input data and execute the appropriate controller. 
 * In order to function there must be an Itemid upon which the View class name wil be found.
 * @author E - Logism
 * 
 */
class ELComponent
{
    
    /**
     * Initializes basic data needed by a component. Also sanitate data thought filters.
     * 
     * @param CMSApplication $app
     * @return CMSApplication $app Return the for chaining calls;
     */
    public static function normData( CMSApplication $app) {
    
        preg_match('/view=.*&/', $app -> getMenu() -> getActive() -> link, $test);
        $viewClassName = trim(str_replace('view=', '', $test[0]), '&' );
        $input = $app -> input;
        $input -> set ('option', $input -> getCMD('option', '') );
        $input -> set ('view', $viewClassName );
        $input -> set ('model', $input -> getCMD('model', $viewClassName) );
        $input -> set ('controller',  $input -> getCMD('controller', $viewClassName) );
        $input -> set ('layout',  $input -> getCMD('layout', $viewClassName) );
        $input -> set ('format',  $input -> getCMD('format', 'html') );
        $input -> set ('Itemid',  $input -> getInt('Itemid', 0) );
        $input -> set ('lang',  $input -> getCMD('lang', '') );
        $input -> set ('ctype',  $input -> getCMD('ctype', '') );
        $input -> set ('limit',  $input -> getInt('limit', 0) );
        $input -> set ('limit_start',  $input -> getInt('limit_start', 0) );
        $input -> set ('filter_order',  $input -> getCMD('filter_order', '') );
        $input -> set ('filter_order_Dir', $input -> getCMD('filter_order_Dir', '') );
        $input -> set ('id', $input -> getInt('id', 0) );
        return $app;
    }
    
        /**
         * Starts execution of the component
         */
        public static function init()
        {
                $app = CMSApplication::getInstance('site');
                Table::addIncludePath( JPATH_COMPONENT_ADMINISTRATOR . '/models/stores');
                Form::addFormPath(JPATH_COMPONENT_SITE . '/models/forms');
                Form::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');
                $lang = Factory::getLanguage(); 
                $lang -> load ( 'elogism', JPATH_SITE . '/libraries/elogism/language', $lang ->getTag() , true ) ;

                ElJoomlaControllerFactory::getController( 
                    self::normData(
                            $app
                            )
                    ) -> execute();
       }
       
    
    public static function getEndPointsItems( array $keys) : array
    {
        return FileUtils::getIniFileItems($keys, JPATH_COMPONENT_ADMINISTRATOR . '/endpoints.ini');
    }    
    
}
