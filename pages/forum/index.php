<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumIndex';

// Identification
$page_nom = "Espère que le forum reviendra un jour";
$page_url = "pages/forum/index";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = "Forum";
$page_desc  = "Forum de discussion NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Forum NoBleme";
  $trad['soustitre']  = "Reviendra à la vie Bientôt™";
  $trad['desc']       = <<<EOD
Qu'est-ce que NoBleme sans son légendaire forum ? Rien, dirons certains. Une ruine, rajouteront-ils. La honte, surenchériront-ils. Et ils n'auront pas forcément tort. Mais d'autres rappelleront à certains que NoBleme est une communauté qui n'a pas eu besoin de son forum pour survivre pendant ces cinq dernières années, et que ce n'est pas quelques années de plus sans forum qui tueront le site. N'est-ce pas ? Alors soyons patients.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  $trad['titre']      = "NoBleme forum";
  $trad['soustitre']  = "Will be resurrected Soon™";
  $trad['desc']       = <<<EOD
What's NoBleme without its legendary forum? Nothing, some people might say. A ruin, said people might add. A shame, these people would insist. And they wouldn't necessarily be wrong. But others shall remind them that NoBleme as a community didn't need its forum to survive during the past five years, and can survive a few more years without a forum. So let's be patient, and good things shall come in due time.
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
          <img src="http://textfiles.com/underconstruction/elainemarieslittlelanternGODSWORKIN-PROGRESS-Construction.gif" alt="Under construction"><br>
          <img src="http://textfiles.com/underconstruction/CoColosseumPressbox6848picsconstruction.gif" alt="Under construction"><br>
          <img src="http://textfiles.com/underconstruction/HoHollywoodHills5836under_construction.gif" alt="Under construction">
          <img src="http://textfiles.com/underconstruction/Wellesley5405construction.gif" alt="Under construction">
          <img src="http://textfiles.com/underconstruction/HeHeartlandLane5025imagesconstruction.gif" alt="Under construction"><br>
          <img src="http://textfiles.com/underconstruction/Nova2773construction.gif" alt="Under construction">
          <img src="http://textfiles.com/underconstruction/ajaj0077lines_bulletsconstruction.gif" alt="Under construction">
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';