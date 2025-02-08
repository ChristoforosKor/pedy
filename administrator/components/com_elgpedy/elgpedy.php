<?php
/**
 * com_ElgComponent : Component application by e-logism.
 * @author e-logism <info@e-logism.gr>
 * @copyright (C)  2013, e-logism.gr
 */


defined( '_JEXEC' ) or die( 'Restricted access' );
JLoader::register('ComponentUtils', __DIR__ . '/componentutils.php');
require __DIR__ . '/libraries/php/joomla/e-logism/controllers/controller.php';
$controller = new Controller();
$controller->execute();
