<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism 
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/editsave.php';
																			

class ElgPedyControllerAdiologioReportDelete extends EditSave 
{
	
    public function execute() 
    {   
        $app = JFactory::getApplication();
        $data = [];
        $input = $this->getInput();
        $user = JFactory::getUser();
        $viewLevels = $user->getAuthorisedViewLevels();
        try{
            if(!in_array(13, $viewLevels)):
                throw new Exception(JText::_('COM_ELG_NO_VALID_ACCESS_POINT'));
            endif;
            $this->formData->PersonelAttendanceBookRafinaId = $input->getInt('id', 0);
            $this->state->set('formData', $this->formData);
            $this->model->setState($this->state);
            $app->enqueueMessage(JText::_('COM_ELG_DELETE_SUCCESS'));
            $data['delRes'] = 1;
        }catch (Exception $e) {
            JLog::add($e->getMessage());
            $app->enqueueMessage(JText::_('COM_ELG_DELETE_FAILURE'). '(' . $e->getCode() . ')');
            $data['delRes'] = 0;
        }
        $view = Factory::getView('ElgPedy', $this->state->get('view'), $this->model,  $this->state->get('format') );
        echo $view->render();
      
    }
}
