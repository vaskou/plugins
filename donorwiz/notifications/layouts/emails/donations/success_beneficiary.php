<?php

defined('JPATH_BASE') or die;

JFactory::getLanguage()->load( 'plg_donorwiz_notifications');

$amount=$displayData['amount'];
$donor=$displayData['donor'];

?>

<?php echo JLayoutHelper::render( 'header' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>

<div class="main" style="background-color:#ff0f83;color:#ffffff;padding:10px 0 10px 0;">
<div style="max-width:480px;margin:0 auto;padding:10px;">
<h2 style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_DONATIONS_EMAIL_BENEFICIARY_CONGRATULATIONS');?></h2>
<p style="text-align:center;"><?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_DONATIONS_EMAIL_BENEFICIARY_JUST_RECEIVED');?> <?php echo $amount;?> <?php echo JText::_('PLG_DONORWIZ_NOTIFICATIONS_DONATIONS_EMAIL_BENEFICIARY_FROM');?> <?php echo $donor;?></p>
</div>
</div>

<?php echo JLayoutHelper::render( 'footer' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>