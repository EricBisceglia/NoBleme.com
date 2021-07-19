<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/quotes.act.php';  # Actions
include_once './../../lang/quotes.lang.php';    # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/quotes/submit";
$page_title_en    = "Submit a quote";
$page_title_fr    = "Proposer une citation";
$page_description = "Submit a proposal to NoBleme's quote database.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create the quote

// Submit the quote proposal
if(isset($_POST['quotes_add_submit']))
  $quote_create = quotes_add(form_fetch_element('quotes_add_body'));

// Admins should be directly redirected to the quote
if($is_admin && isset($quote_create) && is_int($quote_create))
  exit(header("Location: ".$path."pages/quotes/".$quote_create));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__link("pages/quotes/list", __('submenu_social_quotes'), 'noglow')?>
  </h1>

  <h5>
    <?=__('quotes_add_subtitle')?>
  </h5>

  <?php if(isset($quote_create) && is_int($quote_create)) { ?>

  <p>
    <?=__('quotes_add_thanks')?>
  </p>

  <?php } else { ?>

  <p>
    <?=__('quotes_add_intro_1')?>
  </p>

  <p>
    <?=__('quotes_add_intro_2')?>
  </p>

  <ul class="smallpadding_top padding_bot">
    <li>
      <?=__('quotes_add_rules_1')?>
    </li>
    <li>
      <?=__('quotes_add_rules_2')?>
    </li>
    <li>
      <?=__('quotes_add_rules_3')?>
    </li>
    <li>
      <?=__('quotes_add_rules_4')?>
    </li>
    <li>
      <?=__('quotes_add_rules_5')?>
    </li>
  </ul>

  <form method="POST">
    <fieldset>

      <label for="quotes_add_body"><?=__('quotes_add_body')?></label>
      <textarea id="quotes_add_body" name="quotes_add_body"></textarea>

      <?php if(isset($quote_create) && !is_int($quote_create)) { ?>
      <div class="smallpadding_top">
        <h5 class="text_white red uppercase align_center">
          <?=$quote_create?>
        </h5>
      </div>
      <?php } ?>

      <div class="smallpadding_top">
        <input type="submit" name="quotes_add_submit" value="<?=__('quotes_add_submit')?>">
      </div>

    </fieldset>
  </form>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }