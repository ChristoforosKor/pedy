<?php
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
namespace components\com_elpedy\views\CovidvaccineEdit;
defined('_JEXEC') or die('Restricted access');
use elogism\views\View;
use elogism\ELComponent;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
 
class Html extends View
{
    public function render() {
        $data = $this -> state -> get('data');
        $endPoints = array_map ( 
                function ($val)  {
                    return Route::_( 'index.php?option=com_elpedy&Itemid=' . $val . '&format=json', false);
                } 
        ,ELComponent::getEndPointsItems( ['VaccinesUniEditData', 'VaccinesUniSaveData']) 
                );        
        $doc = Factory::getDocument();
        $doc -> addScriptOptions('com_elpedy',  $endPoints  );
        $reformedData = $this ->reformEditData(
                $data['VaccinesEdit']
                );
        $this -> vaccines = $reformedData[1];
        $this -> vaccinesSteps = $reformedData[2];
        $this -> vaccinesStepsRel = $reformedData[0];
        $this -> VaccinesSaveUrl = $endPoints['VaccinesUniSaveData'];
        $this -> commonForm =Form::getInstance('common', 'common');
        $this -> formPatient = Form::getInstance('patient', 'patient');
        $this -> VaccinePatientId = $this -> state -> get('id', 0);
         $s =  ' var schools = ' . json_encode( $data[ 'schools' ] ) . ';       
                            var schoolLevels = ' . json_encode( $data['schoolLevels']). ';
                            var areas = ' . json_encode ( $data[ 'areas' ] )  . ';
                            var areasTypes = ' . json_encode ( $data[ 'areaTypes' ] ) . '.map(function(areaType){return {id:areaType[0], text:areaType[1]};});
                            var levelClasses = ' . json_encode ( $data[ 'levelClasses' ]) . ';';
            
        $doc->addScriptDeclaration( $s );      
        
        return parent::render();
    }    
    
    /**
     * Reform data and returns an array containing sub arrays 
     * 1: pivoted vaccines, vaccines steps relation in the form [idVaccine][idVaccinestep] => 1
     * 2: Vaccines names map
     * 3: Vaccines Steps map
     * @param type $data
     * @return type
     */
    private function reformEditData( $data )
    {
        $rel =[]; $vaccines = []; $vaccinesSteps = [];
        forEach( $data as $item ):
            if ( !isset( $rel [$item[0] ] ) ):
                $rel[ $item[0] ] = [];
            endif;
            if ( !isset( $rel [$item[0] ] [$item[1] ] ) ):
                $rel[ $item[0] ] [$item[1] ] = [];
            endif;
            $rel[ $item[0] ] [$item[1] ] = $item[4];
            
            if ( !isset( $vaccines [ $item[0] ] ) ):
                $vaccines[ $item[0] ] = $item[3];
            endif;
            
            if ( !isset( $vaccinesSteps [ $item[1] ] ) ):
                $vaccinesSteps[ $item[1] ] = $item[2];
            endif;
        endforeach;  
        unset($item);
        ksort( $vaccinesSteps );
        return [ $rel, $vaccines, $vaccinesSteps ];
    }
}
