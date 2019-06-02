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
$qroadmap = mysqli_fetch_array(query("  SELECT    todo_roadmap.id_classement  AS 'r_idc'      ,
                                                  todo_roadmap.version_fr     AS 'r_titre_fr' ,
                                                  todo_roadmap.version_en     AS 'r_titre_en' ,
                                                  todo_roadmap.description_fr AS 'r_desc_fr'  ,
                                                  todo_roadmap.description_en AS 'r_desc_en'
                                        FROM      todo_roadmap
                                        WHERE     todo_roadmap.id = '$roadmap_id' "));

// Si l'entrée existe pas, on s'arrête là
if($qroadmap['r_idc'] === NULL)
  exit();

// Sinon, on prépare les données pour l'affichage
$roadmap_classement     = $qroadmap['r_idc'];
$roadmap_version_fr     = predata($qroadmap['r_titre_fr']);
$roadmap_version_en     = predata($qroadmap['r_titre_en']);
$roadmap_description_fr = predata($qroadmap['r_desc_fr']);
$roadmap_description_en = predata($qroadmap['r_desc_en']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<fieldset>

  <label for="roadmap_classement_<?=$roadmap_id?>">Classement</label>
  <input id="roadmap_classement_<?=$roadmap_id?>" name="roadmap_classement_<?=$roadmap_id?>" class="indiv" type="text" value="<?=$roadmap_classement?>"><br>
  <br>

  <label for="roadmap_titre_fr_<?=$roadmap_id?>">Version (français)</label>
  <input id="roadmap_titre_fr_<?=$roadmap_id?>" name="roadmap_titre_fr_<?=$roadmap_id?>" class="indiv" type="text" value="<?=$roadmap_version_fr?>"><br>
  <br>

  <label for="roadmap_titre_en_<?=$roadmap_id?>">Version (anglais)</label>
  <input id="roadmap_titre_en_<?=$roadmap_id?>" name="roadmap_titre_en_<?=$roadmap_id?>" class="indiv" type="text" value="<?=$roadmap_version_en?>"><br>
  <br>

  <label for="roadmap_desc_fr_<?=$roadmap_id?>">Description (français)</label>
  <textarea id="roadmap_desc_fr_<?=$roadmap_id?>" name="roadmap_desc_fr_<?=$roadmap_id?>" class="indiv" style="height:100px"><?=$roadmap_description_fr?></textarea><br>
  <br>

  <label for="roadmap_desc_en_<?=$roadmap_id?>">Description (anglais)</label>
  <textarea id="roadmap_desc_en_<?=$roadmap_id?>" name="roadmap_desc_en_<?=$roadmap_id?>" class="indiv" style="height:100px"><?=$roadmap_description_en?></textarea><br>
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