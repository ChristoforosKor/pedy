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
  require_once JPATH_COMPONENT_SITE . '/views/clinicaltransaction/view.html.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewMotherChildCareReport extends DataCommonReport
   {
        public function render()
        {
            $data = $this->state->get('data');
            $this->fields =  new stdClass(); 
            $this->clinics = $data->fields->clinics;
            $this->incidents = $data->fields->incidents;
            $this->fields->prolepsis = $data->fields->prolepsis;
            $this->dataLayout = 'motherchildcarereport.php';
            $this->checker = $data->checker;           
            $this->dataClinical = ViewUtils::ClinicalReform($data->clinics);
            $this->dataProlepsis =ViewUtils::ProlepsisReform($data->prolepsis);
            $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=114');
            $this->clinicMissing = $data->clinicMissing;
            $this->prolepsisMissing = $data->prolepsisMissing;
            return parent::render();			
        }
   }
