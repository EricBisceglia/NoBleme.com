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
$page_url         = "pages/quotes/reject";
$page_title_en    = "Reject a quote";
$page_title_fr    = "Rejeter une citation";
$page_description = "Reject a quote proposal before it can make it to NoBleme's quote database";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Reject the quote

// Fetch the quote's ID
$quote_id = form_fetch_element('id', 0, request_type: 'GET');

// Trigger the rejection if requested
if(isset($_POST['quotes_reject_submit']))
{
  // Reject the quote
  $reject_error = quotes_reject(  $quote_id                                 ,
                                  form_fetch_element('quote_reject_reason') );

  // Redirect to the quote if the rejection was successful
  if(!isset($reject_error))
    exit(header("Location: ".$path."pages/quotes/".$quote_id));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the quote's contents

// Fetch the quote data
$quote_data = quotes_get($quote_id);

// Redirect to the quotes list if it the selected quote does not exist, is deleted, or is approved
if(!$quote_data || $quote_data['deleted'] || $quote_data['validated'])
  header("Location: ".$path."pages/quotes/list");

// Get the submitter's language
$submitter_language = user_get_language($quote_data['submitter_id']);
$submitter_language = ($submitter_language == 'FR') ? __('french') : __('english');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link('pages/quotes/'.$quote_id, __('quotes_id', preset_values: array($quote_id)), 'noglow')?>
  </h1>

  <h5 class="padding_bot">
    <?=__('quotes_reject_subtitle')?>
  </h5>

  <form method="POST">
    <fieldset>

      <label for="quote_reject_submitted"><?=__('quotes_edit_submitted')?></label>
      <input class="indiv" type="text" id="quote_reject_submitted" name="quote_reject_submitted" value="<?=$quote_data['submitter']?>" disabled>

      <div class="smallpadding_top">
        <label for="quote_reject_language"><?=__('quotes_reject_language')?></label>
        <input class="indiv" type="text" id="quote_reject_language" name="quote_reject_language" value="<?=string_change_case($submitter_language, 'initials')?>" disabled>
      </div>

      <div class="smallpadding_top">
        <label for="quote_reject_reason"><?=__('quotes_reject_reason')?></label>
        <input class="indiv" type="text" id="quote_reject_reason" name="quote_reject_reason" value="">
      </div>

      <?php if(isset($reject_error) && $reject_error) { ?>
      <div class="smallpadding_top">
        <h5 class="align_center red text_white uppercase">
          <?=$reject_error?>
        </h5>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="quotes_reject_submit" value="<?=__('quotes_reject_submit')?>">
      </div>

    </fieldset>
  </form>

  <div class="monospace bigpadding_top align_justify break_words">
    <?=$quote_data['body_full']?>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }