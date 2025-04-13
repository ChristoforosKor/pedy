<?php

/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # author    Christoforos J. Korifidis
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */

namespace components\com_elpedy\views\ProlepsisList;

defined('_JEXEC') or die('Restricted access');

use elogism\views\View;
use Joomla\CMS\Factory;
use elogism\ELComponent;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;

class Html extends View {

    public function render() {
        $endPoints = array_merge(
                $this -> getJsonUrls()
                , $this -> getHTMLUrls()
                );
        Factory::getDocument()->addScriptOptions('com_elpedy', $endPoints);
        $this -> commonForm =Form::getInstance('common', 'common');
        $healthUnitField = $this->commonForm->getField('HealthUnitId');
        $healthUnitField->addOption(Text::_('COM_EL_SELECT'), '');
        
        
        $this->prolepsisEditUrl = $endPoints['ProlepsisEdit'];
        
        
        Text::script('JDATE');
        Text::script('COM_EL_PEDY_EXAMS_CENTER_CONDENSED');
        Text::script('COM_EL_PEDY_RECEIVES');
        Text::script('COM_EL_PEDY_TO_EXAM_CENTER');
        Text::script('COM_EL_PEDY_NEGATIVE');
        Text::script('COM_EL_PEDY_HPV_16');
        Text::script('COM_EL_PEDY_HPV_18');
        Text::script('COM_EL_PEDY_ASCSUS');
        Text::script('COM_EL_PEDY_POSITIVE_TO_PAP');
        Text::script('JACTION_EDIT');
        Text::script('JACTION_DELETE');
        
        $this->deleteTitle = Text::_('COM_EL_PEDY_DELETE_SAMPLE');
        $this->deletePrologue= Text::_('COM_EL_PEDY_DELETE_PROLOGUE');
        return parent::render();
    }

    private function getJsonUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
        }                       
                , ELComponent::getEndPointsItems(['ProlepsisListData', 'ProlepsisDeleteData'])
        );
    }
    
    private function getHTMLUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=html', false);
        }
                , ELComponent::getEndPointsItems(['ProlepsisEdit', 'ProlepsisList'])
        );
    }

}
