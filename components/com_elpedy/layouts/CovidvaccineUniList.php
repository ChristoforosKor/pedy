<?php
/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # @author    E-Logism
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;


?>
<style>
    .table-bordered > tbody > tr > td.sum-data-1st {
        border-left:#000 double thick;
    } 
    
   tbody tr.subhead1 th, tbody tr.subhead2 th {
         text-align:center!important;
        color:white;
        border-width: 3px;
        border-style: solid;
        border-left-width:1px;
    }
    tr.subhead1 th {
        background-color: #00539b!important;
       
    }
   
    
    
    tr.subhead2 th {
        background-color: #007bc2!important;
       
    }
    
    tbody tr.subhead1 th {
        border-color: #00539b
    }
    
    tbody tr.subhead2 th {
        border-color: #007bc2
    }
	
   
</style>
<div class="covid-vaccine" >
    <section class="el covid-Vaccine-section section" style="margin-bottom: 3rem" >
        <h2>Εμβολιασμός Φοιτητών / Μελών ΔΕΠ Covid-19</h2>
        <div id="CovidVaccineListToolbar">
            <?php echo $this->covidVaccineForm->getInput("idCovidVaccineHead"); ?>
            <form role="form" id="covidVaccineFilters">

                <div class="row">
                    <div class="col-md-3" >
                        <?php
                        echo $this->covidVaccineForm->getLabel("id_health_unit"), $this->covidVaccineForm->getInput("id_health_unit");
                        ?>
                    </div>
                    
			<div class="col-md-3" style="display:none"  >
                        <?php
                        echo $this->covidVaccineForm->getLabel("MunicipalitySectorId"), $this->covidVaccineForm->getInput("MunicipalitySectorId");
                        ?>
                    </div>

                    <div class="col-md-3" >
                        <?php
                        echo $this->covidVaccineForm->getLabel("ref_date"), $this->covidVaccineForm->getInput("ref_date");
                        ?>
                    </div>        
                    <div class=" buttons col-md-3">
                        <button class="btn btn-default" ><?php echo JText::_('COM_EL_SEARCH'); ?></button>                    
                    </div>                
                </div>
            </form>


    </section>
    <link href="/media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css" />       
    <link href="/media/com_elgpedy/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
    <link href="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>    
    
    
    
    <section class="section covidVaccineDetails " style="display:block" >
        <?php  
        
        require_once __DIR__ . '/CovidvaccineUniListSectionType2.php'; ?>
    </section>
</div>
<div class="el-busy main"></div>







<div class="modal fade"  tabindex="2" role="dialog" aria-labelledby="Προσθήκη" aria-hidden="true" id="modalValidate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
                <h4 class="modal-title" id="myModalLabel">Προσοχή</h4>
            </div>
            <div class="modal-body">              
                <p class="text-warning"></p>
            </div>
            <div class="modal-footer">
           
            </div>

           
        </div>
    </div>
</div>



<script type="text/javascript"src="/media/com_elgpedy/js/bootstrap-editable.min.js"></script>

<!-- script src="libraries/elogism/js/bower_components/bootstrap-table/dist/bootstrap-table.min.js" type="text/javascript"></script -->
<!-- script src="libraries/elogism/js/bower_components/bootstrap-table/dist/locale/bootstrap-table-el-GR.min.js" type="text/javascript"></script -->
<script src="libraries/elogism/js/node_modules/moment/min/moment.min.js" type="text/javascript"></script>

<script src="libraries/elogism/js/elgsjs.js" type="text/javascript" ></script>

<script  type="module">
    
    import * as CovidVaccineList from  '/media/com_elpedy/js/CovidVaccineUniList.js?ver=2'  ;
    CovidVaccineList.init({
    tableSelector: '.covidVaccineTable'
    , dataUrl: Joomla.getOptions('com_elpedy')['CovidVaccineUniListData']
    , editUrl :  Joomla.getOptions('com_elpedy')['CovidVaccineUniEdit'] 
    , delUrl: Joomla.getOptions('com_elpedy')['CovidVaccineDeleteUniData']  //'index.php?option=com_elpedy&view=CovidVaccineDeleteData&format=json'
    , saveUrl:  Joomla.getOptions('com_elpedy')['CovidVaccineUniSaveData']
    , covidVaccineDetails: document.querySelector('.covidVaccineUniDetails')                                                                          
    , messageArea : document.querySelector('.yjsg-system-msg.inside-container')
    , vaccinesAttributes: '<?php echo json_encode($this->vaccinesAttributes); ?>'
    });
    window.delQuestion = CovidVaccineList.delQuestion;     
    window.CovidVaccineList = CovidVaccineList;
    document.addEventListener('DOMContentLoaded', function(e){
  
        document.getElementById('covidVaccineFilters').addEventListener('submit', function(e){
            e.preventDefault();
            CovidVaccineList.filtersSubmit();
        }); 

//        document.getElementById('covidVaccineDetailsForm').addEventListener('submit', function(e){
//            e.preventDefault();
//            CovidVaccineList.detailsSubmit(e);
//        });


//        CovidVaccineList.showDetails(e);
    //alert("I want this to appear after the modal has opened!");
    });

</script>


<!-- script type="text/javascript"src="/libraries/elogism/js/bootstrap-table-editable.min.js"></script >
<!-- script type="text/javascript"src="/libraries/elogism/js/extension.json"></script -->
