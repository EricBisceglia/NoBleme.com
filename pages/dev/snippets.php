<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/dev.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang      = array('FR', 'EN');
$page_url       = "pages/dev/snippets";
$page_title_en  = "Dev - Code snippets";
$page_title_fr  = "Dev - Modèles de code";

// Extra CSS & JS
$css  = array('dev');
$js   = array('toggle', 'clipboard', 'highlight');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?>


      <table class="fullgrid blacktitles margin_auto noresize dev_snippets_width">
        <thead>
          <tr>
          <th class="rowaltc pointer dev_border_right_blank"
                onClick="toggle_class_oneway('snippets_section', 0); toggle_element('snippets_full');">
              <?=__('dev_snippets_title_full')?>
            </th>
            <th class="rowaltc pointer dev_border_right_blank"
                onClick="toggle_class_oneway('snippets_section', 0); toggle_element('snippets_blocks');">
              <?=__('dev_snippets_title_blocks')?>
            </th>
            <th class="rowaltc pointer dev_border_right_blank"
                onClick="toggle_class_oneway('snippets_section', 0); toggle_element('snippets_header');">
              <?=__('dev_snippets_title_header')?>
            </th>
          </tr>
        </thead>
      </table>

      <div class="margin_auto snippets_section bigpadding_top dev_snippets_width" id="snippets_full">

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_full'); select_element('dev_snippets_pre_full');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_full">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations

// Limit page access rights
user_restrict_to_guests($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/index";
$page_title_en    = "Title";
$page_title_fr    = "Titre";
$page_description = "Metadescription";

// Extra CSS &amp; JS
$css  = array('tabs');
$js   = array('tabs');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

      &lt;div class="width_50">

        &lt;h1>
          &lt;?=__('nobleme')?>
        &lt;/h1>

        &lt;h5>
          &lt;?=__('nobleme')?>
        &lt;/h5>

        &lt;p>
          &lt;?=__('nobleme')?>
        &lt;/p>

      &lt;/div>

&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }</pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_full_dynamic'); select_element('dev_snippets_pre_full_dynamic');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_full_dynamic">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_global_moderators($lang);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

&lt;?=__('nobleme')?></pre>

      </div>




      <div class="margin_auto snippets_section bigpadding_top dev_snippets_width hidden" id="snippets_blocks">

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_blocks_separator'); select_element('dev_snippets_pre_blocks_separator');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_blocks_separator">///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// </pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_blocks_back'); select_element('dev_snippets_pre_blocks_back');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_blocks_back">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/</pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_blocks_front_open'); select_element('dev_snippets_pre_blocks_front_open');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_blocks_front_open">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?></pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_blocks_front_dynamic_open'); select_element('dev_snippets_pre_blocks_front_dynamic_open');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_blocks_front_dynamic_open">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?></pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_blocks_front_close'); select_element('dev_snippets_pre_blocks_front_close');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_blocks_front_close">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';</pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_blocks_back_dynamic_close'); select_element('dev_snippets_pre_blocks_back_dynamic_close');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_blocks_back_dynamic_close">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
include './../../inc/footer.inc.php'; /*****************************************************************************/ }</pre>

      </div>




      <div class="margin_auto snippets_section bigpadding_top dev_snippets_width hidden" id="snippets_header">

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_header'); select_element('dev_snippets_pre_header');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_header">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations

// Limit page access rights
user_restrict_to_guests($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/index";
$page_title_en    = "Title";
$page_title_fr    = "Titre";
$page_description = "Metadescription";

// Extra CSS & JS
$css  = array('tabs');
$js   = array('tabs');</pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_headers_dynamic'); select_element('dev_snippets_pre_headers_dynamic');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_headers_dynamic">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';    # Core
include_once './../../actions/nobleme.act.php'; # Actions
include_once './../../lang/nobleme.lang.php';   # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_global_moderators($lang);</pre>

        <pre onclick="to_clipboard(1, 'dev_snippets_pre_headers_included'); select_element('dev_snippets_pre_headers_included');" class="monospace spaced dev_snippets_container" id="dev_snippets_pre_headers_included">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }</pre>

      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';