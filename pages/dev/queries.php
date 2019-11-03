<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/queries.inc.php';  # Run all queries awaiting execution
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/dev.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators($lang);

// Menus
$header_menu      = 'Admin';
$header_sidemenu  = 'SQL';

// User activity
$page_name = "admin";

// Page summary
$page_lang  = array('EN', 'FR');
$page_title = __('dev_queries_page_title');

// Extra CSS
$css = array('dev');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50 dev_queries_block">

        <h1 class="positive text_white align_center">
          <?=__('dev_queries_ok')?>
        </h1>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';