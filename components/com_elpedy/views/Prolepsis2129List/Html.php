<?php

/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # author    Christoforos J. Korifidis
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */

namespace components\com_elpedy\views\Prolepsis2129List;

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
        $this->prolepsisEditUrl = $endPoints['Prolepsis2129Edit'];
        
        
        Text::script('JDATE');
        Text::script('JACTION_EDIT');
        Text::script('JACTION_DELETE');
        Text::script('COM_EL_PEDY_SAMPLES_TO_CHECK_TO_NEXT');
        Text::script('COM_EL_PEDY_RESULT_NORMAL');       
        Text::script('COM_EL_RESULT_NOT_OK');
        Text::script('COM_EL_PEDY_VIALS_STOCK');
        Text::script('COM_EL_PEDY_CHECK_FILTERS_DATE');
        
        $this->deleteTitle = Text::_('COM_EL_PEDY_DELETE_SAMPLE');
        $this->deletePrologue= Text::_('COM_EL_PEDY_DELETE_PROLOGUE');
        return parent::render();
    }

    private function getJsonUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
        }                       
                , ELComponent::getEndPointsItems(['Prolepsis2129ListData', 'Prolepsis2129DeleteData'])
        );
    }
    
    private function getHTMLUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=html', false);
        }
                , ELComponent::getEndPointsItems(['Prolepsis2129Edit', 'Prolepsis2129List'])
        );
    }

}
