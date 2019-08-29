<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// The following global variables are your local settings - set them accordingly, otherwise NoBleme will not work
// Duplicate this file, then remove the .DEFAULT (rename it to "configuration.inc.php") and fill up these variables:

$GLOBALS['website_url']   = 'http://127.0.0.1/nobleme/';  // URL of the website root
$GLOBALS['domain_name']   = 'nobleme.com';                // Domain name on which the website is being used
$GLOBALS['mysql_host']    = 'localhost';                  // MySQL server address
$GLOBALS['mysql_user']    = 'root';                       // MySQL user login
$GLOBALS['mysql_pass']    = '';                           // MySQL user password
$GLOBALS['salt_key']      = '$6$bnk$';                    // String used by crypt() to hash passwords
$GLOBALS['irc_bot_pass']  = '';                           // Password of the IRC bot
$GLOBALS['extra_folders'] = 1;                            /* If NoBleme URL is not at server root, this is the number
                                                          /  of folders between the root and NoBleme. example:
                                                          /  if NoBleme is at http://website.com/ leave this as 0
                                                          /  if NoBleme is at http://website.com/nobleme/, this is 1
                                                          /  at http://website.com/stuff/nobleme/, this at 2, etc. */