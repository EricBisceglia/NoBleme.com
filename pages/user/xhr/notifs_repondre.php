<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              *//*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
useronly($lang);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On commence par récupérer le postdata
$notif_a      = postdata($_POST['destinataire'], 'string');
$notif_sujet  = tronquer_chaine(postdata($_POST['sujet'], 'string'), 80);
$notif_corps  = postdata($_POST['contenu'], 'string');

// On va vérifier si l'user auquel on veut envoyer la réponse existe bien
$qverifuser = query(" SELECT  membres.id
                      FROM    membres
                      WHERE   membres.pseudonyme LIKE '$notif_a' ");
if(!mysqli_num_rows($qverifuser))
  exit('ERREUR: UTILISATEUR INEXISTANT');

// On va vérifier si l'user est un flooder ou non
$notif_de   = $_SESSION['user'];
$floodtest  = (time() - 300);
$qfloodtest = query(" SELECT  COUNT(notifications.id) AS 'm_count'
                      FROM    notifications
                      WHERE   notifications.FKmembres_envoyeur = '$notif_de'
                      AND     notifications.date_envoi        >= '$floodtest' ");
$dfloodtest = mysqli_fetch_array($qfloodtest);

// Si on est pas dans un cas de flood, on peut maintenant envoyer le message
if($dfloodtest['m_count'] < 5)
{
  $dverifuser = mysqli_fetch_array($qverifuser);
  $notif_a    = $dverifuser['id'];
  $timestamp  = time();
  envoyer_notif($notif_a, $notif_sujet, $notif_corps, $notif_de);

  // Reste plus qu'à préparer le message de confirmation
  $notif_ok   = ($lang == 'FR') ? 'LE MESSAGE A BIEN ÉTÉ ENVOYÉ' : 'YOUR MESSAGE HAS BEEN SENT';
}

// Sinon, on balance une erreur
else
{
  $notif_ok   = 0;
  $notif_fail = ($lang == 'FR') ? 'VOTRE MESSAGE N\'A PAS ÉTÉ ENVOYÉ<br>VOUS AVEZ ENVOYÉ TROP DE MESSAGES RÉCEMMENT<br>RÉESSAYEZ PLUS TARD' : 'YOUR MESSAGE HAS NOT BEEN SENT<br>YOU HAVE SENT TOO MANY MESSAGES RECENTLY<br>TRY AGAIN LATER';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<?php if($notif_ok) { ?>
<h4 class="positif texte_blanc gras spaced"><?=$notif_ok?></h4>
<?php } else { ?>
<h4 class="negatif texte_blanc gras spaced"><?=$notif_fail?></h4>
<?php } ?>

<br>
<br>