<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'IRCServices';

// Identification
$page_nom = "Essaye de comprendre les commandes IRC";
$page_url = "pages/irc/services";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Commandes IRC" : "IRC commands";
$page_desc  = "Commandes et services utilisés sur le serveur de discussion IRC de NoBleme";

// CSS & JS
$css  = array('tabs');
$js   = array('onglets');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']            = "IRC : Commandes et services";
  $trad['soustitre']        = "Collection d'informations utiles pour votre expérience sur IRC";

  // Onglets
  $trad['onglet_default']   = "IRC";
  $trad['onglet_infos']     = "INFOS";
  $trad['onglet_commandes'] = "COMMANDES";
  $trad['onglet_nickserv']  = "NICKSERV";
  $trad['onglet_chanserv']  = "CHANSERV";
  $trad['onglet_akundo']    = "AKUNDO";


  // IRC
  $trad['irc_titre']        = "Informations utiles liées à IRC";
  $trad['irc_desc']         = <<<EOD
<p class="spaced">
  J'ai regroupé pour vous une collection d'informations utiles à votre expérience sur le <a class="gras" href="{$chemin}pages/irc/index">serveur IRC NoBleme</a> (et même sur IRC en général si vous fréquentez d'autres serveurs). IRC peut être assez étrange et complexe à comprendre les premières fois que vous vous en servez, l'objectif de cette page est de répondre par avance autant que possible aux questions que vous pourriez vous poser.
</p>
<p class="spaced">
  L'onglet <span class="gras texte_noir">INFOS</span> contient une mini-référence de vocabulaire propre à IRC, ainsi qu'une explication des symboles bizarres que vous verrez régulièrement sur IRC.
</p>
<p class="spaced">
  L'onglet <span class="gras texte_noir">COMMANDES</span> contient un guide des commandes de base qui peuvent vous servir lors de votre utilisation d'IRC au quotidien, si vous vous demandez comment changer de pseudonyme, avoir une conversation privée avec quelqu'un, rejoindre d'autres canaux de discussion, etc.
</p>
<p class="spaced">
  L'onglet <span class="gras texte_noir">NICKSERV</span> documente un service nommé NickServ qui vous permet, entre autres, d'enregistrer votre pseudonyme auprès du serveur pour empêcher d'autres utilisateurs d'usurper votre identité.
</p>
<p class="spaced">
  L'onglet <span class="gras texte_noir">CHANSERV</span> documente un service nommé ChanServ qui vous permet de créer et de gérer votre propre canal de discussion sur le serveur IRC de NoBleme.
</p>
<p class="spaced">
  L'onglet <span class="gras texte_noir">AKUNDO</span> documente notre robot IRC local, une non-intelligence artificielle qui sert à peu près uniquement à écrire des bêtises à la demande.
</p>
EOD;


  // INFOS
  $trad['infos_ref_titre']  = "Mini-référence de vocabulaire lié à IRC";
  $trad['infos_r_serveur']  = <<<EOD
<span class="gras texte_noir">Serveur</span> : Le serveur est l'interface à laquelle tout le monde est connecté pour discuter sur IRC. Dans le cas de NoBleme, il s'agit d'un programme nommé <a class="gras" href="https://fr.wikipedia.org/wiki/UnrealIRCd">UnrealIRCd</a>. Lorsque vous postez un message sur IRC, il est d'abord envoyé au serveur, qui se charge ensuite de le redistribuer aux utilisateurs concernés.
EOD;
  $trad['infos_r_client']   = <<<EOD
<span class="gras texte_noir">Client</span> : Un client IRC est une interface chargée d'échanger des messages avec un serveur IRC, c'est ce dont vous vous servez pour discuter sur IRC. Un client IRC peut être un programme installé sur votre ordinateur (tel <a class="gras" href="https://hexchat.github.io/">HexChat</a>) aussi bien qu'un service sur un site internet (tel <a class="gras" href="https://kiwiirc.com/">KiwiIRC</a>). Chaque client a sa propre apparence et ses propres options de personnalisation, ce qui fait qu'IRC peut avoir l'air complètement différent d'une personne à l'autre.
EOD;
  $trad['infos_r_canal']    = <<<EOD
<span class="gras texte_noir">Canal</span> : Un serveur IRC contient un nombre illimité de canaux de discussion, qui peuvent être publics ou privés. Lorsqu'un message est envoyé sur un canal de discussion, seuls ceux qui sont présents sur le canal en question voient le message. Les canaux IRC sont identifiables du fait que leur nom commence par un croisillon (comme par exemple #NoBleme ou #dev). Vous pouvez trouver plus d'informations sur les canaux IRC sur la <a class="gras" href="{$chemin}pages/irc/canaux">liste des canaux IRC de NoBleme</a>.
EOD;
  $trad['infos_r_op']       = <<<EOD
<span class="gras texte_noir">Opérateur</span> : Sur un canal IRC, chaque utilisateur a des permissions différentes. Le fondateur d'un canal peut donner le pouvoir d'administrer le canal à certains utilisateurs (par exemple le pouvoir d'éjecter les utilisateurs indésirables). Ce sont ce que l'on appelle sur IRC des Opérateurs. Il existe plusieurs niveaux de permission qui donnent accès à plus ou moins de fonctions administratives, qui sont listés plus bas dans la page que vous êtes en train de lire en ce moment même.
EOD;
  $trad['infos_r_ircop']    = <<<EOD
<span class="gras texte_noir">IRCop</span> : Petit jeu de mot anglophone signifiant « policier d'IRC », un IRCop est un utilisateur qui a un pouvoir d'opérateur global sur tout le serveur. Un IRCop peut entre autres fermer des canaux IRC et bannir des utilisateurs de l'intégralité du serveur. Ses pouvoirs ne servent que dans des cas extrêmes, pour résoudre les conflits graves. Pour éviter que quelqu'un abuse de leur absence pour causer du chaos, l'identité et le nombre des IRCops du serveur IRC de NoBleme sont un secret.
EOD;
  $trad['infos_r_commande'] = <<<EOD
<span class="gras texte_noir">Commande</span> : Sur IRC, pour effectuer des actions autres que discuter, il faut utiliser des commandes. Il s'agit de messages qui commencent par un slash et contiennent des instructions pour votre client ou pour le serveur. Par exemple, /join permet de rejoindre un canal, et /msg permet d'envoyer un message privé. L'onglet COMMANDES de cette page contient une liste de quelques commandes utiles.
EOD;
  $trad['infos_r_kick']     = <<<EOD
<span class="gras texte_noir">Kick</span> : Mot anglais signifiant « coup de pied », un kick est une action qu'un opérateur peut utiliser contre un utilisateur indésirable, l'éjectant du canal de discussion sur lequel il se trouve. Il est possible de rejoindre un canal de discussion immédiatement après en avoir été kické, il s'agit donc plus d'une mesure d'avertissement que d'une réelle punition.
EOD;
  $trad['infos_r_ban']      = <<<EOD
<span class="gras texte_noir">Ban</span> : Comme son nom l'indique, un ban est un bannissement, c'est à dire une éjection définitive d'un utilisateur hors d'un canal IRC. Une fois banni d'un canal, vous ne pouvez plus le rejoindre, sauf si un opérateur du canal décide d'annuler le ban. Cette mesure punitive est réservée aux cas extrêmes.
EOD;
  $trad['infos_r_mode']     = <<<EOD
<span class="gras texte_noir">Mode</span> : Sur IRC, chaque utilisateur et chaque canal de discussion ont ce que l'on appelle des modes, une série d'options permettant d'effectuer des réglages. Ces modes sont exprimés sous forme de lettres vaguement arbitraires. Je vous en épargne la description, ce n'est pas très utile ou important à comprendre. Le seul mode intéressant à retenir est le mode +m pour un canal. Il s'agit du mode muet : tant qu'un canal est en mode +m, seuls les opérateurs ont le pouvoir de parler dans le canal, les simples utilisateurs ne peuvent plus y écrire. Lorsque le mode -m y est appliqué, il revient à la normale. C'est une méthode parfois utilisée quand un canal est victime de harcèlement externe, le temps que ça passe.
EOD;
  $trad['infos_r_bip']      = <<<EOD
<span class="gras texte_noir">Bip / Highlight</span> : Dans la majorité des clients IRC, lorsque vous écrivez le pseudonyme de quelqu'un, un son est joué chez l'utilisateur qui a été mentionné et la ligne contenant son pseudonyme apparait pour lui de façon surlignée. Le fait d'utiliser le pseudonyme de quelqu'un pour le notifier qu'il est concerné par une phrase est appelé en français un bip (biper quelqu'un), et en anglais un highlight (surlignement), ou parfois juste hl (diminutif de highlight). Ainsi, si quelqu'un vous parle de bip ou de hl, vous comprendrez qu'il parle du fait que son pseudonyme a été mentionné dans une conversation.
EOD;
  $trad['infos_r_ignore']   = <<<EOD
<span class="gras texte_noir">Ignore</span> : Une personne qui en a marre d'une autre peut choisir de l'ignorer dans son client IRC (référez vous à l'onglet COMMANDES de cette page si vous vous demandez comment faire). Une fois une personne ignorée, vous ne verrez plus les messages qu'il écrit sur les canaux IRC. C'est une façon utile de résoudre une situation tendue sans créer un drame public.
EOD;
  $trad['infos_r_lurk']     = <<<EOD
<span class="gras texte_noir">Lurk</span> : Mot anglais signifiant « se cacher tout en observant », lurker consiste à être présent sur IRC sans pour autant discuter. Les lurkers sont des utilisateurs qui font le choix de visiter un canal IRC, de lire ce qui s'y passe, mais ne s'y sentent pas assez confortables pour y prendre part à la conversation. NoBleme n'a rien contre les lurkers, tout le monde n'est pas immédiatement à l'aise avec des inconnus, n'ayez pas honte de vous si vous êtes un lurker.
EOD;

  // INFOS : Opérateurs
  $trad['infos_ops']        = "Opérateurs, modes, et symboles utilisateur";
  $trad['infos_ops_desc']   = <<<EOD
Sur les canaux IRC, les utilisateurs peuvent avoir différents niveaux de pouvoir. Chaque niveau correspond à un mode, et donc à une lettre comme expliqué plus haut (par exemple un opérateur va être +o, le fondateur d'un canal +q, etc.). La majorité des clients IRC représentent ces niveaux de pouvoir par des symboles plutôt que par des lettres (par exemple @ pour un opérateur et ~ pour le fondateur). Lorsque vous voyez quelqu'un avec un symbole devant son pseudonyme (par exemple ~Bad ou @Planeshift), cela signifie que cet utilisateur a certains pouvoirs sur le canal IRC en question. Pour comprendre le sens de ces symboles, voici un tableau les recensant :
EOD;

  // INFOS : Tableau des opérateurs
  $trad['infos_o_symbole']  = "SYMBOLE";
  $trad['infos_o_titre']    = "TITRE";
  $trad['infos_o_mode']     = "MODE";
  $trad['infos_o_pouvoirs'] = "POUVOIRS";
  $trad['infos_o_ou']       = "ou";
  $trad['infos_o_u']        = "Utilisateur";
  $trad['infos_o_u_desc']   = "Ne possède aucun pouvoir sur le canal";
  $trad['infos_o_v']        = "Voix";
  $trad['infos_o_v_desc']   = "Ne possède aucun pouvoir sur le canal. Si le canal bascule en mode muet (+m), cet utilisateur peut quand même continuer à envoyer des messages sur le canal.";
  $trad['infos_o_h']        = "Halfop";
  $trad['infos_o_h_desc']   = "« Demi opérateur ». Possède le pouvoir de kicker et bannir les utilisateurs normaux et les voix. Peut changer les réglages du canal.";
  $trad['infos_o_o']        = "Opérateur";
  $trad['infos_o_o_desc']   = "Possède le pouvoir de kicker et bannir les utilisateurs normaux, les voix, et les halfops. Peut changer les réglages du canal.";
  $trad['infos_o_a']        = "Superop";
  $trad['infos_o_a_desc']   = "Possède le pouvoir de kicker et bannir les utilisateurs normaux, les voix, les halfops, et les opérateurs. Peut changer les réglages du canal et changer le niveau de pouvoir des autres utilisateurs et opérateurs.";
  $trad['infos_o_q']        = "Fondateur";
  $trad['infos_o_q_desc']   = "L'utilisateur qui a fondé le canal. Possède tous les droits sur tous les utilisateurs, ne peut pas être kické ou banni sauf par lui-même.";


  // COMMANDES
  $trad['com_titre']        = "Quelques commandes utiles sur IRC";
  $trad['com_desc']         = <<<EOD
Sur IRC, pour effectuer des actions autres que discuter, il faut utiliser des commandes. Ils s'agit de messages qui commencent par un slash et contiennent des instructions pour votre client ou pour le serveur (par exemple /join ou /msg). Si vous ne comprenez pas une partie du vocabulaire utilisé ici, il est défini dans l'onglet INFOS de cette page.
EOD;
  $trad['com_desc_2']       = <<<EOD
La majorité des commandes qui sont listées ici dépendent de votre client IRC. Ces commandes varient d'un client à l'autre, par conséquent il n'y a aucune garantie qu'elles fonctionnent chez vous. La plupart des clients proposent une interface alternative à ces commandes (par exemple, dans beaucoup de clients IRC, au lieu de de faire /whois Bad, vous pouvez cliquer sur Bad et une option whois apparaitra sur laquelle vous pourrez cliquer).
EOD;
  $trad['com_desc_3']       = <<<EOD
Les commandes que vous verrez dans le tableau ci-dessous contiennent parfois du texte entre [crochets]. Lorsque c'est le cas, cela signifie qu'il s'agit de texte variable, et que c'est à vous de remplacer ce texte par le contenu spécifique que vous désirez, sans les crochets. Par exemple, dans la commande /join [canal], vous devez laisser le /join tel quel, mais remplacer [canal] par le nom d'un canal, ce qui donne des commandes comme /join #NoBleme ou /join #dev.
EOD;
  $trad['com_desc_4']       = <<<EOD
Vous trouverez d'autres commandes utiles liées à la gestion de votre pseudonyme dans la section NICKSERV de cette page, et encore d'autres liées à la gestion et à l'administration des canaux IRC dans l'onglet CHANSERV.
EOD;

  // COMMANDES : Tableau
  $trad['com_t_commande']   = "COMMANDE";
  $trad['com_t_exemple']    = "EXEMPLE";
  $trad['com_t_effet']      = "EFFET";
  $trad['com_t_clear_d']    = "Nettoie tout le texte présent à l'écran actuellement";
  $trad['com_t_list_d']     = "Liste tous les canaux IRC du serveur";
  $trad['com_t_join']       = "/join [canal]";
  $trad['com_t_join_e']     = "/join #NoBleme";
  $trad['com_t_join_d']     = "Rejoint le canal de discussion spéficié";
  $trad['com_t_part']       = "/part [canal]";
  $trad['com_t_part_e']     = "/part #dev";
  $trad['com_t_part_d']     = "Quitte le canal de discussion spéficié";
  $trad['com_t_quit_d']     = "Vous déconnecte totalement du serveur et quitte votre client IRC";
  $trad['com_t_nick']       = "/nick [pseudonyme]";
  $trad['com_t_nick_d']     = "Change le pseudonyme sous lequel vous apparaissez";
  $trad['com_t_whois']      = "/whois [pseudonyme]";
  $trad['com_t_whois_d']    = "Renvoie des informations (en anglais) sur l'utilisateur spécifié";
  $trad['com_t_msg']        = "/msg [pseudonyme] [message]";
  $trad['com_t_msg_e']      = "/msg Bad Salut ça va ?";
  $trad['com_t_msg_d']      = "Envoie un message privé que seul l'utilisateur spécifié recevra";
  $trad['com_t_ignore']     = "/ignore [pseudonyme]";
  $trad['com_t_ignore_d']   = "Bloque tous les messages venant de l'utilisateur spécifié";


  // NICKSERV
  $trad['ns_titre']         = "Qu'est-ce que NickServ ?";
  $trad['ns_desc']          = <<<EOD
<p class="spaced">
  Le serveur IRC NoBleme utilise les services <a class="gras" href="http://www.anope.org/">Anope</a>, qui créent quelques utilisateurs non-humains sur le serveur. Parmi ces utilisateurs se trouve NickServ (service des pseudonymes), qui vous permet d'enreistrer et de protéger votre pseudonyme pour qu'il ne soit pas usurpé par quelqu'un d'autre.
</p>
<p class="spaced">
  Les intéractions avec NickServ se font par messages privés ayant pour destinataire NickServ, qui vous renverra des réponses automatisées. Ces intéractions se font donc sous formes de commandes, référez-vous à l'onglet COMMANDES de cette page si vous ne comprenez pas comment les commandes fonctionnent sur IRC.
</p>
<p class="spaced">
  Dans cette section, nous allons voir comment enregistrer votre pseudonyme, comment vous authentifier quand vous vous connectez à IRC, et comment récupérer votre pseudonyme s'il est occupé par quelqu'un d'autre. Notez toutefois deux choses très importantes : <span class="gras souligne texte_noir">vous ne pouvez pas récupérer un pseudonyme dont vous avez perdu le mot de passe</span>, donc faites attention à bien retenir votre choix, et <span class="gras souligne texte_noir">vous serez puni si vous utilisez ce service pour squatter le pseudonyme de quelqu'un d'autre</span>, les administrateurs du serveur IRC NoBleme ont le pouvoir de libérer ces pseudonymes et de vous bannir définitivement.
</p>
EOD;

  // NICKSERV : Enregistrer
  $trad['ns_reg_titre']     = "Enregistrer votre pseudonyme";
  $trad['ns_reg_desc']      = <<<EOD
<p class="spaced">
  Les commandes utilisées dans les exemples contiennent du texte entre [crochets]. Lorsque c'est le cas, cela signifie qu'il s'agit de texte variable, et que c'est à vous de remplacer ce texte par le contenu spécifique que vous désirez, sans les crochets. Par exemple, dans la commande /msg NickServ identify [motdepasse], vous devez laisser le /msg NickServ identify tel quel, mais remplacer [motdepasse] par votre mot de passe, ce qui donne une commande telle que /msg NickServ identify hunter2
</p>
<p class="spaced">
  L'utilité de NickServ étant de gérer votre pseudonyme, il faut commencer par enregistrer votre pseudonyme auprès de NickServ avant de pouvoir utiliser les autres commandes du service. Pour ce faire, vous allez utiliser la commande suivante :
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ register [motdepasse]
</p>
<br>
<p class="spaced">
  Maintenant que votre pseudonyme est enregistré, il est automatiquement protégé par les services de NickServ. Si quelqu'un se sert de votre pseudonyme, il sera éjecté au bout d'une minute. Cela signifie que lorsque vous vous connectez à IRC, vous aurez vous-même une minute pour vous identifier, ou vous serez éjecté de votre propre pseudonyme. Pour vous identifier, utilisez la commande suivante :
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ identify [motdepasse]
</p>
<p class="spaced">
  Dans la plupart des clients IRC, vous pouvez entrer certaines commandes à effectuer automatiquement lorsque vous vous connectez à un serveur. Pour vous simplifier la vie et ne pas avoir à utiliser la commande ci-dessus à chaque fois, il est suggéré de l'entrer comme commande automatiquement effectée à la connexion (si votre client IRC le permet).
</p>
<br>
<p class="spaced">
  Maintenant que vous êtes le propriétaire de votre pseudonyme, vous pouvez vous retrouver dans une situation où le serveur ne vous laisse pas vous servir de votre propre pseudynome. Cela peut arriver quand quelqu'un d'autre squatte votre pseudonyme (et va s'en faire éjecter dans moins d'une minute), quand vous êtes connecté en double parce que votre internet est tombé, ou quand vous ne vous êtes pas identifié assez vite et que NickServ vous a éjecté de votre propre pseudonyme. Pour récupérer votre pseudonyme, entrez la commande suivante :
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ recover [pseudonyme] [motdepasse]
</p>
<p class="spaced">
  Bien entendu, une fois que vous avez utilisé recover pour libérer votre pseudonyme, si vous voulez reprendre votre pseudonyme, il faut ensuite entrer la commande /nick [pseudonyme]
</p>
<br>
<p class="spaced">
  Si vous ne voulez plus que votre pseudonyme soit enregistré dans NickServ pour une raison quelconque, vous pouvez le libérer définitivement en vous identifiant avec ce pseudonyme puis en utilisant la commande suivante :
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ drop [pseudonyme]
</p>
<p class="spaced">
  Notez que pour changer votre mot de passe, il faut d'abord vous identifier, puis utiliser drop pour libérer votre pseudonyme définitivement, et ensuite utiliser register pour l'enregistrer à nouveau avec un mot de passe différent.
</p>
EOD;


  // CHANSERV
  $trad['cs_titre']         = "Qu'est-ce que ChanServ ?";
  $trad['cs_desc']          = <<<EOD
<p class="spaced">
  Le serveur IRC NoBleme utilise les services <a class="gras" href="http://www.anope.org/">Anope</a>, qui créent quelques utilisateurs non-humains sur le serveur. Parmi ces utilisateurs se trouve ChanServ (service des canaux), qui vous permet de créer et de gérer vos propres canaux IRC.
</p>
<p class="spaced">
  Les intéractions avec ChanServ se font par messages privés ayant pour destinataire ChanServ, qui vous renverra des réponses automatisées. Ces intéractions se font donc sous formes de commandes, référez-vous à l'onglet COMMANDES de cette page si vous ne comprenez pas comment les commandes fonctionnent sur IRC.
</p>
<p class="spaced">
  Dans cette section, nous allons voir les diverses commandes utiles aux opérateurs pour administrer un canal IRC, ainsi que comment créer et gérer votre propre canal IRC.
</p>
EOD;

  // CHANSERV : Administrer
  $trad['cs_op_titre']      = "Administrer un canal IRC";
  $trad['cs_op_desc']       = <<<EOD
<p class="spaced">
  Les commandes listées dans le tableau ci-dessous ne vous sont accessibles que si vous êtes au minimum halfop dans un canal IRC. Le niveau minimum requis pour chaque commande correspond au degré de pouvoir nécessaire pour avoir le droit d'effectuer l'action en question. Vous trouverez une liste des niveaux de pouvoir dans l'onglet INFOS de cette page.
</p>
<p class="spaced">
  La majorité des commandes qui sont listées ici dépendent de votre client IRC. Ces commandes varient d'un client à l'autre, par conséquent il n'y a aucune garantie qu'elles fonctionnent chez vous. La plupart des clients proposent une interface alternative à ces commandes (par exemple, dans beaucoup de clients IRC, au lieu de de faire /kick Planeshift, vous pouvez cliquer sur Planeshift et une option kicker apparaitra sur laquelle vous pourrez cliquer).
</p>
<p class="spaced">
  Les commandes que vous verrez dans le tableau ci-dessous contiennent parfois du texte entre [crochets]. Lorsque c'est le cas, cela signifie qu'il s'agit de texte variable, et que c'est à vous de remplacer ce texte par le contenu spécifique que vous désirez, sans les crochets. Par exemple, dans la commande /kick [pseudonyme], vous devez laisser le /kick tel quel, mais remplacer [pseudonyme] par le pseudonyme d'un utilisateur, ce qui donne une commande comme /kick Planeshift
</p>
<p class="spaced">
  Lorsque vous verrez [masque] apparaitre, il s'agit de ce qu'on appelle un masque d'hôte, une façon spécifique d'identifier un utilisateur que vous pouvez trouver en faisant un /whois [pseudonyme]. Vous pouvez trouver une bonne explication du format des masques d'hôte en <a class="gras" href="https://fr.wikipedia.org/wiki/Hostmask">cliquant ici</a>
</p>
EOD;

  // CHANSERV : Administrer - Tableau
  $trad['cs_op_commande']   = "COMMANDE ET EXEMPLE";
  $trad['cs_op_niveau']     = "NIVEAU<br>MINIMUM";
  $trad['cs_op_effet']      = "EFFET DE LA COMMANDE";
  $trad['cs_op_topic']      = "/topic [canal] [contenu]";
  $trad['cs_op_topic_e']    = "/topic #NoBleme Bienvenue ici";
  $trad['cs_op_topic_d']    = "Change le sujet du canal (le sujet est un court texte que tout le monde voit lorsqu'il se connecte au canal)";
  $trad['cs_op_kick']       = "/kick [pseudonyme] [raison]";
  $trad['cs_op_kick_e']     = "/kick Planeshift Tu sors !";
  $trad['cs_op_kick_d']     = "Éjecte un utilisateur hors du canal. La raison est optionnelle, vous pouvez juste /kick [pseudonyme] sans spécifier de raison.";
  $trad['cs_op_ban']        = "/mode [canal] +b [masque]";
  $trad['cs_op_ban_e']      = "/mode #NoBleme +b *!*@*xxx.fr";
  $trad['cs_op_ban_d']      = "Bannit tous les utilisateurs correspondant au masque d'hôte spécifié. Ils ne peuvent plus envoyer de messages sur le canal. S'ils sont kickés du canal, ils ne pourront plus le rejoindre.";
  $trad['cs_op_deban']      = "/mode [canal] -b [masque]";
  $trad['cs_op_deban_e']    = "/mode #NoBleme -b *!*@*xxx.fr";
  $trad['cs_op_deban_d']    = "Retire le ban sur le masque d'hôte spécifié, permettant aux utilisateurs correspondants de rejoindre le canal à nouveau.";
  $trad['cs_op_mute']       = "/mode [canal] +m";
  $trad['cs_op_mute_e']     = "/mode #dev +m";
  $trad['cs_op_mute_d']     = "Bascule le canal en mode muet : seuls les utilisateurs de niveau voix ou plus peuvent discuter sur le canal.";
  $trad['cs_op_unmute']     = "/mode [canal] -m";
  $trad['cs_op_unmute_e']   = "/mode #dev -m";
  $trad['cs_op_unmute_d']   = "Retire le mode muet du canal, tout le monde peut à nouveau discuter sur le canal.";
  $trad['cs_op_vop']        = "/msg ChanServ vop [canal] add [pseudonyme]";
  $trad['cs_op_vop_e']      = "/msg ChanServ vop #dev add Trucy";
  $trad['cs_op_vop_d']      = "Donne le pouvoir voix à un utilisateur du canal.";
  $trad['cs_op_hop']        = "/msg ChanServ hop [canal] add [pseudonyme]";
  $trad['cs_op_hop_e']      = "/msg ChanServ hop #dev add Bruce";
  $trad['cs_op_hop_d']      = "Donne le pouvoir halfop à un utilisateur du canal.";
  $trad['cs_op_aop']        = "/msg ChanServ aop [canal] add [pseudonyme]";
  $trad['cs_op_aop_e']      = "/msg ChanServ aop #NoBleme add Planeshift";
  $trad['cs_op_aop_d']      = "Donne le pouvoir opérateur à un utilisateur du canal.";
  $trad['cs_op_sop']        = "/msg ChanServ sop [canal] add [pseudonyme]";
  $trad['cs_op_sop_e']      = "/msg ChanServ sop #NoBleme add Akundo";
  $trad['cs_op_sop_f']      = "Fondateur";
  $trad['cs_op_sop_d']      = "Donne le pouvoir superop à un utilisateur du canal.";
  $trad['cs_op_deop']       = "/msg ChanServ aop [canal] del [pseudonyme]";
  $trad['cs_op_deop_e']     = "/msg ChanServ aop #NoBleme del Exirel";
  $trad['cs_op_deop_d']     = "Retire le pouvoir opérateur à un utilisateur du canal. Vous pouvez substituer vop, hop, ou sop à aop dans cette commande pour retirer les autres niveaux de permission.";

  // CHANSERV : Puis-je ?
  $trad['cs_cani_titre']    = "Puis-je créer mon propre canal de discussion sur NoBleme ?";
  $trad['cs_cani_desc']     = <<<EOD
<p class="spaced">
  Si vous désirez créer votre propre canal, même si c'est pour vos amis qui ne sont pas NoBlemeux, vous êtes libres de le faire sans demander la permission. La seule condition est que vous soyez vous-même un NoBlemeux, et que vous fassiez respecter le <a class="gras" href="{$chemin}pages/doc/coc">code de conduite de NoBleme</a> sur votre canal.
</p>
<p class="spaced">
  Toutefois, si vous n'êtes pas un régulier de NoBleme et désirez utiliser le serveur pour créer votre propre canal, votre canal se fera probablement fermer. Il existe de nombreux autres serveurs IRC (vous pouvez trouver une liste des plus populaires <a class="gras" href="http://irc.netsplit.de/networks/top100.php">assez facilement</a>), et je préfère que le serveur IRC de NoBleme reste un serveur centré sur la communauté du site.
</p>
<p class="spaced">
  Si vous désirez créer un canal IRC public où tout le monde est bienvenu, envoyez un message privé à <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> pour qu'il soit ajouté à la <a class="gras" href="{$chemin}pages/irc/canaux">liste des canaux</a>, ce qui lui donnera de la visibilité.
</p>
EOD;

  // CHANSERV : Créer un canal
  $trad['cs_creer_titre']   = "Créer et gérer un canal IRC";
  $trad['cs_creer_desc']    = <<<EOD
<p class="spaced">
  Les commandes utilisées dans les exemples contiennent du texte entre [crochets]. Lorsque c'est le cas, cela signifie qu'il s'agit de texte variable, et que c'est à vous de remplacer ce texte par le contenu spécifique que vous désirez, sans les crochets. Par exemple, dans la commande /msg ChanServ register [canal], vous devez laisser le /msg ChanServ register tel quel, mais remplacer [canal] par le canal désiré, ce qui donne une commande telle que /msg ChanServ register #MonCanal
</p>
<p class="spaced">
  Pour commencer, la première chose dont vous aurez besoin est la commande pour enregistrer votre propre canal. Notez bien entendu que cette commande ne fonctionne que pour des canaux qui ne sont pas encore enregistrés par quelqu'un d'autre :
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ register [canal]
</p>
<p class="spaced">
  Maintenant que vous avez enregistré votre canal IRC, vous en êtes le fondateur et avez tous les droits dessus. Vous aurez peut-être besoin d'ajouter des opérateurs pour vous aider à gérer le canal, vous pouvez retrouver les commandes de modification des permissions dans le tableau qui se trouve plus haut dans la page.
</p>
<br>
<p class="spaced">
  Peut-être que vous désirez rendre privé le canal que vous venez de créer, afin qu'il n'apparaisse pas dans la liste des canaux du serveur. Si c'est le cas, utilisez la commande suivante :
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ mode [canal] set +s
</p>
<p class="spaced">
  Si vous désirez annuler l'effet de cette commande et rendre votre canal public, remplacez +s par -s.
</p>
<br>
<p class="spaced">
  Peut-être désirez vous aller encore plus loin et créer un canal privé que seuls des gens spécifiques peuvent rejoindre. Si vous désirez créer votre zone fermée de discussion, commencez par utiliser la commande suivante :
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ mode [canal] set +i
</p>
<p class="spaced">
  Votre canal est maintenant en mode « invitation uniquement », seuls les utilisateurs invités peuvent le rejoindre. Maintenant, il faut ajouter un par un les utilisateurs qui auront le droit de rejoindre votre canal, avec la commande suivante pour chacun d'eux :
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ mode [canal] set +I [masque]
</p>
<p class="spaced">
  [masque] représente un masque d'hôte. Si vous ne comprenez pas comment fonctionne un masque d'hôte, vous pouvez juste spécifier le pseudonyme de la personne invitée de la façon suivante : [pseudonyme]!*@* , ce qui donne par exemple la commande suivante : /msg ChanServ mode #MonCanal set +I Bad!*@*
</p>
<p class="spaced">
  Comme pour le mode +s, vous pouvez annuler le mode +i ou +I [masque] en les remplacant par -i et -I [masque] dans leurs commandes respectives.
</p>
<br>
<p class="spaced">
  Si un jour vous en avez marre de gérer un canal et désirez vous en débarrasser, ou désirez laisser quelqu'un d'autre l'enregistrer à la place pour transférer le pouvoir de fondateur, vous pouvez utiliser la commande suivante pour perdre tous les droits sur un canal et en supprimer complètement la configuration :
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ drop [canal] [canal]
</p>
<p class="spaced">
  Il est nécessaire d'écrire le nom du canal deux fois de suite, c'est une mesure préventive pour éviter d'écrire la commande pour le mauvais canal par accident.
</p>
EOD;


  // AKUNDO
  $trad['akundo_titre']     = "Qui est Akundo ?";
  $trad['akundo_desc']      = <<<EOD
<p class="spaced">
  Akundo est ce que l'on appelle un bot, une non-intelligence artificielle appartenant à <a class="gras" href="{$chemin}pages/user/user?pseudo=ThArGos">ThArGos</a> qui est présent sur quelques canaux IRC du serveur NoBleme. Son utilité est de retenir et de régurgiter des bêtises à la demande.
</p>
<p class="spaced">
  Akundo réagit à certains mots ou certaines phrases et renvoie une réponse prédéfinie. Notez toutefois que si vous abusez d'Akundo dans le seul but de polluer un canal de discussion, vous vous retrouverez exclu de ce canal.
</p>
<p class="spaced">
  Si vous êtes lourdé par Akundo (compréhensible), vous pouvez utiliser la commande /ignore Akundo pour ne plus voir les messages qu'il poste sur les canaux où il est présent.
</p>
<p class="spaced">
  Akundo permet également de générer des statistiques sur l'utilisation du canal #NoBleme. Vous pouvez retrouver ces statistiques ici : <a class="gras" href="http://www.hobeika.fr/~vincent/stuff/irc/logs.html">derniers 365 jours</a> (mis à jour quotidiennement), <a class="gras" href="http://www.hobeika.fr/~vincent/stuff/irc/logs-all.html">depuis 2007</a> (mis à jour mensuellement).
</p>
<p class="spaced">
  Voici des exemples stupides d'Akundo se faisant déclencher par une phrase, puis par plusieurs mots-clés, puis ressortant une définition qu'il a été utilisé pour mémoriser :
</p>
EOD;

  // AKUNDO : Liste des commandes
  $trad['akunliste_titre']  = "Où trouver la liste des déclencheurs et des définitions ?";
  $trad['akunliste_desc']   = <<<EOD
<p class="spaced">
  Nulle part. Les déclencheurs qui font réagir Akundo sont changés régulièrement, et le but est qu'ils soient découverts par accident lors de conversations. Lorsqu'un déclencheur perd son aspect amusant ou pourrit trop les conversations, il sera supprimé ou renommé.
</p>
<p class="spaced">
  Seuls <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> et <a class="gras" href="{$chemin}pages/user/user?pseudo=ThArGos">ThArGos</a> peuvent modifier les déclencheurs et définitions auxquels Akundo réagit.
</p>
EOD;

  // AKUNDO : NoBleme-trivia
  $trad['akuntrivia_titre'] = "Le #NoBleme-trivia, jeu de mots via Akundo";
  $trad['akuntrivia_desc']  = <<<EOD
<p class="spaced">
  Akundo possède également une fonctionnalité ludique, un jeu de <a class="gras" href="https://fr.wikipedia.org/wiki/Motus_(jeu_t%C3%A9l%C3%A9vis%C3%A9)">motus</a> multijoueur dans lequel vous cherchez à deviner un mot d'une taille fixe, et Akundo vous répond par des indices vous disant si vous avez trouvé des lettres bien placées (en vert) ou des lettres présentes dans le mot mais mal placées (en rouge).
</p>
<p class="spaced">
  Pour jouer au Motus d'Akundo, commencez par annoncer sur NoBleme que vous avez envie de faire un #NoBleme-trivia pour trouver des participants (sauf si vous voulez jouer seul), puis rejoignez le <a class="gras" href="{$chemin}pages/irc/canaux">canal de discussion</a> #NoBleme-trivia et écrivez « !motus » dans le canal pour démarrer une partie. Akundo devrait normalement vous proposer un mot vide d'une certaine longueur, il ne vous reste plus qu'à écrire des mots de cette longueur pour qu'Akundo vous réponde et que la partie avance. Au cas où les règles ne seraient pas claires, voici une capture d'écran d'une brève partie en solo :
</p>
EOD;
}




// Maintenant, en anglais
else
{
  // Header
  $trad['titre']            = "IRC : Commands and services";
  $trad['soustitre']        = "Compendium of useful information to enhance your IRC experience";

  // Onglets
  $trad['onglet_default']   = "IRC";
  $trad['onglet_infos']     = "REFERENCE";
  $trad['onglet_commandes'] = "COMMANDS";
  $trad['onglet_nickserv']  = "NICKSERV";
  $trad['onglet_chanserv']  = "CHANSERV";


  // IRC
  $trad['irc_titre']        = "Useful information about IRC";
  $trad['irc_desc']         = <<<EOD
<p class="spaced">
  I collected on this page a bunch of information that could be useful during your stay on <a class="gras" href="{$chemin}pages/irc/index">NoBleme's IRC server</a> (or on IRC in general if you also use other servers). IRC can be strange and confusing at first, the goal of this page is to give answers in advance to as many questions as possible that you could be asking yourself.
</p>
<p class="spaced">
  The <span class="gras texte_noir">REFERENCE</span> tab contains a mini dictionary of IRC related vocabulary, aswell as a guide on those weird symbols that you often see next to nicknames on IRC.
</p>
<p class="spaced">
  The <span class="gras texte_noir">COMMANDS</span> tab contains a list of basic commands that you might need to use on IRC, if you want to do things such as changing your nickname, having a private conversation with someone else, joining or leaving channels, etc.
</p>
<p class="spaced">
  The <span class="gras texte_noir">NICKSERV</span> tab is a documentation of the nickname registration service, which allows you to protect your identity from being usurpated by other people.
</p>
<p class="spaced">
  The <span class="gras texte_noir">CHANSERV</span> tab is a documentation of the channel registration service and more generally a guide on registering and managing a channel of your own.
</p>
EOD;


  // INFOS
  $trad['infos_ref_titre']  = "Mini-dictionary of IRC related vocabulary";
  $trad['infos_r_serveur']  = <<<EOD
<span class="gras texte_noir">Server</span>: The server is the interface to which everyone is connected in order to talk on IRC. Whenever you send a message on IRC, it is first sent to the server, which then redistributes it to the people who should see that message. In NoBleme's case, the server is a program called <a class="gras" href="https://en.wikipedia.org/wiki/UnrealIRCd">UnrealIRCd</a>.
EOD;
  $trad['infos_r_client']   = <<<EOD
<span class="gras texte_noir">Client</span>: An IRC client is a program that serves as an interface between a user and an IRC server, it is what you use to chat on IRC. A client can be software that you install on your computer (such as <a class="gras" href="https://hexchat.github.io/">HexChat</a>) just as well as it can be a service on a website (such as <a class="gras" href="https://kiwiirc.com/">KiwiIRC</a>). Each IRC client has its own appearance and settings, which means that everyone sees IRC differently.
EOD;
  $trad['infos_r_canal']    = <<<EOD
<span class="gras texte_noir">Channel</span>: An IRC server is comprised of an unilimited number of channels, which can be public or private. When a message is sent on an IRC channel, only the users present on that channel will be able to see the message. You can tell something on IRC is a channel by the fact that its name starts with a pound sign (like #english or #overwatch). You can find more information about IRC channels on <a class="gras" href="{$chemin}pages/irc/canaux">NoBleme's channel list</a>.
EOD;
  $trad['infos_r_op']       = <<<EOD
<span class="gras texte_noir">Operator</span>: On an IRC channel, each user has different power levels. A channel's founder can give some powers to specific users (such as kicking undesirable users), which are called operators. Different access levels give access to different powers, those are documented at the bottom of the page that you are reading right now.
EOD;
  $trad['infos_r_ircop']    = <<<EOD
<span class="gras texte_noir">IRCop</span>: Global operators of sorts, IRCops have power over the whole IRC server. They can shut down channels, issue server-wide bans on users, and more. Their powers are only used in extreme cases. In order to avoid someone tracking their absence to do mischievious acts, their number and identity on NoBleme's IRC server will remain a secret.
EOD;
  $trad['infos_r_commande'] = <<<EOD
<span class="gras texte_noir">Command</span>: On IRC, in order to do actions other than talking, you must use commands. They are messages which begin with a slash, and contain instructions that will be interpreted by your client or the server. For example, /join allows you to join a channel and /msg allows you to send private messages. The COMMANDS tab of this page lists of a few useful commands.
EOD;
  $trad['infos_r_kick']     = <<<EOD
<span class="gras texte_noir">Kick</span>: Kicking someone from an IRC channel is nothing more than a warning shot, as a kicked user can instantly rejoin the channel he was kicked from.
EOD;
  $trad['infos_r_ban']      = <<<EOD
<span class="gras texte_noir">Ban</span>: As its name implies, a ban is a harsher form of punishment. A banned user can not talk at all in a channel from which he is banned, and will not be able to rejoin it if he gets kicked from it.
EOD;
  $trad['infos_r_mode']     = <<<EOD
<span class="gras texte_noir">Mode</span>: On IRC, every user and every channel have what we call modes, various options that are represented by letters. I will spare you the list of all existing modes (there are a lot), but a good example to know is that when a channel has the +m mode activated, it is in mute mode: only operators and voiced users can chat in that channel, the rest won't be able to send messages. This ends once mode -m is applied to the channel, which removes mute mode.
EOD;
  $trad['infos_r_bip']      = <<<EOD
<span class="gras texte_noir">Highlight</span>: In most IRC clients, when someone else writes your nickname, you will hear a beeping sound and/or see the line of text where your nickname appeared highlighted. Thus, highlighting someone is the term used for when you use someone else's nickname in a message on IRC. It is sometimes shortened to just hl.
EOD;
  $trad['infos_r_ignore']   = <<<EOD
<span class="gras texte_noir">Ignore</span>: When someone cannot stand someone else, they have the option of using the ignore command in their client to ignore that other person. Once you have someone on ignore, you will not see the messages he posts in IRC channels. It is a useful way to solve tense situations without creating unnecessary drama.
EOD;
  $trad['infos_r_lurk']     = <<<EOD
<span class="gras texte_noir">Lurk</span>: A lurker is someone who idles in an IRC channel without sending any messages. Lurkers are as welcome as everyone else on NoBleme's IRC server, we understand that everyone doesn't feel comfortable talking to strangers right away.
EOD;

  // INFOS : Opérateurs
  $trad['infos_ops']        = "Operators and user symbols";
  $trad['infos_ops_desc']   = <<<EOD
On IRC channels, users can have various power levels. Each power level comes from a user mode (such as +o for operators, +q for channel founder, etc). In most IRC clients, these power levels are represented with a specific symbol which appears before the user's nickname (for example @ for operators and ~ for the channel's founder). Therefore, when you see a symbol before a user's nickname (like @Planeshift or ~Bad), you will know that this user has powers on the channel you are currently on. Here's a table listing the power levels you can find on IRC:
EOD;

  // INFOS : Tableau des opérateurs
  $trad['infos_o_symbole']  = "SYMBOL";
  $trad['infos_o_titre']    = "TITLE";
  $trad['infos_o_mode']     = "MODE";
  $trad['infos_o_pouvoirs'] = "POWERS";
  $trad['infos_o_ou']       = "or";
  $trad['infos_o_u']        = "User";
  $trad['infos_o_u_desc']   = "Does not have any powers";
  $trad['infos_o_v']        = "Voiced";
  $trad['infos_o_v_desc']   = "Does not have any powers. If the channel switches to mute mode (+m), a voiced user will still be able to send messages on the channel.";
  $trad['infos_o_h']        = "Halfop";
  $trad['infos_o_h_desc']   = "Half operator. Can kick and ban normal and voiced users. Can change channel settings.";
  $trad['infos_o_o']        = "Operator";
  $trad['infos_o_o_desc']   = "Can kick and ban normal users, voiced users, and halfops. Can change channel settings.";
  $trad['infos_o_a']        = "Superop";
  $trad['infos_o_a_desc']   = "Can kick and ban normal users, voiced users, halfops, and operators. Can change channel settings and can change other users' power levels.";
  $trad['infos_o_q']        = "Founder";
  $trad['infos_o_q_desc']   = "The user who founded the channel. Can do anything on the channel, and cannot be kicked and banned by anyone except himself.";


  // COMMANDES
  $trad['com_titre']        = "A few useful IRC commands";
  $trad['com_desc']         = <<<EOD
On IRC, in order to do actions other than chatting, you must use commands. Commands are messages that begin with a slash and contain instructions for your client or the server (for example /join or /msg). If you don't understand some of the vocabulary used here, some of it is defined in the REFERENCE tab.
EOD;
  $trad['com_desc_2']       = <<<EOD
Most of the commands listed here depend on your IRC client: the way they are written or interpreted varies from client to client, and there is no guarantee that they will work for you (though they do on most clients). Usually, clients also include a visual way to execute those commands, for example in some clients instead of typing /whois Bad, you might be able to click on Bad in the user list and execute the whois action from there.
EOD;
  $trad['com_desc_3']       = <<<EOD
The commands in the table below sometimes contain text between [brackets]. It represents variable text, which you should replace by the contents you desire. For example, when the command /join [channel] is listed, you should leave the /join as is, but replace the [channel] by the name of a channel, as in /join #english
EOD;
  $trad['com_desc_4']       = <<<EOD
You will find more commands related to nickname management in the NICKSERV tab, and commands related to operators and channel management in the CHANSERV tab.
EOD;

  // COMMANDES : Tableau
  $trad['com_t_commande']   = "COMMAND";
  $trad['com_t_exemple']    = "EXAMPLE";
  $trad['com_t_effet']      = "RESULT";
  $trad['com_t_clear_d']    = "Removes all the text currently on your screen";
  $trad['com_t_list_d']     = "Lists all non-hidden IRC channels on the server";
  $trad['com_t_join']       = "/join [channel]";
  $trad['com_t_join_e']     = "/join #english";
  $trad['com_t_join_d']     = "Joins the specified channel";
  $trad['com_t_part']       = "/part [channel]";
  $trad['com_t_part_e']     = "/part #english";
  $trad['com_t_part_d']     = "Leaves the specified channel";
  $trad['com_t_quit_d']     = "Disconnects you from the server and exits your client";
  $trad['com_t_nick']       = "/nick [nickname]";
  $trad['com_t_nick_d']     = "Changes the nickname that you are currently using";
  $trad['com_t_whois']      = "/whois [nickname]";
  $trad['com_t_whois_d']    = "Returns various informations about the specified user";
  $trad['com_t_msg']        = "/msg [nickname] [message]";
  $trad['com_t_msg_e']      = "/msg Bad What's up?";
  $trad['com_t_msg_d']      = "Sends a private message that only the specified user will see";
  $trad['com_t_ignore']     = "/ignore [nickname]";
  $trad['com_t_ignore_d']   = "Blocks all messages coming from the specified user";


  // NICKSERV
  $trad['ns_titre']         = "What is NickServ?";
  $trad['ns_desc']          = <<<EOD
<p class="spaced">
  NoBleme's IRC server uses <a class="gras" href="http://www.anope.org/">Anope services</a>, which spawn a few non human users on the server. One of those automated users is called NickServ, and allows you to register your nickname so that it can not be usurpated by other users.
</p>
<p class="spaced">
  Interactions with NickServ are done through private messages sent to NickServ, which will reply with automated answers. This means you interact with NickServ using commands, see the COMMANDS tab if you don't understand how commands work.
</p>
<p class="spaced">
  In this section, we will learn how to register your nickname, how to authentify yourself, and how to recover your nickname if it's being used. Before we do that, please take notes of two important rules: <span class="gras souligne texte_noir">you can not recover a lost password</span>, so make sure you remember the password you use to register your nickname, and <span class="gras souligne texte_noir">you will be punished if you abuse this service to steal someone else's nickname</span>, NoBleme's IRCops have the power to recover those nicknames and ban you from the server.
</p>
EOD;

  // NICKSERV : Enregistrer
  $trad['ns_reg_titre']     = "Registering your nickname";
  $trad['ns_reg_desc']      = <<<EOD
<p class="spaced">
  The commands listed below sometimes contain text between [brackets]. It represents variable text, which you should replace by the contents you desire. For example, in the command /msg NickServ identify [password], you should leave the /msg NickServ identify part as is, but replace the [password] by your password, as in /msg NickServ identify hunter2
</p>
<p class="spaced">
  NickServ's use being nickname management, we must first register your nickname before we can do anything else with it. Start by using this command:
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ register [password]
</p>
<br>
<p class="spaced">
  Now that your nickname has been registered, it is automatically protected by NickServ. If someone else tries to use your nickname, they will be booted from it after a minute. However, this means that when you connect to NoBleme's IRC server, you will have one minute to identify yourself before NickServ boots you from your own nickname. In order to identify, you must use the following command:
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ identify [password]
</p>
<p class="spaced">
  In most IRC clients, you can specify commands that should be used whenever you connect to a server. If you don't want to have to identify manually every time you connect to NoBleme's server, you might want to add that command to your client's auto-connect command lists (if it has that feature).
</p>
<br>
<p class="spaced">
  Now that you are the official owner of your nickname, you might find yourself in a situation where you must recover your nickname. It could be because someone else is using it, because you got disconnected due to internet issues and a copy of you lingers on the server, or because you got locked out of your nickname by services due to not identifying fast enough. When this happens, use the following command to regain ownership of your nickname:
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ recover [nickname] [password]
</p>
<p class="spaced">
  Obviously, once you have recovered your nickname, you must then use the /nick [nickname] command to change your nickname.
</p>
<br>
<p class="spaced">
  If for some reason you do not want your nickname to be registered on NickServ anymore, you can remove it from its database by using the following command:
</p>
<p class="spaced monospace texte_noir gras">
  /msg NickServ drop [nickname]
</p>
<p class="spaced">
  Useful tip: if you ever want to change your password on NickServ, you must first drop your nickname then register it once again with a new password.
</p>
EOD;


  // CHANSERV
  $trad['cs_titre']         = "What is ChanServ?";
  $trad['cs_desc']          = <<<EOD
<p class="spaced">
  NoBleme's IRC server uses <a class="gras" href="http://www.anope.org/">Anope services</a>, which spawn a few non human users on the server. One of those automated users is called ChanServ, and allows you to register and manage your own channels.
</p>
<p class="spaced">
  Interactions with ChanServ are done through private messages sent to ChanServ, which will reply with automated answers. This means you interact with ChanServ using commands, see the COMMANDS tab if you don't understand how commands work.
</p>
<p class="spaced">
  In this section, we will first list a few commands useful to operators and founders when managing their channels, then see how to register and manage a channel of your own.
</p>
EOD;

  // CHANSERV : Administrer
  $trad['cs_op_titre']      = "IRC channel administration";
  $trad['cs_op_desc']       = <<<EOD
<p class="spaced">
  Commands listed in the table below are only available to you on channels where you are halfop or higher. For each command, a minimum acess level is listed, which is the mode you need to have in a channel in order to use that command. Explanations on access levels are given in the REFERENCE tab of this page.
</p>
<p class="spaced">
  Most of the commands listed here depend on your IRC client: the way they are written or interpreted varies from client to client, and there is no guarantee that they will work for you (though they do on most clients). Usually, clients also include a visual way to execute those commands, for example in some clients instead of typing /kick moop, you might be able to click on moop in the user list and execute the kick action from there.
</p>
<p class="spaced">
  The commands listed below sometimes contain text between [brackets]. It represents variable text, which you should replace by the contents you desire. For example, in the command /kick [nickname], you should leave the /kick as is, but replace the [nickname] by the nickname of the person you want to kick, as in /kick moop
</p>
<p class="spaced">
  When you see the parameter [mask], you should replace it with a hostmask, a specific way of identifying a unique user which you can find by using the /whois [username] command. You can find a good documentation on hostmasks by <a class="gras" href="https://www.afternet.org/help/irc/hostmasks">clicking here</a>
</p>
EOD;

  // CHANSERV : Administrer - Tableau
  $trad['cs_op_commande']   = "COMMAND AND EXAMPLE";
  $trad['cs_op_niveau']     = "MINIMUM<br>ACCESS";
  $trad['cs_op_effet']      = "COMMAND EFFECTS";
  $trad['cs_op_topic']      = "/topic [channel] [text]";
  $trad['cs_op_topic_e']    = "/topic #english Welcome, stranger";
  $trad['cs_op_topic_d']    = "Changes the channel's topic (a topic is a short piece of text that everyone sees when joining the channel)";
  $trad['cs_op_kick']       = "/kick [nickname] [reason]";
  $trad['cs_op_kick_e']     = "/kick moop Go away!";
  $trad['cs_op_kick_d']     = "Kicks a user from the channel. The reason part is optional, you can kick a user without specifying a reason.";
  $trad['cs_op_ban']        = "/mode [channel] +b [mask]";
  $trad['cs_op_ban_e']      = "/mode #english +b *!*@*xxx.co.uk";
  $trad['cs_op_ban_d']      = "Bans all users with the specified hostmask.";
  $trad['cs_op_deban']      = "/mode [channel] -b [mask]";
  $trad['cs_op_deban_e']    = "/mode #english -b *!*@*xxx.co.uk";
  $trad['cs_op_deban_d']    = "Unbans all users with the specified hostmask.";
  $trad['cs_op_mute']       = "/mode [channel] +m";
  $trad['cs_op_mute_e']     = "/mode #english +m";
  $trad['cs_op_mute_d']     = "Changes the channel to mute mode: only voiced or higher users can chat on the channel";
  $trad['cs_op_unmute']     = "/mode [channel] -m";
  $trad['cs_op_unmute_e']   = "/mode #english -m";
  $trad['cs_op_unmute_d']   = "Removes mute mode from the channel, everyone can once again chat on it";
  $trad['cs_op_vop']        = "/msg ChanServ vop [channel] add [nickname]";
  $trad['cs_op_vop_e']      = "/msg ChanServ vop #english add moop";
  $trad['cs_op_vop_d']      = "Gives permanent voiced access to a user.";
  $trad['cs_op_hop']        = "/msg ChanServ hop [channel] add [nickname]";
  $trad['cs_op_hop_e']      = "/msg ChanServ hop #english add ThArGos";
  $trad['cs_op_hop_d']      = "Makes a user a permanent halfop on the channel.";
  $trad['cs_op_aop']        = "/msg ChanServ aop [channel] add [nickname]";
  $trad['cs_op_aop_e']      = "/msg ChanServ aop #english add Andreas";
  $trad['cs_op_aop_d']      = "Makes a user a permanent operator on the channel.";
  $trad['cs_op_sop']        = "/msg ChanServ sop [channel] add [nickname]";
  $trad['cs_op_sop_e']      = "/msg ChanServ sop #english add Akundo";
  $trad['cs_op_sop_f']      = "Founder";
  $trad['cs_op_sop_d']      = "Makes a user a permanent superop on the channel.";
  $trad['cs_op_deop']       = "/msg ChanServ aop [channel] del [nickname]";
  $trad['cs_op_deop_e']     = "/msg ChanServ aop #english del Exirel";
  $trad['cs_op_deop_d']     = "Removes operator access from a user on the channel. You can substitute aop with vop, hop, and sop to remove other access levels.";

  // CHANSERV : Puis-je ?
  $trad['cs_cani_titre']    = "May I create my own channel on NoBleme's IRC server?";
  $trad['cs_cani_desc']     = <<<EOD
<p class="spaced">
  If you want to create your own channel on the server, even if it is for your friends who don't use NoBleme, that's fine by me, you can do it without asking. The only conditions are that you must yourself be a part of the NoBleme community, and that you enforce NoBleme's <a class="gras" href="{$chemin}pages/doc/coc">code of conduct</a> on the channel you create.
</p>
<p class="spaced">
  However, if you are not part of NoBleme's community and want to host your own channel on the server, it will probably end up getting closed. There are many other IRC servers (you can <a class="gras" href="http://irc.netsplit.de/networks/top100.php">easily</a> find a list of the most popular ones), and I would prefer NoBleme's IRC server to remain centered on the website's community.
</p>
<p class="spaced">
  If the channel you want to create is meant to be public, you should send <a class="gras" href="{$chemin}pages/user/user?id=1">Bad</a> a private message so that it gets added to the <a class="gras" href="{$chemin}pages/irc/canaux">channel list</a>, which will give some visibility to your channel.
</p>
EOD;

  // CHANSERV : Créer un canal
  $trad['cs_creer_titre']   = "Creating and managing an IRC channel";
  $trad['cs_creer_desc']    = <<<EOD
<p class="spaced">
  The commands listed below sometimes contain text between [brackets]. It represents variable text, which you should replace by the contents you desire. For example, in the command /msg ChanServ register [channel], you should leave the /msg ChanServ register part as is, but replace the [channel] by your channel's name, as in /msg ChanServ register #MyChannel
</p>
<p class="spaced">
  Let's get started by registering your channel. Obviously, this command will only work if the channel has not already been registered by someone else.
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ register [channel]
</p>
<p class="spaced">
  Now that you have registered your own IRC channel, you have founder access to it. You might need to add some operators to help you manage the channel. You can find the commands to add and remove operators in the table located higher in the page you are currently reading.
</p>
<br>
<p class="spaced">
  If the channel that you have just created needs to be a private channel and you do not want it appear on the public channel list, you can use the following command:
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ mode [channel] set +s
</p>
<p class="spaced">
  You can revert this anytime by using the same command with -s instead of +s.
</p>
<br>
<p class="spaced">
  If you desire to go further and make that channel fully private, you can set it into invite only mode. In this mode, only specific users that you add yourself one by one are allowed to join the channel.
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ mode [channel] set +i
</p>
<p class="spaced">
  Now that your channel is invite only, you can add users who are allowed to join it one by one using this command:
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ mode [channel] set +I [mask]
</p>
<p class="spaced">
  [mask] is a hostmask. If you do not understand how hostmasks work, you can add users using the following hostmask format: [nickname]!*@* , which for example leads to the following command: /msg ChanServ mode #MyChannel set +I Bad!*@*
</p>
<p class="spaced">
  As with +s, you can cancel +i and +I [mask] modes by setting -i and -I [mask] modes.
</p>
<br>
<p class="spaced">
  If you don't want to own your channel anymore, you can resign from the founder position and delete all of the channel settings by using the following command:
</p>
<p class="spaced monospace texte_noir gras">
  /msg ChanServ drop [channel] [channel]
</p>
<p class="spaced">
  Writing the channel name twice in a row is not a typo, it's a security measure that helps with preventing people typing this command by accident.
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
            <a id="default_onglet" class="bouton_onglet onglet_actif" onclick="ouvrirOnglet(event, 'default')">
              <?=$trad['onglet_default']?>
            </a>
          </li>
          <li>
            <a id="infos_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'infos')">
              <?=$trad['onglet_infos']?>
            </a>
          </li>
          <li>
            <a id="commandes_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'commandes')">
              <?=$trad['onglet_commandes']?>
            </a>
          </li>
          <li>
            <a id="nickserv_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'nickserv')">
              <?=$trad['onglet_nickserv']?>
            </a>
          </li>
          <li>
            <a id="chanserv_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'chanserv')">
              <?=$trad['onglet_chanserv']?>
            </a>
          </li>
          <?php if($lang == 'FR') { ?>
          <li>
            <a id="akundo_onglet" class="bouton_onglet" onclick="ouvrirOnglet(event, 'akundo')">
              <?=$trad['onglet_akundo']?>
            </a>
          </li>
          <?php } ?>
        </ul>




        <div id="default" class="contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['irc_titre']?></h5>

          <?=$trad['irc_desc']?>

          <br>

        </div>




        <div id="infos" class="hidden contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['infos_ref_titre']?></h5>

          <br>

          <ul class="spaced">
            <li>
              <?=$trad['infos_r_serveur']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_client']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_canal']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_op']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_ircop']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_commande']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_kick']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_ban']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_mode']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_bip']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_ignore']?><br>
              <br>
            </li>
            <li>
              <?=$trad['infos_r_lurk']?><br>
              <br>
            </li>
          </ul>

          <br>

          <h5 class="alinea"><?=$trad['infos_ops']?></h5>

          <p><?=$trad['infos_ops_desc']?></p>

          <br>
          <br>

          <table class="grid titresnoirs altc">
            <thead>

              <tr>
                <th class="nowrap">
                  <?=$trad['infos_o_symbole']?>
                </th>
                <th class="nowrap">
                  <?=$trad['infos_o_titre']?>
                </th>
                <th class="nowrap">
                  <?=$trad['infos_o_mode']?>
                </th>
                <th>
                  <?=$trad['infos_o_pouvoirs']?>
                </th>
              </tr>

            </thead>
            <tbody class="align_center">

              <tr>
                <td class="nowrap gras texte_noir">
                  &nbsp;
                </td>
                <td class="nowrap spaced gras">
                  <?=$trad['infos_o_u']?>
                </td>
                <td class="gras nowrap">
                  &nbsp;
                </td>
                <td>
                  <?=$trad['infos_o_u_desc']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap gras texte_noir">
                  +
                </td>
                <td class="nowrap spaced gras">
                  <?=$trad['infos_o_v']?>
                </td>
                <td class="gras nowrap">
                  +v
                </td>
                <td>
                  <?=$trad['infos_o_v_desc']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap gras texte_noir">
                  %
                </td>
                <td class="nowrap spaced gras">
                  <?=$trad['infos_o_h']?>
                </td>
                <td class="gras nowrap">
                  +h
                </td>
                <td>
                  <?=$trad['infos_o_h_desc']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap gras texte_noir">
                  @
                </td>
                <td class="nowrap spaced gras">
                  <?=$trad['infos_o_o']?>
                </td>
                <td class="gras nowrap">
                  +o
                </td>
                <td>
                  <?=$trad['infos_o_o_desc']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap gras texte_noir">
                  &amp;
                </td>
                <td class="nowrap spaced gras">
                  <?=$trad['infos_o_a']?>
                </td>
                <td class="gras nowrap">
                  +a <?=$trad['infos_o_ou']?> +oa
                </td>
                <td>
                  <?=$trad['infos_o_a_desc']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap gras texte_noir">
                  ~
                </td>
                <td class="nowrap spaced gras">
                  <?=$trad['infos_o_q']?>
                </td>
                <td class="gras nowrap">
                  +q <?=$trad['infos_o_ou']?> +qo
                </td>
                <td>
                  <?=$trad['infos_o_q_desc']?>
                </td>
              </tr>

            </tbody>
          </table>

        </div>




        <div id="commandes" class="hidden contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['com_titre']?></h5>

          <p class="spaced"><?=$trad['com_desc']?></p>

          <p class="spaced"><?=$trad['com_desc_2']?></p>

          <p class="spaced"><?=$trad['com_desc_3']?></p>

          <p class="spaced"><?=$trad['com_desc_4']?></p>

          <br>
          <br>

          <table class="grid titresnoirs altc">
            <thead>

              <tr>
                <th class="nowrap">
                  <?=$trad['com_t_commande']?>
                </th>
                <th class="nowrap">
                  <?=$trad['com_t_exemple']?>
                </th>
                <th class="nowrap">
                  <?=$trad['com_t_effet']?>
                </th>
              </tr>

            </thead>
            <tbody class="align_center">

              <tr>
                <td class="nowrap spaced texte_noir">
                  /clear
                </td>
                <td class="nowrap spaced">
                  &nbsp;
                </td>
                <td>
                  <?=$trad['com_t_clear_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  /CS list *
                </td>
                <td class="nowrap spaced">
                  &nbsp;
                </td>
                <td>
                  <?=$trad['com_t_list_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  <?=$trad['com_t_join']?>
                </td>
                <td class="nowrap spaced">
                  <?=$trad['com_t_join_e']?>
                </td>
                <td>
                  <?=$trad['com_t_join_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  <?=$trad['com_t_part']?>
                </td>
                <td class="nowrap spaced">
                  <?=$trad['com_t_part_e']?>
                </td>
                <td>
                  <?=$trad['com_t_part_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  /quit
                </td>
                <td class="nowrap spaced">
                  &nbsp;
                </td>
                <td>
                  <?=$trad['com_t_quit_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  <?=$trad['com_t_nick']?>
                </td>
                <td class="nowrap spaced">
                  /nick Bad
                </td>
                <td>
                  <?=$trad['com_t_nick_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  <?=$trad['com_t_whois']?>
                </td>
                <td class="nowrap spaced">
                  /whois ThArGos
                </td>
                <td>
                  <?=$trad['com_t_whois_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  <?=$trad['com_t_msg']?>
                </td>
                <td class="nowrap spaced">
                  <?=$trad['com_t_msg_e']?>
                </td>
                <td>
                  <?=$trad['com_t_msg_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced texte_noir">
                  <?=$trad['com_t_ignore']?>
                </td>
                <td class="nowrap spaced">
                  /ignore Exirel
                </td>
                <td>
                  <?=$trad['com_t_ignore_d']?>
                </td>
              </tr>

            </tbody>
          </table>

        </div>




        <div id="nickserv" class="hidden contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['ns_titre']?></h5>

          <?=$trad['ns_desc']?>

          <br>
          <br>

          <h5 class="alinea"><?=$trad['ns_reg_titre']?></h5>

          <?=$trad['ns_reg_desc']?>

          <br>

        </div>




        <div id="chanserv" class="hidden contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['cs_titre']?></h5>

          <?=$trad['cs_desc']?>

          <br>
          <br>

          <h5 class="alinea"><?=$trad['cs_op_titre']?></h5>

          <?=$trad['cs_op_desc']?>

          <br>
          <br>

          <table class="grid titresnoirs altc">
            <thead>

              <tr>
                <th class="nowrap">
                  <?=$trad['cs_op_commande']?>
                </th>
                <th class="nowrap">
                  <?=$trad['cs_op_niveau']?>
                </th>
                <th class="nowrap">
                  <?=$trad['cs_op_effet']?>
                </th>
              </tr>

            </thead>
            <tbody class="align_center">

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_topic']?></span><br>
                  <?=$trad['cs_op_topic_e']?>
                </td>
                <td class="nowrap">
                  Halfop
                </td>
                <td>
                  <?=$trad['cs_op_topic_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_kick']?></span><br>
                  <?=$trad['cs_op_kick_e']?>
                </td>
                <td class="nowrap">
                  Halfop
                </td>
                <td>
                  <?=$trad['cs_op_kick_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_ban']?></span><br>
                  <?=$trad['cs_op_ban_e']?>
                </td>
                <td class="nowrap">
                  Halfop
                </td>
                <td>
                  <?=$trad['cs_op_ban_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_deban']?></span><br>
                  <?=$trad['cs_op_deban_e']?>
                </td>
                <td class="nowrap">
                  Halfop
                </td>
                <td>
                  <?=$trad['cs_op_deban_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_mute']?></span><br>
                  <?=$trad['cs_op_mute_e']?>
                </td>
                <td class="nowrap">
                  Halfop
                </td>
                <td>
                  <?=$trad['cs_op_mute_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_unmute']?></span><br>
                  <?=$trad['cs_op_unmute_e']?>
                </td>
                <td class="nowrap">
                  Halfop
                </td>
                <td>
                  <?=$trad['cs_op_unmute_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_vop']?></span><br>
                  <?=$trad['cs_op_vop_e']?>
                </td>
                <td class="nowrap">
                  Superop
                </td>
                <td>
                  <?=$trad['cs_op_vop_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_hop']?></span><br>
                  <?=$trad['cs_op_hop_e']?>
                </td>
                <td class="nowrap">
                  Superop
                </td>
                <td>
                  <?=$trad['cs_op_hop_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_aop']?></span><br>
                  <?=$trad['cs_op_aop_e']?>
                </td>
                <td class="nowrap">
                  Superop
                </td>
                <td>
                  <?=$trad['cs_op_aop_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_sop']?></span><br>
                  <?=$trad['cs_op_sop_e']?>
                </td>
                <td class="nowrap">
                  <?=$trad['cs_op_sop_f']?>
                </td>
                <td>
                  <?=$trad['cs_op_sop_d']?>
                </td>
              </tr>

              <tr>
                <td class="nowrap spaced">
                  <span class="gras texte_noir"><?=$trad['cs_op_deop']?></span><br>
                  <?=$trad['cs_op_deop_e']?>
                </td>
                <td class="nowrap">
                  Superop
                </td>
                <td>
                  <?=$trad['cs_op_deop_d']?>
                </td>
              </tr>

            </tbody>
          </table>

          <br>
          <br>
          <br>

          <h5 class="alinea"><?=$trad['cs_cani_titre']?></h5>

          <?=$trad['cs_cani_desc']?>

          <br>
          <br>

          <h5 class="alinea"><?=$trad['cs_creer_titre']?></h5>

          <?=$trad['cs_creer_desc']?>

          <br>

        </div>



        <?php if($lang == 'FR') { ?>

        <div id="akundo" class="hidden contenu_onglet">

          <br>

          <h5 class="alinea"><?=$trad['akundo_titre']?></h5>

          <?=$trad['akundo_desc']?>

          <br>
          <br>
          <div class="align_center">
            <img src="<?=$chemin?>img/irc/akundo_1.png" alt="Capture d'écran d'Akundo en action"><br>
            <br>
            <img src="<?=$chemin?>img/irc/akundo_2.png" alt="Capture d'écran d'Akundo en action"><br>
            <br>
            <img src="<?=$chemin?>img/irc/akundo_3.png" alt="Capture d'écran d'Akundo en action"><br>
          </div>
          <br>
          <br>
          <br>

          <h5 class="alinea"><?=$trad['akunliste_titre']?></h5>

          <?=$trad['akunliste_desc']?>

          <br>
          <br>

          <h5 class="alinea"><?=$trad['akuntrivia_titre']?></h5>

          <?=$trad['akuntrivia_desc']?>

          <br>
          <br>
          <div class="align_center">
            <img src="<?=$chemin?>img/irc/akundo_trivia.png" alt="Capture d'écran du NoBleme-trivia"><br>
          </div>
          <br>

        </div>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';