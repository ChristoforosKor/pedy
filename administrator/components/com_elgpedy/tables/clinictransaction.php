<?php

/**
 * @author e-logism http://www.e-logism.gr
 * @copyright (C) 2013 e-logism. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('_JEXEC') or die('Restricted access');
require JPATH_COMPONENT_ADMINISTRATOR . '/tables/tablepedytransaction.php';

/**
 * JTable class father of all pedy application tables
 *
 * @author e-logism
 */
class JTableClinicTransaction extends TablePedyTransaction {

    var $ClinicTransactionId = null;
    var $ClinicTypeId = null;
    var $ClinicIncidentId = null;
    var $ClinicDepartmentId = null;
    var $PersonelId = null;
    var $ClinicIncidentGroupId = null;
    var $EducationId = null;
    var $PatientAmka = null;
    function __construct() {
        parent::__construct('ClinicTransaction', 'ClinicTransactionId');
        $this->ClinicDepartmentId = 1;
    }

    /**
      Check to see if submited data already in the database
     * */
    protected function loadExistingData() {

        $params = [
            'StatusId' => ComponentUtils::$STATUS_ACTIVE,
            'HealthUnitId' => $this->HealthUnitId,
            'RefDate' => $this->RefDate,
            'ClinicTypeId' => $this->ClinicTypeId,
            'ClinicIncidentId' => $this->ClinicIncidentId,
            'ClinicDepartmentId' => $this->ClinicDepartmentId,
            'ClinicIncidentGroupId' => $this -> ClinicIncidentGroupId,
            'PatientAmka' => $this -> PatientAmka
        ];
       

        if ($this->PersonelId != null):
            $params['PersonelId'] = $this->PersonelId;
        endif;

        return $this->load($params);
    }
    
    
     protected function loadExistingData2() {

        $params = [
            'StatusId' => ComponentUtils::$STATUS_ACTIVE,
            'HealthUnitId' => $this->HealthUnitId,
            'RefDate' => $this->RefDate,
            'ClinicTypeId' => $this->ClinicTypeId,
         
            'ClinicDepartmentId' => $this->ClinicDepartmentId,
            'ClinicIncidentGroupId' => $this->ClinicIncidentGroupId,
            'PatientAmka' => $this -> PatientAmka
        ];
        if ($this->PersonelId != null):
            $params['PersonelId'] = $this->PersonelId;
        endif;

        return $this->load($params);
    }
    
    
    
    

    protected function hasChanged($submitedData) {
        if ($this->Quantity == $submitedData['Quantity'] && $this -> EducationId == $submitedData['EducationId'] && $this -> ClinicIncidentId == $submitedData['ClinicIncidentId']  && $this ->PatientAmka == $submitedData['PatientAmka']) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_ARE_SAME_NO_UPDATE'), 'error');
            return false;
        } else {
            return true;
        }
    }

    

    protected function hasChangedChildPsychoHealth($submitedData) {
       
        if ($this->Quantity == $submitedData['Quantity'] 
                && $this -> EducationId == $submitedData['EducationId'] 
               && $this -> ClinicIncidentId == $submitedData['ClinicIncidentId']  
                 ) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_ARE_SAME_NO_UPDATE'), 'error');
            return false;
        } else {
            return true;
        }
    }

    
    public function storeChildPsychoHealth( )
    {
        
         $submitedData = 
        [

                'HealthUnitId' => $this->HealthUnitId
                , 'RefDate' => $this->RefDate
                , 'ClinicTypeId' => $this->ClinicTypeId
                , 'ClinicIncidentId' => $this->ClinicIncidentId
                , 'ClinicIncidentGroupId' => $this-> ClinicIncidentGroupId
                , 'Quantity' => $this->Quantity
                , 'PersonelId' => $this->PersonelId
                , 'UserId' => $this->UserId
                , 'AutoDate' => $this->AutoDate
                , 'ClinicDepartmentId' => $this->ClinicDepartmentId
                , 'EducationId' => $this -> EducationId
                , 'PatientAmka' => $this -> PatientAmka
        ];

        $params = [
            'StatusId' => ComponentUtils::$STATUS_ACTIVE,
            'HealthUnitId' => $this->HealthUnitId,
            'RefDate' => $this->RefDate,
            'ClinicTypeId' => $this->ClinicTypeId,
            'ClinicDepartmentId' => $this->ClinicDepartmentId,
            'ClinicIncidentGroupId' => $this->ClinicIncidentGroupId,
         
            'PatientAmka' => $this -> PatientAmka
        ];
     
        if ($this->PersonelId != null):
            $params['PersonelId'] = $this->PersonelId;
        endif;

        $existingDataLoaded = $this -> load( $params );
      
        if ( $existingDataLoaded )
        {
            if (!$this->hasChangedChildPsychoHealth($submitedData)) :
                return false;
            endif;
            $this->StatusId = ComponentUtils::$STATUS_MODIFIED;
            try {
                $res = parent::store();
            } catch (Exception $e) {
                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                return false;
            }
        }
        else
        {
            if ($submitedData['Quantity'] === 0 && $submitedData['EducationId'] !== 1  ):
                JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_NO_DATA_NO_UPDATE'), 'info');
                return false;
            endif;
        }
        
         $this->loadSubmited($submitedData);
        if ($this->Quantity == 0  && $submitedData['EducationId'] !== 1  ) {
            $this->insertNewWithStatus(ComponentUtils::$STATUS_DELETED);
        } else {
            $this->insertNewWithStatus(ComponentUtils::$STATUS_ACTIVE);
        }
        
    }
    
    public function store($updateNulls = false) {
       
        $submitedData = 
                [
                    
                        'HealthUnitId' => $this->HealthUnitId
                        , 'RefDate' => $this->RefDate
                        , 'ClinicTypeId' => $this->ClinicTypeId
                        , 'ClinicIncidentId' => $this->ClinicIncidentId
                        , 'ClinicIncidentGroupId' => $this-> ClinicIncidentGroupId
                        , 'Quantity' => $this->Quantity
                        , 'PersonelId' => $this->PersonelId
                        , 'UserId' => $this->UserId
                        , 'AutoDate' => $this->AutoDate
                        , 'ClinicDepartmentId' => $this->ClinicDepartmentId
                        , 'EducationId' => $this -> EducationId
                        , 'PatientAmka' => $this -> PatientAmka
                ];

        if ( $submitedData['EducationId'] > 0 ):
            $existingDataLoaded = $this -> loadExistingData2();
        else:
            $existingDataLoaded = $this -> loadExistingData();
        endif;

        if ( $existingDataLoaded ): 
            if (!$this->hasChanged($submitedData)) :
                return false;
            endif;
            $this->StatusId = ComponentUtils::$STATUS_MODIFIED;
            try {
                $res = parent::store();
            } catch (Exception $e) {
                JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
                return false;
            }
        else:
            if ($submitedData['Quantity'] === 0 && $submitedData['EducationId'] !== 1  ):
                JFactory::getApplication()->enqueueMessage(JText::_('COM_ELGPEDY_DATA_NO_DATA_NO_UPDATE'), 'info');
                return false;
            endif;
        endif;

        $this->loadSubmited($submitedData);

        if ($this->Quantity == 0  && $submitedData['EducationId'] !== 1  ) {

            $this->insertNewWithStatus(ComponentUtils::$STATUS_DELETED);
        } else {

            $this->insertNewWithStatus(ComponentUtils::$STATUS_ACTIVE);
        }
    }

    private function loadSubmited($submitedData) {

        $this->HealthUnitId = $submitedData['HealthUnitId'];
        $this->RefDate = $submitedData['RefDate'];
        $this->ClinicTypeId = $submitedData['ClinicTypeId'];
        $this->ClinicIncidentId = $submitedData['ClinicIncidentId'];
        $this->Quantity = $submitedData['Quantity'];
        $this->PersonelId = $submitedData['PersonelId'];
        $this->UserId = $submitedData['UserId'];
        $this->AutoDate = $submitedData['AutoDate'];
        $this->ClinicDepartmentId = $submitedData['ClinicDepartmentId'];
        $this->ClinicIncidentGroupId = $submitedData['ClinicIncidentGroupId'];
        $this->EducationId = $submitedData['EducationId'];
        $this->PatientAmka = $submitedData['PatientAmka'];
    }

    private function insertNewWithStatus($statusId) {
        $this->ClinicTransactionId = null;
        $this->StatusId = $statusId;
        try {
            $res = parent::store();
            JFactory::getApplication()->enqueueMessage(JText::_('COM_ELG_SUBMIT_SUCCESS'), 'success');
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
            return false;
        }
    }

    
    public function load($keys = null, $reset = true)
	{
		// Implement \JObservableInterface: Pre-processing by observers
		$this->_observers->update('onBeforeLoad', array($keys, $reset));

		if (empty($keys))
		{
			$empty = true;
			$keys  = array();

			// If empty, use the value of the current key
			foreach ($this->_tbl_keys as $key)
			{
				$empty      = $empty && empty($this->$key);
				$keys[$key] = $this->$key;
			}

			// If empty primary key there's is no need to load anything
			if ($empty)
			{
				return true;
			}
		}
		elseif (!is_array($keys))
		{
			// Load by primary key.
			$keyCount = count($this->_tbl_keys);

			if ($keyCount)
			{
				if ($keyCount > 1)
				{
					throw new \InvalidArgumentException('Table has multiple primary keys specified, only one primary key value provided.');
				}

				$keys = array($this->getKeyName() => $keys);
			}
			else
			{
				throw new \RuntimeException('No table keys defined.');
			}
		}

		if ($reset)
		{
			$this->reset();
		}

		// Initialise the query.
		$query = $this->_db->getQuery(true)
			->select('*')
			->from($this->_tbl);
		$fields = array_keys($this->getProperties());

		foreach ($keys as $field => $value)
		{
			// Check that $field is in the table.
			if (!in_array($field, $fields))
			{
				throw new \UnexpectedValueException(sprintf('Missing field in database: %s &#160; %s.', get_class($this), $field));
			}

			// Add the search tuple to the query.
                                                if ( $value == null )
                                                {
                                                    $query->where( '(' .  $this->_db->quoteName($field) . ' = ' . $this->_db->quote($value) . ' or  ' . $this->_db->quoteName($field) . ' is null )' );
                                                }
                                                else
                                                {
                                                    $query->where($this->_db->quoteName($field) . ' = ' . $this->_db->quote($value));
                                                }
			//$query->where($this->_db->quoteName($field) . ' = ' . $this->_db->quote($value));
		}

		$this->_db->setQuery($query);

		$row = $this->_db->loadAssoc();

		// Check that we have a result.
		if (empty($row))
		{
			$result = false;
		}
		else
		{
			// Bind the object with the row and return.
			$result = $this->bind($row);
		}

		// Implement \JObservableInterface: Post-processing by observers
		$this->_observers->update('onAfterLoad', array(&$result, $row));

		return $result;
	}

}
