<?php
/**
 * @copyright (c) 2013, e-logism
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/joomla/views/itemviewactionable.php';
 
 /**
  * Base class for all views that have forms.
  * @package e-logism.joomla;
  * @subpackage view
  * @author Christoforos J. Korifidis
  * 
  */
 class  ItemViewForms extends ItemViewActionable
 {
    
     
     /**
      * @var Array<JForm> $forms Array holding the actual JForm Objects.
      */
    protected  $forms = array();
   
    /**
     *
     * @var Array<string> $formaActions This array has the same keys as the $forms array and holds the urls where the correspoding forms submit their data.
     * Initial values for this array is the current view name plus the text "save" e.g. "viewnamesave".
     */
    protected $formsActions = array();
     /**
     * Class Constructor.
     * @param   JModel            $model  The model object.
     * @param   SplPriorityQueue  $paths  The paths queue where the layoyts files reside.
     */
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
       parent::__construct($model, $paths);
       $this->forms = $this->state->get('forms', array());
       $keys = array_keys($this->forms);
       foreach($keys as $key)
       {
            $this->formsActions[$key] = $this->commonUrl . '&controller=' .  $this->basicData['view'].'save';
       }
        
       unset($key);
    }
    
 }
?>
