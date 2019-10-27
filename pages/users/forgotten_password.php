<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; // Common inclusions

// Limit page access rights
user_restrict_to_guests($lang);

// Translations and available languages
include_once './../../lang/users.lang.php';
$page_lang = array('FR', 'EN');

// Menus
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Homepage';

// User activity
$page_name  = "users_forgotten";
$page_url   = "pages/users/forgotten_password";

// Title and description
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