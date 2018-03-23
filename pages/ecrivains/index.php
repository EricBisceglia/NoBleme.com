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
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des publications

// On va chercher les textes
$qtextes = "  SELECT    ecrivains_texte.id                  AS 't_id'       ,
                        ecrivains_texte.timestamp_creation  AS 't_date'     ,
                        ecrivains_texte.niveau_feedback     AS 't_feedback' ,
                        ecrivains_texte.titre               AS 't_titre'    ,
                        ecrivains_texte.note_moyenne        AS 't_note'     ,
                        ecrivains_texte.longueur_texte      AS 't_longueur' ,
                        membres.id                          AS 'm_id'       ,
                        membres.pseudonyme                  AS 'm_pseudo'
              FROM      ecrivains_texte
              LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
              ORDER BY  ecrivains_texte.timestamp_creation DESC ";

// Et on envoie la requête
$qtextes = query($qtextes);

// Puis on parcourt les résultats pour les préparer à l'affichage
for($ntextes = 0 ; $dtextes = mysqli_fetch_array($qtextes) ; $ntextes++)
{
  $texte_id[$ntextes]       = $dtextes['t_id'];
  $texte_titre[$ntextes]    = predata($dtextes['t_titre']);
  $texte_longueur[$ntextes] = $dtextes['t_longueur'];
  $texte_idauteur[$ntextes] = $dtextes['m_id'];
  $texte_auteur[$ntextes]   = predata($dtextes['m_pseudo']);
  $texte_publie[$ntextes]   = predata(ilya($dtextes['t_date']));
  $texte_note[$ntextes]     = ($dtextes['t_feedback'] < 2 || $dtextes['t_note'] < 0) ? '&nbsp;' : $dtextes['t_note'].' / 5';
}






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

            <?php for($i=0;$i<$ntextes;$i++) { ?>

            <tr>
              <td>
                <a class="gras" href="<?=$chemin?>pages/ecrivains/texte?id=<?=$texte_id[$i]?>">
                  <?=$texte_titre[$i]?>
                </a>
              </td>
              <td>
                <?=$texte_longueur[$i]?>
              </td>
              <td>
                <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$texte_idauteur[$i]?>">
                  <?=$texte_auteur[$i]?>
                </a>
              </td>
              <td>
                <?=$texte_publie[$i]?>
              </td>
              <td>
                <?=$texte_note[$i]?>
              </td>
            </tr>

            <?php } ?>

          </tbody>

          <?php if(!getxhr()) { ?>

        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }