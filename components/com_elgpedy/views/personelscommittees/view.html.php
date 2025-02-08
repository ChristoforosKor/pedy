<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
  //require JPATH_COMPONENT_SITE . '/views/datacommon.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
  require_once JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
 
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewPersonelsCommittees  extends View //DataCommon
   {
        public function render()
        {
			
			 // parent:: __construct($model, $paths);
        	$this->forms = $this->state->get('forms');
			$this->forms->commonForm->setFieldAttribute('RefDate', 'class', 'form-control');
            $this->setLayout('dataform');
            $this->header = JPATH_COMPONENT_SITE . '/layouts/partchronodatetime.php';
            
			
		   // JHtml::script('media/com_elgpedy/js/submitions.js');
            //JHtml::script('media/com_elgpedy/js/bootstrap-datetimepicker.min.js');
            //JHtml::script('media/com_elgpedy/js/locales/bootstrap-datetimepicker.el.js');
          
			//JHtml::script('media/com_elgpedy/fullcalendar340/lib/moment.min.js');
            
			
			
			//JHTML::script('media/com_elgpedy/js/moment.min.js');
            
			//JHTML::_('bootstrap.framework');
            //JHTML::stylesheet('media/com_elgpedy/jquery-ui-1.12.1.custom/jquery-ui.min.css');
			//JHTML::stylesheet('media/com_elgpedy/jquery-ui-1.12.1.custom/jquery-ui.strucutre.min.css');
			//JHTML::script('media/com_elgpedy/jquery-ui-1.12.1.custom/jquery-ui.min.js');
			 			 
			
			// JHTML::stylesheet('media/com_elgpedy/css/fullcalendar.min.css'); 
            // JHTML::stylesheet('media/com_elgpedy/css/fullcalendar.print.css', array('media'=>'print')); 			
            // JHTML::script('media/com_elgpedy/js/fullcalendar.min.js');
			// JHTML::script('media/com_elgpedy/js/lang-all.js');
			
			$doc = JFactory::getDocument();				
            $doc -> addScriptDeclaration('elgview=\'' . $this->escape($this->state->get('view') .'\';elgItemid=' . $this->escape($this->state->get('Itemid')) . ';'));
			$doc -> addStyleSheet('media/com_elgpedy/fullcalendar340/fullcalendar.min.css');
			$doc -> addStyleSheet('media/com_elgpedy/fullcalendar340/fullcalendar.print.css', [], ['media' => 'print' ] );
			
			
			$doc -> addScript( 'media/com_elgpedy/fullcalendar340/lib/moment.min.js' );
			$doc -> addScript( 'media/com_elgpedy/fullcalendar340/lib/jquery.min.js' );
			$doc -> addScript( 'media/com_elgpedy/fullcalendar340/fullcalendar.js' );
			$doc -> addScript( 'media/com_elgpedy/js/submitions.js' );
			$doc -> addScript( 'media/com_elgpedy/fullcalendar340/locale/el.js');
            
			$dataDB = $this->state->get('data');
            $this->personels = $dataDB->personels;
            $this->committees = $dataDB->committees;
            $this->data = ViewUtils::scheduleReform($dataDB->data); //$data;
            $this->setLayout('dataformmonth');
            $this->header = JPATH_COMPONENT_SITE . '/layouts/partchronomonth.php';
            $this->dataLayout =  'personelscommittees.php';
			
            return parent::render();
        }
   }
