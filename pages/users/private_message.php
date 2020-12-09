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

<div class="smallpadding_top smallpadding_bot">
  <?=$private_message_data['body']?>
</div>

<?php } ?>