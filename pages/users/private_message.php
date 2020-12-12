<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../inc/functions_time.inc.php';      # Time management
include_once './../../inc/bbcodes.inc.php';             # Text formatting
include_once './../../actions/users/messages.act.php';  # Actions
include_once './../../lang/users/messages.lang.php';    # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_users();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the requested private message

$private_message_data = private_message_get(form_fetch_element('private_message_id'));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

if(isset($private_message_data['error'])) { ?>

<h4 class="hugepadding_top hugepadding_bot uppercase align_center"><?=__('error').__(':', spaces_after: 1).$private_message_data['error']?></h4>

<?php } else { ?>

<h4 class="tinypadding_bot"><?=$private_message_data['title']?></h4>

<p class="nopadding_top smallpadding_bot">
  <?php if($private_message_data['sender']) { ?>
  <?=__('users_message_sent_by', preset_values: array('todo_link?id='.$private_message_data['sender_id'], $private_message_data['sender'], $private_message_data['sent_at']))?>
  <?php } else { ?>
  <?=__('users_message_system', preset_values: array($private_message_data['sent_at']))?>
  <?php } if ($private_message_data['read_at']) { ?>
  <br>
  <?=__('users_message_read', preset_values: array($private_message_data['read_at']))?>
  <?php } ?>
</p>

<hr>

<div class="private_message_buttons desktop">
  <div class="tinypadding_top tinypadding_bot flexcontainer">
    <?php if(!$private_message_data['self']) { ?>
    <div class="flex align_center">
      <button onclick="users_message_reply();"><?=__('users_message_reply')?></button>
    </div>
    <?php } ?>
    <div class="flex align_center">
      <button onclick="users_message_delete(<?=$private_message_data['id']?>, '<?=__('users_message_confirm')?>');"><?=__('users_message_delete')?></button>
    </div>
  </div>
</div>

<div class="private_message_buttons tinypadding_top tinypadding_bot mobile">
<?php if(!$private_message_data['self']) { ?>
  <div class="tinypadding_bot">
    <button onclick="users_message_reply();"><?=__('users_message_reply')?></button>
  </div>
  <?php } ?>
  <button onclick="users_message_delete(<?=$private_message_data['id']?>, '<?=__('users_message_confirm')?>');"><?=__('users_message_delete')?></button>
</div>

<div class="smallpadding_top hidden" id="private_message_reply">

  <form method="POST">
    <fieldset>

      <?php if(!$private_message_data['sender']) { ?>
      <div class="smallpadding_bot">
        <p class="nopadding"><?=__('users_message_reply_system')?></p>
      </div>
      <?php } ?>

      <label for="private_message_reply_body"><?=__('users_message_reply_title', preset_values: array(__link('pages/doc/bbcodes', __('bbcodes'), popup:true)))?></label>
      <div class="flexcontainer">
        <div style="flex:9">
          <textarea id="private_message_reply_body" name="private_message_reply_body"></textarea>
        </div>
        <div class="flex desktop">
          <?php
          $editor_line_break = 1;
          $editor_target_element = 'private_message_reply_body';
          include './../../inc/editor.inc.php';
          ?>
        </div>
      </div>

    </fieldset>
  </form>

  <div class="smallpadding_top smallpadding_bot">
    <button onclick="users_message_reply_send(<?=$private_message_data['id']?>);"><?=__('users_message_reply_send')?></button>
  </div>

</div>

<div class="smallpadding_bot smallpadding_top hidden" id="private_message_reply_return">
  &nbsp;
</div>

<hr>

<div class="smallpadding_top smallpadding_bot">
  <?=$private_message_data['body']?>
</div>

<?php } ?>