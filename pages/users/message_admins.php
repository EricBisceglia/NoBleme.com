<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../inc/bbcodes.inc.php';             # BBCodes
include_once './../../actions/users/messages.act.php';  # Actions
include_once './../../lang/users/messages.lang.php';    # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/message_admins";
$page_title_en    = "Contact the administrative team";
$page_title_fr    = "Contacter l'équipe administrative";
$page_description = "Send a message to the website's administrative team";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contact the admins

// Fetch the form's content
$contact_form_body = form_fetch_element('contact_form_body');

// Send the message
if(isset($_POST['contact_form_send']))
  $contact_form_return = private_message_admins($contact_form_body);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h2>
    <?=__('users_message_admins_title')?>
  </h2>

  <p>
    <?=__('users_message_admins_intro')?>
  </p>

  <p>
    <?=__('users_message_admins_proof')?>
  </p>

  <p class="smallpadding_bot">
    <?=__('users_message_admins_bug')?>
  </p>

  <?php if(!isset($contact_form_return['sent'])) { ?>
  <form method="POST" class="padding_top">
    <fieldset>

      <div class="smallpadding_bot">
        <textarea name="contact_form_body"><?=$contact_form_body?></textarea>
      </div>

      <?php if(isset($contact_form_return['error'])) { ?>
      <div class="smallpadding_bot">
        <div class="red text_white uppercase bold spaced">
          <?=__('error').__(':', spaces_after: 1).$contact_form_return['error']?>
        </div>
      </div>
      <?php } ?>

      <input type="submit" name="contact_form_send" value="<?=__('users_message_form_send')?>">

    </fieldset>
  </form>

  <?php } else { ?>
  <div class="padding_top">
    <div class="green text_white uppercase bold spaced">
      <?=__('users_message_admins_sent')?>
    </div>
  </div>
  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }