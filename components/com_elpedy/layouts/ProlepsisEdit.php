<?php

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
?>
<style>
    .row {
        margin-bottom:2rem;
    }
    h3, h4 {
        margin-top: 4rem;
    }
  
    .tm-7 {
        margin-top: 7rem;
    }
</style>

<link href="/media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css"/>
<div class="el prolepsis-edit section">
    <h2><?php echo Text::_("COM_EL_PEDY_PROGRAM"); ?></h2>
    <div class="msg-area"></div>
    <form method="post" action="" id="prolepsisHPV3065">
             <?php echo $this->formProlepsis->renderField('id'); ?>
            <legend><?php echo Text::_("COM_EL_PEDY_HPV_3065") ?></legend>
            <div class="row">
                <div class="col-md-4">
                    <?php echo $this->formProlepsis->renderField('RefDate'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->formProlepsis->renderField('exam_center_id'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php echo $this->formProlepsis->renderField('vials_received'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->formProlepsis->renderField('samples_to_hc'); ?>
                </div>
                  <div class="col-md-4">
                    <?php echo $this->formProlepsis->renderField('vials_in_stock'); ?>
                </div>
            </div>

              <h3><?php echo Text::_('COM_EL_PEDY_RESULTS_FROM_HC'); ?></h3>
            <div class="row">
                  
                <div class="col-md-4">
                    <?php echo $this->formProlepsis->renderField('result_negative'); ?>

                </div>
            </div>
            <h4><?php echo Text::_('COM_EL_PEDY_POSITIVE_TO_VIO'); ?></h4>
            <div class="row">
                
                    
                    <div class="col-md-4">
                        <?php echo $this->formProlepsis->renderField('result_positive_hpv16'); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $this->formProlepsis->renderField('result_positive_hpv18'); ?>
                    </div>
            </div>
            <h4><?php echo Text::_('COM_EL_PEDY_POSITIVE_TO_PAP'); ?></h4>
            <div class="row">
                
                    
                    <div class="col-md-4">
                        <?php echo $this->formProlepsis->renderField('result_positive_ascsus'); ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $this->formProlepsis->renderField('result_positive_to_pap_negative'); ?>
                    </div>
                
            </div>
           

            <div class="row tm-7">
<!--                <div class="col-md-2">
                    <button class="btn btn-primary" name="act" value="apply">< ?php echo Text::_('JSAVE'); ?></button>
                </div>-->
                <div class="col-md-4">
                    <a class="btn btn-info" href="<?php echo $this->listUrl; ?>" ><?php echo Text::_('JCANCEL'); ?></a>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary pull-right" name="act" value="save"><?php echo Text::_('COM_EL_PEDY_SAVE_AND_CLOSE'); ?></button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" name="act" value="saveandnew"><?php echo Text::_('COM_EL_PEDY_SAVE_AND_ΝEW'); ?></button>
                </div>
                
            </div>

        </fieldset>

    </form>
    <div class="prolepsisHPV3065 el-busy"></div>
</div>
<script type="application/javascript" src="media/com_elpedy/js/moment.min.js" ></script>
<script type="application/javascript" src="libraries/elogism/js/elgsjs.js"></script>
<script type="application/javascript" src="/media/com_elpedy/js/ProlepsisEdit.js"></script>
<script type="application/javascript">
        Prolepsis.init({
            dataUrl: Joomla.getOptions('com_elpedy')['ProlepsisEditData'],
            saveUrl: Joomla.getOptions('com_elpedy')['ProlepsisEditSaveData'],
            listUrl: Joomla.getOptions('com_elpedy')['ProlepsisList']
        });
</script>
