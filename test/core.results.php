<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 inc/tests.inc.php                                                 */
/*                                                                                                                   */
/*                                                       TESTS                                                       */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="2">
    tests.inc.php
  </td>
  <td class="nowrap" rowspan="2">
    test_assert
  </td>
  <td class="<?=$test_style['test']?> text_white bold spaced">
    <?=$test_results['test']['explanation']?>
  </td>
</tr>

<tr class="row_separator_dark">
  <td class="<?=$test_style['test_fail']?> text_white bold spaced">
    <?=$test_results['test_fail']['explanation']?>
  </td>
</tr>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                 inc/query.inc.php                                                 */
/*                                                                                                                   */
/*                                                    SQL QUERIES                                                    */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="6">
    sql.inc.php
  </td>
  <td class="nowrap" rowspan="3">
    query
  </td>
  <td class="<?=$test_style['query']?> text_white bold spaced">
    <?=$test_results['query']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['query_data']?> text_white bold spaced">
    <?=$test_results['query_data']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['query_err']?> text_white bold spaced">
    <?=$test_results['query_err']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    query_row
  </td>
  <td class="<?=$test_style['query_row']?> text_white bold spaced">
    <?=$test_results['query_row']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    query_row_count
  </td>
  <td class="<?=$test_style['query_count']?> text_white bold spaced">
    <?=$test_results['query_count']['explanation']?>
  </td>
</tr>

<tr class="row_separator_dark">
  <td class="nowrap">
    query_id
  </td>
  <td class="<?=$test_style['query_id']?> text_white bold spaced">
    <?=$test_results['query_id']['explanation']?>
  </td>
</tr>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                             inc/sanitization.inc.php                                              */
/*                                                                                                                   */
/*                                                   SANITIZATION                                                    */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="16">
    sanitization.inc.php
  </td>
  <td class="nowrap" rowspan="7">
    sanitize
  </td>
  <td class="<?=$test_style['sanitize_string']?> text_white bold spaced">
    <?=$test_results['sanitize_string']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_int']?> text_white bold spaced">
    <?=$test_results['sanitize_int']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_bool']?> text_white bold spaced">
    <?=$test_results['sanitize_bool']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_float']?> text_white bold spaced">
    <?=$test_results['sanitize_float']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_min']?> text_white bold spaced">
    <?=$test_results['sanitize_min']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_max']?> text_white bold spaced">
    <?=$test_results['sanitize_max']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_pad']?> text_white bold spaced">
    <?=$test_results['sanitize_pad']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    sanitize_input
  </td>
  <td class="<?=$test_style['sanitize_post']?> text_white bold spaced">
    <?=$test_results['sanitize_post']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    sanitize_array_element
  </td>
  <td class="<?=$test_style['sanitize_array']?> text_white bold spaced">
    <?=$test_results['sanitize_array']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    sanitize_output
  </td>
  <td class="<?=$test_style['sanitize_html']?> text_white bold spaced">
    <?=$test_results['sanitize_html']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sanitize_output']?> text_white bold spaced">
    <?=$test_results['sanitize_output']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    sanitize_output_full
  </td>
  <td class="<?=$test_style['sanitize_full']?> text_white bold spaced">
    <?=$test_results['sanitize_full']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    sanitize_output_javascript
  </td>
  <td class="<?=$test_style['sanitize_js']?> text_white bold spaced">
    <?=$test_results['sanitize_js']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    sanitize_meta_tags
  </td>
  <td class="<?=$test_style['sanitize_meta']?> text_white bold spaced">
    <?=$test_results['sanitize_meta']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    sanitize_json
  </td>
  <td class="<?=$test_style['sanitize_json']?> text_white bold spaced">
    <?=$test_results['sanitize_json']['explanation']?>
  </td>
</tr>

<tr class="row_separator_dark">
  <td class="nowrap">
    sanitize_api_output
  </td>
  <td class="<?=$test_style['sanitize_api']?> text_white bold spaced">
    <?=$test_results['sanitize_api']['explanation']?>
  </td>
</tr>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                inc/fixtures.inc.php                                               */
/*                                                                                                                   */
/*                                               RANDOM DATA GENERATION                                              */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="5">
    fixtures.inc.php
  </td>
  <td class="nowrap" rowspan="2">
    fixtures_generate_data
  </td>
  <td class="<?=$test_style['fixtures_int']?> text_white bold spaced">
    <?=$test_results['fixtures_int']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['fixtures_string']?> text_white bold spaced">
    <?=$test_results['fixtures_string']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    fixtures_fetch_random_id
  </td>
  <td class="<?=$test_style['fixtures_id']?> text_white bold spaced">
    <?=$test_results['fixtures_id']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    fixtures_fetch_random_value
  </td>
  <td class="<?=$test_style['fixtures_entry']?> text_white bold spaced">
    <?=$test_results['fixtures_entry']['explanation']?>
  </td>
</tr>

<tr class="row_separator_dark">
  <td class="nowrap">
    fixtures_check_entry
  </td>
  <td class="<?=$test_style['fixtures_exists']?> text_white bold spaced">
    <?=$test_results['fixtures_exists']['explanation']?>
  </td>
</tr>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                lang/common.lang.php                                               */
/*                                                                                                                   */
/*                                             TEMPLATES AND TRANSLATIONS                                            */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="6">
    common.lang.php
  </td>
  <td class="nowrap">
    __
  </td>
  <td class="<?=$test_style['translation']?> text_white bold spaced">
    <?=$test_results['translation']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    ___
  </td>
  <td class="<?=$test_style['translation_add']?> text_white bold spaced">
    <?=$test_results['translation_add']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    __link
  </td>
  <td class="<?=$test_style['translation_link']?> text_white bold spaced">
    <?=$test_results['translation_link']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['translation_extlink']?> text_white bold spaced">
    <?=$test_results['translation_extlink']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    __icon
  </td>
  <td class="<?=$test_style['translation_icon']?> text_white bold spaced">
    <?=$test_results['translation_icon']['explanation']?>
  </td>
</tr>

<tr class="row_separator_dark">
  <td class="nowrap">
    __tooltip
  </td>
  <td class="<?=$test_style['translation_tooltip']?> text_white bold spaced">
    <?=$test_results['translation_tooltip']['explanation']?>
  </td>
</tr>