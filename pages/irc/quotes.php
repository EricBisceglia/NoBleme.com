<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Miscellanées";
$page_desc  = "Les miscellanées sont des phrases, des monologues, ou des conversations entre membres de NoBleme qui ont été conservées pour la postérité";

// Identification
$page_nom = "quotes";
$page_id  = "index";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Navigation entre les pages
if(!isset($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] <= 0)
  $misc_page = 1;
else
  $misc_page = postdata($_GET['page']);

// Pour éviter les overlaps de query strings
if(isset($_GET['random']) || isset($_GET['id']))
  $misc_page = 1;

// Si une citation spécifique est choisie
if(isset($_GET['id']) && is_numeric($_GET['id']))
  $idmisc = postdata($_GET['id']);
else
  $idmisc = 0;

// Si la citation spécifique existe pas on gtfo
if($idmisc && !mysqli_num_rows(query(" SELECT id FROM quotes WHERE id = '$idmisc' ")))
  erreur("Miscellannée non existante");

// Si on est pas admin on a pas le droit de voir les quotes non validées
if($idmisc && !getadmin() && !mysqli_num_rows(query(" SELECT id FROM quotes WHERE id = '$idmisc' AND valide_admin = 1")))
  erreur("Miscellanée non existante");


// Si une citation aléatoire est choisie
if(isset($_GET['random']))
{
  $qrandmisc  = mysqli_fetch_array(query(" SELECT id FROM quotes WHERE valide_admin = 1 ORDER BY RAND() LIMIT 1 "));
  $idmisc     = $qrandmisc['id'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Navigation entre les pages

// Nombre de citations à aller chercher dans la requête
$misc_page_debut  = (20*$misc_page)-20;
$misc_page_fin    = 20+$misc_page_debut;

// Pages précédente et suivante
$misc_page_prev   = $misc_page-1;
$misc_page_suiv   = $misc_page+1;

// On check si la page suivante existe
$misc_test_debut  = $misc_page_debut+20;
$misc_test_fin    = $misc_page_fin+20;
if(mysqli_num_rows(query(" SELECT quotes.id FROM quotes WHERE valide_admin = 1 LIMIT $misc_test_debut, $misc_test_fin ")))
  $misc_display_suiv = 1;
else
  $misc_display_suiv = 0;




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des citations

// On prépare la requête
$qmisc =    " SELECT    quotes.id           ,
                        quotes.timestamp    ,
                        quotes.contenu      ,
                        quotes.FKauteur     ,
                        membres.pseudonyme  ,
                        quotes.valide_admin
              FROM      quotes
              LEFT JOIN membres ON quotes.FKauteur = membres.id ";
if(!getadmin())
  $qmisc .= " WHERE     quotes.valide_admin = 1 ";
else if(isset($_GET['admin']))
  $qmisc .= " WHERE     quotes.valide_admin = 0 ";
else
  $qmisc .= " WHERE     1=1 ";
if($idmisc)
  $qmisc .= " AND       quotes.id = '$idmisc' ";
$qmisc .=   " ORDER BY  quotes.timestamp  DESC  ,
                        quotes.id         DESC
              LIMIT     $misc_page_debut , $misc_page_fin ";

// On balance la requête
$qmisc = query($qmisc);

// On prépare les citations pour l'affichage
for($nmisc = 0 ; $dmisc = mysqli_fetch_array($qmisc) ; $nmisc++)
{
  $misc_id[$nmisc]        = $dmisc['id'];
  $misc_date[$nmisc]      = ($dmisc['timestamp']) ? " du ".jourfr(date('Y-m-d',$dmisc['timestamp'])) : '';
  $misc_contenu[$nmisc]   = nl2br_fixed($dmisc['contenu']);
  $misc_auteur[$nmisc]    = $dmisc['pseudonyme'];
  $misc_auteurid[$nmisc]  = $dmisc['FKauteur'];
  $misc_valide[$nmisc]    = $dmisc['valide_admin'];
}

// Si c'est une citation spécifique, on change les infos de la page
if($idmisc)
{
  $page_id    = $idmisc;
  $page_titre = "Miscellanée #".$idmisc;
  $page_desc  = substr($misc_contenu[0],0,100).'...';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/irc/quotes">
        <img src="<?=$chemin?>img/logos/miscellanees.png" alt="Miscellanées">
      </a>
    </div>
    <br>

    <?php if(!isset($_GET['page']) && !isset($_GET['id']) && !isset($_GET['random'])) { ?>

    <div class="body_main midsize">
      <span class="titre">Paroles de NoBlemeux</span><br>
      <br>
      <span class="italique">Miscellanée : nom féminin, ordinairement au pluriel.<br>
      Bibliothèque hétéroclite, recueil de différents ouvrages qui n'ont quelquefois aucun rapport entre eux.</span><br>
      <br>
      Les miscellanées sont des phrases, des monologues, des conversations entre les NoBlemeux qui sont été conservés pour la posterité.<br>
      Elles sont toutes présentes sur cette page, par ordre antéchronologique (de la plus récente à la plus ancienne).<br>
      <br>
      L'intégralité de ces citations proviennent de NoBleme.<br>
      Presque toutes viennent du <a href="<?=$chemin?>pages/irc/">serveur IRC</a>, le reste sont tirées du <a href="<?=$chemin?>pages/forum/">forum</a> ou ont été dites pendant les <a href="<?=$chemin?>pages/nobleme/irls">rencontres IRL</a>.<br>
      <br>
      Si vous êtes diverti par du contenu qui a été écrit sur NoBleme, n'hésitez pas à proposer que ce contenu soit intégré aux miscellanées.<br>
      Pour proposer une nouvelle miscellanée, tout ce que vous avez à faire est <a href="<?=$chemin?>pages/irc/quote_add">cliquer ici</a> et remplir le formulaire.
    </div>

    <br>
    <br>

    <?php } ?>

    <div class="body_main bigsize">
      <?php if(isset($_GET['random'])) { ?>
      <div class="indiv align_center">
        <a class="dark blank gras moinsgros monospace" href="<?=$chemin?>pages/irc/quotes?random">Une autre miscellanée aléatoire !</a>
      </div>
      <hr class="points">
      <br>
      <?php } if($idmisc && getadmin()) { ?>
      <span class="gras souligne">Admin</span> : Citation soumise par <a href="<?=$chemin?>pages/user/user?id=<?=$misc_auteurid[0]?>"><?=$misc_auteur[0]?></a> :
      <?php if($misc_valide[0]) { ?>
      <a href="<?=$chemin?>pages/irc/quotes_admin?edit=<?=$idmisc?>">Modifier la citation</a> - <a href="<?=$chemin?>pages/irc/quotes_admin?delete=<?=$idmisc?>">Supprimer la citation</a>
      <?php } else { ?>
      <a href="<?=$chemin?>pages/irc/quotes_admin?edit=<?=$idmisc?>">Accepter la citation</a> - <a href="<?=$chemin?>pages/irc/quotes_admin?delete=<?=$idmisc?>">Refuser la citation</a>
      <?php } ?>
      <hr class="points">
      <?php } ?>
      <?php for($i=0;$i<$nmisc;$i++) { ?>
      <span class="monospace"><a class="dark blank gras" href="<?=$chemin?>pages/irc/quotes?id=<?=$misc_id[$i]?>">Miscellanée #<?=$misc_id[$i]?></a><?=$misc_date[$i]?></span><br>
      <br>
      <span class="monospace"><?=$misc_contenu[$i]?></span><br>
      <?php if(!isset($_GET['id']) && !isset($_GET['random'])) { ?>
      <br>
      <hr class="points">
      <br>
      <?php } } if(!isset($_GET['id']) && !isset($_GET['random'])) { ?>
      <div class="indiv align_center">
        <?php if($misc_page_prev > 0) { ?>
        <a class="dark blank gras moinsgros monospace" href="<?=$chemin?>pages/irc/quotes?page=<?=$misc_page_prev?>">Page précédente</a>
        <?php } if($misc_page_prev > 0 && $misc_display_suiv) { ?>
        -
        <?php } if($misc_display_suiv) { ?>
        <a class="dark blank gras moinsgros monospace" href="<?=$chemin?>pages/irc/quotes?page=<?=$misc_page_suiv?>">Page suivante</a>
        <?php } ?>
      </div>
      <?php } ?>
    </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';