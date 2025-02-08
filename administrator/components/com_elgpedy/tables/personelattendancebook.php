<?php
/**
 * @author e-logism http://www.e-logism.gr
 * @copyright (C) 2013 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_COMPONENT_ADMINISTRATOR . '/tables/tablepedy.php';

/**
 * JTable class father of all pedy application tables
 *
 * @author e-logism
 */
      
class JTablePersonelAttendanceBook extends TablePedy
{
    var $PersonelAttendanceBookId = null;
    var $PersonelId = null;
    var $RefHealthUnitId = null;
    var $RefDate = null;
    var $PersonelStatusId = null;
	var $HealthUnitId = null;
    function __construct()
    {
            parent::__construct('PersonelAttendanceBook', 'PersonelAttendanceBookId');
    }	
 	
    public function store_($updateNulls = false)
    {
        if(! parent::check())
        {
            return false;
        }
        return parent::store();
    }
}