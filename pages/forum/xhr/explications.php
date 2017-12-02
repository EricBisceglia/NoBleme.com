<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On récupère le chemin et le nom de l'élément sur lequel ont veut des explications
$chemin_xhr   = postdata_vide('chemin', 'string', '');
$explications = postdata_vide('element', 'string', '');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Fil de discussion
  $trad['fil_titre']        = "Fil de discussion";
  $trad['fil_soustitre']    = "Idéal pour la majorité des conversations";
  $trad['fil_desc']         = <<<EOD
Sujet de discussion linéaire classique, dans lequel les messages se suivent dans l'ordre, chronologiquement, du plus ancien au plus récent. Permet d'avoir une conversation facile à suivre où aucun message ne passe inaperçu.
EOD;
  $trad['fil_sujet']        = "Titre de la discussion";
  $trad['fil_1_pseudo']     = "Un membre";
  $trad['fil_1_date']       = "Posté le 19/03/05 à 10:00";
  $trad['fil_1_contenu']    = "Message de l'auteur du sujet";
  $trad['fil_2_pseudo']     = "Un autre membre";
  $trad['fil_2_date']       = "Posté le 19/03/05 à 11:00";
  $trad['fil_2_contenu']    = "Réponse au message de l'auteur ";
  $trad['fil_3_pseudo']     = "Membre #3";
  $trad['fil_3_date']       = "Posté le 19/03/05 à 12:00";
  $trad['fil_3_contenu']    = "Réponse à la réponse, etc. ";

  // Fil de discussion anonyme
  $trad['anon_titre']       = "Fil de discussion anonyme";
  $trad['anon_soustitre']   = "Idéal pour les conversations anonymes (c'est dans le nom)";
  $trad['anon_desc']        = <<<EOD
Comme dans un fil de discussion, les messages se suivent dans l'ordre chronologique, du plus ancien au plus récent. Toutefois, les pseudonymes des auteurs sont masqués, permettant ainsi d'avoir une conversation anonyme où chacun peut parler sans être identifié.
EOD;
  $trad['anon_desc_2']      = <<<EOD
Afin de préserver l'anonymité de chacun, les messages postés dans des fils de discussion anonymes n'augmentent pas le compte de messages postés sur le forum qui se trouve dans le <a class="gras" href="{$chemin_xhr}pages/user/user">profil public</a> de chaque utilisateur.
EOD;
  $trad['anon_pseudo']      = "Anonyme";

  // Sujet standard
  $trad['stand_titre']      = "Sujet standard";
  $trad['stand_soustitre']  = "Pour la majorité des conversations";
  $trad['stand_desc']       = <<<EOD
Sélectionnez ceci si votre sujet ne nécessite aucune des autres options de classification possibles. Dans la majorité des cas, c'est cette option que vous voudrez choisir pour votre sujet de discussion.
EOD;

  // Sujet sérieux
  $trad['ser_titre']        = "Sujet sérieux";
  $trad['ser_soustitre']    = "Pour les sujets qui vous tiennent à cœur";
  $trad['ser_desc']         = <<<EOD
Vous désirez que votre sujet soit pris au sérieux, et indiquez que ce n'est pas le lieu pour faire des plaisanteries ou partir sur des messages hors sujet. Choisissez cette option par exemple si vous voulez parler de quelque chose qui vous tient à cœur sans que ça déraille, si vous avez besoin de conseils sur quelque chose de personnel et important, ou si tout simplement vous voulez que votre sujet reste dans la ligne de conversation que vous désirez.
EOD;
  $trad['ser_desc_admin']   = <<<EOD
L'équipe administrative modèrera ce sujet avec sévérité, tous les messages qui ne respectent pas le sujet seront supprimés sans avertissement.
EOD;

  // Débat d'opinion
  $trad['debat_titre']      = "Débat d'opinion";
  $trad['debat_soustitre']  = "Pour les conversations constructives";
  $trad['debat_desc']       = <<<EOD
Vous désirez débattre d'un sujet sans que la conversation déraille, dans un cadre où chacun respecte les opinions des autres et se retient de lancer des attaques personnelles. Choisissez cette option si vous désirez parler de politique, d'actualités, ou d'autre chose de potentiellement sensible en vous assurant que le sujet ne sera pas déraillé par des trolls.
EOD;
  $trad['debat_desc_2']     = <<<EOD
Notez toutefois que choisir cette option ne signifie pas que vous pouvez briser le <a class="gras" href="{$chemin_xhr}pages/doc/coc">code de conduite de NoBleme</a> : même dans le cadre d'une opinion argumentée et sourcée présentée dans un débat, nous n'accepterons pas les messages de nature raciste ou les autres formes de discrimination.
EOD;
  $trad['debat_desc_adm']   = <<<EOD
L'équipe administrative modèrera sérieusement ce sujet. Les messages hors sujet, les trolls, les provocations, et les attaques personnelles seront supprimés sans avertissement.
EOD;

  // Jeu de forum
  $trad['jeu_titre']        = "Jeu de forum";
  $trad['jeu_soustitre']    = "Pour les sujets qui ne sont pas des conversations";
  $trad['jeu_desc']         = <<<EOD
Le sujet que vous voulez ouvrir n'est pas fait pour être une discussion traditionnelle. Il s'agit soit d'un jeu utilisant le forum comme support, soit d'un sujet qui est fait pour être délibérément stupide et avoir beaucoup de réponses non constructives.
EOD;
  $trad['jeu_desc_2']       = <<<EOD
Les messages postés dans les sujets classifiés comme des jeux de forum n'augmentent pas le compte de messages postés sur le forum qui se trouve dans le <a class="gras" href="{$chemin_xhr}pages/user/user">profil public</a> de chaque utilisateur.
EOD;

  // Aucune catégorie
  $trad['aucune_titre']     = "Aucune catégorie";
  $trad['aucune_soustitre'] = "Pour les conversations génériques";
  $trad['aucune_desc']      = <<<EOD
Sélectionnez ceci si votre sujet ne correspond à aucune des options de catégorisation possibles. Dans la majorité des cas, c'est cette option que vous voudrez choisir pour votre sujet de discussion.
EOD;

  // Politique
  $trad['pol_titre']        = "Politique";
  $trad['pol_soustitre']    = "Pour les conversations politisées";
  $trad['pol_desc']         = <<<EOD
Si votre sujet parle de politique et/ou est lié à des actualités de nature politisées, cochez cette case afin que les utilisateurs qui le désirent puissent soit facilement trouver votre sujet pour y répondre, soit facilement filtrer votre sujet afin de ne pas le voir.
EOD;

  // Informatique
  $trad['info_titre']       = "Informatique";
  $trad['info_soustitre']   = "Pour parler développement, sysadmin, réseau, etc.";
  $trad['info_desc']        = <<<EOD
Afin de catégoriser les conversations liées à tous les champs de l'informatique (logiciels, développement, administration système, réseau, hardware, etc.), cochez cette case si votre sujet parle d'un sujet informatique quelconque. Cette catégorie n'est pas faite pour les jeux vidéo : si vous souhaitez parler de jeux vidéo sélectionnez l'option Aucune catégorie.
EOD;

  // Informatique
  $trad['nb_titre']         = "NoBleme.com";
  $trad['nb_soustitre']     = "Pour parler de NoBleme";
  $trad['nb_desc']          = <<<EOD
Cochez cette case si votre sujet parle du contenu du site NoBleme.com et/ou de la communauté NoBleme.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<?php if($explications == 'fil') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['fil_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['fil_soustitre']?></div>

<p><?=$trad['fil_desc']?></p>

<br>

<table class="forum_sujet_entete forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_entete">
      <td class="valign_middle align_center forum_sujet_entete_titre">
        <span class="gras forum_sujet_entete_titre"><?=$trad['fil_sujet']?></span>
        <img src="./../../img/icones/lang_<?=changer_casse($lang, 'min')?>_clear.png" alt="<?=$lang?>" class="valign_middle forum_sujet_entete_lang" height="15">
      </td>
    </tr>
  </tbody>
</table>

<table class="forum_sujet_message forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_message">
      <td class="align_center valign_top nowrap forum_sujet_message_gauche">
        <a class="gras pointeur"><?=$trad['fil_1_pseudo']?></a><br>
        <?=$trad['fil_1_date']?>
      </td>
      <td class="valign_top forum_sujet_message_contenu">
        <?=$trad['fil_1_contenu']?>
      </td>
    </tr>
  </tbody>
</table>
<table class="forum_sujet_message forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_message">
      <td class="align_center valign_top nowrap forum_sujet_message_gauche">
        <a class="gras pointeur"><?=$trad['fil_2_pseudo']?></a><br>
        <?=$trad['fil_2_date']?>
      </td>
      <td class="valign_top forum_sujet_message_contenu">
        <?=$trad['fil_2_contenu']?>
      </td>
    </tr>
  </tbody>
</table>
<table class="forum_sujet_message forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_message">
      <td class="align_center valign_top nowrap forum_sujet_message_gauche">
        <a class="gras pointeur"><?=$trad['fil_3_pseudo']?></a><br>
        <?=$trad['fil_3_date']?>
      </td>
      <td class="valign_top forum_sujet_message_contenu">
        <?=$trad['fil_3_contenu']?>
      </td>
    </tr>
  </tbody>
</table>




<?php } else if($explications == 'anonyme') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['anon_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['anon_soustitre']?></div>

<p><?=$trad['anon_desc']?></p>

<p class="italique"><?=$trad['anon_desc_2']?></p>

<br>

<table class="forum_sujet_entete forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_entete">
      <td class="valign_middle align_center forum_sujet_entete_titre">
        <span class="gras forum_sujet_entete_titre"><?=$trad['fil_sujet']?></span>
        <img src="./../../img/icones/lang_<?=changer_casse($lang, 'min')?>_clear.png" alt="<?=$lang?>" class="valign_middle forum_sujet_entete_lang" height="15">
      </td>
    </tr>
  </tbody>
</table>

<table class="forum_sujet_message forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_message">
      <td class="align_center valign_top nowrap forum_sujet_message_gauche">
        <span class="gras"><?=$trad['anon_pseudo']?></span><br>
        <?=$trad['fil_1_date']?>
      </td>
      <td class="valign_top forum_sujet_message_contenu">
        <?=$trad['fil_1_contenu']?>
      </td>
    </tr>
  </tbody>
</table>
<table class="forum_sujet_message forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_message">
      <td class="align_center valign_top nowrap forum_sujet_message_gauche">
        <span class="gras"><?=$trad['anon_pseudo']?></span><br>
        <?=$trad['fil_2_date']?>
      </td>
      <td class="valign_top forum_sujet_message_contenu">
        <?=$trad['fil_2_contenu']?>
      </td>
    </tr>
  </tbody>
</table>
<table class="forum_sujet_message forum_nouveau_sujet_petitexemple">
  <tbody>
    <tr class="forum_sujet_message">
      <td class="align_center valign_top nowrap forum_sujet_message_gauche">
        <span class="gras"><?=$trad['anon_pseudo']?></span><br>
        <?=$trad['fil_3_date']?>
      </td>
      <td class="valign_top forum_sujet_message_contenu">
        <?=$trad['fil_3_contenu']?>
      </td>
    </tr>
  </tbody>
</table>




<?php } else if($explications == 'standard') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['stand_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['stand_soustitre']?></div>

<p><?=$trad['stand_desc']?></p>





<?php } else if($explications == 'serieux') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['ser_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['ser_soustitre']?></div>

<p><?=$trad['ser_desc']?></p>

<p class="gras"><?=$trad['ser_desc_admin']?></p>




<?php } else if($explications == 'debat') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['debat_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['debat_soustitre']?></div>

<p><?=$trad['debat_desc']?></p>

<p><?=$trad['debat_desc_2']?></p>

<p class="gras"><?=$trad['debat_desc_adm']?></p>




<?php } else if($explications == 'jeu') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['jeu_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['jeu_soustitre']?></div>

<p><?=$trad['jeu_desc']?></p>

<p class="italique"><?=$trad['jeu_desc_2']?></p>




<?php } else if($explications == 'aucune') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['aucune_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['aucune_soustitre']?></div>

<p><?=$trad['aucune_desc']?></p>




<?php } else if($explications == 'politique') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['pol_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['pol_soustitre']?></div>

<p><?=$trad['pol_desc']?></p>




<?php } else if($explications == 'informatique') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['info_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['info_soustitre']?></div>

<p><?=$trad['info_desc']?></p>




<?php } else if($explications == 'nobleme') { ?>

<h5 class="indiv align_center texte_noir"><?=$trad['nb_titre']?></h5>

<div class="texte_positif gras indiv align_center"><?=$trad['nb_soustitre']?></div>

<p><?=$trad['nb_desc']?></p>

<?php } ?>