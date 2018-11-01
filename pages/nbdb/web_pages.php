<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbdb.inc.php';     // Fonctions lées à la NBDB

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloListe';

// Identification
$page_nom = "Parcourt la culture du web";
$page_url = "pages/nbdb/web_pages";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "NBDB : Culture internet" : "NBDB: Internet culture";
$page_desc  = "Liste des pages de l'encyclopédie de la culture internet, des obscurs bulletin boards d'antan aux memes modernes.";

// CSS & JS
$css  = array('nbdb');
$js   = array('dynamique', 'nbdb/web_pages');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des pages

// On spécifique la langue à utiliser
$web_lang = changer_casse($lang, 'min');

// On spéficie si on veut les redirections ou non
$where_web_redirections = getadmin() ? " " : " AND nbdb_web_page.redirection_$web_lang LIKE '' ";

// On spéficie si on filtre par catégorie ou non
$filtre_categorie     = (isset($_GET['categorie'])) ? postdata($_GET['categorie'], 'int', 0) : 0;
$where_web_categorie  = (isset($_GET['categorie']) && $filtre_categorie) ? " AND nbdb_web_page_categorie.FKnbdb_web_categorie = '$filtre_categorie' " : '';

// On spéficie si on filtre par période ou non
$filtre_periode     = (isset($_GET['periode'])) ? postdata($_GET['periode'], 'int', 0) : 0;
$where_web_periode  = (isset($_GET['periode']) && $filtre_periode) ? " AND nbdb_web_page.FKnbdb_web_periode = '$filtre_periode' " : '';

// On spécifie s'il y a une recherche en cours ou non
$where_search     = postdata_vide('search', 'string', '');
$where_web_search = ($where_search) ? " AND nbdb_web_page.titre_$web_lang LIKE '%$where_search%' " : '';

// On va chercher la liste des définitions pour notre langue
if(!isset($_GET['categorie']) || !$filtre_categorie)
  $qweb = query(" SELECT    nbdb_web_page.redirection_$web_lang  AS 'd_redirect' ,
                            nbdb_web_page.titre_$web_lang        AS 'd_titre'
                  FROM      nbdb_web_page
                  WHERE     nbdb_web_page.titre_$web_lang  NOT LIKE ''
                            $where_web_redirections
                            $where_web_periode
                            $where_web_search
                  ORDER BY  nbdb_web_page.titre_$web_lang REGEXP '^[a-z]' DESC  ,
                            nbdb_web_page.titre_$web_lang                       ");

// La requête est différente si on cherche par catégorie
else if($filtre_categorie > 0)
  $qweb = query(" SELECT    nbdb_web_page.redirection_$web_lang  AS 'd_redirect' ,
                            nbdb_web_page.titre_$web_lang        AS 'd_titre'
                  FROM      nbdb_web_page_categorie
                  LEFT JOIN nbdb_web_page ON nbdb_web_page_categorie.FKnbdb_web_page = nbdb_web_page.id
                  WHERE     nbdb_web_page.titre_$web_lang  NOT LIKE ''
                            $where_web_redirections
                            $where_web_categorie
                  GROUP BY  nbdb_web_page_categorie.FKnbdb_web_page
                  ORDER BY  nbdb_web_page.titre_$web_lang REGEXP '^[a-z]' DESC  ,
                            nbdb_web_page.titre_$web_lang                       ");

// Et encore différente si on veut les pages non catégorisées
else
  $qweb = query(" SELECT    nbdb_web_page.redirection_$web_lang  AS 'd_redirect' ,
                            nbdb_web_page.titre_$web_lang        AS 'd_titre'
                  FROM      nbdb_web_page
                  LEFT JOIN nbdb_web_page_categorie ON nbdb_web_page_categorie.FKnbdb_web_page = nbdb_web_page.id
                  WHERE     nbdb_web_page.titre_$web_lang  NOT LIKE ''
                  AND       nbdb_web_page_categorie.FKnbdb_web_page IS NULL
                  AND       nbdb_web_page.redirection_$web_lang     LIKE ''
                  ORDER BY  nbdb_web_page.titre_$web_lang REGEXP '^[a-z]' DESC  ,
                            nbdb_web_page.titre_$web_lang                       ");

// Préparation pour l'affichage
for($nweb = 0 ; $dweb = mysqli_fetch_array($qweb) ; $nweb++)
{
  $temp_lettre          = substr(remplacer_accents(changer_casse($dweb['d_titre'], 'maj')), 0, 1);
  $temp_specialchars    = ($lang == 'FR') ? 'Divers' : 'Various';
  $web_lettre[$nweb]    = (ctype_alpha($temp_lettre)) ? $temp_lettre : $temp_specialchars;
  $web_titre[$nweb]     = predata($dweb['d_titre']);
  $web_titre_css[$nweb] = ($dweb['d_redirect']) ? 'gras texte_noir' : 'gras';
  $web_titre_url[$nweb] = urlencode($dweb['d_titre']);
  $web_redirect[$nweb]  = ($dweb['d_redirect']) ? ' -> '.predata($dweb['d_redirect']) : '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Informations sur la catégorie ou la période

// On vérifie si on doit sortir des infos sur la catégorie
if(isset($_GET['categorie']) && $filtre_categorie > 0)
{
  // On commence par vérifier si la catégorie existe
  if(verifier_existence('nbdb_web_categorie', $filtre_categorie))
  {
    // Maintenant, on peut aller piocher les détails de la catégorie
    $dcategorie = mysqli_fetch_array(query("  SELECT    nbdb_web_categorie.titre_$web_lang        AS 'c_titre' ,
                                                        nbdb_web_categorie.description_$web_lang  AS 'c_desc'
                                              FROM      nbdb_web_categorie
                                              WHERE     nbdb_web_categorie.id = '$filtre_categorie' "));

    // Et les préparer pour l'affichage
    $categorie_titre  = predata($dcategorie['c_titre']);
    $categorie_desc   = nbdbcode(bbcode(predata($dcategorie['c_desc'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang));
  }
}

// On vérifie si on doit sortir des infos sur la période
if(isset($_GET['periode']) && $filtre_periode)
{
  // On commence par vérifier si la période existe
  if(verifier_existence('nbdb_web_periode', $filtre_periode))
  {
    // Maintenant, on peut aller piocher les détails de la catégorie
    $dperiode = mysqli_fetch_array(query("  SELECT    nbdb_web_periode.titre_$web_lang        AS 'p_titre'  ,
                                                      nbdb_web_periode.description_$web_lang  AS 'p_desc'
                                            FROM      nbdb_web_periode
                                            WHERE     nbdb_web_periode.id = '$filtre_periode' "));

    // Et les préparer pour l'affichage
    $periode_titre  = predata($dperiode['p_titre']);
    $periode_desc   = nbdbcode(bbcode(predata($dperiode['p_desc'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang));
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des catégories

// On va chercher la liste des catégories
$qcategories = query("  SELECT    nbdb_web_categorie.id               AS 'c_id' ,
                                  nbdb_web_categorie.titre_$web_lang  AS 'c_titre'
                        FROM      nbdb_web_categorie
                        ORDER BY  nbdb_web_categorie.ordre_affichage ASC ");

// Et on remplit le menu déroulant
$select_categories = '';
while($dcategories = mysqli_fetch_array($qcategories))
  $select_categories .= '<option value='.$dcategories['c_id'].'>'.predata($dcategories['c_titre']).'</option>';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des périodes

// On va chercher les périodes
$qperiodes = query("  SELECT    nbdb_web_periode.id               AS 'p_id'     ,
                                nbdb_web_periode.titre_$web_lang  AS 'p_titre'  ,
                                nbdb_web_periode.annee_debut      AS 'p_debut'  ,
                                nbdb_web_periode.annee_fin        AS 'p_fin'
                      FROM      nbdb_web_periode
                      ORDER BY  nbdb_web_periode.annee_debut  ASC ,
                                nbdb_web_periode.annee_fin    ASC ");

// Et on remplit le menu déroulant
$select_periodes  = '';
while($dperiodes = mysqli_fetch_array($qperiodes))
{
  $temp_annees      = ($dperiodes['p_debut']) ? $dperiodes['p_debut'].' - ' : 'XXXX - ';
  $temp_annees      = ($dperiodes['p_fin']) ? $temp_annees.$dperiodes['p_fin'] : $temp_annees.' XXXX';
  $select_periodes .= '<option value="'.$dperiodes['p_id'].'">'.$temp_annees.' &nbsp; '.predata($dperiodes['p_titre']).'</option>';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Introduction
  $trad['titre']          = "Encyclopédie de la culture web";
  $trad['soustitre']      = "Documentation de l'histoire des memes et de la culture d'internet";
  $trad['description']    = <<<EOD
  Vous trouverez ci-dessous la liste de toutes les pages formant <a class="gras" href="{$chemin}pages/nbdb/web">l'encyclopédie de la culture internet</a>. Le contenu couvert par cette encyclopédie étant très large, vous pouvez utiliser les menus déroulants situés juste en dessous pour filtrer les pages appartenant à une catégorie ou à une période spécifique. En dessous, vous trouverez également un champ de recherche, au cas où vous seriez à la recherche d'une page spécifique.
EOD;

  // Header
  $trad['web_search']     = "Chercher une page dans l'encyclopédie";
  $trad['web_search2']    = "Chercher dans les titres uniquement";
  $trad['web_selecteur']  = "Sélectionner une catégorie ou une période";
  $trad['web_nocat']      = "Pages non catégorisées";

  // Catégories et périodes
  $trad['web_categorie']  = "Catégorie :";
  $trad['web_periode']    = "Période :";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Introduction
  $trad['titre']          = "Internet culture encyclopedia";
  $trad['soustitre']      = "Documenting the history of memes and internet culture";

  // Header
  $trad['web_search']     = "Search the encyclopedia for a specific page";
  $trad['web_search2']    = "Search page titles only";
  $trad['web_selecteur']  = "Select a category or an era";
  $trad['web_nocat']      = "Uncategorized pages";
  $trad['description']    = <<<EOD
  On this page, you will find a list of all the entries in the <a class="gras" href="{$chemin}pages/nbdb/web">encyclopedia of internet culture</a>. Since the encyclopedia covers a lot of varied content, you can use the dropdown menus below to show pages belonging to a specific category or era. Below them, you will find a text field, in case you are looking for a specific page.
EOD;

  // Catégories et périodes
  $trad['web_categorie']  = "Category:";
  $trad['web_periode']    = "Era:";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte align_justify">

        <h1>
          <a href="<?=$chemin?>pages/nbdb/web">
            <?=$trad['titre']?>
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_images">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/upload.svg" alt="+" height="22">
          </a>
          <a href="<?=$chemin?>pages/nbdb/web_edit">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="22">
          </a>
          <?php } ?>
        </h5>

        <p>
          <?=$trad['description']?>
        </p>

        <br>

        <div class="gras">
          <form method="POST">
            <fieldset>

              <label for="web_pages_categorie"><?=$trad['web_selecteur']?></label>
              <select id="web_pages_categorie" name="web_pages_categorie" class="web_pages_selecteur_categorie" onchange="web_pages_select_categorie('<?=$chemin?>');">
                <option value="0"></option>
                <?=$select_categories?>
                <option value="-1"><?=$trad['web_nocat']?></option>
              </select>
              <?php if($est_admin) { ?>
              <a href="<?=$chemin?>pages/nbdb/web_categories_edit">
                &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="24">
              </a>
              <?php } ?>
              <br>

              <select id="web_pages_periode" name="web_pages_periode" class="web_pages_selecteur_periode" onchange="web_pages_select_periode('<?=$chemin?>');">
                <option value="0"></option>
                <?=$select_periodes?>
              </select>
              <?php if($est_admin) { ?>
              <a href="<?=$chemin?>pages/nbdb/web_periodes_edit">
                &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="24">
              </a>
              <?php } ?>
              <br>
              <br>

              <label for="web_pages_search"><?=$trad['web_search']?></label>
              <input id="web_pages_search" name="web_pages_search" class="web_pages_champ_recherche" type="text" onkeyup="web_pages_recherche('<?=$chemin?>');"><br>

            </fieldset>
          </form>
        </div>

        <br>

        <?php } ?>

        <div id="web_pages_liste">

          <?php if(isset($categorie_desc)) { ?>

          <hr class="separateur_contenu">
          <br>

          <h4>
            <?=$trad['web_categorie']?> <?=$categorie_titre?>
          </h4>

          <?php if($categorie_desc) { ?>
          <p>
            <?=$categorie_desc?>
          </p>
          <?php } ?>

          <br>
          <hr class="separateur_contenu">
          <br>

          <?php } if(isset($periode_desc)) { ?>

          <hr class="separateur_contenu">
          <br>

          <h4>
            <?=$trad['web_periode']?> <?=$periode_titre?>
          </h4>

          <?php if($periode_desc) { ?>
          <p>
            <?=$periode_desc?>
          </p>
          <?php } ?>

          <br>
          <hr class="separateur_contenu">
          <br>

          <?php } ?>

          <?php for($i=0;$i<$nweb;$i++) { ?>

          <?php if($i == 0 || $web_lettre[$i] != $web_lettre[$i-1]) { ?>

          <br>
          <h4><?=$web_lettre[$i]?></h4>
          <br>

          <?php } ?>

          <ul>
            <li>
              <a class="<?=$web_titre_css[$i]?>" href="<?=$chemin?>pages/nbdb/web?page=<?=$web_titre_url[$i]?>"><?=$web_titre[$i]?></a> <?=$web_redirect[$i]?>
            </li>
          </ul>

          <?php } ?>

        </div>

      </div>

      <?php if(!getxhr()) { ?>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }
