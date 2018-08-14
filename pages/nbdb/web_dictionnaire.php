<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'NBDBDicoWeb';

// Identification
$page_nom = "Apprend à comprendre internet";
$page_url = "pages/nbdb/web_dictionnaire";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = "NBDB : Culture internet";
$page_desc  = "Dictionnaire des termes propres à la culture internet.";

// JS
$js = array('dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération de l'id (ou de l'absence d'id) de la page

// On récupère le titre ou l'id s'il y en a un de spécifié
$dico_titre = (isset($_GET['define']))  ? postdata($_GET['define'], 'string')                                       : '';
$dico_id    = (isset($_GET['id']))      ? verifier_existence('nbdb_web_definition', predata(($_GET['id']), 'int'))  : 0;

// Si c'est une définition aléatoire, on va choper un ID au pif
if(isset($_GET['random']))
{
  // Selon la langue, on fait une requête différente
  $dico_lang    = 'titre_'.changer_casse($lang, 'min');
  $ddicorandom  = mysqli_fetch_array(query("  SELECT    nbdb_web_definition.id AS 'd_id'
                                              FROM      nbdb_web_definition
                                              WHERE     nbdb_web_definition.$dico_lang NOT LIKE ''
                                              ORDER BY  RAND()
                                              LIMIT     1 "));
  $dico_id      = $ddicorandom['d_id'];
}

// On va chercher si l'entrée existe
if($dico_titre && !$dico_id)
{
  // Selon la langue, on fait une requête différente
  $dico_lang  = 'titre_'.changer_casse($lang, 'min');
  $check_dico = mysqli_fetch_array(query("  SELECT  nbdb_web_definition.id AS 'd_id'
                                            FROM    nbdb_web_definition
                                            WHERE   nbdb_web_definition.$dico_lang  LIKE '$dico_titre' "));

  // Si la page existe, on récupère son id
  $dico_id = ($check_dico['d_id']) ? $check_dico['d_id'] : 0;
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
  $definition_lang = changer_casse($lang, 'min');

  // On va chercher la définition
  $ddefinition = mysqli_fetch_array(query(" SELECT  nbdb_web_definition.titre_".$definition_lang."      AS  'd_titre'  ,
                                                    nbdb_web_definition.definition_".$definition_lang." AS  'd_contenu'
                                            FROM    nbdb_web_definition
                                            WHERE   nbdb_web_definition.id = '$dico_id' "));

  // Puis on prépare le contenu de la définition pour l'affichage
  $definition_titre   = predata($ddefinition['d_titre']);
  $definition_contenu = bbcode(predata($ddefinition['d_contenu'], 1));

  // Et on oublie pas de modifier les infos de la page
  $page_nom = 'Apprend le sens de '.predata(tronquer_chaine($ddefinition['d_titre'], 20, '...'));
  $page_url = "pages/nbdb/web_dictionnaire";
  $page_titre = "NBDB : ".predata($ddefinition['d_titre']);
  $page_desc  = "Dictionnaire des termes propres à la culture internet.";
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des définitions

// On en a besoin que si on est pas sur une définition spécifique
if(!$dico_id)
{
  // On spécifique la langue à utiliser
  $definition_lang = 'titre_'.changer_casse($lang, 'min');

  // On va chercher la liste des définitions pour notre langue
  $qdefinition = query("  SELECT    nbdb_web_definition.$definition_lang  AS 'd_titre'
                          FROM      nbdb_web_definition
                          WHERE     nbdb_web_definition.$definition_lang  NOT LIKE ''
                          ORDER BY  nbdb_web_definition.$definition_lang  ASC ");

  // Préparation pour l'affichage
  for($ndefinition = 0 ; $ddefinition = mysqli_fetch_array($qdefinition) ; $ndefinition++)
  {
    $temp_lettre                        = substr(remplacer_accents(changer_casse($ddefinition['d_titre'], 'maj')), 0, 1);
    $temp_specialchars                  = ($lang == 'FR') ? 'Divers' : 'Various';
    $definition_lettre[$ndefinition]    = (ctype_alpha($temp_lettre)) ? $temp_lettre : $temp_specialchars;
    $definition_titre[$ndefinition]     = predata($ddefinition['d_titre']);
    $definition_titre_url[$ndefinition] = urlencode($ddefinition['d_titre']);
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
  $trad['titre']        = "Dictionnaire de la culture web";
  $trad['soustitre']    = "Documentation de l'histoire des memes et de la culture d'internet";
  $trad['desc']         = <<<EOD
Ce dictionnaire sert à accompagner <a class="gras" href="{$chemin}pages/nbdb/web">l'encyclopédie de la culture internet</a>, vous offrant des définitions pour comprendre les termes récurrents sans avoir à les redéfinir à chaque fois.
EOD;
  $trad['desc2']        = <<<EOD
Il sert également à définir divers termes amusants et/ou intéressants, et à toucher à des sujets sociaux importants à comprendre pour appréhender les subtilités de la culture internet, qui est souvent très politisée.
EOD;
  $trad['desc3']        = <<<EOD
Vous trouverez ci-dessous la liste alphabétique de toutes les définitions contenues dans ce dictionnaire, ainsi qu'un champ de texte vous permettant de chercher une définition spécifique si vous le désirez.
EOD;
  $trad['dico_search']  = "Chercher une définition dans le dictionnaire";

  // Liste des définitions
  $trad['dico_trandom'] = "Aléatoire";
  $trad['dico_random']  = "Cliquez ici pour être redirigé vers une définition aléatoire";

  // Définitions spécifiques
  $trad['dico_colon']   = " :";
  $trad['dico_autre']   = "Autre définition au hasard";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Introduction
  $trad['titre']        = "Internet culture dictionary";
  $trad['soustitre']    = "Documenting the history of memes and internet culture";
  $trad['desc']         = <<<EOD
This dictionary is meant to be used along with the <a class="gras" href="{$chemin}pages/nbdb/web">encyclopedia of internet culture</a>, helping you understand recurring terms in order to avoid having to redefine them every time they are mentioned.
EOD;
  $trad['desc2']        = <<<EOD
It is also used to define various funny and/or interesting terms, and to explain various social topics necessary to properly understand internet culture, which sometimes tends to have a political dimension.
EOD;
  $trad['desc3']        = <<<EOD
Below, you will find an alphabetical list of all the definitions in this dictionary, aswell as a text field that you can use to search for a specific definition if you so desire.
EOD;
  $trad['dico_search']  = "Search the dictionary";

  // Liste des définitions
  $trad['dico_trandom'] = "Random";
  $trad['dico_random']  = "Click here to be redirected towards a random definition";

  // Définitions spécifiques
  $trad['dico_colon']   = ":";
  $trad['dico_autre']   = "Other random definition";
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
            <input id="web_dico_search" name="web_dico_search" class="indiv" type="text">
          </fieldset>
        </form>

        <br>
        <br>

        <h4><?=$trad['dico_trandom']?></h4>

        <br>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?random"><?=$trad['dico_random']?></a>
          </li>
        </ul>

        <?php for($i=0;$i<$ndefinition;$i++) { ?>

        <?php if($i == 0 || $definition_lettre[$i] != $definition_lettre[$i-1]) { ?>

        <br>
        <h4><?=$definition_lettre[$i]?></h4>
        <br>

        <?php } ?>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=<?=$definition_titre_url[$i]?>"><?=$definition_titre[$i]?></a>
          </li>
        </ul>

        <?php } ?>

      </div>




      <?php ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Page spécifique du dictionnaire du web
      } else { ?>

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

        <p class="alinea gros texte_noir souligne">
          <?=$definition_titre?><?=$trad['dico_colon']?>
        </p>

        <p>
          <?=$definition_contenu?>
        </p>

        <?php if(isset($_GET['random'])) { ?>

        <br>

        <p class="align_center moinsgros gras">
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire?random">
            <?=$trad['dico_autre']?>
          </a>
        </p>

        <?php } ?>

      </div>

      <?php } ?>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }