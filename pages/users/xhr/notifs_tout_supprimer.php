<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              *//*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
useronly($lang);

// On fait la purge demandée
$purge_user = $_SESSION['user'];
query(" DELETE FROM notifications WHERE notifications.FKmembres_destinataire = '$purge_user' ");

// Et on prépare la phrase
$purge_ok = ($lang == 'FR') ? 'TOUS VOS MESSAGES ONT ÉTÉ SUPPRIMÉS' : 'ALL YOUR MESSAGES HAVE BEEN DELETED';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<tr>
  <td class="negatif texte_blanc gras" colspan="3">
    <?=$purge_ok?>
  </td>
<tr>