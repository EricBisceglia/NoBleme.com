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
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/doc_js_toolbox";
$page_title_en    = "JS Toolbox";
$page_title_fr    = "Outils JS";

// Extra CSS & JS
$css = array('dev');
$js  = array('dev/doc', 'clipboard');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dropdown selector

$js_toolbox = sanitize_input('POST', 'js_toolbox', 'string', 'fetch');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="width_50">

  <h4 class="align_center">
    <?=__('dev_js_toolbox_title')?>
    <select class="inh" id="select_js_toolbox" onchange="dev_js_toolbox_selector();">
      <option value="clipboard">clipoard.js</option>
      <option value="fetch" selected>fetch.js</option>
      <option value="highlight">highlight.js</option>
      <option value="toggle">toggle.js</option>
    </select>
  </h4>

</div>

<div class="bigpadding_top" id="dev_js_toolbox_body">




<?php } if($js_toolbox === 'clipboard') { ########################################################################## ?>

<div class="width_40">
  <pre class="dev_pre_code" id="dev_js_toolbox_cliboard" onclick="to_clipboard('', 'dev_js_toolbox_cliboard', 1);">&lt;pre class="dev_pre_code" id="lorem_id" onclick="to_clipboard('', 'lorem_id', 1);">Lorem clipboardum&lt;/pre></pre>
</div>




<?php } else if($js_toolbox === 'fetch') { ######################################################################### ?>

<div class="width_50 bigpadding_bot">
  <pre class="dev_pre_code" id="dev_js_toolbox_cliboard" onclick="to_clipboard('', 'dev_js_toolbox_cliboard', 1);">// Only fetch the data if the form is properly filled up
if(!form_require_field("my_field","my_field_label"))
  return;

// Prepare the postdata
postdata  = 'my_id='          + my_id;
postdata += '&some_value='    + fetch_sanitize(some_value);
postdata += '&some_element='  + fetch_sanitize_id('some_element');

// Fetch the data
fetch_page(fetched_page_url, 'replaced_element_id', postdata);</pre>
</div>

<div class="width_80">
  <pre>/**
 * Fetches content dynamically.
 *
 * fetch_sanitize() and/or fetch_sanitize_id() should be used to sanitize the contents of the postdata.
 *
 * @param   {string}  target_page       The url of the page containing the content to be fetched.
 * @param   {string}  target_element    The element of the current page in which the target content will be fetched.
 * @param   {string}  [postdata]        This content will be passed to the target page as postdata.
 * @param   {string}  [callback]        Script element to call once the content has been fetched.
 * @param   {int}     [append_content]  Should the content be appended to the target element instead of replacing it.
 * @param   {string}  [path]            The path to the root of the website.
 * @param   {int}     [show_load_bar]   If set, there will be a "loading" bar until the fetched content is loaded.
 *
 * @returns {void}
 */</pre>
</div>



<?php } else if($js_toolbox === 'highlight') { ##################################################################### ?>

<div class="width_40">
  <pre class="dev_pre_code" id="dev_js_toolbox_highlight" onclick="to_clipboard('', 'dev_js_toolbox_highlight', 1);">&lt;pre class="dev_pre_code" id="lorem_id" onclick="select_element('lorem_id');">Lorem highlightium&lt;/pre></pre>
</div>




<?php } else if($js_toolbox === 'toggle') { ######################################################################## ?>

<div class="width_40">
  <pre class="dev_pre_code" id="dev_js_toolbox_toggle" onclick="to_clipboard('', 'dev_js_toolbox_toggle', 1);">// Toggle element
toggle_element('element_id', 'table-row');

// Toggle element one way
toggle_element_oneway('element_id', 1, 'table-row');

// Toggle all elements of given class
toggle_class('class_id', 'table-row');

// Toggle all elements of given class one way
toggle_class_oneway('class_id', 1, 'table-row');</pre>
</div>




<?php } if(!page_is_fetched_dynamically()) { ###################################################################### ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }