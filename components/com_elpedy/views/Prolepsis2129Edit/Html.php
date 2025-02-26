<?php

namespace components\com_elpedy\views\Prolepsis2129Edit;

defined('_JEXEC') or die('Restricted access');
use elogism\views\View;
use elogism\ELComponent;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;



class Html extends View {

    public function render() {
        
        $state = $this->state;
        $this->formProlepsis = $state->get('forms')['prolepsis2129'];
        
        $endPoints = array_merge(
                $this -> getJsonUrls()
                , $this -> getHTMLUrls()
                );
                
             
        $this->listUrl = $endPoints['Prolepsis2129List'];     
        
        $doc = Factory::getDocument();
        $doc -> addScriptOptions('com_elpedy',  $endPoints);
        
        return parent::render();
    }    
    
    
     private function getHTMLUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=html', false);
        }
                , ELComponent::getEndPointsItems(['Prolepsis2129List'])
        );
    }
    
     private function getJsonUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
        }                       
                , ELComponent::getEndPointsItems(['Prolepsis2129EditData', 'Prolepsis2129EditSaveData'])
        );
    }
  
}
