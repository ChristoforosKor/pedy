<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
  
   require_once JPATH_COMPONENT_SITE . '/views/datacommonreport.php';
   require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
  
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
    class ElgPedyViewClinicalTransactionReportOld extends  DataCommonReport
    {
        public function render()
        {
            $data = $this->state->get('data');
            $this->clinics = $data->clinics;
            $this->incidents = $data->incidents;
            $this->dataClinical = ViewUtils::ClinicalReform($data->data);
            $this->checker = $data->checker;
            $this->dataLayout = 'clinicaltransactionreportold.php';
            $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=112');
            return parent::render();
        }	
    }
