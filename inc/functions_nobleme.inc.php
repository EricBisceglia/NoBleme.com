<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                                                                                                   //
//     The functions in this file are fairly global, at least one of them is guaranteed to be used by most pages     //
//   However, since some pages don't need them, they will not be included by default when running includes.inc.php   //
//                                                                                                                   //
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   GENERIC TOOLS                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Does a row already exist in a table.
 *
 * @param   string  $table  Name of the table.
 * @param   int     $id     ID of the row.
 *
 * @return  bool            Whether the row exists or not.
 */

function database_row_exists($table, $id)
{
  // We sanitize the data before running the query
  $table  = sanitize($table, 'string');
  $id     = sanitize($id, 'int', 0);

  // We go check whether the row exists
  $dcheck = mysqli_fetch_array(query("  SELECT  ".$table.".id AS 'r_id'
                                        FROM    $table
                                        WHERE   ".$table.".id = '".$id."' "));

  // We return whether the row exists or not
  return ($dcheck['r_id']) ? 1 : 0;
}



/**
 * Is the page being called through XHR.
 *
 * @return  bool  Whether the page is being called through XHR or not.
 */

function page_is_xhr()
{
  // Return whether the XHR header is set
  return (isset($_SERVER['HTTP_XHR'])) ? 1 : 0;
}




/**
 * Throws a 404 if the page is not being called through XHR.
 *
 * @param   string|null $path The path to the root of the website (defaults to 2 folders away from root).
 *
 * @return  void
 */

function allow_only_xhr($path='./../../')
{
  // If the XHR header is not set, throw a 404
  if(!page_is_xhr())
    exit(header("Location: ".$path."pages/nobleme/404")); die();
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                         SEARCHING AND DIFFERENCE CHECKING                                         */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Returns a raw diff between two string arrays.
 *
 * This function is a prerequisite for the more useful diff_strings() function to work properly.
 * The core logic was taken from Paul Butler's simplediff through arrays method @ https://github.com/paulgb/simplediff.
 *
 * @param   array $old  An array of strings, the older version of the texts being compared.
 * @param   array $new  An array of strings, the newer version of the texts being compared.
 *
 * @return  array       An array of strings, showcasing the differences between the two arrays of strings.
 */

function diff_raw_string_arrays($old, $new)
{
  // We prepare the variables
  $matrix = array();
  $maxlen = 0;

  // Finds the largest substring in common between the two arrays
  foreach($old as $oindex => $ovalue)
  {
    $nkeys = array_keys($new, $ovalue);
    foreach($nkeys as $nindex)
    {
      $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
        $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
      if($matrix[$oindex][$nindex] > $maxlen){
        $maxlen = $matrix[$oindex][$nindex];
        $omax = $oindex + 1 - $maxlen;
        $nmax = $nindex + 1 - $maxlen;
      }
    }
  }

  // If we have found a difference, we return it in an array of arrays of strings
  // The deleted content is in an array called 'd', and the inserted content in an array called 'i'
  if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));

  // As long as there are differences, we run this function recursively until all differences are identified
  // Content which is not different is returned at the root of the returned array, not within a 'd' or 'i' array
  return array_merge(
    diff_raw_string_arrays(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
    array_slice($new, $nmax, $maxlen),
    diff_raw_string_arrays(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
  );
}




/**
 * Returns a human readable list of differences between two strings.
 *
 * The differences are treated word by word and not character by character.
 * The output contains HTML tags, as we use <del> and <ins> to highlight the differences.
 * The core logic was taken from Paul Butler's simplediff through arrays method @ https://github.com/paulgb/simplediff.
 *
 * @param   string $old  The older version of the texts being compared.
 * @param   string $new  The newer version of the texts being compared.
 *
 * @return  string       Human readable list of differences between the two arrays.
 */

function diff_strings($old, $new)
{
  // We break both strings in arrays of words, then run diff_raw_string_arrays() on them
  $diff = diff_raw_string_arrays(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));

  // We initialize the future returned string
  $return = '';

  // We walk through the array of differences returned by diff_raw_string_arrays()
  foreach($diff as $k)
  {
    // If the element is an array, then we're dealing with a difference - we wrap it between <del> or <ins> tags
    if(is_array($k))
        $return .= (!empty($k['d'])?"&nbsp;<del>&nbsp;".implode(' ',$k['d'])."&nbsp;</del>&nbsp;":'').(!empty($k['i'])?"&nbsp;<ins>&nbsp;".implode(' ',$k['i'])."&nbsp;</ins>&nbsp;":'');
    // Otherwise there's no difference, we leave it as is
    else
      $return .= $k . ' ';
  }

  // We return the recomposed string
  return $return;
}




/**
 * Searches for a string in a text, along with the words surrounding said string.
 *
 * @param   string    $search                       The string being searched.
 * @param   string    $text                         The text in which to search for the string.
 * @param   int|null  $nb_words_around  (OPTIONAL)  Number of words around the string to return.
 *
 * @return  string                                  The searched string and the words around it (or an empty string).
 */

function search_string_context($search, $text, $nb_words_around=1)
{
  // We escape special characters
  $search = preg_quote($search, '/');
  $text   = preg_quote($text, '/');

  // First we split the text into an array of words and make them all lowercase (this way we search case insensitively)
  $words = preg_split('/\s+/u', string_change_case($text, 'lowercase'));

  // We search for the string in the array of words, and mark its positions in an array if we find it
  $fetch_words      = preg_grep("/".string_change_case($search, 'lowercase').".*/", $words);
  $words_positions  = array_keys($fetch_words);

  // We split the text into an array of words again, but without changing case this time
  $words = preg_split('/\s+/u', $text);

  // If we managed to find the string, we fetch its first position
  if(count($words_positions))
    $position = $words_positions[0];

  // If we did not have any matches, we return an empty array
  if(!isset($position))
    return '';

  // We fetch the start and end positions based on the number of words that we are wrapping around the result
  $start  = (($position - $nb_words_around) > 0) ? $position - $nb_words_around : 0;
  $end    = ((($position + ($nb_words_around + 1)) < count($words)) ? $position + ($nb_words_around + 1) : count($words)) - $start;

  // We slice the array by keeping only the words that we need (anything between start and end positions)
  $slice  = array_slice($words, $start, $end);

  // If needed, we add ... at the beginning and/or end of the array
  $start  = ($start > 0) ? "..." : "";
  $end    = ($position + ($nb_words_around + 1) < count($words)) ? "..." : "";

  // We can now assemble this array into a string and return it
  return stripslashes($start.implode(' ', $slice).$end);
}




/**
 * Wraps HTML tags around every occurence of a string in a text.
 *
 * @param   string  $search     The string being searched.
 * @param   string  $text       The text in which the string is being searched.
 * @param   string  $open_tag   The tag to place before each occurence of the string.
 * @param   string  $close_tag  The tag to place after each occurence oft he string.
 *
 * @return  string              The result of the operation.
 */

function search_string_wrap_html($search, $text, $open_tag, $close_tag)
{
  // We escape special characters
  $search = preg_quote($search, '/');
  $text   = preg_quote($text, '/');

  // We use a regex to do the trick and return the result
  return stripslashes(preg_replace("/($search)/i", "$open_tag$1$close_tag", $text));
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 PRIVATE MESSAGES                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Sends a private message to an user.
 *
 * @param   string    $title                        The message's title.
 * @param   string    $body                         The message's body.
 * @param   int|null  $recipient        (OPTIONAL)  The ID of the user which gets the message - if 0, current user.
 * @param   int|null  $sender           (OPTIONAL)  The ID of the suer sending the message - if 0, system notification.
 * @param   bool|null $is_silent        (OPTIONAL)  If set, the message arrives as already read.
 * @param   bool|null $do_not_sanitize  (OPTIONAL)  If set, the data will not be sanitized.
 *
 * @return  bool                                    Whether the message was sent or not.
 */

function private_message_send($title, $body, $recipient=0, $sender=0, $is_silent=0, $do_not_sanitize=0)
{
  // If the user is not logged in but expected to be the sender, we do not send the message
  if(!$recipient && !user_is_logged_in())
    return 0;

  // Sanitize and prepare the data
  $title      = ($do_not_sanitize) ? $title : sanitize($title, 'string');
  $body       = ($do_not_sanitize) ? $body : sanitize($body, 'string');
  $recipient  = ($recipient) ? sanitize($recipient, 'int', 0) : sanitize(user_get_id(), 'int', 0);
  $sender     = sanitize($sender, 'int', 0);
  $sent_at    = sanitize(time(), 'int', 0);
  $read_at    = ($is_silent) ? sanitize(time(), 'int', 0) : 0;

  // If the recipient does not exist, we do not send the message
  if(!database_row_exists('users', $recipient))
    return 0;

  // If the sender does not exist, we do not send the message either
  if($sender && !database_row_exists('users', $sender))
    return 0;

  // We send the message by inserting a new row in the private messages table
  query(" INSERT INTO   users_private_messages
          SET           users_private_messages.fk_users_recipient = '$recipient'  ,
                        users_private_messages.fk_users_sender    = '$sender'     ,
                        users_private_messages.sent_at            = '$sent_at'    ,
                        users_private_messages.read_at            = '$read_at'    ,
                        users_private_messages.title              = '$title'      ,
                        users_private_messages.body               = '$body'       ");

  // We return 1 to show the message was sent
  return 1;
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                ACTIVITY MANAGEMENT                                                */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Throws an error if the user is currently flooding the website, then updates the last activity date.
 *
 * Keep in mind, since an error is being thrown, this interrupts the rest of the process of the page.
 *
 * @param   string|null $lang       (OPTIONAL)  The language currently being used.
 * @param   string|null $path       (OPTIONAL)  The path to the root of the website (defaults to 2 folders from root).
 * @param   string|null $menu_main  (OPTIONAL)  The main menu element to highlight in the menu bar in case of error.
 * @param   string|null $menu_side  (OPTIONAL)  The side menu element to highlight in the sidebar in case of error.
 * @param   int|null    $user_id    (OPTIONAL)  Specifies the ID of the user to check - if null, current user.
 *
 * @return  bool                                Is the user allowed to post content to the website.
 */

function flood_check($path='./../../', $lang='EN', $menu_main='NoBleme', $menu_side='Homepage', $user_id=NULL)
{
  // We need to prepare some translated strings
  $lang_login = ($lang == 'EN') ? 'You can only do this action while logged into your account' : 'Vous devez être connecté pour effectuer cette action';
  $lang_wait  = ($lang == 'EN') ? 'You must wait a bit between each action on the website<br><br>Try doing it again in 10 seconds' : 'Vous devez attendre quelques secondes entre chaque action<br><br>Réessayez dans 10 secondes';

  // If the user is logged out, then he shouldn't be able to do any actions, we throw an error
  if(is_null($user_id) && !user_is_logged_in())
    error_page($lang_login, $path, $lang, $menu_main, $menu_side);

  // Let's fetch and sanitize the user's ID
  $user_id = (!is_null($user_id)) ? $user_id : user_get_id();
  $user_id = sanitize($user_id, 'int', 0);

  // We can go fetch the user's recent activity
  $dactivity = mysqli_fetch_array(query(" SELECT  users.last_action_at AS 'u_last'
                                          FROM    users
                                          WHERE   users.id = '$user_id' "));

  // If the last activity for the user happened less than 10 seconds ago, we throw an error
  $timestamp = time();
  if(($timestamp - $dactivity['u_last']) <= 10 )
    error_page($lang_wait, $path, $lang, $menu_main, $menu_side);

  // We can now update the last activity of the user
  query(" UPDATE  users
          SET     users.last_action_at  = '$timestamp'
          WHERE   users.id              = '$user_id' ");

  // Just in case, we return 1
  return 1;
}




/**
 * Adds an entry to the recent activity logs.
 *
 * @param   string          $activity_type                      The identifier of the activity log's type.
 * @param   bool|null       $is_administrators_only (OPTIONAL)  Is it a public activity log or a moderation log.
 * @param   int|null        $fk_users               (OPTIONAL)  ID of the user implicated in the activity log.
 * @param   string|null     $nickname               (OPTIONAL)  Nickname of the user implicated in the activity log.
 * @param   int|null        $activity_id            (OPTIONAL)  ID of the item linked to the activity log.
 * @param   string|null     $activity_summary       (OPTIONAL)  Summary of the activity log.
 * @param   string|int|null $activity_parent        (OPTOINAL)  Summary or ID of the parent to the item in question.
 * @param   string|null     $moderation_reason      (OPTOINAL)  Reason specified by the moderator for the activity.
 * @param   bool|null       $do_not_sanitize        (OPTOINAL)  If set, do not sanitize the data.
 *
 * @return  int                                                 The ID of the newly inserted activity log.
 */

function log_activity($activity_type, $is_administrators_only=0, $fk_users=0, $nickname=NULL, $activity_id=0, $activity_summary=NULL, $activity_parent=NULL, $moderation_reason=NULL, $do_not_sanitize=0)
{
  // We sanitize and prepare the data
  $timestamp              = sanitize(time(), 'int', 0);
  $activity_type          = sanitize($activity_type, 'string');
  $is_administrators_only = sanitize($is_administrators_only, 'int', 0, 1);
  $fk_users               = sanitize($fk_users, 'int', 0);
  $nickname               = ($do_not_sanitize) ? $nickname : sanitize($nickname, 'string');
  $activity_id            = sanitize($activity_id, 'int', 0);
  $activity_summary       = ($do_not_sanitize) ? $activity_summary : sanitize($activity_summary, 'string');
  $activity_parent        = ($do_not_sanitize) ? $activity_parent : sanitize($activity_parent, 'string');
  $moderation_reason      = ($do_not_sanitize) ? $moderation_reason : sanitize($moderation_reason, 'string');

  // We create the activity log by inserting it in the table
  query(" INSERT INTO logs_activity
          SET         logs_activity.happened_at             = '$timestamp'              ,
                      logs_activity.is_administrators_only  = '$is_administrators_only' ,
                      logs_activity.fk_users                = '$fk_users'               ,
                      logs_activity.nickname                = '$nickname'               ,
                      logs_activity.activity_type           = '$activity_type'          ,
                      logs_activity.activity_id             = '$activity_id'            ,
                      logs_activity.activity_summary        = '$activity_summary'       ,
                      logs_activity.activity_parent         = '$activity_parent'        ,
                      logs_activity.moderation_reason       = '$moderation_reason'      ");

  // We end this by returning the ID of the newly created activity log
  return(mysqli_insert_id($GLOBALS['db']));
}




/**
 * Adds an entry to the recent activity detailed logs.
 *
 * @param   int         $linked_activity_log              ID of the recent activity log to which this is linked.
 * @param   string      $description                      Description of the detailed activity log.
 * @param   string      $before                           Previous value of the content.
 * @param   string|null $after                (OPTIONAL)  Current value of the content.
 * @param   bool|null   $optional             (OPTIONAL)  The log will only be created if before / after are different.
 * @param   bool|null   $do_not_sanitize      (OPTOINAL)  If set, do not sanitize the data.
 *
 * @return  void
 */

function log_activity_details($linked_activity_log, $description, $before, $after=NULL, $optional=0, $do_not_sanitize = 0)
{
  // If no diff log should be created, we exit now
  if($optional && ($before == $after))
    return 0;

  // In order to avoid strain caused by the diff functions, we do not create a diff log if $after is too long
  $after = (strlen($after) > 10000) ? NULL : $after;

  // We sanitize the data if required
  $linked_activity_log  = sanitize($linked_activity_log, 'int', 0);
  $description          = ($do_not_sanitize) ? $description : sanitize($description, 'string');
  $before               = ($do_not_sanitize) ? $before : sanitize($before, 'string');
  $after                = ($do_not_sanitize) ? $after : sanitize($after, 'string');

  // We can now create the detailed log
  query(" INSERT INTO logs_activity_details
          SET         logs_activity_details.fk_logs_activity    = '$linked_activity_log'  ,
                      logs_activity_details.content_description = '$description'          ,
                      logs_activity_details.content_before      = '$before'               ,
                      logs_activity_details.content_after       = '$after'                ");
}




/**
 * Deletes all orphan entries in the detailed activity logs.
 *
 * This will remove all entries in thes logs_activity_details table which have no linked entry in logs_activity.
 *
 * @return  void
 */

function log_activity_purge_orphan_diffs()
{
  // We fetch all orphan diffs
  $qorphans = query(" SELECT    logs_activity_details.id AS 'd_id'
                      FROM      logs_activity_details
                      LEFT JOIN logs_activity ON logs_activity_details.fk_logs_activity = logs_activity.id
                      WHERE     logs_activity.id IS NULL ");

  // And we stealthily choke them to death
  while($dorphans = mysqli_fetch_array($qorphans))
  {
    $orphan_id = sanitize($dorphans['d_id'], 'int', 0);
    query(" DELETE FROM logs_activity_details
            WHERE       logs_activity_details.id = '$orphan_id' ");
  }
}




/**
 * Deletes an entry in the activity logs.
 *
 * @param   string          $activity_type                      The identifier of the activity log's type.
 * @param   bool|null       $is_administrators_only (OPTIONAL)  Is it a public activity log or a moderation log.
 * @param   int|null        $fk_users               (OPTIONAL)  ID of the user implicated in the activity log.
 * @param   string|null     $nickname               (OPTIONAL)  Nickname of the user implicated in the activity log.
 * @param   int|null        $activity_id            (OPTIONAL)  ID of the item linked to the activity log.
 * @param   bool|null       $global_type_wipe       (OPTOINAL)  Deletes all logs of type beginning like $activity_type.
 *
 * @return  void
 */

function activite_supprimer($activity_type, $is_administrators_only=0, $fk_users=0, $nickname=NULL, $activity_id=0, $global_type_wipe=0)
{
  // We begin by sanitizing the data
  $activity_type          = sanitize($activity_type, 'string');
  $is_administrators_only = sanitize($is_administrators_only, 'int', 0, 1);
  $fk_users               = sanitize($fk_users, 'int', 0);
  $nickname               = sanitize($nickname, 'string');
  $activity_id            = sanitize($activity_id, 'int', 0);
  $global_type_wipe       = sanitize($global_type_wipe, 'int', 0, 1);

  // We begin building our query
  $qactivity    = " DELETE FROM logs_activity ";

  // Depending on whether this is a global type wipe or not, we do a different kind of string matching
  if(!$global_type_wipe)
    $qactivity .= " WHERE       logs_activity.activity_type           LIKE  '$activity_type' ";
  else
    $qactivity .= " WHERE       logs_activity.activity_type           LIKE  '$activity_type%' ";

  // We treat public and private logs separately
  $qactivity .= "   AND         logs_activity.is_administrators_only  =     '$is_administrators_only' ";

  // Optional parameters
  if($fk_users)
    $qactivity .= " AND         logs_activity.fk_users                =     '$fk_users' ";
  if($nickname)
    $qactivity .= " AND         logs_activity.nickname                LIKE  '$nickname' ";
  if($activity_id)
    $qactivity .= " AND         logs_activity.activity_id             =     '$activity_id' ";

  // We can now run the query and delete the activity
  query($qactivity);

  // We purge all orphaned detailed activity logs
  log_activity_purge_orphan_diffs();
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      IRC BOT                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Uses the IRC bot to broadcast a message.
 *
 * @param   string      $message                              The message to send.
 * @param   string|null $channel                  (OPTIONAL)  The IRC channel on which the message should be sent.
 * @param   string|null $path                     (OPTIONAL)  Path to the website root (defaults to 2 folders away).
 * @param   bool|null   $allow_special_formatting (OPTIONAL)  Allow IRC formatting characters in the message.
 *
 * @return  bool                                              Whether the message has been queued in the bot's file.
 */

function ircbot($message, $channel=NULL, $path='./../../', $allow_special_formatting=0)
{
  // We sanitize the message for IRC usage
  $message = str_replace("\\n", '', $message);
  $message = str_replace("\\r", '', $message);
  $message = str_replace("\\t", '', $message);

  // If allowed, we apply special formatting to the message
  if($allow_special_formatting)
  {
    // Swap special characters for bytes
    $message = str_replace('%O',chr(0x0f),$message);        // Reset
    $message = str_replace('%B',chr(0x02),$message);        // Bold
    $message = str_replace('%I',chr(0x1d),$message);        // Italics
    $message = str_replace('%U',chr(0x1f),$message);        // Underline
    $message = str_replace('%C00',chr(0x03).'00',$message); // Color: White
    $message = str_replace('%C01',chr(0x03).'01',$message); // Color: Black
    $message = str_replace('%C02',chr(0x03).'02',$message); // Color: Blue
    $message = str_replace('%C03',chr(0x03).'03',$message); // Color: Green
    $message = str_replace('%C04',chr(0x03).'04',$message); // Color: Red
    $message = str_replace('%C05',chr(0x03).'05',$message); // Color: Brown
    $message = str_replace('%C06',chr(0x03).'06',$message); // Color: Purple
    $message = str_replace('%C07',chr(0x03).'07',$message); // Color: Orange
    $message = str_replace('%C08',chr(0x03).'08',$message); // Color: Yellow
    $message = str_replace('%C09',chr(0x03).'09',$message); // Color: Light green
    $message = str_replace('%C10',chr(0x03).'10',$message); // Color: Teal
    $message = str_replace('%C11',chr(0x03).'11',$message); // Color: Light cyan
    $message = str_replace('%C12',chr(0x03).'12',$message); // Color: Ligh blue
    $message = str_replace('%C13',chr(0x03).'13',$message); // Color: Pink
    $message = str_replace('%C14',chr(0x03).'14',$message); // Color: Grey

    // Custom made bytes
    $message = str_replace('%NB',chr(0x02).chr(0x03).'00,01',$message);              // Bold white on black
    $message = str_replace('%TROLL',chr(0x1f).chr(0x02).chr(0x03).'08,13',$message); // Bold underlined yellow on green
  }

  // If we are allowed to write in the file, then we queue a message
  if($fichier_ircbot = fopen($path.'ircbot.txt', "a"))
  {
    // Depending on whether a channel is specifiied, the message is sent to the server or to a channel
    if(!$channel)
      file_put_contents($path.'ircbot.txt', time()." ".substr($message,0,450).PHP_EOL, FILE_APPEND);
    else
      file_put_contents($path.'ircbot.txt', time()." PRIVMSG ".$channel." :".substr($message,0,450).PHP_EOL, FILE_APPEND);

    // Close the IRCbot file
    fclose($fichier_ircbot);

    // We return 1 now that the work is done
    return 1;
  }
  // If we can't write in the IRCbot file, we return 0
  else
    return 0;
}