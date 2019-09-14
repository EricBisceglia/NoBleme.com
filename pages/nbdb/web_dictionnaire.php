<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/nbdb.inc.php';     // Fonctions lées à la NBDB

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBDicoWeb';

// Identification
$page_nom = "Apprend à comprendre internet";
$page_url = "pages/nbdb/web_dictionnaire";

// Lien court
$shorturl = "wd";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "NBDB : Culture internet" : "NBDB: Internet culture";
$page_desc  = "Dictionnaire des termes propres à la culture internet.";

// CSS & JS
$css  = array('nbdb');
$js   = array('dynamique', 'highlight');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id (ou de l'absence d'id) de la page

// On récupère le titre ou l'id s'il y en a un de spécifié
$dico_titre = (isset($_GET['define']))  ? postdata($_GET['define'], 'string') : '';
$dico_id    = (isset($_GET['id']))      ? predata($_GET['id'], 'int', 0)      : 0;

// Si c'est une définition aléatoire, on va choper un ID au pif
if(isset($_GET['random']))
{
  // Selon la langue, on fait une requête différente
  $dico_lang    = changer_casse($lang, 'min');
  $ddicorandom  = mysqli_fetch_array(query("  SELECT    nbdb_web_definition.id AS 'd_id'
                                              FROM      nbdb_web_definition
                                              WHERE     nbdb_web_definition.titre_$dico_lang    NOT LIKE ''
                                              AND       nbdb_web_definition.redirection_$dico_lang  LIKE ''
                                              AND       nbdb_web_definition.est_vulgaire               = 0
                                              ORDER BY  RAND()
                                              LIMIT     1 "));
  $dico_id      = $ddicorandom['d_id'];
}

// On va chercher si l'entrée existe
if($dico_titre && !$dico_id)
{
  // Selon la langue, on fait une requête différente
  $dico_lang  = changer_casse($lang, 'min');
  $dcheckdico = mysqli_fetch_array(query("  SELECT  nbdb_web_definition.id AS 'd_id'
                                            FROM    nbdb_web_definition
                                            WHERE   nbdb_web_definition.titre_$dico_lang  LIKE '$dico_titre' "));

  // Si la page existe, on récupère son id
  $dico_id = ($dcheckdico['d_id']) ? $dcheckdico['d_id'] : 0;
}
// Sinon, on lui met l'id 0
else if(!$dico_id)
  $dico_id = 0;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Contenu d'une définition

// On ne peut aller la chercher que si une définition spécifique est choisie
if($dico_id)
{
  // On spécifique la langue à utiliser
  $definition_lang      = changer_casse($lang, 'min');
  $definition_autrelang = ($definition_lang == 'fr') ? 'en' : 'fr';

  // On va chercher la définition
  $ddefinition = mysqli_fetch_array(query(" SELECT  nbdb_web_definition.redirection_$definition_lang      AS 'd_redirect'       ,
                                                    nbdb_web_definition.titre_$definition_lang            AS 'd_titre'          ,
                                                    nbdb_web_definition.definition_$definition_lang       AS 'd_contenu'        ,
                                                    nbdb_web_definition.titre_$definition_autrelang       AS 'd_titre_autre'    ,
                                                    nbdb_web_definition.redirection_$definition_autrelang AS 'd_redirect_autre' ,
                                                    nbdb_web_definition.contenu_floute                    AS 'd_floute'         ,
                                                    nbdb_web_definition.est_vulgaire                      AS 'd_vulgaire'       ,
                                                    nbdb_web_definition.est_politise                      AS 'd_politise'       ,
                                                    nbdb_web_definition.est_incorrect                     AS 'd_incorrect'
                                            FROM    nbdb_web_definition
                                            WHERE   nbdb_web_definition.id = '$dico_id' "));

  // Si c'est une redirection, on redirige vers la bonne page
  if($ddefinition['d_redirect'] && $ddefinition['d_redirect'] != $ddefinition['d_titre'] && !$est_admin)
    exit(header("Location: ".$chemin."pages/nbdb/web_dictionnaire?define=".urlencode($ddefinition['d_redirect'])));

  // S'il n'y a pas de définition dans notre langue, on dégage
  if(!$ddefinition['d_titre'])
    exit(header("Location: ".$chemin."pages/nbdb/web_dictionnaire"));

  // Puis on prépare le contenu de la définition pour l'affichage
  $definition_redirect      = ($ddefinition['d_redirect']) ? predata($ddefinition['d_redirect']) : '';
  $definition_redirect_url  = ($ddefinition['d_redirect']) ? urlencode($ddefinition['d_redirect']) : '';
  $definition_titre         = predata($ddefinition['d_titre']);
  $definition_contenu       = nbdbcode(bbcode(predata($ddefinition['d_contenu'], 1)), $chemin, nbdb_web_liste_pages_encyclopedie($lang), nbdb_web_liste_pages_dictionnaire($lang));
  $definition_floute        = (niveau_nsfw() < 2 && $ddefinition['d_floute']) ? 1 : 0;
  $definition_vulgaire      = $ddefinition['d_vulgaire'];
  $definition_politise      = $ddefinition['d_politise'];
  $definition_incorrect     = $ddefinition['d_incorrect'];
  $definition_bilingue      = ($ddefinition['d_titre_autre'] && !$ddefinition['d_redirect_autre']) ? 1 : 0;

  // Et on oublie pas de modifier les infos de la page
  $page_nom   = 'Apprend le sens de '.predata(tronquer_chaine($ddefinition['d_titre'], 20, '...'));
  $page_url   = "pages/nbdb/web_dictionnaire?define=".urlencode($ddefinition['d_titre']);
  $shorturl  .= "=".$dico_id;
  $page_titre = "NBDB : ".predata($ddefinition['d_titre']);
  $page_desc  = predata($ddefinition['d_titre']).", ça veut dire quoi ? Dictionnaire des termes propres à la culture internet.";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des définitions

// On en a besoin que si on est pas sur une définition spécifique
if(!$dico_id)
{
  // On spécifique la langue à utiliser
  $definition_lang = changer_casse($lang, 'min');

  // On spéficie si on veut les redirections ou non
  $where_definition_redirections = ($est_admin && isset($_GET['redirections'])) ? " " : " AND nbdb_web_definition.redirection_$definition_lang LIKE '' ";

  // On spécifie s'il y a une recherche en cours ou non
  $where_search       = postdata_vide('search', 'string', '');
  $where_dico_search  = ($where_search) ? " AND nbdb_web_definition.titre_$definition_lang LIKE '%$where_search%' " : '';

  // On va chercher la liste des définitions pour notre langue
  $qdefinition = query("  SELECT    nbdb_web_definition.redirection_$definition_lang  AS 'd_redirect' ,
                                    nbdb_web_definition.titre_$definition_lang        AS 'd_titre'    ,
                                    nbdb_web_definition.est_vulgaire                  AS 'd_vulgaire'
                          FROM      nbdb_web_definition
                          WHERE     nbdb_web_definition.titre_$definition_lang  NOT LIKE ''
                                    $where_definition_redirections
                                    $where_dico_search
                          ORDER BY  nbdb_web_definition.titre_$definition_lang REGEXP '^[a-z]' DESC  ,
                                    nbdb_web_definition.titre_$definition_lang                       ");

  // Préparation pour l'affichage
  for($ndefinition = 0 ; $ddefinition = mysqli_fetch_array($qdefinition) ; $ndefinition++)
  {
    $temp_lettre                        = substr(remplacer_accents(changer_casse($ddefinition['d_titre'], 'maj')), 0, 1);
    $temp_specialchars                  = ($lang == 'FR') ? 'Divers' : 'Various';
    $definition_lettre[$ndefinition]    = (ctype_alpha($temp_lettre)) ? $temp_lettre : $temp_specialchars;
    $definition_titre[$ndefinition]     = predata($ddefinition['d_titre']);
    $definition_titre_css[$ndefinition] = ($ddefinition['d_redirect']) ? 'gras texte_noir' : 'gras';
    $definition_titre_url[$ndefinition] = urlencode($ddefinition['d_titre']);
    $definition_redirect[$ndefinition]  = ($ddefinition['d_redirect']) ? ' -> '.predata($ddefinition['d_redirect']) : '';
    $definition_vulgaire[$ndefinition]  = ($ddefinition['d_vulgaire']) ? '<img class="valign_middle web_dict_nsfw" src="'.$chemin.'img/icones/avertissement.svg" alt="!" height="20">': '';
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Introduction
  $trad['titre']          = "Dictionnaire de la culture web";
  $trad['soustitre']      = "Documentation de l'histoire des memes et de la culture d'internet";
  $trad['desc']           = <<<EOD
Ce dictionnaire sert à accompagner <a class="gras" href="{$chemin}pages/nbdb/web">l'encyclopédie de la culture internet</a>, vous offrant des définitions pour comprendre les termes récurrents sans avoir à les redéfinir à chaque fois.
EOD;
  $trad['desc2']          = <<<EOD
Il sert également à définir divers termes amusants et/ou intéressants, et à toucher à des sujets sociaux importants à comprendre pour appréhender les subtilités de la culture internet, qui est souvent très politisée.
EOD;
  $trad['desc3']          = <<<EOD
Vous trouverez ci-dessous la liste alphabétique de toutes les définitions contenues dans ce dictionnaire, ainsi qu'un champ de texte vous permettant de chercher une définition spécifique si vous le désirez. Attention, les définitions dont le titre est suivi d'un point d'exclamation portent sur du contenu vulgaire ou dégueulasse.
EOD;
  $trad['dico_search']    = "Chercher une définition dans le dictionnaire";

  // Liste des définitions
  $trad['dico_trandom']   = "Aléatoire";
  $trad['dico_random']    = "Cliquez ici pour être redirigé vers une définition aléatoire";

  // Définitions spécifiques
  $trad['dico_colon']     = " :";
  $trad['dico_floutage']  = <<<EOD
Certains contenus de cette page sont floutés car ils sont de nature vulgaire ou sensible. Pour les afficher en clair, vous devez passer votre curseur dessus. Si le floutage vous ennuie, vous pouvez le désactiver de façon permanente via les <a class="gras" href="{$chemin}pages/users/nsfw">options de vulgarité</a> de votre compte.
EOD;
  $trad['dico_vulgaire']  = "LA DÉFINITION CI-DESSOUS CONTIENT DU CONTENU VULGAIRE OU DÉGUEULASSE";
  $trad['dico_politise']  = "La définition ci-dessous est politisée : elle aborde un sujet de société d'une façon avec laquelle tout le monde ne sera pas forcément d'accord. Le but de ce dictionnaire n'est pas de plaire à tous, mais plutôt de présenter des faits de façon objective, quitte à froisser certaines opinions.";
  $trad['dico_incorrect'] = "Le but de ce dictionnaire est de documenter toute la culture internet, même dans ses aspects offensants. La définition ci-dessous porte sur un sujet politiquement incorrect : il est très fortement conseillé de ne pas utiliser ce terme publiquement, car il a de mauvaises connotations.";
  $trad['dico_autre']     = "Autre définition au hasard";
  $trad['dico_bilingue']  = "This definition is available in english aswell";
  $trad['dico_bilingue2'] = "Cette définition est disponible en anglais également";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Introduction
  $trad['titre']          = "Internet culture dictionary";
  $trad['soustitre']      = "Documenting the history of memes and internet culture";
  $trad['desc']           = <<<EOD
This dictionary is meant to be used along with the <a class="gras" href="{$chemin}pages/nbdb/web">encyclopedia of internet culture</a>, helping you understand recurring terms in order to avoid having to redefine them every time they are mentioned.
EOD;
  $trad['desc2']          = <<<EOD
It is also used to define various funny and/or interesting terms, and to explain various social topics necessary to properly understand internet culture, which sometimes tends to have a political dimension.
EOD;
  $trad['desc3']          = <<<EOD
Below, you will find an alphabetical list of all the definitions in this dictionary, aswell as a text field that you can use to search for specific definitions. Be warned, entries whose name are followed by an exclamation mark are about gross or nasty content.
EOD;
  $trad['dico_search']    = "Search the dictionary";

  // Liste des définitions
  $trad['dico_trandom']   = "Random";
  $trad['dico_random']    = "Click here to be redirected towards a random definition";

  // Définitions spécifiques
  $trad['dico_colon']     = ":";
  $trad['dico_floutage']  = <<<EOD
Some contents on this page are blurred due to their crude or sensitive nature. Hover your mouse cursor over them in order to reveal their contents. If you are bothered by the blurring or have no need for it, you can permanently disable it in the <a class="gras" href="{$chemin}pages/users/nsfw">adult content options</a> of your account.
EOD;
  $trad['dico_vulgaire']  = "THE FOLLOWING DEFINITION CONTAINS NASTY AND/OR GROSS CONTENT";
  $trad['dico_politise']  = "The following definition is politically loaded: it concerns an aspect of society on which people tend to have disagreements. The goal of this dictionary is not to paint a skewed view of society, but rather to try to bring facts objectively, even if it means displeasing some crowds.";
  $trad['dico_incorrect'] = "This dictionary's goal is to document internet culture as a whole, including its offensive and irrespectful aspects. The following definition concerns a politically incorrect topic: it is heavily suggested that you do not use it publicly, as it has extremely negative connotations.";
  $trad['dico_autre']     = "Other random definition";
  $trad['dico_bilingue']  = "This definition is available in french aswell";
  $trad['dico_bilingue2'] = "Cette définition est disponible en français également";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Index du dictionnaire du web
      if(!$dico_id) { ?>

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_images">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/upload.svg" alt="+" height="22">
          </a>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_edit">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="22">
          </a>
          <?php } ?>
        </h5>

        <p><?=$trad['desc']?></p>

        <p><?=$trad['desc2']?></p>

        <p><?=$trad['desc3']?></p>

        <br>

        <form method="POST">
          <fieldset>
            <label for="web_dico_search"><?=$trad['dico_search']?></label>
            <input id="web_dico_search" name="web_dico_search" class="indiv" type="text" onkeyup="dynamique('<?=$chemin?>', 'web_dictionnaire', 'web_pages_liste', 'search=' + dynamique_prepare('web_dico_search'), 0);">
          </fieldset>
        </form>

        <br>

        <h4>
          <?=$trad['dico_trandom']?>
          <?php if($est_admin && !isset($_GET['redirections'])) { ?>
          <a class="gras valign_middle" href="<?=$chemin?>pages/nbdb/web_dictionnaire?redirections">
            <img src="<?=$chemin?>img/icones/lien.svg" alt="R">
          </a>
          <?php } else if($est_admin && isset($_GET['redirections'])) { ?>
          <a class="gras valign_middle" href="<?=$chemin?>pages/nbdb/web_dictionnaire">
            <img src="<?=$chemin?>img/icones/x.svg" alt="R">
          </a>
          <?php } ?>
        </h4>

        <br>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?random"><?=$trad['dico_random']?></a>
          </li>
        </ul>

        <?php } } if(!$dico_id) { ?>

        <div id="web_pages_liste">

          <?php for($i=0;$i<$ndefinition;$i++) { ?>

          <?php if($i == 0 || $definition_lettre[$i] != $definition_lettre[$i-1]) { ?>

          <br>
          <h4><?=$definition_lettre[$i]?></h4>
          <br>

          <?php } ?>

          <ul>
            <li>
              <a class="<?=$definition_titre_css[$i]?>" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=<?=$definition_titre_url[$i]?>"><?=$definition_titre[$i]?></a> <?=$definition_redirect[$i]?><?=$definition_vulgaire[$i]?>
            </li>
          </ul>

          <?php } ?>

        </div>

        <?php } if(!getxhr()) { ?>
        <?php if(!$dico_id) { ?>

      </div>




      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Redirection vers une autre page
      } else if($definition_redirect && $est_admin) { ?>

      <div class="texte">

        <h1>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire">
            <?=$trad['titre']?>
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_edit?id=<?=$dico_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="22">
          </a>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_delete?id=<?=$dico_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="22">
          </a>
          <?php } ?>
        </h5>

        <br>
        <br>

        <p class="alinea gros texte_noir">
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=<?=$definition_redirect_url?>">
            Redirection automatique vers : <span class="souligne"><?=$definition_redirect?></span>
          </a>
        </p>

      </div>




      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Page spécifique du dictionnaire du web
      } else { ?>

      <div class="texte align_justify">

        <h1>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire">
            <?=$trad['titre']?>
          </a>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_edit?id=<?=$dico_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="22">
          </a>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_delete?id=<?=$dico_id?>">
            &nbsp;<img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" height="22">
          </a>
          <?php } ?>
        </h5>

        <?php if($definition_floute) { ?>

        <p><?=$trad['dico_floutage']?></p>

        <?php } ?>

        <br>
        <br>

        <?php if($definition_vulgaire) { ?>

        <div class="flexcontainer web_dict_warning">
          <div style="flex:1" class="align_center">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="70">
          </div>
          <div style="flex:5" class="align_center gros gras texte_noir">
            <?=$trad['dico_vulgaire']?>
          </div>
          <div style="flex:1" class="align_center">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="70">
          </div>
        </div>
        <br>
        <br>

        <?php } if($definition_politise) { ?>

        <div class="flexcontainer web_dict_warning">
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
          <div style="flex:5" class="gras texte_noir">
            <?=$trad['dico_politise']?>
          </div>
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
        </div>
        <br>
        <br>

        <?php } if($definition_incorrect) { ?>

        <div class="flexcontainer web_dict_warning">
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
          <div style="flex:5" class="gras texte_noir">
            <?=$trad['dico_incorrect']?>
          </div>
          <div style="flex:1" class="align_center" class="valign_middle">
            <img src="<?=$chemin?>img/icones/avertissement.svg" alt="!" height="50">
          </div>
        </div>
        <br>
        <br>

        <?php } ?>

        <p class="alinea gros texte_noir souligne">
          <?=$definition_titre?><?=$trad['dico_colon']?>
        </p>

        <br>

        <div class="align_justify">
          <?=$definition_contenu?>
        </div>

        <br>
        <br>

        <p class="align_center">

          <span class="moinsgros gras">
            <a href="<?=$chemin?>pages/nbdb/web_dictionnaire?random">
              <?=$trad['dico_autre']?>
            </a>
          </span>

          <?php if($definition_bilingue) { ?>

          <br>
          <span class="pluspetit">
            <a href="<?=$chemin?>pages/nbdb/web_dictionnaire?id=<?=$dico_id?>&amp;changelang">
            <?=$trad['dico_bilingue']?><br>
            <?=$trad['dico_bilingue2']?></a>
          </span>

          <?php } ?>

        </p>

      </div>

      <?php } ?>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }