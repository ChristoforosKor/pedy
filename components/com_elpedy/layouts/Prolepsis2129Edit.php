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
    
    h1, h2, h3 {
        
        margin-bottom: 50px;
    }
    
   
</style>

<link href="/media/com_elpedy/css/site.stylesheet.css" rel="stylesheet" type="text/css"/>
<div class="el prolepsis2129-edit section">
    <h2><?php echo Text::_("COM_EL_PEDY_PROGRAM") , ' ', Text::_('COM_EL_PEDY_TEST_PAP_AGE_2129'); ?></h2>
    <div class="msg-area"></div>
    <form method="post" action="" id="prolepsis2129">
             <?php echo $this->formProlepsis->renderField('id'); ?>
            
            <div class="row">
                <div class="col-md-3">
                    <?php echo $this->formProlepsis->renderField('RefDate'); ?>
                </div>
                <div class="col-md-3">
                    <?php echo $this->formProlepsis->renderField('healthunit_id'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?php echo $this->formProlepsis->renderField('samples_to_check'); ?>
                </div>
                <div class="col-md-3">
                    <?php echo $this->formProlepsis->renderField('vials_in_stock'); ?>
                </div>
            </div>
        <fieldset>
            <legend><?php echo Text::_('COM_EL_PEDY_RESULTS_TEST_PAP'); ?></legend>
            <div class="row">
               
                <div class="col-md-3">
                    <?php echo $this->formProlepsis->renderField('result_ok'); ?>
                </div>
                  <div class="col-md-3">
                    <?php echo $this->formProlepsis->renderField('result_notok'); ?>
                </div>
            </div>
        </fieldset>
        

            <div class="row tm-7">
<!--                <div class="col-md-2">
                    <button class="btn btn-primary" name="act" value="apply">< ?php echo Text::_('JSAVE'); ?></button>
                </div>-->
                <div class="col-md-3">
                    <a class="btn btn-info" href="<?php echo $this->listUrl; ?>" ><?php echo Text::_('JCANCEL'); ?></a>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary pull-right" name="act" value="save"><?php echo Text::_('COM_EL_PEDY_SAVE_AND_CLOSE'); ?></button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" name="act" value="saveandnew"><?php echo Text::_('COM_EL_PEDY_SAVE_AND_ΝEW'); ?></button>
                </div>
                
            </div>

     

    </form>
    <div class="prolepsis2129 el-busy"></div>
</div>
<script type="application/javascript" src="media/com_elpedy/js/moment.min.js" ></script>
<script type="application/javascript" src="libraries/elogism/js/elgsjs.js"></script>
<script type="application/javascript" src="/media/com_elpedy/js/Prolepsis2129Edit.js"></script>
<script type="application/javascript">
        Prolepsis.init({
            dataUrl: Joomla.getOptions('com_elpedy')['Prolepsis2129EditData'],
            saveUrl: Joomla.getOptions('com_elpedy')['Prolepsis2129EditSaveData'],
            listUrl: Joomla.getOptions('com_elpedy')['Prolepsis2129List']
        });
</script>
