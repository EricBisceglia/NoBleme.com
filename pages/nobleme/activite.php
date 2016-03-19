<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Activité récente";
$page_desc  = "Recensement de l'activité récente sur toutes les pages du site";

// Identification
$page_nom = "nobleme";
$page_id  = "activite";

// CSS & JS
$css  = array('general');
$js   = array('toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on a affaire à une page mod only, on fout les users à la porte et on change le titre

if(isset($_GET['mod']))
{
  sysoponly();
  $page_titre = "Logs de modération";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression de logs

if(isset($_POST['secretAdmin']) && getadmin())
{
  $id_del = postdata($_POST['secretAdmin']);
  query(" DELETE FROM activite      WHERE activite.id               = '$id_del' ");
  query(" DELETE FROM activite_diff WHERE activite_diff.FKactivite  = '$id_del' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On laisse activite.inc.php faire le travail préparatoire

include './../../inc/activite.inc.php';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation du dropdown de sélection du nombre de logs à voir

if(!isset($activite_limit))
{
  $select_activite_limit = '<select name="activite_num" class="moinsgros nobleme_fonce texte_blanc gras align_center discret activite_limit" onChange="document.getElementById(\'activite\').submit();">
                              <option value="100" selected>100</option>
                              <option value="200">200</option>
                              <option value="500">500</option>
                              <option value="1000">1000</option>
                            </select> ';
}
else
{
  $select_activite_limit = '<select name="activite_num" class="moinsgros nobleme_fonce texte_blanc gras align_center discret activite_limit" onChange="document.getElementById(\'activite\').submit();">';
  if($activite_limit == 100)
    $select_activite_limit .= '<option value="100" selected>100</option>';
  else
    $select_activite_limit .= '<option value="100">100</option>';
  if($activite_limit == 200)
    $select_activite_limit .= '<option value="200" selected>200</option>';
  else
    $select_activite_limit .= '<option value="200">200</option>';
  if($activite_limit == 500)
    $select_activite_limit .= '<option value="500" selected>500</option>';
  else
    $select_activite_limit .= '<option value="500">500</option>';
  if($activite_limit == 1000)
    $select_activite_limit .= '<option value="1000" selected>1000</option>';
  else
    $select_activite_limit .= '<option value="1000">1000</option>';
  $select_activite_limit .= '</select> ';
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation des options du dropdown de filtrage par action

if(!isset($activite_action))
{
  $options_activite_action = '<option value="">Toutes les actions</option>
                              <option value="user">Activité des membres</option>
                              <option value="devblog">Blog de développement</option>
                              <option value="forum">Forum de discussion</option>
                              <option value="todo">Liste des tâches</option>
                              <option value="irl">Rencontres IRL</option>
                              <option value="version">Versions de NoBleme</option>';
}
else
{
  $options_activite_action = '';
  if($activite_action == "")
    $options_activite_action .= '<option value="" selected>Toutes les actions</option>';
  else
    $options_activite_action .= '<option value="">Toutes les actions</option>';
  if($activite_action == "user")
    $options_activite_action .= '<option value="user" selected>Activité des membres</option>';
  else
    $options_activite_action .= '<option value="user">Activité des membres</option>';
  if($activite_action == "devblog")
    $options_activite_action .= '<option value="devblog" selected>Blog de développement</option>';
  else
    $options_activite_action .= '<option value="devblog">Blog de développement</option>';
  if($activite_action == "forum")
    $options_activite_action .= '<option value="forum" selected>Forum de discussion</option>';
  else
    $options_activite_action .= '<option value="forum">Forum de discussion</option>';
  if($activite_action == "todo")
    $options_activite_action .= '<option value="todo" selected>Liste des tâches</option>';
  else
    $options_activite_action .= '<option value="todo">Liste des tâches</option>';
  if($activite_action == "irl")
    $options_activite_action .= '<option value="irl" selected>Rencontres IRL</option>';
  else
    $options_activite_action .= '<option value="irl">Rencontres IRL</option>';
  if($activite_action == "version")
    $options_activite_action .= '<option value="version" selected>Versions de NoBleme</option>';
  else
    $options_activite_action .= '<option value="version">Versions de NoBleme</option>';

}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <?php if(isset($_GET['mod'])) { ?>
      <img src="<?=$chemin?>img/logos/moderation_logs.png" alt="Logs de modération">
      <?php } else { ?>
      <img src="<?=$chemin?>img/logos/activite.png" alt="Activité récente">
      <?php } ?>
    </div>
    <br>

      <div class="body_main bigsize">
        <?php if(isset($_GET['mod'])) { ?>
        <form id="activite" action="activite?mod" method="POST">
        <?php } else { ?>
        <form id="activite" action="activite" method="POST">
        <?php } ?>
          <?php if(getadmin()) { ?>
          <input type="hidden" name="secretAdmin" id="secretAdmin" value="">
          <?php } ?>
          <table class="cadre_gris indiv">
            <tr>
              <?php if(isset($_GET['mod']) && getadmin()) { ?>
              <td class="cadre_gris_titre gros" colspan="4">
                LOGS DE MODÉRATION : <?=$select_activite_limit?>&nbsp; &nbsp;DERNIÈRES ACTIONS
              </td>
              <?php } else if(isset($_GET['mod']) && !getadmin()) { ?>
              <td class="cadre_gris_titre gros" colspan="3">
                LOGS DE MODÉRATION : <?=$select_activite_limit?>&nbsp; &nbsp;DERNIÈRES ACTIONS
              </td>
              <?php } else if(getadmin()) { ?>
              <td class="cadre_gris_titre gros" colspan="3">
                ACTIVITÉ RÉCENTE : <?=$select_activite_limit?>&nbsp; &nbsp;DERNIÈRES ACTIONS
              </td>
              <?php } else { ?>
              <td class="cadre_gris_titre gros" colspan="2">
                ACTIVITÉ RÉCENTE : <?=$select_activite_limit?>&nbsp; &nbsp;DERNIÈRES ACTIONS
              </td>
              <?php } ?>
            </tr>
            <tr>
              <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                Date
              </td>
              <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                <select name="activite_action" class="moinsgros nobleme_clair texte_blanc gras align_center discret activite_action" onChange="document.getElementById('activite').submit();"><?=$options_activite_action?></select>
              </td>
              <?php if(isset($_GET['mod'])) { ?>
              <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros">
                Détails
              </td>
              <?php } if(getadmin()) { ?>
              <td class="cadre_gris_sous_titre cadre_gris_haut moinsgros activite_colonne">
                X
              </td>
              <?php } ?>
            </tr>

            <?php for($i=0;$i<$nactrec;$i++) { ?>

            <tr>

              <td class="cadre_gris cadre_gris_haut align_center spaced nowrap <?=$description_class[$i]?>">
                <?=$date_action[$i]?>
              </td>

              <?php if(!isset($_GET['mod'])) { ?>
              <td class="cadre_gris cadre_gris_haut align_center spaced nowrap <?=$description_class[$i]?>">
                <?=$description_action[$i]?>
              </td>
              <?php } else if(!$description_diff[$i] && !$description_raison[$i]) { ?>
              <td colspan="2" class="cadre_gris cadre_gris_haut align_center spaced nowrap <?=$description_class[$i]?>">
                <?=$description_action[$i]?>
              </td>
              <?php } else { ?>
              <td class="cadre_gris cadre_gris_haut align_center spaced nowrap <?=$description_class[$i]?>">
                <?=$description_action[$i]?>
              </td>
              <td class="cadre_gris cadre_gris_haut align_center spaced nowrap <?=$description_class[$i]?>">
                <?php if($description_raison[$i]) { ?>
                <img height="20" width="20" class="pointeur" src="<?=$chemin?>img/icones/pourquoi.png" alt="diff" onClick="toggle_row('why<?=$i?>');">
                <?php } if($description_diff[$i]) { ?>
                <img height="20" width="20" class="pointeur" src="<?=$chemin?>img/icones/details.png" alt="diff" onClick="toggle_row('diff<?=$i?>');">
                <?php } ?>
              </td>

              <?php } if(getadmin()) { ?>
              <td class="cadre_gris cadre_gris_haut align_center spaced nowrap <?=$description_class[$i]?>">
                <img height="20" width="20" class="pointeur" src="<?=$chemin?>img/icones/delete.png" alt="diff" onClick="var ok = confirm('Confirmation'); if(ok == true) {document.getElementById('secretAdmin').value = '<?=$actid[$i]?>'; document.getElementById('activite').submit();}">
              </td>
              <?php } ?>

            </tr>

            <?php if(isset($_GET['mod']) && $description_raison[$i]) { ?>
            <tr class="hidden" id="why<?=$i?>">
              <?php if(getadmin()) { ?>
              <td colspan="4" class="cadre_gris cadre_gris_haut align_center gras spaced <?=$description_class[$i]?>">
              <?php } else { ?>
              <td colspan="3" class="cadre_gris cadre_gris_haut align_center gras spaced <?=$description_class[$i]?>">
              <?php } ?>
                <br>
                <?=$description_raison[$i]?><br>
                <br>
              </td>
            </tr>
            <?php } if(isset($_GET['mod']) && $description_diff[$i]) { ?>
            <tr class="hidden" id="diff<?=$i?>">
              <?php if(getadmin()) { ?>
              <td colspan="4" class="cadre_gris cadre_gris_haut align_left spaced <?=$description_class[$i]?>">
              <?php } else { ?>
              <td colspan="3" class="cadre_gris cadre_gris_haut align_left spaced <?=$description_class[$i]?>">
              <?php } ?>
                <br>
                <?=$description_diff[$i]?><br>
                <br>
              </td>
            </tr>
            <?php } ?>

            <?php } ?>

          </table>
        </form>
      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';