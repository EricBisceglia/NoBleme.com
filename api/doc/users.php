<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/users";
$page_title_en    = "API: Users";
$page_title_fr    = "API : Comptes";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['users'] = true;

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
    <?=__('api_users_menu')?>
  </h4>

  <p>
    <?=__('api_users_intro')?>
  </p>

  <ul class="tinypadding_top">
    <li><?=__link('#list', 'GET /api/users', is_internal: false)?></li>
    <li><?=__link('#get', 'GET /api/user/{id}', is_internal: false)?></li>
    <li><?=__link('#getusername', 'GET /api/user/username/{username}', is_internal: false)?></li>
    <li><?=__link('#getrandom', 'GET /api/user/random', is_internal: false)?></li>
  </ul>

</div>

<hr id="list">

<div class="width_50 padding_top padding_bot">

  <h4>
    GET /api/users
  </h4>

  <p>
    <?=__('api_users_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "users": [
    {
      "user": {
        "id": string,
        "username": string,
        "deleted": bool,
        "banned": bool,
        "is_moderator": bool,
        "is_administrator": bool
      }
    },
  ]
}</pre>

</div>

<hr id="get">

<div class="width_50 padding_top padding_bot">

  <h4>
    GET /api/user/{id}
  </h4>

  <p>
    <?=__('api_users_get_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">id</span> - int<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_users_get_id')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "user": {
    "id": string,
    "username": string,
    "is_deleted": bool,
    "is_banned": bool,
    "is_moderator": bool,
    "is_administrator": bool,
    "profile": {
      "account_created_on": string,
      "speaks_english": bool,
      "speaks_french": bool,
      "birthday": string,
      "age": string,
      "location": string,
      "pronouns_en": string,
      "pronouns_fr": string,
      "custom_text_en": string,
      "custom_text_fr": string
    },
    "last_activity": {
      "datetime": string,
      "timezone": string,
      "page_link": string,
      "page_name_en": string,
      "page_name_fr": string
    },
    "stats": {
      "quotes_appeared_in": int,
      "quotes_submitted": int,
      "meetups_attended": int,
      "tasks_submitted": int
    },
    "ban": {
      "unban_datetime": string,
      "unban_timezone": string
    }
  }
}</pre>

</div>

<hr id="getusername">

<div class="width_50 padding_top padding_bot">

  <h4>
    GET /api/user/username/{username}
  </h4>

  <p>
    <?=__('api_users_get_username_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">username</span> - string<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_users_get_username')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "user": {
    "id": string,
    "username": string,
    "is_deleted": bool,
    "is_banned": bool,
    "is_moderator": bool,
    "is_administrator": bool,
    "profile": {
      "account_created_on": string,
      "speaks_english": bool,
      "speaks_french": bool,
      "birthday": string,
      "age": string,
      "location": string,
      "pronouns_en": string,
      "pronouns_fr": string,
      "custom_text_en": string,
      "custom_text_fr": string
    },
    "last_activity": {
      "datetime": string,
      "timezone": string,
      "page_link": string,
      "page_name_en": string,
      "page_name_fr": string
    },
    "stats": {
      "quotes_appeared_in": int,
      "quotes_submitted": int,
      "meetups_attended": int,
      "tasks_submitted": int
    },
    "ban": {
      "unban_datetime": string,
      "unban_timezone": string
    }
  }
}</pre>

</div>

<hr id="getrandom">

<div class="width_50 padding_top">

  <h4>
    GET /api/user/random
  </h4>

  <p>
    <?=__('api_users_random_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">id</span> - int<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_users_get_id')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "user": {
    "id": string,
    "username": string,
    "is_deleted": bool,
    "is_banned": bool,
    "is_moderator": bool,
    "is_administrator": bool,
    "profile": {
      "account_created_on": string,
      "speaks_english": bool,
      "speaks_french": bool,
      "birthday": string,
      "age": string,
      "location": string,
      "pronouns_en": string,
      "pronouns_fr": string,
      "custom_text_en": string,
      "custom_text_fr": string
    },
    "last_activity": {
      "datetime": string,
      "timezone": string,
      "page_link": string,
      "page_name_en": string,
      "page_name_fr": string
    },
    "stats": {
      "quotes_appeared_in": int,
      "quotes_submitted": int,
      "meetups_attended": int,
      "tasks_submitted": int
    },
    "ban": {
      "unban_datetime": string,
      "unban_timezone": string
    }
  }
}</pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }