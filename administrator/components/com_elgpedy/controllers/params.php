<?php
/**
 * @author e-logism
 * @copyright (c) elogism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.2.1 2012-09-12
 **/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');


class ElgPedyControllerparams extends JController{


    function edit(){
        $model = & $this->getModel();
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view','params');
        $view = & $this->getView($viewName,$document->getType());
        $view->setModel( $model, true );
        parent::display();
    }
    
  
      
    
    function save(){
        $model = & $this->getModel();
        $app = JFactory::getApplication();
        
        if($model->save() ) {
            $app->enqueueMessage(JText::_("COM_ALUMINCOCC_MSG_ACTION_SUCCESS"));
        } else {
           $app->enqueueMessage(JText::_("COM_ALUMINCOCC_MSG_MODEL_ERROR"),'error');
        }
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view','params');
        $view = & $this->getView($viewName,$document->getType());
        $view->setModel( $model, true );
        
        parent::display();
   }

}
?>