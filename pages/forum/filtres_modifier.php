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
$header_sidemenu  = 'ForumFiltrage';

// Identification
$page_nom = "Administre secrètement le site";
$page_url = "pages/nobleme/404";

// Titre et description
$page_titre = "Catégories de filtrage du forum";

// JS
$js = array('toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une nouvelle catégorie

if(isset($_POST['categorie_add_go']))
{
  // Assainissement du postdata
  $categorie_add_classement = postdata_vide('categorie_add_classement', 'int', 999);
  $categorie_add_nom_fr     = postdata_vide('categorie_add_nom_fr', 'string', '');
  $categorie_add_nom_en     = postdata_vide('categorie_add_nom_en', 'string', '');
  $categorie_add_desc_fr    = postdata_vide('categorie_add_desc_fr', 'string', '');
  $categorie_add_desc_en    = postdata_vide('categorie_add_desc_en', 'string', '');

  // Ajout de la catégorie
  query(" INSERT INTO forum_categorie
          SET         par_defaut      = 0                           ,
                      classement      = '$categorie_add_classement' ,
                      nom_fr          = '$categorie_add_nom_fr'     ,
                      nom_en          = '$categorie_add_nom_en'     ,
                      description_fr  = '$categorie_add_desc_fr'    ,
                      description_en  = '$categorie_add_desc_en'    ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'une catégorie

if(isset($_POST['categorie_edit_go']))
{
  // Assainissement du postdata
  $categorie_edit_id          = postdata_vide('categorie_edit_id', 'int', 0);
  $categorie_edit_par_defaut  = postdata_vide('categorie_edit_par_defaut', 'string', '');
  $categorie_edit_classement  = postdata_vide('categorie_edit_classement', 'int', 999);
  $categorie_edit_nom_fr      = postdata_vide('categorie_edit_nom_fr', 'string', '');
  $categorie_edit_nom_en      = postdata_vide('categorie_edit_nom_en', 'string', '');
  $categorie_edit_desc_fr     = postdata_vide('categorie_edit_desc_fr', 'string', '');
  $categorie_edit_desc_en     = postdata_vide('categorie_edit_desc_en', 'string', '');

  // Modification de la catégorie
  query(" UPDATE  forum_categorie
          SET     forum_categorie.classement      = '$categorie_edit_classement'  ,
                  forum_categorie.nom_fr          = '$categorie_edit_nom_fr'      ,
                  forum_categorie.nom_en          = '$categorie_edit_nom_en'      ,
                  forum_categorie.description_fr  = '$categorie_edit_desc_fr'     ,
                  forum_categorie.description_en  = '$categorie_edit_desc_en'
          WHERE   forum_categorie.id              = '$categorie_edit_id' ");

  // Catégorie par défaut
  if($categorie_edit_par_defaut)
  {
    query(" UPDATE  forum_categorie
            SET     forum_categorie.par_defaut  = 0 ");
    query(" UPDATE  forum_categorie
            SET     forum_categorie.par_defaut  = 1
            WHERE   forum_categorie.id          = '$categorie_edit_id' ");
    query(" DELETE FROM forum_filtrage
            WHERE       forum_filtrage.FKforum_categorie = '$categorie_edit_id' ");
  }
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une catégorie

if(isset($_POST['categorie_delete_go']))
{
  // Assainissement du postdata
  $categorie_delete_id = postdata_vide('categorie_edit_id', 'int', 0);

  // Récupération de la catégorie par défaut
  $qpardefaut = mysqli_fetch_array(query("  SELECT  forum_categorie.id
                                            FROM    forum_categorie
                                            WHERE   forum_categorie.par_defaut = 1 "));
  $par_defaut = $qpardefaut['id'];

  // Déplacement des sujets de cette catégorie vers la catégorie par défaut
  query(" UPDATE  forum_sujet
          SET     forum_sujet.FKforum_categorie = '$par_defaut'
          WHERE   forum_sujet.FKforum_categorie = '$categorie_delete_id' ");

  // Suppression de la catégorie
  query(" DELETE FROM forum_categorie
          WHERE       forum_categorie.id = '$categorie_delete_id' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la liste des catégories
$qcategories = query("  SELECT    forum_categorie.id              ,
                                  forum_categorie.par_defaut      ,
                                  forum_categorie.classement      ,
                                  forum_categorie.nom_fr          ,
                                  forum_categorie.nom_en          ,
                                  forum_categorie.description_fr  ,
                                  forum_categorie.description_en
                        FROM      forum_categorie
                        ORDER BY  forum_categorie.par_defaut  DESC ,
                                  forum_categorie.classement  ASC  ");

// On les prépare pour l'affichage
for($ncategories = 0; $dcategories = mysqli_fetch_array($qcategories); $ncategories++)
{
  $categorie_id[$ncategories]           = $dcategories['id'];
  $categorie_css_1[$ncategories]        = ($dcategories['par_defaut']) ? ' positif texte_blanc' : ' texte_noir';
  $categorie_css_2[$ncategories]        = ($dcategories['par_defaut']) ? ' class="positif texte_blanc"' : '';
  $categorie_par_defaut[$ncategories]   = ($dcategories['par_defaut']) ? ' checked' : '';
  $categorie_classement[$ncategories]   = $dcategories['classement'];
  $categorie_nom_fr[$ncategories]       = predata($dcategories['nom_fr']);
  $categorie_nom_en[$ncategories]       = predata($dcategories['nom_en']);
  $categorie_desc_fr[$ncategories]      = bbcode(predata($dcategories['description_fr'], 1));
  $categorie_desc_fr_raw[$ncategories]  = predata($dcategories['description_fr']);
  $categorie_desc_en[$ncategories]      = bbcode(predata($dcategories['description_en'], 1));
  $categorie_desc_en_raw[$ncategories]  = predata($dcategories['description_en']);
}

// On en profite pour récupérer le prochain ID au classement
$categorie_prochain_classement = ($categorie_classement[$ncategories-1] + 1);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1 class="align_center">
          Catégories du forum
          <img class="pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" onclick="toggle_row('categorie_ajouter')" height="28">
        </h1>

        <br>
        <br>

        <div class="hidden" id="categorie_ajouter">

          <form method="POST">
            <fieldset>

              <label for="categorie_add_classement">Classement</label>
              <input id="categorie_add_classement" name="categorie_add_classement" class="indiv" type="text" value="<?=$categorie_prochain_classement?>"><br>
              <br>

              <label for="categorie_add_nom_fr">Nom français</label>
              <input id="categorie_add_nom_fr" name="categorie_add_nom_fr" class="indiv" type="text"><br>
              <br>

              <label for="categorie_add_nom_en">Nom anglais</label>
              <input id="categorie_add_nom_en" name="categorie_add_nom_en" class="indiv" type="text"><br>
              <br>

              <label for="categorie_add_desc_fr">Description en français (formatage via <a href="<?=$chemin?>pages/doc/bbcodes">BBcodes</a>)</label>
              <textarea id="categorie_add_desc_fr" name="categorie_add_desc_fr" class="indiv"></textarea><br>
              <br>

              <label for="categorie_add_desc_en">Description en anglais (formatage via <a href="<?=$chemin?>pages/doc/bbcodes">BBcodes</a>)</label>
              <textarea id="categorie_add_desc_en" name="categorie_add_desc_en" class="indiv"></textarea><br>
              <br>

              <input value="CRÉER UNE NOUVELLE CATÉGORIE" type="submit" name="categorie_add_go">

            </fieldset>
          </form>

          <br>
          <br>
          <br>

        </div>

      </div>
      <div class="texte2">

        <table class="grid titresnoirs hiddenaltc2">

          <thead>
            <tr>
              <th>
                #
              </th>
              <th>
                CATÉGORIE
              </th>
              <th>
                DESCRIPTION EN FRANÇAIS
              </th>
              <th>
                DESCRIPTION EN ANGLAIS
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <tr class="hidden">
              <td colspan="4" class="noir texte_blanc gras">
                &nbsp;
              </td>
            </tr>

            <?php for($i=0;$i<$ncategories;$i++) { ?>

            <tr class="pointeur" onclick="toggle_oneway('categorie_editer_<?=$i?>', 1, 1);">

              <td class="nowrap gras<?=$categorie_css_1[$i]?>">
                <?=$categorie_classement[$i]?>
              </td>

              <td class="nowrap gras<?=$categorie_css_1[$i]?>">
                <?=$categorie_nom_fr[$i]?><br>
                <?=$categorie_nom_en[$i]?>
              </td>

              <td<?=$categorie_css_2[$i]?>>
                <?=$categorie_desc_fr[$i]?>
              </td>

              <td<?=$categorie_css_2[$i]?>>
                <?=$categorie_desc_en[$i]?>
              </td>

            </tr>

            <tr class="hidden" id="categorie_editer_<?=$i?>">
              <td class="align_left" colspan="4">

                <div class="texte">

                  <form method="POST" onsubmit="">
                    <fieldset>

                      <input type="hidden" name="categorie_edit_id" value="<?=$categorie_id[$i]?>">
                      <br>

                      <label>Catégorie par défaut</label>
                      <input id="categorie_edit_par_defaut" name="categorie_edit_par_defaut" type="checkbox"<?=$categorie_par_defaut[$i]?>>
                      <label class="label-inline" for="categorie_edit_par_defaut">Correspond à l'absence de catégorisation</label><br>
                      <br>

                      <label for="categorie_edit_classement">Classement</label>
                      <input id="categorie_edit_classement" name="categorie_edit_classement" class="indiv" type="text" value="<?=$categorie_classement[$i]?>"><br>
                      <br>

                      <label for="categorie_edit_nom_fr">Nom français</label>
                      <input id="categorie_edit_nom_fr" name="categorie_edit_nom_fr" class="indiv" type="text" value="<?=$categorie_nom_fr[$i]?>"><br>
                      <br>

                      <label for="categorie_edit_nom_en">Nom anglais</label>
                      <input id="categorie_edit_nom_en" name="categorie_edit_nom_en" class="indiv" type="text" value="<?=$categorie_nom_en[$i]?>"><br>
                      <br>

                      <label for="categorie_edit_desc_fr">Description en français (formatage via <a href="<?=$chemin?>pages/doc/bbcodes">BBcodes</a>)</label>
                      <textarea id="categorie_edit_desc_fr" name="categorie_edit_desc_fr" class="indiv"><?=$categorie_desc_fr_raw[$i]?></textarea><br>
                      <br>

                      <label for="categorie_edit_desc_en">Description en anglais (formatage via <a href="<?=$chemin?>pages/doc/bbcodes">BBcodes</a>)</label>
                      <textarea id="categorie_edit_desc_en" name="categorie_edit_desc_en" class="indiv"><?=$categorie_desc_en_raw[$i]?></textarea><br>
                      <br>

                      <div class="flexcontainer">

                        <div style="flex:1">
                          <input value="MODIFIER LA CATÉGORIE" type="submit" name="categorie_edit_go">
                        </div>

                        <div class="align_right" style="flex:1">
                          <input class="button button-outline" value="SUPPRIMER LA CATÉGORIE" type="submit" name="categorie_delete_go" onclick="return confirm('Confirmer la suppression de la catégorie ?');">
                        </div>

                        <div class="align_right" style="flex:1">
                          <button type="button" class="button button-clear" onclick="toggle_oneway('categorie_editer_<?=$i?>', 0, 1);">MASQUER LE FORMULAIRE</button>
                        </div>

                      </div>

                      <br>

                    </fieldset>
                  </form>

                </div>

              </td>
            </tr>

            <?php } ?>

          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';