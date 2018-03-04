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
if($forum_search_auteur && $forum_search_anonyme)
  $forum_search_erreur = ($lang == 'FR') ? "Impossible de faire une recherche par pseudonyme tout en incluant les sujets anonymes" : "Can't include anonymous threads when searching posts by author";
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
// Résultats de la recherche
if(isset($_POST['forum_search_go']) && !isset($forum_search_erreur))
{
  // On prépare la recherche de texte
  $qsujets_texte          = ($forum_search_texte) ? " , MATCH (forum_sujet.titre) AGAINST ('$forum_search_texte' IN BOOLEAN MODE) " : '';
  $qsujets_texte_where    = ($forum_search_texte) ? " WHERE MATCH (forum_sujet.titre) AGAINST ('$forum_search_texte') > 0 " : ' WHERE 1 = 1 ';
  $qmessages_texte        = ($forum_search_texte) ? " , MATCH (forum_message.contenu) AGAINST ('$forum_search_texte' IN BOOLEAN MODE) " : '';
  $qmessages_texte_where  = ($forum_search_texte) ? " WHERE MATCH (forum_message.contenu) AGAINST ('$forum_search_texte') > 0 " : ' WHERE 1 = 1 ';

  // Ainsi que la recherche de pseudonymes
  $qsujets_pseudo   = ($forum_search_auteur) ? " AND forum_sujet.FKmembres_createur LIKE '$forum_search_membre' AND forum_sujet.apparence NOT LIKE 'Anonyme' " : "";
  $qmessages_pseudo = ($forum_search_auteur) ? " AND forum_message.FKmembres        LIKE '$forum_search_membre' AND forum_sujet.apparence NOT LIKE 'Anonyme' " : "";

  // Et les critères de recherche
  $qsujets_criteres   = (!$forum_search_anonyme)  ? " AND forum_sujet.apparence NOT LIKE 'Anonyme' "  : " ";
  $qsujets_criteres  .= (!$forum_search_jeux)     ? " AND forum_sujet.classification NOT LIKE 'Jeu' " : " ";

  // Critères auxquels on rajoute les préférences de langage et de catégories si l'utilisateur est connecté
  if(loggedin())
  {
    // Filtrage par langage
    $user_id    = postdata($_SESSION['user'], 'int', 0);
    $qforumlang = mysqli_fetch_array(query("  SELECT  membres.forum_lang
                                              FROM    membres
                                              WHERE   membres.id = '$user_id' "));
    if($qforumlang['forum_lang'])
    {
      $qsujets_criteres .= (strpos($qforumlang['forum_lang'], 'FR') !== false) ? '' : " AND forum_sujet.langage LIKE 'EN' ";
      $qsujets_criteres .= (strpos($qforumlang['forum_lang'], 'EN') !== false) ? '' : " AND forum_sujet.langage LIKE 'FR' ";
    }

    // Filtrage par catégories
    $qforumcat = query("  SELECT  forum_filtrage.FKforum_categorie
                          FROM    forum_filtrage
                          WHERE   forum_filtrage.FKmembres = '$user_id' ");
    if(mysqli_num_rows($qforumcat))
    {
      while($dforumcat = mysqli_fetch_array($qforumcat))
        $qsujets_criteres .= " AND forum_sujet.FKforum_categorie != '".$dforumcat['FKforum_categorie']."' ";
    }
  }

  // On interdit aux non-admins de voir les sujets privés
  $qsujets_prive = getmod('forum') ? "" : " AND forum_sujet.public = 1 ";

  // On va chercher les sujets
  if($forum_search_sujets)
  {
    $qsujets = query("  SELECT    forum_sujet.id                  AS 's_id'         ,
                                  forum_sujet.titre               AS 's_titre'      ,
                                  forum_sujet.apparence           AS 's_apparence'  ,
                                  forum_sujet.timestamp_creation  AS 's_date'       ,
                                  membres.pseudonyme              AS 's_auteur'     ,
                                  membres.id                      AS 's_idauteur'
                                  $qsujets_texte
                        FROM      forum_sujet
                        LEFT JOIN membres ON forum_sujet.FKmembres_createur = membres.id
                                  $qsujets_texte_where
                                  $qsujets_pseudo
                                  $qsujets_prive
                                  $qsujets_criteres
                        ORDER BY  forum_sujet.timestamp_creation DESC ");

    // Qu'on prépare ensuite pour l'affichage
    for($nsujets = 0; $dsujets = mysqli_fetch_array($qsujets); $nsujets++)
    {
      $sujet_id[$nsujets]         = $dsujets['s_id'];
      $sujet_titre[$nsujets]      = ($forum_search_auteur && !$forum_search_texte) ? predata(tronquer_chaine($dsujets['s_titre'], 55, '...')) : html_autour($forum_search_texte, predata(tronquer_chaine($dsujets['s_titre'], 55, '...')), '<ins>', '</ins>');
      $sujet_idmessage[$nsujets]  = 0;
      $sujet_message[$nsujets]    = '-';
      $temp_anonyme               = ($lang == 'FR') ? 'Anonyme' : 'Anonymous';
      $sujet_auteur[$nsujets]     = ($dsujets['s_apparence'] == 'Anonyme') ? $temp_anonyme : predata($dsujets['s_auteur']);
      $sujet_idauteur[$nsujets]   = ($dsujets['s_apparence'] == 'Anonyme') ? 0 : $dsujets['s_idauteur'];
      $sujet_date[$nsujets]       = ilya($dsujets['s_date']);
    }
  }
  else
    $nsujets = 0;

  // Puis les messages individuels
  $total_sujets = $nsujets;
  if($forum_search_messages)
  {
    $qsujets = query("  SELECT    forum_sujet.id                    AS 's_id'         ,
                                  forum_sujet.titre                 AS 's_titre'      ,
                                  forum_sujet.apparence             AS 's_apparence'  ,
                                  forum_message.id                  AS 'm_id'         ,
                                  forum_message.contenu             AS 'm_contenu'    ,
                                  forum_message.timestamp_creation  AS 'm_date'       ,
                                  membres.pseudonyme                AS 'm_auteur'     ,
                                  membres.id                        AS 'm_idauteur'
                                  $qmessages_texte
                        FROM      forum_message
                        LEFT JOIN forum_sujet ON forum_message.FKforum_sujet  = forum_sujet.id
                        LEFT JOIN membres     ON forum_message.FKmembres      = membres.id
                                  $qmessages_texte_where
                                  $qmessages_pseudo
                                  $qsujets_prive
                                  $qsujets_criteres
                        ORDER BY  forum_message.timestamp_creation DESC ");

    // Qu'on prépare ensuite pour l'affichage
    for(; $dsujets = mysqli_fetch_array($qsujets); $nsujets++)
    {
      $sujet_id[$nsujets]         = $dsujets['s_id'];
      $sujet_titre[$nsujets]      = predata(tronquer_chaine($dsujets['s_titre'], 55, '...'));
      $sujet_idmessage[$nsujets]  = $dsujets['m_id'];
      $sujet_message[$nsujets]    = ($forum_search_auteur) ? bbcode(predata(tronquer_chaine($dsujets['m_contenu'], 80, '...'))) : bbcode(html_autour($forum_search_texte, predata(tronquer_chaine(search_wrap($forum_search_texte, $dsujets['m_contenu'], 5), 80, '...')), '<ins>', '</ins>'));
      if(!$sujet_message[$nsujets])
        $sujet_message[$nsujets]  = bbcode(predata(tronquer_chaine($dsujets['m_contenu'], 80, '...')));
      $temp_anonyme               = ($lang == 'FR') ? 'Anonyme' : 'Anonymous';
      $sujet_auteur[$nsujets]     = ($dsujets['s_apparence'] == 'Anonyme') ? $temp_anonyme : predata($dsujets['m_auteur']);
      $sujet_idauteur[$nsujets]   = ($dsujets['s_apparence'] == 'Anonyme') ? 0 : $dsujets['m_idauteur'];
      $sujet_date[$nsujets]       = ilya($dsujets['m_date']);
    }
  }

  // On calcule les totaux de sujets et messages
  $total_messages = $nsujets - $total_sujets;
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
  $trad['form_go']        = "EXÉCUTER LA RECHERCHE SUR LE FORUM NOBLEME";

  // Résultats de la recherche
  $trad['res_erreur']     = "Erreur :";
  $temp_nsujets           = (isset($total_sujets)) ? $total_sujets : 0;
  $temp_nmessages         = (isset($total_messages)) ? $total_messages : 0;
  $trad['res_titre']      = "Résultats de la recherche : $temp_nsujets sujets et $temp_nmessages messages trouvés";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "Search the forum";
  $trad['soustitre']      = "Find specific posts on NoBleme's forum";
  $trad['desc']           = <<<EOD
Are you searching for specific content on <a class="gras" href="{$chemin}pages/forum/index">NoBleme's forum</a>? Fill up part of the search form below, then press the search button, and you might find what you are looking for. The search results will be displayed or hidden according to your <a class="gras" href="{$chemin}pages/forum/filtres">filtering preferences</a>.
EOD;

  // Formulaire de recherche
  $trad['form_texte']     = "Text to search on the forum";
  $trad['form_auteur']    = "Nickname of the post's author";
  $trad['form_contenu']   = "Contents that you want to return";
  $trad['form_criteres']  = "Search options";
  $trad['form_sujets']    = "Thread titles";
  $trad['form_posts']     = "Individual posts";
  $trad['form_anon']      = "Include anonymous threads in the search results";
  $trad['form_jeux']      = "Include forum games in the search results";
  $trad['form_go']        = "SEARCH THE NOBLEME FORUM";

  // Résultats de la recherche
  $trad['res_erreur']     = "Error:";
  $temp_nsujets           = (isset($total_sujets)) ? $total_sujets : 0;
  $temp_nmessages         = (isset($total_messages)) ? $total_messages : 0;
  $trad['res_titre']      = "Search results: $temp_nsujets thread titles and $temp_nmessages posts found";
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

            <label><?=$trad['form_criteres']?></label>

            <input id="forum_search_anonyme" name="forum_search_anonyme" type="checkbox"<?=$checked_anonyme?>>
            <label class="label-inline" for="forum_search_anonyme"><?=$trad['form_anon']?></label><br>

            <input id="forum_search_jeux" name="forum_search_jeux" type="checkbox"<?=$checked_jeux?>>
            <label class="label-inline" for="forum_search_jeux"><?=$trad['form_jeux']?></label><br>

            <br>

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

      <div class="align_center">

        <br>

        <h4 class="texte_negatif"><span class="souligne"><?=$trad['res_erreur']?></span> <?=$forum_search_erreur?></h4>

        <br>

      </div>

      <?php } else { ?>

      <div class="tableau2">

        <br>

        <h2 class="align_center"><?=$trad['res_titre']?></h2>

        <br>
        <br>
        <br>

        <?php if($nsujets) { ?>

        <table class="grid titresnoirs nowrap">
          <thead>
            <tr class="bas_noir">
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
            <?php if(($i < $nsujets - 1) && $sujet_idmessage[$i+1] && !$sujet_idmessage[$i]) { ?>
            <tr class="bas_noir">
            <?php } else { ?>
            <tr>
            <?php } ?>
              <td>
                <a href="<?=$chemin?>pages/forum/sujet?id=<?=$sujet_id[$i]?>"><?=$sujet_titre[$i]?></a>
              </td>
              <td>
                <?php if($sujet_idmessage[$i]) { ?>
                <a href="<?=$chemin?>pages/forum/sujet?id=<?=$sujet_id[$i]?>#<?=$sujet_idmessage[$i]?>"><?=$sujet_message[$i]?></a>
                <?php } else { ?>
                <?=$sujet_message[$i]?>
                <?php } ?>
              </td>
              <td>
                <?php if($sujet_idauteur[$i]) { ?>
                <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$sujet_idauteur[$i]?>"><?=$sujet_auteur[$i]?></a>
                <?php } else { ?>
                <?=$sujet_auteur[$i]?>
                <?php } ?>
              </td>
              <td>
                <?=$sujet_date[$i]?>
              </td>
            </tr>
            <?php } ?>

          </tbody>
        </table>

        <?php } ?>

      </div>

      <?php } ?>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';