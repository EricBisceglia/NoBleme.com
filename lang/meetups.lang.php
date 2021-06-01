<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   MEETUPS LIST                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('meetups_list_title',   'EN', "Real life meetups");
___('meetups_list_title',   'FR', "Rencontres IRL");
___('meetups_list_body_1',  'EN', <<<EOT
Ever since {{link|pages/doc/nobleme|its inception in 2005}}, NoBleme's community has been organizing regular real life meetups for those who enjoy meeting in person. This page is used to both plan future meetups and keep track of the memories that come with older meetups. At first, the meetups were made solely of french speakers, then over time they expanded to include english speakers aswell. Sadly, as we have only been documenting our meetups since 2012, all data on older meetups has been lost.
EOT
);
___('meetups_list_body_1',  'FR', <<<EOT
Depuis {{link|pages/doc/nobleme|sa création en 2005}}, la communauté NoBleme a organisé de façon régulière ce que nous appelons des « IRL », initialisme anglophone signifiant « In Real Life », soit en français « dans la vraie vie » : des rencontres en personne plutôt que sur Internet. Cette page sert à organiser les futures IRL, ainsi qu'à documenter les IRL passées pour en préserver les souvenirs. Malheureusement, nous ne documentons les IRL que depuis 2012, les informations sur les IRL plus anciennes sont perdues.
EOT
);
___('meetups_list_body_2',  'EN', <<<EOT
Click on any line in the table below to see more details about a meetup, including how to join one in the case of future meetups (which are shown in green on the table).
EOT
);
___('meetups_list_body_2',  'FR', <<<EOT
Cliquez sur une ligne du tableau ci-dessous pour afficher plus de détails au sujet de l'IRL, incluant comment la rejoindre s'il s'agit d'une future IRL (qui apparaissent en vert dans la liste).
EOT
);


// Meetups list
___('meetups_list_date',      'EN', "Meetup date");
___('meetups_list_date',      'FR', "Date de l'IRL");
___('meetups_list_location',  'EN', "Location");
___('meetups_list_location',  'FR', "Lieu");
___('meetups_list_attendees', 'EN', "Attendees");
___('meetups_list_attendees', 'FR', "Personnes");
___('meetups_list_bilingual', 'EN', "Bilingual");
___('meetups_list_bilingual', 'FR', "Bilingue");
___('meetups_list_count',     'EN', "{{1}} NoBleme real life meetups");
___('meetups_list_count',     'FR', "{{1}} rencontres IRL NoBlemeuses");
___('meetups_list_none',      'EN', "No real life meetups have been found");
___('meetups_list_none',      'FR', "Aucune rencontre IRL trouvée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 INDIVIDUAL MEETUP                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('meetups_title',          'EN', "Real life meetup");
___('meetups_title',          'FR', "Rencontre IRL");
___('meetups_title_deleted',  'EN', "Deleted meetup");
___('meetups_title_deleted',  'FR', "IRL supprimée");
___('meetups_subtitle',       'EN', "{{1}} in {{2}}");
___('meetups_subtitle',       'FR', "{{1}} à {{2}}");
___('meetups_past_body',      'EN', <<<EOT
This page contains information on a {{link|pages/meetups/list|real life meetup}} between members of NoBleme's community. As the meetup has already happened, it acts as an archive for memory preservation.
EOT
);
___('meetups_past_body',      'FR', <<<EOT
Cette page contient des informations sur une {{link|pages/meetups/list|rencontre IRL}} entre membres de la communauté NoBleme. Cette IRL étant passée, il s'agit d'une archive dans le but de préserver les souvenirs.
EOT
);
___('meetups_today_body',     'EN', <<<EOT
This page contains information on a {{link|pages/meetups/list|real life meetup}} between members of NoBleme's community, which is happening today. If you have already signed up to be part of the meetup, we hope you are having a good time! If you didn't, we are sorry, it is too late to join it. But you can still join a future one!
EOT
);
___('meetups_today_body',     'FR', <<<EOT
Cette page contient des informations sur une {{link|pages/meetups/list|rencontre IRL}} entre membres de la communauté NoBleme, qui a lieu aujourd'hui. Si vous faites partie de cette IRL, nous espérons que vous passez un bon moment ! Si ce n'est pas le cas, il est malheureusement trop tard pour la rejoindre, mais vous pourrez toujours participer à une autre IRL dans le futur !
EOT
);
___('meetups_future_body_1',  'EN', <<<EOT
This page contains information on a {{link|pages/meetups/list|real life meetup}} between members of NoBleme's community, which is planned to take place in <span class="bold text_red">{{1}}</span>. NoBleme's meetups are open to everyone, and we are always very welcoming and happy to meet new people : don't hesitate to join us!
EOT
);
___('meetups_future_body_1',  'FR', <<<EOT
Cette page contient des informations sur une {{link|pages/meetups/list|rencontre IRL}} entre membres de la communauté NoBleme, qui aura lieu dans <span class="bold text_red">{{1}}</span>. Les IRL NoBlemeuses sont ouvertes à tout le monde, n'hésitez pas à nous rejoindre !
EOT
);
___('meetups_future_body_2',  'EN', <<<EOT
If you would like to take part in this meetup, only one <span class="bold text_red">mandatory</span> action is expected of you: you must inform a member of NoBleme's {{link|pages/users/admins|administrative team}} that you plan to be a part of the meetup, ideally through NoBleme's {{link|pages/social/irc|IRC chat}} or {{link|pages/social/discord|Discord}} servers. As we have to plan the spaces that will be used to host the meetup, it is necessary that we know in advance who will be attending in order to be properly prepared.
EOT
);
___('meetups_future_body_2',  'FR', <<<EOT
Si vous désirez participer à cette IRL, une seule action <span class="bold text_red">impérative</span> est attendue de vous : vous devez informer {{link|pages/users/admins|l'équipe administrative}} de NoBleme que vous comptez y participer, idéalement via notre {{link|pages/social/irc|chat IRC}} ou notre serveur {{link|pages/social/discord|Discord}}. Comme nous devons préparer les espaces qui seront utilisés pour l'IRL, il est nécessaire que nous sachions en avance qui y participera afin de s'y adapter.
EOT
);
___('meetups_wrong_language', 'EN', <<<EOT
Do note that this meetup is planned to be a <span class="bold text_red">french speaking meetup</span>: if you do not speak french, you might feel out of place. But worry not, many of us speak english, and we will ensure that you feel as comfortable as possible if you do decide to attend regardless.
EOT
);
___('meetups_wrong_language', 'FR', <<<EOT
Notez qu'il s'agit d'une IRL <span class="bold text_red">uniquement anglophone</span> : si vous ne parlez pas anglais, vous ne pourrez pas en profiter pleinement. Si vous n'êtes pas assez confortable en anglais, peut-être vaudrait-il mieux attendre la prochaine : nous organisons régulièrement des IRL francophones ou bilingues.
EOT
);


// Meetup details
___('meetups_details_title',  'EN', "Meetup details");
___('meetups_details_title',  'FR', "Organisation de l'IRL");


// Add an attendee
___('meetups_attendees_add_username', 'EN', <<<EOT
The form starts with two optional fields that seem similar: "account name" and "nickname or name". You must fill either one of the two. If the user is registered on NoBleme.com then enter their username in the first field. If the user isn't registered on NoBleme.com then enter a nickname for them in the second field. You also have the option to fill both, in which case the chosen nickname in the second field will be shown along with a link to the account named in the first field.
EOT
);
___('meetups_attendees_add_username', 'FR', <<<EOT
Le formulaire commence avec deux champs qui se ressemblent : « pseudonyme du compte » et « surnom ou nom ». Vous devez remplir un des deux. Si la personne possède un compte sur NoBleme.com, dans ce cas entrez le pseudonyme de son compte dans le premier champ. Si la personne n'en possède pas, dans ce cas entrez un surnom pour cette personne dans le second champ. Vous avez également l'option de remplir les deux, auquel cas le surnom choisi dans le second champ sera affiché et contiendra un lien vers le profil du compte NoBleme.com renseigné dans le premier champ.
EOT
);
___('meetups_attendees_add_account',  'EN', "Account name on NoBleme.com (optional)");
___('meetups_attendees_add_account',  'FR', "Pseudonyme du compte sur NoBleme.com (optionnel)");
___('meetups_attendees_add_nickname', 'EN', "Nickname or name (optional)");
___('meetups_attendees_add_nickname', 'FR', "Surnom ou nom (optionnel)");
___('meetups_attendees_add_extra_en', 'EN', "Extra details in english (optional, keep it short and simple)");
___('meetups_attendees_add_extra_en', 'FR', "Détails supplémentaires en anglais (optionnel, rester concis et simple)");
___('meetups_attendees_add_extra_fr', 'EN', "Extra details in french (optional, keep it short and simple)");
___('meetups_attendees_add_extra_fr', 'FR', "Détails supplémentaires en français (optionnel, rester concis et simple)");
___('meetups_attendees_add_lock',     'EN', "100% confirmed attendance");
___('meetups_attendees_add_lock',     'FR', "Présence 100% confirmée");
___('meetups_attendees_add_submit',   'EN', "Add an attendee");
___('meetups_attendees_add_submit',   'FR', "Ajouter une personne");


// Edit an attendee
___('meetups_attendees_edit_submit',        'EN', "Edit attendee details");
___('meetups_attendees_edit_submit',        'FR', "Modifier les informations");
___('meetups_attendees_edit_hide',          'EN', "Close this form");
___('meetups_attendees_edit_hide',          'FR', "Fermer ce formulaire");
___('meetups_attendees_edit_error_id',      'EN', "The attendee does not exist or has been deleted.");
___('meetups_attendees_edit_error_id',      'FR', "La personne n'existe pas ou a été supprimée.");
___('meetups_attendees_edit_error_meetup',  'EN', "The meetup does not exist or has been deleted.");
___('meetups_attendees_edit_error_meetup',  'FR', "La rencontre IRL n'existe pas ou a été supprimée.");


// Delete an attendee
___('meetups_attendees_delete_confirm', 'EN', "Confirm the deletion of an attendee from the meetup");
___('meetups_attendees_delete_confirm', 'FR', "Confirmer la suppression d\'une personne participant à cette rencontre IRL");
___('meetups_attendees_delete_ok',      'EN', "The attendee has succesfully been removed from the meetup");
___('meetups_attendees_delete_ok',      'FR', "La personne a bien été supprimée de la rencontre IRL");


// Attendees
___('meetups_attendees_future',       'EN', "{{1}} person will attend this meetup");
___('meetups_attendees_future+',      'EN', "{{1}} people will attend this meetup");
___('meetups_attendees_future',       'FR', "{{1}} personne participera à cette IRL");
___('meetups_attendees_future+',      'FR', "{{1}} personnes participeront à cette IRL");
___('meetups_attendees_present',      'EN', "{{1}} person is attending this meetup");
___('meetups_attendees_present+',     'EN', "{{1}} people are attending this meetup");
___('meetups_attendees_present',      'FR', "{{1}} personne participe à cette IRL");
___('meetups_attendees_present+',     'FR', "{{1}} personnes participent à cette IRL");
___('meetups_attendees_finished',     'EN', "{{1}} person attended this meetup");
___('meetups_attendees_finished+',    'EN', "{{1}} people attended this meetup");
___('meetups_attendees_finished',     'FR', "{{1}} personne a participé à cette IRL");
___('meetups_attendees_finished+',    'FR', "{{1}} personnes ont participé à cette IRL");
___('meetups_no_attendees_future',    'EN', "Nobody is attending this meetup yet");
___('meetups_no_attendees_future',    'FR', "Personne ne participe à cette IRL pour le moment");
___('meetups_no_attendees_finished',  'EN', "Nobody attended this meetup");
___('meetups_no_attendees_finished',  'FR', "Personne n'a participé à cette IRL");
___('meetups_attendees_body',         'EN', <<<EOT
In order to limit abuse, you can not sign yourself up to the meetup: only a member of the {{link|pages/users/admins|administrative team}} can add you to the list below. If you plan to attend this meetup, please contact our administrative team beforehand in order to get added to this list, ideally through NoBleme's {{link|pages/social/irc|IRC chat}} or {{link|pages/social/discord|Discord}} servers.
EOT
);
___('meetups_attendees_body',         'FR', <<<EOT
Afin d'éviter certains abus, vous ne pouvez pas vous ajouter vous-même à la liste ci-dessous : seule {{link|pages/users/admins|l'équipe administrative}} de NoBleme peut le faire. Si vous désirez participer à cette IRL, contactez l'administration afin de vous faire ajouter à cette liste, idéalement via notre {{link|pages/social/irc|chat IRC}} ou notre serveur {{link|pages/social/discord|Discord}}.
EOT
);
___('meetups_attendees_lock',         'EN', "Présence<br>confirmée");
___('meetups_attendees_lock',         'FR', "Confirmed<br>attendance");
___('meetups_attendees_details',      'EN', "Extra details");
___('meetups_attendees_details',      'FR', "Détails supplémentaires");