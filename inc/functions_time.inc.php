<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../pages/nobleme/404")); die(); }


/**
 * Returns in plain text how long ago a timestamp happened.
 *
 * @param   string      $timestamp              The timestamp at which the event happened.
 * @param   string|null $lang       (OPTIONAL)  The language in which the text should be.
 *
 * @return  string                              A plain text description of how long ago the event happened.
 */

function time_since($timestamp, $lang="EN")
{
  // We will base our result on the difference between the event and the current timestamp
  $time_since = time() - $timestamp;

  // We can now proceed to return the time difference in plain text
  if($time_since < 0)
    return ($lang == 'EN') ? "In the future" : "Dans le futur";
  else if ($time_since == 0)
    return ($lang == 'EN') ? "Right now" : "En ce moment même";
  else if ($time_since == 1)
    return ($lang == 'EN') ? "A second ago" : "Il y a 1 seconde";
  else if ($time_since <= 60)
    return ($lang == 'EN') ? $time_since." seconds ago" : "Il y a ".$time_since." secondes";
  else if ($time_since <= 120)
    return ($lang == 'EN') ? "A minute ago" : "Il y a 1 minute";
  else if ($time_since <= 3600)
    return ($lang == 'EN') ? floor($time_since/60)." minutes ago" : "Il y a ".floor($time_since/60)." minutes";
  else if ($time_since <= 7200)
    return ($lang == 'EN') ? "An hour ago" : "Il y a 1 heure";
  else if ($time_since <= 86400)
    return ($lang == 'EN') ? floor($time_since/3600)." hours ago" : "Il y a ".floor($time_since/3600)." heures";
  else if ($time_since <= 172800)
    return ($lang == 'EN') ? "Yesterday" : "Hier";
  else if ($time_since <= 259200)
    return ($lang == 'EN') ? floor($time_since/86400)." days ago" : "Avant-hier";
  else if ($time_since <= 31536000)
    return ($lang == 'EN') ? floor($time_since/86400)." days ago" : "Il y a ".floor($time_since/86400)." jours";
  else if ($time_since <= 63072000)
    return ($lang == 'EN') ? "A year ago" : "L'année dernière";
  else if ($time_since <= 3153600000)
    return ($lang == 'EN') ? floor($time_since/31536000)." years ago" : "Il y a ".floor($time_since/31536000)." ans";
  else if ($time_since <= 6307200000)
    return ($lang == 'EN') ?  "A century ago" : "Le siècle dernier";
  else
    return ($lang == 'EN') ? "An extremely long time ago" : "Il y a très très longtemps";
}




/**
 * Returns in plain text in how long a timestamp will happen.
 *
 * @param   string      $timestamp              The timestamp at which the event will happen.
 * @param   string|null $lang       (OPTIONAL)  The language in which the text should be.
 *
 * @return  string                              A plain text description of how long remains until the event.
 */

function time_until($timestamp, $lang="EN")
{
  // We will base our result on the difference between the event and the current timestamp
  $time_until = $timestamp - time();

  // We can now proceed to return the time difference in plain text
  if($time_until < 0)
    return ($lang == 'EN') ? "In the past" : "Dans le passé";
  else if ($time_until == 0)
    return ($lang == 'EN') ? "Right now" : "En ce moment même";
  else if ($time_until == 1)
    return ($lang == 'EN') ? "In 1 second" : "Dans 1 seconde";
  else if ($time_until < 60)
    return ($lang == 'EN') ? "In ".$time_until." seconds" : "Dans ".$time_until." secondes";
  else if ($time_until < 120)
    return ($lang == 'EN') ? "In 1 minute" : "Dans 1 minute";
  else if ($time_until < 3600)
    return ($lang == 'EN') ? "In ".floor($time_until/60)." minutes" : "Dans ".floor($time_until/60)." minutes";
  else if ($time_until < 7200)
    return ($lang == 'EN') ? "In 1 hour" : "Dans 1 heure";
  else if ($time_until < 86400)
    return ($lang == 'EN') ? "In ".floor($time_until/3600)." hours" : "Dans ".floor($time_until/3600)." heures";
  else if ($time_until < 172800)
    return ($lang == 'EN') ? "Tomorrow" : "Demain";
  else if ($time_until < 259200)
    return ($lang == 'EN') ? "In ".floor($time_until/86400)." days" : "Après-demain";
  else if ($time_until < 31536000)
    return ($lang == 'EN') ? "In ".floor($time_until/86400)." days" : "Dans ".floor($time_until/86400)." jours";
  else if ($time_until < 63072000)
    return ($lang == 'EN') ? "In 1 year" : "Dans 1 an";
  else if ($time_until < 3153600000)
    return ($lang == 'EN') ? "In ".floor($time_until/31536000)." years" : "Dans ".floor($time_until/31536000)." ans";
  else if ($time_until < 6307200000)
    return ($lang == 'EN') ?  "Next century" : "Dans un siècle";
  else
    return ($lang == 'EN') ? "In an extremely long time" : "Dans très très longtemps";
}