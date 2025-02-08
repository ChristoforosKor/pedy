<?php
/*------------------------------------------------------------------------
# com_elgpedy - e-logism 
# ------------------------------------------------------------------------
# author    e-logism
# copyright Copyright (C) 2013 e-logism.gr. All Rights Reserved.
# @license - GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.e-logism.gr

----------------------------------**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_COMPONENT_SITE . '/controllers/editsave.php';
use Joomla\CMS\Language\Text;																			
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
class ElgPedyControllerPersonelEditDelete extends EditSave 
{
	
	public function execute() 
	{		
		$this -> formData -> PersonelId = $this -> getInput() -> getInt('id', 0);
                                $rd = $this -> getInput() -> getInt('rd', 0);
                                if ( $this -> formData -> PersonelId === 0 || $rd === 0 ):
                                    throw new Exception( JText::_('COM_ELG_50001_NO_VALID_DATA_SUBMITED') );
                                else:
                                    $endDate = date_create_from_format('Ymd', $rd);
                                    if( $endDate === false):
                                        throw new Exception( JText::_('COM_ELG_50001_NO_VALID_DATA_SUBMITED') );
                                    else:
                                        $this -> formData -> EndDate = $endDate -> format('Y-m-d');
                                    endif;
		endif;
				
		$this -> state -> set('formData', $this -> formData);
		try {
                                    $this -> model -> setState( $this -> state);
                                    $msg = Text::_( 'COM_ELG_DELETE_SUCCESS' );
                                } catch (Exception $ex) {
                                    $msg = $ex ->getMessage();
                                }
                                $app =  Factory::getApplication();
                                $app -> enqueueMessage( $msg );
                                $redUrl = Route::_('index.php?option=com_elgpedy&view=personels&ItemId=' . $this->appData['Itemid'],  false);
		$app -> redirect($redUrl);
    }
}
