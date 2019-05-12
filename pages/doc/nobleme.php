<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'QuEstCeQueNoBleme';

// Identification
$page_nom = "Se demande ce qu'est NoBleme";
$page_url = "pages/doc/nobleme";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Qu'est-ce que NoBleme" : "What is NoBleme";
$page_desc  = "Qu'est-ce que NoBleme ? Histoire du site, en résumé et en plus long";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if($lang == 'FR') { ?>

      <div class="texte">

        <h1 class="alinea">Qu'est-ce que NoBleme ?</h1>

        <p>
          NoBleme est un site internet francophone qui existe en continu depuis 2005. Sans thème central, c'est un lieu de discussion ouverte. À l'origine, NoBleme était un forum de discussion, puis a évolué au fil des années et du développement de liens sociaux jusqu'à devenir une communauté internet.
        </p>

        <p>
          Pour mieux comprendre ce qu'est NoBleme, il faut commencer par comprendre son histoire. Elle a lieu en plusieurs actes, que je vais vous conter. Une fois que j'aurai fini de vous parler du passé, on pourra se tourner vers le présent et l'avenir, et se poser ensemble des questions existentielles : À quoi sert NoBleme ? Quel est l'avenir de NoBleme ? Est-il trop tard pour faire partie de NoBleme ?
        </p>

        <br>
        <br>
        <br>

        <h3>L'histoire de NoBleme</h3>

        <br>

        <h5>Acte I : Avant NoBleme (2000-2005)</h5>

        <p>
          Remontons dans le temps jusqu'à l'âge sombre d'internet. Nous sommes au début des années 2000, peu de français ont internet à domicile. Un lieu toutefois permet à tous d'accéder à internet : les cyber cafés. Dans ces boutiques, les gens vont payer pour jouer à des jeux vidéos, et certains de ces jeux requièrent internet pour accéder à leur contenu multijoueur. Parmi ces gamers de la première heure, le futur administrateur de NoBleme, <a class="gras" href="<?=$chemin?>pages/user/user?id=1">Bad</a>, fait du commerce de <a class="gras" href="https://fr.wikipedia.org/wiki/Magic_:_L%27Assembl%C3%A9e">cartes Magic</a> dans son collège, et se sert des bénéfices pour aller jouer à <a class="gras" href="https://fr.wikipedia.org/wiki/Quake_III_Arena">Quake</a> et <a class="gras" href="https://fr.wikipedia.org/wiki/StarCraft:_Brood_War">StarCraft</a> au cyber café du coin. Pour jouer compétitivement à ces jeux, il fallait nécessairement passer par des serveurs IRC et des forums, dans lesquels des communautés internet se développaient inévitablement à force de se fréquenter.
        </p>

        <p>
          En 2003, voulant essayer par pure curiosité de créer sa propre communauté web, Bad crée son premier site web « Leuphorie-world » (ouais bon, on a tous eu 14 ans un jour). Sur ce site, quelques pages sans intérêt remplies de blagues et de devinettes servent à attirer le chaland vers un forum de discussion. Le succès est mitigé, ce forum attire quelques personnes qui viennent discuter de temps en temps, mais son activité reste basse et les conversations sans grand intérêt. Leuphorie-world ferme ses portes par manque d'activité et d'intérêt fin 2004, et fait réaliser à Bad qu'un site n'est pas si simple que ça à faire fonctionner.
        </p>

        <p>
          Pendant ce temps, des éléments de la future communauté NoBleme s'assemblent un peu partout. Dans la vie réelle, Bad se fait des amis au lycée qui contribueront aux débuts de NoBleme : Piratmac, Maxleouf, et Gromitflash. Sur internet, Bad crée du contenu pour le jeu <a class="gras" href="https://fr.wikipedia.org/wiki/Warcraft_III:_Reign_of_Chaos">Warcraft 3</a> et aide d'autres créateurs de contenu avec leurs problèmes techniques sur un site nommé WC3Campaigns, que fréquentent alors des futurs membres de NoBleme : Tenshi, StormrageJunior, et Kalkhran (les deux derniers fréquentant le site Metalplanet où ils côtoient deux futurs NoBlemeux, Planeshift et Pins). Encore ailleurs sur internet, Bad joue à un jeu en ligne nommé Super Robot Wars Online, qui servira plus tard d'inspiration pour un futur jeu hébergé sur NoBleme qui ramènera de nombreux membres sur le site.
        </p>

        <br>
        <br>
        <br>
        <br>

        <h5>Acte II : L'enfance de NoBleme (2005)</h5>

        <p>
          Début 2005, les étoiles s'alignent. Un ami de lycée de Bad, Maxleouf, se lance dans la réalisation de films amateur. Il aimerait bien une plateforme pour pouvoir partager ses films sur internet. Comme à cette époque Bad est en plein apprentissage du développement informatique, Maxleouf se dit que c'est une bonne idée de lui en parler. Justement, Bad a toujours cette envie de faire partie d'une communauté internet, et l'apport humain de Maxleouf pourrait se combiner avec l'apport technique de Bad.
        </p>

        <p>
          En mars 2005, un groupe de trois personnes engage une conversation via internet pour parler de ce projet. Il s'agit des membres fondateurs de NoBleme : BadFurDay (pseudonyme de Bad à l'époque), Maxleouf, et ThomYorke. À l'issue de cette conversation, le nom de domaine « nobleme.com » est choisi, et il est décidé que le site sera centré sur un forum généraliste où tout le monde sera accueilli peu importe leurs opinions ou leur personnalité (magistrale erreur, mais les adolescents ont tendance à être naïfs). C'est un lieu où il n'y aura pas de problème (si seulement), donc No[Pro]Blème, le nom est choisi !
        </p>

        <p>
          Le 19 mars 2005, NoBleme.com voit officiellement le jour, contenant uniquement un forum. Les trois membres fondateurs parlent du site à leurs amis, et en à peine quelques mois le forum NoBleme atteint le niveau d'activité respectable d'une centaine messages par jour, tandis qu'un des membres fondateurs (ThomYorke) disparait dès le premier mois. Parmi les membres qui participent au forum NoBleme en 2005, les plus actifs sont (dans leur ordre d'arrivée) BadFurDay, Tenshi, Pickman, coincoin, Namour, jordanleouf, Piratmac, StormrageJunior, antiprof, Gromitflash, the WindmillS fighter, Kalkhran, Planeshift, et Pins. Ils sont la toute première génération de NoBlemeux.
        </p>

        <p>
          Bien entendu, tout n'est pas simple. Assembler une communauté de gens majoritairement adolescents qui ne se connaissaient pour la plupart pas avant de rejoindre le site garantit de la tension. Un des évènements notables de la première année de NoBleme est la création de la BrigadeAntispam, un compte bidon crée sur le forum dans le but de demander à jordanleouf d'arrêter de poster des messages indéchiffrables (il avait alors à peine 13 ans et écrivait en quasi-SMS). Cette modération soudaine dans une communauté réputée libre crée des heurts, opposant les partisans de la modération (principalement Piratmac et Maxleouf) aux partisans de la liberté totale (principalement the WindmillS fighter et StormrageJunior).
        </p>

        <p>
          L'escalade de violence verbale entre ces deux partis a mené en fin 2005 au départ définitif de Piratmac et temporaire de Maxleouf, Bad ayant choisi le camp de la non intervention. Lourdé par la BrigadeAntispam, jordanleouf quitte à son tour le site, suivi de Namour, coincoin, the WindmillS fighter, et quelques autres. Pour remonter l'ambiance morne de la fin d'année, Bad célèbre Noël en produisant une animation flash nommée « Les mystères de NoBleme », un <a class="gras" href="https://fr.wikipedia.org/wiki/Documentaire_parodique">mocumentaire</a> volontairement ultra-dramatique en trois parties qui finit par révéler qui était réellement derrière le compte BrigadeAntispam... il s'agissait de Bad lui-même.
        </p>

        <p>
          Voici des images de NoBleme en avril 2005 (cliquez dessus pour les voir en taille normale) :
        </p>

        <p class="align_center">
          <div class="flexcontainer">
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2005_1.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2005_1.png" alt="NoBleme en 2005">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2005_2.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2005_2.png" alt="NoBleme en 2005">
              </a>
            </div>
          </div>
        </p>

        <br>
        <br>
        <br>
        <br>

        <h5>Acte III : Des mechas et un gros drame (2006)</h5>

        <p>
          Malgré les heurts et les départs de fin 2005, le forum NoBleme reste actif et continue à grandir en 2006. Pendant ce temps, quelques NoBlemeux discutent régulièrement sur le <a class="gras" href="<?=$chemin?>pages/irc/index">canal IRC #NoBleme</a>, qui existait depuis 2005 mais n'était presque pas utilisé. Sur IRC, BadFurDay, Gromitflash, et Maxleouf (qui est revenu au cours de l'année), ainsi que quelques visiteurs occasionels, forment la première véritable communauté NoBleme, formant des liens d'amitié et organisant des <a class="gras" href="<?=$chemin?>pages/irl/index">rencontres IRL</a>.
        </p>

        <p>
          L'idée que NoBleme serait un site pour les projets cinématographiques de Maxleouf est abandonnée, et Bad cherche des idées de contenu à mettre sur NoBleme pour attirer les chalands. Comme mentionné plus haut, Bad jouait depuis quelques années à un jeu en ligne nommé Super Robot Wars Online, jeu de stratégie basé sur la série <a class="gras" href="https://fr.wikipedia.org/wiki/Super_Robot_Wars">Super Robot Wars</a> dans lequel chaque joueur incarne le pilote d'un mecha (robot de combat futuriste). Or, l'administrateur de ce jeu, n'a plus assez de temps libre dans sa vie pour s'en occuper. Sans développement actif, et envahi de joueurs qui abusent du système de jeu, il est voué à l'abandon. C'est une occasion de sauver le jeu tout en ramenent du monde sur NoBleme...
        </p>

        <p>
          À l'aide de Rincevent, un joueur de Super Robot Wars Online également attristé par la déchéance du jeu, Bad crée le NRM Online (NoBleme Robot Mayhem Online), un jeu de stratégie en ligne fortement inspiré de Super Robot Wars Online, dans lequel - vous l'aurez deviné - chaque joueur incarne le pilote d'un mecha.
        </p>

        <p>
          Le succès du NRM Online n'est pas immédiat, le jeu a du mal à convaincre les joueurs de Super Robot Wars Online qu'il est plus intéressant que l'original (et ils n'ont pas tort, le NRM est mal équilibré et plein de bugs). Le nombre de joueurs actifs en 2006 est en général de l'ordre de 20 à 40 par saison, et ce type de jeu n'est vraiment intéressant que s'il y a au moins une cinquantaine de joueurs actifs. Malgré tout, une partie des joueurs rejoignent le forum NoBleme, et s'intègrent rapidement. Les nouveaux réguliers de NoBleme arrivés via le NRM en 2006 incluent (dans leur ordre d'arrivée) : Les Granges, Super Concombre, Krakefer, Screamers, InnerKollaps, Gargoyle, Aldaris, MortifeR, et ThArGos (ce dernier ne venant pas de Super Robot Wars Online, il avait trouvé le NRM en se baladant sur internet). Ils sont la seconde génération de NoBlemeux.
        </p>

        <p>
          Du côté du forum, cet influx de nouveaux membres en attire d'autres venus d'un peu partout sur internet. Inévitablement, le problème initial se répète : Un grand nombre d'adolescents et de jeunes adultes, ne se connaissant pas auparavant, se retrouvant ensemble sur un forum sans règles où la modération est quasi inexistante. La tension monte à nouveau pendant l'été 2006, opposant deux camps. D'un côté, StormrageJunior et Kalkhran, qui deviennent de plus en plus aggressifs et toxiques. En face, la majorité des membres du forum, qui sont lassés de la façon dont ces deux derniers polluent le lieu.
        </p>

        <p>
          Plutôt que d'exploser, cette fois, la tension persiste et s'amplifie. Bad fait le mauvais choix de ne pas prendre de position, ce qui mène au départ de certains réguliers du forum, blasés par la toxicité ambiante. Parmi ceux qui sont partis se trouvent le membre le plus actif du forum, Tenshi, ainsi que Maxleouf, le co-fondateur de NoBleme, qui part du site une seconde fois.
        </p>

        <p>
          Cherchant à sauver le forum avant qu'il implose, Gromitflash fait appel à un de ses amis, KokoEater, qui était déjà présent mais peu actif sur NoBleme. Également hautement toxique, et assez insupportable, KokoEater arrive à exaspérer StormrageJunior et Kalkhran, qui décident de quitter NoBleme. Avant de partir, ils décident de mettre en place tout un scénario qui aurait mené à la fin de NoBleme. Toutefois, la mise en route de ce plan reposait sur le fait que Bad lise leurs échanges de messages privés, ce qu'ils pensaient qui avait lieu régulièrement. Mis à la porte par tous les NoBlemeux fatigués de leur toxicité, ils finissent par avouer leur plan avorté et disparaitre de NoBleme à jamais.
        </p>

        <p>
          Voici des images de NoBleme en septembre 2006 (cliquez dessus pour les voir en taille normale) :
        </p>

        <p class="align_center">
          <div class="flexcontainer">
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2006_1.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2006_1.png" alt="NoBleme en 2006">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2006_2.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2006_2.png" alt="NoBleme en 2006">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2006_3.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2006_3.png" alt="NoBleme en 2006">
              </a>
            </div>
          </div>
        </p>

        <br>
        <br>
        <br>
        <br>

        <h5>Acte IV : Mort du site et naissance de la communauté (2007-2009)</h5>

        <p>
          Ce que le forum surnomme maintenant « L'affaire StormKal » n'est plus qu'un mauvais souvenir. Hélas, Bad n'ayant pas agi, la communauté s'est beaucoup trop fragmentée autour de cette histoire, et les membres les plus actifs du forum sont partis. La mort lente de NoBleme a irréversiblement commencé.
        </p>

        <p>
          Du côté du NRM Online, Bad essaye autant qu'il peut de regrouper le nombre de joueurs nécessaires pour que le jeu soit aussi intéressant qu'il devrait l'être, et la première saison de 2007 a enfin la cinquantaine de joueurs requis. La seconde saison de 2007 montera même au dessus des 100 joueurs. Hélas, à l'époque, Bad rentre dans une période difficile de sa vie privée, et n'a pas le temps de s'occuper proprement du NRM. Le temps d'attente entre les saisons s'allonge, les saisons se ressemblent trop entre elles, et le NRM décline doucement jusqu'à fermer fin 2008 par manque de joueurs.
        </p>

        <p>
          Revenons un peu en arrière, en 2007. Le pic de popularité du NRM combiné avec la disparition des anciens réguliers du forum fait que le NRM est le seul sujet de discussion sur le forum. Les NoBlemeux de première génération qui sont toujours présents sur le forum en ont marre, et finissent par arrêter de participer, entamant un processus de mort lente pour le forum qui coincide avec le déclin du NRM.
        </p>

        <p>
          Pendant ce temps, sur le canal IRC #NoBleme, des réguliers du forum rejoignent la conversation, et la communauté NoBleme s'assemble doucement. Même si c'est une petite communauté, son existence est ce qui pousse Bad à garder NoBleme en vie à travers les périodes de déclin. En 2007, les principaux réguliers d'IRC sont BadFurDay, Gromitflash, ThArGos, Planeshift, et Pins. Pour certains, ce qui les fait rester est la présence d'un jeu de rôle joué sur IRC nommé le <a class="gras" href="<?=$chemin?>pages/nbrpg/index">NoBlemeRPG</a>, dont l'univers imprévisible et original attire la curiosité. Pour ne pas risquer de rater les sessions de jeu, certains se fidélisent à IRC.
        </p>

        <p>
          Sans vie dans son forum, sans son jeu en ligne, il ne reste plus qu'une chose à NoBleme : une section du site crée en 2006, le Wiki NoBleme. À l'origine fait pour documenter du contenu lié au site, Bad le transforme progressivement en une encyclopédie francophone des phénomènes internet. À l'époque unique en son genre, le Wiki NoBleme attire de nombreux visiteurs, jusqu'à 2500 par jour en 2009. Hélas, ces visiteurs ne viennent pas pour les bonnes raisons, et le forum comme IRC se retrouvent occasionellement en présence de gamins venus parce qu'ils ont cherché « Pedobear » ou « fgsfds » sur internet. Oups.
        </p>

        <p>
          En tant que communauté, NoBleme traverse le désert. En tant que site, grâce à son wiki, NoBleme n'a jamais été aussi populaire. Inévitablement, cette popularité finit par permettre de renouveler la communauté. D'abord, une première vague débarque sur IRC après avoir trouvé NoBleme par des recherches stupides de phénomenes internet. Parmi eux, Baffan, Trucy, Lidys, et Kryos deviennent des réguliers. Plus tard, d'autres trouvent NoBleme via des extraits du NoBlemeRPG postés sur le wiki, et la communauté se voit renforcée de la présence de Enerhpozyks, Shalena, Kutz, et SiHn. Tous ces nouveaux arrivants forment la troisième génération de NoBlemeux.
        </p>

        <p>
          Délaissant totalement le forum et ne se servant presque que d'IRC, cette nouvelle vague de NoBlemeux se mélange en 2008-2009 avec les survivants des premières générations pour former ce qui est aujourd'hui NoBleme, une communauté à l'esprit quasi-familial, où tout le monde prend le temps de connaitre les autres et de s'harmoniser avec l'ambiance générale. Des rencontres IRL sont organisées régulièrement, le NoBlemeRPG est ressuscité pour divertir les nouveaux arrivants, et NoBleme retrouve la vie.
        </p>

        <p>
          Voici des images (hélas incomplètes par manque d'archives de l'époque) de NoBleme en décembre 2008 (cliquez dessus pour les voir en taille normale) :
        </p>

        <p class="align_center">
          <div class="flexcontainer">
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2008_1.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2008_1.png" alt="NoBleme en 2008">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2008_2.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2008_2.png" alt="NoBleme en 2008">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2008_3.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2008_3.png" alt="NoBleme en 2008">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2008_4.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2008_4.png" alt="NoBleme en 2008">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2008_5.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2008_5.png" alt="NoBleme en 2008">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/2008_6.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/2008_6.png" alt="NoBleme en 2008">
              </a>
            </div>
          </div>
        </p>

        <br>
        <br>
        <br>
        <br>

        <h5>Acte V : Blackout et nouveau NoBleme (2010-Aujourd'hui)</h5>

        <p>
          En 2010, Bad décide que vu que seul IRC est actif, le site ne sert plus à rien. L'intégralité du site est remplacé par une page noire avec un compte à rebours jusqu'au 19 mars 2010, jour des 5 ans de NoBleme. Une fois le compte à rebours fini, NoBleme est remplacé par... rien. Le forum et le wiki sont toujours là, mais inactifs et pas mis à jour. La seule différence est que NoBleme tourne sur un nouveau serveur plus rapide, qui peut tenir la charge des milliers de visiteurs quotidiens du wiki. Bravo hein, Bad, c'est tout un talent de savoir décevoir les gens à ce point là. Limite c'en est respectable.
        </p>

        <p>
          Heureusement, l'histoire ne s'arrête pas là. Maintenant qu'il est établi que NoBleme est une communauté et non pas des gens qui se mettent dessus sur un forum ou des joueurs de jeu de stratégie en ligne, il reste à lui développer une identité. Par chance, il n'y a aucun effort à faire, la période est propice : le web, qui était au début des années 2000 composé de plein de petites communautés, est en pleine centralisation. Les gens ne se retrouvent plus sur des petits sites, mais plutôt sur Facebook, Twitter, ou autres gigantesques réseaux sociaux. En ayant survécu à la mort des petites communautés, Bad décide que NoBleme sera un vestige des temps passés d'internet, une communauté chaleureuse où l'ambiance est aussi positive que possible.
        </p>

        <p>
          Doucement, NoBleme continue à se développer et à grandir dans son nouveau rôle. Les rencontres IRL deviennent régulières, attirent de plus en plus de monde. IRC devient actif toute la journée. Les anciens NoBlemeux grandissent, finissent leurs études, rentrent dans la vie active. Une nouvelle génération de réguliers rejoint la communauté, grandit avec les autres.
        </p>

        <p>
          En 2012, Bad décide de fermer une fois pour toute ce qui reste de l'ancien NoBleme. Le forum n'est plus utilisé, le wiki n'attire que des gamins et demande trop d'entretien, tout est fermé. Pour que NoBleme ne soit pas une simple facade pour IRC, une page d'accueil est développée, et autour d'elle un nouveau site (qui ne contient pas grand chose d'utile).
        </p>

        <p>
          Vu qu'il n'y a plus de drames majeurs, il n'y a pas grand chose à raconter sur cette période. Début 2015, NoBleme a le droit à un nouveau design, et fin 2017 le site est recodé en entier afin d'en faire une refonte complète, et de le moderniser afin qu'il vive avec son temps. Ce n'est pas parce qu'un site préserve l'ambiance du passé qu'il doit vivre dans le passé.
        </p>

        <p>
          Voici des images de l'évolution progressive de l'index de NoBleme de 2010 à 2017 (cliquez dessus pour les voir en taille normale) :
        </p>

        <p class="align_center">
          <div class="flexcontainer">
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/acteV_1.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/acteV_1.png" alt="Évolution de NoBleme">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/acteV_2.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/acteV_2.png" alt="Évolution de NoBleme">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/acteV_3.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/acteV_3.png" alt="Évolution de NoBleme">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/acteV_4.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/acteV_4.png" alt="Évolution de NoBleme">
              </a>
            </div>
            <div style="flex:1">
              <a href="<?=$chemin?>img/nobleme/acteV_5.png" target="_blank">
                <img src="<?=$chemin?>img/nobleme/acteV_5.png" alt="Évolution de NoBleme">
              </a>
            </div>
          </div>
        </p>

        <br>
        <br>
        <br>
        <br>

        <h3>Questions existentielles</h3>

        <br>

        <h5>Le présent : À quoi sert NoBleme ?</h5>

        <p>
          Maintenant que vous avez compris d'où vient NoBleme, il est plus facile d'expliquer où on est aujourd'hui. NoBleme sert à une chose : préserver l'ambiance disparue des petites communautés internet. L'objectif n'est pas de rester coincé dans le passé, c'est plutôt d'être tourné vers le futur, sans oublier d'où on vient.
        </p>

        <p>
          Pour ce faire, il est nécessaire que NoBleme garde son esprit de bonne entente. C'est dans le nom du site après tout. La priorité numéro un est donc, avant tout, de s'assurer que tout le monde se sente bien sur NoBleme, le reste est secondaire. À partir du moment où tout le monde se plait ici, il devient plus facile d'être accueillant pour les autres, et de les intégrer dans la communauté.
        </p>

        <br>
        <br>

        <h5>Le futur : Quel est l'avenir de NoBleme ?</h5>

        <p>
          Pour ne pas répéter les erreurs du passé, il est important que NoBleme ait une direction qui ne clashe pas avec l'état d'esprit de sa communauté. Il serait facile de juste faire revenir le NRM ou le Wiki pour faire grandir rapidement NoBleme, mais si c'est pour qu'ils attirent des gens dont la présence écraserait la communauté en place, ce ne serait pas intéressant.
        </p>

        <p>
          La direction prise par NoBleme est réactive : Bad développe des nouveaux contenus sur le site. Si ces contenus sont utiles à la communauté existante et n'attirent personne de nouveau, tant mieux. Si ces contenus attirent des nouveaux membres qui s'intègrent bien dans la communauté, tant mieux. Si ces contenus attirent des nouveaux membres indésirables, toxiques, ou dont l'état d'esprit ne se mélange pas bien avec celui des NoBlemeux d'aujourd'hui, tant pis, le contenu va à la poubelle.
        </p>

        <p>
          En résumé, il n'y a aucun plan de route fixe pour l'avenir de NoBleme. La seule certitude est que si une partie de l'ancien contenu du site revient, ce sera sous une forme différente.
        </p>

        <br>
        <br>

        <h5>La question : Est-il trop tard pour faire partie de NoBleme ?</h5>

        <p>
          Bien sûr que non ! Si après avoir lu tout ce que vous venez de lire sur cette page vous arrivez à la conclusion que NoBleme est une communauté fermée, c'est que je me suis mal exprimé ou que vous avez mal compris. La raison d'être de NoBleme, c'est d'intégrer avec les bras ouverts tous ceux qui ont envie de partager les valeurs que la communauté représente.
        </p>

        <p>
          Alors cessez d'être timide, et venez nous dire bonjour sur <a class="gras" href="<?=$chemin?>pages/irc/index">IRC</a> !
        </p>

        <br>
        <br>

      </div>




      <?php } else { ?>




      <div class="texte">

        <h1 class="alinea">What is NoBleme?</h1>

        <br>
        <br>

        <h5>The past: NoBleme's history (the short version)</h5>

        <p>
          On march 19th 2005, NoBleme was created by <a class="gras" href="<?=$chemin?>pages/user/user?id=1">Bad</a> as an attempt to make his own website and community. Back then, small online communities without a central theme were a common thing on the internet, and NoBleme was yet another one of them.
        </p>

        <p>
          After several rocky years of poorly managed constant teenage drama, the website changed its direction. Instead of an open discussion forum with no rules, it started focusing on its community. Gone were the days of arguing with each other through ad hominems, Bad was growing older and so was the website. Members of the NoBleme community started communicating mostly through <a class="gras" href="<?=$chemin?>pages/irc/index">its IRC server</a>, got to become friends, organized regular <a class="gras" href="<?=$chemin?>pages/irl/index">real life meetups</a>, and thus the current day NoBleme community was born.
        </p>

        <p>
          It took a full decade of being an aimless website to realize what NoBleme was all about: Creating a friendly environment reminescent of the small internet communities of the early 2000s.
        </p>

        <br>
        <br>

        <h5>The present: What is NoBleme for?</h5>

        <p>
          As you might have understood from NoBleme's history, its role is to be a living memory of what the internet used to be. Before the days of centralization on MySpace, Facebook, Twitter, etc., the internet was comprised of small communities where people would hang out, make friends, to the point where it would feel like a family. NoBleme survived those days and is trying to preserve that spirit.
        </p>

        <p>
          However, NoBleme doesn't look too much towards the past. Those communities of the old days are gone for a good reason, they aren't necessary anymore. Instead, NoBleme focuses on maintaining a good environment for its current community, and on trying to feel welcoming to new users wanting to join it.
        </p>

        <br>
        <br>

        <h5>The future: Where is NoBleme going?</h5>

        <p>
          In order to avoid repeating the mistakes of its past, the development of NoBleme is made reactively. Every now and then, Bad develops new features. If those features are useful to the community but don't attract new people to the website, that's good. If those features are useful and attract new users into the community, that's even better. However, if those new features attract toxic users whose state of mind clash with the community, they get removed from the website.
        </p>

        <p>
          There is no fixed roadmap for NoBleme's future. Features come and go, the community evolves and changes, and only time will tell where this will lead us.
        </p>

        <br>
        <br>

        <h5>The language barrier: Being non-french on NoBleme</h5>

        <p>
          NoBleme was initially created as a french only community. Thus, most of the members that make the core of its community are french, and some website features are available only in french.
        </p>

        <p>
          However, many french NoBleme users speak english decently (or fluently), and some members of the community aren't even french. Despite being a french website, english absolutely does have its place on NoBleme (as evidenced by the fact that you are reading this in english right now).
        </p>

        <br>
        <br>

        <h5>Is it too late to be a part of NoBleme's community?</h5>

        <p>
          Of course not! We pride ourselves on our openness towards new people. As long as you share the values listed in our <a class="gras" href="<?=$chemin?>pages/doc/coc">code of conduct</a>, we will be happy to have you within our community.
        </p>

        <p>
          Don't be scared to hop on <a class="gras" href="<?=$chemin?>pages/irc/index">IRC</a> and say hi!
        </p>

        <br>
        <br>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';