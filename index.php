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
$page_nom = "index";
$page_id  = "index";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Flash aléatoire pour l'anniv de NoBleme

// On définit l'âge du site
$agenobleme = date('Y')-2005;

if(date('d-m') == '19-03')
{
  // On va chercher les infos dans la bdd
  $qflash     = query(" SELECT anniv_flash.nom_fichier, anniv_flash.largeur FROM anniv_flash ");
  $nflash     = mysqli_num_rows($qflash);

  // On en pique un au hasard
  $randflash  = rand(1,$nflash);
  for($i=0;$i<$randflash;$i++)
    $dflash = mysqli_fetch_array($qflash);

  // Et on prépare les infos
  $annivflash = $dflash['nom_fichier'];
  $annivsize  = $dflash['largeur'];
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/******************************************************************************************************/ include './inc/header.inc.php'; ?>

      <br>

      <?php if(!isset($_SESSION['lang']) || $_SESSION['lang'] == 'FR') { ?>

      <div class="texte">

        <h1>NoBleme.com</h1>

        <h5>Bienvenue sur NoBleme. Que trouverai-je par ici ?</h5>

        <p>Existant dans son coin depuis plus de <?=$agenobleme?> ans, NoBleme est un vestige du passé d'internet.</p>

        <p>Avant l'ère des réseaux sociaux, le web était décentralisé : composé de plein de petites communautés qui n'avaient pas spécialement de thème ou de raison d'être. Aujourd'hui, NoBleme continue à préserver l'esprit quasi-familial de ces petites commaunatés d'antan.</p>

        <p>Toutefois, NoBleme n'est pas fait pour être un musée. C'est une communauté vivante, activement développée, qui continue à accueillir les nouveaux à bras ouverts et à éjecter les causeurs de drames afin de préserver l'ambiance amicale qui fait son charme.</p>

        <h5 class="bigpadding">NoBleme en <?=date('Y')?></h5>

        <p>En ce moment, NoBleme traverse une phase de travaux où la plupart du contenu du site est en réfection. Toutefois, la communauté est toujours présente sur <a class="gras" href="<?=$chemin?>pages/irc/index">le serveur de discussion IRC</a>. Rejoignez-nous et venez discuter sur IRC, nous accueillons toujours les nouveaux visiteurs à bras ouverts.</p>

        <p>N'ayez pas peur, le site ne mord pas. En tout cas, pas la première fois. Pour la suite, je ne peux rien garantir.</p>
        <a class="alinea" href="<?=$chemin?>pages/user/user?id=1">- Bad</a>

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

        <p>When switching from french to english, you will probably have noticed that you have access to less elements on the left side navigation menu. This is because the non translated (french only) pages are removed from the navigation menu when browsing the website in english, for your convenience. Keep in mind that most of these removed pages are about things that do not translate to english, such as the organization of real life meetups in France, written conversations in french forums, blog posts in french, etc.</p>

        <h5 class="bigpadding">NoBleme in <?=date('Y')?></h5>

        <p>As of <?=date('Y')?>, NoBleme is going through a transformation phase, where most of the website's contents have been removed and are being remade in a more modern and useful way. During that time, the website is going to be short on features. However, our <a class="gras" href="<?=$chemin?>pages/irc/index">IRC chat server</a> is still open and acts as the current center of activity on NoBleme. Join us on IRC, we are always very welcoming with new faces, even non french ones !</p>

        <p>Don't be scared of browsing around, the website doesn't bite. At least, not at first.</p>
        <a class="alinea" href="<?=$chemin?>pages/user/user?id=1">- Bad</a>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/*********************************************************************************************************/ include './inc/footer.inc.php';