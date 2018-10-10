<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php';   // Inclusions communes
include './../../inc/ecrivains.inc.php';  // Fonctions liées au coin des écrivains

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsPublier';

// Identification
$page_nom = "Modifie un de ses textes";
$page_url = "pages/ecrivains/index";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Modifier un texte";
$page_desc  = "Modifier un texte qui a été publié dans le coin des écrivains de NoBleme";

// CSS
$css = array('ecrivains');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Vérification que le texte existe

// Si l'id est pas rempli, on sort
if(!isset($_GET['id']))
  exit(header('Location: '.$chemin.'pages/ecrivains/index'));

// Assainissement de l'id
$texte_edit_id = postdata($_GET['id'], 'int', 0);

// On va vérifier si le sujet existe
$qchecktexte = mysqli_fetch_array(query(" SELECT  ecrivains_texte.titre     ,
                                                  ecrivains_texte.contenu   ,
                                                  ecrivains_texte.FKmembres ,
                                                  ecrivains_texte.FKecrivains_concours
                                          FROM    ecrivains_texte
                                          WHERE   ecrivains_texte.id = '$texte_edit_id' "));

// S'il existe pas, on sort
if($qchecktexte['titre'] === NULL)
  exit(header('Location: '.$chemin.'pages/ecrivains/index'));

// Si on tente de modifier le texte de quelqu'un d'autre, on sort
if(!getsysop() && $qchecktexte['FKmembres'] != $_SESSION['user'])
  exit(header('Location: '.$chemin.'pages/ecrivains/index'));

// Sinon, on en profite pour récupérer les infos sur le texte
$texte_edit_titre_raw     = $qchecktexte['titre'];
$texte_edit_titre_escaped = postdata($qchecktexte['titre'], 'string', '');
$texte_edit_contenu_raw   = $qchecktexte['contenu'];
$texte_edit_concours      = $qchecktexte['FKecrivains_concours'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modifier un texte

if(isset($_POST['modifier_go']))
{
  // Assainissement du postdata
  $texte_concours = postdata_vide('modifier_concours', 'int');
  $texte_titre    = isset($_POST['modifier_titre']) ? postdata(tronquer_chaine($_POST['modifier_titre'], 90)) : '';
  $texte_contenu  = postdata_vide('modifier_contenu', 'string');

  // On vérifie que le texte soit bien rempli
  $erreur = "";
  $texte_longueur = mb_strlen($texte_contenu, 'UTF-8');
  if(!$texte_longueur)
    $erreur = "Texte vide";
  if(!$texte_titre)
    $erreur = "Votre texte doit avoir un titre";

  // Si on a pas d'erreur, on peut passer à la suite
  if(!$erreur)
  {
    // On va chercher des infos sur le texte pour compléter les diffs
    $qchecktexte = mysqli_fetch_array(query(" SELECT    ecrivains_texte.titre                 AS 't_titre'  ,
                                                        ecrivains_texte.contenu               AS 't_texte'  ,
                                                        ecrivains_texte.FKecrivains_concours  AS 't_concours'
                                              FROM      ecrivains_texte
                                              WHERE     ecrivains_texte.id = '$texte_edit_id' "));

    // Modification du texte
    query(" UPDATE  ecrivains_texte
            SET     ecrivains_texte.titre                 = '$texte_titre'    ,
                    ecrivains_texte.contenu               = '$texte_contenu'  ,
                    ecrivains_texte.FKecrivains_concours  = '$texte_concours'
            WHERE   ecrivains_texte.id                    = '$texte_edit_id' ");

    // On recompte les textes des concours avant/après au cas où
    ecrivains_concours_compter_textes($texte_concours);
    ecrivains_concours_compter_textes($qchecktexte['t_concours']);

    // Activité récente
    $edit_pseudo  = postdata(getpseudo(), 'string');
    $activite_id  = activite_nouveau('ecrivains_edit', 1, 0, $edit_pseudo, $texte_edit_id, $texte_titre);

    // Diff
    $texte_avant_concours = postdata($qchecktexte['t_concours'], 'string');
    $texte_avant_titre    = postdata($qchecktexte['t_titre'], 'string');
    $texte_avant_contenu  = postdata($qchecktexte['t_texte'], 'string');
    activite_diff($activite_id, 'Concours', $texte_avant_concours, $texte_concours, 1);
    activite_diff($activite_id, 'Titre', $texte_avant_titre, $texte_titre, 1);
    activite_diff($activite_id, 'Contenu', $texte_avant_contenu, $texte_contenu, 1);

    // On envoie un message sur #sysop avec le bot IRC pour qu'un sysop vérifie que ça soit pas du contenu abusif
    ircbot($chemin, getpseudo()." a modifié le contenu d'un texte du coin des écrivains : ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_edit_id, "#sysop");

    // Redirection vers le texte
    exit(header("Location: ".$chemin."pages/ecrivains/texte?id=".$texte_edit_id));
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualiser avant modification

if(isset($_POST['modifier_prev']))
{
  // On prépare le contenu des champs
  $texte_edit_titre_raw   = $_POST['modifier_titre'];
  $texte_edit_contenu_raw = $_POST['modifier_contenu'];
  $texte_prev_titre       = predata($_POST['modifier_titre']);
  $texte_prev_contenu     = bbcode(predata($_POST['modifier_contenu'], 1));
  $texte_prev_auteur      = predata(getpseudo());
  $texte_prev_creation    = predata(changer_casse(ilya(time()-1), 'min'));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menu déroulant des concours d'écriture

// On va chercher les concours
$qconcours = query("  SELECT    ecrivains_concours.id     AS 'c_id' ,
                                ecrivains_concours.titre  AS 'c_titre'
                      FROM      ecrivains_concours
                      ORDER BY  ecrivains_concours.timestamp_fin DESC ");

// Et on les met dans un menu déroulant
$select_concours  = '';
while($dconcours = mysqli_fetch_array($qconcours))
{
  $temp_selected    = ($texte_edit_concours == $dconcours['c_id']) ? ' selected' : '';
  $select_concours .= '<option value="'.$dconcours['c_id'].'"'.$temp_selected.'>'.predata($dconcours['c_titre']).'</option>';
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Le coin des écrivains</h1>

        <h5>Modifier le contenu d'un texte déjà publié</h5>

        <br>

        <?php if($texte_edit_concours && !getsysop()) { ?>

        <p>
          Ce texte est lié à un <a class="gras" href="<?=$chemin?>pages/ecrivains/concours_liste">concours du coin des écrivains</a>, par conséquent il doit rester figé dans l'état où il était lorsque le concours a eu lieu : vous ne pouvez pas le modifier ni le supprimer.
        </p>

        <?php } else { ?>

        <?php if($texte_edit_concours) { ?>

        <br>

        <h5 class="erreur texte_blanc spaced">Attention ! Ce texte est lié à un concours du coin des écrivains. Il ne faut pas le modifier sans avoir une excellente raison de le faire, sous peine de créer des incohérences dans les archives du concours.</h5>

        <br>

        <?php } ?>

        <form method="POST" action="texte_modifier?id=<?=$texte_edit_id?>#modifier_contenu">
          <fieldset>

            <label for="modifier_concours">Concours d'écriture lié</label>
            <select id="modifier_concours" name="modifier_concours" class="indiv">
              <option value="0">Le texte n'est lié à aucun concours d'écriture</option>
              <?=$select_concours?>
            </select><br>
            <br>

            <label for="modifier_titre">Titre du texte (maximum 90 caractères)</label>
            <input id="modifier_titre" name="modifier_titre" class="indiv" type="text" value="<?=$texte_edit_titre_raw?>" maxlength="90"><br>
            <br>

            <label for="modifier_contenu">Contenu du texte (vous pouvez utiliser des <a class="gras" href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> pour formater le texte)</label>
            <textarea id="modifier_contenu" name="modifier_contenu" class="indiv composer_texte"><?=$texte_edit_contenu_raw?></textarea><br>
            <br>

            <?php if(isset($erreur)) { ?>
            <h4 class="align_center erreur texte_blanc">Erreur : <?=$erreur?></h4>
            <?php } ?>

            <br>
            <div class="flexcontainer">
              <div style="flex:1">
                <input class="button-outline" value="PRÉVISUALISER LE TEXTE AVANT DE LE MODIFIER" type="submit" name="modifier_prev">
              </div>
              <div style="flex:1">
                <input value="VALIDER ET ENVOYER LES MODIFICATIONS" type="submit" name="modifier_go">
              </div>
            </div>

          </fieldset>
        </form>

        <?php } ?>

      </div>

      <?php if(isset($_POST['modifier_prev'])) { ?>

      <br>
      <br>
      <hr class="separateur_contenu">
      <br>

      <div class="texte">

        <h3>
          <?=$texte_prev_titre?>
        </h3>

        <h6>
          Publié dans le <a>coin des écrivains</a> de NoBleme par <a><?=$texte_prev_auteur?></a> <?=$texte_prev_creation?>
        </h6>

        <br>

        <p>
          <?=$texte_prev_contenu?>
        </p>

      </div>

      <br>
      <br>
      <br>
      <hr class="separateur_contenu">

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';