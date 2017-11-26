<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Admin';
$header_sidemenu  = 'Pageviews';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Pageviews";

// JS
$js = array('dynamique', 'admin/pageviews');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assainissement du postdata

$pageviews_tri        = postdata_vide('pageviews_tri', 'string', '');
$pageviews_recherche  = postdata_vide('pageviews_recherche', 'string', '');
$pageviews_raz        = postdata_vide('pageviews_raz', 'int', 0);
$pageviews_delete     = postdata_vide('pageviews_delete', 'int', 0);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remise à zéro de la date de comparaison

if($pageviews_raz)
{
  // On change la variable globale qui contient la date de dernière remise à zéro
  $timestamp = time();
  query(" UPDATE  vars_globales
          SET     vars_globales.last_pageview_check = '$timestamp' ");

  // Puis on met à jour les vues de toutes les pages
  query(" UPDATE  pageviews
          SET     pageviews.vues_lastvisit = pageviews.vues ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une entrée

if($pageviews_delete)
{
  // On supprime l'entrée
  query(" DELETE FROM pageviews
          WHERE       pageviews.id = '$pageviews_delete' ");
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les pages
$qpageviews = "     SELECT    pageviews.id              ,
                              pageviews.nom_page        ,
                              pageviews.url_page        ,
                              pageviews.vues            ,
                              pageviews.vues_lastvisit
                    FROM      pageviews
                    WHERE     1 = 1 ";

// Recherche dans le tableau
if($pageviews_recherche)
  $qpageviews .= "  AND     ( pageviews.nom_page LIKE '%$pageviews_recherche%'
                    OR        pageviews.url_page LIKE '%$pageviews_recherche%' ) ";

// Tri du tableau
if($pageviews_tri == 'nom')
  $qpageviews .= "  ORDER BY  pageviews.nom_page                          ASC   ,
                              pageviews.vues                              DESC  ";
else if($pageviews_tri == 'avant')
  $qpageviews .= "  ORDER BY  pageviews.vues_lastvisit                    DESC  ,
                              pageviews.vues                              DESC  ,
                              pageviews.nom_page                          ASC   ";
else if($pageviews_tri == 'croissance')
  $qpageviews .= "  ORDER BY  (pageviews.vues - pageviews.vues_lastvisit) DESC  ,
                              pageviews.vues                              DESC  ,
                              pageviews.vues_lastvisit                    DESC  ,
                              pageviews.nom_page                          ASC   ";
else
  $qpageviews .= "  ORDER BY  pageviews.vues                              DESC  ,
                              pageviews.vues_lastvisit                    DESC  ,
                              pageviews.nom_page                          ASC   ";

// On envoie la requête
$qpageviews = query($qpageviews);

// Et on prépare tout ça pour l'affichage
for($npageviews = 0; $dpageviews = mysqli_fetch_array($qpageviews); $npageviews++)
{
  $views_id[$npageviews]          = $dpageviews['id'];
  $views_nom[$npageviews]         = (!$dpageviews['url_page']) ? predata($dpageviews['nom_page']) : '<a href="'.$chemin.predata($dpageviews['url_page']).'">'.predata($dpageviews['nom_page']).'</a>';
  $views_vues[$npageviews]        = format_nombre($dpageviews['vues'], 'nombre');
  $views_lastvisit[$npageviews]   = format_nombre($dpageviews['vues_lastvisit'], 'nombre');
  $views_croissance[$npageviews]  = ($dpageviews['vues'] != $dpageviews['vues_lastvisit']) ? format_nombre($dpageviews['vues'] - $dpageviews['vues_lastvisit'], 'nombre', NULL, 1) : '-';
  $views_croissancep[$npageviews] = ($dpageviews['vues'] != $dpageviews['vues_lastvisit'] && $dpageviews['vues_lastvisit'] != 0) ? format_nombre(calcul_pourcentage($dpageviews['vues'], $dpageviews['vues_lastvisit'], 1),"pourcentage", 1, 1) : '-';
}

// On a aussi besoin de la dernière date de comparaison
$qpageviews           = mysqli_fetch_array(query("  SELECT  vars_globales.last_pageview_check
                                                    FROM    vars_globales
                                                    LIMIT   1 "));
$last_pageview_check  = jourfr(date('Y-m-d', $qpageviews['last_pageview_check'])).' ('.ilya($qpageviews['last_pageview_check']).')';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte2 align_center">

        <h1>Pageviews</h1>

        <h5>Popularité des pages depuis le <?=$last_pageview_check?></h5>

        <br>

        <p>
          <fieldset>
            <input type="hidden" id="pageviews_tri" value="views">
            <input id="pageviews_recherche" class="indiv" placeholder="Rechercher une page par son nom et/ou son url" type="text" onkeyup="d_tableau_pageviews('<?=$chemin?>');"><br>
            <br>
            <button class="button button-outline" onclick="d_tableau_pageviews('<?=$chemin?>', 0, 1);">REMETTRE À ZÉRO LA DATE DE COMPARAISON</button>
          </fieldset>
        </p>

        <br>

        <table class="grid titresnoirs altc">
          <thead>
            <tr>
              <th class="pointeur" onclick="d_tableau_pageviews('<?=$chemin?>', 'nom');">
                PAGE
              </th>
              <th class="pointeur" onclick="d_tableau_pageviews('<?=$chemin?>', 'views');">
                PAGEVIEWS
              </th>
              <th class="pointeur" onclick="d_tableau_pageviews('<?=$chemin?>', 'avant');">
                AVANT
              </th>
              <th colspan="2" class="pointeur" onclick="d_tableau_pageviews('<?=$chemin?>', 'croissance');">
                CROISSANCE
              </th>
              <th>
                &nbsp;
              </th>
            </tr>
          </thead>
          <tbody class="align_center" id="pageviews_tbody">
            <?php } ?>
            <?php for($i=0;$i<$npageviews;$i++) { ?>
            <tr>
              <td>
                <?=$views_nom[$i]?>
              </td>
              <td class="texte_noir gras">
                <?=$views_vues[$i]?>
              </td>
              <td>
                <?=$views_lastvisit[$i]?>
              </td>
              <td>
                <?=$views_croissance[$i]?>
              </td>
              <td>
                <?=$views_croissancep[$i]?>
              </td>
              <td class="pointeur" onclick="d_tableau_pageviews('<?=$chemin?>', 0, 0, <?=$views_id[$i]?>);">
                <img height="17" width="17" class="valign_table" src="./../../img/icones/delete.png" alt="X">
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