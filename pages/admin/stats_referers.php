<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Titre
$page_titre = "Stats - Referers";

// Identification
$page_nom = "admin";

// CSS
$css = array("admin");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher si on update un alias
if(isset($_POST['referer_edit']) && $_POST['referer_edit'] != 'fail')
{
  // On assainit le postdata
  $edit_referer   = postdata($_POST['referer_edit']);
  $id_referer     = postdata($_POST['referer_id'.$edit_referer]);
  $alias_referer  = postdata($_POST['referer_alias'.$edit_referer]);

  // Et on met à jour
  query(" UPDATE stats_referer SET stats_referer.alias = '$alias_referer' WHERE stats_referer.id = '$id_referer' ");
}

// On remet la recherche et les champs à zéro avant de traiter le postdata
$search_raw     = '';
$search_alias   = '';
$search_nombre  = 100;
$stats_raw      = '';
$stats_alias    = '';
$stats_nombre   = 100;

// Si c'est une recherche...
if(isset($_POST['referer_edit']))
{
  // On assainit le postdata
  $search_raw     = postdata($_POST['search_raw']);
  $search_alias   = postdata($_POST['search_alias']);
  $search_nombre  = postdata($_POST['search_nombre']);

  // On prépare les champs
  $stats_raw      = $_POST['search_raw'];
  $stats_alias    = $_POST['search_alias'];
  $stats_nombre   = $_POST['search_nombre'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les referers
$qreferers =  " SELECT    stats_referer.id      ,
                          stats_referer.source  ,
                          stats_referer.alias   ,
                          stats_referer.nombre
                FROM      stats_referer         ";

// On fait les recherches
$qreferers .= " WHERE     stats_referer.nombre > '$search_nombre' ";
if($search_raw)
  $qreferers .= " AND stats_referer.source LIKE '%$search_raw%' ";
if($search_alias)
  $qreferers .= " AND stats_referer.alias LIKE '%$search_alias%' ";

// On balance la requête
$qreferers .= " ORDER BY  stats_referer.nombre DESC ";
$qreferers = query($qreferers);

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

  // Et on alterne les couleurs pour pouvoir suivre les lignes
  $referer_css[$nreferers]  = ($nreferers % 2) ? ' blanc' : ' nobleme_background';
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

    <div class="body_main bigsize">
      <form name="stats_referers" action="stats_referers" method="POST">
        <input type="hidden" value="fail" id="referer_edit" name="referer_edit">
        <table class="cadre_gris indiv">
          <tr>
            <td colspan="4" class="cadre_gris_titre gros">
              REFERERS
            </td>
          </tr>
          <tr>
            <td class="referer_raw cadre_gris_sous_titre cadre_gris_haut">
              Raw
            </td>
            <td colspan="2" class="referer_alias cadre_gris_sous_titre cadre_gris_haut">
              Alias
            </td>
            <td class="cadre_gris_sous_titre cadre_gris_haut">
              Nombre
            </td>
          </tr>
          <tr>
            <td class="cadre_gris">
              <input class="intable discret align_center" name="search_raw" onChange="this.form.submit();" value="<?=$stats_raw?>">
            </td>
            <td class="cadre_gris" colspan="2">
              <input class="intable discret align_center" name="search_alias" onChange="this.form.submit();" value="<?=$stats_alias?>">
            </td>
            <td class="cadre_gris">
              <input class="intable discret align_center" name="search_nombre" onChange="this.form.submit();" value="<?=$stats_nombre?>">
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
              <input type="submit" class="discret intable<?=$referer_css[$i]?>" value="Modifier" onClick="document.getElementById('referer_edit').value = <?=$i?> ; this.form.submit();">
            </td>
            <td class="cadre_gris align_center gras<?=$referer_css[$i]?>">
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