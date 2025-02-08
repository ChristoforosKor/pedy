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
<div class="covid-attendancy" >
<section class="el covid-attendancy-section">
    <h2>Επισκεψιμότητα Covid-19</h2>
	<div class="col-md-12"><p style='color: red;'>Προσοχή! Για καταχώρηση σε νέα Ημερομηνία την επιλέγουμε στο φίλτρο και πατάμε Αναζήτηση πριν συνεχίσουμε.</p></div>
        <form role="form" id="covidAttendnacyFilters">
            
            <div class="row">
                <div class="col-md-4" >
                    <?php
                    echo $this->covidAttendancyForm->getLabel("id_health_unit"), $this->covidAttendancyForm->getInput("id_health_unit");
                    ?>
                </div>
                <div class="col-md-4" >
                    <?php
                    echo $this->covidAttendancyForm->getLabel("ref_date"), $this->covidAttendancyForm->getInput("ref_date");
                    ?>
                </div>        
                <div class=" buttons col-md-4">
                    <button class="btn btn-default" ><?php echo JText::_('COM_EL_SEARCH'); ?></button>
                    
                </div>                
            </div>
        </form>
        <form role="form" id="covidAttendancyHead" style="margin-top:2rem">
              <?php echo $this->covidAttendancyForm->getInput("id"); ?>
            <div class="row">
                
                <div class="col-md-8" >   
                    <h3>Καταχώρηση δυναμικού</h3>
                    <div class="col-md-4">
                        <?php
                        echo $this->covidAttendancyForm->getLabel("personnel_doctors"), $this->covidAttendancyForm->getInput("personnel_doctors");
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->covidAttendancyForm->getLabel("personnel_nurses"), $this->covidAttendancyForm->getInput("personnel_nurses");
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->covidAttendancyForm->getLabel("personnel_office"), $this->covidAttendancyForm->getInput("personnel_office");
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->covidAttendancyForm->getLabel("personnel_labs"), $this->covidAttendancyForm->getInput("personnel_labs");
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->covidAttendancyForm->getLabel("personnel_cleaning"), $this->covidAttendancyForm->getInput("personnel_cleaning");
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo $this->covidAttendancyForm->getLabel("personnel_guard"), $this->covidAttendancyForm->getInput("personnel_guard");
                        ?>
                    </div>
                </div>
                <div class="col-md-4 well" id="attendnacy_sums" style="visibility: hidden">
                   
                    
                         <h3>Σύνολα εξετασθέντων</h3>
                         <table class="table table-borders">
                             <thead>
                             <tr>
                                 <td></td>
                                 <th>Άνδρες</th>
                                 <th>Γυναίκες</th>
								 <th>Σύνολο</th>
                             </tr>
                             </thead>
                             <tbody>
                             <tr>
                                 <th class="text-left"  >Εξετασθέντες</th>
                                 <td id="total_men" class="text-right"></td>
                                 <td id="total_women" class="text-right"></td>
								 <td style="border:4px double Silver;" id="total_all" class="text-right"></td>
                             </tr>
                             <tr >
                                 <th class="text-left">Ύποπτα Περιστατικά</th>
                                 <td id="total_suspectmen" class="text-right"></td>
                                 <td id="total_suspectwomen" class="text-right"></td>
								 <td style="border:4px double Silver;" id="total_suspectall" class="text-right"></td>
                             </tr>
							
                             </tbody>
                         </table>                    
                    
                
            </div>
            </div>
            <div class="row">
                <div class="col-sm-12 " style="margin:1rem 0" >                    
                    <button class="btn btn-primary" id="btCovidHeadSubmit"><?php echo JText::_('COM_EL_SUBMIT'); ?></button>
                </div>    
            </div>
        </form>
</section>
<section class=" covidAttendancyDetails mt1" style="display:none">
    <div class="row">
         
        <div class="col-sm-12 text-right" style="margin:1rem 0" >
            <button class="btn btn-success " type="button" data-toggle="modal" data-target="#addCovidAttendancy"><?php echo JText::_('COM_EL_NEW'); ?></button>
        </div>    
            
        <div class="col-sm-12">
            
            <table class="covidAttendancyTable" ></table>
        </div>
    </div>
</section>
    </div>
<div class="el-busy main"></div>

