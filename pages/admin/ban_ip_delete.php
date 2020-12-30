<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/user.act.php';        # User management
include_once './../../actions/ban.act.php';         # Ban management
include_once './../../lang/admin/ban.lang.php';     # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/ban_ip_delete";
$page_title_en    = "Unban an IP";
$page_title_fr    = "Débannir une IP";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Restrict the page to existing and currently banned IPs

// Sanitize the ID
$ip_ban_id = sanitize_input('GET', 'id', 'string', '');

// Exit if the ip ban does not exist
if(!database_row_exists('system_ip_bans', $ip_ban_id))
  error_page(__('admin_ban_edit_error_ip'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Delete an existing ban

if(isset($_POST['admin_ipban_delete_submit']))
{
  admin_ip_ban_delete(  $ip_ban_id                                          ,
                        user_get_id()                                       ,
                        form_fetch_element('admin_ipban_delete_reason_en')  ,
                        form_fetch_element('admin_ipban_delete_reason_fr')  );
  exit(header("Location: ./ban#active"));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch data about the IP ban

// Get the user's username and some details regarding the ban
$ban_details = admin_ip_ban_get($ip_ban_id);

// Hide the french unban justification in the english interface
$admin_ban_hide_french = ($lang == 'EN') ? ' hidden' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="align_center">
    <?=__('admin_ban_delete_title_ip')?>
  </h1>

</div>

<div class="width_30 bigpadding_top">

  <form method="POST">
    <fieldset>

      <div class="smallpadding_bot">
        <label for="admin_ipban_delete_nick"><?=__('admin_ban_delete_ip')?></label>
        <input class="indiv" type="text" id="admin_ipban_delete_nick" name="admin_ipban_delete_nick" value="<?=$ban_details['ip_address']?>" disabled>
      </div>

      <div class="smallpadding_bot">
        <label for="admin_ipban_delete_length"><?=__('admin_ban_edit_duration')?></label>
        <input class="indiv" type="text" id="admin_ipban_delete_length" name="admin_ipban_delete_length" value="<?=$ban_details['time_left']?>" disabled>
      </div>

      <?php if($ban_details['ban_reason']) { ?>
      <div class="padding_bot">
        <label for="admin_ipban_delete_reason"><?=__('admin_ban_delete_ban_reason')?></label>
        <input class="indiv" type="text" id="admin_ipban_delete_reason" name="admin_ipban_delete_reason" value="<?=$ban_details['ban_reason']?>" disabled>
      </div>
      <?php } ?>

      <div class="smallpadding_bot<?=$admin_ban_hide_french?>">
        <label for="admin_ipban_delete_reason_fr"><?=__('admin_ban_delete_unban_reason_ip_fr')?></label>
        <input class="indiv" type="text" id="admin_ipban_delete_reason_fr" name="admin_ipban_delete_reason_fr" value="">
      </div>

      <div class="padding_bot">
        <label for="admin_ipban_delete_reason_en"><?=__('admin_ban_delete_unban_reason_ip_en')?></label>
        <input class="indiv" type="text" id="admin_ipban_delete_reason_en" name="admin_ipban_delete_reason_en" value="">
      </div>

      <input type="submit" name="admin_ipban_delete_submit" value="<?=__('admin_ban_delete_ip_submit')?>">

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }
