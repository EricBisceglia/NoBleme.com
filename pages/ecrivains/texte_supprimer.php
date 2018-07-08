<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsPublier';

// Identification
$page_nom = "Supprime un de ses textes";
$page_url = "pages/ecrivains/index";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Supprimer un texte";
$page_desc  = "Supprimer un texte qui a été publié dans le coin des écrivains de NoBleme";




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
$texte_delete_id = postdata($_GET['id'], 'int', 0);

// On va vérifier si le sujet existe
$qchecktexte = mysqli_fetch_array(query(" SELECT  ecrivains_texte.titre     ,
                                                  ecrivains_texte.FKmembres ,
                                                  ecrivains_texte.FKecrivains_concours
                                          FROM    ecrivains_texte
                                          WHERE   ecrivains_texte.id = '$texte_delete_id' "));

// S'il existe pas, on sort
if($qchecktexte['titre'] === NULL)
  exit(header('Location: '.$chemin.'pages/ecrivains/index'));

// Si on tente de supprimer le texte de quelqu'un d'autre, on sort
if(!getsysop() && $qchecktexte['FKmembres'] != $_SESSION['user'])
  exit(header('Location: '.$chemin.'pages/ecrivains/index'));

// Sinon, on en profite pour récupérer les infos sur le texte
$texte_delete_titre         = predata($qchecktexte['titre']);
$texte_delete_titre_escaped = postdata($qchecktexte['titre'], 'string', '');
$texte_delete_concours      = $qchecktexte['FKecrivains_concours'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un texte

if(isset($_POST['texte_suppression_go']))
{
  // On va chercher des infos sur le texte pour compléter le diff
  $qchecktexte = mysqli_fetch_array(query(" SELECT    ecrivains_texte.titre   AS 't_titre'    ,
                                                      ecrivains_texte.contenu AS 't_texte'    ,
                                                      ecrivains_texte.anonyme AS 't_anonyme'  ,
                                                      membres.pseudonyme      AS 'm_pseudo'
                                            FROM      ecrivains_texte
                                            LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                                            WHERE     ecrivains_texte.id = '$texte_delete_id' "));

  // Suppression du texte et de ses réactions
  query(" DELETE FROM ecrivains_texte
          WHERE       ecrivains_texte.id = '$texte_delete_id' ");
  query(" DELETE FROM ecrivains_note
          WHERE       ecrivains_note.FKecrivains_texte = '$texte_delete_id' ");

  // Suppression des logs d'activité liés au texte
  query(" DELETE FROM activite
          WHERE     ( activite.action_type  LIKE  'ecrivains_new'
          OR          activite.action_type  LIKE  'ecrivains_reaction_new'
          OR          activite.action_type  LIKE  'ecrivains_reaction_new_anonyme' )
          AND         activite.action_id    =     '$texte_delete_id' ");

  // Activité récente
  $timestamp            = time();
  $texte_delete_pseudo  = postdata(getpseudo(), 'string', '');
  query(" INSERT INTO activite
          SET         activite.timestamp      = '$timestamp'                  ,
                      activite.log_moderation = 1                             ,
                      activite.pseudonyme     = '$texte_delete_pseudo'        ,
                      activite.action_type    = 'ecrivains_delete'            ,
                      activite.action_titre   = '$texte_delete_titre_escaped' ");

  // Diff
  $activite_id          = mysqli_insert_id($db);
  $texte_avant_auteur   = ($qchecktexte['t_anonyme']) ? 'Anonyme' : postdata($qchecktexte['m_pseudo'], 'string');
  $texte_avant_titre    = postdata($qchecktexte['t_titre'], 'string');
  $texte_avant_contenu  = postdata($qchecktexte['t_texte'], 'string');
  query(" INSERT INTO activite_diff
          SET         FKactivite  = '$activite_id'        ,
                      titre_diff  = 'Auteur'              ,
                      diff_avant  = '$texte_avant_auteur' ");
  query(" INSERT INTO activite_diff
          SET         FKactivite  = '$activite_id'        ,
                      titre_diff  = 'Titre'               ,
                      diff_avant  = '$texte_avant_titre'  ");
  query(" INSERT INTO activite_diff
          SET         FKactivite  = '$activite_id'          ,
                      titre_diff  = 'Contenu'               ,
                      diff_avant  = '$texte_avant_contenu'  ");

  // Notification des sysops au cas où
  ircbot($chemin, getpseudo()." a supprimé un texte du coin des écrivains intitulé : ".$qchecktexte['titre']." - ".$GLOBALS['url_site']."pages/nobleme/activite?mod", "#sysop");

  // Redirection
  exit(header('Location: '.$chemin.'pages/ecrivains/index'));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Le coin des écrivains</h1>

        <h5>Supprimer définitevement une publication</h5>

        <br>

        <?php if($texte_delete_concours && !getsysop()) { ?>

        <p>
          Ce texte est lié à un <a class="gras" href="<?=$chemin?>pages/ecrivains/concours">concours du coin des écrivains</a>, par conséquent il doit rester figé dans l'état où il était lorsque le concours a eu lieu : vous ne pouvez pas le modifier ni le supprimer.
        </p>

        <?php } else { ?>

        <?php if($texte_delete_concours) { ?>

        <br>

        <h5 class="erreur texte_blanc spaced">Attention ! Ce texte est lié à un concours du coin des écrivains. Il ne faut pas le supprimer sans avoir une excellente raison de le faire, sous peine de créer des trous les archives du concours.</h5>

        <br>

        <?php } ?>

        <p>
          Confirmer la suppression <span class="texte_noir gras">définitive</span> du texte <a class="gras" href="<?=$chemin?>pages/ecrivains/texte?id=<?=$texte_delete_id?>"><?=$texte_delete_titre?></a>. Il disparaitra du coin des écrivains, aucune copie n'en sera conservée, et toutes les réactions liées au texte (s'il y en a) disparaitront également.
        </p>

        <br>
        <br>

        <form method="POST">
          <input value="OUI, JE DÉSIRE SUPPRIMER DÉFINITIVEMENT CE TEXTE" type="submit" name="texte_suppression_go">
        </form>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';