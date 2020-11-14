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