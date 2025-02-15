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
use Joomla\CMS\MVC\Model\AdminModel;
/**
 * Gets step list data
 * @author E-Logism
 */
class ProlepsisEdit extends JModelDatabase {

    
    
    
    public function getState(): Registry {
      
        $state = parent::getState();
//        $format= $state->get('format');
//        if ($format === 'json') {
//            $item = $this->getItem($state->get('id',0));
//            $state->set('data', $item);
//        } else { 
            $form = $this->getForm();
            $state->set('forms', ['prolepsis'=> $form]);
//        }
      
//       
//        var_dump($state);
//        $db = ComUtils::getPedyDB();
//        $query = $db -> getQuery(true);
//        $state = parent::getState();
//        $data = $state -> get( 'data', []) ; 
//        $data [ 'VaccinesEdit' ] =  $this -> getVaccinesSteps ( $db, $query );
//        $data['schools'] = $this -> getSchoolData( $db, $query );
//        $data['levelClasses'] = $this -> getSchoolLevelClasses( $db, $query );
//        $data['areas'] = $this -> getArea( $db, $query );
//        $data['areaTypes'] = $this -> getAreaType( $db, $query );
//        $data['schoolLevels'] = array_values(
//                array_unique(
//                        array_map(function( $item ) {
//                            return [$item[0], $item[1]];
//                        }, $data['levelClasses'])
//                        , SORT_REGULAR
//        ));
//        $state -> set('data', $data);
        return $state;
    }   
//    
//    private function getVaccinesSteps( $db, $query) {
//        return 
//                $db -> setQuery ( 
//                        $query 
//                        -> clear()
//                        -> select('vvs.idVaccine, vvs.idVaccineStep, vs.VaccineStep, v.Vaccine, vvs.id')
//                        -> from ('#__Vaccine_VaccineStep vvs')
//                        -> innerJoin ('#__VaccineStep vs on vvs.idVaccineStep = vs.id')
//                        -> innerJoin('#__Vaccine v on v.id = vvs.idVaccine')
//                        -> order ( 'Vaccine, idVaccineStep')
//                        ) -> loadRowList();
//        
//    }
//    
//    private function getSchoolData( $db, $query )
//    {
//        $query -> clear();
//        $query -> select ( 'school_id, school_level_id, area_id, description') ->  from ('#__school');
//        return $db -> setQuery($query) ->loadRowList();
//      
//    }
//    private function getSchoolLevelClasses( $db, $query )
//    {
//        $query -> clear();
//        $query ->  select ('sl.school_level_id, sl.school_level , sc.school_level_class_id, sc.school_level_class') 
//                ->    from ('#__school_level sl')
//                ->    innerJoin ('#__school_level_class sc on sc.school_level_id = sl.school_level_id ');
//        return $db->setQuery($query)->loadRowList();
//     
//    }
//    
//    private function getArea( $db, $query )
//    {
//        $query -> clear()
//       -> select ('area_id, area_type_id, area')
//        ->from ('#__area')
//        ->order ('area');
//        return $db -> setQuery ( $query ) ->loadRowList();
//    
//    }
//    
//    private function getAreaType ( $db, $query )
//    {
//        $query -> clear()
//        -> select ('area_type_id, area_type') 
//        -> from ('#__area_type');
//        return $db -> setQuery ( $query ) ->loadRowList();
//    }

    public function getForm($data = array(), $loadData = true) {
        $form = $this->loadForm('com_elpedy.prolepsis', 'prolepsis', ['load_data' => false]);
        
        if (empty($form)) {
            return false;
        }

        
//        $temp = clone $this->getState('params');

      

//        $active = JFactory::getApplication()->getMenu()->getActive();
//
//        if ($active) {
//            // If the current view is the active item and a contact view for this contact, then the menu item params take priority
//            if (strpos($active->link, 'view=contact') && strpos($active->link, '&id=' . (int) $contact->id)) {
//                // $contact->params are the contact params, $temp are the menu item params
//                // Merge so that the menu item params take priority
//                $contact->params->merge($temp);
//            } else {
//                // Current view is not a single contact, so the contact params take priority here
//                // Merge the menu item params with the contact params so that the contact params take priority
//                $temp->merge($contact->params);
//                $contact->params = $temp;
//            }
//        } else {
//            // Merge so that contact params take priority
//            $temp->merge($contact->params);
//            $contact->params = $temp;
//        }
//
//        if (!$contact->params->get('show_email_copy', 0)) {
//            $form->removeField('contact_email_copy');
//        }

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
