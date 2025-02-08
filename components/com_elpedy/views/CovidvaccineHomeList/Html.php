<?php

/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # author    Christoforos J. Korifidis
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */

namespace components\com_elpedy\views\CovidvaccineHomeList;

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

        $this->CovidVaccineEditUrl = $endPoints['CovidVaccineHomeEdit'];
        $this -> covidVaccineForm = Form::getInstance("covidvaccinehome", "covidvaccinehome");
        
        $state = $this -> model ->getState();
        $state -> set("task", "html");
        $this -> model -> setState( $state );       
        $state =  $this -> model -> getState();
//        print_r($state);
        $this -> vaccinesAttributes =  $this -> getVaccinesAttributes( $state );
        return parent::render();
    }

    private function getJsonUrls() {
        return array_map(
                function ($val) {
                        return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
                }
                , ELComponent::getEndPointsItems(['CovidVaccineHomeListData', 'CovidVaccineHomeSaveData'])
                        
        );
    }
    
    private function getHTMLUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=html', false);
        }
                , ELComponent::getEndPointsItems(['CovidVaccineHomeEdit'])
               
        );
    }
    
    public function getVaccinesAttributes($state) {
      //  var_dump($state -> get("data") );
        if( isset ( $state -> get("data")["attributes"] ) ) {
            return $state -> get("data")["attributes"];
        }
        else {
            return [];
        }
    }

}
