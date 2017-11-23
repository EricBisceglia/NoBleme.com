<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'IRCClient';

// Identification
$page_nom = "Discute sur IRC";
$page_url = "pages/irc/client";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Client IRC" : "IRC client";
$page_desc  = "Rejoindre le serveur de discussion IRC de NoBleme";

// CSS & JS
$css  = array('onglets');
$js   = array('onglets');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Se connecter à IRC";
  $trad['soustitre']      = "Utiliser un client IRC pour rejoindre la conversation";

  // Onglets
  $trad['onglet_choisir'] = "CHOISISSEZ UNE OPTION";
  $trad['onglet_un_clic'] = "ALLER SUR IRC EN UN CLIC";
  $trad['onglet_custom']  = "CLIENT IRC PERSONNALISABLE";

  // Choisir une option
  $trad['choisir_titre']  = "Choisissez parmi deux options";
  $trad['choisir_desc']   = <<<EOD
<p class="spaced">
  Afin de venir discuter sur le <a class="gras" href="{$chemin}pages/irc/index">serveur IRC de NoBleme</a>, il va falloir utiliser ce qu'on appelle un client IRC : un programme ou site internet servant d'interface entre vous et le serveur de discussion. Pour vous simplifier la vie, je vous propose deux options au choix, à vous de choisir ce qui vous convient le mieux.
</p>
<p class="spaced">
  La première option est la plus simple : vous n'avez rien à installer, rien à personnaliser. Il suffit d'entrer votre pseudonyme, d'apuyer sur le bouton « Démarrer », et vous êtes connecté au serveur IRC NoBleme et prêt à discuter. Cette option est idéale si vous êtes juste curieux de voir comment les choses se passent sur IRC et n'avez pas envie de perdre du temps à personnaliser votre expérience. Pour ce faire, cliquez sur l'onglet « Aller sur IRC en un clic » (ou <a class="gras pointeur" onclick="ouvrirOnglet(event, 'un_clic', 'un_clic_onglet')">cliquez ici</a>). Peut-être que si notre serveur IRC vous plait, vous pourrez considérer la seconde option par la suite.
</p>
<p class="spaced">
  La seconde option est la plus pratique : vous aurez besoin de 5 à 10 minutes pour vous créer un compte (gratuit) sur un site et faire quelques réglages, et en échange vous aurez la possibilité de personnaliser l'apparence d'IRC, de retenir à quels canaux IRC vous êtes connecté, de pouvoir suivre les conversations qui ont lieu pendant que vous êtes absent, et de pouvoir utiliser IRC n'importe où, même sur mobile. Pour configurer un client IRC plus sérieux, cliquez sur l'onglet « Client IRC personnalisable » (ou <a class="gras pointeur" onclick="ouvrirOnglet(event, 'custom', 'custom_onglet')">cliquez ici</a>), puis suivez les instructions du guide (simple et illustré).
</p>
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "Join the conversation";
  $trad['soustitre']      = "Using an IRC client to join NoBleme's chat rooms";

  // Onglets
  $trad['onglet_choisir'] = "CHOOSE AN OPTION";
  $trad['onglet_un_clic'] = "JOINING IRC IN ONE CLICK";
  $trad['onglet_custom']  = "CUSTOMIZABLE IRC CLIENT";

  // Choisir une option
  $trad['choisir_titre']  = "Choose one of two options";
  $trad['choisir_desc']   = <<<EOD
<p class="spaced">
  In order to come chat on <a class="gras" href="{$chemin}pages/irc/index">NoBleme's IRC server</a>, you will need to use an IRC client, a software or website that works as an interface between you and the IRC server. I made things as simple as possible by offering you two options, one that requires no setup but isn't very flexible and one that's flexible but requires a bit of setup time.
</p>
<p class="spaced">
  The first option is the simplest one: you have nothing to intall, nothing to customize. All you have to do is enter your nickname, press a button, and you will be connected on NoBleme's IRC server and ready to chat. It's the ideal solution if you don't want to waste time customizing your experience and just want to get chatting right away. If you want to follow that option, press the « Joining IRC in one click » tab (or <a class="gras pointeur" onclick="ouvrirOnglet(event, 'un_clic', 'un_clic_onglet')">click here</a>).
