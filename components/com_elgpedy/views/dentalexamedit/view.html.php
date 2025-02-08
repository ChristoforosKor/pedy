<?php
/**
 * e-logism's com_elgpedy.
 * @copyright (c) 2013, e-logism.
 * 
 */
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 // require JPATH_COMPONENT . '/libraries/php/joomla/e-logism/views/view.php';
 require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
 /**
  
  * @package e-logism.joomla.com_elgcomponents.site
  * @subpackage views
  * @author Christoforos J. Korifidis.
  * 
  */
   class ElgPedyViewDentalExamEdit extends DataCommon
   {
		public function render()
		{
                    $doc = JFactory::getDocument();
                    $this->configDocument( );
		    $this->formAction = JRoute::_( 'index.php?option=com_elgpedy&controller=dentalexamsave&Itemid=' . $this->state->get('Itemid'),  false);
                    $forms = $this->state->get( 'forms' );
                    $data = $this->state->get( 'data' );
                    $this->setCustomScripts( $doc, $data );
                    $this->formDentalExamEdit = $forms->dentalexamedit;   
                    $this->formDentalExamEdit->setValue('birthday', null, ComponentUtils::getDateFormated( $this->formDentalExamEdit->getValue('birthday'), 'Y-m-d', 'd/m/Y'));
                    $this->setLayout('dentalexamedit'); 
                    $this->chronoscripts = '';
                    return parent::render();
		}
                
                private function configDocument()
                {
                    JHtml::_('bootstrap.framework');
                    JHtml::stylesheet('media/com_elgpedy/css/select2.css');                    
                    JHtml::stylesheet('media/com_elgpedy/css/select2-bootstrap.css');
                    JHtml::script('media/com_elgpedy/js/select2.js'); 
                   
                }
                
                private function setCustomScripts($doc, $data)
                {
                    $s =  ' var schools = ' . json_encode( $data[ 'schools' ] ) . ';    
                            var schoolLevels = ' . json_encode( $data['schoolLevels']). ';
                            var areas = ' . json_encode ( $data[ 'areas' ] )  . ';
                            var areasTypes = ' . json_encode ( $data[ 'areaTypes' ] ) . '.map(function(areaType){return {id:areaType[0], text:areaType[1]};});
                            var levelClasses = ' . json_encode ( $data[ 'levelClasses' ]) . ';   
                            var dentalConditions = ' . json_encode ( $data[ 'dentalConditions' ]) . ';  
                            var dentalTooths = ' . json_encode ( $data[ 'dentalTooths' ]) . ';
                            var toothTransaction = ' . json_encode($data['toothTransactions']) . ';'; 
                            
                    $doc->addScriptDeclaration( $s );      
                    $doc->addScript('media/com_elgpedy/js/dental.js'); 
                }
   }  ///  var schoolsData = schools.map(function(school) {return {id: school[0], text: school[3]};});