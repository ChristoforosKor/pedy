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
require JPATH_COMPONENT_SITE . '/models/nulls.php';
class Pedy extends JModelBase
{
	protected $pedyDB = '';
	protected $UserId = 0;
	
    protected $query = null;
	protected $data;
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		$this->data = new stdClass();
		$this->UserId = JFactory::getUser()->id;
		$this->pedyDB = ComponentUtils::getPedyDB();		
		$query = $this->pedyDB->getQuery(true);
		$this->pedyDB->setQuery($query);
		$this->query = $query;		
	}
 }