<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_ban_create            Bans a user.                                                                         */
/*  admin_ban_edit              Modifies an existing ban.                                                            */
/*  admin_ban_delete            Unbans a banned user.                                                                */
/*                                                                                                                   */
/*  admin_ip_ban_create         Bans an IP.                                                                          */
/*  admin_ip_ban_list_users     Fetches a list of users affected by an IP ban.                                       */
/*  admin_ip_ban_get            Fetches information about an IP ban.                                                 */
/*  admin_ip_ban_delete         Unbans a banned IP.                                                                  */
/*                                                                                                                   */
/*  admin_ban_logs_get          Fetches information about a ban log.                                                 */
/*  admin_ban_logs_list         Lists the ban log history.                                                           */
/*  admin_ban_logs_delete       Permanently deletes an entry in the ban history logs.                                */
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

function admin_ban_create(  $banner_id                    ,
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
  require_included_file('ban.lang.php');

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

  // Error: No nickname specified
  if(mb_strlen($nickname) < 3)
    return __('admin_ban_add_error_no_nickname');

  // Error: Nickname does not exist
  if(!$banned_user_id)
    return __('admin_ban_add_error_wrong_user');

  // Error: Can't ban self
  if($banned_user_id == $banner_id)
    return __('admin_ban_add_error_self');

  // Error: Moderators can't ban admins
  if(user_is_administrator($banned_user_id) && user_is_moderator($banner_id))
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
                      logs_bans.fk_banned_by_user = '$banner_id'      ,
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

function admin_ban_edit(  $banner_id                    ,
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
  require_included_file('ban.lang.php');

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

function admin_ban_delete(  $unbanner_id                    ,
                            $unbanned_id                    ,
                            $unban_reason_en  = ''          ,
                            $unban_reason_fr  = ''          ,
                            $lang             = 'EN'        ,
                            $path             = './../../'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('ban.lang.php');

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
 * Bans a user.
 *
 * @param   int         $banner_id                  The id of the moderator ordering the ban.
 * @param   string      $ip_address                 The IP address to ban.
 * @param   int         $ban_length                 The ban length.
 * @param   int|null    $severity       (OPTIONAL)  Whether the IP ban will be standard or full.
 * @param   string|null $nickname       (OPTIONAL)  An user whose IP should be banned if no IP is specified.
 * @param   string|null $ban_reason_en  (OPTIONAL)  The justification for the ban, in english.
 * @param   string|null $ban_reason_fr  (OPTIONAL)  The justification for the ban, in french.
 * @param   string|null $lang           (OPTIONAL)  The language currently in use.
 *
 * @return  string|null                             Returns a string containing an error, or null if all went well.
 */

function admin_ip_ban_create( $banner_id                    ,
                              $ip_address                   ,
                              $ban_length                   ,
                              $severity       = 0           ,
                              $nickname       = ''          ,
                              $ban_reason_en  = ''          ,
                              $ban_reason_fr  = ''          ,
                              $lang           = 'EN'        )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('ban.lang.php');

  // Sanitize the data
  $banner_id          = sanitize($banner_id, 'int', 0);
  $banner_ip          = sanitize($_SERVER['REMOTE_ADDR'], 'string');
  $ip_address_raw     = $ip_address;
  $ip_address         = sanitize($ip_address, 'string');
  $ban_length         = sanitize($ban_length, 'int', 0, 3650);
  $severity           = sanitize($severity, 'int', 0, 1);
  $nickname           = sanitize($nickname, 'string');
  $ban_reason_en_raw  = $ban_reason_en;
  $ban_reason_fr_raw  = $ban_reason_fr;
  $ban_reason_en      = sanitize($ban_reason_en, 'string');
  $ban_reason_fr      = sanitize($ban_reason_fr, 'string');

  // Error: No IP or nickname specified
  if(mb_strlen($nickname) < 3 && !$ip_address)
    return __('admin_ban_add_error_no_ip');

  // Error: Both IP and nickname have been specified
  if($nickname && $ip_address)
    return __('admin_ban_add_error_ip_and_user');

  // Error: Cannot ban wildcard
  if(!$nickname && $ip_address == '*')
    return __('admin_ban_add_error_wildcard');

  // Error: One wildcard maximum
  if(substr_count($ip_address, '*') > 1)
    return __('admin_ban_add_error_wildcards');

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

  // Retrieve the IP address from nickname if none was specified
  if($nickname)
  {
    // Get the user's ID from their nickname
    $banned_user_id = sanitize(database_entry_exists('users', 'nickname', $nickname), 'int');

    // Error: Nickname does not exist
    if(!$banned_user_id)
      return __('admin_ban_add_error_wrong_user');

    // Error: Can't ban self
    if($banned_user_id == $banner_id)
      return __('admin_ban_add_error_self');

    // Error: Moderators can't ban admins
    if(user_is_administrator($banned_user_id) && user_is_moderator($banner_id))
      return __('admin_ban_add_error_moderator');

    // Fetch the user's latest IP address
    $dip = mysqli_fetch_array(query(" SELECT  users.current_ip_address AS 'u_ip'
                                      FROM    users
                                      WHERE   users.id = '$banned_user_id' "));
    $ip_address_raw = $dip['u_ip'];
    $ip_address     = sanitize($dip['u_ip']);

    // Error: The user does not have an IP address
    if(!$ip_address)
      return __('admin_ban_add_error_no_user_ip');
  }

  // Error: Cannot ban self
  $check_ip = str_replace('*', '', $ip_address);
  if(strpos($check_ip, $banner_ip) !== FALSE || strpos($banner_ip, $check_ip) !== FALSE)
    return 'no';

  // Fetch all currently banned IPs
  $qip = query("  SELECT  system_ip_bans.ip_address AS 'i_ip'
                  FROM    system_ip_bans ");

  // Error: IP address is already banned
  while($dip = mysqli_fetch_array($qip))
  {
    $check_ip = str_replace('*', '', $dip['i_ip']);
    if(strpos($check_ip, $ip_address) !== FALSE || strpos($ip_address, $check_ip) !== FALSE)
      return __('admin_ban_add_error_ip_already');
  }

  // Fetch all admin IPs
  $qip = query("  SELECT  users.current_ip_address AS 'u_ip'
                  FROM    users
                  WHERE   users.is_administrator    = 1
                  AND     users.current_ip_address != '' ");

  // Error: Cannot IP ban administrators
  while($dip = mysqli_fetch_array($qip))
  {
    $check_ip = str_replace('*', '', $dip['u_ip']);
    $ip_no_wildcard = str_replace('*', '', $ip_address);
    if(strpos($check_ip, $ip_no_wildcard) !== FALSE || strpos($ip_no_wildcard, $check_ip) !== FALSE)
      return __('admin_ban_add_error_ip_admin');
  }

  // Ban the IP
  $timestamp  = sanitize(time(), 'int', 0);
  $ban_end    = sanitize($ban_end, 'int', 0);
  query(" INSERT INTO system_ip_bans
          SET         system_ip_bans.ip_address     = '$ip_address'     ,
                      system_ip_bans.is_a_total_ban = '$severity'       ,
                      system_ip_bans.banned_since   = '$timestamp'      ,
                      system_ip_bans.banned_until   = '$ban_end'        ,
                      system_ip_bans.ban_reason_en  = '$ban_reason_en'  ,
                      system_ip_bans.ban_reason_fr  = '$ban_reason_fr'  ");

  // Schedule the unbanning
  $ip_ban_id = query_id();
  schedule_task('users_unban_ip', $ip_ban_id, $ban_end, $ip_address);

  // Activity logs
  $banner_nickname = user_get_nickname($banner_id);
  $modlog = log_activity('users_banned_ip', 1, 'ENFR', $ip_ban_id, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, 0, $ip_address_raw, $banner_nickname);

  // Detailed activity logs
  if($ban_reason_en_raw)
    log_activity_details($modlog, 'Ban reason (EN)', 'Raison du ban (EN)', $ban_reason_en_raw, $ban_reason_en_raw);
  if($ban_reason_fr_raw)
    log_activity_details($modlog, 'Ban reason (FR)', 'Raison du ban (FR)', $ban_reason_fr_raw, $ban_reason_fr_raw);

  // Ban logs
  query(" INSERT INTO logs_bans
          SET         logs_bans.banned_ip_address = '$ip_address'     ,
                      logs_bans.is_a_total_ip_ban = '$severity'       ,
                      logs_bans.fk_banned_by_user = '$banner_id'      ,
                      logs_bans.banned_at         = '$timestamp'      ,
                      logs_bans.banned_until      = '$ban_end'        ,
                      logs_bans.ban_reason_en     = '$ban_reason_en'  ,
                      logs_bans.ban_reason_fr     = '$ban_reason_fr'  ");

  // IRC bot message
  $ban_duration = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month', '365' => 'for a year', '3650' => 'permanently');
  $ban_extra    = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '(no reason specified)';
  irc_bot_send_message("$banner_nickname has banned the IP address $ip_address_raw $ban_duration[$ban_length] $ban_extra", 'mod');
  irc_bot_send_message("$banner_nickname has banned the IP address $ip_address_raw $ban_duration[$ban_length] $ban_extra", 'admin');
}




/**
 * Fetches a list of users affected by an IP ban.
 *
 * @param   string        $banned_ip              The banned IP.
 * @param   string|null   $lang       (OPTIONAL)  The user's current language.
 *
 * @return  array                                 An array containing data related to users affected by the IP ban.
 */

function admin_ip_ban_list_users( $banned_ip          ,
                                  $lang       = 'EN'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Sanitize the ip
  $banned_ip = sanitize(str_replace("*", "%", $banned_ip), 'string');

  // Fetch affeted users
  $qusers = query(" SELECT    users.id        AS 'u_id'   ,
                              users.nickname  AS 'u_nick'
                    FROM      users
                    WHERE     users.current_ip_address LIKE '$banned_ip'
                    ORDER BY  users.nickname ASC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qusers); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['u_id']);
    $data[$i]['nickname'] = sanitize_output($row['u_nick']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'dev/ban.act.php', 'function' => 'admin_ip_ban_list_users', 'data' => $data));

  // Return the prepared data
  return $data;
}




/**
 * Fetches information about an IP ban.
 *
 * @param   int         $ip_ban_id              The IP ban's ID.
 * @param   string|null $lang       (OPTIONAL)  The language currently in use.
 *
 * @return  array|string                        An array of data regarding the ban, or a string containing an error.
 */

function admin_ip_ban_get(  $ip_ban_id          ,
                            $lang       = 'EN'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Sanitize the ID
  $ip_ban_id = sanitize($ip_ban_id, 'int', 0);

  // Fetch data regarding the ban
  $dban = mysqli_fetch_array(query("  SELECT  system_ip_bans.ip_address     AS 'b_ip'         ,
                                              system_ip_bans.banned_until   AS 'b_end'        ,
                                              system_ip_bans.ban_reason_en  AS 'b_reason_en'  ,
                                              system_ip_bans.ban_reason_fr  AS 'b_reason_fr'
                                      FROM    system_ip_bans
                                      WHERE   system_ip_bans.id = '$ip_ban_id' "));

  // Prepare the data
  $data['ip_address'] = sanitize_output($dban['b_ip']);
  $data['time_left']  = sanitize_output(time_until($dban['b_end']));
  $temp               = ($dban['b_reason_fr']) ? $dban['b_reason_fr'] : $dban['b_reason_en'];
  $data['ban_reason'] = ($lang == 'EN') ? sanitize_output($dban['b_reason_en']) : sanitize_output($temp);

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/ban.act.php', 'function' => 'admin_ip_ban_get', 'data' => $data));

  // Return the data
  return $data;
}




/**
 * Unbans a banned IP.
 *
 * @param   int         $ban_id                       The ID of the IP ban to remove.
 * @param   int         $unbanner_id                  The id of the moderator unbanning the user.
 * @param   string|null $unban_reason_en  (OPTIONAL)  The justification for the unban, in english.
 * @param   string|null $unban_reason_fr  (OPTIONAL)  The justification for the unban, in french.
 * @param   string|null $lang             (OPTIONAL)  The language currently in use.
 *
 * @return  void
 */

function admin_ip_ban_delete( $ban_id                   ,
                              $unbanner_id              ,
                              $unban_reason_en  = ''    ,
                              $unban_reason_fr  = ''    ,
                              $lang             = 'EN'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Sanitize the data
  $ban_id               = sanitize($ban_id, 'int', 0);
  $unbanner_id          = sanitize($unbanner_id, 'int', 0);
  $unban_reason_en_raw  = $unban_reason_en;
  $unban_reason_fr_raw  = $unban_reason_fr;
  $unban_reason_en      = sanitize($unban_reason_en, 'string');
  $unban_reason_fr      = sanitize($unban_reason_fr, 'string');

  // Do nothing if the ban does not exist
  if(!database_row_exists('system_ip_bans', $ban_id));

  // Fetch the IP address that was banned
  $dban = mysqli_fetch_array(query("  SELECT  system_ip_bans.ip_address     AS 'b_ip'     ,
                                              system_ip_bans.banned_since   AS 'b_start'  ,
                                              system_ip_bans.banned_until   AS 'b_end'
                                      FROM    system_ip_bans
                                      WHERE   system_ip_bans.id = '$ban_id' "));

  // Prepare data regarding the ban
  $banned_ip_raw  = $dban['b_ip'];
  $banned_ip      = sanitize($dban['b_ip'], 'string');
  $days_served    = time_days_elapsed($dban['b_start'], time(), 1);
  $days_left      = time_days_elapsed(time(), $dban['b_end'], 1);

  // Unban the IP
  query(" DELETE FROM system_ip_bans
          WHERE       system_ip_bans.id = '$ban_id' ");

  // Delete the unbanning scheduled task
  schedule_task_delete('users_unban_ip', $ban_id);

  // Activity logs
  $unbanner_nickname_raw = user_get_nickname($unbanner_id);
  $modlog = log_activity('users_banned_ip_delete', 1, 'ENFR', $ban_id, $unban_reason_en_raw, $unban_reason_fr_raw, 0, 0, $banned_ip_raw, $unbanner_nickname_raw);

  // Detailed activity logs
  log_activity_details($modlog, 'Days left in the ban', 'Jours restants au bannissement', $days_left);
  log_activity_details($modlog, 'Days served before the unbanning', 'Jours purgés avant le débannissement', $days_served);
  if($unban_reason_en_raw)
    log_activity_details($modlog, 'Unan reason (EN)', 'Raison du débannissement (EN)', $unban_reason_en_raw, $unban_reason_en_raw);
  if($unban_reason_fr_raw)
    log_activity_details($modlog, 'Unan reason (FR)', 'Raison du débannissement (FR)', $unban_reason_fr_raw, $unban_reason_fr_raw);

  // Update the ban log with the unban reasons if necessary
  if($unban_reason_fr || $unban_reason_en)
    query(" UPDATE    logs_bans
            SET       logs_bans.unban_reason_en   =     '$unban_reason_en'  ,
                      logs_bans.unban_reason_fr   =     '$unban_reason_fr'
            WHERE     logs_bans.banned_ip_address LIKE  '$banned_ip'
            ORDER BY  logs_bans.unbanned_at       DESC
            LIMIT     1 ");

  // IRC bot message
  $unban_reason_irc = ($unban_reason_en_raw) ? '('.$unban_reason_en_raw.')' : '';
  irc_bot_send_message("$unbanner_nickname_raw has unbanned the IP address $banned_ip_raw $unban_reason_irc", 'mod');
  irc_bot_send_message("$unbanner_nickname_raw has unbanned the IP address $banned_ip_raw $unban_reason_irc", 'admin');
}




/**
 * Fetches information about a ban log.
 *
 * @param   int|null      $log_id     (OPTIONAL)  The id of the ban log.
 * @param   int|null      $user_id    (OPTIONAL)  The id of the user that was banned.
 * @param   int|null      $ip_ban_id  (OPTIONAL)  The id of an IP ban.
 * @param   string|null   $lang       (OPTIONAL)  The user's current language.
 *
 * @return  array|int                           The ban log history data, ready for displaying, or 0 if log not found.
*/

function admin_ban_logs_get(  $log_id     = NULL  ,
                              $user_id    = NULL  ,
                              $ip_ban_id  = NULL  ,
                              $lang       = 'EN'  )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Return nothing if all ids are missing
  if(!$log_id && !$user_id && !$ip_ban_id)
    return 0;

  // Sanitize the data
  $log_id     = sanitize($log_id, 'int', 0);
  $user_id    = sanitize($user_id, 'int', 0);
  $ip_ban_id  = sanitize($ip_ban_id, 'int', 0);

  // Return nothing if only the ban log id, user id, and ip ban id all don't exist
  if(!$log_id && !database_row_exists('users', $user_id) && !database_row_exists('system_ip_bans', $ip_ban_id))
    return 0;

  // If a user_id has been provided, fetch the log_id
  if($user_id)
  {
    $dban = mysqli_fetch_array(query("  SELECT    logs_bans.id AS 'l_id'
                                        FROM      logs_bans
                                        WHERE     logs_bans.fk_banned_user  = '$user_id'
                                        AND       logs_bans.unbanned_at     = 0
                                        ORDER BY  logs_bans.banned_at       DESC
                                        LIMIT     1 "));
    $log_id = sanitize($dban['l_id'], 'int', 0);
  }

  // If an ip ban has been provided, fetch the log id
  if($ip_ban_id)
  {
    // Fetch the banned IP address
    $dip = mysqli_fetch_array(query(" SELECT  system_ip_bans.ip_address AS 'ib_ip'
                                      FROM    system_ip_bans
                                      WHERE   system_ip_bans.id = '$ip_ban_id' "));
    $banned_ip = sanitize($dip['ib_ip'], 'string');

    // Fetch the log id matching the fetched IP address
    $dban = mysqli_fetch_array(query("  SELECT    logs_bans.id AS 'l_id'
                                        FROM      logs_bans
                                        WHERE     logs_bans.banned_ip_address LIKE  '$banned_ip'
                                        AND       logs_bans.unbanned_at       =     0
                                        ORDER BY  logs_bans.banned_at         DESC
                                        LIMIT     1 "));
    $log_id = sanitize($dban['l_id'], 'int', 0);
  }

  // Return nothing if the ban log id does not exist
  if(!database_row_exists('logs_bans', $log_id))
    return 0;

  // Fetch data regarding the ban
  $qlog = query(" SELECT    logs_bans.banned_ip_address AS 'l_ip'           ,
                            logs_bans.is_a_total_ip_ban AS 'l_total_ip_ban' ,
                            logs_bans.banned_at         AS 'l_start'        ,
                            logs_bans.banned_until      AS 'l_end'          ,
                            logs_bans.unbanned_at       AS 'l_unban'        ,
                            logs_bans.ban_reason_en     AS 'l_reason_en'    ,
                            logs_bans.ban_reason_fr     AS 'l_reason_fr'    ,
                            logs_bans.unban_reason_en   AS 'l_ureason_en'   ,
                            logs_bans.unban_reason_fr   AS 'l_ureason_fr'   ,
                            users_banned.id             AS 'banned_id'      ,
                            users_banned.nickname       AS 'banned_nick'    ,
                            users_banner.id             AS 'banner_id'      ,
                            users_banner.nickname       AS 'banner_nick'    ,
                            users_unbanner.id           AS 'unbanner_id'    ,
                            users_unbanner.nickname     AS 'unbanner_nick'
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
  $data['banned_ip']        = sanitize_output($dlog['l_ip']);
  $data['total_ip_ban']     = sanitize_output($dlog['l_total_ip_ban']);
  $data['ip_bans']          = ($dlog['l_ip']) ? admin_ip_ban_list_users($dlog['l_ip'], $lang) : '';
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

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'admin/ban.act.php', 'function' => 'admin_ban_logs_get', 'data' => $data));

  // Return the prepared data
  return $data;
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

function admin_ban_logs_list( $lang             = 'EN'      ,
                              $sorting_order    = 'banned'  ,
                              $search_status    = -1        ,
                              $search_username  = NULL      ,
                              $search_banner    = NULL      ,
                              $search_unbanner  = NULL      )
{
  // Require moderator rights to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_mathematics.inc.php');
  require_included_file('functions_numbers.inc.php');

  // Prepare the query to fetch the log list
  $qlogs  = "   SELECT    logs_bans.id                AS 'l_id'         ,
                          logs_bans.banned_ip_address AS 'l_ip'         ,
                          logs_bans.banned_at         AS 'l_start'      ,
                          logs_bans.banned_until      AS 'l_end'        ,
                          logs_bans.unbanned_at       AS 'l_unban'      ,
                          logs_bans.ban_reason_en     AS 'l_reason_en'  ,
                          logs_bans.ban_reason_fr     AS 'l_reason_fr'  ,
                          logs_bans.unban_reason_en   AS 'l_ureason_en' ,
                          logs_bans.unban_reason_fr   AS 'l_ureason_fr' ,
                          logs_bans.is_a_total_ip_ban AS 'l_total_ban'  ,
                          users_banned.id             AS 'banned_id'    ,
                          users_banned.nickname       AS 'banned_nick'  ,
                          users_banner.id             AS 'banner_id'    ,
                          users_banner.nickname       AS 'banner_nick'  ,
                          users_unbanner.id           AS 'unbanner_id'  ,
                          users_unbanner.nickname     AS 'unbanner_nick'
                FROM      logs_bans
                LEFT JOIN users AS users_banned   ON logs_bans.fk_banned_user       = users_banned.id
                LEFT JOIN users AS users_banner   ON logs_bans.fk_banned_by_user    = users_banner.id
                LEFT JOIN users AS users_unbanner ON logs_bans.fk_unbanned_by_user  = users_unbanner.id
                WHERE     1 = 1 ";

  // Search for data if requested
  if($search_status == 0)
    $qlogs .= " AND       logs_bans.unbanned_at         >     0                       ";
  else if($search_status == 1)
    $qlogs .= " AND       logs_bans.unbanned_at         =     0                       ";
  if($search_username)
    $qlogs .= " AND     ( users_banned.nickname         LIKE  '%$search_username%'
                OR        logs_bans.banned_ip_address   LIKE  '%$search_username%' )  ";
  if($search_banner)
    $qlogs .= " AND       users_banner.nickname         LIKE  '%$search_banner%'      ";
  if($search_unbanner)
    $qlogs .= " AND       users_unbanner.nickname       LIKE  '%$search_unbanner%'    ";

  // Sort the data as requested
  if($sorting_order == 'username')
    $qlogs .= " ORDER BY  logs_bans.banned_ip_address != '' ,
                          users_banned.nickname       ASC   ,
                          logs_bans.banned_ip_address ASC   ";
  else if($sorting_order == 'unbanned')
    $qlogs .= " ORDER BY  logs_bans.unbanned_at       DESC  ";
  else
    $qlogs .= " ORDER BY  logs_bans.banned_at         DESC  ";

  // Execute the query
  $qlogs = query($qlogs);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qlogs); $i++)
  {
    $data[$i]['id']                 = $row['l_id'];
    $data[$i]['ban_type']           = ($row['banned_nick']) ? 'user' : 'ip_ban';
    $data[$i]['nickname']           = sanitize_output($row['banned_nick']);
    $data[$i]['ip']                 = sanitize_output($row['l_ip']);
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
    var_dump(array('file' => 'admin/ban.act.php', 'function' => 'admin_ban_logs_list', 'data' => $data));

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