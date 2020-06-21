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
 * @param   int|null    $banner_id                  The id of the admin ordering the ban.
 * @param   string      $nickname                   The nickname of the user to ban.
 * @param   int         $ban_length                 The ban length.
 * @param   string|null $ban_reason_en  (OPTIONAL)  The justification for the ban, in english.
 * @param   string|null $ban_reason_fr  (OPTIONAL)  The justification for the ban, in french.
 * @param   string|null $lang           (OPTIONAL)  The language currently in use.
 *
 * @return  string|null                             Returns a string containing an error, or null if all went well.
 */

function admin_ban_user(  $banner_id              ,
                          $nickname               ,
                          $ban_length             ,
                          $ban_reason_en  = ''    ,
                          $ban_reason_fr  = ''    ,
                          $lang           = 'EN'  )
{
  // Require moderator right to run this action
  user_restrict_to_moderators($lang);

  // Check if the required files have been included
  require_included_file('admin.lang.php');

  // Prepare and sanitize the data
  $banned_nickname_raw  = $nickname;
  $ban_reason_en_raw    = $ban_reason_en;
  $ban_reason_fr_raw    = $ban_reason_fr;
  $banner_nickname_raw  = user_get_nickname();
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

  // Activity logs
  $banned_nickname = user_get_nickname($banned_user_id);
  log_activity('users_banned', 0, 'ENFR', 0, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, $banned_user_id, $banned_nickname);
  $modlog = log_activity('users_banned', 1, 'ENFR', 0, $ban_reason_en_raw, $ban_reason_fr_raw, $ban_length, $banned_user_id, $banned_nickname, $banner_nickname_raw);

  // Detailed activity logs
  if($ban_reason_en_raw)
    log_activity_details($modlog, 'Ban reason (EN)', 'Raison du ban (EN)', $ban_reason_en_raw, $ban_reason_en_raw);
  if($ban_reason_fr_raw)
    log_activity_details($modlog, 'Ban reason (FR)', 'Raison du ban (FR)', $ban_reason_fr_raw, $ban_reason_fr_raw);

  // IRC bot messages
  $ban_duration_en  = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month', '365' => 'for a year', '3650' => 'permanently');
  $ban_duration_fr  = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois', '365' => 'un an', '3650' => 'définitivement');
  $ban_extra_en     = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '';
  $ban_extra_fr     = ($ban_reason_fr_raw) ? '('.$ban_reason_fr_raw.')' : '';
  $ban_extra_mod    = ($ban_reason_en_raw) ? '('.$ban_reason_en_raw.')' : '(no reason specified)';
  irc_bot_send_message("$banned_nickname_raw has been banned from the website $ban_duration_en[$ban_length] $ban_extra_en", 'english');
  irc_bot_send_message("$banned_nickname_raw a été banni·e du site $ban_duration_fr[$ban_length] $ban_extra_fr", 'french');
  irc_bot_send_message("$banner_nickname_raw has banned $banned_nickname_raw $ban_duration_en[$ban_length] $ban_extra_mod", 'mod');
}