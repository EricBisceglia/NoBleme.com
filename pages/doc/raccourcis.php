<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Doc';

// Identification
$page_nom = "Préfère les URLs plus courtes";
$page_url = "pages/doc/raccourcis";

// Lien court
$shorturl = "";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Liens courts" : "Short URLs";
$page_desc  = "Versions courtes des URLs de certaines pages de NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Liens courts";
  $trad['desc']           = "Certaines pages peuvent être accédées par des URLs plus courtes, permettant de faire des liens qui prennent moins de place vers ces pages. L'utilité que ça a ? Je sais pas, vous décidez. En attendant, vous trouverez une liste des liens courts présents sur NoBleme dans le tableau ci-dessous.";

  // Tableau
  $trad['rac_page']       = "PAGE";
  $trad['rac_raccourci']  = "RACCOURCI";
  $trad['rac_raccourcis'] = "Liens courts";
  $trad['rac_profil']     = "Profil d'un utilisateur";
  $trad['rac_activite']   = "Activité récente";
  $trad['rac_online']     = "Qui est en ligne";
  $trad['rac_encyclo']    = "Enyclopédie de la culture web";
  $trad['rac_encycloa']   = "Article de l'enyclopédie de la culture web";
  $trad['rac_encycloi']   = "Image de l'enyclopédie de la culture web";
  $trad['rac_dico']       = "Dictionnaire de la culture web";
  $trad['rac_dicoa']      = "Article du dictionnaire de la culture web";
  $trad['rac_forum']      = "Forum de discussion";
  $trad['rac_forum_id']   = "Discussion spécifique du forum";
  $trad['rac_irl']        = "Rencontres IRL";
  $trad['rac_irl_id']     = "IRL spécifique";
  $trad['rac_irc']        = "Serveur IRC";
  $trad['rac_misc']       = "Miscellanée spécifique";
  $trad['rac_ecrivains']  = "Coin des écrivains";
  $trad['rac_ecrtexte']   = "Texte spécifique du coin des écrivains";
  $trad['rac_ecrcon']     = "Concours spécifique du coin des écrivains";
  $trad['rac_todo']       = "Tâche spécifique";
  $trad['rac_devblog']    = "Devblog spécifique";
  $trad['rac_coc']        = "Code de conduite";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "Short links";
  $trad['desc']           = "Some pages can be accessed through shorter URLs, allowing links to them to take less space. What practical use does it have? Hell if I know, you decide. Regardless, you will find below a list of all short links.";

  // Tableau
  $trad['rac_page']       = "PAGE";
  $trad['rac_raccourci']  = "SHORTCUT";
  $trad['rac_raccourcis'] = "Short links";
  $trad['rac_profil']     = "User profile";
  $trad['rac_activite']   = "Recent activity";
  $trad['rac_online']     = "Who's online";
  $trad['rac_encyclo']    = "Encyclopedia of internet culture";
  $trad['rac_encycloa']   = "Page of the encyclopedia of internet culture";
  $trad['rac_encycloi']   = "Image from the encyclopedia of internet culture";
  $trad['rac_dico']       = "Dictionary of internet culture";
  $trad['rac_dicoa']      = "Page of the dictionary of internet culture";
  $trad['rac_forum']      = "Discussion forum";
  $trad['rac_forum_id']   = "Specific forum thread";
  $trad['rac_irl']        = "Real life meetups";
  $trad['rac_irl_id']     = "Specific meetup";
  $trad['rac_irc']        = "IRC server";
  $trad['rac_coc']        = "Code of conduct";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <p><?=$trad['desc']?></p>

      </div>

      <br>
      <br>

      <div class="minitexte2">

        <table class="fullgrid titresnoirs">
          <thead>
            <tr>
              <th>
                <?=$trad['rac_page']?>
              </th>
              <th>
                <?=$trad['rac_raccourci']?>
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <tr>
              <td>
                <?=$trad['rac_raccourcis']?>
              </td>
              <td>
                <a href="<?=$chemin?>s">s</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_profil']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?u=1">u=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_activite']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?a">a</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_online']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?o">o</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_encyclo']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?w">w</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_encycloa']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?w=1">w=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_encycloi']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?wi=1">wi=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_dico']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?wd">o</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_dicoa']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?wd=1">wd=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_forum']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?f">f</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_forum_id']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?f=1">f=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_irl']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?irl">irl</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_irl_id']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?irl=49">irl=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_irc']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?irc">irc</a>
              </td>
            </tr>
            <?php if($lang == 'FR') { ?>
              <tr>
              <td>
                <?=$trad['rac_misc']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?m=210">m=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_ecrivains']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?e">e</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_ecrtexte']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?e=3">e=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_ecrcon']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?ec=2">ec=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_todo']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?t=358">t=?</a>
              </td>
            </tr>
            <tr>
              <td>
                <?=$trad['rac_devblog']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?d=20">d=?</a>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td>
                <?=$trad['rac_coc']?>
              </td>
              <td>
                <a href="<?=$chemin?>s?coc">coc</a>
              </td>
            </tr>
          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';