<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Jouer';
$header_sidemenu  = 'NBRPG';

// Titre et description
$page_titre = "NoBlemeRPG";
$page_desc  = "Le NoBlemeRPG est un jeu de rôle assez spécial propre à NoBleme.com";

// Identification
$page_nom = "nbrpg";
$page_id  = "index";



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/nbrpg_full.png" alt="NBRPG">
    </div>

    <div class="body_main midsize">
      <p class="titre">Qu'est-ce que le NoBlemeRPG ?</p>
      <br>
      Le NBRPG ou NoBlemeRPG est un <a href="https://fr.wikipedia.org/wiki/Jeu_de_r%C3%B4le_sur_table">jeu de rôle</a> existant au sein de NoBleme depuis 2005. Dans la lignée des jeux de rôle classiques, il se joue en petit comité (idéalement 4 à 8 joueurs), et est animé par <a href="<?=$chemin?>pages/user/user.php?pseudo=Bad">Bad</a> dans le rôle du <a href="https://fr.wikipedia.org/wiki/Ma%C3%AEtre_de_donjon">maître du donjon</a>.<br>
      <br>
      Contrairement à la tradition des jeux de rôle qui sont conçus pour jouer en personne, le NoBlemeRPG se joue par internet. Jusqu'en 2016, il était joué sur le <a href="<?=$chemin?>pages/irc/index">serveur IRC NoBleme</a>. Depuis 2017, il dispose de son propre client de jeu et se joue directement dans le navigateur.
    </div>
    <br>
    <div class="body_main midsize">
      <p class="titre">Qu'est-ce qui différencie le NoBlemeRPG des autres jeux de rôle ?</p>
      <br>
      La particularité du NoBlemeRPG est son esprit décalé : <a href="<?=$chemin?>pages/irc/quotes?id=134">tout y est possible</a>, et le plus improbable devient probable. Les joueurs sont placés dans des scénarios étranges, et disposent d'une liberté totale d'agir. Ils sont mêmes encouragés à abuser de l'absence de règles du jeu pour faire tout ce qui leur passe par la tête. Toutefois, le jeu étant lui-même libre de faire ce qu'il veut des joueurs, il est impossible de prévoir ce qui peut se passer dans une session de NBRPG. En tant que maître du donjon, Bad laisse une grande liberté créative à la programmation qui fait fonctionner le jeu, et laisse ainsi les aléas du hasard guider ou bloquer le groupe dans ses aventures.<br>
      <br>
      Depuis 2005, le fonctionnement imprévisible du NoBlemeRPG, la rareté des sessions de jeu (5-10 par an les bonnes années, 0 les mauvaises), et l'évolution continue du jeu à travers les années fait que les NoBlemeux continuent à en redemander, au grand dam de Bad qui n'a pas que ça à faire de son temps libre.
    </div>
    <br>
    <div class="body_main midsize">
      <p class="titre">Quel est l'univers du NoBlemeRPG ?</p>
      <br>
      Le NoBlemeRPG n'a pas un seul univers. Il est composé d'un grand nombre de dimensions, ayant chacune leur particularité et leur propre univers. Les divers groupes d'aventuriers incarnés par les joueurs se baladent entre ses dimensions, mandatés pour accomplir des missions plus ou moins utiles par une entité : L'Oracle. Omniscient et omnipotent, l'Oracle est un peu la divinité du NoBlemeRPG. Il a toutefois un point faible, sa flemmardise, qui le pousse à envoyer des aventuriers s'occuper de ses problèmes plutôt que d'utiliser sa toute puissance pour les résoudre lui-même. Généreux, l'Oracle permet aux aventuriers de communiquer avec lui, mais répond comme bon lui semble aux demandes des aventuriers, et a une tendance à s'amuser de leur mettre des embûches dans les pattes.<br>
      <br>
      Au fil des aventures des joueurs, ils ont découvert des lieux étranges et des créatures improbables, vaincu des ennemis par la ruse ou par la force, et se sont fait annihiler un assez grand nombre de fois, parfois victimes de leur propre stupidité. Certaines de leurs aventures les ont amenés à découvrir des créatures aussi puissantes que l'Oracle, tel que l'immortel Choc Maurice, la redoutable caisse de paquerettes slovène, ou la sombre contrepartie de l'oracle : l'Ombre, qui tentait d'étendre son pouvoir sur l'univers du jeu afin de le détruire.<br>
      <br>
      Pour découvrir plus en détail l'univers du NoBlemeRPG, aventurez-vous donc dans <a href="<?=$chemin?>pages/nbrpg/caverne">la caverne de Liodain</a>, ancien aventurier reconverti en scribe. Son talent unique pour le camouflage combiné avec sa légendaire couardise lui permettent d'observer de loin le progrès des divers groupes d'aventuriers, et de documenter pour la postérité tout ce qu'il voit. Vous pouvez également aller lire l'<a href="<?=$chemin?>pages/nbrpg/archive?>">archive des sessions</a> de jeu passées, si vous désirez voir à quoi ressemblent les parties de NoBlemeRPG.
    </div>
    <br>
    <div class="body_main midsize">
      <p class="titre">Comment puis-je participer au NoBlemeRPG ?</p>
      <br>
      Malheureusement, ma réponse immédiate est négative : ce n'est probablement pas possible pour vous d'y participer. Vu qu'une session de jeu est idéalement jouée avec 4 à 8 joueurs, il est nécessaire de faire une sélection plutôt que de jouer avec n'importe qui. Le NoBlemeRPG est donc réservé en priorité aux NoBlemeux qui fréquentent la communauté assez régulièrement depuis assez longtemps. Vous tenez vraiment très fort à y jouer quand même ? Pas de problème, venez vous intégrer dans la communauté NoBlemeuse, nous sommes très ouverts aux nouveaux membres et rapides à les intégrer parmi nous. Les sessions de jeu sont annoncées sur le <a href="<?=$chemin?>pages/irc/index">serveur IRC NoBleme</a>, c'est donc là qu'il faut être présent si vous désirez participer un jour au NoBlemeRPG.
    </div>
    <br>
    <div class="body_main midsize">
      <p class="titre">Le texte autour du logo, c'est des blagues privées à la con ?</p>
      <br>
      Oui. Vu la rareté des sessions de jeu du NoBlemeRPG, Bad se fait harrasser en continu pour savoir quand la prochaine aura lieu. Pour calmer les ardeurs des foules armées de fourches, il a tendance à répondre que ça reprend demain. Toutefois, ça ne reprend jamais demain. Pour ce qui est du visage triste accompagné du texte « échec critique », c'est un clin d'œil à la tendance qu'a le hasard du jeu à se retourner contre les joueurs aux pires moments possibles.<br>
      <br>
      Et un grand merci à <a href="https://twitter.com/chance_meeting">pins</a> qui a dessiné les logos du NBRPG sans que je lui demande rien, comme ça, juste parce qu'il en avait envie.<br>
      Allez regarder <a href="https://www.patreon.com/pins">son patreon</a> si vous voulez savoir ce qu'il fait d'autre.
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';