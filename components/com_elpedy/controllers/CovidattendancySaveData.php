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
                       
class CovidattendancySaveData extends ElController {
     protected function createState(Input $input = null) : Registry 
    {
        $data = $input -> getArray();
        $data['action'] = $input -> getInt('cid', 0);
        $data['id'] = $input -> getInt('id', 0);
        $data['id_health_unit'] = $input -> getInt('id_health_unit', 0);
        $data['ref_date'] = $input -> getString('ref_date', '');
        $data['personnel_doctors'] = $input -> getInt('personnel_doctors', null);
        $data['personnel_nurses'] = $input -> getInt('personnel_nurses', null);
        $data['personnel_office'] = $input -> getInt('personnel_office', null);
        $data['personnel_labs'] = $input -> getInt('personnel_labs', null);
        $data['personnel_cleaning'] = $input -> getInt('personnel_cleaning', null);
        $data['personnel_guard'] = $input -> getInt('personnel_guard', null);
        
        $data['id_covidattendancy'] = $input -> getInt('id_covidattendancy', 0);
        $data['id_covidattendancy_details'] = $input -> getInt('id_covidattendancy_details', 0);
        $data['id_gender'] = $input -> getInt('id_gender', null);
        $data['age'] = $input -> getInt('age', null);
        $data['residence'] = $input -> getInt('residence', null);
       
        $data['id_attendancy_medium'] = $input -> getInt('id_attendancy_medium', null);
        $data['id_nationality'] = $input -> getInt('id_nationality', null);
        $data['id_treatment'] = $input -> getInt('id_treatment', null);
        $data['id_action'] = $input -> getInt('id_action', null);
        $data['hospital_prompt'] = $input -> getInt('hospital_prompt', null);
      
        return new Registry( $data );
    }
}