<link href="media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css" />       
<link href="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>    


<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="Διαγραφή Εγγραφής" aria-hidden="true" id="covidAttendacyDetailDelete">
    <div class="modal-dialog">
        <form id="covidAtendnacyDeleteForm">
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
                
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
                <button class="btn btn-danger " >Διαγραφή</button>
               
            </div>
        </div>
         </form>
        <div class="el-busy"></div>
    </div>
</div>



<div class="modal fade"  tabindex="2" role="dialog" aria-labelledby="Επεξεργασία/Προσθήκη" aria-hidden="true" id="addCovidAttendancy">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" id="myModalLabel">Επεξεργασία/Προσθήκη</h4>
            </div>
            <form id="covidAttendancyDetailsForm" >
            <div class="modal-body">
                
                <?php echo $this->covidAttendancyForm->getInput("id_covidattendancy_details"); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("id_gender"), $this->covidAttendancyForm->getInput("id_gender"); ?>
                    </div>   
                    <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("age"), $this->covidAttendancyForm->getInput("age"); ?>
                    </div> 
                    <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("id_nationality"), $this->covidAttendancyForm->getInput("id_nationality"); ?>
                    </div>
                     <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("residence"), $this->covidAttendancyForm->getInput("residence"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("id_attendancy_medium"), $this->covidAttendancyForm->getInput("id_attendancy_medium"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("id_treatment"), $this->covidAttendancyForm->getInput("id_treatment"); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("id_action"), $this->covidAttendancyForm->getInput("id_action"); ?>
                    </div>
                     <div class="col-md-6">
                        <?php echo $this->covidAttendancyForm->getLabel("hospital_prompt"), $this->covidAttendancyForm->getInput("hospital_prompt"); ?>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delId" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Άκυρο</button>
                <button class="btn btn-danger storeAttendancyDetails"  >Αποθήκευση</button>
            </div>
             </form>
            <div class="el-busy"></div>
        </div>
    </div>
</div>

<script src="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.js" type="text/javascript"></script>
<script src="libraries/elogism/js/bower_components/bootstrap-table/dist/locale/bootstrap-table-el-GR.min.js" type="text/javascript"></script>
<script src="libraries/elogism/js/node_modules/moment/min/moment.min.js" type="text/javascript"></script>
<script src="libraries/elogism/js/elgsjs.js" type="text/javascript" ></script>
<script  type="module">
 
    import * as CovidAttendancyList from  '/media/com_elpedy/js/CovidAttendancyList.js'  ;
    CovidAttendancyList.init({
    tableSelector: '.covidAttendancyTable'
    , dataUrl: Joomla.getOptions('com_elpedy')['CovidAttendancyListData']
    , editUrl :  Joomla.getOptions('com_elpedy')['CovidAttendancyEdit'] 
    , delUrl: 'index.php?option=com_elpedy&view=CovidAttendancyDeleteData&format=json'
    , saveUrl:  Joomla.getOptions('com_elpedy')['CovidAttendancySaveData']
    , covidAttendancyDetails: document.querySelector('.covidAttendancyDetails')                                                                          
    , messageArea : document.querySelector('.yjsg-system-msg.inside-container')
    });
    window.delQuestion = CovidAttendancyList.delQuestion;     
    window.CovidAttendnacyList = CovidAttendancyList;

    document.addEventListener('DOMContentLoaded', function(e){
        
        document.getElementById('covidAttendancyHead').addEventListener('submit', function(e){
            e.preventDefault();
            CovidAttendancyList.headSubmit();
        });
        
        document.getElementById('covidAttendnacyFilters').addEventListener('submit', function(e){
            e.preventDefault();
            CovidAttendancyList.filtersSubmit();
        });
         
        document.getElementById('covidAttendancyDetailsForm').addEventListener('submit', function(e){
            e.preventDefault();
            CovidAttendancyList.detailsSubmit(e);
        });
       
       document.getElementById('covidAtendnacyDeleteForm').addEventListener('submit', function(e){
            e.preventDefault();
            CovidAttendancyList.delDetail(e);
       }); 
        
        jQuery( "#addCovidAttendancy" ).on('show.bs.modal', function(e){
             CovidAttendancyList.showDetails(e);
            //alert("I want this to appear after the modal has opened!");
        });
        
        
    });
</script>
