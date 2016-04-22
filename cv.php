<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "CV de Bad";
$page_desc  = "Curriculum Vitae de Éric Bisceglia aka Bad, administrateur et développeur de NoBleme";

// Identification
$page_nom = "nobleme";
$page_id  = "cv";

// On force le popout
$_GET['popout'] = 1;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/******************************************************************************************************/ include './inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/cv.png" alt="Curricilum Vitæ">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="gros gras">Éric Bisceglia</span><br>
      <span class="moinsgros gras">Développeur</span><br>
      <br>
      Habite Paris, France<br>
      Né le 26 août 1988 (<?=floor((strtotime(date('Y-m-d'))-strtotime('1988-08-26'))/31556926)?> ans)<br>
      E-Mail : <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a><br>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Parcours professionel :</span><br>
      <br>
      <table>
        <tr>
          <td class="spaced">2016 - Aujourd'hui</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://www.mtd-finance.fr/">MTD Finance</a> : Développement intranet</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL - JavaScript</td>
        </tr>
        <tr>
          <td class="spaced">2014 - 2016</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Freelance</span> : Sous secret professionel</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">C - Python - PostgreSQL</td>
        </tr>
        <tr>
          <td class="spaced">2010 - 2014</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://www.mtd-finance.fr/">MTD Finance</a> : Développement intranet</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL - JavaScript</td>
        </tr>
        <tr>
          <td class="spaced">2009 - 2010</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://www.mecamatic.fr/">Mécamatic</a> : Développement logiciel interne</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">FileMaker - Perl - AppleScript</td>
        </tr>
        <tr>
          <td class="spaced">2007 - 2009</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Freelance</span> : Développement de jeux en Flash</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Flash - ActionScript</td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Projets personnels :</span><br>
      <br>
      <table>
        <tr>
          <td class="spaced">2011 - Aujourd'hui</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Life.base</span> : Utilitaire de gestion de la vie quotidienne</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - PgSQL</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?portfolio#lifebase">Portfolio : Life.base</a></td>
        </tr>
        <tr>
          <td class="spaced">2011 - 2012</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Dix</span> : Utilitaire d'analyse des replays de Starcraft II</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">C - Bash - PHP</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?portfolio#dix">Portfolio : Starcraft Dix</a></td>
        </tr>
        <tr>
          <td class="spaced">2010 - 2011</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">SteelDB</span> : Base de données à usage commercial</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Perl - FileMaker</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?portfolio#steeldb">Portfolio : SteelDB</a></td>
        </tr>
        <tr>
          <td class="spaced">2006 - 2009</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">NRM Online</span> : Jeu de stratégie multijoueur par navigateur</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?portfolio#nrm">Portfolio : NRM Online</a></td>
        </tr>
        <tr>
          <td class="spaced">2006 - 2015</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">NBRPG</span> : Jeu de rôle multijoueur via IRC</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">C - Bash</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?portfolio#nbrpg">Portfolio : NoBlemeRPG</a></td>
        </tr>
        <tr>
          <td class="spaced">2005 - Aujourd'hui</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://nobleme.com/">NoBleme</a> : Communauté et site internet</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?portfolio#nobleme">Portfolio : NoBleme</a></td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Compétences informatiques :</span><br>
      <br>
      <table>
        <tr>
          <td class="spaced">Langages maîtrisés</td>
          <td class="spaced">C ; PHP ; SQL ; JavaScript</td>
        </tr>
        <tr>
          <td class="spaced">Maîtrise partielle</td>
          <td class="spaced">C++ ; Python ; Perl ; Java</td>
        </tr>
        <tr>
          <td class="spaced">Bases de données</td>
          <td class="spaced">MySQL ; PostgreSQL ; FileMaker</td>
        </tr>
        <tr>
          <td class="spaced">Systèmes</td>
          <td class="spaced">FreeBSD ; Linux ; Windows ; Mac OSX</td>
        </tr>
        <tr>
          <td class="spaced">Logiciels</td>
          <td class="spaced">Hg/Git/SVN ; Flash/ActionScript ; GtkRadiant ; Qt</td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Compétences linguistiques (<a class="dark blank gras" href="https://fr.wikipedia.org/wiki/Cadre_europ%C3%A9en_commun_de_r%C3%A9f%C3%A9rence_pour_les_langues">échelle CEFR</a>) :</span><br>
      <br>
      Natif français ; Bilingue natif anglais ; Allemand scolaire ; Bases de russe et d'espagnol<br>
      <br>
      <table>
        <tr>
          <td class="spaced">Oral</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Français C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Anglais C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Allemand A2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Russe A1</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Espagnol A1</td>
        </tr>
        <tr>
          <td class="spaced">Lecture</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Français C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Anglais C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Allemand B1</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Russe A2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Espagnol A2</td>
        </tr>
        <tr>
          <td class="spaced">Écriture</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Français C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Anglais C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Allemand A2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Russe A1</td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Informations complémentaires :</span><br>
      <br>
      Vous trouverez des exemples détaillés et illustrés de mes compétences informatiques dans le <span><a class="dark gras" href="cv?portfolio#portfolio">portfolio</a></span> qui accompagne mon CV.<br>
      <br>
      Outre le développement informatique (ma passion principale), je suis un passioné de littérature, de sociologie, et d'histoire de l'art.<br>
      Je gère l'héritage culturel de la collection <a href="http://www.jazzhot.net/PBEvents.asp?ItmID=23592">photographique</a> et <a href="http://bdzoom.com/60445/actualites/deces-de-jacques-bisceglia/">littéraire </a> de mon défunt père, <a href="http://www.citizenjazz.com/Jacques-Bisceglia-par-Jerome-Merli.html">Jacques Bisceglia</a>.<br>
      J'ai pratiqué le roller de compétition de 2003 à 2005, et je continue à le pratiquer en amateur aujourd'hui.<br>
      <br>
      N'hésitez pas à me contacter via mon e-mail <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a> ou sur <a href="http://nobleme.com/pages/irc/index">IRC</a>.
    </div>

    <br>

    <?php if(isset($_GET['portfolio'])) { ?>

    <br>
    <br>
    <div class="indiv align_center" id="portfolio">
      <img src="<?=$chemin?>img/logos/portfolio.png" alt="Portfolio">
    </div>
    <br>
    <br>

    <div class="body_main midsize">
      <span class="titre">Portfolio : Exemples de projets personnels</span><br>
      <br>
      Par respect du secret professionel et de mes anciens employeurs, je ne vais pas parler de mes anciens emplois dans mon portfolio. À la place, je vais illustrer mes compétences à l'aide de projets personnels (dont un semi-professionel).<br>
      <br>
      Il s'agit principalement de projets que j'ai réalisés parfois pour apprendre, parfois pour le plaisir, parfois pour les deux à la fois.<br>
      J'apprécie la production et le partage de contenu gratuit, par conséquent je ne monétise que très rarement ce que je produis.<br>
      <br>
      <br>
      <hr class="points" id="nobleme">
      <br>
      <br>
      <span class="titre">NoBleme : Communauté et site internet depuis 2005</span><br>
      <span class="alinea moinsgros">PHP - MySQL - JavaScript - Entièrement open source</span><br>
      <br>
      <br>
      Après avoir réalisé quelques « pages perso » et pris le temps d'apprendre les bases de l'administration d'un serveur UNIX, je me suis lancé dans le monde du développement web en inaugurant <a href="http://nobleme.com">nobleme.com</a> en Mars 2005.<br>
      <br>
      À l'origine, NoBleme devait servir à héberger les vidéos d'un ami étudiant en cinéma, aspirant à devenir réalisateur.<br>
      Le défi technologique était énorme, à une époque où les sites de streaming vidéo (tels YouTube) n'existaient pas encore.<br>
      Avec les années, une communauté internet d'amis s'est crée autour de NoBleme. La partie streaming vidéo a rapidement disparu (trop intense en ressources serveur pour la conserver), et NoBleme est devenu un site généraliste centré sur sa communauté.<br>
      <br>
      Depuis 2005, NoBleme est un projet central à ma vie, ses utilisateurs réguliers formant pour moi une sorte de seconde famille.<br>
      Le code source de NoBleme est entièrement libre et open source, publié sous une license permissive qui permet de le réutiliser.<br>
      <br>
      Vous pouvez trouver plus d'informations sur les coulisses de NoBleme et mes convictions de développeur en <a href="<?=$chemin?>pages/nobleme/coulisses">cliquant ici</a>.<br>
      Et vous trouverez le code source de NoBleme sur BitBucket en <a href="https://bitbucket.org/EricBisceglia/nobleme.com/overview">cliquant ici</a>.<br>
      <br>
      <br>
      <hr class="points" id="lifebase">
      <br>
      <br>
      <span class="titre">Life.base : Utilitaire de gestion de la vie quotidienne</span><br>
      <span class="alinea moinsgros">PHP - PostgreSQL - JavaScript - Bash</span><br>
      <br>
      <br>
      J'ai toujours organisé ma vie dans des bases de données. L'investissement temporel pour développer la base de données et la remplir est à long terme largement rattrapé par le temps qu'elle me fait gagner au quotidien.<br>
      <br>
      Life.base est l'incarnation actuelle (depuis 2011) de mes bases de données personnelles. Hébergé sur le réseau local de mon ordinateur, je peux transformer Life.base en un clic en un serveur accessible à distance lorsque je suis en déplacement.<br>
      <br>
      Je gère (entre autres) les contenus suivants dans Life.base :<br>
      - Une liste des tâches à effectuer, pour ne rien oublier dans la vie quotidienne<br>
      - Ma comptabilité personnelle, permettant une gestion avancée avec brouillard, bilans et prévisions<br>
      - Gestion des stocks de livres de collection que j'achète et que je revends (et que je garde parfois dans ma collection personnelle)<br>
      - Une aide au rangement de mes papiers administratifs et comptables, pour pouvoir les retrouver instantanément<br>
      - Une bibliothèque de tous les livres que j'ai lus, films et séries que j'ai vus, et albums de musique que je possède<br>
      - Un annuaire de pages trouvées sur Internet que je désire conserver de façon plus pratique que des favoris dans un navigateur<br>
      - Un rappel de mes mots de passe, encryptés suivant une clé que moi seul connait au cas où quelqu'un d'autre accèderait à life.base<br>
      <br>
      Voici quelques captures d'écran (très lourdement censurées) de diverses sections de Life.base :<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/lifebase_index.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/lifebase_compta.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/lifebase_contact.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/lifebase_show.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/lifebase_collection.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="dix">
      <br>
      <br>
      <span class="titre">Starcraft Dix : Utilitaire d'analyse des replays de Starcraft II</span><br>
      <span class="alinea moinsgros">C - Bash - PHP - MySQL</span><br>
      <br>
      <br>
      En jouant au jeu vidéo de stratégie <a href="https://fr.wikipedia.org/wiki/StarCraft_2">Starcraft II</a>, je me suis retrouvé confronté à un manque : À l'époque (2011), le jeu n'enregistrait pas les statistiques. Il n'était donc pas possible de mesurer mes progrès, ou de savoir quelles étaient mes forces et mes faiblesses. Ayant une nature compétitive, je désirais m'améliorer, et pour cela il fallait que je puisse avoir des statistiques sur mes performances.<br>
      <br>
      Dans un premier temps, je m'étais crée un tableau dans <a href="https://docs.google.com/">Google Docs</a>, où je notais tous mes résultats. Malheureusement, il y avait trop d'informations à noter après chaque partie, ce qui rendait ce système très laborieux. J'ai donc décidé de créer mon propre système, qui extrait automatiquement les informations à partir des replays générés à la fin des parties, et les stocke dans une base de données.<br>
      <br>
      Le plus gros problème était de décrypter le format <a href="https://en.wikipedia.org/wiki/MPQ">MPQ</a> dans lequel les informations des replays est stocké, format extrêmement complexe et qui change à chaque nouvelle version du jeu. Pour ce faire, j'ai crée un programme en C qui est capable de parcourir un fichier MPQ et de n'en extraire que les informations dont j'ai besoin pour ce projet.<br>
      Ensuite, il suffit de semi-automatiser l'ajout de ces informations dans une base de données, et d'afficher les statistiques.<br>
      <br>
      Dix a servi jusqu'en 2012, lorsqu'un outil de statistiques interne au jeu a enfin été ajouté dans Starcraft 2.<br>
      Voici des captures d'écran de l'interface de Dix lorsqu'il était encore en service :<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/dix_upload.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/dix_tableau.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/dix_stats.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/dix_search.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="steeldb">
      <br>
      <br>
      <span class="titre">SteelDB : Outil interne dans l'industrie de l'acier</span><br>
      <span class="alinea moinsgros">Perl - FileMaker - AppleScript</span><br>
      <br>
      <br>
      SteelDB est le nom de code d'un projet professionel que j'ai réalisé qui a gagné un appel d'offres en 2010 et que j'ai continué à développer jusqu'en 2011. Il s'agit d'une situation très spécifique : Une entreprise ayant un environnement entièrement Mac OSX, et désirant utiliser le logiciel (très limité) FileMaker pour leur outil interne.<br>
      <br>
      Étant à l'époque un des seuls développeurs sur Paris ayant de l'expérience avec FileMaker et l'industrie de l'acier, j'ai décidé de tenter ma chance en répondant à l'appel d'offres. Sur mon temps libre, j'ai assemblé un prototype d'outil utilisant des hooks système en AppleScript qui servent à appeler des scripts en Perl afin de contourner les limitations de FileMaker et d'effectuer certaines actions requises par l'appel d'offres qui sont difficiles ou impossibles à faire depuis FileMaker (par exemple envoyer un e-mail, exporter un fichier Excel ou PDF).<br>
      <br>
      Vu que le contrat lié à l'appel d'offres m'autorise à conserver les droits sur le code source que j'ai produit et à le réutiliser librement, je peux parler sans restriction de ce que j'ai fait. Je censure toutefois, par respect, les informations liées à l'entreprise.<br>
      <br>
      SteelDB est une base de données permettant de gérer les éléments suivants :<br>
      - Un carnet d'adresses de contacts, clients et fournisseurs<br>
      - Une liste de pièces d'aciérie lourde stockée de façon bilingue (français/anglais)<br>
      - Un suivi de dossiers pointu allant de la commande au suivi après la vente<br>
      - Un système de traduction de chaque étape des dossiers du français vers l'anglais<br>
      - D'autres outils plus spécifiques dont je ne peux pas parler sans trop révéler d'informations sur l'entreprise<br>
      <br>
      Voici des captures d'écran de SteelDB en production, lourdement censurées des données professionelles qu'elle contient :<br>
      (les premières illustrations sont un schéma relationnel complet de la base de données de l'outil)<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/steeldb_struct1.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_struct2.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_struct3.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_dossier.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_entreprise.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_ddp.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_ddp_details.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_hotel.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/steeldb_pdf.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="nrm">
      <br>
      <br>
      <span class="titre">NRM Online : Jeu de stratégie multijoueur par navigateur</span><br>
      <span class="alinea moinsgros">PHP - MySQL - JavaScript</span><br>
      <br>
      <br>
      Le milieu des années 2000 est marqué sur internet par la mode des jeux au tour par tour via navigateur.<br>
      Suivant cette mode, je m'inspire d'autres jeux similaires pour créer mon propre jeu, le NRM Online.<br>
      Dans ce jeu, chaque joueur incarne un pilote de robot de combat, et affronte d'autres adversaires humains.<br>
      <br>
      Le NRM Online a été actif de 2006 à 2009, et a toujours été entièrement gratuit.<br>
      Le concept du NRM Online était de pousser l'aspect stratégique à fond, permettant à tout joueur de pouvoir battre un adversaire s'il est plus malin que lui, peu importe le robot qu'il a à sa disposition ou le temps qu'il a investi dans le jeu.<br>
      <br>
      Au final, c'est la trop grande profondeur stratégique du NRM qui aura causé sa perte. Même s'il a passé la centaines de joueurs lors de certaines saisons, il n'a su fidéliser qu'un cœur d'une dizaine de joueurs réguliers, nombre trop faible pour continuer à faire vivre le jeu.<br>
      <br>
      Voici des captures d'écran du NRM Online lors de sa 27ème saison, en 2007 :<br>
      (souvenez vous que nous sommes au milieu des années 2000, le design des sites internet était... très différent à l'époque)<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/nrm_index.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/nrm_robot.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/nrm_assign.png" alt="Illustration" width="795px"><br>
        <img src="<?=$chemin?>img/portfolio/nrm_combat.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="nbrpg">
      <br>
      <br>
      <span class="titre">NoBlemeRPG : Jeu de rôle multijoueur via IRC</span><br>
      <span class="alinea moinsgros">C - MySQL - Bash - IRC</span><br>
      <br>
      <br>
      Lorsque j'étais adolescent, j'adorais organiser des sessions de <a href="https://fr.wikipedia.org/wiki/Donjons_et_Dragons">Donjons &amp; Dragons</a>. Je prenais beaucoup de plaisir à être le maître du donjon, à inventer des univers toujours différents et uniques pour mes joueurs.<br>
      <br>
      Le temps est passé, et mes amis se sont dispersés. Puisqu'il n'était plus possible de jouer physiquement avec eux, j'ai décidé en 2006 de créer un système permettant de jouer à un jeu de rôles en se servant du protocole utilisé par les <a href="<?=$chemin?>pages/irc/index">serveurs de chat IRC</a>.<br>
      <br>
      Le NoBlemeRPG part d'un programme de jeu qui se trouve sur mon ordinateur, depuis lequel j'effectue des actions qui affectent les joueurs. Ces actions génèrent des messages sur un canal IRC, auxquels les joueurs doivent réagir en temps réel. Les décisions des joueurs (qu'ils écrivent dans le canal de discussion) sont ensuite interprétées par le programme se trouvant sur mon ordinateur, me permettant ainsi d'intéragir avec les participants en temps quasi-réel de façon quasi-automatisée.<br>
      <br>
      Voici des captures d'écran de l'interface de maître du donjon du NoBlemeRPG tel qu'il était lorsqu'il a pris sa retraite, en 2005 :<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/nbrpg_main.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_perso.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_monstre.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_aptitude.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_item.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_session.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_search.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nbrpg_irc.png" alt="Illustration" width="795px">
      </div>
    </div>

    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';