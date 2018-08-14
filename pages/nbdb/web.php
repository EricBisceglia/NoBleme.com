<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloWeb';

// Identification
$page_nom = "Découvre la culture du web";
$page_url = "pages/nbdb/web";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = "NBDB : Culture internet";
$page_desc  = "Encyclopédie de la culture internet, des obscurs bulletin boards d'antan aux memes modernes.";

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
  $trad['titre']      = "Encyclopédie de la culture web";
  $trad['soustitre']  = "Documentation de l'histoire des memes et de la culture d'internet";
  $trad['desc']       = <<<EOD
À l'origine un monde à part, Internet s'est doucement ouvert au public jusqu'à devenir un lieu incontournable. Cette encyclopédie vise à raconter l'histoire des cultures qui se sont développées au sein d'Internet lors de son enfance, ainsi qu'à documenter les <a class="gras" href="{$chemin}pages/nbdb/web_dictionnaire?define=meme">memes</a> qui se propagent sur le web de nos jours. Elle est accompagnée d'un <a class="gras" href="{$chemin}pages/nbdb/web_dictionnaire">dictionnaire de la culture internet</a>, afin de ne pas avoir à redéfinir à chaque page de l'encyclopédie le vocabulaire propre à la culture internet.
EOD;
  $trad['desc_liste'] = <<<EOD
Vous trouverez ci-dessous la liste des contenus de cette encyclopédie, cliquez sur l'un d'entre eux pour y accéder. Je vous suggère de commencer par le premier avant de vous intéresser au reste.
EOD;

  // Liste des contenus
  $trad['doct_intro']       = "Introduction à la culture internet";
  $trad['docd_intro']       = "Vous ne savez pas par où commencer ?<br>Ça tombe bien, cette page est là exprès pour ça !";
  $trad['doct_liste']       = "Liste des pages";
  $trad['docd_liste']       = "Liste de toutes les pages que vous pouvez trouver dans cette encyclopédie, regroupées par catégorie.";
  $trad['doct_chronologie'] = "Chronologie";
  $trad['docd_chronologie'] = "Ligne chronologique vous permettant de placer les memes et évènements dans le contexte de leur époque.";
  $trad['doct_random']      = "Page au hasard";
  $trad['docd_random']      = "Vous redirigera vers un contenu choisi au hasard.";
  $trad['doct_search']      = "Recherche";
  $trad['docd_search']      = "Êtes-vous à la recherche d'un contenu spécifique ?";
  $trad['doct_activite']    = "Changements";
  $trad['docd_activite']    = "Liste des contenus crées ou modifiés récemment.";
  $trad['doct_rss']         = "Suivre l'évolution";
  $trad['docd_rss']         = "Suivre les changements de contenu par flux RSS.";
  $trad['doct_suggerer']    = "Signaler une erreur, suggérer du contenu";
  $trad['docd_suggerer']    = "Cette encyclopédie étant maintenue par une seule personne, votre aide et vos suggestions sont appréciés.";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Introduction
  $trad['titre']      = "Internet culture encyclopedia";
  $trad['soustitre']  = "Documenting the history of memes and internet culture";
  $trad['desc']       = <<<EOD
At first a quaint world of its own, the Internet slowly opened itself to the public, and has now become an unavoidable part of everyone's life. The goal of this encyclopedia is to tell the history of how Internet became what it is today, aswell as document the various <a class="gras" href="{$chemin}pages/nbdb/web_dictionnaire?define=meme">memes</a> that are being spread everywhere nowadays. It comes with a <a class="gras" href="{$chemin}pages/nbdb/web_dictionnaire">dictionary of internet culture</a>, in order to avoid having to define the same words over and over.
EOD;
  $trad['desc_liste'] = <<<EOD
Below, you will find a list of this encyclopedia's pages. Click any of them in order to access it. I would suggest beginning with the introduction to internet culture, even if you are already familiar with it.
EOD;

  // Liste des contenus
  $trad['doct_intro']       = "Introduction to internet culture";
  $trad['docd_intro']       = "You don't know where to start?<br>That's what this page is here for!";
  $trad['doct_liste']       = "List of all pages";
  $trad['docd_liste']       = "A listing of all the pages available in the encyclopedia,<br>sorted by categories for ease of use.";
  $trad['doct_chronologie'] = "Internet culture timeline";
  $trad['docd_chronologie'] = "This timeline should help you put some context on when some events and memes happened compared to others.";
  $trad['doct_random']      = "Random page";
  $trad['docd_random']      = "Redirects you towards a randomly selected page.";
  $trad['doct_search']      = "Search";
  $trad['docd_search']      = "Are you looking for some specific content?";
  $trad['doct_activite']    = "Recent changes";
  $trad['docd_activite']    = "List of recently added or edited content.";
  $trad['doct_rss']         = "Follow changes";
  $trad['docd_rss']         = "Follow new content through your RSS feed reader.";
  $trad['doct_suggerer']    = "Report a mistake, suggest new content";
  $trad['docd_suggerer']    = "This encyclopedia being the work of a single person,<br> your help is always appreciated.";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_edit">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="22">
          </a>
          <?php } ?>
        </h5>

        <p><?=$trad['desc']?></p>

        <p><?=$trad['desc_liste']?></p>

      </div>

      <br>
      <br>

      <div class="minitexte2">

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web?page=Introduction';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_intro']?>
            </h5>
            <span class="doc_minipadding">
            <?=$trad['docd_intro']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_liste';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_liste']?>
            </h5>
            <span class="doc_minipadding">
            <?=$trad['docd_liste']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_timeline';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_chronologie']?>
            </h5>
            <span class="doc_minipadding">
            <?=$trad['docd_chronologie']?>
            </span>
          </div>
        </div>

        <br>

        <div class="flexcontainer">
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web?page=random';">
              <div class="align_center doc_minibordure">
                <h5 class="doc_minipadding_bot doc_minibordure_bot">
                  <?=$trad['doct_random']?>
                </h5>
                <span class="doc_minipadding">
                <?=$trad['docd_random']?>
                </span>
              </div>
            </div>
          </div>
          <div style="flex:1;">
            &nbsp;
          </div>
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/recherche?section=web';">
              <div class="align_center doc_minibordure">
                <h5 class="doc_minipadding_bot doc_minibordure_bot">
                  <?=$trad['doct_search']?>
                </h5>
                <span class="doc_minipadding">
                <?=$trad['docd_search']?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <br>

        <div class="flexcontainer">
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/activite?section=web';">
              <div class="align_center doc_minibordure">
                <h5 class="doc_minipadding_bot doc_minibordure_bot">
                  <?=$trad['doct_activite']?>
                </h5>
                <span class="doc_minipadding">
                <?=$trad['docd_activite']?>
                </span>
              </div>
            </div>
          </div>
          <div style="flex:1;">
            &nbsp;
          </div>
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/rss?preselection=nbdb_web';">
              <div class="align_center doc_minibordure">
                <h5 class="doc_minipadding_bot doc_minibordure_bot">
                  <?=$trad['doct_rss']?>
                </h5>
                <span class="doc_minipadding">
                  <?=$trad['docd_rss']?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_contact';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_suggerer']?>
            </h5>
            <span class="doc_minipadding">
            <?=$trad['docd_suggerer']?>
            </span>
          </div>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';