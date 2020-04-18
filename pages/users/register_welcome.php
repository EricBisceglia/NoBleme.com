<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/users.lang.php';  # Translations

// Limit page access rights
user_restrict_to_guests($lang);

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/users/register_welcome";
$page_title_en    = "Welcome to NoBleme";
$page_title_fr    = "Bienvenue sur NoBleme";
$page_description = "Welcome to NoBleme - thank you for creating a new account";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Unhide the login menu

$onload = "toggle_header_menu('account', 1);";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50">

        <h3>
          <?=__('users_welcome_title')?>
        </h3>

        <p>
          <?=__('users_welcome_body')?>
        </p>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }