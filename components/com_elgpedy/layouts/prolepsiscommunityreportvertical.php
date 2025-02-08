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
echo '<section id="elgdata"><div class="row">'; 


 foreach($this->fields->prolepsis as $item):

		$tbo ++;
		if(count($item) > 0 ) :
		$elgcnt ++;
		echo '<div class="col-md-6"><table class="table table-hover table-bordered " id="prolepsisTransaction"  ><thead><tr class="info" ><td colspan="2">' ,  $item[0] -> ActDesc,  '</td></tr></thead><tbody id="elgmedactid',  $item[0]->MedicalActId ,  '">';
		foreach($item  as $value):	
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
			echo '<tr><th>', $value->MedDesc, '</th><td class="col-md-2 ', $rowClass, '" id="elgmedtid', $value->MedicalActId, '-', $value->MedicalTypeId, '" data-inputclass="edit-text" tabindex="', $tbo, '" >', $rowValue, '</td></tr>';		
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

 echo '</div></section>';
 ?>
 <div class="clearfix"></div>
<?php include JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; 