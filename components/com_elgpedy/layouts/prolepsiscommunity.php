<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');  
$elgcnt =0;
$lastActId = 0;
$tbo=0;
$act7 = [];
$attr1 = [];
$attr2 = [];



foreach ( $this -> fields  -> prolepsisAtttibutesValues as $attribute ):
	if ( $attribute -> PatientAttributeId == 1 ):
		$attr1[] = $attribute;
	elseif ( $attribute -> PatientAttributeId == 2 ):
		$attr2[] = $attribute;
	endif;
endforeach;
unset( $idType );
unset( $attribute );

echo '<section id="elgdata"><div class="row">'; 


 foreach($this -> fields -> prolepsis as $item):
	
		if ( $item[0] -> MedicalActId == 7):
			$act7[] = $item;
			continue;
		endif;
		$tbo ++;
		if(count($item) > 0 ) :
		$elgcnt ++;
		echo '<div class="col-md-6"><table class="table table-hover table-bordered "   ><thead><tr class="info"><td colspan="2">', $item[0]->ActDesc, '</td></tr></thead><tbody id="elgmedactid', $item[0]->MedicalActId, '">';
		foreach($item  as $value):	
			//echo $value -> MedicalActId, '-', $value -> MedicalTypeId, '<br />';
			//var_dump( $this->dataProlepsis[$value->MedicalActId][$value->MedicalTypeId] );
			//exit();		
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
			echo '<tr><th>', $value->MedDesc, '</th><td class="col-md-2 ', $rowClass, '  editable editable-text" id="elgmedtid', $value->MedicalActId, '-', $value->MedicalTypeId, '" data-inputclass="edit-text" tabindex="', $tbo, '" >', $rowValue, '</td></tr>';		
		endforeach;
		unset($value);
		echo '</tbody></table></div>';
	endif;
	if($elgcnt % 2 === 0)
	{
		echo '</div><hr /><div class="row">';
	}
 endforeach;
 unset($item);
 
 echo '</div>';
 
 
 //////////////////////////////////////////////// Show results with doctors details.
	$totalSum = 0;
	$medicalActId = 7;
	echo '<div class="row" ><div class="col-md-12"><table class="table table-hover table-bordered medicalTransaction-' . $medicalActId .'" ><thead><tr class="info"><td colspan="8">', $act7[0][0]->ActDesc, '</td></tr>'
	, '<tr><th> Φυσικοθεραπευτής/τρια</th><th>ΑΜΚΑ Ασθενούς</th>';
	foreach ( $this -> fields -> prolepsisAttributes as $attr ):
		echo '<th>', $attr -> attribute, '</th>';
	endforeach;
	unset($attr);
	echo '<th>Τύπος Περιστατικού</th><th>Εξυπηρετούμενος Δήμος</th><th>Ποσότητα</th><th></th></tr></thead>'
	, '<tfoot><tr><td colspan="8" ><button type="button" class="btn btn-default addDoctor pull-left">Προσθήκη Ιατρού</button></td> </tr>'
	, '<tbody data-id="' . $medicalActId . '" >';
        // $personelInserted = [];
		
		foreach($this -> fields -> doctors as $doctor):
			if ( isset( $this -> dataProlepsisNew[ $medicalActId ][ $doctor['PersonelId'] ] ) ): // if there is a record of the doctor for medicalActId = 7 show it.
				getRowProlepsis( $doctor, $this -> dataProlepsisNew[ $medicalActId ][ $doctor['PersonelId'] ], $this -> refDate, $this -> healthUnit );  
			elseif( $doctor['PersonelSpecialityId'] == 51 ) : // show the docotr if is a physiotherapist
				getRowProlepsis( $doctor, [['','','','', 0,0,0]], $this -> refDate, $this -> healthUnitId );  
			endif;
	    endforeach;
        unset($doctor);
        echo '</tbody></table></div>';
        
	if($elgcnt % 2 === 0)
	{
		echo '</div><hr /><div class="row">';
	}
  
 echo '</div></section><div class="clearfix">&nbsp;</div><p><span class="comments-title">', JText::_('COM_ELG_PEDY_COMMENTS'), ':</span>', JText::_('COM_ELG_PEDY_FORM_FOOTER_CLINIC'), '</p>';
 function getRowProlepsis($doctor, $rows, $refDate, $healthUnitId)
	{
		/**
			0: MedicaalTransactionId
			1: PatientAmka
			2: PatientAttributeInsurance
			3: PatientAttributeOrigination
			4: MunicipalityId
			5: MedicalTypeId
			6: Quantity
			
		**/
		foreach ( $rows as $rowData ): 
			// echo json_encode( $rowData ), '<br />';
			if ( $rowData[6] == 0 ) :
				$className = ' warning ';
			else:
				$className = ' success ';
			endif;
			echo '<tr data-id="' . $rowData[0] . '" ><th data-id="' , $doctor['PersonelId'], '" >', $doctor['FirstName'], ' ', $doctor['LastName'], '</th>'
			, '<td class=" editable',' ', $className, '" >', $rowData[1], '</td>'	
			, '<td class=" editable-drop1',' ', $className, '" >', $rowData[2], '</td>'
			, '<td class=" editable-drop2',' ', $className, '" >', $rowData[3], '</td>'
			, '<td class=" editable-med-type',' ', $className, '" >', $rowData[4], '</td>'
			, '<td class=" editable-munic',' ', $className, '" >', $rowData[5], '</td>'
			, '<td class=" editable-doctor-quantity',' ', $className, '" >', $rowData[6], '</td>'
			, '<td><button type="button" class="btn btn-default more-incidents">+</button><button type="button" class="btn btn-warning remove-record">-</button></td></tr>';
		endforeach;
		unset( $rowData );
	
	}
 
	function getCellProlepsis_($MedicalActId, $id, $idType, $doctorId, $personelData, $classsfx="text-doctors" )
	{
		 if( $incidentId !='' ):
				$rowValue = $personelData[$MedicalActId];
				if($rowValue > 0 ):
					$rowClass='success';
		 
				else :
					$rowClass='warning';
					$rowValue= '';
				endif;
		else:
			$rowClass='warning';
			$rowValue= '';
		endif;
		echo '<td class=" editable-', $classsfx, ' ', $rowClass, '" data-id="' . $id . '"   >', ( $idType === 3 && $rowValue === '' ? 0 : $rowValue), '</td>';
		return $rowValue;		
	}
 ?>
  <div class="modal fade" id="docModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">x</button>
          <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span>Επιλέξτε</h4>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="form-group">
                <div class="doctor">
                    <label for="doctor">Ιατρός</label>
                    <?php echo $this -> docsDrop;?>
                </div>
            </div>
           
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal" onclick="insertDoctor()">Εισαγωγή</button>
          
        </div>
      </div>
    </div>
  </div>
