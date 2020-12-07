<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  private_messages_list         Lists a user's private messages and system notifications.                          */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Lists a user's private messages and system notifications.
 *
 * @return  array   The private messages, ready for displaying.
 */

function private_messages_list() : array
{
  // Require users to be logged in to run this action
  user_restrict_to_users();

  // Check if the required files have been included
  require_included_file('functions_time.inc.php');

  // Fetch the user's id
  $user_id = sanitize(user_get_id(), 'int', 1);

  // Fetch the private messages
  $qmessages = query("  SELECT    users_private_messages.id               AS 'pm_id'    ,
                                  users_private_messages.fk_users_sender  AS 'us_id'    ,
                                  users_sender.username                   AS 'us_nick'  ,
                                  users_private_messages.sent_at          AS 'us_sent'  ,
                                  users_private_messages.read_at          AS 'us_read'  ,
                                  users_private_messages.title            AS 'us_title'
                        FROM      users_private_messages
                        LEFT JOIN users AS users_sender ON users_private_messages.fk_users_sender = users_sender.id
                        WHERE     users_private_messages.fk_users_recipient = '$user_id'
                        ORDER BY  users_private_messages.sent_at DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmessages); $i++)
  {
    $data[$i]['id']     = sanitize_output($row['pm_id']);
    $data[$i]['title']  = sanitize_output($row['us_title']);
    $data[$i]['system'] = (!$row['us_id']);
    $data[$i]['sender'] = sanitize_output($row['us_nick']);
    $data[$i]['sent']   = sanitize_output(time_since($row['us_sent']));
    $data[$i]['read']   = ($row['us_read']) ? sanitize_output(time_since($row['us_read'])) : '-';
    $data[$i]['css']    = ($row['us_read']) ? '' : ' bold glow text_red';
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // In ACT debug mode, print debug data
  if($GLOBALS['dev_mode'] && $GLOBALS['act_debug_mode'])
    var_dump(array('file' => 'users/messages.act.php', 'function' => 'private_messages_list', 'data' => $data));

  // Return the prepared data
  return $data;
}