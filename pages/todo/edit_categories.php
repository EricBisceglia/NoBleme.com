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
$header_sidemenu  = 'Todolist';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Catégories";

// JS
$js = array('toggle', 'dynamique', 'todo/categories');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajouter une nouvelle catégorie

if(isset($_POST['categorie_add']))
{
  // On insère une nouvelle catégorie vierge
  query(" INSERT INTO todo_categorie
          SET         todo_categorie.categorie = '-' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier une catégorie

if(isset($_POST['categorie_edit']))
{
  // On assainit le postdata
  $categorie_edit_id  = postdata_vide('categorie_edit', 'int', 0);
  $categorie_edit_nom = postdata_vide('categorie_nom', 'string', '');

  // Et on met à jour la catégorie
  query(" UPDATE  todo_categorie
          SET     todo_categorie.categorie  = '$categorie_edit_nom'
          WHERE   todo_categorie.id         = '$categorie_edit_id' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Supprimer une catogérie

if(isset($_POST['categorie_delete']))
{
  // On récupère l'id de la catégorie à supprimer
  $categorie_delete = postdata_vide('categorie_delete', 'int', 0);

  // On met à zéro la catégorie des tâches liées
  query(" UPDATE  todo
          SET     todo.FKtodo_categorie = 0
          WHERE   todo.FKtodo_categorie = '$categorie_delete' ");

  // Et on la supprime
  query(" DELETE FROM todo_categorie
          WHERE       todo_categorie.id = '$categorie_delete' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la liste des catégories
$qcategories = query("  SELECT    todo_categorie.id ,
                                  todo_categorie.categorie
                        FROM      todo_categorie
                        ORDER BY  todo_categorie.categorie ASC ");

// On les prépare pour l'affichage
for($ncategories = 0; $dcategories = mysqli_fetch_array($qcategories); $ncategories++)
{
  $categorie_id[$ncategories]   = $dcategories['id'];
  $categorie_nom[$ncategories]  = predata($dcategories['categorie']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="minitexte">

        <h1 class="align_center">
          Catégories
          <img class="pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" onclick="categorie_ajouter('<?=$chemin?>');" height="32">
        </h1>

      </div>

      <br>

      <div class="microtexte">

        <table class="titresnoirs grid fullgrid hiddenaltc2">

          <thead>
            <tr class="grisclair">
              <th>
                CATÉGORIE
              </th>
            </tr>
          </thead>

          <tbody class="align_center" id="categories_tbody">
            <?php } ?>

            <tr class="hidden">
              <td>
                &nbsp;
              </td>
            </tr>

            <?php for($i=0;$i<$ncategories;$i++) { ?>
            <tr class="pointeur" onclick="categorie_formulaire_edition('<?=$chemin?>', <?=$categorie_id[$i]?>);">
              <td class="gras">
                <?=$categorie_nom[$i]?>
              </td>
            </tr>
            <tr class="hidden" id="categorie_edit_container_<?=$categorie_id[$i]?>">
              <td class="align_left spaced" id="categorie_edit_<?=$categorie_id[$i]?>">
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