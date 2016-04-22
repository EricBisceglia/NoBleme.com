<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Titre et description
$page_titre = "Coulisses de NoBleme";
$page_desc  = "Un regard à travers la facade du site, droit dans les entrailles de NoBleme";

// Identification
$page_nom = "nobleme";
$page_id  = "coulisses";



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/developpement.png" alt="Développement: Les coulisses de NoBleme">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">La face cachée de NoBleme</span><br>
      <br>
      Depuis le redesign du site en 2012, j'ai décide d'exposer le développement de NoBleme, de le rendre aussi transparent que possible.<br>
      <br>
      La section développement permet les actions suivantes :<br>
      <br>
      <ul class="dotlist">
        <li class="spaced">
          Suivre via le <a class="dark blank gras" href="<?=$chemin?>pages/todo/roadmap">plan de route</a> et la <a class="dark blank gras" href="<?=$chemin?>pages/todo/index">liste des tâches</a> l'évolution passée, présente et future du développement de NoBleme
        </li>
        <li class="spaced">
          Permettre aux utilisateurs de proposer leurs idées de nouvelles fonctionnalités ou de rapporter des bugs en <a class="dark blank gras" href="<?=$chemin?>pages/todo/add">ouvrant un ticket</a>
        </li>
        <li class="spaced">
          Découvrir grâce au <a class="dark blank gras" href="<?=$chemin?>pages/devblog/index">blog de développement</a> les dessous du développement de NoBleme et du monde de l'informatique en général
        </li>
        <li class="spaced">
          Ou carrément aller consulter le <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/coulisses#source">code source de NoBleme</a>, qui est open sourcé et librement mis à la disposition du public.
        </li>
      </ul>
    </div>

    <br>

    <div class="body_main midsize">
      <span class="soustitre">Les convictions qui s'appliquent au développement de NoBleme</span><br>
      <br>
      <ul class="dotlist">
        <li>
          <span class="gras">Gratuit, sans publicités, sans quêtes :</span> Internet est un milieu d'expression qui est, à mon goût, complètement gâché par les intérêts financiers des gens. <a class="dark blank gras" href="http://www.google.com">Certains</a> les cachent derrière une pseudo-gratuité, et en profitent pour collecter des informations sur les gens qu'ils revendent à des publicitaires, ou se servent de la gratuité d'un site pour attirer les gens vers un autre site payant. <a class="dark blank gras" href="http://www.twitch.tv">D'autres</a> se servent d'un site comme prétexte pour gagner leur pain au dépens des utilisateurs, en y insérant des publicités qui peuvent parfois gâcher l'expérience de la navigation alors même qu'elles ne rapportent que très peu d'argent. Et enfin, il y a ceux (moins critiquables que les autres) qui se lancent dans un projet qu'ils ne peuvent pas assumer, et réclament des donations pour garder leur projet en vie. Sur NoBleme, rien de tout ça. Le site est entièrement assumé. Vous n'aurez rien à payer, rien à supporter, rien à donner, aucune publicité à subir. Je n'accepte pas les donations. Contentez-vous de profiter.
        </li>
      </ul>
      <br>
      <ul class="dotlist">
        <li>
          <span class="gras">Aucun traquage des données personnelles :</span> A l'inscription, vous n'avez qu'à rentrer un pseudonyme, un mot de passe, et optionnellement un e-mail. L'authenticité de votre e-mail n'est même pas vérifiée, sa seule utilité est d'avoir un moyen de prouver qu'il s'agit vraiment de vous si vous venez me dire que vous avez perdu votre mot de passe. Les seules données que je conserve sur les utilisateurs sont la dernière adresse IP dont ils se sont servis (pour des raisons de sécurité, et je ne garde que la toute dernière), et un <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Cookie_(informatique)">cookie</a> qui reste automatiquement stocké dans votre navigateur si vous avez coché la case « se souvenir de moi » à la connexion (comme son nom l'indique, pour se souvenir que vous êtes connecté). Je ne garde rien permettant de vous identifier personellement, et j'encrypte toutes les données personnelles, ce qui fait que je ne peux pas les voir moi-même. Cela signifie que si NoBleme vient à être hacké, sait-on jamais, les données qui seront récupérées sur les utilisateurs seront majoritairement inutilisables par les hackeurs et/ou publicitaires. Vous pouvez vérifier la véracité de mes propos en allant directement consulter <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/coulisses#source">le code source de NoBleme</a>.
        </li>
      </ul>
      <br>
      <ul class="dotlist">
        <li>
          <span class="gras">Une transparence totale et un partage éducatif :</span> L'intégralité du code source de NoBleme.com est open sourcé, vous pouvez allez le consulter <a class="dark blank gras" href="<?=$chemin?>pages/nobleme/coulisses#source">en bas de la page</a>. De plus, le code est open sourcé via une licence permissive (<a class="dark blank gras" href="https://fr.wikipedia.org/wiki/Licence%20MIT">MIT license</a>), ce qui signifie que vous pouvez réutiliser une partie ou l'intégralité du code source de NoBleme, tant que vous conservez la même licence. Ainsi, ce n'est pas seulement par souci de transparence que la source de NoBleme est libre et publique, mais aussi pour des raisons éducatives&nbsp;: si vous vous demandez comment certains features de NoBleme fonctionnent, vous n'avez qu'à aller consulter le code source. Et si vous aimez la méthode que j'utilise, rien ne vous empêche de réutiliser mon code.
        </li>
      </ul>
      <br>
      <ul class="dotlist">
        <li>
          <span class="gras">Des alternatives au JavaScript :</span> Le <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/JavaScript">JavaScript</a> a ses avantages, mais je respecte ceux qui font le choix d'utiliser <a class="dark blank gras" href="http://noscript.net/">NoScript</a>, ou de <a class="dark blank gras" href="https://fr.wikipedia.org/wiki/Cross-site_scripting">bloquer complètement le JavaScript</a>. J'utilise moi-même NoScript, et regrette le peu d'effort que font la plupart des sites pour les utilisateurs faisant ce choix. C'est pour cela que les pages utilisant du JavaScript auront dans la mesure du possible également une alternative pour ceux qui n'en disposent pas, ou au moins un message leur indiquant qu'ils ne peuvent pas se servir de la fonctionnalité de par leur absence de JavaScript. Par exemple, le menu déroulant situé en haut de chaque page est entièrement réalisé en <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/CSS">CSS</a>, ce qui a demandé plus de temps de travail (un investissement temporel qui est selon moi justifié).
        </li>
      </ul>
      <br>
      <ul class="dotlist">
        <li>
          <span class="gras">Un effort de compatibilité :</span> Le bon fonctionnement du site est testé sur tous les navigateurs ayant au moins <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Parts_de_march%C3%A9_des_navigateurs_web">1% de part de marché</a>. Je préfère laisser les utilisateurs choisir leur navigateur plutôt que de leur imposer un changement lorsque mon site ne peut plus les assumer. De plus, toutes les pages du site sont validées via le <a class="dark blank gras" href="http://validator.w3.org/check?uri=http%3A%2F%2Fwww.nobleme.com">validateur du W3C</a>, assurant que tout navigateur qui respecte les <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/W3C#Standards_du_W3C">standards du W3C</a> puisse se servir du site sans encombre.
        </li>
      </ul>
    </div>

    <br>

    <div class="body_main midsize">
      <span class="soustitre">La logistique du développement de NoBleme</span><br>
      <br>
      <ul class="dotlist">
        <li>
          Un nom de domaine (<a class="dark blank gras" href="http://reports.internic.net/cgi/whois?whois_nic=nobleme.com&amp;type=domain">nobleme.com</a>) hébergé chez <a class="dark blank gras" href="http://www.phpnet.org/">PHPnet</a>
        </li>
        <li>
          Un serveur utilisant <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Debian">Debian Linux</a> hébergé chez <a class="dark blank gras" href="http://www.ovh.fr/">OVH</a>
        </li>
        <li>
          Un serveur IRC utilisant une version personnalisée du daemon <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/UnrealIRCd">UnrealIRCd</a> et les <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Services_IRC">services</a> Anope
        </li>
        <li>
          Un serveur HTTP <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Apache_HTTP_Server">Apache</a>
        </li>
        <li>
          Un site codé majoritairement en <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/PHP">PHP</a> puis rendu en <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/HTML">HTML</a>
        </li>
        <li>
          Une base de données <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/MySQL">MySQL</a> avec laquelle le PHP intéragit via des requêtes
        </li>
        <li>
          Du <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/CSS">CSS</a> pour régir l'apparence du HTML rendu par le PHP
        </li>
        <li>
          Du <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/JavaScript">JavaScript</a> pour conférér des fonctionnalités dynamiques à certaines pages
        </li>
        <li>
          Le site est développé depuis mon ordinateur opérant sous <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Windows">Microsoft Windows</a> et contenant des machines virtuelles <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/FreeBSD">FreeBSD</a>
        </li>
        <li>
          Un espace de développement local sur mon ordinateur, nativement sous FreeBSD et à l'aide de <a class="dark blank gras" href="http://www.wampserver.com/">WampServer</a> sous Windows
        </li>
        <li>
          Le code source du site est écrit avec l'éditeur <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Emacs">Emacs</a> sous FreeBSD et <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Sublime_Text">Sublime Text</a> sous Windows
        </li>
        <li>
          Les graphismes sont tous réalisés sous <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/MS_Paint">Microsoft Paint</a> (même pas honte)
        </li>
        <li>
          La maintenance du serveur est effectuée en ligne de commande depuis FreeBSD, et parfois via <a class="dark blank gras" href="http://mobaxterm.mobatek.net/">MobaXterm</a> sous Windows
        </li>
        <li>
          Les modifications sont traquées et publiées à l'aide du logiciel de gestion de versions <a class="dark blank gras" href="http://fr.wikipedia.org/wiki/Mercurial">Mercurial</a>
        </li>
        <li>
          Le dépôt mercurial sur lequel les modifications sont traquées est hébergé sur <a class="dark blank gras" href="http://bitbucket.org">BitBucket</a>
        </li>
      </ul>
    </div>

    <br>
    <br>

    <div class="body_main midsize" id="source">
      <span class="titre">Code source de NoBleme</span><br>
      <br>
      Le code source de NoBleme est hébergé dans un dépôt public sur Bitbucket : <a class="dark blank gras" href="https://bitbucket.org/EricBisceglia/nobleme.com/src/">cliquez ici pour accéder au code source de NoBleme</a>.<br>
      <br>
      Par souci de transparence, l'intégralité code source de NoBleme.com est open sourcé : Si vous avez des connaissances en développement informatique et que vous demandez comment vos données sont traitées, quelles données sont conservées, qu'est-ce qui est ou n'est pas encrypté, ce que peuvent voir et faire les administrateurs, etc., vous pouvez aller le vérifier à la source par vous-même.<br>
      <br>
      Même si la codebase est très vieille (première itération en 2005) et utilise des technologies datées (cœur entièrement en PHP procédural), la source est faite pour être lisible et aérée : Tous les fichiers sont largement commentés, le PHP et le HTML sont séparés autant que possible, et les sections de chaque fichier sont séparés par des gros blocs de commentaires. L'objectif est que quelqu'un ayant des connaissances basiques en programmation puisse facilement lire n'importe quel fichier du code source de NoBleme sans avoir besoin d'explications extérieures pour le comprendre.<br>
      <br>
      Notons que la source est sous <a class="dark blank gras" href="https://fr.wikipedia.org/wiki/Licence%20MIT">licence MIT</a>, c'est à dire que vous êtes libres de réutiliser une partie ou l'intégralité du code source de NoBleme pour vos projets personnels, à condition de conserver la licence. Ce choix de licence correspond à mes convictions : Tout code source non commercial est fait pour être partagé, afin d'éduquer les débutants dans le métier et d'aider les développeurs qui pourraient gagner du temps ou trouver des idées dans le code source des autres.<br>
      <br>
      <br>
      <span class="soustitre">Contribuer au code source de NoBleme</span><br>
      <br>
      Je n'accepte pas les contributions au code source de NoBleme : Si vous proposez une pull request dans le dépôt public, elle sera refusée. Je tiens à travailler seul dessus, afin d'avoir le contrôle total sur ce que je fais. L'investissement temporel est conséquent, mais j'en assume la responsabilité. Cette méthode de travail en solitaire fonctionne confortablement pour moi depuis 2005, et je ne tiens pas à la changer.<br>
      <br>
      Si vous trouvez un problème et voulez proposer une solution, ou si vous avez des propositions d'amélioration, <a class="dark blank gras" href="<?=$chemin?>pages/todo/add">ouvrez un ticket</a> ou venez en discuter sur le <a class="dark blank gras" href="<?=$chemin?>pages/irc/canaux">canal #dev</a> du <a class="dark blank gras" href="<?=$chemin?>pages/irc/">serveur IRC NoBleme</a>, et ce sera avec plaisir que je discuterai de votre bug report ou de votre idée.
    </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';