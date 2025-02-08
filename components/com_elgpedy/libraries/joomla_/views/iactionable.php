<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 /**
  * Interface for all class that implement action button like edit, submit, retun link etc.
  * @package e-logism.joomla;
  * @subpackage views
  * @author Christoforos J. Korifidis
  * 
  */
 interface  IActionable 
 {
    
     /**
      *  declares and/or sets the css classes of the html elmeents that hols the links.
     */
    public function setLinksClass($class);
    
    
    /*
     * declares and/or sets  the css  classes from the html elements that holds the buttons.
     */
    public function setButtonsClass($class);
    
    
    /**
     * declares and/or sets  the types of the types of our buttons
     */
    public function setButtonsTypes(Array $buttonTypes);
    
    /**
     * declares and/or sets  the text of our buttons
     */
    public function setButtonsTexts(Array $buttonTexts);
    
    
    /**
     * declares and/or sets  the links of our anchors
     */
    public function setLinksUrls(Array $linksUrls);
    
    /**
     * declares and/or sets  the text of our anchors
     */
    public function setLinksTexts(Array $linksTexts);
    
    /**
     * declares and/or sets  the text of our anchors
     */
    public function setButtonsActions(Array $buttonActions);
   
 }
?>
