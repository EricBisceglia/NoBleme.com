<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/quotes";
$page_title_en    = "API: Quotes";
$page_title_fr    = "API : Citations";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['quotes'] = true;

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
    <?=__('api_quotes_menu')?>
  </h4>

  <p>
    <?=__('api_quotes_intro')?>
  </p>

  <ul class="tinypadding_top">
    <li><?=__link('#list', 'GET /api/quotes', is_internal: false)?></li>
    <li><?=__link('#get', 'GET /api/quote/{id}', is_internal: false)?></li>
    <li><?=__link('#random', 'GET /api/quote/random', is_internal: false)?></li>
  </ul>

</div>

<hr id="list">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/quotes
  </h4>

  <p>
    <?=__('api_quotes_list_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">language</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_list_language')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">user_id</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_list_user_id')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">search</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_list_search')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">year</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_list_year')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">nsfw</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_list_nsfw')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "quotes": [
    {
      "quote": {
        "id": string,
        "is_nsfw": bool,
        "language": string,
        "link": string,
        "body": string,
        "added_at": {
          "datetime": string,
          "timezone": string
        },
        "users": [
          {
            "id": string,
            "username": string,
            "link": string
          },
        ]
      }
    }
  ]
}</pre>

</div>

<hr id="get">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/quote/{id}
  </h4>

  <p>
    <?=__('api_quotes_get_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">id</span> - int<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_get_id')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "quote": {
    "id": string,
    "is_nsfw": bool,
    "language": string,
    "link": string,
    "body": string,
    "added_at": {
      "datetime": string,
      "timezone": string
    }
  },
  "users": [
    {
      "id": string,
      "username": string,
      "link": string
    },
  ]
}</pre>

</div>

<hr id="random">

<div class="width_50 padding_top">

  <h4>
    GET /api/quote/random
  </h4>

  <p>
    <?=__('api_quotes_random_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">language</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_random_language')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">user_id</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_random_user_id')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">nsfw</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_random_nsfw')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">year</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_quotes_random_year')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "quote": {
    "id": string,
    "is_nsfw": bool,
    "language": string,
    "link": string,
    "body": string,
    "added_at": {
      "datetime": string,
      "timezone": string
    }
  },
  "users": [
    {
      "id": string,
      "username": string,
      "link": string
    },
  ]
}</pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }