<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  tasks_get                       Returns data related to a task.                                                  */
/*  tasks_list                      Fetches a list of tasks.                                                         */
/*  tasks_add                       Creates a new task.                                                              */
/*  tasks_propose                   Creates a new unvalidated task proposal.                                         */
/*  tasks_approve                   Approves an unvalidated task proposal.                                           */
/*  tasks_reject                    Rejects and hard deletes an unvalidated task proposal.                           */
/*  tasks_solve                     Marks a task as solved.                                                          */
/*  tasks_edit                      Modifies an existing task.                                                       */
/*  tasks_delete                    Soft deletes an existing task.                                                   */
/*  tasks_restore                   Restores a deleted task.                                                         */
/*  tasks_delete_hard               Hard deletes a deleted task.                                                     */
/*                                                                                                                   */
/*  tasks_categories_list           Fetches a list of task categories.                                               */
/*  tasks_categories_add            Creates a new task category.                                                     */
/*  tasks_categories_edit           Modifies a task category.                                                        */
/*  tasks_categories_delete         Deletes a task category.                                                         */
/*                                                                                                                   */
/*  tasks_milestones_list           Fetches a list of task milestones.                                               */
/*  tasks_milestones_add            Creates a new task milestone.                                                    */
/*  tasks_milestones_edit           Modifies a task milestone.                                                       */
/*  tasks_milestones_delete         Deletes a task milestone.                                                        */
/*                                                                                                                   */
/*  tasks_stats_list                Returns stats related to tasks.                                                  */
/*  tasks_stats_recalculate_user    Recalculates tasks statistics for a specific user.                               */
/*  tasks_stats_recalculate_all     Recalculates global tasks statistics.                                            */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns data related to a task.
 *
 * @param   int         $task_id              The task's id.
 * @param   string      $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array|null                        An array containing task related data, or NULL if it does not exist.
 */

function tasks_get( int     $task_id            ,
                    string  $format   = 'html'  ) : mixed
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Get the user's current language and access rights
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = user_is_administrator();

  // Sanitize the data
  $task_id = sanitize($task_id, 'int', 0);

  // Check if the task exists
  if(!database_row_exists('dev_tasks', $task_id))
    return NULL;

  // Fetch the data
  $dtask = query("  SELECT    dev_tasks.is_deleted              AS 't_deleted'    ,
                              dev_tasks.admin_validation        AS 't_validated'  ,
                              dev_tasks.is_public               AS 't_public'     ,
                              dev_tasks.priority_level          AS 't_priority'   ,
                              dev_tasks.created_at              AS 't_created'    ,
                              dev_tasks.finished_at             AS 't_solved'     ,
                              dev_tasks.title_$lang             AS 't_title'      ,
                              dev_tasks.title_en                AS 't_title_en'   ,
                              dev_tasks.title_fr                AS 't_title_fr'   ,
                              dev_tasks.body_$lang              AS 't_body'       ,
                              dev_tasks.body_en                 AS 't_body_en'    ,
                              dev_tasks.body_fr                 AS 't_body_fr'    ,
                              dev_tasks.source_code_link        AS 't_source'     ,
                              users.id                          AS 'u_id'         ,
                              users.username                    AS 'u_name'       ,
                              dev_tasks_categories.id           AS 'tc_id'        ,
                              dev_tasks_categories.title_$lang  AS 'tc_name'      ,
                              dev_tasks_categories.title_en     AS 'tc_name_en'   ,
                              dev_tasks_categories.title_fr     AS 'tc_name_fr'   ,
                              dev_tasks_milestones.id           AS 'tm_id'        ,
                              dev_tasks_milestones.title_$lang  AS 'tm_name'      ,
                              dev_tasks_milestones.title_en     AS 'tm_name_en'   ,
                              dev_tasks_milestones.title_fr     AS 'tm_name_fr'
                    FROM      dev_tasks
                    LEFT JOIN users
                    ON        dev_tasks.fk_users                = users.id
                    LEFT JOIN dev_tasks_categories
                    ON        dev_tasks.fk_dev_tasks_categories = dev_tasks_categories.id
                    LEFT JOIN dev_tasks_milestones
                    ON        dev_tasks.fk_dev_tasks_milestones = dev_tasks_milestones.id
                    WHERE     dev_tasks.id                      = '$task_id' ",
                    fetch_row: true);

  // Format the data
  $task_deleted           = $dtask['t_deleted'];
  $task_validated         = $dtask['t_validated'];
  $task_public            = $dtask['t_public'];
  $task_title             = $dtask['t_title'];
  $task_title_en          = $dtask['t_title_en'];
  $task_title_fr          = $dtask['t_title_fr'];
  $task_created_at        = $dtask['t_created'];
  $task_solved_at         = $dtask['t_solved'];
  $task_body              = $dtask['t_body'];
  $task_body_en           = $dtask['t_body_en'];
  $task_body_fr           = $dtask['t_body_fr'];
  $task_source_code       = $dtask['t_source'];
  $task_priority          = $dtask['t_priority'];
  $task_reporter_id       = $dtask['u_id'];
  $task_reporter_name     = $dtask['u_name'];
  $task_category_id       = $dtask['tc_id'];
  $task_category_name     = $dtask['tc_name'];
  $task_category_name_en  = $dtask['tc_name_en'];
  $task_category_name_fr  = $dtask['tc_name_fr'];
  $task_milestone_id      = $dtask['tm_id'];
  $task_milestone_name    = $dtask['tm_name'];
  $task_milestone_name_en = $dtask['tm_name_en'];
  $task_milestone_name_fr = $dtask['tm_name_fr'];

  // Prepare the data for display
  if($format === 'html')
  {
    // Return null if the task should not be displayed
    if(!$is_admin && $task_deleted)
      return NULL;
    if(!$is_admin && !$task_validated)
      return NULL;
    if(!$is_admin && !$task_public)
      return NULL;

    // Assemble an array with the data
    $data['deleted']        = $task_deleted;
    $data['validated']      = $task_validated;
    $data['public']         = $task_public;
    $data['title']          = sanitize_output($task_title);
    $data['title_flex']     = ($task_title_en)
                            ? sanitize_output($task_title_en)
                            : sanitize_output($task_title_fr);
    $data['title_en']       = sanitize_output($task_title_en);
    $data['title_fr']       = sanitize_output($task_title_fr);
    $data['title_en_raw']   = $task_title_en;
    $data['title_fr_raw']   = $task_title_fr;
    $data['created']        = sanitize_output(date_to_text($task_created_at, strip_day: 1));
    $data['created_full']   = sanitize_output(date_to_text($task_created_at, include_time: 1));
    $data['created_since']  = sanitize_output(time_since($task_created_at));
    $data['creator']        = sanitize_output($task_reporter_name);
    $data['creator_id']     = sanitize_output($task_reporter_id);
    $data['solved']         = ($task_solved_at)
                            ? sanitize_output(date_to_text($task_solved_at, strip_day: 1))
                            : '';
    $data['solved_full']    = sanitize_output(date_to_text($task_solved_at, include_time: 1));
    $data['solved_since']   = sanitize_output(time_since($task_solved_at));
    $data['priority']       = sanitize_output($task_priority);
    $data['category']       = sanitize_output($task_category_name);
    $data['category_id']    = ($task_category_id) ? sanitize_output($task_category_id) : 0;
    $data['milestone']      = sanitize_output($task_milestone_name);
    $data['milestone_id']   = ($task_milestone_id) ? sanitize_output($task_milestone_id) : 0;
    $data['body']           = bbcodes(sanitize_output($task_body, preserve_line_breaks: true));
    $body_flex              = ($task_body_en) ? $task_body_en : $task_body_fr;
    $data['body_flex']      = bbcodes(sanitize_output($body_flex, preserve_line_breaks: true));
    $data['body_proposal']  = sanitize_output($body_flex);
    $data['body_en']        = sanitize_output($task_body_en);
    $data['body_fr']        = sanitize_output($task_body_fr);
    $data['source']         = ($task_source_code) ? sanitize_output($task_source_code) : '';
    $data['meta_desc']      = ($task_title_en)
                            ? 'Task #'.$task_id.': '.$task_title_en
                            : 'Task #'.$task_id.': '.$task_title_fr;
  }

  // Prepare the data for the API
  else if($format === 'api')
  {
    // Return null if the task should not be displayed in the public API
    if($task_deleted || !$task_validated || !$task_public)
      return NULL;

    // Task data
    $data['task']['id']               = (string)$task_id;
    $data['task']['link']             = sanitize_json($GLOBALS['website_url'].'pages/tasks/'.$task_id);
    $data['task']['status']           = ($task_solved_at)
                                      ? sanitize_json(__('tasks_list_solved'))
                                      : sanitize_json(__('tasks_list_state_'.$task_priority));
    $data['task']['title_en']         = sanitize_json($task_title_en) ?: NULL;
    $data['task']['title_fr']         = sanitize_json($task_title_fr) ?: NULL;
    $data['task']['description_en']   = sanitize_json(bbcodes_remove($task_body_en)) ?: NULL;
    $data['task']['description_fr']   = sanitize_json(bbcodes_remove($task_body_fr)) ?: NULL;
    $data['task']['source_code_link'] = sanitize_json($task_source_code) ?: NULL;

    // Category data
    if($task_category_id)
    {
      $data['task']['category']['name_en']  = sanitize_json($task_category_name_en) ?: NULL;
      $data['task']['category']['name_fr']  = sanitize_json($task_category_name_fr) ?: NULL;
    }
    else
      $data['task']['category'] = NULL;

    // Milestone data
    if($task_milestone_id)
    {
      $data['task']['milestone']['name_en'] = sanitize_json($task_milestone_name_en) ?: NULL;
      $data['task']['milestone']['name_fr'] = sanitize_json($task_milestone_name_fr) ?: NULL;
    }
    else
      $data['task']['milestone'] = NULL;

    // Creation data
    if($task_created_at)
    {
      $created_at_aware_datetime = date_to_aware_datetime($task_created_at);
      $data['task']['created_at']['datetime'] = $created_at_aware_datetime['datetime'];
      $data['task']['created_at']['timezone'] = $created_at_aware_datetime['timezone'];
    }
    else
      $data['task']['created_at'] = NULL;

    // Completion data
    if($task_solved_at)
    {
      $finished_at_aware_datetime = date_to_aware_datetime($task_solved_at);
      $data['task']['solved_at']['datetime']  = $finished_at_aware_datetime['datetime'];
      $data['task']['solved_at']['timezone']  = $finished_at_aware_datetime['timezone'];
    }
    else
      $data['task']['solved_at'] = NULL;

    // Reporter data
    if($task_reporter_id)
    {
      $data['task']['opened_by']['user_id']   = (string)$task_reporter_id;
      $data['task']['opened_by']['username']  = sanitize_json($task_reporter_name);
    }
    else
      $data['task']['opened_by'] = NULL;
  }

  // Return the array
  return $data;
}




/**
 * Fetches a list of tasks.
 *
 * @param   string  $sort_by    (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search     (OPTIONAL)  Search for specific field values.
 * @param   bool    $user_view  (OPTIONAL)  Views the list as a regular user even if the account is an administrator.
 * @param   string  $format     (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                           An array containing tasks.
 */

function tasks_list(  string  $sort_by    = 'status'  ,
                      array   $search     = array()   ,
                      bool    $user_view  = false     ,
                      string  $format     = 'html'    ) : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');
  require_included_file('functions_time.inc.php');
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_mathematics.inc.php');

  // Get the user's current language and access rights
  $lang     = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');
  $is_admin = ($user_view || $format === 'api') ? 0 : user_is_administrator();

  // Sanitize the search parameters
  $search_id          = sanitize_array_element($search, 'id', 'int', min: 0, default: 0);
  $search_title       = sanitize_array_element($search, 'title', 'string');
  $search_title_en    = sanitize_array_element($search, 'title_en', 'string');
  $search_title_fr    = sanitize_array_element($search, 'title_fr', 'string');
  $search_status      = sanitize_array_element($search, 'status', 'int', min: -2, default: 0);
  $search_status_id   = sanitize($search_status - 1, 'int', 0, 5);
  $search_open        = sanitize_array_element($search, 'open', 'int', min: 0, max: 1, default: 0);
  $search_created     = sanitize_array_element($search, 'created', 'int', min: 0, default: 0);
  $search_reporter    = sanitize_array_element($search, 'reporter', 'string');
  $search_reporter_id = sanitize_array_element($search, 'reporter_id', 'string');
  $search_category    = sanitize_array_element($search, 'category', 'int', min: -1, default: 0);
  $search_goal        = sanitize_array_element($search, 'goal', 'int', min: -1, default: 0);
  $search_admin       = sanitize_array_element($search, 'admin', 'int', min: 0, max: 5, default: 0);

  // Do not show deleted, unvalidated, private, or wrong language tasks to regular users
  $query_search = (!$is_admin) ? "  WHERE dev_tasks.is_deleted        = 0
                                    AND   dev_tasks.is_public         = 1
                                    AND   dev_tasks.admin_validation  = 1
                                    AND   dev_tasks.title_$lang      != '' " : " WHERE 1 = 1 ";

  // Show less data in roadmap view
  if($sort_by === 'roadmap')
    $query_search .= "  AND dev_tasks.is_deleted              = 0
                        AND dev_tasks.admin_validation        = 1
                        AND dev_tasks.fk_dev_tasks_milestones > 0 ";

  // Search through the data: Task status
  if($search_status === -2 || $search_open)
    $query_search .= "  AND dev_tasks.finished_at                       = 0                 ";
  else if($search_status === -1)
    $query_search .= "  AND dev_tasks.finished_at                       > 0                 ";
  else if($search_status > 0 && $search_status <= 6)
    $query_search .= "  AND dev_tasks.priority_level                    = '$search_status_id'
                        AND dev_tasks.finished_at                       = 0                 ";
  else if($search_status > 6)
    $query_search .= "  AND YEAR(FROM_UNIXTIME(dev_tasks.finished_at))  = '$search_status'  ";

  // Search through the data: Categories
  if($search_category === -1)
    $query_search .= " AND  dev_tasks.fk_dev_tasks_categories = 0                   ";
  else if($search_category)
    $query_search .= " AND  dev_tasks.fk_dev_tasks_categories = '$search_category'  ";

  // Search through the data: Goals
  if($search_goal === -1)
    $query_search .= " AND  dev_tasks.fk_dev_tasks_milestones = 0               ";
  else if($search_goal)
    $query_search .= " AND  dev_tasks.fk_dev_tasks_milestones = '$search_goal'  ";

  // Search through the data: Admin filters
  if($is_admin)
  {
    $query_search .= match($search_admin)
    {
      1       => " AND  dev_tasks.admin_validation  = 0 "   ,
      2       => " AND  dev_tasks.is_deleted        = 1 "   ,
      3       => " AND  dev_tasks.is_public         = 0 "   ,
      4       => " AND  dev_tasks.title_en          = '' "  ,
      5       => " AND  dev_tasks.title_fr          = '' "  ,
      default => ""                                         ,
    };
  }

  // Search through the data: Other searches
  $query_search .= ($search_id)       ? " AND dev_tasks.id                              = '$search_id'          " : "";
  $query_search .= ($search_title)    ? " AND dev_tasks.title_$lang                  LIKE '%$search_title%'     " : "";
  $query_search .= ($search_title_en) ? " AND dev_tasks.title_en                     LIKE '%$search_title_en%'  " : "";
  $query_search .= ($search_title_fr) ? " AND dev_tasks.title_fr                     LIKE '%$search_title_fr%'  " : "";
  $query_search .= ($search_created)  ? " AND YEAR(FROM_UNIXTIME(dev_tasks.created_at)) = '$search_created'     " : "";
  $query_search .= ($search_reporter) ? " AND users.username                         LIKE '%$search_reporter%'  " : "";
  $query_search .= ($search_reporter_id) ? " AND users.id                               = '$search_reporter_id' " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'id'          => " ORDER BY dev_tasks.id                        ASC     " ,
    'description' => " ORDER BY dev_tasks.title_$lang               ASC     " ,
    'created'     => " ORDER BY dev_tasks.created_at                DESC    " ,
    'reporter'    => " ORDER BY users.username                      ASC     ,
                                dev_tasks.finished_at               != ''   ,
                                dev_tasks.finished_at               DESC    ,
                                dev_tasks.priority_level            DESC    ,
                                dev_tasks.created_at                DESC    " ,
    'category'    => " ORDER BY dev_tasks_categories.id             IS NULL ,
                                dev_tasks_categories.title_$lang    ASC     ,
                                dev_tasks.finished_at               != ''   ,
                                dev_tasks.finished_at               DESC    ,
                                dev_tasks.priority_level            DESC    ,
                                dev_tasks.created_at                DESC    " ,
    'goal'        => " ORDER BY dev_tasks.finished_at               != ''   ,
                                dev_tasks_milestones.id             IS NULL ,
                                dev_tasks_milestones.sorting_order  DESC    ,
                                dev_tasks.finished_at               DESC    ,
                                dev_tasks.priority_level            DESC    ,
                                dev_tasks.created_at                DESC    " ,
    'roadmap'     => " ORDER BY dev_tasks_milestones.id             IS NULL ,
                                dev_tasks_milestones.sorting_order  DESC    ,
                                dev_tasks.finished_at               > 0     ,
                                dev_tasks.finished_at               DESC    ,
                                dev_tasks.priority_level            DESC    ,
                                dev_tasks.created_at                DESC    " ,
    'admin'       => " ORDER BY dev_tasks.admin_validation          ASC     ,
                                dev_tasks.is_deleted                DESC    ,
                                dev_tasks.finished_at               > 0     ,
                                dev_tasks.is_public                 ASC     ,
                                dev_tasks.priority_level            DESC    ,
                                dev_tasks.finished_at               DESC    ,
                                dev_tasks.created_at                DESC    " ,
    default       => " ORDER BY dev_tasks.admin_validation          = 1     ,
                                dev_tasks.is_deleted                != ''   ,
                                dev_tasks.finished_at               != ''   ,
                                dev_tasks.finished_at               DESC    ,
                                dev_tasks.priority_level            DESC    ,
                                dev_tasks.created_at                DESC    " ,
  };

  // Fetch the tasks
  $qtasks = query(" SELECT    dev_tasks.id                        AS 't_id'             ,
                              dev_tasks.is_deleted                AS 't_deleted'        ,
                              dev_tasks.created_at                AS 't_created'        ,
                              dev_tasks.finished_at               AS 't_finished'       ,
                              dev_tasks.is_public                 AS 't_public'         ,
                              dev_tasks.admin_validation          AS 't_validated'      ,
                              dev_tasks.priority_level            AS 't_status'         ,
                              dev_tasks.title_en                  AS 't_title_en'       ,
                              dev_tasks.title_fr                  AS 't_title_fr'       ,
                              dev_tasks_categories.id             AS 't_category_id'    ,
                              dev_tasks_categories.title_$lang    AS 't_category'       ,
                              dev_tasks_categories.title_en       AS 't_category_en'    ,
                              dev_tasks_categories.title_fr       AS 't_category_fr'    ,
                              dev_tasks_milestones.id             AS 't_milestone_id'   ,
                              dev_tasks_milestones.title_$lang    AS 't_milestone'      ,
                              dev_tasks_milestones.title_en       AS 't_milestone_en'   ,
                              dev_tasks_milestones.title_fr       AS 't_milestone_fr'   ,
                              dev_tasks_milestones.summary_$lang  AS 't_milestone_body' ,
                              users.id                            AS 't_author_id'      ,
                              users.username                      AS 't_author'
                    FROM      dev_tasks
                    LEFT JOIN dev_tasks_categories  ON dev_tasks.fk_dev_tasks_categories  = dev_tasks_categories.id
                    LEFT JOIN dev_tasks_milestones  ON dev_tasks.fk_dev_tasks_milestones  = dev_tasks_milestones.id
                    LEFT JOIN users                 ON dev_tasks.fk_users                 = users.id
                              $query_search
                              $query_sort ");

  // Initialize the finished task counter
  $total_tasks_finished = 0;

  // Initialize the years array
  $tasks_created_years  = array();
  $tasks_solved_years   = array();

  // Loop through the results
  for($i = 0; $row = query_row($qtasks); $i++)
  {
    // Format the data
    $task_id              = $row['t_id'];
    $task_deleted         = $row['t_deleted'];
    $task_public          = $row['t_public'];
    $task_validated       = $row['t_validated'];
    $task_finished        = $row['t_finished'];
    $task_status          = $row['t_status'];
    $task_title_en        = $row['t_title_en'];
    $task_title_fr        = $row['t_title_fr'];
    $task_created_at      = $row['t_created'];
    $task_author_id       = $row['t_author_id'];
    $task_author          = $row['t_author'];
    $task_category        = $row['t_category'];
    $task_category_en     = $row['t_category_en'];
    $task_category_fr     = $row['t_category_fr'];
    $task_category_id     = $row['t_category_id'];
    $task_milestone       = $row['t_milestone'];
    $task_milestone_en    = $row['t_milestone_en'];
    $task_milestone_fr    = $row['t_milestone_fr'];
    $task_milestone_id    = $row['t_milestone_id'];
    $task_milestone_body  = $row['t_milestone_body'];

    // Prepare the data for display
    if($format === 'html')
    {
      // Task data
      $data[$i]['id']         = sanitize_output($task_id);
      $task_css               = ($task_finished) ? 'task_solved' : 'task_status_'.sanitize_output($task_status);
      $data[$i]['css_row']    = ($task_deleted) ? 'brown' : $task_css;
      $task_css               = ($task_status < 2) ? ' italics' : '';
      $task_css               = ($task_status > 3) ? ' bold' : $task_css;
      $task_css               = ($task_status > 4) ? ' bold uppercase underlined' : $task_css;
      $data[$i]['css_status'] = ($task_css && !$task_finished) ? $task_css : '';
      $task_title             = ($lang === 'en') ? $task_title_en : $task_title_fr;
      $task_title             = ($lang === 'en' && !$task_title_en) ? $task_title_fr : $task_title;
      $task_title             = ($lang !== 'en' && !$task_title_en) ? $task_title_en : $task_title;
      $task_title             = ($sort_by === 'roadmap' && !$task_public)
                              ? __('tasks_roadmap_private').$task_title
                              : $task_title;
      $data[$i]['title']      = sanitize_output(string_truncate($task_title, 42, '…'));
      $data[$i]['road_title'] = sanitize_output(string_truncate($task_title, 50, '…'));
      $data[$i]['fulltitle']  = (strlen($task_title) > 42) ? sanitize_output($task_title) : '';
      $data[$i]['road_full']  = (strlen($task_title) > 50) ? sanitize_output($task_title) : '';
      $data[$i]['shorttitle'] = sanitize_output(string_truncate($task_title, 38, '…'));
      $data[$i]['status']     = ($task_finished)
                              ? sanitize_output(__('tasks_list_solved'))
                              : sanitize_output(__('tasks_list_state_'.$task_status));
      $data[$i]['created']    = sanitize_output(time_since($task_created_at));
      $data[$i]['solved']     = ($task_finished) ? sanitize_output(time_since($task_finished)) : __('tasks_roadmap_unsolved');
      $data[$i]['author']     = sanitize_output($task_author);
      $data[$i]['category']   = sanitize_output($task_category);
      $data[$i]['milestone']  = sanitize_output($task_milestone);
      $data[$i]['goal_id']    = sanitize_output($task_milestone_id);
      $data[$i]['goal_body']  = bbcodes(sanitize_output($task_milestone_body, preserve_line_breaks: true));
      $data[$i]['nolang_en']  = (!$task_title_en);
      $data[$i]['nolang_fr']  = (!$task_title_fr);
      $data[$i]['deleted']    = ($task_deleted);
      $data[$i]['private']    = (!$task_public);
      $data[$i]['new']        = (!$task_validated);

      // Count the finished tasks
      $total_tasks_finished += ($task_finished) ? 1 : 0;

      // Fill up the years arrays
      if(!in_array(date('Y', $task_created_at), $tasks_created_years))
        array_push($tasks_created_years, sanitize_output(date('Y', $task_created_at)));
      if($task_finished && !in_array(date('Y', $task_finished), $tasks_solved_years))
        array_push($tasks_solved_years, sanitize_output(date('Y', $task_finished)));
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      // Task data
      $data[$i]['id']           = (string)$task_id;
      $data[$i]['link']         = sanitize_json($GLOBALS['website_url'].'pages/tasks/'.$task_id);
      $data[$i]['status']       = ($task_finished)
                                ? sanitize_json(__('tasks_list_solved'))
                                : sanitize_json(__('tasks_list_state_'.$task_status));
      $data[$i]['title_en']     = sanitize_json($task_title_en) ?: NULL;
      $data[$i]['title_fr']     = sanitize_json($task_title_fr) ?: NULL;

      // Category data
      if($task_category_id)
      {
        $data[$i]['category']['name_en']  = sanitize_json($task_category_en) ?: NULL;
        $data[$i]['category']['name_fr']  = sanitize_json($task_category_fr) ?: NULL;
      }
      else
        $data[$i]['category'] = NULL;

      // Milestone data
      if($task_milestone_id)
      {
        $data[$i]['milestone']['name_en'] = sanitize_json($task_milestone_en) ?: NULL;
        $data[$i]['milestone']['name_fr'] = sanitize_json($task_milestone_fr) ?: NULL;
      }
      else
        $data[$i]['milestone'] = NULL;

      // Creation data
      if($task_created_at)
      {
        $created_at_aware_datetime = date_to_aware_datetime($task_created_at);
        $data[$i]['created_at']['datetime'] = $created_at_aware_datetime['datetime'];
        $data[$i]['created_at']['timezone'] = $created_at_aware_datetime['timezone'];
      }
      else
        $data[$i]['created_at'] = NULL;

      // Completion data
      if($task_finished)
      {
        $finished_at_aware_datetime = date_to_aware_datetime($task_finished);
        $data[$i]['solved_at']['datetime']  = $finished_at_aware_datetime['datetime'];
        $data[$i]['solved_at']['timezone']  = $finished_at_aware_datetime['timezone'];
      }
      else
        $data[$i]['solved_at'] = NULL;

      // Reporter data
      if($task_author_id)
      {
        $data[$i]['opened_by']['user_id']   = (string)$task_author_id;
        $data[$i]['opened_by']['username']  = sanitize_json($task_author);
      }
      else
        $data[$i]['opened_by'] = NULL;
    }
  }

  // Task stats
  if($format === 'html')
  {
    // Add the number of rows to the data
    $data['rows'] = $i;

    // Calculate the remaining totals
    $total_tasks_todo       = $data['rows'] - $total_tasks_finished;
    $total_tasks_percentage = maths_percentage_of($total_tasks_finished, $data['rows']);

    // Add the totals to the data
    $data['finished'] = sanitize_output($total_tasks_finished);
    $data['todo']     = sanitize_output($total_tasks_todo);
    $data['percent']  = sanitize_output(number_display_format($total_tasks_percentage, 'percentage', 0));

    // Sort the years arrays
    rsort($tasks_created_years);
    rsort($tasks_solved_years);

    // Add the years to the data
    $data['years_created']  = $tasks_created_years;
    $data['years_solved']   = $tasks_solved_years;
  }

  // Give a default return value when no tasks are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('tasks' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new task.
 *
 * @param   array       $contents   The contents of the task.
 *
 * @return  string|int              An error string, or the task's id if it was properly created.
 */

function tasks_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $task_title_en  = sanitize_array_element($contents, 'title_en', 'string');
  $task_title_fr  = sanitize_array_element($contents, 'title_fr', 'string');
  $task_body_en   = sanitize_array_element($contents, 'body_en', 'string');
  $task_body_fr   = sanitize_array_element($contents, 'body_fr', 'string');
  $task_priority  = sanitize_array_element($contents, 'priority', 'int', min: 0, max: 5, default: 0);
  $task_category  = sanitize_array_element($contents, 'category', 'int', min: 0, default: 0);
  $task_milestone = sanitize_array_element($contents, 'milestone', 'int', min: 0, default: 0);
  $task_private   = sanitize_array_element($contents, 'private', 'int', min: 0, max: 1, default: 0);
  $task_public    = ($task_private) ? 0 : 1;
  $task_silent    = sanitize_array_element($contents, 'silent', 'int', min: 0, max: 1, default: 0);

  // Error: No title
  if(!$task_title_en && !$task_title_fr)
    return __('tasks_add_error_title');

  // Fetch the current user's ID and timestamp
  $user_id    = sanitize(user_get_id(), 'int', 0);
  $timestamp  = sanitize(time(), 'int', 0);

  // Create the task
  query(" INSERT INTO dev_tasks
          SET         dev_tasks.fk_users                  = '$user_id'        ,
                      dev_tasks.created_at                = '$timestamp'      ,
                      dev_tasks.admin_validation          = 1                 ,
                      dev_tasks.is_public                 = '$task_public'    ,
                      dev_tasks.priority_level            = '$task_priority'  ,
                      dev_tasks.title_en                  = '$task_title_en'  ,
                      dev_tasks.title_fr                  = '$task_title_fr'  ,
                      dev_tasks.body_en                   = '$task_body_en'   ,
                      dev_tasks.body_fr                   = '$task_body_fr'   ,
                      dev_tasks.fk_dev_tasks_categories   = '$task_category'  ,
                      dev_tasks.fk_dev_tasks_milestones   = '$task_milestone' ");

  // Fetch the newly created task's id
  $task_id = query_id();

  // If the task is private or must be created silently, stop here and return the task's id
  if($task_private || $task_silent)
    return $task_id;

  // Determine the activity language
  $activity_lang  = ($task_title_en) ? 'EN' : '';
  $activity_lang .= ($task_title_fr) ? 'FR' : '';

  // Fetch the raw task title
  $task_title_en_raw = ($task_title_en) ? $contents['title_en'] : '';
  $task_title_fr_raw = ($task_title_fr) ? $contents['title_fr'] : '';

  // Fetch the current user's username
  $admin_username = user_get_username();

  // Activity log
  log_activity( 'dev_task_new'                            ,
                language:             $activity_lang      ,
                activity_id:          $task_id            ,
                activity_summary_en:  $task_title_en_raw  ,
                activity_summary_fr:  $task_title_fr_raw  ,
                username:             $admin_username     );

  // IRC bot message
  if($task_title_en)
    irc_bot_send_message("A new task has been added to the to-do list by $admin_username : $task_title_en_raw - ".$GLOBALS['website_url']."pages/tasks/$task_id", 'dev');

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($user_id);

  // Return the task's id
  return $task_id;
}




/**
 * Creates a new unvalidated task proposal.
 *
 * @param   string        $body   The task proposal's body.
 *
 * @return  string|int            A string if an error happened, or the newly created task's id.
*/

function tasks_propose( string $body ) : mixed
{
  // Require users to be logged in to run this action
  user_restrict_to_users();

  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Sanitize the data
  $user_id    = sanitize(user_get_id(), 'int', 1);
  $username   = user_get_username();
  $body       = sanitize($body, 'string');
  $timestamp  = sanitize(time(), 'int', 0);

  // Error: No body
  if(!str_replace(' ', '', $body))
    return __('tasks_proposal_error');

  // Check if the user is flooding the website
  if(!flood_check(error_page: false))
    return __('tasks_proposal_flood');

  // Determine the body's language and the task's title
  $lang       = string_change_case(user_get_language(), 'lowercase');
  $task_title = ($lang === 'en') ? "Unvalidated task" : "Tâche non validée";

  // Create the unvalidated task
  query(" INSERT INTO dev_tasks
          SET         dev_tasks.fk_users          = '$user_id'    ,
                      dev_tasks.created_at        = '$timestamp'  ,
                      dev_tasks.is_public         = 1             ,
                      dev_tasks.title_$lang       = '$task_title' ,
                      dev_tasks.body_$lang        = '$body'       ");

  // Get the newly created task's id
  $task_id = query_id();

  // IRC bot notification
  irc_bot_send_message("Task proposal submitted by $username - ".$GLOBALS['website_url']."pages/tasks/$task_id", 'admin');

  // Return the task's id
  return $task_id;
}




/**
 * Approves an unvalidated task proposal.
 *
 * @param   int           $task_id    The ID of the task being approved.
 * @param   array         $contents   The contents of the task being approved.
 *
 * @return  string|null               An error string, or null if the task was properly approved.
 */

function tasks_approve( int   $task_id  ,
                        array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $task_id        = sanitize($task_id, 'int', 0);
  $task_title_en  = sanitize_array_element($contents, 'title_en', 'string');
  $task_title_fr  = sanitize_array_element($contents, 'title_fr', 'string');
  $task_body_en   = sanitize_array_element($contents, 'body_en', 'string');
  $task_body_fr   = sanitize_array_element($contents, 'body_fr', 'string');
  $task_priority  = sanitize_array_element($contents, 'priority', 'int', min: 0, max: 5, default: 0);
  $task_category  = sanitize_array_element($contents, 'category', 'int', min: 0, default: 0);
  $task_milestone = sanitize_array_element($contents, 'milestone', 'int', min: 0, default: 0);
  $task_private   = sanitize_array_element($contents, 'private', 'int', min: 0, max: 1, default: 0);
  $task_public    = ($task_private) ? 0 : 1;
  $task_silent    = sanitize_array_element($contents, 'silent', 'int', min: 0, max: 1, default: 0);

  // Error: No title
  if(!$task_title_en && !$task_title_fr)
    return __('tasks_add_error_title');

  // Error: Task does not exist
  if(!database_row_exists('dev_tasks', $task_id))
    return __('tasks_details_error');

  // Update the task
  query(" UPDATE      dev_tasks
          SET         dev_tasks.admin_validation          = 1                 ,
                      dev_tasks.is_public                 = '$task_public'    ,
                      dev_tasks.priority_level            = '$task_priority'  ,
                      dev_tasks.title_en                  = '$task_title_en'  ,
                      dev_tasks.title_fr                  = '$task_title_fr'  ,
                      dev_tasks.body_en                   = '$task_body_en'   ,
                      dev_tasks.body_fr                   = '$task_body_fr'   ,
                      dev_tasks.fk_dev_tasks_categories   = '$task_category'  ,
                      dev_tasks.fk_dev_tasks_milestones   = '$task_milestone'
          WHERE       dev_tasks.id                        = '$task_id'        ");

  // Fetch the task's author
  $dtask = query("  SELECT    dev_tasks.id    AS 't_id'   ,
                              users.id        AS 'tu_id'  ,
                              users.username  AS 'tu_nick'
                    FROM      dev_tasks
                    LEFT JOIN users ON dev_tasks.fk_users = users.id
                    WHERE     dev_tasks.id = '$task_id' ",
                    fetch_row: true);
  $username = $dtask['tu_nick'];
  $user_id  = $dtask['tu_id'];

  // Fetch some data about the user
  $admin_id = sanitize(user_get_id(), 'int', 0);
  $user_id  = sanitize($user_id, 'int', 0);
  $lang     = user_get_language($user_id);
  $path     = root_path();

  // Prepare the message's title
  $message_title = ($lang === 'FR') ? 'Tâche acceptée' : 'Task proposal approved';

  // Prepare the message's body
  if($lang === 'FR')
    $message_body = <<<EOT
[url={$path}pages/tasks/{$task_id}]Votre proposition de tâche a été approuvée.[/url]

Nous vous remercions pour votre participation au développement de NoBleme.
EOT;
  else
    $message_body = <<<EOT
[url={$path}pages/tasks/{$task_id}]Your task proposal has been approved.[/url]

Thank you for helping NoBleme's development.
EOT;

  // If the task is private, prepare a different message
  if($task_private && $lang === 'FR')
    $message_body = <<<EOT
Une proposition de [url={$path}pages/tasks/list]tâche[/url] que vous avez fait récemment a été acceptée.

La tâche va rester privée pour le moment : soit elle est sensible pour la sécurité du site, soit il s'agit d'une idée qui sera meilleure sous la forme d'une surprise pour le reste des personnes utilisant le site.

Merci d'en conserver le secret. Nous vous remercions pour votre participation au développement de NoBleme.
EOT;
  else if($task_private)
    $message_body = <<<EOT
You made a [url={$path}pages/tasks/list]task[/url] proposal which has been approved.

The task will remain private for now: it is either too sensitive for the website's security, or is a great idea that would be better kept secret in order to surprise everyone else once it is done.

Thank you for helping NoBleme's development. Please keep this secret for now!
EOT;

  // Send the notification message unless it's being sent to self
  if($user_id !== $admin_id)
    private_message_send( $message_title          ,
                          $message_body           ,
                          recipient: $user_id     ,
                          sender: 0               ,
                          true_sender: $admin_id  ,
                          hide_admin_mail: true   );

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($user_id);

  // If the task is private or must be created silently, stop here and return null
  if($task_private || $task_silent)
    return null;

  // Determine the activity language
  $activity_lang  = ($task_title_en) ? 'EN' : '';
  $activity_lang .= ($task_title_fr) ? 'FR' : '';

  // Fetch the raw task title
  $task_title_en_raw = ($task_title_en) ? $contents['title_en'] : '';
  $task_title_fr_raw = ($task_title_fr) ? $contents['title_fr'] : '';

  // Activity log
  log_activity( 'dev_task_new'                            ,
                language:             $activity_lang      ,
                activity_id:          $task_id            ,
                activity_summary_en:  $task_title_en_raw  ,
                activity_summary_fr:  $task_title_fr_raw  ,
                username:             $username           );

  // IRC bot message
  if($task_title_en)
    irc_bot_send_message("A new task has been added to the to-do list by $username : $task_title_en_raw - ".$GLOBALS['website_url']."pages/tasks/$task_id", 'dev');

  // All went well, return NULL
  return null;
}




/**
 * Rejects and hard deletes an unvalidated task proposal.
 *
 * @param   int           $task_id                The ID of the task being rejected.
 * @param   string        $reason     (OPTIONAL)  The reason for which the proposal was rejected.
 * @param   bool          $is_silent  (OPTIONAL)  Whether to make it a silent rejection (no private message).
 *
 * @return  string|null                           An error string, or null if the task was properly rejected.
 */

function tasks_reject(  int     $task_id            ,
                        string  $reason     = ''    ,
                        bool    $is_silent  = true  ) : mixed
{
  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task's id
  $task_id = sanitize($task_id, 'int', 0);

  // Error: Task does not exist
  if(!database_row_exists('dev_tasks', $task_id))
    return __('tasks_details_error');

  // Fetch the task's author
  $dtask = query("  SELECT    dev_tasks.id    AS 't_id' ,
                              users.id        AS 'tu_id'
                    FROM      dev_tasks
                    LEFT JOIN users ON dev_tasks.fk_users = users.id
                    WHERE     dev_tasks.id = '$task_id' ",
                    fetch_row: true);
  $user_id  = $dtask['tu_id'];

  // Delete the task
  query(" DELETE FROM dev_tasks
          WHERE       dev_tasks.id = '$task_id' ");

  // If silent mode is requested, stop here
  if($is_silent)
    return null;

  // Fetch some data about the user
  $lang     = user_get_language($user_id);
  $path     = root_path();
  $admin_id = user_get_id();

  // Prepare the message's title
  $message_title = ($lang === 'FR') ? 'Tâche refusée' : 'Task proposal rejected';

  // If a reason is specified, prepare it
  if($reason && $lang === 'FR')
    $reason = <<<EOT

Votre proposition a été rejetée pour la raison suivante : {$reason}

EOT;
  else if($reason)
    $reason = <<<EOT

Your proposal has been rejected for the following reason: {$reason}

EOT;

  // Prepare the message's body
  if($lang === 'FR')
    $message_body = <<<EOT
Vous avez fait une [url={$path}pages/tasks/proposal]proposition de tâche[/url], qui a été rejetée.
{$reason}
Malgré ce rejet, nous vous encourageons à continuer à contribuer dans le futur en rapportant des bugs ou en proposant vos idées.

Nous vous remercions pour votre participation au développement de NoBleme.
EOT;
  else
    $message_body = <<<EOT
You made a [url={$path}pages/tasks/proposal]task proposal[/url], which has been rejected.
{$reason}
Despite this rejection, we encourage you to continue contributing to NoBleme in the future by reporting bugs or suggesting your ideas.

Thank you for helping NoBleme's development.
EOT;

  // Send the notification message unless it's being sent to self
  if($user_id !== $admin_id)
    private_message_send( $message_title          ,
                          $message_body           ,
                          recipient: $user_id     ,
                          sender: 0               ,
                          true_sender: $admin_id  ,
                          hide_admin_mail: true   );

  // All went well, return NULL
  return null;
}




/**
 * Marks a task as solved.
 *
 * @param   int           $task_id                  The ID of the task being solved.
 * @param   string        $source       (OPTIONAL)  A link to the patch's source code.
 * @param   bool          $is_silent    (OPTIONAL)  Whether to make it a silent solving (no IRC message).
 * @param   bool          $is_stealthy  (OPTIONAL)  Whether to send a private message to the task's original author.
 *
 * @return  string|null                             An error string, or null if the task was properly solved.
 */

function tasks_solve( int     $task_id              ,
                      string  $source       = ''    ,
                      bool    $is_silent    = true  ,
                      bool    $is_stealthy  = true  ) : mixed
{
  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $task_id    = sanitize($task_id, 'int', 0);
  $source     = sanitize($source, 'string');
  $admin_id   = user_get_id();
  $timestamp  = sanitize(time(), 'int', 0);

  // Error: Task does not exist
  if(!database_row_exists('dev_tasks', $task_id))
    return __('tasks_details_error');

  // Fetch data on the task
  $task_data = tasks_get($task_id);

  // Error: Task has already been solved
  if($task_data['solved'])
    return __('tasks_solve_impossible');

  // Error: Task has been deleted
  if($task_data['deleted'])
    return __('tasks_details_error');

  // Mark the task as solved
  query(" UPDATE  dev_tasks
          SET     dev_tasks.finished_at       = '$timestamp'  ,
                  dev_tasks.source_code_link  = '$source'
          WHERE   dev_tasks.id                = '$task_id'    ");

  // If the task is private, end here
  if(!$task_data['public'])
    return null;

  // Determine the activity language
  $activity_lang  = ($task_data['title_en_raw']) ? 'EN' : '';
  $activity_lang .= ($task_data['title_fr_raw']) ? 'FR' : '';

  // Fetch the raw task title
  $task_title_en_raw = $task_data['title_en_raw'];
  $task_title_fr_raw = $task_data['title_fr_raw'];

  // Activity log
  if(!$is_silent)
    log_activity( 'dev_task_finished'                       ,
                  language:             $activity_lang      ,
                  activity_id:          $task_id            ,
                  activity_summary_en:  $task_title_en_raw  ,
                  activity_summary_fr:  $task_title_fr_raw  );

  // IRC bot message
  if($task_title_en_raw && !$is_silent)
  {
    irc_bot_send_message("A task has been solved: $task_title_en_raw - ".$GLOBALS['website_url']."pages/tasks/$task_id", 'dev');
    if($source)
      irc_bot_send_message("Patch link: $source", 'dev');
  }

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($task_data['creator_id']);

  // If stealthy mode is requested or the author is the one currently approving the task, stop here
  if($is_stealthy || (int)$task_data['creator_id'] === user_get_id())
    return null;

  // Fetch some data about the user
  $user_id  = $task_data['creator_id'];
  $lang     = user_get_language($user_id);
  $path     = root_path();
  $admin_id = user_get_id();

  // Prepare the message's title
  $message_title = ($lang === 'FR') ? 'Tâche résolue' : 'Task solved';

  // Prepare the message's body
  if($lang === 'FR')
    $message_body = <<<EOT
Une tâche que vous avez proposée a été résolue : [url={$path}pages/tasks/{$task_id}]Tâche #{$task_id}[/url].

Nous vous remercions pour votre participation au développement de NoBleme.
EOT;
  else
    $message_body = <<<EOT
A task you opened has been solved: [url={$path}pages/tasks/{$task_id}]Task #{$task_id}[/url].

Thank you for helping NoBleme's development.
EOT;

  // Send the notification message
  private_message_send( $message_title          ,
                        $message_body           ,
                        recipient: $user_id     ,
                        sender: 0               ,
                        true_sender: $admin_id  ,
                        hide_admin_mail: true   );

  // All went well, return null
  return null;
}




/**
 * Modifies an existing task
 *
 * @param   int           $task_id    The ID of the task being solved.
 * @param   array         $contents   The contents of the task.
 *
 * @return  string|null               An error string, or null if the task was properly modified.
 */

function tasks_edit(  int     $task_id  ,
                      array   $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('tasks.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $task_id        = sanitize($task_id, 'int', 0);
  $task_title_en  = sanitize_array_element($contents, 'title_en', 'string');
  $task_title_fr  = sanitize_array_element($contents, 'title_fr', 'string');
  $task_body_en   = sanitize_array_element($contents, 'body_en', 'string');
  $task_body_fr   = sanitize_array_element($contents, 'body_fr', 'string');
  $task_priority  = sanitize_array_element($contents, 'priority', 'int', min: 0, max: 5, default: 0);
  $task_category  = sanitize_array_element($contents, 'category', 'int', min: 0, default: 0);
  $task_milestone = sanitize_array_element($contents, 'milestone', 'int', min: 0, default: 0);
  $task_source    = sanitize_array_element($contents, 'source', 'string');
  $task_author    = (isset($contents['author'])) ? $contents['author'] : 0;
  $task_private   = sanitize_array_element($contents, 'private', 'int', min: 0, max: 1, default: 0);
  $task_public    = ($task_private) ? 0 : 1;
  $task_solved    = sanitize_array_element($contents, 'solved', 'int', min: 0, max: 1, default: 0);

  // Error: No title
  if(!$task_title_en && !$task_title_fr)
    return __('tasks_add_error_title');

  // Error: Task does not exist
  if(!database_row_exists('dev_tasks', $task_id))
    return __('tasks_details_error');

  // Fetch the task's author
  if($task_author)
    $task_author = sanitize(user_fetch_id($task_author), 'int', 0);

  // Error: Author does not exist
  if(!$task_author)
    return __('tasks_edit_no_author');

  // Prepare an extra statement if the task hasn't been solved or is being unsolved
  $query_solved = (!$task_solved) ? " , dev_tasks.finished_at = 0 " : "";

  // Update the task
  query(" UPDATE      dev_tasks
          SET         dev_tasks.fk_users                  = '$task_author'    ,
                      dev_tasks.is_public                 = '$task_public'    ,
                      dev_tasks.priority_level            = '$task_priority'  ,
                      dev_tasks.title_en                  = '$task_title_en'  ,
                      dev_tasks.title_fr                  = '$task_title_fr'  ,
                      dev_tasks.body_en                   = '$task_body_en'   ,
                      dev_tasks.body_fr                   = '$task_body_fr'   ,
                      dev_tasks.fk_dev_tasks_categories   = '$task_category'  ,
                      dev_tasks.fk_dev_tasks_milestones   = '$task_milestone' ,
                      dev_tasks.source_code_link          = '$task_source'
                      $query_solved
          WHERE       dev_tasks.id                        = '$task_id'        ");

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($task_author);

  // All went well, return null
  return null;
}




/**
 * Soft deletes an existing task.
 *
 * @param   int   $task_id  The task's id.
 *
 * @return  void
 */

function tasks_delete( int $task_id ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task's id
  $task_id = sanitize($task_id, 'int', 0);

  // Fetch data on the task
  $task_data = tasks_get($task_id);

  // Proceed only if the task exists
  if(!isset($task_data))
    return;

  // Proceed only if the task has already been validated
  if(!$task_data['validated'])
    return;

  // Soft delete the task
  query(" UPDATE  dev_tasks
          SET     dev_tasks.is_deleted  = 1
          WHERE   dev_tasks.id          = '$task_id' ");

  // Delete related task activity
  log_activity_delete(  'dev_task'                  ,
                        activity_id:      $task_id  ,
                        global_type_wipe: true      );

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($task_data['creator_id']);
}




/**
 * Restores a deleted task.
 *
 * @param   int   $task_id  The task's id.
 *
 * @return  void
 */

function tasks_restore( int $task_id ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task's id
  $task_id = sanitize($task_id, 'int', 0);

  // Fetch data on the task
  $task_data = tasks_get($task_id);

  // Proceed only if the task exists
  if(!isset($task_data))
    return;

  // Soft delete the task
  query(" UPDATE  dev_tasks
          SET     dev_tasks.is_deleted  = 0
          WHERE   dev_tasks.id          = '$task_id' ");

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($task_data['creator_id']);
}




/**
 * Hard deletes a deleted task.
 *
 * @param   int   $task_id  The task's id.
 *
 * @return  void
 */

function tasks_delete_hard( int $task_id ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task's id
  $task_id = sanitize($task_id, 'int', 0);

  // Fetch data on the task
  $task_data = tasks_get($task_id);

  // Proceed only if the task exists
  if(!isset($task_data))
    return;

  // Proceed only if the task has already been deleted
  if(!$task_data['deleted'])
    return;

  // Hard delete the task
  query(" DELETE FROM dev_tasks
          WHERE       dev_tasks.id = '$task_id' ");

  // Recalculate stats for the task's submitter
  tasks_stats_recalculate_user($task_data['creator_id']);
}




/**
 * Fetches a list of task categories.
 *
 * @param   bool    $exclude_archived   (OPTIONAL)  Do not show archived categories.
 * @param   bool    $sort_by_archived   (OPTIONAL)  Active categories will appear below archived categories.
 *
 * @return  array                                   An array containing task categories.
 */

function tasks_categories_list( bool  $exclude_archived = false ,
                                bool  $sort_by_archived = false ) : array
{
  // Get the user's current language and access rights
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Exclude archived categories if requested
  $query_archived = ($exclude_archived) ? ' WHERE dev_tasks_categories.is_archived = 0 ' : '';

  // Sort the categories
  if($sort_by_archived)
    $query_sort = " ORDER BY  dev_tasks_categories.is_archived  ASC ,
                              dev_tasks_categories.title_$lang  ASC ";
  else
    $query_sort = " ORDER BY  dev_tasks_categories.title_$lang  ASC ";

  // Fetch the categories
  $qcategories  = query(" SELECT  dev_tasks_categories.id           AS 'c_id'       ,
                                  dev_tasks_categories.is_archived  AS 'c_archived' ,
                                  dev_tasks_categories.title_en     AS 'c_title_en' ,
                                  dev_tasks_categories.title_fr     AS 'c_title_fr' ,
                                  dev_tasks_categories.title_$lang  AS 'c_title'
                          FROM    dev_tasks_categories
                                  $query_archived
                                  $query_sort ");

  // Prepare the data
  for($i = 0; $row = query_row($qcategories); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['c_id']);
    $data[$i]['archived'] = sanitize_output($row['c_archived']);
    $data[$i]['carchive'] = ($row['c_archived']) ? ' checked' : '';
    $data[$i]['title']    = sanitize_output($row['c_title']);
    $data[$i]['title_en'] = sanitize_output($row['c_title_en']);
    $data[$i]['title_fr'] = sanitize_output($row['c_title_fr']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new task category.
 *
 * @param   array   $contents   The contents of the task category.
 *
 * @return  void
 */

function tasks_categories_add( array $contents ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $title_en = sanitize_array_element($contents, 'title_en', 'string');
  $title_fr = sanitize_array_element($contents, 'title_fr', 'string');

  // Set default values in case some are missing
  $title_en = ($title_en) ? $title_en : '-';
  $title_fr = ($title_fr) ? $title_fr : '-';

  // Create the task category
  query(" INSERT INTO dev_tasks_categories
          SET         dev_tasks_categories.title_en = '$title_en' ,
                      dev_tasks_categories.title_fr = '$title_fr' ");
}




/**
 * Modifies a task category.
 *
 * @param   int     $category_id  The id of the task category to edit.
 * @param   array   $contents     The updated task category contents.
 *
 * @return  void
 */

function tasks_categories_edit( int   $category_id  = 0       ,
                                array $contents     = array() ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task category id
  $category_id = sanitize($category_id, 'int', 0);

  // Stop here if the task category doesn't exist
  if(!database_row_exists('dev_tasks_categories', $category_id))
    return;

  // Sanitize and prepare the data
  $title_en = sanitize_array_element($contents, 'title_en', 'string');
  $title_fr = sanitize_array_element($contents, 'title_fr', 'string');
  $archived = sanitize_array_element($contents, 'archived', 'string', default: 'false');
  $archived = ($archived === 'true') ? 1 : 0;

  // Update the task category
  query(" UPDATE  dev_tasks_categories
          SET     dev_tasks_categories.is_archived  = '$archived' ,
                  dev_tasks_categories.title_en     = '$title_en' ,
                  dev_tasks_categories.title_fr     = '$title_fr'
          WHERE   dev_tasks_categories.id           = '$category_id' ");
}




/**
 * Deletes a task category
 *
 * @param   int   $category_id  The id of the task category to delete.
 *
 * @return  void
 */

function tasks_categories_delete( int $category_id = 0 ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task category id
  $category_id = sanitize($category_id, 'int', 0);

  // Fetch the category name
  $dcategory = query("  SELECT  dev_tasks_categories.title_en  AS 'tc_name'
                        FROM    dev_tasks_categories
                        WHERE   dev_tasks_categories.id = '$category_id' ",
                        fetch_row: true);
  $category_name = $dcategory['tc_name'];

  // Fetch the number of tasks linked to the category
  $dtasks = query(" SELECT  COUNT(*) AS 't_count'
                    FROM    dev_tasks
                    WHERE   dev_tasks.fk_dev_tasks_categories = '$category_id' ",
                    fetch_row: true);
  $task_count = $dtasks['t_count'];

  // Unlink all tasks currently linked to this category
  query(" UPDATE  dev_tasks
          SET     dev_tasks.fk_dev_tasks_categories = 0
          WHERE   dev_tasks.fk_dev_tasks_categories = '$category_id' ");

  // Delete the task category
  query(" DELETE FROM dev_tasks_categories
          WHERE       dev_tasks_categories.id = '$category_id' ");

  // Fetch the username of the admin deleting the category
  $admin_name = user_get_username();

  // IRC bot message
  irc_bot_send_message("$admin_name deleted the task category named \"$category_name\" - $task_count task(s) were linked to it and are now uncategorized - ".$GLOBALS['website_url']."pages/tasks/list", 'admin');
}




/**
 * Fetches a list of task milestones.
 *
 * @param   bool    $exclude_archived   Excludes archived milestones.
 *
 * @return  array                       An array containing task milestones.
 */

function tasks_milestones_list( bool $exclude_archived = false ) : array
{
  // Get the user's current language and access rights
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Exclude archived milestones if requested
  $query_archived = ($exclude_archived) ? ' WHERE dev_tasks_milestones.is_archived = 0 ' : '';

  // Fetch the milestones
  $qmilestones  = query(" SELECT    dev_tasks_milestones.id             AS 'm_id'       ,
                                    dev_tasks_milestones.is_archived    AS 'm_archived' ,
                                    dev_tasks_milestones.title_en       AS 'm_title_en' ,
                                    dev_tasks_milestones.title_fr       AS 'm_title_fr' ,
                                    dev_tasks_milestones.title_$lang    AS 'm_title'    ,
                                    dev_tasks_milestones.sorting_order  AS 'm_order'    ,
                                    dev_tasks_milestones.summary_en     AS 'm_body_en'  ,
                                    dev_tasks_milestones.summary_fr     AS 'm_body_fr'
                          FROM      dev_tasks_milestones
                                    $query_archived
                          ORDER BY  dev_tasks_milestones.sorting_order DESC ");

  // Prepare the data
  for($i = 0; $row = query_row($qmilestones); $i++)
  {
    $data[$i]['id']       = sanitize_output($row['m_id']);
    $data[$i]['archived'] = sanitize_output($row['m_archived']);
    $data[$i]['carchive'] = ($row['m_archived']) ? ' checked' : '';
    $data[$i]['title']    = sanitize_output($row['m_title']);
    $data[$i]['title_en'] = sanitize_output($row['m_title_en']);
    $data[$i]['title_fr'] = sanitize_output($row['m_title_fr']);
    $data[$i]['order']    = sanitize_output($row['m_order']);
    $data[$i]['body_en']  = sanitize_output($row['m_body_en']);
    $data[$i]['body_fr']  = sanitize_output($row['m_body_fr']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new task milestone.
 *
 * @param   array   $contents   The contents of the task milestone.
 *
 * @return  void
 */

function tasks_milestones_add( array $contents ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $order    = sanitize_array_element($contents, 'order', 'int', min: 0, default: 0);
  $title_en = sanitize_array_element($contents, 'title_en', 'string');
  $title_fr = sanitize_array_element($contents, 'title_fr', 'string');

  // Set default values in case some are missing
  $title_en = ($title_en) ? $title_en : '-';
  $title_fr = ($title_fr) ? $title_fr : '-';

  // Create the task milestone
  query(" INSERT INTO dev_tasks_milestones
          SET         dev_tasks_milestones.sorting_order  = '$order'  ,
                      dev_tasks_milestones.title_en       = '$title_en' ,
                      dev_tasks_milestones.title_fr       = '$title_fr' ");
}




/**
 * Modifies a task milestone.
 *
 * @param   int     $milestone_id   The id of the task milestone to edit.
 * @param   array   $contents       The updated task milestone contents.
 *
 * @return  void
 */

function tasks_milestones_edit( int   $milestone_id = 0       ,
                                array $contents     = array() ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task milestone id
  $milestone_id = sanitize($milestone_id, 'int', 0);

  // Stop here if the task milestone doesn't exist
  if(!database_row_exists('dev_tasks_milestones', $milestone_id))
    return;

  // Sanitize and prepare the data
  $order    = sanitize_array_element($contents, 'order', 'int', min: 0, default: 0);
  $title_en = sanitize_array_element($contents, 'title_en', 'string');
  $title_fr = sanitize_array_element($contents, 'title_fr', 'string');
  $body_en  = sanitize_array_element($contents, 'body_en', 'string');
  $body_fr  = sanitize_array_element($contents, 'body_fr', 'string');
  $archived = sanitize_array_element($contents, 'archived', 'string', default: 'false');
  $archived = ($archived === 'true') ? 1 : 0;

  // Update the task milestone
  query(" UPDATE  dev_tasks_milestones
          SET     dev_tasks_milestones.is_archived    = '$archived' ,
                  dev_tasks_milestones.sorting_order  = '$order'    ,
                  dev_tasks_milestones.title_en       = '$title_en' ,
                  dev_tasks_milestones.title_fr       = '$title_fr' ,
                  dev_tasks_milestones.summary_en     = '$body_en'  ,
                  dev_tasks_milestones.summary_fr     = '$body_fr'
          WHERE   dev_tasks_milestones.id             = '$milestone_id' ");
}




/**
 * Deletes a task milestone.
 *
 * @param   int   $milestone_id   The id of the task milestone to delete.
 *
 * @return  void
 */

function tasks_milestones_delete( int $milestone_id = 0 ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the task milestone id
  $milestone_id = sanitize($milestone_id, 'int', 0);

  // Fetch the milestone name
  $dmilestone = query(" SELECT  dev_tasks_milestones.title_en AS 'tm_name'
                        FROM    dev_tasks_milestones
                        WHERE   dev_tasks_milestones.id = '$milestone_id' ",
                        fetch_row: true);
  $milestone_name = $dmilestone['tm_name'];

  // Fetch the number of tasks linked to the milestone
  $dtasks = query(" SELECT  COUNT(*) AS 't_count'
                    FROM    dev_tasks
                    WHERE   dev_tasks.fk_dev_tasks_milestones = '$milestone_id' ",
                    fetch_row: true);
  $task_count = $dtasks['t_count'];

  // Unlink all tasks currently linked to this milestone
  query(" UPDATE  dev_tasks
          SET     dev_tasks.fk_dev_tasks_milestones = 0
          WHERE   dev_tasks.fk_dev_tasks_milestones = '$milestone_id' ");

  // Delete the task milestone
  query(" DELETE FROM dev_tasks_milestones
          WHERE       dev_tasks_milestones.id = '$milestone_id' ");

  // Fetch the username of the admin deleting the milestone
  $admin_name = user_get_username();

  // IRC bot message
  irc_bot_send_message("$admin_name deleted the task milestone named \"$milestone_name\" - $task_count task(s) were linked to it and are not roadmapped anymore - ".$GLOBALS['website_url']."pages/tasks/list", 'admin');
}




/**
 * Returns stats related to tasks.
 *
 * @return  array   An array of stats related to tasks.
 */

function tasks_stats_list() : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');
  require_included_file('functions_numbers.inc.php');
  require_included_file('functions_mathematics.inc.php');

  // Initialize the return array
  $data = array();

  // Fetch the user's language
  $lang = string_change_case(user_get_language(), 'lowercase');

  // Fetch the total number of tasks
  $dtasks = query(" SELECT  COUNT(*)                AS 't_total'  ,
                    SUM(CASE  WHEN dev_tasks.finished_at > 0 THEN 1
                              ELSE 0 END)           AS 't_solved' ,
                    SUM(CASE  WHEN dev_tasks.source_code_link = '' THEN 0
                              ELSE 1 END)           AS 't_source'
                    FROM    dev_tasks
                    WHERE   dev_tasks.is_deleted        = 0
                    AND     dev_tasks.admin_validation  = 1
                    AND     dev_tasks.is_public         = 1
                    AND     dev_tasks.title_$lang      != '' ",
                    fetch_row: true);

  // Add some stats to the return array
  $data['total']            = sanitize_output($dtasks['t_total']);
  $data['solved']           = sanitize_output($dtasks['t_solved']);
  $data['percent_solved']   = number_display_format(maths_percentage_of($dtasks['t_solved'], $dtasks['t_total']) ,
                                                    'percentage', 1);
  $data['unsolved']         = sanitize_output($dtasks['t_total'] - $dtasks['t_solved']);
  $data['percent_unsolved'] = number_display_format(
                                maths_percentage_of(($dtasks['t_total'] - $dtasks['t_solved']) , $dtasks['t_total']) ,
                                'percentage', 1);
  $data['sourced']          = sanitize_output($dtasks['t_source']);
  $data['percent_sourced']  = number_display_format(maths_percentage_of($dtasks['t_source'], $dtasks['t_solved']) ,
                                                    'percentage', 1);

  // Fetch opened tasks by year
  $qtasks = query(" SELECT    YEAR(FROM_UNIXTIME(dev_tasks.created_at)) AS 't_year' ,
                              COUNT(*)                                  AS 't_count'
                    FROM      dev_tasks
                    WHERE     dev_tasks.is_deleted        = 0
                    AND       dev_tasks.admin_validation  = 1
                    AND       dev_tasks.is_public         = 1
                    AND       dev_tasks.title_$lang      != ''
                    GROUP BY  t_year
                    ORDER BY  t_year ASC ");

  // Prepare to identify the oldest task's year
  $oldest_year = date('Y');

  // Add created task data over time to the return data
  while($dtasks = query_row($qtasks))
  {
    $year                   = $dtasks['t_year'];
    $oldest_year            = ($year < $oldest_year) ? $year : $oldest_year;
    $data['created_'.$year] = ($dtasks['t_count']) ? sanitize_output($dtasks['t_count']) : '';
  }

  // Fetch solved tasks by year
  $qtasks = query(" SELECT    YEAR(FROM_UNIXTIME(dev_tasks.finished_at))  AS 't_year' ,
                              COUNT(*)                                    AS 't_count'
                    FROM      dev_tasks
                    WHERE     dev_tasks.is_deleted        = 0
                    AND       dev_tasks.admin_validation  = 1
                    AND       dev_tasks.is_public         = 1
                    AND       dev_tasks.title_$lang      != ''
                    AND       dev_tasks.finished_at       > 0
                    GROUP BY  t_year
                    ORDER BY  t_year ASC ");

  // Add solved task data over time to the return data
  while($dtasks = query_row($qtasks))
  {
    $year                   = $dtasks['t_year'];
    $oldest_year            = ($year < $oldest_year) ? $year : $oldest_year;
    $data['solved_'.$year]  = ($dtasks['t_count']) ? sanitize_output($dtasks['t_count']) : '';
  }

  // Add the oldest year to the return data
  $data['oldest_year'] = $oldest_year;

  // Ensure every year has an entry until the current one
  for($i = $oldest_year; $i <= date('Y'); $i++)
  {
    $data['created_'.$i] ??= '';
    $data['solved_'.$i] ??= '';
  }

  // Fetch categories
  $qcategories = query("  SELECT    dev_tasks.fk_dev_tasks_categories               AS 'tc_id'        ,
                                    dev_tasks_categories.title_$lang                AS 'tc_title'     ,
                                    COUNT(*)                                        AS 'tc_count'     ,
                                    SUM(CASE  WHEN dev_tasks.finished_at > 0 THEN 0
                                              ELSE 1 END)                           AS 'tc_unsolved'  ,
                                    MIN(YEAR(FROM_UNIXTIME(dev_tasks.created_at)))  AS 'tc_oldest'    ,
                                    MAX(YEAR(FROM_UNIXTIME(dev_tasks.created_at)))  AS 'tc_newest'
                          FROM      dev_tasks
                          LEFT JOIN dev_tasks_categories ON dev_tasks.fk_dev_tasks_categories = dev_tasks_categories.id
                          WHERE     dev_tasks.is_deleted        = 0
                          AND       dev_tasks.admin_validation  = 1
                          AND       dev_tasks.is_public         = 1
                          AND       dev_tasks.title_$lang      != ''
                          GROUP BY  tc_id
                          ORDER BY  tc_count  DESC  ,
                                    tc_title  ASC   ");

  // Loop through categories and add their data to the return array
  for($i = 0; $row = query_row($qcategories); $i++)
  {
    $data['category_id_'.$i]        = sanitize_output($row['tc_id']);
    $data['category_name_'.$i]      = sanitize_output($row['tc_title']);
    $data['category_count_'.$i]     = sanitize_output($row['tc_count']);
    $data['category_unsolved_'.$i]  = ($row['tc_unsolved']) ? sanitize_output($row['tc_unsolved']) : '&nbsp;';
    $data['category_punsolved_'.$i] = ($row['tc_unsolved'])
                                    ? sanitize_output(number_display_format(
                                                            maths_percentage_of($row['tc_unsolved'], $row['tc_count'])
                                                            , 'percentage'))
                                    : '';
    $data['category_oldest_'.$i]    = ($row['tc_oldest']) ? sanitize_output($row['tc_oldest']) : '&nbsp;';
    $data['category_newest_'.$i]    = ($row['tc_newest']) ? sanitize_output($row['tc_newest']) : '&nbsp;';
  }

  // Add the number of categories to the return array
  $data['category_count'] = $i;

  // Fetch milestones
  $qmilestones = query("  SELECT    dev_tasks.fk_dev_tasks_milestones           AS 'tm_id'        ,
                                    dev_tasks_milestones.title_$lang            AS 'tm_title'     ,
                                    dev_tasks_milestones.summary_$lang          AS 'tm_body'      ,
                                    SUM(CASE  WHEN dev_tasks.finished_at > 0 THEN 1
                                              ELSE 0 END)                       AS 'tm_solved'    ,
                                    SUM(CASE  WHEN dev_tasks.finished_at > 0 THEN 0
                                              ELSE 1 END)                       AS 'tm_unsolved'  ,
                                    MIN(CASE  WHEN dev_tasks.finished_at = 0 THEN NULL
                                              ELSE dev_tasks.finished_at END )  AS 'tm_date'
                          FROM      dev_tasks
                          LEFT JOIN dev_tasks_milestones ON dev_tasks.fk_dev_tasks_milestones = dev_tasks_milestones.id
                          WHERE     dev_tasks_milestones.id     > 0
                          AND       dev_tasks.is_deleted        = 0
                          AND       dev_tasks.admin_validation  = 1
                          AND       dev_tasks.is_public         = 1
                          AND       dev_tasks.title_$lang      != ''
                          GROUP BY  tm_id
                          ORDER BY  dev_tasks_milestones.sorting_order DESC ");

  // Loop through milestones and add their data to the return array
  for($i = 0; $row = query_row($qmilestones); $i++)
  {
    $data['milestone_id_'.$i]       = sanitize_output($row['tm_id']);
    $data['milestone_title_'.$i]    = sanitize_output($row['tm_title']);
    $data['milestone_body_'.$i]     = bbcodes(sanitize_output($row['tm_body'], preserve_line_breaks: true));
    $data['milestone_date_'.$i]     = (isset($row['tm_date']))
                                    ? sanitize_output(date_to_text($row['tm_date'], strip_day: 1))
                                    : '-';
    $data['milestone_solved_'.$i]   = $row['tm_solved'] ? sanitize_output($row['tm_solved']) : '&nbsp';
    $data['milestone_unsolved_'.$i] = $row['tm_unsolved'] ? sanitize_output($row['tm_unsolved']) : '&nbsp';
  }

  // Add the number of milestones to the return array
  $data['milestone_count'] = $i;

  // Fetch tasks by priority levels
  $qtasks = query(" SELECT    COUNT(*)                  AS 't_count'    ,
                              dev_tasks.priority_level  AS 't_priority' ,
                              SUM(CASE  WHEN dev_tasks.finished_at > 0 THEN 0
                                        ELSE 1 END)     AS 't_unsolved'
                    FROM      dev_tasks
                    WHERE     dev_tasks.is_deleted        = 0
                    AND       dev_tasks.admin_validation  = 1
                    AND       dev_tasks.is_public         = 1
                    AND       dev_tasks.title_$lang      != ''
                    GROUP BY  dev_tasks.priority_level
                    ORDER BY  dev_tasks.priority_level  DESC");

  // Loop through priority levels and add their data to the return array
  for($i = 0; $row = query_row($qtasks); $i++)
  {
    $data['priority_level_'.$i]   = sanitize_output($row['t_priority']);
    $data['priority_count_'.$i]   = sanitize_output($row['t_count']);
    $data['priority_percent_'.$i] = sanitize_output(number_display_format(
                                                      maths_percentage_of($row['t_count'], $data['total']) ,
                                                      'percentage'));
    $data['priority_open_'.$i]    = ($row['t_unsolved']) ? sanitize_output($row['t_unsolved']) : '&nbsp;';
  }

  // Add the number of priority levels to the return array
  $data['priority_count'] = $i;

  // Fetch contributors
  $qusers = query(" SELECT    users_stats.tasks_submitted AS 'us_tasks'   ,
                              users_stats.tasks_solved    AS 'us_solved'  ,
                              users.id                    AS 'u_id'       ,
                              users.username              AS 'u_nick'
                    FROM      users_stats
                    LEFT JOIN users ON users_stats.fk_users = users.id
                    WHERE     users_stats.tasks_submitted > 0
                    ORDER BY  users_stats.tasks_submitted DESC  ,
                              users.username              ASC   ");

  // Loop through contributors and add their data to the return array
  for($i = 0; $row = query_row($qusers); $i++)
  {
    $data['contrib_id_'.$i]     = sanitize_output($row['u_id']);
    $data['contrib_nick_'.$i]   = sanitize_output($row['u_nick']);
    $data['contrib_tasks_'.$i]  = sanitize_output($row['us_tasks']);
    $open_tasks                 = $row['us_tasks'] - $row['us_solved'];
    $data['contrib_open_'.$i]   = ($open_tasks) ? sanitize_output($open_tasks) : '&nbsp;';
    $percentage_open_tasks      = ($open_tasks) ? maths_percentage_of($open_tasks, $row['us_tasks']) : '';
    $data['contrib_popen_'.$i]  = ($percentage_open_tasks)
                                ? sanitize_output('('.number_display_format($percentage_open_tasks, 'percentage').')')
                                : '';
  }

  // ADd the number of contributors to the return array
  $data['contrib_count'] = $i;

  // Return the stats
  return $data;
}




/**
 * Recalculates tasks statistics for a specific user.
 *
 * @param   int   $user_id  The user's id.
 *
 * @return  void
 */

function tasks_stats_recalculate_user( int $user_id )
{
  // Sanitize the user's id
  $user_id = sanitize($user_id, 'int', 0);

  // Check if the user exists
  if(!$user_id || !database_row_exists('users', $user_id))
    return;

  // Count the tasks submitted by the user
  $dtasks = query(" SELECT    COUNT(*)              AS 't_count'    ,
                              SUM(CASE  WHEN dev_tasks.finished_at > 0 THEN 1
                                        ELSE 0 END) AS 't_count_solved'
                    FROM      dev_tasks
                    WHERE     dev_tasks.fk_users          = '$user_id'
                    AND       dev_tasks.is_deleted        = 0
                    AND       dev_tasks.admin_validation  = 1
                    AND       dev_tasks.is_public         = 1 ",
                    fetch_row: true);

  // Sanitize the contributions stats
  $tasks_count    = sanitize($dtasks['t_count'], 'int', 0);
  $tasks_count_en = sanitize($dtasks['t_count_solved'], 'int', 0);

  // Update the user's tasks stats
  query(" UPDATE  users_stats
          SET     users_stats.tasks_submitted = '$tasks_count'    ,
                  users_stats.tasks_solved    = '$tasks_count_en'
          WHERE   users_stats.fk_users        = '$user_id'        ");
}




/**
 * Recalculates global tasks statistics.
 *
 * @return  void
 */

function tasks_stats_recalculate_all()
{
  // Fetch every user id
  $qusers = query(" SELECT    users.id AS 'u_id'
                    FROM      users
                    ORDER BY  users.id ASC ");

  // Loop through the users and recalculate their individual tasks statistics
  while($dusers = query_row($qusers))
  {
    $user_id = sanitize($dusers['u_id'], 'int', 0);
    tasks_stats_recalculate_user($user_id);
  }
}