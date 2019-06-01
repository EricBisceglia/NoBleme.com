<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbdb.inc.php';     // Fonctions lées à la NBDB

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloWeb';

// Identification
$page_nom = "Découvre la culture du web";
$page_url = "pages/nbdb/web";

// Lien court
$shorturl = "w";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "NBDB : Culture internet" : "NBDB: Internet culture";
$page_desc  = "Encyclopédie de la culture internet, des obscurs bulletin boards d'antan aux memes modernes.";

// CSS & JS
$css  = array('doc', 'nbdb');
$js   = array('highlight');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id (ou de l'absence d'id) de la page

// On récupère le titre ou l'id s'il y en a un de spécifié
$web_titre = (isset($_GET['page'])) ? postdata($_GET['page'], 'string') : '';
$web_id    = (isset($_GET['id']))   ? predata($_GET['id'], 'int', 0)      : 0;

// Si c'est une page aléatoire, on va choper un ID au pif
if(isset($_GET['random']))
{
  // Selon la langue, on fait une requête différente
  $header_sidemenu  = 'NBDBEncycloRand';
  $web_lang         = changer_casse($lang, 'min');
  $dwebrandom       = mysqli_fetch_array(query("  SELECT    nbdb_web_page.id AS 'w_id'
                                            FROM      nbdb_web_page
                                            WHERE     nbdb_web_page.titre_$web_lang    NOT LIKE ''
                                            AND       nbdb_web_page.redirection_$web_lang  LIKE ''
                                            AND       nbdb_web_page.est_vulgaire              = 0
                                            ORDER BY  RAND()
                                            LIMIT     1 "));
  $web_id           = $dwebrandom['w_id'];
}

// On va chercher si l'entrée existe
if($web_titre && !$web_id)
{
  // Selon la langue, on fait une requête différente
  $web_lang   = changer_casse($lang, 'min');
  $dcheckweb  = mysqli_fetch_array(query("  SELECT  nbdb_web_page.id AS 'w_id'
                                            FROM    nbdb_web_page
                                            WHERE   nbdb_web_page.titre_$web_lang  LIKE '$web_titre' "));

  // Si la page existe, on récupère son id
  $web_id     = ($dcheckweb['w_id']) ? $dcheckweb['w_id'] : 0;

  // Sinon, on redirige vers la liste des pages
  if(!$web_id)
    exit(header("Location: ".$chemin."pages/nbdb/web_pages"));
}
// Sinon, on lui met l'id 0
else if(!$web_id)
  $web_id = 0;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu d'une page

// On ne peut aller la chercher que si une page spécifique est choisie
if($web_id)
{
  // On spécifique la langue à utiliser
  $web_lang       = changer_casse($lang, 'min');
  $web_autrelang  = ($web_lang == 'fr') ? 'en' : 'fr';

  // On va chercher l'entrée
  $dweb = mysqli_fetch_array(query("  SELECT    nbdb_web_page.redirection_$web_lang       AS 'w_redirect'         ,
                                                nbdb_web_page.titre_$web_lang             AS 'w_titre'            ,
                                                nbdb_web_page.contenu_$web_lang           AS 'w_contenu'          ,
                                                nbdb_web_page.titre_$web_autrelang        AS 'w_titre_autre'      ,
                                                nbdb_web_page.redirection_$web_autrelang  AS 'w_redirect_autre'   ,
                                                nbdb_web_page.annee_apparition            AS 'w_apparition_y'     ,
                                                nbdb_web_page.mois_apparition             AS 'w_apparition_m'     ,
                                                nbdb_web_page.annee_popularisation        AS 'w_popularisation_y' ,
                                                nbdb_web_page.mois_popularisation         AS 'w_popularisation_m' ,
                                                nbdb_web_page.contenu_floute              AS 'w_floute'           ,
                                                nbdb_web_page.est_vulgaire                AS 'w_vulgaire'         ,
                                                nbdb_web_page.est_politise                AS 'w_politise'         ,
                                                nbdb_web_page.est_incorrect               AS 'w_incorrect'        ,
                                                nbdb_web_periode.id                       AS 'p_id'               ,
                                                nbdb_web_periode.titre_$web_lang          AS 'p_nom'
                                      FROM      nbdb_web_page
                                      LEFT JOIN nbdb_web_periode ON nbdb_web_page.FKnbdb_web_periode = nbdb_web_periode.id
                                      WHERE     nbdb_web_page.id = '$web_id' "));

  // Si c'est une redirection, on redirige vers la bonne page
  if($dweb['w_redirect'] && $dweb['w_redirect'] != $dweb['w_titre'] && !$est_admin)
    exit(header("Location: ".$chemin."pages/nbdb/web?page=".urlencode($dweb['w_redirect'])));

  // S'il n'y a pas de page dans notre langue, on dégage
  if(!$dweb['w_titre'])
    exit(header("Location: ".$chemin."pages/nbdb/web_pages"));

  // Puis on prépare le contenu de la page pour l'affichage
  $web_redirect         = ($dweb['w_redirect']) ? predata($dweb['w_redirect']) : '';
  $web_redirect_url     = ($dweb['w_redirect']) ? urlencode($dweb['w_redirect']) : '';
  $web_titre            = predata($dweb['w_titre']);
  $web_contenu          = nbdbcode(bbcode(predata($dweb['w_contenu'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang));
  $web_floute           = (niveau_nsfw() < 2 && $dweb['w_floute']) ? 1 : 0;
  $web_vulgaire         = $dweb['w_vulgaire'];
  $web_politise         = $dweb['w_politise'];
  $web_incorrect        = $dweb['w_incorrect'];
  $temp_moisfr          = ($dweb['w_apparition_m']) ? $moisfr[$dweb['w_apparition_m']] : '';
  $temp_apparition      = ($lang == 'FR') ? $temp_moisfr : date('F', strtotime('2018-'.$dweb['w_apparition_m'].'-01'));
  $web_apparition_m     = ($dweb['w_apparition_m']) ? $temp_apparition.' ' : '';
  $web_apparition_y     = $dweb['w_apparition_y'];
  $temp_moisfr          = ($dweb['w_popularisation_m']) ? $moisfr[$dweb['w_popularisation_m']] : '';
  $temp_popularisation  = ($lang == 'FR') ? $temp_moisfr : date('F', strtotime('2018-'.$dweb['w_popularisation_m'].'-01'));
  $web_popularisation_m = ($dweb['w_popularisation_m']) ? $temp_popularisation.' ' : '';
  $web_popularisation_y = $dweb['w_popularisation_y'];
  $web_periode_id       = $dweb['p_id'];
  $web_periode          = ($dweb['p_nom']) ? predata($dweb['p_nom']) : '';
  $web_bilingue         = ($dweb['w_titre_autre'] && !$dweb['w_redirect_autre']) ? 1 : 0;

  // On a besoin de la liste des catégories liées à la page
  $qcategories = query("  SELECT    nbdb_web_categorie.id               AS 'c_id' ,
                                    nbdb_web_categorie.titre_$web_lang  AS 'c_nom'
                          FROM      nbdb_web_page_categorie
                          LEFT JOIN nbdb_web_categorie ON nbdb_web_page_categorie.FKnbdb_web_categorie = nbdb_web_categorie.id
                          WHERE     nbdb_web_page_categorie.FKnbdb_web_page = '$web_id'
                          ORDER BY  nbdb_web_categorie.ordre_affichage ASC ");

  // Maintenant on peut préparer les catégories pour l'affichage
  $web_categories = '';
  for($ncategories = 0 ; $dcategories = mysqli_fetch_array($qcategories) ; $ncategories++)
    $web_categories .= '<a href="'.$chemin.'pages/nbdb/web_pages?categorie='.$dcategories['c_id'].'">'.predata($dcategories['c_nom']).'</a> ; ';
  $web_categories = ($ncategories) ? substr($web_categories, 0, -2) : '';

  // Et on oublie pas de modifier les infos de la page
  $page_nom   = 'Découvre ce qu\'est '.predata(tronquer_chaine($dweb['w_titre'], 20, '...'));
  $page_url   = "pages/nbdb/web?page=".urlencode($dweb['w_titre']);
  $shorturl  .= "=".$web_id;
  $page_titre = "NBDB : ".predata($dweb['w_titre']);
  $page_desc  = predata($dweb['w_titre']).", c'est quoi ça ? Encyclopédie de la culture internet.";
}




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
  $trad['doct_rss']         = "Suivre l'évolution";
  $trad['docd_rss']         = "Suivre les changements de contenu par flux RSS.";
  $trad['doct_suggerer']    = "Signaler une erreur, suggérer du contenu";
  $trad['docd_suggerer']    = "Cette encyclopédie étant maintenue par une seule personne, votre aide et vos suggestions sont appréciés.";

  // Contenu du dictionnaire du web
  $trad['web_colon']        = ' :';
  $trad['web_autre']        = "Autre page au hasard";
  $trad['web_bilingue']     = "This page is available in english aswell";
  $trad['web_bilingue_2']   = "Cette page est disponible en anglais également";
  $trad['web_floutage']     = <<<EOD
Certains contenus de cette page sont floutés car ils sont de nature vulgaire ou sensible. Pour les afficher en clair, vous devez passer votre curseur dessus. Si le floutage vous ennuie, vous pouvez le désactiver de façon permanente via les <a class="gras" href="{$chemin}pages/user/nsfw">options de vulgarité</a> de votre compte.
EOD;
  $trad['web_vulgaire']     = "LA PAGE CI-DESSOUS CONTIENT DU CONTENU VULGAIRE OU DÉGUEULASSE";
  $trad['web_politise']     = "La page ci-dessous est politisée : elle aborde un sujet de société d'une façon avec laquelle tout le monde ne sera pas forcément d'accord. Le but de cette encyclopédie n'est pas de plaire à tous, mais plutôt de présenter des faits de façon objective, quitte à froisser certaines opinions.";
  $trad['web_incorrect']    = "Le but de cette encyclopédie est de documenter toute la culture internet, même dans ses aspects offensants. La page ci-dessous porte sur un sujet politiquement incorrect : il est très fortement conseillé de ne pas utiliser ce terme publiquement, car il a de mauvaises connotations.";

  // Contenu d'une page spécifique
  $trad['web_apparition']   = "Première apparition :";
  $trad['web_popular']      = "Pic de popularité :";
  $trad['web_categorie']    = "Catégorie :";
  $trad['web_categories']   = "Catégories :";
  $trad['web_periode']      = "Période :";
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
  $trad['doct_rss']         = "Follow changes";
  $trad['docd_rss']         = "Follow new content through your RSS feed reader.";
  $trad['doct_suggerer']    = "Report a mistake, suggest new content";
  $trad['docd_suggerer']    = "This encyclopedia being the work of a single person,<br> your help is always appreciated.";

  // Contenu du dictionnaire du web
  $trad['web_colon']        = ':';
  $trad['web_autre']        = "Another random page";
  $trad['web_bilingue']     = "This page is available in french aswell";
  $trad['web_bilingue_2']   = "Cette page est disponible en français également";
  $trad['web_floutage']     = <<<EOD
Some contents on this page are blurred due to their crude or sensitive nature. Hover your mouse cursor over them in order to reveal their contents. If you are bothered by the blurring or have no need for it, you can permanently disable it in the <a class="gras" href="{$chemin}pages/user/nsfw">adult content options</a> of your account.
EOD;
  $trad['web_vulgaire']     = "THE FOLLOWING PAGE CONTAINS NASTY AND/OR GROSS CONTENT";
  $trad['web_politise']     = "The following page is politically loaded: it concerns an aspect of society on which people tend to have disagreements. The goal of this encyclopedia is not to paint a skewed view of society, but rather to try to bring facts objectively, even if it means displeasing some crowds.";
  $trad['web_incorrect']    = "This encyclopedia's goal is to document internet culture as a whole, including its offensive and irrespectful aspects. The following page concerns a politically incorrect topic: it is heavily suggested that you do not use it publicly, as it has extremely negative connotations.";

  // Contenu d'une page spécifique
  $trad['web_apparition']   = "First appearance:";
  $trad['web_popular']      = "Peak popularity:";
  $trad['web_categorie']    = "Categorie :";
  $trad['web_categories']   = "Categories :";
  $trad['web_periode']      = "Era :";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Index de l'encyclopédie du web
      if(!$web_id) { ?>

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
          <a href="<?=$chemin?>pages/nbdb/web_images">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/upload.svg" alt="+" height="22">
          </a>
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

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_pages';">
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

        <!--
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
        -->

        <div class="flexcontainer">
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web?random';">
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

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/user/pm?user=1';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_suggerer']?>
            </h5>
            <span class="doc_minipadding">
            <?=$trad['docd_suggerer']?>
            </span>
          </div>
        </div>

        <?php if($est_admin) { ?>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_images';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              Administration : Images
            </h5>
            <span class="doc_minipadding">
              Liste des images et des lieux où elles sont utilisées
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_notes_admin';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              Administration : Notes privées
            </h5>
            <span class="doc_minipadding">
              Notes privées globales et liées aux pages individuelles
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nbdb/web_missing';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              Administration : Pages manquantes
            </h5>
            <span class="doc_minipadding">
              Liste des pages liées mais non existantes dans l'encyclopédie du web et le dictionnaire du web
            </span>
          </div>
        </div>

        <?php } ?>

      </div>




      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Redirection vers une autre page
      } else if($web_redirect && $est_admin) { ?>

      <div class="texte">

        <h1>
          <a href="<?=$chemin?>pages/nbdb/web">
            <?=$trad['titre']?>
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_edit?id=<?=$web_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="22">
          </a>
          <a href="<?=$chemin?>pages/nbdb/web_delete?id=<?=$web_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="22">
          </a>
          <?php } ?>
        </h5>

        <br>
        <br>

        <p class="alinea gros texte_noir">
          <a href="<?=$chemin?>pages/nbdb/web?page=<?=$web_redirect_url?>">
            Redirection automatique vers : <span class="souligne"><?=$web_redirect?></span>
          </a>
        </p>

      </div>




      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Page spécifique du dictionnaire du web
      } else { ?>

      <div class="texte">

        <h1>
          <a href="<?=$chemin?>pages/nbdb/web">
            <?=$trad['titre']?>
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_edit?id=<?=$web_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="22">
          </a>
          <a href="<?=$chemin?>pages/nbdb/web_delete?id=<?=$web_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="22">
          </a>
          <?php } ?>
        </h5>

        <?php if($web_floute) { ?>

        <p><?=$trad['web_floutage']?></p>

        <?php } ?>

        <br>
        <br>

        <?php if($web_vulgaire) { ?>

        <div class="flexcontainer web_dico_alerte_conteneur">
          <div style="flex:1" class="align_center">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="70">
          </div>
          <div style="flex:5" class="align_center gros gras texte_noir">
            <?=$trad['web_vulgaire']?>
          </div>
          <div style="flex:1" class="align_center">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="70">
          </div>
        </div>
        <br>
        <br>

        <?php } if($web_politise) { ?>

        <div class="flexcontainer web_dico_alerte_conteneur">
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
          <div style="flex:5" class="gras texte_noir">
            <?=$trad['web_politise']?>
          </div>
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
        </div>
        <br>
        <br>

        <?php } if($web_incorrect) { ?>

        <div class="flexcontainer web_dico_alerte_conteneur">
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
          <div style="flex:5" class="gras texte_noir">
            <?=$trad['web_incorrect']?>
          </div>
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
        </div>
        <br>
        <br>

        <?php } ?>

        <br>

        <h3 class="alinea texte_noir">
          <?=$web_titre?><?=$trad['web_colon']?>
        </h3>

        <p class="alinea">
          <?php if($web_apparition_y) { ?>
          <span class="gras"><?=$trad['web_apparition']?></span> <?=$web_apparition_m?><?=$web_apparition_y?><br>
          <?php } if ($web_popularisation_y) { ?>
          <span class="gras"><?=$trad['web_popular']?></span> <?=$web_popularisation_m?><?=$web_popularisation_y?><br>
          <?php } if($web_periode) { ?>
          <span class="gras"><?=$trad['web_periode']?></span> <a href="<?=$chemin?>pages/nbdb/web_pages?periode=<?=$web_periode_id?>"><?=$web_periode?></a><br>
          <?php } if ($web_categories && $ncategories == 1) { ?>
          <span class="gras"><?=$trad['web_categorie']?></span> <?=$web_categories?>
          <?php } else if ($web_categories) { ?>
          <span class="gras"><?=$trad['web_categories']?></span> <?=$web_categories?>
          <?php } ?>
        </p>

        <br>
        <br>

        <div class="align_justify">
          <?=$web_contenu?>
        </div>

        <br>

        <p class="align_center">

          <span class="moinsgros gras">
            <a href="<?=$chemin?>pages/nbdb/web?random">
              <?=$trad['web_autre']?>
            </a>
          </span>

          <?php if($web_bilingue) { ?>

          <br>
          <span class="pluspetit">
            <a href="<?=$chemin?>pages/nbdb/web?id=<?=$web_id?>&amp;changelang">
            <?=$trad['web_bilingue']?><br>
            <?=$trad['web_bilingue_2']?></a>
          </span>

          <?php } ?>

        </p>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';