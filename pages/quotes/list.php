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

// Check if unvalidated or soft deleted quotes should be shown
$quotes_waitlist  = form_fetch_element('waiting', element_exists: true, request_type: 'GET');
$quotes_waitlist  = (form_fetch_element('quotes_waitlist')) ? true : $quotes_waitlist;
$quotes_deleted   = form_fetch_element('deleted', element_exists: true, request_type: 'GET');
$quotes_deleted   = (form_fetch_element('quotes_deleted')) ? true : $quotes_deleted;

// Prepare the search settings
$quotes_search = array( 'lang_en' => $quotes_settings['show_en']  ,
                        'lang_fr' => $quotes_settings['show_fr']  );

// Fetch relevant quotes
$quotes_list = quotes_list( $quotes_search    ,
                            $quote_id         ,
                            $quotes_waitlist  ,
                            $quotes_deleted   );

// Redirect if a single quote is requested but doesn't exist
if($quote_id && !$quotes_list['rows'])
  exit(header("Location: ./list"));

// Change the page data in case of single quote
if($quote_id)
{
  $page_url         = "pages/quotes/".$quotes_list[0]['id'];
  $page_title_en    = "Quote #".$quote_id;
  $page_title_fr    = "Citation #".$quote_id;
  $page_description = $quotes_list[0]['summary'];

  // If the quote is deleted or not validated yet, it shouldn't show up in who's online
  if($is_admin && ($quotes_list[0]['deleted'] || !$quotes_list[0]['validated']))
    $hidden_activity = 1;
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
    <?=__icon('add', alt: '+', title: __('quotes_add'), href: "pages/quotes/submit")?>
    <?php if($is_admin) { ?>
    <?php if($quotes_waitlist) { ?>
    <?=__icon('refresh', alt: 'R', title: __('quotes_back'), href: "pages/quotes/list")?>
    <?php } if(!$quotes_waitlist) { ?>
    <?=__icon('user_confirm', alt: 'O', title: __('quotes_waiting'), href: "pages/quotes/list?waiting")?>
    <?php } if($quotes_deleted) { ?>
      <?=__icon('refresh', alt: 'R', title: __('quotes_back'), href: "pages/quotes/list")?>
    <?php } if(!$quotes_deleted) { ?>
    <?=__icon('delete', alt: 'X', title: __('quotes_deleted'), href: "pages/quotes/list?deleted")?>
    <?php } ?>
    <?php } ?>
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

    <input type="hidden" id="quotes_waitlist" value="<?=$quotes_waitlist?>">
    <input type="hidden" id="quotes_deleted" value="<?=$quotes_deleted?>">

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
      <?php if($is_admin && $quotes_waitlist) { ?>
      <?=__('quotes_count_waitlist', $quotes_list['rows'], preset_values: array($quotes_list['rows']))?>
      <?php } else if($is_admin && $quotes_deleted) { ?>
      <?=__('quotes_count_deleted', $quotes_list['rows'], preset_values: array($quotes_list['rows']))?>
      <?php } else if($quotes_list['rows']) { ?>
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
      <?=__link('pages/quotes/list', __('quotes_id', preset_values: array($quotes_list[$i]['id'])), "noglow")?>
      <?php } else { ?>
      <?=__link('pages/quotes/list', __('quotes_random'), "noglow")?>
      <?php } ?>
    </h1>

    <?php if($quotes_list[$i]['nsfw'] && !$adult_settings) { ?>
    <p class="padding_bot">
      <?=__('quotes_blur')?>
    </p>
    <?php } ?>

    <?php if($is_admin && $quotes_list[0]['deleted']) { ?>
    <div class="red text_white bold uppercase align_center">
      <?=__('quotes_is_deleted')?>
    </div>
    <?php } if($is_admin && !$quotes_list[0]['validated']) { ?>
    <div class="red text_white bold uppercase align_center">
      <?=__('quotes_unapproved')?>
    </div>
    <?php } ?>

    <?php } ?>

    <div class="monospace padding_top padding_bot align_justify break_words" id="quote_body_<?=$quotes_list[$i]['id']?>">

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
        <?=__link('pages/users/'.$quotes_list[$i]['linked_ids'][$j], $quotes_list[$i]['linked_nicks'][$j])?>
        <?php } ?>
        <?php } ?>

        <?php if($is_admin) { ?>
        <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials', href: 'pages/quotes/edit?id='.$quotes_list[$i]['id'])?>
        <?=__icon('user', is_small: true, alt: 'U', title: __('quotes_users'), href: 'pages/quotes/users?id='.$quotes_list[$i]['id'])?>
        <?php if($quotes_waitlist || !$quotes_list[$i]['validated']) { ?>
        <?=__icon('user_confirm', is_small: true, alt: 'Y', title: __('quotes_approve'), onclick: "quotes_approve(".$quotes_list[$i]['id'].", '".__('quotes_approve_confirm')."');")?>
        <?=__icon('user_delete', is_small: true, alt: 'N', title: __('quotes_deny'), href: 'pages/quotes/reject?id='.$quotes_list[$i]['id'])?>
        <?=__icon('delete', is_small: true, alt: 'X', title: __('quotes_hard_delete'), onclick: "quotes_delete(".$quotes_list[$i]['id'].", '".__('quotes_delete_hard')."', 1);")?>
        <?php } else { ?>
        <?php if($quotes_deleted || $quotes_list[$i]['deleted']) { ?>
        <?=__icon('refresh', is_small: true, alt: 'R', title: __('quotes_restore'), onclick: "quotes_restore(".$quotes_list[$i]['id'].");")?>
        <?=__icon('delete', is_small: true, alt: 'X', title: __('quotes_hard_delete'), onclick: "quotes_delete(".$quotes_list[$i]['id'].", '".__('quotes_delete_hard')."', 1);")?>
        <?php } else { ?>
        <?=__icon('delete', is_small: true, alt: 'X', title: __('delete'), title_case: 'initials', onclick: 'quotes_delete('.$quotes_list[$i]['id'].');')?>
        <?php } ?>
        <?php } ?>
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