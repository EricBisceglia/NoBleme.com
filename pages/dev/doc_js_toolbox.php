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
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/doc_js_toolbox";
$page_title_en    = "JS Toolbox";
$page_title_fr    = "Outils JS";

// Extra CSS & JS
$css = array('dev');
$js  = array('dev/doc', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the correct js toolbox entry

// Prepare a list of all js toolbox entries
$dev_jstools_selection = array('clipboard', 'fetch', 'highlight', 'toggle');

// Prepare the CSS for each js toolbox entry
foreach($dev_jstools_selection as $dev_jstools_selection_name)
{
  // If a js toolbox entry is selected, display it and select the correct dropdown menu entry
  if(!isset($dev_jstools_is_selected) && isset($_GET[$dev_jstools_selection_name]))
  {
    $dev_jstools_is_selected                            = true;
    $dev_jstools_hide[$dev_jstools_selection_name]      = '';
    $dev_jstools_selected[$dev_jstools_selection_name]  = ' selected';
  }

  // Hide every other js toolbox entry
  else
  {
    $dev_jstools_hide[$dev_jstools_selection_name]      = ' hidden';
    $dev_jstools_selected[$dev_jstools_selection_name]  = '';
  }
}

// If no js tooltbox entry is selected, select the main one by default
if(!isset($dev_jstools_is_selected))
{
  $dev_jstools_hide['fetch']      = '';
  $dev_jstools_selected['fetch']  = ' selected';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center dev_doc_selector">

  <fieldset>
    <h5>
      <?=__('dev_js_toolbox_title')?>
      <select class="inh" id="dev_jstools_selector" onchange="dev_js_toolbox_selector();">
        <option value="clipboard"<?=$dev_jstools_selected['clipboard']?>>clipoard.js</option>
        <option value="fetch"<?=$dev_jstools_selected['fetch']?>>fetch.js</option>
        <option value="highlight"<?=$dev_jstools_selected['highlight']?>>highlight.js</option>
        <option value="toggle"<?=$dev_jstools_selected['toggle']?>>toggle.js</option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ CLIPBOARD *************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['clipboard']?>" id="dev_jstools_clipboard">
  <pre class="dev_pre_code" id="dev_js_toolbox_cliboard" onclick="to_clipboard('', 'dev_js_toolbox_cliboard', 1);">&lt;pre id="lorem_id" onclick="to_clipboard('', 'lorem_id', 1);">Lorem clipboardum&lt;/pre></pre>
</div>




<?php /************************************************* FETCH ****************************************************/ ?>

<div class="padding_top dev_jstools_section<?=$dev_jstools_hide['fetch']?>" id="dev_jstools_fetch">

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

</div>



<?php /*********************************************** HIGHLIGHT **************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['highlight']?>" id="dev_jstools_highlight">
  <pre class="dev_pre_code" id="dev_js_toolbox_highlight" onclick="to_clipboard('', 'dev_js_toolbox_highlight', 1);">&lt;pre class="dev_pre_code" id="lorem_id" onclick="select_element('lorem_id');">Lorem highlightium&lt;/pre></pre>
</div>




<?php /************************************************* TOGGLE ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['toggle']?>" id="dev_jstools_toggle">
  <pre class="dev_pre_code" id="dev_js_toolbox_toggle" onclick="to_clipboard('', 'dev_js_toolbox_toggle', 1);">// Toggle element
toggle_element('element_id', 'table-row');

// Toggle element one way
toggle_element_oneway('element_id', 1, 'table-row');

// Toggle all elements of given class
toggle_class('class_id', 'table-row');

// Toggle all elements of given class one way
toggle_class_oneway('class_id', 1, 'table-row');</pre>
</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }