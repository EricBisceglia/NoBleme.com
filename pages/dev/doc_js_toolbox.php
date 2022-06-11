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
$js  = array('dev/doc', 'common/editor', 'common/highlight', 'common/preview', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the correct js toolbox entry

// Prepare a list of all js toolbox entries
$dev_jstools_selection = array('clipboard', 'editor', 'fetch', 'highlight', 'preview', 'section_selector', 'toggle', 'unblur');

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
        <option value="editor"<?=$dev_jstools_selected['editor']?>>editor.js</option>
        <option value="fetch"<?=$dev_jstools_selected['fetch']?>>fetch.js</option>
        <option value="highlight"<?=$dev_jstools_selected['highlight']?>>highlight.js</option>
        <option value="preview"<?=$dev_jstools_selected['preview']?>>preview.js</option>
        <option value="section_selector"<?=$dev_jstools_selected['section_selector']?>>selector.js</option>
        <option value="toggle"<?=$dev_jstools_selected['toggle']?>>toggle.js</option>
        <option value="unblur"<?=$dev_jstools_selected['unblur']?>>unblur.js</option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ CLIPBOARD *************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['clipboard']?>" id="dev_jstools_clipboard">

  <div class="padding_bot">
    <pre id="dev_jstools_clipboard_test" onclick="to_clipboard('', 'dev_jstools_clipboard_test', 1);">Lorem clipboardum</pre>
  </div>

  <pre class="dev_pre_code" id="dev_js_toolbox_cliboard" onclick="to_clipboard('', 'dev_js_toolbox_cliboard', 1);">&lt;pre id="lorem_id" onclick="to_clipboard('', 'lorem_id', 1);">Lorem clipboardum&lt;/pre></pre>

</div>




<?php /************************************************* EDITOR ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['editor']?>" id="dev_jstools_editor">

  <div class="smallpadding_bot">
    <?php
    $editor_target_element  = 'dev_jstools_editor_in';
    $preview_output         = 'dev_jstools_editor_out';
    $preview_path           = $path;
    include './../../inc/editor.inc.php';
    ?>
    <textarea id="dev_jstools_editor_in" onkeyup="preview_bbcodes('dev_jstools_editor_in', 'dev_jstools_editor_out');"><?=__('dev_jstools_editor_in')?></textarea>
    <div class="smallpadding_top" id="dev_jstools_editor_out"></div>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_editor_include" onclick="to_clipboard('', 'dev_js_toolbox_editor_include', 1);">$js = array('common/editor', 'common/preview');</pre>
  </div>

  <pre class="dev_pre_code" id="dev_js_toolbox_editor" onclick="to_clipboard('', 'dev_js_toolbox_editor', 1);">&lt;?php
$editor_target_element  = 'target_id';
$preview_output         = 'output_id';
$preview_path           = $path;
include './../../inc/editor.inc.php';
?>

&lt;textarea id="target_id" onkeyup="preview_bbcodes('target_id', 'output_id');">&lt;?=__('target_id')?>&lt;/textarea>

&lt;div id="output_id">&lt;/div></pre>

</div>




<?php /************************************************* FETCH ****************************************************/ ?>

<div class="padding_top dev_jstools_section<?=$dev_jstools_hide['fetch']?>" id="dev_jstools_fetch">

  <div class="width_50 padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_fetch" onclick="to_clipboard('', 'dev_js_toolbox_fetch', 1);">// Only fetch the data if the form is properly filled up
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

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_jstools_highlight_test" onclick="select_element('dev_jstools_highlight_test');">Lorem highlightium</pre>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_highlight_include" onclick="to_clipboard('', 'dev_js_toolbox_highlight_include', 1);">$js = array('common/highlight');</pre>
  </div>

  <pre class="dev_pre_code" id="dev_js_toolbox_highlight" onclick="to_clipboard('', 'dev_js_toolbox_highlight', 1);">&lt;pre class="dev_pre_code" id="lorem_id" onclick="select_element('lorem_id');">Lorem highlightium&lt;/pre></pre>

</div>




<?php /************************************************ PREVIEW ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['preview']?>" id="dev_jstools_preview">

  <div class="smallpadding_bot">
    <textarea id="dev_jstools_preview_in" onkeyup="preview_bbcodes('dev_jstools_preview_in', 'dev_jstools_preview_out');"><?=__('dev_jstools_preview_in')?></textarea>
    <div class="smallpadding_top" id="dev_jstools_preview_out"></div>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_preview_include" onclick="to_clipboard('', 'dev_js_toolbox_preview_include', 1);">$js = array('common/preview');</pre>
  </div>

  <pre class="dev_pre_code" id="dev_js_toolbox_preview" onclick="to_clipboard('', 'dev_js_toolbox_preview', 1);">
&lt;textarea id="target_id" onkeyup="preview_bbcodes('target_id', 'output_id');">&lt;?=__('target_id')?>&lt;/textarea>

&lt;div id="output_id">&lt;/div></pre>

</div>




<?php /******************************************** SECTION SELECTOR **********************************************/ ?>

<div class="width_70 padding_top dev_jstools_section<?=$dev_jstools_hide['section_selector']?>" id="dev_jstools_section_selector">

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_selector_include" onclick="to_clipboard('', 'dev_js_toolbox_selector_include', 1);">$js = array('common/toggle', 'common/selector');</pre>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_selector_setup" onclick="to_clipboard('', 'dev_js_toolbox_selector_setup', 1);">///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$pagename_selector_entries = array( '1' ,
                                    '2' );

