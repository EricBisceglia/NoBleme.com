<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/quotes.act.php';  # Actions
include_once './../../actions/account.act.php'; # Account settings
include_once './../../lang/quotes.lang.php';    # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/quotes/list";
$page_title_en    = "Quotes";
$page_title_fr    = "Citations";
$page_description = "Funny bits and pieces of NoBleme's life, immortalized in our quote database";

// Extra JS
$js = array('quotes/list');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update user quote settings

if(user_is_logged_in() && isset($_POST['quotes_lang_en']) && isset($_POST['quotes_lang_fr']))
{
  // Assemble the new values
  $quotes_lang  = ($_POST['quotes_lang_en'] == 'true') ? 'EN' : '';
  $quotes_lang .= ($_POST['quotes_lang_fr'] == 'true') ? 'FR' : '';

  // Update the user settings
  account_update_settings('quotes_languages', $quotes_lang);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the quotes

// Grab the user's adult content settings
$adult_settings = user_settings_nsfw();

// Grab the user's quotes settings
$quotes_settings = user_settings_quotes();

// Override the quote language settings if a new value is being submitted
if(isset($_POST['quotes_lang_en']))
  $quotes_settings['show_en'] = ($_POST['quotes_lang_en'] == 'true') ? 1 : 0;
if(isset($_POST['quotes_lang_fr']))
  $quotes_settings['show_fr'] = ($_POST['quotes_lang_fr'] == 'true') ? 1 : 0;

// Check if a single quote is being requested
$quote_id = form_fetch_element('id', request_type: 'GET');

// Check if a random quote is being requested
$quote_random = form_fetch_element('random', element_exists: true, request_type: 'GET');

// Fetch a random quote id based on the user's quotes language settings if needed
$quote_id = ($quote_random) ? quotes_get_random_id() : $quote_id;

// Prepare the search settings
$quotes_search = array( 'lang_en' => $quotes_settings['show_en']  ,
                        'lang_fr' => $quotes_settings['show_fr']  );

// Fetch relevant quotes
$quotes_list = quotes_list( $quotes_search, $quote_id );

// Redirect if a single quote is requested but doesn't exist
if($quote_id && !$quotes_list['rows'])
  exit(header("Location: ./"));

// Change the page data in case of single quote
if($quote_id)
{
  $page_url         = "pages/quotes/".$quotes_list[0]['id'];
  $page_title_en    = "Quote #".$quote_id;
  $page_title_fr    = "Citation #".$quote_id;
  $page_description = $quotes_list[0]['summary'];
}

// Prepare the language checkboxes
$lang_en_checked  = ($quotes_list['lang_en']) ? ' checked' : '';
$lang_fr_checked  = ($quotes_list['lang_fr']) ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <?php if(!$quote_id) { ?>
  <h1>
    <?=__('submenu_social_quotes')?>
  </h1>

  <h5>
    <?=__('quotes_subtitle')?>
  </h5>

  <p>
    <?=__('quotes_header_intro')?>
  </p>

  <?php if(!$adult_settings) { ?>
  <p>
    <?=__('quotes_header_blur')?>
  </p>
  <?php } ?>

  <fieldset class="padding_top">

    <label>
      <?php if(user_is_logged_in()) { ?>
      <?=__('quotes_languages')?>
      <?php } else { ?>
      <?=__('quotes_languages_guest')?>
      <?php } ?>
    </label>
    <input type="checkbox" id="quotes_lang_en" name="quotes_lang_en" onclick="quotes_set_language();"<?=$lang_en_checked?>>
    <label class="label_inline" for="quotes_lang_en"><?=string_change_case(__('english'), 'initials')?></label><br>
    <input type="checkbox" id="quotes_lang_fr" name="quotes_lang_fr" onclick="quotes_set_language();"<?=$lang_fr_checked?>>
    <label class="label_inline" for="quotes_lang_fr"><?=string_change_case(__('french'), 'initials')?></label>

  </fieldset>

  <div id="quotes_list_body">

    <?php } ?>

    <?php } if(!$quote_id) { ?>

    <h5 class="bigpadding_top">
      <?php if($quotes_list['rows']) { ?>
      <?=__('quotes_count', $quotes_list['rows'], preset_values: array($quotes_list['rows']))?>
      <?php } else { ?>
      <?=__('quotes_none')?>
      <?php } ?>
    </h5>

    <?php } ?>

    <?php for($i = 0; $i < $quotes_list['rows']; $i++) { ?>

    <?php if($quote_id) { ?>
    <h1 class="padding_bot">
      <?php if(!$quote_random) { ?>
      <?=__link('pages/quotes/list', __('quotes_id', preset_values: array($quotes_list[$i]['id'])), "noglow text_red")?>
      <?php } else { ?>
      <?=__link('pages/quotes/list', __('quotes_random'), "noglow text_red")?>
      <?php } ?>
    </h1>
    <?php if($quotes_list[$i]['nsfw'] && !$adult_settings) { ?>
    <p class="padding_bot">
      <?=__('quotes_blur')?>
    </p>
    <?php } ?>
    <?php } ?>

    <div class="monospace padding_top padding_bot align_justify break_words">

      <div class="tinypadding_bot">
        <span class="bold">
          <?php if(!$quote_id || $quote_random) { ?>
          <?=__link('pages/quotes/'.$quotes_list[$i]['id'], __('quotes_id', preset_values: array($quotes_list[$i]['id'])))?>
          <?php } ?>
          <?=$quotes_list[$i]['date']?>
        </span>

        <?php if($quotes_list[$i]['linked_count']) { ?>
        -
        <?php for($j = 0; $j < $quotes_list[$i]['linked_count']; $j++) { ?>
        <?=__link('todo_link?id='.$quotes_list[$i]['linked_ids'][$j], $quotes_list[$i]['linked_nicks'][$j])?>
        <?php } ?>
        <?php } ?>

        <?php if($is_admin) { ?>
        <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials');?>
        <?=__icon('delete', is_small: true, alt: 'X', title: __('delete'), title_case: 'initials');?>
        <?php } ?>
        <?php if($quote_random) { ?>
        <br>
        <?=__link('pages/quotes/random', __('quotes_another'))?>
        <?php } ?>
      </div>

      <?php if($quotes_list[$i]['nsfw'] && !$adult_settings) { ?>
      <span class="blur"><?=$quotes_list[$i]['body']?></span>
      <?php } else { ?>
      <?=$quotes_list[$i]['body']?>
      <?php } ?>

    </div>

    <?php } ?>

    <?php if(!page_is_fetched_dynamically()) { ?>

  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }