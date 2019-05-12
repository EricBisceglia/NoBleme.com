<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();
sysoponly();




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// S'il manque du postdata, on dégage
if(!isset($_POST['chemin']) || !isset($_POST['id']))
  exit();

// Assainissement du postdata
$chemin_xhr = postdata_vide('chemin', 'string', $chemin);
$delete_id  = postdata_vide('id', 'int', 0);

// On va chercher si la réaction existe
$qnote = mysqli_fetch_array(query(" SELECT  ecrivains_note.id
                                    FROM    ecrivains_note
                                    WHERE   ecrivains_note.id = '$delete_id' "));

// Si elle n'existe pas, on dégage
if($qnote['id'] === NULL)
  exit();




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<br>

<form method="POST" id="supprimer_reaction_<?=$delete_id?>">
  <fieldset>

    <input type="hidden" name="supprimer_reaction_id" value="<?=$delete_id?>">

    <label for="supprimer_reaction_justification_<?=$delete_id?>" id="supprimer_reaction_justification_<?=$delete_id?>_label">Justification de la suppression de la réaction (optionnel)</label>
    <input id="supprimer_reaction_justification_<?=$delete_id?>" name="supprimer_reaction_justification_<?=$delete_id?>" class="indiv" type="text"><br>
    <br>

    <div class="align_center">
      <input type="submit" value="SUPPRIMER LA RÉACTION CI-DESSOUS" name="supprimer_reaction_go"><br>
      <br>
    </div>


  </fieldset>
</form>