<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');  
//$healthUnits = $this->state->get('data')->healthUnits;
$ItemId = $this->state->get('Itemid'); 
 ?>
 <h2><?php echo JFactory::getApplication()->getMenu()->getActive()->title;?></h2>
<div class="elg">
	<table id="healthUnits" class="table table-striped table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo JText::_('COM_ELG_ID'); ?></th>
                    <th><?php echo JText::_('COM_ELG_PEDY_UNIT'); ?></th>
                    <th><?php echo JText::_('COM_ELG_PEDY_UNIT_TYPE'); ?></th>
                    <th><?php echo JText::_('COM_ELGPEDY_ADDRESS'); ?></th>
                    <th><?php echo JText::_('COM_ELGPEDY_PHONE'); ?></th>
                </tr>
            </thead>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    var dtbl = jQuery('#healthUnits').dataTable({
        "processing": true,
        "serverSide": true,
		"searching": false,
		"info": false,
		"order": [[1, 'asc']],
		"ajax": "<?php echo JRoute::_('index.php?option=com_elgpedy&view=healthunits&format=json&Itemid=' . $ItemId, false); ?>",
		"language": {url: "//cdn.datatables.net/plug-ins/725b2a2115b/i18n/Greek.json"},
		"columns": [
                    {
                        "class":          'details-control',
                        "orderable":      false,
                        "data":           null,                
                        "defaultContent": '<span class="text-info"  onclick="elgEditHealthUnit(this)" >' + Joomla.JText._('COM_ELG_EDIT') + '</span>'
                    },
                    { "data": 'HealthUnitId', "visible" : false },
                    { "data": 'HealthUnit' },
                    { "data": 'HealthUnitType' },
                    { "data": 'Address' },
                    { "data": 'Phone' }
		]
                ,
            "createdRow": function(row, data, index) {
                row.id = 'row'+data.HealthUnitId;                
            }  
    } );

} );
function elgEditHealthUnit(src) {var id =  getIdFromTable(src); location.href='index.php?option=com_elgpedy&view=healthunitedit&Itemid=<?php echo $ItemId; ?>&id=' + id};
function elgRemoveHealthUnit(src){ 
	var id = src.parentNode.nextSibling.innerHTML; 
	jQuery('#healthUnitDelete').on('show.bs.modal', 
		function(e){
                    jQuery(this).find('.btn-danger').attr('href','index.php?option=com_elgpedy&controller=healthuniteditdelete&Itemid=<?php echo $ItemId; ?>&id=' + id)}
	);
	jQuery('#healthUnitDelete').modal('show');
}
</script>
<div class="modal fade" id="healthUnitDelete" tabindex="-1" role="dialog" aria-labelledby="<?php echo JText::_('COM_ELGPEDY_DELETE_HEALTH_UNIT'); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo JText::_('COM_ELGPEDY_DELETE_HEALTH_UNIT'); ?></h4>
            </div>
            <div class="modal-body">
                <h3><?php echo JText::_('COM_ELG_PEDY_UNIT_DELETE_QUESTION'); ?></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('COM_ELG_CANCEL'); ?></button>
                <a class="btn btn-danger" type="button" href="#"><?php echo JText::_('COM_ELG_DELETE'); ?></a>
        </div>
    </div>
  </div>
</div>


