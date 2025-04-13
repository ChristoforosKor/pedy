<?php
/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # @author    E-Logism
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
?>
<link href="media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css" />    
<style>
    .calendar-form-control {
        width: 70%;
    }
    div.buttons {
        padding-top: 3rem;
    }
</style>
<div class="el prolepsis-list">
    <div class="msg"></div>
    <div id="prolepsisListToolbar">
        <div class="row" role="form">
            <div class="col-md-3">
                <?php echo $this->commonForm->renderField('HealthUnitId'); ?>
            </div>
            <div class="col-md-3">
                <?php echo $this->commonForm->renderField('exam_center_id'); ?>
            </div>
            <div class="col-md-3">
                <?php echo $this->commonForm->renderField('RefDateFrom'); ?>	
            </div>
            <div class="col-md-3">
                <?php echo $this->commonForm->renderField('RefDateTo'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 buttons">
                <button class="btn btn-primary" id="btProlepsisListSearch"><?php echo Text::_('COM_EL_SEARCH'); ?></button>
                <a class="btn btn-success" href="<?php echo $this->prolepsisEditUrl; ?>"><?php echo JText::_('COM_EL_NEW'); ?></a>
            </div>
        </div>
    </div>
    <table class="prolepsis-table" ></table>
       
    <link href="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>    
    <script src="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.js" type="text/javascript"></script>
    <script src="libraries/elogism/js/bower_components/bootstrap-table/dist/locale/bootstrap-table-el-GR.min.js" type="text/javascript"></script>
    <script src="libraries/elogism/js/node_modules/moment/min/moment.min.js" type="text/javascript"></script>
    <script src="libraries/elogism/js/elgsjs.js" type="text/javascript" ></script>
    <script  type="module">
        import * as ProlepsisList from  '/media/com_elpedy/js/ProlepsisList.js';
        ProlepsisList.init({
            tableSelector: '.prolepsis-table'
            , dataUrl: Joomla.getOptions('com_elpedy')['ProlepsisListData']
            , editUrl: Joomla.getOptions('com_elpedy')['ProlepsisEdit']
            , delUrl: Joomla.getOptions('com_elpedy')['ProlepsisDeleteData']
            , messageArea: document.querySelector('.prolepsis-list .msg')
        });
        window.delQuestion = ProlepsisList.delQuestion;
        window.ProlepsisList = ProlepsisList;
    </script>
</div>

<div class="modal fade" id="prolepsisDelete" tabindex="-1" role="dialog" aria-labelledby="<?php echo $this->deleteTitle; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->deleteTitle; ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->deletePrologue; ?></p>
                <p class="text-info"></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Text::_('JCANCEL'); ?></button>
                <button class="btn btn-danger" type="button"  onclick="window.ProlepsisList.delRec();"><?php echo Text::_('JACTION_DELETE'); ?></button>
            </div>
        </div>
    </div>
</div>