<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';
/**
  * @package pedy.site
  * @subpackage models
  * 
  */

class ElgPedyModelDentalExams extends PedyDataEdit
{
	function getState() 
	{
            $state = parent::getState();
            $data = new stdClass();
            $query = $this->pedyDB->getQuery(true);
            $this->pedyDB->setQuery($query);
            $query->setQuery('select dental_transaction_id, exam_date, sl.school_level, s.description , ct.country, isMale, dt.father_profession, dt.mother_profession, birthday
                    from dental_transaction dt
                    inner join school s on dt.school_id = s.school_id ' 
                    . ($state->get('RefDate') != '' ? ' and dt.exam_date =' . $this->pedyDB->quote($state->get('RefDate')) : '') 
                    . ($state->get('HealthUnitId') > 0 ? ' and dt.health_unit_id =' . $this->pedyDB->quote($state->get('HealthUnitId')) : '') 
                    . ' and dt.status_id = ' . ComponentUtils::$STATUS_ACTIVE .
                    ' inner join school_level sl on sl.school_level_id = s.school_level_id
                    inner join country_translation ct on ct.idCountry = dt.nationality_id and ct.`language` = \'el-GR\'');
            $data->examsData = $this->pedyDB->loadObjectList(); 
            $state->set('data', $data);
            return $state;	
	}
 }
