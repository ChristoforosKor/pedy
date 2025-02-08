<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism.gr  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2014 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/
class Nulls {
    public static function getNullHealthUnit()
    {
        $o = new stdClass();
        $o->HealthUnitId = 0;
        $o->HealthUnitTypeId = 0;
        $o->AutoDate = '';
        $o->Status = 0;
        $o->DescEL = '';
        $o->DescShortEL = '';
        $o->UserId = 0;
        $o->IsActive = 0;
        return $o;
    }
}
