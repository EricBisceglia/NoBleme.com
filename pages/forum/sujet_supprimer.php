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
$page_titre = ($lang == 'FR') ? "Supprimer un sujet du forum" : "Delete a forum topic";




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
$sujet_delete_id = postdata($_GET['id'], 'int', 0);

// On va vérifier si le sujet existe
$qchecksujet = mysqli_fetch_array(query(" SELECT  forum_sujet.titre
                                          FROM    forum_sujet
                                          WHERE   forum_sujet.id = '$sujet_delete_id' "));

// S'il existe pas, on sort
if($qchecksujet['titre'] === NULL)
  exit(header('Location: '.$chemin.'pages/forum/index'));

// Sinon, on en profite pour récupérer le titre
$sujet_delete_titre       = predata($qchecksujet['titre']);
$sujet_delete_titre_post  = postdata($qchecksujet['titre'], 'string', '');
$sujet_delete_titre_raw   = $qchecksujet['titre'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression du sujet

if(isset($_POST['forum_delete_go']))
{
  // On récupère les réponses au sujet pour le diff du log de moderation
  $qcheckmessages = query(" SELECT    forum_message.contenu AS 'f_contenu'  ,
                                      membres.pseudonyme    AS 'm_pseudo'
                            FROM      forum_message
                            LEFT JOIN membres ON forum_message.FKmembres  = membres.id
                            WHERE     forum_message.FKforum_sujet         = '$sujet_delete_id'
                            AND       forum_message.message_supprime      = 0
                            ORDER BY  forum_message.timestamp_creation ");

  // On a aussi besoin d'une liste des users qui ont posté dans le sujet
  $qcheckmembres = query("  SELECT    forum_message.FKmembres
                            FROM      forum_message
                            WHERE     forum_message.FKforum_sujet = '$sujet_delete_id'
                            GROUP BY  forum_message.FKmembres ");

  // On supprime le sujet et ses messages
  query(" DELETE FROM forum_sujet
          WHERE       forum_sujet.id = '$sujet_delete_id' ");
  query(" DELETE FROM forum_message
          WHERE       forum_message.FKforum_sujet = '$sujet_delete_id' ");

  // On supprime l'activité récente et les logs de modération liés à ce sujet
  query(" DELETE FROM activite
          WHERE     ( activite.action_type  LIKE  'forum_new'
          OR          activite.action_type  LIKE  'forum_edit' )
          AND         activite.action_id    =     '$sujet_delete_id' ");
  query(" DELETE FROM activite
          WHERE     ( activite.action_type  LIKE  'forum_new_message'
          OR          activite.action_type  LIKE  'forum_edit_message'
          OR          activite.action_type  LIKE  'forum_delete_message' )
          AND         activite.parent       =     '$sujet_delete_id' ");

  // On nettoie les potentiels diffs orphelins
  purger_diff_orphelins();

  // On recalcule le postcount des membres qui avaient posté dans le sujet
  while($dcheckmembres = mysqli_fetch_array($qcheckmembres))
    forum_recompter_messages_membre($dcheckmembres['FKmembres']);

  // Activité récente
  $timestamp            = time();
  $sujet_delete_pseudo  = postdata(getpseudo());
  query(" INSERT INTO activite
          SET         activite.timestamp      = '$timestamp'            ,
                      activite.log_moderation = 1                       ,
                      activite.pseudonyme     = '$sujet_delete_pseudo'  ,
                      activite.action_type    = 'forum_delete'          ,
                      activite.action_titre   = '$sujet_delete_titre_post' ");

  // Diff
  $activite_id = mysqli_insert_id($db);
  query(" INSERT INTO activite_diff
          SET         FKactivite  = '$activite_id'              ,
                      titre_diff  = 'Sujet'                     ,
                      diff_avant  = '$sujet_delete_titre_post'  ");
  for($i = 1; $dcheckmessages = mysqli_fetch_array($qcheckmessages); $i++)
  {
    $message_delete_id      = 'Message #'.$i.' par '.postdata($dcheckmessages['m_pseudo']);
    $message_delete_contenu = postdata($dcheckmessages['f_contenu']);
    query(" INSERT INTO activite_diff
            SET         FKactivite  = '$activite_id'            ,
                        titre_diff  = '$message_delete_id'      ,
                        diff_avant  = '$message_delete_contenu' ");
  }

  // IRCbot
  ircbot($chemin, getpseudo()." a supprimé un sujet sure le forum : ".$sujet_delete_titre_raw.". Le contenu du sujet est archivé ici : ".$GLOBALS['url_site']."pages/nobleme/activite?mod", "#sysop");

  // Redirection
  exit(header("Location: ".$chemin."pages/forum/index"));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Forum: Supprimer un sujet";
  $trad['desc']       = <<<EOD
La suppression d'un sujet du forum est <span class="gras">définitive</span>, elle ne <span class="gras">peut pas être annulée</span>.<br>
Confirmez la suppression de <span class="gras souligne">{$sujet_delete_titre}</span> en cliquant sur le bouton ci-dessous :
EOD;

  // Bouton
  $trad['delete_go']  = "OUI, JE LE VEUX";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Forum: Supprimer un sujet";
  $trad['desc']       = <<<EOD
La suppression d'un sujet du forum est <span class="gras">définitive</span>, elle ne <span class="gras">peut pas être annulée</span>.<br>
Confirmez la suppression de <span class="gras souligne">{$sujet_delete_titre}</span> en cliquant sur le bouton ci-dessous :
EOD;

  // Bouton
  $trad['delete_go']  = "OUI, JE LE VEUX";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$sujet_delete_titre?></h5>

        <p><?=$trad['desc']?></p>

        <br>

        <form method="POST">
          <fieldset>
            <input value="<?=$trad['delete_go']?>" type="submit" name="forum_delete_go">
          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';