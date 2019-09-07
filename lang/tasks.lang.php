<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       TASKS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Priorities
___('task_priority_5', 'EN', "Emergency");
___('task_priority_5', 'FR', "Urgent");
___('task_priority_4', 'EN', "Important");
___('task_priority_4', 'FR', "Important");
___('task_priority_3', 'EN', "To consider");
___('task_priority_3', 'FR', "À considérer");
___('task_priority_2', 'EN', "There\'s still time");
___('task_priority_2', 'FR', "Y'a le temps");
___('task_priority_1', 'EN', "No hurry");
___('task_priority_1', 'FR', "Pas pressé");
___('task_priority_0', 'EN', "Maybe some day");
___('task_priority_0', 'FR', "À faire un jour");