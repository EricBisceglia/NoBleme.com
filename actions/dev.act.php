<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CLOSE THE WEBSITE                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Toggles the website's status between open and closed.
 *
 * @return  void
 */

function dev_toggle_website_status()
{
  // Fetch the current update status
  $website_status = system_variable_fetch('update_in_progress');

  // Determine the required new value
  $new_status = ($website_status) ? 0 : 1;

  // Toggle the website status
  system_variable_update('update_in_progress', $new_status, 'int');
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  VERSION NUMBERS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns the website's version numbering history.
 *
 * @return array  An array containing past version numbers, sorted in reverse chronological order by date.
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
    $data[$i]['date']       = date_to_text($row['v_date'], 1);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Calculate the date differences
  for($i = 0 ; $i < $data['rows']; $i++)
  {
    // If it is the oldest version, there is no possible differential
    if($i == ($data['rows'] - 1))
      $data[$i]['date_diff'] = '-';

    // Otherwise, calculate the time differential and prepare the formatted string
    else
    {
      $temp_diff              = time_days_elapsed($data[$i]['date'], $data[$i + 1]['date']);
      $data[$i]['date_diff']  = ($temp_diff) ? $temp_diff.__('day', $temp_diff, 1) : '-';
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
 * @param   int       $major            The major version number.
 * @param   int       $minor            The minor version number.
 * @param   int       $patch            The patch number.
 * @param   string    $extension        The extension string (eg. beta, rc-1, etc.).
 * @param   bool|null $publish_activity Whether to publish an entry in recent activity.
 * @param   bool|null $notify_irc       Whether to send a notification on IRC.
 *
 * @return  void
 */

function dev_versions_create($major, $minor, $patch, $extension, $publish_activity=1, $notify_irc=0)
{
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
    return;

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
    ircbot("A new version of NoBleme has been released: $version_number - ".$GLOBALS['website_url']."todo_link", "#dev");
}




/**
 * Deletes an entry in the website's version numbering history.
 *
 * @param   int         $version_id   The version number's id.
 *
 * @return  string|int                The version number, or 0 if the version does not exist.
 */

function dev_versions_delete($version_id)
{
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