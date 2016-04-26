<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Éric Bisceglia";
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

    <?php if(!isset($_GET['en'])) { ?>

    <div class="body_main midsize">
      <table class="indiv">
        <tr>
          <td>
            <span class="gros gras">Éric Bisceglia</span><br>
            <span class="moinsgros gras">Développeur</span><br>
          </td>
          <td class="align_right valign_top">
            <a class="dark blank gras" href="cv?en">Click here for the english version</a>
          </td>
        </tr>
      </table>
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
          <td>&nbsp;&nbsp;</td>
          <td>&nbsp;&nbsp;</td>
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
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_compta.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_contact.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_show.png" alt="Illustration" width="795px"><br>
        <br>
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
      Dix a servi jusqu'en 2012, lorsqu'un outil de statistiques interne au jeu a enfin été ajouté dans Starcraft II.<br>
      Voici des captures d'écran de l'interface de Dix lorsqu'il était encore en service :<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/dix_upload.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/dix_tableau.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/dix_stats.png" alt="Illustration" width="795px"><br>
        <br>
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
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_struct2.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_struct3.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_dossier.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_entreprise.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_ddp.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_ddp_details.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_hotel.png" alt="Illustration" width="795px"><br>
        <br>
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
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_robot.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_assign.png" alt="Illustration" width="795px"><br>
        <br>
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
      Voici des captures d'écran de l'interface de maître du donjon du NoBlemeRPG tel qu'il était lorsqu'il a pris sa retraite, en 2015 :<br>
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


    <?php } } else { ?>


    <div class="body_main midsize">
      <table class="indiv">
        <tr>
          <td>
            <span class="gros gras">Éric Bisceglia</span><br>
            <span class="moinsgros gras">Developer</span><br>
          </td>
          <td class="align_right valign_top">
            <a class="dark blank gras" href="cv">Cliquez ici pour la version française</a><br>
            <a class="dark blank gras" href="cv">Click here for the french version</a>
          </td>
        </tr>
      </table>
      <br>
      Lives in Paris, France<br>
      Born August 26, 1988 (<?=floor((strtotime(date('Y-m-d'))-strtotime('1988-08-26'))/31556926)?> years old)<br>
      E-Mail : <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a><br>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Work experience:</span><br>
      <br>
      <table>
        <tr>
          <td class="spaced">2016 - Today</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://www.mtd-finance.fr/">MTD Finance</a> : Intranet development</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL - JavaScript</td>
        </tr>
        <tr>
          <td class="spaced">2014 - 2016</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Freelance</span> : Details protected by a NDA</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">C - Python - PostgreSQL</td>
        </tr>
        <tr>
          <td class="spaced">2010 - 2014</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://www.mtd-finance.fr/">MTD Finance</a> : Intranet development</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL - JavaScript</td>
        </tr>
        <tr>
          <td class="spaced">2009 - 2010</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://www.mecamatic.fr/en/home.php">Mécamatic</a> : Custom software development</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">FileMaker - Perl - AppleScript</td>
        </tr>
        <tr>
          <td class="spaced">2007 - 2009</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Freelance</span> : Flash game development</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Flash - ActionScript</td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Personal projects:</span><br>
      <br>
      <table>
        <tr>
          <td class="spaced">2011 - Today</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Life.base</span> : Daily life management tool</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - PgSQL</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?en&amp;portfolio#lifebase">Portfolio : Life.base</a></td>
        </tr>
        <tr>
          <td class="spaced">2011 - 2012</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">Dix</span> : Automated Starcraft II replay analysis</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">C - Bash - PHP</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?en&amp;portfolio#dix">Portfolio : Starcraft Dix</a></td>
        </tr>
        <tr>
          <td class="spaced">2010 - 2011</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">SteelDB</span> : Commercial database for the steel industry</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Perl - FileMaker</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?en&amp;portfolio#steeldb">Portfolio : SteelDB</a></td>
        </tr>
        <tr>
          <td class="spaced">2006 - 2009</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">NRM Online</span> : Massively multiplayer browser game</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?en&amp;portfolio#nrm">Portfolio : NRM Online</a></td>
        </tr>
        <tr>
          <td class="spaced">2006 - 2015</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><span class="gras">NBRPG</span> : Real time multiplayer game through IRC</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">C - Bash</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?en&amp;portfolio#nbrpg">Portfolio : NoBlemeRPG</a></td>
        </tr>
        <tr>
          <td class="spaced">2005 - Today</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="http://nobleme.com/">NoBleme</a> : Community and website</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">PHP - MySQL</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced"><a class="dark blank gras" href="cv?en&amp;portfolio#nobleme">Portfolio : NoBleme</a></td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Development skills:</span><br>
      <br>
      <table>
        <tr>
          <td class="spaced">Fully mastered</td>
          <td class="spaced">C ; PHP ; SQL ; JavaScript</td>
        </tr>
        <tr>
          <td class="spaced">Strong knowledge</td>
          <td class="spaced">C++ ; Python ; Perl ; Java</td>
        </tr>
        <tr>
          <td class="spaced">Databases</td>
          <td class="spaced">MySQL ; PostgreSQL ; FileMaker</td>
        </tr>
        <tr>
          <td class="spaced">Operating systems</td>
          <td class="spaced">FreeBSD ; Linux ; Windows ; Mac OSX</td>
        </tr>
        <tr>
          <td class="spaced">Other software</td>
          <td class="spaced">Hg/Git/SVN ; Flash/ActionScript ; GtkRadiant ; Qt</td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Languages (<a class="dark blank gras" href="https://en.wikipedia.org/wiki/Common_European_Framework_of_Reference_for_Languages">CEFR scale</a>):</span><br>
      <br>
      Fluent native french ; Fluent bilingual english ; Decent german ; Basics of russian and spanish<br>
      <br>
      <table>
        <tr>
          <td class="spaced">Spoken</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">French C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">English C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">German A2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Russian A1</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Spanish A1</td>
        </tr>
        <tr>
          <td class="spaced">Reading</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">French C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">English C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">German B1</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Russian A2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Spanish A2</td>
        </tr>
        <tr>
          <td class="spaced">Writing</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">French C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">English C2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">German A2</td>
          <td>&nbsp;&nbsp;</td>
          <td class="spaced">Russian A1</td>
          <td>&nbsp;&nbsp;</td>
          <td>&nbsp;&nbsp;</td>
        </tr>
      </table>
      <br>
      <hr>
      <br>
      <span class="alinea gras">Extra information:</span><br>
      <br>
      You can find detailed and illustrated examples of my development skills in the <span><a class="dark gras" href="cv?en&amp;portfolio#portfolio">portfolio</a></span> that comes with my CV.<br>
      <br>
      Other than computer programming (my main passion), I am passionate about french literature, sociology, and art history.<br>
      I manage the cultural inheritance (photographic and literary collections) of my deceased father, <a href="http://inconstantsol.blogspot.fr/2013/03/jacques-bisceglia-1940-2013.html">Jacques Bisceglia</a>.<br>
      I've practiced competitive rollerblading from 2003 to 2005, and still practice it as an amateur nowadays.<br>
      <br>
      Do not hesitate to contact me by email at <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a> or on IRC at irc.nobleme.com on the channel #english.
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
      <span class="titre">Portfolio : Examples of personal projects</span><br>
      <br>
      Out of respect for my current and former employers, I will not discuss any of my professional projects within this portfolio.<br>
      Instead, I will illustrate my skills through personal projects (and one semi-professional project).<br>
      <br>
      Since I mostly develop for myself and/or french communities, the content in most screenshots will be in french.<br>
      I am however fluent in english, and have worked on many professional english projects.<br>
      <br>
      <br>
      <hr class="points" id="nobleme">
      <br>
      <br>
      <span class="titre">NoBleme : Internet community since 2005</span><br>
      <span class="alinea moinsgros">PHP - MySQL - JavaScript - Entirely open sourced</span><br>
      <br>
      <br>
      After making a few “personal homepages” and taking the time required to learn UNIX administration, I entered the world of proper web development in March 2005 by launching the french website <a href="http://nobleme.com">nobleme.com</a>.<br>
      <br>
      At first, NoBleme was meant to be a hosting platform for the videos of a friend who studied filmmaking.<br>
      The technological challenge was tough, at a time where video streaming websites (such as YouTube) didn't exist yet.<br>
      As time went by, a community of internet and real life friends appeared within NoBleme. The video streaming part disappeared (too demanding in server resources), and NoBleme became a general purpose website centered on its community.<br>
      <br>
      Since 2005, NoBleme has always been a central part of my life, its users being sort of a second family to me.<br>
      The website is entirely open sourced, published under a permissive licence which allows code re-use.<br>
      You can find nobleme.com's source code on BitBucket by <a href="https://bitbucket.org/EricBisceglia/nobleme.com/src">clicking here</a> (keep in mind it is a <?=floor((strtotime(date('Y-m-d'))-strtotime('2005-03-21'))/31556926)?> year old project).<br>
      <br>
      <br>
      <hr class="points" id="lifebase">
      <br>
      <br>
      <span class="titre">Life.base : Daily life management tool</span><br>
      <span class="alinea moinsgros">PHP - PostgreSQL - JavaScript - Bash</span><br>
      <br>
      <br>
      I've always organized many aspects of my life using databases. The time invested in developing and maintening the databases usually ends up being offset by the comfort and time gained in my daily life from having readily available information.<br>
      <br>
      Life.base is the current embodiment (since 2011) of my personal databases. Hosted on my home computer's localhost, I can transform it in one click into a server which allows me to access and use Life.base when I am traveling.<br>
      <br>
      I manage the following content (among others) within Life.base :<br>
      - A daily todo-list/tasklist, in order to never forget anything<br>
      - My personal accounting, using tools that allow for long term planning and balancing when I work as a freelancer<br>
      - A management tool for my book storage (I buy, sell, and collect high value french books)<br>
      - An administrative document sorting tool, which lets me know instantly where any important document is stored<br>
      - A library of every book I've read, movie I've watched, and music album I own<br>
      - A directory of web pages which I want to keep in a way that is more convenient than browser bookmarks<br>
      - A reminder of my important passwords, which can only be accessed through the use of a specific key that only I know<br>
      <br>
      Here are a few (highly censored) screenshots of some Life.base pages:<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/lifebase_index.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_compta.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_contact.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_show.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/lifebase_collection.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="dix">
      <br>
      <br>
      <span class="titre">Starcraft Dix : Automated Starcraft II replay analysis</span><br>
      <span class="alinea moinsgros">C - Bash - PHP - MySQL</span><br>
      <br>
      <br>
      Playing the real time strategy game <a href="https://en.wikipedia.org/wiki/StarCraft_2">Starcraft II</a>, I was faced with an issue : At the time (2011), the game did not keep any stats about your performances. It was therefore not possible to measure my strengths and weaknesses, to know which area I needed to improve in. Having a competitive nature, I had a drive to become a better player, and thus needed a tool that would track those stats for me.<br>
      <br>
      At first, I used <a href="https://docs.google.com/">Google Docs</a> to store my results. However, there was so much information to keep from each game that it felt like a waste of time to enter them manually. I had to find a way to automate that process as much as possible, and to keep those stats in a database from which I could easily extract any custom data I'd want.<br>
      <br>
      The main issue was to parse the <a href="https://en.wikipedia.org/wiki/MPQ">MPQ</a> format used by replay files. Not only is it an extremely complex format, but it also changes with every new version of the game. After a while, I developed a program in C capable of extracting the data I needed from MPQ files.<br>
      Once that program extracted enough data, all that remained was to create a web interface to display the stats I wanted to see.<br>
      <br>
      Dix was used and maintained until 2012, when internal stats tracking was finally added to Starcraft II.<br>
      Here are a few screenshots of the Starcraft Dix web interface from when it was still in use:<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/dix_upload.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/dix_tableau.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/dix_stats.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/dix_search.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="steeldb">
      <br>
      <br>
      <span class="titre">SteelDB : Internal software for the steel industry</span><br>
      <span class="alinea moinsgros">Perl - FileMaker - AppleScript</span><br>
      <br>
      <br>
      SteelDB is the code name of a professional project with which I won a bidding call in 2010, and which I kept developing until 2011.<br>
      It was the product of a very specific situation: A company working entirely in a Mac OSX environment needed an internal tool, and insisted that said tool used the (very limited) FileMaker software as its database and user interface.<br>
      <br>
      Being at the time one of the very few developers in France who had experience with both FileMaker and the steel industry, I decided to answer the bidding call. During my free time, I assembled a prototype tool which used sysem hooks in AppleScript to call Perl scripts in order to bypass FileMaker's limitations and achieve things that were tedious or impossible to do natively with FileMaker (such as sending an e-mail, exporting a PDF file, or editing an Excel file).<br>
      <br>
      Given that the contract I signed for that bidding call allows me to keep the rights to the software I developed, I can talk about it freely. However, out of respect for the company that made the bidding call, I censor everything related to them.<br>
      <br>
      SteelDB is a multi purpose tool able to manage the following things :<br>
      - An address books for clients, suppliers, and other contacts<br>
      - A list of steelworks components stored bilingually (french/english)<br>
      - A complex tracking tool that allows to follow a sale from the price quotation to the post-sale delivery<br>
      - An automated translation system that allows communication between french and english companies without the need for a translator<br>
      - Other tools specific to the company which I will not talk about out of respect for their business<br>
      <br>
      Here are a few SteelDB screenshots, heavily censored of all the company data it contains:<br>
      (the first pictures are a partial relational graph of the tool's database)<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/steeldb_struct1.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_struct2.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_struct3.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_dossier.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_entreprise.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_ddp.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_ddp_details.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_hotel.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/steeldb_pdf.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="nrm">
      <br>
      <br>
      <span class="titre">NRM Online : Massively multiplayer browser game</span><br>
      <span class="alinea moinsgros">PHP - MySQL - JavaScript</span><br>
      <br>
      <br>
      Turn by turn browser games were one of the biggest internet trends of the first decade of the 2000s.<br>
      Following this trend, I took inspiration from a few other games to develop my own, the NRM Online.<br>
      In this game, each player incarnated a combat mech pilot, and fought other players over dominance of the rankings.<br>
      <br>
      The NRM Online was active from 2006 to 2009, and was a fully free game during all of its lifespan, despite the server costs.<br>
      The main idea behind the game was to push the boundaries of turn by turn strategy as deep as possible, always giving any player the ability to beat any other player even if his mech was way inferior to that of his opponent. It was all about outsmarting other players.<br>
      <br>
      The game peaked at several hundred daily active players in 2007. As browser games started to become a thing of the past, the playerbase slowly shrunk over time to a point where there was no point in keeping the game alive. It was shut down in 2009.<br>
      <br>
      Here are a few screenshots from the NRM Online 27th season, in 2007:<br>
      (keep in mind that back then what was considered good web design was rather... different)<br>
      <br>
      <div class="indiv align_center">
        <img src="<?=$chemin?>img/portfolio/nrm_index.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_robot.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_assign.png" alt="Illustration" width="795px"><br>
        <br>
        <img src="<?=$chemin?>img/portfolio/nrm_combat.png" alt="Illustration" width="795px"><br>
      </div>
      <br>
      <br>
      <hr class="points" id="nbrpg">
      <br>
      <br>
      <span class="titre">NoBlemeRPG : Multiplayer role playing game through IRC</span><br>
      <span class="alinea moinsgros">C - MySQL - Bash - IRC</span><br>
      <br>
      <br>
      Back when I was a teenager, I used to love hosting <a href="https://en.wikipedia.org/wiki/Dungeons_%26_Dragons">Dungeons &amp; Dragons</a> games. I took a lot of pleasure in being the dungeon master, in inventing new universes every week to keep my players interested enough to come back the next week.<br>
      <br>
      Time went by, and my friends moved to other cities. As it wasn't possible anymore to play with them in real life, I decided in 2006 to create a way to keep playing online. Since most of us used <a href="https://en.wikipedia.org/wiki/Internet_Relay_Chat">IRC</a> on a daily basis, I decided to build the game on top of it.<br>
      <br>
      The NoBlemeRPG is a master program which rests in my computer. From this master program, I run commands which affect players. Those commands generate messages on an IRC channel, to which players have to reply. The player's actions are then read by the master program and automatically processed, allowing me to interact in near real time with my players.<br>
      <br>
      Here are a few screenshots from the NoBlemeRPG's master program as it was when I retired it, in 2005:<br>
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

    <?php } } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';