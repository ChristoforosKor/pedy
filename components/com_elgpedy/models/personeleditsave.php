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


class ElgPedyModelPersonelEditSave extends JModelBase
{
	private $pedyDB = null;
	
	function setState(JRegistry $state) 
	{
		
		$formData = $state->get('formData');
		$this -> pedyDB = ComponentUtils::getPedyDB();
		if ( $formData -> pt === 1 ): // Main Personel Data
			$this -> saveMain( $formData );
		elseif ( $formData -> pt === 2 ): // HealthUnitHistory Data
			$this -> saveHealthUnitHistory( $formData );
		else:
			throw new Exception ( JText::_('COM_ELG_50002_NO_VALID_ACTION') );
		endif;
		
		
	}
	
	private function saveMain( $formData )
	{
		if ($formData -> PersonelId > 0 ):
			$isNew = false;
		else:
			$isNew = true;
		endif;
		// if (  ):
			// checkVatNoExisting( $formData -> trn );
			// checkAMKAExisting( $formData -> amka );
		// endif;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
		$table = JTable::getInstance('Personel');
		$table -> bind( $formData ); 		
		$res = $table->store();
		$formData -> PersonelId = $table -> PersonelId;
		if ( $res ) :
			if ( $this -> isSpecialityDifferent( $formData -> PersonelSpecialityId, $table -> PersonelId) ):
				$this -> endPersonelSpeciality( $formData -> PersonelId, date('Y-m-d') );
				$this -> insertNewPersonelSpeciality( $formData );
			endif;
			if ( $isNew ):				
				$formData -> RefHealthUnitId = $table -> HealthUnitId;
				$formData -> RefUnitEndDate = null;
				//$formData -> PersonelStatusId = 1;
				$this -> makeNewPersonelMovement( $formData );
                              
			endif;
		endif;
		JFactory::getApplication() -> enqueueMessage( JText::_('COM_ELG_SUBMIT_SUCCESS') );
		
	}
	
//	private function getExistingPersonel( $personelId )
//	{
//		if ( $personelId > 0) :
//			return $this -> pedyDB -> setQuery( "select HealthUnitID from Personel where PersonelId = $personelId " ) -> loadAssoc();
//		else:
//			return [];
//		endif;
//	}		
//	
//	private function checkVatNoExisting( $trn ) {
//		if( $this -> pedyDB -> setQuery( "select ifNull(trn,0) from Personel where trn = '$trn'" ) -> loadAssoc() != '') :
//			throw new Exception(JText::_('COM_ELG_PEDY_50004_TRN_ALREADY_EXIST'), 50004 );
//		endif;
//	}
//	
//	private function checkAMKAExisting( $amka ) {
//		if ( $this -> pedyDB -> setQuery( "select ifNull(amka,0) from Personel where amka = '$amka'" ) -> loadAssoc() != '' ):
//			throw new Exception(JText::_('COM_ELG_PEDY_50005_TRN_ALREADY_EXIST'), 50005 );
//		endif;
//	}
	
	
	///////////////Health Unit History
	
	private function saveHealthUnitHistory( $formData )
	{
		$this -> validateNewPersonelMovement( $formData );
		$endDate = new DateTime( $formData -> RefUnitStartDate );
		$endDate -> sub( new DateInterval('P1D') );
		$this -> endPersonelMovement( $formData -> PersonelId, $endDate -> format('Y-m-d') );
		$this -> makeNewPersonelMovement( $formData );
		// Below wont be necessary when Health Unit is stored only on history table
		$personel = JTable::getInstance('Personel'); 
		$personel -> load ( $formData -> PersonelId );
		$personel -> HealthUnitId = $formData -> HealthUnitId;
                 // When opening a personel page through the link of similar afm or amka we can change the movement so as to put the personel 
                // on duty to different Health Unit. In this case the deleted personle mut take StatusId =1 so as the personel be active again.
                // !!!This is not the best solution !!!
                $personel -> StatusId = 1;
                $personel -> store();		
	}
        
        
	
	private function endPersonelMovement( $personelId, $endDate)	
	{
		$lastMovement = $this -> getLastPersonelMovement( $personelId );
		$this -> validateEndDateMovement( $lastMovement['StartDate'], $endDate );
		if ( count( $lastMovement ) > 0 ):
			$this -> pedyDB -> setQuery( "update PersonelHealthUnitHistory set endDate = '$endDate', statusid = 2 where id = " . $lastMovement['id'] ) -> execute();
			JFactory::getApplication() -> enqueueMessage( JText::_('COM_ELG_SUBMIT_SUCCESS') );
		endif;
	}
	
	private function getLastPersonelMovement ($personelId) 
	{
		return $this -> pedyDB -> setQuery("select id, HealthUnitId, RefHealthUnitId, StartDate from PersonelHealthUnitHistory where PersonelId = $personelId and (endDate is null or endDate ='0000-00-00 00:00:00') order by id desc limit 0, 1") -> loadAssoc();
	}
	
	private function validateEndDateMovement( $startDate, $endDate)
	{
		$d1 = date('Y-m-d', strtotime($startDate) );
		$d2 = date('Y-m-d', strtotime($endDate) );
		if ( $d1  > $d2  ):
			throw new Exception( sprintf( JText::_( 'COM_ELG_50003_OLD_START_DATE_GRATER_EQUAL_THAN_START_DATE' ), date( 'd/m/Y', strtotime( $endDate ) ) , date( 'd/m/Y', strtotime( $startDate ) ) ), 50003);
		endif;
	}
	
	
	private function validateNewPersonelMovement( $formData ) 
	{
		if (  $formData -> RefHealthUnitId == '' 
		 || $formData -> PersonelStatusId == ''
		 || $formData -> RefUnitStartDate == ''):
			throw new Exception( JText::_( 'COM_ELG_50001_NO_VALID_DATA_SUBMITED' ) );
		 endif;
	}	

		
	
	private function makeNewPersonelMovement( $formData ) {
		$table = JTable::getInstance('PersonelHealthUnitHistory');
		$table -> id = null;
		$table -> EndDate = ( $formData -> RefUnitEndDate != '' ? $formData -> RefUnitEndDate : null );
		$table -> HealthUnitId = $formData -> HealthUnitId;
		$table -> RefHealthUnitId = $formData -> RefHealthUnitId;
		$table -> PersonelId = $formData -> PersonelId;
		$table -> PersonelStatusId = $formData -> PersonelStatusId;
		$table -> StartDate = $formData -> RefUnitStartDate;
		$table -> statusid = 1;		
		$table -> store();	
	}
	
	/////////////////// Specialities
	
	
	private function endPersonelSpeciality( $personelId, $endDate)	
	{
		$lastMovement = $this -> getLastPersonelSpeciality( $personelId );
		if ( count( $lastMovement ) > 0 ):
			$this -> pedyDB -> setQuery( "update PersonelSpecialityHistory set endDate = '$endDate', statusid = 2 where id = " . $lastMovement['id'] ) -> execute();
		endif;
	}
	
	private function getLastPersonelSpeciality($personelId)
	{
		return $this -> pedyDB -> setQuery("select id, SpecialityId, StartDate from PersonelSpecialityHistory where PersonelId = $personelId and (endDate is null or endDate ='0000-00-00 00:00:00') order by id desc limit 0, 1") -> loadAssoc();
	}
	
	
	private function isSpecialityDifferent( $SpecialityId, $PersonelId )
	{
		$data = $this -> pedyDB -> setQuery("select SpecialityId, EndDate from PersonelSpecialityHistory where PersonelId = $PersonelId order by StartDate desc") -> loadAssoc();
		if(count($data) > 0 ):
			if ($data['SpecialityId'] != $SpecialityId):
				return true;
			else:
				return false;
			endif;
		else:
			return true;
		endif;		
	}
	
	
	private function insertNewPersonelSpeciality( $formData )
	{
		$table = JTable::getInstance('PersonelSpecialityHistory');
		$table -> id = null;
		$table -> PersonelId = $formData -> PersonelId;
		$table -> SpecialityId = $formData -> PersonelSpecialityId;
                if ( $formData -> RefUnitStartDate === ''):
                    $table -> StartDate = $formData -> RefUnitStartDate;
                else: 
                    $table -> StartDate = date('Y-m-d'); 
                endif;
		$table -> statusid = 1;		
		$table -> store();
		return $table -> id;
		
	}
 }