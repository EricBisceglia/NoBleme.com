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

// Langages disponibles
$langage_page = array('FR','EN');

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