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
$page_nom = "Critique une image: ";
$page_url = "pages/nbdb/web_image?image=";

// Lien court
$shorturl = "wi=";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "NBDB : " : "NBDB: ";
$page_desc  = "Encyclopédie de la culture internet, des obscurs bulletin boards d'antan aux memes modernes.";

// CSS & JS
$css  = array('nbdb');
$js   = array('clipboard');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Image aléatoire

// On vérifie si on demande une image au hasard
if(isset($_GET['random']))
{
  // On va chercher une image au pif dans la liste
  $qrandomimg = mysqli_fetch_array(query("  SELECT    nbdb_web_image.nom_fichier AS 'i_nom'
                                            FROM      nbdb_web_image
                                            WHERE     nbdb_web_image.nsfw = 0
                                            ORDER BY  RAND()
                                            LIMIT     1 "));

  // On récupère le nom de cette image
  $web_image_nom = postdata($qrandomimg['i_nom']);
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Image spécifique

if(!isset($web_image_nom))
{
  // Si y'a pas d'image ni d'id précisé, on dégage
  if(!isset($_GET['image']) && !isset($_GET['id']))
    exit(header("Location: $chemin/pages/nbdb/web"));

  // Si y'a un nom spécifié, on le récupère
  if(isset($_GET['image']))
    $web_image_nom = postdata($_GET['image'], 'string', '');

  // Sinon, on doit aller chercher le nom à partir de l'id
  else
  {
    // On assainit l'id
    $image_id = postdata($_GET['id'], 'int', 0);

    // On va chercher le nom de l'image
    $qnomimage = mysqli_fetch_array(query(" SELECT  nbdb_web_image.nom_fichier AS 'i_nom'
                                            FROM    nbdb_web_image
                                            WHERE   nbdb_web_image.id = '$image_id' "));

    // Si elle existe pas, on dégage
    if(!$qnomimage['i_nom'])
      exit(header("Location: $chemin/pages/nbdb/web"));

    // Sinon, on récupère le nom de l'image
    $web_image_nom = postdata($qnomimage['i_nom']);
  }
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détails de l'image

// On va chercher les infos sur l'image
$dwebimage = mysqli_fetch_array(query(" SELECT  nbdb_web_image.id           AS 'i_id'   ,
                                                nbdb_web_image.nom_fichier  AS 'i_nom'  ,
                                                nbdb_web_image.tags         AS 'i_tags' ,
                                                nbdb_web_image.nsfw         AS 'i_nsfw'
                                        FROM    nbdb_web_image
                                        WHERE   nbdb_web_image.nom_fichier LIKE '$web_image_nom' "));

// Si y'a pas d'image à ce nom, on dégage
if(!$dwebimage['i_nom'])
  exit(header("Location: $chemin/pages/nbdb/web"));

// Mise à jour des infos de la page
$page_url   .= $dwebimage['i_nom'];
$page_nom   .= (tronquer_chaine($dwebimage['i_nom'], 25, '...'));
$page_titre .= $dwebimage['i_nom'];
$page_desc  .= ($dwebimage['i_tags']) ? " ".predata($dwebimage['i_tags']) : "";
$shorturl   .= $dwebimage['i_id'];

// Préparation des données pour l'affichage
$web_image_titre    = urldecode($dwebimage['i_nom']);
$web_image_fichier  = urlencode($dwebimage['i_nom']);
$web_image_nsfw     = ((niveau_nsfw() < 2) && $dwebimage['i_nsfw']) ? 1 : 0;
$web_image_flou     = ((niveau_nsfw() < 2) && $dwebimage['i_nsfw']) ? ' class="web_nsfw_flou"' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pages contenant l'image

// On détermine la langue dans laquelle chercher
$image_lang = changer_casse($lang, 'min');

// On prépare le nom de l'image pour la recherche
$web_image_nom_encoded = urlencode($web_image_nom);

// On va chercher dans l'encyclopédie de la culture web
$qimage_web = query(" SELECT    nbdb_web_page.titre_$image_lang AS 'w_titre'
                      FROM      nbdb_web_page
                      WHERE     MATCH(nbdb_web_page.contenu_$image_lang) AGAINST ('$web_image_nom_encoded' IN BOOLEAN MODE)
                      ORDER BY  nbdb_web_page.titre_$image_lang ASC ");

// Puis on prépare les titres pour l'affichage
for($nimage_web = 0; $dimage_web = mysqli_fetch_array($qimage_web); $nimage_web++)
  $image_web[$nimage_web] = predata($dimage_web['w_titre']);

// On va chercher dans le dictionnaire de la culture web
$qimage_dico = query("  SELECT    nbdb_web_definition.titre_$image_lang AS 'd_titre'
                        FROM      nbdb_web_definition
                        WHERE     MATCH(nbdb_web_definition.definition_$image_lang) AGAINST ('$web_image_nom_encoded' IN BOOLEAN MODE)
                        ORDER BY  nbdb_web_definition.titre_$image_lang ASC ");

// Puis on prépare les titres pour l'affichage
for($nimage_dico = 0; $dimage_dico = mysqli_fetch_array($qimage_dico); $nimage_dico++)
  $image_dico[$nimage_dico] = predata($dimage_dico['d_titre']);

// On va chercher dans les catégories des pages
$qimage_categorie = query(" SELECT    nbdb_web_categorie.id                 AS 'c_id' ,
                                      nbdb_web_categorie.titre_$image_lang  AS 'c_titre'
                            FROM      nbdb_web_categorie
                            WHERE     MATCH(nbdb_web_categorie.description_$image_lang) AGAINST ('$web_image_nom_encoded' IN BOOLEAN MODE)
                            ORDER BY  nbdb_web_categorie.titre_$image_lang ASC ");

// Puis on prépare les titres pour l'affichage
for($nimage_categorie = 0; $dimage_categorie = mysqli_fetch_array($qimage_categorie); $nimage_categorie++)
{
  $image_categorie_id[$nimage_categorie]  = $dimage_categorie['c_id'];
  $image_categorie[$nimage_categorie]     = predata($dimage_categorie['c_titre']);
}

// On va chercher dans les périodes
$qimage_periode = query(" SELECT    nbdb_web_periode.id                 AS 'p_id' ,
                                    nbdb_web_periode.titre_$image_lang  AS 'p_titre'
                          FROM      nbdb_web_periode
                          WHERE     MATCH(nbdb_web_periode.description_$image_lang) AGAINST ('$web_image_nom_encoded' IN BOOLEAN MODE)
                          ORDER BY  nbdb_web_periode.titre_$image_lang ASC ");

// Puis on prépare les titres pour l'affichage
for($nimage_periode = 0; $dimage_periode = mysqli_fetch_array($qimage_periode); $nimage_periode++)
{
  $image_periode_id[$nimage_periode]  = $dimage_periode['p_id'];
  $image_periode[$nimage_periode]     = predata($dimage_periode['p_titre']);
}

// On fait le total des comptes d'utilisation
$nimage_total = $nimage_web + $nimage_dico + $nimage_categorie + $nimage_periode;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['image_nsfw']         = <<<EOD
Cette image est floutée car elle contient du contenu vulgaire ou sensible, vous devez passer votre curseur dessus pour l'afficher. Si le floutage vous ennuie, vous pouvez le désactiver de façon permanente via les <a class="gras" href="{$chemin}pages/user/nsfw">options de vulgarité</a> de votre compte.
EOD;
  $trad['image_utilisation']  = "Cette image est utilisée sur la page suivante :";
  $trad['image_utilisations'] = "Cette image est utilisée sur les pages suivantes :";
  $trad['image_nullepart']    = "Cette image n'est utilisée sur aucune page de l'encyclopédie de la culture internet pour le moment.";
  $trad['image_categorie']    = "Catégorie :";
  $trad['image_periode']      = "Période :";

  // Footer
  $trad['image_autre']        = "Autre image au hasard";
  $trad['image_disclaimer']   = <<<EOD
Cette image est utilisée sur ce site internet dans un but encyclopédique : elle a été diffusée assez largement sur internet pour devenir une partie intégrante de la culture internet, et sert à documenter une facette de cette culture. Si vous êtes l'auteur de cette image et ne souhaitez pas qu'elle reste en ligne sur ce site, contactez moi avec une preuve que vous en êtes l'auteur par <a class="gras" href="{$chemin}pages/user/pm?user=1">message privé</a> et je supprimerai cette image au plus vite.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['image_nsfw']         = <<<EOD
This image is blurred due to its crude or sensitive content. Hover your mouse cursor over it in order to reveal its contents. If you are bothered by the blurring or have no need for it, you can permanently disable it in the <a class="gras" href="{$chemin}pages/user/nsfw">adult content options</a> of your account.
EOD;
  $trad['image_utilisation']  = "This image is used in the following page:";
  $trad['image_utilisations'] = "This image is used in the following pages:";
  $trad['image_nullepart']    = "This image hasn't been used in any page of the encyclopedia of internet culture so far.";
  $trad['image_categorie']    = "Category:";
  $trad['image_periode']      = "Era:";

  // Footer
  $trad['image_autre']        = "Other random image";
  $trad['image_disclaimer']   = <<<EOD
This image is used on this website for encyclopedic purposes : it was shared so much on the internet that it became an integral part of internet culture, and is used here to document this specific aspect of internet culture. If you are the author of this image and want it to be removed from this website, contact me with proof of authorship by <a class="gras" href="{$chemin}pages/user/pm?user=1">private message</a> and I will remove it from the website right away.
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

  <br>

  <h2 class="align_center">
    <?=$web_image_titre?>
    <?php if($est_admin) { ?>
    <a href="<?=$chemin?>pages/nbdb/web_images">
      <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/upload.svg" alt="+" height="30">
    </a>
    <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/copier.svg" alt="X" height="26" onclick="pressepapiers('[[image:<?=$web_image_nom_encoded?>]]');">
    <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/image.svg" alt="X" height="26" onclick="pressepapiers('[[galerie:<?=$web_image_nom_encoded?>]]');">
    <?php } ?>
  </h2>

  <?php if($web_image_nsfw) { ?>

  <br>

  <div class="minitexte3">

    <p><?=$trad['image_nsfw']?></p>

  </div>

  <?php } ?>

  <br>
  <br>

  <?php if($nimage_total) { ?>

  <div class="minitexte gras">

    <span>
      <?php if($nimage_total == 1) { ?>
      <?=$trad['image_utilisation']?>
      <?php } else { ?>
      <?=$trad['image_utilisations']?>
      <?php } ?>
    </span><br>

    <?php if($nimage_categorie) { ?>
    <?php for($i=0;$i<$nimage_categorie;$i++) { ?>
    - <a href="<?=$chemin?>pages/nbdb/web_pages?categorie=<?=$image_categorie_id[$i]?>"><?=$trad['image_categorie']?> <?=$image_categorie[$i]?></a><br>
    <?php } } ?>

    <?php if($nimage_periode) { ?>
    <?php for($i=0;$i<$nimage_periode;$i++) { ?>
    - <a href="<?=$chemin?>pages/nbdb/web_pages?periode=<?=$image_periode_id[$i]?>"><?=$trad['image_periode']?> <?=$image_periode[$i]?></a><br>
    <?php } } ?>

    <?php if($nimage_web) { ?>
    <?php for($i=0;$i<$nimage_web;$i++) { ?>
    - <a href="<?=$chemin?>pages/nbdb/web?page=<?=$image_web[$i]?>"><?=$image_web[$i]?></a><br>
    <?php } } ?>

    <?php if($nimage_dico) { ?>
    <?php for($i=0;$i<$nimage_dico;$i++) { ?>
    - <a href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=<?=$image_dico[$i]?>"><?=$image_dico[$i]?></a><br>
    <?php } } ?>

  </div>

  <?php } else { ?>

  <div class="minitexte gras align_center">
    <?=$trad['image_nullepart']?>
  </div>

  <?php } ?>

  <br>
  <br>
  <br>

  <div class="align_center">
    <img src="<?=$chemin?>img/nbdb_web/<?=$web_image_fichier?>"<?=$web_image_flou?>>
  </div>

  <br>
  <br>

  <div class="minitexte">

    <p class="align_center moinsgros gras">
      <a href="<?=$chemin?>pages/nbdb/web_image?random"><?=$trad['image_autre']?></a>
    </p>

    <br>

    <p style="font-size:0.72em">
      <?=$trad['image_disclaimer']?>
    </p>

  </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';