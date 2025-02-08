<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class DataCommon extends View 
   {
        protected $forms = null;
        protected $formAction = '';
        
        function __construct(JModel $model, SplPriorityQueue $paths = null) 
        {
            parent:: __construct($model, $paths);
        	$this->forms = $this->state->get('forms');
			
            $this->setLayout('dataform');
            $this->header = JPATH_COMPONENT_SITE . '/layouts/partchronodatetime.php';
            JHtml::_('bootstrap.framework');          
            $doc = JFactory::getDocument();				
            $doc->addStyleSheet('media/com_elgpedy/css/bootstrap-editable.css');
            $doc->addStyleSheet('media/com_elgpedy/css/bootstrap-datetimepicker.min.css');
            $doc->addScriptDeclaration('elgview=\'' . $this->escape($this->state->get('view') .'\';elgItemid=' . $this->escape($this->state->get('Itemid')) . ';'));
            JHtml::script('media/com_elgpedy/js/submitions.js');
            JHtml::script('media/com_elgpedy/js/bootstrap-datetimepicker.min.js');
            JHtml::script('media/com_elgpedy/js/locales/bootstrap-datetimepicker.el.js');
            JHtml::script('media/com_elgpedy/js/moment.min.js');
			//JHtml::script('media/com_elgpedy/fullcalendar340/lib/moment.min.js');
            $this->forms->commonForm->setFieldAttribute('RefDate', 'class', 'form-control');
        }
    }
