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
$page_nom = "Coin des écrivains";
$page_url = "pages/ecrivains/texte?id=";

// Langues disponibles
$langue_page = array('FR');

// Titre et description
$page_titre = "Coin des écrivains";
$page_desc  = "Coin des écrivains de NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Identification du texte et informations/contenu du texte

// Si on a pas d'id, on dégage
if(!isset($_GET['id']))
  erreur("Texte inexistant");

// On récupère l'id du sujet
$texte_id = postdata($_GET['id'], 'int', 0);

// On va chercher si le sujet existe, et on en profite pour récupérer des infos pour le header et sur l'apparence de sujet
$qveriftexte = mysqli_fetch_array(query(" SELECT    ecrivains_texte.titre               AS 't_titre'    ,
                                                    ecrivains_texte.contenu             AS 't_contenu'  ,
                                                    ecrivains_texte.timestamp_creation  AS 't_creation' ,
                                                    ecrivains_texte.niveau_feedback     AS 't_feedback' ,
                                                    membres.id                          AS 'm_id'       ,
                                                    membres.pseudonyme                  AS 'm_pseudo'
                                          FROM      ecrivains_texte
                                          LEFT JOIN membres ON ecrivains_texte.FKmembres = membres.id
                                          WHERE     ecrivains_texte.id = '$texte_id' "));

// S'il existe pas, on dégage
if($qveriftexte['t_titre'] === NULL)
  erreur("Texte inexistant");

// On prépare le contenu pour l'affichage
$texte_titre      = predata($qveriftexte['t_titre']);
$texte_contenu    = bbcode(predata($qveriftexte['t_contenu'], 1));
$texte_auteur_id  = $qveriftexte['m_id'];
$texte_auteur     = predata($qveriftexte['m_pseudo']);
$texte_creation   = predata(ilya($qveriftexte['t_creation']));
$texte_feedback   = $qveriftexte['t_feedback'];

// Et on met à jour les infos du header
$page_nom  .= ' : '.predata(tronquer_chaine($qveriftexte['t_titre'], 25, '...'));
$page_url  .= $texte_id;
$page_titre = predata($qveriftexte['t_titre']);
$page_desc .= ' : '.predata($qveriftexte['t_titre']);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Réactions au texte

// On va chercher la liste des réactions
$qreactions = query(" SELECT    ecrivains_note.timestamp  AS 'n_date'     ,
                                ecrivains_note.note       AS 'n_note'     ,
                                ecrivains_note.anonyme    AS 'n_anon'     ,
                                ecrivains_note.message    AS 'n_message'  ,
                                membres.id                AS 'm_id'       ,
                                membres.pseudonyme        AS 'm_pseudo'
                      FROM      ecrivains_note
                      LEFT JOIN membres ON ecrivains_note.FKmembres = membres.id
                      WHERE     ecrivains_note.FKecrivains_texte = '$texte_id'
                      ORDER BY  ecrivains_note.timestamp DESC ");




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h3>
          <?=$texte_titre?>
          <?php if(getsysop()) { ?>
          <a href="<?=$chemin?>pages/ecrivains/texte_modifier?id=<?=$texte_id?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/modifier.png" alt="M">
          </a>
          <a href="<?=$chemin?>pages/ecrivains/texte_supprimer?id=<?=$texte_id?>">
            <img class="valign_middle pointeur" src="<?=$chemin?>img/icones/supprimer.png" alt="X">
          </a>
          <?php } ?>
        </h3>

        <h6>Publié dans le <a href="<?=$chemin?>pages/ecrivains/index">coin des écrivains</a> de NoBleme par <a href="<?=$chemin?>pages/user/user?id=<?=$texte_auteur_id?>"><?=$texte_auteur?></a> <?=$texte_creation?></h6>

        <br>

        <p><?=$texte_contenu?></p>

      </div>

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>

      <hr class="separateur_contenu">

      <div class="texte">

        <?php if(!$texte_feedback) { ?>

        <p>L'auteur de ce texte a demandé spécifiquement à ne pas avoir de retours. Son texte est uniquement fait pour être lu, les réactions ne l'intéressent pas. Par conséquent, vous ne pouvez pas laisser de notes sur ce texte.</p>

        <br>
        <br>

        <?php } else if($texte_feedback == 1) { ?>

        <p>L'auteur de ce texte accepte les retours sur son texte, mais uniquement par messages privés. Vous ne pouvez pas laisser de notes sur ce texte, mais vous pouvez toutefois communiquer ce que vous en avez pensé en <a href="<?=$chemin?>pages/user/pm?user=<?=$texte_auteur_id?>">écrivant un message privé à <?=$texte_auteur?></a>.</p>

        <br>
        <br>

        <?php } else { ?>

        <br>
        <br>

        <h4>
          Réactions au texte
        </h4>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';