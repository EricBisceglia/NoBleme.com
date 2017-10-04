<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
if(isset($_GET['mod']))
  sysoponly($lang);

// Menus du header
$header_menu      = (!isset($_GET['mod'])) ? 'NoBleme' : 'Admin';
$header_sidemenu  = (!isset($_GET['mod'])) ? 'ActiviteRecente' : 'ModLogs';

// Identification
$page_nom = "Consulte l'activité récente";
$page_url = "pages/nobleme/activite";

// Langages disponibles
$langage_page = (!isset($_GET['mod'])) ? array('FR','EN') : array('FR');

// Titre et description
$page_titre = ($lang == 'FR') ? "Activité récente" : "Recent activity";
$page_titre = (isset($_GET['mod'])) ? "Logs de modération" : $page_titre;
$page_desc  = "Liste chronologique des évènements qui ont eu lieu récemment";

// CSS & JS
$js  = array('dynamique', 'toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

/*
// Suppression d'une ligne d'activité
query(" DELETE FROM activite      WHERE activite.id               = '$id_del' ");
query(" DELETE FROM activite_diff WHERE activite_diff.FKactivite  = '$id_del' ");
*/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// La préparation des données du tableau est déléguée à /inc/activite.php afin d'y avoir un accès rapide/facile pour l'éditer

include './../../inc/activite.inc.php';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

$traduction['titre']      = ($lang == 'FR') ? "Activité récente" : "Recent activity";
$traduction['soustitre']  = ($lang == 'FR') ? "Pour ceux qui ne veulent rien rater et tout traquer" : "For those of us who don't want to miss a thing";
$traduction['titre_mod']  = ($lang == 'FR') ? "Logs de modération" : "Mod logs";
$traduction['titretable'] = ($lang == 'FR') ? "DERNIÈRES ACTIONS" : "LATEST ACTIONS";
$traduction['ar_tout']    = ($lang == 'FR') ? "Voir tout" : "Everything";
$traduction['ar_user']    = ($lang == 'FR') ? "Membres" : "Users";
$traduction['ar_irl']     = ($lang == 'FR') ? "IRL" : "Meetups";
$traduction['ar_dev']     = ($lang == 'FR') ? "Développement" : "Internals";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <?php if(!isset($_GET['mod'])) { ?>
        <h1 class="indiv align_center"><?=$traduction['titre']?></h1>
        <h6 class="indiv align_center texte_nobleme_clair"><?=$traduction['soustitre']?></h6>
        <?php } else { ?>
        <h1 class="indiv align_center"><?=$traduction['titre_mod']?></h1>
        <?php } ?>

        <br>

        <p class="indiv align_center">
          <select id="activite_num">
            <option value="100">100</option>
            <option value="250">250</option>
            <option value="1000">1000</option>
          </select>
          <span class="gros gras spaced valign_bottom"><?=$traduction['titretable']?></span>
          <select id="activite_type">
            <option value="tout"><?=$traduction['ar_tout']?></option>
            <option value="membres"><?=$traduction['ar_user']?></option>
            <option value="irl"><?=$traduction['ar_irl']?></option>
            <option value="dev"><?=$traduction['ar_dev']?></option>
          </select>
        </p>

        <br>

        <table class="titresnoirs nowrap">
          <thead>
            <tr>
              <th colspan="3">
                &nbsp;
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$nactrec;$i++) { ?>
            <?php if($activite_desc[$i][$lang]) { ?>
            <tr>
              <?php if($activite_href[$i]) { ?>
              <td class="pointeur <?=$activite_css[$i]?>" onClick="window.open('<?=$activite_href[$i]?>','_self');">
              <?php } else { ?>
              <td class="align_center <?=$activite_css[$i]?>">
              <?php } ?>
                <?=$activite_date[$i]?>
              </td>
              <?php if($activite_href[$i]) { ?>
              <td class="pointeur <?=$activite_css[$i]?>" onClick="window.open('<?=$activite_href[$i]?>','_self');">
              <?php } else { ?>
              <td class="align_center <?=$activite_css[$i]?>">
              <?php } ?>
                <?=$activite_desc[$i][$lang]?>
              </td>
              <td class="pointeur <?=$activite_css[$i]?>">
                <?php if(isset($_GET['mod']) && $activite_raison[$i]) { ?>
                <img  height="17" width="17" class="valign_center" src="<?=$chemin?>img/icones/pourquoi.png" alt="?"
                      onClick="toggle_row('activite_hidden<?=$i?>',1);">
                <?php } if(isset($_GET['mod']) && $activite_diff[$i]) { ?>
                <img height="17" width="17" class="valign_center" src="<?=$chemin?>img/icones/details.png" alt="?"
                      onClick="toggle_row('activite_hidden<?=$i?>',1);">
                <?php } if(getadmin()) { ?>
                <img height="17" width="17" class="valign_center" src="<?=$chemin?>img/icones/delete.png" alt="X"
                      onClick="var ok = confirm('Confirmation'); if(ok == true) { alert('Ici ira la suppression'); }">
                <?php } ?>
              </td>
            </tr>
            <?php if(isset($_GET['mod'])) { ?>
            <tr class="hidden" id="activite_hidden<?=$i?>">
              <td colspan="3" class="align_left">
                <?php if($activite_raison[$i]) { ?>
                <span class="alinea gras souligne texte_noir">Justification de l'action:</span> <?=$activite_raison[$i]?><br>
                <br>
                <?php } if($activite_diff[$i]) { ?>
                <span class="alinea gras souligne texte_noir">Différences avant/après l'action:</span><br>
                <?=$activite_diff[$i]?><br>
                <br>
                <?php } ?>
              </td>
            </tr>
            <?php } } } ?>
          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';