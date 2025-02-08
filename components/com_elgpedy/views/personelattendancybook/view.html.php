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
  * @package pedy.site
  * @subpackage views
  * 
  */
   class ElgPedyViewPersonelAttendancyBook extends DataCommon
   {
        
   	public function render()
        {
            $data = $this->state->get('data');
            $this->optStatus = array();
            foreach($data->attendancyStatus as $status):
                $this->optStatus[] = array('value'=>$status->PersonelStatusId, 'text'=>$status->description); // .= '<option value="' . $status->PersonelStatusId . '" >' . $status->description . '</option>';
            endforeach;
            unset($status);
            $this->optHUs = array();
            foreach($data->attendancyHealthUnit as $atUnit):
                $this->optHUs[] = array('id'=>$atUnit->HealthUnitId, 'text'=>$atUnit->DescEL);   // .= '<option value="' . $atUnit->HealthUnitId . '" >' . $atUnit->DescEL . '</option>';
            endforeach;
            unset($atUnit);
            $this->attendancyData = json_encode($data->attendancyData);
            $this->dataLayout = 'personelattendancybook.php';
            JFactory::getDocument()->addStyleDeclaration('.bootstrap-table .fixed-table-header th{padding-left:0; padding-right:0}  div.select2-container{width:190px}') ;
            JHTML::stylesheet('media/node_modules/bootstrap-table/dist/bootstrap-table.min.css');
            JHTML::stylesheet('media/com_elgpedy/css/select2.css');
            JHTML::stylesheet('media/com_elgpedy/css/select2-bootstrap.css');
            JText::script('COM_ELGPEDY_ORG_UNIT');
            JText::script('COM_ELGPEDY_LASTNAME');
            JText::script('COM_ELGPEDY_FIRSTNAME');
            JText::script('COM_ELGPEDY_FATHERNAME');
            JText::script('COM_ELG_PEDY_PERSONEL_STATUS_ID');
            JText::script('COM_ELGPEDY_UNIT_WORK');
            JText::script('COM_ELGPEDY_SPECIALITY');
             JText::script('COM_ELGPEDY_EDUCATION');
            return parent::render();
        }
   }