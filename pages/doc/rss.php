<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'RSS';

// Identification
$page_nom = "S'abonne aux flux RSS";
$page_url = "pages/doc/rss";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Flux RSS" : "RSS feeds";
$page_desc  = "S'abonner aux flux RSS de NoBleme pour ne rien rater";

// CSS & JS
$css  = array('doc');
$js   = array('toggle', 'doc/rss_checkboxes');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Assemblage d'un flux RSS
if(isset($_POST['flux_go']))
{
  // On prépare la liste des flux possibles
  if($lang == 'FR')
    $liste_flux = array('flux_irl'                ,
                        'flux_nbdbweb'            ,
                        'flux_nbdbdico'           ,
                        'flux_devblog'            ,
                        'flux_todo'               ,
                        'flux_todo_fini'          ,
                        'flux_misc_fr'            ,
                        'flux_misc_en'            ,
                        'flux_ecrivains'          ,
                        'flux_ecrivains_concours' ,
                        'flux_forum_fr'           ,
                        'flux_forum_en'           ,
                        'flux_forumpost_fr'       ,
                        'flux_forumpost_en'       );
  else
    $liste_flux = array('flux_irl'                ,
                        'flux_nbdbweb'            ,
                        'flux_nbdbdico'           ,
                        'flux_misc_fr'            ,
                        'flux_misc_en'            ,
                        'flux_forum_fr'           ,
                        'flux_forum_en'           ,
                        'flux_forumpost_fr'       ,
                        'flux_forumpost_en'       );

  // On initialise un compteur et l'url
  $fluxcount  = 0;
  $flux_url   = $GLOBALS['url_site'].'rss';

  // On parcourt cette liste
  foreach($liste_flux as $flux)
  {
    // Assainissement du postdata
    $check_flux = postdata_vide($flux, 'string', '');

    // Si la case est cochée, on agrandit l'url
    if($check_flux == 'on')
    {
      $fluxcount++;
      if(strpos($flux_url,'?') !== false) {
        $flux_url .= '&'.$flux;
      } else {
        $flux_url .= '?'.$flux;
      }
    }
  }

  // Si on est en anglais, on le précise dans l'url
  if($lang != 'FR')
    $flux_url .= '&lang_en';

  // Si l'URL est vide, on la gènere pas
  if(!$fluxcount)
    $flux_url = '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']          = "Flux RSS";
  $trad['soustitre']      = "S'abonner pour ne rien rater";
  $trad['desc']           = <<<EOD
<p>
  Les <a class="gras" href="https://fr.wikipedia.org/wiki/RSS">flux RSS</a> sont un système d'abonnement volontaire permettant d'être tenu au courant au rythme que l'on veut des nouveautés dans une section spécifique d'un site. NoBleme possède des flux RSS pour toutes les sections actives du site, dont les liens vous sont proposés sur cette page si vous désirez vous y abonner.
</p>
<p>
  Pour suivre un flux RSS, il faut utiliser ce que l'on appelle un <a class="gras" href="https://fr.wikipedia.org/wiki/Agr%C3%A9gateur">agrégateur</a>, un service qui se charge d'aller vérifier régulièrement s'il y a des nouvelles entrées dans le flux. Si vous ne savez pas vous servir d'un agrégateur, cliquez sur le bouton ci-dessous pour un tutoriel illustré très simple et très rapide :
</p>
EOD;

  // Personnalisation
  $trad['flux_titre']     = "Personnalisez vos flux RSS";
  $trad['flux_desc']      = <<<EOD
<p>
  Au lieu de vous proposer de choisir à quels flux vous désirez vous abonner un par un, NoBleme vous offre la possibilité de créer une combinaison de flux personnalisée. Tout est possible : S'abonner à juste une section de NoBleme, avoir tout NoBleme en un seul abonnement, s'abonner à plusieurs flux différents pour chaque section de NoBleme, vous êtes libres de choisir ce qui correspond à votre besoin.
</p>
<p>
  Pour ce faire, utilisez le menu déroulant ci-dessous pour sélectionner un des flux RSS prédéfinis, et/ou cochez les cases en dessous pour sélectionner la combinaison de flux RSS spécifique que vous désirez assembler. Une fois votre sélection faite, appuyez sur le bouton « Générer mon flux RSS » et vous serez redirigé vers le flux que vous avez demandé. Simple !
</p>
EOD;
  $trad['flux_label']     = "Préselections de flux RSS";
  $trad['flux_error']     = "Vous devez cocher au moins une case pour générer un flux !";
  $trad['flux_s_all']     = "Sélectionner tous les flux RSS";
  $trad['flux_s_none']    = "Tout déselectionner";
  $trad['flux_s_irl']     = "Rencontres irl";
  $trad['flux_irl']       = "Organisation de nouvelles IRL";
  $trad['flux_s_nbdbweb'] = "Encyclopédie de la culture internet";
  $trad['flux_nbdbweb']   = "Nouveau contenu dans l'encyclopédie de la culture internet";
  $trad['flux_nbdbdico']  = "Nouveau contenu dans le dictionnaire de la culture internet";
  $trad['flux_s_misc']    = "Miscellanées";
  $trad['flux_misc_fr']   = "Nouvelles miscellanées (français)";
  $trad['flux_misc_en']   = "Nouvelles miscellanées (anglais)";
  $trad['flux_s_forum']   = "Forum NoBleme";
  $trad['flux_forum']     = "Nouveaux sujets sur le forum";
  $trad['flux_forumpost'] = "Messages postés sur le forum";
  $trad['flux_forum_fr']  = "(en français)";
  $trad['flux_forum_en']  = "(en anglais)";
  $trad['flux_forum_all'] = "(bilingue)";
  $trad['flux_go']        = "GÉNÉRER MON FLUX RSS";
  $trad['flux_resultat']  = "Adresse de votre flux RSS personnalisé (à coller dans votre agrégateur de flux RSS)";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']          = "RSS feeds";
  $trad['soustitre']      = "Subscribe and never miss anything";
  $trad['desc']           = <<<EOD
<p>
  <a class="gras" href="https://en.wikipedia.org/wiki/RSS">RSS feeds</a> are a subscription system which lets you know whenever new content is posted on websites that you choose to follow. NoBleme has RSS feeds for every active section of the website.
</p>
<p>
  In order to follow an RSS feed, you need what is called an <a class="gras" href="https://en.wikipedia.org/wiki/News_aggregator">aggregator</a>. If you are new to the world of RSS feeds and/or don't know which aggregator to use, I would suggest the free, web-based, and simple to use <a class="gras" href="https://inoreader.com">Inoreader</a>. Once you have created an account on Inoreader, paste the URL of a feed into it, and install a browser plugin such as <a class="gras" href="https://addons.mozilla.org/fr/firefox/addon/inoreader-companion/">this Firefox one</a> or <a class="gras" href="https://chrome.google.com/webstore/detail/inoreader-companion/kfimphpokifbjgmjflanmfeppcjimgah">this Chrome one</a> to get notified when new entries are added to your feeds. If you prefer using your smartphone, there's also <a class="gras" href="https://play.google.com/store/apps/details?id=com.innologica.inoreader">an Android app</a> and <a class="gras" href="https://itunes.apple.com/us/app/inoreader-rss-news-reader/id892355414?mt=8">an iTunes app</a>.
</p>
EOD;

  // Personnalisation
  $trad['flux_titre']     = "Customize your RSS feeds";
  $trad['flux_desc']      = <<<EOD
<p>
  Instead of giving you an array of RSS picks to select one by one, NoBleme lets you compose a customized RSS feed containing the specific combination of content that you desire.
</p>
<p>
  In order to build your dream RSS feed, use the dropdown menu below to select a predefined combination and/or check the boxes below to select which contents you want or don't want to follow. Once done, press the « Generate my RSS feed » button, and you will be redirected to the page of your desired feed.
</p>
EOD;
  $trad['flux_label']     = "Preselected RSS feed combinations";
  $trad['flux_error']     = "You must check at least one box to generate a feed !";
  $trad['flux_s_all']     = "Select all RSS feeds";
  $trad['flux_s_none']    = "Unselect all feeds";
  $trad['flux_s_irl']     = "Real life meetups";
  $trad['flux_irl']       = "Real life meetups";
  $trad['flux_s_nbdbweb'] = "Encyclopedia of internet culture";
  $trad['flux_nbdbweb']   = "New content in the encyclopedia of internet culture";
  $trad['flux_nbdbdico']  = "New content in the dictionary of internet culture";
  $trad['flux_s_misc']    = "Quote database";
  $trad['flux_misc_fr']   = "New quotes in the miscellanea (in french)";
  $trad['flux_misc_en']   = "New quotes in the miscellanea (in english)";
  $trad['flux_s_forum']   = "NoBleme forum";
  $trad['flux_forum']     = "New forum threads";
  $trad['flux_forumpost'] = "Posts on the forum";
  $trad['flux_forum_fr']  = "(in french)";
  $trad['flux_forum_en']  = "(in english)";
  $trad['flux_forum_all'] = "(bilingual)";
  $trad['flux_go']        = "GENERATE MY RSS FEED";
  $trad['flux_resultat']  = "Your custom RSS feed's URL (paste this in your RSS feed aggregator)";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <img src="<?=$chemin?>img/icones/rss.svg" alt="RSS" height="40">
        </h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>

        <?php if($lang == 'FR') { ?>

        <button class="button button-outline" onclick="toggle_row('rss_tutoriel');">TUTORIEL : SE SERVIR D'UN AGRÉGATEUR POUR S'ABONNER AUX FLUX RSS DE NOBLEME</button>

        <div id="rss_tutoriel" class="hidden">

          <br>
          <br>

          <h5>Tutoriel : Mise en place rapide d'un lecteur de flux RSS</h5>

          <p>
            Pour commencer, il faut choisir un agrégateur de flux RSS. Je vous propose d'utiliser <a class="gras" href="https://inoreader.com/?lang=fr_FR">Inoreader</a>, comme il est gratuit, plutôt simple à utiliser, et disponible en français. Commencez donc par aller sur <a class="gras" href="https://inoreader.com/?lang=fr_FR">le site d'inoreader</a>, appuyez sur le bouton « Créer un compte gratuit », créez votre compte, puis connectez-vous.
          </p>

          <br>
          <br>

          <div class="indiv align_center">
            <img src="<?=$chemin?>img/doc/rss_1.png" alt="Illustration du tutoriel"><br>
            <br>
            <img src="<?=$chemin?>img/doc/rss_2.png" alt="Illustration du tutoriel"><br>
          </div>

          <br>
          <br>

          <p>
            Maintenant que vous avez un compte sur inoreader, il vous faut choisir un flux RSS à ajouter à votre compte. Allez <a class="gras" href="#flux_select">en bas de la page que vous lisez en ce moment-même</a>, choisissez une option dans le menu déroulant ou cochez les cases qui correspondent à ce que vous désirez suivre, puis cliquez sur le bouton « Générer mon flux RSS ».
          </p>

          <p>
            Vous vous retrouverez avec l'adresse d'une page et l'instruction de coller cette adresse dans votre agrégateur de flux RSS. Sélectionnez cette adresse, et copiez-la dans votre presse-papiers.
          </p>

          <br>
          <br>

          <div class="indiv align_center">
            <img src="<?=$chemin?>img/doc/rss_3.png" alt="Illustration du tutoriel"><br>
            <br>
            <br>
            <img src="<?=$chemin?>img/doc/rss_4.png" alt="Illustration du tutoriel"><br>
          </div>

          <br>
          <br>

          <p>
            Revenez sur <a class="gras" href="https://inoreader.com/?lang=fr_FR">Inoreader</a>, et connectez-vous à votre compte. En haut à gauche de la page, vous verrez un champ de texte, collez dedans l'adresse que vous venez de copier sur NoBleme, puis cliquez sur « Ajouter les flux ».
          </p>

          <br>
          <br>

          <div class="indiv align_center">
            <img src="<?=$chemin?>img/doc/rss_5.png" alt="Illustration du tutoriel"><br>
          </div>

          <br>
          <br>

          <p>
            C'est fait, vous êtes maintenant abonné ! Il ne vous reste plus qu'à cliquer sur « Marquer tout comme lu » dans inoreader, puis à vous connecter sur inoreader de temps en temps pour consulter vos flux RSS et voir s'il s'est passé de nouvelles choses sur NoBleme.
          </p>

          <p>
            Si vous préférez être notifié directement lorsqu'il y a de nouvelles activités dans vos flux RSS plutôt que de devoir aller vérifier manuellement sur inoreader, vous pouvez installer dans votre navigateur l'extension inoreader <a class="gras" href="https://addons.mozilla.org/fr/firefox/addon/inoreader-companion/">pour Firefox</a> ou <a class="gras" href="https://chrome.google.com/webstore/detail/inoreader-companion/kfimphpokifbjgmjflanmfeppcjimgah">pour Chrome</a>. Si vous préférez utiliser votre smartphone, il existe également des apps inoreader <a class="gras" href="https://play.google.com/store/apps/details?id=com.innologica.inoreader&hl=fr">pour Android</a> et <a class="gras" href="https://itunes.apple.com/us/app/inoreader-rss-news-reader/id892355414?mt=8"> pour iOS</a>.
          </p>

        </div>

        <br>
        <br id="flux_select">

        <?php } ?>

        <br>

        <h5><?=$trad['flux_titre']?></h5>

        <?=$trad['flux_desc']?>

        <br>

        <?php if(isset($fluxcount) && !$fluxcount) { ?>
        <span class="texte_negatif moinsgros gras"><?=$trad['flux_error']?></span><br>
        <br>
        <?php } else { ?>
        <br>
        <?php } ?>

        <form method="POST" action="rss#rss_resultat">
          <fieldset>

            <label for="flux_preset"><?=$trad['flux_label']?></label>
            <select id="flux_preset" name="flux_preset" class="indiv" onchange="rss_check_boxes();">
              <option value="0">&nbsp;</option>
              <option value="all"><?=$trad['flux_s_all']?></option>
              <option value="none"><?=$trad['flux_s_none']?></option>
              <option value="irl"><?=$trad['flux_s_irl']?></option>
              <option value="nbdbweb"><?=$trad['flux_s_nbdbweb']?></option>
              <option value="misc"><?=$trad['flux_s_misc']?></option>
              <option value="forum_fr"><?=$trad['flux_s_forum']?> <?=$trad['flux_forum_fr']?></option>
              <option value="forum_en"><?=$trad['flux_s_forum']?> <?=$trad['flux_forum_en']?></option>
              <option value="forum_all"><?=$trad['flux_s_forum']?> <?=$trad['flux_forum_all']?></option>
              <?php if($lang == 'FR') { ?>
              <option value="ecrivains">Coin des écrivains</option>
              <option value="dev">Développement de NoBleme</option>
              <?php } ?>
            </select><br>
            <br>

            <input id="flux_irl" name="flux_irl" type="checkbox">
            <label class="label-inline" for="flux_irl"><?=$trad['flux_irl']?></label><br>

            <input id="flux_nbdbweb" name="flux_nbdbweb" type="checkbox">
            <label class="label-inline" for="flux_nbdbweb"><?=$trad['flux_nbdbweb']?></label><br>

            <input id="flux_nbdbdico" name="flux_nbdbdico" type="checkbox">
            <label class="label-inline" for="flux_nbdbdico"><?=$trad['flux_nbdbdico']?></label><br>

            <?php if($lang == 'FR') { ?>

            <input id="flux_misc_fr" name="flux_misc_fr" type="checkbox">
            <label class="label-inline" for="flux_misc_fr"><?=$trad['flux_misc_fr']?></label><br>

            <input id="flux_misc_en" name="flux_misc_en" type="checkbox">
            <label class="label-inline" for="flux_misc_en"><?=$trad['flux_misc_en']?></label><br>

            <?php } else { ?>

            <input id="flux_misc_en" name="flux_misc_en" type="checkbox">
            <label class="label-inline" for="flux_misc_en"><?=$trad['flux_misc_en']?></label><br>

            <input id="flux_misc_fr" name="flux_misc_fr" type="checkbox">
            <label class="label-inline" for="flux_misc_fr"><?=$trad['flux_misc_fr']?></label><br>

            <?php } ?>

            <?php if($lang == 'FR') { ?>

            <input id="flux_forum_fr" name="flux_forum_fr" type="checkbox">
            <label class="label-inline" for="flux_forum_fr"><?=$trad['flux_forum']?> <?=$trad['flux_forum_fr']?></label><br>

            <input id="flux_forumpost_fr" name="flux_forumpost_fr" type="checkbox">
            <label class="label-inline" for="flux_forumpost_fr"><?=$trad['flux_forumpost']?> <?=$trad['flux_forum_fr']?></label><br>

            <?php } ?>

            <input id="flux_forum_en" name="flux_forum_en" type="checkbox">
            <label class="label-inline" for="flux_forum_en"><?=$trad['flux_forum']?> <?=$trad['flux_forum_en']?></label><br>

            <input id="flux_forumpost_en" name="flux_forumpost_en" type="checkbox">
            <label class="label-inline" for="flux_forumpost_en"><?=$trad['flux_forumpost']?> <?=$trad['flux_forum_en']?></label><br>

            <?php if($lang == 'EN') { ?>

            <input id="flux_forum_fr" name="flux_forum_fr" type="checkbox">
            <label class="label-inline" for="flux_forum_fr"><?=$trad['flux_forum']?> <?=$trad['flux_forum_fr']?></label><br>

            <input id="flux_forumpost_fr" name="flux_forumpost_fr" type="checkbox">
            <label class="label-inline" for="flux_forumpost_fr"><?=$trad['flux_forumpost']?> <?=$trad['flux_forum_fr']?></label><br>

            <?php } ?>

            <?php if($lang != 'FR') { ?>
            <div class="hidden">
            <?php } ?>

            <input id="flux_ecrivains" name="flux_ecrivains" type="checkbox">
            <label class="label-inline" for="flux_ecrivains">Textes du coin des écrivains</label><br>

            <input id="flux_ecrivains_concours" name="flux_ecrivains_concours" type="checkbox">
            <label class="label-inline" for="flux_ecrivains_concours">Concours du coin des écrivains</label><br>

            <input id="flux_devblog" name="flux_devblog" type="checkbox">
            <label class="label-inline" for="flux_devblog">Blogs de développement</label><br>

            <input id="flux_todo" name="flux_todo" type="checkbox">
            <label class="label-inline" for="flux_todo">Liste des tâches ouvertes</label><br>

            <input id="flux_todo_fini" name="flux_todo_fini" type="checkbox">
            <label class="label-inline" for="flux_todo_fini">Liste des tâches finies</label><br>

            <?php if($lang != 'FR') { ?>
            </div>
            <?php } ?>

            <br id="rss_resultat">
            <input value="<?=$trad['flux_go']?>" type="submit" name="flux_go"><br>

            <?php if(isset($flux_url) && $flux_url) { ?>
            <br>
            <label class="texte_negatif" for="rss_url"><?=$trad['flux_resultat']?></label>
            <input id="rss_url" name="rss_url" class="indiv gras" type="text" value="<?=$flux_url?>" onclick="this.select();"><br>
            <?php } ?>

          </fieldset>
        </form>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';