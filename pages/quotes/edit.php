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
  $misc_date    = postdata_vide('misc_date', 'string', '');
  $misc_date    = ($misc_date) ? strtotime($misc_date) : 0;
  $misc_contenu = postdata_vide('misc_contenu', 'string', '');
  $misc_langue  = postdata_vide('misc_langue', 'string', 'FR');
  $misc_nsfw    = (isset($_POST['misc_nsfw'])) ? 1 : 0;

  // On met à jour la miscellanée
  query(" UPDATE  quotes
          SET     quotes.timestamp  = '$misc_date'    ,
                  quotes.contenu    = '$misc_contenu' ,
                  quotes.langue     = '$misc_langue'  ,
                  quotes.nsfw       = '$misc_nsfw'
          WHERE   quotes.id         = '$misc_id' ");

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
    if($misc_langue == 'FR')
    {
      $misc_message   = <<<EOD
[b]Félicitations, votre proposition de miscellanée a été acceptée ![/b]

Vous pouvez retrouver la miscellanée #{$misc_id} en [url={$chemin}pages/quotes/quote?id={$misc_id}]cliquant ici[/url].

Votre contribution aux miscellanées de NoBleme est appréciée. N'hésitez pas à soumettre d'autres propositions de miscellanées dans le futur !
EOD;
      envoyer_notif($misc_auteur, "Proposition de miscellanée acceptée", postdata($misc_message));
    }
    else
    {
      $misc_message   = <<<EOD
[b]Congratulations, your quote proposal has been approved![/b]

You can read miscellanea #{$misc_id} by [url={$chemin}pages/quotes/quote?id={$misc_id}]clicking here[/url].

Your contribution to NoBleme's quote database is appreciated. Do not hesitate to submit more quote proposals in the future!
EOD;
      envoyer_notif($misc_auteur, "Quote proposal approved", postdata($misc_message));
    }

    // On va aussi mettre une notification dans l'activité récente
    activite_nouveau('quote_new_'.changer_casse($misc_langue, 'min'), 0, 0, NULL, $misc_id);

    // Et via le bot IRC
    if($misc_langue == 'FR')
      ircbot($chemin, "Miscellanée #".$misc_id." ajoutée à la collection : ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#NoBleme");
    else
    {
      ircbot($chemin, "Miscellanée anglophone #".$misc_id." ajoutée à la collection : ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id, "#NoBleme");
      ircbot($chemin, "Quote #".$misc_id." added to the collection: ".$GLOBALS['url_site']."pages/quotes/quote?id=".$misc_id."&english", "#english");
    }

    // On redirige vers la liste des miscellanées
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
                                              quotes.langue       AS 'q_lang'     ,
                                              quotes.contenu      AS 'q_contenu'  ,
                                              quotes.nsfw         AS 'q_nsfw'     ,
                                              quotes.valide_admin AS 'q_valide'   ,
                                              membres.pseudonyme  AS 'm_auteur'
                                    FROM      quotes
                                    LEFT JOIN membres ON quotes.FKauteur = membres.id
                                    WHERE     quotes.id = '$misc_id' "));

// Préparation des données pour l'affichage
$misc_id        = $qmisc['q_id'];
$misc_date      = ($qmisc['q_time']) ? 'le '.predata(jourfr(date('Y-m-d', $qmisc['q_time']))) : '';
$misc_auteur    = predata($qmisc['m_auteur']);
$misc_valide    = $qmisc['q_valide'];
$misc_contenu   = $qmisc['q_contenu'];
$misc_editdate  = ($qmisc['q_time']) ? date('d-m-Y', $qmisc['q_time']) : '';
$misc_lang_fr   = ($qmisc['q_lang'] == 'FR') ? ' selected' : '';
$misc_lang_en   = ($qmisc['q_lang'] == 'EN') ? ' selected' : '';
$misc_nsfw      = ($qmisc['q_nsfw']) ? ' checked' : '';
$misc_preview   = (isset($_POST['misc_preview'])) ? predata($_POST['misc_preview'], 1, 1) : predata($qmisc['q_contenu'], 1, 1);

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
          <img class="pointeur" src="<?=$chemin?>img/icones/supprimer.svg" height="15" alt="X" onclick="miscellanee_membres_lies('<?=$chemin?>', <?=$misc_id?>, 'supprimer', <?=$miscpseudos_id[$i]?>);">
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

            <label for="misc_date">Date de la citation (Y-m-d)</label>
            <input type="text" id="misc_date" name="misc_date" class="indiv" value="<?=$misc_editdate?>"><br>
            <br>

            <label for="misc_langue">Langue de la citation</label>
            <select id="misc_langue" name="misc_langue" class="indiv">
              <option value="FR"<?=$misc_lang_fr?>>Français</option>
              <option value="EN"<?=$misc_lang_en?>>Anglais</option>
            </select><br>
            <br>

            <input id="misc_nsfw" name="misc_nsfw" type="checkbox"<?=$misc_nsfw?>>
            <label class="label-inline" for="misc_nsfw">Cette citation est NSFW</label><br>
            <br>

            <?php if(!$misc_valide) { ?>
            <input type="submit" value="APPROUVER LA MISCELLANÉE" name="misc_approve">
            <?php } else { ?>
            <input type="submit" value="MODIFIER LA MISCELLANÉE">
            <?php } ?>

            <br>
            <br>

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