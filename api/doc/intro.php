<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/intro";
$page_title_en    = "API";
$page_title_fr    = "API";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['intro'] = true;

// Extra CSS & JS
$css  = array('api');
$js   = array('api/doc');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /*******/ include './../../inc/header.inc.php'; /*******/ include './menu.php'; ?>

<div class="width_50 padding_top">

  <h1>
    <?=__('api_title')?>
  </h1>

  <h5>
    <?=__('api_intro_menu')?>
  </h5>

  <p>
    <?=__('api_intro_body_1')?>
  </p>

  <p>
    <?=__('api_intro_body_2')?>
  </p>

  <h5 class="bigpadding_top">
    <?=__('api_intro_usage_title')?>
  </h5>

  <p>
    <?=__('api_intro_usage_body_1', preset_values: array($GLOBALS['website_url']))?>
  </p>

  <p>
    <?=__('api_intro_usage_body_2')?>
  </p>

  <p>
    <?=__('api_intro_usage_body_3')?>
  </p>

  <p>
    <?=__('api_intro_usage_body_4')?>
  </p>

  <p>
    <?=__('api_intro_usage_body_5')?>
  </p>


</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }