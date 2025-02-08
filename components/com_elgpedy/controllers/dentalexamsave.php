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

class ElgPedyControllerDentalExamSave extends EditSave {

    public function execute() {
        $input = $this->getInput();
        $idHealtUnit = $input->getInt('HealthUnitId', 0);
        $idSchool = $input->getInt('school_id', 0);
        $date = new DateTime();
        $date ->setTimezone('Europe/Athens');
        $refDate = $date ->createFromFormat('d/m/Y', $input->getString('RefDate', '') );
        if ( $refDate !== false):
            $RefDate =  $refDate ->format('Y-m-d'); //ComponentUtils::getDateFormated($input->getString('RefDate'), 'd/m/Y', 'Y-m-d');
        else:
            throw new Exception('Πρόβλημα κατά την ανάγνωση της ημερομηνίας εξέτασης. Παρακαλώ δοκιμάστε πάλι!');
        endif;
        $this->formData->dental_transaction_id  =  $input->getInt('dental_transaction_id');
        $this->formData->health_unit_id  = $idHealtUnit;  
        $this->formData->exam_date = $RefDate;
        $this->formData->school_id = $idSchool;
        $this->formData->InfolevelId = $input -> getInt('info_level');
        $this->formData->school_class_id = $input->getInt('school_class_id');
        $this->formData->ssn = $input->getString('ssn','');
        $birthDate = $date -> createFromFormat('d/m/Y',  $input->getString('birthday') );
        if ($birthDate !== false):   
            $this -> formData -> birthday  =$birthDate -> format('Y-m-d');
        else:
            throw new Exception('Πρόβλημα κατά την ανάγνωση της ημερομηνίας γέννησης. Παρακαλώ δοκιμάστε πάλι!');
        endif;
      //  $this->formData->birthday = ComponentUtils::getDateFormated($input->getString('birthday'), 'd/m/Y', 'Y-m-d');
        $this->formData->age = $input->getInt('age');
        $this->formData->nationality_id = $input->getInt('nationality_id');
        $this->formData->father_profession = $input->getString('father_profession');
        $this->formData->mother_profession = $input->getString('mother_profession');
        $this->formData->tooth = $input->get('tooth', null, 'ARRAY');
         
        $this->formData->dental_mouthcondition = $input->get('dental_mouthcondition', array(), 'ARRAY'); 
        $this -> formData -> dental_mouthcondition [] =  $input -> getInt( 'problem_category_2', 0 );
        $this -> formData -> dental_mouthcondition [] =  $input -> getInt( 'problem_category_3', 0 );
        $this -> formData -> dental_mouthcondition [] =  $input -> getInt( 'problem_category_4', 0 );
        $this->formData->isMale = $input->getInt('isMale', 0); 
		
        $this->state->set('formData', $this->formData);
       
        $this->model->setState($this->state);
        JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'));
       // jFactory::getApplication()->redirect(JRoute::_('index.php?option=com_elgpedy&view=dentalexams&Itemid=152&HealthUnitId=' .  $this->formData->health_unit_id . '&RefDate=' . ComponentUtils::getDateFormated($input->getString('RefDate'), 'd/m/Y', 'Ymd') .'&school_id=' .  $this->formData->school_id ,false));
        jFactory::getApplication()->redirect(JRoute::_('index.php?option=com_elgpedy&view=dentalexamedit&layout=dentalexamedit&Itemid=151&school_id=' .  $idSchool . '&HealthUnitId=' . $idHealtUnit . '&RefDate=' . urlencode($RefDate), false));
    }
}
