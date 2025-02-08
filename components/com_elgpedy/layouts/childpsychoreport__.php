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
$lastDepartmentId = '';
echo '<section id="elgdata">'; ?>
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
foreach($this->departments as $depName=>$depId):
    if($lastDepartmentId != $depId): ?>
<h3><?php echo $depName; $lastDepartmentId = $depId; ?></h3>
<?php
echo '<div><table class="table table-hover table-bordered clinicTransaction" ><thead><tr class="info"><th></th>';
        foreach($this -> incidents as $incident):
            if($incident->DepartmentId == $lastDepartmentId):
                echo  '<th>', $incident->Incident, '</th>';
            endif;
        endforeach;
        unset($incident);
        echo '</tr></thead><tbody >';
endif; 
foreach($this -> clinics as $clinic):
    
    if($clinic->DepartmentId == $lastDepartmentId):
        echo '<tr id="elgcli', $clinic->ClinicId, '"><th>', $clinic->Clinic, '</th>';
	$elgcnt ++;
	
	foreach($this ->  incidents as $incident):
            if($incident->DepartmentId == $lastDepartmentId) :
		if(isset($this->dataClinical [$lastDepartmentId][$clinic->ClinicId][$incident->IncidentId])):
			
			$rowValue= $this->dataClinical[$lastDepartmentId][$clinic->ClinicId][$incident->IncidentId];
			if($rowValue > 0 ):
				$rowClass='success';
			else :
				$rowClass='warning';
			endif;
		else:
			$rowClass='warning';
			$rowValue= 0;
		endif;
		echo '<td class="', $rowClass, '" id="elginc', $lastDepartmentId, '-', $clinic->ClinicId, '-', $incident->IncidentId, '" data-inputclass="edit-text">', $rowValue, '</td>';		
            endif;
        endforeach;
	unset($incident);
	echo '</tr>';
	
    else:  //clinic departmentid
        $elgcnt = 0;
    endif;
   
 endforeach;
 unset($clinic);
 echo '</tbody></table>';

endforeach; unset($department);
?>
</section>
<div class="clearfix"></div>
<?php include_once JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; ?>