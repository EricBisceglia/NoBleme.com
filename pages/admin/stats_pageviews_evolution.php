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
$header_sidemenu  = 'stats_views_evo';

// Identification
$page_nom = "admin";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les pageviews
$qpageviews = query(" SELECT    stats_pageviews.nom_page  ,
                                stats_pageviews.id_page   ,
                                stats_pageviews.vues      ,
                                stats_pageviews.vues_lastvisit
                      FROM      stats_pageviews
                      ORDER BY  (stats_pageviews.vues - stats_pageviews.vues_lastvisit) DESC ,
                                stats_pageviews.vues DESC ");

// Et on prépare pour l'affichage
for($npageviews = 0 ; $dpageviews = mysqli_fetch_array($qpageviews) ; $npageviews++)
{
  // Appel à active.php pour définir le nom et l'url de la page
  $page_nom   = $dpageviews['nom_page'];
  $page_id    = $dpageviews['id_page'];
  $page_titre = -1;
  include $chemin."inc/pages.inc.php";

  // On prépare le lien selon s'il existe ou non
  if($visite_url != "")
    $pageviews_nom[$npageviews] = '<a class="dark blank" href="'.$visite_url.'">'.substr($visite_page,0,55).'</a>';
  else
    $pageviews_nom[$npageviews] = substr($visite_page,0,55);

  // On veut aussi les données raw
  $page_nom_raw[$npageviews]    = $dpageviews['nom_page'];
  $page_id_raw[$npageviews]     = $dpageviews['id_page'];

  // On formate le nombre de vues pour que ça soit lisible
  $pageviews_vues[$npageviews]  = number_format($dpageviews['vues'], 0, ',', ' ');
  $pageviews_last[$npageviews]  = number_format($dpageviews['vues_lastvisit'], 0, ',', ' ');
  $pageviews_grow[$npageviews]  = '+'.number_format($dpageviews['vues'] - $dpageviews['vues_lastvisit'], 0, ',', ' ').' ';
  if($dpageviews['vues_lastvisit'] && ($dpageviews['vues'] - $dpageviews['vues_lastvisit']) != 0)
    $pageviews_growpourcent[$npageviews] = '+'.number_format((($dpageviews['vues'] - $dpageviews['vues_lastvisit']) / $dpageviews['vues_lastvisit']) * 100, 2, ',', ' ').'%';
  else if(!$dpageviews['vues_lastvisit'])
    $pageviews_growpourcent[$npageviews] = 'New !';
  else
    $pageviews_growpourcent[$npageviews] = '-';

  // Et on alterne les couleurs pour pouvoir suivre les lignes
  $pageviews_css[$npageviews]   = ($npageviews % 2) ? ' nobleme_background' : '';
}

// On va chercher de quand datent les stats
$qdatestats       = mysqli_fetch_array(query(" SELECT vars_globales.last_pageview_check FROM vars_globales "));
$pageviews_date   = strtoupper(jourfr(date('Y-m-d',$qdatestats['last_pageview_check'])));
$pageviews_jours  = round((time() - $qdatestats['last_pageview_check'])/86400);

// Puis on reset les stats
$timestamp = time();
query(" UPDATE vars_globales SET vars_globales.last_pageview_check = '$timestamp' ");
query(" UPDATE stats_pageviews SET stats_pageviews.vues_lastvisit = stats_pageviews.vues ");

// On set le titre de la page avant d'invoquer le header
$page_titre = "Stats - Pageviews";



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

    <div class="body_main midsize">
      <table class="cadre_gris indiv">
        <tr>
          <td colspan="6" class="cadre_gris_titre gros">
            PAGEVIEWS : ÉVOLUTION SUR <?=$pageviews_jours?> JOURS DEPUIS LE <?=$pageviews_date?>
          </td>
        </tr>
        <tr>
          <td class="cadre_gris_sous_titre cadre_gris_haut">
            Raw
          </td>
          <td class="cadre_gris_sous_titre cadre_gris_haut">
            Formaté
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
        <?php for($i=0;$i<$npageviews;$i++) { ?>
        <tr>
          <td class="cadre_gris align_center<?=$pageviews_css[$i]?>">
            <?=$page_nom_raw[$i]?> - <?=$page_id_raw[$i]?>
          </td>
          <td class="cadre_gris align_center<?=$pageviews_css[$i]?>">
            <?=$pageviews_nom[$i]?>
          </td>
          <td class="cadre_gris align_center gras<?=$pageviews_css[$i]?>">
            <?=$pageviews_grow[$i]?>
          </td>
          <td class="cadre_gris align_center gras<?=$pageviews_css[$i]?>">
            <?=$pageviews_growpourcent[$i]?>
          </td>
          <td class="cadre_gris align_center<?=$pageviews_css[$i]?>">
            <?=$pageviews_last[$i]?>
          </td>
          <td class="cadre_gris align_center<?=$pageviews_css[$i]?>">
            <?=$pageviews_vues[$i]?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';