<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_ADMINISTRATOR . '/components/com_elgpedy/tables/dentaltable.php';
/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
class JTableDentalTransaction extends DentalTable {
    
    var $dental_transaction_id = null;
    var $health_unit_id = null;
    var $school_id = null;
    var $schol_class_id = null;
    var $patient_id = null;
    var $exam_date = null;
    var $birthday = null;
    var $age = null;
    var $nationality_id = null;
    var $father_profession = null;
    var $mother_profession = null;
    var $isMale = null;
    var $ssn = null;
 
    
    function __construct()
    {
        parent::__construct('dental_transaction', 'dental_transaction_id');
    }	
   
    
}
