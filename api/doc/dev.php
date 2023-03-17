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
    <li><?=__link('#blogs_get', 'GET /api/dev/blog/{id}', is_internal: false)?></li>
    <li><?=__link('#tasks_list', 'GET /api/dev/tasks', is_internal: false)?></li>
  </ul>

</div>

<hr id="blogs_list">

<div class="width_50 padding_top bigpadding_bot">

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
      "id": string,
      "published_on": string,
      "title_en": string,
      "title_fr": string
    },
  ]
}</pre>

</div>

<hr id="blogs_get">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/dev/blog/{id}
  </h4>

  <p>
    <?=__('api_dev_blogs_get_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">id</span> - int<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_dev_blogs_get_id')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "blog": {
    "id": string,
    "published_on": string,
    "title_en": string,
    "title_fr": string,
    "contents_en": string,
    "contents_fr": string
  }
}</pre>

</div>

<hr id="tasks_list">

<div class="width_50 padding_top">

  <h4>
    GET /api/dev/tasks
  </h4>

  <p>
    <?=__('api_dev_tasks_list_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">open</span> - bool - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_dev_tasks_list_open')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">title_en</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_dev_tasks_list_title_en')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">title_fr</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_dev_tasks_list_title_fr')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">reporter_id</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_dev_tasks_list_reporter')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "tasks": [
    {
      "id": string,
      "status": string,
      "title_en": string,
      "title_fr": string,
      "category": {
        "id": string,
        "name_en": string,
        "name_fr": string
      },
      "milestone": {
        "id": string,
        "name_en": string,
        "name_fr": string
      },
      "created_at": {
        "datetime": string,
        "timezone": string
      },
      "solved_at": {
        "datetime": string,
        "timezone": string
      },
      "opened_by": {
        "user_id": string,
        "username": string
      }
    },
  ]
}</pre>


<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }