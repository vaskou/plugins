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
		
		//General parameters
		$fb_tags['og:url'] = $twt_tags['twitter:url'] = JFactory::getURI()->toString();
		$fb_tags['og:title'] = $twt_tags['twitter:title'] = $document->title ;
		$fb_tags['og:description'] = $twt_tags['twitter:description'] = $this->params->get('description');
		$fb_tags['og:image'] = $twt_tags['twitter:image'] = ( strpos($this->params->get('image'),'http') === 0 ) ? $this->params->get('image') : JUri::base().$this->params->get('image');
		
		//Facebook parameters
		$fb_tags['og:site_name'] = $this->params->get('og_site_name');
		$fb_tags['fb:app_id'] = $this->params->get('fb_app_id');
		$fb_tags['og:type'] = $this->params->get('og_type');
		$fb_tags['og:locale'] = str_replace ( '-' , '_' ,JFactory::getLanguage()->getTag() );
		
		//Twitter parameters
		$twt_tags['twitter:card'] = $this->params->get('twt_type');
		$twt_tags['twitter:site'] = $this->params->get('twt_site');
		
		//Facebook tags
		if( isset($document->_custom) ){
			foreach($fb_tags as $key=>$tag){
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
		
		//Twitter tags
		if( isset($document->_metaTags) ){
			foreach($twt_tags as $key=>$tag){
				$tag_exists=false;
				foreach($document->_metaTags['standard'] as $m_key=>$m_tag){
					if( $key == $m_key ){
						$tag_exists=true;
						break;
					}
				}
				if(!$tag_exists){
					if(!empty($tag)){
						$document->setMetaData($key,$tag);
					}
				}
			}
		}
		
    }
}