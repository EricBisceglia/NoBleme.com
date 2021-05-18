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