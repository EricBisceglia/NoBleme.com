<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             FIXTURES FOR THE DATABASE                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                    These fixtures are data meant to be used locally when working on the website                   */
/*       They should/will never be run on a production environment, so don't worry too much about their conents      */
/*                                                                                                                   */
/*               Word of warning: This page WILL fail its execution if not included from fixtures.php                */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Only allow this page to be ran in dev mode, it wouldn't be nice to accidentally wipe production data, would it?
include_once './inc/configuration.inc.php';
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                      FUNCTIONS REQUIRED TO INSERT FIXTURES                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Generates a lorem ipsum like sentence.
 *
 * @param   int     $word_count The number of words the paragraph should contain.
 *
 * @return  string  The randomly generated paragraph.
 */

function fixtures_lorem_ipsum($word_count)
{
  // Random words to use in the lorem genertion
  $words = array('lorem', 'lorem', 'lorem', 'ipsum', 'ipsum', 'ipsum', 'dolor', 'dolor', 'sit', 'sit', 'amet', 'consectetur', 'adipisicing', 'elit', 'sed', 'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'et', 'et', 'dolore', 'magna', 'aliqua', 'exercitationem', 'perferendis', 'perspiciatis', 'laborum', 'eveniet', 'sunt', 'iure', 'nam', 'nam', 'nobis', 'eum', 'cum', 'officiis', 'excepturi', 'odio', 'consectetur', 'quasi', 'aut', 'quisquam', 'vel', 'eligendi', 'itaque', 'non', 'odit', 'tempore', 'quaerat', 'dignissimos', 'facilis', 'neque', 'nihil', 'expedita', 'vitae', 'vero', 'ipsum', 'nisi', 'animi', 'cumque', 'pariatur', 'velit', 'modi', 'natus', 'iusto', 'eaque', 'sequi', 'illo', 'sed', 'ex', 'et', 'voluptatibus', 'tempora', 'veritatis', 'ratione', 'assumenda', 'incidunt', 'nostrum', 'placeat', 'aliquid', 'fuga', 'fuga', 'provident', 'praesentium', 'rem', 'necessitatibus', 'suscipit', 'adipisci', 'quidem', 'possimus', 'voluptas', 'debitis', 'sint', 'accusantium', 'unde', 'sapiente', 'voluptate', 'qui', 'aspernatur', 'laudantium', 'soluta', 'amet', 'quo', 'aliquam', 'saepe', 'culpa', 'libero', 'ipsa', 'dicta', 'reiciendis', 'nesciunt', 'doloribus', 'autem', 'impedit', 'minima', 'maiores', 'repudiandae', 'ipsam', 'obcaecati', 'ullam', 'enim', 'totam', 'totam', 'delectus', 'ducimus', 'quis', 'voluptates', 'dolores', 'molestiae', 'harum', 'dolorem', 'quia', 'voluptatem', 'molestias', 'magni', 'distinctio', 'omnis', 'illum', 'dolorum', 'voluptatum', 'ea', 'quas', 'quam', 'corporis', 'quae', 'blanditiis', 'atque', 'deserunt', 'laboriosam', 'earum', 'consequuntur', 'hic', 'cupiditate', 'quibusdam', 'accusamus', 'ut', 'rerum', 'error', 'minus', 'eius', 'ab', 'ad', 'nemo', 'fugit', 'officia', 'at', 'in', 'id', 'quos', 'reprehenderit', 'numquam', 'iste', 'fugiat', 'sit', 'inventore', 'beatae', 'repellendus', 'magnam', 'recusandae', 'quod', 'explicabo', 'doloremque', 'aperiam', 'consequatur', 'asperiores', 'commodi', 'optio', 'dolor', 'labore', 'temporibus', 'repellat', 'veniam', 'architecto', 'est', 'est', 'est', 'esse', 'mollitia', 'nulla', 'a', 'similique', 'eos', 'alias', 'dolore', 'tenetur', 'deleniti', 'porro', 'facere', 'maxime', 'corrupti');

  // Generate a random lorem ipsum
  $lorem_ipsum = '';
  for ($i = 0; $i < $word_count ; $i++)
  {
    $lorem_ipsum .= ($i) ? ' ' : '';
    $lorem_ipsum .= $words[array_rand($words, 1)];
  }

  // Return the lorem ipsum
  return $lorem_ipsum;
}




/**
 * Generates SQL safe random data.
 *
 * @param   string              $type       Type of data to generate ('int', 'digits', 'string', 'sentence', 'text').
 * @param   int                 $min        The minimum length or amount of data to be generated.
 * @param   int                 $max        The maximum length or amount of data to be generated.
 * @param   int|null  OPTIONAL  $no_periods If set, disables periods at the end of sentences.
 * @param   int|null  OPTIONAL  $no_spaces  If set, strings will not contain spaces.
 *
 * @return  string                          The randomly generated content.
 */

function fixtures_generate_data(  $type           ,
                                  $min            ,
                                  $max            ,
                                  $no_periods = 0 ,
                                  $no_spaces  = 0 )
{
  // Don't do aything if the min/max values are incorrect
  if($max < 1 || $min > $max)
    return;

  // Random int between $min and $max
  if($type == 'int')
    return mt_rand($min, $max);

  // Random string of digits
  if($type == 'digits')
  {
    $digits  = '';
    $max_length   = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
      $digits .= mt_rand(0,9);
    return $digits;
  }

  // Random string
  if($type == 'string')
  {
    $characters   = "aaaaaabcdeeeeeeefghiiiiiijkllmmnnoooooopqrrsssttuuvwxyz";
    if(!$no_spaces)
      $characters .= "      ";
    $max_length   = mt_rand($min, $max);
    $string  = '';
    for ($i = 0; $i < $max_length; $i++)
      $string .= $characters[mt_rand(0, (strlen($characters) - 1))];
    return $string;
  }

  // Random paragraph
  if($type == 'sentence')
  {
    $sentence = ucfirst(fixtures_lorem_ipsum(mt_rand($min, $max), 1));
    return ($no_periods) ? $sentence : $sentence.'.';
  }

  // Random text
  if($type == 'text')
  {
    $text = '';
    $max_length = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
    {
      $text .= ($i) ? '\r\n\r\n' : '';
      $text .= ucfirst(fixtures_lorem_ipsum(mt_rand(100, 400), 1)).'.';
    }
    return $text;
  }
}




/**
 * Finds a random legitimate id in a table.
 *
 * @param   string  $table  The name of the table from which to fetch a random id.
 *
 * @return  int             The ID of an existing entry.
 */

function fixtures_fetch_random_id($table)
{
  // Fetch an ID in the database
  $drand = mysqli_fetch_array(query(" SELECT    $table.id AS 'u_id'
                                      FROM      $table
                                      ORDER BY  RAND()
                                      LIMIT     1 "));

   // Return the ID
   return $drand['u_id'];
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      SYSTEM                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global variables

// Set global variables
query(" INSERT INTO system_variables
        SET         system_variables.update_in_progress       = 0   ,
                    system_variables.latest_query_id          = 31  ,
                    system_variables.last_scheduler_execution = 0   ,
                    system_variables.last_pageview_check      = 0   ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Versions

// Generate preset versions
query(" INSERT INTO system_versions
        SET         system_versions.major         = '1'           ,
                    system_versions.minor         = '1'           ,
                    system_versions.patch         = '1'           ,
                    system_versions.extension     = 'rc0'         ,
                    system_versions.release_date  = '2005-03-19'  ");
$date = date('Y-m-d');
query(" INSERT INTO system_versions
        SET         system_versions.major         = '1'           ,
                    system_versions.minor         = '1'           ,
                    system_versions.patch         = '2'           ,
                    system_versions.release_date  = '$date'       ");

$timestamp = strtotime('2005-03-19');
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at         = '$timestamp'  ,
                    logs_activity.language            = 'ENFR'        ,
                    logs_activity.activity_type       = 'dev_version' ,
                    logs_activity.activity_summary_en = '1 build 0'   ,
                    logs_activity.activity_summary_fr = '1 build 0'   ");
$timestamp = time();
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at         = '$timestamp'  ,
                    logs_activity.language            = 'ENFR'        ,
                    logs_activity.activity_type       = 'dev_version' ,
                    logs_activity.activity_summary_en = '1 build 1'   ,
                    logs_activity.activity_summary_fr = '1 build 1'   ");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       USERS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create default users with no password and varied access rights for testing purposes

// Generate preset users
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 1                 ,
                    users.nickname              = 'Admin'           ,
                    users.password              = ''                ,
                    users.is_administrator      = 1                 ,
                    users.last_visited_at       = '$last_visit'     ,
                    users.last_visited_page_en  = 'Unlisted page'   ,
                    users.last_visited_page_fr  = 'Page non listée' ,
                    users.last_visited_url      = ''                ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 2                 ,
                    users.nickname              = 'Mod'             ,
                    users.password              = ''                ,
                    users.is_moderator          = 1                 ,
                    users.last_visited_at       = '$last_visit'     ,
                    users.last_visited_page_en  = 'Unlisted page'   ,
                    users.last_visited_page_fr  = 'Page non listée' ,
                    users.last_visited_url      = ''                ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 4             ,
                    users.nickname              = 'User'        ,
                    users.password              = ''            ,
                    users.last_visited_at       = '$last_visit' ,
                    users.last_visited_page_en  = 'Index'       ,
                    users.last_visited_page_fr  = 'Index'       ,
                    users.last_visited_url      = 'index'       ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 5             ,
                    users.nickname              = 'Prude'       ,
                    users.password              = ''            ,
                    users.last_visited_at       = '$last_visit' ,
                    users.last_visited_page_en  = 'Index'       ,
                    users.last_visited_page_fr  = 'Index'       ,
                    users.last_visited_url      = 'index'       ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 6             ,
                    users.nickname              = 'Banned'      ,
                    users.password              = ''            ,
                    users.is_banned_until       = 1918625619    ,
                    users.is_banned_because     = 'Fixture'     ,
                    users.last_visited_at       = '$last_visit' ,
                    users.last_visited_page_en  = 'Index'       ,
                    users.last_visited_page_fr  = 'Index'       ,
                    users.last_visited_url      = 'index'       ");

// Activity logs
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1111239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '1'               ,
                    logs_activity.activity_nickname = 'Admin'           ");
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1211239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '2'               ,
                    logs_activity.activity_nickname = 'Mod'             ");
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1411239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '4'               ,
                    logs_activity.activity_nickname = 'User'           ");
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1511239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '5'               ,
                    logs_activity.activity_nickname = 'Prude'           ");
$timestamp = time();
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '$timestamp'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '6'               ,
                    logs_activity.activity_nickname = 'Banned'          ");

// Give these users profiles
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 1                     ,
                    users_profile.email_address = 'admin@localhost'     ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 2                     ,
                    users_profile.email_address = 'globalmod@localhost' ,
                    users_profile.created_at    = '1211239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 3                     ,
                    users_profile.email_address = 'moderator@localhost' ,
                    users_profile.created_at    = '1311239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 4                     ,
                    users_profile.email_address = 'user@localhost'      ,
                    users_profile.created_at    = '1411239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 5                     ,
                    users_profile.email_address = 'prude@localhost'     ,
                    users_profile.created_at    = '1511239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 6                     ,
                    users_profile.email_address = 'banned@localhost'    ,
                    users_profile.created_at    = '$timestamp '         ");

// Give these users stats
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 1 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 2 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 3 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 4 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 5 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 6 ");

// Give these users settings
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 1           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 2           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 3           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 4           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 5           ,
                    users_settings.show_nsfw_content  = 0 ,
                    users_settings.hide_tweets        = 1 ,
                    users_settings.hide_youtube       = 1 ,
                    users_settings.hide_google_trends = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 6           ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mass create randomly generated guests

// Determine the number of guests to generate
$random = mt_rand(50,100);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $name_en      = ucfirst(fixtures_generate_data('sentence', 1, 3, 1));
  $name_fr      = ucfirst(fixtures_generate_data('sentence', 1, 3, 1));
  $current_ip   = fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255);
  $last_visit   = mt_rand((time() - 2629746), time());
  $last_page_fr = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_page_en = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_url     = (mt_rand(0,2) < 2) ? 'index' : '';

  // Generate the guests
  query(" INSERT INTO users_guests
          SET         users_guests.randomly_assigned_name_en  = '$name_en'      ,
                      users_guests.randomly_assigned_name_fr  = '$name_fr'      ,
                      users_guests.ip_address                 = '$current_ip'   ,
                      users_guests.last_visited_at            = '$last_visit'   ,
                      users_guests.last_visited_page_en       = '$last_page_en' ,
                      users_guests.last_visited_page_fr       = '$last_page_fr' ,
                      users_guests.last_visited_url           = '$last_url'     ");
}

// Output progress
echo "<tr><td>Generated&nbsp;</td><td style=\"text-align:right\">$random</td><td>guests</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mass create randomly generated users

// Determine the number of users to generate
$random = mt_rand(500,1000);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,50) < 50) ? 0 : 1;
  $username     = ucfirst(fixtures_generate_data('string', 3, 15));
  $current_ip   = fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255);
  $email        = $username.'@localhost';
  $created_at   = mt_rand(1111239420, time());
  $last_visit   = mt_rand($created_at, time());
  $last_page_fr = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_page_en = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_url     = (mt_rand(0,2) < 2) ? 'index' : '';
  $birthday     = (mt_rand(0,4) < 4) ? '0000-00-00' : mt_rand(1980, 2010).'-'.mt_rand(1,12).'-'.mt_rand(1,28);
  $languages    = (mt_rand(0,5) < 5) ? '' : 'EN';
  $languages   .= (mt_rand(0,5) < 5) ? '' : 'FR';
  $gender       = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('string', 2, 8));
  $lives_at     = (mt_rand(0,6) < 6) ? '' : ucfirst(fixtures_generate_data('string', 10, 15));
  $occupation   = (mt_rand(0,6) < 6) ? '' : ucfirst(fixtures_generate_data('string', 10, 15));
  $profile_text = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('text', 1, 10));

  // Check if the nickname was already generated
  $dcheck = mysqli_fetch_array(query("  SELECT  users.id
                                        FROM    users
                                        WHERE   users.nickname LIKE '$username' "));

  // Ensure nicknames don't get generated twice
  if(!$dcheck['id'])
  {
    // Generate the users
    query(" INSERT INTO users
            SET         users.is_deleted            = '$deleted'      ,
                        users.nickname              = '$username'     ,
                        users.password              = ''              ,
                        users.last_visited_at       = '$last_visit'   ,
                        users.last_visited_page_en  = '$last_page_en' ,
                        users.last_visited_page_fr  = '$last_page_fr' ,
                        users.last_visited_url      = '$last_url'     ,
                        users.current_ip_address    = '$current_ip'   ");

    // Fetch the id of the generated users
    $user_id = query_id();

    // Generate the rest of the user data
    query(" INSERT INTO users_profile
            SET         users_profile.fk_users          = '$user_id'      ,
                        users_profile.email_address     = '$email'        ,
                        users_profile.created_at        = '$created_at '  ,
                        users_profile.birthday          = '$birthday'     ,
                        users_profile.spoken_languages  = '$languages'    ,
                        users_profile.gender            = '$gender'       ,
                        users_profile.lives_at          = '$lives_at'     ,
                        users_profile.occupation        = '$occupation'   ,
                        users_profile.profile_text      = '$profile_text' ");

    query(" INSERT INTO users_settings
            SET         users_settings.fk_users = '$user_id' ");

    query(" INSERT INTO users_stats
            SET         users_stats.fk_users = '$user_id' ");

    // Add some logs
    if(!$deleted)
    {
      $deleted_log = (mt_rand(0,50) < 50) ? 0 : 1;
      query(" INSERT INTO logs_activity
              SET         logs_activity.is_deleted        = '$deleted_log'    ,
                          logs_activity.happened_at       = '$created_at'     ,
                          logs_activity.language          = 'ENFR'            ,
                          logs_activity.activity_type     = 'users_register'  ,
                          logs_activity.fk_users          = '$user_id'        ,
                          logs_activity.activity_nickname = '$username'       ");
    }

    if(!$deleted && $profile_text && mt_rand(0,3) >= 3)
    {
      $deleted_log  = (mt_rand(0,50) < 50) ? 0 : 1;
      $edited_at    = mt_rand($created_at, time());
      $text_before  = (mt_rand(0,1)) ? '' : ucfirst(fixtures_generate_data('text', 1, 10));
      query(" INSERT INTO logs_activity
              SET         logs_activity.is_deleted          = '$deleted_log'        ,
                          logs_activity.happened_at         = '$edited_at'          ,
                          logs_activity.is_moderators_only  = 1                     ,
                          logs_activity.language            = 'ENFR'                ,
                          logs_activity.activity_type       = 'users_profile_edit'  ,
                          logs_activity.fk_users            = '$user_id'            ,
                          logs_activity.activity_nickname   = '$username'           ");
      $log_id = query_id();
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                          logs_activity_details.content_description_en  = 'Profile text'  ,
                          logs_activity_details.content_description_fr  = 'Texte libre'   ,
                          logs_activity_details.content_before          = '$text_before'  ,
                          logs_activity_details.content_after           = '$profile_text' ");
    }
    else if(!$deleted && $profile_text && mt_rand(0,3) >= 3)
    {
      $deleted_log  = (mt_rand(0,15) < 15) ? 0 : 1;
      $edited_at    = mt_rand($created_at, time());
      $text_before  = (mt_rand(0,1)) ? '' : ucfirst(fixtures_generate_data('text', 1, 10));
      query(" INSERT INTO logs_activity
              SET         logs_activity.is_deleted                  = '$deleted_log'              ,
                          logs_activity.happened_at                 = '$edited_at'                ,
                          logs_activity.is_moderators_only          = 1                           ,
                          logs_activity.language                    = 'ENFR'                      ,
                          logs_activity.activity_type               = 'users_admin_edit_profile'  ,
                          logs_activity.fk_users                    = '$user_id'                  ,
                          logs_activity.activity_nickname           = '$username'                 ,
                          logs_activity.activity_moderator_nickname = 'Admin'                     ");
      $log_id = query_id();
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                          logs_activity_details.content_description_en  = 'Profile text'  ,
                          logs_activity_details.content_description_fr  = 'Texte libre'   ,
                          logs_activity_details.content_before          = '$text_before'  ,
                          logs_activity_details.content_after           = '$profile_text' ");
    }
    else if(!$deleted && !$profile_text && mt_rand(0,50) >= 50)
    {
      $deleted_log  = (mt_rand(0,25) < 25) ? 0 : 1;
      $edited_at    = mt_rand($created_at, time());
      $text_before  = ucfirst(fixtures_generate_data('text', 1, 10));
      query(" INSERT INTO logs_activity
              SET         logs_activity.is_deleted          = '$deleted_log'        ,
                          logs_activity.happened_at         = '$edited_at'          ,
                          logs_activity.is_moderators_only  = 1                     ,
                          logs_activity.language            = 'ENFR'                ,
                          logs_activity.activity_type       = 'users_profile_edit'  ,
                          logs_activity.fk_users            = '$user_id'            ,
                          logs_activity.activity_nickname   = '$username'           ");
      $log_id = query_id();
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                          logs_activity_details.content_description_en  = 'Profile text'  ,
                          logs_activity_details.content_description_fr  = 'Texte libre'   ,
                          logs_activity_details.content_before          = '$text_before'  ,
                          logs_activity_details.content_after           = ''              ");
    }
    if(mt_rand(0,100) >= 100)
    {
      $edited_at = mt_rand($created_at, time());
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at                 = '$edited_at'                ,
                          logs_activity.is_moderators_only          = 1                           ,
                          logs_activity.language                    = 'ENFR'                      ,
                          logs_activity.activity_type               = 'users_admin_edit_password' ,
                          logs_activity.fk_users                    = '$user_id'                  ,
                          logs_activity.activity_nickname           = '$username'                 ,
                          logs_activity.activity_moderator_nickname = 'Admin'                     ");
    }
    if(mt_rand(0,150) >= 150)
    {
      $banned_at    = mt_rand($created_at, time());
      $unbanned_at  = mt_rand($banned_at, time());
      $ban_reason   = ucfirst(fixtures_generate_data('sentence', 4, 8));
      $unban_reason = (mt_rand(0,1)) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
      $ban_length   = (abs($banned_at - $unbanned_at) / 86400);
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at             = '$banned_at'    ,
                          logs_activity.fk_users                = '$user_id'      ,
                          logs_activity.language                = 'ENFR'          ,
                          logs_activity.activity_type           = 'users_banned'  ,
                          logs_activity.activity_amount         = '$ban_length'   ,
                          logs_activity.activity_nickname       = '$username'     ");
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at                 = '$banned_at'    ,
                          logs_activity.is_moderators_only          = 1               ,
                          logs_activity.language                    = 'ENFR'          ,
                          logs_activity.activity_type               = 'users_banned'  ,
                          logs_activity.activity_id                 = '$user_id'      ,
                          logs_activity.activity_nickname           = '$username'     ,
                          logs_activity.activity_moderator_nickname = 'Admin'         ,
                          logs_activity.moderation_reason           = '$ban_reason'   ");
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at             = '$unbanned_at'    ,
                          logs_activity.fk_users                = '$user_id'        ,
                          logs_activity.language                = 'ENFR'            ,
                          logs_activity.activity_type           = 'users_unbanned'  ,
                          logs_activity.activity_amount         = '$ban_length'     ,
                          logs_activity.activity_nickname       = '$username'       ");
      if($unban_reason)
        query(" INSERT INTO logs_activity
                SET         logs_activity.happened_at                 = '$unbanned_at'    ,
                            logs_activity.is_moderators_only          = 1                 ,
                            logs_activity.language                    = 'ENFR'            ,
                            logs_activity.activity_type               = 'users_unbanned'  ,
                            logs_activity.activity_id                 = '$user_id'        ,
                            logs_activity.activity_nickname           = '$username'       ,
                            logs_activity.activity_moderator_nickname = 'Admin'           ,
                            logs_activity.moderation_reason           = '$unban_reason'   ");
    }
    if(mt_rand(0,250) >= 250)
    {
      $granted_at     = mt_rand($created_at, time());
      $reverted_at    = mt_rand($granted_at, time());
      $granted_rights = (mt_rand(0,3) >= 3) ? 'users_rights_administrator' : 'users_rights_moderator';
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at             = '$granted_at'     ,
                          logs_activity.language                = 'ENFR'            ,
                          logs_activity.activity_type           = '$granted_rights' ,
                          logs_activity.activity_nickname       = '$username'       ");
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at             = '$reverted_at'        ,
                          logs_activity.language                = 'ENFR'                ,
                          logs_activity.activity_type           = 'users_rights_delete' ,
                          logs_activity.activity_nickname       = '$username'           ");
    }
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>users</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add some randomly generated private messages

// Determine the number of messages to generate
$random = mt_rand(1500,3000);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,5) < 5) ? 0 : 1;
  $recipient  = fixtures_fetch_random_id('users');
  $sender     = (mt_rand(0,1)) ? fixtures_fetch_random_id('users') : 0;
  $sent_at    = mt_rand(1111239420, time());
  $read_at    = (mt_rand(0,5) < 3) ? mt_rand($sent_at, time()) : 0;
  $title      = fixtures_generate_data('sentence', 4, 7);
  $body       = fixtures_generate_data('text', 1, 3);

  // Generate the private messages
  query(" INSERT INTO users_private_messages
          SET         users_private_messages.is_deleted         = '$deleted'    ,
                      users_private_messages.fk_users_recipient = '$recipient'  ,
                      users_private_messages.fk_users_sender    = '$sender'     ,
                      users_private_messages.sent_at            = '$sent_at'    ,
                      users_private_messages.read_at            = '$read_at'    ,
                      users_private_messages.title              = '$title'      ,
                      users_private_messages.body               = '$body'       ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>private messages</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     DEV STUFF                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Randomly generated devblogs

// Determine the number of devblogs to generate
$random = mt_rand(25, 75);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,15) < 15) ? 0 : 1;
  $posted_at  = mt_rand(1111239420, time());
  $title_en   = (mt_rand(0,1)) ? fixtures_generate_data('sentence', 4, 7) : '';
  $title_fr   = (!$title_en || mt_rand(0,1)) ? fixtures_generate_data('sentence', 4, 7) : '';
  $body_en    = ($title_en) ? fixtures_generate_data('text', 1, 5) : '';
  $body_fr    = ($title_fr) ? fixtures_generate_data('text', 1, 5) : '';

  // Generate the devblogs
  query(" INSERT INTO dev_blogs
          SET         dev_blogs.is_deleted= '$deleted'    ,
                      dev_blogs.posted_at = '$posted_at'  ,
                      dev_blogs.title_en  = '$title_en'   ,
                      dev_blogs.title_fr  = '$title_fr'   ,
                      dev_blogs.body_en   = '$body_en'    ,
                      dev_blogs.body_fr   = '$body_fr'    ");

  // Activity logs
  $deleted_log  = (mt_rand(0,15) < 15) ? 0 : 1;
  $blog_id      = query_id();
  query(" INSERT INTO logs_activity
          SET         logs_activity.is_deleted          = '$deleted_log'  ,
                      logs_activity.happened_at         = '$posted_at'    ,
                      logs_activity.language            = 'ENFR'          ,
                      logs_activity.activity_type       = 'dev_blog'      ,
                      logs_activity.activity_id         = '$blog_id'      ,
                      logs_activity.activity_summary_en = '$title_en'     ,
                      logs_activity.activity_summary_fr = '$title_fr'     ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>devblogs</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Randomly generated tasks

// Generate some random categories
$random = mt_rand(10,20);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $title_en = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr = ucfirst(fixtures_generate_data('string', 5, 15));

  // Generate the categories
  query(" INSERT INTO dev_tasks_categories
          SET         dev_tasks_categories.title_en = '$title_en' ,
                      dev_tasks_categories.title_fr = '$title_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>task categories</td></tr>";
ob_flush();
flush();

// Generate some random milestones
$random = mt_rand(25,50);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $title_en       = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr       = ucfirst(fixtures_generate_data('string', 5, 15));
  $summary_en     = (mt_rand(0,4) < 4) ? '' : fixtures_generate_data('text', 1, 1);
  $summary_fr     = (mt_rand(0,4) < 4) ? '' : fixtures_generate_data('text', 1, 1);

  // Generate the milestones
  query(" INSERT INTO dev_tasks_milestones
          SET         dev_tasks_milestones.sorting_order  = '$i'          ,
                      dev_tasks_milestones.title_en       = '$title_en'   ,
                      dev_tasks_milestones.title_fr       = '$title_fr'   ,
                      dev_tasks_milestones.summary_en     = '$summary_en' ,
                      dev_tasks_milestones.summary_fr     = '$summary_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>task milestones</td></tr>";
ob_flush();
flush();

// Generate some random tasks
$random = mt_rand(250,500);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted          = (mt_rand(0,25) < 25) ? 0 : 1;
  $fk_users         = (mt_rand(0,4) < 4) ? 1 : fixtures_fetch_random_id('users');
  $created_at       = mt_rand(1111239420, time());
  $finished_at      = (mt_rand(0,4) < 4) ? mt_rand($created_at, time()) : 0;
  $admin_validation = (mt_rand(0,50) < 50) ? 1 : 0;
  $is_public        = (mt_rand(0,20) < 20) ? 1 : 0;
  $priority_level   = mt_rand(0,5);
  $title_en         = ucfirst(fixtures_generate_data('sentence', 2, 10, 1));
  $title_fr         = ucfirst(fixtures_generate_data('sentence', 2, 10, 1));
  $body_en          = fixtures_generate_data('text', 1, 5);
  $body_fr          = fixtures_generate_data('text', 1, 5);
  $category         = fixtures_fetch_random_id('dev_tasks_categories');
  $milestone        = fixtures_fetch_random_id('dev_tasks_milestones');
  $source_code_link = ($finished_at && mt_rand(0,1)) ? 'http://nobleme.com/' : '';


  // Generate the tasks
  query(" INSERT INTO dev_tasks
          SET         dev_tasks.is_deleted              = '$deleted'          ,
                      dev_tasks.fk_users                = '$fk_users'         ,
                      dev_tasks.created_at              = '$created_at'       ,
                      dev_tasks.finished_at             = '$finished_at'      ,
                      dev_tasks.admin_validation        = '$admin_validation' ,
                      dev_tasks.is_public               = '$is_public'        ,
                      dev_tasks.priority_level          = '$priority_level'   ,
                      dev_tasks.title_en                = '$title_en'         ,
                      dev_tasks.title_fr                = '$title_fr'         ,
                      dev_tasks.body_en                 = '$body_en'          ,
                      dev_tasks.body_fr                 = '$body_fr'          ,
                      dev_tasks.fk_dev_tasks_categories = '$category'         ,
                      dev_tasks.fk_dev_tasks_milestones = '$milestone'        ,
                      dev_tasks.source_code_link        = '$source_code_link' ");

  // Activity logs
  $deleted_log  = (mt_rand(0,40) < 40) ? 0 : 1;
  $task_id      = query_id();
  $dnickname    = mysqli_fetch_array(query("  SELECT  users.nickname AS 'u_nick'
                                              FROM    users
                                              WHERE   users.id = '$fk_users' "));
  $nickname   = $dnickname['u_nick'];
  query(" INSERT INTO logs_activity
          SET         logs_activity.is_deleted          = '$deleted_log'  ,
                      logs_activity.happened_at         = '$created_at'   ,
                      logs_activity.language            = 'ENFR'          ,
                      logs_activity.activity_type       = 'dev_task_new'  ,
                      logs_activity.activity_nickname   = '$nickname'     ,
                      logs_activity.activity_id         = '$task_id'      ,
                      logs_activity.activity_summary_en = '$title_en'     ,
                      logs_activity.activity_summary_fr = '$title_fr'     ");
  if($finished_at)
  {
    $deleted_log  = (mt_rand(0,20) < 20) ? 0 : 1;
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted          = '$deleted_log'      ,
                        logs_activity.happened_at         = '$finished_at'      ,
                        logs_activity.language            = 'ENFR'              ,
                        logs_activity.activity_type       = 'dev_task_finished' ,
                        logs_activity.activity_id         = '$task_id'          ,
                        logs_activity.activity_summary_en = '$title_en'         ,
                        logs_activity.activity_summary_fr = '$title_fr'         ");
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>tasks</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      MEETUPS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Generate some meetups
$random       = mt_rand(40,60);
$meetup_users = 0;
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,15) < 15) ? 0 : 1;
  $event_date = date('Y-m-d', mt_rand(1111339420, time()));
  $location   = fixtures_generate_data('string', 5, 15);
  $reason_en  = (mt_rand(0,3) < 3) ? '' : fixtures_generate_data('sentence', 1, 4, 1);
  $reason_fr  = ($reason_en) ? fixtures_generate_data('sentence', 1, 4, 1) : '';
  $details_en = fixtures_generate_data('text', 1, 5);
  $details_fr = fixtures_generate_data('text', 1, 5);

  // Generate the meetups
  query(" INSERT INTO meetups
          SET         meetups.is_deleted      = '$deleted'    ,
                      meetups.event_date      = '$event_date' ,
                      meetups.location        = '$location'   ,
                      meetups.event_reason_en = '$reason_en'  ,
                      meetups.event_reason_fr = '$reason_fr'  ,
                      meetups.details_en      = '$details_en' ,
                      meetups.details_fr      = '$details_fr' ");

  // Fetch the ID of the generated meetup
  $meetup = query_id();

  // Activity logs
  $deleted_log  = (mt_rand(0,25) < 25) ? 0 : 1;
  $created_at   = strtotime($event_date) - (mt_rand(0,100) * 86400);
  $created_at   = ($created_at < 1111239420) ? mt_rand(1111239420, strtotime($event_date)) : $created_at;
  $meetup_date  = strtotime($event_date);
  if(!$deleted)
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted          = '$deleted_log'  ,
                        logs_activity.happened_at         = '$created_at'   ,
                        logs_activity.language            = 'ENFR'          ,
                        logs_activity.activity_type       = 'meetups_new'   ,
                        logs_activity.activity_id         = '$meetup'       ,
                        logs_activity.activity_summary_en = '$meetup_date'  ,
                        logs_activity.activity_summary_fr = '$meetup_date'  ");
  query(" INSERT INTO logs_activity
          SET         logs_activity.is_deleted                  = '$deleted_log'  ,
                      logs_activity.happened_at                 = '$created_at'   ,
                      logs_activity.is_moderators_only          = 1               ,
                      logs_activity.language                    = 'ENFR'          ,
                      logs_activity.activity_moderator_nickname = 'Admin'         ,
                      logs_activity.activity_type               = 'meetups_new'   ,
                      logs_activity.activity_id                 = '$meetup'       ,
                      logs_activity.activity_summary_en         = '$meetup_date'  ,
                      logs_activity.activity_summary_fr         = '$meetup_date'  ");

  // Activity logs: edited
  if(mt_rand(0,15) >= 15)
  {
    $deleted_log  = (mt_rand(0,5) < 5) ? 0 : 1;
    $edited_at    = mt_rand($created_at, strtotime($event_date));
    $old_location = fixtures_generate_data('string', 5, 15);
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted                  = '$deleted_log'  ,
                        logs_activity.happened_at                 = '$edited_at'    ,
                        logs_activity.is_moderators_only          = 1               ,
                        logs_activity.language                    = 'ENFR'          ,
                        logs_activity.activity_moderator_nickname = 'Admin'         ,
                        logs_activity.activity_type               = 'meetups_edit'  ,
                        logs_activity.activity_id                 = '$meetup'       ,
                        logs_activity.activity_summary_en         = '$meetup_date'  ,
                        logs_activity.activity_summary_fr         = '$meetup_date'  ");
    $log_id = query_id();
    query(" INSERT INTO logs_activity_details
            SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                        logs_activity_details.content_description_en  = 'Location'      ,
                        logs_activity_details.content_description_fr  = 'Lieu'          ,
                        logs_activity_details.content_before          = '$old_location' ,
                        logs_activity_details.content_after           = '$location'     ");
  }

  // Activity logs: deleted
  if($deleted)
  {
    $deleted_at = mt_rand($created_at, strtotime($event_date));
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted                  = '$deleted_log'    ,
                        logs_activity.happened_at                 = '$deleted_at'     ,
                        logs_activity.is_moderators_only          = 1                 ,
                        logs_activity.language                    = 'ENFR'            ,
                        logs_activity.activity_moderator_nickname = 'Admin'           ,
                        logs_activity.activity_type               = 'meetups_delete'  ,
                        logs_activity.activity_summary_en         = '$meetup_date'  ,
                        logs_activity.activity_summary_fr         = '$meetup_date'  ");
    $log_id   = query_id();
    $random2  = mt_rand(1,10);
    for($i = 0; $i < $random2; $i++)
    {
      $nickname = fixtures_generate_data('string', 3, 18);
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'     ,
                          logs_activity_details.content_description_en  = 'Attending'   ,
                          logs_activity_details.content_description_fr  = 'Participant' ,
                          logs_activity_details.content_before          = '$nickname'   ");
    }
  }

  // Add some people to the meetup
  $random2       = mt_rand(5,10);
  $meetup_users += $random2;
  $user_list     = array();
  for($j = 0; $j < $random2; $j++)
  {
    // Generate random data
    $user       = (mt_rand(0,3) < 3) ? fixtures_fetch_random_id('users') : 0;
    $nickname   = ($user) ? '' : fixtures_generate_data('string', 3, 18);
    $attendance = (strtotime($event_date) > time() && mt_rand(0,1)) ? 0 : 1;
    $extra_en   = (mt_rand(0,3) < 3) ? '' : fixtures_generate_data('sentence', 2, 5, 1);
    $extra_fr   = (mt_rand(0,3) < 3) ? '' : fixtures_generate_data('sentence', 2, 5, 1);

    // If the user isn't in the meetup yet, add them
    if(!$user || !in_array($user, $user_list))
    {
      array_push($user_list, $user);
      query(" INSERT INTO meetups_people
              SET         meetups_people.fk_meetups           = '$meetup'     ,
                          meetups_people.fk_users             = '$user'       ,
                          meetups_people.nickname             = '$nickname'   ,
                          meetups_people.attendance_confirmed = '$attendance' ,
                          meetups_people.extra_information_en = '$extra_en'   ,
                          meetups_people.extra_information_fr = '$extra_fr'   ");

      // Activity logs
      $deleted_log  = (mt_rand(0,25) < 25) ? 0 : 1;
      $added_at     = mt_rand($created_at, strtotime($event_date));
      if(!$deleted && $nickname)
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted          = '$deleted_log'        ,
                            logs_activity.happened_at         = '$added_at'           ,
                            logs_activity.language            = 'ENFR'                ,
                            logs_activity.activity_type       = 'meetups_people_new'  ,
                            logs_activity.activity_nickname   = '$nickname'           ,
                            logs_activity.activity_id         = '$meetup'             ,
                            logs_activity.activity_summary_en = '$meetup_date'  ,
                            logs_activity.activity_summary_fr = '$meetup_date'  ");
      if($nickname)
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted                  = '$deleted_log'        ,
                            logs_activity.happened_at                 = '$added_at'           ,
                            logs_activity.is_moderators_only          = 1                     ,
                            logs_activity.language                    = 'ENFR'                ,
                            logs_activity.activity_nickname           = '$nickname'           ,
                            logs_activity.activity_type               = 'meetups_people_new'  ,
                            logs_activity.activity_id                 = '$meetup'             ,
                            logs_activity.activity_summary_en         = '$meetup_date'        ,
                            logs_activity.activity_summary_fr         = '$meetup_date'        ,
                            logs_activity.activity_moderator_nickname = 'Admin'               ");

      // Activity logs: edited
      if($nickname && mt_rand(0,25) >= 25)
      {
        $deleted_log  = (mt_rand(0,5) < 5) ? 0 : 1;
        $edited_at    = mt_rand($created_at, strtotime($event_date));
        $old_extra    = fixtures_generate_data('sentence', 2, 5, 1);
        $new_extra    = ($extra_en) ? $extra_en : $extra_fr;
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted                  = '$deleted_log'        ,
                            logs_activity.happened_at                 = '$edited_at'          ,
                            logs_activity.is_moderators_only          = 1                     ,
                            logs_activity.language                    = 'ENFR'                ,
                            logs_activity.activity_nickname           = '$nickname'           ,
                            logs_activity.activity_type               = 'meetups_people_edit' ,
                            logs_activity.activity_id                 = '$meetup'             ,
                            logs_activity.activity_summary_en         = '$meetup_date'        ,
                            logs_activity.activity_summary_fr         = '$meetup_date'        ,
                            logs_activity.activity_moderator_nickname = 'Admin'               ");
        $log_id = query_id();
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                            logs_activity_details.content_description_en  = 'Extra info'    ,
                            logs_activity_details.content_description_fr  = 'Détails'       ,
                            logs_activity_details.content_before          = '$old_extra'    ,
                            logs_activity_details.content_after           = '$new_extra'    ");
      }

      // Activity logs: deleted
      if($nickname && mt_rand(0,25) >= 25)
      {
        $deleted_log  = (mt_rand(0,5) < 5) ? 0 : 1;
        $deleted_at   = mt_rand($created_at, strtotime($event_date));
        $deleted_nick = fixtures_generate_data('string', 3, 18);
        $extra_info   = fixtures_generate_data('sentence', 2, 5, 1);
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted              = '$deleted_log'          ,
                            logs_activity.happened_at             = '$deleted_at'           ,
                            logs_activity.language                = 'ENFR'                  ,
                            logs_activity.activity_nickname       = '$deleted_nick'         ,
                            logs_activity.activity_type           = 'meetups_people_delete' ,
                            logs_activity.activity_id             = '$meetup'               ,
                            logs_activity.activity_summary_en     = '$meetup_date'          ,
                            logs_activity.activity_summary_fr     = '$meetup_date'          ");
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted                  = '$deleted_log'          ,
                            logs_activity.happened_at                 = '$deleted_at'           ,
                            logs_activity.is_moderators_only          = 1                       ,
                            logs_activity.language                    = 'ENFR'                  ,
                            logs_activity.activity_nickname           = '$deleted_nick'         ,
                            logs_activity.activity_type               = 'meetups_people_delete' ,
                            logs_activity.activity_id                 = '$meetup'               ,
                            logs_activity.activity_summary_en         = '$meetup_date'          ,
                            logs_activity.activity_summary_fr         = '$meetup_date'          ,
                            logs_activity.activity_moderator_nickname = 'Admin'                 ");
        $log_id = query_id();
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                            logs_activity_details.content_description_en  = 'Extra info'    ,
                            logs_activity_details.content_description_fr  = 'Détails'       ,
                            logs_activity_details.content_before          = '$extra_info'   ");
      }
    }
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>meetups</td></tr>";
echo "<tr><td>Generated</td><td style=\"text-align:right\">$meetup_users</td><td>meetup attending users</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      QUOTES                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Generate some quotes
$random       = mt_rand(200,400);
$quote_users  = 0;
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,10) < 10) ? 0 : 1;
  $submitter  = fixtures_fetch_random_id('users');
  $validated  = (mt_rand(0,50) < 50) ? 1 : 0;
  $submitted  = mt_rand(1111239420, time());
  $nsfw       = (mt_rand(0,8) < 8) ? 0 : 1;
  $language   = (mt_rand(0,1)) ? 'EN' : 'FR';
  $body       = fixtures_generate_data('text', 1, 1);

  // Generate the quotes
  query(" INSERT INTO quotes
          SET         quotes.is_deleted         = '$deleted'    ,
                      quotes.fk_users_submitter = '$submitter'  ,
                      quotes.admin_validation   = '$validated'  ,
                      quotes.submitted_at       = '$submitted'  ,
                      quotes.is_nsfw            = '$nsfw'       ,
                      quotes.language           = '$language'   ,
                      quotes.body               = '$body'       ");

  // Activity logs
  $quote = query_id();
  if(!$deleted && $language == 'EN')
    query(" INSERT INTO logs_activity
            SET         logs_activity.happened_at       = '$submitted'    ,
                        logs_activity.language          = 'ENFR'          ,
                        logs_activity.activity_type     = 'quotes_new_en' ,
                        logs_activity.activity_id       = '$quote'        ");
  else if(!$deleted && $language == 'FR')
    query(" INSERT INTO logs_activity
            SET         logs_activity.happened_at       = '$submitted'    ,
                        logs_activity.language          = 'FR'            ,
                        logs_activity.activity_type     = 'quotes_new_fr' ,
                        logs_activity.activity_id       = '$quote'        ");

  // Link some users to the quote
  $random2      = mt_rand(1,4);
  $quote_users += $random2;
  $user_list    = array();
  for($j = 0; $j < $random2; $j++)
  {
    // Generate random data
    $user = fixtures_fetch_random_id('users');

    // If the user isn't linked to the quote yet, add them
    if(!in_array($user, $user_list))
    {
      array_push($user_list, $user);
      query(" INSERT INTO quotes_users
              SET         quotes_users.fk_quotes  = '$quote'  ,
                          quotes_users.fk_users   = '$user'   ");
    }
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>quotes</td></tr>";
echo "<tr><td>Generated</td><td style=\"text-align:right\">$quote_users</td><td>quote-user links</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                     WRITINGS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Texts

// Generate some random texts
$random = mt_rand(100,200);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,10) < 10) ? 0 : 1;
  $user       = fixtures_fetch_random_id('users');
  $language   = (mt_rand(0,1)) ? 'EN' : 'FR';
  $anonymous  = (mt_rand(0,5) < 5) ? 0 : 1;
  $created_at = mt_rand(1111239420, time());
  $edited_at  = (mt_rand(0,5) < 5) ? 0 : mt_rand($created_at, time());
  $title      = fixtures_generate_data('sentence', 2, 6, 1);
  $body       = fixtures_generate_data('text', 2, 5);
  $length     = strlen($body);

  // Generate the writings
  query(" INSERT INTO writings_texts
          SET         writings_texts.is_deleted             = '$deleted'    ,
                      writings_texts.fk_users               = '$user'       ,
                      writings_texts.language               = '$language'   ,
                      writings_texts.is_anonymous           = '$anonymous'  ,
                      writings_texts.created_at             = '$created_at' ,
                      writings_texts.edited_at              = '$edited_at'  ,
                      writings_texts.title                  = '$title'      ,
                      writings_texts.character_count        = '$length'     ,
                      writings_texts.body                   = '$body'       ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>writings</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contests

// Generate some random contests
$random         = mt_rand(8,14);
$contest_votes  = 0;
for($i = 1; $i < $random; $i++)
{
  // Add a bunch of texts to the contest
  $random2  = mt_rand(4,8);
  $language = (mt_rand(0,1)) ? 'EN' : 'FR';
  query(" UPDATE    writings_texts
          SET       writings_texts.fk_writings_contests = '$i'
          WHERE     writings_texts.language             = '$language'
          ORDER BY  RAND()
          LIMIT     $random2 ");

  // Generate random data
  $deleted  = (mt_rand(0,5) < 5) ? 0 : 1;
  $started  = mt_rand(1111239420, time());
  $ended    = mt_rand($started, time());
  $entries  = $random2;
  $name     = fixtures_generate_data('sentence', 2, 4, 1);
  $topic    = fixtures_generate_data('sentence', 4, 7);

  // Generate the contest
  query(" INSERT INTO writings_contests
          SET         writings_contests.id            = '$i'        ,
                      writings_contests.is_deleted    = '$deleted'  ,
                      writings_contests.language      = '$language' ,
                      writings_contests.started_at    = '$started'  ,
                      writings_contests.ended_at      = '$ended'    ,
                      writings_contests.nb_entries    = '$entries'  ,
                      writings_contests.contest_name  = '$name'     ,
                      writings_contests.contest_topic = '$topic'    ");

  // Fetch the ID of the generated contest
  $contest = query_id();

  // Link some votes to the contest
  $random2        = mt_rand(5,10);
  $contest_votes += $random2;
  $qvoters        = query(" SELECT    users.id AS 'u_id'
                            FROM      users
                            ORDER BY  rand()
                            LIMIT     $random2 ");
  while($dvoters = mysqli_fetch_array($qvoters))
  {
    // Fetch some texts
    $qvotes  = query("  SELECT    writings_texts.id AS 't_id'
                        FROM      writings_texts
                        WHERE     writings_texts.fk_writings_contests = '$i'
                        ORDER BY  rand()
                        LIMIT     3 ");

    // Insert the votes
    $user = $dvoters['u_id'];
    for($j = 0;$j < 3;$j++)
    {
      $dvotes = mysqli_fetch_array($qvotes);
      $text   = $dvotes['t_id'];
      $weight = (!$j) ? 5 : 3;
      $weight = ($j == 2) ? 1 : $weight;
      query(" INSERT INTO writings_contests_votes
              SET         writings_contests_votes.fk_writings_contests  = '$i'      ,
                          writings_contests_votes.fk_writings_texts     = '$text'   ,
                          writings_contests_votes.fk_users              = '$user'   ,
                          writings_contests_votes.vote_weight           = '$weight' ");
    }
  }

  // Determine the contest's winner
  $dwintext = mysqli_fetch_array(query("  SELECT    writings_contests_votes.fk_writings_texts AS 't_id' ,
                                                    SUM(writings_contests_votes.vote_weight)  AS 'c_votes'
                                          FROM      writings_contests_votes
                                          WHERE     writings_contests_votes.fk_writings_contests  = '$i'
                                          GROUP BY  writings_contests_votes.fk_writings_texts
                                          ORDER BY  SUM(writings_contests_votes.vote_weight) DESC
                                          LIMIT     1 "));
  $wintext  = $dwintext['t_id'];
  $dwinner  = mysqli_fetch_array(query("  SELECT  writings_texts.fk_users AS 'u_id'
                                          FROM    writings_texts
                                          WHERE   writings_texts.id = '$wintext' "));
  $winner   = $dwinner['u_id'];

  // Update the contest with its results
  query(" UPDATE  writings_contests
          SET     writings_contests.fk_users_winner           = '$winner' ,
                  writings_contests.fk_writings_texts_winner  = '$wintext'
          WHERE   writings_contests.id = '$i' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>writing contests</td></tr>";
echo "<tr><td>Generated</td><td style=\"text-align:right\">$contest_votes</td><td>writing contest votes</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 INTERNET CULTURE                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Admin notes

// Generate some random strings
$global_notes = fixtures_generate_data('text', 1, 1);
$draft_en     = fixtures_generate_data('text', 1, 1);
$draft_fr     = fixtures_generate_data('text', 1, 1);
$snippets     = fixtures_generate_data('text', 1, 1);
$template_en  = fixtures_generate_data('text', 1, 1);
$template_fr  = fixtures_generate_data('text', 1, 1);

// Generate admin notes
query(" INSERT INTO internet_admin_notes
        SET         internet_admin_notes.global_notes = '$global_notes' ,
                    internet_admin_notes.draft_en     = '$draft_en'     ,
                    internet_admin_notes.draft_fr     = '$draft_fr'     ,
                    internet_admin_notes.snippets     = '$snippets'     ,
                    internet_admin_notes.template_en  = '$template_en'  ,
                    internet_admin_notes.template_fr  = '$template_fr'  ");

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">1</td><td>internet encyclopedia admin notes</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// internet encyclopedia

// Generate some random categories
$random = mt_rand(8,16);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $display    = $i * mt_rand(1,100);
  $title_en   = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr   = ucfirst(fixtures_generate_data('string', 5, 15));
  $details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
  $details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));

  // Generate the categories
  query(" INSERT INTO internet_categories
          SET         internet_categories.display_order   = '$display'    ,
                      internet_categories.name_en         = '$title_en'   ,
                      internet_categories.name_fr         = '$title_fr'   ,
                      internet_categories.description_en  = '$details_en' ,
                      internet_categories.description_fr  = '$details_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>internet encyclopedia categories</td></tr>";
ob_flush();
flush();

// Generate some random eras
$random = mt_rand(5,10);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $start_year = mt_rand(1999, (date('Y') - 1));
  $end_year   = (!$i) ? 0 : mt_rand($start_year, date('Y'));
  $title_en   = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr   = ucfirst(fixtures_generate_data('string', 5, 15));
  $details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
  $details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));

  // Generate the categories
  query(" INSERT INTO internet_eras
          SET         internet_eras.began_in_year   = '$start_year' ,
                      internet_eras.ended_in_year   = '$end_year'   ,
                      internet_eras.name_en         = '$title_en'   ,
                      internet_eras.name_fr         = '$title_fr'   ,
                      internet_eras.description_en  = '$details_en' ,
                      internet_eras.description_fr  = '$details_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>internet encyclopedia eras</td></tr>";
ob_flush();
flush();

// Generate some random pages
$page_titles_en = array();
$page_titles_fr = array();
$random         = mt_rand(200,400);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,20) < 20) ? 0 : 1;
  $era          = fixtures_fetch_random_id('internet_eras');
  $dictionary   = mt_rand(0,1);
  $title_en     = ucfirst(fixtures_generate_data('sentence', 1, 6, 1));
  $title_fr     = ucfirst(fixtures_generate_data('sentence', 1, 6, 1));
  $appeared_y   = (mt_rand(0,4) < 4) ? mt_rand(1999, date('Y')) : 0;
  $appeared_m   = ($appeared_y && mt_rand(0,4) < 4) ? mt_rand(1,12) : 0;
  $spread_y     = ($appeared_y && mt_rand(0,3) < 3) ? mt_rand($appeared_y, date('Y')) : 0;
  $spread_m     = ($appeared_y && mt_rand(0,4) < 4) ? mt_rand($appeared_m, 12) : 0;
  $is_nsfw      = (mt_rand(0,5) < 5) ? 0 : 1;
  $is_gross     = (mt_rand(0,10) < 10) ? 0 : 1;
  $is_political = (mt_rand(0,10) < 10) ? 0 : 1;
  $is_incorrect = (mt_rand(0,10) < 10) ? 0 : 1;
  $body_en      = fixtures_generate_data('text', 2, 5);
  $body_fr      = fixtures_generate_data('text', 2, 5);
  $admin_notes  = (mt_rand(0,10) < 10) ? '' : fixtures_generate_data('text', 1, 1);

  // Generate the pages if they don't exist already
  if(!in_array($title_en, $page_titles_en) && !in_array($title_fr, $page_titles_fr))
  {
    array_push($page_titles_en, $title_en);
    array_push($page_titles_fr, $title_fr);
    query(" INSERT INTO internet_pages
            SET         internet_pages.is_deleted               = '$deleted'      ,
                        internet_pages.fk_internet_eras         = '$era'          ,
                        internet_pages.is_dictionary_entry      = '$dictionary'   ,
                        internet_pages.title_en                 = '$title_en'     ,
                        internet_pages.title_fr                 = '$title_fr'     ,
                        internet_pages.appeared_in_year         = '$appeared_y'   ,
                        internet_pages.appeared_in_month        = '$appeared_m'   ,
                        internet_pages.spread_in_year           = '$spread_y'     ,
                        internet_pages.spread_in_month          = '$spread_m'     ,
                        internet_pages.is_nsfw                  = '$is_nsfw'      ,
                        internet_pages.is_gross                 = '$is_gross'     ,
                        internet_pages.is_political             = '$is_political' ,
                        internet_pages.is_politically_incorrect = '$is_incorrect' ,
                        internet_pages.definition_en            = '$body_en'      ,
                        internet_pages.definition_fr            = '$body_fr'      ,
                        internet_pages.private_admin_notes      = '$admin_notes'  ");

    // Activity logs
    $page       = query_id();
    $created_at = mt_rand(1111239420, time());
    $log_type   = ($dictionary) ? 'internet_definition_new' : 'internet_page_new';
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted          = '$deleted'    ,
                        logs_activity.happened_at         = '$created_at' ,
                        logs_activity.language            = 'ENFR'        ,
                        logs_activity.activity_type       = '$log_type'   ,
                        logs_activity.activity_id         = '$page'       ,
                        logs_activity.activity_summary_en = '$title_en'   ,
                        logs_activity.activity_summary_fr = '$title_fr'   ");
    if(mt_rand(0,30) >= 30)
    {
      $edited_at  = mt_rand($created_at, time());
      $log_type   = ($dictionary) ? 'internet_definition_edit' : 'internet_page_edit';
      query(" INSERT INTO logs_activity
              SET         logs_activity.is_deleted          = '$deleted'    ,
                          logs_activity.happened_at         = '$edited_at'  ,
                          logs_activity.language            = 'ENFR'        ,
                          logs_activity.activity_type       = '$log_type'   ,
                          logs_activity.activity_id         = '$page'       ,
                          logs_activity.activity_summary_en = '$title_en'   ,
                          logs_activity.activity_summary_fr = '$title_fr'   ");
    }
    if($deleted)
    {
      $deleted_at = mt_rand($created_at, time());
      $log_type   = ($dictionary) ? 'internet_definition_delete' : 'internet_page_delete';
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at         = '$deleted_at' ,
                          logs_activity.language            = 'ENFR'        ,
                          logs_activity.activity_type       = '$log_type'   ,
                          logs_activity.activity_summary_en = '$title_en'   ,
                          logs_activity.activity_summary_fr = '$title_fr'   ");
    }

    // Add some categories to the page
    if(mt_rand(0,3) < 3)
    {
      $random2    = mt_rand(1,4);
      $categories = array();
      for($j = 0; $j < $random2; $j++)
      {
        $category = fixtures_fetch_random_id('internet_categories');
        if(!in_array($category, $categories))
        {
          array_push($categories, $category);
          query(" INSERT INTO internet_pages_categories
                  SET         internet_pages_categories.fk_internet_pages       = '$page'     ,
                              internet_pages_categories.fk_internet_categories  = '$category' ");
        }
      }
    }
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>internet encyclopedia entries</td></tr>";
ob_flush();
flush();

// Make some pages into redirections
$random = mt_rand(20,40);
$qpages = query(" SELECT    internet_pages.id AS 'p_id'
                  FROM      internet_pages
                  ORDER BY  RAND()
                  LIMIT     $random ");
while($dpages = mysqli_fetch_array($qpages))
{
  // Fetch a random other page to redirect to
  $page     = $dpages['p_id'];
  $randpage = mysqli_fetch_array(query("  SELECT    internet_pages.title_en AS 'p_title_en' ,
                                                    internet_pages.title_fr AS 'p_title_fr'
                                          FROM      internet_pages
                                          WHERE     internet_pages.id            != '$page'
                                          AND       internet_pages.is_deleted     = 0
                                          AND       internet_pages.redirection_en = ''
                                          ORDER BY  RAND()
                                          LIMIT     1 "));

  // Redirect to this other definition
  $redirect_en  = $randpage['p_title_en'];
  $redirect_fr  = $randpage['p_title_fr'];
  query(" UPDATE  internet_pages
          SET     internet_pages.redirection_en = '$redirect_en'  ,
                  internet_pages.redirection_fr = '$redirect_fr'
          WHERE   internet_pages.id             = '$page' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>internet encyclopedia redirections</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Images

// Generate some random non existing image placeholders
$random = mt_rand(50,100);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,15) < 15) ? 0 : 1;
  $uploaded_at  = mt_rand(1111239420, time());
  $file_name    = str_replace(' ', '', fixtures_generate_data('string', 5, 15)).'.png';
  $tags         = (mt_rand(0,2) < 2) ? fixtures_generate_data('string', 5, 15) : '';
  $tags        .= ($tags && mt_rand(0,1)) ? ';'.fixtures_generate_data('string', 5, 15) : '';
  $tags        .= ($tags && mt_rand(0,1)) ? ';'.fixtures_generate_data('string', 5, 15) : '';
  $nsfw         = (mt_rand(0,10) < 10) ? 0 : 1;

  // Generate the image placeholders
  query(" INSERT INTO internet_images
          SET         internet_images.is_deleted  = '$deleted'      ,
                      internet_images.uploaded_at = '$uploaded_at'  ,
                      internet_images.file_name   = '$file_name'    ,
                      internet_images.tags        = '$tags'         ,
                      internet_images.is_nsfw     = '$nsfw'         ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>internet encyclopedia images</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                        IRC                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// IRC channels

// Generate some random channels
$random = mt_rand(15,25);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $name         = fixtures_generate_data('string', 5, 15);
  $languages    = (mt_rand(0,1)) ? '' : 'FR';
  $languages   .= (mt_rand(0,1)) ? '' : 'EN';
  $languages    = (!$languages) ? 'FR' : $languages;
  $display      = (mt_rand(0,1)) ? $i : (mt_rand(10,20) * $i);
  $display      = (mt_rand(0,1)) ? 0 : $display;
  $details_en   = ucfirst(fixtures_generate_data('sentence', 2, 8));
  $details_fr   = ucfirst(fixtures_generate_data('sentence', 2, 8));

  // Generate the channels
  query(" INSERT INTO irc_channels
          SET         irc_channels.name           = '$name'       ,
                      irc_channels.languages      = '$languages'  ,
                      irc_channels.display_order  = '$display'    ,
                      irc_channels.details_en     = '$details_en' ,
                      irc_channels.details_fr     = '$details_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>IRC channels</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// IRC bot logs

// Generate some random logs
$random   = mt_rand(500,1000);
$channels = array('#nobleme', '#english', '#dev', '#admin');
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $sent_at      = mt_rand(1111239420, time());
  $channel      = $channels[array_rand($channels)];
  $body         = ucfirst(fixtures_generate_data('sentence', 2, 8));
  $is_silenced  = (mt_rand(0,50) < 50) ? 0 : 1;
  $is_failed    = (mt_rand(0,50) < 50) ? 0 : 1;
  $is_manual    = (mt_rand(0,50) < 50) ? 0 : 1;
  $is_action    = (mt_rand(0,50) < 50) ? 0 : 1;

  // Generate the logs
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at      = '$sent_at'      ,
                      logs_irc_bot.channel      = '$channel'      ,
                      logs_irc_bot.body         = '$body'         ,
                      logs_irc_bot.is_silenced  = '$is_silenced'  ,
                      logs_irc_bot.is_failed    = '$is_failed'    ,
                      logs_irc_bot.is_manual    = '$is_manual'    ,
                      logs_irc_bot.is_action    = '$is_action'    ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>IRC bot logs</td></tr>";
ob_flush();
flush();




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       STATS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pageviews

// Generate some random pages
$random   = mt_rand(500,1000);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $page_name_en       = ucfirst(fixtures_generate_data('sentence', 2, 8));
  $page_name_fr       = ucfirst(fixtures_generate_data('sentence', 2, 8));
  $page_url           = 'pages/'.mb_strtolower(fixtures_generate_data('sentence', 1, 1, 1)).'/'.fixtures_generate_data('string', 10, 20, 0, 1);
  $last_viewed_at     = mt_rand(1111239420, time());
  $view_count         = (mt_rand(0, 25) < 25) ? mt_rand(0, 100) : mt_rand(100, 1000000);
  $view_count_archive = (mt_rand(0, $view_count));
  $query_count        = (mt_rand(0, 50) < 50) ? mt_rand(10, 25) : mt_rand(10, 100);
  $load_time          = (mt_rand(0, 50) < 50) ? mt_rand(30, 90) : mt_rand(50, 2500);

  // Generate the stats
  query(" INSERT INTO stats_pages
          SET         stats_pages.page_name_en        = '$page_name_en'       ,
                      stats_pages.page_name_fr        = '$page_name_fr'       ,
                      stats_pages.page_url            = '$page_url'           ,
                      stats_pages.last_viewed_at      = '$last_viewed_at'     ,
                      stats_pages.view_count          = '$view_count'         ,
                      stats_pages.view_count_archive  = '$view_count_archive' ,
                      stats_pages.query_count         = '$query_count'        ,
                      stats_pages.load_time           = '$load_time'          ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>page stats</td></tr>";
ob_flush();
flush();