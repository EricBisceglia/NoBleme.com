<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Travaux";
$page_desc  = "Page en cours de travaux, revenez plus tard !";

// Identification
$page_nom = "nobleme";
$page_id  = "travaux";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On récupère les quotes
$qquotes = query(" SELECT quotes.contenu FROM quotes WHERE quotes.valide_admin = 1 ORDER BY quotes.timestamp DESC , quotes.id DESC ");
for($nquotes = 0 ; $dquotes = mysqli_fetch_array($qquotes) ; $nquotes++)
  $quote_temp[$nquotes] = nl2br(stripslashes($dquotes['contenu']));



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/travaux.png" alt="Page en cours de travaux, revenez plus tard !">
    </div>
    <br>
    <br>
    <br>

    <div class="body_main midsize">
      <span class="titre">En attendant les travaux...</span><br>
      <br>
      Les miscellanées sont trop précieuses pour être complètement mises hors ligne pendant la durée des travaux.<br>
      Ma solution temporaire est de faire un dump complet des miscellanées sur cette page.<br>
      <br>
      Pour les non initiés, les miscellanées sont des paroles de NoBlemeux venant principalement du <a class="dark blank" href="<?=$chemin?>pages/irc/index">chat IRC</a>, qui sont conservées pour la postérité parce qu'elles sont amusantes et/ou stupides.<br>
      <br>
      Vous les trouverez toutes ci-dessous, sans aucun contexte et mal formatées. Mais au moins, elles sont toutes là.<br>
      <br>
      Si vous voulez proposer une nouvelle miscellanée avant la fin des travaux, faites-le en <a class="dark blank" href="<?=$chemin?>pages/user/pm?user=1">envoyant un message privé à Bad</a>.<br>
    </div>

    <br>

    <div class="body_main bigsize">
      <span class="titre">Miscellanées : Paroles de NoBlemeux</span><br>
      <?php for($i=0;$i<$nquotes;$i++) { ?>
      <br>
      <hr>
      <br>
      <span class="monospace"><?=$quote_temp[$i]?></span>
      <br>
      <?php } ?>

    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';