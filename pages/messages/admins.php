<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';      # Core
include_once './../../inc/bbcodes.inc.php';       # BBCodes
include_once './../../actions/messages.act.php';  # Actions
include_once './../../lang/messages.lang.php';    # Translations

// Limit page access rights
user_restrict_to_users();

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/messages/admins";
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
$contact_form_nick  = form_fetch_element('contact_form_nick');
$contact_form_body  = form_fetch_element('contact_form_body');

// Send the message
if(isset($_POST['contact_form_send']))
{
  // Username change request
  if(isset($_GET['username']))
    $contact_form_return = private_message_admins($contact_form_body, 'username', $contact_form_nick);

  // Account deletion request
  else if(isset($_GET['delete']))
    $contact_form_return = private_message_admins($contact_form_body, 'delete');

  // Generic contact form
  else
    $contact_form_return = private_message_admins($contact_form_body);
}

// Prepare the form contents for displaying
$contact_form_nick = sanitize_output($contact_form_nick);
$contact_form_body = sanitize_output($contact_form_body);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <?php if(isset($_GET['username'])) { ?>

  <h2>
    <?=__('users_message_admins_nick_title')?>
  </h2>

  <p>
    <?=__('users_message_admins_nick_intro')?>
  </p>

  <p class="smallpadding_bot">
    <?=__('users_message_admins_nick_past')?>
  </p>

  <?php } else if(isset($_GET['delete'])) { ?>

  <h2>
    <?=__('users_message_admins_del_title')?>
  </h2>

  <p>
    <?=__('users_message_admins_del_intro')?>
  </p>

  <p class="smallpadding_bot">
    <?=__('users_message_admin_del_history')?>
  </p>

  <?php } else { ?>

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

  <?php } ?>

  <?php if(!isset($contact_form_return['sent'])) { ?>
  <form method="POST" class="padding_top">
    <fieldset>

      <?php if(isset($_GET['username'])) { ?>

      <div class="smallpadding_bot">
        <label for="contact_form_nick"><?=__('users_message_admins_newnick')?></label>
        <input class="indiv" type="text" id="contact_form_nick" name="contact_form_nick" value="<?=$contact_form_nick?>" maxlength="15">
      </div>

      <?php } ?>

      <div class="smallpadding_bot">
        <?php if(isset($_GET['username'])) { ?>
        <label for="contact_form_body"><?=__('users_message_admins_nick')?></label>
        <?php } ?>
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