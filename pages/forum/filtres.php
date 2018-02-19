<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumFiltrage';

// Identification
$page_nom = "Choisit ce qu'il veut voir sur le forum";
$page_url = "pages/forum/filtres";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Filtrage du forum" : "Forum filtering preferences";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mise à jour des préférences de filtrage

if(isset($_POST['filtre_go']))
{
  // On commence par récupérer l'ID du membre et les préférences de langage
  $user_id            = postdata($_SESSION['user'], 'int', 0);
  $edit_filtre_fr     = postdata_vide('filtre_lang_fr', 'string', '');
  $edit_filtre_en     = postdata_vide('filtre_lang_en', 'string', '');
  $edit_filtre_lang   = ($edit_filtre_fr) ? 'FR' : '';
  $edit_filtre_lang  .= ($edit_filtre_en) ? 'EN' : '';

  // Puis on met à jour les préférences de langage
  query(" UPDATE  membres
          SET     membres.forum_lang  = '$edit_filtre_lang'
          WHERE   membres.id          = '$user_id' ");

  // Pour les catégories, on doit aller chercher la liste des catégories en excluant celle par défaut
  $qcategories = query("  SELECT    forum_categorie.id
                          FROM      forum_categorie
                          WHERE     forum_categorie.par_defaut = 0 ");

  // Puis parcourir cette liste de catégories
  while($dcategories = mysqli_fetch_array($qcategories))
  {
    // On vérifie si on doit filtrer cette catégorie
    $temp_categorie   = $dcategories['id'];
    $cat_filtre_check = postdata_vide('filtre_categorie_'.$temp_categorie, 'string', '');

    // On vérifie si le membre filtre cette catégorie
    $qcheckfiltre = mysqli_fetch_array(query("  SELECT  forum_filtrage.id
                                                FROM    forum_filtrage
                                                WHERE   forum_filtrage.FKmembres          = '$user_id'
                                                AND     forum_filtrage.FKforum_categorie  = '$temp_categorie' "));

    // Si on doit l'ajouter aux filtres, on le fait
    if(!$cat_filtre_check && !$qcheckfiltre['id'])
      query(" INSERT INTO forum_filtrage
              SET         forum_filtrage.FKmembres          = '$user_id'        ,
                          forum_filtrage.FKforum_categorie  = '$temp_categorie' ");

    // Si on doit le supprimer des filtres, on le fait
    if($cat_filtre_check && $qcheckfiltre['id'])
      query(" DELETE FROM forum_filtrage
              WHERE       forum_filtrage.FKmembres          = '$user_id'
              AND         forum_filtrage.FKforum_categorie  = '$temp_categorie' ");
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filtrage des langues

// On a besoin de l'ID du membre
$user_id = postdata($_SESSION['user'], 'int', 0);

// On va chercher ses filtrages de langues
$qchecklang = mysqli_fetch_array(query("  SELECT  membres.forum_lang
                                          FROM    membres
                                          WHERE   membres.id = '$user_id' "));

// Et on coche ou non les cases selon s'il y a filtrage ou non
$filtre_lang_fr = (!$qchecklang['forum_lang'] || strpos($qchecklang['forum_lang'], 'FR') !== false) ? ' checked' : '';
$filtre_lang_en = (!$qchecklang['forum_lang'] || strpos($qchecklang['forum_lang'], 'EN') !== false) ? ' checked' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filtrage des catégories

// On va chercher la liste des catégories
$qcategories = query("  SELECT    forum_categorie.id      ,
                                  forum_categorie.nom_fr  ,
                                  forum_categorie.nom_en
                        FROM      forum_categorie
                        WHERE     forum_categorie.par_defaut = 0
                        ORDER BY  forum_categorie.classement ASC ");

// Et on les prépare pour l'affichage
for($ncategories = 0; $dcategories = mysqli_fetch_array($qcategories); $ncategories++)
{
  $categorie_id[$ncategories]       = $dcategories['id'];
  $categorie_nom[$ncategories]      = ($lang == 'FR') ? predata($dcategories['nom_fr']) : predata($dcategories['nom_en']);

  // On a besoin de vérifier si l'user a filtré cette catégorie
  $temp_cat_id  = $dcategories['id'];
  $qcheckfiltre = mysqli_fetch_array(query("  SELECT  forum_filtrage.id
                                              FROM    forum_filtrage
                                              WHERE   forum_filtrage.FKmembres          = '$user_id'
                                              AND     forum_filtrage.FKforum_categorie  = '$temp_cat_id'  "));
  $categorie_checked[$ncategories]  = (!$qcheckfiltre['id']) ? ' checked' : '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']        = "Préférences de filtrage";
  $trad['soustitre']    = "Choisir ce que vous avez envie de voir sur le forum";
  $trad['desc']         = <<<EOD
Le <a class="gras" href="{$chemin}pages/forum/index">forum NoBleme</a> contient un mélange de langages et catégories de conversations, qui n'intéressent pas forcément tout le monde. Sur cette page, vous pouvez choisir d'exclure certains langages et/ou certaines catégories pour ne plus les voir apparaitre dans la liste des sujets.
EOD;

  // Langues
  $trad['lang_titre']   = "Langues à afficher";
  $trad['lang_legende'] = "Décochez une case pour masquer une langue";
  $trad['lang_fr']      = "Français";
  $trad['lang_en']      = "Anglais";

  // Catégories
  $trad['cat_titre']    = "Catégories à afficher";
  $trad['cat_legende']  = "Décochez une case pour masquer une catégorie de sujets";

  // Bouton
  $trad['go_texte']     = "MODIFIER MES PRÉFÉRENCES DE FILTRAGE";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']        = "Filtering preferences";
  $trad['soustitre']    = "Pick what you want to hide or see on the forum";
  $trad['desc']         = <<<EOD
<a class="gras" href="{$chemin}pages/forum/index">NoBleme's forum</a> contains a mixture of languages and conversation categories, some of which you might not care to read. On this page, you can choose to exclude some languages and/or categories, which will not appear anymore for you on the forum's topic list.
EOD;

  // Langues
  $trad['lang_titre']   = "Languages to show";
  $trad['lang_legende'] = "Uncheck a box to hide a language";
  $trad['lang_fr']      = "French";
  $trad['lang_en']      = "English";

  // Catégories
  $trad['cat_titre']    = "Categories to show";
  $trad['cat_legende']  = "Uncheck a box to hide a conversation category";

  // Bouton
  $trad['go_texte']     = "EDIT MY FILTERING PREFERENCES";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <?php if(getadmin()) { ?>
          <a href="<?=$chemin?>pages/forum/filtres_modifier">
            <img class="pointeur" src="<?=$chemin?>img/icones/modifier.png" alt="M">
          </a>
          <?php } ?>
        </h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <br>
        <br>

        <form method="POST">
          <fieldset>

            <h5><?=$trad['lang_titre']?></h5>

            <br>

            <label><?=$trad['lang_legende']?></label>

            <input id="filtre_lang_fr" name="filtre_lang_fr" type="checkbox"<?=$filtre_lang_fr?>>
            <label class="label-inline" for="filtre_lang_fr"><?=$trad['lang_fr']?></label><br>

            <input id="filtre_lang_en" name="filtre_lang_en" type="checkbox"<?=$filtre_lang_en?>>
            <label class="label-inline" for="filtre_lang_en"><?=$trad['lang_en']?></label><br>
            <br>

            <h5><?=$trad['cat_titre']?></h5>

            <br>

            <label><?=$trad['cat_legende']?></label>

            <?php for($i=0;$i<$ncategories;$i++) { ?>
            <input id="filtre_categorie_<?=$categorie_id[$i]?>" name="filtre_categorie_<?=$categorie_id[$i]?>" type="checkbox"<?=$categorie_checked[$i]?>>
            <label class="label-inline" for="filtre_categorie_<?=$categorie_id[$i]?>"><?=$categorie_nom[$i]?></label><br>
            <?php } ?>

            <br>

            <input value="<?=$trad['go_texte']?>" type="submit" name="filtre_go">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';