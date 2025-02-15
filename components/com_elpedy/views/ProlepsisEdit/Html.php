<?php
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\views\ProlepsisEdit;

defined('_JEXEC') or die('Restricted access');
use elogism\views\View;
use elogism\ELComponent;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;


class Html extends View {

    public function render() {
        
        $state = $this->state;
        $this->formProlepsis = $state->get('forms')['prolepsis'];
        
        $endPoints = array_merge(
                $this -> getJsonUrls()
                , $this -> getHTMLUrls()
                );
                
                
        $this->listUrl = $endPoints['ProlepsisList'];                
        $doc = Factory::getDocument();
        $doc -> addScriptOptions('com_elpedy',  $endPoints);
        
        return parent::render();
    }    
    
    
     private function getHTMLUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=html', false);
        }
                , ELComponent::getEndPointsItems(['ProlepsisList'])
        );
    }
    
     private function getJsonUrls() {
        return array_map(
                function ($val) {
            return Route::_('index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
        }                       
                , ELComponent::getEndPointsItems(['ProlepsisEditData', 'ProlepsisEditSaveData'])
        );
    }
  
}
