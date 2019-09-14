<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'MentionsLegales';

// Identification
$page_nom = "S'assure que NoBleme soit son ami";
$page_url = "pages/doc/mentions_legales";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Mentions légales" : "Legal mentions";
$page_desc  = "Mentions légales et politique de confidentialité de NoBleme.com";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <?php if($lang == 'FR') { ?>

        <h1>
          Mentions légales
        </h1>

        <br>
        <br>

        <h5>
          Politique de confidentialité des données
        </h5>

        <p>
          NoBleme prend très au sérieux vos données personnelles. Non seulement nous respectons les directives du <a class="gras" href="https://fr.wikipedia.org/wiki/R%C3%A8glement_g%C3%A9n%C3%A9ral_sur_la_protection_des_donn%C3%A9es">RGPD (Règlement général sur la protection des données)</a>, mais nous allons encore plus loin en s'assurant de ne garder que le strict minimum de données utiles sur vous et en étant totalement transparent sur le fonctionnement interne du site.
        </p>

        <p>
          Si vous vous demandez spécifiquement quelles données personnelles NoBleme stocke sur vous, vous pouvez en voir la liste complète sur la page « <a class="gras" href="<?=$chemin?>pages/doc/donnees_personnelles">Vos données personnelles</a> ».
        </p>

        <p>
          Si vous voulez voir le code source de NoBleme afin de vérifier par vous-même la façon dont NoBleme utilise vos données personnelles, vous pouvez le voir dans les <a class="gras" href="<?=$chemin?>pages/nobleme/coulisses">coulisses de NoBleme</a>.
        </p>

        <p>
          Si vous désirez que NoBleme supprime automatiquement toutes les données personnelles qui vous concernent, nous respectons le droit à l'oubli, que vous pouvez faire valoir via la page « <a class="gras" href="<?=$chemin?>pages/doc/droit_oubli">Droit à l'oubli</a> ».
        </p>

        <br>
        <br>
        <br>

        <h5>
          Responsabilités sur les contenus et propriété intellectuelle
        </h5>

        <p>
          Les contenus statiques des pages de NoBleme (ceux qui font partie du code source du site et ne sont pas rédigés par les utilisateurs du site) sont la responsabilité personnelle de l'auteur et administrateur du site, <a class="gras" href="<?=$chemin?>pages/users/user?id=1">Éric Bisceglia</a>. Ce contenu est protégé, via son <a class="gras" href="<?=$chemin?>pages/nobleme/coulisses">code source</a>, par la <a class="gras" href="https://fr.wikipedia.org/wiki/Licence_MIT">Licence MIT</a>. Cette licence est volontairement très permissive et vous autorise à réutiliser, modifier, ou même vendre tout le contenu que vous le désirez, à condition de créditer l'auteur initial et de conserver la notice de propriété intellectuelle contenue dans la licence : <span class="italique">« Copyright (c) 2005 Eric Bisceglia / NoBleme.com »</span>.
        </p>

        <p>
          La modération à postériori ne nous permet pas d'être responsables des contenus postés par les utilisateurs sur le site. Toutefois, nous avons un <a class="gras" href="<?=$chemin?>pages/doc/coc">code de conduite</a> que nous respectons à la lettre, et tout contenu allant à l'encontre de ce code de conduite sera supprimé dans les plus brefs délais. Les utilisateurs du site contrevenant de façon délibérée à ce code de conduite se veront exclus temporairement ou définitivement de la possibilité de participer à la rédaction de contenus sur le site.
        </p>

        <p>
          En publiant du contenu sur NoBleme, vous autorisez à titre gracieux leur reproduction et diffusion sur le reste de NoBleme, et autorisez les autres membres du site à citer vos messages sur le site. Toutefois, en tant qu'auteur des contenus que vous publiez, vous en gardez la propriété intellectuelle et les droits d'auteurs assortis. NoBleme s'engage par conséquent à ne pas réutiliser hors du site sans votre permission et à ne pas monétiser les contenus que vous publiez sur le site.
        </p>

        <p>
          Si un contenu du site enfreint vos droits de propriété intellectuelle et/ou de droit d'auteur, contactez un membre de <a class="gras" href="<?=$chemin?>pages/nobleme/admins">l'équipe administrative</a> et il sera supprimé dans les plus brefs délais.
        </p>

        <?php } else { ?>

        <h1>
          Legal notice
        </h1>

        <br>
        <br>

        <h5>
          Privacy policy and personal data confidentiality
        </h5>

        <p>
          NoBleme is very serious about protecting your personal data. Not only do we respect the <a class="gras" href="https://en.wikipedia.org/wiki/General_Data_Protection_Regulation">GDPR (General Data Protection Regulation)</a>, but we even go further than that by ensuring that we only keep the very bare minimum of personal data and by being fully transparent about the website's internals.
        </p>

        <p>
          If you are wondering which personal data NoBleme keeps about you, we've prepared an automated fully detailed list of it for you in "<a class="gras" href="<?=$chemin?>pages/doc/donnees_personnelles">Your personal data</a>".
        </p>

        <p>
          If you're looking to dig into the website's internals to check by yourself where and how your personal data is used, you can find NoBleme's full source code in "<a class="gras" href="<?=$chemin?>pages/nobleme/coulisses">Behind the scenes</a>".
        </p>

        <p>
          Maybe you just want NoBleme to delete everything that it stores about you? Good thing we fully support the right to be forgotten, and you can make it happen in "<a class="gras" href="<?=$chemin?>pages/doc/droit_oubli">Right to be forgotten</a>".
        </p>

        <br>
        <br>
        <br>

        <h5>
          Content responsibility and intellectual property
        </h5>

        <p>
          The static content of NoBleme's pages (those which are part of the website's source code and aren't created by the website's users) are the personal responsibility of the website's author and administrator, <a class="gras" href="<?=$chemin?>pages/users/user?id=1">Éric Bisceglia</a>. This content is protected, through its <a class="gras" href="<?=$chemin?>pages/nobleme/coulisses">source code</a>, by the <a class="gras" href="https://en.wikipedia.org/wiki/MIT_License">MIT license</a>. This software license is extremely permissive and allows you to reuse, modify, or even sell any part of NoBleme's source code if you want, as long as you credit the original author by keeping the copyright notice contained in the license publicly visible: <span class="italique">« Copyright (c) 2005 Eric Bisceglia / NoBleme.com »</span>.
        </p>

        <p>
          As we moderate content only after users post it to the website, we can not be held responsible for the content posted by users on the website. However, we have a <a class="gras" href="<?=$chemin?>pages/doc/coc">code of conduct</a> which we expect ourselves and our users to follow. Any content which goes against this code of conduct will be deleted as soon as possible. Users which deliberately go against this code of conduct will find themselves temporarly or permanently excluded from contributing to NoBleme, and thus lose their ability to post content on the website.
        </p>

        <p>
          By posting content on NoBleme, you authorize us to reuse and repost this content on the rest of NoBleme, and authorize other users of the website to quote the content that you posted. However, as the author of the content that you are posting on NoBleme, you own full intellectual property rights on anything that you post on the website. This means that NoBleme will not reuse those contents outside of the website or monetize them in any way without your authorization.
        </p>

        <p>
          If you believe that something on the website infringes on your intellectual property rights, contact a member of the <a class="gras" href="<?=$chemin?>pages/nobleme/admins">website's staff</a> and it will be removed as quickly as possible.
        </p>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';