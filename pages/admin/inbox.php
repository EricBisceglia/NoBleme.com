<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
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

// Extra CSS
$css = array('admin');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//




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

  <div class="admin_mail_border admin_mail_left_panel">
    &nbsp;
  </div>

  <div class="admin_mail_right_panel">

    <div class="admin_mail_border admin_mail_search">
      <label class="admin_mail_search_label"><?=__('admin_mail_list_search')?></label>
      <input class="table_search indiv" value="">
    </div>

    <?php for($i = 0; $i < 50; $i++) { ?>
    <?php if($i < 3) { ?>
    <div class="admin_mail_border admin_mail_right_entry pointer">
      <span class="text_red glow bold">Unread message title</span><br>
      <a>Sender</a> - 10 days ago
    </div>
    <?php } else { ?>
    <div class="admin_mail_border admin_mail_right_entry pointer">
      Twenty five characters MM<br>
      <a>Sender</a> - 10 days ago
    </div>
    <?php } ?>
    <?php } ?>

  </div>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }