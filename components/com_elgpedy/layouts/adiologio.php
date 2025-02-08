<?php
/* ------------------------------------------------------------------------
  # com_ElgComponent e-logism
  # ------------------------------------------------------------------------
  # author    e-logism
  # copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
  # @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  # Website: http://www.e-logism.gr
  ----------------------------------* */
defined('_JEXEC') or die('Restricted access');
?>


<section id="elgdata" <?php echo ($this->healthUnitId > 0 && $this->refDate > 0  ? '': 'style="display:none"'); ?> >    

    <form method="post"  id="adiologioForm" action="index.php?option=com_elgpedy&controller=adiologiodataeditsave&model=adiologiodataeditsave&Itemid=156" onsubmit="return formSubmitAdiologio()" >
        <?php echo $this->adiologio->getInput('PersonelAttendanceBookRafinaId'); ?> 	
        <h3>1. ΕΠΙΛΟΓΗ ΕΡΓΑΖΟΜΕΝΟΥ</h3>
        <fieldset name="personnel">
            <div class="row">    
                <div  class="col-md-4"  id="personnel-container" >
                    <?php 
                        if($this->healthUnitId > 0 ): 
                            echo $this->adiologio->getLabel('PersonelId'), '<br />', $this->adiologio->getInput('PersonelId'); 
                        endif;
                    ?>
                </div>   
            </div>
        </fieldset>
        <h3>2. ΕΠΙΛΟΓΗ ΑΔΕΙΑΣ</h3>
        <fieldset name="leave">
            <div class="row"> 
                <div  class="col-md-4"  id="leavegroup-container" >
                    <?php echo $this->adiologio->getLabel('PersonelStatusGroupId'), '<br />', $this->adiologio->getInput('PersonelStatusGroupId'); ?> 		
                </div>  		
                <div  class="col-md-4"  id="leave-container" >
                    <?php echo $this->adiologio->getLabel('PersonelStatusId'), '<br />', $this->adiologio->getInput('PersonelStatusId'); ?> 		
                </div>   
            </div>
        </fieldset>
        <h3>3. ΗΜΕΡΟΜΗΝΙΑ ΑΔΕΙΑΣ</h3>
        <p class="text-danger" ><font size='2'>"<?php echo JText::_('COM_ELGPEDY_SUBMIT_ADIOLOGIO_WARNING'); ?>"</font></p>
        <fieldset name="adeiologiocalendar">
            <div class="row">    
                <div  class="col-md-4"  id="leave-begin" class="input-group date form_datetime" >
                    <?php echo $this->adiologio->getLabel('StartDate'), '<br />', $this->adiologio->getInput('StartDate'); ?>
                </div>

                <div  class="col-md-4"  id="leave-ends"  >
                    <?php echo $this->adiologio->getLabel('EndDate'), '<br />', $this->adiologio->getInput('EndDate'); ?>
                </div>
                <div class="clearfix"></div>
                <div  class="col-md-4"  id="year" >
                    <?php echo $this->adiologio->getLabel('Year'), '<br />', $this->adiologio->getInput('Year'); ?>
                </div>  
                
                <div  class="col-md-4"  id="days"  >
                    <?php echo $this->adiologio->getLabel('Duration'), '<br />', $this->adiologio->getInput('Duration'); ?>
                </div>
            </div>
        </fieldset>
        <h3>4. ΠΑΡΑΤΗΡΗΣΕΙΣ</h3>
        <fieldset name="paratiriseis">
            <div class="row">
                <div class="col-md-8">
                    <?php echo $this->adiologio->getLabel('Details'), '<br />', $this->adiologio->getInput('Details'); ?>
                </div>
            </div>
        </fieldset>
        <br>
        <div>
            <button class="btn-primary"><?php echo JText::_('COM_ELG_SUBMIT'); ?></button>
        </div>
    </form>
</section>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function (ev) {
        var pSE = document.getElementById('PersonelStatusId');
        var pSGE = document.getElementById('PersonelStatusGroupId');
        var personelStatus = {};
<?php foreach ($this->personelStatus as $key => $group): ?>
            personelStatus[<?php echo $key; ?>] = '<?php echo $group; ?>';
    <?php
endforeach;
unset($group);
unset($key);
?>
        pSE.innerHTML = personelStatus[pSGE.value];
        pSGE.addEventListener('change', function (ev) {
            pSE.innerHTML = '';
            pSE.innerHTML = personelStatus[ev.currentTarget.value];
        });
    });


    function formSubmitAdiologio() {
        var msgf = '';
        var d1 = moment(document.getElementById('StartDate').value, 'DD/MM/YYYY');
        if (!d1.isValid()) {
            msgf += ' Lathos Dedomena imerominia enarxis\n';
        }
        var d2 = moment(document.getElementById('EndDate').value, 'DD/MM/YYYY');
        if (!d2.isValid()) {
            msgf += ' Lathos Dedomena imerominia lixi\n';
        }
        if (msgf !== '') {
            alert('Problima Imeominion\n' + msgf);
            return false;
        }
        else {
            return true;
        }
    }
    ;
</script>

