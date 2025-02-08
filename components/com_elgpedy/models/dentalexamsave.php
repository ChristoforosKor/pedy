<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism  application
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (c) 2010-2020 e-logism.com. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

 
----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );


class ElgPedyModelDentalExamSave extends JModelDatabase
{
	
	function setState(JRegistry $state) 
	{            
            $formData = $state->get('formData');
            $table = JTable::getInstance('dentaltransaction');
            $hasChanged = false;
            $createTime = date('Y-m-d H:i:s');
            $updateTime = date('Y-m-d H:i:s');
            if( $formData->dental_transaction_id > 0 ):
                $table->load($formData->dental_transaction_id);
                if($table->health_unit_id != $formData->health_unit_id 
                        || $table->school_id != $formData->school_id
                        || $table->school_class_id != $formData->school_class_id
                        || $table->exam_date != $formData->exam_date
                        || $table->birthday != $formData->birthday
                        || $table->nationality_id != $formData->nationality_id
                        || $table->father_professoin != $formData->profession
                        || $table->mother_profession != $formData->mother_profession
                        || $table->isMale != $formData->isMale
                          || $table->ssn != $formData->ssn
                        ):
                    $hasChanged = true;
                    $table->status_id = ComponentUtils::$STATUS_MODIFIED;
                    $table->update_time = $updateTime;
                    $createTime = $table->create_time;
                    $table->store();
                    $this->insertNew($table, $formData, $createTime, $updateTime);
                endif;
            else:
                $this->insertNew($table, $formData, $createTime, $updateTime);
            endif;            
            $db = ComponentUtils::getPedyDB();
            if( $hasChanged ):
                $this->updateChildren($db, $formData->dental_transaction_id, $table->dental_transaction_id);
            endif;           
            $this->toothTransaction($db, $table->dental_transaction_id, $this->clearToothData($formData->tooth), $createTime, $updateTime);
            $this->mouthTransaction($db, $table->dental_transaction_id, $formData->dental_mouthcondition, $createTime, $updateTime);            
	}
        
        private function insertNew($table, $formData, $createTime, $updateTime)
        {
            $table->bind($formData);
            $table->status_id = ComponentUtils::$STATUS_ACTIVE;
            $table->create_time= $createTime;
            $table->update_time = $updateTime;
            $table->dental_transaction_id = null;
            $table->locale = 'el';
            $table->store();
        }
        
        
        private function updateChildren($db, $oldId, $newId)
        {
            $query = $db->getQuery();
            $query->clear();
            $query->update('#__dental_transaction_tooth')->set('dental_transaction_id=' . $newId)->where('dental_transaction_id=' . $oldId . ' and status_id = ' . ComponentUtils::$STATUS_ACTIVE);
            $db->execute();
            $query->clear();
            $query->update('#__dental_transaction_mouth')->set('dental_transaction_id=' . $newId)->where('dental_transaction_id=' . $oldId . ' and status_id = ' . ComponentUtils::$STATUS_ACTIVE);
            $db->execute();
        }
        
        private function toothTransaction($db, $dentalTransactionId, $toothData, $createTime, $updateTime)
        {
            $oldToothData = $this->getOldToothData($db, $dentalTransactionId);
            $this->deleteOldToothData( $db, $toothData, $oldToothData, $dentalTransactionId );
            $this->updateOldToothData($db, $toothData, $oldToothData, $updateTime);
            $table2 = JTable::getInstance('dentaltransactiontooth');
            foreach($toothData as $key=>$value):
                $table2->dental_transaction_tooth_id = null;
                $table2->dental_transaction_id = $dentalTransactionId;
                $table2->dental_tooth_id = $key;
                $table2->dental_condition_id = $value;
                $table2->create_time = $createTime;
                $table2->update_time = $updateTime;
                $table2->status_id = ComponentUtils::$STATUS_ACTIVE;
                $table2->store();                
            endforeach;
            unset($key);
            unset($value);
        }
        
