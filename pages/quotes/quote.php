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
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Miscellanée #" : "Quote #";
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
$misc_langue  = postdata($lang, 'string', 'FR');
$qrandommisc  = mysqli_fetch_array(query("  SELECT    quotes.id
                                            FROM      quotes
                                            WHERE     quotes.valide_admin =     1
                                            AND       quotes.langue       LIKE  '$misc_langue'
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
$qmisc = mysqli_fetch_array(query(" SELECT    quotes.id         AS 'q_id'       ,
                                              quotes.timestamp  AS 'q_time'     ,
                                              quotes.contenu    AS 'q_contenu'  ,
                                              quotes.nsfw       AS 'q_nsfw'
                                    FROM      quotes
                                    WHERE     quotes.id = '$misc_id' "));

// Préparation des données pour l'affichage
$misc_id      = $qmisc['q_id'];
$temp_date_fr = ($qmisc['q_time']) ? '<span class="gras">du '.predata(jourfr(date('Y-m-d', $qmisc['q_time']), 'FR')).'</span>' : '';
$temp_date_en = ($qmisc['q_time']) ? '<span class="gras">'.predata(jourfr(date('Y-m-d', $qmisc['q_time']), 'EN')).'</span>' : '';
$misc_date    = ($lang == 'FR') ? $temp_date_fr : $temp_date_en;
$misc_contenu = predata($qmisc['q_contenu'], 1, 1);
$misc_nsfw    = (niveau_nsfw()) ? 0 : $qmisc['q_nsfw'];

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
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Miscellanée";
  $trad['desc_nsfw']  = <<<EOD
Cette citation est floutée car elle contient du contenu vulgaire ou sensible, vous devez passer votre curseur dessus pour lire son contenu. Si le floutage vous ennuie, vous pouvez le désactiver de façon permanente via les <a class="gras" href="{$chemin}pages/user/nsfw">options de vulgarité</a> de votre compte.;
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Quote";
  $trad['desc_nsfw']  = <<<EOD
This quote is blurred due to its crude or sensitive content. Hover your mouse cursor over it in order to reveal its contents. If you are bothered by the blurring or have no need for it, you can permanently disable it in the <a class="gras" href="{$chemin}pages/user/nsfw">adult content options</a> of your account.
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1>
          <a href="<?=$chemin?>pages/quotes/index"><?=$trad['titre']?> #<?=$misc_id?></a>
        </h1>

        <?php if($lang == 'FR') { ?>
        <h5>
          Petite citation amusante
        </h5>
        <?php } ?>

        <?php if($misc_nsfw) { ?>
        <p>
          <?=$trad['desc_nsfw']?>
        </p>
        <?php } ?>

        <p class="monospace align_left">
          <a class="gras" href="<?=$chemin?>pages/quotes/quote?id=<?=$misc_id?>"><?=$trad['titre']?> #<?=$misc_id?></a> <?=$misc_date?> <?=$misc_pseudos?>
          <?php if(getadmin()) { ?>
          - <a class="gras" href="<?=$chemin?>pages/quotes/edit?id=<?=$misc_id?>">Modifier</a> - <a class="gras" href="<?=$chemin?>pages/quotes/delete?id=<?=$misc_id?>">Supprimer</a>
          <?php } ?>
          <br>

          <?php if($misc_nsfw) { ?>
          <span class="flou">
            <?=$misc_contenu?>
          </span>
          <?php } else { ?>
            <?=$misc_contenu?>
          <?php } ?>

        </p>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';