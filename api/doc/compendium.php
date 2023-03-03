<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/compendium";
$page_title_en    = "API: Compendium";
$page_title_fr    = "API : Compendium";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['compendium'] = true;

// Extra CSS & JS
$css  = array('api');
$js   = array('api/doc');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /*******/ include './../../inc/header.inc.php'; /*******/ include './menu.php'; ?>

<div class="width_50 padding_top bigpadding_bot">

  <h1>
    <?=__('api_title')?>
  </h1>

  <h4>
    <?=__('api_compendium_menu')?>
  </h4>

  <p>
    <?=__('api_compendium_intro')?>
  </p>

  <ul class="tinypadding_top">
    <li><?=__link('#categories_list', 'GET /api/compendium/categories', is_internal: false)?></li>
    <li><?=__link('#page_types_list', 'GET /api/compendium/page_types', is_internal: false)?></li>
  </ul>

</div>

<hr id="categories_list">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/categories
  </h4>

  <p>
    <?=__('api_compendium_categories_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "categories": [
    {
      "category": {
        "id": string,
        "name_en": string,
        "name_fr": string,
        "link": string,
        "pages_in_category": int
      }
    },
  ]
}</pre>

</div>

<hr id="page_types_list">

<div class="width_50 padding_top">

  <h4>
    GET /api/compendium/page_types
  </h4>

  <p>
    <?=__('api_compendium_page_types_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "page_types": [
    {
      "page_type": {
        "id": string,
        "name_en": string,
        "name_fr": string,
        "link": string,
        "pages_of_type": int
      }
    },
  ]
}</pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }