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
    <li><?=__link('#pages_list', 'GET /api/compendium/pages', is_internal: false)?></li>
    <li><?=__link('#pages_get_id', 'GET /api/compendium/page/id/{id}', is_internal: false)?></li>
    <li><?=__link('#pages_get_url', 'GET /api/compendium/page/url/{url}', is_internal: false)?></li>
    <li><?=__link('#pages_get_random', 'GET /api/compendium/page/random', is_internal: false)?></li>
    <li><?=__link('#images_get_name', 'GET /api/compendium/image/{name}', is_internal: false)?></li>
    <li><?=__link('#categories_list', 'GET /api/compendium/categories', is_internal: false)?></li>
    <li><?=__link('#eras_list', 'GET /api/compendium/eras', is_internal: false)?></li>
    <li><?=__link('#types_list', 'GET /api/compendium/types', is_internal: false)?></li>
  </ul>

</div>

<hr id="pages_list">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/pages
  </h4>

  <p>
    <?=__('api_compendium_pages_list_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">sort</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_sort')?>
  </p>

  <ul class="tinypadding_bot">
  <li>
      <span class="bold">url</span> - <?=__('api_compendium_pages_list_sort_url')?>
    </li>
    <li>
      <span class="bold">appeared</span> - <?=__('api_compendium_pages_list_sort_app')?>
    </li>
    <li>
      <span class="bold">appeared_reverse</span> - <?=__('api_compendium_pages_list_sort_app_r')?>
    </li>
    <li>
      <span class="bold">peaked</span> - <?=__('api_compendium_pages_list_sort_peak')?>
    </li>
    <li>
      <span class="bold">peaked_reverse</span> - <?=__('api_compendium_pages_list_sort_peak_r')?>
    </li>
  </ul>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">include_redirections</span> - bool - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_redirections')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">exclude_nsfw</span> - bool - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_no_nsfw')?>
  </p>


  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">url</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_url')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">title_en</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_title_en')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">title_fr</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_title_fr')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">contents_en</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_contents_en')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">contents_fr</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_contents_fr')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">type</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_type')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">era</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_era')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">category</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_list_category')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "pages": [
    {
      "id": string,
      "url": string,
      "link": string,
      "redirects_to": {
        "target_is_a_page_url": bool,
        "url_en": string,
        "url_fr": string
      },
      "title_en": string,
      "title_fr": string,
      "content_warnings": {
        "title_is_nsfw": bool,
        "not_safe_for_work": bool,
        "offensive": bool,
        "gross": bool
      },
      "first_appeared_year": int,
      "first_appeared_month": int,
      "peak_popularity_year": int,
      "peak_popularity_month": int,
      "summary_en": string,
      "summary_fr": string,
      "type": {
        "id": string,
        "name_en": string,
        "name_fr": string
      }
    },
  ]
}</pre>

</div>

<hr id="pages_get_id">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/page/id/{id}
  </h4>

  <p>
    <?=__('api_compendium_pages_get_id_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">id</span> - int<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_get_id')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "page": {
    "id": string,
    "url": string,
    "link": string,
    "redirects_to": {
      "target_is_a_page_url": bool,
      "url_en": string,
      "url_fr": string
    },
    "title_en": string,
    "title_fr": string,
    "content_warnings": {
      "title_is_nsfw": bool,
      "not_safe_for_work": bool,
      "offensive": bool,
      "gross": bool
    },
    "first_appeared_year": int,
    "first_appeared_month": int,
    "peak_popularity_year": int,
    "peak_popularity_month": int,
    "summary_en": string,
    "summary_fr": string,
    "contents_en": string,
    "contents_fr": string,
    "type": {
      "id": string,
      "name_en": string,
      "name_fr": string
    },
    "era": {
      "id": string,
      "name_en": string,
      "name_fr": string
    },
    "categories": [
      {
        "id": string,
        "name_en": string,
        "name_fr": string
      },
    ],
    "created_at": {
      "datetime": string,
      "timezone": string
    },
    "last_updated_at": {
      "datetime": string,
      "timezone": string
    }
  }
}</pre>

</div>

