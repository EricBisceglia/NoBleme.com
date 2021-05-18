<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  meetups_list                  Fetches a list of meetups.                                                         */
/*                                                                                                                   */
/*  meetups_list_years            Fetches the years at which meetups happened.                                       */
/*  meetups_get_max_attendees     Fetches the highest number of attendees in a meetup.                               */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Returns a list of meetups.
 *
 * @param   string  $sort_by  (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 *
 * @return  array   An array containing meetups.
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