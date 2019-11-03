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

// User activity
$page_name  = "users_forgotten";
$page_url   = "pages/users/forgotten_password";

// Page summary
$page_lang        = array('EN', 'FR');
$page_title       = __('users_forgotten_page_title');
$page_description = __('users_forgotten_page_description');





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