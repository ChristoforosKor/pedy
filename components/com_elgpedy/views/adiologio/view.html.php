<?php
/**
 * e-logism's com_elgpedy.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewadiologio extends DataCommon
   {
        public function render()
        {
            $state = $this->model->getState();
            $this->adiologio = $state->get('form');
            $layoutPaths = new   SplPriorityQueue();
            $layoutPaths->insert(JPATH_COMPONENT_SITE . '/layouts', 'normal');
            $this->setPaths($layoutPaths);
            $this->healthUnitId = $state->get('HealthUnitId', 0); 
            $this->refDate = $state->get('RefDate',0);
            //$this->setLayout('adiologio');
            $this->personelStatus =  $this->reformPersonelStatus( $state->get('personelStatus') ); //$state->get('personelStatus'); //$this->reformPersonelStatus( $state->get('personelStatus') );
            $this->dataLayout = 'adiologio.php';
            JHtml::script('media/com_elgpedy/js/moment.min.js');
            JHTML::stylesheet('media/com_elgpedy/css/site.stylesheet.css');
            return parent::render();					
	}
        
        private function reformPersonelStatus_($personelStatus) {
            $ret = [];
            forEach($personelStatus as $item):
                if(!isset( $ret [$item [ 'PersonelStatusGroupId' ] ] )):
                    $ret[$item['PersonelStatusGroupId']] = [];
                endif;
                $ret[$item['PersonelStatusGroupId']][] = ['id' => $item['PersonelStatusId'], 'text' =>$item['DescEL'] ];
            endforeach;
            unset($item);
            return $ret;
        }
        
        
        private function reformPersonelStatus($personelStatus) {
            $ret = [];
            forEach($personelStatus as $item):
                if(!isset( $ret [$item [ 'PersonelStatusGroupId' ] ] )):
                    $ret[$item['PersonelStatusGroupId']] = '';
                endif;
                $ret[$item['PersonelStatusGroupId']] .= '<option value="' . $item['PersonelStatusId'] . '">' . $item['DescEL'] . '</option>';
            endforeach;
            unset($item);
            return $ret;
        }
            
   }