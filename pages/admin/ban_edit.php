<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/users/user.act.php';  # User management
include_once './../../actions/admin/ban.act.php';   # Ban management
include_once './../../lang/admin.lang.php';         # Translations

// Limit page access rights
user_restrict_to_moderators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/ban_edit";
$page_title_en    = "Edit a ban";
$page_title_fr    = "Modifier un bannissement";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Restrict the page to existing and currently banned users

// Sanitize the user id
$user_id = sanitize_input('GET', 'user', 'int', 0, 0);

// Exit if the user id is malformed
if(!$user_id)
  error_page(__('admin_ban_edit_error_id'));

// Exit if the user does not exist
if(!database_entry_exists('users', 'id', $user_id))
  error_page(__('admin_ban_edit_error_id'));

// Exit if the user is not banned
if(!user_is_banned($user_id))
  error_page(__('admin_ban_edit_error_id'));

// Exit if a non administrator is trying to edit a moderator
if(user_is_moderator($user_id) && !user_is_administrator())
  error_page(__('admin_ban_edit_error_rights'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modify an existing ban

if(isset($_POST['admin_ban_edit_submit']))
{
  admin_ban_user_edit(  user_get_id()                                   ,
                        $user_id                                        ,
                        form_fetch_element('admin_ban_edit_length')     ,
                        form_fetch_element('admin_ban_edit_reason_en')  ,
                        form_fetch_element('admin_ban_edit_reason_fr')  ,
                        $lang                                           ,
                        $path                                           );
  exit(header("Location: ./ban#active"));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch data about the user's ban

// Get the user's nickname and some details regarding the ban
$ban_username = user_get_nickname($user_id);
$ban_details  = user_ban_details($lang, $user_id);

// Hide the french ban justification in the english interface
$admin_ban_hide_french = ($lang == 'EN') ? ' hidden' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center">
    <?=__('admin_ban_edit_title')?>
  </h1>

</div>

<div class="width_30 bigpadding_top">

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_ban_edit_nick"><?=__('admin_ban_add_nickname')?></label>
        <input class="indiv" type="text" id="admin_ban_edit_nick" name="admin_ban_edit_nick" value="<?=$ban_username?>" disabled>
      </div>

      <div class="padding_bot">
        <label for="admin_ban_edit_length_old"><?=__('admin_ban_edit_duration')?></label>
        <input class="indiv" type="text" id="admin_ban_edit_length_old" name="admin_ban_edit_length_old" value="<?=$ban_details['time_left']?>" disabled>
      </div>

      <div class="smallpadding_bot<?=$admin_ban_hide_french?>">
        <label for="admin_ban_edit_reason_fr"><?=__('admin_ban_add_reason_fr')?></label>
        <input class="indiv" type="text" id="admin_ban_edit_reason_fr" name="admin_ban_edit_reason_fr" value="<?=$ban_details['ban_r_fr']?>">
      </div>

      <div class="smallpadding_bot">
        <label for="admin_ban_edit_reason_en"><?=__('admin_ban_add_reason_en')?></label>
        <input class="indiv" type="text" id="admin_ban_edit_reason_en" name="admin_ban_edit_reason_en" value="<?=$ban_details['ban_r_en']?>">
      </div>

      <div class="padding_bot">
        <label for="admin_ban_edit_length"><?=__('admin_ban_edit_reban')?></label>
        <select class="indiv" id="admin_ban_edit_length" name="admin_ban_edit_length">
          <option value="0">&nbsp;</option>
          <option value="1"><?=__('admin_ban_add_duration_1d')?></option>
          <option value="7"><?=__('admin_ban_add_duration_1w')?></option>
          <option value="30"><?=__('admin_ban_add_duration_1m')?></option>
          <option value="365"><?=__('admin_ban_add_duration_1y')?></option>
          <option value="3650"><?=__('admin_ban_add_duration_10y')?></option>
        </select>
      </div>

      <input type="submit" name="admin_ban_edit_submit" value="<?=__('admin_ban_edit_submit')?>">

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }
