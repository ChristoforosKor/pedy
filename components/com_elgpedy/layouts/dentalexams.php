<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript" src="media/com_elgpedy/js/bootstrap-table.js"></script>
<script type="text/javascript" src="media/com_elgpedy/js/select2.js"></script>
<section id="elgdata"  >
   
    <div class="clearfix"></div>
    <div class="dental-tools">
        <a href="<?php echo JRoute::_('index.php?option=com_elgpedy&view=dentalexamedit&Itemid=151');?>" class="btn btn-primary" ><?php echo JText::_('COM_ELG_ADD'); ?></a>
    </div>
    <table id="exTable" class="exTable"></table>
    <div class="dental-tools">
        <a href="<?php echo JRoute::_('index.php?option=com_elgpedy&view=dentalexamedit&Itemid=151');?>" class="btn btn-primary" ><?php echo JText::_('COM_ELG_ADD'); ?></a>
    </div>
    <div class="clearfix"></div>
    

</section>
<script type="text/javascript" >
   
    function makeExamsTable(examsData) {
        function dateFormater(value) {
            return moment(value).format('DD/MM/YYYY');
        }
        jQuery('#exTable').bootstrapTable({
                 data: examsData,
               
//                responseHandler: 
                idField: 'dental_transaction_id',
                height: 800,
                send: 'never',
                pagination: true,
                pageSize:50,
                classes: 'table table-hover', 
                columns: [
                   {
                       field: 'dental_transaction_id',
                       title: '#',
                       sortable: false,
                       formatter: function(value, row, index){
                            return index + 1;
                       }
                      
                   },     
                      
                   {
                       field: 'exam_date',
                       title: Joomla.JText._('COM_ELG_PEDY_DATE'),
                       align: 'left',
                       sortable: true,
                       formatter: dateFormater
                   },                    
                   {
                       field: 'school_level',
                       title: Joomla.JText._('COM_ELG_PEDY_SCHOOL_LEVEL'),
                       align: 'left',
                       sortable: true
                   },  
                   {
                       field: 'description',
                       title: Joomla.JText._('COM_ELG_PEDY_SCHOOL'),
                       align: 'left',
                       sortable: true
                   },
                   {
                       field: 'country',
                       title: Joomla.JText._('COM_ELG_PEDY_NATIONALITY'),
                       align: 'left',
                       sortable: true
                   },
                   {
                       field: 'birthday',
                       title: Joomla.JText._('COM_ELG_PEDY_BIRTHDAY'),
                       align: 'left',
                       sortable: true,
                       formatter:dateFormater
                   },
                   {
                       field: 'isMale',
                       title: Joomla.JText._('COM_ELG_PEDY_IS_MALE') ,
                       align: 'left',
                       
                       sortable: true,
                       formatter: function(value, row, index) { 
                          return (value==1 ? '<span class="fa fa-check" >': '') ;
                       }
 
                   },
                    {
                       field: 'father_profession',
                       title: Joomla.JText._('COM_ELG_PEDY_FATHER_PROFESSION'),
                       align: 'left',
                       sortable: true
                   },
                   {
                       field: 'mother_profession',
                       
                       title: Joomla.JText._('COM_ELG_PEDY_MOTHER_PROFESSION'),
                       align: 'left',
                       sortable: true
                   },
                    {   
                       field: 'dental_transaction_id',
                       title: '',
                       align: 'left',
                        sortable: false,
                       formatter: function(value, row, index) { 
                          return '<a href="<?php echo $this->editUrl; ?>&id=' + value +'" class="yjsg-button-blue">' + Joomla.JText._('COM_ELG_EDIT') + '</a>\n\
                                  <button class="yjsg-button-red" type="button" onclick="confirmDelete(' + index + ',' + value + ')" >' + Joomla.JText._('COM_ELG_DELETE') + '</button>' ;
                       }
 
                   }
                   
                ]      
                });
        }
    
        function getExamsData() {
            showAsBusy();
            var hu = document.getElementById('HealthUnitId');
            var refDate = document.getElementById('RefDate');
            jQuery.get( location.href + '&format=json&HealthUnitId=' + hu.value  +'&RefDate=' + moment(refDate.value, 'D-M-YYYY').format('YYYYMMDD')
            , function( data ) {
                makeExamsTable(data.data);
            showDataArea();
        });
    }    
    getExamsData();
    var delId = '';
    function confirmDelete(index, value){
        delId = value;
        jQuery('.modal .modal-body').text('Είστε σίγουροι για τη διαγραφή τηε γραμμής ' +  (index + 1) + ';');
        jQuery('table tbody tr:nth-child(2)')
        jQuery('#myModal').modal({show: true});
    }
    
    function deleteRow() {
        var d = delId;
        delId = '';
        location.href= '<?php echo JRoute::_('index.php?option=com_elgpedy&controller=dentalexamdelete&Itemid=151', false); ?>&id=' + d;
    }
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
        <h4 class="modal-title" id="myModalLabel">Επιβεβαίωση διαγραφής</h4>
      </div>
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('JNO'); ?></button>
        <button type="button" class="btn btn-primary" onclick="deleteRow()" ><?php echo JText::_('JYES'); ?></button>
      </div>
    </div>
  </div>
</div>