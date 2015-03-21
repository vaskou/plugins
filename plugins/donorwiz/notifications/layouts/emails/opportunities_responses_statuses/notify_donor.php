<?php

defined('JPATH_BASE') or die;

JFactory::getLanguage()->load( 'plg_donorwiz_notifications');

$status=$displayData['status'];
$opportunity_title=$displayData['opportunity_title'];


?>

<?php echo JLayoutHelper::render( 'header' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>

<div class="main" style="background-color:#ff0f83;color:#ffffff;padding:10px 0 10px 0;">
<div style="max-width:480px;margin:0 auto;padding:10px;">
<p style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_STATUSES_NEW_RESPONSE_STATUS_NOTIFICATION_BODY');?></p>
<h2 style="text-align:center;"><?php echo $opportunity_title;?></h2>
<p style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_STATUSES_NEW_RESPONSE_STATUS_NOTIFICATION_'.$status);?></p>
</div>
</div>

<?php echo JLayoutHelper::render( 'footer' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>