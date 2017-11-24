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
$page_titre = "Supprimer une miscellanée";




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
// Suppression de la miscellanée

if(isset($_POST['misc_raison']))
{
  // Assainissement du postdata
  $misc_raison = $_POST['misc_raison'];

  // On va chercher des infos sur la miscellanée rejetée
  $qmisc = mysqli_fetch_array(query(" SELECT    quotes.contenu  AS 'q_contenu'  ,
                                                membres.id      AS 'm_auteur'
                                      FROM      quotes
                                      LEFT JOIN membres ON quotes.FKauteur = membres.id
                                      WHERE     quotes.id = '$misc_id' "));

  // On envoie un message de rejet à l'auteur
  $misc_auteur      = $qmisc['m_auteur'];
  $misc_contenu_raw = $qmisc['q_contenu'];
  $misc_raison      = ($misc_raison) ? $misc_raison : "Aucune raison spécifiée";
  $misc_message     = <<<EOD
[b]Votre proposition de miscellanée a été refusée.[/b]

[b]Raison du refus :[/b] {$misc_raison}

[b]Contenu de la proposition :[/b]
[quote]{$misc_contenu_raw}[/quote]

Même si votre miscellanée a été refusée, votre proposition de contribution aux miscellanées de NoBleme est appréciée. Nous préférons conserver la qualité plutôt que la quantité, par conséquent les critères de sélection sont sévères. N'hésitez pas à soumettre d'autres propositions de miscellanées dans le futur !
EOD;
  envoyer_notif($misc_auteur, "Proposition de miscellanée refusée", postdata($misc_message));
}

if(isset($_POST['misc_delete']))
{
  // On supprime la miscellanée
  query(" DELETE FROM quotes
          WHERE       quotes.id = '$misc_id' ");

  // On supprime les membres liés
  query(" DELETE FROM quotes_membres
          WHERE       quotes_membres.FKquotes = '$misc_id' ");

  // On supprime l'activité récente liée
  query(" DELETE FROM activite
          WHERE       action_type LIKE  'quote'
          AND         action_id   =     '$misc_id' ");

  // Redirection vers les miscellanées
  exit(header("Location: ".$chemin."pages/quotes/index?admin"));
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
$misc_contenu = predata($qmisc['q_contenu'], 1);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1>Supprimer la miscellanée #<?=$misc_id?></h1>

        <br>

        <form method="POST">
          <fieldset>
            <?php if(!$misc_valide) { ?>
            <label for="misc_raison">Raison du rejet :</label>
            <input type="text" class="indiv" name="misc_raison"><br>
            <br>
            <input type="submit" value="REJETER LA MISCELLANÉE" name="misc_delete">
            <?php } else { ?>
            <input type="submit" value="SUPPRIMER LA MISCELLANÉE" name="misc_delete">
            <?php } ?>
          </fieldset>
        </form>

        <br>

        <p class="monospace">
          <span class="gras">Soumise par <?=$misc_auteur?> <?=$misc_date?></span><br>
          <?=$misc_contenu?><br>
        </p>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';