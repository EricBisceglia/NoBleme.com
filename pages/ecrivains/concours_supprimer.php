<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsConcours';

// Identification
$page_nom = "Gère les concours d'écriture";
$page_url = "pages/ecrivains/concours_liste";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Concours du coin des écrivains";
$page_desc  = "Le célèbre concours d'écriture du coin des écrivains de NoBleme.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ID du concours

// On vérifie si l'ID est bien spécifie, sinon on dégage
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  exit(header("Location: ".$chemin."pages/ecrivains/concours_liste"));

// On vérifie que le concours existe, sinon on dégage
$id_concours = postdata($_GET['id'], 'int');
if(!verifier_existence('ecrivains_concours', $id_concours))
  exit(header("Location: ".$chemin."pages/ecrivains/concours_liste"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un concours

if(isset($_POST['concours_supprimer']))
{
  // Suppression du concours
  query(" DELETE FROM ecrivains_concours
          WHERE       ecrivains_concours.id = '$id_concours' ");

  // Suppression des liens texte-concours
  query(" UPDATE  ecrivains_texte
          SET     FKecrivains_concours  = 0
          WHERE   FKecrivains_concours  = '$id_concours' ");

  // Suppression des votes
  query(" DELETE FROM ecrivains_concours_vote
          WHERE       ecrivains_concours_vote.FKecrivains_concours = '$id_concours' ");

  // Suppression de l'activité récente liée au concours
  activite_supprimer('ecrivains_concours_', 0, 0, NULL, $id_concours, 1);

  // Suppression des automatisations liées au concours
  query(" DELETE FROM automatisation
          WHERE       automatisation.action_type LIKE 'ecrivains_concours_%'
          AND         automatisation.action_id      = '$id_concours' ");

  // Redirection
  exit(header("Location: ".$chemin."pages/ecrivains/concours?id=".$concours_new_id));
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Titre du concours

// On va chercher le titre du concours
$dconcours = mysqli_fetch_array(query(" SELECT  ecrivains_concours.titre AS 'e_titre'
                                        FROM    ecrivains_concours
                                        WHERE   ecrivains_concours.id = '$id_concours' "));

// Et on le prépare pour l'affichage
$concours_titre = predata($dconcours['e_titre']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

      <br>
      <br>

      <h3>SUPPRESSION D'UN CONCOURS D'ÉCRITURE</h3>

      <br>
      <br>
      <br>

      <h5>
        Confirmer la suppression définitive du concours :<br>
        <span class="texte_negatif"><?=$concours_titre?></span>
      </h5>

      <br>
      <br>
      <br>

      <form method="POST">
        <fieldset>
          <input value="SUPPRIMER LE CONCOURS" type="submit" name="concours_supprimer" onclick="return confirm('Confirmer encore une fois la suppression du concours');">
        </fieldset>
      </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';