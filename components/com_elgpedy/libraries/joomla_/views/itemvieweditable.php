<?php
/**
 * @copyright (c) 2013, e-logism
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require_once 'itemviewactionable.php';
 /**
  * Base class for all views that have edit button and return url.
  * @package e-logism.joomla;
  * @subpackage view
  * @author Christoforos J. Korifidis
  * 
  */
 class  ItemViewEditable  extends ItemViewActionable
 {
    
     /**
     * Class Constructor.
     * @param   JModel            $model  The model object.
     * @param   SplPriorityQueue  $paths  The paths queue where the layoyts files reside.
     */
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
      
       parent::__construct($model, $paths);
     
       $this->buttonsTexts[0] = JText::_('COM_ELG_EDIT');
       $this->buttonsTypes[0] = "button";
       $this->buttonsActions[0] = 'goToItemEdit0()';
       $script = $this->getGoToEditScript();
       JFactory::getDocument()->addScriptDeclaration($script);
      
    }

    protected function getGoToEditScript()
    {
        return ' function goToItemEdit0(){ location.href = "' . $this->commonUrl . '&id=' . $this->basicData['id'] . '&view=' . $this->basicData['view'] . 'edit" ;}';
    }
    
    
 }
?>
