<?php

defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT .'/components/com_community/libraries/core.php';
 
class plgCommunityDonorwizstream extends CApplications
{
	var $name = "DONORwiz Stream";
	var $_name = 'DONORwiz Stream';
 
	function plgCommunityDonorwizstream(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}
    
    public function onCommunityStreamRender($act)
	{
        
		$actor = CFactory::getUser($act->actor);
		$stream    = new stdClass();
    	$stream->actor  = $actor;
    	$stream->message = $act->content;
		$stream->headline = $act->title;
		return $stream;
	}
 
}

?>