<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/users.act.php'; # Actions
include_once './../../lang/users.lang.php';   # Translations

// Limit page access rights
user_restrict_to_guests($lang);

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/login";
$page_title_en    = "Register";
$page_title_fr    = "S'inscrire";
$page_description = "Register a new NoBleme account";

// Extra CSS & JS
$css  = array('users');
$js   = array('fetch', 'users/register');





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Registration attempt

if(isset($_POST['register_nickname']))
{
  // Attempt to create the account
  $user_register_attempt = users_create_account(  $_POST['register_nickname']     ,
                                                  $_POST['register_password_1']   ,
                                                  $_POST['register_email']        ,
                                                  $_POST['register_password_2']   ,
                                                  $_POST['register_captcha']      ,
                                                  $_SESSION['captcha']            );

  // If the user has succesfully registered, redirect them
  if($user_register_attempt === 1)
    header("location: ".$path."pages/users/inbox");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Form values

$register_nickname    = isset($_POST['register_nickname'])    ? sanitize_output($_POST['register_nickname'])      : '';
$register_password_1  = isset($_POST['register_password_1'])  ? sanitize_output($_POST['register_password_1'])    : '';
$register_password_2  = isset($_POST['register_password_2'])  ? sanitize_output($_POST['register_password_2'])    : '';
$register_email       = isset($_POST['register_email'])       ? sanitize_output($_POST['register_email'])         : '';
$register_check_q1[1] = (isset($_POST['register_question_1']) && $_POST['register_question_1'] == 1) ? ' checked' : '';
$register_check_q1[2] = (isset($_POST['register_question_1']) && $_POST['register_question_1'] == 2) ? ' checked' : '';
$register_check_q1[3] = (isset($_POST['register_question_1']) && $_POST['register_question_1'] == 3) ? ' checked' : '';
$register_check_q2[1] = (isset($_POST['register_question_2']) && $_POST['register_question_2'] == 1) ? ' checked' : '';
$register_check_q2[2] = (isset($_POST['register_question_2']) && $_POST['register_question_2'] == 2) ? ' checked' : '';
$register_check_q2[3] = (isset($_POST['register_question_2']) && $_POST['register_question_2'] == 3) ? ' checked' : '';
$register_check_q3[1] = (isset($_POST['register_question_3']) && $_POST['register_question_3'] == 1) ? ' checked' : '';
$register_check_q3[2] = (isset($_POST['register_question_3']) && $_POST['register_question_3'] == 2) ? ' checked' : '';
$register_check_q4[1] = (isset($_POST['register_question_4']) && $_POST['register_question_4'] == 1) ? ' checked' : '';
$register_check_q4[2] = (isset($_POST['register_question_4']) && $_POST['register_question_4'] == 2) ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50 padding_bot">

        <h1>
          <?=__('users_register_title')?>
        </h1>

        <h5>
          <?=__('users_register_subtitle')?>
        </h5>

        <p class="padding_bot">
          <?=__('users_register_coc')?>
        </p>

        <?=__('coc')?>

      </div>

      <div class="width_35 bigpadding_top">

        <form method="POST" id="register_form" action="register#register_form">
          <fieldset>

            <div class="padding_bot">
              <label for="register_nickname" id="label_register_nickname"><?=__('users_register_form_nickname')?></label>
              <input id="register_nickname" name="register_nickname" class="indiv" type="text" value="<?=$register_nickname?>" maxlength="15" onkeyup="users_register_validate_username();">
            </div>

            <div class="padding_bot">
              <label for="register_password_1" id="label_register_password_1"><?=__('users_register_form_password_1')?></label>
              <input id="register_password_1" name="register_password_1" class="indiv" type="password" value="<?=$register_password_1?>" onkeyup="users_register_validate_password();">
            </div>

            <div class="padding_bot">
              <label for="register_password_2" id="label_register_password_2"><?=__('users_register_form_password_2')?></label>
              <input id="register_password_2" name="register_password_2" class="indiv" type="password" value="<?=$register_password_2?>" onkeyup="users_register_validate_password();">
            </div>

            <div class="bigpadding_bot">
              <label for="register_email" id="label_register_email"><?=__('users_register_form_email')?></label>
              <input id="register_email" name="register_email" class="indiv" type="text" value="<?=$register_email?>">
            </div>

            <label for="register_question_1" id="label_register_question_1"><?=__('users_register_form_question_1')?></label>
            <div class="flexcontainer padding_bot">
              <div style="flex:1">
            <input id="register_question_1" name="register_question_1" value="1" type="radio"<?=$register_check_q1[1]?>>
            <label class="label_inline" for="register_question_1"><?=string_change_case(__('yes'), 'initials')?></label>
              </div>
              <div style="flex:1">
            <input name="register_question_1" value="2" type="radio"<?=$register_check_q1[2]?>>
            <label class="label_inline" for="register_question_1"><?=string_change_case(__('no'), 'initials')?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_1" value="3" type="radio"<?=$register_check_q1[3]?>>
            <label class="label_inline" for="register_question_1"><?=__('users_register_form_question_1_maybe')?></label>
              </div>
            </div>

            <label for="register_question_2" id="label_register_question_2"><?=__('users_register_form_question_2')?></label>
            <div class="flexcontainer padding_bot">
              <div style="flex:1">
            <input id="register_question_2" name="register_question_2" value="1" type="radio"<?=$register_check_q2[1]?>>
            <label class="label_inline" for="register_question_2"><?=string_change_case(__('yes'), 'initials')?></label>
              </div>
              <div style="flex:1">
            <input name="register_question_2" value="2" type="radio"<?=$register_check_q2[2]?>>
            <label class="label_inline" for="register_question_2"><?=string_change_case(__('no'), 'initials')?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_2" value="3" type="radio"<?=$register_check_q2[3]?>>
            <label class="label_inline" for="register_question_2"><?=__('users_register_form_question_2_dummy')?></label>
              </div>
            </div>

            <label for="register_question_3" id="label_register_question_3"><?=__('users_register_form_question_3')?></label>
            <div class="flexcontainer padding_bot">
              <div style="flex:2">
            <input id="register_question_3" name="register_question_3" value="1" type="radio"<?=$register_check_q3[1]?>>
            <label class="label_inline" for="register_question_3"><?=__('users_register_form_question_3_silly')?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_3" value="2" type="radio"<?=$register_check_q3[2]?>>
            <label class="label_inline" for="register_question_3"><?=__('users_register_form_question_3_good')?></label>
              </div>
            </div>

            <label for="register_question_4" id="label_register_question_4"><?=__('users_register_form_question_4')?></label>
            <div class="flexcontainer bigpadding_bot">
              <div style="flex:2">
            <input id="register_question_4" name="register_question_4" value="1" type="radio"<?=$register_check_q4[1]?>>
            <label class="label_inline" for="register_question_4"><?=__('users_register_form_question_4_banned')?></label>
              </div>
              <div style="flex:3">
            <input name="register_question_4" value="2" type="radio"<?=$register_check_q4[2]?>>
            <label class="label_inline" for="register_question_4"><?=__('users_register_form_question_4_freedom')?></label>
              </div>
            </div>

            <label for="register_captcha" id="label_register_captcha"><?=__('users_register_form_captcha')?></label>
            <div class="flexcontainer bigpadding_bot">
              <div style="flex:1">
                <img src="<?=$path?>inc/captcha.inc.php" alt="<?=__('users_register_form_captcha_alt')?>">
              </div>
              <div style="flex:4">
                <input id="register_captcha" name="register_captcha" class="indiv" type="text">
              </div>
            </div>

          </fieldset>
        </form>

        <?php if(isset($user_register_attempt)) { ?>

        <h6 class="align_center padding_bot text_negative underlined">
          <?=string_change_case(__('error'), 'uppercase').__(':').' '.$user_register_attempt?>
        </h6>

        <?php } ?>

        <button class="bigbutton" onclick="users_register_submit('<?=$path?>');"><?=__('users_register_form_submit')?></button>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';