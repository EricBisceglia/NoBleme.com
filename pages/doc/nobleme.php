<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Doc : NoBleme";
$page_desc  = "Documentation : Mais qu'est-ce que NoBleme ?";

// Identification
$page_nom = "doc";
$page_id  = "nobleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/doc/">
        <img src="<?=$chemin?>img/logos/documentation.png" alt="Documentation">
      </a>
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Qu'est-ce que NoBleme ?</span><br>
      <br>
      Il est malheureusement impossible de résumer NoBleme en une phrase.<br>
      <br>
      En gros, il s'agit d'une communauté internet francophone qui s'était à l'origine formée autour d'un projet cinématographique étudiant.<br>
      Le projet n'a jamais vu le jour, et NoBleme est à la place devenu le terrain d'expérimentation personnel de <a class="dark blank" href="<?=$chemin?>pages/user/user?id=1">Bad</a>.<br>
      <br>
      Passé par des phases d'activité intense et de quasi-mort depuis sa création en 2005, NoBleme a maturé en même temps que ses membres - à l'origine adolescents - sont devenus adultes. Aujourd'hui, le site est « généraliste », sans thème particulier.<br>
      <br>
      Vous verrez dans le menu de navigation situé en haut de chaque page qu'il y a plein de sections différentes au site. Aucune de ces sections n'est la « section centrale » du site, le tout est un ensemble étrange et unique qui s'assemble pour former NoBleme.<br>
      <br>
      <br>
      NoBleme se définit aussi par ce que certains appellent « l'esprit NoBlemeux » : Un humour un peu puéril, infantile, et parfois provocateur, derrière lequel se cachent des gens sérieux et adultes qui ont développé un lien d'amitié entre eux à force de se fréquenter.<br>
      Pas d'inquiétude toutefois, la communauté est accueillante avec la plupart des gens et intègre rapidement les nouveaux arrivants.<br>
      <br>
      <br>
      Pour mieux comprendre ce qu'est NoBleme aujourd'hui, il faut comprendre son passé. <s>Vous trouverez donc sur cette page un histoirique de NoBleme, racontant le passé du site, ainsi qu'une présentation de l'administrateur et développeur du site, <a class="dark blank" href="<?=$chemin?>pages/user/user?id=1">Bad</a>.</s><br>
      En fait non, le reste de cette page est en travaux pour le moment. Ça reviendra bientôt !
    </div>

    <br>
    <br>
    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/travaux.png" alt="Page en cours de travaux, revenez plus tard !">
    </div>
    <br>
    <br>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';