<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/meetups.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/meetups/organize";
$page_title_en    = "Organize a meetup";
$page_title_fr    = "Organiser une IRL";
$page_description = "How to organize a real life meetup between members of NoBleme's community.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('meetups_organize_title')?>
  </h1>

  <?php if($is_moderator) { ?>

  <h5>
    <?=__('meetups_organize_mod_title')?>
  </h5>

  <p class="padding_bot">
    <?=__('meetups_organize_mod_body_1')?>
  </p>

  <?php } ?>

  <h5>
    <?=__('meetups_organize_plan_title')?>
  </h5>

  <p>
    <?=__('meetups_organize_plan_body_1')?>
  </p>

  <p>
    <?=__('meetups_organize_plan_body_2')?>
  </p>

  <p>
    <?=__('meetups_organize_plan_body_3')?>
  </p>

  <p>
    <?=__('meetups_organize_plan_body_4')?>
  </p>

  <p>
    <?=__('meetups_organize_plan_body_5')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }