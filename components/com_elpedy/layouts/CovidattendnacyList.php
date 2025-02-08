<?php
/*------------------------------------------------------------------------
# com_elergon - e-logism
# ------------------------------------------------------------------------
# @author    E-Logism
# @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
# Website: http://www.e-logism.gr
----------------------------------**/
defined('_JEXEC') or die('Restricted access');
?>
<div class="el vaccines-list">
   
         <div id="vaccinesListToolbar">
            <div class="form-inline" role="form">
           <?php require_once JPATH_COMPONENT_SITE . '/layouts/partchronodatetimerange.php'; ?>
                <div class="form-group buttons">
            <button class="btn btn-primary" id="btVaccListSearch"><?php echo JText::_('COM_EL_SEARCH'); ?></button>
            <a class="btn btn-success " href="<?php echo  $this -> VaccineEditUrl ; ?>"><?php echo JText::_('COM_EL_NEW'); ?></a>
                </div>
                </div>
        </div>
    <table class="vaccines-table" ></table>
    <link href="media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css" />       
    <link href="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>    
    <script src="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.js" type="text/javascript"></script>
    <script src="libraries/elogism/js/bower_components/bootstrap-table/dist/locale/bootstrap-table-el-GR.min.js" type="text/javascript"></script>
    <script src="libraries/elogism/js/node_modules/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="libraries/elogism/js/elgsjs.js" type="text/javascript" ></script>
    <script  type="module">
        import * as VaccinesList from  '/media/com_elpedy/js/VaccinesList.js'  ;
        VaccinesList.init({
            tableSelector: '.vaccines-table'
           , dataUrl: Joomla.getOptions('com_elpedy')['VaccinesListData']
            , editUrl :  Joomla.getOptions('com_elpedy')['VaccinesEdit'] 
            , delUrl: 'index.php?option=com_elpedy&view=VaccinesDeleteData&format=json'
            , messageArea : document.querySelector('.yjsg-system-msg.inside-container')
        });
       window.delQuestion = VaccinesList.delQuestion;     
       window.VaccinesList = VaccinesList;
    </script>
</div>

<div class="modal fade" id="vaccinesDelete" tabindex="-1" role="dialog" aria-labelledby="Διαγραφή Εμβολιασμού" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
            <h4 class="modal-title" id="myModalLabel">Διαγραφή εμβολιασμού</h4>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουροι για την διαγραφή </p>
                <p class="text-info"></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
                <button class="btn btn-danger" type="button"  onclick="window.VaccinesList.delRec();">Διαγραφή</button>
        </div>
    </div>
  </div>
</div>