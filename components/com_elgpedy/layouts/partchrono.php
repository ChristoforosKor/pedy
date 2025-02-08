<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');
  JFactory::getApplication()->getUserState('userUnits' ); 
?>
<script type="text/javascript">
     var unitsUrls = {};
    <?php 
            $activeId = 0;
            $currentId =$this->state->get('Itemid'); 
            $iId = $currentId;
            foreach(JFactory::getApplication()->getUserState('userUnits') as $unit): 
                if($unit->HealthUnitTypeId != 8 && $unit->HealthUnitTypeId != 11 && ($currentId == 119 || $currentId == 114 || $currentId = 122) ):                        
                    $iId = 112;
                elseif($unit->HealthUnitTypeId == 11 && ($currentId == 112 || $currentId == 120 || $currentId == 114 || $currentId=122)):
                    $iId = 119;
                elseif($unit->HealthUnitTypeId == 8 && ($currentId == 112 || $currentId == 120 || $currentId == 119 || $currentId == 123)):
                    $iId = 114;
                endif;
//                if($unit->HealthUnitTypeId != 8 && $unit->HealthUnitTypeId != 11 && ($currentId == 112 || $currentId == 120) ):
//                    $activeId = $unit->HealthUnitId;
//                elseif($unit->HealthUnitTypeId == 8 && ($currentId == 114 || $currentId == 122)):
//                    $activeId = $unit->HealthUnitId;
//                elseif($unit->HealthUnitTypeId == 11 && ($currentId == 119 || $currentId == 123)):
//                    $activeId = $unit->HealthUnitId;
//                endif;
               
                echo 'unitsUrls[', $unit->HealthUnitId, '] =\'', JRoute::_('index.php?option=com_elgpedy&Itemid=' . $iId ,false) . '\'; ';
            endforeach;    
//             if($activeId > 0):
//                    $this->forms->commonForm->setValue('HealthUnitId', null, $activeId);
//                endif;
    ?>
    jQuery(document).ready(function(){
        document.getElementById('RefMonth').onchange = elgGetFormData;
        document.getElementById('RefYear').onchange = elgGetFormData;
        document.getElementById('HealthUnitId').onchange = function() {location.href= unitsUrls[this.value] + '&HealthUnitId=' + document.getElementById('HealthUnitId').value + '&RefMonth=' + document.getElementById('RefMonth').value + '&RefYear=' + document.getElementById('RefYear').value;}
    });
   
</script>
<?php
    if($currentId == 122 || $currentId == 114):
    elseif($currentId == 112 || $currentId == 120):
    elseif($currentId == 123 || $currentId == 119):
    endif;
?>
<div class="col-sm-3" >
	<label class="control-label"><?php echo JText::_('COM_ELG_PEDY_UNIT'), '</label>',  $this->forms->commonForm->getInput('HealthUnitId'); ?>
</div>
<div class="col-sm-3" >
	<?php echo '<label class="control-label" for="RefYear">', JText::_('COM_ELG_PEDY_YEAR'), '</label>',  $this->forms->commonForm->getInput('RefYear'); ?> 
</div>
<div class="col-sm-3" >
	<?php echo '<label class="control-label" for="RefMonth">', JText::_('COM_ELG_PEDY_MONTH'), '</label>', $this->forms->commonForm->getInput('RefMonth'); ?> 
</div>

