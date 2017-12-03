<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/forum.inc.php';

// Permissions
useronly($lang);

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumNew';

// Identification
$page_nom = "Prépare un nouveau sujet pour le forum";
$page_url = "pages/forum/new";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Forum : Nouveau sujet" : "Forum: New topic";
$page_desc  = "Ouvrir un nouveau sujet de discussion sur le forum NoBleme";

// CSS & JS
$css  = array('forum');
$js   = array('forum/ouvrir_sujet', 'dynamique');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Récupération des options de création du sujet

// Par défaut, on autorise pas la composition du sujet
$new_composition = 0;

// Maintenant, on va vérifier si on peut l'autoriser
if(isset($_POST['forum_presentation_go']))
{
  // On récupère les options d'apparence
  $new_apparence = (isset($_POST['forum_presentation_fil']))      ? 'Fil'     : 0;
  $new_apparence = (isset($_POST['forum_presentation_anonyme']))  ? 'Anonyme' : $new_apparence;

  // Ainsi que les options de classification
  $new_classification = (isset($_POST['forum_type_standard']))  ? 'Standard'  : 0;
  $new_classification = (isset($_POST['forum_type_serieux']))   ? 'Sérieux'   : $new_classification;
  $new_classification = (isset($_POST['forum_type_debat']))     ? 'Débat'     : $new_classification;
  $new_classification = (isset($_POST['forum_type_jeu']))       ? 'Jeu'       : $new_classification;

  // Et les options de catégorie
  $new_categorie  = (isset($_POST['forum_categorie_aucune']))       ? 'Aucune'        : 0;
  $new_categorie  = (isset($_POST['forum_categorie_politique']))    ? 'Politique'     : $new_categorie;
  $new_categorie  = (isset($_POST['forum_categorie_informatique'])) ? 'Informatique'  : $new_categorie;
  $new_categorie  = (isset($_POST['forum_categorie_nobleme']))      ? 'NoBleme'       : $new_categorie;

  // Si les trois options sont remplies, on autorise la composition du sujet
  $new_composition = ($new_apparence && $new_classification && $new_categorie) ? 1 : 0;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ouverture d'un nouveau sujet de discussion

if(isset($_POST['forum_add_titre']))
{
  // Assainissement du postdata
  $add_apparence        = postdata_vide('forum_add_apparence', 'string', 'Fil');
  $add_classification   = postdata_vide('forum_add_classification', 'string', 'Standard');
  $add_categorie        = postdata_vide('forum_add_categorie', 'string', 'Aucune');
  $add_langage          = postdata_vide('forum_add_langue', 'string', 'FR');
  $add_public           = (getmod('forum')) ? postdata_vide('forum_add_public', 'int', 1) : 1;
  $add_titre            = (isset($_POST['forum_add_titre'])) ? postdata(tronquer_chaine($_POST['forum_add_titre'], 100), 'string', ''): '';
  $add_premier_message  = postdata_vide('forum_add_contenu', 'string', '');

  // On crée le sujet
  $add_auteur = $_SESSION['user'];
  $timestamp  = time();
  query(" INSERT INTO forum_sujet
          SET         forum_sujet.FKmembres_createur        = '$add_auteur'         ,
                      forum_sujet.FKmembres_dernier_message = '$add_auteur'         ,
                      forum_sujet.timestamp_creation        = '$timestamp'          ,
                      forum_sujet.timestamp_dernier_message = '$timestamp'          ,
                      forum_sujet.apparence                 = '$add_apparence'      ,
                      forum_sujet.classification            = '$add_classification' ,
                      forum_sujet.categorie                 = '$add_categorie'      ,
                      forum_sujet.public                    = '$add_public'         ,
                      forum_sujet.ouvert                    = 1                     ,
                      forum_sujet.epingle                   = 0                     ,
                      forum_sujet.langage                   = '$add_langage'        ,
                      forum_sujet.titre                     = '$add_titre'          ,
                      forum_sujet.nombre_reponses           = 0                     ");

  // On ajoute le message au sujet
  $sujet_id = mysqli_insert_id($db);
  query(" INSERT INTO forum_message
          SET         forum_message.FKforum_sujet           = '$sujet_id'             ,
                      forum_message.FKforum_message_parent  = 0                       ,
                      forum_message.FKmembres               = '$add_auteur'           ,
                      forum_message.timestamp_creation      = '$timestamp'            ,
                      forum_message.timestamp_modification  = 0                       ,
                      forum_message.message_supprime        = 0                       ,
                      forum_message.contenu                 = '$add_premier_message'  ");

  // Si nécessaire, on augmente le post count de l'user
  forum_recompter_messages_membre($add_auteur);

  // Activité récente
  $add_pseudo = postdata(getpseudo(), 'string');
  $add_modlog = ($add_public) ? 0 : 1;
  query(" INSERT INTO activite
          SET         activite.timestamp      = '$timestamp'  ,
                      activite.log_moderation = '$add_modlog' ,
                      activite.pseudonyme     = '$add_pseudo' ,
                      activite.action_type    = 'forum_new'   ,
                      activite.action_id      = '$sujet_id'   ,
                      activite.action_titre   = '$add_titre'  ");

  // Bot IRC
  $add_pseudo_raw = getpseudo();
  $add_titre_raw  = (isset($_POST['forum_add_titre'])) ? tronquer_chaine($_POST['forum_add_titre'], 100) : '';
  if($add_public)
  {
    if($add_langage == 'FR')
      ircbot($chemin, $add_pseudo_raw." a ouvert un nouveau sujet sur le forum : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/forum/sujet?id=".$sujet_id, "#NoBleme");
    else
      ircbot($chemin, $add_pseudo_raw." opened a new thread on the forum: ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/forum/sujet?id=".$sujet_id, "#english");
  }
  else
    ircbot($chemin, $add_pseudo_raw." a ouvert un sujet privé sur le forum : ".$add_titre_raw." - ".$GLOBALS['url_site']."pages/forum/sujet?id=".$sujet_id, "#sysop");

  // Redirection
  exit(header("Location: ".$chemin."pages/forum/sujet?id=".$sujet_id));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// Menu déroulant pour la sélection de la langue
$temp_lang          = ($lang == 'FR') ? 'Français' : 'French';
$selected           = ($lang == 'FR') ? ' selected' : '';
$select_add_langue  = '<option value="FR"'.$selected.'>'.$temp_lang.'</option>';
$temp_lang          = ($lang == 'FR') ? 'Anglais' : 'English';
$selected           = ($lang == 'FR') ? '' : ' selected';
$select_add_langue .= '<option value="EN"'.$selected.'>'.$temp_lang.'</option>';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']            = "Forum NoBleme";
  $trad['soustitre']        = "Ouvrir un nouveau sujet de discussion";
  $trad['desc']             = <<<EOD
<p>
  Avant de composer le contenu du sujet que vous souhaitez poster sur le <a class="gras" href="{$chemin}pages/forum/index">forum NoBleme</a>, vous devez commencer par spécifier de quel type de sujet il s'agit. Plusieurs options d'apparence, classification, et catégorisation de sujet vous serons proposés, et vous devrez impérativement sélectionner un de chaque. Une fois que vous aurez sélectionné les trois, un bouton apparaitra qui vous permettra de composer le contenu de votre sujet. <span class="gras">Si vous hésitez ou voulez créer un sujet de forum linéaire classique, sélectionnez tout simplement la première option dans les trois catégories.</span>
</p>
<p>
  Afin de vous aider à comprendre ce que chacune des options signifie, vous pouvez cliquer sur le nom d'une option, et une description illustrée de l'option choisie apparaitra dans l'encadré à droite. Assurez-vous de faire le bon choix car il s'agit d'un choix définitif : <span class="gras">Vous ne pourrez plus modifier ces options une fois votre sujet de discussion publié sur le forum.</span>
</p>
EOD;

  // Options de catégorisation du sujet
  $trad['cat_apparence']    = "Apparence de votre sujet de discussion";
  $trad['cat_class']        = "Classification de votre sujet";
  $trad['cat_categorie']    = "Catégorisation de votre sujet";
  $trad['cat_erreur']       = "Vous devez cocher une case pour chacune des trois options ci-dessus avant de pouvoir composer votre sujet de discussion.";
  $trad['cat_composer']     = "COMPOSER MON SUJET DE DISCUSSION";
  $trad['cat_placeholder']  = "Cliquez sur le nom d'une option à gauche et une explication illustrée de son fonctionnement apparaitra dans ce cadre.";

  // Composition du sujet
  $trad['comp_apparence']   = "Apparence ";
  $trad['comp_class']       = "Classification ";
  $trad['comp_categorie']   = "Catégorie ";
  $trad['comp_langue']      = "Langue de la conversation";
  $trad['comp_prive']       = "Visibilité du sujet (option réservée à l'équipe administrative)";
  $trad['comp_prive_pub']   = "Public";
  $trad['comp_prive_prive'] = "Privé (seuls les membres de l'équipe administrative pourront voir ce sujet)";
  $trad['comp_titre']       = "Titre du sujet de discussion (100 caractères maximum)";
  $trad['comp_contenu']     = <<<EOD
Contenu du premier message du sujet (vous pouvez utiliser des <a class="gras" href="{$chemin}pages/doc/emotes">émoticônes</a> et des <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['comp_prev']        = "Prévisualisation du message";
  $trad['comp_go']          = "OUVRIR LE SUJET DE DISCUSSION";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']            = "Forum NoBleme";
  $trad['soustitre']        = "Open a new discussion topic";
  $trad['desc']             = <<<EOD
<p>
  Before you write the contents of the thread you want to post on the <a class="gras" href="{$chemin}pages/forum/index">NoBleme forum</a>, you will first have to specify what kind of thread it is that you want to open by picking a format, subject, and category from predefined options. Once all three are selected, you will be able to get to the topic writing part. <span class="gras">If you don't know what to pick or want to create a standard forum thread, pick the first option in each of the three categories.</span>
</p>
<p>
  If you are wondering what any of the options do, click on one of them and its illustrated description will appear in the frame to its right. Make sure you choose wisely: <span class="gras">You will not be able to modify those options once your thread has been posted.</span>
</p>
EOD;

  // Options de catégorisation du sujet
  $trad['cat_apparence']    = "Format of your discussion thread";
  $trad['cat_class']        = "Subject of your thread";
  $trad['cat_categorie']    = "Category of your thread";
  $trad['cat_erreur']       = "You must check a box in each of the three sets of options above before you can continue.";
  $trad['cat_composer']     = "SELECT MY THREAD OPTIONS";
  $trad['cat_placeholder']  = "Cliquez sur le nom d'une option à gauche et une explication illustrée de son fonctionnement apparaitra dans ce cadre.";

  // Composition du sujet
  $trad['comp_apparence']   = "Format";
  $trad['comp_class']       = "Subject";
  $trad['comp_categorie']   = "Category";
  $trad['comp_langue']      = "Language of your topic";
  $trad['comp_prive']       = "Topic visibility (available to the administrative team only)";
  $trad['comp_prive_pub']   = "Public";
  $trad['comp_prive_prive'] = "Private (only members of the administrative team will be able to see this topic)";
  $trad['comp_titre']       = "Topic title (max. 100 characters)";
  $trad['comp_contenu']     = <<<EOD
Contents of the first message in the thread (you can format your message with <a class="gras" href="{$chemin}pages/doc/emotes">emotes</a> and <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['comp_prev']        = "Formatted message preview";
  $trad['comp_go']          = "OPEN MY DISCUSSION THREAD";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if(!$new_composition) { ?>

      <div class="texte2">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>
        <br>
        <br>

        <div class="flexcontainer">
          <div style="flex:2">

            <form method="POST" id="forum_choisir_options">
              <fieldset>

                <input type="hidden" name="forum_presentation_go">

                <label class="texte_noir forum_nouveau_sujet_option"><?=$trad['cat_apparence']?></label>

                <input id="forum_presentation_fil" name="forum_presentation_fil" type="checkbox" onchange="forum_ouvrir_sujet_categories('apparence', 'forum_presentation_fil');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'fil');"><?=forum_option_info('Fil', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_presentation_anonyme" name="forum_presentation_anonyme" type="checkbox" onchange="forum_ouvrir_sujet_categories('apparence', 'forum_presentation_anonyme');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'anonyme');"><?=forum_option_info('Anonyme', 'complet', $lang)?></a>
                </div>
                <br>

                <br>

                <label class="texte_noir forum_nouveau_sujet_option forum_nouveau_sujet_label"><?=$trad['cat_class']?></label>

                <input id="forum_type_standard" name="forum_type_standard" type="checkbox" onchange="forum_ouvrir_sujet_categories('classification', 'forum_type_standard');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'standard');"><?=forum_option_info('Standard', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_type_serieux" name="forum_type_serieux" type="checkbox" onchange="forum_ouvrir_sujet_categories('classification', 'forum_type_serieux');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'serieux');"><?=forum_option_info('Sérieux', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_type_debat" name="forum_type_debat" type="checkbox" onchange="forum_ouvrir_sujet_categories('classification', 'forum_type_debat');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'debat');"><?=forum_option_info('Débat', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_type_jeu" name="forum_type_jeu" type="checkbox" onchange="forum_ouvrir_sujet_categories('classification', 'forum_type_jeu');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'jeu');"><?=forum_option_info('Jeu', 'complet', $lang)?></a>
                </div>
                <br>

                <br>

                <label class="texte_noir forum_nouveau_sujet_option forum_nouveau_sujet_label"><?=$trad['cat_categorie']?></label>

                <input id="forum_categorie_aucune" name="forum_categorie_aucune" type="checkbox" onchange="forum_ouvrir_sujet_categories('categorisation', 'forum_categorie_aucune');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'aucune');"><?=forum_option_info('Aucune', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_categorie_politique" name="forum_categorie_politique" type="checkbox" onchange="forum_ouvrir_sujet_categories('categorisation', 'forum_categorie_politique');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'politique');"><?=forum_option_info('Politique', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_categorie_informatique" name="forum_categorie_informatique" type="checkbox" onchange="forum_ouvrir_sujet_categories('categorisation', 'forum_categorie_informatique');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'informatique');"><?=forum_option_info('Informatique', 'complet', $lang)?></a>
                </div>
                <br>

                <input id="forum_categorie_nobleme" name="forum_categorie_nobleme" type="checkbox" onchange="forum_ouvrir_sujet_categories('categorisation', 'forum_categorie_nobleme');">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'nobleme');"><?=forum_option_info('NoBleme', 'complet', $lang)?></a>
                </div>
                <br>

                <p class="texte_negatif gras spaced hidden" id="forum_choisir_options_erreur"><?=$trad['cat_erreur']?></p>

                <br>

                <button type="button" onclick="forum_ouvrir_sujet_composer();"><?=$trad['cat_composer']?></button>

              </fieldset>
            </form>

          </div>

          <div class="forum_nouveau_sujet_cadre" style="flex:3" id="forum_explications">

            <div class="indiv forum_nouveau_sujet_valignhack_1">
              <div class="indiv forum_nouveau_sujet_valignhack_2">
                <div class="indiv align_center">
                  <?=$trad['cat_placeholder']?>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>




      <?php } else { ?>

      <div class="texte">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <p>
          <span class="gras"><?=$trad['comp_apparence']?></span>: <?=forum_option_info($new_apparence, 'complet', $lang)?><br>
          <span class="gras"><?=$trad['comp_class']?></span>: <?=forum_option_info($new_classification, 'complet', $lang)?><br>
          <span class="gras"><?=$trad['comp_categorie']?></span>: <?=forum_option_info($new_categorie, 'complet', $lang)?><br>
        </p>

        <br>

        <form class="vspaced" method="POST" id="forum_composer_message">
          <fieldset>

            <input name="forum_add_apparence" type="hidden" value="<?=$new_apparence?>">
            <input name="forum_add_classification" type="hidden" value="<?=$new_classification?>">
            <input name="forum_add_categorie" type="hidden" value="<?=$new_categorie?>">

            <label for="forum_add_langue"><?=$trad['comp_langue']?></label>
            <select id="forum_add_langue" name="forum_add_langue" class="indiv">
              <?=$select_add_langue?>
            </select><br>
            <br>

            <?php if(getmod('forum')) { ?>

            <label for="forum_add_public"><?=$trad['comp_prive']?></label>
            <select id="forum_add_public" name="forum_add_public" class="indiv">
              <option value="1"><?=$trad['comp_prive_pub']?></option>
              <option value="0"><?=$trad['comp_prive_prive']?></option>
            </select><br>
            <br>

            <?php } ?>

            <label for="forum_add_titre" id="forum_add_titre_label"><?=$trad['comp_titre']?></label>
            <input id="forum_add_titre" name="forum_add_titre" class="indiv" type="text" maxlength="100"><br>
            <br>

            <label for="forum_add_contenu" id="forum_add_contenu_label"><?=$trad['comp_contenu']?></label>
            <textarea id="forum_add_contenu" name="forum_add_contenu" class="indiv forum_nouveau_sujet_composition" onkeyup="forum_ouvrir_sujet_previsualisation('<?=$chemin?>');"></textarea><br>
            <br>

            <div id="forum_add_previsualisation_container" class="hidden">
              <label><?=$trad['comp_prev']?></label>
              <div class="vscrollbar forum_nouveau_sujet_previsualisation" id="forum_add_previsualisation">
                &nbsp;
              </div>
              <br>
            </div>

            <br>

            <button type="button" onclick="forum_ouvrir_sujet_envoyer();"><?=$trad['comp_go']?></button>

          </fieldset>
        </form>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';