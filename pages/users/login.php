<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  // Common inclusions
include_once './../../actions/users.act.php'; // User actions

// Limit page access rights
user_restrict_to_guests();

// Translations and available languages
include_once './../../lang/users.lang.php';
$page_lang = array('FR', 'EN');

// Menus
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Homepage';

// User activity
$page_name  = "users_login";
$page_url   = "pages/users/login";

// Title and description
$page_title       = __('users_login_page_title');
$page_description = __('users_login_page_description');

// CSS
$css = array('users');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Login attempt

if(isset($_POST['login_submit']))
{
  // Check whether "remember me" is checked
  $user_login_remember_me = isset($_POST['login_remember']) ? 1 : null;

  // Attempt to login
  $user_login_attempt = users_authenticate( $_SERVER["REMOTE_ADDR"]   ,
                                            $_POST['login_nickname']  ,
                                            $_POST['login_password']  ,
                                            $user_login_remember_me   );

  // If the user has logged in, redirect them
  if($user_login_attempt === 1)
    header("location: ".$path."pages/users/notifications");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Form values

$user_login_nickname    = isset($_POST['login_nickname']) ? sanitize_output($_POST['login_nickname']) : '';
$user_login_password    = isset($_POST['login_password']) ? sanitize_output($_POST['login_password']) : '';
$user_login_remember_me = (isset($_POST['login_remember']) || !isset($_POST['login_submit'])) ? " checked" : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50">

        <h1 class="align_center bigpadding_bot">
          <?=__('users_login_page_title')?>
        </h1>

        <h5 class="align_center bigpadding_bot">
          <?=__link('pages/users/register', __('users_login_form_create'), '')?>
        </h5>

        <?php if(isset($user_login_attempt)) { ?>

        <h5 class="align_center bigpadding_bot text_negative underlined">
          <?=string_change_case(__('error'), 'uppercase').__(':').' '.$user_login_attempt?>
        </h5>

        <?php } ?>

      </div>

      <div class="width_30">

        <form method="POST" action="login">
          <fieldset>

            <label for="login_nickname"><?=string_change_case(__('nickname'), 'initials')?></label>
            <input id="login_nickname" name="login_nickname" class="indiv" type="text" value="<?=$user_login_nickname?>"><br>
            <br>

            <label for="login_password"><?=string_change_case(__('password'), 'initials')?></label>
            <input id="login_password" name="login_password" class="indiv" type="password" value="<?=$user_login_password?>"><br>

            <?php if(isset($_POST['login_nickname']) && $_POST['login_nickname'] && isset($_POST['login_password']) && $_POST['login_password']) { ?>

              <p class="align_center"><?=__link('pages/users/forgotten_password', __('users_login_form_forgotten_password'), '')?></p>

            <?php } ?>

            <br>

            <div class="float_right remember_me">
              <input id="login_remember" name="login_remember" type="checkbox"<?=$user_login_remember_me?>>
              <label class="label_inline" for="login_remember"><?=__('users_login_form_remember')?></label>
            </div>
            <input value="<?=__('users_login_page_title')?>" type="submit" name="login_submit">
            &nbsp;&nbsp;
            <a href="<?=$path?>pages/users/register">
              <button type="button" class="button_outline"><?=__('users_login_form_register')?></button>
            </a>

          </fieldset>
        </form>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';