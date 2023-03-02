<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  meetups_get                         Fetches data related to a meetup.                                            */
/*  meetups_list                        Fetches a list of meetups.                                                   */
/*  meetups_add                         Creates a new meetup.                                                        */
/*  meetups_edit                        Modifies an existing meetup.                                                 */
/*  meetups_delete                      Soft deletes a meetup.                                                       */
/*  meetups_restore                     Restores a soft deleted meetup.                                              */
/*  meetups_hard_delete                 Permanently deletes a meetup.                                                */
/*                                                                                                                   */
/*  meetups_attendees_get               Fetches data related to a meetup attendee.                                   */
/*  meetups_attendees_list              Fetches a list of people attending a meetup.                                 */
/*  meetups_attendees_add               Adds an attendee to a meetup.                                                */
/*  meetups_attendees_edit              Modifies data related to a meetup attendee.                                  */
/*  meetups_attendees_update_count      Recounts the number of people attending a meetup.                            */
/*  meetups_attendees_delete            Removes an attendee from a meetup.                                           */
/*                                                                                                                   */
/*  meetups_list_years                  Fetches the years at which meetups happened.                                 */
/*  meetups_get_max_attendees           Fetches the highest number of attendees in a meetup.                         */
/*                                                                                                                   */
/*  meetups_stats_list                  Returns stats related to meetups.                                            */
/*  meetups_stats_recalculate_user      Recalculates meetups statistics for a specific user.                         */
/*  meetups_stats_recalculate_all       Recalculates meetups statistics.                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Fetches data related to a meetup.
 *
 * @param   int         $meetup_id              The meetup's id.
 * @param   string      $format     (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array|null              An array containing related data, or null if it does not exist.
 */

function meetups_get( int     $meetup_id          ,
                      string  $format     = 'html') : mixed
{
  // Check if the required files have been included
  require_included_file('functions_time.inc.php');
  require_included_file('bbcodes.inc.php');

  // Sanitize the data
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Check if the meetup exists
  if(!database_row_exists('meetups', $meetup_id))
    return NULL;

  // Fetch the data
  $dmeetup = mysqli_fetch_array(query(" SELECT    meetups.is_deleted      AS 'm_deleted'    ,
                                                  meetups.event_date      AS 'm_date'       ,
                                                  meetups.location        AS 'm_location'   ,
                                                  meetups.languages       AS 'm_lang'       ,
                                                  meetups.attendee_count  AS 'm_attendees'  ,
                                                  meetups.details_en      AS 'm_details_en' ,
                                                  meetups.details_fr      AS 'm_details_fr'
                                        FROM      meetups
                                        WHERE     meetups.id = '$meetup_id' "));

  // Only moderators can see deleted meetups
  if($dmeetup['m_deleted'] && !user_is_moderator())
    return NULL;

  // Fetch the user's language
  $lang = sanitize(string_change_case(user_get_language(), 'lowercase'), 'string');

  // Format the data
  $data               = NULL;
  $meetup_deleted     = $dmeetup['m_deleted'];
  $meetup_date        = $dmeetup['m_date'];
  $meetup_location    = $dmeetup['m_location'];
  $meetup_languages   = $dmeetup['m_lang'];
  $meetup_attendees   = $dmeetup['m_attendees'];
  $meetup_details     = $dmeetup['m_details_'.$lang];
  $meetup_details_en  = $dmeetup['m_details_en'];
  $meetup_details_fr  = $dmeetup['m_details_fr'];

  // Prepare the data for display
  if($format === 'html')
  {
    $data['id']             = $meetup_id;
    $data['is_deleted']     = sanitize_output($meetup_deleted);
    $data['is_finished']    = (strtotime(date('Y-m-d')) > strtotime($meetup_date));
    $data['is_today']       = (date('Y-m-d') === $meetup_date);
    $data['date']           = sanitize_output(date_to_text($meetup_date));
    $data['date_en']        = sanitize_output(date_to_text($meetup_date, lang: 'EN'));
    $data['date_short_en']  = date_to_text($meetup_date, strip_day: 1, lang: 'EN');
    $data['date_short_fr']  = date_to_text($meetup_date, strip_day: 1, lang: 'FR');
    $data['date_ddmmyy']    = sanitize_output(date('d/m/y', strtotime($meetup_date)));
    $data['location']       = sanitize_output($meetup_location);
    $data['location_raw']   = $meetup_location;
    $days_to_meetup         = time_days_elapsed(date('Y-m-d'), $meetup_date);
    $data['days_until']     = sanitize_output($days_to_meetup.__('day', amount: $days_to_meetup, spaces_before: 1));
    $data['lang_en']        = str_contains($meetup_languages, 'EN');
    $data['lang_fr']        = str_contains($meetup_languages, 'FR');
    $data['wrong_lang_en']  = ($lang === 'en' && !str_contains($meetup_languages, 'EN'));
    $data['wrong_lang_fr']  = ($lang === 'fr' && !str_contains($meetup_languages, 'FR'));
    $data['details']        = bbcodes(sanitize_output($meetup_details, preserve_line_breaks: true));
    $data['details_en']     = sanitize_output($meetup_details_en);
    $data['details_fr']     = sanitize_output($meetup_details_fr);
  }

  // Prepare the data for the API
  else if($format === 'api')
  {
    // Do not show deleted meetups in the API
    if($meetup_deleted)
      return NULL;

    // Meetup data
    $data['meetup']['id']             = (string)$meetup_id;
    $data['meetup']['date']           = $meetup_date;
    $data['meetup']['location']       = sanitize_json($meetup_location);
    $data['meetup']['attendee_count'] = (int)$meetup_attendees;
    $data['meetup']['link']           = $GLOBALS['website_url'].'pages/meetups/'.$meetup_id;
    $data['meetup']['details_en']     = sanitize_json(bbcodes_remove($meetup_details_en)) ?: NULL;
    $data['meetup']['details_fr']     = sanitize_json(bbcodes_remove($meetup_details_fr)) ?: NULL;

    // Language data
    $data['meetup']['languages_spoken']['english']  = (bool)str_contains($meetup_languages, 'EN');
    $data['meetup']['languages_spoken']['french']   = (bool)str_contains($meetup_languages, 'FR');

    // Attendee data
    $meetup_attendees = meetups_attendees_list($meetup_id);
    if($meetup_attendees['rows'])
    {
      for($i = 0; $i < $meetup_attendees['rows']; $i++)
      {
        $data['meetup']['attendees'][$i]['user_id']               = ($meetup_attendees[$i]['user_id'])
                                                                  ? (string)$meetup_attendees[$i]['user_id']
                                                                  : NULL;
        $data['meetup']['attendees'][$i]['username']              = sanitize_json($meetup_attendees[$i]['nick_raw']);
        $data['meetup']['attendees'][$i]['confirmed_attending']   = (bool)$meetup_attendees[$i]['lock'];
        $data['meetup']['attendees'][$i]['extra_info_en']         = sanitize_json($meetup_attendees[$i]['extra_en'])
                                                                  ?: NULL;
        $data['meetup']['attendees'][$i]['extra_info_fr']         = sanitize_json($meetup_attendees[$i]['extra_fr'])
                                                                  ?: NULL;
      }
    }
    else
      $data['meetup']['attendees'] = NULL;
  }

  // Return the data
  return $data;
}




/**
 * Returns a list of meetups.
 *
 * @param   string  $sort_by  (OPTIONAL)  How the returned data should be sorted.
 * @param   array   $search   (OPTIONAL)  Search for specific field values.
 * @param   string  $format   (OPTIONAL)  Formatting to use for the returned data ('html', 'api').
 *
 * @return  array                         An array containing meetups.
 */

function meetups_list(  string  $sort_by  = 'date'  ,
                        array   $search   = array() ,
                        string  $format   = 'html'  ) : array
{
  // Check if the required files have been included
  if($format === 'api')
    require_included_file('bbcodes.inc.php');

  // Sanitize the search parameters
  $search_date      = sanitize_array_element($search, 'date', 'int', min: 0, default: 0);
  $search_lang      = sanitize_array_element($search, 'lang', 'string');
  $search_lang_api  = sanitize_array_element($search, 'lang_api', 'string', case: 'uppercase');
  $search_location  = sanitize_array_element($search, 'location', 'string');
  $search_people    = sanitize_array_element($search, 'people', 'int', min: 0, default: 0);
  $search_user      = sanitize_array_element($search, 'attendee', 'int', min: 0, default: 0);

  // Hide deleted meetups to regular users
  $query_search = (!user_is_moderator() || $format === 'api') ? " AND meetups.is_deleted = 0 " : "";

  // Search the data: Languages
  if($search_lang === 'ENFR' || $search_lang === 'FREN')
    $query_search .= "  AND ( meetups.languages LIKE 'ENFR'
                        OR    meetups.languages LIKE 'FREN' ) ";
  else if($search_lang)
    $query_search .= "  AND   meetups.languages LIKE '$search_lang' ";
  if($search_lang_api)
    $query_search .= "  AND   meetups.languages LIKE '%$search_lang_api%' ";

  // Search the data: Other searches
  $query_search .= ($search_date)     ? " AND YEAR(meetups.event_date)  = '$search_date'        " : "";
  $query_search .= ($search_people)   ? " AND meetups.attendee_count   >= '$search_people'      " : "";
  $query_search .= ($search_location) ? " AND meetups.location       LIKE '%$search_location%'  " : "";

  // Sort the data
  $query_sort = match($sort_by)
  {
    'location'  => " ORDER BY meetups.location        ASC   ,
                              meetups.event_date      DESC  ,
                              meetups.id              DESC  " ,
    'people'    => " ORDER BY meetups.attendee_count  DESC  ,
                              meetups.event_date      DESC  ,
                              meetups.id              DESC  " ,
    default     => " ORDER BY meetups.event_date      DESC  ,
                              meetups.id              DESC  " ,
  };

  // Different query depending on whether the full meetup list or a single attendant's meetup list are being requested
  if(!$search_user)
    $query_from = " FROM      meetups
                    WHERE     1 = 1 ";
  else
    $query_from = " FROM      meetups_people
                    LEFT JOIN meetups ON meetups_people.fk_meetups  = meetups.id
                    WHERE     meetups_people.fk_users               = '$search_user' ";

  // Group by meetup if an attendee is being searched for
  $query_group = ($search_user) ? " GROUP BY meetups_people.fk_meetups " : "";

  // Fetch the meetups
  $qmeetups = query(" SELECT  meetups.id              AS 'm_id'       ,
                              meetups.is_deleted      AS 'm_deleted'  ,
                              meetups.event_date      AS 'm_date'     ,
                              meetups.location        AS 'm_location' ,
                              meetups.languages       AS 'm_lang'     ,
                              meetups.attendee_count  AS 'm_people'   ,
                              meetups.details_en      AS 'm_desc_en'  ,
                              meetups.details_fr      AS 'm_desc_fr'
                              $query_from
                              $query_search
                              $query_group
                              $query_sort ");

  // Prepare the data
  for($i = 0; $row = mysqli_fetch_array($qmeetups); $i++)
  {
    // Format the data
    $meetup_id          = $row['m_id'];
    $meetup_deleted     = $row['m_deleted'];
    $meetup_date        = $row['m_date'];
    $meetup_languages   = $row['m_lang'];
    $meetup_location    = $row['m_location'];
    $meetup_attendees   = $row['m_people'];
    $meetup_details_en  = $row['m_desc_en'];
    $meetup_details_fr  = $row['m_desc_fr'];

    // Prepare the data for display
    if($format === 'html')
    {
      $data[$i]['id']         = sanitize_output($meetup_id);
      $meetup_css             = ($meetup_deleted) ? 'text_red': 'green dark_hover text_white';
      $data[$i]['css']        = ($meetup_deleted || (strtotime($meetup_date) >= strtotime(date('Y-m-d'))))
                              ? ' '.$meetup_css
                              : '';
      $data[$i]['css_link']   = ($meetup_deleted) ? 'text_red text_white_hover' : '';
      $data[$i]['deleted']    = sanitize_output($meetup_deleted);
      $data[$i]['date']       = sanitize_output(date_to_text($meetup_date));
      $data[$i]['lang_en']    = str_contains($meetup_languages, 'EN');
      $data[$i]['lang_fr']    = str_contains($meetup_languages, 'FR');
      $data[$i]['location']   = sanitize_output($meetup_location);
      $data[$i]['people']     = sanitize_output($meetup_attendees);
    }

    // Prepare the data for the API
    else if($format === 'api')
    {
      // Meetup data
      $data[$i]['meetup']['id']             = (string)$meetup_id;
      $data[$i]['meetup']['date']           = $meetup_date;
      $data[$i]['meetup']['location']       = sanitize_json($meetup_location);
      $data[$i]['meetup']['attendee_count'] = (int)$meetup_attendees;
      $data[$i]['meetup']['link']           = $GLOBALS['website_url'].'pages/meetups/'.$meetup_id;
      $data[$i]['meetup']['details_en']     = sanitize_json(bbcodes_remove($meetup_details_en)) ?: NULL;
      $data[$i]['meetup']['details_fr']     = sanitize_json(bbcodes_remove($meetup_details_fr)) ?: NULL;

      // Language data
      $data[$i]['meetup']['languages_spoken']['english']  = (bool)str_contains($meetup_languages, 'EN');
      $data[$i]['meetup']['languages_spoken']['french']   = (bool)str_contains($meetup_languages, 'FR');
    }

    // Treat the case where a user search returns a row containing only NULL data
    if(!$i && $search_user && is_null($row['m_id']))
      $i = -1;
  }

  // Add the number of rows to the data
  if($format === 'html')
    $data['rows'] = $i;

  // Add to the data the username of the attendee being searched for
  if($search_user && $format === 'html')
    $data['attendee'] = user_get_username($search_user);

  // Give a default return value when no meetups are found
  $data = (isset($data)) ? $data : NULL;
  $data = ($format === 'api') ? array('meetups' => $data) : $data;

  // Return the prepared data
  return $data;
}




/**
 * Creates a new meetup.
 *
 * @param   array       $contents   The contents of the meetup.
 *
 * @return  string|int              An error string, or the meetup's id if it was properly created.
 */

function meetups_add( array $contents ) : mixed
{
  // Check if the required files have been included
  require_included_file('meetups.lang.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize and prepare the data
  $meetup_date        = sanitize_array_element($contents, 'date', 'string', convert_date: 'to_mysql', default: 0);
  $meetup_location    = sanitize_array_element($contents, 'location', 'string', max: 20);
  $meetup_details_en  = sanitize_array_element($contents, 'details_en', 'string');
  $meetup_details_fr  = sanitize_array_element($contents, 'details_fr', 'string');
  $meetup_lang        = ($contents['lang_en']) ? 'EN' : '';
  $meetup_lang       .= ($contents['lang_fr']) ? 'FR' : '';

  // Error: Incorrect date
  if(!$meetup_date || $meetup_date === '0000-00-00')
    return __('meetups_new_error_date');

  // Error: No location
  if(!$meetup_location)
    return __('meetups_new_error_location');

  // Error: No language
  if(!$meetup_lang)
    return __('meetups_new_error_language');

  // Create the meetup
  query(" INSERT INTO meetups
          SET         meetups.event_date  = '$meetup_date'        ,
                      meetups.location    = '$meetup_location'    ,
                      meetups.languages   = '$meetup_lang'        ,
                      meetups.details_en  = '$meetup_details_en'  ,
                      meetups.details_fr  = '$meetup_details_fr'  ");

  // Fetch the newly created meetup's id
  $meetup_id = query_id();

  // Scheduled task
  $meetup_end_date  = strtotime(date('Y-m-d H:i:s', strtotime("+1 day +1 hour +1 minute", strtotime($meetup_date))));
  $meetup_end_name  = $meetup_date.' '.$meetup_location;
  schedule_task(  action_type:        'meetups_end'     ,
                  action_id:          $meetup_id        ,
                  action_planned_at:  $meetup_end_date  ,
                  action_description: $meetup_end_name  ,
                  sanitize_data:      true              );

  // Fetch the username of the moderator creating the meetup
  $mod_username = user_get_username();

  // Activity log, for future meetups only
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
    log_activity( 'meetups_new'                         ,
                  language:             $meetup_lang    ,
                  activity_id:          $meetup_id      ,
                  activity_summary_en:  $meetup_date    ,
                  activity_summary_fr:  $meetup_date    );

  // Moderation log
  log_activity( 'meetups_new'                         ,
                is_moderators_only:   true            ,
                activity_id:          $meetup_id      ,
                activity_summary_en:  $meetup_date    ,
                activity_summary_fr:  $meetup_date    ,
                moderator_username:   $mod_username   );

  // Plain text meetup dates
  $meetup_date_en = date_to_text($meetup_date, lang: 'EN');
  $meetup_date_fr = date_to_text($meetup_date, lang: 'FR');

  // IRC bot message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    if(str_contains($meetup_lang, 'EN'))
      irc_bot_send_message("A new real life meetup is being planned on $meetup_date_en - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'english');
    if(str_contains($meetup_lang, 'FR'))
      irc_bot_send_message("Une nouvelle rencontre IRL est planifiée le $meetup_date_fr - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'french');
  }
  else
    irc_bot_send_message("A real life meetup has been created in the past by $mod_username on $meetup_date_en - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');

  // Discord message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    if(str_contains($meetup_lang, 'EN') && str_contains($meetup_lang, 'FR'))
    {
      $discord_message  = "A new real life meetup is being organized on $meetup_date_en";
      $discord_message .= PHP_EOL."Une nouvelle rencontre IRL est planifiée le $meetup_date_fr";
      $discord_message .= PHP_EOL."@here <".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
      discord_send_message($discord_message, 'main');
    }
    else if(str_contains($meetup_lang, 'EN'))
    {
      $discord_message  = "A new english speaking real life meetup is being organized on $meetup_date_en";
      $discord_message .= PHP_EOL."Une nouvelle rencontre IRL anglophone est planifiée le $meetup_date_en";
      $discord_message .= PHP_EOL."@here <".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
      discord_send_message($discord_message, 'main');
    }
    else if(str_contains($meetup_lang, 'FR'))
    {
      $discord_message  = "A new french speaking real life meetup is being organized on $meetup_date_en";
      $discord_message .= PHP_EOL."Une nouvelle rencontre IRL francophone est planifiée le $meetup_date_en";
      $discord_message .= PHP_EOL."@here <".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
      discord_send_message($discord_message, 'main');
    }
  }

  // Return the meetup's id
  return $meetup_id;
}




/**
 * Creates a new meetup.
 *
 * @param   array       $meetup_id  The meetup's id.
 * @param   array       $contents   The edited contents of the meetup.
 *
 * @return  string|null             An error string, or null if all went well.
 */

function meetups_edit(  int   $meetup_id  ,
                        array $contents   ) : mixed
{
  // Check if the required files have been included
  require_included_file('meetups.lang.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize and prepare the data
  $meetup_id          = sanitize($meetup_id, 'int', 0);
  $meetup_date        = sanitize_array_element($contents, 'date', 'string', convert_date: 'to_mysql', default: 0);
  $meetup_location    = sanitize_array_element($contents, 'location', 'string', max: 20);
  $meetup_details_en  = sanitize_array_element($contents, 'details_en', 'string');
  $meetup_details_fr  = sanitize_array_element($contents, 'details_fr', 'string');
  $meetup_lang        = ($contents['lang_en']) ? 'EN' : '';
  $meetup_lang       .= ($contents['lang_fr']) ? 'FR' : '';

  // Error: Meetup does not exist
  if(!database_row_exists('meetups', $meetup_id))
    return __('meetups_edit_error_id');

  // Error: Incorrect date
  if(!$meetup_date || $meetup_date === '0000-00-00')
    return __('meetups_new_error_date');

  // Error: No location
  if(!$meetup_location)
    return __('meetups_new_error_location');

  // Error: No language
  if(!$meetup_lang)
    return __('meetups_new_error_language');

  // Fetch the old meetup data
  $dmeetup = mysqli_fetch_array(query(" SELECT  meetups.is_deleted  AS 'm_deleted'  ,
                                                meetups.event_date  AS 'm_date'     ,
                                                meetups.location    AS 'm_location' ,
                                                meetups.languages   AS 'm_lang'     ,
                                                meetups.details_en  AS 'm_extra_en' ,
                                                meetups.details_fr  AS 'm_extra_fr'
                                        FROM    meetups
                                        WHERE   meetups.id = '$meetup_id' "));

  // Sanitize and prepare the old meetup data
  $meetup_deleted         = $dmeetup['m_deleted'];
  $meetup_date_old        = sanitize($dmeetup['m_date'], 'string');
  $meetup_location_old    = sanitize($dmeetup['m_location'], 'string');
  $meetup_lang_old        = sanitize($dmeetup['m_lang'], 'string');
  $meetup_details_en_old  = sanitize($dmeetup['m_extra_en'], 'string');
  $meetup_details_fr_old  = sanitize($dmeetup['m_extra_fr'], 'string');

  // Update the meetup
  query(" UPDATE  meetups
          SET     meetups.event_date  = '$meetup_date'        ,
                  meetups.location    = '$meetup_location'    ,
                  meetups.languages   = '$meetup_lang'        ,
                  meetups.details_en  = '$meetup_details_en'  ,
                  meetups.details_fr  = '$meetup_details_fr'
          WHERE   meetups.id          = '$meetup_id'          ");

  // Scheduled task
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    $meetup_end_date  = strtotime(date('Y-m-d H:i:s', strtotime("+1 day +1 hour +1 minute", strtotime($meetup_date))));
    $meetup_end_name  = $meetup_date.' '.$meetup_location;
    schedule_task_update( action_type:        'meetups_end'     ,
                          action_id:          $meetup_id        ,
                          action_planned_at:  $meetup_end_date  ,
                          action_description: $meetup_end_name  ,
                          sanitize_data:      true              );
  }

  // Fetch the username of the moderator creating the meetup
  $mod_username = user_get_username();

  // Activity log, only for future meetups getting their date changed
  if(!$meetup_deleted && $meetup_date !== $meetup_date_old && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    log_activity( 'meetups_edit'                        ,
                  language:             $meetup_lang    ,
                  activity_id:          $meetup_id      ,
                  activity_summary_en:  $meetup_date    ,
                  activity_summary_fr:  $meetup_date    );

  // Moderation log
  $modlog = log_activity( 'meetups_edit'                        ,
                          is_moderators_only:   true            ,
                          activity_id:          $meetup_id      ,
                          activity_summary_en:  $meetup_date    ,
                          activity_summary_fr:  $meetup_date    ,
                          moderator_username:   $mod_username   );

  // Detailed moderation logs
  if($meetup_date !== $meetup_date_old)
    log_activity_details($modlog, "Meetup date", "Date de l\'IRL", $meetup_date_old, $meetup_date, do_not_sanitize: true);
  if($meetup_location !== $meetup_location_old)
    log_activity_details($modlog, "Meetup location", "Lieu de l\'IRL", $meetup_location_old, $meetup_location, do_not_sanitize: true);
  if($meetup_lang !== $meetup_lang_old)
    log_activity_details($modlog, "Meetup languages", "Langues de l\'IRL", $meetup_lang_old, $meetup_lang, do_not_sanitize: true);
  if($meetup_details_en !== $meetup_details_en_old)
    log_activity_details($modlog, "Extra details (english)", "Détails supplémentaires (anglais)", $meetup_details_en_old, $meetup_details_en, do_not_sanitize: true);
  if($meetup_details_fr !== $meetup_details_fr_old)
    log_activity_details($modlog, "Extra details (french)", "Détails supplémentaires (français)", $meetup_details_fr_old, $meetup_details_fr, do_not_sanitize: true);

  // Plain text meetup dates and location
  $meetup_date_en = date_to_text($meetup_date, lang: 'EN');
  $meetup_date_fr = date_to_text($meetup_date, lang: 'FR');

  // IRC bot message
  if(!$meetup_deleted && $meetup_date !== $meetup_date_old && strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    if(str_contains($meetup_lang, 'EN'))
      irc_bot_send_message("The $meetup_date_en real life meetup has been moved to a new date - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'english');
    if(str_contains($meetup_lang, 'FR'))
      irc_bot_send_message("La date de la rencontre IRL du $meetup_date_fr a été modifiée - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'french');
  }
  irc_bot_send_message("The $meetup_date_en real life meetup has been modified by $mod_username - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id." - Detailed logs are available - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Discord message
  if(!$meetup_deleted && $meetup_date !== $meetup_date_old && strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    if(str_contains($meetup_lang, 'EN') && str_contains($meetup_lang, 'FR'))
    {
      $discord_message  = "The $meetup_date_en real life meetup has been moved to a new date";
      $discord_message .= PHP_EOL."La date de la rencontre IRL du $meetup_date_fr a été modifiée";
      $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
      discord_send_message($discord_message, 'main');
    }
    else if(str_contains($meetup_lang, 'EN'))
    {
      $discord_message  = "The english speakig $meetup_date_en real life meetup has been moved to a new date";
      $discord_message .= PHP_EOL."La date de la rencontre IRL anglophone du $meetup_date_fr a été modifiée";
      $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
      discord_send_message($discord_message, 'main');
    }
    else if(str_contains($meetup_lang, 'FR'))
    {
      $discord_message  = "The french speaking $meetup_date_en real life meetup has been moved to a new date";
      $discord_message .= PHP_EOL."La date de la rencontre IRL francophone du $meetup_date_fr a été modifiée";
      $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
      discord_send_message($discord_message, 'main');
    }
  }

  // Fetch all meetup attendees
  $meetup_users = meetups_attendees_list($meetup_id);

  // Recalculate stats for all users in the meetup
  for($i = 0; $i < $meetup_users['rows']; $i++)
  {
    if($meetup_users[$i]['user_id'])
      meetups_stats_recalculate_user($meetup_users[$i]['user_id']);
  }

  // All went well
  return NULL;
}




/**
 * Soft deletes a meetup
 *
 * @param   int     $meetup_id  The meetup's id.
 *
 * @return  void
 */

function meetups_delete( int $meetup_id ) : void
{
  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize the meetup's id
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Stop here if the meetup doesn't exist
  if(!database_row_exists('meetups', $meetup_id))
    return;

  // Get some data on the meetup
  $dmeetup = mysqli_fetch_array(query(" SELECT  meetups.is_deleted  AS 'm_deleted'  ,
                                                meetups.event_date  AS 'm_date'     ,
                                                meetups.languages   AS 'm_lang'
                                        FROM    meetups
                                        WHERE   meetups.id = '$meetup_id' "));

  // Prepare the meetup data
  $meetup_deleted = $dmeetup['m_deleted'];
  $meetup_date    = $dmeetup['m_date'];
  $meetup_date_en = date_to_text($meetup_date, lang: 'EN');
  $meetup_date_fr = date_to_text($meetup_date, lang: 'FR');
  $meetup_lang    = $dmeetup['m_lang'];

  // Stop here if it is already deleted
  if($meetup_deleted)
    return;

  // Fetch all meetup attendees
  $meetup_users = meetups_attendees_list($meetup_id);

  // Soft delete the meetup
  query(" UPDATE  meetups
          SET     meetups.is_deleted  = 1
          WHERE   meetups.id          = '$meetup_id' ");

  // Activity log, only for future meetups getting deleted
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
    log_activity( 'meetups_delete'                      ,
                  language:             $meetup_lang    ,
                  activity_id:          $meetup_id      ,
                  activity_summary_en:  $meetup_date    ,
                  activity_summary_fr:  $meetup_date    );

  // Fetch the username of the moderator adding the attendee
  $mod_username = user_get_username();

  // Moderation log
  log_activity( 'meetups_delete'                      ,
                is_moderators_only:   true            ,
                activity_id:          $meetup_id      ,
                activity_summary_en:  $meetup_date    ,
                activity_summary_fr:  $meetup_date    ,
                moderator_username:   $mod_username   );

  // IRC bot message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    if(str_contains($meetup_lang, 'EN'))
      irc_bot_send_message("The $meetup_date_en real life meetup has been cancelled - ".$GLOBALS['website_url']."pages/meetups/list", 'english');
    if(str_contains($meetup_lang, 'FR'))
      irc_bot_send_message("La rencontre IRL du $meetup_date_fr a été annulée - ".$GLOBALS['website_url']."pages/meetups/list", 'french');
  }
  irc_bot_send_message("The $meetup_date_en real life meetup has been deleted by $mod_username - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');

  // Discord message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    $discord_message  = "The $meetup_date_en real life meetup has been cancelled";
    $discord_message .= PHP_EOL."La rencontre IRL du $meetup_date_fr a été annulée";
    $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/list>";
    discord_send_message($discord_message, 'main');
  }

  // Recalculate stats for all users in the meetup
  for($i = 0; $i < $meetup_users['rows']; $i++)
  {
    if($meetup_users[$i]['user_id'])
      meetups_stats_recalculate_user($meetup_users[$i]['user_id']);
  }

  // End the function so that the js awaiting a callback doesn't get hung up
  return;
}




/**
 * Restores a soft deleted meetup.
 *
 * @param   int     $meetup_id  The meetup's id.
 *
 * @return  void
 */

function meetups_restore( int $meetup_id ) : void
{
  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize the meetup's id
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Stop here if the meetup doesn't exist
  if(!database_row_exists('meetups', $meetup_id))
    return;

  // Get some data on the meetup
  $dmeetup = mysqli_fetch_array(query(" SELECT  meetups.is_deleted  AS 'm_deleted'  ,
                                                meetups.event_date  AS 'm_date'     ,
                                                meetups.languages   AS 'm_lang'
                                        FROM    meetups
                                        WHERE   meetups.id = '$meetup_id' "));

  // Prepare the meetup data
  $meetup_deleted = $dmeetup['m_deleted'];
  $meetup_date    = $dmeetup['m_date'];
  $meetup_date_en = date_to_text($meetup_date, lang: 'EN');
  $meetup_date_fr = date_to_text($meetup_date, lang: 'FR');
  $meetup_lang    = $dmeetup['m_lang'];

  // Stop here if it is not deleted
  if(!$meetup_deleted)
    return;

  // Restore delete the meetup
  query(" UPDATE  meetups
          SET     meetups.is_deleted  = 0
          WHERE   meetups.id          = '$meetup_id' ");

  // Activity log, only for future meetups getting restored
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
    log_activity( 'meetups_restore'                     ,
                  language:             $meetup_lang    ,
                  activity_id:          $meetup_id      ,
                  activity_summary_en:  $meetup_date    ,
                  activity_summary_fr:  $meetup_date    );

  // Fetch the username of the moderator adding the attendee
  $mod_username = user_get_username();

  // Moderation log
  log_activity( 'meetups_restore'                     ,
                is_moderators_only:   true            ,
                activity_id:          $meetup_id      ,
                activity_summary_en:  $meetup_date    ,
                activity_summary_fr:  $meetup_date    ,
                moderator_username:   $mod_username   );

  // IRC bot message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    if(str_contains($meetup_lang, 'EN'))
      irc_bot_send_message("The $meetup_date_en real life meetup is back on the menu! - ".$GLOBALS['website_url']."pages/meetups/list", 'english');
    if(str_contains($meetup_lang, 'FR'))
      irc_bot_send_message("La rencontre IRL du $meetup_date_fr est de retour ! - ".$GLOBALS['website_url']."pages/meetups/list", 'french');
  }
  irc_bot_send_message("The $meetup_date_en real life meetup has been restored by $mod_username - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');

  // Discord message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    $discord_message  = "The $meetup_date_en real life meetup is back on the menu!";
    $discord_message .= PHP_EOL."La rencontre IRL du $meetup_date_fr est de retour !";
    $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
    discord_send_message($discord_message, 'main');
  }

  // Fetch all meetup attendees
  $meetup_users = meetups_attendees_list($meetup_id);

  // Recalculate stats for all users in the meetup
  for($i = 0; $i < $meetup_users['rows']; $i++)
  {
    if($meetup_users[$i]['user_id'])
      meetups_stats_recalculate_user($meetup_users[$i]['user_id']);
  }

  // End the function so that the js awaiting a callback doesn't get hung up
  return;
}




/**
 * Permanently deletes a meetup
 *
 * @param   int     $meetup_id  The meetup's id.
 *
 * @return  void
 */

function meetups_hard_delete( int $meetup_id ) : void
{
  // Only administrators can run this action
  user_restrict_to_administrators();

  // Sanitize the meetup's id
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Stop here if the meetup doesn't exist
  if(!database_row_exists('meetups', $meetup_id))
    return;

  // Get the meetup's date
  $dmeetup = mysqli_fetch_array(query(" SELECT  meetups.event_date  AS 'm_date'
                                        FROM    meetups
                                        WHERE   meetups.id = '$meetup_id' "));

  // Fetch all meetup attendees
  $meetup_users = meetups_attendees_list($meetup_id);

  // Hard delete the meetup
  query(" DELETE FROM meetups
          WHERE       meetups.id = '$meetup_id' ");

  // Delete all related activity logs
  log_activity_delete(  'meetups_'                      ,
                        is_moderators_only: false       ,
                        activity_id:        $meetup_id  ,
                        global_type_wipe:   true        );
  log_activity_delete(  'meetups_'                      ,
                        is_moderators_only: true        ,
                        activity_id:        $meetup_id  ,
                        global_type_wipe:   true        );

  // Delete all related scheduled tasks
  schedule_task_delete( action_type:  'meetups_end' ,
                        action_id:    $meetup_id    );

  // Recalculate stats for all users in the meetup
  for($i = 0; $i < $meetup_users['rows']; $i++)
  {
    if($meetup_users[$i]['user_id'])
      meetups_stats_recalculate_user($meetup_users[$i]['user_id']);
  }

  // End the function so that the js awaiting a callback doesn't get hung up
  return;
}




/**
 * Fetches data related to a meetup attendee.
 *
 * @param   int           $attendee_id  The attendee's id, from the meetups_people table.
 *
 * @return  array|string                An array containing related data, or a string if something went wrong.
 */

function meetups_attendees_get( int $attendee_id ) : mixed
{
  // Sanitize the data
  $attendee_id = sanitize($attendee_id, 'int', 0);

  // Check if the attendee exists
  if(!database_row_exists('meetups_people', $attendee_id))
    return __('meetups_attendees_edit_error_id');

  // Fetch the data
  $dattendee = mysqli_fetch_array(query(" SELECT    meetups.id                          AS 'm_id'         ,
                                                    meetups.is_deleted                  AS 'm_deleted'    ,
                                                    meetups.event_date                  AS 'm_date'       ,
                                                    users.username                      AS 'u_account'    ,
                                                    meetups_people.username             AS 'p_nickname'   ,
                                                    meetups_people.attendance_confirmed AS 'p_lock'       ,
                                                    meetups_people.extra_information_en AS 'p_extra_en'   ,
                                                    meetups_people.extra_information_fr AS 'p_extra_fr'
                                          FROM      meetups_people
                                          LEFT JOIN users   ON meetups_people.fk_users    = users.id
                                          LEFT JOIN meetups ON meetups_people.fk_meetups  = meetups.id
                                          WHERE     meetups_people.id = '$attendee_id' "));

  // Can not edit attendees of non existing meetups
  if(!$dattendee['m_id'])
    return __('meetups_attendees_edit_error_meetup');

  // Only moderators can see deleted meetups
  if($dattendee['m_deleted'] && !user_is_moderator())
    return __('meetups_attendees_edit_error_meetup');

  // Assemble an array with the data
  $data['meetup_id']    = sanitize_output($dattendee['m_id']);
  $data['is_finished']  = (strtotime(date('Y-m-d')) > strtotime($dattendee['m_date']));
  $data['account']      = sanitize_output($dattendee['u_account']);
  $data['nickname']     = sanitize_output($dattendee['p_nickname']);
  $data['extra_en']     = sanitize_output($dattendee['p_extra_en']);
  $data['extra_fr']     = sanitize_output($dattendee['p_extra_fr']);
  $data['lock']         = sanitize_output($dattendee['p_lock']);

  // Return the data
  return $data;
}




/**
 * Returns a list of people attending a meetup.
 *
 * @param   string  $meetup_id  (OPTIONAL)  The meetup's id.
 *
 * @return  array                           An array containing meetup attendees, or NULL if it doesn't exist.
 */

function meetups_attendees_list( int $meetup_id = 0 ) : array
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
  $qattendees = query(" SELECT    meetups_people.id                       AS 'p_id'       ,
                                  meetups.is_deleted                      AS 'm_deleted'  ,
                                  users.id                                AS 'u_id'       ,
                                  users.username                          AS 'u_nick'     ,
                                  meetups_people.username                 AS 'm_nick'     ,
                                  meetups_people.attendance_confirmed     AS 'm_lock'     ,
                                  meetups_people.extra_information_$lang  AS 'm_extra'    ,
                                  meetups_people.extra_information_en     AS 'm_extra_en' ,
                                  meetups_people.extra_information_fr     AS 'm_extra_fr'
                        FROM      meetups_people
                        LEFT JOIN users   ON meetups_people.fk_users    = users.id
                        LEFT JOIN meetups ON meetups_people.fk_meetups  = meetups.id
                        WHERE     meetups_people.fk_meetups             = '$meetup_id'
                        ORDER BY  IF(meetups_people.username != '', meetups_people.username, users.username) ASC ");

  // Loop through the data
  for($i = 0; $row = mysqli_fetch_array($qattendees); $i++)
  {
    // Only moderators can see deleted meetups
    if(!$i && $row['m_deleted'] && !user_is_moderator())
      return NULL;

    // Prepare the data
    $data[$i]['attendee_id']  = sanitize_output($row['p_id']);
    $data[$i]['user_id']      = sanitize_output($row['u_id']);
    $data[$i]['nick']         = ($row['m_nick']) ? sanitize_output($row['m_nick']) : sanitize_output($row['u_nick']);
    $data[$i]['nick_raw']     = ($row['m_nick']) ?: $row['u_nick'];
    $data[$i]['lock']         = $row['m_lock'];
    $data[$i]['extra']        = bbcodes(sanitize_output($row['m_extra']));
    $data[$i]['extra_en']     = $row['m_extra_en'];
    $data[$i]['extra_fr']     = $row['m_extra_fr'];
  }

  // Add the number of rows to the data
  $data['rows'] = $i;

  // Return the prepared data
  return $data;
}




/**
 * Adds an attendee to a meetup.
 *
 * @param   int     $meetup_id  The ID of the meetup to which the attendee will be added.
 * @param   array   $contents   Data regarding the attendee.
 *
 * @return  void
 */

function meetups_attendees_add( int   $meetup_id  ,
                                array $contents   ) : void
{
  // Check if the required files have been included
  require_included_file('users.inc.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize and prepare the data
  $meetup_id  = sanitize($meetup_id, 'int', 0);
  $account    = sanitize_array_element($contents, 'account', 'string');
  $nickname   = sanitize_array_element($contents, 'nickname', 'string', max: 20);
  $extra_en   = sanitize_array_element($contents, 'extra_en', 'string');
  $extra_fr   = sanitize_array_element($contents, 'extra_fr', 'string');
  $lock       = (isset($contents['lock'])) ? sanitize($contents['lock'], 'bool') : 'false';
  $lock       = ($lock === 'true') ? 1 : 0;
  $username   = ($nickname) ? string_truncate($contents['nickname'], 20) : $contents['account'];

  // Error: No account or nickname provided
  if(!$account && !$nickname)
    return;

  // Error: Meetup does not exist
  if(!database_row_exists('meetups', $meetup_id))
    return;

  // Remove the account's name if it does not exist
  if(!users_check_username($account))
    $account = '';

  // Fetch the account's id
  if($account)
    $account_id = sanitize(database_entry_exists('users', 'username', $account), 'int');
  else
    $account_id = 0;

  // Error: Account is already attending the meetup
  if($account_id)
  {
    $dattendee = mysqli_fetch_array(query(" SELECT  meetups_people.id AS 'p_id'
                                            FROM    meetups_people
                                            WHERE   meetups_people.fk_meetups = '$meetup_id'
                                            AND     meetups_people.fk_users   = '$account_id' "));
    if(isset($dattendee['p_id']))
      return;
  }

  // Error: Nickname is already attending the meetup
  if($nickname)
  {
    $dattendee = mysqli_fetch_array(query(" SELECT    meetups_people.id AS 'p_id'
                                            FROM      meetups_people
                                            LEFT JOIN users ON meetups_people.fk_users = users.id
                                            WHERE     meetups_people.fk_meetups =     '$meetup_id'
                                            AND     ( meetups_people.username   LIKE  '$nickname'
                                            OR        users.username            LIKE  '$nickname' ) "));
    if(isset($dattendee['p_id']))
      return;
  }

  // Add the attendee
  query(" INSERT INTO meetups_people
          SET         meetups_people.fk_meetups           = '$meetup_id'  ,
                      meetups_people.fk_users             = '$account_id' ,
                      meetups_people.username             = '$nickname'   ,
                      meetups_people.attendance_confirmed = '$lock'       ,
                      meetups_people.extra_information_en = '$extra_en'   ,
                      meetups_people.extra_information_fr = '$extra_fr'   ");

  // Recount the meetup's attendee count
  meetup_attendees_update_count($meetup_id);

  // Fetch data on the meetup
  $dmeetup = mysqli_fetch_array(query(" SELECT  meetups.is_deleted  AS 'm_deleted'  ,
                                                meetups.event_date  AS 'm_date'     ,
                                                meetups.languages   AS 'm_lang'
                                        FROM    meetups
                                        WHERE   meetups.id = '$meetup_id' "));

  // Prepare the meetup data
  $meetup_deleted   = $dmeetup['m_deleted'];
  $meetup_date      = sanitize($dmeetup['m_date'], 'string');
  $meetup_date_en   = date_to_text($dmeetup['m_date'], lang: 'EN');
  $meetup_date_fr   = date_to_text($dmeetup['m_date'], lang: 'FR');
  $meetup_lang      = sanitize($dmeetup['m_lang'], 'string');

  // Fetch the username of the moderator adding the attendee
  $mod_username = user_get_username();

  // Activity log, for future meetups only
  if(!$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    log_activity( 'meetups_people_new'                ,
                  language:             $meetup_lang  ,
                  activity_id:          $meetup_id    ,
                  activity_summary_en:  $meetup_date  ,
                  activity_summary_fr:  $meetup_date  ,
                  username:             $username     );

  // Moderation log
  log_activity( 'meetups_people_new'                ,
                is_moderators_only:   true          ,
                activity_id:          $meetup_id    ,
                activity_summary_en:  $meetup_date  ,
                activity_summary_fr:  $meetup_date  ,
                username:             $username     ,
                moderator_username:   $mod_username );

  // IRC bot message
  if(str_contains($meetup_lang, 'EN') && !$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    irc_bot_send_message("$username has joined the $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'english');
  if(str_contains($meetup_lang, 'FR') && !$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    irc_bot_send_message("$username a rejoint la rencontre IRL du $meetup_date_fr - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'french');
  if(strtotime($meetup_date) === strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has added $username to the currently ongoing $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');
  if(strtotime($meetup_date) < strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has added $username to the already finished $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');

  // Discord message
  if(!$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    $discord_message = "$username has joined the $meetup_date_en real life meetup";
    $discord_message .= PHP_EOL."$username a rejoint la rencontre IRL du $meetup_date_fr";
    $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
    discord_send_message($discord_message, 'main');
  }

  // Recalculate the user's meetup stats if they have an account
  if($account_id)
    meetups_stats_recalculate_user($account_id);
}




/**
 * Modifies data related to a meetup attendee.
 *
 * @param   int     $attendee_id  The ID of the attendee (from the meetups_people table).
 * @param   array   $contents     Data regarding the attendee.
 *
 * @return  void
 */

function meetups_attendees_edit(  int   $attendee_id  ,
                                  array $contents     ) : void
{
  // Check if the required files have been included
  require_included_file('users.inc.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize and prepare the data
  $attendee_id  = sanitize($attendee_id, 'int', 0);
  $account    = sanitize_array_element($contents, 'account', 'string');
  $nickname   = sanitize_array_element($contents, 'nickname', 'string', max: 20);
  $extra_en   = sanitize_array_element($contents, 'extra_en', 'string');
  $extra_fr   = sanitize_array_element($contents, 'extra_fr', 'string');
  $lock       = (isset($contents['lock'])) ? sanitize($contents['lock'], 'bool') : 'false';
  $lock       = ($lock === 'true') ? 1 : 0;
  $username   = ($nickname) ? string_truncate($contents['nickname'], 20) : $contents['account'];

  // Error: No account or nickname provided
  if(!$account && !$nickname)
    return;

  // Error: Attendee does not exist
  if(!database_row_exists('meetups_people', $attendee_id))
    return;

  // Fetch data on the attendee and the meetup they are attending
  $dattendee = mysqli_fetch_array(query(" SELECT    meetups.id                          AS 'm_id'         ,
                                                    meetups.event_date                  AS 'm_date'       ,
                                                    users.id                            AS 'u_id'         ,
                                                    users.username                      AS 'u_account'    ,
                                                    meetups_people.username             AS 'p_nickname'   ,
                                                    meetups_people.attendance_confirmed AS 'p_lock'       ,
                                                    meetups_people.extra_information_en AS 'p_extra_en'   ,
                                                    meetups_people.extra_information_fr AS 'p_extra_fr'
                                          FROM      meetups_people
                                          LEFT JOIN users   ON meetups_people.fk_users    = users.id
                                          LEFT JOIN meetups ON meetups_people.fk_meetups  = meetups.id
                                          WHERE     meetups_people.id = '$attendee_id' "));

  // Sanitize and prepare older data
  $meetup_id      = sanitize($dattendee['m_id'], 'int', 0);
  $meetup_date    = $dattendee['m_date'];
  $meetup_date_en = date_to_text($dattendee['m_date'], lang: 'EN');
  $old_user_id    = sanitize($dattendee['u_id'], 'int', 0);
  $old_account    = sanitize($dattendee['u_account'], 'string');
  $old_nickname   = sanitize($dattendee['p_nickname'], 'string');
  $old_extra_en   = sanitize($dattendee['p_extra_en'], 'string');
  $old_extra_fr   = sanitize($dattendee['p_extra_fr'], 'string');
  $old_lock       = $dattendee['p_lock'];

  // Error: Meetup does not exist
  if(!$meetup_id)
    return;

  // Remove the account's name if it does not exist
  if(!users_check_username($account))
    $account = '';

  // Fetch the account's id
  if($account)
    $account_id = sanitize(database_entry_exists('users', 'username', $account), 'int');
  else
    $account_id = 0;

  // Error: Account is already attending the meetup
  if($account_id)
  {
    $dattendee = mysqli_fetch_array(query(" SELECT  meetups_people.id AS 'p_id'
                                            FROM    meetups_people
                                            WHERE   meetups_people.id        != '$attendee_id'
                                            AND     meetups_people.fk_meetups = '$meetup_id'
                                            AND     meetups_people.fk_users   = '$account_id' "));
    if(isset($dattendee['p_id']))
      return;
  }

  // Error: Nickname is already attending the meetup
  if($nickname)
  {
    $dattendee = mysqli_fetch_array(query(" SELECT    meetups_people.id AS 'p_id'
                                            FROM      meetups_people
                                            LEFT JOIN users ON meetups_people.fk_users = users.id
                                            WHERE     meetups_people.id         !=    '$attendee_id'
                                            AND       meetups_people.fk_meetups =     '$meetup_id'
                                            AND     ( meetups_people.username   LIKE  '$nickname'
                                            OR        users.username            LIKE  '$nickname' ) "));
    if(isset($dattendee['p_id']))
      return;
  }

  // Edit the attendee
  query(" UPDATE  meetups_people
          SET     meetups_people.fk_users             = '$account_id' ,
                  meetups_people.username             = '$nickname'   ,
                  meetups_people.attendance_confirmed = '$lock'       ,
                  meetups_people.extra_information_en = '$extra_en'   ,
                  meetups_people.extra_information_fr = '$extra_fr'
          WHERE   meetups_people.id                   = '$attendee_id' ");

  // Fetch the username of the moderator editing the attendee
  $mod_username = user_get_username();

  // Moderation log
  $modlog = log_activity( 'meetups_people_edit'               ,
                          is_moderators_only:   true          ,
                          activity_id:          $meetup_id    ,
                          activity_summary_en:  $meetup_date  ,
                          activity_summary_fr:  $meetup_date  ,
                          username:             $username     ,
                          moderator_username:   $mod_username );

  // Detailed moderation log
  if($account !== $old_account)
    log_activity_details($modlog, 'Account name', 'Nom du compte', $old_account, $account, do_not_sanitize: true);
  if($nickname !== $old_nickname)
    log_activity_details($modlog, 'Nickname or name', 'Pseudonyme ou nom', $old_nickname, $nickname, do_not_sanitize: true);
  if($extra_en !== $old_extra_en)
    log_activity_details($modlog, 'Extra details (EN)', 'Détails supplémentaires (EN)', $old_extra_en, $extra_en, do_not_sanitize: true);
  if($extra_fr !== $old_extra_fr)
    log_activity_details($modlog, 'Extra details (FR)', 'Détails supplémentaires (FR)', $old_extra_fr, $extra_fr, do_not_sanitize: true);
  if($lock !== $old_lock)
    log_activity_details($modlog, 'Confirmed attendance', 'Présence confirmée', $old_lock, $lock, do_not_sanitize: true);

  // IRC bot message
  if(strtotime($meetup_date) > strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has edited $username's details in the upcoming $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id." - Detailed logs are available - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');
  if(strtotime($meetup_date) === strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has edited $username's details in the currently ongoing $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id." - Detailed logs are available - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');
  if(strtotime($meetup_date) < strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has edited $username's details in the already finished $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id." - Detailed logs are available - ".$GLOBALS['website_url']."pages/nobleme/activity?mod", 'mod');

  // Recalculate the user's meetup stats if they have an account
  if($old_user_id)
    meetups_stats_recalculate_user($old_user_id);
  if($account_id)
    meetups_stats_recalculate_user($account_id);
}




/**
 * Removes an attendee from a meetup.
 *
 * @param   int         $attendee_id  The ID of the attendee (from the meetups_people table).
 *
 * @return  string|null               A string contaiing an error message, or null if all went well.
 */

function meetups_attendees_delete( int $attendee_id ) : mixed
{
  // Check if the required files have been included
  require_included_file('users.inc.php');

  // Only moderators can run this action
  user_restrict_to_moderators();

  // Sanitize the attendee id
  $attendee_id  = sanitize($attendee_id, 'int', 0);

  // Error: Attendee does not exist
  if(!database_row_exists('meetups_people', $attendee_id))
    return __('meetups_attendees_edit_error_id');

  // Fetch data on the attendee and the meetup they are attending
  $dattendee = mysqli_fetch_array(query(" SELECT    meetups.id                          AS 'm_id'         ,
                                                    meetups.is_deleted                  AS 'm_deleted'    ,
                                                    meetups.event_date                  AS 'm_date'       ,
                                                    meetups.languages                   AS 'm_lang'       ,
                                                    users.id                            AS 'u_id'         ,
                                                    users.username                      AS 'u_account'    ,
                                                    meetups_people.username             AS 'p_nickname'   ,
                                                    meetups_people.attendance_confirmed AS 'p_lock'       ,
                                                    meetups_people.extra_information_en AS 'p_extra_en'   ,
                                                    meetups_people.extra_information_fr AS 'p_extra_fr'
                                          FROM      meetups_people
                                          LEFT JOIN users   ON meetups_people.fk_users    = users.id
                                          LEFT JOIN meetups ON meetups_people.fk_meetups  = meetups.id
                                          WHERE     meetups_people.id = '$attendee_id' "));

  // Sanitize and prepare the data
  $meetup_id      = sanitize($dattendee['m_id'], 'int', 0);
  $meetup_deleted = $dattendee['m_deleted'];
  $meetup_date    = $dattendee['m_date'];
  $meetup_date_en = date_to_text($dattendee['m_date'], lang: 'EN');
  $meetup_date_fr = date_to_text($dattendee['m_date'], lang: 'FR');
  $meetup_lang    = $dattendee['m_lang'];
  $account        = sanitize($dattendee['u_account'], 'string');
  $account_id     = sanitize($dattendee['u_id'], 'int', 0);
  $nickname       = sanitize($dattendee['p_nickname'], 'string');
  $username       = ($nickname) ? $nickname : $account;
  $username_raw   = ($dattendee['p_nickname']) ? $dattendee['p_nickname'] : $dattendee['u_account'];
  $extra_en       = sanitize($dattendee['p_extra_en'], 'string');
  $extra_fr       = sanitize($dattendee['p_extra_fr'], 'string');
  $lock           = $dattendee['p_lock'];

  // Error: Meetup does not exist or has been deleted
  if(!$meetup_id)
    return __('meetups_attendees_edit_error_meetup');

  // Remove the attendee
  query(" DELETE FROM meetups_people
          WHERE       meetups_people.id = '$attendee_id' ");

  // Recount the meetup's attendees
  meetup_attendees_update_count($meetup_id);

  // Fetch the username of the moderator deleting the attendee
  $mod_username = user_get_username();

  // Activity log, for future meetups only
  if(!$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    log_activity( 'meetups_people_delete'             ,
                  language:             $meetup_lang  ,
                  activity_id:          $meetup_id    ,
                  activity_summary_en:  $meetup_date  ,
                  activity_summary_fr:  $meetup_date  ,
                  username:             $username_raw );

  // Moderation log
  $modlog = log_activity( 'meetups_people_delete'             ,
                          is_moderators_only:   true          ,
                          activity_id:          $meetup_id    ,
                          activity_summary_en:  $meetup_date  ,
                          activity_summary_fr:  $meetup_date  ,
                          username:             $username_raw ,
                          moderator_username:   $mod_username );

  // Detailed moderation log
  if($account)
    log_activity_details($modlog, 'Account name', 'Nom du compte', $account, do_not_sanitize: true);
  if($nickname)
    log_activity_details($modlog, 'Nickname or name', 'Pseudonyme ou nom', $nickname, do_not_sanitize: true);
  if($extra_en)
    log_activity_details($modlog, 'Extra details (EN)', 'Détails supplémentaires (EN)', $extra_en, do_not_sanitize: true);
  if($extra_fr)
    log_activity_details($modlog, 'Extra details (FR)', 'Détails supplémentaires (FR)', $extra_fr, do_not_sanitize: true);
  if($lock)
    log_activity_details($modlog, 'Confirmed attendance', 'Présence confirmée', $lock, do_not_sanitize: true);

  // IRC bot message
  if(str_contains($meetup_lang, 'EN') && !$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    irc_bot_send_message("$username_raw has left the $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'english');
  if(str_contains($meetup_lang, 'FR') && !$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
    irc_bot_send_message("$username_raw a quitté la rencontre IRL du $meetup_date_fr - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'french');
  if(strtotime($meetup_date) === strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has removed $username_raw from the currently ongoing $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');
  if(strtotime($meetup_date) < strtotime(date('Y-m-d')))
    irc_bot_send_message("$mod_username has removed $username_raw from the already finished $meetup_date_en real life meetup - ".$GLOBALS['website_url']."pages/meetups/".$meetup_id, 'mod');

  // Discord message
  if(!$meetup_deleted && strtotime($meetup_date) > strtotime(date('Y-m-d')))
  {
    $discord_message = "$username_raw has left the $meetup_date_en real life meetup";
    $discord_message .= PHP_EOL."$username_raw a quitté la rencontre IRL du $meetup_date_fr";
    $discord_message .= PHP_EOL."<".$GLOBALS['website_url']."pages/meetups/".$meetup_id.">";
    discord_send_message($discord_message, 'main');
  }

  // Recalculate the user's meetup stats if they have an account
  if($account_id)
    meetups_stats_recalculate_user($account_id);

  // All went well
  return NULL;
}




/**
 * Recounts the number of people attending a meetup.
 *
 * @param   int   $meetup_id  The meetup's ID
 *
 * @return  void
 */

function meetup_attendees_update_count( int $meetup_id ) : void
{
  // Sanitize the id
  $meetup_id = sanitize($meetup_id, 'int', 0);

  // Fetch the meetup's attendee count
  $dattendees = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'p_count'
                                            FROM    meetups_people
                                            WHERE   meetups_people.fk_meetups = '$meetup_id' "));

  // Sanitize the count
  $attendees = sanitize($dattendees['p_count'], 'int', 0);

  // Update the count
  query(" UPDATE  meetups
          SET     meetups.attendee_count  = '$attendees'
          WHERE   meetups.id              = '$meetup_id' ");
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




/**
 * Returns stats related to meetups.
 *
 * @return  array   An array of stats related to meetups.
 */

function meetups_stats_list() : array
{
  // Initialize the return array
  $data = array();

  // Fetch the total number of finished meetups
  $dmeetups = mysqli_fetch_array(query("  SELECT  COUNT(*)                AS 'm_total'    ,
                                                  SUM(CASE  WHEN meetups.languages LIKE 'EN' THEN 1
                                                            ELSE 0 END)   AS 'm_total_en' ,
                                                  SUM(CASE  WHEN meetups.languages LIKE 'FR' THEN 1
                                                            ELSE 0 END)   AS 'm_total_fr' ,
                                                  SUM(CASE  WHEN meetups.languages LIKE 'ENFR' THEN 1
                                                            WHEN meetups.languages LIKE 'FREN' THEN 1
                                                            ELSE 0 END)   AS 'm_total_bi'
                                          FROM    meetups
                                          WHERE   meetups.is_deleted  = 0
                                          AND     meetups.event_date  < CURDATE()  "));

  // Add some stats to the return array
  $data['total']    = sanitize_output($dmeetups['m_total']);
  $data['total_en'] = sanitize_output($dmeetups['m_total_en']);
  $data['total_fr'] = sanitize_output($dmeetups['m_total_fr']);
  $data['total_bi'] = sanitize_output($dmeetups['m_total_bi']);

  // Fetch the number of future meetups
  $dmeetups = mysqli_fetch_array(query("  SELECT  COUNT(*) AS 'm_total'
                                          FROM    meetups
                                          WHERE   meetups.is_deleted = 0
                                          AND     meetups.event_date >= CURDATE() "));

  // Add future meetups to the return array
  $data['future'] = sanitize_output($dmeetups['m_total']);

  // Fetch the meetup with most attendees
  $dmeetups = mysqli_fetch_array(query("  SELECT    meetups.id              AS 'm_id'     ,
                                                    meetups.attendee_count  AS 'm_count'  ,
                                                    meetups.event_date      AS 'm_date'
                                          FROM      meetups
                                          WHERE     meetups.is_deleted = 0
                                          ORDER BY  meetups.attendee_count  DESC ,
                                                    meetups.event_date      DESC
                                          LIMIT     1 "));

  // Add the biggest meetup to the return array
  $data['biggest_id']     = sanitize_output($dmeetups['m_id']);
  $data['biggest_count']  = sanitize_output($dmeetups['m_count']);
  $data['biggest_date']   = sanitize_output(date_to_text($dmeetups['m_date'], strip_day: true));

  // Fetch user stats
  $qmeetups = query("   SELECT    users.id                        AS 'u_id'                 ,
                                  users.username                  AS 'u_nick'               ,
                                  users_stats.meetups             AS 'us_meetups'           ,
                                  users_stats.meetups_en          AS 'us_meetups_en'        ,
                                  users_stats.meetups_fr          AS 'us_meetups_fr'        ,
                                  users_stats.meetups_bilingual   AS 'us_meetups_bi'        ,
                                  users_stats.meetups_oldest_id   AS 'us_meetups_old_id'    ,
                                  users_stats.meetups_oldest_date AS 'us_meetups_old_date'  ,
                                  users_stats.meetups_newest_id   AS 'us_meetups_new_id'    ,
                                  users_stats.meetups_newest_date AS 'us_meetups_new_date'
                        FROM      users_stats
                        LEFT JOIN users ON users_stats.fk_users = users.id
                        WHERE     users_stats.meetups > 0
                        ORDER BY  users_stats.meetups DESC  ,
                                  users.username      ASC   ");

  // Loop through user stats and add its data to the return array
  for($i = 0; $row = mysqli_fetch_array($qmeetups); $i++)
  {
    $data['users_id_'.$i]         = sanitize_output($row['u_id']);
    $data['users_nick_'.$i]       = sanitize_output($row['u_nick']);
    $data['users_meetups_'.$i]    = sanitize_output($row['us_meetups']);
    $data['users_meetups_bi_'.$i] = $row['us_meetups_bi'] ? (sanitize_output($row['us_meetups_bi'])) : '';
    $data['users_meetups_en_'.$i] = $row['us_meetups_en'] ? (sanitize_output($row['us_meetups_en'])) : '';
    $data['users_meetups_fr_'.$i] = $row['us_meetups_fr'] ? (sanitize_output($row['us_meetups_fr'])) : '';
    $data['users_mold_id_'.$i]    = sanitize_output($row['us_meetups_old_id']);
    $data['users_mold_date_'.$i]  = sanitize_output($row['us_meetups_old_date']);
    $data['users_mnew_id_'.$i]    = sanitize_output($row['us_meetups_new_id']);
    $data['users_mnew_date_'.$i]  = sanitize_output($row['us_meetups_new_date']);
  }

  // Add the amount of user stats to the return array
  $data['users_count'] = $i;

  // Fetch meetups by location
  $qmeetups = query("  SELECT   meetups.location    AS 'm_location' ,
                                COUNT(*)            AS 'm_count'
                      FROM      meetups
                      WHERE     meetups.is_deleted  = 0
                      GROUP BY  meetups.location
                      ORDER BY  COUNT(*)          DESC  ,
                                meetups.location  ASC   ");

  // Loop through location stats and add their data to the return array
  for($i = 0; $row = mysqli_fetch_array($qmeetups); $i++)
  {
    $data['locations_name_'.$i]   = sanitize_output($row['m_location']);
    $data['locatouns_count_'.$i]  = sanitize_output($row['m_count']);
  }

  // Add the amount of location stats to the return array
  $data['locations_count'] = $i;

  // Fetch meetups by years
  $qmeetups = query("  SELECT   meetups.event_date        AS 'm_date'     ,
                                YEAR(meetups.event_date)  AS 'm_year'     ,
                                COUNT(*)                  AS 'm_count'    ,
                                SUM(CASE  WHEN meetups.languages LIKE 'EN' THEN 1
                                          ELSE 0 END)     AS 'm_count_en' ,
                                SUM(CASE  WHEN meetups.languages LIKE 'FR' THEN 1
                                          ELSE 0 END)     AS 'm_count_fr' ,
                                SUM(CASE  WHEN meetups.languages LIKE 'ENFR' THEN 1
                                          WHEN meetups.languages LIKE 'FREN' THEN 1
                                          ELSE 0 END)     AS 'm_count_bi'
                      FROM      meetups
                      WHERE     meetups.is_deleted  = 0
                      GROUP BY  m_year
                      ORDER BY  m_year ASC ");

  // Prepare to identify the oldest meetup year
  $oldest_year = date('Y');

  // Add meetups data over time to the return data
  while($dmeetups = mysqli_fetch_array($qmeetups))
  {
    $year                           = $dmeetups['m_year'];
    $oldest_year                    = ($year < $oldest_year) ? $year : $oldest_year;
    $data['years_count_'.$year]     = ($dmeetups['m_count']) ? sanitize_output($dmeetups['m_count']) : '';
    $data['years_count_bi_'.$year]  = ($dmeetups['m_count_bi']) ? sanitize_output($dmeetups['m_count_bi']) : '';
    $data['years_count_en_'.$year]  = ($dmeetups['m_count_en']) ? sanitize_output($dmeetups['m_count_en']) : '';
    $data['years_count_fr_'.$year]  = ($dmeetups['m_count_fr']) ? sanitize_output($dmeetups['m_count_fr']) : '';
  }

  // Add the oldest year to the return data
  $data['oldest_year'] = $oldest_year;

  // Ensure every year has an entry until the current one
  for($i = $oldest_year; $i <= date('Y'); $i++)
  {
    $data['years_count_'.$i]    ??= '';
    $data['years_count_bi_'.$i] ??= '';
    $data['years_count_en_'.$i] ??= '';
    $data['years_count_fr_'.$i] ??= '';
  }

  // Return the stats
  return $data;
}




/**
 * Recalculates meetups statistics for a specific user.
 *
 * @param   int   $user_id  The user's id.
 *
 * @return  void
 */

function meetups_stats_recalculate_user( int $user_id )
{
  // Sanitize the user's id
  $user_id = sanitize($user_id, 'int', 0);

  // Check if the user exists
  if(!$user_id || !database_row_exists('users', $user_id))
    return;

  // Count the meetups in which the user was present
  $dmeetups = mysqli_fetch_array(query("  SELECT    COUNT(*)              AS 'm_count'    ,
                                                    SUM(CASE  WHEN meetups.languages LIKE 'EN' THEN 1
                                                              ELSE 0 END) AS 'm_count_en' ,
                                                    SUM(CASE  WHEN meetups.languages LIKE 'FR' THEN 1
                                                              ELSE 0 END) AS 'm_count_fr' ,
                                                    SUM(CASE  WHEN  meetups.languages LIKE 'ENFR' THEN 1
                                                              WHEN  meetups.languages LIKE 'FREN' THEN 1
                                                              ELSE 0 END) AS 'm_count_bi'
                                          FROM      meetups_people
                                          LEFT JOIN meetups
                                          ON        meetups_people.fk_meetups           = meetups.id
                                          WHERE     meetups_people.fk_users             = '$user_id'
                                          AND       meetups_people.attendance_confirmed = 1
                                          AND       meetups.is_deleted                  = 0
                                          AND       meetups.event_date                  < CURDATE() "));

  // Sanitize the user involvement stats
  $meetups_count            = sanitize($dmeetups['m_count'], 'int', 0);
  $meetups_count_en         = sanitize($dmeetups['m_count_en'], 'int', 0);
  $meetups_count_fr         = sanitize($dmeetups['m_count_fr'], 'int', 0);
  $meetups_count_bilingual  = sanitize($dmeetups['m_count_bi'], 'int', 0);

  // Find the user's oldest meetup
  $dmeetups = mysqli_fetch_array(query("  SELECT    meetups.id          AS 'm_id' ,
                                                    meetups.event_date  AS 'm_date'
                                          FROM      meetups_people
                                          LEFT JOIN meetups
                                          ON        meetups_people.fk_meetups           = meetups.id
                                          WHERE     meetups_people.fk_users             = '$user_id'
                                          AND       meetups_people.attendance_confirmed = 1
                                          AND       meetups.is_deleted                  = 0
                                          AND       meetups.event_date                  < CURDATE()
                                          ORDER BY  meetups.event_date  ASC ,
                                                    meetups.id          ASC
                                          LIMIT     1 "));

  // Sanitize the oldest meetup stats
  $oldest_id    = isset($dmeetups['m_id']) ? sanitize($dmeetups['m_id'], 'int', 0)    : 0;
  $oldest_date  = isset($dmeetups['m_id']) ? sanitize($dmeetups['m_date'], 'int', 0)  : 0;

  // Find the user's newest meetup
  $dmeetups = mysqli_fetch_array(query("  SELECT    meetups.id          AS 'm_id' ,
                                                    meetups.event_date  AS 'm_date'
                                          FROM      meetups_people
                                          LEFT JOIN meetups
                                          ON        meetups_people.fk_meetups           = meetups.id
                                          WHERE     meetups_people.fk_users             = '$user_id'
                                          AND       meetups_people.attendance_confirmed = 1
                                          AND       meetups.is_deleted                  = 0
                                          AND       meetups.event_date                  < CURDATE()
                                          ORDER BY  meetups.event_date  DESC ,
                                                    meetups.id          DESC
                                          LIMIT     1 "));

  // Sanitize the newest meetup stats
  $newest_id    = isset($dmeetups['m_id']) ? sanitize($dmeetups['m_id'], 'int', 0)    : 0;
  $newest_date  = isset($dmeetups['m_id']) ? sanitize($dmeetups['m_date'], 'int', 0)  : 0;

  // Update the user's meetups stats
  query(" UPDATE  users_stats
          SET     users_stats.meetups             = '$meetups_count'            ,
                  users_stats.meetups_en          = '$meetups_count_en'         ,
                  users_stats.meetups_fr          = '$meetups_count_fr'         ,
                  users_stats.meetups_bilingual   = '$meetups_count_bilingual'  ,
                  users_stats.meetups_oldest_id   = '$oldest_id'                ,
                  users_stats.meetups_oldest_date = '$oldest_date'              ,
                  users_stats.meetups_newest_id   = '$newest_id'                ,
                  users_stats.meetups_newest_date = '$newest_date'
          WHERE   users_stats.fk_users            = '$user_id'                  ");

}




/**
 * Recalculates meetups statistics.
 *
 * @return  void
 */

function meetups_stats_recalculate_all()
{
  // Fetch every user id
  $qusers = query(" SELECT    users.id AS 'u_id'
                    FROM      users
                    ORDER BY  users.id ASC ");

  // Loop through the users and recalculate their individual meetups statistics
  while($dusers = mysqli_fetch_array($qusers))
  {
    $user_id = sanitize($dusers['u_id'], 'int', 0);
    meetups_stats_recalculate_user($user_id);
  }
}