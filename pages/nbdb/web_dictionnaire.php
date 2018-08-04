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
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Introduction
  $trad['titre']        = "Dictionnaire de la culture web";
  $trad['soustitre']    = "Documentation de l'histoire des memes et des cultures d'internet";
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
  $trad['dico_autres']  = "Autres";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Introduction
  $trad['titre']        = "Internet culture dictionary";
  $trad['soustitre']    = "Documenting the history of memes and internet culture in general";
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
  $trad['dico_autres']  = "Others";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/nbdb/web_dictionnaire_add">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="30">
          </a>
          <?php } else { ?>
            <a href="<?=$chemin?>pages/doc/rss">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="M" height="30">
          </a>
          <?php } ?>
        </h1>

        <h5><?=$trad['soustitre']?></h5>

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

        <br>

        <h4>A</h4>

        <br>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=aardvark">Aardvark</a>
          </li>
        </ul>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=aardvark">Animal</a>
          </li>
        </ul>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=aardvark">Autant pour moi</a>
          </li>
        </ul>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=aardvark">Avant c'était mieux le web, non ?</a>
          </li>
        </ul>

        <br>

        <h4>B</h4>

        <br>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=aardvark">Continuer comme ça pour chaque lettre jusqu'à Z</a>
          </li>
        </ul>

        <br>

        <h4><?=$trad['dico_autres']?></h4>

        <br>

        <ul>
          <li>
            <a class="gras" href="<?=$chemin?>pages/nbdb/web_dictionnaire?define=aardvark">Tout ce qui n'est pas A-Z va ici</a>
          </li>
        </ul>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }