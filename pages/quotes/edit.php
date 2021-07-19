<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/quotes.act.php';  # Actions
include_once './../../lang/quotes.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/quotes/edit";
$page_title_en    = "Edit a quote";
$page_title_fr    = "Modifier une citation";
$page_description = "Edit the contents of an entry in NoBleme's quote database.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Edit the quote

// Fetch the quote's ID
$quote_id = form_fetch_element('id', 0, request_type: 'GET');

// Edit the quote if requested
if(isset($_POST['quote_edit_submit']))
{
  // Prepare the edited data
  $quote_edited_data = array( 'body'  => form_fetch_element('quotes_edit_body')                       ,
                              'date'  => form_fetch_element('quote_edit_date')                        ,
                              'lang'  => form_fetch_element('quote_edit_language')                    ,
                              'nsfw'  => form_fetch_element('quote_edit_nsfw', element_exists: true)  );

  // Update the quote
  quotes_edit(  $quote_id           ,
                $quote_edited_data  );

  // Redirect to the updated quote
  header("Location: ".$path."pages/quotes/".$quote_id);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the quote's contents

// Fetch the quote data
$quote_data = quotes_get($quote_id);

// Redirect to the quotes list if it the selected quote does not exist
if(!$quote_data)
  header("Location: ".$path."pages/quotes/list");

// Select the correct language option
$quote_lang_en = ($quote_data['lang'] == 'EN') ? ' selected' : '';
$quote_lang_fr = ($quote_data['lang'] == 'FR') ? ' selected' : '';

// Check the nsfw box when necessary
$quote_nsfw = ($quote_data['nsfw']) ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="padding_bot">
    <?=__link('pages/quotes/'.$quote_id, __('quotes_id', preset_values: array($quote_id)), 'noglow')?>
  </h1>

  <form method="POST">
    <fieldset>

      <label for="quote_edit_submitted"><?=__('quotes_edit_submitted')?></label>
      <input class="indiv" type="text" id="quote_edit_submitted" name="quote_edit_submitted" value="<?=$quote_data['submitter']?>" disabled>

      <div class="smallpadding_top">
        <label for="quotes_edit_body"><?=__('quotes_edit_body')?></label>
        <textarea id="quotes_edit_body" name="quotes_edit_body"><?=$quote_data['body']?></textarea>
      </div>

      <div class="smallpadding_top">
        <label for="quote_edit_date"><?=__('quotes_edit_date')?></label>
        <input class="indiv" type="text" id="quote_edit_date" name="quote_edit_date" value="<?=$quote_data['date']?>">
      </div>

      <div class="smallpadding_top">
        <label for="quote_edit_language"><?=__('quotes_edit_language')?></label>
        <select class="indiv align_left" id="quote_edit_language" name="quote_edit_language">
          <option value="EN"<?=$quote_lang_en?>><?=string_change_case(__('english'), 'initials')?></option>
          <option value="FR"<?=$quote_lang_fr?>><?=string_change_case(__('french'), 'initials')?></option>
        </select>
      </div>

      <div class="padding_top">
        <input type="checkbox" id="quote_edit_nsfw" name="quote_edit_nsfw"<?=$quote_nsfw?>>
        <label class="label_inline" for="quote_edit_nsfw"><?=__('quotes_edit_nsfw')?></label>
      </div>

      <div class="smallpadding_top">
        <input type="submit" name="quote_edit_submit" value="<?=__('quotes_edit_submit')?>">
      </div>

    </fieldset>
  </form>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }