<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
adminonly($lang);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On vérifie que l'ID et le chemin soient bien rentrés
if(!isset($_POST['categorie_id']) || !isset($_POST['chemin']))
  exit();

// Maintenant on peut les assainir
$categorie_id = postdata_vide('categorie_id', 'int', 0);
$chemin_xhr   = postdata_vide('chemin', 'string', '');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les données de la catégorie qu'on veut modifier
$qcategorie = mysqli_fetch_array(query("  SELECT    todo_categorie.categorie
                                          FROM      todo_categorie
                                          WHERE     todo_categorie.id = '$categorie_id' "));

// Si l'entrée existe pas, on s'arrête là
if($qcategorie['categorie'] === NULL)
  exit();

// Sinon, on prépare les données pour l'affichage
$categorie_nom = predata($qcategorie['categorie']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<br>

<fieldset>

  <input id="categorie_nom_<?=$categorie_id?>" name="categorie_nom_<?=$categorie_id?>" class="indiv" type="text" value="<?=$categorie_nom?>"><br>
  <br>

  <div class="align_center">
    <button onclick="categorie_modifier('<?=$chemin_xhr?>', <?=$categorie_id?>);">MODIFIER</button><br>
    <button class="button-outline" onclick="categorie_supprimer('<?=$chemin_xhr?>', <?=$categorie_id?>);">SUPPRIMER</button>
  </div>

</fieldset>