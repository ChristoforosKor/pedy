<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );


class ElgPedyModelDentalExamDelete extends JModelDatabase
{
	
	function setState(JRegistry $state) 
	{            
            $formData = $state->get('formData');
            $id = $formData->dental_transaction_id; 
            $db = ComponentUtils::getPedyDB();
            $query = $db->getQuery(true);
            $query->update('#__dental_transaction')->set('status_id=' . ComponentUtils::$STATUS_DELETED)->where('dental_transaction_id=' . $id);
            $db->setQuery($query);
            $db->execute();
            $query->clear();
            $query->update('#__dental_transaction_mouth')->set('status_id=' . ComponentUtils::$STATUS_DELETED)->where('dental_transaction_id=' . $id);
            $db->execute();
            $query->clear();
            $query->update('#__dental_transaction_tooth')->set('status_id=' . ComponentUtils::$STATUS_DELETED)->where('dental_transaction_id=' . $id);
            $db->execute();
            
        }
        
 }