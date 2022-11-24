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
$js  = array('common/editor', 'common/highlight', 'common/preview', 'common/selector', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$jstoolbox_selector_entries = array(  'fetch'             ,
                                      'toggle'            ,
                                      'css'               ,
                                      'forms'             ,
                                      'clipboard'         ,
                                      'editor'            ,
                                      'highlight'         ,
                                      'preview'           ,
                                      'section_selector'  ,);

// Define the default dropdown menu entry
$jstoolbox_selector_default = 'fetch';

// Initialize the page section selector data
$jstoolbox_selector = page_section_selector(            $jstoolbox_selector_entries  ,
                                              default:  $jstoolbox_selector_default  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>
      <?=__('dev_js_toolbox_title')?>
      <select class="inh" id="dev_jstools_selector" onchange="page_section_selector('dev_jstools', '<?=$jstoolbox_selector_default?>');">
        <option value="fetch"<?=$jstoolbox_selector['menu']['fetch']?>><?=__('dev_js_toolbox_fetch')?></option>
        <option value="toggle"<?=$jstoolbox_selector['menu']['toggle']?>><?=__('dev_js_toolbox_toggle')?></option>
        <option value="css"<?=$jstoolbox_selector['menu']['css']?>><?=__('dev_js_toolbox_css')?></option>
        <option value="forms"<?=$jstoolbox_selector['menu']['forms']?>><?=__('dev_js_toolbox_forms')?></option>
        <option value="clipboard"<?=$jstoolbox_selector['menu']['clipboard']?>>clipoard.js</option>
        <option value="editor"<?=$jstoolbox_selector['menu']['editor']?>>editor.js</option>
        <option value="highlight"<?=$jstoolbox_selector['menu']['highlight']?>>highlight.js</option>
        <option value="preview"<?=$jstoolbox_selector['menu']['preview']?>>preview.js</option>
        <option value="section_selector"<?=$jstoolbox_selector['menu']['section_selector']?>>selector.js</option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************* FETCH ****************************************************/ ?>

<div class="padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['fetch']?>" id="dev_jstools_fetch">

  <div class="width_50 padding_bot">
    <pre class="dev_pre_code dev_pre_code_nomax" style="max-height:100%;" id="dev_js_toolbox_fetch" onclick="to_clipboard('', 'dev_js_toolbox_fetch', 1);">// Only fetch the data if the form is properly filled up
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




<?php /************************************************* TOGGLE ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['toggle']?>" id="dev_jstools_toggle">

  <div class="padding_bot">
    <button id="dev_jstools_toggle_button_1" class="button_chain" onclick="toggle_element('dev_jstools_toggle_button_2', 'table-row');">Toggle 1</button>
    <button id="dev_jstools_toggle_button_2" class="button_chain" onclick="toggle_element('dev_jstools_toggle_button_1', 'table-row');">Toggle 2</button>
  </div>

  <div class="smallpadding_bot">
    <pre id="dev_js_toolbox_toggle_element" onclick="to_clipboard('', 'dev_js_toolbox_toggle_element', 1);">// Toggles the visibility of a specific element
toggle_element('element_id', 'table-row');
toggle_element_oneway('element_id', 1, 'table-row');</pre>
  </div>

  <div class="smallpadding_bot">
    <pre id="dev_js_toolbox_toggle_class" onclick="to_clipboard('', 'dev_js_toolbox_toggle_class', 1);">// Toggles the visibility of all elements with a specific class
toggle_class('class_id', 'table-row');
toggle_class_oneway('class_id', 1, 'table-row');</pre>
  </div>

  <pre id="dev_js_toolbox_toggle_detect" onclick="to_clipboard('', 'dev_js_toolbox_toggle_detect', 1);">// Detects the current visibility state of an element
if element_is_toggled('element_id')
  return true;</pre>

</div>




<?php /******************************************** CSS MANIPULATION **********************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['css']?>" id="dev_jstools_css">

  <div class="padding_bot">
    <button id="dev_js_toolbox_class_manipulation" disabled>Text</button>
    <button onclick="css_add('dev_js_toolbox_class_manipulation', ['strikethrough', 'italics', 'glow']);">+</button>
    <button onclick="css_remove('dev_js_toolbox_class_manipulation', ['strikethrough', 'italics', 'glow']);">-</button>
  </div>

  <div class="smallpadding_bot">
    <pre id="dev_js_toolbox_css_add" onclick="to_clipboard('', 'dev_js_toolbox_css_add', 1);">css_add('element_name', 'class_name');</pre>
  </div>

  <div class="padding_bot">
    <pre id="dev_js_toolbox_css_add_array" onclick="to_clipboard('', 'dev_js_toolbox_css_add_array', 1);">css_add('element_name', ['array', 'of', 'classes']);</pre>
  </div>

  <div class="smallpadding_bot">
    <pre id="dev_js_toolbox_css_remove" onclick="to_clipboard('', 'dev_js_toolbox_css_remove', 1);">css_remove('element_name', 'class_name');</pre>
  </div>

  <div class="bigpadding_bot">
    <pre id="dev_js_toolbox_css_remove_array" onclick="to_clipboard('', 'dev_js_toolbox_css_remove_array', 1);">css_remove('element_name', ['array', 'of', 'classes']);</pre>
  </div>

  <div class="padding_bot">
    <button id="dev_jstools_unblur_button" class="blur" onmouseover="unblur(this);">Unblur</button>
  </div>

  <div class="smallpadding_bot">
    <pre id="dev_js_toolbox_unblur_element" onclick="to_clipboard('', 'dev_js_toolbox_unblur_element', 1);">unblur_element('element_id');</pre>
  </div>

  <pre id="dev_js_toolbox_unblur" onclick="to_clipboard('', 'dev_js_toolbox_unblur', 1);">&lt;div class="blur" onmouseover="unblur(this)">Blurry&lt;/div></pre>

</div>




<?php /************************************************** FORMS ***************************************************/ ?>

<div class="padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['forms']?>" id="dev_jstools_forms">

  <div class="width_50">

    <div class="smallpadding_bot">
      <label for="dev_js_toolbox_require_field" id="dev_js_toolbox_require_field_label">Label</label>
      <input id="dev_js_toolbox_require_field" name="dev_js_toolbox_require_field" class="indiv" type="text">
    </div>

    <div class="bigpadding_bot">
      <button class="button" onclick="if(form_require_field('dev_js_toolbox_require_field', 'dev_js_toolbox_require_field_label')) { alert('OK!'); } else { alert('ERROR!'); };"><?=__('submit')?></button>
    </div>

    <div class="padding_bot">
      <pre id="dev_js_toolbox_form_require_example" onclick="to_clipboard('', 'dev_js_toolbox_form_require_example', 1);">&lt;label for="form_input" id="form_input_label">&lt;?=__('label')?>&lt;/label>
&lt;input id="form_input" name="form_input" class="indiv" type="text">

&lt;button class="button" onclick="form_require_field('form_input', 'form_input_label');">&lt;?=__('submit')?>&lt;/button></pre>
    </div>

    <div class="bigpadding_bot">
      <pre id="dev_js_toolbox_form_require" onclick="to_clipboard('', 'dev_js_toolbox_form_require', 1);">if(form_require_field('input_id', 'label_id'))
  action;</pre>
    </div>

  </div>

  <div class="width_60">
    <pre>/**
 * Ensures that a form element is properly filled.
 *
 * @param   {string}  element_id  The ID of a form element that should not be empty.
 * @param   {string}  label_id    The ID of the label associated with said element.
 *
 * @returns {int}                 0 if the field is empty, 1 if the field is filled.
 */</pre>
  </div>

</div>




<?php /************************************************ CLIPBOARD *************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['clipboard']?>" id="dev_jstools_clipboard">

  <div class="padding_bot">
    <pre id="dev_js_toolbox_editor_include" onclick="to_clipboard('', 'dev_js_toolbox_editor_include', 1);">$js = array('common/clipboard');</pre>
  </div>

  <pre id="dev_js_toolbox_cliboard" onclick="to_clipboard('', 'dev_js_toolbox_cliboard', 1);">&lt;pre id="lorem_id" onclick="to_clipboard('', 'lorem_id', 1);">Lorem clipboardum&lt;/pre></pre>

</div>




<?php /************************************************* EDITOR ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['editor']?>" id="dev_jstools_editor">

  <div class="smallpadding_bot">
    <?php
    $editor_target_element  = 'dev_jstools_editor_in';
    $preview_output         = 'dev_jstools_editor_out';
    $preview_path           = $path;
    include './../../inc/editor.inc.php';
    ?>
    <textarea id="dev_jstools_editor_in" onkeyup="preview_bbcodes('dev_jstools_editor_in', 'dev_jstools_editor_out');">&nbsp;</textarea>
    <div class="smallpadding_top" id="dev_jstools_editor_out"></div>
  </div>

  <div class="padding_bot">
    <pre id="dev_js_toolbox_editor_include" onclick="to_clipboard('', 'dev_js_toolbox_editor_include', 1);">$js = array('common/editor', 'common/preview');</pre>
  </div>

  <pre id="dev_js_toolbox_editor" onclick="to_clipboard('', 'dev_js_toolbox_editor', 1);">&lt;?php
$editor_target_element  = 'target_id';
$preview_output         = 'output_id';
$preview_path           = $path;
include './../../inc/editor.inc.php';
?>

&lt;textarea id="target_id" onkeyup="preview_bbcodes('target_id', 'output_id');">&lt;?=__('target_id')?>&lt;/textarea>

&lt;div id="output_id">&lt;/div></pre>

</div>




<?php /*********************************************** HIGHLIGHT **************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['highlight']?>" id="dev_jstools_highlight">

  <div class="padding_bot">
    <pre id="dev_jstools_highlight_test" onclick="select_element('dev_jstools_highlight_test');">Lorem highlightium</pre>
  </div>

  <div class="padding_bot">
    <pre id="dev_js_toolbox_highlight_include" onclick="to_clipboard('', 'dev_js_toolbox_highlight_include', 1);">$js = array('common/highlight');</pre>
  </div>

  <pre id="dev_js_toolbox_highlight" onclick="to_clipboard('', 'dev_js_toolbox_highlight', 1);">&lt;pre id="lorem_id" onclick="select_element('lorem_id');">Lorem highlightium&lt;/pre></pre>

</div>




<?php /************************************************ PREVIEW ***************************************************/ ?>

<div class="width_40 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['preview']?>" id="dev_jstools_preview">

  <div class="smallpadding_bot">
    <textarea id="dev_jstools_preview_in" onkeyup="preview_bbcodes('dev_jstools_preview_in', 'dev_jstools_preview_out');"><?=__('dev_jstools_preview_in')?></textarea>
    <div class="smallpadding_top" id="dev_jstools_preview_out"></div>
  </div>

  <div class="padding_bot">
    <pre id="dev_js_toolbox_preview_include" onclick="to_clipboard('', 'dev_js_toolbox_preview_include', 1);">$js = array('common/preview');</pre>
  </div>

  <pre id="dev_js_toolbox_preview" onclick="to_clipboard('', 'dev_js_toolbox_preview', 1);">
&lt;textarea id="target_id" onkeyup="preview_bbcodes('target_id', 'output_id');">&lt;?=__('target_id')?>&lt;/textarea>

&lt;div id="output_id">&lt;/div></pre>

</div>




<?php /******************************************** SECTION SELECTOR **********************************************/ ?>

<div class="width_70 padding_top dev_jstools_section<?=$jstoolbox_selector['hide']['section_selector']?>" id="dev_jstools_section_selector">

  <div class="padding_bot">
    <pre id="dev_js_toolbox_selector_include" onclick="to_clipboard('', 'dev_js_toolbox_selector_include', 1);">$js = array('common/selector');</pre>
  </div>

  <div class="padding_bot">
    <pre id="dev_js_toolbox_selector_setup" onclick="to_clipboard('', 'dev_js_toolbox_selector_setup', 1);">///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    <pre id="dev_js_toolbox_selector_menu" onclick="to_clipboard('', 'dev_js_toolbox_selector_menu', 1);">&lt;div class="padding_bot align_center section_selector_container">

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
    <pre id="dev_js_toolbox_selector_section" onclick="to_clipboard('', 'dev_js_toolbox_selector_section', 1);">&lt;?php /************************************************ SECTION ***************************************************/ ?>

&lt;div class="width_50 padding_top pagename_section&lt;?=$pagename_selector['hide']['1']?>" id="pagename_1">

  &lt;?=__('title')?>

&lt;/div></pre>
  </div>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }