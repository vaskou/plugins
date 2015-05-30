<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class exists checking
 */
if (!class_exists('plgSystemdonorwizredirects')) {

    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgSystemdonorwizredirects extends JPlugin {

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgSystemdonorwizredirects(& $subject, $config) {
            parent::__construct($subject, $config);
        }

        /**
         * This event is triggered after the framework has loaded and the application initialise method has been called.
         */
        public function onAfterRoute() {
			
			$app = JFactory::getApplication();
			
			//Check if we are in frontend
			if(!$app->isSite())
				return;
			
			//Check if user is Root
			$user = JFactory::getUser();
			$isRoot = $user->get('isRoot');
			
			if($isRoot)
				return;
			
			$option = JRequest::getVar('option');
			$view = JRequest::getVar('view');
			$task = JRequest::getVar('task');
			
			$redirects = $this -> redirectsSettings();

			if( isset($redirects[$option][$view][$task])){
			
				$app -> redirect($redirects[$option][$view][$task]);
				return;
			
			}
				
		
			
        }
		
		private function redirectsSettings(){
			
			$redirects = array();
			
			$error404 = JRoute::_('index.php?option=com_donorwiz&view=error&Itemid=394') ;
			
			//Login register redirects
			$return =  base64_encode ( JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard', true )->id ) );
			$login = JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&return='.$return);
			$register = JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&mode=register&return='.$return);
			
			//Jomsocial-------------------------------------------------------
			//$redirects['com_community'][''][''] = JURI::root();
			//$redirects['com_community']['profile'][''] = JURI::root();
			$redirects['com_community']['profile']['editPage'] = JURI::root();
			//$redirects['com_community']['profile']['preferences'] = JURI::root();
			//$redirects['com_community']['profile']['privacy'] = JURI::root();
			//$redirects['com_community']['profile']['linkVideo'] = JURI::root();
			$redirects['com_community']['multiprofile']['changeprofile'] = JRoute::_('index.php?option=com_community&view=profile&task=edit&Itemid=111');
			
			$redirects['com_community']['register']['register'] = $register;
			$redirects['com_community']['register'][''] = $register ;
			
			//$redirects['com_community']['groups']['mygroups'] = JURI::root();
			
			$redirects['com_users']['login'][''] = $login;
			$redirects['com_users']['registration'][''] = $register;
			$redirects['com_users']['remind'][''] = $error404;

			
			return $redirects;
			
		}
    }
}