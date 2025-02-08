<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');  
use Joomla\CMS\Factory;
use Joomla\CMS\Document\Document;
//$personels = $this->state->get('data')->personels;
$ItemId = $this->state->get('Itemid'); 
 $commonForm = JForm::getInstance('datacommon', ComponentUtils::getDefaultFormPath() . '/datacommon.xml');
 $document = Factory::getDocument();
 $document  -> addStylesheet('/media/com_elgpedy/css/bootstrap-datetimepicker.min.css'); 
  $document -> addStyleDeclaration(' .personels-table  tbody td:nth-child(1) span { cursor:pointer}');
 ?>
<script type="text/javascript">
    var elgPeronelsOptions = {elgItemid: <?php echo $this -> escape( $ItemId ); ?>};
</script>
<script type="text/javascript" src="media/com_elgpedy/js/personels.js"></script>
<script type="text/javascript" src="media/node_modules/bootstrap-table/dist/bootstrap-table.min.js"></script>
<script type="text/javascript" src="media/node_modules/bootstrap-table/dist/locale/bootstrap-table-el-GR.min.js"></script>
 <h2><?php echo JFactory::getApplication()->getMenu()->getActive()->title;?></h2>
<div class="elg personels">
	<!-- table id="personnels" class="table striped table-hover" cellspacing="0" width="100%" -->
        <table 
            class="personels-table table"
            data-toggle="table"
            data-side-pagination="server"
            data-pagination="true"
            data-page-size="50"
            data-smart-display="true"
            data-search="true"
            data-search-on-enter-key="true"
            data-silent-sort="false"
            data-locale="el-GR"
            data-striped="true"
                      data-url="<?php echo JRoute::_('index.php?option=com_elgpedy&view=personels&format=json&Itemid=' . $ItemId, false); ?>" >
		<thead class="thead-inverse">
                    <tr class="hidden-print" >
                        <th colspan="8" class="hidden-print" >
                            <a class="pull-right btn btn-primary" href="index.php?option=com_elgpedy&view=personeledit&Itemid=<?php echo $ItemId; ?>" ><?php echo JText::_('COM_ELG_ADD'); ?></a>
                        </th>
                    </tr>
			<tr>
                                <th data-field="PersonelId" data-formatter="personels.frmAction"></th>
				<th data-field="amka" data-sortable="false"  ><?php echo JText::_('COM_ELGPEDY_AMKA'); ?></th>
                                <th data-field="trn" data-sortable="false"  ><?php echo JText::_('COM_ELGPEDY_TRN'); ?></th>
				<th data-field="HealthUnit" data-sortable="true"   ><?php echo JText::_('COM_ELG_PEDY_UNIT'); ?></th>
				<th data-field="LastName" data-sortable="true"    ><?php echo JText::_('COM_ELGPEDY_LASTNAME'); ?></th>
				<th data-field="FirstName" data-sortable="true"   ><?php echo JText::_('COM_ELGPEDY_FIRSTNAME'); ?></th>
				<th data-field="FatherName" data-sortable="false"    ><?php echo JText::_('COM_ELGPEDY_FATHERNAME'); ?></th>
				<th data-field="PersonelSpeciality" data-sortable="true"   ><?php echo JText::_('COM_ELGPEDY_SPECIALITY'); ?></th>
			</tr>
			
		</thead>
		
	</table>
</div>
 <script type="text/javascript" src="/media/com_elgpedy/js/moment.min.js"></script>
 <script type="text/javascript" src="/media/com_elgpedy/js/bootstrap-datetimepicker.min.js" ></script>
 <script type="text/javascript" src="/media/com_elgpedy/js/locales/bootstrap-datetimepicker.el.js" ></script>

<div class="modal fade" id="personelDelete" tabindex="-1" role="dialog" aria-labelledby="<?php echo JText::_('COM_ELGPEDY_DELETE_PERSONEL'); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo JText::_('COM_ELGPEDY_DELETE_PERSONEL'); ?></h4>
            </div>
            <div class="modal-body">
                <h3><?php echo JText::_('COM_ELG_PEDY_PERSONEL_DELETE_QUESTION'); ?></h3>
                <p class="text-info"></p>
                <div class="row" >
                   <form class="col-sm-12">
                     <div class="form-group">	
                         <label for="RefDate" >Ημερομηνία Λήξης Υπηρεσίας</label>
                   <div class="input-group date form_datetime"  >
                        
                        <input id="RefDate" name="RefDate" class="form-control" type="text" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                   </div>
                         
               </div>
                       </form>
            </div>
            </div>
           
            <div class="modal-footer">
                 
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('COM_ELG_CANCEL'); ?></button>
                <a class="btn btn-danger" type="button" href="#"  id="deleteRecordTrigger" ><?php echo JText::_('COM_ELG_DELETE'); ?></a>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
     var unitsUrls = {};
     
    
    jQuery(document).ready(function(){
        jQuery('.form_datetime').datetimepicker({
                format: "dd/mm/yyyy",
                startView: 2,
                minView: 2,
                autoclose: true,
                todayHighlight: true,
                language: 'el',
                forceParse: false,
                endDate: new Date(),
                defaultDate: moment(). format('DD/MM/YYYY')
            })
            .on('hide',function(){var a = $(this);setTimeout(function(){a.show();},2);})
                  
             document.querySelector('#deleteRecordTrigger').addEventListener('click', pdDeleteRecord)     
              
    });   
    
    
    function pdDeleteRecord(e){
        e.preventDefault();
        var rd = moment(document.getElementById('RefDate').value, 'DD/MM/YYYY');
        if ( rd.isValid()) {
            document.location = e.target.getAttribute('href') +'&rd='+ rd.format('YYYYMMDD') ;
        }
        else {
            alert('Μη έγκυρη ημερομηνία διαγραφής');
        }
    }
</script>