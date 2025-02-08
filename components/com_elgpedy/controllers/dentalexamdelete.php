<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism
  # ------------------------------------------------------------------------
  # author    e-logism
  # copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr

  ----------------------------------* */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_COMPONENT_SITE . '/controllers/editsave.php';

class ElgPedyControllerDentalExamDelete extends EditSave {

    public function execute() {
        $input = $this->getInput();
        
        $this->formData->dental_transaction_id  =  $input->getInt('id');
        $this->state->set('formData', $this->formData);
        $this->model->setState($this->state);
        JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
        jFactory::getApplication()->redirect(JRoute::_('index.php?option=com_elgpedy&view=dentalexams&Itemid=152&HealthUnitId=' .  $this->formData->health_unit_id . '&RefDate=' . ComponentUtils::getDateFormated($input->getString('RefDate'), 'd/m/Y', 'Ymd'),false));
    }
}
