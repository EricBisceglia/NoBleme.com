<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/**
 * Plaintext description of a task's priority level.
 *
 * @param   int         $priority_level             The priority level of the task as stored in the database (an int).
 * @param   bool|null   $styled         (OPTIONAL)  If set, returns a styled description with HTML tags.
 *
 * @return  string                                  A plaintext description of the priority level.
 */

function task_priority( $priority_level     ,
                        $styled         = 0 )
{
  // No trickery here, simply parse priority levels one by one using a switch
  switch($priority_level)
  {
    // 5 -> Urgent task
    case 5:
      return (!$styled) ? __('task_priority_5') : '<span class="bold underlined">'.__('task_priority_5').'</span>';
    break;

    // 4 -> Important task
    case 4:
      return (!$styled) ? __('task_priority_5') : '<span class="bold">'.__('task_priority_4').'</span>';
    break;

    // 3 -> Averagely important task
    case 3:
      return __('task_priority_3');
    break;

    // 2 -> Not too important task
    case 2:
      return __('task_priority_2');
    break;

    // 1 -> Low importance task
    case 1:
      return (!$styled) ? __('task_priority_1') : '<span class="italics">'.__('task_priority_1').'</span>';
    break;

    // 0 (or other) -> Background task
    default:
      return (!$styled) ? __('task_priority_0') : '<span class="italics">'.__('task_priority_0').'</span>';
    break;
  }
}