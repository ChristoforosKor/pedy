<?php
/*------------------------------------------------------------------------
# com_elgcomponent - e-logism
# ------------------------------------------------------------------------
# author    Christoforos J. Korifidis
# copyright Copyright (C) 2010-2014 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr
----------------------------------**/

defined('_JEXEC') or die('Restricted access');
//require JPATH_COMPONENT_ADMINISTRATOR . '/libraries/e-logism/php/joomla/views/view.php';

class ElgPedyViewAbout extends JViewHTML
{
    function render() 
    {
        $this->logoImage = 'media/com_elgcompomnent/logo.png';
        $this->about = $this->model->getState()->get('data')->about;
		echo parent::render();
    }
    

}