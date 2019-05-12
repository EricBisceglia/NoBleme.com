<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Accueil';

// Identification
$page_nom = "Traine sur l'index du site";
$page_url = "index";

// Langues disponibles
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Accueil" : "Homepage";
$page_desc  = "NoBleme, la communauté web qui n'apporte rien mais a réponse à tout";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On définit l'âge du site
$agenobleme = date('Y')-2005;




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/******************************************************************************************************/ include './inc/header.inc.php'; ?>

      <br>

      <?php if($lang == 'FR') { ?>

      <div class="texte">

        <h1>NoBleme.com</h1>

        <h5>Bienvenue sur NoBleme. Que trouverai-je par ici ?</h5>

        <p>Existant dans son coin depuis plus de <?=$agenobleme?> ans, NoBleme est un vestige du passé d'internet.</p>

        <p>Avant l'ère des réseaux sociaux, le web était décentralisé : composé de plein de petites communautés qui n'avaient pas spécialement de thème ou de raison d'être. Aujourd'hui, NoBleme continue à préserver l'esprit quasi-familial de ces petites communautés d'antan.</p>

        <p>Toutefois, NoBleme n'est pas fait pour être un musée. C'est une communauté vivante, activement développée, qui continue à accueillir les nouveaux à bras ouverts et à éjecter les causeurs de drames afin de préserver l'ambiance amicale qui fait son charme.</p>

        <h5 class="bigpadding">Visite guidée minimaliste du site</h5>

        <p>Si vous vous demandez d'où NoBleme vient et à quoi sert NoBleme, vous pouvez trouver la réponse à ces questions dans la page <a class="gras" href="<?=$chemin?>pages/doc/nobleme">qu'est-ce que NoBleme</a> de la <a class="gras" href="<?=$chemin?>pages/doc">documentation du site</a></p>

        <p>Notre attraction principale pour les visiteurs perdus est <a class="gras" href="<?=$chemin?>pages/nbdb/index">l'encyclopédie de la culture internet</a>, une documentation de l'histoire d'internet et des memes qu'on y trouve.</p>

        <p>Maintenant que vous avez une vague idée de ce que NoBleme représente, peut-être êtes vous assez curieux pour avoir envie d'intéragir avec la communauté NoBlemeuse. Si c'est le cas, venez nous rejoindre là où nous sommes toujours actifs : sur notre <a class="gras" href="<?=$chemin?>pages/irc/index">serveur de discussion IRC</a>.</p>

        <p>N'hésitez pas à vous balader sur le site pour découvrir son contenu, et bon séjour sur NoBleme !</p>
        <a class="alinea gras" href="<?=$chemin?>pages/user/user?id=1">- Bad</a>

      </div>

      <?php } else { ?>

      <div class="texte">

        <h1>NoBleme.com</h1>

        <h5>Welcome to NoBleme. What's this place all about?</h5>

        <p>A relic of the internet's past, NoBleme is a french community which has been online for over 12 years.</p>

        <p>Before the days of social networks, the internet was decentralized: split into a lot of small communities, most of them without a specific theme or purpose. NoBleme is an attempt to preserve the almost familial spirit of those small communities of the past.</p>

        <p>However, NoBleme is not meant to be a museum. It is a living place, the website is still being developed, and the community is continuously accepting new members with open arms whilst making sure to get rid of any source of drama in order to preserve its friendly atmosphere.</p>

        <h5 class="bigpadding">NoBleme for english speakers</h5>

        <p>NoBleme was originally created as a french community. This means that some of the website's features have no english translation and are only available in french. It does not mean that english speakers are not desired, as absolutely everyone is welcome on NoBleme, and many if not most of our users speak english.</p>

        <p>When switching from french to english, you will probably have noticed that you have access to fewer elements on the left side navigation menu. This is because the non translated (french only) pages are removed from the navigation menu when browsing the website in english, for your convenience. Keep in mind that most of these removed pages are about things that do not translate to english, such as quotes from conversations in french, games that are played solely in french, etc.</p>

        <p>Don't hesitate to look around the website, and enjoy your stay on NoBleme!</p>
        <a class="alinea" href="<?=$chemin?>pages/user/user?id=1">- Bad</a>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';