<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';      # Core
include_once './../../inc/bbcodes.inc.php';       # BBCodes
include_once './../../actions/messages.act.php';  # Actions
include_once './../../lang/messages.lang.php';    # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/messages/write";
$page_title_en    = "Private message";
$page_title_fr    = "Message privé";
$page_description = "Write a private message to another website user.";

// Extra JS
$js = array('common/editor', 'common/preview', 'common/toggle', 'messages/messages', 'users/autocomplete_username');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Send a private message

// Fetch the form elements
$private_message_recipient  = form_fetch_element('private_message_recipient');
$private_message_title      = form_fetch_element('private_message_title');
$private_message_body       = form_fetch_element('private_message_body');

// Prepare the message preview
$private_message_hidden     = ($private_message_body) ? '' : ' hidden';
$private_message_preview    = bbcodes(sanitize_output(form_fetch_element('private_message_body', ''), true));

// Send the message
if(isset($_POST['private_message_send']))
{
  $private_message_error = private_message_write( $private_message_recipient  ,
                                                  $private_message_title      ,
                                                  $private_message_body       );

  // Redirect to the outbox if the message was successfully sent
  if(!$private_message_error)
    exit(header("Location: ./outbox"));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_user_pms_write')?>
  </h1>

  <p>
    <?=__('users_message_intro')?>
  </p>

  <form method="POST" class="padding_top">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="private_message_recipient"><?=__('users_message_form_recipient')?></label>
        <input type="text" class="indiv" id="private_message_recipient" name="private_message_recipient" value="<?=$private_message_recipient?>" autocomplete="off" list="private_message_user_list" onkeyup="autocomplete_username('private_message_recipient', 'private_message_user_list_parent', './../common/autocomplete_username', 'private_message_user_list', 'normal');">
      </div>
      <div id="private_message_user_list_parent">
        <datalist id="private_message_user_list">
          <option value=" ">&nbsp;</option>
        </datalist>
      </div>

      <div class="smallpadding_bot">
        <label for="private_message_title"><?=__('users_message_form_title')?></label>
        <input type="text" class="indiv" id="private_message_title" name="private_message_title" maxlength="25" value="<?=$private_message_title?>">
      </div>

      <div class="smallpadding_bot">
        <label for="private_message_body"><?=__('users_message_form_body', preset_values: array(__link('pages/doc/bbcodes', __('bbcodes'), popup:true)))?></label>
          <?php
          $editor_target_element  = 'private_message_body';
          $preview_output         = 'private_message_preview';
          $preview_path           = $path;
          include './../../inc/editor.inc.php';
          ?>
        <textarea id="private_message_body" name="private_message_body" onkeyup="users_message_preview()"><?=$private_message_body?></textarea>
      </div>

      <?php if(isset($private_message_error)) { ?>
      <div class="smallpadding_bot">
        <div class="red text_white uppercase bold spaced">
          <?=__('error').__(':', spaces_after: 1).$private_message_error?>
        </div>
      </div>
      <?php } ?>

      <input type="submit" name="private_message_send" value="<?=__('users_message_form_send')?>">

    </fieldset>
  </form>

  <div class="bigpadding_top<?=$private_message_hidden?>" id="private_message_preview_container">
    <label class="smallpadding_bot"><?=__('users_message_preview_reply')?></label>
    <div id="private_message_preview">
      <?=$private_message_preview?>
    </div>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }