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
$header_sidemenu  = 'NBDBDicoWeb';

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
// Récupération de l'id de l'entrée à supprimer

// On récupère et on assainit l'id
$dico_id = postdata($_GET['id'], 'int', 0);

// Si l'id n'existe pas, on dégage
if(!verifier_existence('nbdb_web_definition', $dico_id))
  exit(header("Location: $chemin/pages/nbdb/web_dictionnaire"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une définition

if(isset($_POST['web_dico_delete']))
{
  // Assainissement du postdata
  $delete_dico_activite = isset($_POST['web_dico_activite']) ? 1 : 0;
  $delete_dico_irc      = isset($_POST['web_dico_irc']) ? 1 : 0;

  // Avant de supprimer, on a potentiellement besoin d'infos sur l'entrée pour l'activité récente et IRC
  $ddico = mysqli_fetch_array(query(" SELECT  nbdb_web_definition.titre_fr  AS 'd_titre_fr'     ,
                                              nbdb_web_definition.titre_en  AS 'd_titre_en'
                                      FROM    nbdb_web_definition
                                      WHERE   nbdb_web_definition.id = '$dico_id' "));

  // On récupère les données qu'on est allé chercher
  $delete_dico_titre_fr     = postdata($ddico['d_titre_fr'], 'string', '');
  $delete_dico_titre_en     = postdata($ddico['d_titre_en'], 'string', '');
  $delete_dico_titre_fr_raw = $ddico['d_titre_fr'];
  $delete_dico_titre_en_raw = $ddico['d_titre_en'];

  // On supprime l'entrée
  query(" DELETE FROM nbdb_web_definition
          WHERE       nbdb_web_definition.id = '$dico_id' ");

  // Activité récente
  if($delete_dico_activite)
    activite_nouveau('nbdb_web_definition_delete', 0, 0, NULL, 0, $delete_dico_titre_fr, $delete_dico_titre_en);
  else
    activite_supprimer('nbdb_web_definition_', 0, 0, NULl, $dico_id, 1);

  // IRC
  if($delete_dico_irc)
  {
    if($delete_dico_titre_fr)
      ircbot($chemin, "Une entrée du dictionnaire de la culture internet a été supprimée : ".$delete_dico_titre_fr_raw, "#NoBleme");
    if($delete_dico_titre_en)
      ircbot($chemin, "An entry in the dictionary of internet culture has been deleted : ".$delete_dico_titre_en_raw, "#english");
  }

  // Redirection
  exit(header("Location: $chemin/pages/nbdb/web_dictionnaire"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu de la page

// On va chercher les titres
$ddico = mysqli_fetch_array(query(" SELECT  nbdb_web_definition.titre_fr  AS 'd_titre_fr'     ,
                                            nbdb_web_definition.titre_en  AS 'd_titre_en'
                                    FROM    nbdb_web_definition
                                    WHERE   nbdb_web_definition.id = '$dico_id' "));

// Et on les prépare pour l'affichage
$dico_titre_fr    = predata($ddico['d_titre_fr']);
$dico_titre_en    = predata($ddico['d_titre_en']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte3">

        <h3 class="align_center">Supprimer une définition du dictionnaire de la culture web</h3>

        <br>
        <br>
        <br>

        <?php if($dico_titre_fr) { ?>
        <h5><span class="souligne">Titre français :</span> <?=$dico_titre_fr?></h5>
        <?php } ?>

        <br>

        <?php if($dico_titre_en) { ?>
        <h5><span class="souligne">Titre anglais :</span> <?=$dico_titre_en?></h5>
        <?php } ?>

        <br>
        <br>
        <br>

      </div>

      <div class="minitexte2">

        <form method="POST">
          <fieldset>

            <label>Actions à effectuer au moment de la suppression</label>
            <input id="web_dico_activite" name="web_dico_activite" type="checkbox">
            <label class="label-inline" for="web_dico_activite">Entrée dans l'activité récente</label><br>
            <input id="web_dico_irc" name="web_dico_irc" type="checkbox">
            <label class="label-inline" for="web_dico_irc">Message du bot IRC NoBleme</label><br>

            <br>
            <br>

            <input value="SUPPRIMER LA DÉFINITION" type="submit" name="web_dico_delete">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';
