<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloWeb';

// Identification
$page_nom = "Administre la NBDB";
$page_url = "pages/nbdb/index";

// Langues disponibles
$langue_page = array('FR');

// Titre
$page_titre = "NBDB : Administration";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id de la page à supprimer

// On récupère et on assainit l'id
$web_id = postdata($_GET['id'], 'int', 0);

// Si l'id n'existe pas, on dégage
if(!verifier_existence('nbdb_web_page', $web_id))
  exit(header("Location: $chemin/pages/nbdb/web_pages"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une page

if(isset($_POST['web_delete']))
{
  // Assainissement du postdata
  $delete_web_activite  = isset($_POST['web_activite']) ? 1 : 0;
  $delete_web_irc       = isset($_POST['web_irc']) ? 1 : 0;

  // Avant de supprimer, on a potentiellement besoin d'infos sur la page pour l'activité récente et IRC
  $dweb = mysqli_fetch_array(query("  SELECT  nbdb_web_page.titre_fr  AS 'w_titre_fr'     ,
                                              nbdb_web_page.titre_en  AS 'w_titre_en'
                                      FROM    nbdb_web_page
                                      WHERE   nbdb_web_page.id = '$web_id' "));

  // On récupère les données qu'on est allé chercher
  $delete_web_titre_fr     = postdata($dweb['w_titre_fr'], 'string', '');
  $delete_web_titre_en     = postdata($dweb['w_titre_en'], 'string', '');
  $delete_web_titre_fr_raw = $dweb['w_titre_fr'];
  $delete_web_titre_en_raw = $dweb['w_titre_en'];

  // On supprime la page
  query(" DELETE FROM nbdb_web_page
          WHERE       nbdb_web_page.id = '$web_id' ");

  // Ainsi que les catégorisations de la page
  query(" DELETE FROM nbdb_web_page_categorie
          WHERE       FKnbdb_web_page = '$web_id' ");

  // Activité récente
  if($delete_web_activite)
    activite_nouveau('nbdb_web_page_delete', 0, 0, NULL, 0, $delete_web_titre_fr, $delete_web_titre_en);
  else
    activite_supprimer('nbdb_web_page_', 0, 0, NULl, $web_id, 1);

  // IRC
  if($delete_web_irc)
  {
    if($delete_web_titre_fr)
      ircbot($chemin, "Une entrée de l'encyclopédie de la culture internet a été supprimée : ".$delete_web_titre_fr_raw, "#NoBleme");
    if($delete_web_titre_en)
      ircbot($chemin, "An entry in the encyclopedia of internet culture has been deleted : ".$delete_web_titre_en_raw, "#english");
  }

  // Redirection
  exit(header("Location: $chemin/pages/nbdb/web_pages"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu de la page

// On va chercher les titres
$dweb = mysqli_fetch_array(query("  SELECT  nbdb_web_page.titre_fr  AS 'w_titre_fr' ,
                                            nbdb_web_page.titre_en  AS 'w_titre_en'
                                    FROM    nbdb_web_page
                                    WHERE   nbdb_web_page.id = '$web_id' "));

// Et on les prépare pour l'affichage
$web_titre_fr = predata($dweb['w_titre_fr']);
$web_titre_en = predata($dweb['w_titre_en']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte3">

        <h3 class="align_center">Supprimer une définition de l'encyclopédie de la culture web</h3>

        <br>
        <br>
        <br>

        <?php if($web_titre_fr) { ?>
        <h5><span class="souligne">Titre français :</span> <?=$web_titre_fr?></h5>
        <?php } ?>

        <br>

        <?php if($web_titre_en) { ?>
        <h5><span class="souligne">Titre anglais :</span> <?=$web_titre_en?></h5>
        <?php } ?>

        <br>
        <br>
        <br>

      </div>

      <div class="minitexte2">

        <form method="POST">
          <fieldset>

            <label>Actions à effectuer au moment de la suppression</label>
            <input id="web_activite" name="web_activite" type="checkbox">
            <label class="label-inline" for="web_activite">Entrée dans l'activité récente</label><br>
            <input id="web_irc" name="web_irc" type="checkbox">
            <label class="label-inline" for="web_irc">Message du bot IRC NoBleme</label><br>

            <br>
            <br>

            <input value="SUPPRIMER LA PAGE" type="submit" name="web_delete">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';
