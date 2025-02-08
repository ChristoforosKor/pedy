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

/**
 * @todo To init table πρέπει να ταο εξαλείψω. Η λειοτυργία αυτή εκτός του refDate έχει πάει στο table το ίδιο.
 */
class PedyDataEditSave extends Pedy
{
	protected $table = null;
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
	}
	
	protected function initTable($formData)
	{
                        $this->table->UserId = $this->UserId;
                        $this->table->HealthUnitId = $formData->HealthUnitId;
                        $this->table->RefDate = $formData->RefDate;
	}
 }
