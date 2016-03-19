<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "IRC #NoBleme";
$page_desc  = "Communication en temps réel entre NoBlemeux via IRC";

// Identification
$page_nom = "irc";
$page_id  = "index";




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
      <span class="titre">Qu'est-ce que IRC ? &nbsp; Pourquoi IRC plutôt qu'autre chose ?</span><br>
      <br>
      IRC signifie <a class="dark" href="https://fr.wikipedia.org/wiki/Internet_Relay_Chat">Internet Relay Chat</a> (discussion via un relai internet). Il s'agit du plus ancien système de communication de groupe en temps réel via internet, et reste encore aujourd'hui très utilisé. NoBleme possède son propre serveur IRC depuis 2005.<br>
      <br>
      L'avantage d'IRC par rapport à d'autres systèmes de discussion en temps réel est la liberté qui l'accompagne. N'importe qui peut déployer son serveur IRC personnel, et les utilisateurs sont libres de choisir le programme ou l'application web qu'ils veulent pour s'y connecter.<br>
      <br>
      Si on compare par exemple IRC à Skype, au lieu de devoir impérativement installer le programme officiel Skype et utiliser le serveur officiel de Microsoft, IRC nous permet d'avoir un système de discussion hébergé directement sur NoBleme et auquel vous pouvez accéder sans rien installer, ou installer un programme que vous choisissez parmi une longue liste selon ce qui vous convient le mieux.<br>
      <br>
      Le choix d'utiliser IRC est aussi influencé par le fait que vous pouvez rejoindre la conversation <a class="dark" href="<?=$chemin?>pages/irc/web">en juste un clic, sans rien installer</a>.<br>
      Peu importe le moment de la journée, il y a probablement quelqu'un de présent sur notre chat IRC, n'hésitez pas à venir discuter !<br>
    </div>

    <br>

    <div class="body_main midsize">
      <span class="titre">Comment venir discuter sur IRC ?</span><br>
      <br>
      Avant de venir discuter avec nous, je vous conseille assez fort de prendre le temps de lire la page sur les coutumes et traditions du serveur IRC de NoBleme en <a class="dark" href="<?=$chemin?>pages/irc/traditions">cliquant ici</a>. Ça vous évitera probablement beaucoup d'incompréhension.<br>
      <br>
      Pour ceux qui savent déjà se servir d'IRC, voici les informations requises pour rejoindre notre serveur :<br>
      <span class="gras">Serveur :</span> irc.nobleme.com &nbsp; <span class="gras">Port :</span> 6697 (SSL) ou 6667 &nbsp; <span class="gras">Hub :</span> #NoBleme &nbsp; <span class="gras">Encodage :</span> UTF-8<br>
      <br>
      Si vous n'êtes pas familier avec IRC, la façon la plus simple de nous rejoindre est d'utiliser un client web. Ça ne requiert aucune installation, il suffit de faire un clic et vous êtes dans la conversation. Pour en savoir plus, <a class="dark" href="<?=$chemin?>pages/irc/web">cliquez ici</a>.<br>
      <br>
      Si vous voulez une expérience plus personnalisable et qui ne dépend pas de votre navigateur web ou que vous voulez vous servir d'IRC sur votre smartphone, installez un client IRC. Pour en savoir plus, <a class="dark" href="<?=$chemin?>pages/irc/client">cliquez ici</a>.<br>
      <br>
      Si vous voulez une connexion permanente (même lorsque votre ordinateur/smartphone est éteint) afin de ne rien rater des conversations pendant quand vous êtes absent, ce que vous cherchez est un bouncer IRC. Pour en savoir plus, <a class="dark" href="<?=$chemin?>pages/irc/bouncer">cliquez ici</a>.<br>
    </div>

    <br>

    <div class="body_main midsize">
      <span class="titre">En savoir plus sur le serveur IRC de NoBleme</span><br>
      <br>
      Le serveur possède plusieurs canaux de discussion, chacun ayant son propre thème. Par défaut, vous arrivez sur ce que nous appelons le « hub » du serveur, le canal #NoBleme sur lequel se font les conversations générales qui n'ont pas de thème particulier. Peut-être que les conversations d'autres canaux de discussion du serveur vous intéresseraient, <a class="dark" href="<?=$chemin?>pages/irc/canaux">cliquez ici</a> pour consulter la liste des principaux canaux.<br>
      <br>
      Le serveur possède un set de services nommés NickServ et ChanServ. Le premier vous permet d'enregistrer votre pseudonyme afin que personne ne puisse prétendre être vous, et le second vous permet de créer et gérer vos propres canaux de discussion sur le serveur. <a class="dark" href="<?=$chemin?>pages/irc/services">Cliquez ici</a> pour en savoir plus sur les services du serveur.<br>
      <br>
      Nous possédons également un bot qui est présent sur quelques uns des canaux de discussion (dont le hub #NoBleme). Il utilise le pseudonyme Akundo et permet de faire des choses plus ou moins inutiles. <a class="dark" href="<?=$chemin?>pages/irc/akundo">Cliquez ici</a> pour voir ce que Akundo peut faire pour vous.<br>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';