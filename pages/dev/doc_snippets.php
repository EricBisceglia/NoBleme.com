<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../lang/dev/documentation.lang.php'; # Translations

// Limit page access rights
user_restrict_to_administrators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang      = array('FR', 'EN');
$page_url       = "pages/dev/doc_snippets";
$page_title_en  = "Code snippets";
$page_title_fr  = "Modèles de code";

// Extra JS
$js = array('dev/doc', 'common/clipboard');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dropdown selector

$selected_snippet = sanitize_input('POST', 'snippet', 'string', 'full');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h4 class="align_center">
    <?=__('dev_snippets_title')?>
    <select class="inh" id="select_snippet" onchange="dev_snippet_selector();">
      <option value="full" selected><?=__('dev_snippets_selector_full')?></option>
      <option value="fetched"><?=__('dev_snippets_selector_fetched')?></option>
      <option value="header"><?=__('dev_snippets_selector_header')?></option>
      <option value="blocks"><?=__('dev_snippets_selector_blocks')?></option>
    </select>
  </h4>

</div>

<div class="bigpadding_top" id="dev_snippets_body">




<?php } if($selected_snippet === 'full') { ######################################################################### ?>

<div class="width_60">

  <pre class="small" id="dev_snippets_full_standard" onclick="to_clipboard('', 'dev_snippets_full_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../actions/nobleme/actions.act.php'; # Actions
include_once './../../lang/nobleme/lang.lang.php';      # Translations

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




<?php } else if ($selected_snippet === 'fetched') { ################################################################ ?>

<div class="width_60">

  <pre class="small" id="dev_snippets_fetched_standard" onclick="to_clipboard('', 'dev_snippets_fetched_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../actions/nobleme/actions.act.php'; # Actions
include_once './../../lang/nobleme/lang.lang.php';      # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_guests($lang);




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




<?php } else if ($selected_snippet === 'header') { ################################################################# ?>

<div class="width_60">

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_header_standard" onclick="to_clipboard('', 'dev_snippets_header_standard', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../actions/nobleme/actions.act.php'; # Actions
include_once './../../lang/nobleme/lang.lang.php';      # Translations

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
$css  = array('');
$js   = array('');</pre>
  </div>

  <div class="padding_bot">
    <pre class="small" id="dev_snippets_header_fetched" onclick="to_clipboard('', 'dev_snippets_header_fetched', 1);">&lt;?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                              THIS PAGE WILL WORK ONLY WHEN IT IS CALLED DYNAMICALLY                               */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';            # Core
include_once './../../actions/nobleme/actions.act.php'; # Actions
include_once './../../lang/nobleme/lang.lang.php';      # Translations

// Throw a 404 if the page is being accessed directly
page_must_be_fetched_dynamically();

// Limit page access rights
user_restrict_to_guests($lang);</pre>
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




<?php } else if ($selected_snippet === 'blocks') { ################################################################# ?>

<div class="width_60">

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




<?php } if(!page_is_fetched_dynamically()) { ####################################################################### ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }