<?php
/**
 * com_elgcomponent : elgcomponent application by e-logism.
 * @author e-logism <info@e-logism.gr>
 * @copyright (C)  2013, e-logism.gr
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JLoader::register('ComponentUtils', __DIR__ . '/componentutils.php');


require_once JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/controllers/controller.php';
JFormHelper::addFieldPath(	JPATH_ADMINISTRATOR . '/components/com_elgpedy/models/fields');
$controller = new Controller();
$controller->execute();