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

// Langages disponibles
$langage_page = array('FR','EN');

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




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les infos du sujet
$qsujet = mysqli_fetch_array(query("  SELECT  forum_sujet.categorie       ,
                                              forum_sujet.langage         ,
                                              forum_sujet.titre           ,
                                              forum_sujet.public          ,
                                              forum_sujet.ouvert          ,
                                              forum_sujet.epingle
                                      FROM    forum_sujet
                                      WHERE   forum_sujet.id = '$sujet_edit_id' "));

// On les prépare pour l'affichage
$sujet_titre      = predata($qsujet['titre']);
$sujet_categorie  = predata($qsujet['categorie']);
$sujet_langue     = $qsujet['langage'];
$sujet_public     = (!$qsujet['public']) ? ' checked' : '';
$sujet_ouvert     = (!$qsujet['ouvert']) ? ' checked' : '';
$sujet_epingle    = ($qsujet['epingle']) ? ' checked' : '';

// Menu déroulant : Catégorie
$temp_selected      = ($sujet_categorie == 'Aucune') ? ' selected' : '';
$select_categorie   = '<option value="Aucune"'.$temp_selected.'>'.forum_option_info('Aucune', 'complet', $lang).'</option>';
$temp_selected      = ($sujet_categorie == 'Politique') ? ' selected' : '';
$select_categorie  .= '<option value="Politique"'.$temp_selected.'>'.forum_option_info('Politique', 'complet', $lang).'</option>';
$temp_selected      = ($sujet_categorie == 'Informatique') ? ' selected' : '';
$select_categorie  .= '<option value="Informatique"'.$temp_selected.'>'.forum_option_info('Informatique', 'complet', $lang).'</option>';
$temp_selected      = ($sujet_categorie == 'NoBleme') ? ' selected' : '';
$select_categorie  .= '<option value="NoBleme"'.$temp_selected.'>'.forum_option_info('NoBleme', 'complet', $lang).'</option>';

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
            <input id="sujet_edit_titre" name="sujet_edit_titre" class="indiv" type="text" value="<?=$sujet_titre?>"><br>
            <br>

            <label for="sujet_edit_categorie"><?=$trad['edit_categorie']?></label>
            <select id="sujet_edit_categorie" name="sujet_edit_categorie" class="indiv">
              <?=$select_categorie?>
            </select><br>
            <br>

            <label for="sujet_edit_langue"><?=$trad['edit_langue']?></label>
            <select id="sujet_edit_langue" name="sujet_edit_langue" class="indiv">
              <?=$select_langue?>
            </select><br>
            <br>

            <input id="sujet_edit_prive" name="sujet_edit_prive" type="checkbox"<?=$sujet_public?>>
            <label class="label-inline" for="sujet_edit_prive"><span class="texte_blanc negatif spaced gras"><?=$trad['edit_prive']?></span><?=$trad['edit_prive_desc']?></label><br>

            <input id="sujet_edit_ferme" name="sujet_edit_ferme" type="checkbox"<?=$sujet_ouvert?>>
            <label class="label-inline" for="sujet_edit_ferme"><span class="texte_blanc neutre spaced gras"><?=$trad['edit_ferme']?></span><?=$trad['edit_ferme_desc']?></label><br>

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