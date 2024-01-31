<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_scheduler_get               Returns data related to a scheduled task.                                        */
/*  dev_scheduler_list              Returns a list of all task scheduler executions, past and future.                */
/*  dev_scheduler_edit              Edits an entry in the task scheduler.                                            */
/*  dev_scheduler_delete_task       Deletes an entry in the scheduled tasks.                                         */
/*  dev_scheduler_delete_log        Deletes an entry in the scheduler execution logs.                                */
/*                                                                                                                   */
/*  dev_scheduler_types_list        Returns a list of all scheduler task types.                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to a scheduled task.
 *
 * @param   int         $task_id  The scheduled task's id.
 *
 * @return  array|null            An array containing task related data, or NULL if it does not exist.
 */

function dev_scheduler_get( int $task_id ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $task_id = sanitize($task_id, 'int', 0);

  // Check if the scheduled task exists
  if(!database_row_exists('system_scheduler', $task_id))
    return NULL;

  // Fetch the data
  $dtask = query("  SELECT  system_scheduler.planned_at       AS 't_date' ,
                            system_scheduler.task_id          AS 't_id'   ,
                            system_scheduler.task_type        AS 't_type' ,
                            system_scheduler.task_description AS 't_description'
                    FROM    system_scheduler
                    WHERE   system_scheduler.id = '$task_id' ",
                    fetch_row: true);

  // Assemble an array with the data
  $data['date_days']  = sanitize_output(date('d/m/y', $dtask['t_date']));
  $data['date_time']  = sanitize_output(date('h:i:s', $dtask['t_date']));

  // Return the array
  return $data;
}




/**
 * Returns a list of all task scheduler executions, past and future.
 *
 * @param   string  $sort_by  (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                        An array containing the scheduler logs and upcoming tasks.
 */

function dev_scheduler_list(  string  $sort_by  = 'date'  ,
                              array   $search   = array() ) : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Sanitize and prepare the data
  $lang     = user_get_language();
  $sort_by  = sanitize($sort_by, 'string');

  // Sanitize the search parameters
  $search_type        = sanitize_array_element($search, 'type', 'string');
  $search_id          = sanitize_array_element($search, 'id', 'int', 0, default: 0);
  $search_execution   = sanitize_array_element($search, 'date', 'int', 0, 2, default: 0);
  $search_description = sanitize_array_element($search, 'description', 'string');
  $search_report      = sanitize_array_element($search, 'report', 'string');

  // Search through the data: Future executions
  $future_search  = " WHERE 1 = 1 ";
  $future_search .= ($search_type)            ? " AND system_scheduler.task_type LIKE '$search_type'          " : "";
  $future_search .= ($search_id)              ? " AND system_scheduler.task_id      = '$search_id'            " : "";
  $future_search .= ($search_description)     ? "
                                           AND system_scheduler.task_description LIKE '%$search_description%' " : "";
  $future_search .= ($search_report)          ? " AND 1 = 0                                                   " : "";
  $future_search .= ($search_execution === 2) ? " AND 1 = 0                                                   " : "";

  // Search through the data: Past executions
  $past_search  = " WHERE 1 = 1 ";
  $past_search .= ($search_type)            ? " AND logs_scheduler.task_type       LIKE '$search_type'          " : "";
  $past_search .= ($search_id)              ? " AND logs_scheduler.task_id            = '$search_id'            " : "";
  $past_search .= ($search_description)     ? "
                                               AND logs_scheduler.task_description LIKE '%$search_description%' " : "";
  $past_search .= ($search_report)          ? " AND logs_scheduler.execution_report LIKE '%$search_report%'     " : "";
  $past_search .= ($search_execution === 1) ? " AND 1 = 0                                                       " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'type'        => " ORDER BY s_type    ASC   ,
                                s_date    DESC  " ,
    'description' => " ORDER BY s_desc    = ''  ,
                                s_desc    ASC   ,
                                s_date    DESC  " ,
    'report'      => " ORDER BY s_report  = ''  ,
                                s_report  ASC   ,
                                s_date    DESC  " ,
    default       => " ORDER BY s_date    DESC  " ,
  };

  // Fetch all future and past scheduler executions
  $qscheduler = query(" ( SELECT  'future'                          AS 's_exec' ,
                                  system_scheduler.id               AS 's_id'   ,
                                  system_scheduler.planned_at       AS 's_date' ,
                                  system_scheduler.task_id          AS 's_tid'  ,
                                  system_scheduler.task_type        AS 's_type' ,
                                  system_scheduler.task_description AS 's_desc' ,
                                  ''                                AS 's_report'
                          FROM    system_scheduler
                                  $future_search )
                          UNION
                        ( SELECT  'past'                            AS 's_exec' ,
                                  logs_scheduler.id                 AS 's_id'   ,
                                  logs_scheduler.happened_at        AS 's_date' ,
                                  logs_scheduler.task_id            AS 's_tid'  ,
                                  logs_scheduler.task_type          AS 's_type' ,
                                  logs_scheduler.task_description   AS 's_desc' ,
                                  logs_scheduler.execution_report   AS 's_report'
                          FROM    logs_scheduler
                                  $past_search )
                                  $query_sort ");

  // Reset the counters
  $data['rows_past']    = 0;
  $data['rows_future']  = 0;

  // Prepare the data
  for($i = 0; $row = query_row($qscheduler); $i++)
  {
    $data['rows_past']       += ($row['s_exec'] === 'past') ? 1 : 0;
    $data['rows_future']     += ($row['s_exec'] === 'future') ? 1 : 0;
    $data[$i]['type']         = $row['s_exec'];
    $data[$i]['id']           = $row['s_id'];
    $data[$i]['date']         = ($row['s_exec'] === 'past')
                              ? sanitize_output(time_since($row['s_date']))
                              : sanitize_output(time_until($row['s_date']));
    $data[$i]['fdate']        = date_to_text($row['s_date'], 0, 1, $lang);
    $data[$i]['task_id']      = $row['s_tid'];
    $data[$i]['task_type']    = sanitize_output($row['s_type']);
    $data[$i]['description']  = sanitize_output(string_truncate($row['s_desc'], 20, '...'));
    $data[$i]['fdescription'] = (strlen($row['s_desc']) > 20) ? sanitize_output($row['s_desc']) : '';
    $data[$i]['report']       = sanitize_output(string_truncate($row['s_report'], 35, '...'));
    $data[$i]['freport']      = (strlen($row['s_report']) > 35) ? sanitize_output($row['s_report']) : '';
  }

  // Add the search order to the data
  $data['sort'] = $sort_by;

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Edits an entry in the task scheduler.
 *
 * @param   int           $id     The task's id.
 * @param   string        $date   The task's execution date.
 * @param   string        $time   The task's execution time.
 *
 * @return  string|null           NULL if all went according to plan, or an error string
 */

