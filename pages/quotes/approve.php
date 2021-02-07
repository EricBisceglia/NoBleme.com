<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/quotes.act.php';  # Actions
include_once './../../lang/quotes.lang.php';    # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_administrators();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Approve the quote

$approve_error = quotes_approve(form_fetch_element('quote_id', 0));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<?php if(isset($approve_error)) { ?>
<h5 class="uppercase align_center red text_white">
  <?=$approve_error?>
</h5>
<?php } else { ?>
<h5 class="uppercase align_center green text_white">
  <?=__('quotes_approve_ok')?>
</h5>
<?php } ?>
