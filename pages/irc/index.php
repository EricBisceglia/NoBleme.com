<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'IRC';

// Identification
$page_nom = "Découvre le chat IRC";
$page_url = "pages/irc/index";

// URL courte
$shorturl = "irc";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Chat IRC" : "IRC chat";
$page_desc  = "Communication en temps réel entre NoBlemeux via le protocole IRC";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Chat IRC";
  $trad['soustitre']      = "Communiquer en temps réel";
  $trad['desc']           = <<<EOD
<a class="gras" href="https://fr.wikipedia.org/wiki/Internet_Relay_Chat">IRC (Internet Relay Chat)</a> est un protocole de communication en temps réel via Internet datant de 1988. Malgré son âge vénérable, il reste le système de communication de choix de nombreuses communautés, dont NoBleme. Le choix d'utiliser IRC sur NoBleme s'est fait en 2005, et est toujours justifiable aujourd'hui : IRC est stable, plutôt bien sécurisé, entièrement gratuit, ne dépend d'aucune entreprise, laisse à chaque utilisateur la liberté de s'en servir avec l'interface qu'il veut, et peut être hébergé en interne sur le serveur de NoBleme.
EOD;

  // Infos de connexion
  $trad['infos']          = "Si vous savez déjà vous servir d'IRC, voici les informations qui permettent de se connecter à l'IRC NoBleme :";
  $trad['infos_serveur']  = "Serveur :";
  $trad['infos_port']     = "Port :";
  $trad['infos_port_t']   = "6697 (SSL) ou 6667 (normal)";
  $trad['infos_hub']      = "Canal :";
  $trad['infos_hub_t']    = "#NoBleme";
  $trad['infos_encodage'] = "Encodage :";

  // Rejoindre IRC
  $trad['rej_titre']      = "Comment rejoindre la conversation (en moins d'une minute)";
  $trad['rej_desc']       = <<<EOD
Vous ne connaissez pas IRC et vous voulez venir discuter avec nous ? Pas de panique, <span class="gras">c'est super simple !</span><br>
<br>
La seule chose à faire pour venir discuter est d'utiliser un client IRC, c'est à dire un programme ou site internet qui se connectera au serveur IRC de NoBleme. Envie d'essayer ? <a class="gras" href="{$chemin}pages/irc/client">J'ai écrit pour vous un tutoriel illustré</a> expliquant comment rejoindre la conversation sans rien installer et en moins d'une minute.
EOD;

  // Infos sur le serveur
  $trad['nobleme_titre']  = "Informations sur le serveur IRC de NoBleme";
  $trad['nobleme_desc']   = <<<EOD
<p>
  Tout le monde est bienvenu sur le serveur, à condition de respecter le <a class="gras" href="{$chemin}pages/doc/coc">code de conduite de NoBleme</a>. Même si vous êtes timide, rien ne vous empêche de venir observer nos conversations sans y participer, il se peut que vous nous trouviez assez sympathiques pour un jour prendre part aux conversations.
</p>
<p>
  Le serveur IRC NoBleme est centré autour d'un canal de discussion nommé <span class="gras">#NoBleme</span>, sur lequel ont lieu la majorité des discussions. Lorsque des sujets de discussion plus spécifiques ont lieu de façon récurrente, ils sont déplacés sur des canaux à thème spécifiques à ces discussions (par exemple #english pour les conversations en anglais, #dev pour l'informatique, #starcraft pour parler du jeu vidéo Starcraft). Pour savoir quels canaux de discussion pourraient vous intéresser, consultez la <a class="gras" href="{$chemin}pages/irc/canaux">liste des canaux</a>.
</p>
<p>
  Le serveur possède également une série d'outils vous permettant par exemple de protéger votre pseudonyme ou de créer vos propres canaux de discussion. Ces services, ainsi que notre gentil robot local nommé Akundo, sont documentés sur la page <a class="gras" href="{$chemin}pages/irc/services">commandes et services</a>.
</p>
EOD;

  // Créer un canal
  $trad['canal_titre']  = "Puis-je créer mon propre canal de discussion sur NoBleme ?";
  $trad['canal_desc']   = <<<EOD
<p>
  Si vous désirez créer votre propre canal, même si c'est pour vos amis qui ne sont pas NoBlemeux, vous êtes libres de le faire sans demander la permission. La seule condition est que vous soyez vous-même un NoBlemeux, et que vous fassiez respecter le <a class="gras" href="{$chemin}pages/doc/coc">code de conduite de NoBleme</a> sur votre canal.
</p>
<p>
  Toutefois, si vous n'êtes pas un régulier de NoBleme et désirez utiliser le serveur pour créer votre propre canal, votre canal se fera probablement fermer. Il existe de nombreux autres serveurs IRC (vous pouvez trouver une liste des plus populaires <a class="gras" href="http://irc.netsplit.de/networks/top100.php">assez facilement</a>), et je préfère que le serveur IRC de NoBleme reste un serveur centré sur la communauté du site.
