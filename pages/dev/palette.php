<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/dev.lang.php';    # Translations
include_once './../../inc/bbcodes.inc.php';  # BBCodes

// Limit page access rights
user_restrict_to_administrators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/palette";
$page_title_en    = "CSS Palette";
$page_title_fr    = "Palette CSS";

// Extra CSS & JS
$css = array('dev');
$js  = array('fetch', 'dev/palette', 'clipboard');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dropdown selector

$css_palette = sanitize_input('POST', 'palette', 'string', 'default');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50">

        <h4 class="align_center">
          <?=__('dev_palette_title')?>
          <select class="inh" id="select_css_palette" onchange="dev_palette_selector();">
            <option value="bbcodes"><?=__('dev_palette_selector_bbcodes')?></option>
            <option value="colors"><?=__('dev_palette_selector_colors')?></option>
            <option value="default" selected><?=__('dev_palette_selector_default')?></option>
            <option value="divs"><?=__('dev_palette_selector_divs')?></option>
            <option value="forms"><?=__('dev_palette_selector_forms')?></option>
            <option value="icons"><?=__('dev_palette_selector_icons')?></option>
            <option value="spacing"><?=__('dev_palette_selector_spacing')?></option>
            <option value="tables"><?=__('dev_palette_selector_tables')?></option>
            <option value="text"><?=__('dev_palette_selector_text')?></option>
            <option value="tooltips"><?=__('dev_palette_selector_tooltips')?></option>
          </select>
        </h4>

      </div>

      <div class="bigpadding_top" id="dev_palette_body">
        <?php } ?>