// Define the default dropdown menu entry
$pagename_selector_default = '1';

// Initialize the page section selector data
$pagename_selector = page_section_selector(           $pagename_selector_entries  ,
                                            default:  $pagename_selector_default  );</pre>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_selector_menu" onclick="to_clipboard('', 'dev_js_toolbox_selector_menu', 1);">&lt;div class="padding_bot align_center section_selector_container">

&lt;fieldset>
  &lt;h5>
    &lt;?=__('title')?>
    &lt;select class="inh" id="pagename_selector" onchange="page_section_selector('pagename', '&lt;?=$pagename_selector_default?>');">
      &lt;option value="1"&lt;?=$pagename_selector['menu']['1']?>>&lt;?=__('title')?>&lt;/option>
    &lt;/select>
  &lt;/h5>
&lt;/fieldset>

&lt;/div>

&lt;hr></pre>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_selector_section" onclick="to_clipboard('', 'dev_js_toolbox_selector_section', 1);">&lt;?php /************************************************ SECTION ***************************************************/ ?>

&lt;div class="width_50 padding_top pagename_section&lt;?=$pagename_selector['hide']['1']?>" id="pagename_1">

  &lt;?=__('title')?>

&lt;/div></pre>
  </div>

</div>




<?php /************************************************* TOGGLE ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['toggle']?>" id="dev_jstools_toggle">

  <div class="padding_bot">
    <button id="dev_jstools_toggle_button_1" class="button_chain" onclick="toggle_element('dev_jstools_toggle_button_2', 'table-row');">Toggle 1</button>
    <button id="dev_jstools_toggle_button_2" class="button_chain" onclick="toggle_element('dev_jstools_toggle_button_1', 'table-row');">Toggle 2</button>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_toggle_include" onclick="to_clipboard('', 'dev_js_toolbox_toggle_include', 1);">$js = array('common/toggle');</pre>
  </div>

  <pre class="dev_pre_code" id="dev_js_toolbox_toggle" onclick="to_clipboard('', 'dev_js_toolbox_toggle', 1);">// Toggle element
toggle_element('element_id', 'table-row');

// Toggle element one way
toggle_element_oneway('element_id', 1, 'table-row');

// Toggle all elements of given class
toggle_class('class_id', 'table-row');

// Toggle all elements of given class one way
toggle_class_oneway('class_id', 1, 'table-row');</pre>
</div>




<?php /************************************************* UNBLUR ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$dev_jstools_hide['unblur']?>" id="dev_jstools_unblur">

  <div class="padding_bot">
    <button id="dev_jstools_unblur_button" class="blur" onmouseover="unblur(this);">Unblur</button>
  </div>

  <div class="padding_bot">
    <pre class="dev_pre_code" id="dev_js_toolbox_unblur" onclick="to_clipboard('', 'dev_js_toolbox_unblur', 1);">&lt;div class="blur" onmouseover="unblur(this)">Blurry&lt;/div></pre>
  </div>

  <pre class="dev_pre_code" id="dev_js_toolbox_unblur_element" onclick="to_clipboard('', 'dev_js_toolbox_unblur_element', 1);">&lt;div id="unblur_id" class="blur" onmouseover="unblur_element('unblur_id')">Blurry&lt;/div></pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }