<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/**
 * Returns in plain text how long ago a timestamp happened.
 *
 * @param   string      $timestamp              The timestamp at which the event happened.
 *
 * @return  string                              A plain text description of how long ago the event happened.
 */

function time_since($timestamp)
{
  // Base the result on the difference between the event and the current timestamp
  $time_since = time() - $timestamp;

  // Return the time difference in plain text
  if($time_since < 0)
    return __('time_diff_past_future');
  else if ($time_since == 0)
    return __('time_diff_past_now');
  else if ($time_since == 1)
    return __('time_diff_past_second');
  else if ($time_since <= 60)
    return __('time_diff_past_seconds', $time_since, 0, 0, array($time_since));
  else if ($time_since <= 120)
    return __('time_diff_past_minute');
  else if ($time_since <= 3600)
    return __('time_diff_past_minutes', $time_since, 0, 0, array(floor($time_since/60)));
  else if ($time_since <= 7200)
    return __('time_diff_past_hour');
  else if ($time_since <= 86400)
    return __('time_diff_past_hours', $time_since, 0, 0, array(floor($time_since/3600)));
  else if ($time_since <= 172800)
    return __('time_diff_past_day');
  else if ($time_since <= 259200)
    return __('time_diff_past_2days');
  else if ($time_since <= 31536000)
    return __('time_diff_past_days', $time_since, 0, 0, array(floor($time_since/86400)));
  else if ($time_since <= 63072000)
    return __('time_diff_past_year');
  else if ($time_since <= 3153600000)
    return __('time_diff_past_years', $time_since, 0, 0, array(floor($time_since/31536000)));
  else if ($time_since <= 6307200000)
    return __('time_diff_past_century');
  else
    return __('time_diff_past_long');
}




/**
 * Returns in plain text in how long a timestamp will happen.
 *
 * @param   string      $timestamp              The timestamp at which the event will happen.
 *
 * @return  string                              A plain text description of how long remains until the event.
 */

function time_until($timestamp)
{
  // Base the result on the difference between the event and the current timestamp
  $time_until = $timestamp - time();

  // Return the time difference in plain text
  if($time_until < 0)
    return __('time_diff_future_past');
  else if ($time_until == 0)
    return __('time_diff_past_now');
  else if ($time_until == 1)
    return __('time_diff_future_second');
  else if ($time_until < 60)
    return __('time_diff_future_seconds', $time_until, 0, 0, array($time_until));
  else if ($time_until < 120)
    return __('time_diff_future_minute');
  else if ($time_until < 3600)
    return __('time_diff_future_minutes', $time_until, 0, 0, array(floor($time_until/60)));
  else if ($time_until < 7200)
    return __('time_diff_future_hour');
  else if ($time_until < 86400)
    return __('time_diff_future_hours', $time_until, 0, 0, array(floor($time_until/3600)));
  else if ($time_until < 172800)
    return __('time_diff_future_day');
  else if ($time_until < 259200)
    return __('time_diff_future_2days');
  else if ($time_until < 31536000)
    return  __('time_diff_future_days', $time_until, 0, 0, array(floor($time_until/86400)));
  else if ($time_until < 63072000)
    return __('time_diff_future_year');
  else if ($time_until < 3153600000)
    return __('time_diff_future_years', $time_until, 0, 0, array(floor($time_until/31536000)));
  else if ($time_until < 6307200000)
    return __('time_diff_future_century');
  else
    return __('time_diff_future_long');
}




/**
 * Calculates the number of days elapsed between two MySQL dates.
 *
 * @param   string  $date_start The starting date.
 * @param   string  $date_end   The ending date.
 *
 * @return  int                 The amount of days elapsed.
 */

function time_days_elapsed( $date_start ,
                            $date_end   )
{
  // Return the time elapsed between the two dates: convert them to timestamps and divide by the total seconds in a day
  return round(floor(abs(strtotime($date_start)) - abs(strtotime($date_end))) / (86400));
}