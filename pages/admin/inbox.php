<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../actions/messages.act.php';    # Actions
include_once './../../lang/messages.lang.php';      # Translations

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
$js   = array('admin/messages', 'common/toggle', 'common/editor', 'common/preview');
$css  = array('admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the admin mail

$admin_mail = admin_mail_list(form_fetch_element('admin_mail_search', ''));




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

  <div class="admin_mail_border admin_mail_left_panel spaced" id="admin_mail_main_panel">
    <h2 class="hugepadding_top align_center uppercase spaced">
      <?=__('admin_mail_list_select')?>
    </h2>
  </div>

  <div class="admin_mail_right_panel">

    <?php if(!$admin_mail['rows']) { ?>
    <div class="admin_mail_border admin_mail_right_entry text_red bold glow bigger">
      <?=__('admin_mail_list_none')?>
    </div>
    <?php } else { ?>
    <div class="admin_mail_border admin_mail_search">
      <label class="admin_mail_search_label"><?=__('admin_mail_list_search')?></label>
      <input class="table_search indiv" name="admin_mail_search" id="admin_mail_search" value="" onkeyup="admin_mail_search();">
    </div>
    <?php } ?>

    <div id="admin_mail_message_list">
      <?php } ?>
      <?php for($i = 0; $i < $admin_mail['rows']; $i++) { ?>
      <?php if($admin_mail[$i]['top_level']) { ?>
      <div class="admin_mail_border admin_mail_right_entry pointer" onclick="admin_mail_display(<?=$admin_mail[$i]['id']?>);">

        <?php if(!$admin_mail[$i]['read'] && !$admin_mail[$i]['recipient']) { ?>
        <span class="text_red glow bold" id="admin_mail_list_<?=$admin_mail[$i]['id']?>"><?=$admin_mail[$i]['title']?></span><br>
        <?php } else { ?>
          <span id="admin_mail_list_<?=$admin_mail[$i]['id']?>"><?=$admin_mail[$i]['title']?></span><br>
        <?php } ?>
        <span class="bold glow text_light"><?=$admin_mail[$i]['sender']?></span> - <?=$admin_mail[$i]['sent']?>

      </div>
      <?php } ?>
      <?php } ?>
      <?php if(!page_is_fetched_dynamically()) { ?>
    </div>

  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }