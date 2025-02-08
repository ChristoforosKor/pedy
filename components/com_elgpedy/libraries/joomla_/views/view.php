<?php
/**
 * e-logism's library
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 /**
  * Base class for all views.
  * @package e-logism.joomla;
  * @subpackage views
  * @author Christoforos J. Korifidis
  * 
  */
 class  View extends JViewHTML
 {
    
     /**
      *
      * @state JRegistry The view's state. The state initial comes from the view's model
      */
    protected  $state = null;
    /*    *
     *
     * @uri Array An array containing the parts of the current uri. 
     */
   // protected  $uri = null;
    
    /**
     *
     * @basicData Array Array containg the basic data of a joomla request. That is option, view, controller, model, Itemid, lang and any aother is defind in utils::geBasicData method  
     */
    public $basicData = null;
    
    
    /**
     *
     * @data stdClass Holds only the actual data from the state.
     */
    protected $data = null;
    
     /**
     * The common url  part that used for url construction from various subclasses.
     * This common url  consist from following
     * 1. index.php
     * 1. option
     * 2. lang
     * 3. Itemid
     * @var type 
     */
    protected $commonUrl ;
    
    /**
     * Class Constructor.
     * @param   JModel            $model  The model object.
     * @param   SplPriorityQueue  $paths  The paths queue where the layoyts files reside.
     */
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
       parent::__construct($model, $paths);
       $this->state = $this->model->getState();
       $this->basicData = Utils::getBasicStateData();
       $this->data = $this->state->get('data');
       $this->commonUrl = "index.php?option=" . $this->basicData['option'] . '&Itemid=' . $this->basicData['Itemid'] . '&lang=' . $this->basicData['lang'];
      
    }
    
    
 }
?>
