<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';        # Core
include_once './../../actions/compendium.act.php';  # Actions
include_once './../../lang/compendium.lang.php';    # Translations
include_once './../../inc/functions_time.inc.php';  # Time management
include_once './../../inc/bbcodes.inc.php';         # BBCodes

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/page_social_media";
$page_title_en    = "Compendium: Social media";
$page_title_fr    = "Compendium : Réseaux sociaux";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page contents

// Fetch the page's id
$compendium_page_id = (int)form_fetch_element('id', request_type: 'GET');

// Fetch the page's data
$compendium_page_data = compendium_pages_get( page_id:  $compendium_page_id ,
                                              no_loops: false               );

// Redirect if the page doesn't exist
if(!$compendium_page_data)
  exit(header('Location: '.$path.'pages/compendium/page_list_admin'));

// Redirect if the page isn't published
if($compendium_page_data['draft'])
  exit(header('Location: '.$path.'pages/compendium/'.$compendium_page_data['url_raw']));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50 bigpadding_bot">

  <h1><?=__link('pages/compendium/'.$compendium_page_data['url_raw'], __('compendium_social_media_title'), 'noglow')?></h1>

  <div class="padding_top">
    <label for="compendium_social_media_reddit_1"><?=__('compendium_social_media_reddit')?></label>
    <pre id="compendium_social_media_reddit_url" onclick="to_clipboard('', 'compendium_social_media_reddit_url', 1);"><?=$GLOBALS['website_url'].'pages/compendium/'.$compendium_page_data['url_raw']?></pre>
    <div class="tinypadding_top">
      <pre id="compendium_social_media_reddit_2" onclick="to_clipboard('', 'compendium_social_media_reddit_2', 1);"><?=__('compendium_social_media_reddit_2', preset_values: array($compendium_page_data['title_en'], $compendium_page_data['title_fr']))?></pre>
    </div>
    <div class="tinypadding_top">
      <pre id="compendium_social_media_reddit_1" onclick="to_clipboard('', 'compendium_social_media_reddit_1', 1);"><?=$compendium_page_data['title_en']?></pre>
    </div>
  </div>

  <div class="padding_top">
    <label for="compendium_social_media_toot_1"><?=__('compendium_social_media_mastodon')?></label>
    <pre id="compendium_social_media_toot_2" onclick="to_clipboard('', 'compendium_social_media_toot_2', 1);"><?=__('compendium_social_media_toot_2', preset_values: array($compendium_page_data['title_en'], $compendium_page_data['title_fr'], string_change_case($compendium_page_data['type_en'], 'lowercase'), $GLOBALS['website_url'].'pages/compendium/'.$compendium_page_data['url_raw']))?></pre>
    <div class="tinypadding_top">
      <pre id="compendium_social_media_toot_1" onclick="to_clipboard('', 'compendium_social_media_toot_1', 1);"><?=__('compendium_social_media_toot_1', preset_values: array($compendium_page_data['title_en'], string_change_case($compendium_page_data['type_en'], 'lowercase'), $GLOBALS['website_url'].'pages/compendium/'.$compendium_page_data['url_raw']))?></pre>
    </div>
    <div class="tinypadding_top">
      <pre id="compendium_social_media_toot_4" onclick="to_clipboard('', 'compendium_social_media_toot_4', 1);"><?=__('compendium_social_media_toot_4', preset_values: array($compendium_page_data['title_en'], $compendium_page_data['title_fr'], $GLOBALS['website_url'].'pages/compendium/'.$compendium_page_data['url_raw']))?></pre>
    </div>
    <div class="tinypadding_top">
      <pre id="compendium_social_media_toot_3" onclick="to_clipboard('', 'compendium_social_media_toot_3', 1);"><?=__('compendium_social_media_toot_3', preset_values: array($compendium_page_data['title_en'], $GLOBALS['website_url'].'pages/compendium/'.$compendium_page_data['url_raw']))?></pre>
    </div>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }