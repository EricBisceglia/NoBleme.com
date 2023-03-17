<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/dev";
$page_title_en    = "API: Development tools";
$page_title_fr    = "API : Outils de développement";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['dev'] = true;

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
    <?=__('api_dev_menu')?>
  </h4>

  <p>
    <?=__('api_dev_intro')?>
  </p>

  <ul class="tinypadding_top">
    <li><?=__link('#blogs_list', 'GET /api/dev/blogs', is_internal: false)?></li>
  </ul>

</div>

<hr id="blogs_list">

<div class="width_50 padding_top">

  <h4>
    GET /api/dev/blogs
  </h4>

  <p>
    <?=__('api_dev_blogs_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "blogs": [
    {
      "blog": {
        "id": string,
        "published_on": string,
        "title_en": string,
        "title_fr": string
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