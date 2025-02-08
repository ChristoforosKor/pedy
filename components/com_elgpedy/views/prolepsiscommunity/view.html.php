<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# @copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, dexteraconsutling.com
-----------------------------------------------------------------------**/
 
 defined( '_JEXEC' ) or die( 'Restricted access' );
 // require JPATH_COMPONENT_SITE . '/libraries/php/joomla/e-logism/views/view.php';
  require_once JPATH_COMPONENT_SITE . '/views/datacommon.php';
  require_once JPATH_COMPONENT_SITE . '/views/viewutils.php';
  
 /**
  * @package pedy.site
  * @subpackage views
  * 
  */
   
   class ElgPedyViewProlepsisCommunity extends DataCommon
   {
		protected $fields;
		public function render()
		{
			$data = $this->state->get('data');
			$this -> refDate = $data -> refDate;
			//$data->fields->prolepsis;
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
			
			$data -> fields->prolepsis = $fieldsView;
			$this -> fields = $data->fields;
			$this -> healthUnitId = $data -> healthUnitId;
			$this -> dataProlepsis = self::ProlepsisReform($data->data);
			$this -> dataProlepsisNew = self::ProlepsisReformDoctor($data -> data);
			// $this -> dataProlepsis = self::ProlepsisReformDoctor($data->data); //$dataProlepsis;
			$this -> docsDrop = $this -> makeDocsDrop($this -> fields -> doctors);
                                                $this -> prolepsis = 
			$this -> dataLayout = 'prolepsiscommunity.php';			
			JText::script('COM_ELG_PEDY_DELETE_ASK');
			return parent::render();			
		}	
		

	/**
	* Reforms model data to be viewed according to then new style where doctors area visible. Sums are presented on a per for each exam.
	* @data Array Data retrieved from model.
	**/
	
	public static function ProlepsisReformDoctor($data)
	{
		
		$dataProlepsis = array();
		
		foreach($data as $item):
		
			if( !isset ($dataProlepsis [ $item -> MedicalActId ] ) ) :
				$dataProlepsis [ $item -> MedicalActId ] = [];
			endif;
			if( !isset( $dataProlepsis [$item -> MedicalActId] [$item -> PersonelId]) ):
				$dataProlepsis [$item -> MedicalActId] [$item -> PersonelId]= [];
			endif;
			$dataProlepsis [$item -> MedicalActId] [$item -> PersonelId] []= [ $item -> MedicalTransactionId, $item -> PatientAmka, $item -> PatientAttributeInsurance, $item -> PatientAttributeOrigination,  $item -> MedicalTypeId, $item -> MunicipalityId, $item->Quantity  ];
		endforeach;
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
		
		
		private function makeDocsDrop($doctors)
		{
			$inserted = [];
			$nDSet = false;
			$res = '<select id="docsDrop">';
			foreach($doctors as $doctor):
				if ( $doctor['PersonelId'] === '' and $nDSet === true ):
					continue;
				else:
					$nDSet = true;
				endif;
				if(! in_array($doctor['PersonelId'], $inserted) ):
					$res .= '<option value="' . $doctor['PersonelId'] . '">' . $doctor['LastName'] . ' ' . $doctor['FirstName'] . '</option>';  
				endif;
				$inserted [] = $doctor['PersonelId'];
			endforeach;
			unset($doctor);
			$res .= '</select>';
			return $res;
		}
		
			// $data = $this->state->get('data');
			// $this->fields = $data->fields;
			// $this->dataClinical = ViewUtils::ClinicalReformDoctors($data->data); 
			
			// $this->dataLayout = 'clinicaltransaction.php';
            // $this -> docsDrop = $this -> makeDocsDrop($this -> fields -> doctors);
			// $this -> refDate = $data -> refDate;
			// $this -> healthUnitId = $data -> healthUnitId;
			// return parent::render();
   }