function dev_scheduler_edit(  int     $id   ,
                              string  $date ,
                              string  $time ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('scheduler.lang.php');

  // Sanitize the data
  $id         = sanitize($id, 'int', 0);
  $date       = sanitize($date, 'string');
  $time       = sanitize($time, 'string');
  $timestamp  = sanitize(strtotime(date_to_mysql($date).' '.$time), 'int');

  // Check if the scheduled task exists
  if(!database_row_exists('system_scheduler', $id))
    return __('dev_scheduler_edit_error_id');

  // Check if the submitted time and date are correct
  if($timestamp <= 0)
    return __('dev_scheduler_edit_error_time');

  // Edit the scheduled task
  query(" UPDATE  system_scheduler
          SET     system_scheduler.planned_at = '$timestamp'
          WHERE   system_scheduler.id         = '$id' ");

  // Return that all went well
  return NULL;
}




/**
 * Deletes an entry in the scheduled tasks.
 *
 * @param   int   $task_id  The tasks's id
 *
 * @return  int             The tasks's id, or 0 if the task does not exist.
 */

function dev_scheduler_delete_task( int $task_id ) : int
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $task_id = sanitize($task_id, 'int', 0);

  // Ensure the task id exists or return 0
  if(!database_row_exists('system_scheduler', $task_id))
    return 0;

  // Delete the entry
  query(" DELETE FROM system_scheduler
          WHERE       system_scheduler.id = '$task_id' ");

  // Return the deleted task id
  return $task_id;
}




/**
 * Deletes an entry in the scheduler execution logs.
 *
 * @param   int   $log_id   The log's id
 *
 * @return  int             The log's id, or 0 if the log does not exist.
 */

function dev_scheduler_delete_log( int $log_id ) : int
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $log_id = sanitize($log_id, 'int', 0);

  // Ensure the log id exists or return 0
  if(!database_row_exists('logs_scheduler', $log_id))
    return 0;

  // Delete the entry
  query(" DELETE FROM logs_scheduler
          WHERE       logs_scheduler.id = '$log_id' ");

  // Return the deleted log id
  return $log_id;
}




/**
 * Returns a list of all scheduler task types.
 *
 * @return  array   An array containing the task types.
 */

function dev_scheduler_types_list() : array
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Fetch all scheduler types
  $qtypes = query(" SELECT    system_scheduler.task_type  AS 's_type'
                    FROM      system_scheduler
                    UNION
                    SELECT    logs_scheduler.task_type    AS 's_type'
                    FROM      logs_scheduler
                    GROUP BY  s_type
                    ORDER BY  s_type ASC ");

  // Prepare the data
  for($i = 0; $row = query_row($qtypes); $i++)
    $data[$i]['type'] = sanitize_output($row['s_type']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}