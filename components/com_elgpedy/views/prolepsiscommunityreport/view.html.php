<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
  
   require_once JPATH_COMPONENT_SITE . '/views/datacommonreport.php';
   require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
  
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewProlepsisCommunityReport extends  DataCommonReport
   {
   	   	
		public function render()
		{
                    $data = $this->state->get('data');
			$data->fields->prolepsis;
			$fieldsView = array();
			$lastActId = 0;
			foreach($data->fields->prolepsis as $field)
			{
				if($lastActId != $field->MedicalActId)
				{
					$lastActId = $field->MedicalActId;
					$fieldsView[$lastActId] = array();
					
				}
				$fieldsView[$lastActId][] = $field;
			}
			unset($field);
			
			$data->fields->prolepsis = $fieldsView;
			$this->fields = $data->fields;
			$this->dataProlepsis = self::ProlepsisReform($data->data);
			$this -> dataProlepsisNew = self::ProlepsisReformDoctor($data -> newData);
			$this->dataLayout = 'prolepsiscommunityreport.php';
                        $this->submitUrl = JRoute::_('index.php?option=com_elgpedy&Itemid=115');
			return parent::render();
		}
		
	/**
	* Reforms model data to be viewed according to then new style where doctors area visible. Sums are presented on a per for each exam.
	* @data Array Data retrieved from model.
	**/
	public static function ProlepsisReformDoctor($data)
	{
		$dataProlepsis = array();
		foreach($data as $item)
		{
			
			if( !isset( $dataProlepsis[ $item->MedicalActId ] ) ):
				$dataProlepsis[$item->MedicalActId] = [];
			endif;
			if( !isset( $dataProlepsis[ $item->MedicalActId ][ $item->PersonelId ] ) ):
				$dataProlepsis[ $item->MedicalActId ][ $item->PersonelId ] = [];
			endif;
			$dataProlepsis[ $item->MedicalActId ][ $item->PersonelId ][] = [ $item -> FirstName, $item -> LastName, $item -> PatientAmka, $item -> PatientAttributeInsurance, $item -> PatientAttributeOrigination,  $item -> MedicalType, $item -> Municipality, $item->Quantity  ];
		}
		unset($item);
		return $dataProlepsis;
	}
	
	/**
	* Reforms model data to be viewed according to old style where doctors area not visible. Only the sums are showing for each exam.
	* @data Array Data retrieved from model.
	**/
	public static function ProlepsisReform($data)
	{
		$dataProlepsis = array();
		foreach($data as $item)
		{
			
			if(isset($dataProlepsis[$item->MedicalActId]))
			{
				$dataProlepsis[$item->MedicalActId][$item->MedicalTypeId] =$item->Quantity;
			}
			else
			{
				$dataProlepsis[$item->MedicalActId] =  array();
				$dataProlepsis[$item->MedicalActId][$item->MedicalTypeId] =$item->Quantity;
			}
		}
		unset($item);
		return $dataProlepsis;
	}

	
   }
