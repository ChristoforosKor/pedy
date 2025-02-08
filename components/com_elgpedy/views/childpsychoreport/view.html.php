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
   
   class ElgPedyViewChildPsychoReport extends DataCommonReport
   {
   	   	
		public function render()
		{
			
			$data = $this->state->get('data');
			$this->clinics = $data -> fields -> clinics;
                                                $this->incidents = $data -> fields -> incidents;
			if (isset($data -> data)):
				$this->dataClinical = ViewUtils::ClinicalReform($data -> data);
			endif;
			if (isset($data -> newData)):
                                                    if ( count($data -> newData) > 0 ):
                                                        $this-> newData =  ViewUtils::ClinicalReformWithDoctors($data -> newData);
                                                        $this -> doctors = $data -> doctors;
                                                    endif;
			endif;
                                                if (isset($data -> newData3)):
                                                    $this-> newData3 =  ViewUtils::ClinicalReformWithDoctors3($data -> newData3);
                                                    $this -> doctors3 = $data -> doctors3;
			endif;
			$this -> d1 = $data -> d1;
			$this -> d2 = $data -> d2;
                                                $this -> d3 = $data -> d3;
                                                $this->checker = $data->checker;
			$departments = array();
			foreach($this -> incidents as $incident)
			{
				if(!in_array($incident->DepartmentId, $departments))
				{
					$departments[$incident->Department] = $incident->DepartmentId;
				}
			}
			$this->departments = $departments;
            $this->dataLayout = 'childpsychoreport.php';
            $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=119');
            return parent::render();
        }
		
		
   }
