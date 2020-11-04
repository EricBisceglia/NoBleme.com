<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_bot_start                         Starts the IRC bot.                                                        */
/*  irc_bot_stop                          Stops the IRC bot.                                                         */
/*                                                                                                                   */
/*  irc_bot_toggle_silence_mode           Toggles the silent IRC bot mode on and off.                                */
/*                                                                                                                   */
/*  irc_bot_admin_send_message            Sends a message through the IRC bot from the admin interface.              */
/*                                                                                                                   */
/*  irc_bot_get_message_queue             Fetches the queue of messages that have not been sent yet by the IRC bot.  */
/*  irc_bot_purge_queued_message          Purges a message from the IRC bot's upcoming message queue.                */
/*                                                                                                                   */
/*  irc_bot_get_message_history           Fetches the history of past messages sent by the IRC bot.                  */
/*  irc_bot_replay_message_history_entry  Replays an entry from the IRC bot's message history.                       */
/*  irc_bot_delete_message_history_entry  Deletes an entry from the IRC bot's message history.                       */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Starts the IRC bot.
 *
 * @param   string|null   $path (OPTIONAL)  The path to the root of the website.
 * @param   string|null   $lang (OPTIONAL)  The user's current language.
 *
 * @return  string|null                     A string if an error happened, nothing if the loop is running as intended.
 */

function irc_bot_start( $path = './../../'  ,
                        $lang = 'EN'        )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Write a log in the database
  $timestamp = sanitize(time(), 'int', 0);
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at    = '$timestamp'              ,
                      logs_irc_bot.body       = '** Starting IRC bot **'  ,
                      logs_irc_bot.is_manual  = 1                         ,
                      logs_irc_bot.is_action  = 1                         ");

  // Bot settings
  $irc_bot_file     = $path.$GLOBALS['irc_bot_file_name'];
  $irc_bot_server   = $GLOBALS['irc_bot_server'];
  $irc_bot_port     = $GLOBALS['irc_bot_port'];
  $irc_bot_channels = $GLOBALS['irc_bot_channels'];
  $irc_bot_nickname = $GLOBALS['irc_bot_nickname'];
  $irc_bot_password = $GLOBALS['irc_bot_password'];

  // Don't run the bot if it is disabled
  if(!$GLOBALS['enable_irc_bot'])
    return __('irc_bot_start_disabled');

  // Check if the file used by the bot exists
  if(!file_exists($irc_bot_file))
    return __('irc_bot_start_no_file');

  // Open the IRC socket
  if(!$irc_socket = fsockopen($irc_bot_server, $irc_bot_port))
    return __('irc_bot_start_failed');

  // Remove the time limit so that the script can run forever
  set_time_limit(0);

  // Declare the USER and change the bot's nickname
  fputs($irc_socket, "USER $irc_bot_nickname $irc_bot_nickname $irc_bot_nickname $irc_bot_nickname :$irc_bot_nickname\r\n");
  fputs($irc_socket, "NICK $irc_bot_nickname\r\n");

  // The server will ask for a PING reply, fetch the pings and PONG them back
  $irc_ping = fgets($irc_socket);
  $irc_ping = fgets($irc_socket);
  $irc_ping = fgets($irc_socket);
  fputs($irc_socket, str_replace('PING', 'PONG', $irc_ping)."\r\n");

  // Identify as the bot
  fputs($irc_socket, "NickServ IDENTIFY $irc_bot_nickname $irc_bot_password\r\n");

  // Once the PONG gets accepted, send the request to join the channels
  foreach($irc_bot_channels AS $irc_bot_channel)
    fputs($irc_socket, "JOIN #".$irc_bot_channel."\r\n");

  // Reset the bot's file reading pointer before entering the loop
  $latest_message = file_get_contents($irc_bot_file);

  // The bot will run in this infinite loop
  while(1)
  {
    // Quirk of PHP, if we don't set this constantly the script might hang
    stream_set_timeout($irc_socket, 1);

    // Check for a PING
    while (($irc_socket_contents = fgets($irc_socket, 512)) !== false)
    {
      flush();
      $irc_ping = explode(' ', $irc_socket_contents);

      // If a PING is found, reply with the appropriate PONG
      if($irc_ping[0] == 'PING')
        fputs($irc_socket,"PONG ".$irc_ping[1]."\r\n");
    }

    // Kill the bot in dramatic fashion if its txt file is gone
    if(!file_exists($irc_bot_file))
    {
      fputs($irc_socket,"QUIT :My life-file is gone, so shall I leave\r\n");
      exit();
    }

    // Check the bot's txt file for an order to quit
    if(substr(file_get_contents($irc_bot_file),0,4) == 'quit' || substr(file_get_contents($irc_bot_file),11,4) == 'quit')
    {
      fputs($irc_socket,"QUIT :Getting terminated... I'll be back\r\n");
      exit();
    }

    // Check if the bot's txt file has changed
    if($latest_message != file_get_contents($irc_bot_file))
    {
      // Update the status of the loop
      $latest_message = file_get_contents($irc_bot_file);

      // Send the first line of the bot's txt file on IRC
      $irc_bot_file_contents  = fopen($irc_bot_file, 'r');
      $irc_bot_pointer_line   = fgets($irc_bot_file_contents);
      fputs($irc_socket, substr($irc_bot_pointer_line, 11).PHP_EOL);
      fclose($irc_bot_file_contents);

      // Delete the first line of the bot's txt file
      $irc_bot_file_data = file($irc_bot_file, FILE_IGNORE_NEW_LINES);
      array_shift($irc_bot_file_data);
      file_put_contents($irc_bot_file, implode("\r\n", $irc_bot_file_data));
    }

    // Avoid a potential exponential memory leak by flushing the buffer then manually triggering garbage collection
    flush();
    gc_collect_cycles();
  }
}




/**
 * Stops the IRC bot.
 *
 * @param   string|null   $lang   (OPTIONAL)  The user's current language.
 *
 * @return  void
 */

function irc_bot_stop( $lang = 'EN' )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Execute order 66
  irc_bot_send_message('quit');

  // Write a log in the database
  $timestamp = sanitize(time(), 'int', 0);
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at    = '$timestamp'              ,
                      logs_irc_bot.body       = '** Stopping IRC bot **'  ,
                      logs_irc_bot.is_manual  = 1                         ,
                      logs_irc_bot.is_action  = 1                         ");
}




/**
 * Toggles the silent IRC bot mode on and off.
 *
 * @param   bool          $silenced             The current status of silent mode.
 * @param   string|null   $lang     (OPTIONAL)  The user's current language.
 *
 * @return  bool                                The new status of silent mode.
 */

function irc_bot_toggle_silence_mode( $silenced         ,
                                      $lang     = 'EN'  )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Decide which mode to toggle to
  $silenced = ($silenced) ? 0 : 1;

  // Update the system variable
  system_variable_update('irc_bot_is_silenced', $silenced, 'int');

  // Write a log in the database
  $timestamp    = sanitize(time(), 'int', 0);
  $silenced_log = ($silenced) ? '** Silencing IRC bot **' : '** Unsilencing IRC bot **';
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at    = '$timestamp'    ,
                      logs_irc_bot.body       = '$silenced_log' ,
                      logs_irc_bot.is_manual  = 1               ,
                      logs_irc_bot.is_action  = 1               ");

  // Return the new value of silent mode
  return $silenced;
}




/**
 * Sends a message through the IRC bot from the admin interface.
 *
 * @param   string        $body                 The message to send on IRC.
 * @param   string|null   $channel  (OPTIONAL)  If the string isn't empty, send the message to a channel instead.
 * @param   string|null   $user     (OPTIONAL)  If the string isn't empty, send the message to a user instead.
 * @param   string|null   $path     (OPTIONAL)  The path to the root of the website.
 * @param   string|null   $lang     (OPTIONAL)  The user's current language.
 *
 * @return  void
 */

function irc_bot_admin_send_message(  $body                   ,
                                      $channel  = ''          ,
                                      $user     = ''          ,
                                      $path     = './../../'  ,
                                      $lang     = 'EN'        )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Stop here if there is no message to send
  if(!$body)
    return;

  // If an user is specified, prepend a PRIVMSG to the body
  if($user)
    $body = 'PRIVMSG '.$user.' :'.$body;

  // If a channel is specified, ensure it begins with a hash then prepend a PRIVMSG to the body
  else if($channel)
  {
    if($channel && (substr($channel, 0, 1) != '#'))
      $channel = '#'.$channel;
    $body = 'PRIVMSG '.$channel.' :'.$body;
  }

  irc_bot_send_message($body, '', $path, 1, 1);
}




