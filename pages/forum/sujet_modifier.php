<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/forum.inc.php';

// Permissions
sysoponly($lang, 'forum');

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumIndex';

// Identification
$page_nom = "Administre secrètement le site";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Modifier un sujet du forum" : "Edit a forum topic";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérification que le sujet existe

// Si l'id est pas rempli, on sort
if(!isset($_GET['id']))
  exit(header('Location: '.$chemin.'pages/forum/index'));

// Assainissement de l'id
$sujet_edit_id = postdata($_GET['id'], 'int', 0);

// On va vérifier si le sujet existe
$qchecksujet = mysqli_fetch_array(query(" SELECT  forum_sujet.id
                                          FROM    forum_sujet
                                          WHERE   forum_sujet.id = '$sujet_edit_id' "));

// S'il existe pas, on sort
if($qchecksujet['id'] === NULL)
  exit(header('Location: '.$chemin.'pages/forum/index'));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification du sujet

if(isset($_POST['sujet_edit_go']))
{
  // On va chercher des infos sur le sujet pour compléter le diff
  $qchecksujet = mysqli_fetch_array(query(" SELECT    forum_sujet.langue      AS 's_lang'     ,
                                                      forum_sujet.titre       AS 's_titre'    ,
                                                      forum_sujet.public      AS 's_public'   ,
                                                      forum_sujet.ouvert      AS 's_ouvert'   ,
                                                      forum_sujet.epingle     AS 's_epingle'  ,
                                                      forum_categorie.nom_fr  AS 'cat_nom'
                                            FROM      forum_sujet
                                            LEFT JOIN forum_categorie ON forum_sujet.FKforum_categorie = forum_categorie.id
                                            WHERE     forum_sujet.id = '$sujet_edit_id' "));

  // On prépare les infos pour le diff
  $edit_avant_titre     = postdata($qchecksujet['s_titre'], 'string', '');
  $edit_avant_categorie = postdata($qchecksujet['cat_nom'], 'string', 'Aucune');
  $edit_avant_langue    = postdata($qchecksujet['s_lang'], 'string', 'FR');
  $edit_avant_public    = $qchecksujet['s_public'];
  $edit_avant_ouvert    = $qchecksujet['s_ouvert'];
  $edit_avant_epingle   = $qchecksujet['s_epingle'];
  $edit_titre_raw       = $qchecksujet['s_titre'];

  // Assainissement du postdata
  $edit_titre     = postdata_vide('sujet_edit_titre', 'string', '');
  $edit_categorie = postdata_vide('sujet_edit_categorie', 'int', 0);
  $edit_langue    = postdata_vide('sujet_edit_langue', 'string', 'FR');
  $edit_public    = (isset($_POST['sujet_edit_prive']) && $_POST['sujet_edit_prive']) ? 0 : 1;
  $edit_ouvert    = (isset($_POST['sujet_edit_ferme']) && $_POST['sujet_edit_ferme']) ? 0 : 1;
  $edit_epingle   = (isset($_POST['sujet_edit_epingle']) && $_POST['sujet_edit_epingle']) ? 1 : 0;

  // Mise à jour des infos
  query(" UPDATE  forum_sujet
          SET     forum_sujet.FKforum_categorie = '$edit_categorie' ,
                  forum_sujet.langue            = '$edit_langue'    ,
                  forum_sujet.titre             = '$edit_titre'     ,
                  forum_sujet.public            = '$edit_public'    ,
                  forum_sujet.ouvert            = '$edit_ouvert'    ,
                  forum_sujet.epingle           = '$edit_epingle'
          WHERE   forum_sujet.id                = '$sujet_edit_id' ");

  // Activité récente
  $edit_pseudo  = getpseudo();
  $activite_id  = activite_nouveau('forum_edit', 1, 0, $edit_pseudo, $sujet_edit_id, $edit_titre);

  // Diff
  activite_diff($activite_id, 'Titre', $edit_avant_titre, $edit_titre, 1);
  if($edit_avant_categorie != $edit_categorie)
  {
    $qgetcategorie  = mysqli_fetch_array(query("  SELECT  forum_categorie.nom_fr
                                                  FROM    forum_categorie
                                                  WHERE   forum_categorie.id = '$edit_categorie' "));
    $edit_categorie = $qgetcategorie['nom_fr'];
    activite_diff($activite_id, 'Catégorie', $edit_avant_categorie, $edit_categorie);
  }
  activite_diff($activite_id, 'Langue', $edit_avant_langue, $edit_langue, 1);
  if($edit_avant_public != $edit_public)
    activite_diff($activite_id, 'Public', $edit_avant_public);
  if($edit_avant_ouvert != $edit_ouvert)
    activite_diff($activite_id, 'Ouvert', $edit_avant_ouvert);
  if($edit_avant_epingle != $edit_epingle)
    activite_diff($activite_id, 'Épinglé', $edit_avant_epingle);

  // IRCbot
  ircbot($chemin, getpseudo()." a modifié le sujet du forum ".$edit_titre_raw.". Diff des changements : ".$GLOBALS['url_site']."pages/nobleme/activite?mod", "#sysop");

  // Redirection
  exit(header("Location: ".$chemin."pages/forum/sujet?id=".$sujet_edit_id));
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les infos du sujet
$qsujet = mysqli_fetch_array(query("  SELECT    forum_sujet.FKforum_categorie AS 'f_cat'      ,
                                                forum_sujet.langue            AS 'f_lang'     ,
                                                forum_sujet.titre             AS 'f_titre'    ,
                                                forum_sujet.public            AS 'f_public'   ,
                                                forum_sujet.ouvert            AS 'f_ouvert'   ,
                                                forum_sujet.epingle           AS 'f_epingle'
                                      FROM      forum_sujet
                                      WHERE     forum_sujet.id = '$sujet_edit_id' "));

// On les prépare pour l'affichage
$sujet_titre      = predata($qsujet['f_titre']);
$sujet_categorie  = $qsujet['f_cat'];
$sujet_langue     = $qsujet['f_lang'];
$sujet_public     = (!$qsujet['f_public']) ? ' checked' : '';
$sujet_ouvert     = (!$qsujet['f_ouvert']) ? ' checked' : '';
$sujet_epingle    = ($qsujet['f_epingle']) ? ' checked' : '';

// Menu déroulant : Catégorie
$select_categorie = '';
$qcategories = query("  SELECT    forum_categorie.id      ,
                                  forum_categorie.nom_fr  ,
                                  forum_categorie.nom_en
                        FROM      forum_categorie
                        ORDER BY  forum_categorie.par_defaut  DESC  ,
                                  forum_categorie.classement  ASC   ");
while($dcategories = mysqli_fetch_array($qcategories))
{
  $temp_selected      = ($sujet_categorie == $dcategories['id']) ? ' selected' : '';
  $temp_lang          = ($lang == 'FR') ? predata($dcategories['nom_fr']) : predata($dcategories['nom_en']);
  $select_categorie  .= '<option value="'.$dcategories['id'].'"'.$temp_selected.'>'.$temp_lang.'</option>';
}

// Menu déroulant : Langue du sujet
$temp_selected  = ($sujet_langue == 'FR') ? ' selected' : '';
$temp_langue    = ($lang == 'FR') ? 'Français' : 'French';
$select_langue  = '<option value="FR"'.$temp_selected.'>'.$temp_langue.'</option>';
$temp_selected  = ($sujet_langue == 'EN') ? ' selected' : '';
$temp_langue    = ($lang == 'FR') ? 'Anglais' : 'English';
$select_langue .= '<option value="EN"'.$temp_selected.'>'.$temp_langue.'</option>';





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']                = "Forum NoBleme";
  $trad['soustitre']            = "Modifier un sujet de discussion";

  // Formulaire
  $trad['edit_categorie']       = "Catégorie";
  $trad['edit_titre']           = "Titre du sujet";
  $trad['edit_langue']          = "Langue du sujet";
  $trad['edit_prive']           = "PRIVÉ";
  $trad['edit_prive_desc']      = " : seuls les membres de l'équipe administrative peuvent voir le sujet";
  $trad['edit_ferme']           = "FERMÉ";
  $trad['edit_ferme_desc']      = " : visible de tout le monde, mais impossible d'y poster des réponses";
  $trad['edit_epingle']         = "ÉPINGLÉ";
  $trad['edit_epingle_desc']    = " : apparait en haut de la liste des sujets";
  $trad['edit_go']              = "MODIFIER CE SUJET";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']                = "NoBleme forum";
  $trad['soustitre']            = "Edit the title and options of a topic";

  // Formulaire
  $trad['edit_categorie']       = "Category";
  $trad['edit_titre']           = "Topic title";
  $trad['edit_langue']          = "Topic language";
  $trad['edit_prive']           = "PRIVATE";
  $trad['edit_prive_desc']      = " : only members of the administrative team can see the topic";
  $trad['edit_ferme']           = "CLOSED";
  $trad['edit_ferme_desc']      = " : everyone can see the topic, but nobody can reply to it";
  $trad['edit_epingle']         = "PINNED";
  $trad['edit_epingle_desc']    = " : appears on top of the topic list";
  $trad['edit_go']              = "EDIT THIS TOPIC";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <br>

        <form method="POST">
          <fieldset>

            <label for="sujet_edit_titre"><?=$trad['edit_titre']?></label>
            <input id="sujet_edit_titre" name="sujet_edit_titre" class="indiv" type="text" value="<?=$sujet_titre?>" maxlength="100"><br>
            <br>

            <label for="sujet_edit_categorie"><?=$trad['edit_categorie']?></label>
            <?php if(getadmin()) { ?>
            <div class="flexcontainer">
              <div style="flex:15">
            <?php } ?>
            <select id="sujet_edit_categorie" name="sujet_edit_categorie" class="indiv">
              <?=$select_categorie?>
            </select><br>
            <?php if(getadmin()) { ?>
              </div>
              <div style="flex:1" class="align_center">
                <a href="<?=$chemin?>pages/forum/filtres_modifier">
                  <img class="pointeur" src="<?=$chemin?>img/icones/modifier.png" alt="M">
                </a>
              </div>
            </div>
            <?php } ?>
            <br>

            <label for="sujet_edit_langue"><?=$trad['edit_langue']?></label>
            <select id="sujet_edit_langue" name="sujet_edit_langue" class="indiv">
              <?=$select_langue?>
            </select><br>
            <br>

            <input id="sujet_edit_ferme" name="sujet_edit_ferme" type="checkbox"<?=$sujet_ouvert?>>
            <label class="label-inline" for="sujet_edit_ferme"><span class="texte_blanc negatif spaced gras"><?=$trad['edit_ferme']?></span><?=$trad['edit_ferme_desc']?></label><br>

            <input id="sujet_edit_prive" name="sujet_edit_prive" type="checkbox"<?=$sujet_public?>>
            <label class="label-inline" for="sujet_edit_prive"><span class="texte_blanc neutre spaced gras"><?=$trad['edit_prive']?></span><?=$trad['edit_prive_desc']?></label><br>

            <input id="sujet_edit_epingle" name="sujet_edit_epingle" type="checkbox"<?=$sujet_epingle?>>
            <label class="label-inline" for="sujet_edit_epingle"><span class="texte_blanc positif spaced gras"><?=$trad['edit_epingle']?></span><?=$trad['edit_epingle_desc']?></label><br>
            <br>

            <input value="<?=$trad['edit_go']?>" type="submit" name="sujet_edit_go">

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';