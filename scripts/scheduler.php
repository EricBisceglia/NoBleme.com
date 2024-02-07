<?php #################################################################################################################
#                                                                                                                     #
#                    Do not try to run this script from the web, .htaccess denies it for a reason.                    #
#                                                                                                                     #
#######################################################################################################################
# Define root path for script execution (you might need to edit this)                                                 #
$root_path = '/var/www/html/';                                                                                        #
#######################################################################################################################
$root_path = "C:/wamp64/www/nobleme/";
// Define the path to the website's root
$root_path = (isset($scheduler_set_root_path)) ? $scheduler_set_root_path : $root_path;

// Check if the root path is correct
if(!file_exists($root_path.'inc/settings.inc.php'))
  exit('Exiting NoBleme Scheduler: Root path is incorrect');

// Include settings
include_once $root_path.'inc/settings.inc.php';

// Don't run the scheduler if scripts are disabled
if(!$GLOBALS['enable_scripts'])
  exit('Exiting NoBleme Scheduler: Scripts are disabled');

// Set a higher max execution time limit
set_time_limit(600);

// Include required files
$path = $root_path;
include_once $root_path.'inc/includes.inc.php';

// Execute a dummy query to confirm the script was executed
$time = sanitize(time(), 'int', 0);
query(" INSERT INTO logs_scheduler
        SET         logs_scheduler.happened_at      = '$time'       ,
                    logs_scheduler.task_type        = 'maintenance' ,
                    logs_scheduler.execution_report = 'Dummy run'   ");