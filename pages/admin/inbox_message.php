<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../inc/bbcodes.inc.php';             # BBCodes
include_once './../../inc/functions_time.inc.php';      # Time management
include_once './../../actions/users/messages.act.php';  # Actions
include_once './../../lang/users/messages.lang.php';    # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_moderators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the message contents

$admin_mail = admin_mail_get(form_fetch_element('admin_mail_display_message', 0));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if(isset($admin_mail['error'])) { ?>

<h2 class="hugepadding_top align_center uppercase">
  <?=__('error').__(':', spaces_after: 1).$admin_mail['error']?>
</h2>

<?php } else { ?>

<h5 class="padding_top indented">
  <?=$admin_mail['title']?>
  <img class="pointer icon admin_mail_icon valign_middle spaced_left" src="<?=$path?>img/icons/edit.svg" alt="E" title="<?=__('admin_mail_chain_reply')?>">
  <?php if($is_admin) { ?>
  <img class="pointer icon admin_mail_icon valign_middle spaced_left" src="<?=$path?>img/icons/delete.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>">
  <?php } ?>
</h5>

<div class="indented padding_bot"><?=__('users_message_sent_by', preset_values: array($admin_mail['sender_id'], $admin_mail['sender'], $admin_mail['sent_at']))?></div>

<div class="spaced padding_bot"><?=$admin_mail['body']?></div>

<?php if(isset($admin_mail['parents'])) { ?>
<?php for($i = 0; $i < $admin_mail['parents']; $i++) { ?>

<hr>

<h5 class="padding_top indented">
  <?=$admin_mail['title']?>
  <?php if($is_admin && !$admin_mail[$i]['sender_id']) { ?>
  <img class="pointer icon admin_mail_icon valign_middle spaced_left" src="<?=$path?>img/icons/delete.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>">
  <?php } ?>
</h5>

<div class="indented padding_bot"><?=__('users_message_chain_sent', preset_values: array($admin_mail[$i]['sender'], $admin_mail[$i]['sent_at'], $admin_mail[$i]['sent_time']))?></div>

<div class="spaced padding_bot"><?=$admin_mail[$i]['body']?></div>

<?php } ?>
<?php } ?>

<?php } ?>