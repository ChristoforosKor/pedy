<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_COMPONENT_ADMINISTRATOR . '/tables/tablepedy.php';
/**
 * JTable class father of all pedy application transaction tables
 *
 * @author e-logism
 */
            
abstract class TablePedyTransaction extends TablePedy {
    var $UserId = null;
   
    var $HealthUnitId = null;
    var $RefYear = null;
    var $RefMonth = null;   
    var $RefDate = null;
    var $Quantity = null;   
    
/**
this function does not belong here. Must be eliminitated. This functionallity should go to higher level
**/

    function check()
    {
        if(parent::check())
        {
            $d =  date_parse_from_format('Ymd' , $this->RefDate);
            if($d['error_count'] > 0  || $d['warning_count'])
            {
                JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_PEDY_INVALID_DATE'), 'error');
                return false;
            }
            return true;
        }
        return false;
    }
}
