<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'IRCCanaux';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Canaux IRC";

// JS
$js = array('toggle', 'dynamique', 'irc/edit_canaux');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un canal

if(isset($_POST['canal_add_go']))
{
  // Assainissement du postdata
  $canal_add_nom        = postdata_vide('canal_add_nom', 'string', '');
  $canal_add_importance = postdata_vide('canal_add_importance', 'string', '');
  $canal_add_langue     = postdata_vide('canal_add_langue', 'string', '');
  $canal_add_descfr     = postdata_vide('canal_add_descfr', 'string', '');
  $canal_add_descen     = postdata_vide('canal_add_descen', 'string', '');

  // Ajout du canal
  query(" INSERT INTO irc_canaux
          SET         irc_canaux.canal          = '$canal_add_nom'        ,
                      irc_canaux.langue         = '$canal_add_langue'     ,
                      irc_canaux.importance     = '$canal_add_importance' ,
                      irc_canaux.description_fr = '$canal_add_descfr'     ,
                      irc_canaux.description_en = '$canal_add_descen'     ");

  // Redirection
  exit(header("Location: ".$chemin."pages/irc/edit_canaux"));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un canal

if(isset($_POST['canal_edit']))
{
  // Assainissement du postdata
  $canal_edit_id          = postdata_vide('canal_edit', 'int', 0);
  $canal_edit_nom         = postdata_vide('canal_nom', 'string', '');
  $canal_edit_importance  = postdata_vide('canal_importance', 'string', '');
  $canal_edit_langue      = postdata_vide('canal_langue', 'string', '');
  $canal_edit_descfr      = postdata_vide('canal_descfr', 'string', '');
  $canal_edit_descen      = postdata_vide('canal_descen', 'string', '');

  // Mise à jour des infos du canal
  query(" UPDATE  irc_canaux
          SET     irc_canaux.canal          = '$canal_edit_nom'         ,
                  irc_canaux.langue         = '$canal_edit_langue'      ,
                  irc_canaux.importance     = '$canal_edit_importance'  ,
                  irc_canaux.description_fr = '$canal_edit_descfr'      ,
                  irc_canaux.description_en = '$canal_edit_descen'
          WHERE   irc_canaux.id             = '$canal_edit_id'          ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un canal

if(isset($_POST['canal_delete']))
{
  // Assainissement du postdata
  $canal_delete_id = postdata_vide('canal_delete', 'int', 0);

  // Suppression du canal
  query(" DELETE FROM irc_canaux
          WHERE       irc_canaux.id = '$canal_delete_id' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les canaux
$qcanaux  = query(" SELECT    irc_canaux.id             ,
                              irc_canaux.canal          ,
                              irc_canaux.langue         ,
                              irc_canaux.importance     ,
                              irc_canaux.description_fr ,
                              irc_canaux.description_en
                    FROM      irc_canaux
                    ORDER BY  irc_canaux.importance DESC  ,
                              irc_canaux.canal      ASC   ");

// Et on les prépare pour l'affichage
for($ncanaux = 0; $dcanaux = mysqli_fetch_array($qcanaux); $ncanaux++)
{
  $canal_id[$ncanaux]         = $dcanaux['id'];
  $canal_nom[$ncanaux]        = predata($dcanaux['canal']);
  $canal_importance[$ncanaux] = $dcanaux['importance'];
  $canal_langue[$ncanaux]     = predata($dcanaux['langue']);
  $canal_descfr[$ncanaux]     = predata($dcanaux['description_fr']);
  $canal_descen[$ncanaux]     = predata($dcanaux['description_en']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="tableau2">

        <h1 class="align_center">
          Canaux IRC
          <img class="pointeur" src="<?=$chemin?>img/icones/ajouter.png" alt="+" onclick="toggle_row('canal_formulaire_ajout');">
        </h1>

        <br>
        <br>

        <div class="hidden texte" id="canal_formulaire_ajout">

          <form method="POST">
            <fieldset>

              <label for="canal_add_nom">Nom du canal</label>
              <input id="canal_add_nom" name="canal_add_nom" class="indiv" type="text"><br>
              <br>

              <label for="canal_add_importance">Importance</label>
              <input id="canal_add_importance" name="canal_add_importance" class="indiv" type="text" value="0"><br>
              <br>

              <label for="canal_add_langue">Langue</label>
              <input id="canal_add_langue" name="canal_add_langue" class="indiv" type="text"><br>
              <br>

              <label for="canal_add_descfr">Description en français</label>
              <input id="canal_add_descfr" name="canal_add_descfr" class="indiv" type="text"><br>
              <br>

              <label for="canal_add_descen">Description en anglais</label>
              <input id="canal_add_descen" name="canal_add_descen" class="indiv" type="text"><br>
              <br>
              <br>

              <input type="submit" value="AJOUTER LE CANAL" name="canal_add_go"><br>
              <br>

            </fieldset>

          </form>

          <br>
          <br>

        </div>

        <table class="grid titresnoirs hiddenaltc2 nowrap">
          <thead>
            <tr>
              <th>
                CANAL
              </th>
              <th>
                IMP.
              </th>
              <th>
                LANGUE
              </th>
              <th>
                DESCRIPTION FRANCOPHONE
              </th>
              <th>
                DESCRIPTION ANGLOPHONE
              </th>
            </tr>
          </thead>
          <tbody class="align_center" id="canaux_tbody">
            <?php } ?>
            <tr class="hidden">
              <td class="hidden" colspan="5">
                LIGNE DE HEAD AU TBODY
              </td>
            </tr>
            <?php for($i=0;$i<$ncanaux;$i++) { ?>
            <tr class="pointeur" onclick="canal_formulaire_edition('<?=$chemin?>', <?=$canal_id[$i]?>);">
              <td>
                <?=$canal_nom[$i]?>
              </td>
              <td>
                <?=$canal_importance[$i]?>
              </td>
              <td>
                <?=$canal_langue[$i]?>
              </td>
              <td>
                <?=$canal_descfr[$i]?>
              </td>
              <td>
                <?=$canal_descen[$i]?>
              </td>
            </tr>
            <tr class="hidden" id="canal_ligne_<?=$canal_id[$i]?>">
              <td colspan="5" class="align_left" id="canal_container_<?=$canal_id[$i]?>">
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