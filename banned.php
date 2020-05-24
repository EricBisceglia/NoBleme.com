<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php';  # Core
include_once './actions/users.act.php'; # Actions
include_once './lang/users.lang.php';   # Translations

// Limit page access rights
user_restrict_to_banned($path);

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "banned";
$page_title_en    = "Banned!";
$page_title_fr    = "Banni !";
$page_description = "Bad news: you have been banned from NoBleme.";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /*********************************************/ include './inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('banned')?>
  </h1>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/***********************************************************************************/ include './inc/footer.inc.php'; }