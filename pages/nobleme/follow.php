<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/nobleme.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/follow";
$page_title_en    = "Follow NoBleme";
$page_title_fr    = "Suivre NoBleme";
$page_description = "Follow NoBleme's activity within the website and over various social media platforms";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_follow')?>
  </h1>

  <h5 class="padding_top">
    <?=__('nobleme_follow_community_title')?>
  </h5>

  <p>
    <?=__('nobleme_follow_community_body_1')?>
  </p>

  <p>
    <?=__('nobleme_follow_community_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('nobleme_follow_activity_title')?>
  </h5>

  <p>
    <?=__('nobleme_follow_activity_body_1')?>
  </p>

  <p>
    <?=__('nobleme_follow_activity_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('nobleme_follow_social_title')?>
  </h5>

  <p>
    <?=__('nobleme_follow_social_body_1')?>
  </p>

  <p>
    <?=__('nobleme_follow_social_body_2')?>
  </p>

  <p>
    <?=__('nobleme_follow_social_body_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }