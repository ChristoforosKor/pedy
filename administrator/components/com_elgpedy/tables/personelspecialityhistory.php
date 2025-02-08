<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
class JTablePersonelSpecialityHistory extends JTable {
    
    var $PersonelId = null;
    var $SpecialityId = null;
    var $StartDate = null;
    var $EndDate = null;	
	var $id = null;
	var $statusid = null;
    
    function __construct() 
	{
        if($db == null):
                $db = ComponentUtils::getPedyDB();
        endif;        
		parent::__construct('PersonelSpecialityHistory', 'id', $db);
    } 
	
public function getLast ($id){
                $db = ComponentUtils::getPedyDB();

	return $db->setQuery("select id from PersonelSpecialityHistory where PersonelId=$id and ifNull(EndDate,'' ) ='' ")->loadResult();
}

	
}
