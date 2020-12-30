<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php';        # Core
include_once './inc/functions_time.inc.php';  # Time management
include_once './actions/user.act.php';        # Actions
include_once './lang/users/banned.lang.php';  # Translations

// Limit page access rights
user_restrict_to_banned();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "banned";
$page_title_en    = "Banned!";
$page_title_fr    = "Banni !";
$page_description = "Bad news: you have been banned from NoBleme.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch data related to the ban

$ban_details = user_ban_details();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /*********************************************/ include './inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="bigglow">
    <?=__('users_banned_title')?>
  </h1>

  <h5>
    <?=__('users_banned_subtitle')?>
  </h5>

  <p>
    <?=__('users_banned_header')?>
  </p>

  <p>
    <?=__('users_banned_header_evason')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('users_banned_details_title')?>
  </h5>

  <p>
    <?=__('users_banned_details_body', 0, 0, 0, array($ban_details['ban_start'], $ban_details['ban_length'], $ban_details['ban_end'], $ban_details['time_left']))?>
    <?php if($ban_details['ban_reason']) { ?>
    <?=__('users_banned_details_reason')?> <span class="bold text_red"><?=$ban_details['ban_reason']?></span>
    <?php } else { ?>
    <?=__('users_banned_details_no_reason')?>
    <?php } ?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('users_banned_coc_title')?>
  </h5>

  <?=__('coc')?>

  <h5 class="bigpadding_top">
    <?=__('users_banned_appeal_title')?>
  </h5>

  <p>
    <?=__('users_banned_appeal_explanation')?>
  </p>

  <p>
    <?=__('users_banned_appeal_instructions')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/***********************************************************************************/ include './inc/footer.inc.php'; }