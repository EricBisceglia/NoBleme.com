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
 * @return  string              The randomly generated paragraph.
 */

function fixtures_lorem_ipsum($word_count, $punctuation=null)
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
 * @param   string  $type   Type of data to be generated ('int', 'digits', 'string', 'sentence', 'text').
 * @param   int     $min    The minimum length or amount of data to be generated.
 * @param   int     $max    The maximum length or amount of data to be generated.
 *
 * @return  string          The randomly generated content.
 */

function fixtures_generate_data($type, $min, $max)
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
    $temp_number  = '';
    $max_length   = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
      $temp_number .= mt_rand(0,9);
    return $temp_number;
  }

  // Random string
  if($type == 'string')
  {
    $characters   = "aaaaaabcdeeeeeeefghiiiiiijkllmmnnoooooopqrrsssttuuvwxyz      ";
    $max_length   = mt_rand($min, $max);
    $temp_string  = '';
    for ($i = 0; $i < $max_length; $i++)
      $temp_string .= $characters[mt_rand(0, (strlen($characters) - 1))];
    return $temp_string;
  }

  // Random paragraph
  if($type == 'sentence')
    return ucfirst(fixtures_lorem_ipsum(mt_rand($min, $max), 1)).'.';

  // Random text
  if($type == 'text')
  {
    $temp_text  = '';
    $max_length = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
    {
      $temp_text .= ($i) ? '\r\n\r\n' : '';
      $temp_text .= ucfirst(fixtures_lorem_ipsum(mt_rand(100, 400), 1)).'.';
    }
    return $temp_text;
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

query(" INSERT INTO system_variables
        SET         system_variables.update_in_progress       = 0   ,
                    system_variables.latest_query_id          = 31  ,
                    system_variables.last_scheduler_execution = 0   ,
                    system_variables.last_pageview_check      = 0   ");



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Versions

$date = date('Y-m-d');
query(" INSERT INTO system_versions
        SET         system_versions.version = '1'           ,
                    system_versions.build   = '0'           ,
                    system_versions.date    = '2019-03-19'  ");
query(" INSERT INTO system_versions
        SET         system_versions.version = '1'           ,
                    system_versions.build   = '1'           ,
                    system_versions.date    = '$date'       ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// NBDB admin notes

query(" INSERT INTO nbdb_web_admin_notes
        SET         nbdb_web_admin_notes.global_notes = '' ");




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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       USERS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create default users with no password and varied access rights for testing purposes

query(" INSERT INTO users
        SET         users.id                  = 1             ,
                    users.nickname            = 'Admin'       ,
                    users.password            = ''            ,
                    users.is_administrator    = 1             ");
query(" INSERT INTO users
        SET         users.id                  = 2             ,
                    users.nickname            = 'Global_mod'  ,
                    users.password            = ''            ,
                    users.is_global_moderator = 1             ");
query(" INSERT INTO users
        SET         users.id                  = 3             ,
                    users.nickname            = 'Moderator'   ,
                    users.password            = ''            ,
                    users.is_moderator        = 1             ,
                    users.moderator_rights    = 'meetups'     ,
                    users.moderator_title_en  = 'Meetups'     ,
                    users.moderator_title_fr  = 'IRL'         ");
query(" INSERT INTO users
        SET         users.id                  = 4             ,
                    users.nickname            = 'User'        ,
                    users.password            = ''            ");
query(" INSERT INTO users
        SET         users.id                  = 5             ,
                    users.nickname            = 'Prude'       ,
                    users.password            = ''            ");
query(" INSERT INTO users
        SET         users.id                  = 6             ,
                    users.nickname            = 'Banned'      ,
                    users.password            = ''            ,
                    users.is_banned_until     = 1918625619    ,
                    users.is_banned_because   = 'Fixture'     ");

query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 1                     ,
                    users_profile.email_address = 'admin@localhost'     ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 2                     ,
                    users_profile.email_address = 'globalmod@localhost' ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 3                     ,
                    users_profile.email_address = 'moderator@localhost' ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 4                     ,
                    users_profile.email_address = 'user@localhost'      ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 5                     ,
                    users_profile.email_address = 'prude@localhost'     ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 6                     ,
                    users_profile.email_address = 'banned@localhost'    ,
                    users_profile.created_at    = '1111239420 '         ");

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
            SET         users.deleted             = '$deleted'    ,
                        users.nickname            = '$username'   ,
                        users.password            = ''            ,
                        users.last_visited_at     = '$last_visit' ,
                        users.current_ip_address  = '$current_ip' ");

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
  }
}




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
  $body       = fixtures_generate_data('text', 1, 5);

  // Generate the private messages
  query(" INSERT INTO users_private_messages
          SET         users_private_messages.deleted            = '$deleted'    ,
                      users_private_messages.fk_users_recipient = '$recipient'  ,
                      users_private_messages.fk_users_sender    = '$sender'     ,
                      users_private_messages.sent_at            = '$sent_at'    ,
                      users_private_messages.read_at            = '$read_at'    ,
                      users_private_messages.title              = '$title'      ,
                      users_private_messages.body               = '$body'       ");
}




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
          SET         dev_blogs.deleted   = '$deleted'    ,
                      dev_blogs.posted_at = '$posted_at'  ,
                      dev_blogs.title_en  = '$title_en'   ,
                      dev_blogs.title_fr  = '$title_fr'   ,
                      dev_blogs.body_en   = '$body_en'    ,
                      dev_blogs.body_fr   = '$body_fr'    ");
}




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
  $title_en         = ucfirst(fixtures_generate_data('sentence', 2, 10));
  $title_fr         = ucfirst(fixtures_generate_data('sentence', 2, 10));
  $body_en          = fixtures_generate_data('text', 1, 5);
  $body_fr          = fixtures_generate_data('text', 1, 5);
  $category         = fixtures_fetch_random_id('dev_tasks_categories');
  $milestone        = fixtures_fetch_random_id('dev_tasks_milestones');
  $source_code_link = ($finished_at && mt_rand(0,1)) ? 'http://nobleme.com/' : '';


  // Generate the tasks
  query(" INSERT INTO dev_tasks
          SET         dev_tasks.deleted                 = '$deleted'          ,
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
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      MEETUPS                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Generate some meetups
$random = mt_rand(50,100);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,15) < 15) ? 0 : 1;
  $event_date = mt_rand(2005,date('Y')).'-'.mt_rand(1,12).'-'.mt_rand(1,28);
  $location   = fixtures_generate_data('string', 5, 15);
  $reason_en  = (mt_rand(0,3) < 3) ? '' : fixtures_generate_data('sentence', 1, 4);
  $reason_fr  = ($reason_en) ? fixtures_generate_data('sentence', 1, 4) : '';
  $details_en = fixtures_generate_data('text', 1, 5);
  $details_fr = fixtures_generate_data('text', 1, 5);

  // Generate the meetups
  query(" INSERT INTO meetups
          SET         meetups.deleted         = '$deleted'    ,
                      meetups.event_date      = '$event_date' ,
                      meetups.location        = '$location'   ,
                      meetups.event_reason_en = '$reason_en'  ,
                      meetups.event_reason_fr = '$reason_fr'  ,
                      meetups.details_en      = '$details_en' ,
                      meetups.details_fr      = '$details_fr' ");

  // Fetch the ID of the generated meetup
  $meetup = query_id();

  // Add some people to the meetup
  $random2    = mt_rand(5,15);
  $user_list  = array();
  for($j = 0; $j < $random2; $j++)
  {
    // Generate random data
    $user       = (mt_rand(0,3) < 3) ? fixtures_fetch_random_id('users') : 0;
    $nickname   = ($user) ? '' : fixtures_generate_data('string', 3, 18);
    $attendance = (strtotime($event_date) > time() && mt_rand(0,1)) ? 0 : 1;
    $extra_en   = (mt_rand(0,3) < 3) ? '' : fixtures_generate_data('sentence', 2, 5);
    $extra_fr   = (mt_rand(0,3) < 3) ? '' : fixtures_generate_data('sentence', 2, 5);

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
    }
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      QUOTES                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Generate some quotes
$random = mt_rand(200,400);
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
          SET         quotes.deleted            = '$deleted'    ,
                      quotes.fk_users_submitter = '$submitter'  ,
                      quotes.admin_validation   = '$validated'  ,
                      quotes.submitted_at       = '$submitted'  ,
                      quotes.is_nsfw            = '$nsfw'       ,
                      quotes.language           = '$language'   ,
                      quotes.body               = '$body'       ");

  // Fetch the ID of the generated quote
  $quote = query_id();

  // Link some users to the quote
  $random2    = mt_rand(1,4);
  $user_list  = array();
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
  $feedback   = (mt_rand(0,4) < 4) ? 2 : mt_rand(0,1);
  $title      = fixtures_generate_data('sentence', 2, 6);
  $body       = fixtures_generate_data('text', 2, 5);
  $length     = strlen($body);

  // Generate the writings
  query(" INSERT INTO writings_texts
          SET         writings_texts.deleted                = '$deleted'    ,
                      writings_texts.fk_users               = '$user'       ,
                      writings_texts.language               = '$language'   ,
                      writings_texts.is_anonymous           = '$anonymous'  ,
                      writings_texts.created_at             = '$created_at' ,
                      writings_texts.edited_at              = '$edited_at'  ,
                      writings_texts.desired_feedback_level = '$feedback'   ,
                      writings_texts.title                  = '$title'      ,
                      writings_texts.character_count        = '$length'     ,
                      writings_texts.body                   = '$body'       ");

  // Randomly decide whether the text deserves comments and ratings
  if($feedback > 1 && mt_rand(0,1))
  {
    // Fetch the ID of the generated text
    $text = query_id();

    // Link some comments to the text
    $random2      = mt_rand(2,7);
    $user_list    = array($user);
    $total_rating = 0;
    for($j = 0; $j < $random2; $j++)
    {
      // Generate random data
      $deleted      = (mt_rand(0,5) < 5) ? 0 : 1;
      $user2        = fixtures_fetch_random_id('users');
      $posted_at    = mt_rand($created_at, time());
      $rating       = mt_rand(0,5);
      $total_rating += $rating;
      $anonymous    = (mt_rand(0,5) < 5) ? 0 : 1;
      $body         = fixtures_generate_data('sentence', 10, 20);

      // If the user hasn't commented yet and isn't the author, add the comment
      if(!in_array($user2, $user_list))
      {
        array_push($user_list, $user2);
        query(" INSERT INTO writings_comments
                SET         writings_comments.deleted           = '$deleted'    ,
                            writings_comments.fk_writings_texts = '$text'       ,
                            writings_comments.fk_users          = '$user2'      ,
                            writings_comments.posted_at         = '$posted_at'  ,
                            writings_comments.rating            = '$rating'     ,
                            writings_comments.is_anonymous      = '$anonymous'  ,
                            writings_comments.message_body      = '$body'       ");
      }
    }

    // Calculate the average rating
    $average_rating = ($total_rating / $random2);

    // Update the text with its rating
    query(" UPDATE  writings_texts
            SET     writings_texts.average_rating = '$average_rating'
            WHERE   writings_texts.id             = '$text' ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contests

// Generate some random contests
$random = mt_rand(8,14);
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
  $name     = fixtures_generate_data('sentence', 2, 4);
  $topic    = fixtures_generate_data('sentence', 4, 7);

  // Generate the contest
  query(" INSERT INTO writings_contests
          SET         writings_contests.id            = '$i'        ,
                      writings_contests.deleted       = '$deleted'  ,
                      writings_contests.language      = '$language' ,
                      writings_contests.started_at    = '$started'  ,
                      writings_contests.ended_at      = '$ended'    ,
                      writings_contests.nb_entries    = '$entries'  ,
                      writings_contests.contest_name  = '$name'     ,
                      writings_contests.contest_topic = '$topic'    ");

  // Fetch the ID of the generated contest
  $contest = query_id();

  // Link some votes to the contest
  $random2  = mt_rand(5,10);
  $qvoters  = query(" SELECT    users.id AS 'u_id'
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




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       NBDB                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Internet dictionary

// Generate some random definitions
$definitions_en = array();
$definitions_fr = array();
$random         = mt_rand(100,200);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,20) < 20) ? 0 : 1;
  $title_en     = ucfirst(fixtures_generate_data('sentence', 1, 6));
  $title_fr     = ucfirst(fixtures_generate_data('sentence', 1, 6));
  $is_nsfw      = (mt_rand(0,5) < 5) ? 0 : 1;
  $is_gross     = (mt_rand(0,10) < 10) ? 0 : 1;
  $is_political = (mt_rand(0,10) < 10) ? 0 : 1;
  $is_incorrect = (mt_rand(0,10) < 10) ? 0 : 1;
  $body_en      = fixtures_generate_data('text', 2, 5);
  $body_fr      = fixtures_generate_data('text', 2, 5);
  $admin_notes  = (mt_rand(0,10) < 10) ? '' : fixtures_generate_data('text', 1, 1);

  // Generate the definitions if they don't exist already
  if(!in_array($title_en, $definitions_en) && !in_array($title_fr, $definitions_fr))
  {
    array_push($definitions_en, $title_en);
    array_push($definitions_fr, $title_fr);
    query(" INSERT INTO nbdb_web_definitions
            SET         nbdb_web_definitions.deleted                  = '$deleted'      ,
                        nbdb_web_definitions.title_en                 = '$title_en'     ,
                        nbdb_web_definitions.title_fr                 = '$title_fr'     ,
                        nbdb_web_definitions.is_nsfw                  = '$is_nsfw'      ,
                        nbdb_web_definitions.is_gross                 = '$is_gross'     ,
                        nbdb_web_definitions.is_political             = '$is_political' ,
                        nbdb_web_definitions.is_politically_incorrect = '$is_incorrect' ,
                        nbdb_web_definitions.definition_en            = '$body_en'      ,
                        nbdb_web_definitions.definition_fr            = '$body_fr'      ,
                        nbdb_web_definitions.private_admin_notes      = '$admin_notes'  ");
  }
}

// Make some definitions into redirections
$random       = mt_rand(20,40);
$qdefinitions = query(" SELECT    nbdb_web_definitions.id AS 'd_id'
                        FROM      nbdb_web_definitions
                        ORDER BY  RAND()
                        LIMIT     $random ");
while($ddefinitions = mysqli_fetch_array($qdefinitions))
{
  // Fetch a random other definition to redirect to
  $definition = $ddefinitions['d_id'];
  $randdef    = mysqli_fetch_array(query("  SELECT    nbdb_web_definitions.title_en AS 'd_title_en' ,
                                                      nbdb_web_definitions.title_fr AS 'd_title_fr'
                                            FROM      nbdb_web_definitions
                                            WHERE     nbdb_web_definitions.id            != '$definition'
                                            AND       nbdb_web_definitions.deleted        = 0
                                            AND       nbdb_web_definitions.redirection_en = ''
                                            ORDER BY  RAND()
                                            LIMIT     1 "));

  // Redirect to this other definition
  $redirect_en  = $randdef['d_title_en'];
  $redirect_fr  = $randdef['d_title_fr'];
  query(" UPDATE  nbdb_web_definitions
          SET     nbdb_web_definitions.redirection_en = '$redirect_en'  ,
                  nbdb_web_definitions.redirection_fr = '$redirect_fr'
          WHERE   nbdb_web_definitions.id             = '$definition' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Internet encyclopedia

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
  query(" INSERT INTO nbdb_web_categories
          SET         nbdb_web_categories.display_order   = '$display'    ,
                      nbdb_web_categories.name_en         = '$title_en'   ,
                      nbdb_web_categories.name_fr         = '$title_fr'   ,
                      nbdb_web_categories.description_en  = '$details_en' ,
                      nbdb_web_categories.description_fr  = '$details_fr' ");
}

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
  query(" INSERT INTO nbdb_web_eras
          SET         nbdb_web_eras.began_in_year   = '$start_year' ,
                      nbdb_web_eras.ended_in_year   = '$end_year'   ,
                      nbdb_web_eras.name_en         = '$title_en'   ,
                      nbdb_web_eras.name_fr         = '$title_fr'   ,
                      nbdb_web_eras.description_en  = '$details_en' ,
                      nbdb_web_eras.description_fr  = '$details_fr' ");
}

// Generate some random pages
$page_titles_en = array();
$page_titles_fr = array();
$random         = mt_rand(100,200);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,20) < 20) ? 0 : 1;
  $era          = fixtures_fetch_random_id('nbdb_web_eras');
  $title_en     = ucfirst(fixtures_generate_data('sentence', 1, 6));
  $title_fr     = ucfirst(fixtures_generate_data('sentence', 1, 6));
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
    query(" INSERT INTO nbdb_web_pages
            SET         nbdb_web_pages.deleted                  = '$deleted'      ,
                        nbdb_web_pages.fk_nbdb_web_eras         = '$era'          ,
                        nbdb_web_pages.title_en                 = '$title_en'     ,
                        nbdb_web_pages.title_fr                 = '$title_fr'     ,
                        nbdb_web_pages.appeared_in_year         = '$appeared_y'   ,
                        nbdb_web_pages.appeared_in_month        = '$appeared_m'   ,
                        nbdb_web_pages.spread_in_year           = '$spread_y'     ,
                        nbdb_web_pages.spread_in_month          = '$spread_m'     ,
                        nbdb_web_pages.is_nsfw                  = '$is_nsfw'      ,
                        nbdb_web_pages.is_gross                 = '$is_gross'     ,
                        nbdb_web_pages.is_political             = '$is_political' ,
                        nbdb_web_pages.is_politically_incorrect = '$is_incorrect' ,
                        nbdb_web_pages.definition_en            = '$body_en'      ,
                        nbdb_web_pages.definition_fr            = '$body_fr'      ,
                        nbdb_web_pages.private_admin_notes      = '$admin_notes'  ");
  }

  // Add some categories to the page
  $page = query_id();
  if(mt_rand(0,3) < 3)
  {
    $random2    = mt_rand(1,4);
    $categories = array();
    for($j = 0; $j < $random2; $j++)
    {
      $category = fixtures_fetch_random_id('nbdb_web_categories');
      if(!in_array($category, $categories))
      {
        array_push($categories, $category);
        query(" INSERT INTO nbdb_web_pages_categories
                SET         nbdb_web_pages_categories.fk_nbdb_web_pages       = '$page'     ,
                            nbdb_web_pages_categories.fk_nbdb_web_categories  = '$category' ");
      }
    }
  }
}

// Make some pages into redirections
$random = mt_rand(20,40);
$qpages = query(" SELECT    nbdb_web_pages.id AS 'p_id'
                  FROM      nbdb_web_pages
                  ORDER BY  RAND()
                  LIMIT     $random ");
while($dpages = mysqli_fetch_array($qpages))
{
  // Fetch a random other page to redirect to
  $page     = $dpages['p_id'];
  $randpage = mysqli_fetch_array(query("  SELECT    nbdb_web_pages.title_en AS 'p_title_en' ,
                                                    nbdb_web_pages.title_fr AS 'p_title_fr'
                                          FROM      nbdb_web_pages
                                          WHERE     nbdb_web_pages.id            != '$page'
                                          AND       nbdb_web_pages.deleted        = 0
                                          AND       nbdb_web_pages.redirection_en = ''
                                          ORDER BY  RAND()
                                          LIMIT     1 "));

  // Redirect to this other definition
  $redirect_en  = $randpage['p_title_en'];
  $redirect_fr  = $randpage['p_title_fr'];
  query(" UPDATE  nbdb_web_pages
          SET     nbdb_web_pages.redirection_en = '$redirect_en'  ,
                  nbdb_web_pages.redirection_fr = '$redirect_fr'
          WHERE   nbdb_web_pages.id             = '$page' ");
}




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
  query(" INSERT INTO nbdb_web_images
          SET         nbdb_web_images.deleted     = '$deleted'      ,
                      nbdb_web_images.uploaded_at = '$uploaded_at'  ,
                      nbdb_web_images.file_name   = '$file_name'    ,
                      nbdb_web_images.tags        = '$tags'         ,
                      nbdb_web_images.is_nsfw     = '$nsfw'         ");
}