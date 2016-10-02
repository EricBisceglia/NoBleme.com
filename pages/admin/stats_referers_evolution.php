<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'admin';
$header_submenu   = 'admin';
$header_sidemenu  = 'stats_refs_evo';

// Titre
$page_titre = "Stats - Referers";

// Identification
$page_nom = "admin";

// CSS & JS
$css = array("admin");
$js  = array("toggle");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher si on update un alias
if(isset($_POST['referer_edit']))
{
  // On assainit le postdata
  $edit_referer   = postdata($_POST['referer_edit']);
  $id_referer     = postdata($_POST['referer_id'.$edit_referer]);
  $alias_referer  = postdata($_POST['referer_alias'.$edit_referer]);

  // Et on met à jour
  query(" UPDATE stats_referer SET stats_referer.alias = '$alias_referer' WHERE stats_referer.id = '$id_referer' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des referers

// On va chercher les referers
$qreferers = query("  SELECT    stats_referer.id      ,
                                stats_referer.source  ,
                                stats_referer.alias   ,
                                stats_referer.nombre  ,
                                stats_referer.nombre_lastvisit
                      FROM      stats_referer
                      WHERE     stats_referer.nombre != stats_referer.nombre_lastvisit
                      ORDER BY  (stats_referer.nombre - stats_referer.nombre_lastvisit) DESC ,
                                stats_referer.nombre DESC ");

// Et on prépare pour l'affichage
for($nreferers = 0 ; $dreferers = mysqli_fetch_array($qreferers) ; $nreferers++)
{
  // Préparation des données
  $referer_id[$nreferers]     = $dreferers['id'];
  $referer_raw[$nreferers]    = destroy_html($dreferers['source']);
  $referer_alias[$nreferers]  = destroy_html($dreferers['alias']);
  if(strlen($dreferers['source']) >= 75)
    $referer_source[$nreferers] = substr($dreferers['source'],0,75).'...';
  else
    $referer_source[$nreferers] = $dreferers['source'];

  // On formate le nombre de vues pour que ça soit lisible
  $referer_num[$nreferers]  = number_format($dreferers['nombre'], 0, ',', ' ');
  $referer_last[$nreferers] = number_format($dreferers['nombre_lastvisit'], 0, ',', ' ');
  $referer_grow[$nreferers] = '+'.number_format($dreferers['nombre'] - $dreferers['nombre_lastvisit'], 0, ',', ' ').' ';
  if($dreferers['nombre_lastvisit'] && ($dreferers['nombre'] - $dreferers['nombre_lastvisit']) != 0)
    $referer_growpourcent[$nreferers] = '+'.number_format((($dreferers['nombre'] - $dreferers['nombre_lastvisit']) / $dreferers['nombre_lastvisit']) * 100, 2, ',', ' ').'%';
  else if(!$dreferers['nombre_lastvisit'])
    $referer_growpourcent[$nreferers] = 'New !';
  else
    $referer_growpourcent[$nreferers] = '-';

  // Et on alterne les couleurs pour pouvoir suivre les lignes
  $referer_css[$nreferers]  = ($nreferers % 2) ? ' nobleme_background' : ' blanc';
}

// On va chercher de quand datent les stats
$qdatestats     = mysqli_fetch_array(query(" SELECT vars_globales.last_referer_check FROM vars_globales "));
$referers_date  = strtoupper(jourfr(date('Y-m-d',$qdatestats['last_referer_check'])));
$referers_jours = round((time() - $qdatestats['last_referer_check'])/86400);

// Puis on reset les stats
$timestamp = time();
query(" UPDATE vars_globales SET vars_globales.last_referer_check = '$timestamp' ");
query(" UPDATE stats_referer SET stats_referer.nombre_lastvisit = stats_referer.nombre ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des alias

// On va chercher les alias
$qaliasref = query("  SELECT    stats_referer.alias         AS 'alias_nom' ,
                                COUNT(stats_referer.alias)  AS 'alias_num'
                      FROM      stats_referer
                      WHERE     stats_referer.alias != ''
                      GROUP BY  stats_referer.alias
                      ORDER BY  COUNT(stats_referer.alias) DESC ");

// Et on les prépare pour l'affichage
for($naliasref = 0 ; $daliasref = mysqli_fetch_array($qaliasref) ; $naliasref++)
{
  $alias_nom[$naliasref]    = $daliasref['alias_nom'];
  $alias_count[$naliasref]  = $daliasref['alias_num'];
  $alias_css[$naliasref]    = ($naliasref % 2) ? 'nobleme_background' : 'blanc';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="Administration">
    </div>
    <br>

    <div class="body_main referer_aliaslist hidden">
      <table class="cadre_gris indiv">
        <tr>
          <td colspan="2" class="cadre_gris cadre_gris_titre moinsgros align_center">
            ALIAS DE REFERERS
          </td>
        </tr>
        <tr>
          <td class="cadre_gris cadre_gris_sous_titre cadre_gris_haut">
            Alias
          </td>
          <td class="cadre_gris cadre_gris_sous_titre cadre_gris_haut">
            Nombre
          </td>
        </tr>
        <?php for($i=0;$i<$naliasref;$i++) { ?>
        <tr>
          <td class="cadre_gris align_center gras <?=$alias_css[$i]?>">
            <?=$alias_nom[$i]?>
          </td>
          <td class="cadre_gris align_center gras <?=$alias_css[$i]?>">
            <?=$alias_count[$i]?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

    <div class="body_main referer_evolution">
      <form name="stats_referers" action="stats_referers" method="POST">
        <input type="hidden" value="fail" id="referer_edit" name="referer_edit">
        <table class="cadre_gris indiv">
          <tr>
            <td colspan="7" class="cadre_gris_titre gros">
              REFERERS : ÉVOLUTION SUR <?=$referers_jours?> JOURS DEPUIS LE <?=$referers_date?>
            </td>
          </tr>
          <tr>
            <td class="referer_raw cadre_gris_sous_titre cadre_gris_haut">
              Raw
            </td>
            <td colspan="2" class="referer_alias cadre_gris_sous_titre cadre_gris_haut pointeur" onClick="toggle_class('hidden')" >
              Alias
            </td>
            <td class="cadre_gris_sous_titre cadre_gris_haut">
              Croissance
            </td>
            <td class="cadre_gris_sous_titre cadre_gris_haut">
              Croissance %
            </td>
            <td class="cadre_gris_sous_titre cadre_gris_haut">
              Avant
            </td>
            <td class="cadre_gris_sous_titre cadre_gris_haut">
              Maintenant
            </td>
          </tr>
          <?php for($i=0;$i<$nreferers;$i++) { ?>
          <tr>
            <td class="cadre_gris align_center<?=$referer_css[$i]?>">
              <a class="dark blank" href="<?=$referer_raw[$i]?>"><?=$referer_source[$i]?></a>
            </td>
            <td class="referer_alias cadre_gris align_center<?=$referer_css[$i]?>">
              <input type="hidden" value="<?=$referer_id[$i]?>" name="referer_id<?=$i?>">
              <input class="align_center discret intable<?=$referer_css[$i]?>" value="<?=$referer_alias[$i]?>" name="referer_alias<?=$i?>">
            </td>
            <td class="referer_modifier cadre_gris align_center<?=$referer_css[$i]?>">
              <input type="submit" class="discret intable<?=$referer_css[$i]?>" value="Modifier" onClick="document.getElementById('referer_edit').value = <?=$i?> ; document.getElementById('stats_referers').submit();">
            </td>
            <td class="cadre_gris align_center gras<?=$referer_css[$i]?>">
              <?=$referer_grow[$i]?>
            </td>
            <td class="cadre_gris align_center gras<?=$referer_css[$i]?>">
              <?=$referer_growpourcent[$i]?>
            </td>
            <td class="cadre_gris align_center<?=$referer_css[$i]?>">
              <?=$referer_last[$i]?>
            </td>
            <td class="cadre_gris align_center<?=$referer_css[$i]?>">
              <?=$referer_num[$i]?>
            </td>
          </tr>
          <?php } ?>
        </table>
      </form>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';