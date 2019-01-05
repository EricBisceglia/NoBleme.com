<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Jouer';
$header_sidemenu  = 'RadikalHype';

// Identification
$page_nom = "Se demande ce qu'est le projet Radikal";
$page_url = "pages/radikal/hype";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Projet : Radikal" : "Project: Radikal";
$page_desc  = "Le prochain projet de jeu NoBlemeux";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Projet : Radikal";
  $trad['soustitre']  = "Le prochain jeu NoBlemeux, disponible Bientôt™";
  $trad['desc']       = <<<EOD
En gestation depuis 2010, le Projet : Radikal est le prochain jeu NoBlemeux en développement. Comme tous les projets de <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a>, plusieurs itérations du jeu ont déjà été complétées, mais aucune n'était assez satisfaisante et tout recommence à zéro. Lorsque le bon équilibre entre intéressant, divertissant, et complexe aura été trouvé, le Projet : Radikal pourra ouvrir ses portes sur NoBleme. Patience !
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Project: Radikal";
  $trad['soustitre']  = "NoBleme's next game, coming Soon™";
  $trad['desc']       = <<<EOD
Constantly gestating as an idea since 2010, Project: Radikal is NoBleme's next upcoming game. As with every one of <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a>'s projects, many iterations of the game have already been completed, but none felt good enough to release. Once the right balance between interesting, entertaining, and challenging will have been found, then Project: Radikal shall open its doors on NoBleme. Patience!
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <br>
        <br>
        <br>

        <div class="align_center">
          <img class="valign_top" src="<?=$chemin?>img/divers/wip5.gif" alt="Under construction"><br>
          <img class="valign_bottom" src="<?=$chemin?>img/divers/wip1.gif" alt="Under construction"><br>
          <img class="valign_middle" src="<?=$chemin?>img/divers/wip3.gif" alt="Under construction">
          <img class="valign_middle" src="<?=$chemin?>img/divers/wip2.gif" alt="Under construction">
          <img class="valign_middle" src="<?=$chemin?>img/divers/wip4.gif" alt="Under construction">
          <img class="valign_middle" src="<?=$chemin?>img/divers/wip2.gif" alt="Under construction">
          <img class="valign_middle" src="<?=$chemin?>img/divers/wip3.gif" alt="Under construction"><br>
          <img class="valign_middle" src="<?=$chemin?>img/divers/wip5.gif" alt="Under construction">
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';