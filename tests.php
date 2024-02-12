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
include_once './lang/dev.lang.php'    ; # Translations

// Limit page access rights
user_restrict_to_administrators();

// Only allow this page to be ran in dev mode, it wouldn't be nice to accidentally wipe production data, would it?
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));

// Page summary
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

// Initialize an array for test results and return values
$test_results = array();
$test_returns = array();

// Core functionalities
if(form_fetch_element('dev_tests_core', element_exists: true))
  include_once './test/core.tests.php';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare data for displaying

// Initialize the test success and failure count
$test_successes = 0;
$test_fails     = 0;

// Run through the list of tests
foreach($test_results as $test_name => $test_result)
{
  // Increment the number of successful tests if necessary
  if($test_result === true)
    $test_successes++;

  // Increment the number of failed tests if necessary
  if($test_result === false)
    $test_fails++;

  // Prepare a style for the cell displaying the test result
  $test_style[$test_name] = ($test_result === true) ? 'green' : 'red';
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
      <tbody class="altc">

  <?php } if(isset($test_results['query'])) { ?>

        <tr>
          <td class="nowrap dark3" rowspan="2">
            query.inc.php
          </td>
          <td class="nowrap">
            query();
          </td>
          <td class="<?=$test_style['query']?> text_white bold spaced align_center">
            <?=$test_returns['query']?>
          </td>
        </tr>

        <tr>
          <td class="nowrap">
            query(fetch_row: true);
          </td>
          <td class="<?=$test_style['query2']?> text_white bold spaced align_center">
            <?=$test_returns['query2']?>
          </td>
        </tr>

  <?php } if(count($test_results)) { ?>

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