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


 foreach($this->fields->prolepsis as $item):

		$tbo ++;
		if(count($item) > 0 ) :
		
		echo '<div class="col-md-10"><table class="table table-hover table-bordered " id="prolepsisTransaction"  ><caption>', $item[0]->ActDesc, '</caption>'
                        . '<thead><tr>';
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
 ?>
<div class="clearfix"></div>
<?php include_once JPATH_COMPONENT_SITE . '/layouts/partmissing.php'; ?>