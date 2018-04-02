<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsListe';

// Identification
$page_nom = "Coin des écrivains";
$page_url = "pages/ecrivains/texte?id=";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Coin des écrivains";
$page_desc  = "Coin des écrivains de NoBleme";

// CSS & JS
$css  = array('ecrivains');
$js   = array('dynamique', 'ecrivains/texte');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Identification du texte

// Si on a pas d'id, on dégage
if(!isset($_GET['id']))
  erreur("Texte inexistant");

// On récupère l'id du sujet
$texte_id = postdata($_GET['id'], 'int', 0);

// On va chercher si le sujet existe, et on en profite pour récupérer des infos pour le header et sur l'apparence de sujet
$qveriftexte = mysqli_fetch_array(query(" SELECT    ecrivains_texte.titre AS 't_titre'
                                          FROM      ecrivains_texte
                                          LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                                          WHERE     ecrivains_texte.id = '$texte_id' "));

// S'il existe pas, on dégage
if($qveriftexte['t_titre'] === NULL)
  erreur("Texte inexistant");

// Et on met à jour les infos du header
$loggedin     = loggedin();
$texte_titre  = predata($qveriftexte['t_titre']);
$page_nom    .= ' : '.predata(tronquer_chaine($qveriftexte['t_titre'], 25, '...'));
$page_url    .= $texte_id;
$page_titre   = predata($qveriftexte['t_titre']);
$page_desc   .= ' : '.predata($qveriftexte['t_titre']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'une nouvelle réaction sur le texte

if(isset($_POST['reaction_go']))
{
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
    $note_pseudo = postdata(getpseudo(), 'string');
    query(" INSERT INTO activite
            SET         activite.timestamp      = '$timestamp'              ,
                        activite.pseudonyme     = '$note_pseudo'            ,
                        activite.action_type    = 'ecrivains_reaction_new'  ,
                        activite.action_id      = '$texte_id'               ,
                        activite.action_titre   = '$texte_titre'            ");
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
  query(" DELETE FROM activite
          WHERE       activite.action_type  =     'ecrivains_reaction_new'
          AND         activite.action_id    =     '$texte_id'
          AND         activite.pseudonyme   LIKE  '$note_pseudo' ");
}


var_dump($_POST);




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
$qtexte = mysqli_fetch_array(query("  SELECT    ecrivains_texte.titre               AS 't_titre'    ,
                                                ecrivains_texte.contenu             AS 't_contenu'  ,
                                                ecrivains_texte.timestamp_creation  AS 't_creation' ,
                                                ecrivains_texte.niveau_feedback     AS 't_feedback' ,
                                                membres.id                          AS 'm_id'       ,
                                                membres.pseudonyme                  AS 'm_pseudo'
                                      FROM      ecrivains_texte
                                      LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                                      WHERE     ecrivains_texte.id = '$texte_id' "));

// Puis on prépare le contenu pour l'affichage
$est_sysop        = getsysop();
$est_auteur       = (loggedin() && ($qtexte['m_id'] == $_SESSION['user']));
$texte_titre      = predata($qtexte['t_titre']);
$texte_contenu    = bbcode(predata($qtexte['t_contenu'], 1));
$texte_auteur_id  = $qtexte['m_id'];
$texte_auteur     = predata($qtexte['m_pseudo']);
$texte_creation   = predata(ilya($qtexte['t_creation']));
$texte_feedback   = $qtexte['t_feedback'];




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
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.png" alt="M">
          </a>
          <a href="<?=$chemin?>pages/ecrivains/texte_supprimer?id=<?=$texte_id?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.png" alt="X">
          </a>
          <?php } ?>
        </h3>

        <h6>Publié dans le <a href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme par <a href="<?=$chemin?>pages/user/user?id=<?=$texte_auteur_id?>"><?=$texte_auteur?></a> <?=$texte_creation?></h6>

        <br>

        <p><?=$texte_contenu?></p>

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

        <?php if(!$texte_feedback) { ?>

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
            <img src="<?=$chemin?>img/icones/delete.png" height="15px" class="pointeur" onclick="texte_supprimer_reaction('<?=$chemin?>', <?=$reaction_id[$i]?>)">
          </span>
          <?php } ?>
          <span class="gras texte_noir"><?=$reaction_note[$i]?> / 5</span>
          par
          <?php if($reaction_anonyme[$i]) { ?>
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

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }