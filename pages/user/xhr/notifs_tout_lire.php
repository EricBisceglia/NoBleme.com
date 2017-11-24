<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              *//*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
useronly($lang);

// On marque tout comme lu
$userid     = $_SESSION['user'];
$timestamp  = time();
query(" UPDATE notifications SET notifications.date_consultation = '$timestamp' WHERE notifications.FKmembres_destinataire = '$userid' ");