<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../inc/functions_time.inc.php';      # Time management
include_once './../../actions/users/messages.act.php';  # Actions
include_once './../../lang/users/messages.lang.php';    # Translations

// Limit page access rights
user_restrict_to_moderators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/admin/inbox";
$page_title_en    = "Administrative mail";
$page_title_fr    = "Courrier administratif";
$page_description = "Private message exchanges between users and the administrative team";

// Extra JS & CSS
$js   = array('admin/messages');
$css  = array('admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the admin mail

$admin_mail = admin_mail_list();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1>
    <?=__('submenu_admin_inbox')?>
  </h1>

  <p>
    <?=__('admin_mail_header')?>
  </p>

</div>

<div class="width_70 flexcontainer admin_mail_border admin_mail_container">

  <div class="admin_mail_border admin_mail_left_panel" id="admin_mail_main_panel">
    &nbsp;
  </div>

  <div class="admin_mail_right_panel">

    <div class="admin_mail_border admin_mail_search">
      <label class="admin_mail_search_label"><?=__('admin_mail_list_search')?></label>
      <input class="table_search indiv" value="">
    </div>

    <?php for($i = 0; $i < $admin_mail['rows']; $i++) { ?>
    <div class="admin_mail_border admin_mail_right_entry pointer" onclick="admin_mail_display(<?=$admin_mail[$i]['id']?>);">

      <?php if(!$admin_mail[$i]['read']) { ?>
      <span class="text_red glow bold" id="admin_mail_list_<?=$admin_mail[$i]['id']?>"><?=$admin_mail[$i]['title']?></span><br>
      <?php } else { ?>
        <span id="admin_mail_list_<?=$admin_mail[$i]['id']?>"><?=$admin_mail[$i]['title']?></span><br>
      <?php } ?>
      <span class="bold glow text_light"><?=$admin_mail[$i]['sender']?></span> - <?=$admin_mail[$i]['sent']?>

    </div>
    <?php } ?>

  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }