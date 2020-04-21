<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php'; # Core
include_once './../../lang/dev.lang.php';    # Translations

// Limit page access rights
user_restrict_to_administrators($lang);

// Hide the page from who's online
$hidden_activity = 1;

// Page summary
$page_lang        = array('FR', 'EN');
$page_url         = "pages/dev/functions_list";
$page_title_en    = "Functions list";
$page_title_fr    = "Liste des fonctions";

// Extra JS
$js   = array('dev/functions_list', 'clipboard');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     BACK END                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dropdown selector

$functions_list_type = sanitize_input('POST', 'functions_list_type', 'string', 'unsorted');




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     FRONT END                                                     */
/*                                                                                                                   */
if(!page_is_fetched_dynamically()) { /***************************************/ include './../../inc/header.inc.php'; ?>

      <div class="width_50">

      <h4 class="align_center">
        <?=__('dev_functions_list_title')?>
        <select class="inh" id="select_functions_list_type" onchange="dev_functions_type_selector();">
          <option value="database"><?=__('dev_functions_selector_database')?></option>
          <option value="dates"><?=__('dev_functions_selector_dates')?></option>
          <option value="numbers"><?=__('dev_functions_selector_numbers')?></option>
          <option value="sanitization"><?=__('dev_functions_selector_sanitization')?></option>
          <option value="strings"><?=__('dev_functions_selector_strings')?></option>
          <option value="unsorted" selected><?=__('dev_functions_selector_unsorted')?></option>
          <option value="users"><?=__('dev_functions_selector_users')?></option>
          <option value="website"><?=__('dev_functions_selector_website')?></option>
        </select>
      </h4>

      </div>

      <div class="bigpadding_top" id="dev_functions_list_body">
      <?php } ?>




<?php if($functions_list_type === 'database') { #################################################################### ?>

      <div class="width_50">

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
              <td class="align_right smallglow">
                query()
              </td>
              <td class="align_left">
                Execute a MySQL query.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                query_id()
              </td>
              <td class="align_left">
                Returns the ID of the latest inserted row.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                database_row_exists()
              </td>
              <td class="align_left">
                Checks whether a row exists in a table.
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
              <td class="align_right smallglow">
                sql_create_table()
              </td>
              <td class="align_left">
                Creates a new table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_rename_table()
              </td>
              <td class="align_left">
                Renames an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_empty_table()
              </td>
              <td class="align_left">
                Gets rid of all the data in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_delete_table()
              </td>
              <td class="align_left">
                Deletes an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_create_field()
              </td>
              <td class="align_left">
                Creates a new field in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_rename_field()
              </td>
              <td class="align_left">
                Renames an existing field in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_change_field_type()
              </td>
              <td class="align_left">
                Changes the type of an existing field in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_move_field()
              </td>
              <td class="align_left">
                Moves an existing field in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_delete_field()
              </td>
              <td class="align_left">
                Deletes an existing field in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_create_index()
              </td>
              <td class="align_left">
                Creates an index in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_delete_index()
              </td>
              <td class="align_left">
                Deletes an existing index in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sql_insert_value()
              </td>
              <td class="align_left">
                Inserts a value in an existing table.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
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
              <td class="align_right smallglow">
                fixtures_generate_data()
              </td>
              <td class="align_left">
                Generates SQL safe random data.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                fixtures_fetch_random_id()
              </td>
              <td class="align_left">
                Finds a random legitimate id in a table.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } else if($functions_list_type === 'dates') { ################################################################ ?>

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
              <td class="align_right smallglow">
                date_to_text()
              </td>
              <td class="align_left">
                Transforms a MySQL date or a timestamp into a plaintext date.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                date_to_ddmmyy()
              </td>
              <td class="align_left">
                Converts a mysql date to the DD/MM/YY format.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                date_to_mysql()
              </td>
              <td class="align_left">
                Converts a date to the mysql date format.
              </td>
            </tr>

          </tbody>
        </table>

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
              <td class="align_right smallglow">
                time_since()
              </td>
              <td class="align_center smallglow">
                functions_time.inc.php
              </td>
              <td class="align_left">
                Returns in plain text how long ago a timestamp happened.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                time_until()
              </td>
              <td class="align_center smallglow">
                functions_time.inc.php
              </td>
              <td class="align_left">
                Returns in plain text in how long a timestamp will happen.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } else if($functions_list_type === 'numbers') { ############################################################## ?>

      <div class="width_70">

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
              <td class="align_right smallglow">
                number_prepend_sign()
              </td>
              <td class="align_center smallglow">
                functions_numbers.inc.php
              </td>
              <td class="align_left">
                Ensures a number is preceded by its sign.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                number_display_format()
              </td>
              <td class="align_center smallglow">
                functions_numbers.inc.php
              </td>
              <td class="align_left">
                Changes the formatting of a number.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                number_styling()
              </td>
              <td class="align_center smallglow">
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
              <td class="align_right smallglow">
                maths_percentage_of()
              </td>
              <td class="align_center smallglow">
                functions_mathematics.inc.php
              </td>
              <td class="align_left">
                The percentage of a number that another number represents.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                math_percentage_growth()
              </td>
              <td class="align_center smallglow">
                functions_mathematics.inc.php
              </td>
              <td class="align_left">
                Growth in percent from one value to another.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } else if($functions_list_type === 'sanitization') { ######################################################### ?>

      <div class="width_50">

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
              <td class="align_right smallglow">
                sanitize()
              </td>
              <td class="align_left">
                Sanitizes data.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
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
              <td class="align_right smallglow">
                sanitize_output()
              </td>
              <td class="align_left">
                Sanitizes data for HTML usage.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                sanitize_output_full()
              </td>
              <td class="align_left">
                Sanitizes data before outputting it as HTML, for untrusted user data.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                html_fix_meta_tags()
              </td>
              <td class="align_left">
                Makes the content of meta tags valid.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } else if($functions_list_type === 'strings') { ############################################################## ?>

      <div class="width_50">

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
              <td class="align_right smallglow">
                string_truncate()
              </td>
              <td class="align_left">
                Truncates a string if it is longer than a specified length.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                string_change_case()
              </td>
              <td class="align_left">
                Changes the case of a string.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                string_remove_accents()
              </td>
              <td class="align_left">
                Removes accentuated latin characters from a string.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                string_wrap_in_html_tags()
              </td>
              <td class="align_left">
                Wraps HTML tags around every occurence of a string in a text.
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
              <td class="align_right smallglow">
                bbcodes()
              </td>
              <td class="align_center smallglow">
                bbcodes.inc.php
              </td>
              <td class="align_left">
                Turns BBCodes into HTML.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                nbcodes()
              </td>
              <td class="align_center smallglow">
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
              <td class="align_right smallglow">
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
              <td class="align_right smallglow">
                search_string_context()
              </td>
              <td class="align_left">
                Searches for a string in a text, along with the words surrounding said string.
              </td>
            </tr>

          </tbody>
        </table>

      </div>



<?php } else if($functions_list_type === 'unsorted') { ############################################################# ?>

      <div class="width_50">

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
              <td class="align_right smallglow">
                error_page()
              </td>
              <td class="align_left">
                Throw an error page.
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
              <td class="align_right smallglow">
                page_is_fetched_dynamically()
              </td>
              <td class="align_left">
                Is the page being fetched dynamically.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
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
              <td class="align_right smallglow">
                has_file_been_included()
              </td>
              <td class="align_left">
                Checks whether a specific file has been included.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
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
              <td class="align_right smallglow">
                encrypt_data()
              </td>
              <td class="align_left">
                Encrypts data.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } else if($functions_list_type === 'users') { ################################################################ ?>

      <div class="width_50">

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
              <td class="align_right smallglow">
                user_get_id()
              </td>
              <td class="align_left">
                Returns a user's id.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_get_nickname()
              </td>
              <td class="align_left">
                Returns a user's nickname from his id.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_get_language()
              </td>
              <td class="align_left">
                Detects the user's language.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_settings_nsfw()
              </td>
              <td class="align_left">
                NSFW filter settings of the current user.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
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
              <td class="align_right smallglow">
                user_is_moderator()
              </td>
              <td class="align_left">
                Checks if an user has moderator rights (or above).
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_is_global_moderator()
              </td>
              <td class="align_left">
                Checks if an user is a global moderator (or above).
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_is_administrator()
              </td>
              <td class="align_left">
                Checks if an user is an administrator.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_restrict_to_guests()
              </td>
              <td class="align_left">
                Allows access only to guests (not logged into an account).
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_restrict_to_users()
              </td>
              <td class="align_left">
                Allows access only to logged in users.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_restrict_to_moderators()
              </td>
              <td class="align_left">
                Allows access only to global or local moderators (or above).
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_restrict_to_global_moderators()
              </td>
              <td class="align_left">
                Allows access only to global moderators (or above).
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_restrict_to_administrators()
              </td>
              <td class="align_left">
                Allows access only to administrators.
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
              <td class="align_right smallglow">
                user_is_logged_in()
              </td>
              <td class="align_left">
                Checks whether the user is logged in.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                user_log_out()
              </td>
              <td class="align_left">
                Logs the user out of his account.
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
              <td class="align_right smallglow">
                user_generate_random_nickname()
              </td>
              <td class="align_left">
                Generates a random nickname for a guest.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } else if($functions_list_type === 'website') { ############################################################## ?>

      <div class="width_60">

        <h2 class="align_center padding_bot">
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
              <td class="align_right smallglow">
                private_message_send()
              </td>
              <td class="align_left">
                Sends a private message to an user.
              </td>
            </tr>

          </tbody>
        </table>

        <h2 class="align_center bigpadding_top padding_bot">
          IRC bot
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
              <td class="align_right smallglow">
                ircbot()
              </td>
              <td class="align_left">
                Uses the IRC bot to broadcast a message.
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
              <td class="align_right smallglow">
                flood_check()
              </td>
              <td class="align_left">
                Throws an error if the user is currently flooding the website, then updates the last activity date.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                log_activity()
              </td>
              <td class="align_left">
                Adds an entry to the recent activity logs.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                log_activity_details()
              </td>
              <td class="align_left">
                Adds an entry to the recent activity detailed logs.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                log_activity_purge_orphan_diffs()
              </td>
              <td class="align_left">
                Deletes all orphan entries in the detailed activity logs.
              </td>
            </tr>
            <tr>
              <td class="align_right smallglow">
                log_activity_delete()
              </td>
              <td class="align_left">
                Soft deletes an entry in the activity logs.
              </td>
            </tr>

          </tbody>
        </table>

      </div>




<?php } ############################################################################################################ ?>

        <?php if(!page_is_fetched_dynamically()) { ?>
      </div>

<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                    END OF PAGE                                                    */
/*                                                                                                                   */
/*****************************************************************************/ include './../../inc/footer.inc.php'; }