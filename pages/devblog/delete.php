<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Devblog';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Supprimer un devblog";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id

// Si l'id est pas set, on dégage
if(!isset($_GET['id']))
  exit(header("Location: ".$chemin."pages/devblog/index"));

// On vérifie que le devblog existe, sinon dehors
$devblog_id     = postdata($_GET['id'], 'int');
$qcheckdevblog  = mysqli_fetch_array(query("  SELECT  devblog.id
                                              FROM    devblog
                                              WHERE   devblog.id = '$devblog_id' "));
if($qcheckdevblog['id'] == NULL)
  exit(header("Location: ".$chemin."pages/devblog/index"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression du devblog

if(isset($_POST['devblog_delete']))
{
  // On supprime le devblog
  query(" DELETE FROM devblog
          WHERE       devblog.id = '$devblog_id' ");

  // On vire l'entrée de l'activité récente
  query(" DELETE FROM activite
          WHERE       activite.action_type  = 'devblog'
          AND         activite.action_id    = '$devblog_id' ");

  // Et on redirige vers la liste des devblogs
  exit(header("Location: ".$chemin."pages/devblog/index"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher le titre du devblog
$qdevblog = mysqli_fetch_array(query("  SELECT  devblog.titre
                                        FROM    devblog
                                        WHERE   devblog.id = '$devblog_id' "));

// Et on le prépare pour l'affichage
$devblog_titre = predata($qdevblog['titre']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Supprimer un devblog</h1>

        <br>

        <h5>Confirmer la suppression définitive du devblog suivant :</h5>

        <h5 class="texte_negatif"><?=$devblog_titre?></h5>

        <br>

        <form method="POST">
          <fieldset>
            <input value="SUPPRIMER LE DEVBLOG" type="submit" name="devblog_delete" onclick="return confirm('Confirmer encore une fois la suppression du devblog');">
          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';