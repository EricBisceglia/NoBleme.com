<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_list                Fetches a list of tasks.                                                               */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Fetches a list of tasks.
 *
 * @param   string  $sort_by  (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         An array containing tasks.
 */

function tasks_list(  string  $sort_by  = 'status'  ,
                      array   $search   = array()   ) : array
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_mathematics.inc.php');

  // Get the user's current language and access rights
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = user_is_administrator();

  // Sanitize the search parameters
  $search_id  = isset($search['id'])  ? sanitize($search['id'], 'int', 0) : 0;

  // Fetch the tasks
  $qtasks = "     SELECT    dev_tasks.id                      AS 't_id'         ,
                            dev_tasks.is_deleted              AS 't_deleted'    ,
                            dev_tasks.created_at              AS 't_created'    ,
                            dev_tasks.finished_at             AS 't_finished'   ,
                            dev_tasks.is_public               AS 't_public'     ,
                            dev_tasks.admin_validation        AS 't_validated'  ,
                            dev_tasks.priority_level          AS 't_status'     ,
                            dev_tasks.title_en                AS 't_title_en'   ,
                            dev_tasks.title_fr                AS 't_title_fr'   ,
                            dev_tasks_categories.title_$lang  AS 't_category'   ,
                            dev_tasks_milestones.title_$lang  AS 't_milestone'  ,
                            users.username                    AS 't_author'
                  FROM      dev_tasks
                  LEFT JOIN dev_tasks_categories  ON dev_tasks.fk_dev_tasks_categories  = dev_tasks_categories.id
                  LEFT JOIN dev_tasks_milestones  ON dev_tasks.fk_dev_tasks_milestones  = dev_tasks_milestones.id
                  LEFT JOIN users                 ON dev_tasks.fk_users                 = users.id
                  WHERE     1 = 1 ";

  // Do not show deleted, unvalidated, or private tasks to regular users
  if(!$is_admin)
    $qtasks .= "  AND       dev_tasks.is_deleted        = 0
                  AND       dev_tasks.is_public         = 1
                  AND       dev_tasks.admin_validation  = 1                     ";

  // Regular users should only see tasks with a title matching their current language
  if(!$is_admin)
    $qtasks .= "  AND       dev_tasks.title_$lang      != ''                    ";

  // Search the data
  if($search_id)
    $qtasks .= "  AND       dev_tasks.id                = '$search_id'          ";

  // Sort the data
  if($sort_by == 'status')
    $qtasks .= " ORDER BY     dev_tasks.finished_at     != '' ,
                              dev_tasks.finished_at     DESC  ,
                              dev_tasks.priority_level  DESC  ,
                              dev_tasks.created_at      DESC  ";

  // Run the query
  $qtasks = query($qtasks);

  // Initialize the finished task counter
  $total_tasks_finished = 0;

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qtasks); $i++)
  {
    $data[$i]['id']         = sanitize_output($row['t_id']);
    $data[$i]['css_row']    = ($row['t_finished']) ? 'task_solved' : 'task_status_'.sanitize_output($row['t_status']);
    $temp                   = ($row['t_status'] < 2) ? ' italics' : '';
    $temp                   = ($row['t_status'] > 3) ? ' bold' : $temp;
    $temp                   = ($row['t_status'] > 4) ? ' bold uppercase underlined' : $temp;
    $data[$i]['css_status'] = ($temp && !$row['t_finished']) ? $temp : '';
    $temp                   = ($lang == 'en') ? $row['t_title_en'] : $row['t_title_fr'];
    $temp                   = ($lang == 'en' && !$row['t_title_en']) ? $row['t_title_fr'] : $temp;
    $temp                   = ($lang != 'en' && !$row['t_title_fr']) ? $row['t_title_en'] : $temp;
    $data[$i]['title']      = sanitize_output(string_truncate($temp, 50, '…'));
    $data[$i]['shorttitle'] = sanitize_output(string_truncate($temp, 40, '…'));
    $temp                   = sanitize_output(__('tasks_list_solved'));
    $data[$i]['status']     = ($row['t_finished']) ? $temp : sanitize_output(__('tasks_list_state_'.$row['t_status']));
    $data[$i]['created']    = sanitize_output(time_since($row['t_created']));
    $data[$i]['author']     = sanitize_output($row['t_author']);
    $data[$i]['category']   = sanitize_output($row['t_category']);
    $data[$i]['milestone']  = sanitize_output($row['t_milestone']);
    $data[$i]['nolang_en']  = (!$row['t_title_en']);
    $data[$i]['nolang_fr']  = (!$row['t_title_fr']);
    $data[$i]['deleted']    = ($row['t_deleted']);
    $data[$i]['private']    = (!$row['t_public']);
    $data[$i]['new']        = (!$row['t_validated']);
    $total_tasks_finished  += ($row['t_finished']) ? 1 : 0;
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Calculate the remaining totals
  $total_tasks_todo       = $data['rows'] - $total_tasks_finished;
  $total_tasks_percentage = maths_percentage_of($total_tasks_finished, $data['rows']);

  // Add the totals to the data
  $data['finished'] = sanitize_output($total_tasks_finished);
  $data['todo']     = sanitize_output($total_tasks_todo);
  $data['percent']  = sanitize_output(number_display_format($total_tasks_percentage, 'percentage', 0));

  // Return the prepared data
  return $data;
}