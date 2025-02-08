<?php
/**
 * @copyright (c) 2013, e-logism.
 * @license http://www.gnu.org/licenses/gpl.txt GPL version 3.
 * 
 */
 defined( '_JEXEC' ) or die( 'Restricted access' );
 
 /**
  * Class f that holds static functions used by e-logism's components.
  * @package e-logism.joomla;
  * @author Christoforos J. Korifidis
  * 
  */


class CommonUtils {
   
   
	public static function getBasicInput(JInput $input)
	{
		 $this->view = $this->input->getCMD('view', '');
			$this->model = $this->input->getCMD('model','')
			$this->input->getCMD('controller','');
			$this->input->getCMD('layout', 
	}
   
     /**
     * Sanitates basic request parameters and returns them as an array. 
      * These request data are
      * 1. option
      * 2. view
      * 3. controller
      * 4. model
      * 5. layout
      * 6. format
      * 7. Itemid
      * 8. id
      * 
     * @param JInput $input the input object to use use for reading request.
      * if no input given gets the default JInput from the application object.
     */
    public static function getBasicStateData(JInput $input = null) {
        if ($input == null) {
            $input = JFactory::getApplication()->input;
        }
        $request = array();
        $request['option'] = $input->getWord('option', '');
        $request['view'] = $input->getWord('view', Utils::VIEW_TO_REPLACE_WITH_DEFAULT);
        if($request['view'] == Utils::COMPONENT_NAME)
        {
            $request['view'] = Utils::VIEW_TO_REPLACE_WITH_DEFAULT;
        }
        $request['controller'] = $input->getWord('controller', '');
        if($request['controller'] == '') 
        {
            $request['controller'] =  'itemcontrollerview';
        }
        $request['model'] = $input->getWord('model',  ( $request['controller'] == 'itemcontrollerview' ? $request['view'] : $request['controller']  ));
        $request['layout'] = $input->getWord('layout',$request['view']);
        if($request['layout'] == Utils::COMPONENT_NAME)
        {
            $request['layout'] = Utils::VIEW_TO_REPLACE_WITH_DEFAULT;
        }
        $request['format'] = $input->getWord('format','html');
        $request['Itemid'] = $input->getInt('Itemid',0);
        $request['id'] = $input->getInt('id',0);
        return $request;
    }
   
    /**
     * Returns baseic information about a user. 
     * 
     * @param INT  $id The user id.
     * @return stdClass Class containg user's info as properties. 
     * Currently these info are
     * 1. user.id
     * 2. user.name
     */
    
    public static function getUserTitleData($id) {
         $dbo = JFactory::getDbo();
         $query = $dbo->getQuery(true);
         $query->select(array($dbo->quoteName('id'),$dbo->quoteName('name')))
                 ->from("#__users")
                 ->where("id=" . $id);
         $dbo->setQuery($query);
         $data = $dbo->loadObject();
         if (!isset($data)) {
             $data = new stdClass();
             $data->name = '';
             $data->id = 0;
         }
         return $data;
     }

     /**
      * This function converts a value to literally "Yes" or "No" or "Not set". The value is converted 
      * according to these rules:
      * 1. If the $conVal is -1 or "" then is converted to "Not set", (Component translatable constant COM_ELG_NOTSET).
      * 2. 0 or false then is converted to "No", (CMS translatable constant JNO).
      * 2. Anything else is converted to "Yes", (CMS translatable constant JYES).
      * @param Mixed $intVal The value we want to convert.      
      * @return String. The litteraly "Yes" or "No" or "Not set".
      */
     public static function getYesNo($conVal) {
        if ($conVal == -1 || $conVal == "") {
            return JText::_('COM_ELG_NOT_SET');
        }
        elseif ($conVal == 0 || $conVal == "" || $conVal === false ) {
            return JText::_('JNO');
        }
        else {
            return JText::_('JYES');
        }
    }
    
    /**
     * This function gets array of data and normalizes them according to given tules. 
     * Which data are going to be normalized and how wil be normalized  depends from the second argument ($keys). 
     * For example if $keys is  ['akey'=>['upper'], 'akey2'=>['nowhitespace', 'lower']] then $data->akey will be convertes to upper case
     * and $data->akey2 will be converted to lower case eliminating all white spaces.
     * which currently are:
     * 1. converts lower case to upper case
     * @param stdClass $data Object that contains in its properties, the data that might be normalized.
     * @param Array $keys An associative array tha contains keys and rules for normalization. The keys of this array corresponds to properties of the 
     * first argument ($data). The matching properties only will be normalized. Each key in tthis array has values in form of array that defines the rules for normalization.
     * Currently the rules that supported are:
     * 1. upper: convert data to upper case.
     * 2. lower: conert data to lower case.
     * 3. nospace: elimenates all spaces from the data.
     * 4. nowhitespace: eliminates all white space (o just spaces but also tabs etc) from the data.
     *  
     * @parma String $encoding. The encoding to be used when needed be transformations.
     * @return JRegistry the original jregistry object with its values converted
     * 
     * @todo strip accents
     * @deprecated since 1.0 
     */
    public static function normDataArray(stdClass $data, $keys, $encoding='utf8') {
        foreach($keys as $key=>$normTypes) {
            foreach($normTypes as $normType) {
                switch($normType) {
                    case 'upper' : $data->$key = mb_strtoupper($data->$key, $encoding);
                        break;
                    case 'lower' : $data->$key = mb_strtolower($data->$key, $encoding);
                        break;
                    case 'nowhitespace' : $data->$key = preg_replace('/\s+/', '', $data->$key);
                        break;
                    case 'nospaces' : $data->$key = str_replace(' ', '',  $data->$key);
                        break;
                }
            }
            unset($normType);
        }
        unset($key);
        unset($normTypes);
        return $data;
        
    }
    
     /**
     * This function gets a value and normalizes it according to given rules. 
     * Normalization rules are given in the array of the function's second argument (see below on the arguments explaination. 
     * @param primitive $value The value to be normalized.
     * @param Array $normRules An associative array that contains the rules for normalization. 
     * Currently the rules that supported are:
     * 1. upper: convert data to upper case.
     * 2. lower: conert data to lower case.
     * 3. nospace: elimenates all spaces from the data.
     * 4. nowhitespace: eliminates all white space (o just spaces but also tabs etc) from the data.
     *  
     * @param String $encoding. The encoding to be used when needed on string operations.
     * @return The $value normalized
     * 
     * @todo strip accents rule
     */
    
    public static function normData($value, $normRules, $encoding='utf8')
    {
        foreach($normRules as $normRule) {
                switch($normRule) {
                    case 'upper' : $value = mb_strtoupper($value, $encoding);
                        break;
                    case 'lower' : $value = mb_strtolower($value, $encoding);
                        break;
                    case 'nowhitespace' : $value = preg_replace('/\s+/', '', $value);
                        break;
                    case 'nospaces' : $value = str_replace(' ', '',  $value);
                        break;
                    case 'numeric' : $value =(is_numeric($value)? $value: 0);
                        break;
                    case 'trim' : $value = trim($value);
                        break;
                }
            }
            unset($normRule);
            return $value;
    }
   
    
    /**
     * This function queues errors for showing later in the application and returns the status of the proccess. So if there where really queed errors 
     * it returns TRUE otherwise it returns FALSE.
     * @param Array $errors An Array containing the errors to be queued.
     * @return BOOLEAN The status of the proccess when the proccess has finished. 
     */
    public static function canQueueErrorsMessages($errors = array(), $noErrorMessage='') {
        $status = false;
        if (is_array($errors)) {
            $app = JFactory::getApplication();
            if(count($errors) >0) {
                
                $cnt = count($errors);
                for ($i = 0; $i < $cnt ; $i++) {
                    if ($errors[$i] instanceof Exception) {
                        $app->enqueueMessage($errors[$i]->getMessage(), 'error');
                        $status = true;
                    }
                    else{
                        $app->enqueueMessage($errors[$i], 'error');
                        $status = true;
                    }
                }
            }
            else {
                $app->enqueueMessage($noErrorMessage);
            }
        }
        return $status;
    }
    
    /**
     * This function check if a valus is null and if is null gets the correpondin valu from the user state.
     * 
     * @param String $key The key of the variable to read from the user state.
     * @param Mixed $defaultValue The default value for the variable.
     * @param JSession $session The JSession object to use. If is null a new JSession object is creted.
     * @param String $sessionNamespace The namespace to use in the JSession object when storing the variable in the JSession.
     * @return Mixed The value of the variable either the origina or the one from the session . 
     */
    public static function syncValueWithSession($key, $defaultValue, $value, $session=null, $sessionNamespace='default') {
        if($session == null) {
            $session = JFactory::getSession();
        }
        if($value === null) {
            $value = $session->get($key, null, $sessionNamespace);
            if($value === null) {
                $value =$defaultValue;
                $session->set($key, $value, $sessionNamespace);
            }
        }
        else {
            $session->set($key, $value, $sessionNamespace);
        }
        return $value;
    }
     
    /**
     * This function return the parameters for a given component. The parameters are stored as a JRegistry object
     * in the user session. These parameters are accesible from the session with the key (name_of_the_compoment).params.
     * If no component name given the default COMPONENT_FOLDER const is used.
     * @param String $comName The name of the compomnent.
     * @return JRegistry The previously store Jregistry object in the user session.
     */
    public static function getComponentParams($comName=null) {
        if($comName == null) {
            $comName = utils::COMPONENT_FOLDER;
        }
        $session = JFactory::getSession();
        if($session->get($comName . '.params') == null) {
            $reg = JRegistry::getInstance(1000);
            $reg->loadFile(JPATH_ADMINISTRATOR . '/components/' . $comName . '/config.xml', 'XML');
            $session->set($comName . '.params', $reg);
        }
        return $session->get($comName . '.params');
    }
      
    /**
     * This function return the necessary values for a data list in a from of an array.
     
     * 
     * @param JInput $input The input object to be use for retrieving data from the request.
     * @param String $sessionNamespece The namspce of the session where the keys of the corresponding data belongs.
     * @param String $defaultOrder The column on which the data will be ordered by default.
     * @param String $orderDir The default ordering direction.
     * 
     * @return Array An array containg the values needed for creating lists of data. the array contains the following keys:
     *  1. limitastart : starting page counting from 0.
     *  2. limit: number of rows in the list.
     *  3. filter_order: the column on which the data are going to be order by
     *  4. filter_order_Dir: the direction of the ordering (asc or desc). 
     * 
     */
    public static function getListParams($input, $sessionNamespace, $defaultOrder, $defaultOrderDir='asc') {
        $listParams = array();
        $session = JFactory::getSession();
        $params = self::getComponentParams();
        $listParams['limitstart'] = ($input->getInt('cp',0) == 1? $input->getInt('limitstart', 0): 0); 
        $listParams['limit'] = self::getRequestNoNull('limit', $params->get('listLimit', 50), $input->getInt('limit', null), $session, $sessionNamespace); 
        $listParams['filter_order'] =  self::getRequestNoNull('filter_order', $defaultOrder, $input->getWord('filter_order', null), $session, $sessionNamespace); 
        $listParams['filter_order_Dir'] =  self::getRequestNoNull('filter_order_Dir', $defaultOrderDir, $input->getWord('filter_order_Dir', null), $session, $sessionNamespace);
        return $listParams;
    }
    
    /**
     * This function returns the pagination object to be used on data lists.
     * @param INT $totalRecords Total number of records retrieved.
     * @param INT $limitStart The current page.
     * @param INT $limit The number of records a page should have.
     * @return JPagination $pagination the paginatoin object.
     */
    public static function getPagination($totalRecords, $limitStart=0, $limit=null) {
        if($limit == null) {
            self::getComponentParams()->get('listLimit', 50);
        }
        $pagination = new JPagination($totalRecords, $limitStart, $limit);
        $pagination->setAdditionalUrlParam('cp', 1);
        return $pagination;
    }
    
    
    public static function resizeImage($originalFile, $destinationFile, $width, $height) {
      
        $image = new JImage($originalFile);
        $properties = JImage::getImageFileProperties($originalFile);
        $resizedImage = $image->resize($width, $height, true);
//        $mime = $properties->mime;
//        if ($mime == 'image/jpeg') {
//            $type = IMAGETYPE_JPEG;
//        }
//        elseif ($mime = 'image/png') {
//            $type = IMAGETYPE_PNG;
//        }
//        elseif ($mime = 'image/gif') {
//            $type = IMAGETYPE_GIF;
//        }       
        $resizedImage->toFile($destinationFile, $properties->type);
    }
    
    
    
    public static function getDateFormated($date='0000-00-00',$format='d/ m/ Y') {
       // if($date == '0000-00-00' || checkdate()) {
        if(strtotime($date))   
        {
            return date($format, strtotime($date));
            
        }
        else {
            return JText::_('COM_ELG_NOT_SET');
        }
    }
    
    public static function getNumWithZeros($num, $numLength = 8) {
        return sprintf('%0' . $numLength . 'd',$num) ;
    }
    
    
    /**
    * rdirect to obect redirect url;
    */
    public static function redirect($redirectUrl, $msg='') {
        if ($redirectUrl != '' ) 
        {
            JFactory::getApplication()->redirect($redirectUrl, $msg);
        }
    }
}    

?>
