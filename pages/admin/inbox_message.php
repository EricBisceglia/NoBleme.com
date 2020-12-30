<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/bbcodes.inc.php';         # BBCodes
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/messages.act.php';    # Actions
include_once './../../lang/messages.lang.php';      # Translations

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

<div class="hidden" id="admin_mail_reply_container">

  <fieldset>

    <label class="admin_mail_search_label" for="admin_mail_reply_textarea"><?=__('admin_mail_reply_label')?></label>
    <?php
    $editor_target_element  = 'admin_mail_reply_textarea';
    $preview_output         = 'admin_mail_preview';
    $preview_path           = $path;
    include './../../inc/editor.inc.php';
    ?>
    <textarea id="admin_mail_reply_textarea" name="admin_mail_reply_textarea" onkeyup="admin_mail_reply_preview();"></textarea>

    <div class="smallpadding_top smallpadding_bot">
      <button onclick="admin_mail_reply_send(<?=$admin_mail['id']?>);"><?=__('users_message_reply_send')?></button>
    </div>

  </fieldset>

  <hr>

</div>

<div class="hidden" id="admin_mail_preview_container">

  <label class="smallpadding_top"><?=__('users_message_preview_reply')?></label>

  <div id="admin_mail_preview" class="smallpadding_top smallpadding_bot">
    &nbsp;
  </div>

  <hr>

</div>

<div id="admin_mail_message_<?=$admin_mail['id']?>">

  <h5 class="padding_top indented">
    <?=$admin_mail['title']?>
    <?php if($admin_mail['sender_id']) { ?>
    <img class="pointer icon admin_mail_icon valign_middle spaced_left" src="<?=$path?>img/icons/edit.svg" alt="E" title="<?=__('admin_mail_chain_reply')?>" id="admin_mail_reply_icon" onclick="admin_mail_reply();">
    <?php } if($is_admin) { ?>
    <img class="pointer icon admin_mail_icon valign_middle spaced_left" src="<?=$path?>img/icons/delete.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>" onclick="admin_mail_delete(<?=$admin_mail['id']?>, '<?=__('admin_mail_delete_confirm')?>');">
    <?php } ?>
  </h5>

  <div class="indented padding_bot">
    <?php if($admin_mail['sender_id']) { ?>
    <?=__('users_message_sent_by', preset_values: array($admin_mail['sender_id'], $admin_mail['sender'], $admin_mail['sent_at']))?><br>
    <?php } else { ?>
    <?=__('admin_mail_chain_system', preset_values: array($admin_mail['recipient_id'], $admin_mail['recipient'], $admin_mail['sender'], $admin_mail['sent_at']))?><br>
    <?php } if($admin_mail['read']) { ?>
    <?=__('users_message_read', preset_values: array($admin_mail['read_at']))?>
    <?php } else { ?>
    <span class="bold glow"><?=__('users_mail_chain_unread')?></span>
    <?php } ?>
  </div>

  <div class="hidden padding_bot" id="admin_mail_reply_return">
    &nbsp;
  </div>

  <div class="spaced padding_bot"><?=$admin_mail['body']?></div>

  <?php if($admin_mail['sender_id']) { ?>
  <div class="indented padding_bot">
    <button id="admin_mail_reply_button" onclick="admin_mail_reply();"><?=__('users_message_reply')?></button>
  </div>
  <?php } ?>

</div>

<?php if(isset($admin_mail['parents'])) { ?>
<?php for($i = 0; $i < $admin_mail['parents']; $i++) { ?>

<hr>

<div id="admin_mail_message_<?=$admin_mail[$i]['id']?>">

  <h5 class="padding_top indented">
    <?=$admin_mail['title']?>
    <?php if($is_admin) { ?>
    <img class="pointer icon admin_mail_icon valign_middle spaced_left" src="<?=$path?>img/icons/delete.svg" alt="X" title="<?=string_change_case(__('delete'), 'initials')?>" onclick="admin_mail_delete(<?=$admin_mail[$i]['id']?>, '<?=__('admin_mail_delete_confirm')?>');">
    <?php } ?>
  </h5>

  <div class="indented padding_bot"><?=__('users_message_chain_sent', preset_values: array($admin_mail[$i]['sender'], $admin_mail[$i]['sent_at'], $admin_mail[$i]['sent_time']))?></div>

  <div class="spaced padding_bot"><?=$admin_mail[$i]['body']?></div>

</div>

<?php } ?>
<?php } ?>

<?php } ?>