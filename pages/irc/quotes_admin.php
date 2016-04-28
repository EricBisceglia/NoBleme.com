<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Identification
$page_nom = "admin";
$page_id  = "admin";



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On récupère l'id de la miscellanée à éditer ou supprimer

if(!isset($_GET['edit']) && !isset($_GET['tag']) && !isset($_GET['delete']))
  erreur('ID invalide');
if(isset($_GET['edit']))
  $idquote = postdata($_GET['edit']);
if(isset($_GET['tag']))
  $idquote = postdata($_GET['tag']);
if(isset($_GET['delete']))
  $idquote = postdata($_GET['delete']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'une quote

if(isset($_POST['quote_edit_x']))
{
  // Assainissement du postdata
  $quote_contenu = postdata(destroy_html($_POST['quote_contenu']));

  // Modification
  query(" UPDATE quotes SET contenu = '$quote_contenu' WHERE id = '$idquote' ");

  // On va check si c'était une quote non approuvée
  $qapprove = mysqli_fetch_array(query(" SELECT quotes.FKauteur, quotes.valide_admin FROM quotes WHERE quotes.id = '$idquote' "));
  if(!$qapprove['valide_admin'])
  {
    // Auquel cas on la valide et on félécite son auteur
    query(" UPDATE quotes SET valide_admin = 1 WHERE id = '$idquote' ");
    $add_message  = "[b]Votre proposition de miscellanée a été acceptée.[/b]\r\n\r\n";
    $add_message .= "La nouvelle miscellanée est visible ici : [b][url=".$chemin."pages/irc/quotes?id=".$idquote."]Miscellanée #".$idquote."[/url][/b]\r\n";
    $add_message .= "Merci d'avoir contribué aux miscellanées de NoBleme !\r\n";
    $add_message .= "N'hésitez pas à soumettre d'autres propositions de miscellanées dans le futur.";
    envoyer_notif($qapprove['FKauteur'] , 'Proposition de miscellanée acceptée' , postdata($add_message));

    // Activité récente
    $timestamp = time();
    query(" INSERT INTO activite
            SET         timestamp     = '$timestamp'  ,
                        action_type   = 'quote_add'   ,
                        action_id     = '$idquote'    ");

    // Bot IRC NoBleme
    ircbot($chemin,"Nouvelle miscellanée : http://nobleme.com/pages/irc/quotes?id=".$idquote,"#nobleme");
  }

  // Et on redirige vers la quote
  header('Location: '.$chemin.'pages/irc/quotes?id='.$idquote);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une quote

if(isset($_POST['quote_delete_x']))
{
  // On va check si c'était une quote non approuvée
  $qapprove = mysqli_fetch_array(query(" SELECT quotes.FKauteur, quotes.valide_admin FROM quotes WHERE quotes.id = '$idquote' "));
  if(!$qapprove['valide_admin'])
  {
    // Auquel cas on fait savoir à son auteur qu'elle dégage
    $del_message    = "[b]Votre proposition de miscellanée a été refusée.[/b]\r\n\r\n";
    if($_POST['quote_raison'])
      $del_message .= "[b]Raison du refus :[/b] ".$_POST['quote_raison']."\r\n\r\n";
    $del_message   .= "Même si votre miscellanée a été refusé, votre tentative de contribution aux miscellanées de NoBleme est appréciée.\r\n";
    $del_message   .= "Si vous pensez que le refus de cette miscellanée est injuste, vous pouvez répondre à ce message privé pour contester la décision.\r\n";
    $del_message   .= "N'hésitez pas à soumettre d'autres propositions de miscellanées dans le futur.";
    envoyer_notif($qapprove['FKauteur'] , 'Proposition de miscellanée refusée' , postdata($del_message));
  }

  // Nettoyage de l'activité récente
  query(" DELETE FROM activite WHERE action_type = 'quote_add' AND action_id = '$idquote' ");

  // Suppression
  query(" DELETE FROM quotes WHERE id = '$idquote' ");

  // Et on redirige vers les miscellanées
  header('Location: '.$chemin.'pages/irc/quotes');
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout de membres liés à une quote

if(isset($_POST['quote_tag_x']))
{
  // Assainissement
  $taguser = postdata($_POST['quote_taguser']);

  // On va check si l'user existe
  $qtaguser = query(" SELECT membres.id FROM membres WHERE membres.pseudonyme LIKE '$taguser' ");
  if(mysqli_num_rows($qtaguser))
  {
    // S'il existe, on va check s'il existe déjà
    $dtaguser   = mysqli_fetch_array($qtaguser);
    $idtaguser  = $dtaguser['id'];
    $qidtaguser = query(" SELECT quotes_membres.id FROM quotes_membres WHERE quotes_membres.FKquotes = '$idquote' AND quotes_membres.FKmembres = '$idtaguser' ");

    // S'il existe pas, on l'ajoute
    if(!mysqli_num_rows($qidtaguser))
      query(" INSERT INTO quotes_membres SET FKquotes = '$idquote' , FKmembres = '$idtaguser' ");
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un membre lié à une quote

if(isset($_POST['quote_taguser']) && !isset($_POST['quote_tag_x']))
{
  // On part chercher la liste des users tag à la quote
  $qtaggedcheck = query(" SELECT quotes_membres.id, quotes_membres.FKmembres FROM quotes_membres WHERE quotes_membres.FKquotes = '$idquote' ");

  // On les parcourt à la recherche de celui qui se fait delete
  while($dtaggedcheck = mysqli_fetch_array($qtaggedcheck))
  {
    // On recherche la quote qui doit être delete
    $tagcheck = $dtaggedcheck['FKmembres'];
    if(isset($_POST['quote_tag_delete_'.$tagcheck.'_x']))
    {
      // Puis on la delete
      $tagdelete = $dtaggedcheck['id'];
      query(" DELETE FROM quotes_membres WHERE id = '$tagdelete' ");
    }
  }
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu de la miscellanée

// On va chercher la miscellanée qui se fait editer
$qquote = query(" SELECT quotes.contenu FROM quotes WHERE quotes.id = '$idquote' ");

// Si y'en a pas on dégage
if(!mysqli_num_rows($qquote))
  erreur('ID invalide');

// On prépare pour l'affichage
$dquote = mysqli_fetch_array($qquote);
$quote_contenu_raw  = $dquote['contenu'];
$quote_contenu      = nl2br_fixed($dquote['contenu']);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Membres liés à la miscellanée

if(isset($_GET['tag']))
{
  // On va chercher les users tag à la miscellanée
  $qtagged = query("  SELECT      membres.pseudonyme        AS 'qpseudo'  ,
                                  quotes_membres.FKmembres  AS 'qid'
                      FROM        quotes_membres
                      LEFT JOIN   membres ON quotes_membres.FKmembres = membres.id
                      WHERE       quotes_membres.FKquotes = '$idquote'  ");

  // Et on les prépare pour l'affichage
  for($ntagged = 0 ; $dtagged = mysqli_fetch_array($qtagged) ; $ntagged++)
  {
    $tagged_id[$ntagged]      = $dtagged['qid'];
    $tagged_pseudo[$ntagged]  = $dtagged['qpseudo'];
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/administration.png" alt="Administration">
    </div>
    <br>
    <br>

    <?php if(isset($_GET['edit'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Modifier une miscellanée :</span><br>
      <br>
      <form name="edit_quote" action="quotes_admin?edit=<?=$idquote?>" method="POST">
        <textarea class="indiv" rows="25" name="quote_contenu"><?=$quote_contenu_raw?></textarea><br>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/modifier.png" alt="Modifier" name="quote_edit">
        </div>
      </form>
    </div>

    <?php } else if(isset($_GET['delete'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Supprimer une miscellanée :</span><br>
      <br>
      <br>
      <span class="monospace"><?=$quote_contenu?></span><br>
      <br>
      <hr class="points">
      <br>
      <form name="edit_quote" action="quotes_admin?delete=<?=$idquote?>" method="POST">
        <span class="gras">Raison du refus :</span><br>
        <input class="indiv" name="quote_raison"><br>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/supprimer.png" alt="Supprimer" name="quote_delete">
        </div>
      </form>
    </div>

    <?php } else if(isset($_GET['tag'])) { ?>
    <div class="body_main midsize">
      <span class="titre">Lier des membres à une miscellanée :</span><br>
      <br>
      <br>
      <span class="monospace"><?=$quote_contenu?></span><br>
      <br>
      <hr class="points">
      <br>
      <form name="edit_quote" action="quotes_admin?tag=<?=$idquote?>" method="POST">
        <span class="gras">Rajouter un membre :</span><br>
        <input class="indiv" name="quote_taguser"><br>
        <br>
        <div class="indiv align_center">
          <input type="image" src="<?=$chemin?>img/boutons/ajouter.png" alt="Ajouter" name="quote_tag">
        </div>
        <br>
        <hr class="points">
        <br>
        <?php if($ntagged) { ?>
        <span class="gras">Membres liés :</span><br>
        <?php for($i=0;$i<$ntagged;$i++) { ?>
        <input type="image" src="<?=$chemin?>img/icones/delete.png" alt="X" width="12px" name="quote_tag_delete_<?=$tagged_id[$i]?>"> <a class="dark blank" href="<?=$chemin?>pages/user/user?id=<?=$tagged_id[$i]?>"><?=$tagged_pseudo[$i]?></a><br>
        <?php } } else { ?>
        <div class="moinsgros gras indiv align_center">Aucun membre n'est lié à cette miscellanée pour le moment.</div>
        <?php } ?>
      </form>
    </div>
    <?php } ?>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';