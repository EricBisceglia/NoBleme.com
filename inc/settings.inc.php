<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inclusion of the local configuration

@include_once 'configuration.inc.php';

// If no MySQL password is provided, then it's not even worth trying to do anything
if(!isset($GLOBALS['mysql_pass']))
  exit("NoBleme is incorrectly installed: The local configuration file is missing.");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definition of the $path variable, which will be used to build URLs all over the website

// Define where to look for URLs: account for the two slashes in http://, then add extra folders from local settings
$uri_base_slashes = 2 + $GLOBALS['extra_folders'];

// We check how far removed from the project root we currently are
$uri_length = count(explode( '/', $_SERVER['REQUEST_URI']));

// If we are at the root, then there is no $path
if($uri_length <= $uri_base_slashes)
  $path = "";

// Otherwise, we increment the $path for each folder we have to ../ until we reach the root at ./
else
{
  $path = "./";
  for ($i=0 ; $i<($uri_length-$uri_base_slashes) ; $i++)
    $path .= "../";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Enforce a timezone on the server side

date_default_timezone_set('Europe/Paris');