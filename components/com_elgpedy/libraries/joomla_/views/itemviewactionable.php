<?php
/**
 * @copyright (c) 2013, e-logism
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require 'itemview.php';
 require 'iactionable.php';
 /**
  * Base class for all views that have edit buttons and retutn anchors .
  * @package e-logism.joomla;
  * @subpackage view
  * @author Christoforos J. Korifidis
  * 
  */
 class  ItemViewActionable extends ItemView implements IActionable 
 {
    
     /**
      *
      * @var INT $colspan When render button on a table footers how many colspan.
      */
    protected $colspans; 
     
   /**
    * Array that holds the class to apply on the html the buttons container.
    * @buttonClasses array 
    */  
    protected $buttonsClasses;
    
    /**
     * Array that holds the class to apply on the html links container.
     * @linksClass array 
     */
    protected $linksClasses;
    
    /**
     * Array that holds the texts for each one button.
     * @buttonTexts array 
     */
    protected $buttonsTexts;
    
    
    /**
     * Array that holds the types for each one button.
     * @buttonTypes array 
     */
    protected $buttonsTypes;
    
    /**
     *Array that holds the uris for each one anchor.
     * @linkClasses array
     */
    protected $linksUrls;
            
            
    /**
     *Array that holds the texts for each one anchor.
     * @linksUrls array
     */
    protected $linksTexts;
 
    /**
     * Array ths holds the javascript function to call a button clik if necessary.
     * @buttonsActions array 
     */
    protected $buttonsActions;
    
   
    
     /**
     * Class Constructor.
     * @param   JModel            $model  The model object.
     * @param   SplPriorityQueue  $paths  The paths queue where the layoyts files reside.
     */
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
       parent::__construct($model, $paths);
       $this->colspans[0] = "3";
       $this->linksClasses[0] = "c2";
       $this->linksTexts[0] = JText::_('COM_ELG_RETURN');
       $this->linksUrls[0] =  $this->commonUrl .'&view=' . $this->basicData['view'] .'s';
       
    }

    
    public function setButtonsClass($class= null) {
        if ($class == null) 
        {
            $this->buttonsClass = '';
        }
        else 
        {
            $this->buttonsClass = $class;
        }
    }

    public function setButtonsTexts(Array $buttonsTexts = array()) {
        $this->buttonsText = $buttonsTexts;
    }
    
    public function setButtonsTypes(Array $buttonsTypes = array()) {
        $this->buttonsTypes = $buttonsTypes;
    }

    public function setLinksClass($linksClass = null) 
    {
        if ($linksClass == null) 
        {
            $this->linkClass = '';
        }
        else 
        {
            $this->linksClass = $linksClass;
        }
    }
                    
    public function setLinksTexts(Array $linksTexts = array()) {
        $this->linksTexts = $linksTexts;
    }

    public function setLinksUrls(Array $linksUrls = array()) {
        $this->linksUrls =  $linksUrls;
    }
    
    public function setButtonsActions(Array $buttonsActions = array()) {
        $this->buttonsActions =  $buttonsActions;
    }

    
    
 }
?>