/**
 * Fetches the queue of messages that have not been sent yet by the IRC bot.
 *
 * @param   string|null $path (OPTIONAL)  The path to the root of the website.
 *
 * @return  array                         An array containing the log of queued messages.
 */

function irc_bot_get_message_queue($path = './../../')
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Assemble the path to the bot's txt file
  $irc_bot_file = $path.$GLOBALS['irc_bot_file_name'];

  // Check if the file used by the bot exists
  if(!file_exists($irc_bot_file))
    return __('irc_bot_start_no_file');

  // Fetch the contents of the bot's txt file
  $file_contents = fopen($irc_bot_file, "r");

  // Read the file line by line
  for($i = 0; !feof($file_contents); $i++)
    $data[$i]['line'] = sanitize_output(substr(fgets($file_contents),11)).'<br>';

  // Close the file
  fclose($file_contents);

  // Add the number of lines to the data (minus one for the empty line at end of file)
  $data['line_count'] = $i - 1;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('dev.act.php', 'irc_bot_get_message_queue', $data));

  // Return the prepared data
  return $data;
}




/**
 * Purges a message from the IRC bot's upcoming message queue.
 *
 * @param   int           $line_id              The line number that must be purged - whole file if this is set to -1.
 * @param   string|null   $path     (OPTIONAL)  The path to the root of the website.
 * @param   string|null   $lang     (OPTIONAL)  The user's current language.
 *
 * @return  void
 */

function irc_bot_purge_queued_message(  $line_id                ,
                                        $path     = './../../'  ,
                                        $lang     = 'EN'        )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Ensure the line id is an int
  $line_id = sanitize($line_id, 'int', -1);

  // Assemble the path to the bot's txt file
  $irc_bot_file = $path.$GLOBALS['irc_bot_file_name'];

  // Check if the file used by the bot exists
  if(!file_exists($irc_bot_file))
    return __('irc_bot_start_no_file');

  // Purge the whole file if requested
  if($line_id < 0)
  {
    // Open the file
    $file_contents = fopen($irc_bot_file, "r+");

    // Purge the file
    ftruncate($file_contents, 0);

    // Close the file
    fclose($file_contents);
  }

  // Otherwise purge a single line from the file
  else
  {
    // Place the file's contents into an array
    $file_contents = file($irc_bot_file);

    // Check if the requested line exists
    if(isset($file_contents[$line_id]))
    {
      // Delete the line
      unset($file_contents[$line_id]);

      // Save the file with the deleted line
      file_put_contents($irc_bot_file, implode("", $file_contents));
    }
  }
}




/**
 * Fetches the history of past messages sent by the IRC bot.
 *
 * @param   string|null   $search_channel (OPTIONAL)  Search messages sent on a specific channel.
 * @param   string|null   $search_body    (OPTIONAL)  Search messages containing a specific body.
 * @param   bool|null     $search_errors  (OPTIONAL)  Search for sent (0) or failed (1) messages only.
 *
 * @return  array An array containing the message history.
 */

