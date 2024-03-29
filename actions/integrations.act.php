<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  irc_channels_get                    Returns data regarder to an IRC channel.                                     */
/*  irc_channels_list                   Returns a list of IRC channels.                                              */
/*  irc_channels_add                    Creates a new entry in the IRC channel list.                                 */
/*  irc_channels_edit                   Modifies an existing IRC channel.                                            */
/*  irc_channels_delete                 Hard deletes an IRC channel.                                                 */
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
/*  discord_webhook_send_message        Sends a message through the Discord webhook from the admin interface.        */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to an IRC channel.
 *
 * @param   int         $channel_id   The channel's id.
 *
 * @return  array|null                An array containing related data, or null if it does not exist.
 */

function irc_channels_get( int $channel_id ) : mixed
{
  // Sanitize the data
  $channel_id = sanitize($channel_id, 'int', 0);

  // Check if the channel exists
  if(!database_row_exists('irc_channels', $channel_id))
    return NULL;

  // Fetch the data
  $dchannel = query(" SELECT  irc_channels.name           AS 'c_name'     ,
                              irc_channels.channel_type   AS 'c_type'     ,
                              irc_channels.languages      AS 'c_lang'     ,
                              irc_channels.description_en AS 'c_desc_en'  ,
                              irc_channels.description_fr AS 'c_desc_fr'
                      FROM    irc_channels
                      WHERE   irc_channels.id = '$channel_id' ",
                      fetch_row: true);

  // Assemble an array with the data
  $data['name']     = sanitize_output($dchannel['c_name']);
  $data['type']     = sanitize_output($dchannel['c_type']);
  $data['lang_en']  = str_contains($dchannel['c_lang'], 'EN');
  $data['lang_fr']  = str_contains($dchannel['c_lang'], 'FR');
  $data['desc_en']  = sanitize_output($dchannel['c_desc_en']);
  $data['desc_fr']  = sanitize_output($dchannel['c_desc_fr']);

  // Return the data
  return $data;
}




/**
 * Returns a list of IRC channels.
 *
 * @param   string  $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                         An array containing IRC channels.
 */

function irc_channels_list( string $format = 'html' ) : array
{
  // Check if the required files have been included
  require_included_file('integrations.lang.php');

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
  for($i = 0; $row = query_row($qchannels); $i++)
  {
    // Format the data
    $channel_id             = $row['c_id'];
    $channel_name           = $row['c_name'];
    $channel_type           = irc_channels_type_get($row['c_type']);
    $channel_languages      = $row['c_lang'];
    $channel_description    = ($lang === 'EN') ? $row['c_desc_en'] : $row['c_desc_fr'];
    $channel_description_en = $row['c_desc_en'];
    $channel_description_fr = $row['c_desc_fr'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']       = $channel_id;
      $data[$i]['name']     = sanitize_output($channel_name);
      $data[$i]['type']     = sanitize_output($channel_type['name']);
      $data[$i]['type_css'] = sanitize_output($channel_type['css']);
      $data[$i]['lang_en']  = str_contains($channel_languages, 'EN');
      $data[$i]['lang_fr']  = str_contains($channel_languages, 'FR');
      $data[$i]['desc']     = sanitize_output($channel_description);
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      // Meetup data
      $data[$i]['name']           = sanitize_json($channel_name);
      $data[$i]['type']           = sanitize_json($channel_type['name']);
      $data[$i]['description_en'] = sanitize_json($channel_description_en);
      $data[$i]['description_fr'] = sanitize_json($channel_description_fr);

      // Language data
      $data[$i]['languages_spoken']['english']  = (bool)str_contains($channel_languages, 'EN');
      $data[$i]['languages_spoken']['french']   = (bool)str_contains($channel_languages, 'FR');
    }
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Give a default return value when no channels are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('channels' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new entry in the IRC channel list.
 *
 * @param   array       $contents   The contents of the IRC channel.
 *
 * @return  string|int              A string if an error happened, or the newly created channel's ID if all went well.
 */

function irc_channels_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('integrations.lang.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize and prepare the data
  $channel_name_raw = (isset($contents['name'])) ? $contents['name'] : '';
  $channel_name     = sanitize_array_element($contents, 'name', 'string');
  $channel_desc_en  = sanitize_array_element($contents, 'desc_en', 'string');
  $channel_desc_fr  = sanitize_array_element($contents, 'desc_fr', 'string');
  $channel_type     = sanitize_array_element($contents, 'type', 'int', min: 0, max: 3, default: 1);
  $channel_lang     = (isset($contents['lang_en'])) ? 'EN' : '';
  $channel_lang    .= (isset($contents['lang_fr'])) ? 'FR' : '';

  // Error: No name
  if(!$channel_name)
    return __('irc_channels_add_error_name');

  // Error: No hash in name
  if(substr($channel_name, 0, 1) !== '#')
    return __('irc_channels_add_error_hash');

  // Error: Spaces in name
  if(str_contains($channel_name_raw, ' '))
    return __('irc_channels_add_error_spaces');

  // Error: Illegal character in name
  if(str_contains($channel_name_raw, ',') || str_contains($channel_name_raw, '␇'))
    return __('irc_channels_add_error_illegal');

  // Error: Channel name is too long
  if(strlen($channel_name) > 50)
    return __('irc_channels_add_error_length');

  // Error: Channel already exists
  if(database_entry_exists('irc_channels', 'name', $channel_name))
    return __('irc_channels_add_error_duplicate');

  // Error: No description
  if(!$channel_desc_en || !$channel_desc_fr)
    return __('irc_channels_add_error_desc');

  // Error: No language
  if(!$channel_lang)
    return __('irc_channels_add_error_lang');

  // Create the channel
  query(" INSERT INTO irc_channels
          SET         irc_channels.name           = '$channel_name'     ,
                      irc_channels.channel_type   = '$channel_type'     ,
                      irc_channels.languages      = '$channel_lang'     ,
                      irc_channels.description_en = '$channel_desc_en'  ,
                      irc_channels.description_fr = '$channel_desc_fr'  ");

  // Fetch the newly created channel's id
  $channel_id = query_id();

  // Fetch the username of the moderator creating the channel
  $mod_username = user_get_username();

  // Activity logs
  $modlog = log_activity( 'irc_channels_new'                  ,
                          is_moderators_only:   true          ,
                          activity_summary_en:  $channel_name ,
                          moderator_username:   $mod_username );

  // Detailed activity logs
  $channel_type_details = irc_channels_type_get($channel_type);
  log_activity_details($modlog, 'Channel description (EN)', 'Description du canal (EN)', $channel_desc_en, $channel_desc_en);
  log_activity_details($modlog, 'Channel description (FR)', 'Description du canal (FR)', $channel_desc_fr, $channel_desc_fr);
  log_activity_details($modlog, "Channel type", "Type de canal", $channel_type_details['name_en'], $channel_type_details['name_en']);
  log_activity_details($modlog, "Channel language(s)", "Langue(s) du canal", $channel_lang, $channel_lang);

  // IRC bot message
  irc_bot_send_message("IRC channel $channel_name_raw added to the public channel list by $mod_username - ".$GLOBALS['website_url']."pages/social/irc?channels", 'mod');

  // Return the channel's id
  return $channel_id;
}




/**
 * Modifies an existing IRC channel.
 *
 * @param   int           $channel_id   The IRC channel's ID.
 * @param   array         $contents     The updated IRC channel data.
 *
 * @return  string|null                 A string if an error happened, or null if all went well.
 */

function irc_channels_edit( int   $channel_id ,
                            array $contents   ) : mixed
{
  // Check if the required files have been included
  require_included_file('integrations.lang.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Stop here if the channel does not exist
  if(!database_row_exists('irc_channels', $channel_id))
    return __('irc_channels_edit_error_id');

  // Sanitize and prepare the data
  $channel_desc_en  = sanitize_array_element($contents, 'desc_en', 'string');
  $channel_desc_fr  = sanitize_array_element($contents, 'desc_fr', 'string');
  $channel_type     = sanitize_array_element($contents, 'type', 'int', min: 0, max: 3, default: 1);
  $channel_lang     = (isset($contents['lang_en'])) ? 'EN' : '';
  $channel_lang    .= (isset($contents['lang_fr'])) ? 'FR' : '';

  // Error: No description
  if(!$channel_desc_en || !$channel_desc_fr)
    return __('irc_channels_add_error_desc');

  // Error: No language
  if(!$channel_lang)
    return __('irc_channels_add_error_lang');

  // Fetch the channel's data before updating it
  $dchannel = query(" SELECT  irc_channels.name           AS 'c_name'     ,
                              irc_channels.channel_type   AS 'c_type'     ,
                              irc_channels.languages      AS 'c_lang'     ,
                              irc_channels.description_en AS 'c_desc_en'  ,
                              irc_channels.description_fr AS 'c_desc_fr'
                      FROM    irc_channels
                      WHERE   irc_channels.id = '$channel_id' ",
                      fetch_row: true);

  // Update the channel
  query(" UPDATE  irc_channels
          SET     irc_channels.channel_type   = '$channel_type'     ,
                  irc_channels.languages      = '$channel_lang'     ,
                  irc_channels.description_en = '$channel_desc_en'  ,
                  irc_channels.description_fr = '$channel_desc_fr'
          WHERE   irc_channels.id             = '$channel_id'       ");

  // Prepare data for the activity logs
  $mod_username     = user_get_username();
  $channel_name_raw = $dchannel['c_name'];
  $channel_name     = sanitize($dchannel['c_name'], 'string');
  $channel_type_old = irc_channels_type_get($dchannel['c_type']);
  $channel_type_new = irc_channels_type_get($channel_type);

  // Activity logs
  $modlog = log_activity( 'irc_channels_edit'                 ,
                          is_moderators_only:   true          ,
                          activity_summary_en:  $channel_name ,
                          moderator_username:   $mod_username );

  // Detailed activity logs
  if($dchannel['c_desc_en'] !== $contents['desc_en'])
    log_activity_details($modlog, 'Channel description (EN)', 'Description du canal (EN)', $dchannel['c_desc_en'], $contents['desc_en']);
  if($dchannel['c_desc_fr'] !== $contents['desc_fr'])
    log_activity_details($modlog, 'Channel description (FR)', 'Description du canal (FR)', $dchannel['c_desc_fr'], $contents['desc_fr']);
  if($dchannel['c_type'] !== $contents['type'])
    log_activity_details($modlog, "Channel type", "Type de canal", $channel_type_old['name_en'], $channel_type_new['name_en']);
  if($dchannel['c_lang'] !== $channel_lang)
    log_activity_details($modlog, "Channel language(s)", "Langue(s) du canal", $dchannel['c_lang'], $channel_lang);

  // IRC bot message
  irc_bot_send_message("IRC channel $channel_name_raw has been updated on the channel list by $mod_username - ".$GLOBALS['website_url']."pages/social/irc?channels", 'mod');

  // All went well, return NULL
  return NULL;
}




/**
 * Hard deletes an IRC channel
 *
 * @param   int     $channel_id   The id of the IRC channel to delete.
 *
 * @return  string                A string recapping the results of the deletion process.
 */

function irc_channels_delete( int $channel_id ) : string
{
  // Require moderator rights to run this action
  user_restrict_to_moderators();

  // Check if the required files have been included
  require_included_file('integrations.lang.php');

  // Sanitize the channel's id
  $channel_id = sanitize($channel_id, 'int', 0);

  // Check if the channel exists
  if(!$channel_id || !database_row_exists('irc_channels', $channel_id))
    return __('irc_channels_delete_error');

  // Fetch the channel's data before deleting it
  $dchannel = query(" SELECT  irc_channels.name           AS 'c_name'     ,
                              irc_channels.channel_type   AS 'c_type'     ,
                              irc_channels.languages      AS 'c_lang'     ,
                              irc_channels.description_en AS 'c_desc_en'  ,
                              irc_channels.description_fr AS 'c_desc_fr'
                      FROM    irc_channels
                      WHERE   irc_channels.id = '$channel_id' ",
                      fetch_row: true);

  // Hard delete the channel
  query(" DELETE FROM irc_channels
          WHERE       irc_channels.id = '$channel_id' ");

  // Prepare data for the activity logs
  $mod_username     = user_get_username();
  $channel_name_raw = $dchannel['c_name'];
  $channel_name     = sanitize($dchannel['c_name'], 'string');
  $channel_type     = irc_channels_type_get($dchannel['c_type']);

  // Activity logs
  $modlog = log_activity( 'irc_channels_delete'               ,
                          is_moderators_only:   true          ,
                          activity_summary_en:  $channel_name ,
                          moderator_username:   $mod_username );

  // Detailed activity logs
  log_activity_details($modlog, 'Channel description (EN)', 'Description du canal (EN)', $dchannel['c_desc_en']);
  log_activity_details($modlog, 'Channel description (FR)', 'Description du canal (FR)', $dchannel['c_desc_fr']);
  log_activity_details($modlog, "Channel type", "Type de canal", $channel_type['name_en']);
  log_activity_details($modlog, "Channel language(s)", "Langue(s) du canal", $dchannel['c_lang']);

  // IRC bot message
  irc_bot_send_message("IRC channel $channel_name_raw has been deleted from the channel list by $mod_username - ".$GLOBALS['website_url']."pages/social/irc?channels", 'mod');

  // Return that all went well
  return __('irc_channels_delete_ok');
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
  require_included_file('integrations.lang.php');

  // Fetch the user's language
  $lang = user_get_language();

  // Channel type description
  if($lang === 'EN')
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

  // Channel type description in english only
  $data['name_en'] = match($type_id)
  {
    3         => 'Main'       ,
    2         => 'Major'      ,
    1         => 'Minor'      ,
    default   => 'Automated'  ,
  };

  // Channel type CSS
  $data['css'] = match($type_id)
  {
    3         => ' bold glow_dark'  ,
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
 * @return  void
 */

function irc_bot_start() : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Write a log in the database
  $timestamp = sanitize(time(), 'int', 0);
  query(" INSERT INTO logs_irc_bot
          SET         logs_irc_bot.sent_at    = '$timestamp'              ,
                      logs_irc_bot.body       = '** Starting IRC bot **'  ,
                      logs_irc_bot.is_manual  = 1                         ,
                      logs_irc_bot.is_action  = 1                         ");

  // Execute the script which starts the IRC bot
  if($GLOBALS['enable_scripts'])
    shell_exec($GLOBALS['scripts_command'].' '.$GLOBALS['scripts_path'].'irc_bot.php');
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
    if($channel && (substr($channel, 0, 1) !== '#'))
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
  require_included_file('integrations.lang.php');

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
  require_included_file('integrations.lang.php');

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
  require_included_file('integrations.lang.php');
  require_included_file('functions_time.inc.php');

  // Sanitize the search parameters
  $search_channel = sanitize_array_element($search, 'channel', 'string');
  $search_body    = sanitize_array_element($search, 'message', 'string');
  $search_errors  = sanitize_array_element($search, 'sent', 'int', min: -1, max: 1, default: -1);

  // Prepare the search string
  $search = " WHERE 1=1 ";
  if(strpos($search_channel, '-') !== false)
    $search .= "  AND logs_irc_bot.is_manual    =     1 ";
  else if($search_channel)
    $search .= "  AND logs_irc_bot.channel      LIKE  '%$search_channel%' ";
  if($search_body)
    $search .= "  AND logs_irc_bot.is_action    =     0
                  AND logs_irc_bot.body         LIKE  '%$search_body%' ";
  if($search_errors === 0)
    $search .= "  AND logs_irc_bot.is_action    =     0
                  AND logs_irc_bot.is_silenced  =     0
                  AND logs_irc_bot.is_failed    =     0 ";
  else if($search_errors === 1)
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
  for($i = 0; $row = query_row($qhistory); $i++)
  {
    $data[$i]['id']         = $row['li_id'];
    $data[$i]['date']       = sanitize_output(time_since($row['li_date']));
    $data[$i]['channel']    = ($row['li_manual']) ? __('irc_bot_history_nochan') : sanitize_output($row['li_channel']);
    $data[$i]['body']       = sanitize_output($row['li_body']);
    $data[$i]['body_js']    = sanitize_output_javascript($row['li_body']);
    $log_failed             = ($row['li_silenced']) ? __('irc_bot_history_silenced') : '';
    $log_failed             = ($row['li_failed']) ? __('irc_bot_history_failed') : $log_failed;
    $data[$i]['failed']     = ($row['li_silenced'] || $row['li_failed']) ? $log_failed : '';
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
  $dlog = query(" SELECT  logs_irc_bot.channel  AS 'il_channel' ,
                          logs_irc_bot.body     AS 'il_body'
                  FROM    logs_irc_bot
                  WHERE   logs_irc_bot.id = '$log_id' ",
                  fetch_row: true);

  // Strip the hash from the start of the  channel name
  $channel = $dlog['il_channel'];
  if($channel && (substr($channel, 0, 1) === '#'))
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




/**
 * Sends a message through the Discord webhook from the admin interface.
 *
 * @param   string    $message              The message to send.
 * @param   string    $channel  (OPTIONAL)  The channel on which the message should be sent.
 *
 * @return  void
 */

function discord_webhook_send_message(  string  $message        ,
                                        string  $channel  = ''  ) : void
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Stop here if no message has been specified
  if(!$message)
    return;

  // Send the message through the webhook
  discord_send_message($message, $channel);
}