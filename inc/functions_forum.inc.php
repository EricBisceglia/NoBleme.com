<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/**
 * Fetch the full name of a forum thread mode.
 *
 * Forum threads have unique modes, which are stored in the database using short names.
 * This function fetches their mode in a specified format, simply enough.
 *
 * @param   string      $mode               The short name of the forum thread mode.
 * @param   string      $format             The expected format of the returned value ('short' or 'full').
 * @param   string|null $lang   (OPTIONAL)  The language of the returned string, defaults to user's current language.
 *
 * @return  string                          The full name of the forum thread mode.
 */

function forum_fetch_mode($mode, $format, $lang=null)
{
  // Fetch the user's language if required
  $lang = (!$lang) ? user_get_language() : $lang;

  // Short mode
  if($format == 'short')
  {
    // Thread formats
    if($mode == 'thread')
      return ($lang == 'EN') ? 'Thread': 'Fil';
    else if($mode == 'thread_anonymous')
      return ($lang == 'EN') ? 'Anonymous' : 'Anonyme';

    // Thread types
    else if($mode == 'standard')
      return ($lang == 'EN') ? '' : '';
    else if($mode == 'serious')
      return ($lang == 'EN') ? 'Serious' : 'Sérieux';
    else if($mode == 'debate')
      return ($lang == 'EN') ? 'Debate' : 'Débat';
    else if($mode == 'game')
      return ($lang == 'EN') ? 'Forum game' : 'Jeu de forum';
  }

  // Full mode
  else if($format == 'full')
  {
    // Thread formats
    if($mode == 'thread')
      return ($lang == 'EN') ? 'Linear thread' : 'Fil de discussion';
    else if($mode == 'thread_anonymous')
      return ($lang == 'EN') ? 'Anonymous thread' : 'Fil de discussion anonyme';

    // Thread types
    else if($mode == 'standard')
      return ($lang == 'EN') ? 'Standard topic' : 'Sujet standard';
    else if($mode == 'serious')
      return ($lang == 'EN') ? 'Serious topic' : 'Sujet sérieux';
    else if($mode == 'debate')
      return ($lang == 'EN') ? 'Debate' : 'Débat d\'opinion';
    else if($mode == 'game')
      return ($lang == 'EN') ? 'Forum game' : 'Jeu de forum';
  }

  // Return an empty string if no match was found
  return '';
}




/**
 * Counts the number of forum messages posted by an user.
 *
 * @param   int $user_id (OPTIONAL) The id of the user whose post count should be updated.
 *
 * @return  int                     The post count of the user.
 */

function forum_update_user_message_count($user_id=0)
{
  // Fetch the sum of all the messages that count
  $dposts = mysqli_fetch_array(query("  SELECT    COUNT(*) AS 'message_count'
                                        FROM      forum_messages
                                        LEFT JOIN forum_threads ON forum_messages.fk_forum_threads = forum_threads.id
                                        WHERE     forum_messages.fk_author                         = '$user_id'
                                        AND       forum_threads.is_private                         = 0
                                        AND       forum_threads.thread_format               NOT LIKE 'thread_anonymous'
                                        AND       forum_threads.thread_type                 NOT LIKE 'game' "));

  // Data sanitization
  $user_id        = sanitize($user_id, 'int', 0);
  $message_count  = sanitize($dposts['message_count'], 'int', 0);

  // Update the user's message count
  query(" UPDATE  users_stats
          SET     users_stats.forum_message_count = '$message_count'
          WHERE   users_stats.id                  = '$user_id' ");

  // Might aswell return the message count
  return $message_count;
}




/**
 * Counts the number of forum messages posted in a forum thread.
 *
 * @param   int $thread_id (OPTIONAL) The id of the thread whose post count should be updated.
 *
 * @return  int                       The post count of the thread.
 */

function forum_update_thread_message_count($thread_id=0)
{
  // Fetch the sum of all of the thread's messages
  $dposts = mysqli_fetch_array(query("  SELECT    COUNT(*) AS 'message_count'
                                        FROM      forum_messages
                                        LEFT JOIN forum_threads ON forum_messages.fk_forum_threads  = forum_threads.id
                                        WHERE     forum_messages.fk_forum_threads                   = '$thread_id' "));

  // Data sanitization
  $thread_id        = sanitize($thread_id, 'int', 0);
  $message_count    = sanitize($dposts['message_count'], 'int', 0);

  // Update the thread's message count
  query(" UPDATE  forum_threads
          SET     forum_threads.nb_messages = '$message_count'
          WHERE   forum_threads.id          = '$thread_id' ");

  // Might aswell return the message count
  return $message_count;
}