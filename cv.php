<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes

// Identification
$page_nom = "Consulte le CV de Bad";
$page_url = "cv";

// On vire le menu
$_GET['popup'] = 1;

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_title = ($lang == 'FR') ? "CV de Éric Bisceglia" : "Éric Bisceglia's CV";
$page_desc  = "Curriculum Vitæ de Éric Bisceglia, développeur.";

// CSS
$css = array('cv');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Changement de langue
if(isset($_GET['en']))
{
  $_SESSION['lang'] = 'EN';
  $lang             = 'EN';
}
if(isset($_GET['fr']))
{
  $_SESSION['lang'] = 'FR';
  $lang             = 'FR';
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // CV: Titres
  $trad['soustitre']      = "Technical manager<br>Senior developer";
  $trad['langlink']       = "en";
  $trad['langswitch']     = "Click here for the english version";
  $trad['domicile']       = "Habite Paris, France";
  $temp_age               = floor((strtotime(date('Y-m-d'))-strtotime('1988-08-26'))/31556926);
  $trad['naissance']      = "Né le 26 août 1988 ($temp_age ans)";
  $trad['active']         = "Développeur depuis 2007";

  // CV: Parcours professionel
  $trad['parcours']       = "Parcours professionel";
  $trad['aujourdhui']     = "Aujourd'hui";
  $trad['work_mtd2']      = "CTO (Directeur informatique)";
  $trad['work_free2']     = "Sous secret professionel";
  $trad['work_mtd']       = "Lead developer de l'intranet";
  $trad['work_meca']      = "Développement logiciel interne";
  $trad['work_free']      = "Développement de jeux en flash";
  $trad['work_phpsymfo']  = "Stack PHP/Symfony";
  $trad['work_phpstack']  = "Stack basé sur du PHP";

  // CV: Projets personnels
  $trad['projets']        = "Projets personnels";
  $trad['perso_nobleme']  = "Site internet et communauté";
  $trad['perso_steeldb']  = "Base de données à usage commercial";
  $trad['perso_dix']      = "Exploitation d'un format propriétaire";
  $trad['perso_nrm']      = "MMO de stratégie via navigateur";
  $trad['perso_nbrpg']    = "Jeu de rôle multijoueur via IRC";

  // CV: Compétences techniques
  $trad['skill']          = "Compétences techniques";
  $trad['skill_maitre']   = "Langages maîtrisés";
  $trad['skill_partiel']  = "Maîtrise partielle";
  $trad['skill_os']       = "Systèmes d'exploitation";
  $trad['skill_bdd']      = "Bases de données";
  $trad['skill_soft']     = "Logiciels";

  // CV: Compatences linguistiques
  $trad['lang']           = "Langues";
  $trad['lang_cefr']      = "Échelle CEFR";
  $trad['lang_cefr_href'] = "https://fr.wikipedia.org/wiki/Cadre_europ%C3%A9en_commun_de_r%C3%A9f%C3%A9rence_pour_les_langues#.C3.89chelle_globale";
  $trad['lang_resume']    = "Français natif ; Bilingue anglais ; Allemand correct ; Bases de russe, espagnol, et autres langues";
  $trad['lang_oral']      = "Oral";
  $trad['lang_lecture']   = "Lecture";
  $trad['lang_ecriture']  = "Écriture";
  $trad['lang_fr']        = "Français";
  $trad['lang_en']        = "Anglais";
  $trad['lang_de']        = "Allemand";
  $trad['lang_ru']        = "Russe";
  $trad['lang_es']        = "Espagnol";

  // CV: Informations complémentaires
  $trad['extra']          = "Informations complémentaires";
  $trad['extra_text']     = <<<EOD
Vous trouverez des exemples illustrés de mes compétences dans le <a class="gras souligne" href="cv?portfolio#portfolio">portfolio</a> qui accompagne ce CV.<br>
<br>
Outre le développement informatique (ma passion principale), je suis un passionné de littérature, histoire, sociologie, game design, science-fiction, et de musique moderne.<br>
Je gère l'héritage culturel de la collection <a class="gras" href="http://www.jazzhot.net/PBEvents.asp?ItmID=23592">photographique</a> et <a class="gras" href="http://bdzoom.com/60445/actualites/deces-de-jacques-bisceglia/">littéraire</a> de mon défunt père, <a class="gras" href="https://www.citizenjazz.com/Jacques-Bisceglia-par-Jerome-Merli.html">Jacques Bisceglia</a>.<br>
<br>
N'hésitez pas à me contacter via mon email <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a> ou sur <a class="gras" href="{$path}pages/irc/index">IRC</a>.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // CV: Titres
  $trad['soustitre']      = "Technical manager<br>Senior developer";
  $trad['langlink']       = "fr";
  $trad['langswitch']     = "Click here for the french version";
  $trad['domicile']       = "Lives in Paris, France";
  $temp_age               = floor((strtotime(date('Y-m-d'))-strtotime('1988-08-26'))/31556926);
  $trad['naissance']      = "Born august 26, 1988 (age $temp_age)";
  $trad['active']         = "Developer since 2007";

  // CV: Parcours professionel
  $trad['parcours']       = "Work experience";
  $trad['aujourdhui']     = "Today";
  $trad['work_mtd2']      = "CTO (executive)";
  $trad['work_free2']     = "Details protected by a NDA";
  $trad['work_mtd']       = "Lead developer";
  $trad['work_meca']      = "Custom software development";
  $trad['work_free']      = "Flash game development";
  $trad['work_phpsymfo']  = "PHP/Symfony stack";
  $trad['work_phpstack']  = "PHP based stack";

  // CV: Projets personnels
  $trad['projets']        = "Personal projets";
  $trad['perso_nobleme']  = "Website and community";
  $trad['perso_steeldb']  = "Database for commercial use";
  $trad['perso_dix']      = "Proprietary format analysis tool";
  $trad['perso_nrm']      = "Browser based strategy MMO";
  $trad['perso_nbrpg']    = "Multiplayer game played through IRC";

  // CV: Compétences techniques
  $trad['skill']          = "Technical skills";
  $trad['skill_maitre']   = "Mastered languages";
  $trad['skill_partiel']  = "Strong knowledge";
  $trad['skill_os']       = "Operating systems";
  $trad['skill_bdd']      = "Databases";
  $trad['skill_soft']     = "Software";

  // CV: Compatences linguistiques
  $trad['lang']           = "Languages";
  $trad['lang_cefr']      = "CEFR scale";
  $trad['lang_cefr_href'] = "https://en.wikipedia.org/wiki/Common_European_Framework_of_Reference_for_Languages#Common_reference_levels";
  $trad['lang_resume']    = "French native ; Fluent english ; Decent german ; Bases of russian, spanish, and other languages";
  $trad['lang_oral']      = "Spoken";
  $trad['lang_lecture']   = "Read";
  $trad['lang_ecriture']  = "Written";
  $trad['lang_fr']        = "French";
  $trad['lang_en']        = "English";
  $trad['lang_de']        = "German";
  $trad['lang_ru']        = "Russian";
  $trad['lang_es']        = "Spanish";

  // CV: Informations complémentaires
  $trad['extra']          = "Extra information";
  $trad['extra_text']     = <<<EOD
You will find illustrated examples of my skills in the <a class="gras souligne" href="cv?portfolio#portfolio">portfolio</a> which accompanies this CV.<br>
<br>
Other than computer programming (my main passion), I am passionate about literature, history, sociology, game design, science fiction, and modern music.<br>
I manage the cultural inheritance (photographs and books) of my deceased father, <a class="gras" href="http://inconstantsol.blogspot.fr/2013/03/jacques-bisceglia-1940-2013.html">Jacques Bisceglia</a>.<br>
<br>
Do not hesitate to contact me by e-mail at <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a> or through <a class="gras" href="{$path}pages/irc/index">IRC</a>.
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/******************************************************************************************************/ include './inc/header.inc.php'; ?>

      <div class="texte">

        <br>
        <br>

        <div class="flexcontainer">

          <div style="flex:1">
            <h1>Éric Bisceglia</h1>
            <h5><?=$trad['soustitre']?></h5>
          </div>

          <div class="align_right" style="flex:1;">
            <p>
              <?=$trad['domicile']?><br>
              <?=$trad['active']?><br>
              <?=$trad['naissance']?><br>
              E-mail : <a href="mailto:bisceglia.eric@gmail.com">bisceglia.eric@gmail.com</a><br>
              <a class="gras souligne" href="cv?<?=$trad['langlink']?>"><?=$trad['langswitch']?></a>
            </p>
          </div>

        </div>

        <br>
        <hr>
        <br>
        <h5 class="alinea"><?=$trad['parcours']?></h5>
        <br>

        <div class="flexcontainer">

          <div style="flex:auto">
            2019 - <?=$trad['aujourdhui']?><br>
            2016 - 2018<br>
            2015 - 2016<br>
            2010 - 2015<br>
            2009 - 2010<br>
            2007 - 2009
          </div>

          <div style="flex:auto">
            <a class="gras" href="http://www.wynd.eu">Wynd</a> - Technical manager<br>
            <a class="gras" href="http://www.mtd-finance.fr">MTD Finance</a> - <?=$trad['work_mtd2']?><br>
            <span class="gras texte_noir">Consulting</span> - <?=$trad['work_free2']?><br>
            <a class="gras" href="http://www.mtd-finance.fr">MTD Finance</a> - <?=$trad['work_mtd']?><br>
            <a class="gras" href="http://www.mecamatic.fr">Mécamatic</a> - <?=$trad['work_meca']?><br>
            <span class="gras texte_noir">Freelance</span> - <?=$trad['work_free']?>
          </div>

          <div style="flex:auto">
            <?=$trad['work_phpsymfo']?> - Management<br>
            <?=$trad['work_phpstack']?> - Management<br>
            Python - PostgreSQL - React.js<br>
            PHP - MySQL - JavaScript<br>
            Filemaker - Perl - AppleScript<br>
            Flash - Actionscript
          </div>

        </div>

        <br>
        <hr>
        <br>
        <h5 class="alinea"><?=$trad['projets']?></h5>
        <br>

        <div class="flexcontainer">

          <div style="flex:auto">
            2005 - <?=$trad['aujourdhui']?><br>
            2010 - 2011<br>
            2011 - 2012<br>
            2006 - 2009<br>
            2006 - 2015
          </div>

          <div style="flex:auto">
            <a class="gras" href="http://nobleme.com/">NoBleme</a> - <?=$trad['perso_nobleme']?><br>
            <span class="gras texte_noir">SteelDB</span> - <?=$trad['perso_steeldb']?><br>
            <span class="gras texte_noir">Dix</span> - <?=$trad['perso_dix']?><br>
            <span class="gras texte_noir">NRM Online</span> - <?=$trad['perso_nrm']?><br>
            <span class="gras texte_noir">NBRPG</span> - <?=$trad['perso_nbrpg']?>
          </div>

          <div style="flex:auto">
            PHP - MySQL<br>
            Perl - Filemaker<br>
            C - Bash - PHP<br>
            PHP - MySQL<br>
            C - MySQL
          </div>

          <div style="flex:auto">
            <a class="gras" href="cv?portfolio#nobleme">Portfolio : NoBleme</a><br>
            <a class="gras" href="cv?portfolio#steeldb">Portfolio : SteelDB</a><br>
            <a class="gras" href="cv?portfolio#dix">Portfolio : Dix</a><br>
            <a class="gras" href="cv?portfolio#nrm">Portfolio : NRM Online</a><br>
            <a class="gras" href="cv?portfolio#nbrpg">Portfolio : NBRPG</a>
          </div>

        </div>

        <br>
        <hr>
        <br>
        <h5 class="alinea"><?=$trad['skill']?></h5>
        <br>

        <div class="flexcontainer">

          <div style="flex:1">
            <?=$trad['skill_maitre']?><br>
            <?=$trad['skill_partiel']?><br>
            <?=$trad['skill_bdd']?><br>
            <?=$trad['skill_os']?><br>
            <?=$trad['skill_soft']?>
          </div>

          <div style="flex:3">
            PHP ; SQL ; JavaScript ; HTML/CSS<br>
            C ; C++ ; Python ; Perl ; Java<br>
            MySQL ; PostgreSQL ; Filemaker<br>
            Windows ; OSX ; Linux ; FreeBSD<br>
            Git/Hg/SVN ; Flash/ActionScript ; GtkRadiant
          </div>

        </div>

        <br>
        <hr>
        <br>
        <h5 class="alinea"><?=$trad['lang']?> (<a href="<?=$trad['lang_cefr_href']?>"><?=$trad['lang_cefr']?></a>)</h5>
        <br>
        <span class="gras"><?=$trad['lang_resume']?></span><br>
        <br>

        <div class="flexcontainer">

          <div style="flex:1">
            <?=$trad['lang_oral']?><br>
            <?=$trad['lang_lecture']?><br>
            <?=$trad['lang_ecriture']?>
          </div>

          <div style="flex:1">
            <?=$trad['lang_fr']?> C2<br>
            <?=$trad['lang_fr']?> C2<br>
            <?=$trad['lang_fr']?> C2
          </div>

          <div style="flex:1">
            <?=$trad['lang_en']?> C2<br>
            <?=$trad['lang_en']?> C2<br>
            <?=$trad['lang_en']?> C2
          </div>

          <div style="flex:1">
            <?=$trad['lang_de']?> A2<br>
            <?=$trad['lang_de']?> B1<br>
            <?=$trad['lang_de']?> A2
          </div>

          <div style="flex:1">
            <?=$trad['lang_ru']?> A1<br>
            <?=$trad['lang_ru']?> A2<br>
            <?=$trad['lang_ru']?> A1
          </div>

          <div style="flex:1">
            <?=$trad['lang_es']?> A1<br>
            <?=$trad['lang_es']?> A2<br>
            <?=$trad['lang_es']?> A1
          </div>

        </div>

        <br>
        <hr>
        <br>
        <h5 class="alinea"><?=$trad['extra']?></h5>

        <p>
          <?=$trad['extra_text']?>
        </p>

      </div>

      <br>
      <br>




      <?php if(isset($_GET['portfolio']) && $lang == 'FR') { ?>

      <br>
      <br>
      <br>
      <hr>
      <br>
      <br>

      <div class="texte" id="portfolio">

        <br>
        <br>

        <h1>Portfolio</h1>
        <h5>Exemples de projets personnels</h5>

        <p>
          Par respect du secret professionnel et de mes anciens employeurs, je ne vais pas parler de mes anciens emplois dans mon portfolio. À la place, je vais me servir de projets personnels (dont un à usage commercial) pour illustrer mes compétences de développeur informatique.<br>
          <br>
          Il s'agit principalement de projets que j'ai réalisés parfois pour apprendre, parfois pour le plaisir, parfois pour les deux à la fois. J'apprécie la production et le partage de contenu gratuit, par conséquent je ne monétise jamais ce que je développe.
        </p>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="nobleme">

        <h5 class="alinea">NoBleme.com : Site internet et communauté depuis 2005</h5>
        <span class="alinea">PHP - MySQL - JavaScript - Entièrement open source</span>

        <p>
          Après avoir pris le temps d'apprendre les bases du développement web et de l'administration d'un serveur UNIX, j'ai inauguré le site internet <a class="gras" href="http://nobleme.com">NoBleme.com</a> en Mars 2005.<br>
          <br>
          À l'origine, NoBleme devait servir à héberger les vidéos d'un ami étudiant en cinéma, aspirant à devenir réalisateur. Le défi technologique était énorme, à une époque où les sites de streaming vidéo publics et gratuits (tels YouTube) n'existaient pas encore.<br>
          <br>
          Au fur et à mesure des années, une communauté internet s'est crée autour de NoBleme. La partie streaming vidéo a rapidement disparu (trop intense en ressources serveur pour la conserver), et NoBleme est devenu un site généraliste centré sur sa communauté, qui organise régulièrement des <a class="gras" href="<?=$path?>pages/irl/index">rencontres IRL</a>.
        </p>

        <p>
          Le code source de NoBleme est entièrement libre et open source, publié sous une license permissive qui permet de le réutiliser. Il est visible publiquement sur GitHub : <a class="gras" href="https://github.com/EricBisceglia/NoBleme.com">voir le code source de NoBleme.com</a><br>
          <br>
          Vous trouverez plus d'informations sur les aspects techniques du développement de NoBleme.com et sur mes convictions de développeur en visitant les <a class="gras" href="<?=$path?>pages/nobleme/coulisses">coulisses de NoBleme</a>
        </p>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="steeldb">

        <h5 class="alinea">SteelDB : Logiciel de traduction pour l'industrie lourde</h5>
        <span class="alinea">Perl - FileMaker - AppleScript - Développé de 2010 à 2011</span>

        <p>
          SteelDB est le nom de code interne d'un projet commercial que j'ai réalisé en 2010 et continué à maintenir jusqu'en 2011. Il s'agit d'un logiciel interne répondant à une problématique spécifique : Une entreprise ayant un environnement Mac OSX, et désirant utiliser le logiciel (très limité) Filemaker pour leur outil interne.<br>
          <br>
          Étant à l'époque un des seuls développeurs sur Paris ayant à la fois de l'expérience avec Filemaker, OSX, et l'industrie lourde, j'ai décidé de tenter ma chance. Sur mon temps libre, j'ai assemblé un prototype d'outil utilisant des hooks système en AppleScript permettant d'appeler des scripts en Perl depuis Filemaker afin de contourner les limitations du logiciel. Certaines actions impossibles à l'époque depuis Filemaker (envoyer un e-mail, exporter un PDF, etc.) deviennent ainsi relativement simples à réaliser.<br>
          <br>
          L'objectif de SteelDB est de gérer tous les éléments suivants :<br>
          - Un carnet d'adresses de contacts, clients et fournisseurs<br>
          - Un utilitaire de traductions techniques pointues automatisées<br>
          - Un suivi du processus allant de la commande au suivi après vente<br>
          - Une liste de pièces d'industrie lourde stockée de façon bilingue (français/anglais)<br>
          - D'autres outils plus spécifiques dont je ne peux pas parler sans ruiner le secret professionel
        </p>

        <br>

        <p>
          Voici des captures d'écran du processus de développement de SteelDB, lourdement censurées des données professionelles qu'elle contiennent. Le développement a commencé par la conception de la structure de données, continué par la gestion des dossiers et des éléments qui y sont liés, et fini par la gestion des exports PDF et des e-mails automatisés.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_struct1.png" alt="SteelDB"><br>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_struct2.png" alt="SteelDB"><br>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_struct3.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_dossier.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_ddp.png" alt="SteelDB"><br>
        <img src="<?=$path?>img/portfolio/steeldb_ddp_details.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_entreprise.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_hotel.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_pdf.png" alt="SteelDB"><br>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="dix">

        <h5 class="alinea">Starcraft Dix : Génération de statistiques à partir de fichiers .MPQ</h5>
        <span class="alinea">C - Bash - PHP - MySQL - JavaScript - Developpé de 2011 à 2012</span>

        <p>
          En 2011, je jouais compétitivement au jeu vidéo <a class="gras" href="https://fr.wikipedia.org/wiki/StarCraft_2:_Wings_of_Liberty">Starcraft II</a>. À l'époque, le jeu ne proposait pas de statistiques sur ses performances à long terme. Afin de mesurer mon progrès et de déterminer les talents spécifiques que je devais entrainer afin de m'améliorer, j'ai décidé de créer mon propre utilitaire de statistiques.
        </p>

        <p>
          À la fin de chaque partie de Starcraft II, une option permettait de produire automatiquement un fichier .MPQ contenant le replay de la partie (qui permet de re-visionner ses parties passées). Le <a class="gras" href="https://en.wikipedia.org/wiki/MPQ">format MPQ</a> est malheureusement propriétaire, mais d'autres développeurs curieux avaient déjà su comment en extraire des informations. En me basant sur la documentation du format MPQ effectuée par d'autres avant moi, j'ai crée mon propre script en C permettant de parcourir un fichier MPQ et d'en extraire les informations pertinentes.
        </p>

        <p>
          Maintenant que je disposais de la capacité à extraire les informations sur mes parties passées, il ne me restait plus qu'à les exploiter. Pour ce faire, j'ai déployé sur mon réseau local un script en Bash qui se charge d'automatiquement insérer les statistiques des replays dans une base de données MySQL, ainsi qu'un environnement local en PHP + JavaScript permettant d'exploiter ces statistiques.
        </p>

        <br>

        <p>
          Voici quelques captures d'écran de l'interface utilisateur que j'utilisais sur mon réseau local. J'ai maintenu Starcraft Dix jusqu'en 2012, lorsqu'un outil de statistiques intégré au jeu a enfin été ajouté dans Starcraft II.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/dix_tableau.png" alt="Starcraft Dix"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/dix_stats.png" alt="Starcraft Dix"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/dix_search.png" alt="Starcraft Dix"><br>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="nrm">

        <h5 class="alinea">NRM Online : Jeu de stratégie multijoueur par navigateur</h5>
        <span class="alinea">PHP - MySQL - JavaScript - Développé de 2006 à 2009</span>

        <p>
          Le milieu des années 2000 est marqué sur internet par la mode des jeux via navigateur. En plein dans cette mode, un jeu nommé Super Robot Wars Online capture l'attention de quelques centaines de joueurs, avant de périr pour cause de manque de temps libre de son administrateur. Moi-même joueur de Super Robot Wars Online, je décide de créer mon propre jeu via navigateur sur le même thème afin de donner un nouveau jeu à ceux qui veulent continuer à jouer à quelque chose qui ressemble à Super Robot Wars Online.
        </p>

        <p>
          Le NRM Online (NoBleme Robot Mayhem Online) a ouvert ses portes en 2006, et été maintenu activement jusqu'en 2009. Tout du long de son existence, le jeu a été entièrement gratuit. Le concept du NRM Online était que chaque joueur incarnait un pilote de robot de combat, et devait utiliser un système de stratégie complexe pour gagner des combats de robots contre les autres joueurs.
        </p>

        <p>
          Durant ses 4 ans d'existence, j'ai introduit en continu de nouvelles idées dans le NRM. Ces changements constants ont fini par lasser les joueurs et ont provoqué la mort lente du jeu, mais m'ont également permis d'apprendre de nombreuses leçons de game design et de me donner la passion du développement.
        </p>

        <br>

        <p>
          Voici des captures d'écran du NRM Online lors de sa 27ème saison, en 2007. Souvenez vous que nous sommes à l'époque au milieu des années 2000, le design des sites internet était... très différent.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_index.png" alt="NRM Online"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_robot.png" alt="NRM Online"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_assign.png" alt="NRM Online"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_combat.png" alt="NRM Online"><br>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="nbrpg">

        <h5 class="alinea">NoBlemeRPG : Jeu de rôle multijoueur via IRC</h5>
        <span class="alinea">C - MySQL - Bash - IRC - Développé par intermittence de 2006 à 2015</span>

        <p>
          Lorsque j'étais adolescent, à chaque fois que j'avais un week-end de libre, je m'en servais pour organiser des sessions de <a class="gras" href="https://fr.wikipedia.org/wiki/Donjons_et_Dragons">Donjons &amp; Dragons</a> et autres <a class="gras" href="https://fr.wikipedia.org/wiki/Jeu_de_r%C3%B4le_sur_table">jeux de rôle</a>. Je prenais beaucoup de plaisir à être le maître du donjon et à inventer des histoires et des univers pour mes joueurs.
        </p>

        <p>
          Le temps est passé, et la vie a  évolué. Je me suis mis à travailler le week-end, des amis ont déménagé, organiser des sessions de jeux de rôle devenait de plus en plus compliqué. Heureusement, internet était en train de se propager, et nous permettait de continuer à jouer via des serveurs de <a class="gras" href="<?=$path?>pages/irc/index">chat IRC</a>.
        </p>

        <p>
          Bien entendu, jouer par écrit n'est pas du tout équivalent à jouer en présence physique de ses joueurs. Il est plus difficile de communiquer des émotions, les actions ont un temps de réaction beaucoup plus long, et il y a une grande quantité de temps morts à meubler causés par la lenteur d'écriture au clavier.
        </p>

        <p>
          Pour s'adapter au changement de méthode de jeu, j'ai décidé de créer mon propre jeu de rôle. Pour ce faire, j'ai suivi des tutoriels de programmation afin d'apprendre le C, puis j'ai assemblé un utilitaire minimaliste en ligne de commande qui permettait de préparer certaines phrases et de résoudre certaines actions. Autour de ce moteur de jeu, j'ai également crée un univers, auquel j'ai donné le nom de la communauté internet à laquelle le jeu était destiné, NoBleme. C'est ainsi que le NoBlemeRPG est né.
        </p>

        <p>
          Au fur et à mesure que j'ai appris à programmer de façon professionelle, le programme d'administration du NoBlemeRPG a évolué en complexité. À la première version minimaliste de 2006 du jeu succède une seconde version en 2007, possédant une interface graphique permettant de réduire au maximum les délais entre les actions et réactions lors des sessions de jeu. En 2009 sort la version finale du NoBlemeRPG, rendant l'interface graphique du jeu extrêmement complexe mais permettant de donner une liberté d'action infinie aux joueurs et de faire aller les sessions de jeu dans n'importe quelle direction créative sans devoir à chaque fois préalablement modifier le code source du jeu.
        </p>

        <p>
          Après 9 ans de bons et loyaux services intermittents, le NoBlemeRPG a pris sa retraite définitive en 2015, tout simplement par manque de temps pour organiser des sessions de jeu.
        </p>

        <br>

        <p>
          Voici des captures d'écran de certaines parties centrales de l'interface locale de maître du donjon du NoBlemeRPG telle qu'elle était en 2011, dans toute sa complexité.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_main.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_perso.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_aptitude.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_item.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_monstre.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_search.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_session.png" alt="NoBlemeRPG"><br>
        <br>
        <br>

      </div>




      <?php } else if(isset($_GET['portfolio']) && $lang == 'EN') { ?>

      <br>
      <br>
      <br>
      <hr>
      <br>
      <br>

      <div class="texte" id="portfolio">

        <br>
        <br>

        <h1>Portfolio</h1>
        <h5>Examples of personal projects</h5>

        <p>
          Out of respect for my current and former employers, I will not showcase any professional projects in this portfolio. Instead, I will illustrate my skills through personal projects (and one project for commercial use).<br>
          <br>
          Since I mostly develop for myself and/or french communities, the content in most screenshots will be in french. I am however fluent in english, and have worked on many professional english projects.
        </p>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="nobleme">

        <h5 class="alinea">NoBleme.com: Website and community since 2005</h5>
        <span class="alinea">PHP - MySQL - JavaScript - Fully open sourced</span>

        <p>
          After taking the time required to learn web development and UNIX server administration, I opened my first website, <a class="gras" href="http://nobleme.com">NoBleme.com</a> in March 2005.<br>
          <br>
          Originally, NoBleme was meant to be a video streaming platform for content made by a friend who was studying movie making. The technological challenge was huge back in the day, as free streaming websites (such as YouTube) weren't a common thing yet.<br>
          <br>
          Time passed, and an internet community appeared on NoBleme. The video streaming part quickly disappeared (too ressource intensive for the server), and NoBleme became a general purpose website centered on its community, which regularly organized <a class="gras" href="<?=$path?>pages/irl/index">real life meetups</a>.
        </p>

        <p>
          NoBleme's source code is entirely free and open source, published under a permissive license that lets you reuse parts of it if you desire. It is publicly available on GitHub: <a class="gras" href="https://github.com/EricBisceglia/NoBleme.com">NoBleme.com's source code</a><br>
        </p>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="steeldb">

        <h5 class="alinea">SteelDB: Translation software for the heavy steel industry</h5>
        <span class="alinea">Perl - FileMaker - AppleScript - Developped from 2010 until 2011</span>

        <p>
          SteelDB is the internal name of a commercial project which I developed in 2010 and maintained throughout 2011. SteelDB is an internal software made to deal with a specific situation: A company using a fully Mac OSX environment, wanting to use the (very limited) Filemaker software for their internal tool.<br>
          <br>
          Being at the time one of the very few developers in Paris who had experience with Filemaker, OSX, and the steel industry, I decided to try my luck. On my free time, I assembled a prototype using system hooks in AppleScript that allowed the use of Perl scripts in order to bypass Filemaker's technical limitations. Several things that were impossible to do within Filemaker at the time (sending an e-mail, generating a PDF file, etc.) became possible thanks to those system hooks.<br>
          <br>
          SteelDB is a multi purpose tool capable of handling the following things:<br>
          - An address books for clients, suppliers, and other contacts<br>
          - A list of steelworks components stored bilingually (french/english)<br>
          - A complex tracking tool that allows to manage a sale from the price quotation to the post-sale delivery<br>
          - A translation system which allows communication between companies without the need for a translator<br>
          - Other tools specific to the company which I will not talk about out of respect for their business
        </p>

        <br>

        <p>
          Below are screenshots of the development process of SteelDB, heavily censored of all the business related data. Development started with the conception of the database, continued with management of sales and quotations, and finished with the use of the system hooks for PDF exports and automated e-mails.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_struct1.png" alt="SteelDB"><br>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_struct2.png" alt="SteelDB"><br>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_struct3.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_dossier.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_ddp.png" alt="SteelDB"><br>
        <img src="<?=$path?>img/portfolio/steeldb_ddp_details.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_entreprise.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_hotel.png" alt="SteelDB"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/steeldb_pdf.png" alt="SteelDB"><br>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="dix">

        <h5 class="alinea">Starcraft Dix: Generating statistics from .MPQ files</h5>
        <span class="alinea">C - Bash - PHP - MySQL - JavaScript - Developed from 2011 until 2012</span>

        <p>
          Back in 2011, I played <a class="gras" href="https://en.wikipedia.org/wiki/StarCraft_II:_Wings_of_Liberty">Starcraft II</a> competitively. At the time, the game did not offer any statistics on our long term performances. As I wanted to improve as a player, I decided to come up with my own statistics tool in order to know which areas of my game I needed to work on in order to climb the game's ranks.
        </p>

        <p>
          At the end of every Starcraft II game, an option allowed for automated generation of a .MPQ file containing the replay of the game. The <a class="gras" href="https://en.wikipedia.org/wiki/MPQ">MPQ format</a> is sadly proprietary, but other curious developers had managed to extract data from .MPQ files in the past. Using their knowledge, I created my own C script which allowed me to extract game data from Starcraft II replays.
        </p>

        <p>
          Now that I had a tool to transform replays into statistics, I needed to turn that raw data into something useful. I started by deploying a Bash script which automatically imported replay data into a MySQL database, then ran a PHP + JavaScript interface on my local network which displayed statistics calculated from the replay data.
        </p>

        <br>

        <p>
          Below are a few screenshots of the interface I used on my local network. I maintained Starcraft Dix until 2012, when a native statistics tool was finally introduced into Starcraft II.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/dix_tableau.png" alt="Starcraft Dix"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/dix_stats.png" alt="Starcraft Dix"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/dix_search.png" alt="Starcraft Dix"><br>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="nrm">

        <h5 class="alinea">NRM Online: Browser based multiplayer strategy game</h5>
        <span class="alinea">PHP - MySQL - JavaScript - Developed from 2006 until 2009</span>

        <p>
          The early 2000s on the internet were characterized by the browser game fad. Right at the peak of this fad, a game named Super Robot Wars Online captured the attention of a few hundred players, until it died when its developer ran out of free time to maintain the game. Being one of those players myself, I decided to create a similarly themed browser game in order to give a new game to disappointed players who wanted to keep playing something that felt like Super Robot Wars Online.
        </p>

        <p>
          The NRM Online (NoBleme Robot Mayhem Online) opened in 2006, and was actively maintained until 2009. During its whole existence, the game remained free to play. In the NRM Online, each user played as the pilot of a combat robot, and had to use a complex strategy system to win fights against other players
        </p>

        <p>
          During its 4 years of existence, I continuously introduced new concepts into the game. These constant changes ended up frustrating the player base and caused the slow death of the game, but also allowed me to learn a lot of useful lessions in game design, and instilled the passion of being a developer into me.
        </p>

        <br>

        <p>
          Below are screenshots from the 27th season of the NRM Online, in 2007. Remember that back in the day, website design used to be... very different.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_index.png" alt="NRM Online"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_robot.png" alt="NRM Online"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_assign.png" alt="NRM Online"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nrm_combat.png" alt="NRM Online"><br>

        <br>
        <br>
        <br>
        <br>
        <hr>
        <br id="nbrpg">

        <h5 class="alinea">NoBlemeRPG: IRC based multiplayer role playing game</h5>
        <span class="alinea">C - MySQL - Bash - IRC - Developed intermittently from 2006 until 2015</span>

        <p>
          Back when I was a teenager, I used to spend a lot of my week-ends hosting games of <a class="gras" href="https://en.wikipedia.org/wiki/Dungeons_and_Dragons">Dungeons &amp; Dragons</a> and other <a class="gras" href="https://en.wikipedia.org/wiki/Role-playing_game">tabletop RPGs</a>. I took a lot of pleasure in being the dungeon master, creating new imaginary worlds and hopefully riveting storylines for my players
        </p>

        <p>
          Time passed, and life changed. I started working on week-ends, some friends moved away, and hosting game sessions became increasingly impossible. Luckily, the internet was starting to spread, and allowed us to continue playing our role playing games through <a class="gras" href="<?=$path?>pages/irc/index">IRC chat</a>.
        </p>

        <p>
          Obviously, playing through internet chat is not the same as playing in real life. It is harder to communicate emotions, actions have a longer reaction time, and there is a lot of dead time to deal with caused by the slowness of typing on a keyboard (compared to speaking).
        </p>

        <p>
          In order to adapt to this new paradigm, I decided to create my own role playing game. I learned C programming by reading tutorials online, and developed a minimalistic command line interface which allowed me to prepare some phrases and react to some actions without wasting too much time. Around this game engine, I created an universe for the game. Since the game was meant to be played with people from the NoBleme community, I called it the NoBleme Role Playing Game. And thus, the NoBlemeRPG was born.
        </p>

        <p>
          As years passed and I became a professional developer, I used my newly learned skills to improve the NoBlemeRPG's dungeon master interface. The first minimalistic version from 2006 was replaced by a more complex version in 2007, with an actual graphic interface, allowing for even more control on the game and faster reaction times. The final version was released in 2009, turning the graphical interface into an extremely complicated mess that allowed me to give infinite freedom of action to my players, thus removing the need to develop new features before every session in preparation of what players would be doing.
        </p>

        <p>
          After 9 years of use, the NoBlemeRPG was retired for good in 2015, simply due to lack of free time.
        </p>

        <br>

        <p>
          Below are screenshots of a few panels of the NoBlemeRPG's dungeon master interface as it looked like in 2011, in all its complexity.
        </p>

        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_main.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_perso.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_aptitude.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_item.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_monstre.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_search.png" alt="NoBlemeRPG"><br>
        <br>
        <hr>
        <br>
        <img src="<?=$path?>img/portfolio/nbrpg_session.png" alt="NoBlemeRPG"><br>
        <br>
        <br>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';