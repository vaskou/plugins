<?php

defined('JPATH_BASE') or die;

JFactory::getLanguage()->load( 'plg_user_donorwizregistration');

$user=$displayData['user'];
$donor=$displayData['donor'];

?>

<?php echo JLayoutHelper::render( 'header' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>

<div class="main" style="background-color:#ffffff;color:#444444;padding:10px 0 10px 0;">
    <div style="max-width:480px;margin:0 auto;padding:10px;">
        <h2 style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_THANK_YOU_HEADER');?></h2>
        <p style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_THANK_YOU_TEXT');?></p>
    </div>
</div>

<div class="main" style="background-color:#ff0f83;color:#ffffff;padding:10px 0 10px 0;">
    <div style="max-width:480px;margin:0 auto;padding:10px;">
        <h2 style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_DONATE_HEADER');?></h2>
        <p style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_DONATE_TEXT');?></p>
        <p style="text-align:center;"><a href="<?php echo JURI::base().'donate';?>" style="color:#444444;background:#ffffff;padding:5px;text-decoration:none;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_DONATE_CTA');?><a></p>
    </div>
</div>

<div class="main" style="background-color:#ffffff;color:#444444;padding:10px 0 10px 0;">
    <div style="max-width:480px;margin:0 auto;padding:10px;">
        <h2 style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_VOLUNTEER_HEADER');?></h2>
        <p style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_VOLUNTEER_TEXT');?></p>
        <p style="text-align:center;"><a href="<?php echo JURI::base().'volunteer';?>" style="color:#ffffff;background:#ff0f83;padding:5px;text-decoration:none;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_VOLUNTEER_CTA');?><a></p>
    </div>
</div>

<div class="main" style="background-color:#ff0f83;color:#ffffff;padding:10px 0 10px 0;">
    <div style="max-width:480px;margin:0 auto;padding:10px;">
        <h2 style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_FEEDBACK_HEADER');?></h2>
        <p style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_FEEDBACK_TEXT');?></p>
        <p style="text-align:center;"><a href="<?php echo JURI::base().'contact';?>" style="color:#444444;background:#ffffff;padding:5px;text-decoration:none;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_FEEDBACK_CTA');?><a></p>
    </div>
</div>

<div class="main" style="background-color:#ffffff;color:#444444;padding:10px 0 10px 0;">
    <div style="max-width:480px;margin:0 auto;padding:10px;">
        <h2 style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_SOCIAL_HEADER');?></h2>
        <p style="text-align:center;"><?php echo JText::_('PLG_USER_DONORWIZREGISTRATION_WELCOME_EMAIL_SOCIAL_TEXT');?></p>
    </div>
</div>
<?php echo JLayoutHelper::render( 'social' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>
<?php echo JLayoutHelper::render( 'footer' , array() , JPATH_ROOT .'/components/com_donorwiz/layouts/mail/common' , null );?>