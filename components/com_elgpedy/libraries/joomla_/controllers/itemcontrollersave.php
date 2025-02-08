<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 require 'itemcontroller.php';
 
 
 /**
  * Base controller for all controlers that saves data.
  * @package e-logism.joomla;
  * @subpackage controllers
  * @author Christoforos J. Korifidis
  * 
  * @todo Check success messages showing
  * @todo Check error messagesd showing
  */
 
class ItemControllerSave extends ItemController
{
    protected $submitedValues = array();
   
    public function execute() 
    {
        $this->setSubmitedValues('formData');
        parent::execute();
        $this->setRedirect();
    }

     /**
      * Sets the submitted values either from http either from session, after sanitazing them and check for form tokens when necessary.
      * The values are also normailized accrding to the rules associates with them. 
      * 
      * @param Strng $dataKey The key of the array tha holds the data in the state.
      
    */
    protected function setSubmitedValues($dataKey='filters') 
    {
            $input = $this->input;
            $isChecked = false;
            $formData = array();
            
            foreach($this->submitedValues as $key=>$type) {
               
                 
                $value = $input->get($key, null, $type[0]);
                if($value != null)
                {
                    if ($isChecked == false) 
                    {
                        JSession::checkToken($input->getCmd('method', 'post')) or jexit(JText::_('JINVALID_TOKEN'));
                        $isChecked = true;
                    }
                    if(is_array($value))
                    {
                        foreach($value as $inkey=>$item)
                        {
                            $value[$inkey] = CommonUtils::normData($item, $type[2]);
                        }
                        unset($item);
                    }
                    else
                    {
                      
                        $value = CommonUtils::normData($value, $type[2]);
                    }
                }
                else
                {
                    if ($type[0] == 'BOOLEAN')
                    {
                        $value=0;
                    }
                }
                
                $formData[$type[3]][$key] = CommonUtils::syncValueWithSession($key, $type[1], $value, $this->session, $this->sessionNamespace);
            }
            unset($key);
            unset($type);
          
            
            $this->basicData[$dataKey] =  $formData;
    }	
        
        
    protected function setRedirect()
    {
        $state= $this->model->getState();
        $errors = $state->get('errors');
        $hasErrors= CommonUtils::canQueueErrorsMessages($errors, JText::_('COM_ELG_SUBMIT_SUCCESS'));
        if($hasErrors) {
            $this->redirectUrl = JRoute::_($this->commonUrl .'&view=' . str_replace('save', '', $state->get('controller')) . '&id=' . $state->get('id'), false);
        }
        else {
            $this->redirectUrl = JRoute::_($this->commonUrl . '&view=' . str_replace('editsave', '', $state->get('controller')) . '&id=' . $state->get('id'), false);
        }
    }
}
?>