<?php if($css_palette === 'bbcodes') { ############################################################################# ?>

        <div class="width_30 padding_bot">

        <p>
          [b]Bold[/b] -> <?=bbcodes('[b]Bold[/b]')?><br>
          [i]Italics[/i] -> <?=bbcodes('[i]Italics[/i]')?><br>
          [u]Underline[/u] -> <?=bbcodes('[u]Underline[/u]')?><br>
          [s]Strikethrough[/s] -> <?=bbcodes('[s]Strikethrough[/s]')?><br>
          [blur]Blurry[/blur] -> <?=bbcodes('[blur]Blurry[/blur]')?><br>
          [ins]Insert[/ins] -> <?=bbcodes('[ins]Insert[/ins]')?><br>
          [del]Delete[/del] -> <?=bbcodes('[del]Delete[/del]')?><br>
          [url=http://url]Link[/url] -> <?=bbcodes('[url=http://www.example.com]Link[/url]')?><br>
          [img]http://img.png[/img] -> <?=bbcodes('[img]'.$path.'img/icons/delete_small.svg[/img]')?><br>
          [color=#B00B1E]Color[/color] -> <?=bbcodes('[color=#B00B1E]Colored text[/color]')?><br>
          [space]Indented -> <?=bbcodes('[space]Indented')?><br>
          [size=2]Text size[/size] -> <?=bbcodes('[size=2]Text size[/size]')?>
        </p>

        <p>
          [line]:<br>
          <?=bbcodes('[line]')?>
        </p>

        <p>
          [align=left/center/right]:<br>
          <?=bbcodes('[align=left]Align left[/align]')?>
          <?=bbcodes('[align=center]Align center[/align]')?>
          <?=bbcodes('[align=right]Align right[/align]')?>
        </p>

        <p>
          [code]Code block[/code]:<br>
          <?=bbcodes('[code]Code block[/code]')?>
        </p>

        <p>
          [quote=author]Quoted text[/quote]:<br>
          <?=bbcodes('[quote=author]Quoted text[/quote]')?>
        </p>

        <p>
          [spoiler=topic]Spoily text[/spoiler]:<br>
          <?=bbcodes('[spoiler=topic]Spoily text[/spoiler]')?>
        </p>

        <p>
          [youtube]videoid[/youtube]:<br>
          <?=bbcodes('[youtube]4o5baMYWdtQ[/youtube]')?>
        </p>

        <p>
          [twitter]tweetid[/twitter]:<br>
          <?=bbcodes('[twitter]855477729084440576[/twitter]')?>
        </p>

      </div>

      <hr>

      <div class="width_30 padding_top">

        <p>
          == Title ==<br>
          <?=nbcodes(bbcodes('== Title =='))?>
        </p>

        <p>
          === Subtitle ===<br>
          <?=nbcodes(bbcodes('=== Subtitle ==='))?>
        </p>

        </div>




<?php } else if($css_palette === 'colors') { ####################################################################### ?>

        <div class="width_30">

          <table class="noresize">
            <tbody class="align_center dark">
              <tr>
                <td class="text_dark light">
                  .text_dark
                </td>
                <td class="dark">
                  .dark
                </td>
              </tr>
              <tr>
                <td class="text_black light">
                  .text_black
                </td>
                <td class="black">
                  .black
                </td>
              </tr>
              <tr>
                <td class="text_white">
                  .text_white
                </td>
                <td class="white text_dark">
                  .white
                </td>
              </tr>
              <tr>
                <td class="text_light">
                  .text_light
                </td>
                <td class="light text_dark">
                  .light
                </td>
              </tr>
              <tr>
                <td class="text_yellow">
                  .text_yellow
                </td>
                <td class="yellow">
                  .yellow
                </td>
              </tr>
              <tr>
                <td class="text_orange">
                  .text_orange
                </td>
                <td class="orange">
                  .orange
                </td>
              </tr>
              <tr>
                <td class="text_red">
                  .text_red
                </td>
                <td class="red">
                  .red
                </td>
              </tr>
              <tr>
                <td class="text_purple">
                  .text_purple
                </td>
                <td class="purple">
                  .purple
                </td>
              </tr>
              <tr>
                <td class="text_blue">
                  .text_blue
                </td>
                <td class="blue">
                  .blue
                </td>
              </tr>
              <tr>
                <td class="text_brown">
                  .text_brown
                </td>
                <td class="brown">
                  .brown
                </td>
              </tr>
              <tr>
                <td class="text_green">
                  .text_green
                </td>
                <td class="green">
                  .green
                </td>
              </tr>
            </tbody>
          </table>

        </div>




<?php } else if($css_palette === 'default') { ###################################################################### ?>

        <div class="width_50 padding_bot">

          <p>&lt;p> above a &lt;hr><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum. The ins and del tags are used in diffs. Aliquam ultricies eleifend egestas.
          </p>

        </div>

        <hr>

        <div class="width_50">

          <h1 class="padding_top">&lt;h1> section header</h1>

          <h2 class="smallpadding_top">&lt;h2> section header</h2>

          <h3 class="smallpadding_top">&lt;h3> section header</h3>

          <h4 class="smallpadding_top">&lt;h4> section header</h4>

          <h5 class="smallpadding_top">&lt;h5> section header</h5>

          <h6 class="smallpadding_top">&lt;h6> isn't really much of a section header</h6>

          <p>
            &lt;a> This phrase <a>contains a link</a> inside it.
          </p>

          <div class="padding_top">
            <blockquote>
              &lt;blockquote> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
            </blockquote>
          </div>

          <div class="padding_top">
            <blockquote class="nobackground">
              &lt;blockquote class="nobackground"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
            </blockquote>
          </div>

          <div class="padding_top">
            <pre>&lt;pre> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
  Line breaks are respected in a pre tag and the font is monospace.</pre>
          </div>

          <div class="padding_top">
            <button>&lt;button></button>
            <button disabled>Disabled</button>
          </div>

          <div class="padding_top">
            <button class="bigbutton">&lt;button class="bigbutton"></button>
            <button class="bigbutton" disabled>Disabled</button>
          </div>

          <div class="padding_top">
            <ul>
              <li>
                &lt;ul> &lt;li>
              </li>
              <li>
                The list has to handle line breaks. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
              </li>
              <li>
                Third list element.
              </li>
            </ul>
          </div>

          <label class="padding_top">&lt;label> this is a label</label>
          <legend>&lt;legend> this is a legend</legend>

          <p>
            &lt;ins> &lt;del> <ins>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam <del>vehicula pulvinar mi</del>, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</ins> The ins and del tags are used in diffs. <del>Aliquam ultricies eleifend egestas. Nunc nisi lorem, dapibus et lobortis id, porttitor a diam. Aenean varius ac mauris sed convallis. Nunc in tellus viverra orci aliquet consectetur <ins>eu sit amet sapien.</ins> Maecenas placerat vel purus efficitur rhoncus. Etiam ex ligula, convallis quis laoreet a, bibendum vitae dolor. Suspendisse sagittis, massa ac viverra laoreet, nibh dolor ultrices urna, vel rutrum justo nibh quis lectus.</del>
          </p>

          <img class="bigpadding_top padding_bot" src="<?=$path?>img/common/logo_full.png" alt="logo">

          <p>
            <span style="font-family: 'NoBleme'">font-family: NoBleme.<br>
            Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</span>
          </p>
          <p>
            <span style="font-family: 'NoBleme-bold'">font-family: NoBleme-bold.<br>
            Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</span>
          </p>
          <p>
            <span style="font-family: 'NoBleme-header'">font-family: NoBleme-header.<br>
            Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</span>
          </p>
          <p>
            <span style="font-family: 'NoBleme-submenu'">font-family: NoBleme-submenu.<br>
            Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</span>
          </p>

        </div>




<?php } else if($css_palette === 'divs') { ######################################################################### ?>

        <div class="width_30 padding_bot">

          <p>
            <span class="bold">.hidden:</span> Will always be hidden.<br>
            <span class="bold">.mobile:</span> Will be visible on mobile only.<br>
            <span class="bold">.desktop:</span> Will be visible on desktop only.<br>
          </p>

        </div>

        <hr>

        <div class="padding_top">
          <div class="width_30 dev_div_border align_center">
            <div class="padding_top padding_bot bold">
              div.width_30
            </div>
          </div>
        </div>

        <div class="padding_top">
          <div class="width_40 dev_div_border align_center">
            <div class="padding_top padding_bot bold">
              div.width_40
            </div>
          </div>
        </div>

        <div class="padding_top">
          <div class="width_50 dev_div_border align_center">
            <div class="padding_top padding_bot bold">
              div.width_50
            </div>
          </div>
        </div>

        <div class="padding_top">
          <div class="width_60 dev_div_border align_center">
            <div class="padding_top padding_bot bold">
              div.width_60
            </div>
          </div>
        </div>

        <div class="padding_top">
          <div class="width_70 dev_div_border align_center">
            <div class="padding_top padding_bot bold">
              div.width_70
            </div>
          </div>
        </div>

        <div class="padding_top padding_bot">
          <div class="width_80 dev_div_border align_center">
            <div class="padding_top padding_bot bold">
              div.width_80
            </div>
          </div>
        </div>

        <hr>

        <div class="width_50 padding_top padding_bot">
          <div class="align_center dev_div_border bold">
            .flexcontainer
          </div>
          <div class="flexcontainer align_center dev_div_border bold">
            <div class="flex dev_div_border">
              .flex
            </div>
            <div class="flex dev_div_border">
              .flex
            </div>
            <div class="dev_div_border" style="flex:2">
              flex = 2
            </div>
            <div class="dev_div_border" style="flex:3">
              flex = 3
            </div>
          </div>

          <div class="padding_top">
            <pre class="dev_pre_code" id="dev_palette_flex" onclick="to_clipboard('', 'dev_palette_flex', 1);">&lt;div class="flexcontainer">
  &lt;div class="flex">
    Flex_1
  &lt;/div>
  &lt;div style="flex:2">
    Flex_2
  &lt;/div>
&lt;/div></pre>
          </div>

        </div>

        <hr>

        <div class="width_30 padding_top">
          <div class="scrollbar align_center smallpadding_bot">
            .scrollbar
          </div>
        </div>
        <div class="width_30 padding_top">
          <div class="vscrollbar align_center smallpadding_top smallpadding_bot">
            .vscrollbar
          </div>
        </div>

        </div>




<?php } else if($css_palette === 'forms') { ######################################################################## ?>

        <div class="width_50 bigpadding_bot">

          <pre class="dev_pre_code" id="dev_palette_form" onclick="to_clipboard('', 'dev_palette_form', 1);">&lt;form method="POST">
  &lt;fieldset>

  &lt;/fieldset>
&lt;/form></pre>

        </div>

        <hr>

        <div class="width_50 bigpadding_top bigpadding_bot">

          <div class="smallpadding_bot">
            <label for="dev_palette_input">&lt;label> for &lt;input></label>
            <input id="dev_palette_input" name="dev_palette_input" value='&lt;input> without a type'>
            <input name="dev_palette_input_disabled" value='&lt;input disabled>' disabled>
          </div>

          <div class="smallpadding_bot">
            <label for="dev_palette_input_text">&lt;label> for &lt;input type="text"></label>
            <input type="text" id="dev_palette_input_text" name="dev_palette_input_text" value='&lt;input type="text">'>
            <input type="text" name="dev_palette_input_text_disabled" value='&lt;input disabled type="text">' disabled>
          </div>

          <div class="smallpadding_bot">
            <label for="dev_palette_input_password">&lt;label> for &lt;input type="password"></label>
            <input type="password" id="dev_palette_input_password" name="dev_palette_input_password" value='&lt;input type="password">'>
            <input type="password" name="dev_palette_input_password_disabled" value='&lt;input disabled type="password">' disabled>
          </div>

          <div class="smallpadding_top bigpadding_bot">
            <pre class="dev_pre_code" id="dev_palette_form_input" onclick="to_clipboard('', 'dev_palette_form_input', 1);">&lt;label for="dev_palette_input_text">Label&lt;/label>
&lt;input type="text" id="dev_palette_input_text" name="dev_palette_input_text" value=""></pre>
          </div>

          <label for="dev_palette_select">&lt;label> for &lt;select></label>
          <select id="dev_palette_select" name="dev_palette_select">
            <option selected>&lt;select></option>
            <option>Width scaled to options</option>
          </select>

          <div class="padding_top bigpadding_bot">
            <pre class="dev_pre_code" id="dev_palette_form_select" onclick="to_clipboard('', 'dev_palette_form_select', 1);">&lt;label for="dev_palette_select">&lt;label> for &lt;select>&lt;/label>
&lt;select id="dev_palette_select" name="dev_palette_select">
  &lt;option value="0" selected>&lt;select>&lt;/option>
  &lt;option value="1">Scales to the biggest option width&lt;/option>
&lt;/select></pre>
          </div>

          <label for="dev_palette_textarea">&lt;label> for &lt;textarea></label>
          <textarea id="dev_palette_textarea" name="dev_palette_textarea">Indentation and line breaks and are respected.

Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum. Aliquam ultricies eleifend egestas. Nunc nisi lorem, dapibus et lobortis id, porttitor a diam. Aenean varius ac mauris sed convallis. Nunc in tellus viverra orci aliquet consectetur eu sit amet sapien. Maecenas placerat vel purus efficitur rhoncus. Etiam ex ligula, convallis quis laoreet a, bibendum vitae dolor. Suspendisse sagittis, massa ac viverra laoreet, nibh dolor ultrices urna, vel rutrum justo nibh quis lectus.</textarea>

          <div class="padding_top bigpadding_bot">
            <pre class="dev_pre_code" id="dev_palette_form_textarea" onclick="to_clipboard('', 'dev_palette_form_textarea', 1);">&lt;label for="dev_palette_textarea">Label&lt;/label>
&lt;textarea id="dev_palette_textarea" name="dev_palette_textarea">&lt;/textarea></pre>
          </div>

          <div>
            <input type="checkbox" id="dev_palette_input_checkbox_1" name="dev_palette_input_checkbox[]" value="1">
            <label class="label_inline" for="dev_palette_input_checkbox_1">&lt;label .label_inline> for &lt;input type="checkbox"></label>
            <input type="checkbox" id="dev_palette_input_checkbox_2" name="dev_palette_input_checkbox[]" value="2">
            <label class="label_inline" for="dev_palette_input_checkbox_2">&lt;label .label_inline> for &lt;input type="checkbox"></label><br>
            <input type="checkbox" id="dev_palette_input_checkbox_3" name="dev_palette_input_checkbox[]" value="3">
            <label class="label_inline" for="dev_palette_input_checkbox_3">&lt;label .label_inline> for &lt;input type="checkbox"></label>
            <input type="checkbox" id="dev_palette_input_checkbox_4" name="dev_palette_input_checkbox[]" value="4">
            <label class="label_inline" for="dev_palette_input_checkbox_4">&lt;label .label_inline> for &lt;input type="checkbox"></label>
          </div>

          <div class="padding_top bigpadding_bot">
            <pre class="dev_pre_code" id="dev_palette_form_input_checkbox" onclick="to_clipboard('', 'dev_palette_form_input_checkbox', 1);">&lt;input type="checkbox" id="dev_palette_checkbox_1" name="dev_palette_checkbox[]" value="1">
&lt;label class="label_inline" for="dev_palette_checkbox_1">Label&lt;/label>
&lt;input type="checkbox" id="dev_palette_checkbox_2" name="dev_palette_checkbox[]" value="2">
&lt;label class="label_inline" for="dev_palette_checkbox_2">Label&lt;/label></pre>
          </div>

          <div>
            <input type="radio" id="dev_palette_input_radio_1" name="dev_palette_input_radio[]" value="1">
            <label class="label_inline" for="dev_palette_input_radio_1">&lt;label .label_inline> for &lt;input type="radio"></label>
            <input type="radio" id="dev_palette_input_radio_2" name="dev_palette_input_radio[]" value="2">
            <label class="label_inline" for="dev_palette_input_radio_2">&lt;label .label_inline> for &lt;input type="radio"></label><br>
            <input type="radio" id="dev_palette_input_radio_3" name="dev_palette_input_radio[]" value="3">
            <label class="label_inline" for="dev_palette_input_radio_3">&lt;label .label_inline> for &lt;input type="radio"></label>
            <input type="radio" id="dev_palette_input_radio_4" name="dev_palette_input_radio[]" value="4">
            <label class="label_inline" for="dev_palette_input_radio_4">&lt;label .label_inline> for &lt;input type="radio"></label>
          </div>

          <div class="padding_top bigpadding_bot">
            <pre class="dev_pre_code" id="dev_palette_form_input_radio" onclick="to_clipboard('', 'dev_palette_form_input_radio', 1);">&lt;input type="radio" id="dev_palette_radio_1" name="dev_palette_radio[]" value="1">
&lt;label class="label_inline" for="dev_palette_radio_1">Label&lt;/label>
&lt;input type="radio" id="dev_palette_radio_2" name="dev_palette_radio[]" value="2">
&lt;label class="label_inline" for="dev_palette_radio_2">Label&lt;/label></pre>
          </div>

          <div class="smallpadding_bot">
            <input type="reset" name="dev_palette_input_reset" value="Reset button">
            <input type="reset" name="dev_palette_input_reset_disabled" value="Disabled" disabled>
          </div>

          <div class="smallpadding_bot">
            <input type="submit" name="dev_palette_input_submit" value="Submit button">
            <input type="submit" name="dev_palette_input_submit_disabled" value="Disabled" disabled>
          </div>

          <div class="smallpadding_bot">
            <input type="submit" class="bigbutton" name="dev_palette_input_submit_big" value="Big submit button">
            <input type="submit" class="bigbutton" name="dev_palette_input_submit_big_disabled" value="Disabled" disabled>
          </div>

          <div>
            <button name="dev_palette_input_button"><img class="pointer" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete"></button>
            <button name="dev_palette_input_button_disabled" disabled><img class="pointer" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete"></button>
          </div>

          <div class="padding_top">
            <pre class="dev_pre_code" id="dev_palette_form_input_submit" onclick="to_clipboard('', 'dev_palette_form_input_submit', 1);">&lt;input type="submit" name="dev_palette_input_submit" value="Submit"></pre>
          </div>

        </div>

        <hr>

        <div class="width_50 bigpadding_top">

          <h1 class="padding_bot">
            &lt;h1> with
            <select class="inh" name="dev_palette_select_inh1">
              <option selected>&lt;select class="inh"></option>
              <option>Option</option>
            </select>
          </h1>

          <h1 class="bigpadding_bot">
            &lt;h1> with
            <input type="text" class="inh" name="dev_palette_input_inh1" value='&lt;input class="inh" type="text">'>
          </h1>

          <h5 class="padding_bot">
            &lt;h5> with
            <select class="inh" name="dev_palette_select_inh5">
              <option selected>&lt;select class="inh"></option>
              <option>Option</option>
            </select>
          </h5>

          <h5 class="padding_bot">
            &lt;h5> with
            <input type="text" class="inh" name="dev_palette_input_inh5" value='&lt;input class="inh" type="text">'>
          </h5>

          <p>
            Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. <select class="intext" name="dev_palette_select_intext"><option selected>&lt;select class="intext"></option><option>Option</option></select> Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. <input type="text" class="intext" name="dev_palette_input_intext" value='&lt;input class="intext" type="text"&gt;'> Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.
          </p>

        </div>




<?php } else if($css_palette === 'icons') { ######################################################################## ?>

        <div class="width_50 bigpadding_bot">

          <h1 class="smallpadding_bot">
            &lt;h1> with icons
            <img class="pointer" src="<?=$path?>img/icons/delete.svg" alt="X" title="Delete">
            <img class="pointer" src="<?=$path?>img/icons/settings.svg" alt="S" title="Settings">
            <img class="pointer" src="<?=$path?>img/icons/rss.svg" alt="R" title="RSS feed">
          </h1>

          <pre class="dev_pre_code" id="dev_palette_h1_icons" onclick="to_clipboard('', 'dev_palette_h1_icons', 1);">&lt;h1>
  Title with icons
  &lt;img class="pointer" src="&lt;?=$path?>img/icons/delete.svg" alt="X" title="Delete">
  &lt;img class="pointer" src="&lt;?=$path?>img/icons/settings.svg" alt="S" title="Settings">
  &lt;img class="pointer" src="&lt;?=$path?>img/icons/rss.svg" alt="R" title="RSS feed">
&lt;/h1></pre>

        </div>

        <hr>

        <div class="width_30 bigpadding_top">

          <table>
            <thead>
              <tr>
                <th>
                  NAME
                </th>
                <th>
                  ICON
                </th>
                <th>
                  _SMALL
                </th>
              </tr>
            </thead>
            <tbody class="align_center">

              <tr>
                <td>
                  add
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/add.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  copy
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/copy.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/copy_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  delete
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/delete.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/delete_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  duplicate
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/duplicate.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/duplicate_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  edit
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/edit.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/edit_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  help
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/help.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/help_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  image
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/image.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/image_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  info
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/info.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/info_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  link
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/link.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/link_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  link_external
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/link_external.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/link_external_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  maximize
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/maximize.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  minimize
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/minimize.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  message
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/message.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  more
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/more.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/more_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  refresh
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/refresh.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/refresh_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  rss
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/rss.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  settings
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/settings.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/settings_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  settings_gear
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/settings_gear.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  sort_down
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/sort_down.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  sort_up
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/sort_up.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/sort_up_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  stats
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/stats.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/stats_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  upload
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/upload.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  user
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  user_add
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_add.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_add_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  user_confirm
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_confirm.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_confirm_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  user_delete
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_delete.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/user_delete_small.svg" alt="X">
                </td>
              </tr>
              <tr>
                <td>
                  warning
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/warning.svg" alt="X">
                </td>
                <td>
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td>
                  x
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/x.svg" alt="X">
                </td>
                <td>
                  <img class="valign_middle" src="<?=$path?>img/icons/x_small.svg" alt="X">
                </td>
              </tr>

            </tbody>
          </table>
        </div>


<?php } else if($css_palette === 'spacing') { ###################################################################### ?>

        <div class="width_30">

          <p class="align_justify">
            .align_justify:<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
          </p>

          <p class="align_left">
            .align_left:<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
          </p>

          <p class="align_center">
            .align_center:<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
          </p>

          <p class="align_right">
            .align_right:<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
          </p>

        </div>

        <hr>

        <div class="width_30">
          <div class="padding_top padding_bot">
            <table class="align_center">
              <tbody>
                <tr>
                  <td class="dev_td_valign valign_top">
                    .valign_top
                  </td>
                  <td class="dev_td_valign valign_middle">
                    .valign_middle
                  </td>
                  <td class="dev_td_valign valign_bottom">
                    .valign_bottom
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <hr>

        <div class="width_70 padding_top">

          <div class="smallpadding_bot">
            <div class="dev_div_spacing indiv align_center">
              .indiv / .intable
            </div>
          </div>

          <div class="smallpadding_bot">
            <div class="dev_div_spacing indented">
              .indented
            </div>
            <div class="dev_div_spacing spaced">
              .spaced
            </div>
            <div class="dev_div_spacing spaced_left">
              .spaced_left
            </div>
            <div class="dev_div_spacing spaced_right">
              .spaced_right
            </div>
            <div class="dev_div_spacing nospaced">
              .nospaced
            </div>
          </div>

          <div class="smallpadding_bot">
            <div class="dev_div_spacing nopadding">
              .nopadding
            </div>
            <div class="dev_div_spacing tinypadding_top">
              .tinypadding_top
            </div>
            <div class="dev_div_spacing smallpadding_top">
              .smallpadding_top
            </div>
            <div class="dev_div_spacing padding_top">
              .padding_top
            </div>
            <div class="dev_div_spacing bigpadding_top">
              .bigpadding_top
            </div>
            <div class="dev_div_spacing hugepadding_top">
              .hugepadding_top
            </div>
            <div class="dev_div_spacing megapadding_top">
              .megapadding_top
            </div>
            <div class="dev_div_spacing gigapadding_top">
              .gigapadding_top
            </div>
          </div>

          <div>
            <div class="dev_div_spacing nopadding">
              .nopadding
            </div>
            <div class="dev_div_spacing tinypadding_bot">
              .tinypadding_bot
            </div>
            <div class="dev_div_spacing smallpadding_bot">
              .smallpadding_bot
            </div>
            <div class="dev_div_spacing padding_bot">
              .padding_bot
            </div>
            <div class="dev_div_spacing bigpadding_bot">
              .bigpadding_bot
            </div>
            <div class="dev_div_spacing hugepadding_bot">
              .hugepadding_bot
            </div>
            <div class="dev_div_spacing megapadding_bot">
              .megapadding_bot
            </div>
            <div class="dev_div_spacing gigapadding_bot">
              .gigapadding_bot
            </div>
          </div>

        </div>




<?php } else if($css_palette === 'tables') { ####################################################################### ?>

        <div class="width_50 padding_bot">

          <table>
            <thead>
              <tr>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
              </tr>
              <tr>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
              </tr>
              <tr>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
              </tr>
              <tr>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
                <td>
                  body
                </td>
              </tr>
            </tbody>
          </table>

          <div class="padding_top">
            <pre class="dev_pre_code" id="dev_palette_table" onclick="to_clipboard('', 'dev_palette_table', 1);">&lt;table>
  &lt;thead>

    &lt;tr>
      &lt;th>
        HEADER
      &lt;/th>
    &lt;/tr>

  &lt;/thead>
  &lt;tbody>

    &lt;tr>
      &lt;td>
        body
      &lt;/td>
    &lt;/tr>

  &lt;/tbody>
&lt;/table></pre>
          </div>

        </div>

        <hr>

        <div class="width_50 padding_bot">

          <form class="padding_bot" method="post">
            <fieldset>
              <table>
                <thead>
                  <tr>
                    <th>
                      HEADER
                      <img class="pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="Sort data">
                    </th>
                    <th>
                      HEADER
                      <img class="pointer valign_middle" src="<?=$path?>img/icons/sort_down_small.svg" alt="v" title="Sort data">
                    </th>
                    <th>
                      ICONS
                    </th>
                  </tr>
                  <tr>
                    <th>
                      <select class="table_search" name="dev_palette_table_select">
                        <option>&lt;select class="table_search"></option>
                        <option>&lt;select class="table_search"></option>
                        <option>&lt;select class="table_search"></option>
                      </select>
                    </th>
                    <th>
                      <input type="text" class="table_search" name="dev_palette_table_input" value='&lt;input class="table_search">'>
                    </th>
                    <th>
                      <input type="submit" class="table_search" name="dev_palette_table_submit" value=".table_search">
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      body text
                    </td>
                    <td>
                      body text
                    </td>
                    <td class="align_center">
                      <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/help_small.svg" alt="?" title="Details">
                      <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/refresh_small.svg" alt="R" title="Refresh">
                      <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      body text
                    </td>
                    <td>
                      body text
                    </td>
                    <td class="align_center">
                      <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/help_small.svg" alt="?" title="Details">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      body text
                    </td>
                    <td>
                      body text
                    </td>
                      &nbsp;
                    </td>
                  </tr>
                  <tr>
                    <td>
                      body text
                    </td>
                    <td>
                      body text
                    </td>
                    <td class="align_center">
                      <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/help_small.svg" alt="?" title="Details">
                      <img class="valign_middle pointer spaced" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="Delete">
                    </td>
                  </tr>
                </tbody>
              </table>
            </fieldset>
          </form>

          <pre class="dev_pre_code" id="dev_palette_table_icons" onclick="to_clipboard('', 'dev_palette_table_icons', 1);">&lt;form method="post">
  &lt;fieldset>

    &lt;table>
      &lt;thead>

        &lt;tr>
          &lt;th>
            HEADER
            &lt;img class="pointer valign_middle" src="&lt;?=$path?>img/icons/sort_down_small.svg" alt="v" title="Sort data">
          &lt;/th>
          &lt;th>
            HEADER
            &lt;img class="pointer valign_middle" src="&lt;?=$path?>img/icons/sort_down_small.svg" alt="v" title="Sort data">
          &lt;/th>
          &lt;th>
            ICONS
          &lt;/th>
        &lt;/tr>

        &lt;tr>

          &lt;th>
            &lt;select class="table_search" name="dev_palette_table_select">
              &lt;option value="0">Option&lt;/option>
            &lt;/select>
          &lt;/th>

          &lt;th>
            &lt;input type="text" class="table_search" name="dev_palette_table_input" value="">
          &lt;/th>

          &lt;th>
            &lt;input type="submit" class="table_search" name="dev_palette_table_submit" value="Search">
          &lt;/th>

        &lt;/tr>

      &lt;/thead>
      &lt;tbody>

        &lt;tr>
          &lt;td>
            body
          &lt;/td>
          &lt;td>
            body
          &lt;/td>
          &lt;td class="align_center">
            &lt;img class="valign_middle pointer spaced" src="&lt;?=$path?>img/icons/help_small.svg" alt="?" title="Details">
            &lt;img class="valign_middle pointer spaced" src="&lt;?=$path?>img/icons/delete_small.svg" alt="X" title="Delete">
          &lt;/td>
        &lt;/tr>

      &lt;/tbody>
    &lt;/table>

  &lt;/fieldset>
&lt;/form></pre>

        </div>

        <hr>

        <div class="width_50 padding_top padding_bot">

          <table class="noresize">
            <thead>
              <tr>
                <th>
                  NO RESIZING
                </th>
                <th>
                  OF COLUMNS
                </th>
                <th>
                  NO MATTER THEIR WIDTH
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  no resizing of columns no matter
                </td>
                <td>
                  their
                </td>
                <td>
                  width
                </td>
              </tr>
              <tr>
                <td>
                  .noresize
                </td>
                <td>
                  .noresize
                </td>
                <td>
                  .noresize
                </td>
              </tr>
            </tbody>
          </table>

          <div class="padding_top">
            <pre class="dev_pre_code" id="dev_palette_table_noresize" onclick="to_clipboard('', 'dev_palette_table_noresize', 1);">&lt;table class="noresize">
  &lt;thead>

    &lt;tr>
      &lt;th>
        HEADER
      &lt;/th>
    &lt;/tr>

  &lt;/thead>
  &lt;tbody>

    &lt;tr>
      &lt;td>
        body
      &lt;/td>
    &lt;/tr>

  &lt;/tbody>
&lt;/table></pre>
          </div>

        </div>

        <hr>

      <div class="width_50 padding_top">

          <table>
            <thead>
              <tr>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
                <th>
                  HEADER
                </th>
              </tr>
            </thead>
            <tbody class="altc">
            <tr>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
              </tr>
              <tr>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
              </tr>
              <tr>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
              </tr>
              <tr>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
              </tr>
              <tr>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
              </tr>
              <tr>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
                <td>
                  tbody.altc
                </td>
              </tr>
            </tbody>
          </table>

          <div class="padding_top">
            <pre class="dev_pre_code" id="dev_palette_table_altc" onclick="to_clipboard('', 'dev_palette_table_altc', 1);">&lt;table>
  &lt;thead>

    &lt;tr>
      &lt;th>
        HEADER
      &lt;/th>
    &lt;/tr>

  &lt;/thead>
  &lt;tbody class="altc">

    &lt;tr>
      &lt;td>
        body
      &lt;/td>
    &lt;/tr>

  &lt;/tbody>
&lt;/table></pre>
          </div>

        </div>




<?php } else if($css_palette === 'text') { ######################################################################## ?>

        <div class="width_30">

          <p class="align_center">
            <span class="small">.small text</span><br>
            Normal<br>
            <span class="big">.big text</span><br>
            <span class="bigger">.bigger text</span><br>
            <span class="biggest">.biggest text</span>
          </p>

          <p class="align_center">
            <span class="bold">.bold text</span><br>
            <span class="notbold">.notbold text</span><br>
            <span class="italics">.italics text</span><br>
            <span class="underlined">.underlined text</span><br>
            <span class="strikethrough">.strikethrough text</span><br>
            <span class="pointer">.pointer (hover me)</span><br>
          </p>

          <p class="align_center">
            <span class="noglow">.noglow text</span><br>
            <span class="glowhover">.glowhover text</span><br>
            <span class="smallglow">.smallglow text</span><br>
            <span class="glow">.glow text</span><br>
            <span class="bigglow">.bigglow text</span><br>
          </p>

          <p>
            .blur<br>
            <span class="blur">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.</span>
          </p>

          <p class="clearfix">
            .clearfix<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam.
            <button class="float_left">.float_left</button>
            Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui.
            <button class="float_right">.float_right</button>
            Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum. The ins and del tags are used in diffs. Aliquam ultricies eleifend egestas.
          </p>

          <p class="nowrap">
            .nowrap<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam.
          </p>

          <p class="dowrap">
            .dowrap<br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam.
          </p>

        </div>




<?php } else if($css_palette === 'tooltips') { ##################################################################### ?>

        <div class="width_30">

          <div class="padding_bot">
            <div class="tooltip_container">
              &lt;div class="tooltip_container"> Hover me.
              <div class="tooltip">
                &lt;div class="tooltip">
              </div>
            </div>
          </div>

          <div class="padding_bot">
            <div class="tooltip_container">
              <img src="<?=$path?>img/common/logo_full.png" alt="logo">
              <div class="tooltip">
                <div class="padding_bot">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod.
                </div>
                <img src="<?=$path?>img/common/logo_full.png" alt="logo">
                <div class="padding_top">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod.
                </div>
              </div>
            </div>
          </div>

          <pre class="dev_pre_code" id="dev_palette_tooltip" onclick="to_clipboard('', 'dev_palette_tooltip', 1);">&lt;div class="tooltip_container">
  Text
  &lt;div class="tooltip">
    Tooltip
  &lt;/div>
&lt;/div></pre>

        </div>




<?php } ############################################################################################################ ?>

        <?php if(!page_is_fetched_dynamically()) { ?>
      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }