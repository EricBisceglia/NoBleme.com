<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';  # Core
include_once './../../actions/dev.act.php';   # Actions
include_once './../../lang/dev.lang.php';     # Translations
include_once './../../inc/bbcodes.inc.php';   # BBCodes

// Limit page access rights
user_restrict_to_administrators();

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/doc_css_palette";
$page_title_en    = "CSS Palette";
$page_title_fr    = "Palette CSS";

// Extra CSS & JS
$css = array('dev');
$js  = array('common/toggle', 'common/selector');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Page section selector

// Define the dropdown menu entries
$palette_selector_entries = array(  'bbcodes'   ,
                                    'colors'    ,
                                    'default'   ,
                                    'divs'      ,
                                    'forms'     ,
                                    'grids'     ,
                                    'icons'     ,
                                    'popins'    ,
                                    'spacing'   ,
                                    'tables'    ,
                                    'text'      ,
                                    'tooltips'  );

// Define the default dropdown menu entry
$palette_selector_default = 'default';

// Initialize the page section selector data
$palette_selector = page_section_selector(            $palette_selector_entries  ,
                                            default:  $palette_selector_default  );




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center section_selector_container">

  <fieldset>
    <h5>
      <?=__('submenu_admin_doc_css').__(':')?>
      <select class="inh" id="dev_palette_selector" onchange="page_section_selector('dev_palette', '<?=$palette_selector_default?>');">
        <option value="bbcodes"<?=$palette_selector['menu']['bbcodes']?>><?=__('bbcodes')?></option>
        <option value="colors"<?=$palette_selector['menu']['colors']?>><?=__('dev_palette_selector_colors')?></option>
        <option value="default"<?=$palette_selector['menu']['default']?>><?=__('dev_palette_selector_default')?></option>
        <option value="divs"<?=$palette_selector['menu']['divs']?>><?=__('dev_palette_selector_divs')?></option>
        <option value="forms"<?=$palette_selector['menu']['forms']?>><?=__('dev_palette_selector_forms')?></option>
        <option value="grids"<?=$palette_selector['menu']['grids']?>><?=__('dev_palette_selector_grids')?></option>
        <option value="icons"<?=$palette_selector['menu']['icons']?>><?=__('dev_palette_selector_icons')?></option>
        <option value="popins"<?=$palette_selector['menu']['popins']?>><?=__('dev_palette_selector_popins')?></option>
        <option value="spacing"<?=$palette_selector['menu']['spacing']?>><?=__('dev_palette_selector_spacing')?></option>
        <option value="tables"<?=$palette_selector['menu']['tables']?>><?=__('dev_palette_selector_tables')?></option>
        <option value="text"<?=$palette_selector['menu']['text']?>><?=string_change_case(__('text'), 'initials')?></option>
        <option value="tooltips"<?=$palette_selector['menu']['tooltips']?>><?=__('dev_palette_selector_tooltips')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************* BBCODES **************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['bbcodes']?>" id="dev_palette_bbcodes">

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

  </div>

  <hr>

  <div class="width_30 padding_top">

    <p class="smallpadding_bot">
      [nsfw]Censored[/nsfw] -> <?=nbcodes(bbcodes('[nsfw]Censored[/nsfw]'))?><br>
      [page:page_name|Compendium link] -> <?=nbcodes(bbcodes('[page:page_name|Compendium link]'))?><br>
      [nobleme:pages/dev/doc_css_palette|Internal link] -> <?=nbcodes(bbcodes('[nobleme:pages/dev/doc_css_palette|Internal link]'))?><br>
      [link:https://nobleme.com|External link] -> <?=nbcodes(bbcodes('[link:https://nobleme.com|External link]'))?><br>
      [source:1] -> <?=nbcodes(bbcodes('[source:1]'))?><br>
      [sources:1|Description] -> <?=nbcodes(bbcodes('[sources:1|Description]'))?>
    </p>

    <p>
      [menu][/menu]<br>
      [menuitem:anchor_name|Menu item title]<br>
      [anchor:anchor_name]<br>
      <?=nbcodes(bbcodes('[menu][menuitem:anchor_link|Menu item title]<br>[menuitem:anchor_link|Other menu entry][/menu]'))?>
    </p>

    <p>
      == Title ==<br>
      <?=nbcodes(bbcodes('== Title =='))?>
    </p>

    <p>
      === Subtitle ===<br>
      <?=nbcodes(bbcodes('=== Subtitle ==='))?>
    </p>

    <p class="smallpadding_bot">
      [copypasta=id]Lorem pasta[/copypasta]<br>
      <?=nbcodes(bbcodes('[copypasta=id]Lorem pasta[/copypasta]'))?>
    </p>

    <p class="smallpadding_bot">
      [copypasta-nsfw=id]Lorem pasta[/copypasta-nsfw]<br>
      <?=nbcodes(bbcodes('[copypasta-nsfw=id]Lorem pasta[/copypasta-nsfw]'))?>
    </p>

    <p class="smallpadding_bot">
      [trends:test]<br>
      [trends5:one|two|three|four|five]<br>
      <br>
      <?=nbcodes(bbcodes('[trends5:one|two|three|four|five]'))?>
    </p>

    <p>
      [image:ah_original.jpg|left|Image description]<br>
      <br>
      <?=nbcodes(bbcodes('[image:ah_original.jpg|left|Image description]'))?>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
    </p>

    <p>
      [image-nsfw:ah_original.jpg|right]<br>
      <br>
      <?=nbcodes(bbcodes('[image-nsfw:ah_original.jpg|right]'))?>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam.
    </p>

    <p>
      [youtube:XE6YaLtctcI|left|Video description]<br>
      <br>
      <?=nbcodes(bbcodes('[youtube:XE6YaLtctcI|left|Video description]'))?>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in.
    </p>

    <p>
      [youtube-nsfw:XE6YaLtctcI|right]<br>
      <br>
      <?=nbcodes(bbcodes('[youtube-nsfw:XE6YaLtctcI|right]'))?>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
    </p>

  </div>

  <div class="width_50">

    <p>
      [gallery]<br>
      [gallery:ah_original.jpg|Description]<br>
      [gallery-nsfw:ah_original.jpg]<br>
      [gallery-youtube:XE6YaLtctcI]<br>
      [gallery-youtube-nsfw:XE6YaLtctcI|Description]<br>
      [/gallery]<br>
      <br>
      <?=nbcodes(bbcodes('[gallery]
      [gallery:ah_original.jpg|Description]
      [gallery-nsfw:ah_original.jpg]
      [gallery-youtube:XE6YaLtctcI]
      [gallery-youtube-nsfw:XE6YaLtctcI|Description]
      [/gallery]'))?>
    </p>

  </div>

</div>




<?php /************************************************* COLORS ***************************************************/ ?>

<div class="width_50 padding_top dev_palette_section<?=$palette_selector['hide']['colors']?>" id="dev_palette_colors">

  <table class="noresize">
    <tbody class="align_center dark">
      <tr>
        <td class="text_dark light">
          .text_dark
        </td>
        <td class="dark">
          .dark
        </td>
        <td class="black text_light dark_hover">
          .dark_hover
        </td>
        <td class="black text_light text_dark_hover">
          .text_dark_hover
        </td>
      </tr>
      <tr>
        <td class="text_black light">
          .text_black
        </td>
        <td class="black">
          .black
        </td>
        <td class="dark text_light black_hover">
          .black_hover
        </td>
        <td class="dark text_light text_black_hover">
          .text_black_hover
        </td>
      </tr>
      <tr>
        <td class="text_white">
          .text_white
        </td>
        <td class="white text_dark">
          .white
        </td>
        <td class="dark text_light white_hover">
          .white_hover
        </td>
        <td class="dark text_light text_white_hover">
          .text_white_hover
        </td>
      </tr>
      <tr>
        <td class="text_light">
          .text_light
        </td>
        <td class="light text_dark">
          .light
        </td>
        <td class="dark text_white light_hover">
          .light_hover
        </td>
        <td class="dark text_white text_light_hover">
          .text_light_hover
        </td>
      </tr>
      <tr>
        <td class="text_yellow">
          .text_yellow
        </td>
        <td class="yellow">
          .yellow
        </td>
        <td class="dark text_light yellow_hover">
          .yellow_hover
        </td>
        <td class="dark text_light text_yellow_hover">
          .text_yellow_hover
        </td>
      </tr>
      <tr>
        <td class="text_orange">
          .text_orange
        </td>
        <td class="orange">
          .orange
        </td>
        <td class="dark text_light orange_hover">
          .orange_hover
        </td>
        <td class="dark text_light text_orange_hover">
          .text_orange_hover
        </td>
      </tr>
      <tr>
        <td class="text_red">
          .text_red
        </td>
        <td class="red">
          .red
        </td>
        <td class="dark text_light red_hover">
          .red_hover
        </td>
        <td class="dark text_light text_red_hover">
          .text_red_hover
        </td>
      </tr>
      <tr>
        <td class="text_purple">
          .text_purple
        </td>
        <td class="purple">
          .purple
        </td>
        <td class="dark text_light purple_hover">
          .purple_hover
        </td>
        <td class="dark text_light text_purple_hover">
          .text_purple_hover
        </td>
      </tr>
      <tr>
        <td class="text_blue">
          .text_blue
        </td>
        <td class="blue">
          .blue
        </td>
        <td class="dark text_light blue_hover">
          .blue_hover
        </td>
        <td class="dark text_light text_blue_hover">
          .text_blue_hover
        </td>
      </tr>
      <tr>
        <td class="text_brown">
          .text_brown
        </td>
        <td class="brown">
          .brown
        </td>
        <td class="dark text_light brown_hover">
          .brown_hover
        </td>
        <td class="dark text_light text_brown_hover">
          .text_brown_hover
        </td>
      </tr>
      <tr>
        <td class="text_green">
          .text_green
        </td>
        <td class="green">
          .green
        </td>
        <td class="dark text_light green_hover">
          .green_hover
        </td>
        <td class="dark text_light text_green_hover">
          .text_green_hover
        </td>
      </tr>
    </tbody>
  </table>

</div>




<?php /************************************************* DEFAULT **************************************************/ ?>

<div class="dev_palette_section<?=$palette_selector['hide']['default']?>" id="dev_palette_default">

  <div class="width_50">

    <h1 class="padding_top">&lt;h1> section header</h1>

    <h2 class="smallpadding_top">&lt;h2> section header</h2>

    <h3 class="smallpadding_top">&lt;h3> section header</h3>

    <h4 class="smallpadding_top">&lt;h4> section header</h4>

    <h5 class="smallpadding_top">&lt;h5> section header</h5>

    <h6 class="smallpadding_top">&lt;h6> isn't really much of a section header</h6>

    <p>
      &lt;p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. &lt;/p>
    </p>

    <p>
      &lt;a> This phrase <a>contains a link</a> inside it. This is a <a class="forced_link">.forced_link</a>.
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
      <button class="button_chain">&lt;button class="button_chain"></button>
      <button class="button_chain">space</button>
      <button class="button_chain" disabled>Disabled</button>
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
      <span style="font-family: 'NoBleme-alt'">font-family: NoBleme-alt.<br>
      Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</span>
    </p>
    <p>
      <span style="font-family: 'NoBleme-alt-bold'">font-family: NoBleme-alt-bold.<br>
      Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum.</span>
    </p>

  </div>

</div>




<?php /************************************************** DIVS ****************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['divs']?>" id="dev_palette_divs">

  <div class="width_30 padding_bot">

    <p>
      <span class="bold">.hidden:</span> Will always be hidden.<br>
      <br>
      <span class="bold">.desktop:</span> Will be visible on desktop only.<br>
      <span class="bold">.desktop_wide:</span> Will be visible on widescreen desktops only.<br>
      <br>
      <span class="bold">.mobile:</span> Will be visible on mobile only.<br>
      <span class="bold">.mobile_table:</span> Same as .mobile, for table elements.<br>
      <span class="bold">.mobile_inline:</span> Same as .mobile, for inline elements.<br>
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

  <div class="padding_top">
    <div class="width_80 dev_div_border align_center">
      <div class="padding_top padding_bot bold">
        div.width_80
      </div>
    </div>
  </div>

  <div class="padding_top">
    <div class="width_90 dev_div_border align_center">
      <div class="padding_top padding_bot bold">
        div.width_90
      </div>
    </div>
  </div>

  <div class="padding_top padding_bot">
    <div class="width_100 dev_div_border align_center">
      <div class="padding_top padding_bot bold">
        div.width_100
      </div>
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
  <div class="width_30 padding_top">
    <div class="autoscroll align_center smallpadding_top smallpadding_bot">
      .autoscroll
    </div>
  </div>

  </div>

</div>



<?php /************************************************* FORMS ****************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['forms']?>" id="dev_palette_forms">

  <div class="width_50 padding_bot">

  <pre class="dev_pre_code" id="dev_palette_form" onclick="to_clipboard('', 'dev_palette_form', 1);">&lt;form method="POST">
  &lt;fieldset>

  &lt;/fieldset>
&lt;/form></pre>

  </div>

  <div class="width_50 padding_top bigpadding_bot">

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
      <pre class="dev_pre_code" id="dev_palette_form_input" onclick="to_clipboard('', 'dev_palette_form_input', 1);">&lt;label for="example_input">&lt;?=__('nobleme')?>&lt;/label>
&lt;input type="text" id="example_input" name="example_input" value=""></pre>
    </div>

    <label for="dev_palette_select">&lt;label> for &lt;select></label>
    <select id="dev_palette_select" name="dev_palette_select">
      <option selected>&lt;select></option>
      <option>Width scaled to options</option>
    </select>

    <div class="padding_top bigpadding_bot">
      <pre class="dev_pre_code" id="dev_palette_form_select" onclick="to_clipboard('', 'dev_palette_form_select', 1);">&lt;label for="example_select">&lt;?=__('nobleme')?>&lt;/label>
&lt;select id="example_select" name="example_select">
  &lt;option value="0" selected>&lt;?=__('nobleme')?>&lt;/option>
&lt;/select></pre>
    </div>

    <label for="dev_palette_textarea">&lt;label> for &lt;textarea></label>
    <textarea id="dev_palette_textarea" name="dev_palette_textarea">Indentation and line breaks and are respected.

Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum. Aliquam ultricies eleifend egestas. Nunc nisi lorem, dapibus et lobortis id, porttitor a diam. Aenean varius ac mauris sed convallis. Nunc in tellus viverra orci aliquet consectetur eu sit amet sapien. Maecenas placerat vel purus efficitur rhoncus. Etiam ex ligula, convallis quis laoreet a, bibendum vitae dolor. Suspendisse sagittis, massa ac viverra laoreet, nibh dolor ultrices urna, vel rutrum justo nibh quis lectus.</textarea>

    <div class="smallpadding_top">
      <label for="dev_palette_textarea">&lt;textarea class="higher"></label>
      <textarea class="higher">Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum. Aliquam ultricies eleifend egestas. Nunc nisi lorem, dapibus et lobortis id, porttitor a diam. Aenean varius ac mauris sed convallis. Nunc in tellus viverra orci aliquet consectetur eu sit amet sapien. Maecenas placerat vel purus efficitur rhoncus. Etiam ex ligula, convallis quis laoreet a, bibendum vitae dolor. Suspendisse sagittis, massa ac viverra laoreet, nibh dolor ultrices urna, vel rutrum justo nibh quis lectus.

Lorem ipsum dolor sit ame, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod. Nunc aliquet in quam nec elementum. Aliquam ultricies eleifend egestas. Nunc nisi lorem, dapibus et lobortis id, porttitor a diam. Aenean varius ac mauris sed convallis. Nunc in tellus viverra orci aliquet consectetur eu sit amet sapien. Maecenas placerat vel purus efficitur rhoncus. Etiam ex ligula, convallis quis laoreet a, bibendum vitae dolor. Suspendisse sagittis, massa ac viverra laoreet, nibh dolor ultrices urna, vel rutrum justo nibh quis lectus.</textarea>
    </div>

    <div class="padding_top bigpadding_bot">
      <pre class="dev_pre_code" id="dev_palette_form_textarea" onclick="to_clipboard('', 'dev_palette_form_textarea', 1);">&lt;label for="example_textarea">&lt;?=__('nobleme')?>&lt;/label>
&lt;textarea id="example_textarea" name="example_textarea">&lt;/textarea></pre>
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

    <div class="padding_top padding_bot">
      <pre class="dev_pre_code" id="dev_palette_form_input_checkbox" onclick="to_clipboard('', 'dev_palette_form_input_checkbox', 1);">&lt;input type="checkbox" id="example_checkbox" name="example_checkbox">
&lt;label class="label_inline" for="example_checkbox">&lt;?=__('nobleme')?>&lt;/label></pre>
    </div>

    <div class="bigpadding_bot">
      <pre class="dev_pre_code" id="dev_palette_form_input_multi_checkbox" onclick="to_clipboard('', 'dev_palette_form_input_multi_checkbox', 1);">&lt;input type="checkbox" id="example_checkbox_1" name="example_checkbox[]" value="1">
&lt;label class="label_inline" for="example_checkbox_1">&lt;?=__('nobleme')?>&lt;/label>
&lt;input type="checkbox" id="example_checkbox_2" name="example_checkbox[]" value="2">
&lt;label class="label_inline" for="example_checkbox_2">&lt;?=__('nobleme')?>&lt;/label></pre>
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
      <pre class="dev_pre_code" id="dev_palette_form_input_radio" onclick="to_clipboard('', 'dev_palette_form_input_radio', 1);">&lt;input type="radio" id="example_radio_1" name="example_radio[]" value="1">
&lt;label class="label_inline" for="example_radio_1">&lt;?=__('nobleme')?>&lt;/label>
&lt;input type="radio" id="example_radio_2" name="example_radio[]" value="2">
&lt;label class="label_inline" for="example_radio_2">&lt;?=__('nobleme')?>&lt;/label></pre>
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
      <input type="submit" class="bigbutton" name="dev_palette_input_submit_big" value=".bigbutton">
      <input type="submit" class="bigbutton" name="dev_palette_input_submit_big_disabled" value="Disabled" disabled>
    </div>

    <div class="smallpadding_bot">
      <input type="submit" class="button_chain" name="dev_palette_input_submit" value=".button_chain">
      <input type="submit" class="button_chain" name="dev_palette_input_submit" value=".button_chain">
      <input type="submit" class="button_chain" name="dev_palette_input_submit" value=".button_chain">
    </div>

    <div>
      <button name="dev_palette_input_button"><img class="icon valign_middle pointer" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="<?=__('delete')?>"></button>
      <button name="dev_palette_input_button_disabled" disabled><img class="icon valign_middle pointer" src="<?=$path?>img/icons/delete_small.svg" alt="X" title="<?=__('delete')?>"></button>
    </div>

    <div class="padding_top">
      <pre class="dev_pre_code" id="dev_palette_form_input_submit" onclick="to_clipboard('', 'dev_palette_form_input_submit', 1);">&lt;input type="submit" name="example_submit" value="&lt;?=__('nobleme')?>"></pre>
    </div>

  </div>

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

</div>




<?php /************************************************* GRIDS ****************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['grids']?>" id="dev_palette_grids">

  <div class="width_50 padding_bot">
    <div class="align_center dev_div_border bold">
      .flexcontainer
    </div>
    <div class="flexcontainer align_center dev_div_border bold">
      <div class="flex autoflex dev_div_border">
        .autoflex
      </div>
      <div class="flex autoflex dev_div_border">
        .autoflex
      </div>
      <div class="flex autoflex dev_div_border">
        .autoflex
      </div>
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

  <div class="width_50 padding_top">

    <div class="padding_bot">
      <div style="grid-template-columns: repeat(3, 1fr);" class="gridcontainer align_center dev_div_border">
        <div style="grid-column: 1 / 1" class="dev_div_border">
          grid-column: 1 / 1
        </div>
        <div style="grid-column: 2 / 4" class="dev_div_border">
          grid-column: 2 / 4
        </div>
        <div style="grid-row: 2 / 5" class="dev_div_border gridcontainer gridcenter">
          grid-row: 2 / 5<br>
          gridcenter
        </div>
        <div class="dev_div_border">
          Normal div
        </div>
        <div class="dev_div_border">
          Normal div
        </div>
        <div style="grid-column: 2 / 4; grid-row: 3 / 5" class="dev_div_border">
          grid-column: 2 / 4<br>
          grid-row: 3 / 5
        </div>
      </div>
    </div>

    <pre class="dev_pre_code" id="dev_palette_grid" onclick="to_clipboard('', 'dev_palette_grid', 1);">&lt;div style="grid-template-columns: repeat(3, 1fr);" class="gridcontainer">
  &lt;div style="grid-column: 1 / 1" class="red">
    &nbsp;
  &lt;/div>
  &lt;div style="grid-column: 2 / 4" class="white">
    &nbsp;
  &lt;/div>
  &lt;div style="grid-row: 2 / 5" class="blue gridcontainer gridcenter">
    &nbsp;
  &lt;/div>
  &lt;div class="purple">
    &nbsp;
  &lt;/div>
  &lt;div class="orange">
    &nbsp;
  &lt;/div>
  &lt;div style="grid-column: 2 / 4; grid-row: 3 / 5" class="brown">
    &nbsp;
  &lt;/div>
&lt;/div></pre>

  </div>

</div>




<?php /************************************************* ICONS ****************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['icons']?>" id="dev_palette_icons">

  <div class="width_50 padding_bot">

    <h1 class="smallpadding_bot">
      &lt;h1> with icons
      <?=__icon('delete', alt: 'X', title: __('delete'))?>
      <?=__icon('settings', alt: 'X', title: __('settings'))?>
      <?=__icon('rss', alt: 'X', title: __('rss'))?>
    </h1>

    <pre class="dev_pre_code" id="dev_palette_h1_icons" onclick="to_clipboard('', 'dev_palette_h1_icons', 1);">&lt;h1>
  Title with icons
  &lt;?=__icon('delete', alt: 'X', title: __('delete'))?>
  &lt;?=__icon('settings', alt: 'X', title: __('settings'))?>
  &lt;?=__icon('rss', alt: 'X', title: __('rss'))?>
&lt;/h1></pre>

  </div>

  <div class="width_30 padding_top">

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
            <?=__icon('add', alt: '+', title: __('add'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('add', 'add', 1, '+')."');")?>
          </td>
          <td>
            <?=__icon('add', is_small: true, alt: '+', title: __('add'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('add', 'add', 1, '+', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            calendar
          </td>
          <td>
            <?=__icon('calendar', alt: 'C', title: __('calendar'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('calendar', 'calendar', 1, 'C')."');")?>
          </td>
          <td>
            <?=__icon('calendar', is_small: true, alt: 'C', title: __('calendar'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('calendar', 'calendar', 1, 'C', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            clock
          </td>
          <td>
            <?=__icon('clock', alt: 'C', title: __('clock'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('clock', 'clock', 1, 'C')."');")?>
          </td>
          <td>
            <?=__icon('clock', is_small: true, alt: 'C', title: __('clock'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('clock', 'clock', 1, 'C', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            copy
          </td>
          <td>
            <?=__icon('copy', alt: 'C', title: __('copy'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('copy', 'copy', 1, 'C')."');")?>
          </td>
          <td>
            <?=__icon('copy', is_small: true, alt: 'C', title: __('copy'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('copy', 'copy', 1, 'C', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            delete
          </td>
          <td>
            <?=__icon('delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('delete', 'delete', 1, 'X')."');")?>
          </td>
          <td>
            <?=__icon('delete', is_small: true, alt: 'C', title: __('delete'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('delete', 'delete', 1, 'X', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            done
          </td>
          <td>
            <?=__icon('done', alt: 'D', title: __('done'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('done', 'done', 1, 'D')."');")?>
          </td>
          <td>
            <?=__icon('done', is_small: true, alt: 'D', title: __('done'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('done', 'done', 1, 'D', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            duplicate
          </td>
          <td>
            <?=__icon('duplicate', alt: 'D', title: __('duplicate'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('duplicate', 'duplicate', 1, 'D')."');")?>
          </td>
          <td>
            <?=__icon('duplicate', is_small: true, alt: 'D', title: __('duplicate'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('duplicate', 'duplicate', 1, 'D', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            edit
          </td>
          <td>
            <?=__icon('edit', alt: 'E', title: __('edit'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('edit', 'edit', 1, 'E')."');")?>
          </td>
          <td>
            <?=__icon('edit', is_small: true, alt: 'E', title: __('edit'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('edit', 'edit', 1, 'E', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            graph
          </td>
          <td>
            <?=__icon('graph', alt: 'G', title: __('graph'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('graph', 'graph', 1, 'G')."');")?>
          </td>
          <td>
            <?=__icon('graph', is_small: true, alt: 'G', title: __('graph'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('graph', 'graph', 1, 'G', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            help
          </td>
          <td>
            <?=__icon('help', alt: '?', title: __('help'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('help', 'help', 1, '?')."');")?>
          </td>
          <td>
            <?=__icon('help', is_small: true, alt: '?', title: __('help'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('help', 'help', 1, '?', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            image
          </td>
          <td>
            <?=__icon('image', alt: 'P', title: __('image'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('image', 'image', 1, 'P')."');")?>
          </td>
          <td>
            <?=__icon('image', is_small: true, alt: 'P', title: __('image'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('image', 'image', 1, 'P', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            info
          </td>
          <td>
            <?=__icon('info', alt: 'I', title: __('info'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('info', 'info', 1, 'I')."');")?>
          </td>
          <td>
            <?=__icon('info', is_small: true, alt: 'I', title: __('info'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('info', 'info', 1, 'I', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            link
          </td>
          <td>
            <?=__icon('link', alt: 'L', title: __('link'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('link', 'link', 1, 'L')."');")?>
          </td>
          <td>
            <?=__icon('link', is_small: true, alt: 'L', title: __('link'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('link', 'link', 1, 'L', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            link_external
          </td>
          <td>
            <?=__icon('link_external', alt: 'L', title: __('link'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('link_external', 'link', 1, 'L')."');")?>
          </td>
          <td>
            <?=__icon('link_external', is_small: true, alt: 'L', title: __('link'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('link_external', 'link', 1, 'L', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            maximize
          </td>
          <td>
            <?=__icon('maximize', alt: 'M', title: __('maximize'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('maximize', 'maximize', 1, 'M')."');")?>
          </td>
          <td>
            <?=__icon('maximize', is_small: true, alt: 'M', title: __('maximize'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('maximize', 'maximize', 1, 'M', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            minimize
          </td>
          <td>
            <?=__icon('minimize', alt: 'M', title: __('minimize'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('minimize', 'minimize', 1, 'M')."');")?>
          </td>
          <td>
            <?=__icon('minimize', is_small: true, alt: 'M', title: __('minimize'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('minimize', 'minimize', 1, 'M', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            message
          </td>
          <td>
            <?=__icon('message', alt: 'M', title: __('message'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('message', 'message', 1, 'M')."');")?>
          </td>
          <td>
            <?=__icon('message', is_small: true, alt: 'M', title: __('message'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('message', 'message', 1, 'M', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            more
          </td>
          <td>
            <?=__icon('more', alt: '+', title: __('more'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('more', 'more', 1, '+')."');")?>
          </td>
          <td>
            <?=__icon('more', is_small: true, alt: '+', title: __('more'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('more', 'more', 1, '+', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            refresh
          </td>
          <td>
            <?=__icon('refresh', alt: 'R', title: __('refresh'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('refresh', 'refresh', 1, 'R')."');")?>
          </td>
          <td>
            <?=__icon('refresh', is_small: true, alt: 'R', title: __('refresh'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('refresh', 'refresh', 1, 'R', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            rss
          </td>
          <td>
            <?=__icon('rss', alt: 'R', title: __('rss'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('rss', 'rss', 1, 'R')."');")?>
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
            <?=__icon('settings', alt: 'S', title: __('settings'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('settings', 'settings', 1, 'S')."');")?>
          </td>
          <td>
            <?=__icon('settings', is_small: true, alt: 'S', title: __('settings'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('settings', 'settings', 1, 'S', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            settings_gear
          </td>
          <td>
            <?=__icon('settings_gear', alt: 'S', title: __('settings'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('settings_gear', 'settings', 1, 'S')."');")?>
          </td>
          <td>
            <?=__icon('settings_gear', is_small: true, alt: 'S', title: __('settings'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('settings_gear', 'settings', 1, 'S', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            sort_down
          </td>
          <td>
            <?=__icon('sort_down', alt: 'S', title: __('sort'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('sort_down', 'sort', 1, 'S')."');")?>
          </td>
          <td>
            <?=__icon('sort_down', is_small: true, alt: 'S', title: __('sort'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('sort_down', 'sort', 1, 'S', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            sort_up
          </td>
          <td>
            <?=__icon('sort_up', alt: 'S', title: __('sort'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('sort_up', 'sort', 1, 'S')."');")?>
          </td>
          <td>
            <?=__icon('sort_up', is_small: true, alt: 'S', title: __('sort'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('sort_up', 'sort', 1, 'S', 'true')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            star
          </td>
          <td>
            <?=__icon('star', alt: 'S', title: __('star'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('star', 'star', 1, 'S')."');")?>
          </td>
          <td>
            <?=__icon('star', is_small: true, alt: 'S', title: __('star'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('star', 'star', 1, 'S', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            stats
          </td>
          <td>
            <?=__icon('stats', alt: 'S', title: __('stats'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('stats', 'stats', 1, 'S')."');")?>
          </td>
          <td>
            <?=__icon('stats', is_small: true, alt: 'S', title: __('stats'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('stats', 'stats', 1, 'S', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            upload
          </td>
          <td>
            <?=__icon('upload', alt: 'U', title: __('upload'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('upload', 'upload', 1, 'U')."');")?>
          </td>
          <td>
            <?=__icon('upload', is_small: true, alt: 'U', title: __('upload'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('upload', 'upload', 1, 'U', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            user
          </td>
          <td>
            <?=__icon('user', alt: 'U', title: __('user'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user', 'user', 1, 'U')."');")?>
          </td>
          <td>
            <?=__icon('user', is_small: true, alt: 'U', title: __('user'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user', 'user', 1, 'U', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            user_add
          </td>
          <td>
            <?=__icon('user_add', alt: '+', title: __('add'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user_add', 'add', 1, '+')."');")?>
          </td>
          <td>
            <?=__icon('user_add', is_small: true, alt: '+', title: __('add'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user_add', 'add', 1, '+', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            user_confirm
          </td>
          <td>
            <?=__icon('user_confirm', alt: 'O', title: __('confirm'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user_confirm', 'confirm', 1, 'O')."');")?>
          </td>
          <td>
            <?=__icon('user_confirm', is_small: true, alt: 'O', title: __('confirm'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user_confirm', 'confirm', 1, 'O', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            user_delete
          </td>
          <td>
            <?=__icon('user_delete', alt: 'X', title: __('delete'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user_delete', 'delete', 1, 'X')."');")?>
          </td>
          <td>
            <?=__icon('user_delete', is_small: true, alt: 'X', title: __('delete'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('user_delete', 'delete', 1, 'X', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            warning
          </td>
          <td>
            <?=__icon('warning', alt: '!', title: __('warning'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('warning', 'warning', 1, '!')."');")?>
          </td>
          <td>
            <?=__icon('warning', is_small: true, alt: '!', title: __('warning'), title_case: 'initials', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('warning', 'warning', 1, '!', 'small')."');")?>
          </td>
        </tr>
        <tr>
          <td>
            x
          </td>
          <td>
            <?=__icon('x', alt: 'X', title: 'X', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('x', 'X', 1, 'X')."');")?>
          </td>
          <td>
            <?=__icon('x', is_small: true, alt: 'X', title: 'X', onclick: "to_clipboard('".dev_doc_icon_to_clipboard('x', 'X', 1, 'X', 'small')."');")?>
          </td>
        </tr>

      </tbody>
    </table>
  </div>

</div>


<?php /************************************************* POPINS ***************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['popins']?>" id="dev_palette_popins">

  <div class="width_30">

    <div class="padding_bot">
      <a href="#popin_demo">Click me</a>
    </div>

    <div id="popin_demo" class="popin_background">
      <div class="popin_body">
        <a class="popin_close" onclick="popin_close('popin_demo');">&times;</a>
        <p class="nopadding_top">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu. Aliquam vehicula pulvinar mi, vitae imperdiet purus rutrum in. Etiam pulvinar volutpat fermentum. Morbi justo ligula, blandit at eros at, viverra placerat dui. Integer tempus porta sapien eget euismod.</p>
      </div>
    </div>

    <pre class="dev_pre_code" id="dev_palette_popin" onclick="to_clipboard('', 'dev_palette_popin', 1);">&lt;a href="#example_popin">Popin&lt;/a>

&lt;div id="example_popin" class="popin_background">
  &lt;div class="popin_body">
    &lt;a class="popin_close" onclick="popin_close('example_popin');">&amp;times;&lt;/a>
    &lt;p class="nopadding_top">Body&lt;/p>
  &lt;/div>
&lt;/div></pre>

  </div>

</div>




<?php /************************************************ SPACING ***************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['spacing']?>" id="dev_palette_spacing">

  <div class="width_30">

    <p class="align_justify">
      .align_justify:<br>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
    </p>

    <p class="align_desktop">
      .align_desktop:<br>
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

  <div class="width_30 padding_top">
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

  <div class="width_70 padding_top">

    <div class="smallpadding_bot">
      <div class="dev_div_spacing indiv align_center">
        .indiv / .intable
      </div>
    </div>

    <div class="smallpadding_bot">
      <div class="dev_div_spacing nospaced">
        .nospaced
      </div>
      <div class="dev_div_spacing spaced">
        .spaced
      </div>
      <div class="dev_div_spacing indented">
        .indented
      </div>
    </div>

    <div class="smallpadding_bot">
      <div class="dev_div_spacing spaced_left">
        .spaced_left
      </div>
      <div class="dev_div_spacing bigspaced_left">
        .bigspaced_left
      </div>
      <div class="dev_div_spacing spaced_right">
        .spaced_right
      </div>
      <div class="dev_div_spacing bigspaced_right">
        .bigspaced_right
      </div>
    </div>

    <div class="smallpadding_bot">
      <div class="dev_div_spacing nopadding">
        .nopadding
      </div>
      <div class="dev_div_spacing nopadding_top">
        .nopadding_top
      </div>
      <div class="dev_div_spacing nopadding_bot">
        .nopadding_bot
      </div>
    </div>

    <div class="smallpadding_bot">
      <div class="dev_div_spacing nopadding">
        .nopadding
      </div>
      <div class="dev_div_spacing nopadding_top">
        .nopadding_top
      </div>
      <div class="dev_div_spacing nopadding_bot">
        .nopadding_bot
      </div>
    </div>

    <div class="smallpadding_bot">
      <div class="dev_div_spacing gigapadding_top">
        .gigapadding_top
      </div>
      <div class="dev_div_spacing megapadding_top">
        .megapadding_top
      </div>
      <div class="dev_div_spacing hugepadding_top">
        .hugepadding_top
      </div>
      <div class="dev_div_spacing bigpadding_top">
        .bigpadding_top
      </div>
      <div class="dev_div_spacing padding_top">
        .padding_top
      </div>
      <div class="dev_div_spacing smallpadding_top">
        .smallpadding_top
      </div>
      <div class="dev_div_spacing tinypadding_top">
        .tinypadding_top
      </div>
    </div>

    <div>
      <div class="dev_div_spacing gigapadding_bot">
        .gigapadding_bot
      </div>
      <div class="dev_div_spacing megapadding_bot">
        .megapadding_bot
      </div>
      <div class="dev_div_spacing hugepadding_bot">
        .hugepadding_bot
      </div>
      <div class="dev_div_spacing bigpadding_bot">
        .bigpadding_bot
      </div>
      <div class="dev_div_spacing padding_bot">
        .padding_bot
      </div>
      <div class="dev_div_spacing smallpadding_bot">
        .smallpadding_bot
      </div>
      <div class="dev_div_spacing tinypadding_bot">
        .tinypadding_bot
      </div>
    </div>

  </div>

</div>




<?php /************************************************* TABLES ***************************************************/ ?>

<div class="padding_top dev_palette_section<?=$palette_selector['hide']['tables']?>" id="dev_palette_tables">

  <div class="width_50 bigpadding_bot">

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
      <pre class="dev_pre_code" id="dev_palette_table" onclick="to_clipboard('', 'dev_palette_table', 1);">&ltdiv class="autoscroll">
  &lt;table>
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
  &lt;/table>
&lt;/div></pre>
    </div>

  </div>

  <div class="width_50 padding_top bigpadding_bot">

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

  <div class="width_50 padding_top bigpadding_bot">

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

  <div class="width_50 padding_top bigpadding_bot">

    <form class="padding_bot" method="post">
      <fieldset>
        <table>
          <thead>
            <tr>
              <th>
                HEADER
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
              </th>
              <th>
                HEADER
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
              </th>
              <th>
                HEADER
                <?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
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
                <input type="text" class="table_search" name="dev_palette_table_input" value='size="1"' size="1">
              </th>
              <th>
                <input type="submit" class="table_search" name="dev_palette_table_submit" value=".table_search">
              </th>
            </tr>
          </thead>
          <tbody class="altc2">
            <tr>
              <td colspan="4" class="uppercase text_light dark bold align_center">
                XX results found
              </td>
            </tr>
            <tr>
              <td>
                body text
              </td>
              <td>
                body text
              </td>
              <td>
                body text
              </td>
              <td class="align_center">
                <?=__icon('help', is_small: true, class: 'valign_middle pointer spaced', alt: '?', title: __('details'), title_case: 'initials')?>
                <?=__icon('refresh', is_small: true, class: 'valign_middle pointer spaced', alt: 'R', title: __('refresh'), title_case: 'initials')?>
                <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials')?>
              </td>
            </tr>
            <tr>
              <td>
                body text
              </td>
              <td>
                body text
              </td>
              <td>
                body text
              </td>
              <td class="align_center">
                <?=__icon('help', is_small: true, class: 'valign_middle pointer spaced', alt: '?', title: __('details'), title_case: 'initials')?>
              </td>
            </tr>
            <tr>
              <td>
                body text
              </td>
              <td>
                body text
              </td>
              <td>
                body text
              </td>
              <td>
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
              <td>
                body text
              </td>
              <td class="align_center">
                <?=__icon('refresh', is_small: true, class: 'valign_middle pointer spaced', alt: 'R', title: __('refresh'), title_case: 'initials')?>
                <?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials')?>
              </td>
            </tr>
          </tbody>
        </table>
      </fieldset>
    </form>

    <pre class="dev_pre_code" id="dev_palette_table_icons_header" onclick="to_clipboard('', 'dev_palette_table_icons_header', 1);">
  &lt;thead>

  &lt;tr>
    &lt;th>
      HEADER
      &lt;?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
    &lt;/th>
    &lt;th>
      HEADER
      &lt;?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
    &lt;/th>
    &lt;th>
      HEADER
      &lt;?=__icon('sort_down', is_small: true, alt: 'v', title: __('sort'), title_case: 'initials')?>
    &lt;/th>
    &lt;th>
      ICONS
    &lt;/th>
  &lt;/tr>

  &lt;tr>

    &lt;th>
      &lt;input type="text" class="table_search" name="example_input" id="example_input" value="">
    &lt;/th>

    &lt;th>
      &lt;input type="text" class="table_search" name="example_input" id="example_input" value="" size="1">
    &lt;/th>

    &lt;th>
      &lt;select class="table_search" name="example_select" id="example_select">
        &lt;option value="0">&amp;nbsp;&lt;/option>
      &lt;/select>
    &lt;/th>

    &lt;th>
      &lt;input type="submit" class="table_search" name="example_submit" id="example_submit" value="&lt;?=string_change_case(__('search'), 'initials')?>">
    &lt;/th>

  &lt;/tr>

&lt;/thead></pre>

    <div class="smallpadding_top">
      <pre class="dev_pre_code" id="dev_palette_table_icons_body" onclick="to_clipboard('', 'dev_palette_table_icons_body', 1);">
  &lt;tbody class="altc2">

  &lt;tr>
    &lt;td colspan="4" class="uppercase text_light dark bold align_center">
      XX results found
    &lt;/td>
  &lt;/tr>

  &lt;tr>
    &lt;td>
      body
    &lt;/td>
    &lt;td>
      body
    &lt;/td>
    &lt;td>
      body
    &lt;/td>
    &lt;td class="align_center">
      &lt?=__icon('help', is_small: true, class: 'valign_middle pointer spaced', alt: '?', title: __('details'), title_case: 'initials')?>
      &lt?=__icon('delete', is_small: true, class: 'valign_middle pointer spaced', alt: 'X', title: __('delete'), title_case: 'initials')?>
    &lt;/td>
  &lt;/tr>

&lt;/tbody></pre>
    </div>

  </div>

  <div class="width_50 padding_top bigpadding_bot">

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
        </tr>
      </thead>
      <tbody class="doublealtc align_center">
        <tr>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
          <td>
            tbody.doublealtc
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
      </tbody>
    </table>

  </div>

  <div class="width_50 padding_top bigpadding_bot">

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
        </tr>
      </thead>
      <tbody class="doublealtc2 align_center">
        <tr>
          <td colspan="3" class="uppercase text_light dark bold align_center">
            XX results found
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
        <tr>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
          <td>
            tbody.doublealtc2
          </td>
        </tr>
        <tr>
          <td colspan="3">
            Hidden content goes here
          </td>
        </tr>
      </tbody>
    </table>

  </div>

  <div class="width_30 padding_top">

    <table>
      <thead>
        <tr class="row_separator_dark">
          <th>
            HEADER
          </th>
        </tr>
      </thead>
      <tbody class="align_center">
        <tr class="row_separator_dark">
          <td>
            &lt;tr class="row_separator_dark"&gt;
          </td>
        </tr>
        <tr>
          <td>
            &lt;tr class="row_separator_dark"&gt;
          </td>
        </tr>
        <tr class="row_separator_dark_thin">
          <td>
            &lt;tr class="row_separator_dark_thin"&gt;
          </td>
        </tr>
        <tr>
          <td>
            &lt;tr class="row_separator_dark_thin"&gt;
          </td>
        </tr>
      </tbody>
    </table>

  </div>

</div>




<?php /************************************************** TEXT ****************************************************/ ?>

<div class="width_30 padding_top dev_palette_section<?=$palette_selector['hide']['text']?>" id="dev_palette_text">

  <p class="align_center">
    <span class="smallest">.smallest text</span><br>
    <span class="smaller">.smaller text</span><br>
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
    <span class="monospace">.monospace text</span><br>
    <span class="uppercase">.uppercase text</span><br>
    <span class="pointer">.pointer (hover me)</span>
  </p>

  <p class="align_center">
    <span class="noglow">.noglow text</span><br>
    <span class="smallglow">.smallglow text</span><br>
    <span class="glow">.glow text</span><br>
    <span class="bigglow">.bigglow text</span><br>
    <span class="hugeglow">.hugeglow text</span><br>
    <span class="glow_dark">.glow_dark text</span><br>
    <span class="bigglow_dark">.bigglow_dark text</span><br>
    <span class="hugeglow_dark">.hugeglow_dark text</span><br>
    <span class="glowhover">.glowhover (hover me)</span>
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
    <button class="float_left float_above">.float_left .float_above</button>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam. Sed mattis pharetra eleifend. Integer nulla diam, tincidunt vel dignissim et, mollis nec arcu.
  </p>

  <p class="nowrap">
    .nowrap<br>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam.
  </p>

  <p class="dowrap">
    .dowrap<br>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam risus nulla, tempor a risus ac, consectetur suscipit quam.
  </p>

  <p class="break_words">
    .break_words<br>
    Loremipsumdolorsitamet,consecteturadipiscingelit.Etiamrisusnulla,temporarisusac,consectetursuscipitquam.Loremipsumdolorsitamet,consecteturadipiscingelit.
  </p>

</div>




<?php /************************************************ TOOLTIPS **************************************************/ ?>

<div class="width_30 padding_top dev_palette_section<?=$palette_selector['hide']['tooltips']?>" id="dev_palette_tooltips">

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

  <div class="padding_bot padding_top">
    <div class="tooltip_container">
      &lt;div class="tooltip_container tooltip_desktop"><br>
      Hover me, this will work on desktop but not on mobile.
      <div class="tooltip">
        &lt;div class="tooltip">
      </div>
    </div>
  </div>

  <pre class="dev_pre_code" id="dev_palette_tooltip_desktop" onclick="to_clipboard('', 'dev_palette_tooltip_desktop', 1);">&lt;div class="tooltip_container tooltip_desktop">
  Text
  &lt;div class="tooltip">
    Tooltip
  &lt;/div>
&lt;/div></pre>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }