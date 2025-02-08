<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/models/pedy.php';

class ElgPedyModelPersonels extends Pedy
{
	function getState() 
	{
		$huids = ComponentUtils::getUserHUOnlyIds();
		$state = parent::getState();
                $search = $state -> get('search', '');
                if ( strlen($search) > 2 ):
                    $search = $this->pedyDB-> quote("%$search%");
                else:
                    $search = '';
                    
                endif;
                $trn = $state -> get('trn', ''); // epxlicitly search for tax number (e.g. personel edit page validate  afm );
		if ( $trn !== ''):
                    $trn = $this -> pedyDB -> quote("%$trn%");
                endif;
                
                $amka = $state -> get('amka', ''); // epxlicitly search for amka number (e.g. personel edit page validate amka );
		if ( $amka !== ''):
                    $amka = $this -> pedyDB -> quote("%$amka%");
                endif;
                
                $data = new stdClass();
		$query = $this->pedyDB->getQuery(true);
		
		$query->select('count(*)')
		->from('Personel p')
		->leftJoin('PersonelSpecialityHistory ps on p.PersonelId = ps.PersonelId and ps.endDate is null')
		->leftJoin('PersonelSpeciality s on s.PersonelSpecialityId = ps.SpecialityId')
		->leftJoin('PersonelHealthUnitHistory ph on p.PersonelId = ph.PersonelId and ph.endDate is null')
		->leftJoin('HealthUnit hu on hu.HealthUnitId = ph.HealthUnitId')
		->where(
                        'p.StatusId in (' . $state -> get('statusId', 1) . ') '  
                     . ( $state -> get('all', 0) === 0 ? " and ph.HealthUnitId in (" . implode(',', $huids) . ")"  : "" ) // search on all health untis or only to those the user has access. The first on is used for validtion of amka etc. 
                    . ( $search === '' ? ''
                                : " and ( LastName like $search  or p.amka like $search or p.trn like $search ) ") 
                    . ( $trn === ''  ? ''
                                : " and ( p.trn like $trn ) ") // epxlicitly search for tax number (e.g. personel edit page validate  afm );
                    . ( $amka === ''  ? ''
                                : " and ( p.amka like $amka ) ") // epxlicitly search for amka number (e.g. personel edit page validate amka );
                );
		
		$this->pedyDB->setQuery($query);
		$data->total = $this->pedyDB->loadResult();
		
		$query->clear('select');
		$query->select('p.PersonelId, LastName, FirstName, FatherName, hu.DescEL as HealthUnit, s.DescEL as PersonelSpeciality, p.amka, p.trn, hu.HealthUnitId, p.statusId')
		 ->order( $state->get('filter_order', 'LastName')  . ' ' . $state->get('filter_order_DIR', 'desc') . ' limit '. $state->get('limitstart') . ', '. $state->get('limit'));
		
		$this->pedyDB->setQuery($query);
		
		$data->rows = $this->pedyDB->loadObjectList();
		$data -> huids = $huids;
		$state-> set('data', $data );
		return $state;	
	}
 }