<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php';   // Inclusions communes
include './../../inc/ecrivains.inc.php';  // Fonctions liées au coin des écrivains


// Menus du header
$header_menu      = 'Lire';
$header_sidemenu  = 'EcrivainsConcours';

// Identification
$page_nom = "Regarde le concours d'écriture ";
$page_url = "pages/ecrivains/concours?id=";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Concours du coin des écrivains";
$page_desc  = "Le célèbre concours d'écriture du coin des écrivains de NoBleme.";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ID du concours

// On vérifie si l'ID est bien spécifie, sinon on dégage
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
  exit(header("Location: ".$chemin."pages/ecrivains/concours_liste"));

// On vérifie que le concours existe, sinon on dégage
$id_concours = postdata($_GET['id'], 'int');
if(!verifier_existence('ecrivains_concours', $id_concours))
  exit(header("Location: ".$chemin."pages/ecrivains/concours_liste"));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Voter pour le concours

if(isset($_POST['concours_vote_go']) && ecrivains_concours_peut_voter())
{
  // Assainissement du postdata
  $concours_vote_1  = postdata_vide('concours_vote_1', 'int', 0);
  $concours_vote_2  = postdata_vide('concours_vote_2', 'int', 0);
  $concours_vote_3  = postdata_vide('concours_vote_3', 'int', 0);
  $concours_voteur  = postdata($_SESSION['user'], 'int', 0);

  // On s'assure qu'il n'y ait pas de vote en double
  if($concours_vote_1 == $concours_vote_3)
    $concours_vote_3 = 0;
  if($concours_vote_1 == $concours_vote_2)
    $concours_vote_2 = 0;
  if($concours_vote_2 == $concours_vote_3)
    $concours_vote_3 = 0;

  // On supprime les votes déjà existants du votant au cas où ils existeraient déjà
  query(" DELETE FROM ecrivains_concours_vote
          WHERE       ecrivains_concours_vote.FKecrivains_concours  = '$id_concours'
          AND         ecrivains_concours_vote.FKmembres             = '$concours_voteur' ");

  // Puis on soumet les votes
  if($concours_vote_1)
    query(" INSERT INTO ecrivains_concours_vote
            SET         ecrivains_concours_vote.FKecrivains_concours  = '$id_concours'      ,
                        ecrivains_concours_vote.FKecrivains_texte     = '$concours_vote_1'  ,
                        ecrivains_concours_vote.FKmembres             = '$concours_voteur'  ,
                        ecrivains_concours_vote.poids_vote            = 5                   ");
  if($concours_vote_2)
    query(" INSERT INTO ecrivains_concours_vote
            SET         ecrivains_concours_vote.FKecrivains_concours  = '$id_concours'      ,
                        ecrivains_concours_vote.FKecrivains_texte     = '$concours_vote_2'  ,
                        ecrivains_concours_vote.FKmembres             = '$concours_voteur'  ,
                        ecrivains_concours_vote.poids_vote            = 3                   ");
  if($concours_vote_3)
    query(" INSERT INTO ecrivains_concours_vote
            SET         ecrivains_concours_vote.FKecrivains_concours  = '$id_concours'      ,
                        ecrivains_concours_vote.FKecrivains_texte     = '$concours_vote_3'  ,
                        ecrivains_concours_vote.FKmembres             = '$concours_voteur'  ,
                        ecrivains_concours_vote.poids_vote            = 1                   ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détails du concours

// Au cas où, on recompte le nombre d'entrées dans le concours
ecrivains_concours_compter_textes($id_concours);

// On va chercher les infos sur le concours
$dconcours = mysqli_fetch_array(query(" SELECT    ecrivains_concours.timestamp_fin              AS 'c_fin'    ,
                                                  ecrivains_concours.titre                      AS 'c_titre'  ,
                                                  ecrivains_concours.sujet                      AS 'c_sujet'  ,
                                                  ecrivains_concours.FKecrivains_texte_gagnant  AS 'c_fini'   ,
                                                  membres.id                                    AS 'm_id'     ,
                                                  membres.pseudonyme                            AS 'm_pseudo' ,
                                                  automatisation.action_timestamp               AS 'a_fin'    ,
                                                  ecrivains_texte.titre                         AS 't_titre'
                                        FROM      ecrivains_concours
                                        LEFT JOIN membres         ON    ecrivains_concours.FKmembres_gagnant  = membres.id
                                        LEFT JOIN automatisation  ON    ecrivains_concours.id                 = automatisation.action_id
                                                                  AND   automatisation.action_type         LIKE 'ecrivains_concours_fin'
                                        LEFT JOIN ecrivains_texte ON    ecrivains_concours.FKecrivains_texte_gagnant = ecrivains_texte.id
                                        WHERE     ecrivains_concours.id = '$id_concours' "));

// On complète les infos de la page
$page_url .= $id_concours;

// Puis on prépare les infos pour l'affichage
$concours_fin           = predata(datefr($dconcours['c_fin']));
$concours_fini          = (time() > $dconcours['c_fin']);
$concours_titre         = predata($dconcours['c_titre']);
$concours_sujet         = predata(changer_casse($dconcours['c_sujet'], 'maj'));
$concours_sujet_taille  = strlen($concours_sujet);
$concours_gagnant_texte = $dconcours['c_fini'];
$concours_gagnant_titre = predata($dconcours['t_titre']);
$concours_gagnant_id    = $dconcours['m_id'];
$concours_gagnant       = ($dconcours['m_id']) ? predata($dconcours['m_pseudo']) : 'Anonyme';
$concours_fin_vote      = predata(datefr($dconcours['a_fin']).' à '.date('H:i', $dconcours['a_fin']));
$concours_peut_voter    = ecrivains_concours_peut_voter();
$concours_est_admin     = getadmin();

// Si nécessaire, o va chercher si le membre a déjà voté pour le concours
if($concours_peut_voter && $concours_fini && !$concours_gagnant_texte)
{
  // On récupère l'ID du membre
  $concours_voteur  = postdata($_SESSION['user'], 'int', 0);

  // On va chercher les textes pour lesquels le membre a déjà voté
  $qvotes = query(" SELECT    ecrivains_concours_vote.poids_vote  AS 'v_poids'  ,
                              ecrivains_texte.id                  AS 't_id'     ,
                              ecrivains_texte.titre               AS 't_titre'  ,
                              ecrivains_texte.anonyme             AS 't_anon'   ,
                              membres.pseudonyme                  AS 'm_pseudo'
                    FROM      ecrivains_concours_vote
                    LEFT JOIN ecrivains_texte ON ecrivains_concours_vote.FKecrivains_texte  = ecrivains_texte.id
                    LEFT JOIN membres         ON ecrivains_texte.FKmembres                  = membres.id
                    WHERE     ecrivains_concours_vote.FKecrivains_concours  = '$id_concours'
                    AND       ecrivains_concours_vote.FKmembres             = '$concours_voteur'
                    ORDER BY  ecrivains_concours_vote.poids_vote DESC ");

  // Par défaut, on suppose qu'il a pas voté
  $concours_a_vote = 0;

  // On prépare ces textes pour l'affichage
  $concours_a_vote = 0;
  for($nvotes = 0 ; $dvotes = mysqli_fetch_array($qvotes) ; $nvotes++)
  {
    $concours_a_vote        = ($dvotes['v_poids']) ? 1 : $concours_a_vote;
    $temp_poids             = ($dvotes['v_poids'] == 3) ? 'Second choix' : 'Troisième choix';
    $temp_poids             = ($dvotes['v_poids'] == 5) ? 'Premier choix' : $temp_poids;
    $vote_poids[$nvotes]    = (!$dvotes['v_poids']) ? 0 : $temp_poids;
    $vote_idtexte[$nvotes]  = $dvotes['t_id'];
    $vote_texte[$nvotes]    = predata($dvotes['t_titre']);
    $vote_auteur[$nvotes]   = (!$dvotes['t_anon']) ? '(par '.predata($dvotes['m_pseudo']).')' : '(Auteur anonyme)';
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des participants au concours

// On va chercher la liste des textes publiés pour le concours
$qtextes = query("  SELECT    ecrivains_texte.id                  AS 't_id'       ,
                              ecrivains_texte.anonyme             AS 't_anon'     ,
                              ecrivains_texte.timestamp_creation  AS 't_creation' ,
                              ecrivains_texte.titre               AS 't_titre'    ,
                              ecrivains_texte.longueur_texte      AS 't_longueur' ,
                              membres.id                          AS 'm_id'       ,
                              membres.pseudonyme                  AS 'm_pseudo'
                    FROM      ecrivains_texte
                    LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                    WHERE     ecrivains_texte.FKecrivains_concours = '$id_concours'
                    ORDER BY  ecrivains_texte.anonyme DESC  ,
                              membres.pseudonyme      ASC   ");

// Initialisation du menu déroulant pour les votes
$select_textes = '';

// Préparation des textes pour l'affichage
for($ntextes = 0; $dtextes = mysqli_fetch_array($qtextes); $ntextes++)
{
  $texte_id[$ntextes]       = $dtextes['t_id'];
  $texte_titre[$ntextes]    = predata($dtextes['t_titre']);
  $texte_longueur[$ntextes] = $dtextes['t_longueur'];
  $texte_idauteur[$ntextes] = $dtextes['m_id'];
  $texte_anonyme[$ntextes]  = ($dtextes['t_anon']) ? 1 : 0;
  $texte_auteur[$ntextes]   = predata($dtextes['m_pseudo']);
  $temp_auteur              = (!$dtextes['t_anon']) ? '[Texte de '.predata($dtextes['m_pseudo']).']' : '[Auteur anonyme]';

  // On ne complète le menu déroulant que si c'est le texte de quelqu'un d'autre
  if(loggedin() && $_SESSION['user'] != $dtextes['m_id'])
    $select_textes         .= '<option value="'.$dtextes['t_id'].'">'.predata($dtextes['t_titre']).' '.$temp_auteur.'</option>';

  // Calcul du score de chaque texte si nécessaire
  $id_texte = $dtextes['t_id'];
  $dscore   = mysqli_fetch_array(query("  SELECT  SUM(ecrivains_concours_vote.poids_vote) AS 'c_score'
                                          FROM    ecrivains_concours_vote
                                          WHERE   ecrivains_concours_vote.FKecrivains_concours  = '$id_concours'
                                          AND     ecrivains_concours_vote.FKecrivains_texte     = '$id_texte' "));
  $texte_score[$ntextes]  = $dscore['c_score'];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Détail des votes

// Si nécessaire, on veut aussi le détail des votes pour vérifier les potentielles collusions
if($concours_est_admin)
{
  // On va chercher les votes
  $qvotesd = query("  SELECT    ecrivains_concours_vote.poids_vote  AS 'c_poids'  ,
                                ecrivains_texte.id                  AS 't_id'     ,
                                ecrivains_texte.titre               AS 't_titre'  ,
                                ecrivains_texte.anonyme             AS 't_anon'   ,
                                membres.id                          AS 'm_id'     ,
                                membres.pseudonyme                  AS 'm_pseudo' ,
                                auteur.id                           AS 'a_id'     ,
                                auteur.pseudonyme                   AS 'a_pseudo'
                      FROM      ecrivains_concours_vote
                      LEFT JOIN ecrivains_texte   ON ecrivains_concours_vote.FKecrivains_texte  = ecrivains_texte.id
                      LEFT JOIN membres           ON ecrivains_concours_vote.FKmembres          = membres.id
                      LEFT JOIN membres AS auteur ON ecrivains_texte.FKmembres                  = auteur.id
                      WHERE     ecrivains_concours_vote.FKecrivains_concours = '$id_concours'
                      ORDER BY  membres.pseudonyme                 ASC  ,
                                ecrivains_concours_vote.poids_vote DESC ");

  // Puis on les prépare pour l'affichage
  for($nvotesd = 0; $dvotesd = mysqli_fetch_array($qvotesd); $nvotesd++)
  {
    $temp_choix               = ($dvotesd['c_poids'] == 5) ? '1er' : '2nd';
    $voted_choix[$nvotesd]    = ($dvotesd['c_poids'] == 1) ? '3ème' : $temp_choix;
    $temp_csschoix            = ($dvotesd['c_poids'] == 5) ? ' class="texte_noir gras"' : ' class="gras"';
    $voted_csschoix[$nvotesd] = ($dvotesd['c_poids'] == 1) ? '' : $temp_csschoix;
    $voted_idtexte[$nvotesd]  = $dvotesd['t_id'];
    $voted_texte[$nvotesd]    = predata($dvotesd['t_titre']);
    $voted_idmembre[$nvotesd] = $dvotesd['m_id'];
    $voted_membre[$nvotesd]   = predata($dvotesd['m_pseudo']);
    $voted_idauteur[$nvotesd] = $dvotesd['a_id'];
    $voted_auteur[$nvotesd]   = ($dvotesd['t_anon']) ? predata($dvotesd['a_pseudo']).' (Anonyme)' : predata($dvotesd['a_pseudo']);
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h3>
          <?=$concours_titre?>
          <?php if($concours_est_admin) { ?>
          <a href="<?=$chemin?>pages/ecrivains/concours_modifier?id=<?=$id_concours?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M">
          </a>
          <a href="<?=$chemin?>pages/ecrivains/concours_supprimer?id=<?=$id_concours?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X">
          </a>
          <?php } ?>
        </h3>

        <h5>Concours du coin des écrivains de NoBleme</h5>

        <p>
          NoBleme organise régulièrement des <a class="gras" href="<?=$chemin?>pages/ecrivains/concours_liste">concours d'écriture</a>, ceci est l'un d'entre eux.
        </p>




        <?php if(!$concours_fini) { ?>

        <p>
          Pour participer au concours, vous devez <a class="gras" href="<?=$chemin?>pages/ecrivains/publier">publier un texte</a> qui respecte le sujet du concours dans le coin des écrivains de NoBleme au plus tard le <span class="gras texte_noir"><?=$concours_fin?> à 22h</span> (heure de Paris, France). Lorsque vous <a class="gras" href="<?=$chemin?>pages/ecrivains/publier">publiez votre texte</a>, faites bien attention à sélectionner qu'il s'agit d'une participation à ce concours !
        </p>

        <p>
          À part l'obligation de respecter le sujet du concours, vous êtes entièrement libre de proposer n'importe quel type de texte, de n'importe quelle longueur, et pouvez même dévier du thème si vous le désirez. Le thème ne sert que de sujet général pour guider vos idées dans une nouvelle direction créative : à vous de l'interpréter comme vous le désirez. Ne laissez pas votre créativité se faire retenir par les menottes d'un thème trop rigide.
        </p>

      </div>

      <br>
      <br>
      <br>

      <div class="align_center">

        <h3 class="texte_noir souligne">Sujet du concours :</h3>

        <br>
        <br>

        <?php if($concours_sujet_taille < 90) { ?>
        <h3 class="texte_negatif"><?=$concours_sujet?></h3>
        <?php } else if($concours_sujet_taille < 150) { ?>
        <h4 class="texte_negatif"><?=$concours_sujet?></h4>
        <?php } else { ?>
        <h5 class="texte_negatif"><?=$concours_sujet?></h5>
        <?php } ?>

      </div>

      <br>
      <br>
      <br>

      <div class="texte">

        <p>
          Le contenu des textes publiés pour ce concours seront cachés jusqu'à la fin du vote décidant du gagnant du concours, ce qui est généralement 10 jours après la date de fin du concours. Seuls les membres de <a class="gras" href="<?=$chemin?>pages/nobleme/admins">l'équipe administrative</a> et ceux qui ont participé à au moins un concours du coin des écrivains dans le passé pourront voir les textes et participer au vote. Une fois le gagnant du concours annoncé, les textes seront dévoilés publiquement et accessibles à tous dans le coin des écrivains.
        </p>

        <p>
          Le vote se fait par un système de classement pondéré : Chaque juge choisit ses 3 textes préférés parmi les participants, donnant ainsi des notes pondérées à chaque texte. L'auteur du texte qui a la meilleure note est nommé gagnant du concours. En cas d'égalité de la note de plusieurs textes, le gagnant sera tiré au sort parmi les textes ayant le plus haut score (quelle injustice !).
        </p>

        <p>
          Si vous vous sentez une irrésistible poussée créative, vous êtes libre de publier plusieurs textes pour ce concours. Après tout, le but des concours du coin des écrivains de NoBleme est de s'entrainer à écrire !
        </p>

        <br>




        <?php } else if(!$concours_gagnant_texte) { ?>

        <p>
          Le thème de ce concours est : <span class="moinsgros gras texte_negatif"><?=$concours_sujet?></span>
        </p>

        <p>
          Ce concours d'écriture est fini, et un vote est en cours pour déterminer un texte dont l'auteur sera nommé gagnant du concours. Seuls les membres de <a class="gras" href="<?=$chemin?>pages/nobleme/admins">l'équipe administrative</a> et ceux qui ont participé à au moins un concours du coin des écrivains dans le passé peuvent voir les textes et participer au vote.
        </p>

        <p>
          Le vote sera ouvert jusqu'au <span class="gras texte_noir"><?=$concours_fin_vote?></span>, puis le gagnant sera annoncé et le contenu des textes sera publiquement révélé. Le vote se fait par un système de classement pondéré : Chaque juge choisit ses 3 textes préférés parmi les participants, donnant ainsi des notes pondérées à chaque texte. L'auteur du texte qui a la meilleure note est nommé gagnant du concours. En cas d'égalité de la note de plusieurs textes, le gagnant sera tiré au sort parmi les textes ayant le plus haut score (quelle injustice !).
        </p>

        <?php if($concours_peut_voter) { ?>

        <br>
        <br>

        <h4>Voter pour vos textes favoris</h4>

        <p>
          En tant que membre de l'équipe administrative et/ou participant à un concours précédent, vous êtes qualifié pour voter pour le gagnant de ce concours. Pour ce faire, sélectionnez vos trois textes favoris de ce concours (vous trouverez les textes du concours plus bas dans la page), puis appuyez sur le bouton « Voter ».
        </p>

        <p>
          Vos votes sont privés et ne seront pas visibles publiquement. Vous ne pouvez pas voter pour vos propres textes, et vous ne pouvez pas voter plusieurs fois pour le même texte. Si vous changez d'avis, vous pouver changer vos votes autant de fois que vous le désirez jusqu'à la fin du concours. Chacun est libre d'avoir ses propres critères pour ses votes, il n'y a pas de consigne spécifique à suivre. Évitez les collusions (échanges de votes entre amis), elles seront détectées et vous serez banni des concours futurs. En cas d'hésitation entre plusieurs textes, essayez de choisir celui qui respecte le mieux le sujet du concours.
        </p>

        <?php if($concours_a_vote) { ?>

        <p>
          Vous avez déjà participé au vote de ce concours, vous avez choisi les textes suivants :<br>

          <?php for($i=0;$i<$nvotes;$i++) { ?>

          <?php if($vote_poids[$i]) { ?>

          - <span class="gras souligne"><?=$vote_poids[$i]?></span> : <a href="<?=$chemin?>pages/ecrivains/texte?id=<?=$vote_idtexte[$i]?>"><?=$vote_texte[$i]?></a> <?=$vote_auteur[$i]?><br>

          <?php } ?>

          <?php } ?>

        </p>

        <?php } ?>

        <br>
        <br>

        <form method="POST">
          <fieldset>

            <label for="concours_vote_1">Votre texte favori</label>
            <select id="concours_vote_1" name="concours_vote_1" class="indiv">
              <option value="0" selected></option>
              <?=$select_textes?>
            </select><br>

            <br>

            <label for="concours_vote_2">Le second texte qui vous a le plus plu (optionnel)</label>
            <select id="concours_vote_2" name="concours_vote_2" class="indiv">
              <option value="0" selected></option>
              <?=$select_textes?>
            </select><br>

            <br>

            <label for="concours_vote_3">Le troisième texte qui vous a le plus plu (optionnel)</label>
            <select id="concours_vote_3" name="concours_vote_3" class="indiv">
              <option value="0" selected></option>
              <?=$select_textes?>
            </select><br>

            <br>
            <br>

            <?php if($concours_a_vote) { ?>
            <input value="CHANGER MON VOTE POUR CE CONCOURS" type="submit" name="concours_vote_go">
            <?php } else { ?>
            <input value="VALIDER MON VOTE POUR CE CONCOURS" type="submit" name="concours_vote_go">
            <?php } ?>

          </fieldset>
        </form>

        <?php } ?>




        <?php } else { ?>

        <p>
          Ce concours d'écriture est fini, et un texte gagnant a été élu suite aux votes d'un jury.<br>
          Le sujet de ce concours était : <span class="moinsgros gras texte_negatif"><?=$concours_sujet?></span>
        </p>

        <p>
          Le texte ayant gagné ce concours est : <a class="moinsgros gras" href="<?=$chemin?>pages/ecrivains/texte?id=<?=$concours_gagnant_texte?>"><?=$concours_gagnant_titre?></a><br>
          <?php if($concours_gagnant_id) { ?>
          Félicitations à l'auteur de ce texte et au gagnant de ce concours, <a class="moinsgros gras texte_positif" href="<?=$chemin?>pages/user/user?id=<?=$concours_gagnant_id?>"><?=$concours_gagnant?></a>
          <?php } else { ?>
          L'auteur de ce texte a choisi de rester <span class="gras texte_noir">anonyme</span>, félicitations tout de même à son auteur !
          <?php } ?>
        </p>

        <p>
          Vous pouvez retrouver ci-dessous la liste de tous les textes publiés pour ce concours, ainsi que la note attribuée à chaque texte par le jury (le score le plus haut détermine le gagnant, en cas d'égalité un des gagnants a été tiré au sort parmi les notes les plus hautes).
        </p>

        <?php } ?>

      </div>

      <?php if($ntextes) { ?>

      <br>
      <br>

      <hr class="separateur_contenu">

      <br>
      <br>

      <div class="texte nowrap">

        <h4 class="align_center">Textes publiés en participation au concours</h4>

        <br>
        <br>

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
              <?php if($concours_gagnant_texte || ($concours_est_admin && $concours_fini)) { ?>
              <th>
                SCORE
              </th>
              <?php } ?>
            </tr>
          </thead>

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
                <?php if($texte_anonyme[$i]) { ?>
                Anonyme
                <?php } else { ?>
                <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$texte_idauteur[$i]?>">
                  <?=$texte_auteur[$i]?>
                </a>
                <?php } ?>
              </td>
              <?php if($concours_gagnant_texte || ($concours_est_admin && $concours_fini)) { ?>
              <td class="texte_noir gras">
                <?=$texte_score[$i]?>
              </td>
              <?php } ?>
            </tr>

            <?php } ?>

          </tbody>

        </table>

      </div>

      <?php } ?>

      <?php if($concours_est_admin && $nvotesd) { ?>

      <br>
      <br>

      <hr class="separateur_contenu">

      <br>
      <br>

      <div class="texte3 nowrap">

        <h4 class="align_center">Détail des votes</h4>

        <br>
        <br>

        <table class="grid titresnoirs">

          <thead>
            <tr class="pointeur bas_noir">
              <th>
                MEMBRE
              </th>
              <th>
                CHOIX
              </th>
              <th>
                AUTEUR
              </th>
              <th>
                TEXTE
              </th>
            </tr>
          </thead>

          <tbody class="align_center">

            <?php for($i=0;$i<$nvotesd;$i++) { ?>

            <?php if($i < ($nvotesd - 1) && $voted_membre[$i] != $voted_membre[$i+1]) { ?>
            <tr class="bas_noir">
            <?php } else { ?>
            <tr>
            <?php } ?>
              <td>
                <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$voted_idmembre[$i]?>">
                  <?=$voted_membre[$i]?>
                </a>
              </td>
              <td<?=$voted_csschoix[$i]?>>
                <?=$voted_choix[$i]?>
              </td>
              <td>
                <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$voted_idauteur[$i]?>">
                  <?=$voted_auteur[$i]?>
                </a>
              </td>
              <td>
                <a class="gras" href="<?=$chemin?>pages/ecrivains/texte?id=<?=$voted_idtexte[$i]?>">
                  <?=$voted_texte[$i]?>
                </a>
              </td>
            </tr>

            <?php } ?>

          </tbody>

        </table>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';