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
if(!isset($_POST['canal_id']) || !isset($_POST['chemin']))
  exit();

// Maintenant on peut les assainir
$canal_id   = postdata_vide('canal_id', 'int', 0);
$chemin_xhr = postdata_vide('chemin', 'string', '');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les données du canal qu'on veut modifier
$qcanal = mysqli_fetch_array(query("  SELECT    irc_canaux.canal          ,
                                                irc_canaux.langue         ,
                                                irc_canaux.importance     ,
                                                irc_canaux.description_fr ,
                                                irc_canaux.description_en
                                      FROM      irc_canaux
                                      WHERE     irc_canaux.id = '$canal_id' "));

// Si l'entrée existe pas, on s'arrête là
if($qcanal['importance'] === NULL)
  exit();

// Sinon, on prépare les données pour l'affichage
$canal_nom        = predata($qcanal['canal']);
$canal_importance = predata($qcanal['importance']);
$canal_langue     = predata($qcanal['langue']);
$canal_descfr     = predata($qcanal['description_fr']);
$canal_descen     = predata($qcanal['description_en']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<br>

<div class="texte">

  <fieldset>

    <label for="canal_nom_<?=$canal_id?>">Nom du canal</label>
    <input id="canal_nom_<?=$canal_id?>" name="canal_nom_<?=$canal_id?>" class="indiv" type="text" value="<?=$canal_nom?>"><br>
    <br>

    <label for="canal_importance_<?=$canal_id?>">Importance (0 : mineur ; 1 à 10 : automatisé ; 11+ : majeur)</label>
    <input id="canal_importance_<?=$canal_id?>" name="canal_importance_<?=$canal_id?>" class="indiv" type="text" value="<?=$canal_importance?>"><br>
    <br>

    <label for="canal_langue_<?=$canal_id?>">Langue</label>
    <input id="canal_langue_<?=$canal_id?>" name="canal_langue_<?=$canal_id?>" class="indiv" type="text" value="<?=$canal_langue?>"><br>
    <br>

    <label for="canal_descfr_<?=$canal_id?>">Description en français</label>
    <input id="canal_descfr_<?=$canal_id?>" name="canal_descfr_<?=$canal_id?>" class="indiv" type="text" value="<?=$canal_descfr?>"><br>
    <br>

    <label for="canal_descen_<?=$canal_id?>">Description en anglais</label>
    <input id="canal_descen_<?=$canal_id?>" name="canal_descen_<?=$canal_id?>" class="indiv" type="text" value="<?=$canal_descen?>"><br>
    <br>
    <br>

    <div class="flexcontainer align_center">
      <div style="flex:1">
        <button onclick="canal_modifier('<?=$chemin_xhr?>', <?=$canal_id?>);">MODIFIER</button>
      </div>
      <div style="flex:1">
        <button class="button-outline" onclick="canal_supprimer('<?=$chemin_xhr?>', <?=$canal_id?>);">SUPPRIMER</button>
      </div>
      <div style="flex:2">
        <button class="button-clear" onclick="toggle_row('canal_ligne_<?=$canal_id?>', 1)">MASQUER LE FORMULAIRE D'ÉDITION</button>
      </div>
    </div>

  </fieldset>

</div>

<br>