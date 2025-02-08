<?php
/*------------------------------------------------------------------------
# com_elgcomponent e-logism 
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# copyright Copyright (c) 2010-2014 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require JPATH_COMPONENT_ADMINISTRATOR . '/libraries/php/xmlutils.php';

class ElgPedyModelAbout extends JModelBase
{
    public function getState()
    {
       $state = parent::getState(); 
       $data= new stdClass();
       $about = new stdClass();
       $xmlData = XMLUtils::getXMLFileProperties(JPATH_COMPONENT_ADMINISTRATOR . '/manifest.xml', array('copyright'=>'/extension/copyright', 'version'=>'/extension/version', 'authorUrl'=>'/extension/authorUrl', 'authorEmail'=>'/extension/authorEmail', 'creationDate'=>'/extension/authorEmail', 'author'=>'/extension/author'))   ;     
       foreach($xmlData as $key=>$value)
       {
            if(count($value) > 0)
            {
                $about->$key = $value[0]->__toString();
            }
            else
            {
                $about->$key = "";
            }
       }
       unset($key);
       unset($value);
       $data->about = $about;
       $state->set('data', $data);
       return $state;
    }
}