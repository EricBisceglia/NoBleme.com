<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Jouer';
$header_sidemenu  = 'NRMPodium';

// Identification
$page_nom = "Se souvient des champions du NRM Online";
$page_url = "pages/nrm/podium";

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
  $trad['titre']      = "Champions du passé";
  $trad['soustitre']  = "Archive des podiums de 26 saisons du NRM Online";
  $trad['desc']       = <<<EOD
Même si le <a class="gras" href="{$chemin}pages/nrm/index">NRM Online</a> a disparu depuis de nombreuses années, les gagnants des diverses saisons du jeu restent gravés dans l'histoire de NoBleme. Pour rajouter une touche de nostalgie, plutôt que de présenter les podiums archivés dans un format moderne, les voici sous la forme d'une grande capture d'écran :
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Champions of the past";
  $trad['soustitre']  = "26 seasons of NRM Online hall of famers, archived";
  $trad['desc']       = <<<EOD
Even though the <a class="gras" href="{$chemin}pages/nrm/index">NRM Online</a> has been gone for several years, the winners of the game's various seasons remain forever archived on NoBleme. In order to add a bit of nostalgia, instead of presenting the hall of fame in a modern format, here it is as a giant screenshot taken from the defunct game:
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

      </div>

      <br>
      <br>

      <div class="align_center">
        <img src="<?=$chemin?>img/divers/nrm_hof.png" alt="NRM Online">
      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';