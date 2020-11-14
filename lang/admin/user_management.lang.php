<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 DELETE AN ACCOUNT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Deactivate: Title
___('admin_deactivate_title', 'EN', "Delete an account");
___('admin_deactivate_title', 'FR', "Supprimer un compte");


// Deactivate: Form
___('admin_deactivate_submit',  'EN', "Delete this account");
___('admin_deactivate_submit',  'FR', "Supprimer ce compte");
___('admin_deactivate_success', 'EN', "The account has been deleted");
___('admin_deactivate_success', 'FR', "Le compte a été supprimé");
___('admin_deactivate_warning', 'EN', <<<EOT
Deleting an account is a one way action that should only be done if the user requests to have their account deleted or if there is a legitimate legal reason to do so. In other situations, you should rather {{link|pages/admin/ban|ban the user}}. Once an account is deleted, a lot of the content linked to the account on the website will also be deleted.
EOT
);
___('admin_deactivate_warning', 'FR', <<<EOT
Supprimer un compte est une action à sens unique qui ne doit être effectuée que si la personne possédant le compte le demande, ou s'il y a une obligation légale de le faire. Dans les autres cas, il faut plutôt {{link|pages/admin/ban|bannir le compte}}. Une fois un compte supprimé, beaucoup du contenu lié au compte sur le site sera également supprimé.
EOT
);


// Deactivate: Errors
___('admin_deactivate_error_username',  'EN', "No username provided");
___('admin_deactivate_error_username',  'FR', "Précisez un pseudonyme");
___('admin_deactivate_error_id',        'EN', "Account not found");
___('admin_deactivate_error_id',        'FR', "Compte non trouvé");
___('admin_deactivate_error_deleted',   'EN', "This account is already deleted");
___('admin_deactivate_error_deleted',   'FR', "Ce compte est déjà supprimé");
___('admin_deactivate_error_admin',     'EN', "You can not delete the administrative team");
___('admin_deactivate_error_admin',     'FR', "Vous ne pouvez pas supprimer l'équipe administrative");


// Deactivate: Accounts list
___('admin_deactivate_list_title',      'EN', "Deactivated accounts");
___('admin_deactivate_list_title',      'FR', "Comptes désactivés");
___('admin_deactivate_list_deleted_at', 'EN', "DELETED");
___('admin_deactivate_list_deleted_at', 'FR', "SUPPRIMÉ");
___('admin_deactivate_list_count',      'EN', "{{1}} DEACTIVATED ACCOUNT");
___('admin_deactivate_list_count',      'FR', "{{1}} COMPTE DÉSACTIVÉ");
___('admin_deactivate_list_count+',     'EN', "{{1}} DEACTIVATED ACCOUNTS");
___('admin_deactivate_list_count+',     'FR', "{{1}} COMPTES DÉSACTIVÉS");
___('admin_deactivate_list_reactivate', 'EN', "Reactivate user");
___('admin_deactivate_list_reactivate', 'FR', "Réactiver le compte");