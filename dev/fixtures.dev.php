<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




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
// Include the main configuration file
if(file_exists('./conf/main.conf.php'))
  include_once './conf/main.conf.php';
else
  exit(header("Location: ."));

// Only allow this page to be ran in dev mode, it wouldn't be nice to accidentally wipe production data, would it?
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));

// Include data generation functions
include_once './inc/fixtures.inc.php';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      SYSTEM                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global variables

// Set global variables
query(" INSERT INTO system_variables
        SET         system_variables.latest_query_id = 255 ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Versions

// Determine the number of versions to generate
$random = mt_rand(30,50);
for($i = 0; $i < $random; $i++)
{
  if($i === 0)
  {
    $time       = 1111239420;
    $date       = date('Y-m-d', $time);
    $major      = 1;
    $minor      = 0;
    $patch      = 0;
    $extension  = '';
  }
  else
  {
    $time         = mt_rand($time, (((3 * $time) + time()) / 4));
    $date         = date('Y-m-d', $time);
    if(!$extension && mt_rand(0,10) > 9)
      $extension = 'hotfix';
    else
    {
      $reset_major  = (mt_rand(0,15) > 14);
      if($reset_major)
      {
        $major      = $major + 1;
        $minor      = 0;
        $patch      = 0;
        $extension  = '';
      }
      else
      {
        $reset_minor = (mt_rand(0,4) > 3);
        if($reset_minor)
        {
          $minor      = $minor + 1;
          $patch      = 0;
          $extension  = '';
        }
        else
        {
          $patch      = $patch + 1;
          $extension  = '';
        }
      }
    }
  }
  $activity = $major.'.'.$minor.'.'.$patch;
  $activity = ($extension) ? $activity.'-'.$extension : $activity;

  // Generate the versions
  query(" INSERT INTO system_versions
          SET         system_versions.major         = '$major'      ,
                      system_versions.minor         = '$minor'      ,
                      system_versions.patch         = '$patch'      ,
                      system_versions.extension     = '$extension'  ,
                      system_versions.release_date  = '$date'       ");
  query(" INSERT INTO logs_activity
          SET         logs_activity.happened_at         = '$time'       ,
                      logs_activity.language            = 'ENFR'        ,
                      logs_activity.activity_type       = 'dev_version' ,
                      logs_activity.activity_summary_en = '$activity'   ,
                      logs_activity.activity_summary_fr = '$activity'   ");
}

// Add the latest version number to system variables
query(" UPDATE  system_variables
        SET     system_variables.current_version_number_en  = '$activity' ,
                system_variables.current_version_number_fr  = '$activity' ");

// Output progress
echo "<tr><td>Generated&nbsp;</td><td style=\"text-align:right\">$random</td><td>website versions</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Task scheduler

// Determine the number of scheduled tasks to generate
$random = mt_rand(15,30);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $finished     = (mt_rand(0, 3) > 0);
  $planned_at   = ($finished) ? mt_rand(1111239420, time()) : mt_rand(time(), time() + 100000000);
  $task_id      = mt_rand(0, 10000);
  $description  = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $report       = ($finished && (mt_rand(0, 3) > 1)) ? ucfirst(fixtures_generate_data('sentence', 1, 4, 1)) : '';

  // Generate the scheduled tasks
  if($finished)
    query(" INSERT INTO logs_scheduler
            SET         logs_scheduler.happened_at      = '$planned_at'   ,
                        logs_scheduler.task_id          = '$task_id'      ,
                        logs_scheduler.task_type        = 'fixtures'      ,
                        logs_scheduler.task_description = '$description'  ,
                        logs_scheduler.execution_report = '$report'       ");
  else
    query(" INSERT INTO system_scheduler
            SET         system_scheduler.planned_at       = '$planned_at'   ,
                        system_scheduler.task_id          = '$task_id'      ,
                        system_scheduler.task_type        = 'fixtures'      ,
                        system_scheduler.task_description = '$description'  ");
}

// Output progress
echo "<tr><td>Generated&nbsp;</td><td style=\"text-align:right\">$random</td><td>task scheduler entries</td></tr>";
ob_flush();
flush();




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
                    users.username              = 'Admin'           ,
                    users.password              = ''                ,
                    users.is_administrator      = 1                 ,
                    users.current_language      = 'EN'              ,
                    users.current_theme         = 'dark'            ,
                    users.last_visited_at       = '$last_visit'     ,
                    users.last_visited_page_en  = 'Unlisted page'   ,
                    users.last_visited_page_fr  = 'Page non listée' ,
                    users.last_visited_url      = ''                ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 2                 ,
                    users.username              = 'Mod'             ,
                    users.password              = ''                ,
                    users.is_moderator          = 1                 ,
                    users.current_language      = 'EN'              ,
                    users.current_theme         = 'dark'            ,
                    users.last_visited_at       = '$last_visit'     ,
                    users.last_visited_page_en  = 'Unlisted page'   ,
                    users.last_visited_page_fr  = 'Page non listée' ,
                    users.last_visited_url      = ''                ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 4             ,
                    users.username              = 'User'        ,
                    users.password              = ''            ,
                    users.current_language      = 'EN'          ,
                    users.current_theme         = 'dark'            ,
                    users.last_visited_at       = '$last_visit' ,
                    users.last_visited_page_en  = 'Index'       ,
                    users.last_visited_page_fr  = 'Index'       ,
                    users.last_visited_url      = 'index'       ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 5             ,
                    users.username              = 'Prude'       ,
                    users.password              = ''            ,
                    users.current_language      = 'EN'          ,
                    users.current_theme         = 'dark'            ,
                    users.last_visited_at       = '$last_visit' ,
                    users.last_visited_page_en  = 'Index'       ,
                    users.last_visited_page_fr  = 'Index'       ,
                    users.last_visited_url      = 'index'       ");
$last_visit = mt_rand((time() - 2629746), time());
query(" INSERT INTO users
        SET         users.id                    = 6             ,
                    users.username              = 'Banned'      ,
                    users.password              = ''            ,
                    users.current_language      = 'EN'          ,
                    users.current_theme         = 'dark'            ,
                    users.is_banned_since       = 1111239420    ,
                    users.is_banned_until       = 1918625619    ,
                    users.is_banned_because_en  = 'Fixture'     ,
                    users.is_banned_because_fr  = 'Fixture'     ,
                    users.last_visited_at       = '$last_visit' ,
                    users.last_visited_page_en  = 'Index'       ,
                    users.last_visited_page_fr  = 'Index'       ,
                    users.last_visited_url      = 'index'       ");
query(" INSERT INTO system_scheduler
        SET         system_scheduler.planned_at       = 1918625619    ,
                    system_scheduler.task_id          = 6             ,
                    system_scheduler.task_type        = 'users_unban' ,
                    system_scheduler.task_description = 'Banned'      ");
query(" INSERT INTO logs_bans
        SET         logs_bans.fk_banned_user      = 6           ,
                    logs_bans.fk_banned_by_user   = 1           ,
                    logs_bans.banned_at           = 1111239420  ,
                    logs_bans.banned_until        = 1918625619  ,
                    logs_bans.ban_reason_en       = 'Fixture'   ,
                    logs_bans.ban_reason_fr       = 'Fixture'   ");

// Activity logs
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1111239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '1'               ,
                    logs_activity.activity_username = 'Admin'           ");
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1211239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '2'               ,
                    logs_activity.activity_username = 'Mod'             ");
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1411239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '4'               ,
                    logs_activity.activity_username = 'User'           ");
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '1511239420'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '5'               ,
                    logs_activity.activity_username = 'Prude'           ");
$timestamp = time();
query(" INSERT INTO logs_activity
        SET         logs_activity.happened_at       = '$timestamp'      ,
                    logs_activity.language          = 'ENFR'            ,
                    logs_activity.activity_type     = 'users_register'  ,
                    logs_activity.fk_users          = '6'               ,
                    logs_activity.activity_username = 'Banned'          ");

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
                    users_settings.hide_youtube       = 1 ,
                    users_settings.hide_google_trends = 1 ,
                    users_settings.hide_discord       = 1 ,
                    users_settings.hide_kiwiirc       = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 6           ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mass create randomly generated IP bans

// Determine the number of bans to generate
$random = mt_rand(5,10);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $id               = $i + 1;
  $ip               = fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.';
  $ip               = (mt_rand(0, 3) > 2) ? $ip.'*' : $ip.fixtures_generate_data('int', 0, 255);
  $total_ban        = (mt_rand(0, 3) > 2);
  $banned_since     = mt_rand(1111239420, time());
  $banned_until     = mt_rand($banned_since, (time() + (time() - $banned_since)));
  $unbanned_at      = ($banned_until > time()) ? 0 : $banned_until;
  $ban_reason_en    = (mt_rand(0,2) < 2) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
  $ban_reason_fr    = (mt_rand(0,2) < 2) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
  $unban_reason_en  = ((mt_rand(0,2) < 2) || ($banned_until > time())) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
  $unban_reason_fr  = ((mt_rand(0,2) < 2) || ($banned_until > time())) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));

  // Generate the ip bans
  if($banned_until > time())
  {
    query(" INSERT INTO system_ip_bans
            SET         system_ip_bans.id             = '$id'             ,
                        system_ip_bans.ip_address     = '$ip'             ,
                        system_ip_bans.is_a_total_ban = '$total_ban'      ,
                        system_ip_bans.banned_since   = '$banned_since'   ,
                        system_ip_bans.banned_until   = '$banned_until'   ,
                        system_ip_bans.ban_reason_en  = '$ban_reason_en'  ,
                        system_ip_bans.ban_reason_fr  = '$ban_reason_fr'  ");
    query(" INSERT INTO system_scheduler
            SET         system_scheduler.planned_at       = '$banned_until'   ,
                        system_scheduler.task_id          = '$id'             ,
                        system_scheduler.task_type        = 'users_unban_ip'  ,
                        system_scheduler.task_description = '$ip'             ");
  }
  query(" INSERT INTO logs_bans
          SET         logs_bans.banned_ip_address = '$ip'               ,
                      logs_bans.is_a_total_ip_ban = '$total_ban'        ,
                      logs_bans.fk_banned_by_user = 1                   ,
                      logs_bans.banned_at         = '$banned_since'     ,
                      logs_bans.banned_until      = '$banned_until'     ,
                      logs_bans.unbanned_at       = '$unbanned_at'      ,
                      logs_bans.ban_reason_en     = '$ban_reason_en'    ,
                      logs_bans.ban_reason_fr     = '$ban_reason_fr'    ,
                      logs_bans.unban_reason_en   = '$unban_reason_en'  ,
                      logs_bans.unban_reason_fr   = '$unban_reason_fr'  ");
  query(" INSERT INTO logs_activity
          SET         logs_activity.happened_at                 = '$banned_since'   ,
                      logs_activity.language                    = 'FREN'            ,
                      logs_activity.is_moderators_only          = 1                 ,
                      logs_activity.activity_type               = 'users_banned_ip' ,
                      logs_activity.activity_amount             = '1'               ,
                      logs_activity.activity_summary_en         = '$ban_reason_en'  ,
                      logs_activity.activity_summary_fr         = '$ban_reason_fr'  ,
                      logs_activity.activity_username           = '$ip'             ,
                      logs_activity.activity_moderator_username = 'Admin'           ");
  $log_id = fixtures_query_id();
  if($ban_reason_en)
    query(" INSERT INTO logs_activity_details
            SET         logs_activity_details.fk_logs_activity        = '$log_id'         ,
                        logs_activity_details.content_description_en  = 'Reason (EN)'     ,
                        logs_activity_details.content_description_fr  = 'Raison (EN)'     ,
                        logs_activity_details.content_before          = '$ban_reason_en'  ,
                        logs_activity_details.content_after           = '$ban_reason_en'  ");
  if($ban_reason_fr)
    query(" INSERT INTO logs_activity_details
            SET         logs_activity_details.fk_logs_activity        = '$log_id'         ,
                        logs_activity_details.content_description_en  = 'Reason (FR)'     ,
                        logs_activity_details.content_description_fr  = 'Raison (FR)'     ,
                        logs_activity_details.content_before          = '$ban_reason_fr'  ,
                        logs_activity_details.content_after           = '$ban_reason_fr'  ");
  if($banned_until < time())
  {
    query(" INSERT INTO logs_scheduler
            SET         logs_scheduler.happened_at      = '$banned_until'   ,
                        logs_scheduler.task_id          = '$id'             ,
                        logs_scheduler.task_type        = 'users_unban_ip'  ,
                        logs_scheduler.task_description = '$ip'             ,
                        logs_scheduler.execution_report = 'Fixture'         ");
    query(" INSERT INTO logs_activity
            SET         logs_activity.happened_at                 = '$banned_until'     ,
                        logs_activity.language                    = 'FREN'              ,
                        logs_activity.is_moderators_only          = 1                   ,
                        logs_activity.activity_type               = 'users_unbanned_ip' ,
                        logs_activity.activity_summary_en         = '$unban_reason_en'  ,
                        logs_activity.activity_summary_fr         = '$unban_reason_fr'  ,
                        logs_activity.activity_username           = '$ip'               ,
                        logs_activity.activity_moderator_username = 'Admin'             ");
    $log_id = fixtures_query_id();
    if($unban_reason_en)
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                          logs_activity_details.content_description_en  = 'Reason (EN)'       ,
                          logs_activity_details.content_description_fr  = 'Raison (EN)'       ,
                          logs_activity_details.content_before          = '$unban_reason_en'  ,
                          logs_activity_details.content_after           = '$unban_reason_en'  ");
    if($unban_reason_fr)
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                          logs_activity_details.content_description_en  = 'Reason (FR)'       ,
                          logs_activity_details.content_description_fr  = 'Raison (FR)'       ,
                          logs_activity_details.content_before          = '$unban_reason_fr'  ,
                          logs_activity_details.content_after           = '$unban_reason_fr'  ");
  }
}

// Output progress
echo "<tr><td>Generated&nbsp;</td><td style=\"text-align:right\">$random</td><td>banned IPs</td></tr>";
ob_flush();
flush();




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
  $current_lang = (mt_rand(0,3) < 3) ? 'EN' : 'FR';
  $current_mode = (mt_rand(0,5) < 5) ? 'dark' : 'light';
  $last_visit   = mt_rand((time() - 2629746), time());
  $last_page_fr = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_page_en = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_url     = (mt_rand(0,2) < 2) ? 'index' : '';
  $rand_visit   = mt_rand(0,10);
  $rand_visit   = (mt_rand(0,1)) ? 1 : $rand_visit;
  $visit_count  = (mt_rand(0,10) < 10) ? $rand_visit : mt_rand(10, 100);

  // Generate the guests
  query(" INSERT INTO users_guests
          SET         users_guests.randomly_assigned_name_en  = '$name_en'      ,
                      users_guests.randomly_assigned_name_fr  = '$name_fr'      ,
                      users_guests.ip_address                 = '$current_ip'   ,
                      users_guests.current_language           = '$current_lang' ,
                      users_guests.current_theme              = '$current_mode' ,
                      users_guests.last_visited_at            = '$last_visit'   ,
                      users_guests.last_visited_page_en       = '$last_page_en' ,
                      users_guests.last_visited_page_fr       = '$last_page_fr' ,
                      users_guests.last_visited_url           = '$last_url'     ,
                      users_guests.visited_page_count         = '$visit_count'  ");
}

// Output progress
echo "<tr><td>Generated&nbsp;</td><td style=\"text-align:right\">$random</td><td>guests</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mass create randomly generated users

// Determine the number of users to generate
$random = mt_rand(250,500);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,50) < 50) ? 0 : 1;
  $username     = ucfirst(fixtures_generate_data('string', 3, 15, 1, 1));
  $deleted_nick = ($deleted) ? $username : '';
  $current_ip   = fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255);
  $email        = $username.'@localhost';
  $rand         = mt_rand(0,1);
  $randlang     = mt_rand(0,1) ? 'EN' : 'FR';
  $cur_language = ($rand) ? '' : $randlang;
  $randtheme    = mt_rand(0,5) < 5 ? 'dark' : 'light';
  $cur_theme    = ($rand) ? '' : $randtheme;
  $created_at   = mt_rand(1111239420, time());
  $deleted_at   = ($deleted) ? mt_rand($created_at, time()) : '';
  $last_visit   = mt_rand($created_at, time());
  $last_page_fr = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_page_en = ucfirst(fixtures_generate_data('sentence', 1, 4, 1));
  $last_url     = (mt_rand(0,2) < 2) ? 'index' : '';
  $last_action  = (mt_rand(0, 5) < 5) ? 0 : mt_rand($created_at, $last_visit);
  $rand_visit   = mt_rand(0, 100);
  $rand_visit   = (mt_rand(0, 10) < 10) ? $rand_visit : mt_rand(0, 1000);
  $visit_count  = ($rand_visit) ? 0 : $rand_visit;
  $birthday     = (mt_rand(0,4) < 4) ? '0000-00-00' : mt_rand(1980, 2010).'-'.mt_rand(1,12).'-'.mt_rand(1,28);
  $languages    = (mt_rand(0,5) < 5) ? '' : 'EN';
  $languages   .= (mt_rand(0,5) < 5) ? '' : 'FR';
  $pronouns_en  = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('string', 2, 8));
  $pronouns_fr  = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('string', 2, 8));
  $lives_at     = (mt_rand(0,6) < 6) ? '' : ucfirst(fixtures_generate_data('string', 10, 15));
  $text_en      = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('text', 1, 10));
  $text_fr      = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('text', 1, 10));

  // Check if the username was already generated
  $dcheck = query(" SELECT  users.id
                    FROM    users
                    WHERE   users.username LIKE '$username' ",
                    fetch_row: true);

  // Ensure usernames don't get generated twice
  if(!isset($dcheck['id']))
  {
    // Generate the users
    query(" INSERT INTO users
            SET         users.is_deleted            = '$deleted'      ,
                        users.deleted_at            = '$deleted_at'   ,
                        users.deleted_username      = '$deleted_nick' ,
                        users.username              = '$username'     ,
                        users.password              = ''              ,
                        users.current_language      = '$cur_language' ,
                        users.current_theme         = '$cur_theme'    ,
                        users.last_visited_at       = '$last_visit'   ,
                        users.last_action_at        = '$last_action'  ,
                        users.last_visited_page_en  = '$last_page_en' ,
                        users.last_visited_page_fr  = '$last_page_fr' ,
                        users.last_visited_url      = '$last_url'     ,
                        users.visited_page_count    = '$visit_count'  ,
                        users.current_ip_address    = '$current_ip'   ");

    // Fetch the id of the generated users
    $user_id = fixtures_query_id();

    // Generate the rest of the user data
    query(" INSERT INTO users_profile
            SET         users_profile.fk_users          = '$user_id'      ,
                        users_profile.email_address     = '$email'        ,
                        users_profile.created_at        = '$created_at '  ,
                        users_profile.birthday          = '$birthday'     ,
                        users_profile.spoken_languages  = '$languages'    ,
                        users_profile.lives_at          = '$lives_at'     ,
                        users_profile.pronouns_en       = '$pronouns_en'  ,
                        users_profile.pronouns_fr       = '$pronouns_fr'  ,
                        users_profile.profile_text_en   = '$text_en'      ,
                        users_profile.profile_text_fr   = '$text_fr'      ");

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
                          logs_activity.activity_username = '$username'       ");
    }

    if(!$deleted && ($text_en || $text_fr) && mt_rand(0,5) >= 5)
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
                          logs_activity.activity_username   = '$username'           ");
      $log_id = fixtures_query_id();
      if($text_en)
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                            logs_activity_details.content_description_en  = 'Profile text (EN)' ,
                            logs_activity_details.content_description_fr  = 'Texte libre (EN)'  ,
                            logs_activity_details.content_before          = '$text_before'      ,
                            logs_activity_details.content_after           = '$text_en'          ");
      if($text_fr)
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                            logs_activity_details.content_description_en  = 'Profile text (FR)' ,
                            logs_activity_details.content_description_fr  = 'Texte libre (FR)'  ,
                            logs_activity_details.content_before          = '$text_before'      ,
                            logs_activity_details.content_after           = '$text_fr'          ");
    }
    else if(!$deleted && ($text_en || $text_fr) && mt_rand(0,5) >= 5)
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
                          logs_activity.activity_username           = '$username'                 ,
                          logs_activity.activity_moderator_username = 'Admin'                     ");
      $log_id = fixtures_query_id();
      if($text_en)
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                            logs_activity_details.content_description_en  = 'Profile text (EN)' ,
                            logs_activity_details.content_description_fr  = 'Texte libre (EN)'  ,
                            logs_activity_details.content_before          = '$text_before'      ,
                            logs_activity_details.content_after           = '$text_en'          ");
      if($text_fr)
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                            logs_activity_details.content_description_en  = 'Profile text (EN)' ,
                            logs_activity_details.content_description_fr  = 'Texte libre (EN)'  ,
                            logs_activity_details.content_before          = '$text_before'      ,
                            logs_activity_details.content_after           = '$text_fr'          ");
    }
    else if(!$deleted && !$text_en && !$text_fr && mt_rand(0,50) >= 50)
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
                          logs_activity.activity_username   = '$username'           ");
      $log_id = fixtures_query_id();
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                          logs_activity_details.content_description_en  = 'Profile text (EN)' ,
                          logs_activity_details.content_description_fr  = 'Texte libre (EN)'  ,
                          logs_activity_details.content_before          = '$text_before'      ,
                          logs_activity_details.content_after           = ''                  ");
    }
    if(mt_rand(0,100) >= 100)
    {
      $edited_at = mt_rand($created_at, time());
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at                 = '$edited_at'      ,
                          logs_activity.is_moderators_only          = 1                 ,
                          logs_activity.language                    = 'ENFR'            ,
                          logs_activity.activity_type               = 'users_password'  ,
                          logs_activity.fk_users                    = '$user_id'        ,
                          logs_activity.activity_username           = '$username'       ,
                          logs_activity.activity_moderator_username = 'Admin'           ");
    }
    if(mt_rand(0,66) >= 66)
    {
      $banned_at        = mt_rand($created_at, time());
      $ban_durations    = array(1, 7, 30, 365, 3650);
      $ban_duration     = $ban_durations[array_rand($ban_durations)];
      $unbanned_at      = $banned_at + ($ban_duration * 86400);
      $ban_reason_en    = (mt_rand(0,2) < 2) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
      $ban_reason_fr    = (mt_rand(0,2) < 2) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
      $unban_reason_en  = (mt_rand(0,3) < 3) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
      $unban_reason_fr  = (mt_rand(0,3) < 3) ? '' : ucfirst(fixtures_generate_data('sentence', 4, 8));
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at             = '$banned_at'    ,
                          logs_activity.fk_users                = '$user_id'      ,
                          logs_activity.language                = 'ENFR'          ,
                          logs_activity.activity_type           = 'users_banned'  ,
                          logs_activity.activity_amount         = '$ban_duration' ,
                          logs_activity.activity_username       = '$username'     ");
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at                 = '$banned_at'      ,
                          logs_activity.is_moderators_only          = 1                 ,
                          logs_activity.language                    = 'ENFR'            ,
                          logs_activity.activity_type               = 'users_banned'    ,
                          logs_activity.activity_amount             = '$ban_duration'   ,
                          logs_activity.activity_summary_en         = '$ban_reason_en'  ,
                          logs_activity.activity_summary_fr         = '$ban_reason_fr'  ,
                          logs_activity.activity_id                 = '$user_id'        ,
                          logs_activity.activity_username           = '$username'       ,
                          logs_activity.activity_moderator_username = 'Admin'           ");
      $log_id = fixtures_query_id();
      if($ban_reason_en)
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'         ,
                            logs_activity_details.content_description_en  = 'Reason (EN)'     ,
                            logs_activity_details.content_description_fr  = 'Raison (EN)'     ,
                            logs_activity_details.content_before          = '$ban_reason_en'  ,
                            logs_activity_details.content_after           = '$ban_reason_en'  ");
      if($ban_reason_fr)
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'         ,
                            logs_activity_details.content_description_en  = 'Reason (FR)'     ,
                            logs_activity_details.content_description_fr  = 'Raison (FR)'     ,
                            logs_activity_details.content_before          = '$ban_reason_fr'  ,
                            logs_activity_details.content_after           = '$ban_reason_fr'  ");
      if($unbanned_at < time())
      {
        query(" INSERT INTO logs_scheduler
                SET         logs_scheduler.happened_at      = '$unbanned_at'  ,
                            logs_scheduler.task_id          = '$user_id'      ,
                            logs_scheduler.task_type        = 'users_unban'   ,
                            logs_scheduler.task_description = '$username'     ,
                            logs_scheduler.execution_report = 'Fixture'       ");
        query(" INSERT INTO logs_activity
                SET         logs_activity.happened_at             = '$unbanned_at'    ,
                            logs_activity.fk_users                = '$user_id'        ,
                            logs_activity.language                = 'ENFR'            ,
                            logs_activity.activity_type           = 'users_unbanned'  ,
                            logs_activity.activity_amount         = '$ban_duration'   ,
                            logs_activity.activity_username       = '$username'       ");
        if($unban_reason_en || $unban_reason_fr)
        {
          query(" INSERT INTO logs_bans
                  SET         logs_bans.fk_banned_user      = '$user_id'          ,
                              logs_bans.fk_banned_by_user   = 1                   ,
                              logs_bans.banned_at           = '$banned_at'        ,
                              logs_bans.banned_until        = '$unbanned_at'      ,
                              logs_bans.unbanned_at         = '$unbanned_at'      ,
                              logs_bans.ban_reason_en       = '$ban_reason_en'    ,
                              logs_bans.ban_reason_fr       = '$ban_reason_fr'    ,
                              logs_bans.unban_reason_en     = '$unban_reason_en'  ,
                              logs_bans.unban_reason_fr     = '$unban_reason_fr'  ");
          query(" INSERT INTO logs_activity
                  SET         logs_activity.happened_at                 = '$unbanned_at'      ,
                              logs_activity.is_moderators_only          = 1                   ,
                              logs_activity.language                    = 'ENFR'              ,
                              logs_activity.activity_type               = 'users_unbanned'    ,
                              logs_activity.activity_summary_en         = '$unban_reason_en'  ,
                              logs_activity.activity_summary_fr         = '$unban_reason_fr'  ,
                              logs_activity.activity_id                 = '$user_id'          ,
                              logs_activity.activity_username           = '$username'         ,
                              logs_activity.activity_moderator_username = 'Admin'             ");
          $log_id = fixtures_query_id();
          if($unban_reason_en)
            query(" INSERT INTO logs_activity_details
                    SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                                logs_activity_details.content_description_en  = 'Reason (EN)'       ,
                                logs_activity_details.content_description_fr  = 'Raison (EN)'       ,
                                logs_activity_details.content_before          = '$unban_reason_en'  ,
                                logs_activity_details.content_after           = '$unban_reason_en'  ");
          if($unban_reason_fr)
            query(" INSERT INTO logs_activity_details
                    SET         logs_activity_details.fk_logs_activity        = '$log_id'           ,
                                logs_activity_details.content_description_en  = 'Reason (FR)'       ,
                                logs_activity_details.content_description_fr  = 'Raison (FR)'       ,
                                logs_activity_details.content_before          = '$unban_reason_fr'  ,
                                logs_activity_details.content_after           = '$unban_reason_fr'  ");
        }
      }
      else
      {
        query(" UPDATE      users
                SET         users.is_banned_since       = '$banned_at'      ,
                            users.is_banned_until       = '$unbanned_at'    ,
                            users.is_banned_because_en  = '$ban_reason_en'  ,
                            users.is_banned_because_fr  = '$ban_reason_fr'
                WHERE       users.id                    = '$user_id'        ");
        query(" INSERT INTO system_scheduler
                SET         system_scheduler.planned_at       = '$unbanned_at'  ,
                            system_scheduler.task_id          = '$user_id'      ,
                            system_scheduler.task_type        = 'users_unban'   ,
                            system_scheduler.task_description = '$username'     ");
        query(" INSERT INTO logs_bans
                SET         logs_bans.fk_banned_user      = '$user_id'        ,
                            logs_bans.fk_banned_by_user   = 1                 ,
                            logs_bans.banned_at           = '$banned_at'      ,
                            logs_bans.banned_until        = '$unbanned_at'    ,
                            logs_bans.ban_reason_en       = '$ban_reason_en'  ,
                            logs_bans.ban_reason_fr       = '$ban_reason_fr'  ");
      }
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
                          logs_activity.activity_username       = '$username'       ");
      query(" INSERT INTO logs_activity
              SET         logs_activity.happened_at             = '$reverted_at'        ,
                          logs_activity.language                = 'ENFR'                ,
                          logs_activity.activity_type           = 'users_rights_delete' ,
                          logs_activity.activity_username       = '$username'           ");
    }

    // Remove the username of deleted users
    if($deleted)
      query(" UPDATE  users
              SET     users.username  = 'user $user_id'
              WHERE   users.id        = '$user_id'  ");
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>users</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add some randomly generated private messages

// Initialize the message counter
$private_messages = 0;

// Look for users
$qusers = query(" SELECT    users.id AS 'u_id'
                  FROM      users
                  ORDER BY  users.id ASC ");

// Loop through users
while($dusers = query_row($qusers))
{
  // Determine the number of individual messages to generate
  $random = mt_rand(3, 5);
  for($i = 0; $i < $random; $i++)
  {
    // Generate random data
    $deleted_r  = (mt_rand(0,50) < 50) ? 0 : 1;
    $deleted_s  = (mt_rand(0,50) < 50) ? 0 : 1;
    $recipient  = $dusers['u_id'];
    $sender     = (mt_rand(0,1)) ? fixtures_fetch_random_id('users') : 0;
    $sent_at    = mt_rand(1111239420, time());
    $read_at    = (mt_rand(0,5) < 3) ? mt_rand($sent_at, time()) : 0;
    $title      = fixtures_generate_data('sentence', 2, 3);
    $body       = fixtures_generate_data('text', 1, 3);

    // Generate the private messages
    query(" INSERT INTO users_private_messages
            SET         users_private_messages.deleted_by_recipient = '$deleted_r'  ,
                        users_private_messages.deleted_by_sender    = '$deleted_s'  ,
                        users_private_messages.fk_users_recipient   = '$recipient'  ,
                        users_private_messages.fk_users_sender      = '$sender'     ,
                        users_private_messages.sent_at              = '$sent_at'    ,
                        users_private_messages.read_at              = '$read_at'    ,
                        users_private_messages.title                = '$title'      ,
                        users_private_messages.body                 = '$body'       ");

    // Count the private messages
    $private_messages++;
  }

  // Also generate a conversation chain
  {
    $random2  = mt_rand(3, 5);
    $partner  = (mt_rand(0,1)) ? fixtures_fetch_random_id('users') : 0;
    for($i = 0; $i < $random2; $i++)
    {
      // Generate random data
      $deleted_r  = (mt_rand(0,50) < 50) ? 0 : 1;
      $deleted_s  = (mt_rand(0,50) < 50) ? 0 : 1;
      $recipient  = ($i % 2) ? $partner : $dusers['u_id'];
      $sender     = ($recipient === $partner) ? $dusers['u_id'] : $partner;
      $sent_at    = ($i) ? mt_rand($sent_at, time()) : mt_rand(1111239420, time());
      $read_at    = ($i < $random2 || mt_rand(0,5) < 3) ? mt_rand($sent_at, time()) : 0;
      $title      = ($i) ? 'RE: '.$title : fixtures_generate_data('sentence', 1, 2);
      $body       = fixtures_generate_data('text', 1, 3);
      $parent     = ($i) ? fixtures_query_id() : 0;

      // Generate the private messages
      query(" INSERT INTO users_private_messages
              SET         users_private_messages.deleted_by_recipient = '$deleted_r'  ,
                          users_private_messages.deleted_by_sender    = '$deleted_s'  ,
                          users_private_messages.fk_users_recipient   = '$recipient'  ,
                          users_private_messages.fk_users_sender      = '$sender'     ,
                          users_private_messages.fk_parent_message    = '$parent'     ,
                          users_private_messages.sent_at              = '$sent_at'    ,
                          users_private_messages.read_at              = '$read_at'    ,
                          users_private_messages.title                = '$title'      ,
                          users_private_messages.body                 = '$body'       ");

      // Count the private messages
      $private_messages++;
    }
  }
}

// Look for users once again
$qusers = query(" SELECT    users.id AS 'u_id'
                  FROM      users
                  ORDER BY  users.id ASC ");

// Loop through users once again
while($dusers = query_row($qusers))
{
  // Count unread private messages
  $user_id = $dusers['u_id'];
  $qmessages = query("  SELECT  COUNT(users_private_messages.id) AS 'm_count'
                        FROM    users_private_messages
                        WHERE   users_private_messages.fk_users_recipient     = '$user_id'
                        AND     users_private_messages.deleted_by_recipient   = 0
                        AND     users_private_messages.is_admin_only_message  = 0
                        AND     users_private_messages.read_at                = 0 ");

  // Update private message count
  $dmessages      = query_row($qmessages);
  $message_count  = $dmessages['m_count'];
  query(" UPDATE  users
          SET     users.unread_private_message_count = '$message_count'
          WHERE   users.id = '$user_id' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$private_messages</td><td>private messages</td></tr>";
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
$random = mt_rand(15, 30);
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
  $blog_id      = fixtures_query_id();
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
  $archived = (mt_rand(0,5) < 5) ? 0 : 1;
  $title_en = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr = ucfirst(fixtures_generate_data('string', 5, 15));

  // Generate the categories
  query(" INSERT INTO dev_tasks_categories
          SET         dev_tasks_categories.is_archived  = '$archived' ,
                      dev_tasks_categories.title_en     = '$title_en' ,
                      dev_tasks_categories.title_fr     = '$title_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>task categories</td></tr>";
ob_flush();
flush();

// Generate some random milestones
$random = mt_rand(10,20);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $archived       = (mt_rand(0,3) < 3) ? 0 : 1;
  $title_en       = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr       = ucfirst(fixtures_generate_data('string', 5, 15));
  $summary_en     = (mt_rand(0,4) < 4) ? '' : fixtures_generate_data('text', 1, 1);
  $summary_fr     = (mt_rand(0,4) < 4) ? '' : fixtures_generate_data('text', 1, 1);

  // Generate the milestones
  query(" INSERT INTO dev_tasks_milestones
          SET         dev_tasks_milestones.is_archived    = '$archived'   ,
                      dev_tasks_milestones.sorting_order  = '$i'          ,
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
$random = mt_rand(100,200);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted          = (mt_rand(0,25) < 25) ? 0 : 1;
  $fk_users         = (mt_rand(0,4) < 4) ? 1 : fixtures_fetch_random_id('users');
  $created_at       = mt_rand(1111239420, time());
  $finished_at      = (mt_rand(0,4) < 4) ? mt_rand($created_at, time()) : 0;
  $admin_validation = (mt_rand(0,50) < 50);
  $is_public        = (mt_rand(0,20) < 20);
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
  $task_id      = fixtures_query_id();
  $dusername    = query(" SELECT  users.username AS 'u_nick'
                          FROM    users
                          WHERE   users.id = '$fk_users' ",
                          fetch_row: true);
  $username   = $dusername['u_nick'];
  query(" INSERT INTO logs_activity
          SET         logs_activity.is_deleted          = '$deleted_log'  ,
                      logs_activity.happened_at         = '$created_at'   ,
                      logs_activity.language            = 'ENFR'          ,
                      logs_activity.activity_type       = 'dev_task_new'  ,
                      logs_activity.activity_username   = '$username'     ,
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
$random       = mt_rand(10,20);
$meetup_users = 0;
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0, 15) < 15) ? 0 : 1;
  $event_date = date('Y-m-d', mt_rand(1111339420, (time() + 100000000)));
  $location   = fixtures_generate_data('string', 5, 15, no_spaces: true);
  $languages  = (mt_rand(0, 1)) ? 'FR' : 'EN';
  $languages  = (mt_rand(0, 1)) ? $languages : 'FREN';
  $details_en = fixtures_generate_data('text', 1, 5);
  $details_fr = fixtures_generate_data('text', 1, 5);

  // Generate the meetups
  query(" INSERT INTO meetups
          SET         meetups.is_deleted      = '$deleted'    ,
                      meetups.event_date      = '$event_date' ,
                      meetups.location        = '$location'   ,
                      meetups.languages       = '$languages'  ,
                      meetups.details_en      = '$details_en' ,
                      meetups.details_fr      = '$details_fr' ");

  // Fetch the ID of the generated meetup
  $meetup = fixtures_query_id();

  // Activity logs
  $deleted_log  = (mt_rand(0,25) < 25) ? 0 : 1;
  $created_at   = strtotime($event_date) - (mt_rand(0,100) * 86400);
  $created_at   = ($created_at < 1111239420) ? mt_rand(1111239420, strtotime($event_date)) : $created_at;
  $created_at   = ($created_at > time()) ? (time() -1) : $created_at;
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
                      logs_activity.activity_moderator_username = 'Admin'         ,
                      logs_activity.activity_type               = 'meetups_new'   ,
                      logs_activity.activity_id                 = '$meetup'       ,
                      logs_activity.activity_summary_en         = '$meetup_date'  ,
                      logs_activity.activity_summary_fr         = '$meetup_date'  ");

  // Activity logs: edited
  if(mt_rand(0,15) >= 15)
  {
    $deleted_log  = (mt_rand(0,5) < 5) ? 0 : 1;
    $edited_at    = mt_rand($created_at, strtotime($event_date));
    $edited_at    = ($edited_at > time()) ? (time() -1) : $edited_at;
    $old_location = fixtures_generate_data('string', 5, 15);
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted                  = '$deleted_log'  ,
                        logs_activity.happened_at                 = '$edited_at'    ,
                        logs_activity.is_moderators_only          = 1               ,
                        logs_activity.language                    = 'ENFR'          ,
                        logs_activity.activity_moderator_username = 'Admin'         ,
                        logs_activity.activity_type               = 'meetups_edit'  ,
                        logs_activity.activity_id                 = '$meetup'       ,
                        logs_activity.activity_summary_en         = '$meetup_date'  ,
                        logs_activity.activity_summary_fr         = '$meetup_date'  ");
    $log_id = fixtures_query_id();
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
    $deleted_at = ($deleted_at > time()) ? (time() -1) : $deleted_at;
    query(" INSERT INTO logs_activity
            SET         logs_activity.is_deleted                  = '$deleted_log'    ,
                        logs_activity.happened_at                 = '$deleted_at'     ,
                        logs_activity.is_moderators_only          = 1                 ,
                        logs_activity.language                    = 'ENFR'            ,
                        logs_activity.activity_moderator_username = 'Admin'           ,
                        logs_activity.activity_type               = 'meetups_delete'  ,
                        logs_activity.activity_summary_en         = '$meetup_date'  ,
                        logs_activity.activity_summary_fr         = '$meetup_date'  ");
    $log_id   = fixtures_query_id();
    $random2  = mt_rand(1,10);
    for($i = 0; $i < $random2; $i++)
    {
      $username = fixtures_generate_data('string', 3, 18);
      query(" INSERT INTO logs_activity_details
              SET         logs_activity_details.fk_logs_activity        = '$log_id'     ,
                          logs_activity_details.content_description_en  = 'Attending'   ,
                          logs_activity_details.content_description_fr  = 'Participant' ,
                          logs_activity_details.content_before          = '$username'   ");
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
    $username   = ($user) ? '' : fixtures_generate_data('string', 3, 18, no_spaces: true);
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
                          meetups_people.username             = '$username'   ,
                          meetups_people.attendance_confirmed = '$attendance' ,
                          meetups_people.extra_information_en = '$extra_en'   ,
                          meetups_people.extra_information_fr = '$extra_fr'   ");

      // Activity logs
      $deleted_log  = (mt_rand(0,25) < 25) ? 0 : 1;
      $added_at     = mt_rand($created_at, strtotime($event_date));
      $added_at     = ($added_at > time()) ? time() : $added_at;
      if(!$deleted && $username)
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted          = '$deleted_log'        ,
                            logs_activity.happened_at         = '$added_at'           ,
                            logs_activity.language            = 'ENFR'                ,
                            logs_activity.activity_type       = 'meetups_people_new'  ,
                            logs_activity.activity_username   = '$username'           ,
                            logs_activity.activity_id         = '$meetup'             ,
                            logs_activity.activity_summary_en = '$meetup_date'  ,
                            logs_activity.activity_summary_fr = '$meetup_date'  ");
      if($username)
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted                  = '$deleted_log'        ,
                            logs_activity.happened_at                 = '$added_at'           ,
                            logs_activity.is_moderators_only          = 1                     ,
                            logs_activity.language                    = 'ENFR'                ,
                            logs_activity.activity_username           = '$username'           ,
                            logs_activity.activity_type               = 'meetups_people_new'  ,
                            logs_activity.activity_id                 = '$meetup'             ,
                            logs_activity.activity_summary_en         = '$meetup_date'        ,
                            logs_activity.activity_summary_fr         = '$meetup_date'        ,
                            logs_activity.activity_moderator_username = 'Admin'               ");

      // Activity logs: edited
      if($username && mt_rand(0,25) >= 25)
      {
        $deleted_log  = (mt_rand(0,5) < 5) ? 0 : 1;
        $edited_at    = mt_rand($created_at, strtotime($event_date));
        $edited_at    = ($edited_at > time()) ? time() : $edited_at;
        $old_extra    = fixtures_generate_data('sentence', 2, 5, 1);
        $new_extra    = ($extra_en) ? $extra_en : $extra_fr;
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted                  = '$deleted_log'        ,
                            logs_activity.happened_at                 = '$edited_at'          ,
                            logs_activity.is_moderators_only          = 1                     ,
                            logs_activity.language                    = 'ENFR'                ,
                            logs_activity.activity_username           = '$username'           ,
                            logs_activity.activity_type               = 'meetups_people_edit' ,
                            logs_activity.activity_id                 = '$meetup'             ,
                            logs_activity.activity_summary_en         = '$meetup_date'        ,
                            logs_activity.activity_summary_fr         = '$meetup_date'        ,
                            logs_activity.activity_moderator_username = 'Admin'               ");
        $log_id = fixtures_query_id();
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                            logs_activity_details.content_description_en  = 'Extra info'    ,
                            logs_activity_details.content_description_fr  = 'Détails'       ,
                            logs_activity_details.content_before          = '$old_extra'    ,
                            logs_activity_details.content_after           = '$new_extra'    ");
      }

      // Activity logs: deleted
      if($username && mt_rand(0,25) >= 25)
      {
        $deleted_log  = (mt_rand(0,5) < 5) ? 0 : 1;
        $deleted_at   = mt_rand($created_at, strtotime($event_date));
        $deleted_at   = ($deleted_at > time()) ? time() : $deleted_at;
        $deleted_nick = fixtures_generate_data('string', 3, 18);
        $extra_info   = fixtures_generate_data('sentence', 2, 5, 1);
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted              = '$deleted_log'          ,
                            logs_activity.happened_at             = '$deleted_at'           ,
                            logs_activity.language                = 'ENFR'                  ,
                            logs_activity.activity_username       = '$deleted_nick'         ,
                            logs_activity.activity_type           = 'meetups_people_delete' ,
                            logs_activity.activity_id             = '$meetup'               ,
                            logs_activity.activity_summary_en     = '$meetup_date'          ,
                            logs_activity.activity_summary_fr     = '$meetup_date'          ");
        query(" INSERT INTO logs_activity
                SET         logs_activity.is_deleted                  = '$deleted_log'          ,
                            logs_activity.happened_at                 = '$deleted_at'           ,
                            logs_activity.is_moderators_only          = 1                       ,
                            logs_activity.language                    = 'ENFR'                  ,
                            logs_activity.activity_username           = '$deleted_nick'         ,
                            logs_activity.activity_type               = 'meetups_people_delete' ,
                            logs_activity.activity_id                 = '$meetup'               ,
                            logs_activity.activity_summary_en         = '$meetup_date'          ,
                            logs_activity.activity_summary_fr         = '$meetup_date'          ,
                            logs_activity.activity_moderator_username = 'Admin'                 ");
        $log_id = fixtures_query_id();
        query(" INSERT INTO logs_activity_details
                SET         logs_activity_details.fk_logs_activity        = '$log_id'       ,
                            logs_activity_details.content_description_en  = 'Extra info'    ,
                            logs_activity_details.content_description_fr  = 'Détails'       ,
                            logs_activity_details.content_before          = '$extra_info'   ");
      }
    }
    else
    {
      $random2--;
      $meetup_users--;
    }
  }

  // Update the attendee count
  query(" UPDATE  meetups
          SET     meetups.attendee_count  = '$random2'
          WHERE   meetups.id              = '$meetup' ");
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
$random       = mt_rand(100,200);
$quote_users  = 0;
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted    = (mt_rand(0,10) < 10) ? 0 : 1;
  $submitter  = fixtures_fetch_random_id('users');
  $validated  = (mt_rand(0,50) < 50);
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
  $quote = fixtures_query_id();
  if(!$deleted && $language === 'EN')
    query(" INSERT INTO logs_activity
            SET         logs_activity.happened_at       = '$submitted'    ,
                        logs_activity.language          = 'ENFR'          ,
                        logs_activity.activity_type     = 'quotes_new_en' ,
                        logs_activity.activity_id       = '$quote'        ");
  else if(!$deleted && $language === 'FR')
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
/*                                                    COMPENDIUM                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Admin notes

// Generate some random strings
$global_notes = fixtures_generate_data('text', 1, 1);
$snippets     = fixtures_generate_data('text', 1, 1);
$template_en  = fixtures_generate_data('text', 1, 1);
$template_fr  = fixtures_generate_data('text', 1, 1);

// Generate random links
$links = '';
$random = mt_rand(5,10);
for($i = 0; $i < 10; $i++)
{
  $random_url = 'https://www.'.fixtures_generate_data('string', 5, 15, no_periods: true, no_spaces: true).'.com';
  $links     .= ($i === 0) ? $random_url : '|||'.$random_url;
}

// Generate admin notes
query(" INSERT INTO compendium_admin_tools
        SET         compendium_admin_tools.global_notes = '$global_notes' ,
                    compendium_admin_tools.snippets     = '$snippets'     ,
                    compendium_admin_tools.template_en  = '$template_en'  ,
                    compendium_admin_tools.template_fr  = '$template_fr'  ,
                    compendium_admin_tools.links        = '$links'        ");

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">1</td><td>compendium admin note</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pages

// Generate some random categories
$random = mt_rand(10,15);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $display    = $i * mt_rand(1,100);
  $title_en   = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr   = ucfirst(fixtures_generate_data('string', 5, 15));
  $details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
  $details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));

  // Generate the categories
  query(" INSERT INTO compendium_categories
          SET         compendium_categories.display_order   = '$display'    ,
                      compendium_categories.name_en         = '$title_en'   ,
                      compendium_categories.name_fr         = '$title_fr'   ,
                      compendium_categories.description_en  = '$details_en' ,
                      compendium_categories.description_fr  = '$details_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium categories</td></tr>";
ob_flush();
flush();

// Preset page types
$details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
$details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));
query(" INSERT INTO compendium_types
        SET         compendium_types.id             = 1             ,
                    compendium_types.display_order  = 1             ,
                    compendium_types.name_en        = 'Meme'        ,
                    compendium_types.name_fr        = 'Meme'        ,
                    compendium_types.full_name_en   = 'Meme'        ,
                    compendium_types.full_name_fr   = 'Meme'        ,
                    compendium_types.description_en = '$details_en' ,
                    compendium_types.description_fr = '$details_fr' ");
$details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
$details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));
query(" INSERT INTO compendium_types
        SET         compendium_types.id             = 2             ,
                    compendium_types.display_order  = 10            ,
                    compendium_types.name_en        = 'Definition'  ,
                    compendium_types.name_fr        = 'Définition'  ,
                    compendium_types.full_name_en   = 'Definition'  ,
                    compendium_types.full_name_fr   = 'Definition'  ,
                    compendium_types.description_en = '$details_en' ,
                    compendium_types.description_fr = '$details_fr' ");
$details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
$details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));
query(" INSERT INTO compendium_types
        SET         compendium_types.id             = 3                       ,
                    compendium_types.display_order  = 100                     ,
                    compendium_types.name_en        = 'Sociocultural'         ,
                    compendium_types.name_fr        = 'Socioculturel'         ,
                    compendium_types.full_name_en   = 'Sociocultural entry'   ,
                    compendium_types.full_name_fr   = 'Contenu socioculturel' ,
                    compendium_types.description_en = '$details_en'           ,
                    compendium_types.description_fr = '$details_fr'           ");
$details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
$details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));
query(" INSERT INTO compendium_types
        SET         compendium_types.id             = 4             ,
                    compendium_types.display_order  = 1000          ,
                    compendium_types.name_en        = 'Drama'       ,
                    compendium_types.name_fr        = 'Drame'       ,
                    compendium_types.full_name_en   = 'Drama'       ,
                    compendium_types.full_name_fr   = 'Drame'       ,
                    compendium_types.description_en = '$details_en' ,
                    compendium_types.description_fr = '$details_fr' ");
$details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
$details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));
query(" INSERT INTO compendium_types
        SET         compendium_types.id             = 5                     ,
                    compendium_types.display_order  = 10000                 ,
                    compendium_types.name_en        = 'History'             ,
                    compendium_types.name_fr        = 'Histoire'            ,
                    compendium_types.full_name_en   = 'Historical entry'    ,
                    compendium_types.full_name_fr   = 'Contenu historique'  ,
                    compendium_types.description_en = '$details_en'           ,
                    compendium_types.description_fr = '$details_fr'           ");

// Generate some random types
$random = mt_rand(3,6);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $display    = mt_rand(10001, 100000);
  $title_en   = ucfirst(fixtures_generate_data('string', 5, 15));
  $title_fr   = ucfirst(fixtures_generate_data('string', 5, 15));
  $details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
  $details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));

  // Generate the categories
  query(" INSERT INTO compendium_types
          SET         compendium_types.display_order  = '$display' ,
                      compendium_types.name_en        = '$title_en'   ,
                      compendium_types.name_fr        = '$title_fr'   ,
                      compendium_types.full_name_en   = '$title_en'   ,
                      compendium_types.full_name_fr   = '$title_fr'   ,
                      compendium_types.description_en = '$details_en' ,
                      compendium_types.description_fr = '$details_fr' ");
}

// Output progress
$random += 5;
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium types</td></tr>";
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
  $short_en   = mb_substr($title_en, 0, 20);
  $short_fr   = mb_substr($title_fr, 0, 20);
  $details_en = ucfirst(fixtures_generate_data('sentence', 10, 20));
  $details_fr = ucfirst(fixtures_generate_data('sentence', 10, 20));

  // Generate the categories
  query(" INSERT INTO compendium_eras
          SET         compendium_eras.year_start      = '$start_year' ,
                      compendium_eras.year_end        = '$end_year'   ,
                      compendium_eras.name_en         = '$title_en'   ,
                      compendium_eras.name_fr         = '$title_fr'   ,
                      compendium_eras.short_name_en   = '$short_en'   ,
                      compendium_eras.short_name_fr   = '$short_fr'   ,
                      compendium_eras.description_en  = '$details_en' ,
                      compendium_eras.description_fr  = '$details_fr' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium eras</td></tr>";
ob_flush();
flush();

// Generate some random pages
$page_titles_en = array();
$page_titles_fr = array();
$random         = mt_rand(150,300);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,20) < 20) ? 0 : 1;
  $draft        = (!$deleted && mt_rand(0,20) === 20) ? 1 : 0;
  $created_at   = mt_rand(1111239420, time());
  $era          = (mt_rand(0,1)) ? fixtures_fetch_random_id('compendium_eras') : 0;
  $rand         = (mt_rand(0,1)) ? 3 : fixtures_fetch_random_id('compendium_types');
  $rand         = (mt_rand(0,1)) ? 2 : $rand;
  $type         = (mt_rand(0,1)) ? 1 : $rand;
  $url          = fixtures_generate_data('string', 5, 15, no_periods: true, no_spaces: true);
  $title_en     = (mt_rand(0,5) < 5) ? ucfirst(fixtures_generate_data('sentence', 1, 6, 1)) : '';
  $title_fr     = (mt_rand(0,5) < 5) ? ucfirst(fixtures_generate_data('sentence', 1, 6, 1)) : '';
  $appeared_y   = (mt_rand(0,4) < 4) ? mt_rand(1999, date('Y')) : 0;
  $appeared_m   = ($appeared_y && mt_rand(0,4) < 4) ? mt_rand(1,12) : 0;
  $spread_y     = ($appeared_y && mt_rand(0,3) < 3) ? mt_rand($appeared_y, date('Y')) : 0;
  $spread_m     = ($appeared_y && mt_rand(0,4) < 4) ? mt_rand($appeared_m, 12) : 0;
  $is_nsfw      = (mt_rand(0,10) < 10) ? 0 : 1;
  $is_gross     = (mt_rand(0,20) < 20) ? 0 : 1;
  $is_offensive = (mt_rand(0,15) < 15) ? 0 : 1;
  $nsfw_title   = (mt_rand(0,25) < 25) ? 0 : 1;
  $summary_en   = fixtures_generate_data('sentence', 25, 50);
  $summary_fr   = fixtures_generate_data('sentence', 25, 50);
  $body_en      = fixtures_generate_data('text', 2, 5);
  $body_fr      = fixtures_generate_data('text', 2, 5);
  $length_en    = mb_strlen($body_en);
  $length_fr    = mb_strlen($body_fr);
  $admin_notes  = (mt_rand(0,7) < 7) ? '' : fixtures_generate_data('text', 1, 1);
  $random_url   = 'https://www.'.fixtures_generate_data('string', 5, 15, no_periods: true, no_spaces: true).'.com';
  $random_url2  = 'https://www.'.fixtures_generate_data('string', 5, 15, no_periods: true, no_spaces: true).'.com';
  $random_url3  = 'https://www.'.fixtures_generate_data('string', 5, 15, no_periods: true, no_spaces: true).'.com';
  $random_urls  = (mt_rand(0, 1)) ? $random_url : $random_url.';'.$random_url2;
  $random_urls  = (mt_rand(0,3) < 3) ? $random_urls : $random_urls.';'.$random_url3;
  $admin_urls   = (mt_rand(0,7) < 7) ? '' : $random_urls;
  $view_count   = (mt_rand(0, 10000));

  // Generate the pages if they don't exist already
  if(!in_array($title_en, $page_titles_en) && !in_array($title_fr, $page_titles_fr))
  {
    if($title_en)
      array_push($page_titles_en, $title_en);
    if($title_fr)
      array_push($page_titles_fr, $title_fr);
    query(" INSERT INTO compendium_pages
            SET         compendium_pages.is_deleted           = '$deleted'      ,
                        compendium_pages.is_draft             = '$draft'        ,
                        compendium_pages.created_at           = '$created_at'   ,
                        compendium_pages.fk_compendium_eras   = '$era'          ,
                        compendium_pages.fk_compendium_types  = '$type'         ,
                        compendium_pages.page_url             = '$url'          ,
                        compendium_pages.title_en             = '$title_en'     ,
                        compendium_pages.title_fr             = '$title_fr'     ,
                        compendium_pages.view_count           = '$view_count'   ,
                        compendium_pages.year_appeared        = '$appeared_y'   ,
                        compendium_pages.month_appeared       = '$appeared_m'   ,
                        compendium_pages.year_peak            = '$spread_y'     ,
                        compendium_pages.month_peak           = '$spread_m'     ,
                        compendium_pages.is_nsfw              = '$is_nsfw'      ,
                        compendium_pages.is_gross             = '$is_gross'     ,
                        compendium_pages.is_offensive         = '$is_offensive' ,
                        compendium_pages.title_is_nsfw        = '$nsfw_title'   ,
                        compendium_pages.summary_en           = '$summary_en'   ,
                        compendium_pages.summary_fr           = '$summary_fr'   ,
                        compendium_pages.definition_en        = '$body_en'      ,
                        compendium_pages.definition_fr        = '$body_fr'      ,
                        compendium_pages.character_count_en   = '$length_en'    ,
                        compendium_pages.character_count_fr   = '$length_fr'    ,
                        compendium_pages.admin_notes          = '$admin_notes'  ,
                        compendium_pages.admin_urls           = '$admin_urls'   ");

    // Activity logs
    $page           = fixtures_query_id();
    $created_at     = mt_rand(1111239420, time());
    $activity_lang  = ($title_en) ? 'EN' : '';
    $activity_lang  = ($title_fr) ? $activity_lang.'FR' : $activity_lang;
    if(!$deleted && !$draft && $activity_lang)
      query(" INSERT INTO logs_activity
              SET         logs_activity.is_deleted          = '$deleted'        ,
                          logs_activity.happened_at         = '$created_at'     ,
                          logs_activity.language            = '$activity_lang'  ,
                          logs_activity.activity_type       = 'compendium_new'  ,
                          logs_activity.activity_id         = '$page'           ,
                          logs_activity.activity_summary_en = '$title_en'       ,
                          logs_activity.activity_summary_fr = '$title_fr'       ,
                          logs_activity.activity_username   = '$url'            ");
    if(mt_rand(0,4) >= 4)
    {
      // Add some history to the page
      $last_edited_at  = mt_rand($created_at, time());
      $random2 = mt_rand(0,10);
      if(mt_rand(0,1))
      {
        $edited_at = $last_edited_at;
        for($j = 0; $j < $random2; $j++)
        {
          $edited_at    = mt_rand($edited_at, time());
          $edit_en      = (mt_rand(0,1)) ? '' : fixtures_generate_data('sentence', 5, 15);
          $edit_fr      = (mt_rand(0,1)) ? '' : fixtures_generate_data('sentence', 5, 15);
          $major_edit   = (mt_rand(0, 5) < 5) ? 0 : 1;
          $major_check  = 0;
          query(" INSERT INTO compendium_pages_history
                  SET         compendium_pages_history.fk_compendium_pages  = '$page'       ,
                              compendium_pages_history.edited_at            = '$edited_at'  ,
                              compendium_pages_history.is_major_edit        = '$major_edit' ,
                              compendium_pages_history.summary_en           = '$edit_en'    ,
                              compendium_pages_history.summary_fr           = '$edit_fr'    ");
          if($major_edit && !$major_check)
          {
            $major_check = 1;
            query(" UPDATE  compendium_pages
                    SET     compendium_pages.last_edited_at = '$edited_at'
                    WHERE   compendium_pages.id             = '$page' ");
          }
          if(!$deleted && !$draft && $activity_lang && $major_edit)
            query(" INSERT INTO logs_activity
                    SET         logs_activity.is_deleted          = '$deleted'        ,
                                logs_activity.happened_at         = '$edited_at'      ,
                                logs_activity.language            = '$activity_lang'  ,
                                logs_activity.activity_type       = 'compendium_edit' ,
                                logs_activity.activity_id         = '$page'           ,
                                logs_activity.activity_summary_en = '$title_en'       ,
                                logs_activity.activity_summary_fr = '$title_fr'       ,
                                logs_activity.activity_username   = '$url'            ");
        }
      }
    }

    // Add some categories to the page
    if(mt_rand(0,3) < 3)
    {
      $random2    = mt_rand(1,4);
      $categories = array();
      for($j = 0; $j < $random2; $j++)
      {
        $category = fixtures_fetch_random_id('compendium_categories');
        if(!in_array($category, $categories))
        {
          array_push($categories, $category);
          query(" INSERT INTO compendium_pages_categories
                  SET         compendium_pages_categories.fk_compendium_pages       = '$page'     ,
                              compendium_pages_categories.fk_compendium_categories  = '$category' ");
        }
      }
    }
  }
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium entries</td></tr>";
ob_flush();
flush();

// Make some pages into redirections
$random = mt_rand(20,40);
$qpages = query(" SELECT    compendium_pages.id AS 'p_id'
                  FROM      compendium_pages
                  ORDER BY  RAND()
                  LIMIT     $random ");
while($dpages = query_row($qpages))
{
  // Fetch a random other page to redirect to
  $page     = $dpages['p_id'];
  $randpage = query(" SELECT    compendium_pages.title_en AS 'p_title_en' ,
                                compendium_pages.title_fr AS 'p_title_fr'
                      FROM      compendium_pages
                      WHERE     compendium_pages.id            != '$page'
                      AND       compendium_pages.is_deleted     = 0
                      AND       compendium_pages.redirection_en = ''
                      ORDER BY  RAND()
                      LIMIT     1 ",
                      fetch_row: true);

  // Redirect to this other definition
  $redirect_en  = $randpage['p_title_en'];
  $redirect_fr  = $randpage['p_title_fr'];
  query(" UPDATE  compendium_pages
          SET     compendium_pages.redirection_en = '$redirect_en'  ,
                  compendium_pages.redirection_fr = '$redirect_fr'
          WHERE   compendium_pages.id             = '$page' ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium redirections</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Images

// Generate some random non existing image placeholders
$random = mt_rand(150,250);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $deleted      = (mt_rand(0,15) < 15) ? 0 : 1;
  $uploaded_at  = mt_rand(1111239420, time());
  $file_name    = str_replace(' ', '', fixtures_generate_data('string', 5, 15)).'.png';
  $tags         = (mt_rand(0,2) < 2) ? fixtures_generate_data('string', 5, 15) : '';
  $tags        .= ($tags && mt_rand(0,1)) ? ';'.fixtures_generate_data('string', 5, 15) : '';
  $tags        .= ($tags && mt_rand(0,1)) ? ';'.fixtures_generate_data('string', 5, 15) : '';
  $nsfw         = (mt_rand(0,20) < 15) ? 0 : 1;
  $gross        = (mt_rand(0,30) < 25) ? 0 : 1;
  $offensive    = (mt_rand(0,20) < 20) ? 0 : 1;
  $used_en      = (mt_rand(0,2) < 2) ? fixtures_fetch_random_value('compendium_pages', 'page_url') : '';
  $used_en     .= ($used_en && mt_rand(0,1)) ? ';'.fixtures_fetch_random_value('compendium_pages', 'page_url') : '';
  $used_en     .= ($used_en && mt_rand(0,1)) ? ';'.fixtures_fetch_random_value('compendium_pages', 'page_url') : '';
  $used_fr      = (mt_rand(0,2) < 2) ? fixtures_fetch_random_value('compendium_pages', 'page_url') : '';
  $used_fr     .= ($used_fr && mt_rand(0,1)) ? ';'.fixtures_fetch_random_value('compendium_pages', 'page_url') : '';
  $used_fr     .= ($used_fr && mt_rand(0,1)) ? ';'.fixtures_fetch_random_value('compendium_pages', 'page_url') : '';
  $caption_en   = (mt_rand(0, 1)) ? fixtures_generate_data('sentence', 5, 20) : '';
  $caption_fr   = (mt_rand(0, 1)) ? fixtures_generate_data('sentence', 5, 20) : '';
  $view_count   = (mt_rand(0, 10000));

  // Generate the image placeholders
  query(" INSERT INTO compendium_images
          SET         compendium_images.is_deleted        = '$deleted'      ,
                      compendium_images.uploaded_at       = '$uploaded_at'  ,
                      compendium_images.file_name         = '$file_name'    ,
                      compendium_images.tags              = '$tags'         ,
                      compendium_images.view_count        = '$view_count'   ,
                      compendium_images.is_nsfw           = '$nsfw'         ,
                      compendium_images.is_gross          = '$gross'        ,
                      compendium_images.is_offensive      = '$offensive'    ,
                      compendium_images.used_in_pages_en  = '$used_en'      ,
                      compendium_images.used_in_pages_fr  = '$used_fr'      ,
                      compendium_images.caption_en        = '$caption_en'   ,
                      compendium_images.caption_fr        = '$caption_fr'   ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium images</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Missing pages

// Generate some random missing pages
$random = mt_rand(25,75);
for($i = 0; $i < $random; $i++)
{
  // Generate random data
  $randtype = (mt_rand(0, 1)) ? 3 : fixtures_fetch_random_id('compendium_types');
  $randtype = (mt_rand(0, 1)) ? 2 : $randtype;
  $type     = (mt_rand(0, 1)) ? 0 : $randtype;
  $url      = fixtures_generate_data('string', 5, 15, no_periods: true, no_spaces: true);
  $title    = ucfirst(fixtures_generate_data('sentence', 1, 6, 1));
  $priority = (mt_rand(0, 5) < 5) ? 0 : 1;
  $notes    = (mt_rand(0, 1)) ? fixtures_generate_data('sentence', 5, 20) : '';

  // Generate the missing pages
  if(!fixtures_check_entry('compendium_pages', 'page_url', $url))
    query(" INSERT INTO compendium_missing
            SET         compendium_missing.fk_compendium_types  = '$type'     ,
                        compendium_missing.page_url             = '$url'      ,
                        compendium_missing.title                = '$title'    ,
                        compendium_missing.is_a_priority        = '$priority' ,
                        compendium_missing.notes                = '$notes'    ");

}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>compendium missing pages</td></tr>";
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
  $name       = '#'.fixtures_generate_data('string', 5, 10, no_spaces: true);
  $languages  = (mt_rand(0,1)) ? '' : 'FR';
  $languages .= (mt_rand(0,1)) ? '' : 'EN';
  $languages  = (!$languages) ? 'FR' : $languages;
  $type       = ($i < 2) ? 3 : 1;
  $type       = ($i < 5 && $i >= 2) ? 2 : $type;
  $type       = ($i < 8 && $i >= 5) ? 0 : $type;
  $desc_en    = ucfirst(fixtures_generate_data('sentence', 4, 8));
  $desc_fr    = ucfirst(fixtures_generate_data('sentence', 4, 8));

  // Generate the channels
  query(" INSERT INTO irc_channels
          SET         irc_channels.name           = '$name'       ,
                      irc_channels.languages      = '$languages'  ,
                      irc_channels.channel_type   = '$type'       ,
                      irc_channels.description_en = '$desc_en'    ,
                      irc_channels.description_fr = '$desc_fr'    ");
}

// Output progress
echo "<tr><td>Generated</td><td style=\"text-align:right\">$random</td><td>IRC channels</td></tr>";
ob_flush();
flush();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// IRC bot logs

// Generate some random logs
$random   = mt_rand(100,200);
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