<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
if(isset($_GET['admin']))
  adminonly();

// Menus du header
$header_menu      = (isset($_GET['admin'])) ? 'Admin' : 'Lire';
$header_sidemenu  = (isset($_GET['admin'])) ? 'QuotesBacklog' : 'MiscIndex';

// Identification
$page_nom = (isset($_GET['admin'])) ? "Administre secrètement le site" : "Se marre devant les miscellanées";
$page_url = (isset($_GET['admin'])) ? "" : "pages/quotes/index";

// Langages disponibles
$langage_page = array('FR');

// Titre et description
$page_titre = "Miscellanées";
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";

// JS
$js = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les citations
$qmisc = "    SELECT    quotes.id         AS 'q_id'   ,
                        quotes.timestamp  AS 'q_time' ,
                        quotes.contenu    AS 'q_contenu'
              FROM      quotes ";

// Version admin ou non
if(isset($_GET['admin']))
  $qmisc .= " WHERE     quotes.valide_admin = 0 ";
else
  $qmisc .= " WHERE     quotes.valide_admin = 1 ";

// Recherche
if(isset($_POST['misc_recherche']))
{
  $misc_recherche = postdata_vide('misc_recherche', 'string', '');
  $qmisc .= " AND       quotes.contenu LIKE '%$misc_recherche%' collate utf8_bin ";
}

// Tri
$qmisc .= "   ORDER BY  quotes.timestamp  DESC  ,
                        quotes.id         DESC  ";

// On envoie la requête
$qmisc = query($qmisc);

// Préparation des données pour l'affichage
for($nmisc = 0; $dmisc = mysqli_fetch_array($qmisc); $nmisc++)
{
  $misc_id[$nmisc]      = $dmisc['q_id'];
  $misc_date[$nmisc]    = ($dmisc['q_time']) ? '<span class="gras">du '.predata(jourfr(date('Y-m-d', $dmisc['q_time']))).'</span>' : '';
  $misc_contenu[$nmisc] = predata($dmisc['q_contenu'], 1);

  // On a aussi besoin des membres liés à la miscellanée
  $tempid               = $dmisc['q_id'];
  $qmiscpseudos         = query(" SELECT      quotes_membres.FKmembres  AS 'qm_id' ,
                                              membres.pseudonyme        AS 'qm_pseudo'
                                  FROM        quotes_membres
                                  LEFT JOIN   membres ON quotes_membres.FKmembres = membres.id
                                  WHERE       quotes_membres.FKquotes = '$tempid'
                                  ORDER BY    membres.pseudonyme ASC ");
  $temp_pseudos         = '';
  for($nmiscpseudos = 0; $dmiscpseudos = mysqli_fetch_array($qmiscpseudos); $nmiscpseudos++)
  {
    $temp_pseudos      .= ($nmiscpseudos) ? ', ' : '';
    $temp_pseudos      .= '<a href="'.$chemin.'pages/user/user?id='.$dmiscpseudos['qm_id'].'">'.predata($dmiscpseudos['qm_pseudo']).'</a>';
  }
  $misc_pseudos[$nmisc] = ($temp_pseudos) ? '<span class="gras">(</span>'.$temp_pseudos.'<span class="gras">)</span>' : '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte2">

        <?php if(isset($_GET['admin'])) { ?>

        <h1>Miscellanées en attente</h1>

        <?php } else { ?>

        <h1>Miscellanées</h1>

        <h5>Petites citations amusantes</h5>

        <p class="italique">
          Miscellanée : nom féminin, ordinairement au pluriel.<br>
          Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.
        </p>

        <p>
          Les miscellanées sont des phrases, des monologues, des conversations entre les NoBlemeux qui sont été conservés pour la posterité. Elles sont toutes présentes sur cette page, par ordre antéchronologique.
        </p>

        <p>
          L'intégralité de ces citations proviennent de NoBleme. La majorité viennent du <a class="gras" href="<?=$chemin?>pages/irc/index">serveur IRC</a>, les autres du <a class="gras" href="<?=$chemin?>pages/forum/index">forum</a> ou des <a class="gras" href="<?=$chemin?>pages/irl/index">rencontres IRL</a>. Si vous êtes diverti par du contenu qui a été écrit sur NoBleme, n'hésitez pas à proposer que ce contenu soit intégré aux miscellanées en <a class="gras" href="<?=$chemin?>pages/quote/add">cliquant ici</a>.
        </p>

        <br>

        <fieldset>
          <label for="miscRecherche">Rechercher dans les miscellanées :</label>
          <input id="miscRecherche" name="miscRecherche" class="indiv" type="text" placeholder="Écrivez du texte ici si vous souhaitez faire une recherche" onkeyup="dynamique('<?=$chemin?>', 'index.php', 'misc_quotes', 'misc_recherche='+dynamique_prepare('miscRecherche'), 1);">
        </fieldset>

        <br>

        <?php } ?>

        <div id="misc_quotes">

          <h5>Liste des <?=$nmisc?> miscellanées :</h5>

          <?php } if(getxhr() && $nmisc) { ?>

          <h5><?=$nmisc?> miscellanées trouvées :</h5>

          <?php } else if(getxhr()) { ?>

          <h5>Aucun résultat pour la recherche</h5>

          <?php } for($i=0;$i<$nmisc;$i++) { ?>

          <p class="monospace">
            <a class="gras" href="<?=$chemin?>pages/quotes/quote?id=<?=$misc_id[$i]?>">Miscellanée #<?=$misc_id[$i]?></a> <?=$misc_date[$i]?> <?=$misc_pseudos[$i]?>
            <?php if(getadmin()) { ?>
            - <a class="gras" href="<?=$chemin?>pages/quotes/edit?id=<?=$misc_id[$i]?>">Modifier</a> - <a class="gras" href="<?=$chemin?>pages/quotes/delete?id=<?=$misc_id[$i]?>">Supprimer</a>
            <?php } ?>
            <br>
            <?=$misc_contenu[$i]?>
          </p>

          <?php } if(!getxhr()) { ?>

        </div>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }