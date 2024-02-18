<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                  THIS PAGE CAN ONLY BE RAN ON A DEV ENVIRONMENT                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                   Running this script might add, edit, delete various entries in the database.                    */
/*        It might completely mess up your environment, you can reset it afterwards by running /fixtures.php         */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './inc/includes.inc.php' ; # Core
include_once './inc/fixtures.inc.php' ; # Dummy data generation
include_once './inc/tests.inc.php'    ; # Functions for tests
include_once './lang/dev.lang.php'    ; # Translations

// Limit page access rights
user_restrict_to_administrators();

// Only allow this page to be ran in dev mode, it wouldn't be nice to accidentally wipe production data, would it?
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));

// Page summary
$page_lang      = array('FR', 'EN');
$page_url       = "tests";
$page_title_en  = "Tests";
$page_title_fr  = "Tests";

// Extra JS
$js = array('tests/suite');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run tests

// Initialize an array for test results
$test_results = array();

// Core functionalities
if(form_fetch_element('dev_tests_core', element_exists: true))
  include_once './test/core.tests.php';

// Common functionalities
if(form_fetch_element('dev_tests_common', element_exists: true))
  include_once './test/common.tests.php';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare data for displaying

// Initialize the test success and failure count
$test_successes = 0;
$test_fails     = 0;

// Run through the list of tests
foreach($test_results as $test_name => $test_result)
{
  // Increment the number of successful tests if necessary
  if($test_result['result'] === true)
    $test_successes++;

  // Increment the number of failed tests if necessary
  if($test_result['result'] === false)
    $test_fails++;

  // Prepare a style for the cell displaying the test result
  $test_style[$test_name] = ($test_result['result'] === true) ? 'green' : 'red';
}

// Remember selected form entries
$test_form_entries = array('core', 'common');
foreach($test_form_entries as $test_form_entry)
  $test_form_checked[$test_form_entry]  = (form_fetch_element('dev_tests_'.$test_form_entry, element_exists: true))
                                        ? ' checked' : '';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
/**********************************************************************************/ include './inc/header.inc.php'; ?>

<div class="width_50">

  <h1>
    <?=__('dev_tests_title')?>
  </h1>

  <p>
    <?=__('dev_tests_select_body')?>
  </p>

  <form method="POST" id="dev_tests_selector">
    <fieldset>

      <div class="smallpadding_top tinypadding_bot">

        <input type="radio" id="dev_tests_all" name="dev_tests_all" onclick="tests_suite_select_all();">
        <label class="label_inline" for="dev_tests_all"><?=__('dev_tests_select_all')?></label><br>

        <input type="radio" id="dev_tests_none" name="dev_tests_none" onclick="tests_suite_unselect_all();">
        <label class="label_inline" for="dev_tests_none"><?=__('dev_tests_select_uncheck')?></label>

      </div>

      <div class="tinypadding_top tinypadding_bot">

        <input type="checkbox" id="dev_tests_core" name="dev_tests_core"<?=$test_form_checked['core']?>>
        <label class="label_inline" for="dev_tests_core"><?=__('dev_tests_select_core')?></label><br>

        <input type="checkbox" id="dev_tests_common" name="dev_tests_common"<?=$test_form_checked['common']?>>
        <label class="label_inline" for="dev_tests_common"><?=__('dev_tests_select_common')?></label>

      </div>

      <input type="submit" name="dev_tests_submit" value="<?=__('dev_tests_select_submit')?>">

    </fieldset>
  </form>

</div>
<div class="width_60">

  <?php if(!count($test_results) && isset($_POST['dev_tests_submit'])) { ?>

  <div class="smallpadding_top">
    <span class="bold red text_white"><?=string_change_case(__('error'), 'uppercase').__(':', spaces_after: 1).__('dev_tests_results_none')?></span>
  </div>

  <?php } else if(count($test_results)) { ?>

  <div class="autoscroll bigpadding_top">
    <table>
      <thead>

        <tr>
          <th colspan="3" class="uppercase bigger vspaced">
            <?=__('dev_tests_results_title')?>
          </th>
        </tr>

        <tr>
          <th colspan="3" class="uppercase text_light dark bold align_center">
            <span class="green text_white spaced bold"><?=$test_successes?></span> <?=__('dev_tests_results_passed', amount: $test_successes)?> <span class="red text_white spaced bold"><?=$test_fails?></span> <?=__('dev_tests_results_failed', amount: $test_fails)?>
          </th>
        </tr>

      </thead>
      <tbody>

        <?php } if(isset($test_results['test'])) { /***************************************************************/ ?>

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

        <?php } if(isset($test_results['query'])) { /**************************************************************/ ?>

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

        <?php } if(isset($test_results['sanitize_string'])) { /****************************************************/ ?>

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

        <?php } if(isset($test_results['fixtures_int'])) { /*******************************************************/ ?>

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

        <?php } if(isset($test_results['translation'])) { /********************************************************/ ?>

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

        <?php } if(isset($test_results['bbcodes'])) { /************************************************************/ ?>

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

        <?php } if(isset($test_results['root_path'])) { /**********************************************************/ ?>

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

        <?php } if(count($test_results)) { /***********************************************************************/ ?>

      </tbody>
    </table>
  </div>

  <?php } ?>

</div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*************************************************************************************/ include './inc/footer.inc.php';