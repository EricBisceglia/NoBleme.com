<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Coutumes IRC";
$page_desc  = "Coutumes et traditions du serveur IRC de NoBleme";

// Identification
$page_nom = "irc";
$page_id  = "traditions";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/irc.png" alt="Logo">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Coutumes et traditions de l'IRC NoBlemeux</span><br>
      <br>
      Cette page sert de mini-documentation explicative de choses inhabituelles que vous pourriez trouver sur le <a class="dark blank" href="<?=$chemin?>pages/irc/index">chat IRC de NoBleme</a>.<br>
      <br>
      Comme toutes les communautés, NoBleme possède son lot de traditions locales et de « private jokes ». Pas de panique toutefois : nous sommes toujours gentils avec les nouveaux visiteurs, et nous sommes prêts à expliquer tout ce qui vous semblerait bizarre.<br>
    </div>

    <br>

    <div class="body_main midsize">
      <span class="soustitre">Qu'est-ce que « biper » quelqu'un ?</span><br>
      <br>
      Lorsque quelqu'un écrit votre pseudo sur IRC, la plupart des clients IRC réagissent en émettant un bip.<br>
      L'acte de "biper" quelqu'un est donc celui d'écrire son pseudo sur IRC afin d'attirer son attention.<br>
      <br>
      <hr>
      <br>
      <span class="soustitre">Pourquoi est-ce qu'on me bipe quand je me connecte à IRC ?</span><br>
      <br>
      C'est une façon de dire bonjour.<br>
      <br>
      Parfois, quelqu'un va être fatigué d'écrire une phrase de bienvenue à l'attention de chaque personne qui rejoint le canal de discussion, mais aura quand même envie de dire bonjour vite fait à ceux qui arrivent au cours de la journée.<br>
      Plutôt que de proprement saluer, il est plus rapide d'écrire la première lettre du pseudonyme, puis de faire tabulation et entrée.<br>
      <br>
      Ainsi, il peut arriver que vous débarquez et que au lieu de « Bonjour Bidule », des utilisateurs se contentent de vous écrire « Bidule: »<br>
      Ca peut sembler (à tort) froid et impersonnel vu de l'extérieur, mais depuis le temps c'est devenu une habitude NoBlemeuse.<br>
      <br>
      <hr>
      <br>
      <span class="soustitre">Pourquoi personne n'est actif aujourd'hui ?</span><br>
      <br>
      Une journée, c'est long. Beaucoup de NoBlemeux ont IRC ouvert en continu, même quand ils sont au travail, dehors, en train de dormir.<br>
      À force de toujours être sur IRC, on se retrouve souvent avec rien à dire. Et mieux vaut ne rien dire que de raconter des inepties, non ?<br>
      <br>
      C'est pourquoi la plupart du temps des NoBlemeux sont présents sur IRC mais aucune conversation n'a lieu dans les canaux de discussion.<br>
      N'hésitez pas à démarrer une conversation. Les NoBlemeux regardent régulièrement leur client IRC, et vous répondront s'ils sont présents.<br>
      Si personne ne vous répond immédiatement, soyez patient. Le temps que quelqu'un regarde son ordinateur et vous aurez une réponse.<br>
      <br>
      <hr>
      <br>
      <span class="soustitre">Pourquoi les conversations sont-elles réparties sur plusieurs canaux ?</span><br>
      <br>
      Certains membres de la communauté ont très envie de discuter de sujets spécifiques qui les passionnent.<br>
      D'autres par contre sont lourdés quand ils se retrouvent exposés à des conversations auxquelles ils ne comprennent rien.<br>
      <br>
      Afin de résoudre ce problème, nous avons déplacé ces conversations spécifiques vers des canaux (comme #dev, #diablo, ou #starcraft).<br>
      Pour tous les autres sujets de conversation, le canal de discussion principal (#NoBleme) est utilisé.<br>
      <br>
      Je vous invite à aller regarder dans la <a class="dark blank" href="<?=$chemin?>pages/irc/canaux">liste des canaux</a> les sujets que nous isolons hors du canal principal #NoBleme.<br>
      Si vous désirez discuter de ces sujets, soyez gentils avec ceux que ça lourde et rejoignez la conversation sur ces canaux spécifiques.<br>
      <br>
      <hr>
      <br>
      <span class="soustitre">Pourquoi me suis-je fait bannir du serveur ?</span><br>
      <br>
      Très peu de gens se font bannir du serveur IRC de NoBleme. Il faut vraiment pousser les limites très loin pour en arriver là.<br>
      Vous êtes donc parfaitement au courant de la raison pour laquelle vous êtes banni. Pas la peine de prétendre que ce n'est pas le cas.<br>
      <br>
      Si vous vous êtes vraiment fait bannir du serveur par erreur, <a class="dark blank" href="<?=$chemin?>pages/user/pm?user=1">envoyez un message privé à Bad</a> et on règlera le problème ensemble.
    </div>


<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';