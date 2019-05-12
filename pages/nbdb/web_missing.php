<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbdb.inc.php';     // Fonctions lées à la NBDB

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




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche des pages manquantes dans l'encyclopédie de la culture web en français

// On va chercher le contenu de toutes les pages de l'encyclopédie du web en français
$qwebmiss = query(" SELECT  nbdb_web_page.contenu_fr      AS 'w_contenu_fr'
                    FROM    nbdb_web_page
                    WHERE   nbdb_web_page.redirection_fr  LIKE ''
                    AND     nbdb_web_page.contenu_fr  NOT LIKE '' ");

// On initialise les listes des liens morts
$web_liens_morts_fr = array();

// Puis on parcourt ces pages à la recherche de liens morts
while($dwebmiss = mysqli_fetch_array($qwebmiss))
{
  // On récupère toutes les instances d'un lien
  $temp_definition = $dwebmiss['w_contenu_fr'];
  preg_match_all('/\[\[web:(.*?)\|(.*?)\]\]/', $temp_definition, $resultats);

  // On parcourt ces instances
  $i = 0;
  foreach($resultats[0] as $pattern)
  {
    // On vérifie si le lien est mort ou non
    $temp_lien_mort = (in_array(changer_casse(html_entity_decode($resultats[1][$i], ENT_QUOTES), 'min'), nbdb_web_liste_pages_encyclopedie('FR'))) ? '' : $resultats[1][$i];

    // Si oui, on l'ajoute dans le tableau des liens morts
    if($temp_lien_mort)
      array_push($web_liens_morts_fr, $temp_lien_mort);

    // On peut passer au lien suivant
    $i++;
  }
}

// On supprime les doublons
$web_liens_morts_fr = array_unique($web_liens_morts_fr);

// On trie le tableau
natcasesort($web_liens_morts_fr);
$web_liens_morts_fr = array_values($web_liens_morts_fr);

// Et pour finir on a besoin du nombre d'entrées dans le tableau
$nweb_liens_morts_fr = count($web_liens_morts_fr);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche des pages manquantes dans l'encyclopédie de la culture web en anglais

// Maintenant on peut faire la même chose en anglais (redondance quand tu nous tiens)
$qwebmiss = query(" SELECT  nbdb_web_page.contenu_en      AS 'w_contenu_en'
                    FROM    nbdb_web_page
                    WHERE   nbdb_web_page.redirection_en  LIKE ''
                    AND     nbdb_web_page.contenu_en  NOT LIKE '' ");

// On initialise les listes des liens morts
$web_liens_morts_en = array();

// Puis on parcourt ces pages à la recherche de liens morts
while($dwebmiss = mysqli_fetch_array($qwebmiss))
{
  // On récupère toutes les instances d'un lien
  $temp_definition = $dwebmiss['w_contenu_en'];
  preg_match_all('/\[\[web:(.*?)\|(.*?)\]\]/', $temp_definition, $resultats);

  // On parcourt ces instances
  $i = 0;
  foreach($resultats[0] as $pattern)
  {
    // On vérifie si le lien est mort ou non
    $temp_lien_mort = (in_array(changer_casse(html_entity_decode($resultats[1][$i], ENT_QUOTES), 'min'), nbdb_web_liste_pages_encyclopedie('EN'))) ? '' : $resultats[1][$i];
    // Si oui, on l'ajoute dans le tableau des liens morts
    if($temp_lien_mort)
      array_push($web_liens_morts_en, $temp_lien_mort);
    // On peut passer au lien suivant
    $i++;
  }
}

// On supprime les doublons
$web_liens_morts_en = array_unique($web_liens_morts_en);

// On trie le tableau
natcasesort($web_liens_morts_en);
$web_liens_morts_en = array_values($web_liens_morts_en);

// Et pour finir on a besoin du nombre d'entrées dans le tableau
$nweb_liens_morts_en = count($web_liens_morts_en);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche des pages manquantes dans le dictionnaire de la culture web en français

// On peut maintenant passer au dictionnaire du web, en français
$qdicomiss = query("  SELECT  nbdb_web_definition.definition_fr   AS 'd_definition_fr'
                      FROM    nbdb_web_definition
                      WHERE   nbdb_web_definition.redirection_fr  LIKE ''
                      AND     nbdb_web_definition.definition_fr   NOT LIKE '' ");

// On initialise les listes des liens morts
$dico_liens_morts_fr = array();

// Puis on parcourt ces pages à la recherche de liens morts
while($ddicomiss = mysqli_fetch_array($qdicomiss))
{
  // On récupère toutes les instances d'un lien
  $temp_definition = $ddicomiss['d_definition_fr'];
  preg_match_all('/\[\[dico:(.*?)\|(.*?)\]\]/', $temp_definition, $resultats);

  // On parcourt ces instances
  $i = 0;
  foreach($resultats[0] as $pattern)
  {
    // On vérifie si le lien est mort ou non
    $temp_lien_mort = (in_array(changer_casse(html_entity_decode($resultats[1][$i], ENT_QUOTES), 'min'), nbdb_web_liste_pages_dictionnaire('FR'))) ? '' : $resultats[1][$i];
    // Si oui, on l'ajoute dans le tableau des liens morts
    if($temp_lien_mort)
      array_push($dico_liens_morts_fr, $temp_lien_mort);
    // On peut passer au lien suivant
    $i++;
  }
}

// On supprime les doublons
$dico_liens_morts_fr = array_unique($dico_liens_morts_fr);

// On trie le tableau
natcasesort($dico_liens_morts_fr);
$dico_liens_morts_fr = array_values($dico_liens_morts_fr);

// Et pour finir on a besoin du nombre d'entrées dans le tableau
$ndico_liens_morts_fr = count($dico_liens_morts_fr);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche des pages manquantes dans le dictionnaire de la culture web en anglais

// On peut maintenant passer au dictionnaire du web, en anglais... on y est presque
$qdicomiss = query("  SELECT  nbdb_web_definition.definition_en   AS 'd_definition_en'
                      FROM    nbdb_web_definition
                      WHERE   nbdb_web_definition.redirection_en  LIKE ''
                      AND     nbdb_web_definition.definition_en   NOT LIKE '' ");

// On initialise les listes des liens morts
$dico_liens_morts_en = array();

// Puis on parcourt ces pages à la recherche de liens morts
while($ddicomiss = mysqli_fetch_array($qdicomiss))
{
  // On récupère toutes les instances d'un lien
  $temp_definition = $ddicomiss['d_definition_en'];
  preg_match_all('/\[\[dico:(.*?)\|(.*?)\]\]/', $temp_definition, $resultats);

  // On parcourt ces instances
  $i = 0;
  foreach($resultats[0] as $pattern)
  {
    // On vérifie si le lien est mort ou non
    $temp_lien_mort = (in_array(changer_casse(html_entity_decode($resultats[1][$i], ENT_QUOTES), 'min'), nbdb_web_liste_pages_dictionnaire('EN'))) ? '' : $resultats[1][$i];
    // Si oui, on l'ajoute dans le tableau des liens morts
    if($temp_lien_mort)
      array_push($dico_liens_morts_en, $temp_lien_mort);
    // On peut passer au lien suivant
    $i++;
  }
}

// On supprime les doublons
$dico_liens_morts_en = array_unique($dico_liens_morts_en);

// On trie le tableau
natcasesort($dico_liens_morts_en);
$dico_liens_morts_en = array_values($dico_liens_morts_en);

// Et pour finir on a besoin du nombre d'entrées dans le tableau
$ndico_liens_morts_en = count($dico_liens_morts_en);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h2 class="align_center">NBDB - Pages manquantes</h2>

        <br>
        <br>

        <div class="flexcontainer">
          <div style="flex:5">

            <h3 class="align_center">FRANÇAIS</h3>

            <br>
            <br>

            <h4 class="align_center">Encyclopédie du web</h4>

            <br>

            <div class="texte_negatif">

              <?php for($i=0;$i<$nweb_liens_morts_fr;$i++) { ?>

              <?=$web_liens_morts_fr[$i]?><br>

              <?php } ?>

            </div>

            <br>
            <br>

            <h4 class="align_center">Dictionnaire du web</h4>

            <br>

            <div class="texte_negatif">

              <?php for($i=0;$i<$ndico_liens_morts_fr;$i++) { ?>

              <?=$dico_liens_morts_fr[$i]?><br>

              <?php } ?>

            </div>

          </div>
          <div style="flex:1">
            &nbsp;
          </div>
          <div style="flex:5">

            <h3 class="align_center">ANGLAIS</h3>

            <br>
            <br>

            <h4 class="align_center">Encyclopédie du web</h4>

            <br>

            <div class="texte_negatif">

              <?php for($i=0;$i<$nweb_liens_morts_en;$i++) { ?>

              <?=$web_liens_morts_en[$i]?><br>

              <?php } ?>

            </div>

            <br>
            <br>

            <h4 class="align_center">Dictionnaire du web</h4>

            <br>

            <div class="texte_negatif">

              <?php for($i=0;$i<$ndico_liens_morts_en;$i++) { ?>

              <?=$dico_liens_morts_en[$i]?><br>

              <?php } ?>

            </div>

          </div>
        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';