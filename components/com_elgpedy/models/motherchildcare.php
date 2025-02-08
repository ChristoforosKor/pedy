<?php

/* ------------------------------------------------------------------------
  # com_elgpedy - e-logism, dexteraconsulting  application
  # ------------------------------------------------------------------------
  # copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Websites: http://www.e-logism.gr, http://dexteraconsulting.com
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
use Joomla\Registry\Registry;
require_once JPATH_COMPONENT_SITE . '/models/pedydataedit.php';
require_once JPATH_COMPONENT_SITE . '/models/prolepsiscommunityold.php';

class ElgPedyModelMotherChildCare extends PedyDataEdit {
    
    private static $LAST_OLD_DATE = '2016-08-31'; // last date of old status.
    private $prolepsisState = null;
    private $clinicalState = null;
    
    public function __construct(Registry $state)
    {
        parent::__construct( $state );
        if ($state->get('RefDate') <= self::$LAST_OLD_DATE):
            require_once JPATH_COMPONENT_SITE . '/models/clinicaltransactionold.php';
            $modelClinical = new ElgPedyModelClinicalTransactionOld( $state );
        else:
            require_once JPATH_COMPONENT_SITE . '/models/clinicaltransaction.php';
            $modelClinical = new ElgPedyModelClinicalTransaction( $state );
        endif;
        $this -> clinicalState = $modelClinical -> getState();
        $modelProlepsis = new ElgPedyModelProlepsisCommunityold( $state);
        $modelProlepsis -> medicalActId = '1,4';
        $modelProlepsis -> medicalCategory = 4;
        $this -> prolepsisState = $modelProlepsis -> getState();
    }
    
    function getState() {

        $oldState = parent::getState();
        $newState = new Registry ( );
        $newState -> set( 'data', [
                                                    'clinical' => $this -> clinicalState -> get('data')
                                                    ,'prolepsis' => $this -> prolepsisState -> get('data') -> data
                                                ]
                );
        $newState -> set ('forms',  $this -> clinicalState -> get('forms' ) );
        
        if ($oldState -> get('format') === 'html') {
            $newState -> set(
                    'fields', [
                        'prolepsis' => $this -> prolepsisState -> get('data') -> fields
                        ,'clinical' => $this -> clinicalState -> get('fields')
                    ]);
        }
        $newState -> set('RefDate', $oldState -> get('RefDate') );
        $newState -> set('HealthUnitId', $oldState -> get('HealthUnitId') );
        $newState -> set ( 'view', $oldState -> get('view') );
        $newState -> set ( 'Itemid', $oldState -> get('Itemid') );
        $newState -> set ('checkers',$this -> clinicalState -> get('checkers', 0 ) );
        return $newState;
    }
}
