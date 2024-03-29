<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/meetups";
$page_title_en    = "API: Meetups";
$page_title_fr    = "API : Rencontres IRL";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['meetups'] = true;

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
    <?=__('api_meetups_menu')?>
  </h4>

  <p>
    <?=__('api_meetups_intro')?>
  </p>

  <ul class="tinypadding_top">
    <li><?=__link('#list', 'GET /api/meetups', is_internal: false)?></li>
    <li><?=__link('#get', 'GET /api/meetup/{id}', is_internal: false)?></li>
  </ul>

</div>

<hr id="list">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/meetups
  </h4>

  <p>
    <?=__('api_meetups_list_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">user_id</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_meetups_list_user')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">language</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_meetups_list_language')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">year</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_meetups_list_year')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">location</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_meetups_list_location')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">attendees</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_meetups_list_attendees')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "meetups": [
    {
      "id": string,
      "date": string,
      "location": string,
      "attendee_count": int,
      "link": string,
      "details_en": string,
      "details_fr": string,
      "languages_spoken": {
        "english": bool,
        "french": bool
      }
    },
  ]
}</pre>

</div>

<hr id="get">

<div class="width_50 padding_top">

  <h4>
    GET /api/meetup/{id}
  </h4>

  <p>
    <?=__('api_meetups_get_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">id</span> - int<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_meetups_get_id')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "meetup": {
    "id": string,
    "date": string,
    "location": string,
    "attendee_count": int,
    "link": string,
    "details_en": string,
    "details_fr": string,
    "languages_spoken": {
      "english": bool,
      "french": bool
    },
    "attendees": [
      {
        "user_id": string,
        "username": string,
        "confirmed_attending": bool,
        "extra_info_en": string,
        "extra_info_fr": string
      },
    ]
  }
}</pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }