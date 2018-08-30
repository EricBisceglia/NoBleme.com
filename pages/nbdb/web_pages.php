<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBEncycloListe';

// Identification
$page_nom = "Parcourt la culture du web";
$page_url = "pages/nbdb/web_liste";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "NBDB : Culture internet" : "NBDB: Internet culture";
$page_desc  = "Liste des pages de l'encyclopédie de la culture internet, des obscurs bulletin boards d'antan aux memes modernes.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des pages

// On spécifique la langue à utiliser
$web_lang = changer_casse($lang, 'min');

// On spéficie si on veut les redirections ou non
$where_web_redirections = getadmin() ? " " : " AND nbdb_web_page.redirection_$web_lang LIKE '' ";

// On va chercher la liste des définitions pour notre langue
$qweb = query(" SELECT    nbdb_web_page.redirection_$web_lang  AS 'd_redirect' ,
                          nbdb_web_page.titre_$web_lang        AS 'd_titre'
                FROM      nbdb_web_page
                WHERE     nbdb_web_page.titre_$web_lang  NOT LIKE ''
                          $where_web_redirections
                ORDER BY  nbdb_web_page.titre_$web_lang REGEXP '^[a-z]' DESC  ,
                          nbdb_web_page.titre_$web_lang                       ");

// Préparation pour l'affichage
for($nweb = 0 ; $dweb = mysqli_fetch_array($qweb) ; $nweb++)
{
  $temp_lettre          = substr(remplacer_accents(changer_casse($dweb['d_titre'], 'maj')), 0, 1);
  $temp_specialchars    = ($lang == 'FR') ? 'Divers' : 'Various';
  $web_lettre[$nweb]    = (ctype_alpha($temp_lettre)) ? $temp_lettre : $temp_specialchars;
  $web_titre[$nweb]     = predata($dweb['d_titre']);
  $web_titre_css[$nweb] = ($dweb['d_redirect']) ? 'gras texte_noir' : 'gras';
  $web_titre_url[$nweb] = urlencode($dweb['d_titre']);
  $web_redirect[$nweb]  = ($dweb['d_redirect']) ? ' -> '.predata($dweb['d_redirect']) : '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Introduction
  $trad['titre']      = "Encyclopédie de la culture web";
  $trad['soustitre']  = "Documentation de l'histoire des memes et de la culture d'internet";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  $trad['titre']      = "Internet culture encyclopedia";
  $trad['soustitre']  = "Documenting the history of memes and internet culture";
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          <a href="<?=$chemin?>pages/nbdb/web">
            <?=$trad['titre']?>
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
        </h5>

        <br>
        <br>

        <?php for($i=0;$i<$nweb;$i++) { ?>

        <?php if($i == 0 || $web_lettre[$i] != $web_lettre[$i-1]) { ?>

        <br>
        <h4><?=$web_lettre[$i]?></h4>
        <br>

        <?php } ?>

        <ul>
          <li>
            <a class="<?=$web_titre_css[$i]?>" href="<?=$chemin?>pages/nbdb/web?page=<?=$web_titre_url[$i]?>"><?=$web_titre[$i]?></a> <?=$web_redirect[$i]?>
          </li>
        </ul>

        <?php } ?>


      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';