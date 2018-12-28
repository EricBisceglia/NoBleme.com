<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                 CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST INCLUDE PAR UNE AUTRE PAGE                                */
/*                                                                                                                                       */
// Include only /*************************************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF'])))
  exit('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>Vous n\'êtes pas censé accéder à cette page, dehors!</body></html>');




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Regroupement de tous les includes majeurs qui sont nécessaires dans toutes les pages

include_once 'reglages.inc.php';        // Réglages préliminaires à l'utilisation du site
include_once 'erreur.inc.php';          // Fonction permettant de générer une page d'erreur
include_once 'sql.inc.php';             // Connexion à la base de données MySQL
include_once 'post.inc.php';            // Fonctions de traitement des données
include_once 'session.inc.php';         // Gestion des sessions de données
include_once 'login.inc.php';           // Gestion de la connexion des utilisateurs
include_once 'date.inc.php';            // Fonctions de traitement de la date
include_once 'bbcode.inc.php';          // BBCodes et émoticones
include_once 'fonctions.inc.php';       // Fonctions génériques
include_once 'nobleme.inc.php';         // Fonctions spécifiques au fonctionnement de NoBleme
include_once 'automatisation.inc.php';  // Exécution des tâches planifiées