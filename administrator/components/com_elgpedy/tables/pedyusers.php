<?php
/**
 * @author e-logism http://www.e-logism.gr
 * @copyright (C) 2013 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_ADMINISTRATOR . '/components/com_elgpedy/tables/tablepedy.php';
/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
class JTablePedyUsers extends TablePedy 
{
    var $UserId = null;
	var $HealthUnitId = null;
	var $username = null;
	var $password =null;
	var $Admin = null;
	   
    function __construct()
	{
		parent::__construct('Users', 'UserId');
	}	
	
	
	
	// function store($updateNulls = false) {
        // $res = parent::store($updateNulls);
        // $lt = JTable::getInstance('lastupdates');
        // $lt->load(array('idUser'=>$this->idUser, 'idType'=>1));
     
		// if($lt->idUser == 0)
        // {
            // $lt->idUser = $this->idUser;
            // $lt->idType = 1;
        // }
        // $lt->datemodified = date('Y-m-d H:i');
        // $lt->store();
        // return $res;
    // }
}
