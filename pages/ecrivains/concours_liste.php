<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsConcours';

// Identification
$page_nom = "Voudrait participer à un concours";
$page_url = "pages/ecrivains/concours_liste";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Concours du coin des écrivains";
$page_desc  = "Le célèbre concours d'écriture du coin des écrivains de NoBleme.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher la liste des concours
$qconcours  = query(" SELECT    ecrivains_concours.id                         AS 'c_id'     ,
                                ecrivains_concours.timestamp_debut            AS 'c_debut'  ,
                                ecrivains_concours.timestamp_fin              AS 'c_fin'    ,
                                ecrivains_concours.num_participants           AS 'c_num'    ,
                                ecrivains_concours.titre                      AS 'c_titre'  ,
                                ecrivains_concours.FKecrivains_texte_gagnant  AS 'c_fini'   ,
                                membres.id                                    AS 'm_id'     ,
                                membres.pseudonyme                            AS 'm_pseudo'
                      FROM      ecrivains_concours
                      LEFT JOIN membres         ON ecrivains_concours.FKmembres_gagnant         = membres.id
                      ORDER BY  ecrivains_concours.timestamp_debut  DESC  ,
                                ecrivains_concours.titre            DESC  ");

// Puis on les prépare pour l'affichage
for($nconcours = 0; $dconcours = mysqli_fetch_array($qconcours); $nconcours++)
{
  $concours_css[$nconcours]           = ($dconcours['c_fini']) ? 'texte_noir gras' : 'edited texte_noir';
  $concours_id[$nconcours]            = $dconcours['c_id'];
  $concours_titre[$nconcours]         = predata(tronquer_chaine($dconcours['c_titre'], 50, '...'));
  $concours_debut[$nconcours]         = predata(jourfr($dconcours['c_debut']));
  $concours_fin[$nconcours]           = predata(jourfr($dconcours['c_fin']));
  $concours_participants[$nconcours]  = $dconcours['c_num'];
  $temp_jours_restants                = ceil(($dconcours['c_fin'] - time()) / (60 * 60 * 24));
  $temp_jours_restants                = ($temp_jours_restants == 1) ? $temp_jours_restants.' jour restant' : $temp_jours_restants.' jours restants';
  $temp_gagnant                       = ($dconcours['c_fin'] > time()) ? $temp_jours_restants : 'Vote en cours';
  $concours_fini[$nconcours]          = ($dconcours['c_fini']) ? 1 : 0;
  $concours_gagnant[$nconcours]       = ($dconcours['m_id']) ? predata($dconcours['m_pseudo']) : $temp_gagnant;
  $concours_gagnant_id[$nconcours]    = $dconcours['m_id'];
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          Concours du coin des écrivains
          <?php if($est_admin) { ?>
          <a href="<?=$chemin?>pages/ecrivains/concours_modifier">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="M">
          </a>
          <?php } ?>
        </h1>

        <h5>Il parait que c'est en écrivant mieux qu'on apprend à mieux écrire</h5>

        <p>
          <a class="gras" href="<?=$chemin?>pages/doc/nobleme">Entre 2006 et 2009</a>, une série de concours d'écriture étaient organisés sur l'ancien <a class="gras" href="<?=$chemin?>pages/forum/index">forum NoBleme</a>, dans le but de pousser les NoBlemeux à s'entrainer à écrire. En effet, la meilleure façon d'apprendre à mieux écrire, ça reste encore d'écrire. Et pour ça, il faut se motiver, ce qui n'est pas facile pour tout le monde.
        </p>

        <p>
          Les concours du <a class="gras" href="<?=$chemin?>pages/ecrivains/index">coin des écrivains de NoBleme</a> sont des concours de nouvelles entre amateurs, où chacun a un temps limité pour écrire un texte sur un sujet spécifique (différent à chaque concours), puis un vote décide de qui a écrit le meilleur texte. Pour éviter le favoritisme ou la triche, les textes sont anonymisés jusqu'à la fin du vote, et seuls les membres de <a class="gras" href="<?=$chemin?>pages/nobleme/admins">l'équipe administrative</a> et ceux qui ont déjà participé à un concours du coin des écrivains peuvent participer aux votes. Il n'y a pas de récompense particulière pour les gagnants, à part la satisfaction personnelle d'avoir écrit un texte qui a plu à ses lecteurs.
        </p>

        <p>
          Vous trouverez ci-dessous la liste des concours qui ont eu lieu depuis le retour du coin des écrivains, en 2018. Si un concours n'a pas encore de gagnant, c'est qu'il est ouvert et que vous pouvez y participer jusqu'à la date de fin, ou que le vote est en cours. Cliquez sur un concours pour en afficher les détails.
        </p>

      </div>

      <br>
      <br>

      <div class="texte3">

        <table class="grid titresnoirs altc nowrap">
          <thead>
            <tr>
              <th>
                CONCOURS
              </th>
              <th>
                DÉBUT
              </th>
              <th>
                FIN
              </th>
              <th>
                TEXTES
              </th>
              <th>
                GAGNANT
              </th>
            </tr>
          </thead>
          <tbody class="align_center">

            <?php for($i=0;$i<$nconcours;$i++) { ?>

            <tr>
              <td class="align_center gras">
                <a href="<?=$chemin?>pages/ecrivains/concours?id=<?=$concours_id[$i]?>">
                  <?=$concours_titre[$i]?>
                </a>
              </td>
              <td>
                <?=$concours_debut[$i]?>
              </td>
              <td>
                <?=$concours_fin[$i]?>
              </td>
              <td>
                <?=$concours_participants[$i]?>
              </td>
              <td class="<?=$concours_css[$i]?>">
                <?php if($concours_fini[$i] && $concours_gagnant_id[$i]) { ?>
                <a href="<?=$chemin?>pages/user/user?id=<?=$concours_gagnant_id[$i]?>">
                <?=$concours_gagnant[$i]?>
                </a>
                <?php } else if($concours_fini[$i] && !$concours_gagnant_id[$i]) { ?>
                Anonyme
                <?php } else { ?>
                <?=$concours_gagnant[$i]?>
                <?php } ?>
              </td>
            </tr>

            <?php } ?>

          </tbody>
        </table>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';