<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  admin_account_deactivate          Deactivates an account.                                                        */
/*  admin_account_reactivate          Reactivates a deleted account.                                                 */
/*                                                                                                                   */
/*  admin_account_check_availability  Checks whether a username is available and legal.                              */
/*  admin_account_rename              Renames an account.                                                            */
/*  admin_account_change_password     Changes an account's password.                                                 */
/*  admin_account_change_rights       Changes an account's access rights.                                            */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Deactivates an account.
 *
 * @param   string        $username   Username of the account to deactivate.
 *
 * @return  string|null               Returns a string containing an error, or null if all went well.
 */

function admin_account_deactivate( string $username ) : mixed
{
  // Require moderator rights to run this action
  user_restrict_to_moderators();

  // Check if the required files have been included
  require_included_file('user_management.lang.php');

  // Sanitize and prepare the data
  $username_raw = $username;
  $username     = sanitize($username, 'string');
  $timestamp    = sanitize(time(), 'int', 0);
  $mod_nick_raw = user_get_username();

  // Error: No username provided
  if(!$username)
    return __('admin_deactivate_error_username');

  // Look for the user id
  $delete_id = sanitize(database_entry_exists('users', 'username', $username), 'int', 0);

  // Error: User not found
  if(!$delete_id)
    return __('admin_deactivate_error_id');

  // Error: Account already deleted
  if(user_is_deleted($delete_id))
    return __('admin_deactivate_error_deleted');

  // Error: Can't deactivate the administrative team
  if(user_is_moderator($delete_id) || user_is_administrator($delete_id))
    return __('admin_deactivate_error_admin');

  // Assemble the new username
  $new_username = 'user '.$delete_id;

  // Delete the user
  query(" UPDATE  users
          SET     users.is_deleted        = 1             ,
                  users.deleted_at        = '$timestamp'  ,
                  users.deleted_username  = '$username'   ,
                  users.username          = '$new_username'
          WHERE   users.id                = '$delete_id'  ");

  // Activity log
  log_activity( 'users_delete'                    ,
                is_moderators_only: 1             ,
                fk_users:           $delete_id    ,
                username:           $username_raw ,
                moderator_username: $mod_nick_raw );

  // IRC bot message
  irc_bot_send_message("$mod_nick_raw has deleted the account of $username_raw - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Discord message
  discord_send_message("$mod_nick_raw has deleted the account of $username_raw - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Return that all went well
  return NULL;
}




/**
 * Deactivates a deleted account.
 *
 * @param   string        $user_id  ID of the account to reactivate.
 *
 * @return  string|null             Returns a string containing an error, or null if all went well.
 */

function admin_account_reactivate( string $user_id ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('user_management.lang.php');

  // Sanitize and prepare the data
  $user_id        = sanitize($user_id, 'int', 0);
  $admin_nick_raw = user_get_username();

  // Error: No ID provided
  if(!$user_id)
    return __('admin_reactivate_no_id');

  // Error: Account does not exist
  if(!database_row_exists('users', $user_id))
    return __('admin_reactivate_no_user');

  // Fetch the user's old username
  $duser = mysqli_fetch_array(query(" SELECT  users.deleted_username AS 'u_nick'
                                      FROM    users
                                      WHERE   users.id = '$user_id' "));
  $username_raw = $duser['u_nick'];
  $username     = sanitize($duser['u_nick'], 'string');

  // Reactivate the user
  query(" UPDATE  users
          SET     users.is_deleted        = 0           ,
                  users.deleted_at        = 0           ,
                  users.deleted_username  = ''          ,
                  users.username          = '$username'
          WHERE   users.id                = '$user_id'  ");

  // Activity log
  log_activity( 'users_undelete'                    ,
                is_moderators_only: 1               ,
                fk_users:           $user_id        ,
                username:           $username_raw   ,
                moderator_username: $admin_nick_raw );

  // IRC bot message
  irc_bot_send_message("$admin_nick_raw has reactivated the deleted account of $username_raw - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Discord message
  discord_send_message("$admin_nick_raw has reactivated the deleted account of $username_raw - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Return that all went well
  return NULL;
}




/**
 * Checks whether a username is available and legal.
 *
 * @param   string  Username to check for availability and legality.
 *
 * @return  array   Array containing whether the username is available and legal, and an error message if not.
 */

function admin_account_check_availability( string $username ) : array
{
  // Require moderator rights to run this action
  user_restrict_to_moderators();

  // Check if the required files have been included
  require_included_file('user_management.lang.php');
  require_included_file('users.act.php');

  // Sanitize the data
  $username = sanitize($username, 'string');

  // Prepare the returned array
  $return['valid'] = 0;

  // Error: username too short
  if(mb_strlen($username) < 3)
  {
    $return['error'] = __('admin_rename_error_short');
    return $return;
  }

  // Error: username too long
  if(mb_strlen($username) > 15)
  {
    $return['error'] = __('admin_rename_error_long');
    return $return;
  }

  // Error: Special characters in username
  if(!preg_match("/^[a-zA-Z0-9]+$/", $username))
  {
    $return['error'] = __('admin_rename_error_characters');
    return $return;
  }

  // Error: Illegal word
  if(user_check_username_illegality($username))
  {
    $return['error'] = __('admin_rename_error_illegal');
    return $return;
  }

  // Error: Already taken
  if(user_check_username($username))
  {
    $return['error'] = __('admin_rename_error_taken');
    return $return;
  }

  // No error: The username is valid
  $return['valid'] = 1;
  return $return;
}




/**
 * Renames an account.
 *
 * @param   string        $username       Username of the account to rename.
 * @param   string        $new_username   New username the account will be renamed to.
 *
 * @return  string|int                    Returns a string containing an error, or the user's id if all went well.
 */

function admin_account_rename(  string  $username     ,
                                string  $new_username ) : mixed
{
  // Require moderator rights to run this action
  user_restrict_to_moderators();

  // Check if the required files have been included
  require_included_file('user_management.lang.php');
  require_included_file('users.act.php');

  // Sanitize and prepare the data
  $username_raw     = $username;
  $username         = sanitize($username, 'string');
  $new_username_raw = $new_username;
  $new_username     = sanitize($new_username, 'string');
  $mod_nick_raw     = user_get_username();

  // Error: No username provided
  if(!$username_raw || !$new_username_raw)
    return __('admin_deactivate_error_username');

  // Look for the user id
  $user_id = sanitize(database_entry_exists('users', 'username', $username), 'int', 0);

  // Error: User not found
  if(!$user_id)
    return __('admin_deactivate_error_id');

  // Error: Mods can't rename admins
  if(!user_is_administrator() && user_is_administrator($user_id))
    return __('admin_rename_error_admin');

  // Error: New username is invalid
  $username_availability = admin_account_check_availability($new_username_raw);
  if(!$username_availability['valid'])
    return $username_availability['error'];

  // Rename the users
  query(" UPDATE  users
          SET     users.username  = '$new_username'
          WHERE   users.id        = '$user_id' ");

  // Activity log
  log_activity( 'users_rename'                          ,
                is_moderators_only:   1                 ,
                activity_summary_en:  $username_raw     ,
                fk_users:             $user_id          ,
                username:             $new_username_raw ,
                moderator_username:   $mod_nick_raw     );

  // IRC bot message
  irc_bot_send_message("$mod_nick_raw has renamed $username_raw to $new_username_raw - ".$GLOBALS['website_url']."pages/users/".$user_id, 'mod');

  // Discord message
  discord_send_message("$mod_nick_raw has renamed $username_raw to $new_username_raw - ".$GLOBALS['website_url']."pages/users/".$user_id, 'mod');

  // Return that all went well
  return NULL;
}




/**
 * Changes an account's password.
 *
 * @param   string        $username   Username of the account that will get their password changed.
 * @param   string        $password   The new password to use.
 *
 * @return  string|int                Returns a string containing an error, or the user's id if all went well.
 */

function admin_account_change_password( string  $username ,
                                        string  $password ) : mixed
{
  // Require moderator rights to run this action
  user_restrict_to_moderators();

  // Check if the required files have been included
  require_included_file('user_management.lang.php');

  // Sanitize and prepare the data
  $username_raw       = $username;
  $username           = sanitize($username, 'string');
  $password_encrypted = sanitize(encrypt_data($password), 'string');
  $mod_nick_raw       = user_get_username();

  // Error: No username provided
  if(!$username_raw)
    return __('admin_deactivate_error_username');

  // Error: No password provided
  if(!$password)
    return __('admin_password_error_no_pass');

  // Error: Password too short
  if(mb_strlen($password) < 8)
    return __('admin_password_error_length');

  // Look for the user id
  $user_id = sanitize(database_entry_exists('users', 'username', $username), 'int', 0);

  // Error: User not found
  if(!$user_id)
    return __('admin_deactivate_error_id');

  // Error: Mods can't change admin passwords
  if(!user_is_administrator() && user_is_administrator($user_id))
    return __('admin_password_error_admin');

  // Update the password
  query(" UPDATE  users
          SET     users.password  = '$password_encrypted'
          WHERE   users.id        = '$user_id' ");

  // Delete all active sessions for the user
  query(" DELETE FROM users_tokens
          WHERE       users_tokens.fk_users   = '$user_id'
          AND         users_tokens.token_type = 'session' ");

  // Activity log
  log_activity( 'users_password'                  ,
                is_moderators_only: 1             ,
                fk_users:           $user_id      ,
                username:           $username_raw ,
                moderator_username: $mod_nick_raw );

  // IRC bot message
  irc_bot_send_message("$mod_nick_raw has changed $username_raw's password - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Discord message
  discord_send_message("$mod_nick_raw has changed $username_raw's password - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Return that all went well
  return NULL;
}




/**
 * Changes an account's access rights.
 *
 * @param   string        $username   Username of the account that will get their access rights changed.
 * @param   string        $level      The new access rights to give the account.
 *
 * @return  string|int                Returns a string containing an error, or the user's id if all went well.
 */

function admin_account_change_rights( string  $username ,
                                      string  $level    ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('user_management.lang.php');

  // Sanitize and prepare the data
  $username_raw   = $username;
  $username       = sanitize($username, 'string');
  $admin_id       = user_get_id();
  $admin_nick_raw = user_get_username();

  // Error: No username provided
  if(!$username_raw)
    return __('admin_deactivate_error_username');

  // Error: Access rights don't exist
  if($level < 0 || $level > 2)
    return __('admin_rights_error_level');

  // Look for the user id
  $user_id = sanitize(database_entry_exists('users', 'username', $username), 'int', 0);

  // Error: User not found
  if(!$user_id)
    return __('admin_deactivate_error_id');

  // Error: Can't delete your own rights
  if($user_id == $admin_id)
    return __('admin_rights_error_self');

  // Error: Can't get rid of the original user
  if($user_id == 1 && $level < 2)
    return __('admin_rights_error_founder');

  // Demotion to user
  if($level == 0)
  {
    // Error: User is already an user
    if(!user_is_moderator($user_id) && !user_is_administrator($user_id))
      return __('admin_rights_error_user');

    // Update the access rights
    query(" UPDATE  users
            SET     users.is_moderator      = 0 ,
                    users.is_administrator  = 0
            WHERE   users.id                = '$user_id' ");

    // Activity log
    log_activity( 'users_rights_delete'               ,
                  fk_users:             $user_id      ,
                  username:             $username_raw );
    log_activity( 'users_rights_delete'               ,
                  is_moderators_only:   1               ,
                  fk_users:             $user_id        ,
                  username:             $username_raw   ,
                  moderator_username:   $admin_nick_raw );

    // IRC bot message
    irc_bot_send_message("$username_raw has been removed from the administrative team by $admin_nick_raw - ".$GLOBALS['website_url']."pages/users/admins", 'mod');

    // Discord message
    discord_send_message("$username_raw has been removed from the administrative team by $admin_nick_raw - ".$GLOBALS['website_url']."pages/users/admins", 'mod');
  }

  // Promotion to moderator
  if($level == 1)
  {
    // Error: Demotions must go full circle
    if(user_is_administrator($user_id))
      return __('admin_rights_error_demotion');

    // Error: User is already a moderator
    if(user_is_moderator($user_id))
      return __('admin_rights_error_mod');

    // Update the access rights
    query(" UPDATE  users
            SET     users.is_moderator      = 1 ,
                    users.is_administrator  = 0
            WHERE   users.id                = '$user_id' ");

    // Activity log
    log_activity( 'users_rights_moderator'                ,
                  fk_users:                 1             ,
                  username:                 $username_raw );
    log_activity( 'users_rights_moderator'                  ,
                  is_moderators_only:       1               ,
                  fk_users:                 1               ,
                  username:                 $username_raw   ,
                  moderator_username:       $admin_nick_raw );

    // IRC bot message
    irc_bot_send_message("$username_raw has joined the website's administrative team as a moderator - ".$GLOBALS['website_url']."pages/users/admins", 'english');
    irc_bot_send_message("$username_raw a rejoint l'équipe de modération du site - ".$GLOBALS['website_url']."pages/users/admins", 'french');
    irc_bot_send_message("$username_raw has been promoted to moderator by $admin_nick_raw - ".$GLOBALS['website_url']."pages/users/admins", 'mod');

    // Discord message
    discord_send_message("$username_raw has been promoted to moderator by $admin_nick_raw - ".$GLOBALS['website_url']."pages/users/admins", 'mod');
  }

  // Promotion to administrator
  if($level == 2)
  {
    // Error: User is already an administrators
    if(user_is_administrator($user_id))
      return __('admin_rights_error_admin');

    // Update the access rights
    query(" UPDATE  users
            SET     users.is_moderator      = 0 ,
                    users.is_administrator  = 1
            WHERE   users.id                = '$user_id' ");

    // Activity log
    log_activity( 'users_rights_administrator'                ,
                  fk_users:                     1             ,
                  username:                     $username_raw );
    log_activity( 'users_rights_administrator'                  ,
                  is_moderators_only:           1               ,
                  fk_users:                     1               ,
                  username:                     $username_raw   ,
                  moderator_username:           $admin_nick_raw );

    // IRC bot message
    irc_bot_send_message("$username_raw is now a website administrator - ".$GLOBALS['website_url']."pages/users/admins", 'english');
    irc_bot_send_message("$username_raw a rejoint l'équipe d'administration du site - ".$GLOBALS['website_url']."pages/users/admins", 'french');
    irc_bot_send_message("$username_raw has been promoted to administrator by $admin_nick_raw - ".$GLOBALS['website_url']."pages/users/admins", 'mod');

    // Discord message
    discord_send_message("$username_raw has been promoted to administrator by $admin_nick_raw - ".$GLOBALS['website_url']."pages/users/admins", 'mod');
  }

  // Return that all went well
  return NULL;
}