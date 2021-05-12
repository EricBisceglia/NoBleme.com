<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../lang/integrations.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/social/others";
$page_title_en    = "NoBleme on the Internet";
$page_title_fr    = "NoBleme sur Internet";
$page_description = "Internet communities officially affiliated with NoBleme.com";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('social_others_title')?>
  </h1>

  <h5>
    <?=__('social_others_subtitle')?>
  </h5>

  <p>
    <?=__('social_others_body_1')?>
  </p>

  <p>
    <?=__('social_others_body_2')?>
  </p>

  <p>
    <?=__('social_others_body_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }