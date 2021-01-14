<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  RECENT ACTIVITY                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('activity_title',           'EN', "Recent activity");
___('activity_title',           'FR', "Activité récente");
___('activity_title_modlogs',   'EN', "Moderation logs");
___('activity_title_modlogs',   'FR', "Logs de modération");
___('activity_icon_deleted',    'EN', "Deleted logs");
___('activity_icon_deleted',    'FR', "Logs supprimés");
___('activity_mod_info',        'EN', <<<EOT
Some of the moderation logs below have an icon to their right: <img class="smallicon valign_middle" src="{{1}}img/icons/help.svg" alt="?"><br>
Clicking one of these icons will load some extra information about the logged action.
EOT
);
___('activity_mod_info',        'FR', <<<EOT
Certains des logs de modération ci-dessous ont des icônes à droite : <img class="smallicon valign_middle" src="{{1}}img/icons/help.svg" alt="?"><br>
Cliquer sur une de ces icônes affiche plus de détails sur l'action qui a été effectée.
EOT
);


// Activity amount/type selector
___('activity_latest_actions',  'EN', "LATEST ACTIONS");
___('activity_latest_actions',  'FR', "DERNIÈRES ACTIONS");

___('activity_type_all',        'EN', "All activity types");
___('activity_type_all',        'FR', "Tous types d'activité");
___('activity_type_users',      'EN', "Users");
___('activity_type_users',      'FR', "Membres");
___('activity_type_meetups',    'EN', "Meetups");
___('activity_type_meetups',    'FR', "Rencontres IRL");
___('activity_type_internet',   'EN', "Internet encyclopedia");
___('activity_type_internet',   'FR', "Encyclopédie du web");
___('activity_type_quotes',     'EN', "Quotes");
___('activity_type_quotes',     'FR', "Citations");
___('activity_type_dev',        'EN', "Website internals");
___('activity_type_dev',        'FR', "Développement");


// Activity log details
___('activity_details_reason',  'EN', "Reason for this action:");
___('activity_details_reason',  'FR', "Justification de l'action :");
___('activity_details_diff',    'EN', "Différence(s) before/after this action:");
___('activity_details_diff',    'FR', "Différence(s) avant/après l'action :");


// Actions
___('activity_delete',    'EN', "Are you sure you want to delete this activity log?");
___('activity_delete',    'FR', "Êtes-vous sûr de vouloir supprimer ce log d'activité ?");
___('activity_deleted',   'EN', "THIS ACTIVITY LOG HAS BEEN DELETED");
___('activity_deleted',   'FR', "CE LOG D'ACTIVITÉ A ÉTÉ SUPPRIMÉ");
___('activity_restore',   'EN', "Restore log");
___('activity_restore',   'FR', "Restaurer le log");
___('activity_restored',  'EN', "THIS ACTIVITY LOG HAS BEEN RESTORED");
___('activity_restored',  'FR', "CE LOG D'ACTIVITÉ A ÉTÉ RÉTABLI");