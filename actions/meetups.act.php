<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  meetups_get                   Fetches data related to a meetup.                                                  */
/*  meetups_list                  Fetches a list of meetups.                                                         */
/*  meetups_list_attendees        Fetches a list of people attending a specific meetup.                              */
/*                                                                                                                   */
/*  meetups_list_years            Fetches the years at which meetups happened.                                       */
/*  meetups_get_max_attendees     Fetches the highest number of attendees in a meetup.                               */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Fetches data related to a meetup.
 *
 * @param   int         $meetup_id  The meetup's id.
 *
 * @return  array|null              An array containing related data, or null if it does not exist.
 */

function meetups_get( int $meetup_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Sanitize the data
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Check if the meetup exists
  if(!database_row_exists('meetups', $meetup_id))
    return NULL;

  // Fetch the user's language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the data
  $dmeetup = mysqli_fetch_array(query(" SELECT    meetups.is_deleted      AS 'm_deleted'    ,
                                                  meetups.event_date      AS 'm_date'       ,
                                                  meetups.location        AS 'm_location'   ,
                                                  meetups.languages       AS 'm_lang'       ,
                                                  meetups.details_$lang   AS 'm_details'
                                        FROM      meetups
                                        WHERE     meetups.id = '$meetup_id' "));

  // Only moderators can see deleted meetups
  if($dmeetup['m_deleted'] && !user_is_moderator())
    return NULL;

  // Assemble an array with the data
  $data['id']             = $meetup_id;
  $data['is_deleted']     = sanitize_output($dmeetup['m_deleted']);
  $data['is_finished']    = (strtotime(date('Y-m-d')) > strtotime($dmeetup['m_date']));
  $data['is_today']       = (date('Y-m-d') == $dmeetup['m_date']);
  $data['date']           = sanitize_output(date_to_text($dmeetup['m_date']));
  $data['date_en']        = sanitize_output(date_to_text($dmeetup['m_date'], lang: 'EN'));
  $data['date_short_en']  = date_to_text($dmeetup['m_date'], strip_day: 1, lang: 'EN');
  $data['date_short_fr']  = date_to_text($dmeetup['m_date'], strip_day: 1, lang: 'FR');
  $data['location']       = sanitize_output($dmeetup['m_location']);
  $temp                   = time_days_elapsed(date('Y-m-d'), $dmeetup['m_date']);
  $data['days_until']     = sanitize_output($temp.__('day', amount: $temp, spaces_before: 1));
  $data['wrong_lang_en']  = ($lang == 'en' && !str_contains($dmeetup['m_lang'], 'EN'));
  $data['wrong_lang_fr']  = ($lang == 'fr' && !str_contains($dmeetup['m_lang'], 'FR'));
  $data['details']        = bbcodes(sanitize_output($dmeetup['m_details'], preserve_line_breaks: true));

  // Return the data
  return $data;
}




/**
 * Returns a list of meetups.
 *
 * @param   string  $sort_by  (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array                         An array containing meetups.
 */

function meetups_list(  string  $sort_by  = 'date'  ,
                        array   $search   = array() ) : array
{
  // Sanitize the search parameters
  $search_date      = isset($search['date'])      ? sanitize($search['date'], 'int', 0)     : NULL;
  $search_lang      = isset($search['lang'])      ? sanitize($search['lang'], 'string')     : NULL;
  $search_location  = isset($search['location'])  ? sanitize($search['location'], 'string') : NULL;
  $search_people    = isset($search['people'])    ? sanitize($search['people'], 'int', 0)   : 0;

  // Fetch the meetups
  $qmeetups = "     SELECT    meetups.id              AS 'm_id'       ,
                              meetups.is_deleted      AS 'm_deleted'  ,
                              meetups.event_date      AS 'm_date'     ,
                              meetups.location        AS 'm_location' ,
                              meetups.languages       AS 'm_lang'     ,
                              meetups.attendee_count  AS 'm_people'   ,
                              meetups.details_en      AS 'm_desc_en'  ,
                              meetups.details_fr      AS 'm_desc_fr'
                    FROM      meetups
                    WHERE     1 = 1 ";

  // Do not show deleted meetups to regular users
  if(!user_is_moderator())
    $qmeetups .= "  AND       meetups.is_deleted        = 0                     ";

  // Search the data
  if($search_date)
    $qmeetups .= "  AND       YEAR(meetups.event_date)  = '$search_date'        ";
  if($search_lang == 'ENFR' || $search_lang == 'FREN')
    $qmeetups .= "  AND     ( meetups.languages      LIKE 'ENFR'
                    OR        meetups.languages      LIKE 'FREN' )              ";
  else if($search_lang)
    $qmeetups .= "  AND       meetups.languages      LIKE '$search_lang'        ";
  if($search_location)
    $qmeetups .= "  AND       meetups.location       LIKE '%$search_location%'  ";
  if($search_people)
    $qmeetups .= "  AND       meetups.attendee_count   >= '$search_people'      ";

  // Sort the data
  if($sort_by == 'location')
    $qmeetups .= " ORDER BY   meetups.location        ASC   ,
                              meetups.event_date      DESC  ";
  else if($sort_by == 'people')
    $qmeetups .= " ORDER BY   meetups.attendee_count  DESC  ,
                              meetups.event_date      DESC  ";
  else
    $qmeetups .= " ORDER BY   meetups.event_date      DESC  ";

  // Run the query
  $qmeetups = query($qmeetups);

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmeetups); $i++)
  {
    $data[$i]['id']         = $row['m_id'];
    $temp                   = ($row['m_deleted']) ? 'text_red': 'green dark_hover text_white';
    $data[$i]['css']        = ($row['m_deleted'] || (strtotime($row['m_date']) > time())) ? ' '.$temp : '';
    $data[$i]['css_link']   = ($row['m_deleted']) ? 'text_red text_white_hover' : '';
    $data[$i]['deleted']    = $row['m_deleted'];
    $data[$i]['date']       = sanitize_output(date_to_text($row['m_date']));
    $data[$i]['lang_en']    = str_contains($row['m_lang'], 'EN');
    $data[$i]['lang_fr']    = str_contains($row['m_lang'], 'FR');
    $data[$i]['location']   = sanitize_output($row['m_location']);
    $data[$i]['people']     = sanitize_output($row['m_people']);
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Returns a list of people attending a specific meetup.
 *
 * @param   string  $meetup_id  (OPTIONAL)  The meetup's id.
 *
 * @return  array                           An array containing meetup attendees, or NULL if it doesn't exist.
 */

function meetups_list_attendees( int $meetup_id = 0 ) : array
{
  // Check if the required files have been included
  require_included_file('bbcodes.inc.php');

  // Sanitize the data
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Check if the meetup exists
  if(!database_row_exists('meetups', $meetup_id))
    return NULL;

  // Fetch the user's language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Fetch the attendees
  $qattendees = query(" SELECT    meetups.is_deleted                      AS 'm_deleted'  ,
                                  users.id                                AS 'u_id'       ,
                                  users.username                          AS 'u_nick'     ,
                                  meetups_people.username                 AS 'm_nick'     ,
                                  meetups_people.attendance_confirmed     AS 'm_lock'     ,
                                  meetups_people.extra_information_$lang  AS 'm_extra'
                        FROM      meetups_people
                        LEFT JOIN users   ON meetups_people.fk_users    = users.id
                        LEFT JOIN meetups ON meetups_people.fk_meetups  = meetups.id
                        WHERE     meetups_people.fk_meetups             = '$meetup_id'
                        ORDER BY  IF(meetups_people.username IS NULL, users.username, meetups_people.username) ASC ");

  // Loop through the data
  for($i = 0; $row = mysqli_fetch_array($qattendees); $i++)
  {
    // Only moderators can see deleted meetups
    if(!$i && $row['m_deleted'] && !user_is_moderator())
      return NULL;

    // Prepare the data
    $data[$i]['nick']   = ($row['m_nick']) ? sanitize_output($row['m_nick']) : sanitize_output($row['u_nick']);
    $data[$i]['lock']   = $row['m_lock'];
    $data[$i]['extra']  = bbcodes(sanitize_output($row['m_extra']));
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches the years at which meetups happened.
 *
 * @return  array   An array containing years.
 */

function meetups_list_years() : array
{
  // Fetch the meetup years
  $qmeetups = query(" SELECT    YEAR(meetups.event_date) AS 'm_year'
                      FROM      meetups
                      GROUP BY  YEAR(meetups.event_date)
                      ORDER BY  YEAR(meetups.event_date) DESC ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmeetups); $i++)
    $data[$i]['year'] = sanitize_output($row['m_year']);

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Fetches the highest number of attendees in a meetup.
 *
 * @return  int   The highest number of attendees in a meetup.
 */

function meetups_get_max_attendees() : int
{
  // Look up the most attended meetup
  $dmeetups = mysqli_fetch_array(query("  SELECT  MAX(meetups.attendee_count) AS 'm_max'
                                          FROM    meetups "));

  // Return the result
  return $dmeetups['m_max'];
}