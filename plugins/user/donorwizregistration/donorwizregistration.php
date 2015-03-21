<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * Class exists checking
 */
if (!class_exists('plgUserdonorwizregistration')) {

    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgUserdonorwizregistration extends JPlugin {

		
        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgUserdonorwizregistration(& $subject, $config) {
            parent::__construct($subject, $config);
			
			
        }
		
		//autologin user after
		public function onUserAfterSave($user, $isnew, $success, $msg)
		{
			$app = JFactory::getApplication();
			
			if($app->isSite() && $isnew)
			{
				include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
			
				//$this -> loginUser($user);
				
				$this -> saveFirstAndLastName($user);
								
				$this -> setUserProfileTypeAndPoints( CFactory::getUser($user['id']) , 1 , 0 );
				
				$return_url=$app->input->get('return',false,'BASE64');
				
				$data=array('user'=>$user,'return_url'=>$return_url);
				
				$app->setUserState('com_donorwiz.registration.login', $data);

			}		
	
		}
		
		private function saveFirstAndLastName($user)
		{
			
			$jinput = JFactory::getApplication()->input;
			
			$profileModel = CFactory::getModel('profile');
			
			$fullname = array();
			
			$jform=$jinput->get('jform',false,'ARRAY');
			
			if($jform){
				$fullname[$profileModel->getFieldId('FIELD_GIVENNAME')] = $jform['jsfirstname'];
				$fullname[$profileModel->getFieldId('FIELD_FAMILYNAME')] = $jform['jslastname'];
			}else{
				$name=explode(' ',$user['name']);
				
				$fullname[$profileModel->getFieldId('FIELD_GIVENNAME')] = $name[0];
				$fullname[$profileModel->getFieldId('FIELD_FAMILYNAME')] = $name[1];
			}

			$profileModel->saveProfile( $user['id'], $fullname);		

		}
		
		private function setUserProfileTypeAndPoints( $cuser , $profileTypeID , $points )
		{
			
			$cuser->_profile_id = $profileTypeID;
			$cuser->_points += $points;
			$cuser->save();
		
		}

    }
}