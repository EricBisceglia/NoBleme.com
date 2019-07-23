<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// These files should be included in every single page of the website
// It is more convenient to include one file (this one) which will then proceed to include all other files

include_once "settings.inc.php";          // Global settings, the local configuration is imported within this file
include_once "sql.inc.php";               // Initializes the connexion to MySQL
include_once "sanitization.inc.php";      // Functions related to data sanitization
include_once "error.inc.php";             // Allows the management of errors
include_once "users.inc.php";             // Functions related to user sessions, logging in, access rights, etc.
include_once "functions_common.inc.php";  // Common functions required by most pages
include_once "scheduler.inc.php";         // Check if any planned tasks need to be ran