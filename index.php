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
/*********************************************************************************************************/ include './inc/header.inc.php';

    if(date('d-m') == '19-03') { ?>

    <br>
    <br>
    <br>

    <div class="moinsgros gras align_center">
      Joyeux anniversaire NoBleme.com !<br>
      <?=$agenobleme?> ans de bons moments<br>
      2005 - <?=date('Y')?><br>
      <a class="dark blank gros gras" href="">F5 !</a><br>
    </div>
    <br>
    <div class="align_center">
      <embed src="<?=$chemin?>img/swf/anniv_<?=$annivflash?>.swf" width="<?=$annivsize?>px"> </embed>
    </div>

    <br>
    <br>

    <?php } ?>

    <br>
    <br>
    <div class="align_center">
      <img src="./img/logos/index.png" alt="NoBleme.com">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Bienvenue sur NoBleme. Que trouverai-je par ici ?</span><br>
      <br>
      Existant dans son coin depuis plus de <?=$agenobleme?> ans, NoBleme est un vestige du passé d'internet.<br>
      <br>
      Avant l'ère des réseaux sociaux, le web était décentralisé : composé de plein de petites communautés qui n'avaient pas spécialement de thème ou de raison d'être. Aujourd'hui, NoBleme continue à préserver l'esprit quasi-familial de ces petites commaunatés d'antan.<br>
      <br>
      Toutefois, NoBleme n'est pas fait pour être un musée. C'est une communauté vivante, activement développée, qui continue à accueillir les nouveaux à bras ouverts et à éjecter les causeurs de drames afin de préserver l'ambiance amicale qui fait son charme.<br>
      <br>
      Voici une liste non exhaustive des pages plus ou moins utiles que vous trouverez sur NoBleme :<br>
      <ul>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/irc/index">Le serveur IRC</a>, où les NoBlemeux discutent entre eux en temps réel
        </li>
        <li class="spaced">
          <span class="barre"><a class="dark blank gras" href="<?=$chemin?>pages/forum/index">Le forum NoBleme</a></span> [travaux en cours], où les NoBlemeux discutent entre eux en différé
        </li>
        <li class="spaced">
          <span class="barre"><a class="dark blank gras" href="<?=$chemin?>pages/nbdb/index">La NBDatabase</a></span> [travaux en cours], où l'on découvre (entre autres) le monde de la culture internet
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/activite">L'activité récente</a>, où l'on suit ce qui se passe un peu partout sur le site
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/doc/index">La documentation</a>, où l'on comprend mieux le fonctionnement du site
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/irc/quotes">Les miscellanées</a>, où l'on rigole des idioties écrites par les NoBlemeux sur <a class="dark blank gras" href="<?=$chemin?>pages/irc/index">IRC</a>
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/coulisses">Les coulisses</a>, où l'on s'informe sur le passé, le présent et le futur du site
        </li>
      </ul>
      <br>
      N'ayez pas peur, le site ne mord pas. En tout cas, pas la première fois. Pour la suite, je ne peux rien garantir.<br>
      <a class="alinea" href="<?=$chemin?>pages/user/user?id=1">- Bad</a>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';