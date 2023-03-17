<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/api.lang.php';     # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "api/doc/irc";
$page_title_en    = "API: IRC chat";
$page_title_fr    = "API : Chat IRC";
$page_description = "NoBleme's API allows you to interact with the website without using a browser.";

// API doc menu selection
$api_doc_menu['irc'] = true;

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
    <?=__('api_irc_menu')?>
  </h4>

  <p>
    <?=__('api_irc_intro')?>
  </p>

  <ul class="tinypadding_top">
    <li><?=__link('#list_channels', 'GET /api/irc/channels', is_internal: false)?></li>
  </ul>

</div>

<hr id="list_channels">

<div class="width_50 padding_top">

  <h4>
    GET /api/irc/channels
  </h4>

  <p>
    <?=__('api_irc_channel_list_summary')?>
  </p>

  <h6 class="bigpadding_top smallpadding_bot">
    <?=__('api_response_schema')?>
  </h6>

  <pre>{
  "channels": [
    {
      "name": string,
      "type": string,
      "description_en": string,
      "description_fr": string,
      "languages_spoken": {
        "english": bool,
        "french": bool
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