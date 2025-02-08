<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');  

$lastActId = 0;
$tbo=0;
echo '<section id="elgdata"><div class="row">'; 

// echo json_encode( $this -> fields -> prolepsis );
 foreach($this->fields->prolepsis as $item):
	if ( $item[0] -> MedicalActId === '7' ):

		showNewStyle($item, $this -> dataProlepsisNew);
		continue;
	endif;
		$tbo ++;
		if(count($item) > 0 ) :
		
		echo '<div class="col-md-10"><table class="table table-hover table-bordered prolepsisTransaction-' , $item[ 'MedicalActId' ], '"  ><caption>', $item[0]->ActDesc, '</caption><thead><tr>';
		foreach($item  as $value):	
                    echo '<th>', $value->MedDesc, '</th>';
                endforeach;
                unset($value);
                echo '</tr></thead><tbody id="elgmedactid', $item[0]->MedicalActId, '"><tr>';
                foreach($item as $value):
                    
			if(isset($this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId]))
			{
				$rowValue= $this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId];
				if($this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId] > 0)
				{
					$rowClass='success';					
				}
				else
				{
					$rowClass='warning';
				}
			}
			else
			{
				$rowClass='warning';
				$rowValue= 0;
			}
			echo '<td class="' , $rowClass, '" id="elgmedtid', $value->MedicalActId, '-', $value->MedicalTypeId, '" data-inputclass="edit-text" tabindex="', $tbo, '" >', $rowValue, '</td>';		
		endforeach;
		unset($value);
		echo '</tr></tbody></table></div>';
	endif;
	
		echo '</div><div class="row">';
	
 endforeach;
 unset($item);
 unset($item);
 echo '</div></section>';
 
 function showNewStyle($item, $dataProlepsisNew) {
	 /**
			0: LastName
			1 : FirstName
			2: AMKA
			3: PatientAttributeInsurance
			4: PatientAttributeOrigination
			5: MedicalTypeId
			6: MunicipalityId
			7: Quantity
		**/
	$sum = 0;
					
	$sum_entos=0;
	$sum_ektos=0;
						
	 echo '<div class="col-md-10"><table class="table table-hover table-bordered prolepsisTransaction-' , $item [ 'MedicalActId' ] , '"  ><caption>', $item[0]->ActDesc, '</caption><thead><tr>',
	 '<th>Ιατρός</th><th>Ασφαλιστικός Φορέας Ασθενούς</th><th>Προέλευση Ασθενούς</th><th>Τύπος Περιστατικού</th><th>Εξυπηρετούμενος Δήμος</th><th>Ποσότητα</th></tr></thead>';
	$bodyHTML ='<tbody>'; 
	foreach ( $dataProlepsisNew as $medicalActData ):
		foreach ( $medicalActData as $doctorData ):
			foreach ( $doctorData as $dataItem):
				$bodyHTML .= '<tr><th>'. $dataItem[0] . ' ' . $dataItem[1] . '</th><td>' . $dataItem[3] . '</td><td>' . $dataItem[4] . '</td><td>' . $dataItem[5] . '</td><td>' . $dataItem[6] . '</td><td>' . $dataItem[7] . '</td></tr>'; 
				$sum += $dataItem[7];
										
				if ($dataItem[5] == 'Εντός Μονάδας'):
					$sum_entos+=$dataItem[7];
				else :
					$sum_ektos+=$dataItem[7];
				endif;
				
			endforeach;
			unset( $dataItem );
		endforeach;
		unset( $doctorData );
	endforeach;
	unset( $medicalActData );
	//echo '<tfoot><tr><td colspan="5"></td><th>Σύνολο</th><td><strong>' . $sum . '</strong></td></tr></tfoot>' . $bodyHTML . '</tbody></table></div>';
	echo '<tfoot> <tr><td colspan="4"></td><th>Εντός Μονάδας</th><td><strong>' . $sum_entos . '</strong></td></td></tr>   <tr><td colspan="4"></td><th>Κατ’οίκον</th><td><strong>' . $sum_ektos . '</strong></td>   </td></tr> <tr><td colspan="4"></td><th>Σύνολο</th><td><strong>' . $sum . '</strong></td></tr></tfoot>' . $bodyHTML . '</tbody></table></div>';
}
 
 ?>
<div class="clearfix"></div>
<?php include_once JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; ?>
