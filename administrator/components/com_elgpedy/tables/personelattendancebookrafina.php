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
      
class JTablePersonelAttendanceBookRafina extends TablePedy
{
    var $PersonelAttendanceBookRafinaId = null;
    var $PersonelId = null;
    var $PersonelStatusId = null;
    var $PersonelStatusGroupId = null;
    var $StartDate = null;
	var $EndDate = null;
	var $Details = null;
	var $Duration = null;
	var $Year = null;
	
    function __construct()
    {
            parent::__construct('PersonelAttendanceBookRafina', 'PersonelAttendanceBookRafinaId');
    }	
 	
    public function store($updateNulls = false)
    {
        if(! parent::check())
        {
            return false;
        }
        return parent::store();
    }
}