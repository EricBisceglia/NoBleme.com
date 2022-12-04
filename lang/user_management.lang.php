<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 DELETE AN ACCOUNT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

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
___('admin_deactivate_list_confirm',    'EN', "Confirm the reactivation of this account");
___('admin_deactivate_list_confirm',    'FR', "Confirmez la réactivation de ce compte");


// Reactivate an account
___('admin_reactivate_no_id',   'EN', "No account ID has been provided");
___('admin_reactivate_no_id',   'FR', "ID de compte manquant");
___('admin_reactivate_no_user', 'EN', "No user found for the provided ID");
___('admin_reactivate_no_user', 'FR', "Aucun compte trouvé pour cet ID");
___('admin_reactivate_success', 'EN', "The account has been reactivated");
___('admin_reactivate_success', 'FR', "Le compte a été réactivé");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 RENAME AN ACCOUNT                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Rename: Title
___('admin_rename_title', 'EN', "Rename an account");
___('admin_rename_title', 'FR', "Renommer un compte");


// Rename: Description
___('admin_rename_warning', 'EN', <<<EOT
Renaming an account should only be done if there is a very good reason to do so (for example an offensive username or a properly justified request from a user). The system will not notify the user of the account's username change, therefore you should keep the user informed by yourself.
EOT
);
___('admin_rename_warning', 'FR', <<<EOT
Renommer un compte ne doit être fait que s'il y a une très bonne raison de le faire (par exemple un pseudonyme offensant ou une demande correctement justifiée). Le système ne notifiera pas la personne concernée de son changement de pseudonyme, par conséquent il faudra l'en informer vous-même.
EOT
);


// Rename: Form
___('admin_rename_success',   'EN', "The account has been renamed");
___('admin_rename_success',   'FR', "Le compte a été renommé");
___('admin_rename_current',   'EN', "Current account username");
___('admin_rename_current',   'FR', "Pseudonyme actuel du compte");
___('admin_rename_new',       'EN', "New account username");
___('admin_rename_new',       'FR', "Nouveau pseudonyme du compte");
___('admin_rename_valid',     'EN', "This username is available");
___('admin_rename_valid',     'FR', "Ce pseudonyme est disponible");
___('admin_rename_reason_fr', 'EN', "Reason for the name change (in french)");
___('admin_rename_reason_fr', 'FR', "Justification du changement en français");
___('admin_rename_reason_en', 'EN', "Reason for the name change");
___('admin_rename_reason_en', 'FR', "Justification du changement en anglais");
___('admin_rename_submit',    'EN', "Rename the account");
___('admin_rename_submit',    'FR', "Renommer le compte");


// Rename: Form errors
___('admin_rename_error_short',       'EN', "This username is too short");
___('admin_rename_error_short',       'FR', "Ce pseudonyme est trop court");
___('admin_rename_error_long',        'EN', "This username is too long");
___('admin_rename_error_long',        'FR', "Ce pseudonyme est trop long");
___('admin_rename_error_characters',  'EN', "Forbidden character in usernames");
___('admin_rename_error_characters',  'FR', "Caractère interdit dans le pseudonyme");
___('admin_rename_error_illegal',     'EN', "Illegal word in username");
___('admin_rename_error_illegal',     'FR', "Mot illégal dans le pseudonyme");
___('admin_rename_error_taken',       'EN', "This username is already taken");
___('admin_rename_error_taken',       'FR', "Ce pseudonyme est déjà utilisé");
___('admin_rename_error_admin',       'EN', "Moderators can't rename administrators");
___('admin_rename_error_admin',       'FR', "Les modérateurs ne peuvent pas renommer les administrateurs");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                 CHANGE A PASSWORD                                                 */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Change password: Description
___('admin_password_warning', 'EN', <<<EOT
Changing a password should only be done if there is a very good reason to do so (for example if a user has lost their password, in case of security breach, or to lock a user out of their account). The system will not notify the user of the account's password change, therefore you should keep the user informed by yourself.
EOT
);
___('admin_password_warning', 'FR', <<<EOT
Changer un mot de passe ne doit être fait que s'il y a une très bonne raison de le faire (par exemple en cas de mot de passe perdu, en cas de problème de sécurité, ou pour verrouiller quelqu'un hors de son compte). Le système ne notifiera pas la personne de son changement de mot de passe, par conséquent il faudra l'en informer vous-même.
EOT
);


// Change password: Form
___('admin_password_new',     'EN', 'New password (at least 8 characters long)');
___('admin_password_new',     'FR', 'Nouveau mot de passe (8 caractères minimum)');
___('admin_password_submit',  'EN', 'Change the password');
___('admin_password_submit',  'FR', 'Modifier le mot de passe');


// Change password: Errors
___('admin_password_error_no_pass', 'EN', 'No password provided');
___('admin_password_error_no_pass', 'FR', 'Précisez un mot de passe');
___('admin_password_error_length',  'EN', 'The provided password is too short');
___('admin_password_error_length',  'FR', 'Ce mot de passe est trop court');
___('admin_password_error_admin',   'EN', "Moderators can't change administrator passwords");
___('admin_password_error_admin',   'FR', "Les modérateurs ne peuvent pas changer les mots de passe des administrateurs");




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    USER RIGHTS                                                    */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Rights: Title
___('admin_rights_title', 'EN', "Account rights");
___('admin_rights_title', 'FR', "Permissions");


// Rights: Form
___('admin_rights_form_title',  'EN', "Change an account's rights");
___('admin_rights_form_title',  'FR', "Changer les droits d'un compte");
___('admin_rights_submit',      'EN', "Change account rights");
___('admin_rights_submit',      'FR', "Changer les permissions");


// Rights: Form errors
___('admin_rights_error_level',     'EN', "The requested access rights don't exist");
___('admin_rights_error_level',     'FR', "Les droits d'accès souhaités n'existent pas");
___('admin_rights_error_self',      'EN', "You can not remove your own rights");
___('admin_rights_error_self',      'FR', "Impossible de changer vos propres droits d'accès");
___('admin_rights_error_founder',   'EN', "The first website's account can't be demoted");
___('admin_rights_error_founder',   'FR', "Impossible de rétrograder le premier compte du site");
___('admin_rights_error_user',      'EN', "This account already has standard rights");
___('admin_rights_error_user',      'FR', "Ce compte a déjà des droits standard");
___('admin_rights_error_mod',       'EN', "This account is already a moderator");
___('admin_rights_error_mod',       'FR', "Ce compte fait déjà partie de la modération");
___('admin_rights_error_admin',     'EN', "This account is already an administrator");
___('admin_rights_error_admin',     'FR', "Ce compte fait déjà partie de l'administration");
___('admin_rights_error_demotion',  'EN', "Administrators can only be demoted to regular users (you can promote them back to anything afterwards)");
___('admin_rights_error_demotion',  'FR', "Les administrateurs ne peuvent que être réduits au statut de simple membre (vous pourrez leur donner n'importe quel autre statut ensuite)");


// Rights: Administrative team memebers
___('admin_rights_list_title',  'EN', "Current administrative team");
___('admin_rights_list_title',  'FR', "Équipe administrative actuelle");