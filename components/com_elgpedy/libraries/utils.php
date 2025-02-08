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


class Utils {
    const COMPONENT_FOLDER = 'com_elgefimeries';
    const COMPONENT_NAME = 'elgefimeries';
    const COMPONENT_URL_LOCALE ='el';
    const COMPONENT_DB_LOCALE='el-GR';
    const VIEW_TO_REPLACE_WITH_DEFAULT = 'elgefimeries';
    
     /**
     * 
     * @return STRING The default path where xml forms files redides.
     */
    public static function getDefaultFormPath() {
        return JPATH_COMPONENT_ADMINISTRATOR . '/models/forms';
    }
    
    /**
     * This function checks to see if a user is priviliged to see additional info. The function return a tru or flase value that has stored in the useer session.
     * @param INT $idUser The id of the user to check.
     * @return BOOLEAN A true or false value that indicaties whether the user can see priviliged info. This boolean variable existe in the session key
     * com_elgergasia.canSeeContactInfo.
     */
    public static function canSeeContactInfo($idUser=null) {
        $session = JFactory::getSession();
        if($session->get('com_elgergasia.canSeeContactInfo') == null){
            $aViewLevels = JFactory::getUser($idUser)->getAuthorisedViewLevels();
            $params = CommonUtils::getComponentParams();
            if (/**in_array($params->get('candidateLevel', self::DEFAULT_AUTHORIZE_VIEW_LEVEL_CANDIDATE), $aViewLevels)
                    || in_array($params->get('employersLevel', self::DEFAULT_AUTHORIZE_VIEW_LEVEL_EMPLOYER), $aViewLevels)
                    || **/ in_array($params->get('jobAgent', self::DEFAULT_AUTHORIZE_VIEW_LEVEL_JOBAGENT), $aViewLevels)
                    ){
                $session->set('com_elgergasia.canSeeContactInfo', true);
            }
            else {
                $session->set('com_elgergasia.canSeeContactInfo', false);
            }
        }
        return true; //$session->get('com_elgergasia.canSeeContactInfo');
    }
    
     /**
     * Gets basic state data from joomla.CommonUtils and add any extra data that are common to the aplication.
     * Extra data are also sanitated. These extra data are:
      * 1. idCustomer
      * 2. idProject
      * 3. lang
      * 
     * @param JInput $input the input object to use use for reading request.
      * if no input given gets the default JInput from the application object.
     */
    public static function getBasicStateData(JInput $input = null) {
        if ($input == null) {
            $input = JFactory::getApplication()->input;
        }
                    
        $request =  CommonUtils::getBasicStateData($input);
        $request['idHospital'] = $input->getInt('idHospital',0);
        //$request['idProject'] = $input->getInt('idProject',0);
        //$request['idProjectState'] = $input->getInt('idProjectState',0);
        $request['lang'] =  $input->getWord('lang', self::COMPONENT_URL_LOCALE);
        //$request['typeview'] = $input->getWord('typeview','');
       // $request['idStep'] = $input->getInt('idStep',0);
        $input->set('basicData', $request);
        return $request;
    }
    
    public static function authorsedForAgent($retTo, $msg, $msgType='error') {
         if(!self::canSeeContactInfo()) {
            JFactory::getApplication()->redirect($retTo, $msg, $msgType);
        }
    }
    
    
        
    
}    



?>
