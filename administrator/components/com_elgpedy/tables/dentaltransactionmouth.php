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
            
class JTableDentalTransactionMouth extends DentalTable {
    
    var $dental_transaction_mouth_id = null;
    var $dental_transaction_id = null;
    var $dental_mouthcondition_id = null;
    
    function __construct()
    {
        parent::__construct('dental_transaction_mouth', 'dental_transaction_mouth_id');
    }	
   
}
