<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = '';
$header_submenu   = 'accueil';

// Identification
$page_nom = "index";
$page_id  = "index";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Flash aléatoire pour l'anniv de NoBleme

// On définit l'âge du site
$agenobleme = date('Y')-2005;

if(date('d-m') == '19-03')
{
  // On va chercher les infos dans la bdd
  $qflash     = query(" SELECT anniv_flash.nom_fichier, anniv_flash.largeur FROM anniv_flash ");
  $nflash     = mysqli_num_rows($qflash);

  // On en pique un au hasard
  $randflash  = rand(1,$nflash);
  for($i=0;$i<$randflash;$i++)
    $dflash = mysqli_fetch_array($qflash);

  // Et on prépare les infos
  $annivflash = $dflash['nom_fichier'];
  $annivsize  = $dflash['largeur'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/******************************************************************************************************/ include './inc/header.inc.php'; ?>

      <br>

      <div class="texte">

        <h1>NoBleme.com</h1>

        <h5>Bienvenue sur NoBleme. Que trouverai-je par ici ?</h5>

        <p>Existant dans son coin depuis plus de <?=$agenobleme?> ans, NoBleme est un vestige du passé d'internet.</p>

        <p>Avant l'ère des réseaux sociaux, le web était décentralisé : composé de plein de petites communautés qui n'avaient pas spécialement de thème ou de raison d'être. Aujourd'hui, NoBleme continue à préserver l'esprit quasi-familial de ces petites commaunatés d'antan.</p>

        <p>Toutefois, NoBleme n'est pas fait pour être un musée. C'est une communauté vivante, activement développée, qui continue à accueillir les nouveaux à bras ouverts et à éjecter les causeurs de drames afin de préserver l'ambiance amicale qui fait son charme.</p>

        <h5 class="bigpadding">NoBleme en <?=date('Y')?></h5>

        <p>En ce moment, NoBleme traverse une phase de travaux où la plupart du contenu du site est en réfection. Toutefois, la communauté est toujours présente sur <a class="gras" href="<?=$chemin?>pages/irc/index">le serveur de discussion IRC</a>. Rejoignez-nous et venez discuter sur IRC, nous accueillons toujours les nouveaux visiteurs les bras ouverts.</p>

        <p>N'ayez pas peur, le site ne mord pas. En tout cas, pas la première fois. Pour la suite, je ne peux rien garantir.</p>
        <a class="alinea" href="<?=$chemin?>pages/user/user?id=1">- Bad</a>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';