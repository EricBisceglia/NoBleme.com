<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsListe';

// Identification
$page_nom = "Découvre le coin des écrivains";
$page_url = "pages/ecrivains/index";

// Lien court
$shorturl = "e";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Le coin des écrivains";
$page_desc  = "Un lieu de partage public pour créations littéraires entre amateurs";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Titre




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1>Le coin des écrivains</h1>

        <h5>Partages littéraires publics entre auteurs amateurs</h5>

        <p>
          Certaines personnes aiment bien écrire pour le plaisir. D'autres prennent l'écriture au sérieux et cherchent à s'améliorer en s'entrainant. Et d'autres encore veulent se forcer à écrire pour diverses raisons. Pour tous les NoBlemeux qui veulent ou aiment écrire, le coin des écrivains est un lieu où ils peuvent partager leurs réalisations, où vous pouvez lire les créations des autres et publier les vôtres.
        </p>

        <p>
          Si vous désirez <a class="gras" href="<?=$chemin?>pages/ecrivains/publier">publier un texte</a>, le coin des écrivains est ouvert à tous. Si vous désirez vous entrainer à écrire sur des sujets imposés, NoBleme organise régulièrement des <a class="gras" href="<?=$chemin?>pages/ecrivains/concours">concours d'écriture</a> entre amateurs.
        </p>

        <p>
          Vous trouverez ci-dessous la liste des textes publiés sur NoBleme, par ordre antéchronologique. Vous pouvez cliquer sur le titre d'une colonne pour les trier (par exemple par auteur ou par note).
        </p>

      </div>

      <br>
      <br>

      <div class="texte3">

        <table class="titresnoirs">

          <thead>
            <tr class="pointeur">
              <th>
                TITRE DU TEXTE
              </th>
              <th>
                LONGUEUR
              </th>
              <th>
                AUTEUR
              </th>
              <th>
                PUBLIÉ
              </th>
              <th>
                NOTE
              </th>
            </tr>
          </thead>

          <?php } ?>

          <tbody class="align_center">
            <tr>
              <td>
                Les aventures du NoBlemeux qui publie un texte
              </td>
              <td>
                700
              </td>
              <td>
                <a class="gras">PseudonymeLong</a>
              </td>
              <td>
                Il y a 73 jours
              </td>
              <td>
                3.5/5
              </td>
            </tr>
          </tbody>

          <?php if(!getxhr()) { ?>

        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }