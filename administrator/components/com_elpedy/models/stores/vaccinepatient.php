<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
                  ;
require_once JPATH_COMPONENT_ADMINISTRATOR . '/models/stores/pedy.php';
class JTableVaccinePatient extends JTablePedy {
    
    var $id = null;
    var $HealthUnitId = null;
    var $school_id = null;
    var $schol_class_id = null;
    var $birthday = null;
    var $RefDate = null;
    var $age = null;
    var $isMale = null;
    var $nationality_id = null;
    var $father_profession = null;
    var $mother_profession = null;
    var $info_level_id = null;
    var $ssn = null;
    var $area_id = null;
 
    
    function __construct()
    {
        parent::__construct('Vaccine_Patient', 'id');
    }	
   
    
}
