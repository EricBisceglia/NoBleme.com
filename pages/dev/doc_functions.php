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
$page_url         = "pages/dev/doc_functions";
$page_title_en    = "Functions list";
$page_title_fr    = "Liste des fonctions";

// Extra CSS & JS
$css  = array('dev');
$js   = array('dev/doc', 'common/toggle');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the correct function list entry

// Prepare a list of all function list entries
$dev_functions_selection = array('database', 'dates', 'numbers', 'sanitization', 'strings', 'unsorted', 'users', 'website');

// Prepare the CSS for each function list entry
foreach($dev_functions_selection as $dev_functions_selection_name)
{
  // If a function list entry is selected, display it and select the correct dropdown menu entry
  if(!isset($dev_functions_is_selected) && isset($_GET[$dev_functions_selection_name]))
  {
    $dev_functions_is_selected                            = true;
    $dev_functions_hide[$dev_functions_selection_name]      = '';
    $dev_functions_selected[$dev_functions_selection_name]  = ' selected';
  }

  // Hide every other function list entry
  else
  {
    $dev_functions_hide[$dev_functions_selection_name]      = ' hidden';
    $dev_functions_selected[$dev_functions_selection_name]  = '';
  }
}

// If no function list entry is selected, select the main one by default
if(!isset($dev_functions_is_selected))
{
  $dev_functions_hide['unsorted']     = '';
  $dev_functions_selected['unsorted'] = ' selected';
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

<div class="padding_bot align_center dev_doc_selector">

  <fieldset>
    <h5>
      <?=__('dev_functions_list_title')?>
      <select class="inh" id="dev_functions_type_selector" onchange="dev_functions_type_selector();">
        <option value="database"<?=$dev_functions_selected['database']?>><?=__('dev_functions_selector_database')?></option>
        <option value="dates"<?=$dev_functions_selected['dates']?>><?=__('dev_functions_selector_dates')?></option>
        <option value="numbers"<?=$dev_functions_selected['numbers']?>><?=__('dev_functions_selector_numbers')?></option>
        <option value="sanitization"<?=$dev_functions_selected['sanitization']?>><?=__('dev_functions_selector_sanitization')?></option>
        <option value="strings"<?=$dev_functions_selected['strings']?>><?=__('dev_functions_selector_strings')?></option>
        <option value="unsorted"<?=$dev_functions_selected['unsorted']?>><?=__('dev_functions_selector_unsorted')?></option>
        <option value="users"<?=$dev_functions_selected['users']?>><?=string_change_case(__('user+'), 'initials')?></option>
        <option value="website"<?=$dev_functions_selected['website']?>><?=__('dev_functions_selector_website')?></option>
      </select>
    </h5>
  </fieldset>

</div>

<hr>




<?php /************************************************ DATABASE **************************************************/ ?>

<div class="width_50 padding_top dev_functions_section<?=$dev_functions_hide['database']?>" id="dev_functions_database">

  <h2 class="align_center padding_bot">
    Queries
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          query()
        </td>
        <td class="align_left">
          Execute a MySQL query.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          query_id()
        </td>
        <td class="align_left">
          Returns the ID of the latest inserted row.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          database_row_exists()
        </td>
        <td class="align_left">
          Checks whether a row exists in a table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          database_entry_exists()
        </td>
        <td class="align_left">
          Checks whether an entry exists in a table.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top smallpadding_bot">
    Migrations
  </h2>

  <h5 class="align_center padding_bot">
    These functions work only in queries.inc.php!
  </h5>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          sql_check_query_id()
        </td>
        <td class="align_left">
        Checks whether a query should be ran or not.
        </td>
      </tr>
      <tr class="row_separator_dark_thin">
        <td class="align_right glow_dark bold">
          sql_update_query_id()
        </td>
        <td class="align_left">
          Updates the ID of the last query that was ran.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_create_table()
        </td>
        <td class="align_left">
          Creates a new table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_rename_table()
        </td>
        <td class="align_left">
          Renames an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_empty_table()
        </td>
        <td class="align_left">
          Gets rid of all the data in an existing table.
        </td>
      </tr>
      <tr class="row_separator_dark_thin">
        <td class="align_right glow_dark bold">
          sql_delete_table()
        </td>
        <td class="align_left">
          Deletes an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_create_field()
        </td>
        <td class="align_left">
          Creates a new field in an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_rename_field()
        </td>
        <td class="align_left">
          Renames an existing field in an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_change_field_type()
        </td>
        <td class="align_left">
          Changes the type of an existing field in an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_move_field()
        </td>
        <td class="align_left">
          Moves an existing field in an existing table.
        </td>
      </tr>
      <tr class="row_separator_dark_thin">
        <td class="align_right glow_dark bold">
          sql_delete_field()
        </td>
        <td class="align_left">
          Deletes an existing field in an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_create_index()
        </td>
        <td class="align_left">
          Creates an index in an existing table.
        </td>
      </tr>
      <tr class="row_separator_dark_thin">
        <td class="align_right glow_dark bold">
          sql_delete_index()
        </td>
        <td class="align_left">
          Deletes an existing index in an existing table.
        </td>
      </tr>
      <tr class="row_separator_dark_thin">
        <td class="align_right glow_dark bold">
          sql_insert_value()
        </td>
        <td class="align_left">
          Inserts a value in an existing table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sql_sanitize_data()
        </td>
        <td class="align_left">
          Sanitizes data for MySQL queries.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top smallpadding_bot">
    Fixtures
  </h2>

  <h5 class="align_center padding_bot">
    These functions work only in sqldump_fixtures.php!
  </h5>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          fixtures_lorem_ipsum()
        </td>
        <td class="align_left">
          Generates a lorem ipsum like sentence.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          fixtures_generate_data()
        </td>
        <td class="align_left">
          Generates SQL safe random data.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          fixtures_fetch_random_id()
        </td>
        <td class="align_left">
          Finds a random legitimate id in a table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          fixtures_fetch_random_value()
        </td>
        <td class="align_left">
          Finds a random legitimate entry in a table.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          fixtures_check_entry()
        </td>
        <td class="align_left">
          Check if a table entry already exists.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          fixtures_query_id()
        </td>
        <td class="align_left">
          Returns the ID of the latest inserted row.
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /************************************************* DATES ****************************************************/ ?>

<div class="padding_top dev_functions_section<?=$dev_functions_hide['dates']?>" id="dev_functions_dates">

  <div class="width_50">

    <h2 class="align_center padding_bot">
      Date formats
    </h2>

    <table>
      <thead>

        <tr>
          <th class="align_right">
            FUNCTION
          </th>
          <th class="align_left">
            DESCRIPTION
          </th>
        </tr>

      </thead>
      <tbody class="altc">

        <tr>
          <td class="align_right glow_dark bold">
            date_to_text()
          </td>
          <td class="align_left">
            Transforms a MySQL date or a timestamp into a plaintext date.
          </td>
        </tr>
        <tr>
          <td class="align_right glow_dark bold">
            date_to_ddmmyy()
          </td>
          <td class="align_left">
            Converts a mysql date to the DD/MM/YY format.
          </td>
        </tr>
        <tr>
          <td class="align_right glow_dark bold">
            date_to_mysql()
          </td>
          <td class="align_left">
            Converts a date to the mysql date format.
          </td>
        </tr>

      </tbody>
    </table>

  </div>

  <div class="width_60">

    <h2 class="align_center bigpadding_top padding_bot">
      Time differentials
    </h2>

    <table>
      <thead>

        <tr>
          <th class="align_right">
            FUNCTION
          </th>
          <th class="align_center">
            REQUIRES
          </th>
          <th class="align_left">
            DESCRIPTION
          </th>
        </tr>

      </thead>
      <tbody class="altc">

        <tr>
          <td class="align_right glow_dark bold">
            time_since()
          </td>
          <td class="align_center glow_dark bold">
            functions_time.inc.php
          </td>
          <td class="align_left">
            Returns in plain text how long ago a timestamp happened.
          </td>
        </tr>
        <tr>
          <td class="align_right glow_dark bold">
            time_until()
          </td>
          <td class="align_center glow_dark bold">
            functions_time.inc.php
          </td>
          <td class="align_left">
            Returns in plain text in how long a timestamp will happen.
          </td>
        </tr>
        <tr>
          <td class="align_right glow_dark bold">
            time_days_elapsed()
          </td>
          <td class="align_center glow_dark bold">
            functions_time.inc.php
          </td>
          <td class="align_left">
            Calculates the number of days elapsed between two MySQL dates.
          </td>
        </tr>

      </tbody>
    </table>

  </div>

</div>




<?php /************************************************ NUMBERS ***************************************************/ ?>

<div class="width_70 padding_top dev_functions_section<?=$dev_functions_hide['numbers']?>" id="dev_functions_numbers">

  <h2 class="align_center padding_bot">
    Number formats
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th>
          REQUIRES
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          number_prepend_sign()
        </td>
        <td class="align_center glow_dark bold">
          functions_numbers.inc.php
        </td>
        <td class="align_left">
          Ensures a number is preceded by its sign.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          number_display_format()
        </td>
        <td class="align_center glow_dark bold">
          functions_numbers.inc.php
        </td>
        <td class="align_left">
          Changes the formatting of a number.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          number_styling()
        </td>
        <td class="align_center glow_dark bold">
          functions_numbers.inc.php
        </td>
        <td class="align_left">
          Returns a styling depending on whether the number is positive, zero, or negative.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Percentages
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th>
          REQUIRES
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          maths_percentage_of()
        </td>
        <td class="align_center glow_dark bold">
          functions_mathematics.inc.php
        </td>
        <td class="align_left">
          The percentage of a number that another number represents.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          maths_percentage_growth()
        </td>
        <td class="align_center glow_dark bold">
          functions_mathematics.inc.php
        </td>
        <td class="align_left">
          Growth in percent from one value to another.
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /********************************************** SANITIZATION ************************************************/ ?>

<div class="width_50 padding_top dev_functions_section<?=$dev_functions_hide['sanitization']?>" id="dev_functions_sanitization">

  <h2 class="align_center padding_bot">
    Input (for MySQL usage)
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          sanitize()
        </td>
        <td class="align_left">
          Sanitizes data.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sanitize_input()
        </td>
        <td class="align_left">
          Sanitizes user inputted data.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Output (for HTML usage)
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          sanitize_output()
        </td>
        <td class="align_left">
          Sanitizes data for HTML usage.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sanitize_output_full()
        </td>
        <td class="align_left">
          Sanitizes data before outputting it as HTML, for untrusted user data.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          sanitize_output_javascript()
        </td>
        <td class="align_left">
          Sanitizes data for passing to inline javascript.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          html_fix_meta_tags()
        </td>
        <td class="align_left">
          Sanitizes the content of meta tags.
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /************************************************ STRINGS ***************************************************/ ?>

<div class="width_50 padding_top dev_functions_section<?=$dev_functions_hide['strings']?>" id="dev_functions_strings">

  <h2 class="align_center padding_bot">
    String manipulation
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          string_truncate()
        </td>
        <td class="align_left">
          Truncates a string if it is longer than a specified length.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          string_change_case()
        </td>
        <td class="align_left">
          Changes the case of a string.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          string_remove_accents()
        </td>
        <td class="align_left">
          Removes accentuated latin characters from a string.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          string_wrap_in_html_tags()
        </td>
        <td class="align_left">
          Wraps HTML tags around every occurence of a string in a text.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          string_increment()
        </td>
        <td class="align_left">
          Increments the last character of a string.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    BBCodes
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_center">
          REQUIRES
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          bbcodes()
        </td>
        <td class="align_center glow_dark bold">
          bbcodes.inc.php
        </td>
        <td class="align_left">
          Turns BBCodes into HTML.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          nbcodes()
        </td>
        <td class="align_center glow_dark bold">
          bbcodes.inc.php
        </td>
        <td class="align_left">
          Turns more BBCodes into HTML, for administrator usage only.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Diffs
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          diff_strings()
        </td>
        <td class="align_left">
          Returns a human readable list of differences between two strings.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Search
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          search_string_context()
        </td>
        <td class="align_left">
          Searches for a string in a text, along with the words surrounding said string.
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /************************************************ UNSORTED **************************************************/ ?>

<div class="width_50 padding_top dev_functions_section<?=$dev_functions_hide['unsorted']?>" id="dev_functions_unsorted">

  <h2 class="align_center padding_bot">
    Errors
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          error_page()
        </td>
        <td class="align_left">
          Throw an error page.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Form data manipulation
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          form_fetch_element()
        </td>
        <td class="align_left">
          Fetches the unsanitized value or returns the existence of submitted user data.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Dynamically called pages
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          page_is_fetched_dynamically()
        </td>
        <td class="align_left">
          Is the page being fetched dynamically.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          page_must_be_fetched_dynamically()
        </td>
        <td class="align_left">
          Throws a 404 if the page is not being fetched dynamically.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    File inclusions
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          has_file_been_included()
        </td>
        <td class="align_left">
          Checks whether a specific file has been included.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          require_included_file()
        </td>
        <td class="align_left">
          Requires a file to be included or exits the script.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Hashing
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          encrypt_data()
        </td>
        <td class="align_left">
          Encrypts data.
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /************************************************* USERS ****************************************************/ ?>

<div class="width_50 padding_top dev_functions_section<?=$dev_functions_hide['users']?>" id="dev_functions_users">

  <h2 class="align_center padding_bot">
    User info
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          user_get_id()
        </td>
        <td class="align_left">
          Returns a user's id.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
        user_fetch_id()
        </td>
        <td class="align_left">
          Returns the user id for a specific username.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_get_username()
        </td>
        <td class="align_left">
          Returns a user's username from their id.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_get_language()
        </td>
        <td class="align_left">
          Detects the user's language.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_get_mode()
        </td>
        <td class="align_left">
          Returns the current user's display mode.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_settings_nsfw()
        </td>
        <td class="align_left">
          NSFW filter settings of the current user.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_settings_privacy()
        </td>
        <td class="align_left">
          Third party content privacy settings of the current user.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Access rights
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          user_is_administrator()
        </td>
        <td class="align_left">
          Checks if a user is an administrator.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_is_moderator()
        </td>
        <td class="align_left">
          Checks if a user is a moderator (or above).
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_is_banned()
        </td>
        <td class="align_left">
          Checks if a user is banned.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_is_ip_banned()
        </td>
        <td class="align_left">
          Checks if a user is IP banned.
        </td>
      </tr>
      <tr class="row_separator_dark_thin">
        <td class="align_right glow_dark bold">
          user_is_deleted()
        </td>
        <td class="align_left">
          Checks if a user's account is deleted.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_administrators()
        </td>
        <td class="align_left">
          Allows access only to administrators.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_moderators()
        </td>
        <td class="align_left">
          Allows access only to moderators (or above).
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_users()
        </td>
        <td class="align_left">
          Allows access only to logged in users.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_guests()
        </td>
        <td class="align_left">
          Allows access only to guests (not logged into an account).
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_banned()
        </td>
        <td class="align_left">
          Allows access only to banned users.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_ip_banned()
        </td>
        <td class="align_left">
          Allows access only to fully IP banned users.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_restrict_to_non_ip_banned()
        </td>
        <td class="align_left">
          Allows access only to users who are not IP banned.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Account data
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          user_get_oldest()
        </td>
        <td class="align_left">
          Finds when the oldest user registered on the website.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_get_birth_years()
        </td>
        <td class="align_left">
          Returns all the years during which a user was born.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Login / Logout
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          user_is_logged_in()
        </td>
        <td class="align_left">
          Checks whether the user is logged in.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          user_log_out()
        </td>
        <td class="align_left">
          Logs the user out of their account.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Guests
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          user_generate_random_username()
        </td>
        <td class="align_left">
          Generates a random username for a guest.
        </td>
      </tr>

    </tbody>
  </table>

</div>




<?php /************************************************ WEBSITE ***************************************************/ ?>

<div class="width_60 padding_top dev_functions_section<?=$dev_functions_hide['website']?>" id="dev_functions_website">

  <h2 class="align_center padding_bot">
    Utilities
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          root_path()
        </td>
        <td class="align_left">
          Returns the path to the root of the website
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    System variables
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          system_variable_fetch()
        </td>
        <td class="align_left">
          Fetches a system variable's value.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          system_variable_update()
        </td>
        <td class="align_left">
          Updates a system variable's value.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Private messages
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          private_message_send()
        </td>
        <td class="align_left">
          Sends a private message to a user.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Integrations
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          irc_bot_send_message()
        </td>
        <td class="align_left">
          Uses the IRC bot to broadcast a message.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          discord_send_message()
        </td>
        <td class="align_left">
          Uses a Discord webhook to broadcast a message.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    User activity
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          flood_check()
        </td>
        <td class="align_left">
          Throws an error if the user is currently flooding the website, then updates the last activity date.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          log_activity()
        </td>
        <td class="align_left">
          Adds an entry to the recent activity logs.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          log_activity_details()
        </td>
        <td class="align_left">
          Adds an entry to the recent activity detailed logs.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          log_activity_purge_orphan_diffs()
        </td>
        <td class="align_left">
          Deletes all orphan entries in the detailed activity logs.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          log_activity_delete()
        </td>
        <td class="align_left">
          Soft deletes an entry in the activity logs.
        </td>
      </tr>

    </tbody>
  </table>

  <h2 class="align_center bigpadding_top padding_bot">
    Versioning
  </h2>

  <table>
    <thead>

      <tr>
        <th class="align_right">
          FUNCTION
        </th>
        <th class="align_left">
          DESCRIPTION
        </th>
      </tr>

    </thead>
    <tbody class="altc">

      <tr>
        <td class="align_right glow_dark bold">
          system_get_current_version_number()
        </td>
        <td class="align_left">
          Returns information about the current version number.
        </td>
      </tr>
      <tr>
        <td class="align_right glow_dark bold">
          system_assemble_version_number()
        </td>
        <td class="align_left">
          Assembles a version number in accordance with SemVer 2.0.0 specification.
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