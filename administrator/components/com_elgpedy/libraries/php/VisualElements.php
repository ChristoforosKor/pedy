<?php

/**
 * @author e-logism
 * @copyright (c) e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 */
class VisualElements {

    /**
     * this class holds functions for creating visual elements.
     *
     */




    /**
     * This creates an html Select element
     * @param String[n][1] $sdata  array containing select's elements data. First column is value second column is text
     * @param String $slcVal: the seleted value of the html select element.
     * @param String $attr: Atributes of the html element e.g. " name=\"myelem\" id=\"myid\" style=\"color:#123456;font-weight: bold\" ".
     * @param String[0][1] $emptyOption If the select element will have an option that indicates that no value is selected. The first column hold the value the second the text to show, e.g. [0]["Select a value"]. This option will always be first on the drop down list.
     * @return String : the html for the select element. If an error ocuurs or no data provided for then construction of the html element it will return an empty string.
     */

    static function htmlSelect($sData, $slcVal=0, $attr="",$emptyOption="") {
        if (is_array($sData))
            $recs = count($sData);
        else
            $recs = "";

        $rHTML =    "<select " . $attr . "   >";
        if(is_array($emptyOption))
        $rHTML .=   "   <option value=\"" . $emptyOption[0][0] . "\" >" . $emptyOption[0][1] . "</option>";
        for ($i = 0; $i < $recs; $i = $i + 1) {
            if ($sData[$i][0] == $slcVal)
                $rHTML = $rHTML . "   <option value=\"" . $sData[$i][0] . "\" selected=\"selected\"  >" . $sData[$i][1] . "</option>";
            else
                $rHTML = $rHTML . "   <option value=\"" . $sData[$i][0] . " >" . $sData[$i][1] . "</option>";
        }
        $rHTML = $rHTML . "</select>";
        return $rHTML;
    }

    function test() {
        return "test";
    }
}

?>
