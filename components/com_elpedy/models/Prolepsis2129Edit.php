<?php

/* ------------------------------------------------------------------------
  # com_elergon - e-logism
  # ------------------------------------------------------------------------
  # author    Christoforos J. Korifidis
  # @license - E Logism Proprietary Software Licence http://www.e-logism.gr/licence.pdf
  # Website: http://www.e-logism.gr
  ----------------------------------* */

namespace components\com_elpedy\models;

defined('_JEXEC') or die('Restricted access');

use components\com_elpedy\ComUtils;
use Joomla\Registry\Registry;
use JModelDatabase;
use Joomla\Utilities\ArrayHelper;
use SplPriorityQueue;
use Joomla\CMS\Form\Form;

/**
 * Gets step list data
 * @author E-Logism
 */
class Prolepsis2129Edit extends JModelDatabase {

    
    
    
    public function getState(): Registry {
      
        $state = parent::getState();
        $form = $this->getForm();
        $state->set('forms', ['prolepsis2129'=> $form]);

        return $state;
    }   

    public function getForm($data = array(), $loadData = true) {
        $form = $this->loadForm('com_elpedy.prolepsis2129', 'prolepsis2129', ['load_data' => false]);
        
        if (empty($form)) {
            return false;
        }

        return $form;
    }
    
    
    
    
    protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false)
	{
		// Handle the optional arguments.
		$options['control'] = ArrayHelper::getValue($options, 'control', false);

		// Create a signature hash.
		$hash = sha1($source . serialize($options));

		// Check if we can use a previously loaded form.
		if (isset($this->_forms[$hash]) && !$clear)
		{
			return $this->_forms[$hash];
		}

		// Get the form.
		// Register the paths for the form -- failing here
		$paths = new SplPriorityQueue;
		$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/model/form', 'normal');
		$paths->insert(JPATH_COMPONENT_ADMINISTRATOR . '/model/field', 'normal');
		$paths->insert(JPATH_COMPONENT . '/model/form', 'normal');
		$paths->insert(JPATH_COMPONENT . '/model/field', 'normal');
		$paths->insert(JPATH_COMPONENT . '/model/rule', 'normal');

		// Legacy support to be removed in 4.0.  -- failing here
		$paths->insert(JPATH_COMPONENT . '/models/forms', 'normal');
		$paths->insert(JPATH_COMPONENT . '/models/fields', 'normal');
		$paths->insert(JPATH_COMPONENT . '/models/rules', 'normal');

		// Solution until Form supports splqueue
		Form::addFormPath(JPATH_COMPONENT . '/models/forms');
		Form::addFieldPath(JPATH_COMPONENT . '/models/fields');
		Form::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/model/form');
		Form::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/model/field');
		Form::addFormPath(JPATH_COMPONENT . '/model/form');
		Form::addFieldPath(JPATH_COMPONENT . '/model/field');

		try
		{
			$form = Form::getInstance($name, $source, $options, false, $xpath);

			if (isset($options['load_data']) && $options['load_data'])
			{
				// Get the data for the form.
				$data = $this->loadFormData();
			}
			else
			{
				$data = array();
			}

			// Allow for additional modification of the form, and events to be triggered.
			// We pass the data because plugins may require it.
//			$this->preprocessForm($form, $data);

			// Load the data into the form after the plugins have operated.
			$form->bind($data);
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage());

			return false;
		}

		// Store the form for later.
		$this->_forms[$hash] = $form;

		return $form;
	}
        
      
}
