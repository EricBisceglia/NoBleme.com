<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  private_message_list            Lists a user's private messages and system notifications.                        */
/*  private_message_years_list      Fetches all years during which the current user got private messages.            */
/*  private_message_get             Fetches information about a private message.                                     */
/*  private_message_delete          Deletes a private message.                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Lists a user's private messages and system notifications.
 *
 * @param   string  $sort_by  (OPTIONAL)  The order in which the returned data will be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         The private messages, ready for displaying.
 */

function private_message_list(  string  $sort_by  = ''      ,
                                array   $search   = array() ) : array
{
  // Require users to be logged in to run this action
  user_restrict_to_users();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Fetch the user's id
  $user_id = sanitize(user_get_id(), 'int', 1);

  // Sanitize the search parameters
  $search_title   = isset($search['title'])   ? sanitize($search['title'], 'string')            : NULL;
  $search_sender  = isset($search['sender'])  ? sanitize($search['sender'], 'string')           : NULL;
  $search_date    = isset($search['date'])    ? sanitize($search['date'], 'int', 0, date('Y'))  : NULL;
  $search_read    = isset($search['read'])    ? sanitize($search['read'], 'int', -1, 1)         : NULL;

  // Fetch the private messages
  $qmessages = "    SELECT      users_private_messages.id               AS 'pm_id'    ,
                                users_private_messages.fk_users_sender  AS 'us_id'    ,
                                users_sender.username                   AS 'us_nick'  ,
                                users_private_messages.sent_at          AS 'pm_sent'  ,
                                users_private_messages.read_at          AS 'pm_read'  ,
                                users_private_messages.title            AS 'pm_title' ,
                                users_private_messages.body             AS 'pm_body'
                    FROM        users_private_messages
                    LEFT JOIN   users AS users_sender ON users_private_messages.fk_users_sender = users_sender.id
                    WHERE       users_private_messages.fk_users_recipient   = '$user_id'
                    AND         users_private_messages.deleted_by_recipient = 0 ";

  // Search for data if requested
  if($search_title)
    $qmessages .= " AND         users_private_messages.title                        LIKE '%$search_title%'    ";
  if($search_sender && str_contains(string_change_case(__('nobleme'), 'lowercase'), string_change_case($search_sender, 'lowercase')))
    $qmessages .= " AND       ( users_private_messages.fk_users_sender                 = 0
                    OR          users_sender.username                               LIKE '%$search_sender%' ) ";
  else if($search_sender)
    $qmessages .= " AND         users_sender.username                               LIKE '%$search_sender%'   ";
  if($search_date)
    $qmessages .= " AND         YEAR(FROM_UNIXTIME(users_private_messages.sent_at))    = '$search_date'       ";
  if($search_read == -1)
    $qmessages .= " AND         users_private_messages.read_at                         = 0                    ";
  else if($search_read)
    $qmessages .= " AND         users_private_messages.read_at                         > 0                    ";

  // Sort the data as requested
  if($sort_by == 'title')
    $qmessages .= " ORDER BY  users_private_messages.title            ASC   ,
                              users_private_messages.sent_at          DESC  ";
  else if($sort_by == 'sender')
    $qmessages .= " ORDER BY  users_private_messages.fk_users_sender  = 0   ,
                              users_sender.username                   ASC   ,
                              users_private_messages.sent_at          DESC  ";
  else if($sort_by == 'rsent')
    $qmessages .= " ORDER BY  users_private_messages.sent_at          ASC   ";
  else if($sort_by == 'read')
    $qmessages .= " ORDER BY  users_private_messages.read_at          != 0  ,
                              users_private_messages.read_at          DESC  ";
  else
    $qmessages .= " ORDER BY  users_private_messages.sent_at          DESC  ";

  // Execute the query
  $qmessages = query($qmessages);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmessages); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['pm_id']);
    $data[$i]['title']      = sanitize_output($row['pm_title']);
    $data[$i]['body']       = bbcodes(sanitize_output(string_truncate($row['pm_body'], 400, ' [...]'), 1));
    $data[$i]['system']     = (!$row['us_id']);
    $data[$i]['sender_id']  = sanitize_output($row['us_id']);
    $data[$i]['sender']     = sanitize_output($row['us_nick']);
    $data[$i]['sent']       = sanitize_output(time_since($row['pm_sent']));
    $data[$i]['fsent']      = sanitize_output(date_to_text($row['pm_sent'], 0, 2));
    $data[$i]['read']       = ($row['pm_read']) ? sanitize_output(time_since($row['pm_read'])) : '-';
    $data[$i]['fread']      = ($row['pm_read']) ? sanitize_output(date_to_text($row['pm_sent'], 0, 2)) : NULL;
    $data[$i]['css']        = ($row['pm_read']) ? '' : ' bold glow text_red';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/messages.act.php', 'function' => 'private_messages_list', 'data' => $data));

  // Return the prepared data
  return $data;
}




/**
 * Fetches all years during which the current user got private messages.
 *
 * @return  array   The data, ready for use.
 */

