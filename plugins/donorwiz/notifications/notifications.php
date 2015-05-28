<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class exists checking
 */
if (!class_exists('plgDonorwiznotifications')) {

    /**
     * Plugin entrypoint
     * @link http://docs.joomla.org/Plugin/Events/System
     */
    class plgDonorwiznotifications extends JPlugin {

        /**
         * Construct method
         * @param type $subject
         * @param type $config
         */
        function plgDonorwiznotifications(& $subject, $config) {
			
			JFactory::getLanguage()->load( 'plg_donorwiz_notifications');
			JPlugin::loadLanguage ( 'plg_community_donorwizstream', JPATH_SITE );
			
            parent::__construct($subject, $config);
        }

		/**
        * This event is triggered after a successful donation
        */
        public function onDonationSuccess( $payment ) {
			
			$app = JFactory::getApplication();
			
			//Check if we are in frontend
			if(!$app->isSite())
				return;
			
			//Notify Donor
			
			$donorwizMail = new DonorwizMail();
			$beneficiary = JFactory::getUser( $payment -> beneficiary_id );

			$mailParams = array();
			$mailParams['subject'] = JText::_('PLG_DONORWIZ_NOTIFICATIONS_DONATIONS_EMAIL_DONOR_SUCCESS_SUBJECT') ;
			$mailParams['recipient'] = $payment->email;
			$mailParams['isHTML'] = true;
			$mailParams['layout'] = 'success_donor';
			$mailParams['layout_path'] = JPATH_ROOT .'/plugins/donorwiz/notifications/layouts/emails/donations';
			$mailParams['layout_params'] = array( 'amount' => $payment -> amount , 'beneficiary' => $beneficiary -> name );
			
			$donorwizMail -> sendMail( $mailParams ) ;
			
			//Notify Beneficiary
			
			$donorwizMail = new DonorwizMail();
			$mailParams = array();
			$mailParams['subject'] = JText::_('PLG_DONORWIZ_NOTIFICATIONS_DONATIONS_EMAIL_BENEFICIARY_SUCCESS_SUBJECT') ;
			$mailParams['recipient'] = $beneficiary->email;
			$mailParams['isHTML'] = true;
			$mailParams['layout'] = 'success_beneficiary';
			$mailParams['layout_path'] = JPATH_ROOT .'/plugins/donorwiz/notifications/layouts/emails/donations';
			$mailParams['layout_params'] = array( 'amount' => $payment -> amount , 'donor' => $payment -> fname.' '.$payment -> lname );

			$donorwizMail -> sendMail( $mailParams ) ;
			
			
			//Add activity stream
			$isAnonymous = ( $payment -> created_by == 0 ) ? true : false ;
			$actor = ( $isAnonymous == true) ? $beneficiary -> id :  $payment -> created_by ;
			$target =  ( $isAnonymous == true ) ? 0 : $beneficiary -> id ;
			$content = JText::sprintf('PLG_DONORWIZSTREAM_DONATION_NEW_CONTENT', $beneficiary -> id , $beneficiary -> name );
			$anonymous = ( $isAnonymous == true ) ? 'Anonymous' : '' ;
			$activity = 'donorwizstream.'.__FUNCTION__.$anonymous;
			$this->addDonorwizActivity( $actor, $target , $content , $activity );

		}
			
			
		/**
        * This event is triggered after a response status is created or updated
        */
        public function onOpportunityResponseUpdate( $data , $isnew ) {

			$app = JFactory::getApplication();
			
			//Check if we are in frontend
			if(!$app->isSite())
				return;

			//Check if response is Trashed, then do nothing
			if( $data ["state"] == "-2")
				return;
			
			//Notify the Beneficiary -------------------------------------------------------------------------------------------------
			//Get opportunity from user state
			$opportunity = JFactory::getApplication()->getUserState('com_dw_opportunities.opportunity.id'.$data['opportunity_id']);

			$donorwizMail = new DonorwizMail();
			$mailParams = array();
			$mailParams['subject'] = $opportunity->title.': '.JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_NEW_RESPONSE_NOTIFICATION_SUBJECT');
			$mailParams['recipient'] = JFactory::getUser( intval ( $opportunity -> created_by ) ) -> email;
			$mailParams['isHTML'] = true;
			$mailParams['layout'] = 'notify_beneficiary';
			$mailParams['layout_path'] = JPATH_ROOT .'/plugins/donorwiz/notifications/layouts/emails/opportunities_responses';
			$mailParams['layout_params'] = array( 'opportunity_title' => $opportunity->title ,'opportunity_id' => $opportunity->id , 'response_message' => $data['message']  );

			$donorwizMail -> sendMail( $mailParams ) ;
			
			//Add activity stream
			if( $isnew == true ){
				$actor = $data ["created_by"];
				$target =  $opportunity -> created_by ;
				$content = JText::_('PLG_DONORWIZSTREAM_OPPORTUNITY_RESPONSE_NEW_CONTENT').'<a href="'.JRoute::_('index.php?option=com_dw_opportunities&view=dwopportunity&Itemid=261&id='. $opportunity->id).'">'.$opportunity->title.'</a>';
				$activity = 'donorwizstream.'.__FUNCTION__;
				$this->addDonorwizActivity( $actor, $target , $content , $activity );
			}
		}
		
        /**
         * This event is triggered after a response status is created or updated
         */
        public function onOpportunityResponseStatusUpdate( $data ) {
			
			$app = JFactory::getApplication();
			
			//Check if we are in frontend
			if(!$app->isSite())
				return;

			//Notify the donor -------------------------------------------------------------------------------------------------
			$parameters = ( isset ( $data['parameters'] ) ) ? json_decode ( $data['parameters'] ) : null ;
			
			//Check if he should be notified by email.
			$notify = ( isset ( $parameters->notify ) && $parameters -> notify =='1' ) ? true : null ;
			
			if( $notify )
			{
				//Get response from user state
				$response = JFactory::getApplication()->getUserState('com_dw_opportunities.opportunity_response.id'.$data['response_id'] );
				//Get opportunity from user state
				$opportunity = JFactory::getApplication()->getUserState('com_dw_opportunities.opportunity.id'.$response -> opportunity_id);
		
				$donorwizMail = new DonorwizMail();
				$mailParams = array();
				$mailParams['subject'] = $opportunity->title.': '.JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_STATUSES_NEW_RESPONSE_STATUS_NOTIFICATION_SUBJECT');
				$mailParams['recipient'] = JFactory::getUser( $response -> created_by ) -> email;
				$mailParams['isHTML'] = true;
				$mailParams['layout'] = 'notify_donor';
				$mailParams['layout_path'] = JPATH_ROOT .'/plugins/donorwiz/notifications/layouts/emails/opportunities_responses_statuses';
				$mailParams['layout_params'] = array( 'status' => $data['status'] , 'opportunity_title' => $opportunity->title  );

				$donorwizMail -> sendMail( $mailParams ) ;
			}
			
			
        }
		
		private function addDonorwizActivity( $actor, $target , $content , $activity ){
			
			$act            = new stdClass();
			$act->cmd 		= $activity;
			$act->actor 	= $actor;
			$act->target 	= $target;
			$act->title		= '';
			
			
			$actorLink = '<a class="cStream-Author" href="' .CUrlHelper::userLink(CFactory::getUser($actor)->id).'">'.CFactory::getUser($actor)->getDisplayName().'</a>';
			if( $target!=0 ){
				$targetLink = '<a class="cStream-Author" href="' .CUrlHelper::userLink(CFactory::getUser($target)->id).'">'.CFactory::getUser($target)->getDisplayName().'</a>';
			}
		
			if ( $activity == 'donorwizstream.onOpportunityResponseUpdate' ){
				$act->title = JText::sprintf('PLG_DONORWIZSTREAM_OPPORTUNITY_RESPONSE_NEW_HEADLINE', $actorLink , $targetLink );
			}
			if ( $activity == 'donorwizstream.onDonationSuccess' ){
				$act->title = JText::sprintf('PLG_DONORWIZSTREAM_DONATION_NEW_HEADLINE', $actorLink , $targetLink );
			}		
			if ( $activity == 'donorwizstream.onDonationSuccessAnonymous' ){
				$act->title = JText::sprintf('PLG_DONORWIZSTREAM_DONATION_ANONYMOUS_NEW_HEADLINE', $actorLink );
			}
			
			$act->content 	= $content;
			// Pay close attention on this
			$act->app 	= $activity;
			$act->access  = 0; // 0 = Public; 20 = Site members; 30 = Friends Only; 40 = Only Me
			$act->cid       = 0;
			 
			CActivityStream::add($act);
		}
    }
}