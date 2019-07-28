<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/**
 * Plaintext description of a task's priority level.
 *
 * @param   int         $priority_level             The priority level of the task as stored in the database (an int).
 * @param   string|null $lang           (OPTIONAL)  The language used for the description of the priority level.
 * @param   bool|null   $styled         (OPTIONAL)  If set, returns a styled description with HTML tags.
 *
 * @return  string                                  A plaintext description of the priority level.
 */

function task_priority($priority_level, $lang='FR', $styled=0)
{
  // No trickery here, we simply parse priority levels one by one using a switch
  switch($priority_level)
  {
    // 5 -> Urgent task: We prepare the translated strings, and return the result (styled or not)
    case 5:
      $temp = ($lang == 'EN') ? 'Emergency' : 'Urgent';
      return (!$styled) ? $temp : '<span class="gras souligne">'.$temp.'</span>';
    break;

    // 4 -> Important task: We prepare the translated strings, and return the result (styled or not)
    case 4:
      $temp = ($lang == 'EN') ? 'Important' : 'Important';
      return (!$styled) ? $temp : '<span class="gras">'.$temp.'</span>';
    break;

    // 3 -> Averagely important task: We prepare the translated strings, and return the result
    case 3:
      return ($lang == 'EN') ? 'To consider' : 'À considérer';
    break;

    // 2 -> Not too important task: We prepare the translated strings, and return the result
    case 2:
      return ($lang == 'EN') ? "There's still time" : "Y'a le temps";
    break;

    // 1 -> Low importance task: We prepare the translated strings, and return the result (styled or not)
    case 1:
      $temp = ($lang == 'EN') ? 'No hurry' : 'Pas pressé';
      return (!$styled) ? $temp : '<span class="italique">'.$temp.'</span>';
    break;

    // 0 (or other) -> Background task: We prepare the translated strings, and return the result (styled or not)
    default:
      $temp = ($lang == 'EN') ? 'Maybe some day' : 'À faire un jour';
      return (!$styled) ? $temp : '<span class="italique">'.$temp.'</span>';
    break;
  }
}