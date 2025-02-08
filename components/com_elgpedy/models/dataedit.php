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
 

 
 class ElgPedyModelDataEdit extends JModelBase
 {
	protected $commonForm = '';
	protected $pedyDB = '';
	public function __construct(\JRegistry $state = null)
	{
		parent::__construct($state);
		$this->commonForm = JForm::getInstance('datacommon', ComponentUtils::getDefaultFormPath() .'/datacommon.xml');
		$this->pedyDB = ComponentUtils::getPedyDB();
	}
 }