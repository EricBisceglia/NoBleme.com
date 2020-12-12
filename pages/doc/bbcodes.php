<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';      # Core
include_once './../../inc/bbcodes.inc.php';       # BBCodes
include_once './../../lang/doc/bbcodes.lang.php'; # Translations

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/doc/bbcodes";
$page_title_en    = "BBCodes";
$page_title_fr    = "BBCodes";
$page_description = "Guide on available BBCodes and how to use them on NoBleme.";




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

<div class="width_50">

  <h1>
    <?=__('bbcodes')?>
  </h1>

  <h5>
    <?=__('bbcodes_subtitle')?>
  </h5>

  <p class="padding_bot">
    <?=__('bbcodes_intro')?>
  </p>

  <table>
    <thead>

      <tr class="uppercase">
        <th>
          <?=__('bbcodes_bbcode')?>
        </th>
        <th>
          <?=__('bbcodes_effect')?>
        </th>
        <th>
          <?=__('bbcodes_result')?>
        </th>
      </tr>

    </thead>
    <tbody class="altc align_center valign_middle">

      <tr>
        <td class="nowrap monospace">
          [url][/url]<br>
          [url=X][/url]
        </td>
        <td class="bold nowrap">
          <?=__('link')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_link')?><br>
          <?=bbcodes(__('bbcodes_doc_link'))?><br>
          <br>
          <?=__('bbcodes_doc_link_full')?><br>
          <?=bbcodes(__('bbcodes_doc_link_full'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [img][/img]
        </td>
        <td class="bold nowrap">
          <?=__('image')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_image')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_image'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [b][/b]
        </td>
        <td class="bold nowrap">
          <?=__('bold')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_bold')?><br>
          <?=bbcodes(__('bbcodes_doc_bold'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [u][/u]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_underlined')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_underlined')?><br>
          <?=bbcodes(__('bbcodes_doc_underlined'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [i][/i]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_italics')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_italics')?><br>
          <?=bbcodes(__('bbcodes_doc_italics'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [s][/s]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_strike')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_strike')?><br>
          <?=bbcodes(__('bbcodes_doc_strike'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [blur][/blur]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_blur')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_blur')?><br>
          <?=bbcodes(__('bbcodes_doc_blur'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [align=X][/align]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_align')?>
        </td>
        <td class="padding_top padding_bot">
          <div class="align_left"><?=__('bbcodes_doc_align_left')?></div>
          <br>
          <div class="align_center"><?=__('bbcodes_doc_align_center')?></div>
          <br>
          <div class="align_right"><?=__('bbcodes_doc_align_right')?></div>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [color=X][/color]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_color')?>
        </td>
        <td class="padding_top padding_bot">
          <span class="text_red"><?=__('bbcodes_doc_color_name')?></span><br>
          <br>
          <span style="color: #A15F8E;"><?=__link('https://www.w3schools.com/colors/colors_picker.asp', __('bbcodes_doc_color_hex'), 'text_blue noglow', false)?></span>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [size=X][/size]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_size')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_size')?><br>
          <?=bbcodes(__('bbcodes_doc_size'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [code][/code]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_code')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_code')?><br>
          <br>
          <span class="align_left"><?=bbcodes(__('bbcodes_doc_code'))?></span>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [space]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_space')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_space')?><br>
          <?=bbcodes(__('bbcodes_doc_space'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [line]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_line')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_line')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_line'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [quote][/quote]<br>
          [quote=x][/quote]
        </td>
        <td class="bold nowrap">
          <?=__('quote')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_quote')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_quote'))?><br>
          <?=__('bbcodes_doc_quote_full')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_quote_full'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [spoiler][/spoiler]<br>
          [spoiler=x][/spoiler]
        </td>
        <td class="bold nowrap">
          <?=__('spoiler')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_spoiler')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_spoiler'))?><br>
          <?=__('bbcodes_doc_spoiler_full')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_spoiler_full'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [youtube][/youtube]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_youtube')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_youtube')?><br>
          <?=__('bbcodes_doc_youtube_vid')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_youtube_vid'))?>
        </td>
      </tr>

      <tr>
        <td class="nowrap monospace">
          [twitter][/twitter]
        </td>
        <td class="bold nowrap">
          <?=__('bbcodes_twitter')?>
        </td>
        <td class="padding_top padding_bot">
          <?=__('bbcodes_doc_twitter')?><br>
          <?=__('bbcodes_doc_twitter_link')?><br>
          <br>
          <?=bbcodes(__('bbcodes_doc_twitter_link'))?>
        </td>
      </tr>

    </tbody>
  </table>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }