<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/forum.inc.php';

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumIndex';

// Identification
$page_nom = "Parcourt les sujets de discussion du forum";
$page_url = "pages/forum/index";

// Lien court
$shorturl = "f";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Forum" : "Forum";
$page_desc  = "Liste des sujets actifs sur le forum NoBleme";

// CSS & JS
$css  = array('forum');
$js   = array('toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Valeurs par défaut pour la recherche
$filter_titre         = '';
$filter_fr            = 'on';
$filter_en            = 'on';
$filter_politique     = 'on';
$filter_informatique  = 'on';
$filter_nobleme       = 'on';

if(isset($_POST['forum_search_go']) || isset($_POST['forum_filter_go']))
{
  // Récupération du postdata
  $filter_titre         = postdata_vide('forum_filtrer_titre', 'string', '');
  $filter_fr            = (isset($_POST['forum_filtrer_fr']))            ? 'on' : '';
  $filter_en            = (isset($_POST['forum_filtrer_en']))            ? 'on' : '';
  $filter_politique     = (isset($_POST['forum_filtrer_politique']))     ? 'on' : '';
  $filter_informatique  = (isset($_POST['forum_filtrer_informatique']))  ? 'on' : '';
  $filter_nobleme       = (isset($_POST['forum_filtrer_nobleme']))       ? 'on' : '';

  // Mise à jour des préférences de filtrage si nécessaire
  if(loggedin() && isset($_POST['forum_filter_go']))
  {
    // On récupère l'id et la liste des filtres
    $user_id = $_SESSION['user'];
    $filterlist = array('filter_fr'           =>  $filter_fr            ,
                        'filter_en'           =>  $filter_en            ,
                        'filter_politique'    =>  $filter_politique     ,
                        'filter_informatique' =>  $filter_informatique  ,
                        'filter_nobleme'      =>  $filter_nobleme)      ;

    // On va parcourir la liste des filtres
    foreach($filterlist as $filterkey => $filtervalue)
    {
      // Si on ne filtre pas, on supprime la préférence de filtrage
      if($filtervalue)
        query(" DELETE FROM forum_filtrage
                WHERE       forum_filtrage.FKmembres  = '$user_id'
                AND         forum_filtrage.filtre     = '$filterkey'  ");

      // Si on filtre, on va vérifier si la préférence existe déjà
      else
      {
        $qcheckfilter = mysqli_fetch_array(query("  SELECT  forum_filtrage.id
                                                    FROM    forum_filtrage
                                                    WHERE   forum_filtrage.FKmembres  = '$user_id'
                                                    AND     forum_filtrage.filtre     = '$filterkey'  "));

        // S'il n'existe pas encore, on le crée
        if($qcheckfilter['id'] == NULL)
          query(" INSERT INTO forum_filtrage
                  SET         forum_filtrage.FKmembres  = '$user_id' ,
                              forum_filtrage.filtre     = '$filterkey'  ");
      }
    }
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On récupère le statut de modérateur (ou non) de l'user
$forum_moderateur = getmod('forum');

// Selon si l'user est modérateur ou non, on affiche ou non les sujets privés
$condition_prive = ($forum_moderateur) ? "" : " AND forum_sujet.public = 1 ";

// On va chercher si l'user a des règles de filtrage en place
if(loggedin())
{
  // On va choper les règles de filtrage
  $user_id = $_SESSION['user'];
  $qregles = query("  SELECT  forum_filtrage.filtre
                      FROM    forum_filtrage
                      WHERE   forum_filtrage.FKmembres = '$user_id' ");

  // On les met dans un tableau
  $regles = array();
  while($dregles = mysqli_fetch_array($qregles))
    array_push($regles, $dregles['filtre']);
}
else
  $regles = array();

// À partir des règles de filtrage et du postdata, on définit les recherches à faire
$recherches = '';
if($filter_titre)
  $recherches .= " AND forum_sujet.titre LIKE '%$filter_titre%' ";
if(in_array("filter_fr", $regles) || !$filter_fr)
  $recherches .= " AND forum_sujet.langage NOT LIKE 'FR' ";
if(in_array("filter_en", $regles) || !$filter_en)
  $recherches .= " AND forum_sujet.langage NOT LIKE 'EN' ";
if(in_array("filter_politique", $regles) || !$filter_politique)
  $recherches .= " AND forum_sujet.categorie NOT LIKE 'Politique' ";
if(in_array("filter_informatique", $regles) || !$filter_informatique)
  $recherches .= " AND forum_sujet.categorie NOT LIKE 'Informatique' ";
if(in_array("filter_nobleme", $regles) || !$filter_nobleme)
  $recherches .= " AND forum_sujet.categorie NOT LIKE 'NoBleme' ";

// On va chercher la liste des sujets
$qsujets = query("  SELECT    forum_sujet.id                        AS 's_id'         ,
                              forum_sujet.timestamp_creation        AS 's_creation'   ,
                              forum_sujet.timestamp_dernier_message AS 's_dernier'    ,
                              forum_sujet.apparence                 AS 's_apparence'  ,
                              forum_sujet.classification            AS 's_classif'    ,
                              forum_sujet.categorie                 AS 's_categorie'  ,
                              forum_sujet.public                    AS 's_public'     ,
                              forum_sujet.ouvert                    AS 's_ouvert'     ,
                              forum_sujet.epingle                   AS 's_epingle'    ,
                              forum_sujet.langage                   AS 's_lang'       ,
                              forum_sujet.titre                     AS 's_titre'      ,
                              forum_sujet.nombre_reponses           AS 's_reponses'   ,
                              membres_createur.id                   AS 'c_id'         ,
                              membres_createur.pseudonyme           AS 'c_pseudo'     ,
                              membres_createur.admin                AS 'c_admin'      ,
                              membres_createur.sysop                AS 'c_sysop'      ,
                              membres_createur.moderateur           AS 'c_mod'        ,
                              membres_dernier.id                    AS 'd_id'         ,
                              membres_dernier.pseudonyme            AS 'd_pseudo'     ,
                              membres_dernier.admin                 AS 'd_admin'      ,
                              membres_dernier.sysop                 AS 'd_sysop'      ,
                              membres_dernier.moderateur            AS 'd_mod'
                    FROM      forum_sujet
                    LEFT JOIN membres AS membres_createur ON forum_sujet.FKmembres_createur         = membres_createur.id
                    LEFT JOIN membres AS membres_dernier  ON forum_sujet.FKmembres_dernier_message  = membres_dernier.id
                    WHERE     1 = 1
                              $condition_prive
                              $recherches
                    ORDER BY  forum_sujet.epingle                   DESC  ,
                              forum_sujet.timestamp_dernier_message DESC  ");

// On prépare la liste des sujets pour l'affichage
for($nsujets = 0; $dsujets = mysqli_fetch_array($qsujets); $nsujets++)
{
  $sujet_id[$nsujets]         = $dsujets['s_id'];
  $sujet_lang[$nsujets]       = predata(changer_casse($dsujets['s_lang'], 'min'));
  $sujet_lang_alt[$nsujets]   = predata(changer_casse($dsujets['s_lang'], 'maj'));
  $sujet_titre[$nsujets]      = predata(tronquer_chaine($dsujets['s_titre'], 55, '...'));
  $sujet_apparence[$nsujets]  = predata(forum_option_info($dsujets['s_apparence'], 'court', $lang));
  $sujet_classif[$nsujets]    = (forum_option_info($dsujets['s_classif'], 'court', $lang)) ? ' <span class="texte_noir">- '.predata(forum_option_info($dsujets['s_classif'], 'court', $lang)).'</span>' : '';
  $sujet_categorie[$nsujets]  = (forum_option_info($dsujets['s_categorie'], 'court', $lang)) ? ' - '.predata(forum_option_info($dsujets['s_categorie'], 'court', $lang)) : '';
  $sujet_public[$nsujets]     = $dsujets['s_public'];
  $sujet_ouvert[$nsujets]     = $dsujets['s_ouvert'];
  $sujet_epingle[$nsujets]    = $dsujets['s_epingle'];
  $sujet_c_id[$nsujets]       = ($dsujets['s_apparence'] != 'Anonyme') ? $dsujets['c_id'] : 0;
  $sujet_c_pseudo[$nsujets]   = predata($dsujets['c_pseudo']);
  $temp_css                   = ($dsujets['c_mod']) ? ' texte_positif' : '';
  $temp_css                   = ($dsujets['c_sysop']) ? ' texte_neutre' : $temp_css;
  $sujet_c_css[$nsujets]      = ($dsujets['c_admin']) ? ' texte_negatif' : $temp_css;
  $sujet_creation[$nsujets]   = predata(ilya($dsujets['s_creation'], $lang));
  $sujet_reponses[$nsujets]   = $dsujets['s_reponses'];
  $sujet_d_id[$nsujets]       = ($dsujets['s_apparence'] != 'Anonyme') ? $dsujets['d_id'] : 0;
  $sujet_d_pseudo[$nsujets]   = predata($dsujets['d_pseudo']);
  $temp_css                   = ($dsujets['d_mod']) ? ' texte_positif' : '';
  $temp_css                   = ($dsujets['d_sysop']) ? ' texte_neutre' : $temp_css;
  $sujet_d_css[$nsujets]      = ($dsujets['d_admin']) ? ' texte_negatif' : $temp_css;
  $sujet_dernier[$nsujets]    = predata(ilya($dsujets['s_dernier'], $lang));
}

// On définit les cases pré-cochées selon les recherches
$forum_filter_fr            = (in_array("filter_fr", $regles))                ? '' : ' checked';
$forum_filter_en            = (in_array("filter_en", $regles))                ? '' : ' checked';
$forum_filter_politique     = (in_array("filter_politique", $regles))    ? '' : ' checked';
$forum_filter_informatique  = (in_array("filter_informatique", $regles)) ? '' : ' checked';
$forum_filter_nobleme       = (in_array("filter_nobleme", $regles))      ? '' : ' checked';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']            = "Forum NoBleme";
  $trad['soustitre']        = "Oui, il est réellement de retour";
  $trad['desc']             = <<<EOD
Bienvenue sur le <a class="gras" href="https://fr.wikipedia.org/wiki/Forum_(informatique)">forum de discussion</a> de NoBleme, un espace d'échange qui se veut convivial et ouvert à tous les individus et tous les sujets, tant que vous respectez notre <a class="gras" href="{$chemin}pages/doc/coc">code de conduite</a>. Le forum NoBleme est bilingue français/anglais et regroupe plusieurs catégories de conversation différentes, vous pouvez changer vos préférences de filtrage personnelles de langue et de catégories en cliquant sur le bouton ci-dessous.
EOD;
  $trad['options']          = "CLIQUEZ ICI POUR CHANGER VOS OPTIONS DE FILTRAGE ET/OU EFFECTUER UNE RECHERCHE";

  // Règles de filtrage
  $trad['filter_titre']     = "Recherche et/ou règles personnelles de filtrage";
  $trad['filter_desc']      = <<<EOD
Les champs ci-dessous vous permettent de faire des recherches sur le forum en filtrant le type de sujets de discussion que vous désirez voir ou ne pas voir. Si vous cliquez sur le bouton « Faire une recherche », le contenu du forum sera filtré de façon temporaire, juste le temps d'une recherche. Si vous cliquez sur le bouton « Modifier mes règles de filtrage », le contenu du forum sera filtré de façon permanente, ce qui vous permet de masquer définitivement certains types de contenus qui ne vous intéressent pas.
EOD;
  $trad['filter_login']     = <<<EOD
Comme les préférences de filtrage permanentes sont liées à votre compte NoBleme, le bouton « Modifier mes règles de filtrage » n'apparaitra que si vous êtes <a class="gras" href="{$chemin}pages/user/login">connecté à votre compte</a>.
EOD;
  $trad['filtrer_titre']    = "Recherche par titre de sujet";
  $trad['filter_titre_p']   = "Écrivez ici un extrait du titre d'un sujet que vous cherchez";
  $trad['filtrer_lang']     = "Filtrer par langue";
  $trad['filter_fr']        = "Sujets en français";
  $trad['filter_en']        = "Sujets en anglais";
  $trad['filtrer_categ']    = "Filtrer par catégorie";
  $trad['filter_search']    = "FAIRE UNE RECHERCHE";
  $trad['filter_edit']      = "MODIFIER MES RÈGLES DE FILTRAGE";

  // Titres de la liste des sujets
  $trad['sujets_sujets']    = "SUJETS DE DISCUSSION";
  $trad['sujets_new']       = "+NOUVEAU";
  $trad['sujets_creation']  = "CRÉATION";
  $trad['sujets_reponses']  = "RÉPONSES";
  $trad['sujets_dernier']   = "DERNIER MESSAGE";

  // Liste des sujets de discussion
  $trad['liste_anon']       = "Anonyme";
  $trad['liste_prive']      = "PRIVÉ";
  $trad['liste_ferme']      = "FERMÉ";
  $trad['liste_epingle']    = "ÉPINGLÉ";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']            = "Forum NoBleme";
  $trad['desc']             = <<<EOD
Welcome to NoBleme's <a class="gras" href="https://en.wikipedia.org/wiki/Internet_forum">discussion forum</a>, your friendly message board open to all users and topics, as long as you respect our <a class="gras" href="{$chemin}pages/doc/coc">code of conduct</a>. As NoBleme's forum is french/english bilingual and regroups various different conversation types and categories, you can apply filters on the topics you want to see and change your forum preferences by clicking the button below.
EOD;
  $trad['options']          = "CLICK HERE TO SEARCH THE FORUM AND/OR CHANGE YOUR FORUM FILTERING OPTIONS";

  // Règles de filtrage
  $trad['filter_titre']     = "Search and/or personal filtering rules";
  $trad['filter_desc']      = <<<EOD
The form below allows you to perform searches on the forum by filtering which types of topics you want to see or hide. If you press the "Search the forum" button, the filters will only be temporary, for the duration of your search. If you press the "Edit my personal filtering rules" button, the filters will be permanently linked to your account, which allows you to permanently hide content that you do not wish to see on the forum.
EOD;
  $trad['filter_login']     = <<<EOD
As filtering preferences as tied to your NoBleme account, the "Edit my personal filtering rules" button will only appear if you are <a class="gras" href="{$chemin}pages/user/login">logged in to your account</a>.
EOD;
  $trad['filtrer_titre']    = "Search by topic title";
  $trad['filter_titre_p']   = "Write here an extract of the topic title you are looking for";
  $trad['filtrer_lang']     = "Filter by lanugage";
  $trad['filter_fr']        = "Topics in french";
  $trad['filter_en']        = "Topics in english";
  $trad['filtrer_categ']    = "Filter by category";
  $trad['filter_search']    = "SEARCH THE FORUM";
  $trad['filter_edit']      = "EDIT MY PERSONAL FILTERING RULES";

  // Titres de la liste des sujets
  $trad['sujets_sujets']    = "LATEST ACTIVE TOPICS";
  $trad['sujets_new']       = "+NEW";
  $trad['sujets_creation']  = "CREATED";
  $trad['sujets_reponses']  = "REPLIES";
  $trad['sujets_dernier']   = "LAST REPLY";

  // Liste des sujets de discussion
  $trad['liste_anon']       = "Anonymous";
  $trad['liste_prive']      = "PRIVATE";
  $trad['liste_ferme']      = "CLOSED";
  $trad['liste_epingle']    = "PINNED";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <?php if($lang == 'FR') { ?>
        <h5><?=$trad['soustitre']?></h5>
        <?php } ?>

        <p><?=$trad['desc']?></p>

        <br>

        <button class="button button-outline" id="forum_preferences_bouton" onclick="toggle_row('forum_preferences'); toggle_row('forum_preferences_bouton');"><?=$trad['options']?></button>

      </div>

      <div id="forum_preferences" class="indiv hidden">

        <br>
        <hr class="separateur_contenu">
        <br>

        <div class="texte">

          <h5><?=$trad['filter_titre']?></h5>

          <p>
            <?=$trad['filter_desc']?>
          </p>

          <?php if(!loggedin()) { ?>
          <p class="texte_negatif">
            <?=$trad['filter_login']?>
          </p>
          <?php } ?>

          <br>

          <form method="POST">
            <fieldset>

              <label for="forum_filtrer_titre"><?=$trad['filtrer_titre']?></label>
              <input id="forum_filtrer_titre" name="forum_filtrer_titre" class="indiv" type="text" placeholder="<?=$trad['filter_titre_p']?>"><br>
              <br>

              <label><?=$trad['filtrer_lang']?></label>
              <input id="forum_filtrer_fr" name="forum_filtrer_fr" type="checkbox"<?=$forum_filter_fr?>>
              <label class="label-inline" for="forum_filtrer_fr"><?=$trad['filter_fr']?></label><br>
              <input id="forum_filtrer_en" name="forum_filtrer_en" type="checkbox"<?=$forum_filter_en?>>
              <label class="label-inline" for="forum_filtrer_en"><?=$trad['filter_en']?></label><br>
              <br>

              <label><?=$trad['filtrer_categ']?></label>
              <input id="forum_filtrer_politique" name="forum_filtrer_politique" type="checkbox"<?=$forum_filter_politique?>>
              <label class="label-inline" for="forum_filtrer_politique"><?=forum_option_info('Politique', 'complet', $lang)?></label><br>
              <input id="forum_filtrer_informatique" name="forum_filtrer_informatique" type="checkbox"<?=$forum_filter_informatique?>>
              <label class="label-inline" for="forum_filtrer_informatique"><?=forum_option_info('Informatique', 'complet', $lang)?></label><br>
              <input id="forum_filtrer_nobleme" name="forum_filtrer_nobleme" type="checkbox"<?=$forum_filter_nobleme?>>
              <label class="label-inline" for="forum_filtrer_nobleme"><?=forum_option_info('NoBleme', 'complet', $lang)?></label><br>
              <br>

              <input class="forum_preferences_bouton" type="submit" name="forum_search_go" value="<?=$trad['filter_search']?>">
              <?php if(loggedin()) { ?>
              <input class="button button-outline" type="submit" name="forum_filter_go" value="<?=$trad['filter_edit']?>">
              <?php } ?>

            </fieldset>
          </form>

        </div>

        <br>
        <hr class="separateur_contenu">

      </div>

      <br>
      <br>

      <div class="texte2">

        <table class="titresnoirs nowrap">

          <thead>
            <tr>
              <th colspan="2">
                <?=$trad['sujets_sujets']?> &nbsp;<a class="texte_positif pointeur" href="<?=$chemin?>pages/forum/new"><?=$trad['sujets_new']?></a>
              </th>
              <th class="nopadding">
                <?=$trad['sujets_creation']?>
              </th>
              <th class="moinsmaigre nopadding">
                <?=$trad['sujets_reponses']?>
              </th>
              <th class="nopadding">
                <?=$trad['sujets_dernier']?>
              </th>
            </tr>
          </thead>

          <tbody>

            <?php for($i=0;$i<$nsujets;$i++) { ?>

            <tr>

              <td>
                <img src="<?=$chemin?>img/icones/lang_<?=$sujet_lang[$i]?>_clear.png" alt="<?=$sujet_lang_alt[$i]?>" class="valign_table" height="20">
              </td>

              <td>

                <a class="gras" href="<?=$chemin?>pages/forum/sujet?id=<?=$sujet_id[$i]?>"><?=$sujet_titre[$i]?></a><br>

                <span class="gras texte_noir"><?=$sujet_apparence[$i]?></span><?=$sujet_classif[$i]?><?=$sujet_categorie[$i]?>
                <?php if(!$sujet_public[$i]) { ?>
                <span class="gras neutre texte_blanc spaced"><?=$trad['liste_prive']?></span>
                <?php } if(!$sujet_ouvert[$i]) { ?>
                <span class="gras negatif texte_blanc spaced"><?=$trad['liste_ferme']?></span>
                <?php } if($sujet_epingle[$i]) { ?>
                <span class="gras positif texte_blanc spaced"><?=$trad['liste_epingle']?></span>
                <?php } ?>

                <?php if($forum_moderateur) { ?>
                <a href="<?=$chemin?>pages/forum/sujet_modifier?id=<?=$sujet_id[$i]?>">
                  <img class="pointeur forum_liste_actions forum_liste_actions_premier" src="<?=$chemin?>img/icones/modifier.png" alt="M" height="16">
                </a>
                <a href="<?=$chemin?>pages/forum/sujet_supprimer?id=<?=$sujet_id[$i]?>">
                  <img class="pointeur forum_liste_actions" src="<?=$chemin?>img/icones/supprimer.png" alt="X" height="16">
                </a>
                <?php } ?>

              </td>

              <td class="align_center nopadding">
                <?php if($sujet_c_id[$i]) { ?>
                <a class="gras<?=$sujet_c_css[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$sujet_c_id[$i]?>"><?=$sujet_c_pseudo[$i]?></a><br>
                <?php } else { ?>
                <span class="gras"><?=$trad['liste_anon']?></span><br>
                <?php } ?>
                <?=$sujet_creation[$i]?>
              </td>

              <td class="align_center texte_noir gras nopadding">
                <?=$sujet_reponses[$i]?><br>
              </td>

              <td class="align_center nopadding">
                <?php if($sujet_d_id[$i]) { ?>
                <a class="gras<?=$sujet_d_css[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$sujet_d_id[$i]?>"><?=$sujet_d_pseudo[$i]?></a><br>
                <?php } else { ?>
                <span class="gras"><?=$trad['liste_anon']?></span><br>
                <?php } ?>
                <?=$sujet_dernier[$i]?>
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