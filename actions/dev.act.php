<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CLOSE THE WEBSITE                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Toggles the website's status between open and closed.
 *
 * @param   int   $website_status Whether an update is currently in progress
 *
 * @return  void
 */

function dev_toggle_website_status($website_status)
{
  // Sanitize the data
  $website_status = sanitize($website_status, 'int', 0, 1);

  // Determine the required new value
  $new_status = ($website_status) ? 0 : 1;

  // Toggle the website status
  system_variable_update('update_in_progress', $new_status, 'int');
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  VERSION NUMBERS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns elements related to a version number.
 *
 * @param   int         $version_id The version number's id.
 *
 * @return  array|null              An array containing elements related to the version, or NULL if it does not exist.
 */

function dev_versions_list_one($version_id)
{
  // Sanitize the id
  $version_id = sanitize($version_id, 'int', 0);

  // Check if the version exists
  if(!database_row_exists('system_versions', $version_id))
    return NULL;

  // Fetch the data
  $dversions = mysqli_fetch_array(query(" SELECT    system_versions.major         AS 'v_major'      ,
                                                    system_versions.minor         AS 'v_minor'      ,
                                                    system_versions.patch         AS 'v_patch'      ,
                                                    system_versions.extension     AS 'v_extension'  ,
                                                    system_versions.release_date  AS 'v_date'
                                          FROM      system_versions
                                          WHERE     system_versions.id = '$version_id' "));

  // Assemble an array with the data
  $data['major']        = sanitize_output($dversions['v_major']);
  $data['minor']        = sanitize_output($dversions['v_minor']);
  $data['patch']        = sanitize_output($dversions['v_patch']);
  $data['extension']    = sanitize_output($dversions['v_extension']);
  $data['release_date'] = sanitize_output(date_to_ddmmyy($dversions['v_date']));

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('dev.act.php', 'dev_versions_list', $data));

  // Return the array
  return $data;
}




/**
 * Returns the website's version numbering history.
 *
 * @return  array   An array containing past version numbers, sorted in reverse chronological order by date.
 */

function dev_versions_list()
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Fetch all versions
  $qversions = query("  SELECT    system_versions.id            AS 'v_id'         ,
                                  system_versions.major         AS 'v_major'      ,
                                  system_versions.minor         AS 'v_minor'      ,
                                  system_versions.patch         AS 'v_patch'      ,
                                  system_versions.extension     AS 'v_extension'  ,
                                  system_versions.release_date  AS 'v_date'
                        FROM      system_versions
                        ORDER BY  system_versions.release_date  DESC  ,
                                  system_versions.id            DESC  ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qversions); $i++)
  {
    $data[$i]['id']         = $row['v_id'];
    $data[$i]['version']    = sanitize_output(system_assemble_version_number($row['v_major'], $row['v_minor'], $row['v_patch'], $row['v_extension']));
    $data[$i]['date_raw']   = $row['v_date'];
    $data[$i]['date']       = sanitize_output(date_to_text($row['v_date'], 1));
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Calculate the date differences
  for($i = 0 ; $i < $data['rows']; $i++)
  {
    // If it is the oldest version, there is no possible differential
    if($i == ($data['rows'] - 1))
    {
      $data[$i]['date_diff']  = '-';
      $data[$i]['css']        = '';
    }

    // Otherwise, calculate the time differential
    else
    {
      $temp_diff = time_days_elapsed($data[$i]['date_raw'], $data[$i + 1]['date_raw']);

      // Assemble the formatted string
      $data[$i]['date_diff'] = ($temp_diff) ? sanitize_output($temp_diff.__('day', $temp_diff, 1)) : '-';

      // Give stylings to long delays
      $temp_style       = ($temp_diff > 90) ? ' class="smallglow"' : '';
      $data[$i]['css']  = ($temp_diff > 365) ? ' class="bold glow"' : $temp_style;
    }
  }

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('dev.act.php', 'dev_versions_list', $data));

  // Return the prepared data
  return $data;
}




/**
 * Releases a new version of the website.
 *
 * The version number will respect the SemVer v2.0.0 standard.
 *
 * @param   int       $major            The major version number.
 * @param   int       $minor            The minor version number.
 * @param   int       $patch            The patch number.
 * @param   string    $extension        The extension string (eg. beta, rc-1, etc.).
 * @param   bool|null $publish_activity Whether to publish an entry in recent activity.
 * @param   bool|null $notify_irc       Whether to send a notification on IRC.
 *
 * @return  string|null                 NULL if all went according to plan, or an error string
 */

function dev_versions_create( $major                ,
                              $minor                ,
                              $patch                ,
                              $extension            ,
                              $publish_activity = 1 ,
                              $notify_irc       = 0 )
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Sanitize the data
  $major            = sanitize($major, 'int', 0);
  $minor            = sanitize($minor, 'int', 0);
  $patch            = sanitize($patch, 'int', 0);
  $extension        = sanitize($extension, 'string');
  $publish_activity = sanitize($publish_activity, 'int', 0, 1);
  $notify_irc       = sanitize($notify_irc, 'int', 0, 1);
  $current_date     = sanitize(date('Y-m-d'), 'string');

  // Check if the version number already exists
  $qversion = query(" SELECT  system_versions.id AS 'v_id'
                      FROM    system_versions
                      WHERE   system_versions.major     =     '$major'
                      AND     system_versions.minor     =     '$minor'
                      AND     system_versions.patch     =     '$patch'
                      AND     system_versions.extension LIKE  '$extension' ");

  // If it already exists, stop the process
  if(mysqli_num_rows($qversion))
    return __('dev_versions_edit_error_duplicate');

  // Create the new version
  query(" INSERT INTO   system_versions
          SET           system_versions.major         = '$major'      ,
                        system_versions.minor         = '$minor'      ,
                        system_versions.patch         = '$patch'      ,
                        system_versions.extension     = '$extension'  ,
                        system_versions.release_date  = '$current_date' ");

  // Fetch the ID of the newly created version
  $version_id = sanitize(query_id(), 'int', 0);

  // Assemble the version number
  $version_number = system_assemble_version_number($major, $minor, $patch, $extension);

  // Log the activity
  if($publish_activity)
    log_activity('dev_version', 0, 'ENFR', $version_id, $version_number, $version_number);

  // Send a message on IRC
  if($notify_irc)
  irc_bot_send_message(chr(0x02).chr(0x03).'03'."A new version of NoBleme has been released: $version_number - ".$GLOBALS['website_url']."todo_link", "dev");

  // Return that all went well
  return;
}




/**
 * Edits an entry in the website's version numbering history.
 *
 * @param   int         $di           The version's id.
 * @param   int         $major        The major version number.
 * @param   int         $minor        The minor version number.
 * @param   int         $patch        The patch number.
 * @param   string      $extension    The extension string (eg. beta, rc-1, etc.).
 * @param   string      $release_date The version's release date.
 *
 * @return  string|null               NULL if all went according to plan, or an error string
 */

function dev_versions_edit( $id           ,
                            $major        ,
                            $minor        ,
                            $patch        ,
                            $extension    ,
                            $release_date )
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Sanitize the data
  $id            = sanitize($id, 'int', 0);
  $major         = sanitize($major, 'int', 0);
  $minor         = sanitize($minor, 'int', 0);
  $patch         = sanitize($patch, 'int', 0);
  $extension     = sanitize($extension, 'string');
  $release_date  = sanitize(date_to_mysql($release_date, date('Y-m-d')), 'string');

  // Check if the version exists
  if(!database_row_exists('system_versions', $id))
    return __('dev_versions_edit_error_id');

  // Check if the version number already exists
  $dversion = mysqli_fetch_array(query("  SELECT  system_versions.id AS 'v_id'
                                          FROM    system_versions
                                          WHERE   system_versions.major     =     '$major'
                                          AND     system_versions.minor     =     '$minor'
                                          AND     system_versions.patch     =     '$patch'
                                          AND     system_versions.extension LIKE  '$extension' "));

  // If it already exists (and isn't the current version), stop the process
  if($dversion['v_id'] && ($dversion['v_id'] != $id))
    return __('dev_versions_edit_error_duplicate');

  // Edit the version
  query(" UPDATE  system_versions
          SET     system_versions.major         = '$major'  ,
                  system_versions.minor         = '$minor'  ,
                  system_versions.patch         = '$patch'  ,
                  system_versions.extension     = '$extension'  ,
                  system_versions.release_date  = '$release_date'
          WHERE   system_versions.id            = '$id' ");

  // Return that all went well
  return;
}




/**
 * Deletes an entry in the website's version numbering history.
 *
 * @param   int         $version_id   The version number's id.
 *
 * @return  string|int                The version number, or 0 if the version does not exist.
 */

function dev_versions_delete($version_id)
{
  // Sanitize the data
  $version_id = sanitize($version_id, 'int', 0);

  // Ensure the version number exists or return 0
  if(!database_row_exists('system_versions', $version_id))
    return 0;

  // Fetch the version number
  $dversion = mysqli_fetch_array(query("  SELECT    system_versions.major     AS 'v_major'      ,
                                                    system_versions.minor     AS 'v_minor'      ,
                                                    system_versions.patch     AS 'v_patch'      ,
                                                    system_versions.extension AS 'v_extension'
                                          FROM      system_versions
                                          WHERE     system_versions.id = '$version_id' "));

  // Assemble the version number
  $version_number = system_assemble_version_number($dversion['v_major'], $dversion['v_minor'], $dversion['v_patch'], $dversion['v_extension']);

  // Delete the entry
  query(" DELETE FROM system_versions
          WHERE       system_versions.id = '$version_id' ");

  // Delete the related activity logs
  log_activity_delete('dev_version', 0, 0, NULL, $version_id);

  // Return the deleted version number
  return $version_number;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      IRC BOT                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Starts the IRC bot.
 *
 * @param   string|null $path (OPTIONAL)  The path to the root of the website.
 *
 * @return  string|null                   A string if an error happened, nothing if the loop is running as intended.
 */

function irc_bot_start($path = './../../')
{
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
 * @return  void
 */

function irc_bot_stop()
{
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
 * @param   bool  $silenced The current status of silent mode.
 *
 * @return  bool            The new status of silent mode.
 */

function irc_bot_toggle_silence_mode($silenced)
{
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
 * @param   string      $body                 The message to send on IRC.
 * @param   string|null $channel  (OPTIONAL)  If the string isn't empty, send the message to a channel instead.
 * @param   string|null $user     (OPTIONAL)  If the string isn't empty, send the message to a user instead.
 * @param   string|null $path     (OPTIONAL)  The path to the root of the website.
 *
 * @return  void
 */

function irc_bot_admin_send_message(  $body                   ,
                                      $channel  = ''          ,
                                      $user     = ''          ,
                                      $path     = './../../'  )
{
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
 * @param   int         $line_id          The line number that must be purged - or the whole file if this is set to -1.
 * @param   string|null $path (OPTIONAL)  The path to the root of the website.
 *
 * @return  void
 */

function irc_bot_purge_queued_message(  $line_id  ,
                                        $path     )
{
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
 *
 * @return  void
 */

function irc_bot_replay_message_history_entry(  $log_id               ,
                                                $path   = './../../'  )
{
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
 * @param   int   $log_id   The ID of the history log to delete.
 *
 * @return  void
 */

function irc_bot_delete_message_history_entry($log_id)
{
  // Sanitize the log id
  $log_id = sanitize($log_id, 'int', 0);

  // Delete the log
  query(" DELETE FROM logs_irc_bot
          WHERE       logs_irc_bot.id = '$log_id' ");
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   DOCUMENTATION                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Generates the source code of an icon, ready for pasting to the clipboard.
 *
 * @param   string      $name                 The name of the icon.
 * @param   string      $alt_text (OPTIONAL)  The alt text for the icon.
 * @param   string|null $size     (OPTIONAL)  The size of the icon ('normal', 'small').
 *
 * @return  string                            The source code ready to be sent to the clipboard.
 */

function dev_doc_icon_to_clipboard( $name                 ,
                                    $alt_text = 'X'       ,
                                    $size     = 'normal'  )
{
  // Prepare the data
  $class  = ($size == 'small') ? 'smallicon' : 'icon';
  $name   = ($size == 'small') ? $name.'_small' : $name;

  // Assemble the string
  $icon = sanitize_output_javascript('<img class="'.$class.' valign_middle" src="<?=$path?>img/icons/'.$name.'.svg" alt="'.$alt_text.'">');

  // Return the assembled string
  return $icon;
}