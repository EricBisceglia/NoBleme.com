<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  task_priority         Plaintext description of a task's priority level.                                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Plaintext description of a task's priority level.
 *
 * @param   int   $priority_level             The priority level of the task as stored in the database (an int).
 * @param   bool  $styled         (OPTIONAL)  If set, returns a styled description with HTML tags.
 *
 * @return  string                                  A plaintext description of the priority level.
 */

function task_priority( int   $priority_level         ,
                        bool  $styled         = false ) : string
{
  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Parse priority levels one by one using a match and return their result
  $return = match($priority_level)
    {
      5       => (!$styled) ? __('task_priority_5') : '<span class="bold underlined">'.__('task_priority_5').'</span>',
      4       => (!$styled) ? __('task_priority_4') : '<span class="bold">'.__('task_priority_4').'</span>'           ,
      3       => __('task_priority_3')                                                                                ,
      2       => __('task_priority_2')                                                                                ,
      1       => (!$styled) ? __('task_priority_1') : '<span class="italics">'.__('task_priority_1').'</span>'        ,
      default => (!$styled) ? __('task_priority_0') : '<span class="italics">'.__('task_priority_0').'</span>'        ,
    };

  echo $return;
}