function irc_bot_get_message_history( $search_channel = NULL  ,
                                      $search_body    = NULL  ,
                                      $search_errors  = -1    )
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');
  require_included_file('functions_time.inc.php');

  // Sanitize the search queries
  $search_channel = sanitize($search_channel, 'string');
  $search_body    = sanitize($search_body, 'string');
  $search_errors  = sanitize($search_errors, 'int', -1, 1);

  // Prepare the search string
  $search = " WHERE 1=1 ";
  if(strpos($search_channel, '-') !== false)
    $search .= "  AND logs_irc_bot.is_manual    =     1 ";
  else if($search_channel)
    $search .= "  AND logs_irc_bot.channel      LIKE  '%$search_channel%' ";
  if($search_body)
    $search .= "  AND logs_irc_bot.is_action    =     0
                  AND logs_irc_bot.body         LIKE  '%$search_body%' ";
  if($search_errors == 0)
    $search .= "  AND logs_irc_bot.is_action    =     0
                  AND logs_irc_bot.is_silenced  =     0
                  AND logs_irc_bot.is_failed    =     0 ";
  else if($search_errors == 1)
    $search .= "  AND ( logs_irc_bot.is_action  =     1
                  OR  logs_irc_bot.is_silenced  =     1
                  OR  logs_irc_bot.is_failed    =     1 ) ";

  // Fetch the message logs
  $qhistory = query(" SELECT    logs_irc_bot.id           AS 'li_id'        ,
                                logs_irc_bot.sent_at      AS 'li_date'      ,
                                logs_irc_bot.channel      AS 'li_channel'   ,
                                logs_irc_bot.body         AS 'li_body'      ,
                                logs_irc_bot.is_silenced  AS 'li_silenced'  ,
                                logs_irc_bot.is_failed    AS 'li_failed'    ,
                                logs_irc_bot.is_manual    AS 'li_manual'    ,
                                logs_irc_bot.is_action    AS 'li_action'
                      FROM      logs_irc_bot
                                $search
                      ORDER BY  logs_irc_bot.sent_at  DESC  ,
                                logs_irc_bot.id       DESC  ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qhistory); $i++)
  {
    $data[$i]['id']         = $row['li_id'];
    $data[$i]['date']       = sanitize_output(time_since($row['li_date']));
    $data[$i]['channel']    = ($row['li_manual']) ? __('irc_bot_history_nochan') : sanitize_output($row['li_channel']);
    $data[$i]['body']       = sanitize_output($row['li_body']);
    $data[$i]['body_js']    = sanitize_output_javascript($row['li_body']);
    $temp                   = ($row['li_silenced']) ? __('irc_bot_history_silenced') : '';
    $temp                   = ($row['li_failed']) ? __('irc_bot_history_failed') : $temp;
    $data[$i]['failed']     = ($row['li_silenced'] || $row['li_failed']) ? $temp : '';
    $data[$i]['failed_css'] = ($data[$i]['failed']) ? ' text_red bold' : '';
    $data[$i]['action']     = $row['li_action'];
  }

  // Add the number of lines to the data
  $data['line_count'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('dev.act.php', 'irc_bot_get_message_history', $data));

  // Return the prepared data
  return $data;
}




/**
 * Replays an entry from the IRC bot's message history.
 *
 * @param   int         $log_id   The ID of the history log to replay.
 * @param   string|null $path     The path to the root of the website.
 * @param   string|null   $lang   (OPTIONAL)  The user's current language.
 *
 * @return  void
 */

function irc_bot_replay_message_history_entry(  $log_id               ,
                                                $path   = './../../'  ,
                                                $lang   = 'EN'        )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Sanitize the log id
  $log_id = sanitize($log_id, 'int', 0);

  // Fetch the data we need to replay the log
  $dlog = mysqli_fetch_array(query("  SELECT  logs_irc_bot.channel  AS 'il_channel' ,
                                              logs_irc_bot.body     AS 'il_body'
                                      FROM    logs_irc_bot
                                      WHERE   logs_irc_bot.id = '$log_id' "));

  // Strip the hash from the start of the  channel name
  $channel = $dlog['il_channel'];
  if($channel && (substr($channel, 0, 1) == '#'))
    $channel = substr($channel, 1);

  // Replay the message and bypass silenced mode
  irc_bot_send_message($dlog['il_body'], $channel, $path, 1, 1);

  // Update the log now that it has been sent (if there's still an error, it will appear in the replayed log instead)
  query(" UPDATE  logs_irc_bot
          SET     logs_irc_bot.is_silenced  = 0 ,
                  logs_irc_bot.is_failed    = 0
          WHERE   logs_irc_bot.id           = '$log_id' ");
}




/**
 * Deletes an entry from the IRC bot's message history.
 *
 * @param   int           $log_id             The ID of the history log to delete.
 * @param   string|null   $lang   (OPTIONAL)  The user's current language.
 *
 * @return  void
 */

function irc_bot_delete_message_history_entry(  $log_id         ,
                                                $lang   = 'EN'  )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators($lang);

  // Sanitize the log id
  $log_id = sanitize($log_id, 'int', 0);

  // Delete the log
  query(" DELETE FROM logs_irc_bot
          WHERE       logs_irc_bot.id = '$log_id' ");
}