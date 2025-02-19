<?php

namespace components\com_elpedy\controllers;
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

class ProlepsisSaveData extends ElController {
     protected function createState(Input $input = null) : Registry 
    {
        $data = $input -> getArray();
        return new Registry( $data );
    }
}
