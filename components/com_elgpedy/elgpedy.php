<?php
/**
 * com_elgcomponent : elgcomponent application by e-logism.
 * @author e-logism <info@e-logism.gr>
 * @copyright (C)  2013, e-logism.gr
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JLoader::register('ComponentUtils', JPATH_COMPONENT_SITE . '/componentutils.php');
JLoader::register('Queries', JPATH_COMPONENT_SITE . '/models/queries.php');
JFormHelper::addFieldPath(	JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');
JForm::addFieldPath(JPATH_COMPONENT_SITE . '/models/fields');
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
$controller = new Controller();

$controller->execute();
