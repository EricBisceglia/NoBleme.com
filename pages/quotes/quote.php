<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = (!isset($_GET['random'])) ? 'MiscIndex' : 'MiscRandom';

// Identification
$page_nom = "Se marre devant la miscellanée #";
$page_url = "pages/quotes/quote?id=";

// Lien court
$shorturl = "m=";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Miscellanée #";
$page_desc  = "Intéractions entre NoBlemeux qui ont été conservées pour la postérité";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Si on a pas précisé d'id, on dégage
if(!isset($_GET['id']) && !isset($_GET['random']))
  exit(header("Location: ".$chemin."pages/quotes/index"));

// Si c'est random, on va chercher un id au pif
$qrandommisc = mysqli_fetch_array(query(" SELECT    quotes.id
                                          FROM      quotes
                                          WHERE     quotes.valide_admin = 1
                                          ORDER BY  RAND()
                                          LIMIT     1 "));

// On vérifie si la miscellanée existe
$misc_id    = (isset($_GET['random'])) ? $qrandommisc['id'] : postdata($_GET['id'], 'int');
$qcheckmisc = mysqli_fetch_array(query("  SELECT  quotes.valide_admin
                                          FROM    quotes
                                          WHERE   quotes.id = '$misc_id' "));

// Si elle n'existe pas, on dégage
if($qcheckmisc['valide_admin'] === NULL)
  exit(header("Location: ".$chemin."pages/quotes/index"));

// Si la miscellanée est pas validée et qu'on est pas admin, on dégage
if(!$qcheckmisc['valide_admin'] && !getadmin())
  exit(header("Location: ".$chemin."pages/quotes/index"));

// Maintenant, on peut compléter les infos de la page
$page_nom   .= $misc_id;
$page_url   .= $misc_id;
$shorturl   .= $misc_id;
$page_titre .= $misc_id;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la miscellanée
$qmisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'q_id'   ,
                                              quotes.timestamp  AS 'q_time' ,
                                              quotes.contenu    AS 'q_contenu'
                                    FROM      quotes
                                    WHERE     quotes.id = '$misc_id' "));

// Préparation des données pour l'affichage
$misc_id      = $qmisc['q_id'];
$misc_date    = ($qmisc['q_time']) ? '<span class="gras">du '.predata(jourfr(date('Y-m-d', $qmisc['q_time']))).'</span>' : '';
$misc_contenu = predata($qmisc['q_contenu'], 1, 1);

// On a aussi besoin des membres liés à la miscellanée
$tempid       = $qmisc['q_id'];
$qmiscpseudos = query(" SELECT      quotes_membres.FKmembres  AS 'qm_id' ,
                                    membres.pseudonyme        AS 'qm_pseudo'
                        FROM        quotes_membres
                        LEFT JOIN   membres ON quotes_membres.FKmembres = membres.id
                        WHERE       quotes_membres.FKquotes = '$tempid'
                        ORDER BY    membres.pseudonyme ASC ");
$temp_pseudos = '';
for($nmiscpseudos = 0; $dmiscpseudos = mysqli_fetch_array($qmiscpseudos); $nmiscpseudos++)
{
  $temp_pseudos .= ($nmiscpseudos) ? ', ' : '';
  $temp_pseudos .= '<a href="'.$chemin.'pages/user/user?id='.$dmiscpseudos['qm_id'].'">'.predata($dmiscpseudos['qm_pseudo']).'</a>';
}
$misc_pseudos = ($temp_pseudos) ? '<span class="gras">(</span>'.$temp_pseudos.'<span class="gras">)</span>' : '';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1><a href="<?=$chemin?>pages/quotes/index">Miscellanée #<?=$misc_id?></a></h1>

        <h5>Petite citation amusante</h5>

        <p class="monospace">
          <a class="gras" href="<?=$chemin?>pages/quotes/quote?id=<?=$misc_id?>">Miscellanée #<?=$misc_id?></a> <?=$misc_date?> <?=$misc_pseudos?>
          <?php if(getadmin()) { ?>
          - <a class="gras" href="<?=$chemin?>pages/quotes/edit?id=<?=$misc_id?>">Modifier</a> - <a class="gras" href="<?=$chemin?>pages/quotes/delete?id=<?=$misc_id?>">Supprimer</a>
          <?php } ?>
          <br>
          <?=$misc_contenu?><br>
        </p>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';