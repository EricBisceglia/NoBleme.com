<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                inc/bbcodes.inc.php                                                */
/*                                                                                                                   */
/*                                                      BBCODES                                                      */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="4">
    bbcodes.inc.php
  </td>
  <td class="nowrap">
    bbcodes
  </td>
  <td class="<?=$test_style['bbcodes']?> text_white bold spaced">
    <?=$test_results['bbcodes']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    nbcodes
  </td>
  <td class="<?=$test_style['nbcodes']?> text_white bold spaced">
    <?=$test_results['nbcodes']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    bbcodes_remove
  </td>
  <td class="<?=$test_style['unbbcodes']?> text_white bold spaced">
    <?=$test_results['unbbcodes']['explanation']?>
  </td>
</tr>

<tr class="row_separator_dark">
  <td class="nowrap">
    nbcodes_remove
  </td>
  <td class="<?=$test_style['unnbcodes']?> text_white bold spaced">
    <?=$test_results['unnbcodes']['explanation']?>
  </td>
</tr>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                           inc/functions_common.inc.php                                            */
/*                                                                                                                   */
/*                                                   COMMON TOOLS                                                    */
/*                                                                                                                   */
/******************************************************************************************************************/ ?>

<tr>
  <td class="nowrap cellnoaltc" rowspan="33">
    functions_common.inc.php
  </td>
  <td class="nowrap">
    root_path
  </td>
  <td class="<?=$test_style['root_path']?> text_white bold spaced">
    <?=$test_results['root_path']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    database_row_exists
  </td>
  <td class="<?=$test_style['db_exists_row']?> text_white bold spaced">
    <?=$test_results['db_exists_row']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['db_exists_row_not']?> text_white bold spaced">
    <?=$test_results['db_exists_row_not']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    database_entry_exists
  </td>
  <td class="<?=$test_style['db_exists_entry']?> text_white bold spaced">
    <?=$test_results['db_exists_entry']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['db_exists_entry_not']?> text_white bold spaced">
    <?=$test_results['db_exists_entry_not']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    system_variable_fetch<br>
    system_variable_update
  </td>
  <td class="<?=$test_style['sysvar_correct']?> text_white bold spaced">
    <?=$test_results['sysvar_correct']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['sysvar_wrong']?> text_white bold spaced">
    <?=$test_results['sysvar_wrong']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    system_assemble_version_number
  </td>
  <td class="<?=$test_style['version_assemble']?> text_white bold spaced">
    <?=$test_results['version_assemble']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    system_get_current_version_number
  </td>
  <td class="<?=$test_style['version_current']?> text_white bold spaced">
    <?=$test_results['version_current']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['version_next']?> text_white bold spaced">
    <?=$test_results['version_next']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    page_is_fetched_dynamically
  </td>
  <td class="<?=$test_style['page_is_xhr']?> text_white bold spaced">
    <?=$test_results['page_is_xhr']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    has_file_been_included
  </td>
  <td class="<?=$test_style['include_file']?> text_white bold spaced">
    <?=$test_results['include_file']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['include_fail']?> text_white bold spaced">
    <?=$test_results['include_fail']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="3">
    form_fetch_element
  </td>
  <td class="<?=$test_style['form_fetch_exists']?> text_white bold spaced">
    <?=$test_results['form_fetch_exists']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['form_fetch_value']?> text_white bold spaced">
    <?=$test_results['form_fetch_value']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['form_fetch_get']?> text_white bold spaced">
    <?=$test_results['form_fetch_get']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    string_truncate
  </td>
  <td class="<?=$test_style['string_truncate']?> text_white bold spaced">
    <?=$test_results['string_truncate']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="3">
    string_change_case
  </td>
  <td class="<?=$test_style['string_lowercase']?> text_white bold spaced">
    <?=$test_results['string_lowercase']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['string_uppercase']?> text_white bold spaced">
    <?=$test_results['string_uppercase']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['string_initials']?> text_white bold spaced">
    <?=$test_results['string_initials']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    string_remove_accents
  </td>
  <td class="<?=$test_style['string_no_accents']?> text_white bold spaced">
    <?=$test_results['string_no_accents']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    string_increment
  </td>
  <td class="<?=$test_style['string_increment']?> text_white bold spaced">
    <?=$test_results['string_increment']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="3">
    date_to_text
  </td>
  <td class="<?=$test_style['date_to_text']?> text_white bold spaced">
    <?=$test_results['date_to_text']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['date_to_text_2']?> text_white bold spaced">
    <?=$test_results['date_to_text_2']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['date_to_text_3']?> text_white bold spaced">
    <?=$test_results['date_to_text_3']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    date_to_ddmmyy
  </td>
  <td class="<?=$test_style['date_to_ddmmyy']?> text_white bold spaced">
    <?=$test_results['date_to_ddmmyy']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    date_to_mysql
  </td>
  <td class="<?=$test_style['date_to_mysql']?> text_white bold spaced">
    <?=$test_results['date_to_mysql']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['date_to_mysql_err']?> text_white bold spaced">
    <?=$test_results['date_to_mysql_err']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap" rowspan="2">
    date_to_aware_datetime
  </td>
  <td class="<?=$test_style['date_aware_time']?> text_white bold spaced">
    <?=$test_results['date_aware_time']['explanation']?>
  </td>
</tr>

<tr>
  <td class="<?=$test_style['date_aware_zone']?> text_white bold spaced">
    <?=$test_results['date_aware_zone']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    diff_strings
  </td>
  <td class="<?=$test_style['string_diff']?> text_white bold spaced">
    <?=$test_results['string_diff']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    search_string_context
  </td>
  <td class="<?=$test_style['string_context']?> text_white bold spaced">
    <?=$test_results['string_context']['explanation']?>
  </td>
</tr>

<tr>
  <td class="nowrap">
    string_wrap_in_html_tags
  </td>
  <td class="<?=$test_style['string_wrap_tags']?> text_white bold spaced">
    <?=$test_results['string_wrap_tags']['explanation']?>
  </td>
</tr>