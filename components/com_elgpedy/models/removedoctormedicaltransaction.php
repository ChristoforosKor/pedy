<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );


class ElgPedyModelRemoveDoctorMedicalTransaction extends JModelDatabase
{
	function setState(JRegistry $state) 
	{
		$db = ComponentUtils::getPedyDB();
		
		$query = 'update MedicalTransaction set StatusId = 3 where MedicalTransactionId = ' . $db -> quote( $state -> get ('id') ) ;
		/**
		 PersonelId = ' . $db -> quote( $state -> get ('pid') ) 
		. ' and HealthUnitId = ' . $db -> quote( $state -> get('HealthUnitId') )
		. ' and MedicalTypeId = ' . $db -> quote( $state -> get('mti') )
		. ' and PatientAttributeInsurance = ' . $db -> quote( $state -> get('pai') )
		. ' and PatientAttributeOrigination = ' . $db -> quote( $state -> get('pao') )
		. ' and ifNull(MunicipalityId, \'\') = ' . $db -> quote( $state -> get('munic') )
		. ' and ifNull(PatientAmka, \'\') = ' . $db -> quote( $state -> get('amka') )
		. ' and RefDate =' . $db -> quote( $state -> get ('RefDate') );
		**/
		//echo $query;
		ComponentUtils::getPedyDB() -> setQuery( $query ) -> execute();
		$state -> set('data', 
			[
				/**
				'PersonelId' => $state -> get ('PersonelId'),
				'HealthUnitId' => $state -> get ('HealthUnitId'),
				'MedicalTypeId' => $state -> get ('MedicalTypeId'),
				'RefDate' => $state -> get ('RefDate')
				**/
				'id' =>  $state -> get ('id')
			]	
		);
		parent::setState($state);
	}
 }