<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       INDEX                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

// Header
___('compendium_index_title',   'EN', "Compendium");
___('compendium_index_title',   'FR', "Compendium");
___('compendium_index_subitle', 'EN', "Documenting 21st century culture");
___('compendium_index_subitle', 'FR', "Documentation du 21ème siècle");