</p>
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "IRC chat";
  $trad['soustitre']      = "Real time communication";
  $trad['desc']           = <<<EOD
<a class="gras" href="https://en.wikipedia.org/wiki/Internet_Relay_Chat">IRC (Internet Relay Chat)</a> is a real time communication protocol from 1988. Despite its old age, it is the backbone of the chat system used by many websites and communities. The choice of using IRC on NoBleme was made in 2005, and the reasons for that choice are still valid today: IRC is stable, rather secure, entirely free, lets users pick the way they want it to look, and can be hosted internally on NoBleme.
EOD;

  // Infos de connexion
  $trad['infos']          = "If you already know how to use IRC, here's NoBleme's server connexion info :";
  $trad['infos_serveur']  = "Server :";
  $trad['infos_port']     = "Port :";
  $trad['infos_port_t']   = "6697 (SSL) or 6667 (standard)";
  $trad['infos_hub']      = "Channel :";
  $trad['infos_hub_t']    = "#english";
  $trad['infos_encodage'] = "Encoding :";

  // Rejoindre IRC
  $trad['rej_titre']      = "Joining the conversation (takes less than a minute)";
  $trad['rej_desc']       = <<<EOD
You don't know IRC and want to chat with us? No problem, <span class="gras">it's extremely simple!</span><br>
<br>
The only thing you need to get chatting on IRC is something called an IRC client, a program or website which you use to connect to NoBleme's server. Want to try? <a class="gras" href="{$chemin}pages/irc/client">I wrote an illustrated tutorial for you</a> explaining how to get on IRC in less than a minute without installing anything.
EOD;

  // Infos sur le serveur
  $trad['nobleme_titre']  = "Server information";
  $trad['nobleme_desc']   = <<<EOD
<p>
  Everyone is welcome on NoBleme's IRC server, as long as you respect the <a class="gras" href="{$chemin}pages/doc/coc">code of conduct</a>. Even if you are shy, it is perfectly okay to join and lurk without talking. Maybe after a while you'll feel comfortable enough to join the conversation, who knows.
</p>
<p>
  Most of NoBleme's IRC channels are in french. However, we have enough users that are non-french or bilingual that we can hold conversations in english aswell. The english hub on the server is the channel <span class="gras">#english</span>, but we also have a bunch of other channels that you can find in our <a class="gras" href="{$chemin}pages/irc/canaux">channel list</a>.
</p>
<p>
  Our IRC server also has a bunch of services which allow you to protect your nickname, create your own channel, and more. Those services, aswell as our local friendly robot Akundo, are documented on the <a class="gras" href="{$chemin}pages/irc/services">commands and services</a> page.
</p>
EOD;

  // Créer un canal
  $trad['canal_titre']  = "May I create my own channel on NoBleme's IRC server ?";
  $trad['canal_desc']   = <<<EOD
<p>
  If you want to create your own channel on the server, even if it is for your friends who don't use NoBleme, that's fine by me, you can do it without asking. The only conditions are that you must yourself be a part of the NoBleme community, and that you enforce NoBleme's <a class="gras" href="{$chemin}pages/doc/coc">code of conduct</a> on the channel you create.
</p>
<p>
  However, if you are not part of NoBleme's community and want to host your own channel on the server, it will probably end up getting closed. There are many other IRC servers (you can <a class="gras" href="http://irc.netsplit.de/networks/top100.php">easily</a> find a list of the most popular ones), and I would prefer NoBleme's IRC server to remain centered on the website's community.
</p>
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p>
          <?=$trad['desc']?>
        </p>

        <p>
          <?=$trad['infos']?><br>
          <br>
          <div class="flexcontainer">
            <div class="gras align_right spaced" style="flex:1">
              <?=$trad['infos_serveur']?><br>
              <?=$trad['infos_port']?><br>
              <?=$trad['infos_hub']?><br>
              <?=$trad['infos_encodage']?>
            </div>
            <div style="flex:7">
              irc.nobleme.com<br>
              <?=$trad['infos_port_t']?><br>
              <?=$trad['infos_hub_t']?><br>
              UTF-8
            </div>
          </div>
        </p>

        <br>

        <h5><?=$trad['rej_titre']?></h5>

        <p>
          <?=$trad['rej_desc']?>
        </p>

        <br>
        <br>

        <h5><?=$trad['nobleme_titre']?></h5>

        <?=$trad['nobleme_desc']?>

        <br>
        <br>

        <h5><?=$trad['canal_titre']?></h5>

        <?=$trad['canal_desc']?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';