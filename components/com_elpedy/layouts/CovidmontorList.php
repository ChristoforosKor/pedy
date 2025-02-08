<?php
/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # @author    E-Logism
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
?>
<section class="el covid-monitor-section container">
    <h2>Επιτήρηση Covid-19</h2>
    <div id="CovidMonitorListToolbar">
        <?php echo $this->covidMonitorForm->getInput("idCovidMonitorHead"); ?>
        <form role="form" id="covidMontorFilters">

            <div class="row">
                <div class="col-md-4" >
                    <?php
                    echo $this->covidMonitorForm->getLabel("id_health_unit"), $this->covidMonitorForm->getInput("id_health_unit");
                    ?>
                </div>
                <div class="col-md-4" >
                    <?php
                    echo $this->covidMonitorForm->getLabel("ref_date"), $this->covidMonitorForm->getInput("ref_date");
                    ?>
                </div>        
                <div class=" buttons col-md-4">
                    <button class="btn btn-primary" id="btVaccListSearch"><?php echo JText::_('COM_EL_SEARCH'); ?></button>
                    
                </div>                
            </div>
        </form>
        <form role="form" id="covidMonitorHead">
            <div class="row">
                <h3>
                    <div class="col-md-2">
                        <?php
                        echo $this->covidMonitorForm->getLabel("personnel_doctors"), $this->covidMonitorForm->getInput("personnel_doctors");
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $this->covidMonitorForm->getLabel("personnel_nurses"), $this->covidMonitorForm->getInput("personnel_nurses");
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $this->covidMonitorForm->getLabel("personnel_office"), $this->covidMonitorForm->getInput("personnel_office");
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $this->covidMonitorForm->getLabel("personnel_labs"), $this->covidMonitorForm->getInput("personnel_labs");
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $this->covidMonitorForm->getLabel("personnel_cleaning"), $this->covidMonitorForm->getInput("personnel_cleaning");
                        ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        echo $this->covidMonitorForm->getLabel("personnel_guard"), $this->covidMonitorForm->getInput("personnel_guard");
                        ?>
                    </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <!-- button class="btn btn-success " type="button" data-toggle="modal" data-target="#addCovidMonitor"><?php echo JText::_('COM_EL_NEW'); ?></button -->
                    <button class="btn btn-primary" id="btCovidHeadSubmit"><?php echo JText::_('COM_EL_SUBMIT'); ?></button>
                </div>    
            </div>
        </form>
</section>
<section class="section">
    <div class="row">
        <div class="col-sm-12">
            <table class="covidMonitorTable" ></table>
        </div>
    </div>
</section>
<link href="media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css" />       
<link href="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>    
<script src="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.js" type="text/javascript"></script>
<script src="libraries/elogism/js/bower_components/bootstrap-table/dist/locale/bootstrap-table-el-GR.min.js" type="text/javascript"></script>
<script src="libraries/elogism/js/node_modules/moment/min/moment.min.js" type="text/javascript"></script>
<script src="libraries/elogism/js/elgsjs.js" type="text/javascript" ></script>
<script  type="module">
    import * as CovidMonitorList from  '/media/com_elpedy/js/CovidMonitorList.js'  ;
    CovidMonitorList.init({
    tableSelector: '#covidMonitorTable'
    , dataUrl: Joomla.getOptions('com_elpedy')['CovidMonitorListData']
    , editUrl :  Joomla.getOptions('com_elpedy')['CovidMonitorEdit'] 
    , delUrl: 'index.php?option=com_elpedy&view=CovidMonitorDeleteData&format=json'
    , saveUrl:  Joomla.getOptions('com_elpedy')['CovidMonitorSaveData']
                                                                              
    , messageArea : document.querySelector('.yjsg-system-msg.inside-container')
    });
    window.delQuestion = CovidMonitorList.delQuestion;     
    window.CovidMontorList = CovidMonitorList;
    document.addEventListener('DOMContentLoaded', function(e){
        
        document.getElementById('covidMonitorHead').addEventListener('submit', function(e){
            e.preventDefault();
            CovidMonitorList.headSubmit();
        });
        
        document.getElementById('covidMonitorFilters').addEventListener('submit', function(e){
            e.preventDefault();
            CovidMonitorList.filtersSubmit();
        });
        
        document.getElementById('covidMonitorDetail').addEventListener('submit', function(e){
            e.preventDefault();
            CovidMonitorList.detailsSubmit();
        });
        
    });
</script>


<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="Διαγραφή Εγγραφής" aria-hidden="true" id="covidMonitorDetailDeleteForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" id="myModalLabel">Διαγραφή εγγραφής</h4>
            </div>
            <div class="modal-body">
                <p>Είστε σίγουροι για την διαγραφή: </p>
                <p class="text-info"></p>
            </div>
            <div class="modal-footer">
                <form id="covidMontorDelete">
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
                <button class="btn btn-danger" type="button"  onclick="window.CovidMonitorList.delDetail();">Διαγραφή</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade"  tabindex="2" role="dialog" aria-labelledby="Προσθήκη" aria-hidden="true" id="addCovidMonitorDetailsForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" id="myModalLabel">Προσθήκη</h4>
            </div>
            <div class="modal-body">
                <form id="covidMonitorDetail" >
                <?php echo $this->covidMonitorForm->getInput("idCovidMonitorDet"); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_gender"), $this->covidMonitorForm->getInput("id_gender"); ?>
                    </div>   
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("age"), $this->covidMonitorForm->getInput("age"); ?>
                    </div> 
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("nationality"), $this->covidMonitorForm->getInput("nationality"); ?>
                    </div>
                     <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("residence"), $this->covidMonitorForm->getInput("residence"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_monitor_medium"), $this->covidMonitorForm->getInput("id_monitor_medium"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_treatment"), $this->covidMonitorForm->getInput("id_treatment"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_action"), $this->covidMonitorForm->getInput("id_action"); ?>
                    </div>
                     <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("hospital_prompt"), $this->covidMonitorForm->getInput("hospital_prompt"); ?>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
                <button class="btn btn-danger" type="button"  onclick="window.CovidMonitorList.storeDetails();">Αποθήκευση</button>
            </div>
        </div>
    </div>
</div>

<?php /*
<div class="modal fade"  tabindex="2" role="dialog" aria-labelledby="Προσθήκη" aria-hidden="true" id="addCovidMonitorHeadForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" id="myModalLabel">Προσθήκη</h4>
            </div>
            <div class="modal-body">
                <form id="covidMonitorDetail" >
                <?php echo $this->covidMonitorForm->getInput("idCovidMonitorDet"); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_gender"), $this->covidMonitorForm->getInput("id_gender"); ?>
                    </div>   
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("age"), $this->covidMonitorForm->getInput("age"); ?>
                    </div> 
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("nationality"), $this->covidMonitorForm->getInput("nationality"); ?>
                    </div>
                     <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("residence"), $this->covidMonitorForm->getInput("residence"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_monitor_medium"), $this->covidMonitorForm->getInput("id_monitor_medium"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_treatment"), $this->covidMonitorForm->getInput("id_treatment"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("id_action"), $this->covidMonitorForm->getInput("id_action"); ?>
                    </div>
                     <div class="col-md-6">
                        <?php echo $this->covidMonitorForm->getLabel("hospital_prompt"), $this->covidMonitorForm->getInput("hospital_prompt"); ?>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
                <button class="btn btn-danger" type="button"  onclick="window.CovidMonitorList.storeDetails();">Αποθήκευση</button>
            </div>
        </div>
    </div>
</div>
*/ ?>

</section>