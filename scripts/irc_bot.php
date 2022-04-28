<?php #################################################################################################################
#                                                                                                                     #
#                    Do not try to run this script from the web, .htaccess denies it for a reason.                    #
#                                                                                                                     #
#######################################################################################################################
# Define root path for script execution (you might need to edit this)                                                 #
$root_path = '/var/www/html/';                                                                                        #
#######################################################################################################################

// Assemble configuration file path
$irc_config_file = $root_path.'inc/configuration.inc.php';

// Check if the configuration file exists
if(!file_exists($irc_config_file))
  exit('Exiting NoBleme IRC Bot: Configuration file configuration.inc.php is missing');

// Include the configuration file
include_once $root_path.'inc/configuration.inc.php';

// Bot settings
$irc_bot_file     = $root_path.$GLOBALS['irc_bot_file_name'];
$irc_bot_server   = $GLOBALS['irc_bot_server'];
$irc_bot_port     = $GLOBALS['irc_bot_port'];
$irc_bot_channels = $GLOBALS['irc_bot_channels'];
$irc_bot_nickname = $GLOBALS['irc_bot_nickname'];
$irc_bot_password = $GLOBALS['irc_bot_password'];

// Don't run the bot if it is disabled
if(!$GLOBALS['enable_irc_bot'])
  exit('Exiting NoBleme IRC Bot: Disabled in configuration');

// Check if the file used by the bot exists
if(!file_exists($irc_bot_file))
  exit('Exiting NoBleme IRC Bot: Text file ircbot.txt is missing');

// Open the IRC socket
if(!$irc_socket = fsockopen($irc_bot_server, $irc_bot_port))
  exit('Exiting NoBleme IRC Bot: Socket could not open');

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
    exit('Exiting NoBleme IRC Bot: Text file ircbot.txt is gone');
  }

  // Check the bot's txt file for an order to quit
  if(substr(file_get_contents($irc_bot_file),0,4) == 'quit' || substr(file_get_contents($irc_bot_file),11,4) == 'quit')
  {
    // Delete the first line of the bot's txt file
    $irc_bot_file_data = file($irc_bot_file, FILE_IGNORE_NEW_LINES);
    array_shift($irc_bot_file_data);
    file_put_contents($irc_bot_file, implode("\r\n", $irc_bot_file_data));

    // Quit IRC
    fputs($irc_socket,"QUIT :Getting terminated... I'll be back\r\n");

    // Stop the script
    exit('Exiting NoBleme IRC Bot: Manual quit requested in ircbot.txt');
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