<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );


class ElgPedyModelRemoveDoctorClinicTransaction extends JModelDatabase
{
	function setState(JRegistry $state) 
	{
                        $db = ComponentUtils::getPedyDB();
                        $ssn = $state -> get('ssn',0);
                        $query = 'update ClinicTransaction set StatusId = 3 where
		 PersonelId = ' . $state -> get ('PersonelId') 
		. ' and HealthUnitId = ' . $state -> get('HealthUnitId')
		. ' and ClinicTypeId = ' . $state -> get('ClinicTypeId')
		. ' and RefDate =' . $db -> quote( $state -> get ('RefDate') )
                                . ( $ssn > 0 ? ' and PatientAmka = ' . $db -> quote( $ssn )  : "" );
                        $db -> setQuery( $query ) -> execute();
                        $data = [
		'PersonelId' => $state -> get ('PersonelId'),
		'HealthUnitId' => $state -> get ('HealthUnitId'),
		'ClinicTypeId' => $state -> get ('ClinicTypeId'),
		'RefDate' => $state -> get ('RefDate')
		];
                        if ( $ssn > 0):
                            $data ['ssn'] = $ssn;                            
                        endif;
                        $data['row2RemId'] = $state -> get('row2RemId');
                        $state -> set('data', $data);
                        parent::setState($state);
	}
 }