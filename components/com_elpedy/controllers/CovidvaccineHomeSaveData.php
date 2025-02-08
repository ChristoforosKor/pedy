<?php
                    
namespace  components\com_elpedy\controllers;
/*-----------------------------------------------------------------------
 com_elpedy by e-logism - Dextera Consulting.
 ------------------------------------------------------------------------
 author    E-Logism - Dextera Consulting
 copyright Copyright (C) 2018 e-logism.gr. All Rights Reserved.
 @license - https://www.e-logism.gr/license.pdf
 Websites: www.e-logism.gr, www.dexteraconsulting.com
------------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
use elogism\controllers\ElController;
use Joomla\Input\Input;
use Joomla\Registry\Registry;
                       
class CovidvaccineHomeSaveData extends ElController {
     protected function createState(Input $input = null) : Registry 
    {
        
        $data = parent::createState($input);
        
        $data['task'] = $input ->getCmd("task");
        $data['RefDate'] = $input ->getCmd("ref_date");
        $data['HealthUnitId'] = $input ->getInt("id_health_unit");
         //$data['MunicipalitySectorId'] = $input ->getInt("MunicipalitySectorId");
        $data['ClinicIncidentGroupId'] = $input ->getInt("ClinicIncidentGroupId");
        $data['CovidVaccineId'] = $input ->getInt('CovidVaccineId');
        $data['Quantity'] = $input ->getInt('Quantity', 0);
        $data['CovidVaccineTransactionId'] = $input ->getInt('CovidVaccineTransactionId', 0);  
        $data['CovidVaccineCompanyId'] = $input ->getInt('CovidVaccineCompanyId', 0);  
//        $data['ReceivedQuantity'] = $input ->getInt('ReceivedQuantity', -1);  
//        $data['RejectedQuantity'] = $input ->getInt('RejectedQuantity', -1);
       
        return new Registry( $data );
    }
}
