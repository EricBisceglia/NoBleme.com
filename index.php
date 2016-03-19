<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes

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
  $agenobleme = date('Y')-2005;
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
      Mais qu'est-ce donc que NoBleme ? <a href="<?=$chemin?>pages/doc/nobleme">Cliquez ici</a> pour consulter la page de la documentation répondant vaguement à cette question.<br>
      Pour faire simple, NoBleme est une communauté internet francophone existant depuis 2005.<br>
      <br>
      NoBleme n'a pas réellement de définition, ni de thème ou d'objectif. Ce site n'est pas nécessaire, mais pas inutile non plus.<br>
      Disons que NoBleme est fait pour être une alternative libre de drames et de problèmes aux sites trop populaires.<br>
      La bonne ambiance amicale et agréable, ça ne se fait pas tout seul. Ça se cultive. Et c'est vers cette ambiance que NoBleme tend.<br>
      <br>
      <br>
      Afin de comprendre où vous êtes tombé, rien de mieux qu'une balade virtuelle parmi le contenu que le site propose, non ?<br>
      Le menu de navigation, que vous retrouverez en haut de toutes les pages, permet de se balader entre les différentes sections du site.<br>
      <br>
      Voici une liste non exhaustive des pages plus ou moins utiles que vous trouverez sur NoBleme :<br>
      <ul>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/irc/index">Le serveur IRC</a>, où les NoBlemeux discutent entre eux en temps réel
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/forum/index">Le forum NoBleme</a>, où les NoBlemeux discutent entre eux en différé
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/wiki/index">La NBDatabase</a>, où l'on découvre (entre autres) le monde de la culture internet
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/activite">L'activité récente</a>, où l'on suit ce qui se passe un peu partout sur le site
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/doc/index">La documentation</a>, où l'on comprend mieux le fonctionnement du site
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/irc/misc">Les miscellanées</a>, où l'on rigole des idioties écrites par les NoBlemeux sur <a class="dark blank gras" href="<?=$chemin?>pages/irc/index">IRC</a>
        </li>
        <li class="spaced">
          <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/coulisses">Les coulisses</a>, où l'on s'informe sur le passé, le présent et le futur du site
        </li>
      </ul>
      <br>
      N'ayez pas peur, le site ne mord pas. En tout cas, pas la première fois. Pour la suite, je ne peux rien garantir.<br>
      <br>
      Bonne balade virtuelle. Surtout, n'hésitez pas à vous perdre !<br>
      <br>
      &nbsp;&nbsp;&nbsp;&nbsp;- <a href="<?=$chemin?>pages/user/user?id=1">Bad</a>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';