        private function deleteOldToothData($db, $newValues, $oldToothData, $idTranasction)
        {
            $toDel = array_diff(array_keys($oldToothData), array_keys($newValues));
            $delIds = '';
            foreach( $toDel as $delItem ):
                $delIds .= $delItem .',';
            endforeach;
            unset($delItem);
            if($delIds != ''):
                $db->setQuery( 'update #__dental_transaction_tooth set status_id = ' . ComponentUtils::$STATUS_DELETED . ' where dental_transaction_id = ' . $idTranasction .' and dental_tooth_id in(' . trim($delIds, ',') . ')');
                $db->execute();
            endif;
        }
        
        private function updateOldToothData($db, $toothData, $oldToothData, $updateTime)
        {
            $updIds = '';
            foreach($toothData as $key => $value):
                 if( array_key_exists($key, $oldToothData)):
                     $updIds .= $oldToothData[$key][2] . ',';
                 endif;
            endforeach;
            unset($key);
            unset($value);
            if($updIds !== ''):
                $query = $db->getQuery();
                $query->setQuery('update #__dental_transaction_tooth
                         set status_id=' . ComponentUtils::$STATUS_MODIFIED . ', update_time=' . $db->quote($updateTime) .
                        ' where dental_transaction_tooth_id in (' . trim($updIds, ',') . ') ');

                $db->execute();
            endif;
        }
        
        private function clearToothData($toothData)
        {
            $cleared = [];
            foreach($toothData as $key => $value):
                if( $value !== ''):
                    $cleared[$key]  = $value;
                endif;
            endforeach;
            return $cleared;
        }
        
        
        private function mouthTransaction( $db, $dentalTransactionId, $mouthData, $createTime, $updateTime )
        {
            $oldMouthData = $this->getOldMouthData($db, $dentalTransactionId);
            $this->deleteOldMouthData( $db, $mouthData, $oldMouthData );
            
            $table3 = JTable::getInstance('dentaltransactionmouth');
            foreach($mouthData as $value):
                if($value !== '' && !array_key_exists($value, $oldMouthData) ):
                    $table3->dental_transaction_mouth_id = null;
                    $table3->dental_transaction_id = $dentalTransactionId;
                    $table3->dental_mouthcondition_id = $value;
                    $table3->create_time = $createTime;
                    $table3->update_time = $updateTime;
                    $table3->status_id = ComponentUtils::$STATUS_ACTIVE;
                    $table3->store();
                endif;
            endforeach;
            unset($value);           
        }
              
        private function getOldToothData($db, $foreignId)
        {
            $query = $db->getQuery();
            $query->clear();
            $query->select('dental_tooth_id, dental_condition_id, dental_transaction_tooth_id')->from('#__dental_transaction_tooth')->where('dental_transaction_id=' . $foreignId . ' and ' . ComponentUtils::$STATUS_ACTIVE );
            return $db->loadRowList(0);
            
        }      
        
        private function getOldMouthData($db, $foreignId)
        {
            $query = $db->getQuery();
            $query->setQuery('select dental_mouthcondition_id, dental_transaction_mouth_id from #__dental_transaction_mouth where dental_transaction_id=' . $foreignId . ' and status_id = ' . ComponentUtils::$STATUS_ACTIVE) ;
            return $db->loadRowList(0);
            
        }
        
        /**
         * Delete moth transaction data that were unselected from user.
         * @param JDatabasedriver $db
         * @param Array $newValues The values the user just submited
         * @param Array $oldMouthData Teh values that were already stored in database.
         */
        private function deleteOldMouthData($db, $newValues,$oldMouthData)
        {
            $toDel = array_diff(array_keys($oldMouthData), $newValues);
            $delIds = '';
            foreach( $toDel as $delItem ):
                $delIds .= $delItem .',';
            endforeach;
            unset($delItem);
            if($delIds !== ''):
                $db->setQuery( 'update #__dental_transaction_mouth set status_id = ' . ComponentUtils::$STATUS_DELETED . ' where dental_transaction_mouth_id in(' . trim($delIds, ',') . ')');
                $db->execute();
            endif;
        }
       
//        private function updateOldMouth($db, $id, $updateTime)
//        {
//            $query = $db->getQuery();
//            $query = 'update #__dental_transaction_mouth
//                     set status_id=' . ComponentUtils::$STATUS_MODIFIED . ', update_time=' . $db->quote($updateTime) .
//                     ' where dental_transaction_mouth_id=' . $id;
//            $db->execute();
//        }
 }