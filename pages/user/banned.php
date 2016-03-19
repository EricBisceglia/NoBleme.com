<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly();

// Titre et description
$page_titre = "Banni :(";
$page_desc  = "Vous êtes banni de NoBleme";

// Identification
$page_nom = "user";
$page_id  = "banned";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le pseudo
$nickid = postdata($_SESSION['user']);

// On récupère les infos
$banquery = query(" SELECT  membres.id          ,
                            membres.pseudonyme  ,
                            membres.banni_date  ,
                            membres.banni_raison
                    FROM    membres
                    WHERE   membres.id = '$nickid' ");

// On met tout ça dans des variables
$baninfo    = mysqli_fetch_array($banquery);
$user_nick  = $baninfo['pseudonyme'];
$ban_fin    = datefr(date("Y-m-d", $baninfo["banni_date"]))." à ".date("H:i:s", $baninfo["banni_date"]).' ('.dans($baninfo['banni_date']).')';
$ban_raison = destroy_html($baninfo['banni_raison']);

// Si l'user n'est pas banni, il n'a rien à faire sur cette page
if($baninfo["banni_date"] == 0)
  erreur("Vous n'avez pas la permission d'accéder à cette page");

// Si le ban est fini, reste plus qu'à le lever
if($baninfo["banni_date"] < time())
{
  query(" UPDATE  membres
          SET     membres.banni_date    = '0' ,
                  membres.banni_raison  = ''
          WHERE   membres.id = '$nickid'");
  erreur("Félicitations, votre bannissement est fini !");
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/banned.png" alt="Vous êtes banni :(">
    </div>
    <br>

    <div class="body_main midsize">

      <span class="titre">Désolé <?=$user_nick?>, vous vous êtes fait bannir de NoBleme</span><br>
      <br>
      Il vous sera impossible de vous servir de votre compte jusqu'au <b><?=$ban_fin?></b><br>
      <br>
      La raison de vore bannissement est la suivante: <b><?=$ban_raison?></b><br>
      <br>
      <br>
      Si vous jugez votre bannissement injuste, vous pouvez tenter de venir contester votre ban auprès de <a href="<?=$chemin?>pages/user/user?id=1">Bad</a> sur le <a href="<?=$chemin?>pages/irc/index">chat IRC NoBleme</a>.<br>

    </div>

    <br/>
    <br/>

    <div class="body_main midsize">

      <span class="titre">Bon à savoir avant de faire des bêtises</span><br>

      <br>
      Si vous créez un nouveau compte pendant la durée de votre sentence, <b>la durée de votre bannissement sera rallongée</b>, et vous serez également banni par range d'addresse IP, ce qui <b>vous empêchera de visiter la moindre page de NoBleme tant que vous êtes banni, même en vous déconnectant de votre compte</b>.<br>
      <br>
      Il va falloir être patient et accepter de payer le prix de ce dont vous êtes accusé. Difficile, je sais, mais il faut faire avec.<br>
      En attendant, vous êtes libre de <a href="<?=$chemin?>pages/nobleme/pilori.php?logout">vous déconnecter</a> de votre compte et de naviguer sur le site en tant qu'invité.<br>
      <br>
      Vous pouvez suivre sans vous connecter la progression de votre sentence depuis le <a href="<?=$chemin?>pages/nobleme/pilori">pilori des bannis</a>

    </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';