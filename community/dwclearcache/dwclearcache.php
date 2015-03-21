<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_ROOT.'/components/com_community/libraries/core.php');
			
if(!class_exists('plgCommunityDwClearCache')) {
	
	class plgCommunityDwClearCache extends CApplications {

	    public function plgCommunityDwClearCache(& $subject, $config) {
			
			parent::__construct($subject, $config);
			
	    }
		
		public function onAfterProfileUpdate($arrItems){
			$cache = JFactory::getCache('com_dw_donations','');
			$cache->setCaching(true);
			$cache->remove('data_array');
		}
		
	}
}
