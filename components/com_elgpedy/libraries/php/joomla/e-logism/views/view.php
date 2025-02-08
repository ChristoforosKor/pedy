<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism, dexteraconsulting  application
# ------------------------------------------------------------------------
# copyright Copyright (C) 2014 e-logism, dexteraconsulting. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr, http://dexteraconsulting.com
----------------------------------**/
 defined( '_JEXEC' ) or die( 'Restricted access' );
 /**
  * Base class for all views.
  * @package libraries.e-logism.php.joomla;
  * @subpackage views
  * @author Christoforos J. Korifidis
  * 
  */
 class  View extends JViewHTML
{   
    protected $state = null;
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
        parent::__construct($model, $paths);
        $paths = new   SplPriorityQueue();
        $paths->insert(JPATH_COMPONENT . '/layouts', 'normal');
        $this->setPaths($paths); 
        $this -> state = $model -> getState(); 
        $this->setLayout( $this -> state -> get('layout'));
        JFactory::getDocument()->addStyleSheet(JUri::base() . 'media/com_elgpedy/css/site.stylesheet.css');
    }   
}