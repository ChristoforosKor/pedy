<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedy.php';

 
class ElgPedyModelHealthUnitEdit extends Pedy
{
	
    function getState() 
    {
		$state = parent::getState();
		JFormHelper::addFieldPath(	JPATH_ADMINISTRATOR . '/components/com_elgpedy/models/fields');
        $form = JForm::getInstance('healthunit', ComponentUtils::getDefaultFormPath() .'/healthunit.xml');
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
		$healthUnit = JTable::getInstance('HealthUnit');
		$healthUnitDetail = JTable::getInstance('HealthUnitDetail');
		$healthUnit->load($state->get('id', 0));
		if($healthUnit !== false)
		{
			$form->bind($healthUnit);
			$healthUnitDetail->load(array('HealthUnitId'=>$healthUnit->HealthUnitId, 'StatusId'=>ComponentUtils::$STATUS_ACTIVE));
			
			if($healthUnitDetail!== false)
			{
				$form->bind($healthUnitDetail);
			}
		}			
		$state->set('form', $form);
		return $state;
    }
}