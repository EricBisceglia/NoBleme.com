<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
adminonly();

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'MiscIndex';

// Identification
$page_nom = "Administre secrètement le site";

// Titre et description
$page_titre = "Modifier une miscellanée";

// JS
$js = array('quotes/modifier_miscellanee', 'dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id

// Si on a pas précisé d'id, on dégage
if(!isset($_GET['id']) && !isset($_GET['random']))
  exit(header("Location: ".$chemin."pages/quotes/index"));

// On vérifie si la miscellanée existe
$misc_id    = postdata($_GET['id'], 'int');
$qcheckmisc = mysqli_fetch_array(query("  SELECT  quotes.id
                                          FROM    quotes
                                          WHERE   quotes.id = '$misc_id' "));

// Si elle n'existe pas, on dégage
if($qcheckmisc['id'] === NULL)
  exit(header("Location: ".$chemin."pages/quotes/index"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un membre lié à la miscellannée

if(isset($_POST['misc_action']) && $_POST['misc_action'] == 'ajout')
{
  // Assainissement du postdata
  $misc_ajouter = postdata_vide('misc_membre', 'string', '');

  // On récupère l'id du membre
  $qgetmembre = mysqli_fetch_array(query("  SELECT  membres.id
                                            FROM    membres
                                            WHERE   membres.pseudonyme LIKE '$misc_ajouter' collate utf8mb4_general_ci "));

  // On vérifie si le membre est déjà lié
  $misc_ajouter     = $qgetmembre['id'];
  $qgetquotesmembre = mysqli_fetch_array(query("  SELECT  quotes_membres.id
                                                  FROM    quotes_membres
                                                  WHERE   quotes_membres.FKquotes   = '$misc_id'
                                                  AND     quotes_membres.FKmembres  = '$misc_ajouter' "));

  // On ajoute le membre lié
  if($qgetmembre['id'] != NULL && $qgetquotesmembre['id'] == NULL)
    query(" INSERT INTO quotes_membres
            SET         quotes_membres.FKquotes   = '$misc_id'      ,
                        quotes_membres.FKmembres  = '$misc_ajouter' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un membre lié à la miscellannée

if(isset($_POST['misc_action']) && $_POST['misc_action'] == 'supprimer')
{
  // Assainissement du postdata
  $misc_supprimer = postdata_vide('misc_membre', 'int', 0);

  // On supprime le lien avec le membre
  query(" DELETE FROM quotes_membres
          WHERE       quotes_membres.FKmembres  = '$misc_supprimer'
          AND         quotes_membres.FKquotes   = '$misc_id' ");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification de la miscellanée

if(isset($_POST['misc_contenu']))
{
  // Assainissement du postdata
  $misc_contenu = postdata_vide('misc_contenu', 'string', '');

  // On met à jour la miscellanée
  query(" UPDATE  quotes
          SET     quotes.contenu  = '$misc_contenu'
          WHERE   quotes.id       = '$misc_id' ");

  // Si c'est une nouvelle miscellanée...
  if(isset($_POST['misc_approve']))
  {
    // ...on commence par valider la miscellanée
    query(" UPDATE  quotes
            SET     quotes.valide_admin = 1
            WHERE   quotes.id           = '$misc_id' ");

    // On a besoin de l'auteur de la miscellanée...
    $qauteurmisc = mysqli_fetch_array(query(" SELECT  quotes.FKauteur
                                              FROM    quotes
                                              WHERE   quotes.id = '$misc_id' "));

    // ...pour lui envoyer un message de félicitations
    $misc_auteur      = $qauteurmisc['FKauteur'];
    $misc_message     = <<<EOD
[b]Félicitations, votre proposition de miscellanée a été acceptée ![/b]

Vous pouvez retrouver la miscellanée #{$misc_id} en [url={$chemin}pages/quotes/quote?id={$misc_id}]cliquant ici[/url].

Votre contribution aux miscellanées de NoBleme est appréciée. N'hésitez pas à soumettre d'autres propositions de miscellanées dans le futur !
EOD;
    envoyer_notif($misc_auteur, "Proposition de miscellanée acceptée", postdata($misc_message));

    // On va aussi mettre une notification dans l'activité récente
    $misc_timestamp = time();
    query(" INSERT INTO activite
            SET         timestamp   = '$misc_timestamp' ,
                        action_type = 'quote'           ,
                        action_id   = '$misc_id'        ");

    // Et via le bot IRC
    ircbot($chemin, "Miscellanée #".$misc_id." ajoutée à la collection: ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#NoBleme");

    // On rediriger vers la liste des miscellanées
    exit(header("Location: ".$chemin."pages/quotes/index"));
  }

  // Sinon, on redirige vers la miscellanée modifiée
  exit(header("Location: ".$chemin."pages/quotes/quote?id=".$misc_id));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la miscellanée
$qmisc = mysqli_fetch_array(query(" SELECT    quotes.id           AS 'q_id'       ,
                                              quotes.timestamp    AS 'q_time'     ,
                                              quotes.contenu      AS 'q_contenu'  ,
                                              quotes.valide_admin AS 'q_valide'   ,
                                              membres.pseudonyme  AS 'm_auteur'
                                    FROM      quotes
                                    LEFT JOIN membres ON quotes.FKauteur = membres.id
                                    WHERE     quotes.id = '$misc_id' "));

// Préparation des données pour l'affichage
$misc_id      = $qmisc['q_id'];
$misc_date    = ($qmisc['q_time']) ? 'le '.predata(jourfr(date('Y-m-d', $qmisc['q_time']))) : '';
$misc_auteur  = predata($qmisc['m_auteur']);
$misc_valide  = $qmisc['q_valide'];
$misc_contenu = predata($qmisc['q_contenu']);
$misc_preview = (isset($_POST['misc_preview'])) ? predata($_POST['misc_preview'], 1) : predata($qmisc['q_contenu'], 1);

// On a aussi besoin des membres liés à la miscellanée
$tempid       = $qmisc['q_id'];
$qmiscpseudos = query(" SELECT      quotes_membres.FKmembres  AS 'qm_id' ,
                                    membres.pseudonyme        AS 'qm_pseudo'
                        FROM        quotes_membres
                        LEFT JOIN   membres ON quotes_membres.FKmembres = membres.id
                        WHERE       quotes_membres.FKquotes = '$tempid'
                        ORDER BY    membres.pseudonyme ASC ");
for($nmiscpseudos = 0; $dmiscpseudos = mysqli_fetch_array($qmiscpseudos); $nmiscpseudos++)
{
  $miscpseudos_id[$nmiscpseudos]      = $dmiscpseudos['qm_id'];
  $miscpseudos_pseudo[$nmiscpseudos]  = predata($dmiscpseudos['qm_pseudo']);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte2">

        <h1>Modifier la miscellanée #<?=$misc_id?></h1>

        <h5>Soumise par <?=$misc_auteur?> <?=$misc_date?></h5>

        <br>

        <label>Membres actuellement liés à la miscellanée :</label>
        <div id="misc_membres_lies">
          <?php } if(!isset($_POST['misc_preview'])) { ?>
          <?php if(!$nmiscpseudos) { ?>
          Aucun pour le moment<br>
          <?php } else { ?>
          <?php for($i=0;$i<$nmiscpseudos;$i++) { ?>
          <img class="pointeur" src="<?=$chemin?>img/icones/delete.png" height="15" alt="X" onclick="miscellanee_membres_lies('<?=$chemin?>', <?=$misc_id?>, 'supprimer', <?=$miscpseudos_id[$i]?>);">
          <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$miscpseudos_id[$i]?>"><?=$miscpseudos_pseudo[$i]?></a>
          <br>
          <?php } ?>
          <?php } ?>
          <br>
          <?php } if(!getxhr()) { ?>
        </div>

        <label for="misc_membres">Lier un membre à la miscellanée :</label>
        <input class="indiv" type="text" id="misc_membres" name="misc_membres"><br>
        <br>
        <button type="button" class="button button-outline" onclick="miscellanee_membres_lies('<?=$chemin?>', <?=$misc_id?>, 'ajout');">LIER LE MEMBRE À LA MISCELLANÉE</button><br>
        <br>
        <br>

        <form method="POST">
          <fieldset>

            <label for="misc_contenu">Modifier le contenu de la miscellanée :</label>
            <textarea class="indiv" id="misc_contenu" name="misc_contenu" style="height:250px" onkeyup="previsualiser_miscellanee('<?=$chemin?>', <?=$misc_id?>);"><?=$misc_contenu?></textarea><br>
            <br>

            <?php if(!$misc_valide) { ?>
            <input type="submit" value="APPROUVER LA MISCELLANÉE" name="misc_approve">
            <?php } else { ?>
            <input type="submit" value="MODIFIER LA MISCELLANÉE">
            <?php } ?>

            <p>
              <label>Prévisualisation de la miscellanée :</label>
              <span class="monospace" id="misc_preview">
                <?php } if(!isset($_POST['misc_action'])) { ?>
                <?=$misc_preview?>
                <?php } if(!getxhr()) { ?>
              </span>
            </p>

          </fieldset>
        </form>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }