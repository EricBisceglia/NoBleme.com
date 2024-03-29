<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Main configuration

// Require PHP8
if(version_compare(phpversion(), '8.0.0', '<'))
  exit("NoBleme requires at least PHP8 to run properly.");

// Include the local configuration file
if(file_exists(dirname(__FILE__).'/../conf/main.conf.php'))
  include_once dirname(__FILE__).'/../conf/main.conf.php';
else
  exit("NoBleme is incorrectly installed: The local configuration file is missing.");

// Include the integrations configuration file
if(file_exists(dirname(__FILE__).'/../conf/integrations.conf.php'))
  include_once dirname(__FILE__).'/../conf/integrations.conf.php';

// If no MySQL password is provided, then it's not even worth trying to do anything
if(!isset($GLOBALS['mysql_pass']))
  exit("NoBleme is incorrectly installed: The local configuration file is incorrect.");

// Give global variables a default value if they're unset
$GLOBALS['website_url']     = isset($GLOBALS['website_url'])      ? $GLOBALS['website_url']    : 'http://nobleme.com/';
$GLOBALS['domain_name']     = isset($GLOBALS['domain_name'])      ? $GLOBALS['domain_name']     : 'nobleme.com';
$GLOBALS['mysql_host']      = isset($GLOBALS['mysql_host'])       ? $GLOBALS['mysql_host']      : 'localhost';
$GLOBALS['mysql_user']      = isset($GLOBALS['mysql_user'])       ? $GLOBALS['mysql_user']      : 'nobleme';
$GLOBALS['salt_key']        = isset($GLOBALS['salt_key'])         ? $GLOBALS['salt_key']        : '$6$somestring$';
$GLOBALS['timezone']        = isset($GLOBALS['timezone'])         ? $GLOBALS['timezone']        : 'Europe/Paris';
$GLOBALS['extra_folders']   = isset($GLOBALS['extra_folders'])    ? $GLOBALS['extra_folders']   : 0;
$GLOBALS['enable_scripts']  = isset($GLOBALS['enable_scripts'])   ? $GLOBALS['enable_scripts']  : 0;
$GLOBALS['enable_irc_bot']  = isset($GLOBALS['enable_irc_bot'])   ? $GLOBALS['enable_irc_bot']  : 0;
$GLOBALS['enable_discord']  = isset($GLOBALS['enable_discord'])   ? $GLOBALS['enable_discord']  : 0;
$GLOBALS['dev_mode']        = isset($GLOBALS['dev_mode'])         ? $GLOBALS['dev_mode']        : 0;

// Enforce a global timezone on the server side
date_default_timezone_set($GLOBALS['timezone']);

// Use french as the locale for everything
setlocale(LC_ALL, "fr_FR@euro", "fr_FR", "fra_fra");

// Make var_dumps unlimited in size
ini_set('xdebug.var_display_max_depth', '-1');
ini_set('xdebug.var_display_max_children', '-1');
ini_set('xdebug.var_display_max_data', '-1');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definition of the $path variable, which will be used to build URLs all over the website

// Define where to look for URLs: account for the two slashes in http://, then add extra folders from local settings
$uri_base_slashes = 2 + $GLOBALS['extra_folders'];

// Check how far removed from the project root the current path is
$request_uri  = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : $root_path;
$uri_length   = count(explode( '/', $request_uri));

// If we are at the project root, then there is no $path
if($uri_length <= $uri_base_slashes)
  $path = "";

// Otherwise, increment the $path for each folder that must be ../ until reaching the root at ./
else
{
  $path = "./";
  for ($i = 0 ; $i < ($uri_length - $uri_base_slashes) ; $i++)
    $path .= "../";
}