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
        JPlugin::loadLanguage ( 'plg_community_donorwizstream', JPATH_SITE ); 
    	$actor = CFactory::getUser($act->actor);
        $actorLink = '<a class="cStream-Author" href="' .CUrlHelper::userLink($actor->id).'">'.$actor->getDisplayName().'</a>';
    	$stream    = new stdClass();
    	$stream->actor  = $actor;
    	$stream->headline = JText::sprintf('PLG_DONORWIZSTREAM_NEW_RESPONSE_HEADLINE', $actorLink );
    	$stream->message = 'Message';
    	return $stream;
	}
 
}

?>