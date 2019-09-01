<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/queries.inc.php';  // Queries awaiting execution
include_once './../../inc/includes.inc.php'; // Common inclusions
include_once './../../lang/dev.lang.php';    // Translations

// Limit page access based on user rights
user_restrict_to_administrators();

// Selected menu and sidemenu
$header_menu      = 'Dev';
$header_sidemenu  = 'SQL';

// Available languages, page title, activity, and description
$page_lang    = array('EN', 'FR');
$page_title   = __('dev_queries_title');
$page_name_en = __('activity_admin_en');
$page_name_fr = __('activity_admin_fr');

// Extra CSS files
$css = array('dev');

/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                              HTML: DISPLAY THE DATA                                               */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte dev_queries_block">

        <h1 class="positive texte_blanc align_center">
          <?=__('dev_queries_ok')?>
        </h1>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF HTML                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';