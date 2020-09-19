<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       BANS                                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Bans a user.
 *
 * @param   int         $banner_id                  The id of the moderator ordering the ban.
 * @param   string      $nickname                   The nickname of the user to ban.
 * @param   int         $ban_length                 The ban length.
 * @param   string|null $ban_reason_en  (OPTIONAL)  The justification for the ban, in english.
 * @param   string|null $ban_reason_fr  (OPTIONAL)  The justification for the ban, in french.
 * @param   string|null $lang           (OPTIONAL)  The language currently in use.
 * @param   string|null $path           (OPTIONAL)  The path to the root of the website.
 *
 * @return  string|null                             Returns a string containing an error, or null if all went well.
 */

function admin_ban_user(  $banner_id                    ,
                          $nickname                     ,
                          $ban_length                   ,
                          $ban_reason_en  = ''          ,
                          $ban_reason_fr  = ''          ,
                          $lang           = 'EN'        ,
                          $path           = './../../'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('admin.lang.php');

  // Prepare and sanitize the data
  $banned_nickname_raw  = $nickname;
  $ban_reason_en_raw    = $ban_reason_en;
  $ban_reason_fr_raw    = $ban_reason_fr;
  $banner_nickname_raw  = user_get_nickname($banner_id);
  $banner_id            = sanitize($banner_id, 'int', 0);
  $nickname             = sanitize($nickname, 'string');
  $ban_length           = sanitize($ban_length, 'int', 0, 3650);
  $ban_reason_en        = sanitize($ban_reason_en, 'string');
  $ban_reason_fr        = sanitize($ban_reason_fr, 'string');
  $ban_start            = sanitize(time(), 'int');
  $banned_user_id       = sanitize(database_entry_exists('users', 'nickname', $nickname), 'int');
  $banner_user_id       = sanitize(user_get_id(), 'int');

  // Error: No nickname specified
  if(mb_strlen($nickname) < 3)
    return __('admin_ban_add_error_no_nickname');

  // Error: Nickname does not exist
  if(!$banned_user_id)
    return __('admin_ban_add_error_wrong_user');

  // Error: Can't ban self
  if($banned_user_id == $banner_user_id)
    return __('admin_ban_add_error_self');

  // Error: Moderators can't ban admins
  if(user_is_administrator($banned_user_id) && user_is_moderator($banner_user_id))
    return __('admin_ban_add_error_moderator');

  // Determine when the ban ends
  if($ban_length == 1)
    $ban_end  = strtotime('+1 day', time());
  else if($ban_length == 7)
    $ban_end  = strtotime('+1 week', time());
  else if($ban_length == 30)
    $ban_end  = strtotime('+1 month', time());
  else if($ban_length == 365)
    $ban_end  = strtotime('+1 year', time());
  else if($ban_length == 3650)
    $ban_end  = strtotime('+10 years', time());
  else
    return __('admin_ban_add_error_length');

  // Error: User is already banned
  $duser = mysqli_fetch_array(query("   SELECT  users.is_banned_until AS 'u_ban'
                                        FROM    users
                                        WHERE   users.id = '$banned_user_id' "));
  if($duser['u_ban'])
    return __('admin_ban_add_error_already');

  // Ban the user
  query(" UPDATE  users
          SET     users.is_banned_since       = '$ban_start'      ,
                  users.is_banned_until       = '$ban_end'        ,
                  users.is_banned_because_en  = '$ban_reason_en'  ,
                  users.is_banned_because_fr  = '$ban_reason_fr'
          WHERE   users.id                    = '$banned_user_id' ");

  // Schedule the unbanning
  schedule_task('users_unban', $banned_user_id, $ban_end, $nickname);

  // Activity logs
  $banned_nickname = user_get_nickname($banned_user_id);
  log_activity('users_banned', 0, 'ENFR', 0, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, $banned_user_id, $banned_nickname);
  $modlog = log_activity('users_banned', 1, 'ENFR', 0, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, $banned_user_id, $banned_nickname, $banner_nickname_raw);

  // Detailed activity logs
  if($ban_reason_en_raw)
    log_activity_details($modlog, 'Ban reason (EN)', 'Raison du ban (EN)', $ban_reason_en_raw, $ban_reason_en_raw);
  if($ban_reason_fr_raw)
    log_activity_details($modlog, 'Ban reason (FR)', 'Raison du ban (FR)', $ban_reason_fr_raw, $ban_reason_fr_raw);

  // Ban logs
  query(" INSERT INTO logs_bans
          SET         logs_bans.fk_banned_user    = '$banned_user_id' ,
                      logs_bans.fk_banned_by_user = '$banner_user_id' ,
                      logs_bans.banned_at         = '$ban_start'      ,
                      logs_bans.banned_until      = '$ban_end'        ,
                      logs_bans.ban_reason_en     = '$ban_reason_en'  ,
                      logs_bans.ban_reason_fr     = '$ban_reason_fr'  ");

  // Put ban duration into words
  $ban_duration_en  = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month', '365' => 'for a year', '3650' => 'permanently');
  $ban_duration_fr  = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois', '365' => 'un an', '3650' => 'définitivement');

  // Private message to the banned user
  $ban_user_language  = user_get_language($banned_user_id);
  $ban_duration_pm    = ($ban_user_language == 'EN') ? $ban_duration_en : $ban_duration_fr;
  $ban_reason_pm_en   = ($ban_reason_en) ? __('admin_ban_add_private_message_reason_en', null, 0, 0, array($path, $ban_reason_en)) : __('admin_ban_add_private_message_no_reason_en', null, 0, 0, array($path));
  $ban_reason_pm_fr   = ($ban_reason_fr) ? __('admin_ban_add_private_message_reason_fr', null, 0, 0, array($path, $ban_reason_fr)) : __('admin_ban_add_private_message_no_reason_fr', null, 0, 0, array($path));
  $ban_reason_pm      = ($ban_user_language == 'EN') ? $ban_reason_pm_en : $ban_reason_pm_fr;
  private_message_send(__('admin_ban_add_private_message_title_'.strtolower($ban_user_language)), __('admin_ban_add_private_message_'.strtolower($ban_user_language), null, 0, 0, array($path, date_to_text(time(), 1, $ban_user_language), $ban_duration_pm[$ban_length] , $ban_reason_pm)), $banned_user_id, 0);

  // IRC bot messages
  $ban_extra_en     = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '';
  $ban_extra_fr     = ($ban_reason_fr_raw) ? '('.$ban_reason_fr_raw.')' : '';
  $ban_extra_mod    = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '(no reason specified)';
  irc_bot_send_message("$banned_nickname_raw has been banned from the website $ban_duration_en[$ban_length] $ban_extra_en", 'english');
  irc_bot_send_message("$banned_nickname_raw s'est fait bannir du site $ban_duration_fr[$ban_length] $ban_extra_fr", 'french');
  irc_bot_send_message("$banner_nickname_raw has banned $banned_nickname_raw $ban_duration_en[$ban_length] $ban_extra_mod", 'mod');
}




/**
 * Modifies an existing ban.
 *
 * @param   int         $banner_id                  The id of the moderator modifying the ban.
 * @param   string      $banned_id                  The id of the user whose ban is being modified.
 * @param   int|null    $ban_length     (OPTIONAL)  The length of the ban extension (or 0 if it should not change).
 * @param   string|null $ban_reason_en  (OPTIONAL)  The justification for the ban modification, in english.
 * @param   string|null $ban_reason_fr  (OPTIONAL)  The justification for the ban modification, in french.
 * @param   string|null $lang           (OPTIONAL)  The language currently in use.
 * @param   string|null $path           (OPTIONAL)  The path to the root of the website.
 *
 * @return  void
 */

function admin_ban_user_edit( $banner_id                    ,
                              $banned_id                    ,
                              $ban_length     = 0           ,
                              $ban_reason_en  = ''          ,
                              $ban_reason_fr  = ''          ,
                              $lang           = 'EN'        ,
                              $path           = './../../'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('admin.lang.php');

  // Prepare and sanitize the data
  $banned_id            = sanitize($banned_id, 'int', 0);
  $banned_nickname_raw  = user_get_nickname($banned_id);
  $ban_reason_en_raw    = $ban_reason_en;
  $ban_reason_fr_raw    = $ban_reason_fr;
  $ban_reason_en        = sanitize($ban_reason_en, 'string');
  $ban_reason_fr        = sanitize($ban_reason_fr, 'string');
  $banner_id            = sanitize($banner_id, 'int', 0);
  $banner_nickname_raw  = user_get_nickname($banner_id);
  $ban_length           = sanitize($ban_length, 'int', 0, 3650);

  // Do nothing if user does not exist
  if(!database_entry_exists('users', 'id', $banned_id))
    return;

  // Do nothing if user is not currently banned
  if(!user_is_banned($banned_id))
    return;

  // Do nothing if it is an attempt to ban self
  if($banned_id == $banner_id)
    return;

  // Do nothing if a moderator is trying to ban an administrator
  if(user_is_administrator($banned_id) && user_is_moderator($banner_id))
    return;

  // Fetch the previous ban details
  $dban = mysqli_fetch_array(query("  SELECT  users.is_banned_until       AS 'b_end'        ,
                                              users.is_banned_because_en  AS 'b_reason_en'  ,
                                              users.is_banned_because_fr  AS 'b_reason_fr'
                                      FROM    users
                                      WHERE   users.id = '$banned_id' "));

  // Determine when the ban ends
  if($ban_length == 1)
    $ban_end  = strtotime('+1 day', time());
  else if($ban_length == 7)
    $ban_end  = strtotime('+1 week', time());
  else if($ban_length == 30)
    $ban_end  = strtotime('+1 month', time());
  else if($ban_length == 365)
    $ban_end  = strtotime('+1 year', time());
  else if($ban_length == 3650)
    $ban_end  = strtotime('+10 years', time());
  else
    $ban_end  = $dban['b_end'];

  // Update the user's ban
  query(" UPDATE  users
          SET     users.is_banned_until       = '$ban_end'        ,
                  users.is_banned_because_en  = '$ban_reason_en'  ,
                  users.is_banned_because_fr  = '$ban_reason_fr'
          WHERE   users.id                    = '$banned_id'      ");

  // Update the unbanning scheduled task if needed
  if($ban_length)
    schedule_task_update('users_unban', $banned_id, $ban_end);

  // Generate activity logs if needed
  if($ban_length)
    log_activity('users_banned_edit', 0, 'ENFR', 0, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, $banned_id, $banned_nickname_raw);

  // Generate a modlog and detailed activity logs if needed
  if($ban_length || $ban_reason_en_raw != $dban['b_reason_en'] || $ban_reason_fr_raw != $dban['b_reason_fr'])
  {
    $modlog = log_activity('users_banned_edit', 1, 'ENFR', 0, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, $banned_id, $banned_nickname_raw, $banner_nickname_raw);
    if($ban_reason_en_raw != $dban['b_reason_en'])
      log_activity_details($modlog, 'New ban reason (EN)', 'Nouvelle raison du ban (EN)', $dban['b_reason_en'], $ban_reason_en_raw);
    if($ban_reason_fr_raw != $dban['b_reason_fr'])
      log_activity_details($modlog, 'New ban reason (FR)', 'Nouvelle raison du ban (FR)', $dban['b_reason_fr'], $ban_reason_fr_raw);
  }

  // Update the ban log
  query(" UPDATE    logs_bans
          SET       logs_bans.banned_until    = '$ban_end'        ,
                    logs_bans.ban_reason_en   = '$ban_reason_en'  ,
                    logs_bans.ban_reason_fr   = '$ban_reason_fr'
          WHERE     logs_bans.fk_banned_user  = '$banned_id'
          AND       logs_bans.unbanned_at     = 0
          ORDER BY  logs_bans.banned_until    DESC
          LIMIT     1 ");

  // Put ban durations into words
  $ban_duration_en  = array(0 => '', 1 => 'ending a day from now', 7 => 'ending a week from now', 30 => 'ending a month from now', '365' => 'ending a year from now', '3650' => 'a permanent ban');
  $ban_duration_fr  = array(0 => '', 1 => 'dans un jour', 7 => 'dans une semaine', 30 => 'dans un mois', '365' => 'dans un an', '3650' => 'ban permanent');
  $ban_duration_mod = array(0 => '', 1 => 'to ending a day from now', 7 => 'to ending a week from now', 30 => 'to ending a month from now', '365' => 'to ending a year from now', '3650' => 'to a permanent ban');

  // IRC bot messages if the ban end date has been changed
  if($ban_length)
  {
    $ban_extra_en     = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '';
    $ban_extra_fr     = ($ban_reason_fr_raw) ? '('.$ban_reason_fr_raw.')' : '';
    $ban_extra_mod    = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '(no reason specified)';
    irc_bot_send_message("$banned_nickname_raw has had their ban updated to $ban_duration_en[$ban_length] $ban_extra_en", 'english');
    irc_bot_send_message("La date de fin du bannissement de $banned_nickname_raw a changé : $ban_duration_fr[$ban_length] $ban_extra_fr", 'french');
    irc_bot_send_message("$banner_nickname_raw edited the ban of $banned_nickname_raw $ban_duration_mod[$ban_length] $ban_extra_mod", 'mod');
  }

  // Private message to the user if the ban's duration has been changed
  if($ban_length)
  {
    $ban_user_language  = user_get_language($banned_id);
    $ban_duration_pm    = ($ban_user_language == 'EN') ? $ban_duration_en : $ban_duration_fr;
    private_message_send(__('admin_ban_edit_private_message_title_'.strtolower($ban_user_language)), __('admin_ban_edit_private_message_'.strtolower($ban_user_language), null, 0, 0, array($path, date_to_text(time(), 1, $ban_user_language), $ban_duration_pm[$ban_length])), $banned_id, 0);
  }
}




/**
 * Unbans a banned user.
 *
 * @param   int         $unbanner_id                  The id of the moderator unbanning the user.
 * @param   string      $unbanned_id                  The id of the user getting unbanned.
 * @param   string|null $unban_reason_en  (OPTIONAL)  The justification for the unban, in english.
 * @param   string|null $unban_reason_fr  (OPTIONAL)  The justification for the unban, in french.
 * @param   string|null $lang             (OPTIONAL)  The language currently in use.
 * @param   string|null $path             (OPTIONAL)  The path to the root of the website.
 *
 * @return  void
 */

function admin_ban_user_delete( $unbanner_id                    ,
                                $unbanned_id                    ,
                                $unban_reason_en  = ''          ,
                                $unban_reason_fr  = ''          ,
                                $lang             = 'EN'        ,
                                $path             = './../../'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('admin.lang.php');

  // Prepare and sanitize the data
  $unbanned_id            = sanitize($unbanned_id, 'int', 0);
  $unbanned_nickname_raw  = user_get_nickname($unbanned_id);
  $unban_reason_en_raw    = $unban_reason_en;
  $unban_reason_fr_raw    = $unban_reason_fr;
  $unban_reason_en        = sanitize($unban_reason_en, 'string');
  $unban_reason_fr        = sanitize($unban_reason_fr, 'string');
  $unbanner_id            = sanitize($unbanner_id, 'int', 0);
  $unbanner_nickname_raw  = user_get_nickname($unbanner_id);

  // Do nothing if user does not exist
  if(!database_entry_exists('users', 'id', $unbanned_id))
    return;

  // Do nothing if user is not currently banned
  if(!user_is_banned($unbanned_id))
    return;

  // Do nothing if it is an attempt to unban self
  if($unbanned_id == $unbanner_id)
    return;

  // Do nothing if a moderator is trying to unban an administrator
  if(user_is_administrator($unbanned_id) && user_is_moderator($unbanner_id))
    return;

  // Fetch the ban details
  $dban = mysqli_fetch_array(query("  SELECT  users.is_banned_since       AS 'b_start'      ,
                                              users.is_banned_until       AS 'b_end'        ,
                                              users.is_banned_because_en  AS 'b_reason_en'  ,
                                              users.is_banned_because_fr  AS 'b_reason_fr'
                                      FROM    users
                                      WHERE   users.id = '$unbanned_id' "));

  // Unban the user and generate a recent activity entry
  user_unban($unbanned_id, $unbanner_id, 1);

  // Delete the unbanning scheduled task
  schedule_task_delete('users_unban', $unbanned_id);

  // Calculate the time served and left before the unbanning
  $days_served  = time_days_elapsed($dban['b_start'], time(), 1);
  $days_left    = time_days_elapsed(time(), $dban['b_end'], 1);

  // Generate a mod log with some detailed activity logs
  $modlog = log_activity('users_banned_delete', 1, 'ENFR', 0, $unban_reason_en_raw, $unban_reason_fr_raw, 0, $unbanned_id, $unbanned_nickname_raw, $unbanner_nickname_raw);
  log_activity_details($modlog, 'Days left in the ban', 'Jours restants au bannissement', $days_left);
  log_activity_details($modlog, 'Days served before the unbanning', 'Jours purgés avant le débannissement', $days_served);
  if($unban_reason_en_raw)
    log_activity_details($modlog, 'Reason for unbanning (EN)', 'Raison du débannissement (EN)', $unban_reason_en_raw);
  if($unban_reason_fr_raw)
    log_activity_details($modlog, 'Reason for unbanning (FR)', 'Raison du débannissement (FR)', $unban_reason_fr_raw);

  // Update the ban log with the unban reasons if necessary
  if($unban_reason_fr || $unban_reason_en)
    query(" UPDATE    logs_bans
            SET       logs_bans.unban_reason_en = '$unban_reason_en'  ,
                      logs_bans.unban_reason_fr = '$unban_reason_fr'
            WHERE     logs_bans.fk_banned_user  = '$unbanned_id'
            ORDER BY  logs_bans.unbanned_at     DESC
            LIMIT     1 ");

  // IRC bot message
  $unban_reason_irc = ($unban_reason_en_raw) ? '('.$unban_reason_en_raw.')' : '';
  irc_bot_send_message("$unbanner_nickname_raw has unbanned $unbanned_nickname_raw $unban_reason_irc", 'mod');

  // Private message to let the user know they have been manually unbanned
  $unbanned_user_language = user_get_language($unbanned_id);
  private_message_send(__('admin_ban_delete_private_message_title_'.strtolower($unbanned_user_language)), __('admin_ban_delete_private_message_'.strtolower($unbanned_user_language), 0, 0, 0, array($path, date_to_text(time(), 1, $unbanned_user_language), $days_served, $days_left)), $unbanned_id, 0);
}




/**
 * Lists the ban log history.
 *
 * @param   string|null   $lang             (OPTIONAL)  The user's current language.
 * @param   string|null   $sorting_order    (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   int|null      $search_status    (OPTIONAL)  Search for only banned (1) or unbanned (0) users.
 * @param   string|null   $search_username  (OPTIONAL)  Search for a specific username.
 * @param   string|null   $search_banner    (OPTIONAL)  Search for a specific banner username.
 * @param   string|null   $search_unbanner  (OPTIONAL)  Search for a specific unbanner username.
 *
 * @return  array                                       The ban log history data, ready for displaying.
*/

function admin_ban_logs_get_list( $lang             = 'EN'      ,
                                  $sorting_order    = 'banned'  ,
                                  $search_status    = -1        ,
                                  $search_username  = NULL      ,
                                  $search_banner    = NULL      ,
                                  $search_unbanner  = NULL      )
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Prepare the query to fetch the log list
  $qlogs  = "   SELECT    logs_bans.id              AS 'l_id'         ,
                          logs_bans.banned_at       AS 'l_start'      ,
                          logs_bans.banned_until    AS 'l_end'        ,
                          logs_bans.unbanned_at     AS 'l_unban'      ,
                          logs_bans.ban_reason_en   AS 'l_reason_en'  ,
                          logs_bans.ban_reason_fr   AS 'l_reason_fr'  ,
                          logs_bans.unban_reason_en AS 'l_ureason_en' ,
                          logs_bans.unban_reason_fr AS 'l_ureason_fr' ,
                          users_banned.id           AS 'banned_id'    ,
                          users_banned.nickname     AS 'banned_nick'  ,
                          users_banner.id           AS 'banner_id'    ,
                          users_banner.nickname     AS 'banner_nick'  ,
                          users_unbanner.id         AS 'unbanner_id'  ,
                          users_unbanner.nickname   AS 'unbanner_nick'
                FROM      logs_bans
                LEFT JOIN users AS users_banned   ON logs_bans.fk_banned_user       = users_banned.id
                LEFT JOIN users AS users_banner   ON logs_bans.fk_banned_by_user    = users_banner.id
                LEFT JOIN users AS users_unbanner ON logs_bans.fk_unbanned_by_user  = users_unbanner.id
                WHERE     1 = 1 ";

  // Search for data if requested
  if($search_status == 0)
    $qlogs .= " AND       logs_bans.unbanned_at   >     0                     ";
  else if($search_status == 1)
    $qlogs .= " AND       logs_bans.unbanned_at   =     0                     ";
  if($search_username)
    $qlogs .= " AND       users_banned.nickname   LIKE  '%$search_username%'  ";
  if($search_banner)
    $qlogs .= " AND       users_banner.nickname   LIKE  '%$search_banner%'    ";
  if($search_unbanner)
    $qlogs .= " AND       users_unbanner.nickname LIKE  '%$search_unbanner%'  ";

  // Sort the data as requested
  if($sorting_order == 'username')
    $qlogs .= " ORDER BY users_banned.nickname  ASC   ";
  else if($sorting_order == 'unbanned')
    $qlogs .= " ORDER BY logs_bans.unbanned_at  DESC  ";
  else
    $qlogs .= " ORDER BY  logs_bans.banned_at   DESC  ";

  // Execute the query
  $qlogs = query($qlogs);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qlogs); $i++)
  {
    $data[$i]['id']                 = $row['l_id'];
    $data[$i]['nickname']           = sanitize_output($row['banned_nick']);
    $data[$i]['user_id']            = $row['banned_id'];
    $data[$i]['start']              = time_since($row['l_start']);
    $data[$i]['start_full']         = date_to_text($row['l_start'], 0, 1, $lang);
    $data[$i]['end']                = ($row['l_unban']) ? time_since($row['l_unban']) : '';
    $data[$i]['end_full']           = date_to_text($row['l_end'], 0, 1, $lang);
    $data[$i]['duration']           = time_days_elapsed($row['l_start'], $row['l_end'], 1);
    $temp                           = ($row['l_unban']) ? $row['l_unban'] : time();
    $data[$i]['served']             = time_days_elapsed($row['l_start'], $temp, 1);
    $temp                           = maths_percentage_of($data[$i]['served'], $data[$i]['duration']);
    $temp                           = ($temp > 100) ? 100 : $temp;
    $data[$i]['served_percent']     = number_display_format($temp, "percentage", 0);
    $data[$i]['banned_by']          = sanitize_output($row['banner_nick']);
    $data[$i]['banned_by_id']       = $row['banner_id'];
    $data[$i]['unbanned_by']        = sanitize_output($row['unbanner_nick']);
    $data[$i]['unbanned_by_id']     = $row['unbanner_id'];
    $temp                           = ($row['l_reason_fr']) ? $row['l_reason_fr'] : $row['l_reason_en'];
    $temp                           = ($lang == 'EN') ? $row['l_reason_en'] : $temp;
    $data[$i]['ban_reason']         = sanitize_output(string_truncate($temp, 9, '...'));
    $data[$i]['ban_reason_full']    = (strlen($temp) > 9 ) ? sanitize_output($temp) : '';
    $temp                           = ($row['l_ureason_fr']) ? $row['l_ureason_fr'] : $row['l_ureason_en'];
    $temp                           = ($lang == 'EN') ? $row['l_ureason_en'] : $temp;
    $data[$i]['unban_reason']       = sanitize_output(string_truncate($temp, 9, '...'));
    $data[$i]['unban_reason_full']  = (strlen($temp) > 9 ) ? sanitize_output($temp) : '';
  }

  // If the sorting is by days sentenced or days banned, then it must still be sorted
  if($sorting_order == 'sentence')
    array_multisort(array_column($data, "duration"), SORT_DESC, $data);
  if($sorting_order == 'served')
    array_multisort(array_column($data, "served"), SORT_DESC, $data);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('admin.act.php', 'admin_ban_logs_get_list', $data));

  // Return the prepared data
  return $data;
}




/**
 * Fetches information about a ban log.
 *
 * @param   int|null      $log_id   (OPTIONAL)  The id of the ban log.
 * @param   int|null      $user_id  (OPTIONAL)  The id of the user that was banned.
 * @param   string|null   $lang     (OPTIONAL)  The user's current language.
 *
 * @return  array|int                           The ban log history data, ready for displaying, or 0 if log not found.
*/

function admin_ban_logs_get_one($log_id   = NULL  ,
                                $user_id  = NULL  ,
                                $lang     = 'EN'  )
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Return nothing if both the log and user id are missing
  if(!$log_id && !$user_id)
    return 0;

  // Sanitize the data
  $log_id   = sanitize($log_id, 'int', 0);
  $user_id  = sanitize($user_id, 'int', 0);

  // Return nothing if only the ban log id has been provided and the user does not exist
  if(!$log_id && !database_row_exists('users', $user_id))
    return 0;

  // If no log_id has been given, fetch it based on the provided user_id
  if(!$log_id)
  {
    $dban = mysqli_fetch_array(query("  SELECT    logs_bans.id AS 'l_id'
                                        FROM      logs_bans
                                        WHERE     logs_bans.fk_banned_user  = '$user_id'
                                        AND       logs_bans.unbanned_at     = 0
                                        ORDER BY  logs_bans.banned_at       DESC
                                        LIMIT     1 "));
    $log_id = sanitize($dban['l_id'], 'int', 0);
  }

  // Return nothing if the ban log id does not exist
  if(!database_row_exists('logs_bans', $log_id))
    return 0;

  // Fetch data regarding the ban
  $qlog = query(" SELECT    logs_bans.banned_at       AS 'l_start'      ,
                            logs_bans.banned_until    AS 'l_end'        ,
                            logs_bans.unbanned_at     AS 'l_unban'      ,
                            logs_bans.ban_reason_en   AS 'l_reason_en'  ,
                            logs_bans.ban_reason_fr   AS 'l_reason_fr'  ,
                            logs_bans.unban_reason_en AS 'l_ureason_en' ,
                            logs_bans.unban_reason_fr AS 'l_ureason_fr' ,
                            users_banned.id           AS 'banned_id'    ,
                            users_banned.nickname     AS 'banned_nick'  ,
                            users_banner.id           AS 'banner_id'    ,
                            users_banner.nickname     AS 'banner_nick'  ,
                            users_unbanner.id         AS 'unbanner_id'  ,
                            users_unbanner.nickname   AS 'unbanner_nick'
                  FROM      logs_bans
                  LEFT JOIN users AS users_banned   ON logs_bans.fk_banned_user       = users_banned.id
                  LEFT JOIN users AS users_banner   ON logs_bans.fk_banned_by_user    = users_banner.id
                  LEFT JOIN users AS users_unbanner ON logs_bans.fk_unbanned_by_user  = users_unbanner.id
                  WHERE     logs_bans.id = '$log_id'
                  ORDER BY  banned_at DESC ");

  // Grab the data from the query
  $dlog = mysqli_fetch_array($qlog);

  // Prepare the data
  $data['is_banned']        = ($dlog['l_unban']) ? 0 : 1;
  $data['user_id']          = sanitize_output($dlog['banned_id']);
  $data['username']         = sanitize_output($dlog['banned_nick']);
  $temp                     = date_to_text($dlog['l_start'], 0, 1, $lang);
  $data['start']            = sanitize_output($temp.' ('.time_since($dlog['l_start']).')');
  $temp                     = ($dlog['l_end'] > time()) ? time_until($dlog['l_end']) : time_since($dlog['l_end']);
  $data['end']              = sanitize_output(date_to_text($dlog['l_end'], 0, 1, $lang).' ('.$temp.')');
  $temp                     = date_to_text($dlog['l_unban'], 0, 1, $lang);
  $data['unban']            = ($dlog['l_unban']) ? sanitize_output($temp.' ('.time_since($dlog['l_unban']).')') : '-';
  $data['days']             = time_days_elapsed($dlog['l_start'], $dlog['l_end'], 1);
  $temp                     = ($dlog['l_unban']) ? $dlog['l_unban'] : time();
  $data['served']           = time_days_elapsed($dlog['l_start'], $temp, 1);
  $temp                     = maths_percentage_of($data['served'], $data['days']);
  $temp                     = ($temp > 100) ? 100 : $temp;
  $data['percent']          = number_display_format($temp, "percentage", 0);
  $data['banned_by']        = sanitize_output($dlog['banner_nick']);
  $data['banned_by_id']     = sanitize_output($dlog['banner_id']);
  $data['ban_reason_en']    = ($dlog['l_reason_en']) ? sanitize_output($dlog['l_reason_en']) : '-';
  $data['ban_reason_fr']    = ($dlog['l_reason_fr']) ? sanitize_output($dlog['l_reason_fr']) : '-';
  $data['unbanned_by']      = sanitize_output($dlog['unbanner_nick']);
  $data['unbanned_by_id']   = sanitize_output($dlog['unbanner_id']);
  $data['unban_reason_en']  = ($dlog['l_ureason_en']) ? sanitize_output($dlog['l_ureason_en']) : '-';
  $data['unban_reason_fr']  = ($dlog['l_ureason_fr']) ? sanitize_output($dlog['l_ureason_fr']) : '-';

  // Return the prepared data
  return $data;
}




/**
 * Permanently deletes an entry in the ban history logs.
 *
 * @param   int           $log_id             The id of the ban history log.
 * @param   string|null   $lang   (OPTIONAL)  The user's current language.
 *
 * @return  void
*/

function admin_ban_logs_delete( $log_id         ,
                                $lang   = 'EN'  )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Sanitize the log id
  $log_id = sanitize($log_id, 'int', 0);

  // Delete the log
  query(" DELETE FROM logs_bans
          WHERE       logs_bans.id = '$log_id' ");
}