</div>
 
 <div class="modal fade" id="remDocModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">x</button>
          <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span>Διαγραφή</h4>
        </div>
        <div class="modal-body">
         
        </div>
		<input type="hidden" value="" id="rin" />
	
        <div class="modal-footer">
          <button type="btn" id="remDocBt" class="btn btn-danger btn-default pull-left" onclick="removeDoctor()">Διαγραφή</button>          
        </div>
      </div>
    </div>
  </div>
</div>
 
<script type="text/javascript">
	var attr1 = <?php echo json_encode ( $attr1 ); ?>.map(function(item){ return {value: item.id, text: item.Value}});
	var attr2 = <?php echo json_encode ( $attr2 ); ?>.map(function(item){ return {value: item.id, text: item.Value}});
	var attrs = <?php echo json_encode ( $this -> fields -> prolepsisAttributes ); ?>;
	var meds = <?php echo json_encode ( $act7[0] ); ?>.map(function(item){ return {value: item.MedicalTypeId, text: item.MedDesc}});
	var municipalities = <?php echo json_encode ( $this -> fields -> municipalities ); ?>.map(function(item){ return {value: item.MunicipalityId, text: item.DescEL}});
	var prolepsisPhysioTherapistSaveUrl  = '<?php echo JRoute::_('index.php?option=com_elgpedy&view=prolepsiscommunitydataeditsave&format=json&Itemid=' . $this->state->get('Itemid'), false); ?>';
	var prolepsisRemoveDoctorUrl = 'index.php?option=com_elgpedy&controller=removedoctormedicaltransaction&format=json&Itemid=<?php echo $this->state->get('Itemid'); ?>';
	
</script>
<script type="application/javascript" src="media/com_elgpedy/js/prolepsiscommunityscripts.js" ></script>



