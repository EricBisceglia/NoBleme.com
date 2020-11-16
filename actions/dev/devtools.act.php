<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  dev_doc_icon_to_clipboard     Generates the source code of an icon, ready for pasting to the clipboard.          */
/*                                                                                                                   */
/*  dev_toggle_website_status     Toggles the website's status between open and closed.                              */
/*                                                                                                                   */
/*  dev_versions_get              Returns elements related to a version number.                                      */
/*  dev_versions_list             Returns the website's version numbering history.                                   */
/*  dev_versions_create           Releases a new version of the website.                                             */
/*  dev_versions_edit             Edits an entry in the website's version numbering history.                         */
/*  dev_versions_delete           Deletes an entry in the website's version numbering history.                       */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Generates the source code of an icon, ready for pasting to the clipboard.
 *
 * @param   string      $name                                 The name of the icon.
 * @param   string|null $title                                The translation which will be used for the image's title.
 * @param   bool|null   $title_is_a trasnslation  (OPTIONAL)  Whether the title is the entered string or a translation.
 * @param   string      $alt_text                 (OPTIONAL)  The alt text for the icon.
 * @param   string|null $size                     (OPTIONAL)  The size of the icon ('normal', 'small').
 *
 * @return  string                                            The source code ready to be sent to the clipboard.
 */

function dev_doc_icon_to_clipboard( $name                               ,
                                    $title                  = ''        ,
                                    $title_is_a_translation = 0         ,
                                    $alt_text               = 'X'       ,
                                    $size                   = 'normal'  )
{
  // Prepare the data
  $title  = ($title_is_a_translation) ? "&lt;?=__('$title')?>" : $title ;
  $class  = ($size == 'small') ? 'smallicon' : 'icon';
  $name   = ($size == 'small') ? $name.'_small' : $name;

  // Assemble the string
  $icon = sanitize_output_javascript('<img class="'.$class.' valign_middle" src="<?=$path?>img/icons/'.$name.'.svg" alt="'.$alt_text.'" title="'.$title.'">');

  // Return the assembled string
  return $icon;
}




/**
 * Toggles the website's status between open and closed.
 *
 * @param   int   $website_status   Whether an update is currently in progress
 *
 * @return  void
 */

function dev_toggle_website_status( $website_status )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $website_status = sanitize($website_status, 'int', 0, 1);

  // Determine the required new value
  $new_status = ($website_status) ? 0 : 1;

  // Toggle the website status
  system_variable_update('update_in_progress', $new_status, 'int');
}




/**
 * Returns elements related to a version number.
 *
 * @param   int         $version_id The version number's id.
 *
 * @return  array|null              An array containing elements related to the version, or NULL if it does not exist.
 */

function dev_versions_get($version_id)
{
  // Sanitize the id
  $version_id = sanitize($version_id, 'int', 0);

  // Check if the version exists
  if(!database_row_exists('system_versions', $version_id))
    return NULL;

  // Fetch the data
  $dversions = mysqli_fetch_array(query(" SELECT    system_versions.major         AS 'v_major'      ,
                                                    system_versions.minor         AS 'v_minor'      ,
                                                    system_versions.patch         AS 'v_patch'      ,
                                                    system_versions.extension     AS 'v_extension'  ,
                                                    system_versions.release_date  AS 'v_date'
                                          FROM      system_versions
                                          WHERE     system_versions.id = '$version_id' "));

  // Assemble an array with the data
  $data['major']        = sanitize_output($dversions['v_major']);
  $data['minor']        = sanitize_output($dversions['v_minor']);
  $data['patch']        = sanitize_output($dversions['v_patch']);
  $data['extension']    = sanitize_output($dversions['v_extension']);
  $data['release_date'] = sanitize_output(date_to_ddmmyy($dversions['v_date']));

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'dev/devtools.act.php', 'function' => 'dev_versions_get', 'data' => $data));

  // Return the array
  return $data;
}




/**
 * Returns the website's version numbering history.
 *
 * @return  array   An array containing past version numbers, sorted in reverse chronological order by date.
 */

function dev_versions_list()
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
  for($i = 0; $row = mysqli_fetch_array($qversions); $i++)
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
    if($i == ($data['rows'] - 1))
    {
      $data[$i]['date_diff']  = '-';
      $data[$i]['css']        = '';
    }

    // Otherwise, calculate the time differential
    else
    {
      $temp_diff = time_days_elapsed($data[$i + 1]['date_raw'], $data[$i]['date_raw']);

      // Assemble the formatted string
      $data[$i]['date_diff'] = ($temp_diff) ? sanitize_output($temp_diff.__('day', $temp_diff, 1)) : '-';

      // Give stylings to long delays
      $temp_style       = ($temp_diff > 90) ? ' class="smallglow"' : '';
      $data[$i]['css']  = ($temp_diff > 365) ? ' class="bold glow"' : $temp_style;
    }
  }

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'dev/devtools.act.php', 'function' => 'dev_versions_list', 'data' => $data));

  // Return the prepared data
  return $data;
}




/**
 * Releases a new version of the website.
 *
 * The version number will respect the SemVer v2.0.0 standard.
 *
 * @param   int           $major            The major version number.
 * @param   int           $minor            The minor version number.
 * @param   int           $patch            The patch number.
 * @param   string        $extension        The extension string (eg. beta, rc-1, etc.).
 * @param   bool|null     $publish_activity Whether to publish an entry in recent activity.
 * @param   bool|null     $notify_irc       Whether to send a notification on IRC.
 *
 * @return  string|null                     NULL if all went according to plan, or an error string
 */

function dev_versions_create( $major                ,
                              $minor                ,
                              $patch                ,
                              $extension            ,
                              $publish_activity = 1 ,
                              $notify_irc       = 0 )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('devtools.lang.php');

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
  if(mysqli_num_rows($qversion))
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

  // Assemble the version number
  $version_number = system_assemble_version_number($major, $minor, $patch, $extension);

  // Log the activity
  if($publish_activity)
    log_activity('dev_version', 0, 'ENFR', $version_id, $version_number, $version_number);

  // Send a message on IRC
  if($notify_irc)
  irc_bot_send_message(chr(0x02).chr(0x03).'03'."A new version of NoBleme has been released: $version_number - ".$GLOBALS['website_url']."todo_link", "dev");

  // Return that all went well
  return;
}




/**
 * Edits an entry in the website's version numbering history.
 *
 * @param   int           $id           The version's id.
 * @param   int           $major        The major version number.
 * @param   int           $minor        The minor version number.
 * @param   int           $patch        The patch number.
 * @param   string        $extension    The extension string (eg. beta, rc-1, etc.).
 * @param   string        $release_date The version's release date.
 *
 * @return  string|null                 NULL if all went according to plan, or an error string
 */

function dev_versions_edit( $id           ,
                            $major        ,
                            $minor        ,
                            $patch        ,
                            $extension    ,
                            $release_date )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Check if the required files have been included
  require_included_file('devtools.lang.php');

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
  $dversion = mysqli_fetch_array(query("  SELECT  system_versions.id AS 'v_id'
                                          FROM    system_versions
                                          WHERE   system_versions.major     =     '$major'
                                          AND     system_versions.minor     =     '$minor'
                                          AND     system_versions.patch     =     '$patch'
                                          AND     system_versions.extension LIKE  '$extension' "));

  // If it already exists (and isn't the current version), stop the process
  if(isset($dversion['v_id']) && ($dversion['v_id'] != $id))
    return __('dev_versions_edit_error_duplicate');

  // Edit the version
  query(" UPDATE  system_versions
          SET     system_versions.major         = '$major'  ,
                  system_versions.minor         = '$minor'  ,
                  system_versions.patch         = '$patch'  ,
                  system_versions.extension     = '$extension'  ,
                  system_versions.release_date  = '$release_date'
          WHERE   system_versions.id            = '$id' ");

  // Return that all went well
  return;
}




/**
 * Deletes an entry in the website's version numbering history.
 *
 * @param   int           $version_id   The version number's id.
 *
 * @return  string|int                  The version number, or 0 if the version does not exist.
 */

function dev_versions_delete( $version_id )
{
  // Require administrator rights to run this action
  user_restrict_to_administrators();

  // Sanitize the data
  $version_id = sanitize($version_id, 'int', 0);

  // Ensure the version number exists or return 0
  if(!database_row_exists('system_versions', $version_id))
    return 0;

  // Fetch the version number
  $dversion = mysqli_fetch_array(query("  SELECT    system_versions.major     AS 'v_major'      ,
                                                    system_versions.minor     AS 'v_minor'      ,
                                                    system_versions.patch     AS 'v_patch'      ,
                                                    system_versions.extension AS 'v_extension'
                                          FROM      system_versions
                                          WHERE     system_versions.id = '$version_id' "));

  // Assemble the version number
  $version_number = system_assemble_version_number($dversion['v_major'], $dversion['v_minor'], $dversion['v_patch'], $dversion['v_extension']);

  // Delete the entry
  query(" DELETE FROM system_versions
          WHERE       system_versions.id = '$version_id' ");

  // Delete the related activity logs
  log_activity_delete('dev_version', 0, 0, NULL, $version_id);

  // Return the deleted version number
  return $version_number;
}