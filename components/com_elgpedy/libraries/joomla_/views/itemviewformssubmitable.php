<?php
/**
 * @copyright (c) 2013, e-logism
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require JPATH_COMPONENT_SITE . '/libraries/joomla/views/itemviewforms.php';
 
 /**
  * Base class for all views that submits data.
  * @package e-logism.joomla;
  * @subpackage view
  * @author Christoforos J. Korifidis
  * 
  */
 class  ItemViewFormsSubmitable extends ItemViewForms
 {
    
    
     /**
     * Class Constructor.
     * @param   JModel            $model  The model object.
     * @param   SplPriorityQueue  $paths  The paths queue where the layoyts files reside.
     */
    public function __construct(JModel $model, SplPriorityQueue $paths = null) 
    {
        parent::__construct($model, $paths);
        $this->linksTexts[0] = JText::_('COM_ELG_RETURN');
        $this->linksUrls[0] = $this->commonUrl . '&id=' . $this->basicData['id'] . '&view=' . str_replace('edit', '', $this->basicData['view']);
        $this->buttonsTexts[0] = JText::_('COM_ELG_SUBMIT');
    }
 }
?>
