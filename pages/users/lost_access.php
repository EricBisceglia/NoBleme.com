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
$page_url         = "pages/users/lost_access";
$page_title_en    = "Lost account access";
$page_title_fr    = "Accès perdu à votre compte";
$page_description = "Lost access to your account? Well I've got bad news for you...";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50">

        <h1>
          <?=__('users_lost_access_title')?>
        </h1>

        <p>
          <?=__('users_lost_access_body')?>
        </p>

        <p>
          <?=__('users_lost_access_solution')?>
        </p>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';