function private_message_years_list() : array
{
  // Require users to be logged in to run this action
  user_restrict_to_users();

  // Fetch the user's id
  $user_id = sanitize(user_get_id(), 'int', 1);

  // Fetch the years during which the user got private messages
  $qyears = query(" SELECT    YEAR(FROM_UNIXTIME(users_private_messages.sent_at)) AS 'pm_year'
                    FROM      users_private_messages
                    WHERE     users_private_messages.fk_users_recipient = '$user_id'
                    GROUP BY  YEAR(FROM_UNIXTIME(users_private_messages.sent_at))
                    ORDER BY  YEAR(FROM_UNIXTIME(users_private_messages.sent_at)) DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qyears); $i++)
    $data[$i]['year'] = sanitize_output($row['pm_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/messages.act.php', 'function' => 'private_messages_years_list', 'data' => $data));

  // Return the prepared data
  return $data;
}




/**
 * Fetches information about a private message.
 *
 * @param   int     $message_id   The private message's ID.
 *
 * @return  array                 An array of data regarding the ban.
 */

function private_message_get( int $message_id ) : array
{
  // Require the user the be logged in
  user_restrict_to_users();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');
  require_included_file('messages.lang.php');

  // Sanitize the user and message ID
  $user_id    = sanitize(user_get_id(), 'int', 0);
  $message_id = sanitize($message_id, 'int', 0);

  // Error: Message ID not found
  if(!database_row_exists('users_private_messages', $message_id))
  {
    $data['error'] = __('users_message_not_found');
    return $data;
  }

  // Prepare the query to fetch the message's data
  $qmessage = " SELECT    users_private_messages.deleted_by_recipient AS 'pm_deleted'   ,
                          users_private_messages.fk_users_recipient   AS 'pm_recipient' ,
                          users_private_messages.fk_users_sender      AS 'pm_sender_id' ,
                          users_sender.username                       AS 'pm_sender'    ,
                          users_private_messages.sent_at              AS 'pm_sent'      ,
                          users_private_messages.read_at              AS 'pm_read'      ,
                          users_private_messages.title                AS 'pm_title'     ,
                          users_private_messages.body                 AS 'pm_body'
                FROM      users_private_messages
                LEFT JOIN users AS users_sender ON users_private_messages.fk_users_sender = users_sender.id
                WHERE     users_private_messages.id = '$message_id' ";

  // Fetch data regarding the message
  $dmessage = mysqli_fetch_array(query($qmessage));

  // Error: Deleted messages
  if($dmessage['pm_deleted'])
  {
    $data['error'] = __('users_message_deleted');
    return $data;
  }

  // Error: Message not found
  if($dmessage['pm_recipient'] != $user_id)
  {
    $data['error'] = __('users_message_neighbor');
    return $data;
  }

  // Prepare the data
  $data['id']         = sanitize_output($message_id);
  $data['title']      = sanitize_output($dmessage['pm_title']);
  $data['sender_id']  = sanitize_output($dmessage['pm_sender_id']);
  $data['sender']     = ($dmessage['pm_sender_id']) ? sanitize_output($dmessage['pm_sender']) : NULL;
  $data['sent_at']    = sanitize_output(date_to_text($dmessage['pm_sent'], 0, 2));
  $data['read_at']    = ($dmessage['pm_read']) ? sanitize_output(date_to_text($dmessage['pm_read'], 0, 2)) : NULL;
  $data['body']       = bbcodes(sanitize_output($dmessage['pm_body'], true));

  // Mark the message as read if it was previously unread
  if(!$dmessage['pm_read'])
  {
    $timestamp = sanitize(time(), 'int', 0);
    query(" UPDATE  users_private_messages
            SET     users_private_messages.read_at  = '$timestamp'
            WHERE   users_private_messages.id       = '$message_id' ");
  }

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/messages.act.php', 'function' => 'private_message_get', 'data' => $data));

  // Return the data
  return $data;
}




/**
 * Deletes a private message.
 *
 * @param   int         $message_id   The private message's id
 *
 * @return  string|null               An error string, or NULL if all went well.
 */

function users_message_delete( int $message_id ) : mixed
{
  // Require users to be logged in to run this action
  user_restrict_to_users();

  // Sanitize the data
  $user_id    = sanitize(user_get_id(), 'int', 1);
  $message_id = sanitize($message_id, 'int', 0);
  $timestamp  = time();

  // Error: Message ID not found
  if(!database_row_exists('users_private_messages', $message_id))
    return __('users_message_not_found');

  // Fetch some data regarding the message
  $dmessage = mysqli_fetch_array(query("  SELECT  users_private_messages.deleted_by_recipient AS 'pm_deleted_r' ,
                                                  users_private_messages.deleted_by_sender    AS 'pm_deleted_s' ,
                                                  users_private_messages.fk_users_recipient   AS 'pm_recipient'
                                          FROM    users_private_messages
                                          WHERE   users_private_messages.id = '$message_id' "));

  // Error: Message is already deleted
  if($dmessage['pm_deleted_r'])
    return __('users_message_predeleted');

  // Error: Message does not belong to user
  if($dmessage['pm_recipient'] != $user_id)
    return __('users_message_ownership');

  // If the sender had already deleted the message, hard delete it
  if($dmessage['pm_deleted_s'])
    query(" DELETE FROM users_private_messages
            WHERE       users_private_messages.id = '$message_id' ");

  // Otherwise soft delete it
  else
    query(" UPDATE  users_private_messages
            SET     users_private_messages.deleted_by_recipient = 1 ,
                    users_private_messages.read_at              = '$timestamp'
            WHERE   users_private_messages.id = '$message_id' ");

  // All went well, return NULL
  return NULL;
}