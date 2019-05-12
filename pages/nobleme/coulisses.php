<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Coulisses';

// Identification
$page_nom = "Zyeute les coulisses de NoBleme";
$page_url = "pages/nobleme/coulisses";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Coulisses" : "Behind the scenes";
$page_desc  = "Un regard à travers la facade du site, droit dans les entrailles de NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if($lang == 'FR') { ?>

      <div class="texte">

        <h1>Coulisses de NoBleme</h1>

        <h5>Une plongée publique dans les entrailles du site</h5>

        <p>
          Depuis le <a class="gras" href="<?=$chemin?>pages/doc/nobleme">redesign de NoBleme en 2012</a>, j'ai décidé de rendre le développement de NoBleme aussi transparent que possible. Pour ce faire, j'ai rendu publics les plans de développement du site via la <a class="gras" href="<?=$chemin?>pages/todo/index">liste des tâches</a> et son <a class="gras" href="<?=$chemin?>pages/todo/roadmap">plan de route</a>, tout en proposant aux utilisateurs de soumettre leurs idées en <a class="gras" href="<?=$chemin?>pages/todo/request">ouvrant un ticket</a>. En parallèle, je discute de sujets touchant parfois au développement du site sur le <a class="gras" href="<?=$chemin?>pages/devblog/index">blog de développement</a>. Pour accompagner tout ça, j'ai également rendu public l'intégralité du code source du site.
        </p>

        <p>
          En complément de cette politique d'ouverture, j'ai crée les coulisses de NoBleme - la page que vous lisez en ce moment même - afin de discuter des raisons pour lesquelles j'ai choisi de rendre transparent le développement de NoBleme, pour expliciter mes convictions en tant que développeur, pour parler des technologies qui font fonctionner NoBleme, et pour partager avec vous le code source du site.
        </p>

        <br>
        <br id="source">
        <br>

        <h5>Code source de NoBleme</h5>

        <p>
          Le code source de NoBleme est hébergé dans un dépôt public sur Bitbucket :
        </p>

        <br>

        <button class="button button-outline" onclick="var sourcecode = window.open('https://bitbucket.org/EricBisceglia/nobleme.com/src/', '_blank'); sourcecode.focus;">VOIR LE CODE SOURCE DE NOBLEME</button>

        <p>
          Par désir de transparence, l'intégralité du code source de NoBleme est open sourcé : Si vous vous avez des connaissances en développement et que vous vous demandez comment un aspect de NoBleme est géré, vous pouvez trouver la réponse à vos questions dans la source publique du site.
        </p>

        <p>
          Le code source de NoBleme utilise une licence très permissive (<a class="gras" href="https://fr.wikipedia.org/wiki/Licence_MIT">MIT license</a>). Cela signifie que vous êtes libres de réutiliser des bouts du code source de NoBleme pour vos projets personnels ou professionels sans me demander ma permission si vous en avez envie, tant que vous me créditez et que vous incluez une copie de la (courte) licence de NoBleme dans chaque fichier contenant du code réutilisé.
        </p>

        <p>
          La source du site est très vieille (le site est dévelopé en continu depuis 2005), et utilise par choix des technologies qui ne sont pas très modernes (PHP procédural sans framework, javascript sans framework, MySQL), mais elle est tout de même modernisée régulièrement afin de rester en concordance technologique avec son temps.
        </p>

        <p>
          L'intégralité du code source est commenté de façon exhaustive, et les commentaires sont faits pour être aussi explicites que possible. Ainsi, même si vous ne maitrisez pas totalement les langages de programmation utilisés, vous devriez quand même pouvoir suivre la logique du code sur n'importe quelle page.
        </p>

        <p>
          Le choix de Bitucket pour héberger la source est technologique : Le dépôt de NoBleme est versionné avec <a class="gras" href="https://fr.wikipedia.org/wiki/Mercurial">Mercurial</a> plutôt que git (préférence personnelle), ce qui exclut d'utiliser des sites comme Github qui ne gèrent pas Mercurial. Au moment de la création du dépôt, parmi les sites gratuits qui géraient Mercurial, Bitbucket avait la meilleure infrastructure et le plus de fonctionnalités utiles. Le choix était donc logique.
        </p>

        <br>
        <br>

        <h5>Contribuer au code source de NoBleme</h5>

        <p>
          Lorsque je travaille seul sur un projet, ma méthode de développement est très pointilleuse et perfectionniste. Par conséquent, je préfère refuser toutes les contributions à NoBleme, car je risque de toutes les rejeter.
        </p>

        <p>
          Si vous avez repéré un problème dans le code source de NoBleme ou que vous avez des ajouts constructifs à y faire, vous pouvez <a class="gras" href="<?=$chemin?>pages/todo/request?bug">ouvrir un ticket</a> et/ou venir en discuter <a class="gras" href="<?=$chemin?>pages/irc/index">sur IRC</a>. Même si je rejette les contributions directes, ce type de contributions indirectes est toujours très fortement apprécié.
        </p>

        <br>
        <br>
        <br>

        <h5>Les convictions qui s'appliquent au développement de NoBleme</h5>

        <p>
          <span class="gras">Gratuit et sans publicités</span> : De mon point de vue, Internet est un merveilleux milieu d'expression libre, qui est gâché à beaucoup d'endroits par l'aspect financier. Il est compréhensible qu'un site à grande échelle a besoin de financement pour vivre, mais il est inexcusable qu'un petit site ruine l'expérience de ses utilisateurs pour gagner au mieux deux ou trois dollars par mois les bons mois. Quand j'ai lancé NoBleme, j'ai assumé la responsabilité du financement, et il est pour moi crucial que le site reste gratuit, sans publicité, sans sponsoring, sans intérêts tiers. Je n'accepte pas les donations. Contentez-vous de profiter.
        </p>

        <p>
          <span class="gras">Aucune conservation des données personnelles</span> : À l'inscription, je ne vous demande qu'un pseudonyme, un mot de passe (bien entendu chiffré de façon à ce que je ne puisse pas le voir), et un e-mail. Je ne vérifie même pas l'authenticité de l'adresse e-mail, elle sert seulement d'outil de secours si jamais vous perdez votre mot de passe. À part ça, la seule donnée que je collecte sur les utilisateurs sont la dernière <a class="gras" href="https://fr.wikipedia.org/wiki/Adresse_IP">adresse IP</a> dont ils se sont servis. De votre côté, un <a class="gras" href="https://fr.wikipedia.org/wiki/Cookie_(informatique)">cookie</a> est stocké dans votre navigateur si jamais vous désirez rester connecté à votre compte entre vos visites, et un second cookie sert à retenir d'une visite à l'autre la langue que vous utilisez (pour nos amis anglophones). C'est tout. Si vous avez le moindre doute, n'oubliez pas que le code source de NoBleme est <a class="gras" href="#source">public</a>, vous pouvez aller vérifier par vous-mêmes.
        </p>

        <p>
          <span class="gras">Une transparence pédagogique</span> : J'ai toujours abordé le développement avec une vision pédagogique. À mes yeux, le rôle d'un développeur est non seulement de développer, mais aussi de transmettre ses compétences. Les métiers des sciences informatiques demandent une telle quantité de connaissances qu'une personne seule ne pourra jamais s'approcher d'une maitrise globale du sujet. Ainsi, plus il y a de développeurs qui partagent activement leur savoir, plus le niveau collectif des développeurs augmente. C'est en grande partie pour cela que le processus de développement de NoBleme est transparent et que le code source est public. Par ailleurs, le <a class="gras" href="<?=$chemin?>pages/irc/canaux">canal #dev</a> du <a class="gras" href="<?=$chemin?>pages/irc/index">serveur IRC NoBleme</a> est un lieu de partage de connaissances permanent entre informaticiens, qui est ouvert à tous, des débutants aux confirmés.
        </p>

        <p>
          <span class="gras">Un effort de compatibilité</span> : Toutes les pages du site sont passées au <a class="gras" href="https://validator.w3.org/">validateur W3C</a> et testées avec les principaux navigateurs ainsi que sur mobile et tablette. Plutôt que de devoir adapter vos outils à NoBleme, c'est NoBleme qui doit s'adapter aux outils que vous utilisez pour naviguer sur le site.
        </p>

        <br>
        <br>
        <br>

        <h5>L'infrastructure technologique de NoBleme</h5>

        <p>
          Si jamais ça peut assouvir la curiosité de quelques personnes, voici une liste plutôt exhaustive des applications, services et technologies qui sont utilisées dans le développement de NoBleme :
        </p>

        <br>

        <ul>
          <li>
            Le nom de domaine (<a class="gras" href="https://reports.internic.net/cgi/whois?whois_nic=nobleme.com&type=domain">nobleme.com</a>) est hébergé depuis 2005 chez <a class="gras" href="https://www.phpnet.org/">PHPNet</a>
          </li>
          <li>
            Le serveur est un <a class="gras" href="https://www.kimsufi.com/fr/">kimsufi</a> hébergé depuis 2012 chez <a class="gras" href="https://www.ovh.com/fr/">OVH</a>
          </li>
          <li>
            Le système d'exploitation du serveur est <a class="gras" href="https://fr.wikipedia.org/wiki/Debian">Debian GNU/Linux</a>
          </li>
          <li>
            Le <a class="gras" href="<?=$chemin?>pages/irc/index">serveur IRC</a> est une version personnalisée de <a class="gras" href="https://fr.wikipedia.org/wiki/UnrealIRCd">UnrealIRCd</a> utilisant les services <a class="gras" href="https://www.anope.org/">Anope</a>
          </li>
          <li>
            Le <a class="gras" href="https://fr.wikipedia.org/wiki/Serveur_HTTP">serveur HTTP</a> qui délivre le contenu web du site est <a class="gras" href="https://fr.wikipedia.org/wiki/Apache_HTTP_Server">Apache HTTP Server</a>
          </li>
          <li>
            La <a class="gras" href="https://fr.wikipedia.org/wiki/Base_de_donn%C3%A9es">base de données</a> du site est une base <a class="gras" href="https://fr.wikipedia.org/wiki/MySQL">MySQL</a>
          </li>
          <li>
            Le <a class="gras" href="https://fr.wikipedia.org/wiki/Backend">back-end</a> du site est entièrement codé en <a class="gras" href="https://fr.wikipedia.org/wiki/PHP">PHP</a>
          </li>
          <li>
            Le <a class="gras" href="https://fr.wikipedia.org/wiki/Frontal_(serveur)">front-end</a> du site est en <a class="gras" href="https://fr.wikipedia.org/wiki/HTML">HTML</a>, stylé en <a class="gras" href="https://fr.wikipedia.org/wiki/Feuilles_de_style_en_cascade">CSS</a>, et dynamisé avec du <a class="gras" href="https://fr.wikipedia.org/wiki/JavaScript">JavaScript</a>
          </li>
          <li>
            Certaines des images utilisées sur le site proviennent de <a class="gras" href="https://feathericons.com/">Feather</a>
          </li>
          <li>
            De mon côté, je développe sous <a class="gras" href="https://fr.wikipedia.org/wiki/Microsoft_Windows">Microsoft Windows</a> (eh ouais, même pas honte)
          </li>
          <li>
            L'environnement de NoBleme est émulé sur ma machine à l'aide de <a class="gras" href="http://www.wampserver.com/">WampServer</a>
          </li>
          <li>
            Dans mon espace de développement local, je me sers parfois de <a class="gras" href="https://www.phpmyadmin.net/">PHPMyAdmin</a> et <a class="gras" href="http://www.ozerov.de/bigdump/">BigDump</a>
          </li>
          <li>
            J'écris le code source de NoBleme avec l'éditeur de texte <a class="gras" href="https://www.sublimetext.com/">Sublime Text</a>
          </li>
          <li>
            J'administre le serveur en utilisant les <a class="gras" href="https://fr.wikipedia.org/wiki/Secure_Shell">clients SSH</a> <a class="gras" href="http://www.putty.org/">Putty</a> et <a class="gras" href="https://mobaxterm.mobatek.net/">MobaXterm</a>
          </li>
          <li>
            Je me sers de temps en temps de <a class="gras" href="https://winscp.net/eng/docs/lang:fr">WinSCP</a> pour transmettre des fichiers
          </li>
          <li>
           Le <a class="gras" href="https://fr.wikipedia.org/wiki/Logiciel_de_gestion_de_versions">versionnage</a> se fait dans un dépôt <a class="gras" href="https://fr.wikipedia.org/wiki/Mercurial">Mercurial</a> que je gère via <a class="gras" href="https://tortoisehg.bitbucket.io/">TortoiseHg</a>
          </li>
        </ul>

      </div>




      <?php } else { ?>

      <div class="texte">

        <h1>Behind the scenes</h1>

        <h5>A public deep dive into the website's guts</h5>

        <p>
         Ever since a 2012 redesign of the website, I made NoBleme's development process as transparent as possible. Sadly, most of the pages that discuss the development process are only available in french (I write a lot of content detailing what I do and translating it to english wouldn't be a justifiable time investment).
        </p>

        <p>
          What you get to see in english is this page on which I share NoBleme's source code, discuss the convictions I hold when developing, and share the technological stack I use to develop and manage the website.
        </p>

        <br>
        <br id="source">
        <br>

        <h5>NoBleme's source code</h5>

        <p>
          NoBleme's source code is hosted on a public Bitbucket repository:
        </p>

        <br>

        <button class="button button-outline" onclick="var sourcecode = window.open('https://bitbucket.org/EricBisceglia/nobleme.com/src/', '_blank'); sourcecode.focus;">CLICK TO SEE NOBLEME'S SOURCE CODE</button>

        <p>
          NoBleme's source code was made public for transparency reasons: If you happen to be experienced in development and wonder how some of NoBleme's features work, you can find answers to your questions in this public repository.
        </p>

        <p>
          NoBleme's source code is protected by a very permissive license (<a class="gras" href="https://en.wikipedia.org/wiki/MIT_License">MIT license</a>). This means that are free to re-use some of NoBleme's source code in your personal or professional projects without asking me for permission. The only condition is to credit me by including a copy of NoBleme's (short) license wherever you re-use some of NoBleme's source code.
        </p>

        <p>
          The website's source code is rather old in places (development has been ongoing since 2005), and uses technologies that can feel antiquated (procedural PHP without any framework, raw javascript, MySQL), but still gets updated and kept up to date as the technologies it uses evolve over time.
        </p>

        <p>
          Every file in the repository is exhaustively commented, but sadly it's all in french. This might make the source code complicated to understand if you're not familiar with the languages used on the website. I am comfortable coding in both french and english, and will pick either depending on the project requirements. Since NoBleme started as a purely french website, I picked french for its documentation.
        </p>

        <p>
          The choice of Bitbucket over another website is a technological choice: NoBleme's repository uses <a class="gras" href="https://en.wikipedia.org/wiki/Mercurial">Mercurial</a> rather than git (personal preference), which prevents the use of websites that support only Git (such as Github). Out of the free version control hosting websites that supported Mercurial when I open sourced NoBleme, Bitbucket was the one with the best infrastructure and features, thus the logical choice.
        </p>

        <br>
        <br>

        <h5>Contributing to NoBleme's source</h5>

        <p>
          When I work alone on a project, I tend to code in a very pedantic and perfectionist way. This means that most direct code contributions tend to feel improper, and I end up rejecting them all.
        </p>

        <p>
          If you have found an issue in NoBleme's source code or want to do some constructive criticism, you can <a class="gras" href="<?=$chemin?>pages/todo/request?bug">make a proposal</a> and/or come talk about it <a class="gras" href="<?=$chemin?>pages/irc/index">on IRC</a>. Even though I do not accept direct contributions, this kind of indirect contribution through feedback is highly appreciated.
        </p>

        <br>
        <br>
        <br>

        <h5>My convictions when developing NoBleme</h5>

        <p>
          <span class="gras">Free to use and ad-free</span>: From my point of view, the Internet is a wonderful place of expression, which is ruined in many places by the presence of financial interests. It is understandable that a big website needs its money to thrive, but a small scale website ruining its browsing experience by constantly begging for money and adding advertisements that will earn them three dollars on a good month is unacceptable. When I launched NoBleme, I accepted the financial responsibilities that came with hosting a small website, and thus NoBleme shall forever be free and contain no advertisements whatsoever (unless it somehow becomes big and costly to maintin some day, but that's not likely). I do not accept donations. Just enjoy the service.
        </p>

        <p>
          <span class="gras">No tracking personal data</span>: When you register an account, all I ask for is a nickname, a password, and an e-mail adress. The e-mail isn't even verified, I just offer you the possibility of having one linked to you so that you can recover access to your account in case you ever forget your password. Other than that, the only personal data I temporarily keep is the latest <a class="gras" href="https://en.wikipedia.org/wiki/IP_address">IP adress</a> from which you have used the website. On your side, up to two <a class="gras" href="https://en.wikipedia.org/wiki/HTTP_cookie">cookies</a> are stored on your browser, one to store your language preference and one to keep you logged into your account if you wish to do so. If you are doubting those claims, remember that NoBleme's source code is <a class="gras" href="#source">public</a>, you can verify them.
        </p>

        <p>
          <span class="gras">An educational transparency</span>: I consider that the role of a developer is not just to write code and deploy software, but also to share his knowledge with other developers. Computer science is a huge field that simply can not be mastered by one person alone, thus it is necessary that each actor of this field shares what he learns in his domains of expertise with others who don't have the time to invest in mastering those domains. This is why I have this transparency mentality, and why I open sourced NoBleme. Additionally, we have many developers, sysadmins, and other computer science related jobs on NoBleme, with which you can interact on our <a class="gras" href="<?=$chemin?>pages/irc/index">IRC server</a>. We always enjoy interacting with others in the field on IRC, be it teaching to beginners, learning from experts, or anything in between.
        </p>

        <p>
          <span class="gras">A compatibility effort</span>: Every page on NoBleme is passed through the <a class="gras" href="https://validator.w3.org/">W3C validator</a> and tested on every major browser, aswell as on mobile and tablet. Instead of having to adapt your tools to NoBleme, it's NoBleme that should adapt itself to the tools you use to browse the website (unless they are horribly outdated, then I obviously can't guarantee anything).
        </p>

        <br>
        <br>
        <br>

        <h5>NoBleme's technological stack</h5>

        <p>
          If it can satiate a few people's curiosity, here's an exhaustive list of all applications, services, and technologies used in the process of developing and administrating NoBleme:
        </p>

        <br>

        <ul>
          <li>
            The domain name (<a class="gras" href="https://reports.internic.net/cgi/whois?whois_nic=nobleme.com&type=domain">nobleme.com</a>) is managed since 2005 by <a class="gras" href="https://www.phpnet.org/">PHPNet</a>
          </li>
          <li>
            The web server is a <a class="gras" href="https://www.kimsufi.com/uk/">kimsufi</a> hosted since 2012 by <a class="gras" href="https://www.ovh.co.uk/">OVH</a>
          </li>
          <li>
            The web server's operating system is <a class="gras" href="https://en.wikipedia.org/wiki/Debian">Debian GNU/Linux</a>
          </li>
          <li>
            The <a class="gras" href="<?=$chemin?>pages/irc/index">IRC server</a> is a customized <a class="gras" href="https://en.wikipedia.org/wiki/UnrealIRCd">UnrealIRCd</a> with some <a class="gras" href="https://www.anope.org/">Anope</a> services
          </li>
          <li>
            The <a class="gras" href="https://en.wikipedia.org/wiki/Web_server">HTTP server</a> delivering web pages is an <a class="gras" href="https://en.wikipedia.org/wiki/Apache_HTTP_Server">Apache HTTP Server</a>
          </li>
          <li>
            The website's <a class="gras" href="https://en.wikipedia.org/wiki/Database">database</a> runs on <a class="gras" href="https://en.wikipedia.org/wiki/MySQL">MySQL</a>
          </li>
          <li>
            The <a class="gras" href="https://en.wikipedia.org/wiki/Front_and_back_ends">back end</a> of the website is entirely coded in <a class="gras" href="https://en.wikipedia.org/wiki/PHP">PHP</a>
          </li>
          <li>
            The <a class="gras" href="https://en.wikipedia.org/wiki/Front_and_back_ends">front end</a> is <a class="gras" href="https://en.wikipedia.org/wiki/HTML">HTML</a>, styled using <a class="gras" href="https://en.wikipedia.org/wiki/Cascading_Style_Sheets">CSS</a>, and dynamized with <a class="gras" href="https://en.wikipedia.org/wiki/JavaScript">JavaScript</a>
          </li>
          <li>
            Some of the images used on the website come from <a class="gras" href="https://feathericons.com/">Feather</a>
          </li>
          <li>
            On my development machine, I run <a class="gras" href="https://en.wikipedia.org/wiki/Microsoft_Windows">Microsoft Windows</a> (yup, not ashamed)
          </li>
          <li>
            NoBleme's environment is locally emulated using <a class="gras" href="http://www.wampserver.com/">WampServer</a>
          </li>
          <li>
            In the development environment, I sometimes use <a class="gras" href="https://www.phpmyadmin.net/">PHPMyAdmin</a> and <a class="gras" href="http://www.ozerov.de/bigdump/">BigDump</a>
          </li>
          <li>
            I write NoBleme's source code using the text editor <a class="gras" href="https://www.sublimetext.com/">Sublime Text</a>
          </li>
          <li>
            I administrate the server using the <a class="gras" href="https://en.wikipedia.org/wiki/Secure_Shell">SSH clients</a> <a class="gras" href="http://www.putty.org/">Putty</a> and <a class="gras" href="https://mobaxterm.mobatek.net/">MobaXterm</a>
          </li>
          <li>
            I sometimes use <a class="gras" href="https://winscp.net/eng/docs/start">WinSCP</a> to transfer files and do backups
          </li>
          <li>
           <a class="gras" href="https://en.wikipedia.org/wiki/Software_versioning">Versioning</a> is done in a <a class="gras" href="https://en.wikipedia.org/wiki/Mercurial">Mercurial</a> repository which I manage using <a class="gras" href="https://tortoisehg.bitbucket.io/">TortoiseHg</a>
          </li>
        </ul>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';