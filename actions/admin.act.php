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
 * @param   int         $banner_id                  The id of the admin ordering the ban.
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
  irc_bot_send_message("$banned_nickname_raw a été banni·e du site $ban_duration_fr[$ban_length] $ban_extra_fr", 'french');
  irc_bot_send_message("$banner_nickname_raw has banned $banned_nickname_raw $ban_duration_en[$ban_length] $ban_extra_mod", 'mod');
}




/**
 * Modifies an existing ban.
 *
 * @param   int         $banner_id                  The id of the admin modifying the ban.
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

  // IRC bot messages if the ban end date has been changed
  if($ban_length)
  {
    $ban_duration_en  = array(0 => '', 1 => 'ending a day from now', 7 => 'ending a week from now', 30 => 'ending a month from now', '365' => 'ending a year from now', '3650' => 'a permanent ban');
    $ban_duration_fr  = array(0 => '', 1 => 'dans un jour', 7 => 'dans une semaine', 30 => 'dans un mois', '365' => 'dans un an', '3650' => 'ban permanent');
    $ban_duration_mod = array(0 => '', 1 => 'to ending a day from now', 7 => 'to ending a week from now', 30 => 'to ending a month from now', '365' => 'to ending a year from now', '3650' => 'to a permanent ban');
    $ban_extra_en     = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '';
    $ban_extra_fr     = ($ban_reason_fr_raw) ? '('.$ban_reason_fr_raw.')' : '';
    $ban_extra_mod    = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '(no reason specified)';
    irc_bot_send_message("$banned_nickname_raw has had their ban updated to $ban_duration_en[$ban_length] $ban_extra_en", 'english');
    irc_bot_send_message("$banned_nickname_raw a changé de date de fin pour son bannissement : $ban_duration_fr[$ban_length] $ban_extra_fr", 'french');
    irc_bot_send_message("$banner_nickname_raw edited the ban of $banned_nickname_raw $ban_duration_mod[$ban_length] $ban_extra_mod", 'mod');
  }
}