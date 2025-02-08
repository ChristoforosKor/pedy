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

<span style="color: red;font-size:1.1em;">Με την ολοκλήρωση της καταχώρησης μίας εξέτασης κλικάρετε στο μενού Εμβολιαστική Κάλυψη και ξαναπατάτε το κουμπί Νέο για να προχωρήσετε σε καινούρια.</span>


<style>
    .el.vaccines-edit .radio label {
        padding-left: 5px;
        padding-right: 20px;
    }
    .el.vaccines-edit .radio input[type="radio"] {
        position:static;
        display:inline;
        margin-left: 0;
        margin-bottom: 5px;
    }
</style> 
<link href="media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css"/>
<link href="libraries/elogism/js/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="libraries/elogism/js/bower_components/select2/dist/js/select2.full.min.js" type="application/javascript"></script>
<script src="libraries/elogism/js/node_modules/moment/min/moment.min.js" type="application/javascript"></script>
<div class="el vaccines-edit">
    <form method="post" action="<?php $this->VaccinesSaveUrl; ?>" id="vaccinesEdit">
        <?php echo $this->formPatient->getInput('vaccine_patient_id'); ?>
        <div class="row">
            <?php require JPATH_COMPONENT_SITE . '/layouts/partchronodatetimeinputs.php'; ?>
             
        </div>
        <div class="row">
            <div class="col-md-3">
                   <?php echo $this->formPatient->getLabel('school_level_id'), '<br />', $this->formPatient->getInput('school_level_id'); ?>
                <br />
                <?php echo $this->formPatient->getLabel('area_id'), '<br />', $this->formPatient->getInput('area_id'); ?>
            </div>
            <div class="col-md-3" >
                 <br />
                        <input checked="checked" type="radio" name="area_type" class="area_type" value="1" > <label> ΑΣΤΙΚΗ ΠΕΡΙΟΧΗ </label>
                    <div style="display:none">
                        <input type="radio" name="area_type" value="2" class="area_type" > <label> ΗΜΙ ΑΣΤΙΚΗ ΠΕΡΙΟΧΗ </label>
                    
                   
                        <input type="radio" name="area_type" value="3"  class="area_type" > <label> ΑΓΡΟΤΙΚΗ ΠΕΡΙΟΧΗ </label>
                    </div>
                  
                
            </div>
              <div class="col-md-3 " id="isMaleContainer">
                 <br />
                            <?php echo $this->formPatient->getInput('isMale'); ?>
                    </div>
        </div>
        <div class="row">
            <div  class="col-md-3"  id="school-container" >
                <?php echo $this->formPatient->getLabel('school_id'), '<br />', $this->formPatient->getInput('school_id'); ?>
            </div>   
            <div  class="col-md-3"  id="class-container"  >
                <?php echo $this->formPatient->getLabel('school_class_id'), '<br />', $this->formPatient->getInput('school_class_id'); ?>
            </div>
           
        </div>
        <div class="row">    
                        
                        
        </div>
        
        <div class="row">
            <div class="col-md-3" >
                    <?php echo $this->formPatient->getLabel('nationality_id'), '<br />', $this->formPatient->getInput('nationality_id'); ?>
             </div>
           
          
            <div class="col-md-3">
                <?php echo $this->formPatient->getLabel('birthday'),  $this->formPatient->getInput('birthday'); ?>
            </div>             
        </div>
                          
        <div class="row" >
            
            <div class="col-md-3" >
                <?php echo $this->formPatient->getLabel('father_profession'), '<br />', $this->formPatient->getInput('father_profession'); ?>
            </div>
            <div class="col-md-3" >
                <?php echo $this->formPatient->getLabel('mother_profession'), '<br />', $this->formPatient->getInput('mother_profession'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <table class="table table-striped table-hover table-bordered" id="vaccines_edit_table">
                    <thead>
                        <tr>
                            <td></td>
                            <?php foreach ($this->vaccinesSteps as $step): ?>
                                <th><?php echo $step; ?></th>
                            <?php
                            endforeach;
                            unset($step)
                            ?>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6"><button class="btn btn-primary">Καταχώριση</button></td>
                        </tr>
                    </tfoot>
                    <tbody>
<?php forEach ($this->vaccines as $idVaccine => $vaccine): ?>
                            <tr>
                                <th><?php echo $vaccine; ?></th>
                                <?php
                                foreach ($this->vaccinesSteps as $idStep => $step):
                                    $key = $idVaccine . '-' . $idStep;
                                    if (isset($this->vaccinesStepsRel[$idVaccine][$idStep])): // vacine step rel
                                        ?>
                                        <td><input type="checkbox" name="v[]" id="v<?php echo $this->vaccinesStepsRel[$idVaccine][$idStep]; ?>" value="<?php echo $this->vaccinesStepsRel[$idVaccine][$idStep]; ?>"  /></td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php
                                    endif;
                                endforeach;
                                unset($step);
                                unset($idStep);
                                ?>
                            </tr>
                            <?php
                        endforeach;
                        unset($vaccine);
                        unset($idVaccine)
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </form>
</div>
<script type="application/javascript" src="libraries/elogism/js/elgsjs.js"></script>
<script  type="module">
    import * as VaccinesEdit from '/media/com_elpedy/js/VaccinesEdit.js';
    VaccinesEdit.init({
    dataUrl: Joomla.getOptions('com_elpedy')['VaccinesEditData']
    , saveUrl :  Joomla.getOptions('com_elpedy')['VaccinesSaveData'] 
    ,id: <?php echo $this->VaccinePatientId; ?>
    });

</script>
<div class="vaccines-edit el-busy"></div>