</p>
<p class="spaced">
  The second option is the most convenient one: you will only need 5 to 10 minutes of setup time in order to create a (free) account on a website and change a few settings. In return, you will get the ability to fully customize the appearance of IRC, will have a service that memorizes what channels you are in, will be able to follow conversations that happen while you are gone, and will be able to keep the conversation going on your smarthone when you aren't home. If you want to follow that option, press the « Customizable IRC client » tab (or <a class="gras pointeur" onclick="ouvrirOnglet(event, 'custom', 'custom_onglet')">click here</a>), then follow the tutorial's instructions (simple and illustrated).
</p>
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1 class="align_center"><?=$trad['titre']?></h1>

        <h5 class="align_center"><?=$trad['soustitre']?></h5>

        <br>
        <br>

        <ul class="onglet">
          <li>
            <a id="choisir_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, 'choisir')">
              <?=$trad['onglet_choisir']?>
            </a>
          </li>
          <li>
            <a id="un_clic_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'un_clic')">
              <?=$trad['onglet_un_clic']?>
            </a>
          </li>
          <li>
            <a id="custom_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'custom')">
              <?=$trad['onglet_custom']?>
            </a>
          </li>
        </ul>

        <div id="choisir" class="contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['choisir_titre']?></h5>

          <?=$trad['choisir_desc']?>

          <br>

        </div>

        <div id="un_clic" class="hidden contenu_onglet">
          <?php if($lang == 'FR') { ?>
          <iframe src="https://kiwiirc.com/client/irc.nobleme.com/?&theme=basic#NoBleme" class="indiv" style="height:600px;"></iframe>
          <?php } else { ?>
          <iframe src="https://kiwiirc.com/client/irc.nobleme.com/?&theme=basic#english" class="indiv" style="height:600px;"></iframe>
          <?php } ?>
        </div>

        <div id="custom" class="hidden contenu_onglet">

          <?php if($lang == 'FR') { ?>

          <br>

          <h5 class="alinea">Configurer un client IRC personnalisable (durée totale 5 à 10 minutes)</h5>

          <p class="spaced">
            Afin d'avoir une expérience d'IRC plus personnalisée, on va choisir <a class="gras" href="https://irccloud.com">IRCCloud</a> comme client IRC, un site internet qui offre un service gratuit (optionnellement payant), ne demandant rien d'installer, et qui a également le rôle de ce qu'on appelle un bouncer (service qui permet de voir les conversations qui ont lieu même lorsque vous n'êtes pas connecté).
          </p>

          <p class="spaced">
            IRCCloud est disponible uniquement en anglais, mais même si votre anglais est mauvais vous devriez arriver assez facilement à vous en servir tant que vous suivez à la lettre les instructions de ce tutoriel. Au cas où il y aurait une ambiguïté dans la façon dont je phrase les choses, des illustrations sont fournies pour chaque étape du tutoriel.
          </p>

          <br>
          <br>

          <h5 class="alinea">Étape 1 : Mise en place d'IRCCloud</h5>

          <p class="spaced">
            Pour commencer, on va se rendre sur le site internet <a class="gras" href="https://irccloud.com">irccloud.com</a> et se créer un compte. Vous verrez sur la page trois champs de texte en dessous de « sign up for a free account » (créer un compte gratuit). Remplissez les champs qui sont, dans l'ordre : votre pseudonyme, votre adresse e-mail, et votre mot de passe, puis cliquez sur le bouton « Sign up ».
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_1.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Une fois que c'est fait, vous serez automatiquement connecté à votre compte IRCCloud. Avant de continuer, nous allons tout de suite confirmer l'authenticité de notre adresse e-mail. Pour ce faire, allez dans la boite e-mail que vous avez utilisée pour créer le compte, et cliquez sur le lien contenu dans le mail que vous devriez normalement avoir reçu d'IRCCloud.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_2.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Le lien ouvrira une page qui vous dira (en anglais) que vous avez validé votre adresse e-mail et que vous pouvez fermer cette page. Fermez la page que vous venez d'ouvrir, et revenez sur IRCCloud.
          </p>

          <br>
          <br>

          <h5 class="alinea">Étape 2 : Se connecter à NoBleme</h5>

          <p class="spaced">
            Vous verrez une interface vous disant « Join a new network » (rejoindre un nouveau serveur IRC), ainsi que plusieurs champs de texte. Vous allez devoir remplir les informations suivantes (faites attention à bien les remplir comme je vous le dit, sinon ça ne fonctionnera pas). Une fois que c'est fait, cliquez sur le bouton « Join network » pour vous connecter au serveur IRC NoBleme.
          </p>

          <br>

          <div class="flexcontainer">
            <div class="gras align_right spaced" style="flex:1">
              Hostname :<br>
              Port :<br>
              Nickname :<br>
              Channels to join :
            </div>
            <div style="flex:5">
              <span class="souligne">irc.nobleme.com</span><br>
              <span class="souligne">6697</span> (cochez la case « Secure port »)<br>
              <span class="souligne">Votre pseudonyme</span><br>
              <span class="souligne">#NoBleme</span> (le croisillon avant NoBleme est important)
            </div>
          </div>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_3.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Si vous avez tout bien rempli comme sur l'image, ça y est, vous êtes arrivé sur notre serveur IRC et vous pouvez discuter !
          </p>

          <p class="spaced">
            L'interface d'IRCCloud peut être un peu compliquée à comprendre au début, je vais vous aider avec une explication et une illustration de l'explication.
          </p>

          <p class="spaced">
            La partie gauche de la page est un grand espace vide, c'est là qu'apparaitront les messages que vous et les autres écrirez. En dessous de cet espace se trouve un champ de texte vide. C'est dans ce champ que vous écrivez les messages que vous voulez envoyer sur IRC (quand vous avez écrit un message, appuyez sur la touche entrée pour l'envoyer).
          </p>

          <p class="spaced">
            À droite de la zone de conversation, vous verrez plusieurs pseudonymes dans des blocs de couleurs différents, il s'agit de la liste des utilisateurs actuellement connectés au canal de discussion. Les symboles à côté des pseudonymes correspondent au degré de pouvoir qu'ont les utilisateurs sur le canal (propriétaire, administrateurs, opérateurs, etc.). Vous pouvez en lire plus sur le sujet sur la page <a class="gras" href="<?=$chemin?>pages/irc/services">commandes et services</a>.
          </p>

          <p class="spaced">
            Tout à droite de la page, vous verrez un message en anglais vous informant que votre compte est gratuit et vous proposant de payer (vous n'en avez pas besoin, la version gratuite d'IRCCloud suffit). Sous ce message, vous verrez la liste des serveurs et canaux de discussion auxquels vous êtes connecté (pour le moment, il ne devrait y avoir que le serveur IRC NoBleme et le canal #NoBleme). Si vous voulez rejoindre d'autres canaux du serveur, vous pouvez consulter la <a class="gras" href="<?=$chemin?>pages/irc/canaux">liste des canaux</a>.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_4.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Maintenant que vous êtes connecté au serveur IRC NoBleme, vous pouvez discuter avec nous (ou rester silencieux et observer les conversations le temps de vous sentir à l'aise, nous avons régulièrement des présences silencieuses et ça ne nous dérange absolument pas).
          </p>

          <br>
          <br>

          <h5 class="alinea">Étape 3 : Personnaliser l'apparence d'IRCCloud</h5>

          <p class="spaced">
            Personnellement, je n'aime pas trop l'apparence par défaut d'IRCCloud. Je trouve qu'il y a trop d'espace vide mal utilisé, que les couleurs sont trop claires pour mes pauvres yeux, et qu'il y a trop de choses qui ne me servent à rien (comme par exemple la prévisualisation automatique des liens twitter ou youtube).
          </p>

          <p class="spaced">
            L'avantage d'utiliser un client IRC est que vous pouvez le configurer à votre goût, et IRCCloud retiendra vos choix de configuration. Je vais vous proposer la configuration que j'utilise personnellement, vous êtes libres de l'adapter comme il vous plait, libre de suivre ou d'ignorer mes recommandations.
          </p>

          <p class="spaced">
            Pour commencer, on va accéder à la page des réglages. Pour ce faire, cliquez sur le petit rouage qui se trouve en bas à droite de votre fenêtre IRCCloud. Un menu s'ouvrira, choisissez l'option « Settings » (réglages) dans ce menu.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_5.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Par défaut, vous serez mis sur l'onglet « Layout & Design », où vous pouvez personnaliser l'apparence des canaux de discussion et des conversations qui y ont lieu.
          </p>

          <p class="spaced">
            Tout d'abord, choisissez un thème qui vous plait en cliquant sur les carrés de couleur (j'ai choisi « Ash » car il est reposant pour mes yeux). Ensuite, vous pouvez choisir une police de caractères (j'ai choisi Monospace), et déplacer la barre latérale des utilisateurs à gauche ou droite des fenêtres de discussion (je l'ai laissée à droite).
          </p>

          <p class="spaced">
            Vous verrez maintenant une liste d'options à cocher ou décocher. J'ai choisi de cocher « Always show channel members », « 24-hour clock », « Show seconds », « Convert :emoji: short codes », « Use symbols for user modes », « Colourise nicknames », et de décocher le reste. L'encadré « Preview » à droite vous permet de voir ce que change chacune des options lorsque vous les activez ou désactivez, bidouillez et voyez ce qui vous convient le mieux !
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_6.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Ensuite, cliquez à gauche sur l'onglet « Message notifications ». Ici, si vous le désirez, vous pouvez désactiver les notifications sonores en décochant la case en face de « Play an alert sound with background highlights » (je les ai désactivées car elles me distrayaient trop).
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_7.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Finalement, cliquez à gauche sur l'onglet « Chat &amp; embeds ». Il s'agit d'options vous permettant d'avoir des prévisualisations des divers médias qui sont postés sur IRC (images, vidéos, tweets, etc.).
          </p>

          <p class="spaced">
            Personnellement, j'ai choisi de cocher les cases « Show joins, parts, nicks, and mode changes » ainsi que juste en dessous « Collapsed », ce qui permet de réduire grandement le nombre de messages liés aux utilisateurs qui rejoignent les canaux IRC ou en partent. J'ai décoché toutes les autres cases, car je n'aime pas avoir des prévisualisations de médias au milieu de mes conversations, mais vous pouvez les laisser cochées si cela vous plait.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_8.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Votre IRCCloud est maintenant configuré à votre goût. Pour l'exemple, je vous montre une capture d'écran de l'apparence de mon IRCCloud avec exactement la même conversation que dans la capture d'écran que j'ai postée plus tôt dans ce tutoriel.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_9.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>
          <br>

          <h5 class="alinea">Étape 4 : Post-scriptum - informations supplémentaires sur IRCCloud</h5>

          <p class="spaced">
            Si vous voulez pouvoir vous servir d'IRC lorsque vous n'êtes pas devant votre ordinateur, bonne nouvelle, il existe des applications gratuites auxquelles vous pouvez vous connecter avec votre compte IRCCloud <a class="gras" href="https://play.google.com/store/apps/details?id=com.irccloud.android&hl=fr">pour Android</a> et <a class="gras" href="https://itunes.apple.com/fr/app/irccloud/id672699103?mt=8">pour iPhone</a>.
          </p>

          <p class="spaced">
            Après avoir crée votre compte, vous aurez le droit à une connexion permanente gratuite pendant 7 jours (lorsque vous vous reconnecterez à votre compte, vous verrez tous les messages qui ont été postés en votre absence sur les canaux de discussion auxquels vous êtes connecté). Une fois les 7 jours gratuits passés, vous n'aurez plus que 2 heures d'archivage des conversations après avoir fermé IRCCloud. C'est la seule chose qui changera après la période d'essai, et ce n'est pas très gênant. Si vous désirez vraiment avoir un historique complet des conversations, il faut vous payer un abonnement (de l'ordre de 4€/mois ou 40€/an).
          </p>

          <p class="spaced">
            Pour mieux profiter de votre expérience du serveur IRC NoBleme, je vous recommende d'enregistrer votre pseudonyme pour qu'il ne se fasse pas usurper (vous pouvez trouver comment faire sur la page <a class="gras" href="<?=$chemin?>pages/irc/services">commandes et services</a>), ainsi que d'aller voir sur la <a class="gras" href="<?=$chemin?>pages/irc/canaux">liste des canaux</a> s'il y a d'autres canaux IRC que #NoBleme qui pourraient vous intéresser. Si vous avez des questions concernant IRC, n'hésitez pas à les poser sur #NoBleme, quelqu'un devrait pouvoir y répondre (si personne ne vous répond, soyez patient, c'est probablement que tout le monde est occupé ou absent, quelqu'un finira bien par vous répondre).
          </p>

          <br>




          <?php } else { ?>

          <br>

          <h5 class="alinea">Configuring a customizable IRC client (takes 5 to 10 minutes)</h5>

          <p class="spaced">
            In order to have a customizable IRC experience, we'll be using <a class="gras" href="https://irccloud.com">IRCCloud</a> as our IRC client, a website which gives you a free (optionally paying) service that doesn't require you to install anything, and also acts as what we call a bouncer (lets you catch up on conversations that happened while you were offline).
          </p>

          <p class="spaced">
            IRCCloud should be quick and easy to set up, but in case anything in my tutorial is unclear I also added some images.
          </p>

          <br>
          <br>

          <h5 class="alinea">Step 1: Setting up IRCCloud</h5>

          <p class="spaced">
            First off, we'll start by going on <a class="gras" href="https://irccloud.com">irccloud.com</a> and creating an account. Fill up your username, e-mail address, and password, then press « Sign up ».
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_1.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Once you have registered, you will automatically be logged in to your IRCCloud account. Before we continue, you should check your e-mail inbox and press the confirmation link to verify you e-mail address.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_2.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            The link will redirect you to a page that says you can close it, so do what it does and close that page.
          </p>

          <br>
          <br>

          <h5 class="alinea">Step 2: Connecting to NoBleme</h5>

          <p class="spaced">
            You will now see an bunch of empty text fields under the title « Join a new network ». Fill them up with the following information, then press the « Join network » button.
          </p>

          <br>

          <div class="flexcontainer">
            <div class="gras align_right spaced" style="flex:1">
              Hostname :<br>
              Port :<br>
              Nickname :<br>
              Channels to join :
            </div>
            <div style="flex:5">
              <span class="souligne">irc.nobleme.com</span><br>
              <span class="souligne">6697</span> (check the « Secure port » box)<br>
              <span class="souligne">Your nickname</span><br>
              <span class="souligne">#english</span> (the pound sign before english is important)
            </div>
          </div>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_3_en.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Now that you are connected to NoBleme's IRC server, you can start chatting with us (or remain silent and lurk until you feel comfortable enough to get talking, we won't judge).
          </p>

          <br>
          <br>

          <h5 class="alinea">Step 3: Customizing IRCCloud's user interface</h5>

          <p class="spaced">
            Personally, I don't like IRCCloud's default user interface. It looks too empty and too bright for my tastes. The good thing about having a customizable IRC client is that you can customize it (duh) to your liking.
          </p>

          <p class="spaced">
            Let's get started by pressing the small cogwheel on the bottom right of your IRCCloud page, then on the « Settings » option in the menu that pops up.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_5.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            By default, you will be on the « Layout &amp; Design » tab. In there, you can customize the way things look in your chat window. Personally, I went for the « Ash » theme, the « Monospace » font, and changed a bunch of options. Feel free to pick whatever fits you best, you will see the preview area change as you fiddle with options. Below is a screenshot of the options I picked.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_6.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Next, we can switch to the « Message notifications » settings tab. This is where you can turn off alert sounds if they distract you (which I did).
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_7.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Finally, let's switch to the « Chat &amp; Embeds » tab. The options there allow you to turn on or off embedded media contents. I find it to be really obnoxious, so I turned everything off, except the first two checkboxes which I checked (they reduce the amount of join/leave spam done by users). Again, customize it to your liking.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_8.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>

          <p class="spaced">
            Now that you have customized IRCCloud, all you have left to do is chat! In case you're wondering how I customized my IRCCloud's interface, below is a screenshot of it.
          </p>

          <br>
          <br>
          <div class="indiv align_center">
            <img src="<?=$chemin?>img/irc/irccloud_9.png" alt="Illustration du tutoriel IRCCloud">
          </div>
          <br>
          <br>

          <h5 class="alinea">Step 4: Post scriptum - Extra info about IRCCloud</h5>

          <p class="spaced">
            If you want to use IRC on your smartphone when you're not in front of your computer, good news, IRCCloud has mobile apps that you can use with your account. Here are links to the <a class="gras" href="https://play.google.com/store/apps/details?id=com.irccloud.android&hl=fr">Android app</a> and the <a class="gras" href="https://itunes.apple.com/fr/app/irccloud/id672699103?mt=8">iPhone app</a>.
          </p>

          <p class="spaced">
            Once your account has been created, you will get a free unlimited bouncer for 7 days. This means that even when IRCCloud is closed, you will still get a backlog of all the messages that you miss. Once the 7 days are over, your account remains free to use, but you will only get up to 2 hours of backlog on missed messages. It's not a big deal, and the free version is sufficient. If you really want to keep the unlimited backlog, you will need to subscribe to the paying version (which is rather cheap).
          </p>

          <p class="spaced">
            In order to make the best of your experience on NoBleme's IRC server, I would suggest you register your nickname so that it doesn't get squatted by someone else (you can find out how to do that on the <a class="gras" href="<?=$chemin?>pages/irc/services">commands and services</a> page). I would also suggest checking out the <a class="gras" href="<?=$chemin?>pages/irc/canaux">channel list</a> to see if channels other than #english might interest you. If you have any questions regarding IRC, feel free to ask them in chat, someone should eventually answer them (if nobody does be patient, everyone might be busy, but someone should eventually show up and answer).
          </p>

          <br>

          <?php } ?>

        </div>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';