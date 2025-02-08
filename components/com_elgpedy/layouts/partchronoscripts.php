<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');

 use Joomla\CMS\Uri\Uri;
 if ( strpos( Uri::getInstance() ->getQuery(), 'report') === false
      && strpos( Uri::getInstance() ->getQuery(), 'dentalexams') === false 
      && strpos( Uri::getInstance() ->getQuery(), 'adiologio') === false )
 {
     echo "<script>var pedyDateFrom = moment().subtract(900, 'd')</script>";
 }
?>
<script type="text/javascript">
     var unitsUrls = {};
     
    <?php require JPATH_COMPONENT_SITE . '/layouts/partchronomenubehavior.php'; ?>
    jQuery(document).ready(function(){
        document.getElementById('HealthUnitId').onchange = elgGetFormData;
        
        var pedyDateTimePickerOptions = {
                format: "dd/mm/yyyy",
                startView: 2,
                minView: 2,
                autoclose: true,
                todayHighlight: true,
                language: 'el',
                forceParse: false,
                endDate: new Date()
            };
        if ( typeof pedyDateFrom !== 'undefined')
        {
            pedyDateTimePickerOptions.startDate =  pedyDateFrom.format('YYYY-MM-DD');
        }
                   
        jQuery('.form_datetime').datetimepicker(
                pedyDateTimePickerOptions
                )
            .on('hide',function(){var a = $(this);setTimeout(function(){a.show();},2);})
            .on('changeDate', elgGetFormData);            
    });   
</script>
