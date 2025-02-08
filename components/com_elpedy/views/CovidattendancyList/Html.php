<?php

/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # author    Christoforos J. Korifidis
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */

namespace components\com_elpedy\views\CovidattendancyList;

defined('_JEXEC') or die('Restricted access');

use elogism\views\View;
use Joomla\CMS\Factory;
use elogism\ELComponent;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Form\Form;

class Html extends View {

    public function render() {
        $endPoints = array_merge(
                $this -> getJsonUrls()
                , $this -> getHTMLUrls()
                );
        Factory::getDocument()->addScriptOptions('com_elpedy', $endPoints);

        $this->CovidAttendancyEditUrl = $endPoints['CovidAttendancyEdit'];
        $this -> covidAttendancyForm = Form::getInstance("covidattendancy", "covidattendancy");
        return parent::render();
    }

    private function getJsonUrls() {
        return array_map(
                function ($val) {
                        return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
                }
                , ELComponent::getEndPointsItems(['CovidAttendancyListData', 'CovidAttendancySaveData'])
                        
        );
    }
    
    private function getHTMLUrls() {
        return array_map(
                function ($val) {
                     return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=html', false);
                }
                , ELComponent::getEndPointsItems(['CovidAttendancyEdit'])
               
        );
    }

}
