<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloWeb';

// Identification
$page_nom = "Administre la NBDB";
$page_url = "pages/nbdb/index";

// Langues disponibles
$langue_page = array('FR');

// Titre
$page_titre = "NBDB : Administration";

// CSS & JS
$css  = array('nbdb');
$js   = array('dynamique', 'toggle', 'clipboard');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mise en ligne d'une nouvelle image

if(isset($_POST['web_images_upload_go']) && isset($_FILES['web_images_upload_fichier']['name']) && $_FILES['web_images_upload_fichier']['name'] != '')
{
  // Véréfication des erreurs
  if($_FILES['web_images_upload_fichier']['error'])
    $erreur = "Erreur à l'upload : ".$_FILES['web_images_upload_fichier']['error'];
  if(!$_POST['web_images_upload_nom'])
    $erreur = "Le fichier doit avoir un nom";

  // Si y'a pas d'erreurs, on peut continuer
  if(!isset($erreur))
  {
    // Assainissement du postdata
    $web_images_upload_nom  = postdata_vide('web_images_upload_nom', 'string', '');
    $web_images_upload_tags = postdata_vide('web_images_upload_tags', 'string', '');
    $web_images_upload_img  = urlencode(str_replace(' ', '_', $web_images_upload_nom)).'.'.pathinfo($_FILES['web_images_upload_fichier']['name'], PATHINFO_EXTENSION);
    $web_images_upload_path = $chemin."img/nbdb_web/".$web_images_upload_img;
    $web_images_upload_temp = $_FILES['web_images_upload_fichier']['tmp_name'];

    // On vérifie que le fichier n'existe pas déjà
    while(file_exists($web_images_upload_path))
    {
      $web_images_upload_img  = urlencode(str_replace(' ', '_', $web_images_upload_nom)).'_'.time().'.'.pathinfo($_FILES['web_images_upload_fichier']['name'], PATHINFO_EXTENSION);
      $web_images_upload_path = $chemin."img/nbdb_web/".$web_images_upload_img;
    }

    // Upload de l'image
    if(move_uploaded_file($web_images_upload_temp, $web_images_upload_path))
    {
      // Assainissement du nom du fichier
      $web_images_upload_nom = postdata($web_images_upload_img, 'string');

      // Entrée dans la base de données
      $timestamp = time();
      query(" INSERT INTO nbdb_web_image
              SET         nbdb_web_image.timestamp_upload = '$timestamp'              ,
                          nbdb_web_image.nom_fichier      = '$web_images_upload_nom'  ,
                          nbdb_web_image.tags             = '$web_images_upload_tags' ");
    }

    // Si l'upload ne s'est pas bien passé, on met un message d'erreur
    else
      $erreur = "Erreur à la copie";
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'une image existante

if(isset($_GET['edit']))
{
  // On récupère le postdata
  $image_edit_id    = postdata_vide('web_images_id', 'int', 0);
  $image_edit_tags  = postdata_vide('web_images_tags', 'string', '');

  // Et on met à jour les infos de l'image
  query(" UPDATE  nbdb_web_image
          SET     nbdb_web_image.tags = '$image_edit_tags'
          WHERE   nbdb_web_image.id = '$image_edit_id' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une image existante

if(isset($_GET['delete']))
{
  // On récupère le postdata
  $image_delete_id = postdata_vide('web_images_id', 'int', 0);

  // Il nous faut le chemin de l'image
  $dimage = mysqli_fetch_array(query("  SELECT  nbdb_web_image.nom_fichier AS 'i_id'
                                        FROM    nbdb_web_image
                                        WHERE   nbdb_web_image.id = '$image_delete_id' "));


  // On supprime l'image
  if(unlink($chemin."img/nbdb_web/".$dimage['i_id']))
  {
    // Ainsi que ses entrées dans la BDD
    query(" DELETE FROM nbdb_web_image
            WHERE       nbdb_web_image.id = '$image_delete_id' ");
  }

  // Si ça c'est mal passé, on le fait savoir
  else
    exit('Image non supprimée !');
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tableau des images

// On va chercher les infos sur les images
$qimages  =   " SELECT    nbdb_web_image.id               AS 'i_id'   ,
                          nbdb_web_image.timestamp_upload AS 'i_date' ,
                          nbdb_web_image.nom_fichier      AS 'i_nom'  ,
                          nbdb_web_image.tags             AS 'i_tags'
                FROM      nbdb_web_image
                WHERE     1 = 1 ";

// Recherche
if($search_images_nom = urlencode(postdata_vide('web_images_search_nom', 'string', '')))
  $qimages .= " AND       nbdb_web_image.nom_fichier LIKE '%$search_images_nom%' ";
if($search_images_tags = postdata_vide('web_images_search_tags', 'string', ''))
  $qimages .= " AND       nbdb_web_image.tags LIKE '%$search_images_tags%' ";

// Ordre de tri des données
$images_tri = postdata_vide('web_images_tri', 'string', '');
if($images_tri == 'nom')
  $qimages .= " ORDER BY  nbdb_web_image.nom_fichier ASC ";
else if($images_tri == 'tags')
  $qimages .= " ORDER BY  nbdb_web_image.tags = '' , nbdb_web_image.tags ASC ";
else
  $qimages .= " ORDER BY  nbdb_web_image.timestamp_upload DESC ";

// On envoie la requête
$qimages = query($qimages);

// On les prépare le contenu du tableau pour l'affichage
for($nimages = 0; $dimages = mysqli_fetch_array($qimages); $nimages++)
{
  $image_id[$nimages]   = $dimages['i_id'];
  $image_nom[$nimages]  = predata(urldecode($dimages['i_nom']));
  $image_lien[$nimages] = urlencode(predata($dimages['i_nom']));
  $image_date[$nimages] = date('y/m/d H:i', $dimages['i_date']);
  $image_tags[$nimages] = str_replace(';', '<br>', $dimages['i_tags']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h2>NBDB - Administration des images</h2>

      </div>

      <br>
      <hr class="separateur_contenu">

      <div class="minitexte3">

        <p>
          <form method="POST" enctype="multipart/form-data">
            <fieldset>

              <?php if(isset($erreur)) { ?>
              <h5 class="indiv align_center erreur texte_blanc gras"><?=$erreur?></h5>
              <br>
              <?php } ?>

              <input type="file" name="web_images_upload_fichier" id="web_images_upload_fichier" class="web_image_upload"><br>
              <br>

              <div class="flexcontainer">
                <div style="flex:10">

                  <label for="web_images_upload_nom">Nom du fichier</label>
                  <input id="web_images_upload_nom" name="web_images_upload_nom" class="indiv" type="text">

                </div>
                <div style="flex:1">
                  &nbsp;
                </div>
                <div style="flex:14">

                  <label for="web_images_upload_tags">Tags (séparés par des points virgule)</label>
                  <input id="web_images_upload_tags" name="web_images_upload_tags" class="indiv" type="text">

                </div>
              </div>

              <br>
              <input value="UPLOADER UNE IMAGE DANS L'ENCYCLOPÉDIE DE LA CULTURE INTERNET" type="submit" name="web_images_upload_go">

            </fieldset>
          </form>
        </p>

      </div>

      <hr class="separateur_contenu">
      <br>

      <div class="tableau" id="web_images_tableau">

      <?php } if(!getxhr() || isset($_POST['web_images_tri']) || isset($_POST['web_images_id'])) { ?>

        <table class="grid titresnoirs">
          <thead>

            <tr>
              <th>
                COPIER
              </th>
              <th class="pointeur" onclick="dynamique('<?=$chemin?>', 'web_images', 'web_images_tableau', 'web_images_tri=nom', 1);">
                NOM DU FICHIER
              </th>
              <th class="pointeur" onclick="dynamique('<?=$chemin?>', 'web_images', 'web_images_tableau', 'web_images_tri=date', 1);">
                MISE EN LIGNE
              </th>
              <th class="pointeur" onclick="dynamique('<?=$chemin?>', 'web_images', 'web_images_tableau', 'web_images_tri=tags', 1);">
                TAGS
              </th>
              <th>
                ACTIONS
              </th>
            </tr>

            <tr>
              <th>
                &nbsp;
              </th>
              <th>
                <input class="intable" size="1" id="web_images_search_nom" onkeyup="dynamique('<?=$chemin?>', 'web_images', 'web_images_tbody', 'web_images_search_nom='+dynamique_prepare('web_images_search_nom')+'&web_images_search_tags='+dynamique_prepare('web_images_search_tags'), 1);">
              </th>
              <th>
                &nbsp;
              </th>
              <th>
                <input class="intable" size="1" id="web_images_search_tags" onkeyup="dynamique('<?=$chemin?>', 'web_images', 'web_images_tbody', 'web_images_search_nom='+dynamique_prepare('web_images_search_nom')+'&web_images_search_tags='+dynamique_prepare('web_images_search_tags'), 1);">
              </th>
              <th>
                &nbsp;
              </th>
            </tr>

          </thead>
          <tbody class="align_center" id="web_images_tbody">

            <?php } for($i=0;$i<$nimages;$i++) { ?>

            <tr>

              <td>
                <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/copier.svg" alt="X" height="24" onclick="pressepapiers('[[image:<?=$image_lien[$i]?>]]');">
                <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/image.svg" alt="X" height="24" onclick="pressepapiers('[[galerie:<?=$image_lien[$i]?>]]');">
              </td>

              <td class="spaced">
                <div class="tooltip-container" onmouseover="document.getElementById('web_images_preview_<?=$image_nom[$i]?>').src = '<?=$chemin?>img/nbdb_web/<?=$image_lien[$i]?>'; document.getElementById('web_images_preview_<?=$image_nom[$i]?>').style.maxHeight = '250px';">
                  <a class="gras" href="<?=$chemin?>pages/nbdb/web_image?image=<?=$image_lien[$i]?>">
                    <?=$image_nom[$i]?>
                    <span class="tooltip web_image_preview">
                      <img id="web_images_preview_<?=$image_nom[$i]?>" class="valign_middle pointeur" src="<?=$chemin?>img/icones/chargement.svg" alt="Chargement">
                    </span>
                  </a>
                </div>
              </td>

              <td>
                <?=$image_date[$i]?>
              </td>

              <td>
                <?=$image_tags[$i]?>
              </td>

              <td>
                <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="24" onclick="toggle_oneway('web_images_edition_<?=$image_id[$i]?>', 1, 1); dynamique('<?=$chemin?>', 'xhr/web_images_modifier?edit', 'web_images_edition_<?=$image_id[$i]?>', 'id=<?=$image_id[$i]?>', 1);">
                <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="24" onclick="toggle_oneway('web_images_edition_<?=$image_id[$i]?>', 1, 1); dynamique('<?=$chemin?>', 'xhr/web_images_modifier?delete', 'web_images_edition_<?=$image_id[$i]?>', 'id=<?=$image_id[$i]?>', 1);">
              </td>

            </tr>

            <tr class="hidden" id="web_images_edition_<?=$image_id[$i]?>">
              <td colspan="5" class="align_center">
                &nbsp;
              </td>
            </tr>

            <?php } if(!getxhr() || isset($_POST['web_images_tri']) || isset($_POST['web_images_id'])) { ?>

          </tbody>
        </table>

      <?php } ?>

      <?php if(!getxhr()) { ?>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }