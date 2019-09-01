<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php';   // Inclusions communes
include './../../inc/ecrivains.inc.php';  // Fonctions liées au coin des écrivains

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsListe';

// Identification
$page_nom = "Coin des écrivains";
$page_url = "pages/ecrivains/texte?id=";

// Lien court
$shorturl = "e=";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Coin des écrivains";
$page_desc  = "Coin des écrivains de NoBleme";

// CSS & JS
$css  = array('writings');
$js   = array('dynamique', 'ecrivains/texte');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Identification du texte

// On vérifie si l'ID est bien spécifie, sinon on dégagee
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  exit(header("Location: ".$chemin."pages/ecrivains/index"));

// On vérifie que le concours existe, sinon on dégage
$texte_id = postdata($_GET['id'], 'int');
if(!verifier_existence('ecrivains_texte', $texte_id))
  exit(header("Location: ".$chemin."pages/ecrivains/index"));

// On a besoin du titre pour compléter les infos de la page
$qveriftexte = mysqli_fetch_array(query(" SELECT    ecrivains_texte.titre AS 't_titre'
                                          FROM      ecrivains_texte
                                          LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                                          WHERE     ecrivains_texte.id = '$texte_id' "));

// Et on met à jour les infos de la page
$loggedin     = loggedin();
$est_sysop    = getsysop();
$est_admin    = getadmin();
$peut_voter   = ecrivains_concours_peut_voter();
$texte_titre  = predata($qveriftexte['t_titre']);
$page_nom    .= ' : '.predata(tronquer_chaine($qveriftexte['t_titre'], 25, '...'));
$page_url    .= $texte_id;
$shorturl    .= $texte_id;
$page_titre   = predata($qveriftexte['t_titre']);
$page_desc   .= ' : '.predata($qveriftexte['t_titre']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une nouvelle réaction sur le texte

if(isset($_POST['reaction_go']))
{
  // Mesure anti flood
  antiflood();

  // Assainissement du postdata
  $note_valeur      = isset($_POST['reaction_note']) ? postdata($_POST['reaction_note'], 'int', 0, 5) : 0;
  $note_commentaire = postdata_vide('reaction_commentaire', 'string', '');
  $note_anonyme     = isset($_POST['reaction_anonyme']) ? 1 : 0;

  // Interdit de poster une note si on l'a déjà fait
  $userid = $_SESSION['user'];
  $qchecknote = mysqli_fetch_array(query("  SELECT  ecrivains_note.id
                                            FROM    ecrivains_note
                                            WHERE   ecrivains_note.FKecrivains_texte  = '$texte_id'
                                            AND     ecrivains_note.FKmembres          = '$userid' "));
  if(!$qchecknote['id'])
  {
    // Ajout de la note
    $timestamp = time();
    query(" INSERT INTO ecrivains_note
            SET         ecrivains_note.FKecrivains_texte  = '$texte_id'         ,
                        ecrivains_note.FKmembres          = '$userid'           ,
                        ecrivains_note.timestamp          = '$timestamp'        ,
                        ecrivains_note.note               = '$note_valeur'      ,
                        ecrivains_note.anonyme            = '$note_anonyme'     ,
                        ecrivains_note.message            = '$note_commentaire' ");

    // Activité récente
    $note_pseudo          = postdata(getpseudo(), 'string');
    $note_type_action     = ($note_anonyme) ? 'ecrivains_reaction_new_anonyme' : 'ecrivains_reaction_new';
    $texte_titre_escaped  = postdata($qveriftexte['t_titre'], 'string');
    activite_nouveau($note_type_action, 0, 0, $note_pseudo, $texte_id, $texte_titre_escaped);

    // Notification sur IRC
    $note_titre_raw = $qveriftexte['t_titre'];
    if($note_anonyme)
      ircbot($chemin, "Quelqu'un a réagi anonymement au texte ".$note_titre_raw." : ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id."#texte_reactions", "#write");
    else
    {
      $note_pseudo_raw = getpseudo();
      ircbot($chemin, $note_pseudo_raw." a réagi au texte ".$note_titre_raw." : ".$GLOBALS['url_site']."pages/ecrivains/texte?id=".$texte_id."#texte_reactions", "#write");
    }
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une réaction au texte par son auteur

if($loggedin && isset($_POST['supprimer_reaction']))
{
  // On supprime la note
  query(" DELETE FROM ecrivains_note
          WHERE       ecrivains_note.FKecrivains_texte  = '$texte_id'
          AND         ecrivains_note.FKmembres          = '$userid' ");

  // Puis on supprime l'entrée dans l'activité récente
  $note_pseudo = postdata(getpseudo(), 'string');
  activite_supprimer('ecrivains_reaction_new', 0, 0, $note_pseudo, $texte_id);
  activite_supprimer('ecrivains_reaction_new_anonyme', 0, 0, $note_pseudo, $texte_id);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une réaction au texte

if($est_sysop && isset($_POST['supprimer_reaction_go']))
{
  // On commence par récupérer et assainir l'id de la réaction
  $delete_id = postdata_vide('supprimer_reaction_id', 'int', 0);

  // On récupère les justifications sur la suppression, si nécessaire
  $delete_raison  = (isset($_POST['supprimer_reaction_justification_'.$delete_id])) ? $_POST['supprimer_reaction_justification_'.$delete_id] : '';

  // On va chercher si la réaction existe (et on en profite pour récupérer son contenu)
  $qreaction = mysqli_fetch_array(query(" SELECT    ecrivains_note.note     AS 'n_note'     ,
                                                    ecrivains_note.message  AS 'n_message'  ,
                                                    ecrivains_note.anonyme  AS 'n_anonyme'  ,
                                                    membres.pseudonyme      AS 'm_pseudo'   ,
                                                    ecrivains_texte.titre   AS 't_titre'
                                          FROM      ecrivains_note
                                          LEFT JOIN membres         ON ecrivains_note.FKmembres         = membres.id
                                          LEFT JOIN ecrivains_texte ON ecrivains_note.FKecrivains_texte = ecrivains_texte.id
                                          WHERE     ecrivains_note.id = '$delete_id'" ));

  // Si elle n'existe pas, on dégage
  if($qreaction['n_note'] === NULL)
    exit(header("Location: ".$chemin."pages/ecrivains/texte?id=".$texte_id));

  // On supprime la note
  query(" DELETE FROM ecrivains_note
          WHERE       ecrivains_note.id = '$delete_id' ");

  // Puis on supprime l'entrée dans l'activité récente
  $delete_pseudo = postdata($qreaction['m_pseudo']);
  activite_supprimer('ecrivains_reaction_new', 0, 0, $delete_pseudo, $texte_id);
  activite_supprimer('ecrivains_reaction_new_anonyme', 0, 0, $delete_pseudo, $texte_id);

  // Activité récente
  $delete_mod           = postdata(getpseudo());
  $delete_anonyme       = ($qreaction['n_anonyme']) ? 'Anonyme' : $delete_pseudo;
  $delete_justification = ($delete_raison) ? postdata($delete_raison, 'string', '') : '';
  $activite_id          = activite_nouveau('ecrivains_reaction_delete', 1, 0, $delete_mod, $delete_id, $delete_anonyme, 0, $delete_justification);

  // Diff
  $delete_note    = postdata($qreaction['n_note'], 'double');
  $delete_message = postdata($qreaction['n_message'], 'string');
  activite_diff($activite_id, 'Note'    , $delete_note);
  activite_diff($activite_id, 'Message' , $delete_message);

  // IRCbot
  $delete_titre_raw   = $qreaction['t_titre'];
  $delete_pseudo_raw  = $qreaction['m_pseudo'];
  ircbot($chemin, getpseudo()." a supprimé une réaction de ".$delete_pseudo_raw." au texte ".$delete_titre_raw.". Le contenu de la réaction est archivé ici : ".$GLOBALS['url_site']."pages/nobleme/activite?mod", "#sysop");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Recalculation de la note moyenne du texte

// On va chercher la note moyenne
$qnotemoyenne = mysqli_fetch_array(query("  SELECT  COUNT(ecrivains_note.note)  AS 'n_nombre' ,
                                                    AVG(ecrivains_note.note)    AS 'n_moyenne'
                                            FROM    ecrivains_note
                                            WHERE   ecrivains_note.FKecrivains_texte  = '$texte_id' "));

// On met à jour la note moyenne du texte
$notemoyenne = ($qnotemoyenne['n_nombre']) ? round($qnotemoyenne['n_moyenne'], 1) : -1;
query(" UPDATE  ecrivains_texte
        SET     note_moyenne        = '$notemoyenne'
        WHERE   ecrivains_texte.id  = '$texte_id' ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu du texte

// On va récupérer des infos pour le header et sur l'apparence de sujet
$qtexte = mysqli_fetch_array(query("  SELECT    ecrivains_texte.anonyme                       AS 't_anonyme'  ,
                                                ecrivains_texte.titre                         AS 't_titre'    ,
                                                ecrivains_texte.contenu                       AS 't_contenu'  ,
                                                ecrivains_texte.timestamp_creation            AS 't_creation' ,
                                                ecrivains_texte.niveau_feedback               AS 't_feedback' ,
                                                membres.id                                    AS 'm_id'       ,
                                                membres.pseudonyme                            AS 'm_pseudo'   ,
                                                ecrivains_concours.id                         AS 'c_id'       ,
                                                ecrivains_concours.titre                      AS 'c_titre'    ,
                                                ecrivains_concours.FKecrivains_texte_gagnant  AS 'c_gagnant'  ,
                                                ecrivains_concours.timestamp_fin              AS 'c_fin'
                                      FROM      ecrivains_texte
                                      LEFT JOIN membres             ON ecrivains_texte.FKmembres            = membres.id
                                      LEFT JOIN ecrivains_concours  ON ecrivains_texte.FKecrivains_concours = ecrivains_concours.id
                                      WHERE     ecrivains_texte.id = '$texte_id' "));

// Puis on prépare le contenu pour l'affichage
$est_auteur             = (loggedin() && ($qtexte['m_id'] == $_SESSION['user']));
$texte_titre            = predata($qtexte['t_titre']);
$texte_contenu          = bbcode(predata($qtexte['t_contenu'], 1));
$texte_anonyme          = $qtexte['t_anonyme'];
$texte_auteur_id        = $qtexte['m_id'];
$texte_auteur           = predata($qtexte['m_pseudo']);
$texte_creation         = predata(changer_casse(ilya($qtexte['t_creation']), 'min'));
$texte_concours_id      = $qtexte['c_id'];
$texte_concours_titre   = predata($qtexte['c_titre']);
$texte_concours_gagnant = ($texte_id == $qtexte['c_gagnant']) ? 1 : 0;
$texte_concours_fini    = ($qtexte['c_gagnant']) ? 1 : 0;
$texte_concours_vote    = (time() > $qtexte['c_fin']) ? 1 : 0;
$texte_feedback         = $qtexte['t_feedback'];




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Réactions au texte

// On a déjà besoin de savoir si l'user a déjà posté une réaction au texte ou pas encore
$deja_reagi     = 0;
$je_suis_auteur = 0;

// Dans tous les cas, s'il n'est pas connecté, il ne peut pas commenter
if($loggedin)
{
  // Si c'est l'auteur du texte qui consulte la page, il n'a pas le droit de commenter
  $userid = $_SESSION['user'];
  if($userid == $texte_auteur_id)
    $je_suis_auteur = 1;

  // Sinon, on va chercher s'il a déjà noté le texte
  $qdejareagi = mysqli_fetch_array(query("  SELECT  ecrivains_note.id
                                            FROM    ecrivains_note
                                            WHERE   ecrivains_note.FKecrivains_texte  = '$texte_id'
                                            AND     ecrivains_note.FKmembres          = '$userid' "));
  if($qdejareagi['id'])
    $deja_reagi = 1;
}

// Maintenant, on peut aller va chercher la liste des réactions
$qreactions = query(" SELECT    ecrivains_note.id         AS 'n_id'       ,
                                ecrivains_note.timestamp  AS 'n_date'     ,
                                ecrivains_note.note       AS 'n_note'     ,
                                ecrivains_note.anonyme    AS 'n_anon'     ,
                                ecrivains_note.message    AS 'n_message'  ,
                                membres.id                AS 'm_id'       ,
                                membres.pseudonyme        AS 'm_pseudo'
                      FROM      ecrivains_note
                      LEFT JOIN membres ON ecrivains_note.FKmembres = membres.id
                      WHERE     ecrivains_note.FKecrivains_texte = '$texte_id'
                      ORDER BY  ecrivains_note.timestamp DESC ");

// Puis on les parcourt afin de les préparer pour l'affichage
for($nreactions = 0; $dreactions = mysqli_fetch_array($qreactions); $nreactions++)
{
  $reaction_id[$nreactions]       = $dreactions['n_id'];
  $reaction_note[$nreactions]     = round($dreactions['n_note']);
  $reaction_anonyme[$nreactions]  = $dreactions['n_anon'];
  $reaction_userid[$nreactions]   = $dreactions['m_id'];
  $reaction_pseudo[$nreactions]   = predata($dreactions['m_pseudo']);
  $reaction_date[$nreactions]     = predata(jourfr(date('Y-m-d', $dreactions['n_date'])));
  $reaction_cestmoi[$nreactions]  = ($loggedin && ($dreactions['m_id'] == $_SESSION['user'])) ? 1 : 0;
  $reaction_message[$nreactions]  = ($dreactions['n_message']) ? ' :<br>'.predata($dreactions['n_message']) : '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h3>
          <?=$texte_titre?>
          <?php if($est_sysop || $est_auteur) { ?>
          <a href="<?=$chemin?>pages/ecrivains/texte_modifier?id=<?=$texte_id?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M">
          </a>
          <a href="<?=$chemin?>pages/ecrivains/texte_supprimer?id=<?=$texte_id?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X">
          </a>
          <?php } ?>
        </h3>

        <?php if($texte_concours_id && !$texte_concours_gagnant) { ?>
        <h6>
          Ce texte est une participation au concours d'écriture <a href="<?=$chemin?>pages/ecrivains/concours?id=<?=$texte_concours_id?>"><?=$texte_concours_titre?></a>
        </h6>
        <?php } else if($texte_concours_id) { ?>
        <h6>
          Ce texte a gagné le concours d'écriture <a href="<?=$chemin?>pages/ecrivains/concours?id=<?=$texte_concours_id?>"><?=$texte_concours_titre?></a>
        </h6>
        <?php } ?>

        <h6>
          <?php if(!$texte_anonyme) { ?>
          Publié dans le <a href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme par <a href="<?=$chemin?>pages/user/user?id=<?=$texte_auteur_id?>"><?=$texte_auteur?></a> <?=$texte_creation?>
          <?php } else if($est_admin) { ?>
            Publié anonymement (<?=$texte_auteur?>) dans le <a href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme <?=$texte_creation?>
          <?php } else { ?>
            Publié anonymement dans le <a href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme <?=$texte_creation?>
          <?php } ?>
        </h6>

        <br>

        <?php if($texte_concours_id && !$texte_concours_fini) { ?>
        <?php if($est_admin || ($texte_concours_vote && $peut_voter)) { ?>
        <p>
          <?=$texte_contenu?>
        </p>
        <?php } else { ?>
        <br>
        <p>
          Ce texte est une participation à un <a class="gras" href="<?=$chemin?>pages/ecrivains/concours_liste">concours du coin des écrivains</a>, et son contenu est caché tant que le concours est en cours, afin de ne pas influencer les autres textes. Une fois que le concours en question (<a class="gras" href="<?=$chemin?>pages/ecrivains/concours?id=<?=$texte_concours_id?>"><?=$texte_concours_titre?></a>) sera fini, le contenu de ce texte deviendra public.
        </p>
        <?php } ?>

        <?php } else { ?>
        <p>
          <?=$texte_contenu?>
        </p>

      </div>

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>

      <hr class="separateur_contenu" id="texte_reactions">

      <div class="texte">

        <?php if(!$texte_feedback || ($texte_feedback == 1 && $texte_anonyme)) { ?>

        <p>L'auteur de ce texte a demandé spécifiquement à ne pas avoir de retours. Son texte est uniquement fait pour être lu, les réactions ne l'intéressent pas. Par conséquent, vous ne pouvez pas laisser de notes sur ce texte.</p>

        <br>
        <br>

        <?php } else if($texte_feedback == 1) { ?>

        <p>L'auteur de ce texte accepte les retours sur son texte, mais uniquement par messages privés. Vous ne pouvez pas laisser de notes sur ce texte, mais vous pouvez toutefois communiquer ce que vous en avez pensé en <a href="<?=$chemin?>pages/user/pm?user=<?=$texte_auteur_id?>">écrivant un message privé à <?=$texte_auteur?></a>.</p>

        <br>
        <br>

        <?php } else { ?>

        <br>
        <br>

        <h4>
          Réactions au texte
        </h4>

        <?php if($je_suis_auteur && !$nreactions) { ?>

        <p>Comme vous êtes l'auteur de ce texte, vous ne pouvez pas y poster de réaction vous-même.</p>
        <br>

        <?php } else if(!$nreactions) { ?>

        <p>Personne n'a posté de réaction à ce texte pour le moment. Voulez-vous être le premier ?</p>
        <br>

        <?php } else { ?>

        <?php for($i=0;$i<$nreactions;$i++) { ?>

        <p>
          <?php if($est_sysop) { ?>
          <span id="texte_reaction_<?=$reaction_id[$i]?>">
            <img src="<?=$chemin?>img/icones/supprimer.svg" height="15px" class="pointeur" onclick="texte_supprimer_reaction('<?=$chemin?>', <?=$reaction_id[$i]?>)">
          </span>
          <?php } ?>
          <span class="gras texte_noir"><?=$reaction_note[$i]?> / 5</span>
          par
          <?php if($reaction_anonyme[$i] && $est_admin) { ?>
          <span class="texte_noir gras">Anonyme</span> (<?=$reaction_pseudo[$i]?>)
          <?php } else if($reaction_anonyme[$i]) { ?>
          <span class="texte_noir gras">Anonyme</span>
          <?php } else { ?>
          <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$reaction_userid[$i]?>"><?=$reaction_pseudo[$i]?></a>
          <?php } ?>
          le <?=$reaction_date[$i]?>
          <?=$reaction_message[$i]?>
          <?php if($reaction_cestmoi[$i]) { ?>
          <br>
          <form method="POST">
            <input type="submit" class="button-outline" value="Supprimer ma réaction à ce texte" name="supprimer_reaction" onclick="return confirm('Confirmer la suppression ?');">
          </form>
          <?php } ?>
        </p>

        <?php } ?>

        <?php } ?>

        <?php if($loggedin) { ?>

        <?php if(!$je_suis_auteur && !$deja_reagi) { ?>

        <br>
        <br>

        <form method="POST" action="texte?id=<?=$texte_id?>#texte_reactions">
          <fieldset>

            <label for="reaction_note">Votre opinion sur le texte</label>
            <select id="reaction_note" name="reaction_note" class="indiv">
              <option value="5">5/5 : Excellent, rien à redire !</option>
              <option value="4">4/5 : Ce texte était agréable à lire, beau travail</option>
              <option value="3">3/5 : Un bel effort d'écriture, félicitations</option>
              <option value="2">2/5 : Il reste du travail à faire, mais c'est déjà pas mal</option>
              <option value="1">1/5 : Bof, je n'ai pas beaucoup aimé lire ce texte</option>
              <option value="0">0/5 : C'était mauvais, désolé</option>
            </select><br>
            <br>

            <label for="reaction_commentaire">Laisser un commentaire avec votre opinion (optionnel)</label>
            <input id="reaction_commentaire" name="reaction_commentaire" class="indiv" type="text"><br>
            <br>

            <div class="float-right">
              <input id="reaction_anonyme" name="reaction_anonyme" type="checkbox">
              <label class="label-inline" for="reaction_anonyme">Poster mon opinion anonymement</label>
            </div>
            <input value="POSTER MON OPINION SUR CE TEXTE" type="submit" name="reaction_go">

          </fieldset>
        </form>

        <?php } ?>

        <?php } else { ?>

        <p>
          Vous devez être connecté à votre compte pour poster votre opinion sur ce texte.<br>
          <a class="gras" href="<?=$chemin?>pages/user/login">Cliquez ici pour vous identifier ou vous enregistrer</a>
        </p>

        <?php } ?>

        <?php } ?>

        <?php } ?>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }