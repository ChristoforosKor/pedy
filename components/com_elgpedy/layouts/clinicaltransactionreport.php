<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access'); 
$elgcnt = 0;
$departmentId = 1;
function getIncidentGroupLabel( $groupData, $clinicId, $incidentId, $groupId) {
    if ( isset( $groupData[$clinicId][$incidentId][$groupId][1] ) ):
        return $groupData[$clinicId][$incidentId][$groupId][1] . ': ';
    else:
        return '';
    endif;
}


$clinicsSummedNoEx = array_filter ( $this -> sumedClinics, function( $item ) { 
    return $item -> isExclusive === '0';
            
});

$clinicsSummedEx = array_filter ( $this -> sumedClinics, function( $item ) { 
    return $item -> isExclusive === '1';
            
});

$notSummedIncidents = array_filter( $this -> incidents, function ($item ){
    return ( $item -> IncidentId !== "10");
       
} );
 
?>
<div class="elg">
	<div class="pedy-form-data">
		<table class="table table-bordered table-striped clinicTransaction">
			<tr>
				<?php 
				
					if($this->checker == 0):
					$rowClass='warning';
					else:
					$rowClass='success';
					endif;
				?>
				<th><?php echo JText::_('COM_ELG_PEDY_CHECKER');?></th><td class="<?php echo $rowClass; ?>" id="checkerValue" ><?php echo $this->checker; ?></td>
			</tr>
		</table>
		
		<?php 
		
		if (isset($this -> dataClinical)):?>
		<h3><?php echo date('d/m/Y', strtotime($this -> d1['start'])) . ' - ' . date('d/m/Y', strtotime($this -> d1['end'])); ?></h3>
		<table class="table table-bordered table-striped clinicTransaction">
			<thead>
				<tr>
					<th></th>
					<?php foreach($this->incidents as $incident): ?>
						<th><?php echo $incident->Incident; ?></th>
					<?php endforeach; unset($incident); ?>
				</tr>
			</thead>
			<tbody id="elgRTClinical" >
				<?php 
                                                                   //     $incidents = ComponentUtils::getClinicsRelInicidents( $this -> incidentsGroups, $this -> clinics );
                                                                       foreach($this -> clinics as $clinic): ?>
					<tr>
						<th><?php echo $clinic->Clinic; ?></th>
						<?php 
						
						foreach($this->incidents as $incident):  // prepei na perilmvanoun kai is exclusive
							if(isset($this->dataClinical[$departmentId][$clinic->ClinicId][$incident->IncidentId])):
								$rowValue = '';
								forEach ( $this->dataClinical[$departmentId][$clinic->ClinicId][$incident->IncidentId] as $groupId => $incidentGroupData ):
								if($incidentGroupData > 0 ):
									$rowClass='success';
								else :
									$rowClass='warning';
								endif;
									$rowValue .= getIncidentGroupLabel(   $this -> reformedGroups , $clinic->ClinicId, $incident->IncidentId, $groupId)  . $incidentGroupData . '<br />'; 
								 endforeach;
								 unset($groupId);
								 unset($incidentGroupData);
							else:
									$rowClass='warning';
									$rowValue= 0;
							endif;
						 //   echo $rowValue;
					?>
					<td id="elginc<?php echo $clinic->ClinicId; ?>-<?php echo $incident->IncidentId ;?>"  class="<?php echo $rowClass; ?>"><?php echo 	$rowValue; ?></td>
						<?php endforeach; unset($incident); ?>
					</tr>
				<?php endforeach; unset($clinic); ?>
			</tbody>
		</table>
		<?php endif; ?>
		<?php 
		
		if (isset($this -> newData)):

			
                                ?>
                                
		<h3><?php echo date('d/m/Y', strtotime($this -> d2['start'])) . ' - ' . date('d/m/Y', strtotime($this -> d2['end'])); ?></h3>
		<?php 
            
			foreach($this -> notSumedClinics as $clinic):
                                                   
                                                ?>
				<table class="table table-bordered table-striped clinicTransaction">
					<thead>
						<tr class="info"><td colspan="<?php echo (count($this -> incidents) + 1) ?>"><?php echo $clinic->Clinic; ?></td></tr>
						<tr>
							<th></th>
							<?php foreach( $notSummedIncidents  as $incident): ?>
								<th><?php echo $incident->Incident; ?></th>
							<?php endforeach; unset($incident); ?>
						</tr>
					</thead>					
					<tbody>
						<?php 
							 $sums = [];
							if(isset($this -> newData[$departmentId][$clinic -> ClinicId])):
                                                                                                                     
							foreach($this -> newData[$departmentId][$clinic -> ClinicId] as $personelId => $personel): ?>
							<tr>
								<th><?php echo $personel['LastName'] . ' ' . $personel['FirstName'] ; ?></th>
								<?php foreach( $notSummedIncidents  as $incident): 
										if(isset($personel['incidents'][$incident -> IncidentId])):
													//if(isset($this->newData[$departmentId][$clinic->ClinicId][$incident->IncidentId])):
												$rowValue = '';
												forEach ( $personel['incidents'][$incident -> IncidentId] as $groupId => $incidentGroupData ):
													if($incidentGroupData > 0 ):
															$rowClass='success';
													else :
															$rowClass='warning';
													endif;
													$label = getIncidentGroupLabel(   $this -> reformedGroups , $clinic->ClinicId, $incident->IncidentId, $groupId);
													if ( $label !== ''):
														$rowValue .= '<div class="igr">' . ( $label !== '' ? '<span class="igrl">' . $label . '</span>': '')  . '<span class="igrv">' . $incidentGroupData . '</span></div>'; 
													else:
														$rowValue .=  '<div class="ingr">' . $incidentGroupData . '</div>'; 
													endif;
													
													 if ( !isset( $sums[ $incident -> IncidentId ]  ) ):
														$sums[ $incident -> IncidentId ] = 0;
													endif;
													$sums[ $incident -> IncidentId ] += $incidentGroupData;
												 endforeach;
												 unset($groupId);
												 unset($incidentGroupData);
										else:
											$rowClass='warning';
											$rowValue= '<div class="ingr">0</div>';
										endif;
										   
													
								?>
								<td id="elginc<?php echo $clinic->ClinicId; ?>-<?php echo $incident->IncidentId ;?>-<?php echo $personelId ;?>"  class="<?php echo $rowClass; ?>"><?php echo $rowValue  ?></td>
								<?php endforeach;
								unset($incident); 
								?>
							</tr>
							<?php endforeach;
							unset($personel);
							unset($personelId);
                                                                                                                
						endif?>
                                                        <tr>
                                                            <th>Σύνολα</th>
                                                            <?php foreach( $notSummedIncidents  as $incident ): ?>
                                                            <td class="text-right"><strong><?php  echo ( isset( $sums[ $incident -> IncidentId ] ) ? $sums[ $incident -> IncidentId ] : 0 ) ?></strong></td>
                                                            <?php
                                                            endforeach;
                                                            unset($incident); ?>
                                                        </tr>
					</tbody>
				</table>
		<?php	endforeach;
			unset($clinic);
                                ?>
                                        <table class="table table-bordered table-striped clinicTransaction">
			<thead>
				<tr>
					<th></th>
					<?php foreach($this->incidents as $incident): ?>
						<th><?php echo $incident->Incident; ?></th>
					<?php endforeach; unset($incident); ?>
				</tr>
			</thead>
			<tbody id="elgRTClinical" >
				<?php 

                                foreach($clinicsSummedNoEx as $clinic): ?>
					<tr>
						<th><?php echo $clinic->Clinic; ?></th>
						<?php 
						
						foreach($this->incidents as $incident):
							if(isset($this->newDataSumed[$departmentId][$clinic->ClinicId][$incident->IncidentId])):
								  $rowValue= '';
								  forEach ( $this->newDataSumed[$departmentId][$clinic->ClinicId][$incident->IncidentId] as $groupId => $incidentGroupData ):
											if($incidentGroupData > 0 ):
													$rowClass='success';
											else :
													$rowClass='warning';
											endif;
											$label = getIncidentGroupLabel(   $this -> reformedGroups , $clinic->ClinicId, $incident->IncidentId, $groupId);
											if ( $label !== ''):
												$rowValue .= '<div class="igr">' . ( $label !== '' ? '<span class="igrl">' . $label . '</span>': '')  . '<span class="igrv">' . $incidentGroupData . '</span></div>'; 
											else:
												$rowValue .=  '<div class="ingr">' . $incidentGroupData . '</div>'; 
											endif;
									endforeach;
									unset($groupId);
									unset($incidentGroupData);                                                                                              
							else:
											$rowClass='warning';
											$rowValue= '';
							endif;
//							
					?>
					<td id="elginc<?php echo $clinic->ClinicId; ?>-<?php echo $incident->IncidentId ;?>"  class="<?php echo $rowClass; ?>"><?php echo 	$rowValue; ?></td>
						<?php endforeach; unset($incident); ?>
					</tr>
				<?php endforeach; unset($clinic); ?>
			</tbody>
		</table>
                
                             <hr />
                             
                                     <table class="table table-bordered table-striped clinicTransaction">
			<thead>
				<tr>
					<th></th>
					<?php 
				   $clinicsIds = array_column( $clinicsSummedEx, 'ClinicId' ); 
				   $exIncidents = []; // will filed with unique exclusive inceidetns from all exclusive clinis
				   forEach( $this -> reformedGroups  as $clinicId => $clinic ):
					   if ( in_array( $clinicId, $clinicsIds) ): // Clinics with grouped incidents that also belong to clinics with exclusive incidents
						   forEach ( $this -> reformedGroups[$clinicId] as $incidentId => $group):
								if ( ! in_array( $incidentId, $exIncidents  ) ): // exclude incident if it is already written to page. (Unique incdents).
									echo '<th>', $group[$incidentId][0], '</th>';
								$exincidents[] = $incidentId;
								endif;
						   endforeach;
							unset ( $incidentId );
							unset( $group);
					   endif ;                                                                                          
				   endforeach;
				   unset($clinic);
				   unset($clinicId);
				   ?>

				</tr>
			</thead>
			<tbody id="elgRTClinical" >
				<?php 
                       
                                foreach($clinicsSummedEx as $clinic): ?>
					<tr>
						<th><?php echo $clinic->Clinic; ?></th>
						<?php 
						 echo pdCSRow(  $clinic -> ClinicId, $this -> reformedGroups, $departmentId, $this -> newDataSumed);
                                                         
                                                         ///////////////////////////////////////////////////////////////////////////////////////////////////
                                                         /*
						foreach($this->reformedGroups as $clinicId => $incident  / **as $incident** /):  // as $clinicId => $clinic 
                                                                                                    if( $clinicId != $clinic -> ClinicId ):
                                                                                                        continue;
                                                                                                    endif;
                                                                                                    forEach ( $incident as $incidentId => $group):
                                                                                                    
                                                                                                                        if(isset($this->newDataSumed[$departmentId][$clinic->ClinicId][$incident->ClinicIncidentId])):
                                                                                                                              $rowValue= '';
                                                                                                                              forEach ( $this->newDataSumed[$departmentId][$clinic->ClinicId][$incident->ClinicIncidentId] as $groupId => $incidentGroupData ):
                                                                                                                                        if($incidentGroupData > 0 ):
                                                                                                                                                $rowClass='success';
                                                                                                                                        else :
                                                                                                                                                $rowClass='warning';
                                                                                                                                        endif;
                                                                                                                                        $label = getIncidentGroupLabel(   $this -> reformedGroups , $clinic->ClinicId, $incident->ClinicIncidentId, $groupId);
                                                                                                                                        if ( $label !== ''):
                                                                                                                                            $rowValue .= '<div class="igr">' . ( $label !== '' ? '<span class="igrl">' . $label . '</span>': '')  . '<span class="igrv">' . $incidentGroupData . '</span></div>'; 
                                                                                                                                        else:
                                                                                                                                            $rowValue .=  '<div class="ingr">' . $incidentGroupData . '</div>'; 
                                                                                                                                        endif;
                                                                                                                                endforeach;
                                                                                                                                unset($groupId);
                                                                                                                                unset($incidentGroupData);                                                                                              
                                                                                                                        else:
                                                                                                                                        $rowClass='warning';
                                                                                                                                        $rowValue= '';
                                                                                                                        endif;
                                                                                                           endforeach;
                                                                                                    unset($incidentId);
                                                                                                    unset($group);	
					?>
					<td id="elginc<?php echo $clinic->ClinicId; ?>-<?php echo $incident->ClinicIncidentId ;?>"  class="<?php echo $rowClass; ?>"><?php echo 	$rowValue; ?></td>
						<?php endforeach; unset($clinic); unset($clinicId);
                                                */
                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                ?>
					</tr>
				<?php endforeach; unset($clinic); ?>
			</tbody>
		</table>
                    <?php endif; ?>
	</div>
</div>
<div class="clearfix"></div>
<?php include JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; 
 function pdCSRow( $curClinicId, $reformedGroups, $departmentId, $newDataSumed)
{
    $cells = '';
    foreach ( $reformedGroups as $clinicId => $incident): 
        if( $clinicId != $curClinicId ):
           // $cells .= '<td></td>';
            continue;
         endif;
         
         forEach ( $incident as $incidentId => $groups ):
             $cellValue = '';
             if ( isset ( $newDataSumed[$departmentId][ $curClinicId] [ $incidentId ] ) ):
                if( count( $newDataSumed[$departmentId][ $curClinicId] [ $incidentId ] ) > 0 ):
                    $cellClass='success';
                     $cellValue =  getCellsData ( $curClinicId, $incidentId, $newDataSumed[$departmentId], $reformedGroups );
                else :
                    $cellClass='warning';
                    $cellValue = '';
                endif;
               
            else:
                  $cellClass='warning';
                  $cellValue = '' ;
            endif;           
            $cells .= getCell( $curClinicId, $curClinicId, $cellClass, $cellValue);
         endforeach;
         unset( $incidentId );
         unset( $groups );
    endforeach;
    unset($clinicId);
    unset($incident);
    return $cells;
}

function getCellsData( $curClinicId, $curIncidentId, $departmentData, $reformedGroups ) {
    $cellValue = '';
    forEach ( $departmentData[ $curClinicId] [ $curIncidentId ] as $groupId => $incidentGroupData ):
        $label = getIncidentGroupLabel(   $reformedGroups , $curClinicId, $curIncidentId, $groupId);
        if ( $label !== ''):
            $cellValue .= '<div class="igr">' . ( $label !== '' ? '<span class="igrl">' . $label . '</span>': '')  . '<span class="igrv">' . $incidentGroupData . '</span></div>'; 
        else:
            $cellValue .=  '<div class="ingr">' . $incidentGroupData . '</div>'; 
        endif;
    endforeach;
    unset( $groupId );
    unset( $incidentGroupData );
    return $cellValue;
}


function getCell( $clinicId, $clinicIncidentId, $cellClass, $cellValue)
{
    return '<td id="elginc' . $clinicId . '-' . $clinicIncidentId . '"  class="'. $cellClass . '">' . $cellValue . '</td>';
}

?>
