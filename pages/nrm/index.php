<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Jouer';
$header_sidemenu  = 'NRM';

// Identification
$page_nom = "Se souvient du NRM Online";
$page_url = "pages/nrm/index";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = "NRM Online";
$page_desc  = "À la mémoire d'un jeu en ligne qui manque à certains d'entre nous.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "NRM Online";
  $trad['soustitre']  = "En souvenir d'un jeu en ligne";
  $trad['desc']       = <<<EOD
<p>
  De 2006 à 2009 est hébergé sur NoBleme un jeu de stratégie via navigateur dans lequel chaque joueur incarne un pilote de mecha géant et se bat jusqu'à la mort avec les autres joueurs. Nommé le NRM Online (NoBleme Robot Mayhem Online), ce jeu est un grand classique de l'histoire de NoBleme.
</p>
<p>
  Aujourd'hui, il n'y a aucun plan de ramener le NRM Online à la vie. Il faut que toutes les bonnes choses finissent un jour, et le NRM est un de ces jeux qui est meilleur en souvenir qu'en réalité. Toutefois, je laisse cette page-souvenir en place avec quelques captures d'écran du jeu, pour ceux qui l'ont connu à l'époque et voudraient faire un voyage nostalgie dans le passé. Vous pouvez également trouver une liste des anciens gagnants du jeu sur la page <a class="gras" href="{$chemin}pages/nrm/podium">champions du passé</a>.
</p>
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "NRM Online";
  $trad['soustitre']  = "Remembering an online game";
  $trad['desc']       = <<<EOD
<p>
  From 2006 to 2009, an online multiplayer browser game was hosted on NoBleme in which each player piloted a giant combat mecha's pilot and fought to the death with other players. Called the NRM Online (NoBleme Robot Mayhem Online), this game is a classic part of NoBleme's history.
</p>
<p>
  Today, there is no plan to bring the NRM Online back to life. All good things must come to an end, and the NRM is one of those things that's better in memories than it actually is. However, I'm leaving this memory shrine up on the website with a few screenshots from the game (in french), for those who experienced the game and want to go on a nostalgia trip. You can also find the game's hall of fame on the <a class="gras" href="{$chemin}pages/nrm/podium">champions of the past</a> page.
</p>
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

        <?=$trad['desc']?>

        <br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_index.png" alt="NRM Online">
        <br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_robot.png" alt="NRM Online">
        <br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_combat.png" alt="NRM Online">
        <br>
        <br>
        <img src="<?=$chemin?>img/nobleme/2006_3.png" alt="NRM Online">

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';