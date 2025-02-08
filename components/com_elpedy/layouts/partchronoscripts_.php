<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript">
     var unitsUrls = {};
     
    
    jQuery(document).ready(function(){
        document.getElementById('HealthUnitId').onchange = elgGetFormData; 
	jQuery('.form_datetime').datetimepicker({
                format: "dd/mm/yyyy",
                startView: 2,
                minView: 2,
                autoclose: true,
                todayHighlight: true,
                language: 'el',
                forceParse: false,
                endDate: new Date()
            })
            .on('hide',function(){var a = $(this);setTimeout(function(){a.show();},2);})
            .on('changeDate', elgGetFormData);            
    });   
</script>
