<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'DonneesPersonnelles';

// Identification
$page_nom = "Liste ses données personnelles";
$page_url = "pages/doc/donnees_personnelles";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Données personnelles" : "Personal data";
$page_desc  = "Liste des données personnelles que NoBleme conserve sur vous";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Données conservées sur le site

// Adresse IP et cookies
$donnees_ip     = $_SERVER["REMOTE_ADDR"];
$temp_lang      = ($lang == 'FR') ? "Ce cookie existe sur votre ordinateur" : "This cookie exists on your computer";
$temp_lang2     = ($lang == 'FR') ? "Ce cookie n'existe pas sur votre ordinateur" : "This cookie does not exist on your computer";
$cookie_login   = (isset($_COOKIE['nobleme_memory'])) ? $temp_lang : $temp_lang2;
$cookie_langue  = (isset($_COOKIE['nobleme_language'])) ? $temp_lang : $temp_lang2;

// Données liées au compte
if(loggedin())
{
  // Récupération de l'id d'utilisateur
  $id_user = postdata($_SESSION['user'], 'int', 0);

  // Récupération des données
  $ddonneesperso  = mysqli_fetch_array(query("  SELECT  membres.pseudonyme  AS 'm_pseudo' ,
                                                        membres.email       AS 'm_email'
                                                FROM    membres
                                                WHERE   membres.id = '$id_user' "));

  // Préparation des données pour l'affichage
  $donnees_pseudo = predata($ddonneesperso['m_pseudo']);
  $donnees_email  = ($ddonneesperso['m_email']) ? predata($ddonneesperso['m_email']) : '-';
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Données personnelles";
  $trad['soustitre']  = "Liste de tout ce que NoBleme conserve sur vous";
  $trad['desc']       = <<<EOD
En respect de la <a class="gras" href="{$chemin}pages/doc/mentions_legales">politique de confidentialité</a> de NoBleme et du <a class="gras" href="https://fr.wikipedia.org/wiki/R%C3%A8glement_g%C3%A9n%C3%A9ral_sur_la_protection_des_donn%C3%A9es">RGPD</a>, vous trouverez sur cette page l'intégralité des données personnelles que NoBleme stocke sur vous, ainsi que la raison pour laquelle ces données sont conservées. Si vous désirez que ces données soient supprimées, vous pouvez faire le faire via la page « <a class="gras" href="{$chemin}pages/doc/droit_oubli">Droit à l'oubli</a> ».
EOD;
  $trad['desc2']      = <<<EOD
Sachez par ailleurs que NoBleme ne conserve que le strict nécessaire sur vous :<br>
- Ces données ne sont utilisées que dans l'enceinte de NoBleme.com<br>
- Ces données ne sont pas utilisées pour vous traquer hors du site<br>
- Ces données ne sont visibles que par vous même et par <a href="{$chemin}pages/user/user?id=1">l'administrateur du site</a><br>
- Ces données ne sont pas et ne seront jamais communiquées ou vendues à des tiers<br>
- Aucun site ou prestataire tiers n'est autorisé à suivre votre activité sur NoBleme<br>
- Aucune statistique personnelle n'est conservée sur le site (tout est anonymisé)
EOD;
  $trad['desc3']      = <<<EOD
Des contenus tiers (vidéos YouTube, tweets, etc.) peuvent être inclus dans certaines pages du site. Nous ne pouvons pas contrôler ce que ces tiers font de vos données personnelles, par conséquent, vous pouvez choisir si vous le désirez de ne pas les afficher sur NoBleme sur la page « <a class="gras" href="{$chemin}pages/user/privacy">Options de vie privée</a> ».
EOD;

  // Adresse IP
  $trad['ip_titre']   = "Votre adresse IP :";
  $trad['ip_desc']    = <<<EOD
NoBleme conserve votre <a class="gras" href="https://fr.wikipedia.org/wiki/Adresse_IP">adresse IP</a> pour une raison et une durée différentes selon si vous êtes un invité ou un membre inscrit sur le site :<br>
<br>
Si vous êtes un invité (que vous n'êtes pas membre du site), votre adresse IP est conservée pour <span class="gras">un maximum de 48h</span> afin de vous identifier sur la page « <a class="gras" href="{$chemin}pages/nobleme/online">Qui est en ligne</a> », mais sert surtout de barrière de sécurité en limitant le nombre de fois que vous pouvez essayer de vous <a class="gras" href="{$chemin}pages/user/login">connecter à votre compte</a> avant que vous ne puissiez plus le faire. Cela permet d'éviter que quelqu'un se serve d'un script pour tenter toutes les combinaisons de mots de passe possibles jusqu'à arriver à se connecter de force à votre compte.<br>
<br>
Si vous êtes un membre du site connecté à votre compte, l'adresse IP depuis laquelle vous vous êtes connecté au site le plus récemment est gardée dans la base de données afin d'identifier les utilisateurs ayant plusieurs comptes, et de pouvoir bannir de façon permanente (par adresse IP) les utilisateurs qui ne respectent pas le <a class="gras" href="{$chemin}pages/doc/coc">code de conduite</a> du site. <span class="gras">Seule votre adresse IP la plus récente est stockée</span>, les autres ne sont pas gardées, et disparaissent de la base de donnée l'instant où vous vous connectez depuis un autre lieu.
EOD;

  // Cookie de langue
  $trad['cl_titre']   = "Cookie de langue :";
  $trad['cl_desc']    = <<<EOD
Afin de retenir si vous naviguez sur le site en français ou en anglais, un <a class="gras" href="https://fr.wikipedia.org/wiki/Cookie_(informatique)">cookie</a> peut être crée. Ce cookie, qui est automatiquement stocké sur votre ordinateur, permet à NoBleme de se souvenir de la langue que vous utilisez d'une visite à l'autre, même si vous fermez votre navigateur ou éteignez votre ordinateur entre temps.
EOD;

  // Cookie de session
  $trad['cs_titre']   = "Cookie de session :";
  $trad['cs_desc']    = <<<EOD
Lorsque vous vous <a class="gras" href="{$chemin}pages/user/login">connectez à votre compte</a>, une case à cocher « Se souvenir de moi » se trouve en bas à droite du formulaire de connexion. Si vous cochez cette case, un cookie est automatiquement stocké sur votre ordinateur. Il permet à NoBleme de se souvenir que vous souhaitez rester connecté à votre compte, même si vous fermez votre navigateur ou éteignez votre ordinateur entre temps.
EOD;

  // Données liées au compte
  $trad['dc_titre']   = "Données liées à votre compte";
  $trad['dc_guest']   = <<<EOD
Comme vous êtes actuellement un invité (vous n'êtes pas <a class="gras" href="{$chemin}pages/user/login">connecté à un compte</a> sur NoBleme), aucune donnée supplémentaire n'est stockée sur vous.
EOD;
  $trad['dc_pseudo']  = "Votre pseudonyme :";
  $trad['dc_pdesc']   = <<<EOD
Lors de la création de votre compte, vous avez choisi ce pseudonyme. Il sert à vous identifier publiquement sur le site, et tout le monde peut le voir. Si vous avez une bonne raison de vouloir changer votre pseudonyme, il est possible d'en faire la demande via la page « <a class="gras" href="{$chemin}pages/user/pseudo">Changer de pseudonyme</a> ».
EOD;
  $trad['dc_email']   = "Votre adresse e-mail :";
  $trad['dc_edesc']   = <<<EOD
Même si NoBleme vous propose optionnellement de stocker votre adresse e-mail, elle ne sera jamais utilisée par le site : nous ne vous enverrons jamais d'e-mails de masse ni de lettres d'information, nous ne partagerons jamais cette donnée privée avec un tiers, et votre e-mail ne sera jamais visible publiquement par les autres visiteurs du site. La raison pour laquelle nous proposons de conserver votre adresse e-mail est pour pouvoir récupérer l'accès à votre compte si jamais vous perdez votre mot de passe - dans ce cas, un e-mail vous sera envoyé pour remettre à zéro votre mot de passe. Vous pouvez changer ou même supprimer votre adresse e-mail via la page « <a class="gras" href="{$chemin}pages/user/email">Changer d'e-mail</a> ».
EOD;
  $trad['dc_autres']  = "Autres données liées à votre compte";
  $trad['dc_adesc']   = <<<EOD
Au fur et à mesure que vous utilisez NoBleme, des données apparaissent sur votre <a class="gras" href="{$chemin}pages/user/user">profil public</a>. Certaines de ces informations sont remplies par vous-même, et vous pouvez les supprimer à tout moment sur la page « <a class="gras" href="{$chemin}pages/user/profil">Modifier mon profil</a> ». D'autres sont des statistiques liées à l'utilisation du site, et ne peuvent pas être supprimées. Si vous avez une bonne justification pour vouloir supprimer ces informations non modifiables, vous pouvez faire une demande de suppression de compte via la page « <a class="gras" href="{$chemin}pages/user/delete">Supprimer mon compte</a> », et tout ce qui peut vous identifier publiquement sera alors supprimé avec votre compte.
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Your personal data";
  $trad['soustitre']  = "All the things NoBleme keeps about you";
  $trad['desc']       = <<<EOD
According to NoBleme's <a class="gras" href="{$chemin}pages/doc/mentions_legales">privacy policy</a> and the <a class="gras" href="https://en.wikipedia.org/wiki/General_Data_Protection_Regulation">GDPR</a>, you will find on this page a list of all your personal data which NoBleme stores, aswell as an explanation for why each of them are being kept. If you want all your personal data to be deleted, you can do it through the "<a class="gras" href="{$chemin}pages/doc/droit_oubli">Right to be forgotten</a>" page.
EOD;
  $trad['desc2']      = <<<EOD
You should also know that NoBleme only keeps the strict minimum amount of your personal data:<br>
- This data is only used within the confines of NoBleme.com<br>
- This data will not be used to track you outside of the website<br>
- This data is only visible to yourself and <a href="{$chemin}pages/user/user?id=1">the website's administrator</a><br>
- This data is not and will never be sent or sold to third parties<br>
- No third party is allowed to follow your activity on NoBleme<br>
- No personal statisticts are kept on the website (everything is anonymized)
EOD;
  $trad['desc3']      = <<<EOD
Third party content (YouTube videos, tweets, etc.) can be included in some of the website's pages. We cannot control how these third parties use your personal data, therefore you have the option to completely hide those contents in order to make sure you are not being tracked by them at all through the "<a class="gras" href="{$chemin}pages/user/privacy">Privacy options</a>" page.
EOD;

  // Adresse IP
  $trad['ip_titre']   = "Your IP address:";
  $trad['ip_desc']    = <<<EOD
NoBleme keeps your <a class="gras" href="https://en.wikipedia.org/wiki/IP_address">IP address</a> for different reasons and amounts of time depending on whether you are a guest or a registered member of the website:<br>
<br>
If you are a guest (are not <a class="gras" href="{$chemin}pages/user/login">logged into an account</a>), your IP address is kept for <span class="gras">up to 48h</span> in order to differentiate you from others on the "<a class="gras" href="{$chemin}pages/nobleme/online">Who's online</a>" page, but must importantly as a security measure to prevent people from trying to brute force your account's password by trying to log into it as many times as they want. Login attempts are limited to a certain amount of tries per IP address, which means that your address must temporarily be kept to enforce this important security measure in order to make user accounts more secure.<br>
<br>
If you are a registered and logged in member, the IP address from which you are currently accessing the website is kept in the database in order to identify users who have multiple accounts, and to have the ability to permanently ban (through IP bans) users who do not respect the website's <a class="gras" href="{$chemin}pages/doc/coc">code of conduct</a>. <span class="gras">Only your current IP address is stored</span>, the one with which you most recently accessed the website. Your previous IP addresses are not stored anywhere, and your current one disappears from the database the instant you connect to your account from a different location.
EOD;

  // Cookie de langue
  $trad['cl_titre']   = "Language cookie:";
  $trad['cl_desc']    = <<<EOD
In order to remember whether you want the website's contents displayed in french or english, a <a class="gras" href="https://en.wikipedia.org/wiki/HTTP_cookie">cookie</a> can be created. This cookie, which is automatically stored on your computer, allows NoBleme to remember the language that you are using from one visit to another, even if you close your browser or your computer between visits.
EOD;

  // Cookie de session
  $trad['cs_titre']   = "Session cookie:";
  $trad['cs_desc']    = <<<EOD
When you <a class="gras" href="{$chemin}pages/user/login">log into your account</a>, there is an optional "Remember me" checkbox. If it is checked when you log in, then a cookie is automatically stored on your computer. This cookie allows NoBleme to remember that you want to stay logged into your account from one visit to another, even if you close your browser or your computer between visits.
EOD;

  // Données liées au compte
  $trad['dc_titre']   = "Personal data linked to your account";
  $trad['dc_guest']   = <<<EOD
As you are currently a guest (you are not <a class="gras" href="{$chemin}pages/user/login">logged into an account</a> on NoBleme), no additional personal data is stored.
EOD;
  $trad['dc_pseudo']  = "Your nickname:";
  $trad['dc_pdesc']   = <<<EOD
When you created your account, you chose this as your nickname. It is used to publicly identify you on the whole website, and everyone can see it publicly. If you have a good reason to want to change your nickname, you can make a request on the "<a class="gras" href="{$chemin}pages/user/pseudo">Change my nickname</a>" page
EOD;
  $trad['dc_email']   = "Your e-mail address:";
  $trad['dc_edesc']   = <<<EOD
Even though NoBleme offers to optionally link an e-mail address to your account, it is a private information that only you and the <a href="{$chemin}pages/user/user?id=1">website's administrator</a> can see, and it will never be used by the website: we will never send you mass e-mails or newsletters, and we will never share this information with a third party. The reason why we offer to store your e-mail address is for recovery purposes. In case you ever lose your account's password, you can recover it using an e-mail which gets sent to the e-mail address that you stored on the website. If you want to edit or remove your e-mail address, you can do so on the "<a class="gras" href="{$chemin}pages/user/email">Change my e-mail</a>" page.
EOD;
  $trad['dc_autres']  = "Other data linked to your account";
  $trad['dc_adesc']   = <<<EOD
As you use NoBleme, various informations appear on your <a class="gras" href="{$chemin}pages/user/user">public profile</a>. Some of those informations have been put there by yourself, and you can edit or delete them at any time on the "<a class="gras" href="{$chemin}pages/user/profil">Edit my profile</a>" page. The other informations are statistics linked to your usage of the website, and can not be deleted. If you have a good reason to want those gone, you can make a request that your account gets deleted through the "<a class="gras" href="{$chemin}pages/user/delete">Delete my account</a>" page, and everything that's listed on your profile will disappear along with your account.
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

        <p><?=$trad['desc']?></p>

        <p><?=$trad['desc2']?></p>

        <p><?=$trad['desc3']?></p>

        <br>
        <br>
        <br>

        <h5><?=$trad['ip_titre']?> <span class="souligne"><?=$donnees_ip?></span></h5>

        <p><?=$trad['ip_desc']?></p>

        <br>
        <br>
        <br>

        <h5><?=$trad['cl_titre']?> <span class="souligne"><?=$cookie_langue?></span></h5>

        <p><?=$trad['cl_desc']?></p>

        <br>
        <br>
        <br>

        <h5><?=$trad['cs_titre']?> <span class="souligne"><?=$cookie_login?></span></h5>

        <p><?=$trad['cs_desc']?></p>

        <br>
        <br>
        <br>

        <h4><?=$trad['dc_titre']?></h4>

        <?php if(!$est_connecte) { ?>

        <p><?=$trad['dc_guest']?></p>

        <?php } else { ?>

        <br>
        <br>

        <h5><?=$trad['dc_pseudo']?> <span class="souligne"><?=$donnees_pseudo?></span></h5>

        <p><?=$trad['dc_pdesc']?></p>

        <br>
        <br>
        <br>

        <h5><?=$trad['dc_email']?> <span class="souligne"><?=$donnees_email?></span></h5>

        <p><?=$trad['dc_edesc']?></p>

        <br>
        <br>
        <br>

        <h5><?=$trad['dc_autres']?></h5>

        <p><?=$trad['dc_adesc']?></p>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';