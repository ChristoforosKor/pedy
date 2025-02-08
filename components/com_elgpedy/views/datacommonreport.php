<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class DataCommonReport extends DataCommon
   {        
	    protected $missing = array();
        function __construct(JModel $model, SplPriorityQueue $paths = null) 
        {
            parent:: __construct($model, $paths);
	        $this->setLayout('dataformreport');
            $this->header = JPATH_COMPONENT_SITE . '/layouts/partchronodatetimerange.php';
            $this->forms->commonForm->setFieldAttribute('RefDateFrom', 'class', 'form-control');
            $this->forms->commonForm->setFieldAttribute('RefDateTo', 'class', 'form-control');
            
            if(isset($this->state->get('data')->missing))
            {
				$this->missing = $this->state->get('data')->missing;
			}
        }
    }
