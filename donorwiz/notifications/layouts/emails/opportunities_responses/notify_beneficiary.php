<?php

defined('JPATH_BASE') or die;

JFactory::getLanguage()->load( 'plg_donorwiz_notifications');

$opportunity_title=$displayData['opportunity_title'];
$opportunity_id=$displayData['opportunity_id'];
$response_message=$displayData['response_message'];


?>

<?php echo JLayoutHelper::render( 'header' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>

<div class="main" style="background-color:#φφφφφφ;color:#444444;padding:10px 0 10px 0;">
<div style="max-width:480px;margin:0 auto;padding:10px;">
<h2 style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_NEW_RESPONSE_NOTIFICATION_CONGRATULATIONS');?></h2>
<p style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_NEW_RESPONSE_NOTIFICATION_BODY');?></p>
</div>
</div>

<div class="main" style="background-color:#ff0f83;color:#ffffff;padding:10px 0 10px 0;">
<div style="max-width:480px;margin:0 auto;padding:10px;">
<h2 style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_NEW_RESPONSE_NOTIFICATION_VOLUNTEERS_WROTE');?></h2>
<p style="text-align:center;font-style: italic;">"<?php echo $response_message;?>"</p>
<p style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_NEW_RESPONSE_NOTIFICATION_LINK');?> <a href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=dashboard&layout=dwopportunityvolunteers&Itemid=298&id='.$opportunity_id); ?>""><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_OPPORTUNITIES_RESPONSES_NEW_RESPONSE_NOTIFICATION_HERE');?></a></p>

</div>
</div>

<?php echo JLayoutHelper::render( 'footer' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>

