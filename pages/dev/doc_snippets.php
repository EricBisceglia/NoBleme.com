<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../lang/dev.lang.php';     # Translations

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang      = array('FR', 'EN');
$page_url       = "pages/dev/doc_snippets";
$page_title_en  = "Code snippets";
$page_title_fr  = "Modèles de code";

// Extra JS
$js = array('dev/doc', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the correct code snippets

// Prepare a list of all snippet options
$dev_snippet_selection = array('full', 'fetched', 'header', 'blocks');

// Prepare the CSS for each snippet
foreach($dev_snippet_selection as $dev_snippet_selection_name)
{
  // If a snippet is selected, display it and select the correct dropdown menu entry
  if(!isset($dev_snippet_is_selected) && isset($_GET[$dev_snippet_selection_name]))
  {
    $dev_snippet_is_selected                            = true;
    $dev_snippet_hide[$dev_snippet_selection_name]      = '';
    $dev_snippet_selected[$dev_snippet_selection_name]  = ' selected';
  }

  // Hide every other snippet
  else
  {
    $dev_snippet_hide[$dev_snippet_selection_name]      = ' hidden';
    $dev_snippet_selected[$dev_snippet_selection_name]  = '';
  }
}

// If no snippet is selected, select the main one by default
if(!isset($dev_snippet_is_selected))
{
  $dev_snippet_hide['full']     = '';
  $dev_snippet_selected['full'] = ' selected';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h4 class="align_center">
    <?=__('dev_snippets_title')?>
    <select class="inh" id="dev_snippet_selector" onchange="dev_snippet_selector();">
      <option value="full"<?=$dev_snippet_selected['full']?>><?=__('dev_snippets_selector_full')?></option>
      <option value="fetched"<?=$dev_snippet_selected['fetched']?>><?=__('dev_snippets_selector_fetched')?></option>
      <option value="header"<?=$dev_snippet_selected['header']?>><?=__('dev_snippets_selector_header')?></option>
      <option value="blocks"<?=$dev_snippet_selected['blocks']?>><?=__('dev_snippets_selector_blocks')?></option>
    </select>
  </h4>

</div>

<div class="bigpadding_top" id="dev_snippets_body">




<?php /************************************************** FULL ****************************************************/ ?>

<div class="width_60 dev_snippets_section<?=$dev_snippet_hide['full']?>" id="dev_snippets_full">

  <pre class="small" id="dev_snippets_full_standard" onclick="to_clipboard('', 'dev_snippets_full_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Limit page access rights
user_restrict_to_guests();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/index";
$page_title_en    = "Title";
$page_title_fr    = "Titre";
$page_description = "Metadescription";

// Extra CSS & JS
$css  = array('');
$js   = array('');




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
/*****************************************************************************/ include './../../inc/footer.inc.php'; }</pre>

</div>




<?php /************************************************ FETCHED ***************************************************/ ?>

<div class="width_60 dev_snippets_section<?=$dev_snippet_hide['fetched']?>" id="dev_snippets_fetched">

  <pre class="small" id="dev_snippets_fetched_standard" onclick="to_clipboard('', 'dev_snippets_fetched_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_guests();




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




<?php /************************************************* HEADER ***************************************************/ ?>

<div class="width_60 dev_snippets_section<?=$dev_snippet_hide['header']?>" id="dev_snippets_header">

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_header_standard" onclick="to_clipboard('', 'dev_snippets_header_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Limit page access rights
user_restrict_to_guests();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/nobleme/index";
$page_title_en    = "Title";
$page_title_fr    = "Titre";
$page_description = "Metadescription";

// Extra CSS & JS
$css  = array('');
$js   = array('');</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_header_fetched" onclick="to_clipboard('', 'dev_snippets_header_fetched', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_guests();</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_header_included" onclick="to_clipboard('', 'dev_snippets_header_included', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN BE RAN ONLY IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }</pre>
  </div>

</div>




<?php /************************************************* BLOCKS ***************************************************/ ?>

<div class="width_60 dev_snippets_section<?=$dev_snippet_hide['blocks']?>" id="dev_snippets_blocks">

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_comments" onclick="to_clipboard('', 'dev_snippets_blocks_comments', 1);">///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_back" onclick="to_clipboard('', 'dev_snippets_blocks_back', 1);">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_front" onclick="to_clipboard('', 'dev_snippets_blocks_front', 1);">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/****************************************************************************/ include './../../inc/header.inc.php'; ?></pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_front_fetch" onclick="to_clipboard('', 'dev_snippets_blocks_front_fetch', 1);">/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?></pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_footer" onclick="to_clipboard('', 'dev_snippets_blocks_footer', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*******************************************************************************/ include './../../inc/footer.inc.php';</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_blocks_footer_fetch" onclick="to_clipboard('', 'dev_snippets_blocks_footer_fetch', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }</pre>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }