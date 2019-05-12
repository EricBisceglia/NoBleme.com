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
$header_sidemenu  = 'Roadmap';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Plans de route";

// JS
$js = array('toggle', 'dynamique', 'todo/roadmaps');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajouter un nouveau plan de route

if(isset($_POST['roadmap_add']))
{
  // On va chercher le plus haut classement actuel
  $qmaxroadmap = mysqli_fetch_array(query(" SELECT  MAX(todo_roadmap.id_classement) AS 'max_classement'
                                            FROM    todo_roadmap "));

  // Et on insère le nouveau plan de route
  $roadmap_max_id = $qmaxroadmap['max_classement'] + 1;
  query(" INSERT INTO todo_roadmap
          SET         todo_roadmap.id_classement = '$roadmap_max_id' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier un plan de route

if(isset($_POST['roadmap_edit']))
{
  // On assainit le postdata
  $roadmap_edit_id          = postdata_vide('roadmap_edit', 'int', 0);
  $roadmap_edit_classement  = postdata_vide('roadmap_classement', 'int', 0);
  $roadmap_edit_titre       = postdata_vide('roadmap_titre', 'string', '');
  $roadmap_edit_description = postdata_vide('roadmap_description', 'string', '');

  // Et on met à jour le plan de route
  query(" UPDATE  todo_roadmap
          SET     todo_roadmap.id_classement  = '$roadmap_edit_classement'  ,
                  todo_roadmap.version        = '$roadmap_edit_titre'       ,
                  todo_roadmap.description    = '$roadmap_edit_description'
          WHERE   todo_roadmap.id             = '$roadmap_edit_id' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprimer un plan de route

if(isset($_POST['roadmap_delete']))
{
  // On récupère l'id du plan de route à supprimer
  $roadmap_delete = postdata_vide('roadmap_delete', 'int', 0);

  // On met à zéro le plan de route des tâches liées
  query(" UPDATE  todo
          SET     todo.FKtodo_roadmap = 0
          WHERE   todo.FKtodo_roadmap = '$roadmap_delete' ");

  // Et on le supprime
  query(" DELETE FROM todo_roadmap
          WHERE       todo_roadmap.id = '$roadmap_delete' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la liste des plans de route
$qroadmaps = query("  SELECT    todo_roadmap.id             ,
                                todo_roadmap.id_classement  ,
                                todo_roadmap.version
                      FROM      todo_roadmap
                      ORDER BY  todo_roadmap.id_classement DESC ");

// On les prépare pour l'affichage
for($nroadmaps = 0; $droadmaps = mysqli_fetch_array($qroadmaps); $nroadmaps++)
{
  $roadmap_id[$nroadmaps]         = $droadmaps['id'];
  $roadmap_classement[$nroadmaps] = $droadmaps['id_classement'];
  $roadmap_version[$nroadmaps]    = predata($droadmaps['version']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="minitexte2">

        <h1 class="align_center">
          Plans de route
          <img class="pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" onclick="roadmap_ajouter('<?=$chemin?>');" height="30">
        </h1>


        <br>

        <table class="titresnoirs grid fullgrid hiddenaltc2">

          <thead>
            <tr class="grisclair">
              <th>
                CLASSEMENT
              </th>
              <th>
                VERSION
              </th>
            </tr>
          </thead>

          <tbody class="align_center" id="roadmaps_tbody">
            <?php } ?>

            <tr class="hidden">
              <td colspan="2">
                &nbsp;
              </td>
            </tr>

            <?php for($i=0;$i<$nroadmaps;$i++) { ?>
            <tr class="pointeur" onclick="roadmap_formulaire_edition('<?=$chemin?>', <?=$roadmap_id[$i]?>);">
              <td class="gras">
                <?=$roadmap_classement[$i]?>
              </td>
              <td>
                <?=$roadmap_version[$i]?>
              </td>
            </tr>
            <tr class="hidden" id="roadmap_edit_container_<?=$roadmap_id[$i]?>">
              <td colspan="2" class="align_left spaced" id="roadmap_edit_<?=$roadmap_id[$i]?>">
                &nbsp;
              </td>
            </tr>
            <?php } ?>

            <?php if(!getxhr()) { ?>
          </tbody>
        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }