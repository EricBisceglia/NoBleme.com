<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/account.act.php'; # Actions
include_once './../../lang/doc.lang.php';       # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/doc/data";
$page_title_en    = "Personal data";
$page_title_fr    = "Données personnelles";
$page_description = "An exhaustive list of all the personal data NoBleme keeps about you";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the user's personal data

// Logged in
$user_data_logged_in = user_is_logged_in();

// Email adress
$user_data_email = ($user_data_logged_in) ? account_get_email() : '';

// IP adress
$user_data_ip = sanitize_output($_SERVER['REMOTE_ADDR']);

// Language
$user_data_language = string_change_case($lang, 'lowercase');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('submenu_nobleme_personal_data')?>
  </h1>

  <p>
    <?=__('doc_data_intro_1')?>
  </p>

  <div class="padding_top">
    <?=__('doc_data_intro_2')?>
    <ul>
      <li>
        <?=__('doc_data_list_1')?>
      </li>
      <li>
        <?=__('doc_data_list_2')?>
      </li>
      <li>
        <?=__('doc_data_list_3')?>
      </li>
      <li>
        <?=__('doc_data_list_4')?>
      </li>
      <li>
        <?=__('doc_data_list_5')?>
      </li>
    </ul>
  </div>

  <h5 class="bigpadding_top">
    <?=__('doc_data_ip_title')?> <span class="blur"><?=$user_data_ip?></span>
  </h5>

  <?php if(!$user_data_logged_in) { ?>

  <p>
    <?=__('doc_data_ip_guest_1')?>
  </p>

  <p>
    <?=__('doc_data_ip_guest_2')?>
  </p>

  <?php } else { ?>

  <p>
    <?=__('doc_data_ip_user_1')?>
  </p>

  <p>
    <?=__('doc_data_ip_user_2')?>
  </p>

  <p>
    <?=__('doc_data_ip_user_3')?>
  </p>

  <?php } ?>

  <?php if(isset($user_data_email) && $user_data_email) { ?>

  <h5 class="bigpadding_top">
    <?=__('doc_data_email_title')?> <span class="blur"><?=$user_data_email?></span>
  </h5>

  <p>
    <?=__('doc_data_email_1')?>
  </p>

  <p>
    <?=__('doc_data_email_2')?>
  </p>

  <?php } ?>

  <h5 class="bigpadding_top">
    <?=__('doc_data_lang_title')?> <span class="text_light"><?=__($user_data_language)?></span>
  </h5>

  <?php if(!$user_data_logged_in) { ?>

  <p>
    <?=__('doc_data_lang_guest_1')?>
  </p>

  <p>
    <?=__('doc_data_lang_guest_2')?>
  </p>

  <?php } else { ?>

  <p>
    <?=__('doc_data_lang_users_1')?>
  </p>

  <p>
    <?=__('doc_data_lang_users_2')?>
  </p>

  <?php } ?>

  <h5 class="bigpadding_top">
    <?=__('doc_data_conclusion_title')?>
  </h5>

  <p>
    <?=__('doc_data_conclusion_1')?>
  </p>

  <p>
    <?=__('doc_data_conclusion_2')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }