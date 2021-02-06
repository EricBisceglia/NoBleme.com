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
$page_url         = "pages/quotes/users";
$page_title_en    = "Link users to a quote";
$page_title_fr    = "Lier des membres à une citation";
$page_description = "Link users to a quote within NoBleme's quote database.";

// Extra JS
$js = array('quotes/users', 'users/autocomplete_username');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Manage linked accounts

// Fetch the quote's ID
$quote_id = form_fetch_element('id', 0, request_type: 'GET');

// Link an account to the quote
if(isset($_POST['quote_users_submit']))
  $user_link_error = quotes_link_user(  $quote_id                               ,
                                        form_fetch_element('quote_users_nick')  );

// Unlink an account from the quote
if(isset($_POST['quote_unlink_account']))
  quotes_unlink_user( form_fetch_element('quote_id')  ,
                      form_fetch_element('user_id')   );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the linked accounts

// Fetch the quote data
$quote_data = quotes_get($quote_id);

// Fetch users linked to the quote
$quote_users = quotes_get_linked_users($quote_id);

// Redirect to the quotes list if it the selected quote does not exist
if(!$quote_data || !$quote_users)
  header("Location: ".$path."pages/quotes/list");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1 class="bigpadding_bot">
    <?=__link('pages/quotes/'.$quote_id, __('quotes_id', preset_values: array($quote_id)), 'text_red noglow')?>
  </h1>

  <div id="quote_users_list">

    <?php } ?>

    <?php if($quote_users['rows']) { ?>

    <label><?=__('quotes_users_header')?></label>

    <ul class="padding_bot">

      <?php for($i = 0; $i < $quote_users['rows'] ; $i++) { ?>

      <li>
        <?php if($quote_users[$i]['deleted']) { ?>
        <?=__link('pages/users/'.$quote_users[$i]['id'], $quote_users[$i]['username'], 'strikethrough bold')?>
        [<?=__('deleted')?>]
        <?php } else { ?>
        <?=__link('pages/users/'.$quote_users[$i]['id'], $quote_users[$i]['username'])?>
        <?php } ?>
        <?=__icon('user_delete', is_small: true, alt: 'X', title: __('quotes_users_remove'), class: 'valign_middle pointer spaced_left', onclick: "quotes_unlink_account('".$quote_id."', '".$quote_users[$i]['id']."');")?>
      </li>

      <?php } ?>

    </ul>

    <?php } else { ?>

    <h5 class="padding_bot">
      <?=__('quotes_users_none')?>
    </h5>

    <?php } ?>

    <?php if(!page_is_fetched_dynamically()) { ?>

  </div>

  <form method="POST">
    <fieldset>

      <div class="smallpadding_top">
        <label for="quote_users_nick"><?=__('quotes_users_add')?></label>
        <input class="indiv" type="text" id="quote_users_nick" name="quote_users_nick" value="" autocomplete="off" list="quote_users_nick_list" onkeyup="autocomplete_username('quote_users_nick', 'quote_users_nick_list_parent', './../common/autocomplete_username', 'quote_users_nick_list', 'normal');">
        <div id="quote_users_nick_list_parent">
          <datalist id="quote_users_nick_list">
            <option value=" ">&nbsp;</option>
          </datalist>
        </div>
      </div>

      <?php if(isset($user_link_error) && $user_link_error) { ?>
      <div class="padding_top">
        <h5 class="red text_white align_center uppercase">
          <?=$user_link_error?>
        </h5>
      </div>
      <?php } ?>

      <div class="padding_top">
        <input type="submit" name="quote_users_submit" value="<?=__('quotes_users_submit')?>">
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