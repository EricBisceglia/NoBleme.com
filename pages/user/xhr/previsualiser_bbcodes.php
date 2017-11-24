<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              *//*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
useronly($lang);

// Si on a pas de message on est pas content
if(!isset($_POST['message']))
  exit('ERREUR: PRÉVISUALISATION IMPOSSIBLE');

// Sinon, on se contente de cracher la version BBCodée du message
echo bbcode(predata($_POST['message'], 1), 1);