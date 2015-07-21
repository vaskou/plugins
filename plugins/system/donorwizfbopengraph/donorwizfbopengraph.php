<?php
/**
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */
 
defined('_JEXEC') or die;
 
class plgSystemDonorwizfbopengraph extends JPlugin
{

    public function onBeforeRender()
    {
		$app = JFactory::getApplication();
			
		//Check if we are in frontend
		if(!$app->isSite())
			return;
		
    	$document = JFactory::getDocument();
		
		$og_description=$this->params->get('og_description');
		$og_site_name=$this->params->get('og_site_name');
		$og_image=( strpos($this->params->get('og_image'),'http') === 0 ) ? $this->params->get('og_image') : JUri::base().$this->params->get('og_image');
		$fb_app_id=$this->params->get('fb_app_id');
		$og_type=$this->params->get('og_type');
		
		$tags['og:url']=JFactory::getURI()->toString();
		$tags['og:title']=$document->title ;
		$tags['og:description']=$og_description;
		$tags['og:site_name']=$og_site_name;
		$tags['og:image']=$og_image;
		$tags['fb:app_id']=$fb_app_id;
		$tags['og:type']=$og_type;
		$tags['og:locale']=str_replace ( '-' , '_' ,JFactory::getLanguage()->getTag() );
		
		//Basic
		if( isset($document->_custom) ){
			foreach($tags as $key=>$tag){
				$tag_exists=false;
				foreach($document->_custom as $c_tag){
					if( strpos($c_tag,$key) !== false ){
						$tag_exists=true;
						break;
					}
				}
				if(!$tag_exists){
					if(!empty($tag)){
						$document->addCustomTag('<meta property="'.$key.'" content="'.$tag.'" />');
					}
				}
			}
		}
		var_dump($document->_custom);
    }
}