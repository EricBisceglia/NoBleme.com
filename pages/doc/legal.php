<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/doc.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/doc/legal";
$page_title_en    = "Legal notice";
$page_title_fr    = "Mentions légales";
$page_description = "Clarifications on the legal aspects of NoBleme and its contents";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_legal')?>
  </h1>

  <p>
    <?=__('legal_intro')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('legal_responsibility_title')?>
  </h5>

  <p>
    <?=__('legal_responsibility_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('legal_user_content_title')?>
  </h5>

  <p>
    <?=__('legal_user_content_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('legal_fair_title')?>
  </h5>

  <p>
    <?=__('legal_fair_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('legal_source_title')?>
  </h5>

  <p>
    <?=__('legal_source_body')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('legal_conclusion_title')?>
  </h5>

  <p>
    <?=__('legal_conclusion_body')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }