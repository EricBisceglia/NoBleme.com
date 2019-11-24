<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/users.lang.php';  # Translations

// Limit page access rights
user_restrict_to_guests($lang);

// Menus
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Homepage';

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/forgotten_password";
$page_title_en    = "Recover password";
$page_title_fr    = "Mot de passe oublié";
$page_description = "Forgot your account's password? Well I've got bad news for you...";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50">

        <h1>
          <?=__('users_forgotten_title')?>
        </h1>

        <p>
          <?=__('users_forgotten_body')?>
        </p>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';