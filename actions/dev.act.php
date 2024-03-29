<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_versions_get                      Returns elements related to a version number.                              */
/*  dev_versions_list                     Returns the website's version numbering history.                           */
/*  dev_versions_create                   Releases a new version of the website.                                     */
/*  dev_versions_edit                     Edits an entry in the website's version numbering history.                 */
/*  dev_versions_delete                   Deletes an entry in the website's version numbering history.               */
/*                                                                                                                   */
/*  dev_blogs_get                         Returns elements related to a devblog.                                     */
/*  dev_blogs_list                        Returns a list of devblogs.                                                */
/*  dev_blogs_add                         Creates a new devblog.                                                     */
/*  dev_blogs_edit                        Modifies an existing devblog.                                              */
/*  dev_blogs_delete                      Deletes an existing devblog.                                               */
/*  dev_blogs_restore                     Restores a soft deleted devblog.                                           */
/*  dev_blogs_stats_list                  Returns stats related to devblogs.                                         */
/*                                                                                                                   */
/*  dev_settings_website_open             Opens the website.                                                         */
/*  dev_settings_website_close            Closes the website.                                                        */
/*  dev_settings_registrations_open       Allows the creation of new accounts.                                       */
/*  dev_settings_registrations_close      Forbids the creation of new accounts.                                      */
/*                                                                                                                   */
/*  dev_doc_icon_to_clipboard             Generates the source code of an icon, ready for pasting to the clipboard.  */
/*                                                                                                                   */
/*  dev_duplicate_translations_list       Looks for duplicate translations in the global translation array.          */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns elements related to a version number.
 *
 * @param   int         $version_id The version number's id.
 *
 * @return  array|null              An array containing elements related to the version, or NULL if it does not exist.
 */

function dev_versions_get( int $version_id ) : mixed
{
  // Sanitize the id
  $version_id = sanitize($version_id, 'int', 0);

  // Check if the version exists
  if(!database_row_exists('system_versions', $version_id))
    return NULL;

  // Fetch the data
  $dversions = query("  SELECT    system_versions.major         AS 'v_major'      ,
                                  system_versions.minor         AS 'v_minor'      ,
                                  system_versions.patch         AS 'v_patch'      ,
                                  system_versions.extension     AS 'v_extension'  ,
                                  system_versions.release_date  AS 'v_date'
                        FROM      system_versions
                        WHERE     system_versions.id = '$version_id' ",
                        fetch_row: true);

  // Assemble an array with the data
  $data['major']        = sanitize_output($dversions['v_major']);
  $data['minor']        = sanitize_output($dversions['v_minor']);
  $data['patch']        = sanitize_output($dversions['v_patch']);
  $data['extension']    = sanitize_output($dversions['v_extension']);
  $data['release_date'] = sanitize_output(date_to_ddmmyy($dversions['v_date']));

  // Return the array
  return $data;
}




/**
 * Returns the website's version numbering history.
 *
 * @return  array   An array containing past version numbers, sorted in reverse chronological order.
 */

