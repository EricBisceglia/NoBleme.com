<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/doc.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/doc/privacy";
$page_title_en    = "Privacy policy";
$page_title_fr    = "Politique de confidentialité";
$page_description = "NoBleme's stance on privacy: User first, GDPR compliant, no third parties whatsoever";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_privacy')?>
  </h1>

  <p>
    <?=__('privacy_intro_1')?>
  </p>

  <p>
    <?=__('privacy_intro_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('submenu_nobleme_personal_data')?>
  </h5>

  <p>
    <?=__('privacy_data_1')?>
  </p>

  <p>
    <?=__('privacy_data_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('privacy_anonymity_title')?>
  </h5>

  <p>
    <?=__('privacy_anonymity_1')?>
  </p>

  <p>
    <?=__('privacy_anonymity_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('privacy_external_title')?>
  </h5>

  <p>
    <?=__('privacy_external_1')?>
  </p>

  <p>
    <?=__('privacy_external_2')?>
  </p>

  <p>
    <?=__('privacy_external_3')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('privacy_agreement_title')?>
  </h5>

  <p>
    <?=__('privacy_agreement_1')?>
  </p>

  <p>
    <?=__('privacy_agreement_2')?>
  </p>

  <p>
    <?=__('privacy_agreement_3')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('privacy_source_title')?>
  </h5>

  <p>
    <?=__('privacy_source_1')?>
  </p>

  <p>
    <?=__('privacy_source_2')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }