<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/account.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/account/register_closed";
$page_title_en    = "Registrations are closed";
$page_title_fr    = "Les inscriptions sont fermées";
$page_description = "Registering a new NoBleme account is currently impossible.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Check if account creation is currently allowed

if(!system_variable_fetch('registrations_are_closed'))
  header("location: ./register");




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
    <?=__('users_closed_subtitle')?>
  </h5>

  <p>
    <?=__('users_closed_body_1')?>
  </p>

  <p>
    <?=__('users_closed_body_2')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';