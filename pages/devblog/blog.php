<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Devblog : ";
$page_desc  = "Blog de développement : ";

// Identification
$page_nom = "devblog";

// CSS & JS
$css = array('devblog');
$js  = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id du blog à afficher

if(isset($_GET['id']) && is_numeric($_GET['id']))
  $blogid = postdata($_GET['id']);
else
{
  // Si pas d'id set, on va chercher l'id du dernier blog publié
  $latestblog = query(" SELECT devblog.id FROM devblog ORDER BY devblog.id DESC ");
  $latest = mysqli_fetch_array($latestblog);
  $blogid = $latest['id'];
}

// On en profite pour définir l'id pour les pageviews
$page_id  = $blogid;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prévisualisation d'un commentaire

// Par défaut on veut rien
$preview_commentaire        = '';
$preview_commentaire_traite = '';

if(isset($_POST['preview_commentaire_x']))
{
  $preview_commentaire        = destroy_html($_POST['contenu_commentaire']);
  $preview_commentaire_traite = bbcode(nl2br_fixed(destroy_html($_POST['contenu_commentaire'])));
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un commentaire

if(isset($_POST['ajouter_commentaire_x']))
{
  // DELETEME
  $preview_commentaire = $_POST['contenu_commentaire'];

  // Récupération du postdata
  $comm_blog      = $blogid;
  $comm_user      = $_SESSION['user'];
  $comm_timestamp = time();
  $comm_contenu   = postdata(destroy_html($_POST['contenu_commentaire']));

  // Ajout du commentaire
  query(" INSERT INTO   devblog_commentaire
          SET           FKdevblog = '$comm_blog'      ,
                        FKmembres = '$comm_user'      ,
                        timestamp = '$comm_timestamp' ,
                        contenu   = '$comm_contenu'   ");

  // Activité récente
  $comm_id      = mysqli_insert_id($db);
  $comm_pseudo  = postdata(getpseudo($comm_user));
  $qcomm_titre  = mysqli_fetch_array(query(" SELECT titre FROM devblog WHERE id = '$blogid' "));
  $comm_titre   = postdata($qcomm_titre['titre']);
  query(" INSERT INTO activite
          SET         timestamp     = '$comm_timestamp'   ,
                      FKmembres     = '$comm_user'        ,
                      pseudonyme    = '$comm_pseudo'      ,
                      action_type   = 'new_devblog_comm'  ,
                      action_id     = '$comm_id'          ,
                      parent_id     = '$comm_blog'        ,
                      parent_titre  = '$comm_titre'       ");

  // Redirection vers le commentaire
  $qcomm_count  = mysqli_fetch_array(query(" SELECT COUNT(*) AS 'ncomm' FROM devblog_commentaire WHERE FKdevblog = '$blogid' "));
  $comm_count   = $qcomm_count['ncomm'];
  header('Location: blog?id='.$blogid.'#'.$comm_count);
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération du contenu du blog

// On récupère le blog, et aussi les pageviews qui seront utilisées plus tard
$devblog = query("  SELECT    devblog.titre     ,
                              devblog.timestamp ,
                              devblog.contenu   ,
                              stats_pageviews.vues
                    FROM      devblog
                    LEFT JOIN stats_pageviews     ON (devblog.id = stats_pageviews.id_page
                                                  AND stats_pageviews.nom_page  = 'devblog' )
                    WHERE     devblog.id = '$blogid' ");

// Si le blog n'existe pas, dehors
if (!mysqli_num_rows($devblog))
  erreur("Le devblog spécifié n'existe pas");

// On prépare les données pour l'affichage
$devblog  = mysqli_fetch_array($devblog);
$titre    = $devblog['titre'];
$date     = datefr(date('Y-m-d',$devblog['timestamp']));
// Fix crade à retirer quand j'aurais réécrit les vieux devblogs, forcé de pas gérer les bbcodes si c'est vieux
$contenu  = ($devblog['timestamp'] < 1400000000) ? htmlspecialchars_decode($devblog['contenu']) : bbcode(htmlspecialchars_decode($devblog['contenu']));

// On en profite pour compléter le titre et la description de la page
$page_titre .= $titre;
$page_desc  .= substr(meta_fix(html_entity_decode($titre)),0,130);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des commentaires du blog

// On récupère les commentaires
$qcomm = query("  SELECT    membres.pseudonyme            ,
                            devblog_commentaire.FKmembres ,
                            devblog_commentaire.id        ,
                            devblog_commentaire.timestamp ,
                            devblog_commentaire.contenu

                  FROM      devblog_commentaire ,
                            membres

                  WHERE     devblog_commentaire.FKdevblog = '$blogid'
                  AND       devblog_commentaire.FKmembres = membres.id

                  ORDER BY  devblog_commentaire.timestamp ASC ");

// Puis on assigne le contenu de la requête dans des variables
for($ncomm = 0 ; $comm = mysqli_fetch_array($qcomm) ; $ncomm++)
{
  $comm_id[$ncomm]          = $comm['id'];
  $comm_userid[$ncomm]      = $comm['FKmembres'];
  $comm_user[$ncomm]        = $comm['pseudonyme'];
  $comm_date[$ncomm]        = datefr(date('Y-m-d',$comm['timestamp'])).' à '.date('H:i:s',$comm['timestamp']);
  $comm_contenu[$ncomm]     = bbcode(nl2br_fixed($comm['contenu']));
  $comm_contenu_raw[$ncomm] = $comm['contenu'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mise à jour du score de popularité

// Récupération des infos requises pour le calcul
$sviews = $devblog['vues'] + 1;
$scoms  = $ncomm;
$sdate  = $devblog['timestamp'];

// Calcul du score
$basescore    = (($sviews+($scoms*50))/5);          # Calcul de base du score selon pageviews et commentaires
$timediff     = ((time() - $sdate) / 86400);        # Jours écoulés depuis la publication du blog
$multiplier   = 1 - ($timediff/1000);               # Multiplicateur de score (-1% par 10 jours écoulés)
if($multiplier < 0.5)                               # Si le multiplicateur de score est > -50%
  $multiplier = 0.5;                                # On laisse le multiplicateur de score à 50%
$total_score  = round($basescore * $multiplier,0);  # Calcul final du score (score de base multiplié par le multiplicateur de score)

// Mise à jour du score
query(" UPDATE devblog SET score_popularite = '$total_score' WHERE id = '$blogid' ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Devblog précédent

// On récupère le blog
$loop_out = 0;
for($i=$blogid-1;!$loop_out;$i--)
{
  $devblog_prev = query(" SELECT  devblog.id    ,
                                  devblog.titre ,
                                  devblog.timestamp
                          FROM    devblog
                          WHERE   devblog.id = '$i' ");

  // On check si le devblog existe, puis on assigne les données
  if (!mysqli_num_rows($devblog_prev))
    $devblog_prev_check = 0;
  else
  {
    $devblog_prev_check = 1;
    $loop_out           = 1;
    $blog_prev          = mysqli_fetch_array($devblog_prev);
    $id_blog_prev       = $blog_prev['id'];
    $titre_blog_prev    = $blog_prev['titre'];
    $date_blog_prev     = datefr(date('Y-m-d',$blog_prev['timestamp']));
  }

  // Si ça boucle trop bas, out
  if($i <= 0)
  {
    $devblog_prev_check = 0;
    $loop_out           = 1;
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Devblog suivant

// On récupère le blog
$loop_out = 0;
for($i=$blogid+1;!$loop_out;$i++)
{
  $devblog_next = query(" SELECT  devblog.id    ,
                                  devblog.titre ,
                                  devblog.timestamp
                          FROM    devblog
                          WHERE   devblog.id = '$i' ");

  // On check si le devblog existe, puis on assigne les données
  if (!mysqli_num_rows($devblog_next))
    $devblog_next_check = 0;
  else
  {
    $devblog_next_check = 1;
    $loop_out           = 1;
    $blog_next          = mysqli_fetch_array($devblog_next);
    $id_blog_next       = $blog_next['id'];
    $titre_blog_next    = $blog_next['titre'];
    $date_blog_next     = datefr(date('Y-m-d',$blog_next['timestamp']));
  }

  // Si ça boucle trop bas, out
  if($i > $blogid + 25)
  {
    $devblog_next_check = 0;
    $loop_out           = 1;
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])) { /* Ne pas afficher les données dynamiques dans la page normale */ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/devblog.png" alt="Devblog">
    </div>
    <br>

    <div class="body_main midsize">
      <?=$contenu?><br>
      <br>
      <hr>
      <div class="indiv align_center">
        <span class="italique">Ce devblog a été publié le <?=$date?> sous le titre <a class="dark blank"><?=$titre?></a></span>
        <?php if(loggedin() && getadmin()) { ?>
        <br><a class="dark blank gras" href="<?=$chemin?>pages/devblog/admin?edit=<?=$blogid?>">Modifier le devblog</a> - <a class="dark blank gras" href="<?=$chemin?>pages/devblog/admin?delete=<?=$blogid?>">Supprimer le devblog</a>
        <?php } ?>
      </div>
      <br>
      <br>
      <table class="indiv">
        <tr>
          <?php if(isset($id_blog_prev)) { ?>
          <td class="devblog_midwidth align_center gras">
            Devblog précédent :
          </td>
          <?php } if(isset($id_blog_next)) { ?>
          <td class="devblog_midwidth align_center gras">
            Devblog suivant :
          </td>
          <?php } ?>
        </tr>
        <tr>
          <?php if(isset($id_blog_prev)) { ?>
          <td class="devblog_midwidth align_center italique">
            <?=$date_blog_prev?>
          </td>
          <?php } if(isset($id_blog_next)) { ?>
          <td class="devblog_midwidth align_center italique">
            <?=$date_blog_next?>
          </td>
          <?php } ?>
        </tr>
        <tr>
          <?php if(isset($id_blog_prev)) { ?>
          <td class="devblog_midwidth align_center valign_top">
            <a class="dark blank gras" href="<?=$chemin?>pages/devblog/blog.php?id=<?=$id_blog_prev?>"><?=$titre_blog_prev?></a>
          </td>
          <?php } if(isset($id_blog_next)) { ?>
          <td class="devblog_midwidth align_center valign_top">
            <a class="dark blank gras" href="<?=$chemin?>pages/devblog/blog.php?id=<?=$id_blog_next?>"><?=$titre_blog_next?></a>
          </td>
          <?php } ?>
        </tr>
      </table>
    </div>

    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/devblog_commentaires.png" alt="Commentaires">
    </div>
    <br>
    <br>

    <?php if(!loggedin()) { ?>
    <div class="body_main midsize" id="commentaires">
      <span class="soustitre">Poster un commentaire</span><br>
      <br>
      Il est nécessaire d'être connecté à un compte sur NoBleme pour poster un commentaire<br>
      <br>
      Si vous ne possédez pas de compte et désirez commenter, <a href="<?=$chemin?>pages/user/register">cliquez ici</a> pour vous inscrire.<br>
      Si vous possédez un compte, connectez-vous <a href="<?=$chemin?>pages/devblog/blog?id=<?=$blogid?>#body">en haut à droite</a> de la page actuelle.<br>
    </div>
    <?php } else { ?>
    <div class="body_main midsize" id="commentaires">
      <span class="titre">Poster un commentaire</span><br>
      <br>
      Les <a href="<?=$chemin?>pages/doc/bbcodes">BBCodes</a> et les <a href="<?=$chemin?>pages/doc/emotes">émoticônes</a> sont autorisés pour mettre en forme votre message.<br>
      Pour éviter de faire n'importe quoi, il est obligatoire de prévisualiser votre message avant de le poster.<br>
      Relisez-vous bien: Une fois votre message posté, vous ne pourrez ni le modifier ni le supprimer.<br>
      <br>
      Merci de ne poster que des commentaires en rapport avec le devblog auquel vous répondez.<br>
      Toute réponse hors sujet ou contenant des éléments publicitaires/auto-promotionnels sera supprimée.<br>
      <br>
      <form name="devblog_commentaire" method="post" action="blog?id=<?=$blogid?>#commentaires">
        <textarea class="intable" name="contenu_commentaire" rows="10"><?=$preview_commentaire?></textarea>
        <?php if($preview_commentaire_traite) { ?>
        <br>
        <br>
        <span class="alinea moinsgros gras">Prévisualisation :</span><br>
        <br>
        <?=$preview_commentaire_traite?><br>
        <br>
        <?php } ?>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/previsualiser.png" alt="PRÉVISUALISER" name="preview_commentaire">
          <?php if($preview_commentaire_traite) { ?>
          <img src="<?=$chemin?>img/boutons/separateur.png" alt=" | ">
          <input type="image" src="<?=$chemin?>img/boutons/ajouter.png" alt="AJOUTER" name="ajouter_commentaire">
          <?php } ?>
        </div>
      </form>
    </div>
    <?php } ?>

    <?php if(!$ncomm) { ?>
    <div class="body_main midsize">
      <br>
      <div class="align_center moinsgros gras">Il n'y a pas encore de commentaires sur ce devblog. Soyez le premier à en poster un.</div>
      <br>
    </div>
    <?php } else { ?>
    <div class="body_main midsize">
      <span class="titre">Commentaires laissés par les utilisateurs</span><br>
      <?php for($i=0;$i<$ncomm;$i++) { ?>
      <hr>
      <table class="indiv" id="table_commentaire<?=$comm_id[$i]?>">
        <tr>
          <td class="align_left">
            <a class="dark" href="#<?=$i+1?>" id="<?=$i+1?>">#<?=$i+1?></a> <i>Posté le <?=$comm_date[$i]?> par <a class="dark blank gras" href="<?=$chemin?>pages/user/user?id=<?=$comm_userid[$i]?>"><?=$comm_user[$i]?></a> :</i>
          </td>
          <?php if(loggedin() && getsysop()) { ?>
          <td class="align_right" id="comm_sysop_tools<?=$comm_id[$i]?>">
            <a class="dark" onClick="document.getElementById('comm_modification<?=$comm_id[$i]?>').style.display = 'inline' ; document.getElementById('comm_contenu<?=$comm_id[$i]?>').style.display = 'none' ; document.getElementById('comm_sysop_tools<?=$comm_id[$i]?>').style.display = 'none'">Modifier le commentaire</a>
            -
            <a class="dark" onClick="document.getElementById('comm_suppression<?=$comm_id[$i]?>').style.display = 'inline' ; document.getElementById('comm_contenu<?=$comm_id[$i]?>').style.display = 'none' ; document.getElementById('comm_sysop_tools<?=$comm_id[$i]?>').style.display = 'none'">Supprimer le commentaire</a>
          </td>
          <?php } else { ?>
          <td>&nbsp;</td>
          <?php } ?>
        </tr>
        <?php if(loggedin() && getsysop()) { ?>
        <tr>
          <td colspan="2" class="nowrap hidden gras moinsgros" id="comm_modification<?=$comm_id[$i]?>">
            <br>
            <textarea class="intable" id="comm_sysop_edit<?=$comm_id[$i]?>" rows="10"><?=$comm_contenu_raw[$i]?></textarea><br>
            Raison de la modification (optionnel) : <input class="raisonedit" id="com_modification_raison<?=$comm_id[$i]?>"><br>
            <br>
            <div class="indiv align_center">
              <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="AJOUTER" name="ajouter_commentaire"
                      onClick="dynamique('<?=$chemin?>','blog.php?id=<?=$blogid?>&amp;dynamique','table_commentaire<?=$comm_id[$i]?>',
                      'comm_sysop_edit='+dynamique_prepare('comm_sysop_edit<?=$comm_id[$i]?>')+
                      '&amp;raison_modification='+dynamique_prepare('com_modification_raison<?=$comm_id[$i]?>')+
                      '&amp;commid=<?=$comm_id[$i]?>');">
            </div>
            <br>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="nowrap hidden gras moinsgros" id="comm_suppression<?=$comm_id[$i]?>">
            <br>
            Raison de la suppression (optionnel) :
            <input class="raisondelete" id="comm_suppression_raison<?=$comm_id[$i]?>">
            <input type="submit" class="nobleme_background" value="Supprimer"
                    onClick="dynamique('<?=$chemin?>','blog.php?id=<?=$blogid?>&amp;dynamique','table_commentaire<?=$comm_id[$i]?>',
                    'raison_suppression='+dynamique_prepare('comm_suppression_raison<?=$comm_id[$i]?>')+
                    '&amp;commid=<?=$comm_id[$i]?>');"><br>
            <br>
          </td>
        </tr>
        <?php } ?>
        <tr id="comm_contenu<?=$comm_id[$i]?>">
          <td colspan="2">
            <br>
            <span><?=$comm_contenu[$i]?></span><br>
            <br>
          </td>
        </tr>
      </table>
    <?php } ?>
    </div>
    <?php } ?>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/********************************************************************************************************************************/ } else {

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Modification d'un commentaire

  if(isset($_POST['comm_sysop_edit']))
  {
    // Si l'user n'est pas un sysop, belle tentative de manipulation, mais gtfo thx
    sysoponly();

    // On récupère le postdata
    $edit_commid  = postdata($_POST['commid']);
    $edit_raison  = postdata(destroy_html($_POST['raison_modification']));
    $edit_contenu = postdata(destroy_html($_POST['comm_sysop_edit']));

    // On vérifie que le commentaire existe avant de se lancer
    if(is_numeric($edit_commid) && $edit_commid > 0)
    {
      // On en profite pour récupérer des infos qui serviront au log de modération
      $deditcomm = mysqli_fetch_array(query(" SELECT  devblog_commentaire.FKdevblog ,
                                                      devblog_commentaire.FKmembres ,
                                                      devblog_commentaire.contenu   ,
                                                      devblog.titre                 ,
                                                      membres.pseudonyme
                                            FROM      devblog_commentaire
                                            LEFT JOIN devblog ON devblog_commentaire.FKdevblog = devblog.id
                                            LEFT JOIN membres ON devblog_commentaire.FKmembres = membres.id
                                            WHERE     devblog_commentaire.id = '$edit_commid' "));

      // On check l'existence du commentaire
      if($deditcomm['FKdevblog'])
      {
        // Log de modération
        $timestamp    = time();
        $editc_membre = $deditcomm['FKmembres'];
        $editc_pseudo = $deditcomm['pseudonyme'];
        $editc_blogid = $deditcomm['FKdevblog'];
        $editc_blog   = postdata($deditcomm['titre']);
        $sysop_id     = $_SESSION['user'];
        $sysop_pseudo = postdata(getpseudo());
        query(" INSERT INTO activite
                SET         timestamp       = '$timestamp'          ,
                            log_moderation  = 1                     ,
                            FKmembres       = '$editc_membre'       ,
                            pseudonyme      = '$editc_pseudo'       ,
                            action_type     = 'edit_devblog_comm'   ,
                            action_id       = '$editc_blogid'       ,
                            action_titre    = '$editc_blog'         ,
                            parent_id       = '$sysop_id'           ,
                            parent_titre    = '$sysop_pseudo'       ,
                            justification   = '$edit_raison'        ");

        // Diff
        $id_diff          = mysqli_insert_id($db);
        $archive_comment  = postdata(diff(nl2br_fixed($deditcomm['contenu']),nl2br_fixed($_POST['comm_sysop_edit']),1));
        query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , diff = '$archive_comment' ");

        // Édition du commentaire
        query(" UPDATE devblog_commentaire SET contenu = '$edit_contenu' WHERE id = '$edit_commid' ");
      }
    }

    // Reste plus qu'à renvoyer le message de confirmation
    ?>
    <div class="vert_background alinea texte_blanc gras">Le commentaire a bien été modifié</div>
    <?php
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // XHR: Suppression d'un commentaire

  if(isset($_POST['raison_suppression']))
  {
    // Si l'user n'est pas un sysop, belle tentative de manipulation, mais gtfo thx
    sysoponly();

    // On récupère le postdata
    $del_commid = postdata($_POST['commid']);
    $del_raison = postdata(destroy_html($_POST['raison_suppression']));

    // On vérifie que le commentaire existe avant de se lancer
    if(is_numeric($del_commid) && $del_commid > 0)
    {
      // On en profite pour récupérer des infos qui serviront au log de modération
      $ddelcom = mysqli_fetch_array(query(" SELECT    devblog_commentaire.FKdevblog ,
                                                      devblog_commentaire.FKmembres ,
                                                      devblog_commentaire.contenu   ,
                                                      devblog.titre                 ,
                                                      membres.pseudonyme
                                            FROM      devblog_commentaire
                                            LEFT JOIN devblog ON devblog_commentaire.FKdevblog = devblog.id
                                            LEFT JOIN membres ON devblog_commentaire.FKmembres = membres.id
                                            WHERE     devblog_commentaire.id = '$del_commid' "));

      // On check l'existence du commentaire
      if($ddelcom['FKdevblog'])
      {
        // Activité récente
        query(" DELETE FROM activite WHERE action_type = 'new_devblog_comm' AND action_id = '$del_commid' ");

        // Log de modération
        $timestamp    = time();
        $delc_membre  = $ddelcom['FKmembres'];
        $delc_pseudo  = postdata($ddelcom['pseudonyme']);
        $delc_blogid  = $ddelcom['FKdevblog'];
        $delc_blog    = postdata($ddelcom['titre']);
        $sysop_id     = $_SESSION['user'];
        $sysop_pseudo = postdata(getpseudo());
        query(" INSERT INTO activite
                SET         timestamp       = '$timestamp'          ,
                            log_moderation  = 1                     ,
                            FKmembres       = '$delc_membre'        ,
                            pseudonyme      = '$delc_pseudo'        ,
                            action_type     = 'del_devblog_comm'    ,
                            action_id       = '$delc_blogid'        ,
                            action_titre    = '$delc_blog'          ,
                            parent_id       = '$sysop_id'           ,
                            parent_titre    = '$sysop_pseudo'       ,
                            justification   = '$del_raison'         ");

        // Diff
        $id_diff          = mysqli_insert_id($db);
        $archive_comment  = postdata(nl2br_fixed($ddelcom['contenu']));
        query(" INSERT INTO activite_diff SET FKactivite = '$id_diff' , diff = '$archive_comment' ");

        // Suppression du commentaire
        query(" DELETE FROM devblog_commentaire WHERE id = '$del_commid' ");
      }
    }

    // Reste plus qu'à renvoyer le message de confirmation
    ?>
    <div class="erreur alinea texte_blanc gras">Le commentaire a bien été supprimé</div>
    <?php
  }

}