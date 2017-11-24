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
if(!isset($_POST['roadmap_id']) || !isset($_POST['chemin']))
  exit();

// Maintenant on peut les assainir
$roadmap_id = postdata_vide('roadmap_id', 'int', 0);
$chemin_xhr = postdata_vide('chemin', 'string', '');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les données du roadmap qu'on veut modifier
$qroadmap = mysqli_fetch_array(query("  SELECT    todo_roadmap.id_classement  ,
                                                  todo_roadmap.version        ,
                                                  todo_roadmap.description
                                        FROM      todo_roadmap
                                        WHERE     todo_roadmap.id = '$roadmap_id' "));

// Si l'entrée existe pas, on s'arrête là
if($qroadmap['id_classement'] === NULL)
  exit();

// Sinon, on prépare les données pour l'affichage
$roadmap_classement   = $qroadmap['id_classement'];
$roadmap_version      = predata($qroadmap['version']);
$roadmap_description  = predata($qroadmap['description']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<fieldset>

  <label for="roadmap_classement_<?=$roadmap_id?>">Classement</label>
  <input id="roadmap_classement_<?=$roadmap_id?>" name="roadmap_classement_<?=$roadmap_id?>" class="indiv" type="text" value="<?=$roadmap_classement?>"><br>
  <br>

  <label for="roadmap_titre_<?=$roadmap_id?>">Nom de la version</label>
  <input id="roadmap_titre_<?=$roadmap_id?>" name="roadmap_titre_<?=$roadmap_id?>" class="indiv" type="text" value="<?=$roadmap_version?>"><br>
  <br>

  <label for="roadmap_description_<?=$roadmap_id?>">Description (optionnel)</label>
  <textarea id="roadmap_description_<?=$roadmap_id?>" name="roadmap_description_<?=$roadmap_id?>" class="indiv" style="height:100px"><?=$roadmap_description?></textarea><br>
  <br>

  <div class="flexcontainer align_center">
    <div style="flex:1">
      <button onclick="roadmap_modifier('<?=$chemin_xhr?>', <?=$roadmap_id?>);">MODIFIER</button>
    </div>
    <div style="flex:1">
      <button class="button-outline" onclick="roadmap_supprimer('<?=$chemin_xhr?>', <?=$roadmap_id?>);">SUPPRIMER</button>
    </div>
  </div>
  <br>

</fieldset>