<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/nobleme.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/social/games";
$page_title_en    = "Gaming nights";
$page_title_fr    = "Sessions de jeu";
$page_description = "NoBleme's social video gaming events";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('nobleme_gaming_title')?>
  </h1>

  <p>
    <?=__('nobleme_gaming_body_1')?>
  </p>

  <p>
    <?=__('nobleme_gaming_body_2')?>
  </p>

  <p>
    <?=__('nobleme_gaming_body_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }