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
$qcategorie = mysqli_fetch_array(query("  SELECT    todo_categorie.titre_fr AS 'c_titre_fr' ,
                                                    todo_categorie.titre_en AS 'c_titre_en'
                                          FROM      todo_categorie
                                          WHERE     todo_categorie.id = '$categorie_id' "));

// Si l'entrée existe pas, on s'arrête là
if($qcategorie['c_titre_fr'] === NULL)
  exit();

// Sinon, on prépare les données pour l'affichage
$categorie_titre_fr = predata($qcategorie['c_titre_fr']);
$categorie_titre_en = predata($qcategorie['c_titre_en']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<br>

<fieldset>

  <label for="categorie_titre_fr_<?=$categorie_id?>">Titre français :</label>
  <input id="categorie_titre_fr_<?=$categorie_id?>" name="categorie_titre_fr_<?=$categorie_id?>" class="indiv" type="text" value="<?=$categorie_titre_fr?>"><br>
  <br>

  <label for="categorie_titre_en_<?=$categorie_id?>">Titre anglais :</label>
  <input id="categorie_titre_en_<?=$categorie_id?>" name="categorie_titre_en_<?=$categorie_id?>" class="indiv" type="text" value="<?=$categorie_titre_en?>"><br>
  <br>

  <div class="align_center">
    <button onclick="categorie_modifier('<?=$chemin_xhr?>', <?=$categorie_id?>);">MODIFIER</button>
    &nbsp;
    <button class="button-outline" onclick="categorie_supprimer('<?=$chemin_xhr?>', <?=$categorie_id?>);">SUPPRIMER</button>
  </div>

</fieldset>