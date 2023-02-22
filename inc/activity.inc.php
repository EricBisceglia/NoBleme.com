<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*  logs_activity_parse     Transforms an entry of the `logs_activity` table into human readable content.            */
/*                                                                                                                   */
/*********************************************************************************************************************/


/**
 * Transforms an entry of the `logs_activity` table into human readable content.
 *
 * @param   bool    $admins_only                Is the log public (true) or private (false) to the standard user.
 * @param   string  $type                       Identifies the type of activity being processed.
 * @param   int     $id             (OPTIONAL)  ID of the action/element of the activity in the log.
 * @param   string  $title_en       (OPTIONAL)  Title of the activity in the log, in english.
 * @param   string  $title_en       (OPTIONAL)  Title of the activity in the log, in french.
 * @param   int     $userid         (OPTIONAL)  ID of the user being implicated by the activity log.
 * @param   string  $username       (OPTIONAL)  username of the user being implicated by the activity log.
 * @param   string  $mod_username   (OPTIONAL)  username of the staff member being implicated by the activity log.
 * @param   int     $amount         (OPTIONAL)  Amount linked to the activity log.
 *
 * @return  array                               Array of elements used to output and format the activity log;
 *                                              return['css']   is the style of the table line (if empty, no style),
 *                                              return['href']  is the url of the activity (if empty, not clickable),
 *                                              return['EN']    is the activity in english (if empty, french only),
 *                                              return['FR']    is the activity in french (if empty, english only).
 */

function logs_activity_parse( bool    $admins_only        ,
                              string  $type               ,
                              int     $id           = 0   ,
                              string  $title_en     = ''  ,
                              string  $title_fr     = ''  ,
                              int     $userid       = 0   ,
                              string  $username     = ''  ,
                              string  $mod_username = ''  ,
                              int     $amount       = 0   ) : array
{
  //*****************************************************************************************************************//
  // Fetch the path to the website's root and the user's display mode

  $path = root_path();
  $mode = user_get_mode();


  //*****************************************************************************************************************//
  //                                             DEVELOPMENT / INTERNALS                                             //
  //*****************************************************************************************************************//

  if($type === 'dev_version')
  {
    $return['css']  = ($mode === 'dark') ? 'text_green bold' : 'text_green bold';
    $return['href'] = $path.'pages/tasks/roadmap';
    $return['EN']   = "New version of the website: ".$title_en;
    $return['FR']   = "Nouvelle version du site : ".$title_fr;
  }

  else if($type === 'dev_blog')
  {
    $return['css']  = ($mode === 'dark') ? 'brown bold' : 'light bold';
    $return['href'] = $path.'pages/dev/blog?id='.$id;
    $return['EN']   = ($title_en) ? "New devblog published: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Nouveau devblog publié : ".$title_fr : '';
  }

  else if($type === 'dev_task_new')
  {
    $return['href'] = $path.'pages/tasks/'.$id;
    $return['EN']   = ($title_en) ? $username." opened a new task: ".$title_en : '';
    $return['FR']   = ($title_fr) ? $username." a ouvert une tâche : ".$title_fr : '';

  }

  else if($type === 'dev_task_finished')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'pages/tasks/'.$id;
    $return['EN']   = ($title_en) ? "Task solved: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Tache résolue : ".$title_fr : '';
  }




  //*****************************************************************************************************************//
  //                                                      USERS                                                      //
  //*****************************************************************************************************************//

  else if($type === 'users_register')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'pages/users/'.$userid;
    $return['EN']   = $username." registered on NoBleme!";
    $return['FR']   = $username." a crée son compte sur NoBleme !";
  }

  else if($type === 'users_profile_edit')
  {
    $return['href'] = $path.'pages/users/'.$userid;
    $return['EN']   = $username.' edited their public profile';
    $return['FR']   = $username.' a modifié son profil public';
  }

  else if($type === 'users_admin_edit_profile')
  {
    $return['css']  = ($mode === 'dark') ? 'orange bold' : 'orange bold text_white';
    $return['href'] = $path.'pages/users/'.$userid;
    $return['EN']   = $mod_username.' edited '.$username."'s public profile";
    $return['FR']   = $mod_username.' a modifié le profil public de '.$username;
  }

  else if($type === 'users_banned' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/users/'.$userid;
    $ban_length     = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month',
                            '365' => 'for a year', '3650' => 'permanently');
    $return['EN']   = $username.' has been banned '.$ban_length[$amount];
    $return['EN']  .= ($title_en) ? ' ('.$title_en.')' : '';
    $ban_length     = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois',
                            '365' => 'un an', '3650' => 'définitivement');
    $return['FR']   = $username.' s\'est fait bannir '.$ban_length[$amount];
    $return['FR']  .= ($title_fr) ? ' ('.$title_fr.')' : '';
  }
  else if($type === 'users_banned')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/admin/ban';
    $ban_length     = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month',
                            '365' => 'for a year', '3650' => 'permanently');
    $return['EN']   = $mod_username.' banned '.$username.' '.$ban_length[$amount];
    $return['EN']  .= ($title_en) ? ' ('.$title_en.')' : '';
    $ban_length     = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois',
                            '365' => 'un an', '3650' => 'définitivement');
    $return['FR']   = $mod_username.' a banni '.$username.' '.$ban_length[$amount];
    $return['FR']  .= ($title_fr) ? ' ('.$title_fr.')' : '';
  }

  else if($type === 'users_banned_edit' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/users/'.$userid;
    $ban_length     = array(0 => '', 1 => 'ending a day from now', 7 => 'ending a week from now',
                            30 => 'ending a month from now', 365 => 'ending a year from now',
                            3650 => 'a permanent ban');
    $return['EN']   = $username.' has had their ban updated to '.$ban_length[$amount];
    $return['EN']  .= ($title_en) ? ' ('.$title_en.')' : '';
    $ban_length     = array(0 => '', 1 => 'dans un jour', 7 => 'dans une semaine',
                            30 => 'dans un mois', 365 => 'dans un an', 3650 => 'ban permanent');
    $return['FR']   = 'La date de fin du bannissement de '.$username.' a changé : '.$ban_length[$amount];
    $return['FR']  .= ($title_fr) ? ' ('.$title_fr.')' : '';
  }
  else if($type === 'users_banned_edit')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/admin/ban';
    $ban_length     = array(0 => '', 1 => 'to ending a day from now', 7 => 'to ending a week from now',
                            30 => 'to ending a month from now', 365 => 'to ending a year from now',
                            3650 => 'to a permanent ban');
    $return['EN']   = $mod_username.' edited the ban of '.$username.' '.$ban_length[$amount];
    $return['EN']  .= ($title_en) ? ' ('.$title_en.')' : '';
    $ban_length     = array(0 => '', 1 => ': fini dans un jour', 7 => ': fini dans une semaine',
                            30 => ': fini dans un mois', 365 => ': fini dans un an', 3650 => 'en un ban permanent');
    $return['FR']   = $mod_username.' a modifié le bannissement de '.$username.' '.$ban_length[$amount];
    $return['FR']  .= ($title_fr) ? ' ('.$title_fr.')' : '';
  }

  else if($type === 'users_banned_delete')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/admin/ban';
    $return['EN']   = $mod_username.' unbanned '.$username;
    $return['EN']  .= ($title_en) ? ' ('.$title_en.')' : '';
    $return['FR']   = $mod_username.' a débanni '.$username;
    $return['FR']  .= ($title_fr) ? ' ('.$title_fr.')' : '';
  }

  else if($type === 'users_unbanned' && !$admins_only)
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'pages/users/'.$userid;
    $return['EN']   = $username.' has been unbanned';
    $return['FR']   = $username.' s\'est fait débannir';
  }
  else if($type === 'users_unbanned')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/admin/ban';
    $return['EN']   = $mod_username.' has unbanned '.$username;
    $return['FR']   = $mod_username.' a débanni '.$username;
  }

  else if($type === 'users_banned_ip')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/admin/ban';
    $ban_length     = array(0 => '', 1 => 'for a day', 7 => 'for a week', 30 => 'for a month',
                            365 => 'for a year', 3650 => 'permanently');
    $return['EN']   = $mod_username.' banned the IP address '.$username.' '.$ban_length[$amount];
    $return['EN']  .= ($title_en) ? ' ('.$title_en.')' : '';
    $ban_length     = array(0 => '', 1 => 'un jour', 7 => 'une semaine', 30 => 'un mois',
                            365 => 'un an', 3650 => 'définitivement');
    $return['FR']   = $mod_username.' a banni l\'adresse IP '.$username.' '.$ban_length[$amount];
    $return['FR']  .= ($title_fr) ? ' ('.$title_fr.')' : '';
  }

  else if($type === 'users_banned_ip_delete')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/admin/ban';
    $return['EN']   = $mod_username.' unbanned the IP address '.$username;
    $return['FR']   = $mod_username.' a débanni l\'adresse IP '.$username;
  }

  else if($type === 'users_unbanned_ip')
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'pages/admin/ban';
    $return['EN']   = 'The ban of the IP address '.$username.' has ended';
    $return['FR']   = 'Le bannissement de l\'adresse IP '.$username.' est fini';
  }

  else if($type === 'users_rights_delete' && !$admins_only)
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'pages/users/admins';
    $return['EN']   = $username." is not part of the administrative team anymore";
    $return['FR']   = $username." ne fait plus partie de l'équipe administrative";
  }
  else if($type === 'users_rights_delete')
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'pages/users/admins';
    $return['EN']   = $mod_username." has removed ".$username." from the administrative team";
    $return['FR']   = $mod_username." a viré ".$username." de l'équipe administrative";
  }

  else if($type === 'users_rights_moderator' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'orange bold' : 'orange bold text_white';
    $return['href'] = $path.'pages/users/admins';
    $return['EN']   = $username." has joined the administrative team as a moderator";
    $return['FR']   = $username." a rejoint l'équipe de modération de NoBleme";
  }
  else if($type === 'users_rights_moderator')
  {
    $return['css']  = ($mode === 'dark') ? 'orange bold' : 'orange bold text_white';
    $return['href'] = $path.'pages/users/admins';
    $return['EN']   = $mod_username." has promoted ".$username." as a moderator";
    $return['FR']   = $mod_username." a promu ".$username." au sein de l'équipe de modération";
  }

  else if($type === 'users_rights_administrator' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/users/admins';
    $return['EN']   = $username." is now a website administrator";
    $return['FR']   = $username." a rejoint l'équipe d'administration de NoBleme";
  }
  else if($type === 'users_rights_administrator')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/users/admins';
    $return['EN']   = $mod_username." has promoted ".$username." as an administrator";
    $return['FR']   = $mod_username." a promu ".$username." au sein de l'équipe d'administration";
  }

  else if($type === 'users_rename')
  {
    $return['css']  = 'yellow text_black bold';
    $return['href'] = $path.'pages/users/'.$userid;
    $return['EN']   = $title_en." has been renamed to ".$username." by ".$mod_username;
    $return['FR']   = "Le compte de ".$title_en." a été renommé en ".$username." par ".$mod_username;
  }

  else if($type === 'users_password')
  {
    $return['css']  = ($mode === 'dark') ? 'orange bold' : 'orange bold text_white';
    $return['EN']   = $mod_username." has changed ".$username."'s password";
    $return['FR']   = $mod_username." a modifié le mot de passe de ".$username;
  }

  else if($type === 'users_delete')
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['EN']   = $username."'s account has been deleted by ".$mod_username;
    $return['FR']   = "Le compte de ".$username." a été supprimé par ".$mod_username;
  }

  else if($type === 'users_undelete')
  {
    $return['css']  = ($mode === 'dark') ? 'green bold' : 'green bold text_white';
    $return['href'] = $path.'pages/users/'.$userid;
    $return['EN']   = $username."'s account has been reactivated by ".$mod_username;
    $return['FR']   = "Le compte de ".$username." a été réactivé par ".$mod_username;
  }




  //*****************************************************************************************************************//
  //                                                REAL LIFE MEETUPS                                                //
  //*****************************************************************************************************************//

  else if($type === 'meetups_new' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'green bold' : 'green bold text_white';
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = 'New real life meetup planned on '.date_to_text($title_en, 1);
    $return['FR']   = 'Nouvelle rencontre IRL planifiée le '.date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_new')
  {
    $return['css']  = 'text_green bold';
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username.' created a new meetup on '.date_to_text($title_en, 1);
    $return['FR']   = $mod_username.' a crée une nouvelle IRL le '.date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_edit' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'text_dark bold yellow' : 'bold yellow';
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = "The ".date_to_text($title_en, 1)." meetup has been moved to a new date";
    $return['FR']   = "La rencontre IRL du ".date_to_text($title_fr, 1)." a changé de date";
  }
  else if($type === 'meetups_edit')
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username." edited the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_username." a modifié l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_delete' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'red bold' : 'red bold text_white';
    $return['href'] = $path.'pages/meetups/list';
    $return['EN']   = 'The '.date_to_text($title_en, 1).' real life meetup has been cancelled';
    $return['FR']   = 'La rencontre IRL du '.date_to_text($title_fr, 1).' a été annulée';
  }
  else if($type === 'meetups_delete')
  {
    $return['css']  = 'text_red bold';
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username." deleted the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_username." a supprimé l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_restore' && !$admins_only)
  {
    $return['css']  = ($mode === 'dark') ? 'text_dark bold yellow' : 'bold yellow';
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = 'The '.date_to_text($title_en, 1).' real life meetup is back on the menu!';
    $return['FR']   = 'La rencontre IRL du '.date_to_text($title_fr, 1).' est de retour !';
  }
  else if($type === 'meetups_restore')
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username." restored the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_username." a restauré l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_new' && !$admins_only)
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $username.' joined the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $username." a rejoint l'IRL du ".date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_people_new')
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username." added ".$username." to the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_username.' a ajouté '.$username." à l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_edit')
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username.' modified '.$username."'s details in the ".date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_username.' a modifié les infos de '.$username." dans l'IRL du ".date_to_text($title_fr, 1);
  }

  else if($type === 'meetups_people_delete' && !$admins_only)
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $username.' left the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $username." a quitté l'IRL du ".date_to_text($title_fr, 1);
  }
  else if($type === 'meetups_people_delete')
  {
    $return['href'] = $path.'pages/meetups/'.$id;
    $return['EN']   = $mod_username.' removed '.$username.' from the '.date_to_text($title_en, 1)." meetup";
    $return['FR']   = $mod_username.' a supprimé '.$username." de l'IRL du ".date_to_text($title_fr, 1);
  }




  //*****************************************************************************************************************//
  //                                             21ST CENTURY COMPENDIUM                                             //
  //*****************************************************************************************************************//

  else if($type === 'compendium_new')
  {
    $return['css']  = ($mode === 'dark') ? 'bold blue' : 'bold blue text_white';
    $return['href'] = $path.'pages/compendium/'.$username;
    $return['EN']   = ($title_en) ? 'New compendium entry: '.$title_en : '';
    $return['FR']   = ($title_fr) ? "Nouvelle page du compendium : ".$title_fr : '';
  }

  else if($type === 'compendium_edit')
  {
    $return['href'] = $path.'pages/compendium/'.$username;
    $return['EN']   = ($title_en) ? "Compendium entry modified: ".$title_en : '';
    $return['FR']   = ($title_fr) ? "Page du compendium modifiée : ".$title_fr : '';
  }




  //*****************************************************************************************************************//
  //                                                     QUOTES                                                      //
  //*****************************************************************************************************************//

  else if($type === 'quotes_new_fr')
  {
    $return['css']  = ($mode === 'dark') ? 'brown bold' : 'brown bold text_white';
    $return['href'] = $path.'pages/quotes/'.$id;
    $return['FR']   = 'Citation #'.$id.' ajoutée à la collection';
  }
  else if($type === 'quotes_new_en')
  {
    $return['css']  = ($mode === 'dark') ? 'brown bold' : 'brown bold text_white';
    $return['href'] = $path.'pages/quotes/'.$id;
    $return['EN']   = 'Quote #'.$id.' added to the collection';
    $return['FR']   = 'Citation anglophone #'.$id.' ajoutée à la collection';
  }




  //*****************************************************************************************************************//
  //                                                       IRC                                                       //
  //*****************************************************************************************************************//

  else if($type === 'irc_channels_new')
  {
    $return['href'] = $path.'pages/social/irc?channels';
    $return['EN']   = 'IRC channel '.$title_en.' added to the list by '.$mod_username;
    $return['FR']   = 'Canal IRC '.$title_en.' ajouté à la liste par '.$mod_username;
  }

  else if($type === 'irc_channels_edit')
  {
    $return['href'] = $path.'pages/social/irc?channels';
    $return['EN']   = 'IRC channel '.$title_en.' updated by '.$mod_username;
    $return['FR']   = 'Canal IRC '.$title_en.' mis à jour par '.$mod_username;
  }

  else if($type === 'irc_channels_delete')
  {
    $return['href'] = $path.'pages/social/irc?channels';
    $return['EN']   = 'IRC channel '.$title_en.' deleted by '.$mod_username;
    $return['FR']   = 'Canal IRC '.$title_en.' supprimé par '.$mod_username;
  }




  //*****************************************************************************************************************//
  //                                                 DEFAULT VALUES                                                  //
  //*****************************************************************************************************************//
  // If no activity type has been matched, return some default content

  else
  {
    $return['EN']   = "This should not appear here, oops (".$type.")";
    $return['FR']   = "Ceci ne devrait pas apparaitre ici, oups (".$type.")";
  }

  // If some values were left empty, replace them with an empty string

  $return['css']  = (isset($return['css']))  ? $return['css']  : "";
  $return['href'] = (isset($return['href'])) ? $return['href'] : "";
  $return['EN']   = (isset($return['EN']))   ? $return['EN']   : "";
  $return['FR']   = (isset($return['FR']))   ? $return['FR']   : "";

  // Time to return the data
  return $return;
}