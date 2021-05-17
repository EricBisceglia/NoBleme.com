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
/*********************************************************************************************************************/


/**
 * Returns a list of meetups.
 *
 * @return  array   An array containing meetups.
 */

function meetups_list() : array
{
  // Do not show deleted meetups to regular users
  $show_deleted = (user_is_moderator()) ? '' : ' AND meetups.is_deleted = 0 ';

  // Fetch the meetups
  $qmeetups = query(" SELECT    meetups.id              AS 'm_id'       ,
                                meetups.is_deleted      AS 'm_deleted'  ,
                                meetups.event_date      AS 'm_date'     ,
                                meetups.location        AS 'm_location' ,
                                meetups.languages       AS 'm_lang'     ,
                                meetups.attendee_count  AS 'm_people'   ,
                                meetups.details_en      AS 'm_desc_en'  ,
                                meetups.details_fr      AS 'm_desc_fr'
                      FROM      meetups
                      WHERE     1 = 1
                                $show_deleted
                      ORDER BY  meetups.event_date  DESC ");

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