<hr id="pages_get_url">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/page/url/{url}
  </h4>

  <p>
    <?=__('api_compendium_pages_get_url_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">url</span> - string<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_get_url')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "page": {
    "id": string,
    "url": string,
    "link": string,
    "redirects_to": {
      "target_is_a_page_url": bool,
      "url_en": string,
      "url_fr": string
    },
    "title_en": string,
    "title_fr": string,
    "content_warnings": {
      "title_is_nsfw": bool,
      "not_safe_for_work": bool,
      "offensive": bool,
      "gross": bool
    },
    "first_appeared_year": int,
    "first_appeared_month": int,
    "peak_popularity_year": int,
    "peak_popularity_month": int,
    "summary_en": string,
    "summary_fr": string,
    "contents_en": string,
    "contents_fr": string,
    "type": {
      "id": string,
      "name_en": string,
      "name_fr": string
    },
    "era": {
      "id": string,
      "name_en": string,
      "name_fr": string
    },
    "categories": [
      {
        "id": string,
        "name_en": string,
        "name_fr": string
      },
    ],
    "created_at": {
      "datetime": string,
      "timezone": string
    },
    "last_updated_at": {
      "datetime": string,
      "timezone": string
    }
  }
}</pre>

</div>

<hr id="pages_get_random">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/page/random
  </h4>

  <p>
    <?=__('api_compendium_pages_get_random_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">type</span> - int - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_get_random_type')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">language</span> - string - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_get_random_language')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">include_nsfw</span> - bool - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_get_random_nsfw')?>
  </p>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">include_redirections</span> - bool - <span class="italics"><?=__('api_optional')?></span><br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_pages_get_random_redirects')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "page": {
    "id": string,
    "url": string,
    "link": string,
    "redirects_to": {
      "target_is_a_page_url": bool,
      "url_en": string,
      "url_fr": string
    },
    "title_en": string,
    "title_fr": string,
    "content_warnings": {
      "title_is_nsfw": bool,
      "not_safe_for_work": bool,
      "offensive": bool,
      "gross": bool
    },
    "first_appeared_year": int,
    "first_appeared_month": int,
    "peak_popularity_year": int,
    "peak_popularity_month": int,
    "summary_en": string,
    "summary_fr": string,
    "contents_en": string,
    "contents_fr": string,
    "type": {
      "id": string,
      "name_en": string,
      "name_fr": string
    },
    "era": {
      "id": string,
      "name_en": string,
      "name_fr": string
    },
    "categories": [
      {
        "id": string,
        "name_en": string,
        "name_fr": string
      },
    ],
    "created_at": {
      "datetime": string,
      "timezone": string
    },
    "last_updated_at": {
      "datetime": string,
      "timezone": string
    }
  }
}</pre>

</div>

<hr id="images_get_name">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/image/{name}
  </h4>

  <p>
    <?=__('api_compendium_images_get_name_summary')?>
  </p>

  <h6 class="bigpadding_top">
    <?=__('api_parameters')?>
  </h6>

  <hr class="api_doc_parameters">

  <p class="tinypadding_top tinypadding_bot">
    <span class="bold underlined">name</span> - string<br>
  </p>

  <p class="nopadding_top tinypadding_bot">
    <?=__('api_compendium_images_get_name')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "image": {
    "name": string,
    "link": string,
    "caption_en": string,
    "caption_fr": string,
    "content_warnings": {
      "not_safe_for_work": bool,
      "offensive": bool,
      "gross": bool
    },
    "used_in_pages_en": [
      {
        "url": string,
        "name": string,
        "link": string
      },
    ],
    "used_in_pages_fr": [
      {
        "url": string,
        "name": string,
        "link": string
      },
    ]
  }
}</pre>

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
      "id": string,
      "name_en": string,
      "name_fr": string,
      "link": string,
      "pages_in_category": int,
      "description_en": string,
      "description_fr": string
    },
  ]
}</pre>

</div>

<hr id="eras_list">

<div class="width_50 padding_top bigpadding_bot">

  <h4>
    GET /api/compendium/eras
  </h4>

  <p>
    <?=__('api_compendium_eras_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "eras": [
    {
      "id": string,
      "name_en": string,
      "name_fr": string,
      "year_start": int,
      "year_end": int,
      "link": string,
      "pages_in_era": int,
      "description_en": string,
      "description_fr": string
    },
  ]
}</pre>

</div>

<hr id="types_list">

<div class="width_50 padding_top">

  <h4>
    GET /api/compendium/types
  </h4>

  <p>
    <?=__('api_compendium_types_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "types": [
    {
      "id": string,
      "name_en": string,
      "name_fr": string,
      "link": string,
      "pages_of_type": int,
      "description_en": string,
      "description_fr": string
    },
  ]
}</pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }