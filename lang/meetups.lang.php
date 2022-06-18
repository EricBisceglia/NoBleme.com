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
___('meetups_list_body_1',  'EN', <<<EOT
Ever since {{link|pages/doc/nobleme|its inception in 2005}}, NoBleme's community has been organizing regular real life meetups for those who enjoy meeting in person. This page is used to both plan future meetups and keep track of the memories that come with older meetups. At first, the meetups were made solely of french speakers, then over time they expanded to include english speakers aswell. Sadly, as we have only been documenting our meetups since 2012, all data on older meetups has been lost.
EOT
);
___('meetups_list_body_1',  'FR', <<<EOT
Depuis {{link|pages/doc/nobleme|sa création en 2005}}, la communauté NoBleme a organisé de façon régulière ce que nous appelons des « IRL », initialisme anglophone signifiant « In Real Life », soit en français « dans la vraie vie » : des rencontres en personne plutôt que sur Internet. Cette page sert à organiser les futures IRL, ainsi qu'à documenter les IRL passées pour en préserver les souvenirs. Malheureusement, nous ne documentons les IRL que depuis 2012, les informations sur les IRL plus anciennes sont perdues.
EOT
);
___('meetups_list_body_2',  'EN', <<<EOT
Click on any line in the table below to see more details about a meetup, including how to join one in the case of future meetups.
EOT
);
___('meetups_list_body_2',  'FR', <<<EOT
Cliquez sur une ligne du tableau ci-dessous pour afficher plus de détails au sujet de l'IRL, incluant comment la rejoindre s'il s'agit d'une future IRL.
EOT
);


// Meetups list
___('meetups_list_date',      'EN', "Meetup date");
___('meetups_list_date',      'FR', "Date de l'IRL");
___('meetups_list_attendees', 'EN', "Attendees");
___('meetups_list_attendees', 'FR', "Personnes");
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
___('meetups_attendees_lock',         'EN', "Confirmed<br>attendance");
___('meetups_attendees_lock',         'FR', "Présence<br>confirmée");
___('meetups_attendees_details',      'EN', "Extra details");
___('meetups_attendees_details',      'FR', "Détails supplémentaires");





/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CREATE A MEETUP                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('meetups_new_title',  'EN', "Create a new meetup");
___('meetups_new_title',  'FR', "Nouvelle rencontre IRL");
___('meetups_new_header', 'EN', <<<EOT
Before creating a meetup, spend a bit of time gauging interest: create it on the website only once a few people are interested in attending and/or a date and place have been 100% determined. Once you create the meetup, automated messages will be sent on IRC and Discord in the appropriate languages (eg. english only meetups will not get communications in french, check both languages if people from both languages will be attending).
EOT
);
___('meetups_new_header', 'FR', <<<EOT
Avant de créer une nouvelle IRL, passez un peu de temps à mesurer l'intérêt : créez-la sur le site seulement une fois que quelques personnes sont intéressées et/ou qu'une date et un lieu ont été 100% déterminés. Une fois l'IRL crée, des messages automatisés seront envoyés sur IRC et Discord dans les langues appropriées (par ex. une IRL uniquement en français n'enverra pas de communication en anglais, cochez les deux langues si l'IRL pourrait contenir des personnes des deux langues/communautés).
EOT
);


// Form: Meetup summary
___('meetups_new_summary',    'EN', "Meetup summary");
___('meetups_new_summary',    'FR', "Résumé de l'IRL");
___('meetups_new_date',       'EN', "Meetup date, DD/MM/YY format (ex. 19/03/05)");
___('meetups_new_date',       'FR', "Date de l'IRL au format JJ/MM/AA (par ex. 19/03/05)");
___('meetups_new_location',   'EN', "Meetup location (just a city or country, 20 characters max.)");
___('meetups_new_location',   'FR', "Lieu de l'IRL (juste une ville ou un pays, 20 caractères max.)");
___('meetups_new_languages',  'EN', "Languages spoken at the meetup");
___('meetups_new_languages',  'FR', "Langues parlées lors de cette IRL");


// Form: Meetup details
___('meetups_new_details',        'EN', "Meetup details");
___('meetups_new_details',        'FR', "Détails de l'IRL");
___('meetups_new_details_body_1', 'EN', <<<EOT
Try to answer all of the following questions:<br>
* Where and when should people meet up?<br>
* What is the general plan for the meetup?<br>
* If it is a multi-day meetup, when does the meetup end?
EOT
);
___('meetups_new_details_body_1', 'FR', <<<EOT
Essayez de répondre aux questions suivantes :<br>
* Où et quand est-ce que les personnes se retrouveront ?<br>
* Quel est le planning de la rencontre IRL ?<br>
* S'il s'agit d'une IRL sur plusieurs jours, quand est-ce que l'IRL finit ?
EOT
);
___('meetups_new_details_body_2', 'EN', <<<EOT
You can use {{link_popup|pages/doc/bbcodes|BBCodes}} for styling. A live preview of the styled text will appear at the bottom of the page as you type the meetup's details in the fields below. If the plans for the meetup are still vague, you can leave these two fields blank or incomplete and fill them up at a later time. If you do not speak french but the meetup is bilingual, ask a french person for help with translating the details in french. If in doubt what to write in those fields, you can look at {{link_popup|pages/meetups/list|previous meetups}} for inspiration.
EOT
);
___('meetups_new_details_body_2', 'FR', <<<EOT
Vous pouvez utiliser des {{link_popup|pages/doc/bbcodes|BBCodes}} pour mettre en forme le texte. Une prévisualisation en temps réel du texte mis en forme apparaitra en bas de la page au fur et à mesure que vous remplirez les détails de l'IRL dans les champs ci-dessous. Si la planification de l'IRL n'est pas encore finalisée, vous pouvez laisser ces champs vierges ou incomplets et les remplir plus tard. Si vous ne parlez pas assez bien anglais mais que l'IRL est bilingue, demandez de l'aide à quelqu'un qui parle bien anglais. Vous pouvez utiliser le contenu des {{link_popup|pages/meetups/list|IRL précédentes}} comme inspiration.
EOT
);
___('meetups_new_details_en',     'EN', "Meetups details in english");
___('meetups_new_details_en',     'FR', "Détails de l'IRL en anglais");
___('meetups_new_details_fr',     'EN', "Meetups details in french");
___('meetups_new_details_fr',     'FR', "Détails de l'IRL en français");
___('meetups_new_submit',         'EN', "Create the meetup");
___('meetups_new_submit',         'FR', "Créer la rencontre IRL");
___('meetups_new_preview_en',     'EN', "Meetup details preview (english)");
___('meetups_new_preview_en',     'FR', "Prévisualisation des détails de l'IRL (anglais)");
___('meetups_new_preview_fr',     'EN', "Meetup details preview (french)");
___('meetups_new_preview_fr',     'FR', "Prévisualisation des détails de l'IRL (français)");


// Error messages
___('meetups_new_error_date',     'EN', "A valid date must be provided for the meetup");
___('meetups_new_error_date',     'FR', "La rencontre IRL doit avoir une date valide");
___('meetups_new_error_location', 'EN', "The meetup must have a location");
___('meetups_new_error_location', 'FR', "Un lieu doit être déterminé pour la rencontre IRL");
___('meetups_new_error_language', 'EN', "The meetup must have a language");
___('meetups_new_error_language', 'FR', "La rencontre IRL doit avoir une langue");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                   EDIT A MEETUP                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('meetups_edit_title', 'EN', "Edit a meetup");
___('meetups_edit_title', 'FR', "Modifier une IRL");


// Form
___('meetups_edit_submit',  'EN', "Edit the meetup");
___('meetups_edit_submit',  'FR', "Modifier la rencontre IRL");


// Error messages
___('meetups_edit_error_id',  'EN', "This meetup does not exist or has been deleted");
___('meetups_edit_error_id',  'FR', "Cette rencontre IRL n'existe pas ou a été supprimée");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  DELETE A MEETUP                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Soft delete
___('meetups_delete_confirm', 'EN', "Confirm the deletion of this meetup");
___('meetups_delete_confirm', 'FR', "Confirmer la suppression de cette rencontre IRL");


// Restore
___('meetups_restore_confirm',  'EN', "Confirm the undeletion of this meetup");
___('meetups_restore_confirm',  'FR', "Confirmer la restauration de cette rencontre IRL");


// Hard_delete
___('meetups_delete_hard_confirm',  'EN', "Confirm the permanent and irreversible deletion of this meetup");
___('meetups_delete_hard_confirm',  'FR', "Confirmer la suppression définitive et irréversible de cette rencontre IRL");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 ORGANIZE A MEETUP                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('meetups_organize_title', 'EN', "Plan a real life meetup");
___('meetups_organize_title', 'FR', "Organiser une IRL");


// Mod disclaimer
___('meetups_organize_mod_title',   'EN', "Reminder: You are part of the administrative team");
___('meetups_organize_mod_title',   'FR', "Rappel : Vous faites partie de l'administration");
___('meetups_organize_mod_body_1',  'EN', <<<EOT
Since you have the ability to host meetups yourself, the contents of the rest of this page do not apply to you. Feel free to use the website's tools to plan your own NoBleme meetups, it is why you were given those abilities! You can create a new meetup by clicking the icon to the right of the title on the {{link|pages/meetups/list|meetups list}} page.
EOT
);
___('meetups_organize_mod_body_1',  'FR', <<<EOT
Comme vous avez la possibilité de créer des rencontres IRL par vous-même, le contenu du reste de cette page ne vous concerne pas. N'hésitez pas à utiliser les outils du site pour planifier vos propres rencontres IRL NoBlemeuses, c'est pour cela que ces pouvoirs vous ont été donnés ! Vous pouvez créer une rencontre IRL en cliquant sur l'icône à droite du titre sur la {{link|pages/meetups/list|liste des IRL}}.
EOT
);


// Planning
___('meetups_organize_plan_title',  'EN', "Looking to organize a meetup of your own?");
___('meetups_organize_plan_title',  'FR', "Vous désirez planifier votre propre rencontre IRL ?");
___('meetups_organize_plan_body_1', 'EN', <<<EOT
Most of NoBleme's {{link|pages/meetups/list|real life meetups}} happen at the behest of members of our community, usually because someone is travelling to a specific country or city where there are other community regulars, and would like to use the opportunity to meet up with them.
EOT
);
___('meetups_organize_plan_body_1', 'FR', <<<EOT
La plupart des {{link|pages/meetups/list|rencontres IRL}} de NoBleme sont organisées à la demande de membres de la communauté, généralement parce que quelqu'un voyage dans un pays ou une ville qui contient d'autres membres de la communauté de NoBleme, et voudrait en profiter pour les croiser.
EOT
);
___('meetups_organize_plan_body_2', 'EN', <<<EOT
If you are a NoBleme regular and happen to be traveling near other regulars, or would like to suggest hosting a meetup for any other reason, then start by gauging interest on NoBleme's {{link|pages/social/irc|IRC chat}} or on {{link|pages/social/discord|Discord}}. If you can get a few people interested, then make sure a member of NoBleme's {{link|pages/users/admins|administrative team}} is part of the conversation, as they are the only ones with the ability to create new meetups on the website.
EOT
);
___('meetups_organize_plan_body_2', 'FR', <<<EOT
Si vous fréquentez NoBleme et comptez voyager quelque part où se trouvent d'autres membres de la communauté, ou voulez suggérer l'organisation d'une rencontre IRL pour n'importe quelle autre raison, commencez par mesurer l'intérêt que cela suscite sur le {{link|pages/social/irc|chat IRC NoBleme}} ou sur {{link|pages/social/discord|Discord}}. Si le lieu et la date intéressent quelques personnes, dans ce cas assurez-vous qu'un membre de {{link|pages/users/admins|l'équipe administrative}} fasse partie de la conversation : ce sont les seules personnes à pouvoir créer de nouvelles rencontres IRL sur le site.
EOT
);
___('meetups_organize_plan_body_3', 'EN', <<<EOT
Try to suggest meetups a long time in advance whenever possible, ideally several months ahead of time. The further ahead you plan, the more people will be able to lock that date, and the more people will be able to consider travel plans in order to attend the meetup. Obviously, if you do not have the ability to plan in advance, we can always do last minute meetups, they just tend to attract fewer people.
EOT
);
___('meetups_organize_plan_body_3', 'FR', <<<EOT
Essayez de suggérer des rencontres IRL longtemps à l'avance si possible, idéalement plusieurs mois avant. Le plus tôt vous planifiez une IRL, le plus de personnes pourront verrouiller ce jour, et le plus de personnes pourront planifier des voyages pour se rendre à l'IRL. Bien entendu, si vous n'avez pas la possibilité de planifier, nous pouvons toujours organiser une IRL de dernière minute, elles ont juste tendance à attirer moins de monde.
EOT
);
___('meetups_organize_plan_body_4', 'EN', <<<EOT
Before suggesting a new meetup, check that there is no {{link|pages/meetups/list|other meetup}} already happening around that date, and try to think of the accomodations: Is there a place indoors large enough for a group of people to hang out? If outdoors, what are the plans in case of rain? If the meetup includes a meal, is there a restaurant that can be booked in advance and will satisfy everyone both pricewise and foodwise? Or would you rather have everyone bring their own food? If the meetup is over several days, is there a place that can house those who can not afford hotels? Don't worry, we are used to hosting meetups and can help you think of solutions.
EOT
);
___('meetups_organize_plan_body_4', 'FR', <<<EOT
Avant de suggérer l'organisation d'une rencontre IRL, vérifiez qu'il n'y en ait pas déjà {{link|pages/meetups/list|une autre autour de cette date}}, et essayez de penser à la planification : Quel lieu pour regrouper un groupe de personnes ? Si c'est dehors, quel plan en cas de pluie ? Si l'IRL inclut un repas, quel restaurant permet de réserver à l'avance et sera accepté par tout le monde ? Serait-il plutôt préférable que chacun ramène de la nourriture ? Si l'IRL est sur plusieurs jours, peut-on mutualiser les hébergements ? Ne vous inquiétez pas, nous avons l'habitude d'organiser des IRL et vous aiderons à trouver des solutions.
EOT
);
___('meetups_organize_plan_body_5', 'EN', <<<EOT
We are always looking for opportunities to organize meetups, so come forward if you think we should do one!
EOT
);
___('meetups_organize_plan_body_5', 'FR', <<<EOT
Nous sommes toujours à la recherche d'opportunités pour organiser des rencontres IRL, faites-nous signe si vous pensez que nous devrions en organiser une !
EOT
);




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       STATS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Page section selector
___('meetups_selector_title',           'EN', "Real life meetups statistics");
___('meetups_selector_title',           'FR', "Stats des rencontres IRL");
___('meetups_stats_selector_overall',   'EN', "Overall stats");
___('meetups_stats_selector_overall',   'FR', "Stats globales");
___('meetups_stats_selector_people',    'EN', "Attendees");
___('meetups_stats_selector_people',    'FR', "Personnes présentes");
___('meetups_stats_selector_locations', 'EN', "Locations");
___('meetups_stats_selector_locations', 'FR', "Lieux des rencontres");
___('meetups_stats_selector_years',     'EN', "Timeline");
___('meetups_stats_selector_years',     'FR', "Ligne temporelle");


// Recalculate all stats
___('meetups_stats_recalculate_button', 'EN', "Recalculate all real life meetups statistics");
___('meetups_stats_recalculate_button', 'FR', "Recalculer toutes les statistiques des rencontres IRL");
___('meetups_stats_recalculate_alert',  'EN', "Are you sure you wish to recalculate all real life meetups statistics?");
___('meetups_stats_recalculate_alert',  'FR', "Confirmer que vous tenez à recalculer toutes les statistiques des rencontres IRL");


// Overall stats
___('meetups_stats_overall_summary',          'EN', "There has been <span class=\"bold\">{{1}}</span> {{link|pages/meetups/list|real life meetup}} in NoBleme's history.");
___('meetups_stats_overall_summary',          'FR', "<span class=\"bold\">{{1}}</span> {{link|pages/meetups/list|rencontre IRL}} a été organisée sur NoBleme à ce jour.");
___('meetups_stats_overall_summary+',         'EN', "There have been <span class=\"bold\">{{1}}</span> {{link|pages/meetups/list|real life meetups}} in NoBleme's history.");
___('meetups_stats_overall_summary+',         'FR', "<span class=\"bold\">{{1}}</span> {{link|pages/meetups/list|rencontres IRL}} ont été organisées sur NoBleme à ce jour.");
___('meetups_stats_overall_lang_bilingual',   'EN', "<span class=\"bold\">{{1}}</span> meetup were bilingual and had no main language.");
___('meetups_stats_overall_lang_bilingual',   'FR', "<span class=\"bold\">{{1}}</span> rencontre IRL était bilingue et n'avait pas de langue principale.");
___('meetups_stats_overall_lang_bilingual+',  'EN', "<span class=\"bold\">{{1}}</span> meetups were bilingual and had no main language.");
___('meetups_stats_overall_lang_bilingual+',  'FR', "<span class=\"bold\">{{1}}</span> rencontres IRL étaient bilingues et n'avaient pas de langue principale.");
___('meetups_stats_overall_lang_en',          'EN', "English was the main language of <span class=\"bold\">{{1}}</span> meetup.");
___('meetups_stats_overall_lang_en',          'FR', "L'anglais était la langue principale d'<span class=\"bold\">{{1}}</span> rencontre IRL.");
___('meetups_stats_overall_lang_en+',         'EN', "English was the main language of <span class=\"bold\">{{1}}</span> meetups.");
___('meetups_stats_overall_lang_en+',         'FR', "L'anglais était la langue principale de <span class=\"bold\">{{1}}</span> rencontres IRL.");
___('meetups_stats_overall_lang_fr',          'EN', "French was the main language of <span class=\"bold\">{{1}}</span> meetup.");
___('meetups_stats_overall_lang_fr',          'FR', "Le français était la langue principale d'<span class=\"bold\">{{1}}</span> rencontre IRL.");
___('meetups_stats_overall_lang_fr+',         'EN', "French was the main language of <span class=\"bold\">{{1}}</span> meetups.");
___('meetups_stats_overall_lang_fr+',         'FR', "Le français était la langue principale de <span class=\"bold\">{{1}}</span> rencontres IRL.");
___('meetups_stats_overall_future',           'EN', "<span class=\"bold\">{{1}}</span> future meetups is currently planned.");
___('meetups_stats_overall_future',           'FR', "<span class=\"bold\">{{1}}</span> rencontre IRL future est actuellement prévue.");
___('meetups_stats_overall_future+',          'EN', "<span class=\"bold\">{{1}}</span> future meetups are currently planned.");
___('meetups_stats_overall_future+',          'FR', "<span class=\"bold\">{{1}}</span> rencontres IRL futures sont actuellement prévues.");
___('meetups_stats_overall_biggest',          'EN', "The {{link|pages/meetups/{{1}}|biggest meetup so far}} was attended by {{2}} people on {{3}}.");
___('meetups_stats_overall_biggest',          'FR', "La {{link|pages/meetups/{{1}}|plus grande rencontre IRL}} à regroupé {{2}} personnes le {{3}}.");
___('meetups_stats_overall_more',             'EN', "You can find more stats about NoBleme's real life meetups by using the dropdown menu at the top.");
___('meetups_stats_overall_more',             'FR', "Vous trouverez d'autres stats sur les rencontres IRL en utilisant le menu déroulant en haut de la page.");