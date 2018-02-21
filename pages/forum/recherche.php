<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumRecherche';

// Identification
$page_nom = "Effectue une recherche sur le forum";
$page_url = "pages/forum/recherche";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Forum : Recherche" : "Forum: Search";
$page_desc  = "Rechercher du contenu parmi les sujets et messages du forum NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Formulaire de recherche

// Assainissement du postdata
$forum_search_texte     = postdata_vide('forum_search_texte', 'string', '');
$forum_search_auteur    = postdata_vide('forum_search_auteur', 'string', '');
$forum_search_sujets    = isset($_POST['forum_search_go']) ? postdata_vide('forum_search_sujets', 'string', '')   : 'on';
$forum_search_messages  = isset($_POST['forum_search_go']) ? postdata_vide('forum_search_messages', 'string', '') : 'on';
$forum_search_anonyme   = isset($_POST['forum_search_go']) ? postdata_vide('forum_search_anonyme', 'string', '')  : 'on';
$forum_search_jeux      = isset($_POST['forum_search_go']) ? postdata_vide('forum_search_jeux', 'string', '')     : '';

// De même pour la liste des catégories
$forum_search_categories = array();
$qcategories = query("  SELECT  forum_categorie.id
                        FROM    forum_categorie ");
while($dcategories = mysqli_fetch_array($qcategories))
  $forum_search_categories[$dcategories['id']] = isset($_POST['forum_search_go']) ? postdata_vide('forum_search_categorie_'.$dcategories['id'], 'string', '') : 'on';

// On va chercher l'id du pseudonyme recherché
if($forum_search_auteur)
{
  $qsearchpseudo = mysqli_fetch_array(query(" SELECT  membres.id
                                              FROM    membres
                                              WHERE   membres.pseudonyme LIKE '$forum_search_auteur' "));
  if($qsearchpseudo['id'])
    $forum_search_membre = $qsearchpseudo['id'];
  else
    $forum_search_erreur = ($lang == 'FR') ? "Le pseudonyme que vous avez rentré n'existe pas sur NoBleme" : "The nickname you entered does not exist on NoBleme";
}

// On s'assure qu'il n'y ait pas d'erreur
if(!$forum_search_texte && !$forum_search_auteur)
  $forum_search_erreur = ($lang == 'FR') ? "Vous devez remplir au moins un des deux premiers champs de recherche" : "You must fill at least one of the first two text forms";
if($forum_search_texte && strlen($forum_search_texte) < 3)
  $forum_search_erreur = ($lang == 'FR') ? "Le texte à chercher doit faire au moins 3 caractères de long" : "The text search must be at least 3 characters long";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recherche par sujets

if(isset($_POST['forum_search_go']) && !isset($forum_search_erreur) && $forum_search_sujets)
{
  // On prépare la recherche
  $qsujets_texte          = ($forum_search_texte) ? " , MATCH (forum_sujet.titre) AGAINST ('%$forum_search_texte%' IN BOOLEAN MODE) " : '';
  $qsujets_texte_where    = ($forum_search_texte) ? " WHERE MATCH (forum_sujet.titre) AGAINST ('%$forum_search_texte%') > 0 " : ' WHERE 1 = 1 ';
  $qmessages_texte        = ($forum_search_texte) ? " , MATCH (forum_message.contenu) AGAINST ('%$forum_search_texte%' IN BOOLEAN MODE) " : '';
  $qmessages_texte_where  = ($forum_search_texte) ? " WHERE MATCH (forum_message.contenu) AGAINST ('%$forum_search_texte%') > 0 " : ' WHERE 1 = 1 ';

  // On va chercher les sujets
  $qsujets = query("  SELECT    forum_sujet.titre     AS 's_titre'
                                $qsujets_texte
                      FROM      forum_sujet
                                $qsujets_texte_where
                      ORDER BY  forum_sujet.timestamp_creation DESC ");

  // Qu'on prépare ensuite pour l'affichage
  for($nsujets = 0; $dsujets = mysqli_fetch_array($qsujets); $nsujets++)
  {
    $sujet_titre[$nsujets]    = html_autour($forum_search_texte, predata(tronquer_chaine($dsujets['s_titre'], 55, '...')), '<ins>', '</ins>');;
    $sujet_message[$nsujets]  = '-';
  }

  // Puis les messages individuels
  $qsujets = query("  SELECT    forum_sujet.titre     AS 's_titre'    ,
                                forum_message.contenu AS 's_message'
                                $qmessages_texte
                      FROM      forum_message
                      LEFT JOIN forum_sujet ON forum_message.FKforum_sujet = forum_sujet.id
                                $qmessages_texte_where
                      ORDER BY  forum_message.timestamp_creation DESC ");

  // Qu'on prépare ensuite pour l'affichage
  for(; $dsujets = mysqli_fetch_array($qsujets); $nsujets++)
  {
    $sujet_titre[$nsujets]    = predata(tronquer_chaine($dsujets['s_titre'], 55, '...'));
    $sujet_message[$nsujets]  = bbcode(html_autour($forum_search_texte, predata(tronquer_chaine(search_wrap($forum_search_texte, $dsujets['s_message'], 5), 80, '...')), '<ins>', '</ins>'));
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des catégories pour la recherche

// Si le membre est connecté, on récupère ses préférences de filtrage
$filtre_categories = ' ';
if(loggedin())
{
  // On va chercher s'il a un filtagee par catégorie en place
  $user_id   = postdata($_SESSION['user'], 'int', 0);
  $qforumcat = query("  SELECT  forum_filtrage.FKforum_categorie
                        FROM    forum_filtrage
                        WHERE   forum_filtrage.FKmembres = '$user_id' ");

  // S'il y en a, on parcourt les filtres pour créer les conditions
  if(mysqli_num_rows($qforumcat))
  {
    while($dforumcat = mysqli_fetch_array($qforumcat))
      $filtre_categories .= " AND forum_categorie.id != '".$dforumcat['FKforum_categorie']."' ";
  }
}

// On va chercher la liste des catégories non filtrées autres que celle par défaut
$qcategories = query("  SELECT    forum_categorie.id      ,
                                  forum_categorie.nom_fr  ,
                                  forum_categorie.nom_en
                        FROM      forum_categorie
                        WHERE     1 = 1
                                  $filtre_categories
                        ORDER BY  forum_categorie.par_defaut DESC ,
                                  forum_categorie.classement ASC  ");

// Et on les prépare pour l'affichage
for($ncategories = 0; $dcategories = mysqli_fetch_array($qcategories); $ncategories++)
{
  $categorie_id[$ncategories]       = $dcategories['id'];
  $categorie_nom[$ncategories]      = ($lang == 'FR') ? predata($dcategories['nom_fr']) : predata($dcategories['nom_en']);
  $categorie_checked[$ncategories]  = ($forum_search_categories[$dcategories['id']]) ? ' checked' : '';
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pré-remplissage des champs de recherche

// Champs de texte
$search_texte   = isset($_POST['forum_search_texte'])   ? predata($_POST['forum_search_texte'])  : '';
$search_auteur  = isset($_POST['forum_search_auteur'])  ? predata($_POST['forum_search_auteur']) : '';

// Checkboxes
$checked_sujets   = ($forum_search_sujets)    ? ' checked'  : '';
$checked_messages = ($forum_search_messages)  ? ' checked'  : '';
$checked_anonyme  = ($forum_search_anonyme)   ? ' checked'  : '';
$checked_jeux     = ($forum_search_jeux)      ? ' checked'  : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Recherche sur le forum";
  $trad['soustitre']      = "Trouver des messages et/ou sujets sur le forum NoBleme";
  $trad['desc']           = <<<EOD
Vous êtes à la recherche de contenu spécifique sur le <a class="gras" href="{$chemin}pages/forum/index">forum NoBleme</a> ? Remplissez une partie du formulaire de recherche ci-dessous, puis exécutez la recherche, et vous trouverez peut-être ce que vous cherchiez. Notez que les résultats de votre recherche prennent en compte vos <a class="gras" href="{$chemin}pages/forum/filtres">préférences de filtrage</a>.
EOD;

  // Formulaire de recherche
  $trad['form_texte']     = "Texte à chercher sur le forum";
  $trad['form_auteur']    = "Pseudonyme de l'auteur du sujet ou message";
  $trad['form_contenu']   = "Contenu dans lequel chercher";
  $trad['form_criteres']  = "Critères de recherche";
  $trad['form_sujets']    = "Sujets de discussion";
  $trad['form_posts']     = "Contenu des messages";
  $trad['form_anon']      = "Inclure les sujets anonymes dans la recherche";
  $trad['form_jeux']      = "Inclure les jeux de forum dans la recherche";
  $trad['form_cat']       = "Catégories dans lesquelles chercher";
  $trad['form_go']        = "EXÉCUTER LA RECHERCHE SUR LE FORUM NOBLEME";

  // Résultats de la recherche
  $trad['res_erreur']     = "Erreur :";
  $trad['res_titre']      = "Résultats de la recherche :";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['desc']?></p>

        <br>
        <br>

        <form method="POST" action="recherche#recherche_resultats">
          <fieldset>

            <label for="forum_search_texte"><?=$trad['form_texte']?></label>
            <input id="forum_search_texte" name="forum_search_texte" class="indiv" type="text" value="<?=$search_texte?>"><br>
            <br>

            <label for="forum_search_auteur"><?=$trad['form_auteur']?></label>
            <input id="forum_search_auteur" name="forum_search_auteur" class="indiv" type="text" value="<?=$search_auteur?>"><br>

            <br>

            <label><?=$trad['form_contenu']?></label>

            <input id="forum_search_sujets" name="forum_search_sujets" type="checkbox"<?=$checked_sujets?>>
            <label class="label-inline" for="forum_search_sujets"><?=$trad['form_sujets']?></label><br>

            <input id="forum_search_messages" name="forum_search_messages" type="checkbox"<?=$checked_messages?>>
            <label class="label-inline" for="forum_search_messages"><?=$trad['form_posts']?></label><br>

            <br>

            <?php if($ncategories > 1) { ?>

            <label><?=$trad['form_cat']?></label>

            <?php for($i=0;$i<$ncategories;$i++) { ?>

            <input id="forum_search_categorie_<?=$categorie_id[$i]?>" name="forum_search_categorie_<?=$categorie_id[$i]?>" type="checkbox"<?=$categorie_checked[$i]?>>
            <label class="label-inline" for="forum_search_categorie_<?=$categorie_id[$i]?>"><?=$categorie_nom[$i]?></label><br>

            <?php } ?>

            <br>

            <label><?=$trad['form_criteres']?></label>

            <input id="forum_search_anonyme" name="forum_search_anonyme" type="checkbox"<?=$checked_anonyme?>>
            <label class="label-inline" for="forum_search_anonyme"><?=$trad['form_anon']?></label><br>

            <input id="forum_search_jeux" name="forum_search_jeux" type="checkbox"<?=$checked_jeux?>>
            <label class="label-inline" for="forum_search_jeux"><?=$trad['form_jeux']?></label><br>

            <br>

            <?php } ?>

            <input value="<?=$trad['form_go']?>" type="submit" name="forum_search_go">

          </fieldset>
        </form>

      </div>

      <?php if(isset($_POST['forum_search_go'])) { ?>

      <br>
      <br>
      <hr class="separateur_contenu" id="recherche_resultats">
      <br>
      <br>

      <?php if(isset($forum_search_erreur)) { ?>

      <div class="tableau align_center">

        <h4 class="texte_negatif"><span class="souligne"><?=$trad['res_erreur']?></span> <?=$forum_search_erreur?></h4>

      </div>

      <?php } else { ?>

      <div class="tableau">

        <h2><?=$trad['res_titre']?></h2>

        <br>
        <br>

        <table class="grid titresnoirs nowrap">
          <thead>
            <tr>
              <th>
                SUJET
              </th>
              <th>
                MESSAGE
              </th>
              <th>
                AUTEUR
              </th>
              <th>
                DATE
              </th>
            </tr>
          </thead>
          <tbody class="align_center">

            <?php for($i=0;$i<$nsujets;$i++) { ?>
            <tr>
              <td>
                <?=$sujet_titre[$i]?>
              </td>
              <td>
                <?=$sujet_message[$i]?>
              </td>
              <td>
                
              </td>
              <td>
                
              </td>
            </tr>
            <?php } ?>

          </tbody>
        </table>

      </div>

      <?php } ?>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';