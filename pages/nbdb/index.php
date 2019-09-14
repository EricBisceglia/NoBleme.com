<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Read';
$header_sidemenu  = 'NBDBIndex';

// Identification
$page_nom = "Se demande ce qu'est la NBDB";
$page_url = "pages/nbdb/index";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = "NBDB";
$page_desc  = "Collection de bases d'informations hébergées sur NoBleme, incluant une encyclopédie de la culture internet";

// CSS
$css = array('doc');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Introduction
  $trad['titre']      = "NBDB : NoBleme Database";
  $trad['soustitre']  = "Collection de bases d'informations hébergées sur NoBleme";
  $trad['desc']       = <<<EOD
La NBDB, signifiant NoBleme Database (en français « Base de données NoBleme ») est une collection de diverses bases d'informations portant chacune sur un sujet spécifique. Il n'y a pas de lien particulier entre les divers contenus de la NBDB, ils sont juste là parce que <a class="gras" href="{$chemin}pages/users/user?pseudo=Bad">Bad</a> est un collectionneur compulsif d'informations et tient à les partager plutôt qu'à les accumuler inutilement dans son coin.
EOD;
  $trad['desc_web']   = <<<EOD
Le contenu principal de la NBDB, celui que cherchent la plupart des gens qui sont venus ici volontairement, est <a class="gras" href="{$chemin}pages/nbdb/web">l'encyclopédie de la culture internet</a>, une base de données historique cherchant à documenter l'évolution de la culture d'internet, des obscurs bulletin boards d'antan à la mémétique grand public moderne.
EOD;
  $trad['desc_liste'] = <<<EOD
Vous trouverez ci-dessous une liste complète des contenus de la NBDB (certains d'entre eux ne sont pas listés dans le menu latéral de gauche). Cliquez sur un contenu pour y accéder. Laissez la curiosité vous tenter !
EOD;

  // Liste des contenus
  $trad['doct_web_encyclo'] = "Encyclopédie de la culture internet";
  $trad['docd_web_encyclo'] = "Internet a une culture bien particulière. À l'origine intime et mystérieuse, elle est devenue grand public. Cette encyclopédie documente son évolution et tente de vous aider à comprendre les memes qui vous échappent.";
  $trad['doct_web_dico']    = "Dictionnaire de la culture internet";
  $trad['docd_web_dico']    = "Pour accompagner l'encyclopédie de la culture internet, un dictionnaire est nécessaire afin d'expliquer certains termes propres au milieu.";
  $trad['doct_web_wip']     = "Travail en cours";
  $trad['docd_web_wip']     = "En raison d'une réfection intégrale de NoBleme, la plupart des contenus de la NBDB ont été supprimés le temps d'être refaits à neuf.<br> Promis, ils reviendront bientôt !";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Introduction
  $trad['titre']      = "NoBleme Database";
  $trad['soustitre']  = "Collection of knowledge bases hosted on NoBleme";
  $trad['desc']       = <<<EOD
The NoBleme Database is a collection of knowledge bases pertaining to various different topics. There is no specific link between all those databases, other than <a class="gras" href="{$chemin}pages/users/user?pseudo=Bad">Bad</a> being a compulsive collector of useless knowledge and deciding to share it online rather than pointlessly keeping it all to himself.
EOD;
  $trad['desc_web']   = <<<EOD
The star content of the NoBleme Database, and what you're probably looking for if you came to this page with a purpose in mind, is the <a class="gras" href="{$chemin}pages/nbdb/web">encyclopedia of internet culture</a>, a historical archive documenting the very peculiar culture of the internet, from the underground bulletin board era to today's mainstream memetic culture.
EOD;
  $trad['desc_liste'] = <<<EOD
Below, you will find a list of all the content available on the NBDB (some of them aren't listed on the left side navigation menu). Click on any content to read it, let your curiosity get the best of you!
EOD;

  // Liste des contenus
  $trad['doct_web_encyclo'] = "Encyclopedia of internet culture";
  $trad['docd_web_encyclo'] = "Internet has a rather peculiar culture. At first intimate and mysterious, it has now become mainstream. This enclyclopedia documents its evolution and attempts to help you understand the memes that make no sense to you.";
  $trad['doct_web_dico']    = "Dictionary of internet culture";
  $trad['docd_web_dico']    = "To go along with the internet culture encyclopedia, a dictionary is necessary in order to explain certain terms specific to its context.";
  $trad['doct_web_wip']     = "Work in progress";
  $trad['docd_web_wip']     = "Due to a full facelift of the website, most contents of the NoBleme Database have been deleted and will come back in a newer fresher format. Hopefully it won't take too long!";
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

        <p><?=$trad['desc_web']?></p>

        <p><?=$trad['desc_liste']?></p>

      </div>

      <br>
      <br>

      <div class="minitexte3">

        <div class="doc_minipadding doc_miniborder pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web';">
          <div class="align_center doc_miniborder">
            <h5 class="doc_minipadding_bot doc_miniborder_bot">
              <?=$trad['doct_web_encyclo']?>
            </h5>
            <span class="doc_minipadding">
            <?=$trad['docd_web_encyclo']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_miniborder pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_dictionnaire';">
          <div class="align_center doc_miniborder">
            <h5 class="doc_minipadding_bot doc_miniborder_bot">
              <?=$trad['doct_web_dico']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_web_dico']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_miniborder">
          <div class="align_center doc_miniborder">
            <h5 class="doc_minipadding_bot doc_miniborder_bot">
              <?=$trad['doct_web_wip']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_web_wip']?>
            </span>
          </div>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';