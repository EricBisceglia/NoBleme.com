<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_channels_list                   Returns a list of IRC channels.                                              */
/*                                                                                                                   */
/*  irc_channels_type_get               Fetches data related to a channel type.                                      */
/*                                                                                                                   */
/*  irc_bot_start                       Starts the IRC bot.                                                          */
/*  irc_bot_stop                        Stops the IRC bot.                                                           */
/*                                                                                                                   */
/*  irc_bot_toggle_silence_mode         Toggles the silent IRC bot mode on and off.                                  */
/*                                                                                                                   */
/*  irc_bot_admin_send_message          Sends a message through the IRC bot from the admin interface.                */
/*                                                                                                                   */
/*  irc_bot_message_queue_list          Fetches the queue of messages that have not been sent yet by the IRC bot.    */
/*  irc_bot_message_queue_delete        Purges a message from the IRC bot's upcoming message queue.                  */
/*                                                                                                                   */
/*  irc_bot_message_history_list        Fetches the history of past messages sent by the IRC bot.                    */
/*  irc_bot_message_history_replay      Replays an entry from the IRC bot's message history.                         */
/*  irc_bot_message_history_delete      Deletes an entry from the IRC bot's message history.                         */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns a list of IRC channels.
 *
 * @return  array   An array containing IRC channels.
 */

function irc_channels_list() : array
{
  // Check if the required files have been included
  require_included_file('irc.lang.php');

  // Fetch the user's language
  $lang = user_get_language();

  // Fetch the IRC channels
  $qchannels = query("  SELECT    irc_channels.id             AS 'c_id'       ,
                                  irc_channels.name           AS 'c_name'     ,
                                  irc_channels.channel_type   AS 'c_type'     ,
                                  irc_channels.languages      AS 'c_lang'     ,
                                  irc_channels.description_en AS 'c_desc_en'  ,
                                  irc_channels.description_fr AS 'c_desc_fr'
                        FROM      irc_channels
                        ORDER BY  irc_channels.channel_type DESC  ,
                                  irc_channels.name         ASC   ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qchannels); $i++)
  {
    $data[$i]['id']       = $row['c_id'];
    $data[$i]['name']     = sanitize_output($row['c_name']);
    $temp                 = irc_channels_type_get($row['c_type']);
    $data[$i]['type']     = sanitize_output($temp['name']);
    $data[$i]['type_css'] = sanitize_output($temp['css']);
    $data[$i]['lang_en']  = str_contains($row['c_lang'], 'EN');
    $data[$i]['lang_fr']  = str_contains($row['c_lang'], 'FR');
    $temp                 = ($lang == 'EN') ? $row['c_desc_en'] : $row['c_desc_fr'];
    $data[$i]['desc']     = sanitize_output($temp);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches data related to a channel type.
 *
 * @param   int     $type_id  The channel type's id.
 *
 * @return  array             An array containing data for that channel type.
 */

function irc_channels_type_get( int $type_id ) : array
{
  // Check if the required files have been included
  require_included_file('irc.lang.php');

  // Fetch the user's language
  $lang = user_get_language();

  // Channel type description
  if($lang == 'EN')
  {
    $data['name'] = match($type_id)
    {
      3         => 'Main'       ,
      2         => 'Major'      ,
      1         => 'Minor'      ,
      default   => 'Automated'  ,
    };
  }
  else
  {
    $data['name'] = match($type_id)
    {
      3         => 'Principal'  ,
      2         => 'Majeur'     ,
      1         => 'Mineur'     ,
      default   => 'Automatisé' ,
    };
  }

  // Channel type CSS
  $data['css'] = match($type_id)
  {
    3         => ' bold smallglow'  ,
    2         => ' bold'            ,
    1         => ''                 ,
    default   => ' italics'         ,
  };

  // Return the data
  return $data;
}




/**
 * Starts the IRC bot.
 *
 * @return  string|void   A string if an error happened, nothing if the loop is running as intended.
 */

function irc_bot_start() : string
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('irc.lang.php');

  // Write a log in the database
  $timestamp = sanitize(time(), 'int', 0);
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at    = '$timestamp'              ,
                      logs_irc_bot.body       = '** Starting IRC bot **'  ,
                      logs_irc_bot.is_manual  = 1                         ,
                      logs_irc_bot.is_action  = 1                         ");

  // Bot settings
  $path             = root_path();
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
 * @return  void
 */

function irc_bot_stop() : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

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
 * @param   bool  $is_silent  The current status of silent mode.
 *
 * @return  bool              The new status of silent mode.
 */

function irc_bot_toggle_silence_mode( bool $is_silent ) : bool
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Decide which mode to toggle to
  $is_silent = ($is_silent) ? 0 : 1;

  // Update the system variable
  system_variable_update('irc_bot_is_silenced', $is_silent, 'int');

  // Write a log in the database
  $timestamp    = sanitize(time(), 'int', 0);
  $silenced_log = ($is_silent) ? '** Silencing IRC bot **' : '** Unsilencing IRC bot **';
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at    = '$timestamp'    ,
                      logs_irc_bot.body       = '$silenced_log' ,
                      logs_irc_bot.is_manual  = 1               ,
                      logs_irc_bot.is_action  = 1               ");

  // Return the new value of silent mode
  return $is_silent;
}




/**
 * Sends a message through the IRC bot from the admin interface.
 *
 * @param   string  $body                 The message to send on IRC.
 * @param   string  $channel  (OPTIONAL)  If the string isn't empty, send the message to a channel instead.
 * @param   string  $user     (OPTIONAL)  If the string isn't empty, send the message to a user instead.
 *
 * @return  void
 */

function irc_bot_admin_send_message(  string  $body           ,
                                      string  $channel  = ''  ,
                                      string  $user     = ''  ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Stop here if there is no message to send
  if(!$body)
    return;

  // If a user is specified, prepend a PRIVMSG to the body
  if($user)
    $body = 'PRIVMSG '.$user.' :'.$body;

  // If a channel is specified, ensure it begins with a hash then prepend a PRIVMSG to the body
  else if($channel)
  {
    if($channel && (substr($channel, 0, 1) != '#'))
      $channel = '#'.$channel;
    $body = 'PRIVMSG '.$channel.' :'.$body;
  }

  // Send the message
  irc_bot_send_message($body, '', 1, 1);
}




/**
 * Fetches the queue of messages that have not been sent yet by the IRC bot.
 *
 * @return  array   An array containing the formatted backlog of queued messages.
 */

function irc_bot_message_queue_list() : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('irc.lang.php');

  // Assemble the path to the bot's txt file
  $path         = root_path();
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

  // Return the prepared data
  return $data;
}




/**
 * Purges a message from the IRC bot's upcoming message queue.
 *
 * @param   int         $line_id  The line number that must be purged - whole file if this is set to -1.
 *
 * @return  string|null           A string in case of error, or NULL if all went well.
 */

function irc_bot_message_queue_delete( int $line_id ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('irc.lang.php');

  // Ensure the line id is an int
  $line_id = sanitize($line_id, 'int', -1);

  // Assemble the path to the bot's txt file
  $path         = root_path();
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

  // All went well, return NULL
  return NULL;
}




/**
 * Fetches the history of past messages sent by the IRC bot.
 *
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         An array containing the message history.
 */

function irc_bot_message_history_list( array $search = array() ) : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('irc.lang.php');
  require_included_file('functions_time.inc.php');

  // Sanitize the search parameters
  $search_channel = isset($search['channel']) ? sanitize($search['channel'], 'string')  : NULL;
  $search_body    = isset($search['message']) ? sanitize($search['message'], 'string')  : NULL;
  $search_errors  = isset($search['sent'])    ? sanitize($search['sent'], 'int', -1, 1) : -1;

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

  // Return the prepared data
  return $data;
}




/**
 * Replays an entry from the IRC bot's message history.
 *
 * @param   int   $log_id   The ID of the history log to replay.
 *
 * @return  void
 */

function irc_bot_message_history_replay( int $log_id ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

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
  irc_bot_send_message($dlog['il_body'], $channel, 1, 1);

  // Update the log now that it has been sent (if there's still an error, it will appear in the replayed log instead)
  query(" UPDATE  logs_irc_bot
          SET     logs_irc_bot.is_silenced  = 0 ,
                  logs_irc_bot.is_failed    = 0
          WHERE   logs_irc_bot.id           = '$log_id' ");
}




/**
 * Deletes an entry from the IRC bot's message history.
 *
 * @param   int   $log_id   The ID of the history log to delete.
 *
 * @return  void
 */

function irc_bot_message_history_delete( int $log_id ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the log id
  $log_id = sanitize($log_id, 'int', 0);

  // Delete the log
  query(" DELETE FROM logs_irc_bot
          WHERE       logs_irc_bot.id = '$log_id' ");
}