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
			
			if ( $isnew == true)
				$this->donorwizStreamAddNewResponse( $data , $opportunity );
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
		
		private function donorwizStreamAddNewResponse( $data , $opportunity ){
			
			$act            = new stdClass();
			$act->cmd 		= 'donorwizstream.newresponse';
			$act->actor 	= JFactory::getUser( ) -> email -> id;
			$act->target 	= $opportunity - created_by;
			$act->title 	= 'title';
			$act->content 	= 'Your activity content';
			// Pay close attention on this
			$act->app 	= 'donorwizstream.newresponse';
			$act->access  = 0; // 0 = Public; 20 = Site members; 30 = Friends Only; 40 = Only Me
			$act->cid       = 0;
			 
			CActivityStream::add($act);
		}
    }
}