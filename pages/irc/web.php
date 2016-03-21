<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "IRC #NoBleme : Clients web";
$page_desc  = "Rejoindre le serveur de discussion IRC de NoBleme en un clic via un client web";

// Identification
$page_nom = "irc";
$page_id  = "web";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <a href="<?=$chemin?>pages/irc/">
        <img src="<?=$chemin?>img/logos/irc.png" alt="Logo">
      </a>
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">À savoir avant de rejoindre IRC</span><br>
      <br>
      Avant de venir discuter avec nous, je vous conseille assez fort de prendre le temps de lire la page sur les coutumes et traditions du serveur IRC de NoBleme en <a class="dark" href="<?=$chemin?>pages/irc/traditions">cliquant ici</a>. Ça vous évitera probablement beaucoup d'incompréhension.<br>
      <br>
      Peu importe le moment de la journée auquel vous débarquez sur IRC, il y aura quasi assurément du monde présent. S'il n'y a pas de conversation en cours, dites bonjour et attendez un peu, quelqu'un finira par vous répondre. Si vous venez juste en observateur et que vous ne voyez aucune conversation, ne soyez pas impatient. Nous avons régulièrement des longues périodes durant lesquelles nous n'avons rien à dire. Ce n'est pas une mauvaise chose, de bonnes conversations occasionelles valent mieux qu'un flot continu insipide.<br>
    </div>

    <br>

    <div class="body_main midsize">
      <span class="titre">Rejoindre le serveur IRC NoBleme en un clic</span><br>
      <br>
      Il existe de nombreux clients web qui permettent de rejoindre très facilement un serveur IRC. Parmi eux, je vous suggère Mibbit, qui est à mon avis le plus simple et efficace pour un débutant qui ne connait pas IRC.<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/irc/mibbit_1.png" alt="Mibbit">
      </div>
      <br>
      <hr>
      <br>
      Tout ce que vous avez à faire pour nous rejoindre est est, dans l'ordre :<br>
      - <a class="dark" href="https://client00.chat.mibbit.com/?url=irc%3A%2F%2Firc.nobleme.com%2FNoBleme&amp;charset=UTF-8">Cliquer sur ce lien qui fait tout le travail pour vous</a><br>
      - Entrer votre pseudonyme (dans le champ encadré de rouge dans l'image ci-dessous)<br>
      - Appuyer sur le bouton « Go » (encadré de bleu dans l'image ci-dessous)<br>
      - Attendre quelques secondes que Mibbit vous connecte<br>
      - Vous êtes maintenant sur le canal #NoBleme du serveur IRC NoBleme. C'était aussi simple que ça. Il ne vous reste plus qu'à discuter !<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/irc/mibbit_2.png" alt="Mibbit">
      </div>
      <br>
      <hr>
      <br>
      Comme vous n'êtes pas forcément familier avec IRC et Mibbit, je vous ai fait une capture d'écran explicative de ce que vous verrez :<br>
      - Au milieu, encadré de noir sur l'image, la zone où les conversations apparaitront<br>
      - En bas, encadré de rouge sur l'image, la zone de texte où vous écrivez vos messages<br>
      - À droite, encadré de violet sur l'image, la liste des utilisateurs actuellement connectés au canal de discussion<br>
      <br>
      Pour envoyer un message, il vous suffit de l'écrire dans la zone de texte encadrée de rouge sur l'image et d'appuyer sur la touche entrée de votre clavier. Tous les gens connectés au canal (en violet sur l'image) verront votre message.<br>
      <br>
      <div class="indiv align_center">
        <img class="midsizeimg" src="<?=$chemin?>img/irc/mibbit_3.png" alt="Mibbit">
      </div>
      <br>
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';