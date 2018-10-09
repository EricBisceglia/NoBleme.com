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

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "NBDB : " : "NBDB: ";
$page_desc  = "Encyclopédie de la culture internet, des obscurs bulletin boards d'antan aux memes modernes.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détails de l'image

// Si y'a pas d'image, on dégage
if(!isset($_GET['image']))
  exit(header("Location: $chemin/pages/nbdb/web"));

// On récupère le nom de l'image
$web_image_nom = postdata($_GET['image'], 'string', '');

// On va chercher les infos sur l'image
$dwebimage = mysqli_fetch_array(query(" SELECT  nbdb_web_image.nom_fichier  AS 'i_nom' ,
                                                nbdb_web_image.tags         AS 'i_tags'
                                        FROM    nbdb_web_image
                                        WHERE   nbdb_web_image.nom_fichier LIKE '$web_image_nom' "));

// Si y'a pas d'image à ce nom, on dégage
if(!$dwebimage['i_nom'])
  exit(header("Location: $chemin/pages/nbdb/web"));

// Mise à jour des infos de la page
$page_url   .= $dwebimage['i_nom'];
$page_titre .= $dwebimage['i_nom'];
$page_desc  .= ($dwebimage['i_tags']) ? " ".predata($dwebimage['i_tags']) : "";

// Préparation des données pour l'affichage
$web_image_fichier = urlencode($dwebimage['i_nom']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

  <br>
  <br>

  <div class="align_center">
    <img src="<?=$chemin?>img/nbdb_web/<?=$web_image_fichier?>">
  </div>

  <br>
  <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';