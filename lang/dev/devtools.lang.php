<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                      QUERIES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/

// All's OK
___('dev_queries_ok', 'EN', "ALL QUERIES HAVE SUCCESSFULLY BEEN RAN");
___('dev_queries_ok', 'FR', "LES REQUÊTES ONT ÉTÉ EFFECTUÉES AVEC SUCCÈS");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CLOSE THE WEBSITE                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Close the website
___('dev_close_website_title',  'EN', "Open / Close the website");
___('dev_close_website_title',  'FR', "Ouvrir / Fermer le site");
___('dev_close_website_button', 'EN', "Toggle");
___('dev_close_website_button', 'FR', "Changer");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  VERSION NUMBERS                                                  */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Version numbers: header
___('dev_versions_title',         'EN', "Version numbers");
___('dev_versions_title',         'FR', "Numéros de version");
___('dev_versions_subtitle',      'EN', "NoBleme Semantic Versioning");
___('dev_versions_subtitle',      'FR', "NoBleme Semantic Versioning");
___('dev_versions_nbsemver',      'EN', "Given a version number MAJOR.MINOR.PATCH-EXTENSION, increment the:");
___('dev_versions_nbsemver',      'FR', "Étant donné un numéro de version MAJEUR.MINEUR.CORRECTIF-EXTENSION, il faut incrémenter :");
___('dev_versions_nbsemver_list', 'EN', <<<EOT
<ul>
  <li>
    MAJOR version when there is a significant core rework,
  </li>
  <li>
    MINOR version when there is a new major functionality,
  </li>
  <li>
    PATCH version when there is a new minor functionality or a bug has been fixed.
  </li>
  <li>
    EXTENSION can be added for incomplete or partial releases (alpha, beta, rc0, etc.).
  </li>
</ul>
EOT
);
___('dev_versions_nbsemver_list', 'FR', <<<EOT
<ul>
  <li>
    MAJEUR quand il y a une réécriture majeure d'un élément central,
  </li>
  <li>
    MINEUR quand il y a une nouvelle fonctionnalité majeure,
  </li>
  <li>
    CORRECTIF quand il y a une nouvelle fonctionnalité mineure ou qu'un bug a été corrigé.
  </li>
  <li>
  EXTENSION peut être ajouté pour les versions incomplètes ou partielles (alpha, beta, rc0, etc.).
  </li>
</ul>
EOT
);


// Version numbers: Form
___('dev_versions_form_title',      'EN', "Release new version");
___('dev_versions_form_title',      'FR', "Publier une nouvelle version");
___('dev_versions_form_major',      'EN', "Major");
___('dev_versions_form_major',      'FR', "Majeur");
___('dev_versions_form_minor',      'EN', "Minor");
___('dev_versions_form_minor',      'FR', "Mineur");
___('dev_versions_form_patch',      'EN', "Patch");
___('dev_versions_form_patch',      'FR', "Correctif");
___('dev_versions_form_extension',  'EN', "Extension");
___('dev_versions_form_extension',  'FR', "Extension");
___('dev_versions_form_activity',   'EN', "Publish in recent activity");
___('dev_versions_form_activity',   'FR', "Publier dans l'activité récente");
___('dev_versions_form_irc',        'EN', "Notify IRC #dev of the new release");
___('dev_versions_form_irc',        'FR', "Notifier IRC #dev de la nouvelle version");
___('dev_versions_form_submit',     'EN', "New release");
___('dev_versions_form_submit',     'FR', "Nouvelle version");


// Version numbers: Table
___('dev_versions_table_title',             'EN', "Version history");
___('dev_versions_table_title',             'FR', "Historique des versions");
___('dev_versions_table_delay',             'EN', "Delay");
___('dev_versions_table_delay',             'FR', "Délai");
___('dev_versions_table_not_existing',      'EN', "This version number does not exist");
___('dev_versions_table_not_existing',      'FR', "Ce numéro de version n'existe pas");
___('dev_versions_table_confirm_deletion',  'EN', "Confirm the irreversible deletion of version {{1}}");
___('dev_versions_table_confirm_deletion',  'FR', "Confirmer la suppression irréversible de la version {{1}}");
___('dev_versions_table_deleted',           'EN', "Version {{1}} has been deleted");
___('dev_versions_table_deleted',           'FR', "Version {{1}} supprimée");


// Version numbers: Edition
___('dev_versions_edit_button',           'EN', "Edit release");
___('dev_versions_edit_button',           'FR', "Modifier la version");
___('dev_versions_edit_error_postdata',   'EN', "Error: No version id was provided.");
___('dev_versions_edit_error_postdata',   'FR', "Erreur : Aucun numéro de version n'a été envoyé.");
___('dev_versions_edit_error_id',         'EN', "Error: The requested version does not exist.");
___('dev_versions_edit_error_id',         'FR', "Erreur : La version demandée n'existe pas.");
___('dev_versions_edit_error_duplicate',  'EN', "Error: This version number already exists.");
___('dev_versions_edit_error_duplicate',  'FR', "Erreur : Ce numéro de version existe déjà.");