function dev_versions_list() : array
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Fetch all versions
  $qversions = query("  SELECT    system_versions.id            AS 'v_id'         ,
                                  system_versions.major         AS 'v_major'      ,
                                  system_versions.minor         AS 'v_minor'      ,
                                  system_versions.patch         AS 'v_patch'      ,
                                  system_versions.extension     AS 'v_extension'  ,
                                  system_versions.release_date  AS 'v_date'
                        FROM      system_versions
                        ORDER BY  system_versions.release_date  DESC  ,
                                  system_versions.id            DESC  ");

  // Prepare the data
  for($i = 0; $row = query_row($qversions); $i++)
  {
    $data[$i]['id']         = $row['v_id'];
    $data[$i]['version']    = sanitize_output(system_assemble_version_number($row['v_major'], $row['v_minor'], $row['v_patch'], $row['v_extension']));
    $data[$i]['date_raw']   = $row['v_date'];
    $data[$i]['date']       = sanitize_output(date_to_text($row['v_date'], 1));
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Calculate the date differences
  for($i = 0 ; $i < $data['rows']; $i++)
  {
    // If it is the oldest version, there is no possible differential
    if($i === ($data['rows'] - 1))
    {
      $data[$i]['date_diff']  = '-';
      $data[$i]['css']        = '';
    }

    // Otherwise, calculate the time differential
    else
    {
      $date_diff = time_days_elapsed($data[$i + 1]['date_raw'], $data[$i]['date_raw']);

      // Assemble the formatted string
      $data[$i]['date_diff'] = ($date_diff) ? sanitize_output($date_diff.__('day', $date_diff, 1)) : '-';

      // Give stylings to long delays
      $date_style       = ($date_diff > 90) ? ' class="smallglow"' : '';
      $data[$i]['css']  = ($date_diff > 365) ? ' class="bold glow"' : $date_style;
    }
  }

  // Return the prepared data
  return $data;
}




/**
 * Releases a new version of the website.
 *
 * The version number will respect the SemVer v2.0.0 standard.
 *
 * @param   int     $major                          The major version number.
 * @param   int     $minor                          The minor version number.
 * @param   int     $patch                          The patch number.
 * @param   string  $extension                      The extension string (eg. beta, rc-1, etc.).
 * @param   bool    $publish_activity   (OPTIONAL)  Whether to publish an entry in recent activity.
 * @param   bool    $notify_irc         (OPTIONAL)  Whether to send a notification on IRC.
 *
 * @return  string|null                             NULL if all went according to plan, or an error string
 */

function dev_versions_create( int     $major                    ,
                              int     $minor                    ,
                              int     $patch                    ,
                              string  $extension                ,
                              bool    $publish_activity = true  ,
                              bool    $notify_irc       = false ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Sanitize the data
  $major            = sanitize($major, 'int', 0);
  $minor            = sanitize($minor, 'int', 0);
  $patch            = sanitize($patch, 'int', 0);
  $extension        = sanitize($extension, 'string');
  $publish_activity = sanitize($publish_activity, 'int', 0, 1);
  $notify_irc       = sanitize($notify_irc, 'int', 0, 1);
  $current_date     = sanitize(date('Y-m-d'), 'string');

  // Check if the version number already exists
  $qversion = query(" SELECT  system_versions.id AS 'v_id'
                      FROM    system_versions
                      WHERE   system_versions.major     =     '$major'
                      AND     system_versions.minor     =     '$minor'
                      AND     system_versions.patch     =     '$patch'
                      AND     system_versions.extension LIKE  '$extension' ");

  // If it already exists, stop the process
  if(query_row_count($qversion))
    return __('dev_versions_edit_error_duplicate');

  // Create the new version
  query(" INSERT INTO   system_versions
          SET           system_versions.major         = '$major'      ,
                        system_versions.minor         = '$minor'      ,
                        system_versions.patch         = '$patch'      ,
                        system_versions.extension     = '$extension'  ,
                        system_versions.release_date  = '$current_date' ");

  // Fetch the ID of the newly created version
  $version_id = sanitize(query_id(), 'int', 0);

  // Update the version number in system variables
  $system_version_en = sanitize(system_get_current_version_number('full', 'EN'));
  $system_version_fr = sanitize(system_get_current_version_number('full', 'FR'));
  query(" UPDATE  system_variables
          SET     system_variables.current_version_number_en = '$system_version_en' ,
                  system_variables.current_version_number_fr = '$system_version_fr' ");

  // Assemble the version number
  $version_number = system_assemble_version_number($major, $minor, $patch, $extension);

  // Log the activity
  if($publish_activity)
    log_activity( 'dev_version'                         ,
                  activity_id:          $version_id     ,
                  activity_summary_en:  $version_number ,
                  activity_summary_fr:  $version_number );

  // Send a message on IRC
  if($notify_irc)
  irc_bot_send_message(chr(0x02).chr(0x03).'03'."A new version of NoBleme has been released: $version_number - ".$GLOBALS['website_url']."pages/tasks/roadmap", "dev");

  // Return that all went well
  return NULL;
}




/**
 * Edits an entry in the website's version numbering history.
 *
 * @param   int     $id             The version's id.
 * @param   int     $major          The major version number.
 * @param   int     $minor          The minor version number.
 * @param   int     $patch          The patch number.
 * @param   string  $extension      The extension string (eg. beta, rc-1, etc.).
 * @param   string  $release_date   The version's release date.
 *
 * @return  string|null             NULL if all went according to plan, or an error string
 */

function dev_versions_edit( int     $id           ,
                            int     $major        ,
                            int     $minor        ,
                            int     $patch        ,
                            string  $extension    ,
                            string  $release_date ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Sanitize the data
  $id            = sanitize($id, 'int', 0);
  $major         = sanitize($major, 'int', 0);
  $minor         = sanitize($minor, 'int', 0);
  $patch         = sanitize($patch, 'int', 0);
  $extension     = sanitize($extension, 'string');
  $release_date  = sanitize(date_to_mysql($release_date, date('Y-m-d')), 'string');

  // Check if the version exists
  if(!database_row_exists('system_versions', $id))
    return __('dev_versions_edit_error_id');

  // Check if the version number already exists
  $dversion = query(" SELECT  system_versions.id AS 'v_id'
                      FROM    system_versions
                      WHERE   system_versions.major     =     '$major'
                      AND     system_versions.minor     =     '$minor'
                      AND     system_versions.patch     =     '$patch'
                      AND     system_versions.extension LIKE  '$extension' ",
                      fetch_row: true);

  // If it already exists (and isn't the current version), stop the process
  if(isset($dversion['v_id']) && ($dversion['v_id'] !== $id))
    return __('dev_versions_edit_error_duplicate');

  // Edit the version
  query(" UPDATE  system_versions
          SET     system_versions.major         = '$major'  ,
                  system_versions.minor         = '$minor'  ,
                  system_versions.patch         = '$patch'  ,
                  system_versions.extension     = '$extension'  ,
                  system_versions.release_date  = '$release_date'
          WHERE   system_versions.id            = '$id' ");

  // Update the version number in system variables
  $system_version_en = sanitize(system_get_current_version_number('full', 'EN'));
  $system_version_fr = sanitize(system_get_current_version_number('full', 'FR'));
  query(" UPDATE  system_variables
          SET     system_variables.current_version_number_en = '$system_version_en' ,
                  system_variables.current_version_number_fr = '$system_version_fr' ");

  // Return that all went well
  return NULL;
}




/**
 * Deletes an entry in the website's version numbering history.
 *
 * @param   int           $version_id   The version number's id.
 *
 * @return  string|null                 The version number, or NULL if the version does not exist.
 */

function dev_versions_delete( int $version_id ) : mixed
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $version_id = sanitize($version_id, 'int', 0);

  // Ensure the version number exists or return NULL
  if(!database_row_exists('system_versions', $version_id))
    return NULL;

  // Fetch the version number
  $dversion = query(" SELECT    system_versions.major     AS 'v_major'      ,
                                system_versions.minor     AS 'v_minor'      ,
                                system_versions.patch     AS 'v_patch'      ,
                                system_versions.extension AS 'v_extension'
                      FROM      system_versions
                      WHERE     system_versions.id = '$version_id' ",
                      fetch_row: true);

  // Assemble the version number
  $version_number = system_assemble_version_number($dversion['v_major'], $dversion['v_minor'], $dversion['v_patch'], $dversion['v_extension']);

  // Delete the entry
  query(" DELETE FROM system_versions
          WHERE       system_versions.id = '$version_id' ");

  // Update the version number in system variables
  $system_version_en = sanitize(system_get_current_version_number('full', 'EN'));
  $system_version_fr = sanitize(system_get_current_version_number('full', 'FR'));
  query(" UPDATE  system_variables
          SET     system_variables.current_version_number_en = '$system_version_en' ,
                  system_variables.current_version_number_fr = '$system_version_fr' ");

  // Delete the related activity logs
  log_activity_delete(  'dev_version'             ,
                        activity_id:  $version_id );

  // Return the deleted version number
  return $version_number;
}




/**
 * Returns elements related to a devblog.
 *
 * @param   int           $blog_id              The devblog's id.
 * @param   string        $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array|null                          An array containing the devblog's data, or NULL if it does not exist.
 */

function dev_blogs_get( int     $blog_id          ,
                        string  $format = 'html'  ) : mixed
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');
  require_included_file('functions_time.inc.php');

  // Sanitize the id
  $blog_id = sanitize($blog_id, 'int', 0);

  // Error: No ID provided
  if(!$blog_id)
    return NULL;

  // Fetch the user's language
  $lang = string_change_case(user_get_language(), 'lowercase');

  // Fetch the data
  $dblog = query("  SELECT    dev_blogs.is_deleted  AS 'b_deleted'  ,
                              dev_blogs.title_en    AS 'b_title_en' ,
                              dev_blogs.title_fr    AS 'b_title_fr' ,
                              dev_blogs.posted_at   AS 'b_date'     ,
                              dev_blogs.body_$lang  AS 'b_body'     ,
                              dev_blogs.body_en     AS 'b_body_en'  ,
                              dev_blogs.body_fr     AS 'b_body_fr'
                    FROM      dev_blogs
                    WHERE     dev_blogs.id = '$blog_id' ",
                    fetch_row: true);

  // Error: Devblog does not exist
  if(!isset($dblog['b_deleted']))
    return NULL;

  // Format the data
  $blog_deleted   = $dblog['b_deleted'];
  $blog_title     = $dblog['b_title_'.$lang];
  $blog_title_en  = $dblog['b_title_en'];
  $blog_title_fr  = $dblog['b_title_fr'];
  $blog_posted_at = $dblog['b_date'];
  $blog_body      = $dblog['b_body'];
  $blog_body_en   = $dblog['b_body_en'];
  $blog_body_fr   = $dblog['b_body_fr'];

  // Prepare the data for display
  if($format === 'html')
  {
    // Devblog data
    $data['deleted']    = $blog_deleted;
    $data['title']      = ($blog_title) ? sanitize_output($blog_title) : __('dev_blog_no_title');
    $data['title_en']   = $blog_title_en;
    $data['title_fr']   = $blog_title_fr;
    $data['date']       = sanitize_output(date_to_text($blog_posted_at));
    $data['date_since'] = sanitize_output(time_since($blog_posted_at));
    $data['body']       = ($blog_body) ? $blog_body : __('dev_blog_no_body');
    $data['body_en']    = sanitize_output($blog_body_en);
    $data['body_fr']    = sanitize_output($blog_body_fr);

    // Sanitize the devblog's timestamp
    $blog_timestamp = sanitize($blog_posted_at, 'int', 0);

    // Fetch the previous devblog
    $dblog = query("  SELECT    dev_blogs.id          AS 'b_id'  ,
                                dev_blogs.title_$lang AS 'b_title'
                      FROM      dev_blogs
                      WHERE     dev_blogs.posted_at     < '$blog_timestamp'
                      AND       dev_blogs.is_deleted    = 0
                      AND       dev_blogs.title_$lang  != ''
                      ORDER BY  dev_blogs.posted_at DESC
                      LIMIT     1 ",
                      fetch_row: true);

    // Add the previous devblog's info to the data array
    $data['prev_id']    = isset($dblog['b_id']) ? sanitize_output($dblog['b_id']) : 0;
    $data['prev_title'] = isset($dblog['b_title']) ? sanitize_output($dblog['b_title']) : '';

    // Fetch the next devblog
    $dblog = query("  SELECT    dev_blogs.id          AS 'b_id'  ,
                                dev_blogs.title_$lang AS 'b_title'
                      FROM      dev_blogs
                      WHERE     dev_blogs.posted_at     > '$blog_timestamp'
                      AND       dev_blogs.is_deleted    = 0
                      AND       dev_blogs.title_$lang  != ''
                      ORDER BY  dev_blogs.posted_at ASC
                      LIMIT     1 ",
                      fetch_row: true);

    // Add the next devblog's info to the data array
    $data['next_id']    = isset($dblog['b_id']) ? sanitize_output($dblog['b_id']) : 0;
    $data['next_title'] = isset($dblog['b_title']) ? sanitize_output($dblog['b_title']) : '';
  }

  // Prepare the data for the API
  else if($format === 'api')
  {
    // Do not show deleted devblogs in the API
    if($blog_deleted)
      return NULL;

    // Devblog data
    $data['blog']['id']           = (string)$blog_id;
    $data['blog']['link']         = sanitize_json($GLOBALS['website_url'].'pages/dev/blog?id='.$blog_id);
    $data['blog']['published_on'] = sanitize_json(date('Y-m-d', $blog_posted_at));
    $data['blog']['title_en']     = sanitize_json($blog_title_en) ?: NULL;
    $data['blog']['title_fr']     = sanitize_json($blog_title_fr) ?: NULL;
    $data['blog']['contents_en']  = sanitize_json(strip_tags($blog_body_en)) ?: NULL;
    $data['blog']['contents_fr']  = sanitize_json(strip_tags($blog_body_fr)) ?: NULL;
  }

  // Return the array
  return $data;
}




/**
 * Returns a list of devblogs.
 *
 * @param   string  $sort     (OPTIONAL)  The value on which to sort the data.
 * @param   string  $year     (OPTIONAL)  Only show devblogs from a specific year.
 * @param   string  $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                         An array containing data about devblogs.
 */

function dev_blogs_list(  string  $sort   = ''      ,
                          int     $year   = 0       ,
                          string  $format = 'html'  ) : array
{
  // Fetch the user's language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'));

  // Restrict this action to administrators only
  $is_admin = user_is_administrator();

  // Decide whether to show deleted blogs
  $show_deleted = (!$is_admin || $format === 'api') ? " AND dev_blogs.is_deleted = 0 " : ' ';

  // Decide whether to show blogs with no translation
  $show_lang = (!$is_admin && $format != 'api') ? " AND dev_blogs.title_$lang != '' " : ' ';

  // Filter by year if necessary
  $year         = sanitize($year, 'int', 0);
  $filter_year  = ($year) ? " AND YEAR(FROM_UNIXTIME(dev_blogs.posted_at)) = '$year' ": ' ';

  // Sort the blogs if necessary
  $order_by = " dev_blogs.posted_at DESC ";
  $order_by = ($is_admin && $sort === 'views') ? " stats_pages.view_count DESC, ".$order_by : $order_by;

  // Fetch devblogs
  $qblogs = query(" SELECT    dev_blogs.id            AS 'b_id'       ,
                              dev_blogs.is_deleted    AS 'b_deleted'  ,
                              dev_blogs.posted_at     AS 'b_date'     ,
                              dev_blogs.title_en      AS 'b_title_en' ,
                              dev_blogs.title_fr      AS 'b_title_fr' ,
                              stats_pages.view_count  AS 'p_views'
                    FROM      dev_blogs
                    LEFT JOIN stats_pages
                    ON        stats_pages.page_url LIKE CONCAT('pages/dev/blog?id=', dev_blogs.id)
                    WHERE     1 = 1
                              $show_deleted
                              $show_lang
                              $filter_year
                    ORDER BY  $order_by ");

  // Prepare the data
  for($i = 0; $row = query_row($qblogs); $i++)
  {
    // Format the data
    $blog_id        = $row['b_id'];
    $blog_deleted   = $row['b_deleted'];
    $blog_title     = $row['b_title_'.$lang];
    $blog_title_en  = $row['b_title_en'];
    $blog_title_fr  = $row['b_title_fr'];
    $blog_posted_at = $row['b_date'];
    $blog_views     = $row['p_views'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']       = $blog_id;
      $data[$i]['deleted']  = $blog_deleted;
      $data[$i]['title']    = ($blog_title) ? sanitize_output($blog_title) : '----------';
      $data[$i]['date']     = sanitize_output(date_to_text($blog_posted_at, strip_day: 1));
      $data[$i]['views']    = sanitize_output($blog_views);
      $data[$i]['lang_en']  = ($blog_title_en);
      $data[$i]['lang_fr']  = ($blog_title_fr);
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      // Blog data
      $data[$i]['id']           = (string)$blog_id;
      $data[$i]['link']         = sanitize_json($GLOBALS['website_url'].'pages/dev/blog?id='.$blog_id);
      $data[$i]['published_on'] = sanitize_json(date('Y-m-d', $blog_posted_at));
      $data[$i]['title_en']     = sanitize_json($blog_title_en) ?: NULL;
      $data[$i]['title_fr']     = sanitize_json($blog_title_fr) ?: NULL;
    }
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Give a default return value when no devblogs are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('blogs' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new devblog.
 *
 * @param   array         $contents   The contents of the devblog.
 *
 * @return  string|int                A string if an error happened, or the newly created blog's ID if all went well.
 */

function dev_blogs_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $blog_title_en_raw  = $contents['title_en'];
  $blog_title_fr_raw  = $contents['title_fr'];
  $blog_title_en      = sanitize($contents['title_en'], 'string');
  $blog_title_fr      = sanitize($contents['title_fr'], 'string');
  $blog_body_en       = sanitize($contents['body_en'], 'string');
  $blog_body_fr       = sanitize($contents['body_fr'], 'string');
  $timestamp          = sanitize(time(), 'int', 0);

  // Error: No title
  if(!$blog_title_en && !$blog_title_fr)
    return __('dev_blog_add_empty');

  // Error: Title but no body
  if($blog_title_en && !$blog_body_en)
    return __('dev_blog_add_empty_en');
  if($blog_title_fr && !$blog_body_fr)
    return __('dev_blog_add_empty_fr');

  // Error: Body but no title
  if(!$blog_title_en && $blog_body_en)
    return __('dev_blog_add_no_body_en');
  if(!$blog_title_fr && $blog_body_fr)
    return __('dev_blog_add_no_body_fr');

  // Create the devblog
  query(" INSERT INTO dev_blogs
          SET         dev_blogs.posted_at = '$timestamp'      ,
                      dev_blogs.title_en  = '$blog_title_en'  ,
                      dev_blogs.title_fr  = '$blog_title_fr'  ,
                      dev_blogs.body_en   = '$blog_body_en'   ,
                      dev_blogs.body_fr   = '$blog_body_fr'   ");

  // Fetch the newly created devblog's id
  $blog_id = query_id();

  // Determine the blog's language
  $activity_lang  = ($blog_title_en) ? 'EN' : '';
  $activity_lang .= ($blog_title_fr) ? 'FR' : '';

  // Activity log
  log_activity( 'dev_blog'                                ,
                language:             $activity_lang      ,
                activity_id:          $blog_id            ,
                activity_summary_en:  $blog_title_en_raw  ,
                activity_summary_fr:  $blog_title_fr_raw  );

  // IRC bot messages in the appropriate languages
  if($blog_title_en)
    irc_bot_send_message("A new devblog has been posted: $blog_title_en_raw - ".$GLOBALS['website_url']."pages/dev/blog?id=".$blog_id, 'english');
  if($blog_title_fr)
    irc_bot_send_message("Un nouveau devblog a été publié : $blog_title_fr_raw - ".$GLOBALS['website_url']."pages/dev/blog?id=".$blog_id, 'french');

  // Discord message
  $discord_message = '';
  if($blog_title_en)
    $discord_message  = "New development blog: $blog_title_en_raw";
  if($blog_title_en && $blog_title_fr)
    $discord_message .= PHP_EOL;
  if($blog_title_fr)
    $discord_message .= "Nouveau blog de développement : $blog_title_fr_raw";
  $discord_message   .= PHP_EOL."@here <".$GLOBALS['website_url']."pages/dev/blog?id=".$blog_id.">";
  discord_send_message($discord_message, 'main');

  // Return the blog's id
  return $blog_id;
}




/**
 * Edits an existing devblog.
 *
 * @param   int           $blog_id    The devblog's id.
 * @param   array         $contents   The contents of the devblog.
 *
 * @return  string|null               A string if an error happened, or NULL if all went well.
 */

function dev_blogs_edit(  int   $blog_id  ,
                          array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize and prepare the data
  $blog_id        = sanitize($blog_id, 'int', 0);
  $blog_title_en  = sanitize($contents['title_en'], 'string');
  $blog_title_fr  = sanitize($contents['title_fr'], 'string');
  $blog_body_en   = sanitize($contents['body_en'], 'string');
  $blog_body_fr   = sanitize($contents['body_fr'], 'string');

  // Error: Devblog does not exist
  if(!$blog_id || !database_row_exists('dev_blogs', $blog_id))
    return __('dev_blog_edit_error');

  // Error: No title
  if(!$blog_title_en && !$blog_title_fr)
    return __('dev_blog_add_empty');

  // Error: Title but no body
  if($blog_title_en && !$blog_body_en)
    return __('dev_blog_add_empty_en');
  if($blog_title_fr && !$blog_body_fr)
    return __('dev_blog_add_empty_fr');

  // Error: Body but no title
  if(!$blog_title_en && $blog_body_en)
    return __('dev_blog_add_no_body_en');
  if(!$blog_title_fr && $blog_body_fr)
    return __('dev_blog_add_no_body_fr');

  // Update the devblog
  query(" UPDATE  dev_blogs
          SET     dev_blogs.title_en  = '$blog_title_en'  ,
                  dev_blogs.title_fr  = '$blog_title_fr'  ,
                  dev_blogs.body_en   = '$blog_body_en'   ,
                  dev_blogs.body_fr   = '$blog_body_fr'
          WHERE   dev_blogs.id        = '$blog_id' ");

  // All went well
  return NULL;
}




/**
 * Deletes an existing devblog.
 *
 * @param   int           $blog_id                    The devblog's id.
 * @param   bool          $hard_deletion  (OPTIONAL)  Perform a hard deletion instead of a soft deletion.
 *
 * @return  string|null                               A string if an error happened, or NULL if all went well.
 */

function dev_blogs_delete(  int   $blog_id                ,
                            bool  $hard_deletion = false  ) : mixed
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the devblog's id
  $blog_id = sanitize($blog_id, 'int', 0);

  // Error: Devblog does not exist
  if(!$blog_id || !database_row_exists('dev_blogs', $blog_id))
    return __('dev_blog_delete_error');

  // Soft deletion
  if(!$hard_deletion)
    query(" UPDATE  dev_blogs
            SET     dev_blogs.is_deleted = 1
            WHERE   dev_blogs.id = '$blog_id' ");

  // Hard deletion
  else
    query(" DELETE FROM dev_blogs
            WHERE       dev_blogs.id = '$blog_id' ");

  // Delete activity log
  log_activity_delete(  'dev_blog'            ,
                        activity_id: $blog_id );

  // All went well
  return NULL;
}




/**
 * Restores a soft deleted devblog.
 *
 * @param   int         $blog_id  The devblog's id.
 *
 * @return  string|null           A string if an error happened, or NULL if all went well.
 */

function dev_blogs_restore(int $blog_id) : mixed
{
  // Check if the required files have been included
  require_included_file('dev.lang.php');

  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the devblog's id
  $blog_id = sanitize($blog_id, 'int', 0);

  // Error: Devblog does not exist
  if(!$blog_id || !database_row_exists('dev_blogs', $blog_id))
    return __('dev_blog_delete_error');

  // Undelete
  query(" UPDATE  dev_blogs
          SET     dev_blogs.is_deleted = 0
          WHERE   dev_blogs.id = '$blog_id' ");

  // All went well
  return NULL;
}




/**
 * Returns stats related to devblogs.
 *
 * @return  array   An array of stats related to devblogs.
 */

function dev_blogs_stats_list() : array
{
  // Initialize the return array
  $data = array();

  // Fetch the user's language
  $lang = string_change_case(user_get_language(), 'lowercase');

  // Fetch devblogs by years
  $qdevblogs = query("  SELECT    dev_blogs.posted_at                       AS 'd_date'     ,
                                  YEAR(FROM_UNIXTIME(dev_blogs.posted_at))  AS 'd_year'     ,
                                  COUNT(*)                                  AS 'd_count'
                        FROM      dev_blogs
                        WHERE     dev_blogs.is_deleted    = 0
                        AND       dev_blogs.title_$lang  != ''
                        GROUP BY  d_year
                        ORDER BY  d_year ASC ");

  // Prepare to identify the oldest devblog year
  $oldest_year = date('Y');

  // Add devblog data over time to the return data
  while($ddevblogs = query_row($qdevblogs))
  {
    $year                 = $ddevblogs['d_year'];
    $oldest_year          = ($year < $oldest_year) ? $year : $oldest_year;
    $data['count_'.$year] = ($ddevblogs['d_count']) ? sanitize_output($ddevblogs['d_count']) : '';
  }

  // Add the oldest year to the return data
  $data['oldest_year'] = $oldest_year;

  // Ensure every year has an entry until the current one
  for($i = $oldest_year; $i <= date('Y'); $i++)
    $data['count_'.$i] ??= '';

  // Return the stats
  return $data;
}




/**
 * Opens the website.
 *
 * @return void
 */

function dev_settings_website_open()
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Open the website
  system_variable_update('website_is_closed', 0, 'int');

  // Fetch the admin's username
  $username = user_get_username();

  // Notify IRC
  irc_bot_send_message("The website has been opened by ".$username ." - ".$GLOBALS['website_url']."pages/dev/settings", 'admin');
}




/**
 * Closes the website.
 *
 * @return void
 */

function dev_settings_website_close()
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Open the website
  system_variable_update('website_is_closed', 1, 'int');

  // Fetch the admin's username
  $username = user_get_username();

  // Notify IRC
  irc_bot_send_message("The website has been closed by ".$username ." - ".$GLOBALS['website_url']."pages/dev/settings", 'admin');
}




/**
 * Allows the creation of new accounts.
 *
 * @return void
 */

function dev_settings_registrations_open()
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Enable new account registration
  system_variable_update('registrations_are_closed', 0, 'int');

  // Fetch the admin's username
  $username = user_get_username();

  // Notify IRC
  irc_bot_send_message("Account registration has been turned back on by ".$username ." - ".$GLOBALS['website_url']."pages/dev/settings", 'admin');
  irc_bot_send_message("Account registration has been turned back on. It is once again possible to create new accounts on NoBleme.", 'mod');
}




/**
 * Forbids the creation of new accounts.
 *
 * @return void
 */

function dev_settings_registrations_close()
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Disable new account registration
  system_variable_update('registrations_are_closed', 1, 'int');

  // Fetch the admin's username
  $username = user_get_username();

  // Notify IRC
  irc_bot_send_message("Account registration has been turned off by ".$username ." - ".$GLOBALS['website_url']."pages/dev/settings", 'admin');
  irc_bot_send_message("Account registration has been turned off. This temporary security measure means no new accounts can be registered on NoBleme for now.", 'mod');
}




/**
 * Generates the source code of an icon, ready for pasting to the clipboard.
 *
 * @param   string  $name                                 The name of the icon.
 * @param   string  $title                                The translation which will be used for the image's title.
 * @param   bool    $title_is_a_translation   (OPTIONAL)  Whether the title is the entered string or a translation.
 * @param   string  $alt_text                 (OPTIONAL)  The alt text for the icon.
 * @param   string  $size                     (OPTIONAL)  The size of the icon ('normal', 'small').
 *
 * @return  string                                        The source code ready to be sent to the clipboard.
 */

function dev_doc_icon_to_clipboard( string  $name                               ,
                                    string  $title                  = ''        ,
                                    bool    $title_is_a_translation = false     ,
                                    string  $alt_text               = 'X'       ,
                                    string  $size                   = 'normal'  ) : string
{
  // Prepare the data
  $title    = ($title_is_a_translation) ? "__('$title')" : "'$title'" ;
  $initials = ($title_is_a_translation) ? ", title_case: 'initials'" : '';
  $small    = ($size === 'small') ? ', is_small: true' : '';

  // Assemble the string
  $icon = sanitize_output_javascript("&lt;?=__icon('$name'".$small.", alt: '$alt_text', title: $title".$initials.")?>");

  // Return the assembled string
  return $icon;
}




/**
 * Looks for duplicate translations in the global translation array.
 *
 * @param   array   $ok_list  (OPTIONAL)  An array of translations which should be excluded from the returned results.
 *
 * @return  array                         An array of duplicate translations.
 */

function dev_duplicate_translations_list( $ok_list = array() ) : array
{
  // Fetch the translations
  $translations = $GLOBALS['translations'];

  // Remove the ok list from the array
  foreach($ok_list as $name)
    unset($translations[$name]);

  // Make translations case insensitive
  foreach($translations as $id => $value)
    $translations[$id] = string_change_case($value, 'initials');

  // Look for duplicates in the global translations array
  $result = array_unique($translations);
  $result = array_diff($translations, array_diff($result, array_diff_assoc($translations, $result)));

  // Sort the result
  asort($result);

  // Turn the result into a usable array
  $i = 0;
  foreach($result as $name => $value)
  {
    $data[$i]['name']   = $name;
    $data[$i]['value']  = $value;
    $i++;
  }

  // Add the row count to the data
  $data['rows'] = $i;

  // Return the duplicate data
  return $data;
}