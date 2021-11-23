<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';      # Core
include_once './../../lang/compendium.lang.php';  # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/compendium/index";
$page_title_en    = "Compendium";
$page_title_fr    = "Compendium";
$page_description = "An encyclopedia of 21st century culture, internet memes, modern slang, and sociocultural concepts";




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('compendium_index_title')?>
  </h1>

  <h5>
    <?=__('compendium_index_subitle')?>
  </h5>

  <p>
    <?=__('compendium_index_intro_1')?>
  </p>

  <p>
    <?=__('compendium_index_intro_2')?>
  </p>

  <h3 class="bigpadding_top">
    <?=__('compendium_closed')?>
  </h3>

  <p>
    <?=__('compendium_closed_1')?>
  </p>

  <p>
    <?=__('compendium_closed_2')?>
  </p>

  <p>
    <?=__('compendium_closed_3')?>
  </p>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }