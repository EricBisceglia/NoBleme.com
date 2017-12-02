<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

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
$js   = array('forum/ouvrir_sujet', 'dynamique', 'toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Titre




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/




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

  // Catégorisation du sujet
  $trad['cat_apparence']    = "Apparence de votre sujet de discussion";
  $trad['cat_app_fil']      = "Fil de discussion";
  $trad['cat_app_anon']     = "Fil de discussion anonyme";
  $trad['cat_class']        = "Classification de votre sujet";
  $trad['cat_cl_standard']  = "Sujet standard";
  $trad['cat_cl_serieux']   = "Sujet sérieux";
  $trad['cat_cl_debat']     = "Débat d'opinion";
  $trad['cat_cl_jeu']       = "Jeu de forum";
  $trad['cat_categorie']    = "Catégorisation de votre sujet";
  $trad['cat_cat_aucun']    = "Aucune catégorie";
  $trad['cat_cat_pol']      = "Politique";
  $trad['cat_cat_info']     = "Informatique";
  $trad['cat_cat_nobleme']  = "NoBleme.com";
  $trad['cat_composer']     = "COMPOSER MON SUJET DE DISCUSSION";
  $trad['cat_placeholder']  = "Cliquez sur le nom d'une option à gauche et une explication illustrée de son fonctionnement apparaitra dans ce cadre.";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte2">

        <h1><?=$trad['titre']?></h1>

        <h5><?=$trad['soustitre']?></h5>

        <?=$trad['desc']?>

        <br>
        <br>
        <br>

        <div class="flexcontainer">
          <div style="flex:2">

            <form method="POST">
              <fieldset>

                <label class="texte_noir forum_nouveau_sujet_option"><?=$trad['cat_apparence']?></label>

                <input id="forum_presentation_fil" name="forum_presentation_fil" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'fil');"><?=$trad['cat_app_fil']?></a>
                </div>
                <br>

                <input id="forum_presentation_anonyme" name="forum_presentation_anonyme" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'anonyme');"><?=$trad['cat_app_anon']?></a>
                </div>
                <br>

                <br>

                <label class="texte_noir forum_nouveau_sujet_option forum_nouveau_sujet_label"><?=$trad['cat_class']?></label>

                <input id="forum_type_standard" name="forum_type_standard" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'standard');"><?=$trad['cat_cl_standard']?></a>
                </div>
                <br>

                <input id="forum_type_serieux" name="forum_type_serieux" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'serieux');"><?=$trad['cat_cl_serieux']?></a>
                </div>
                <br>

                <input id="forum_type_debat" name="forum_type_debat" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'debat');"><?=$trad['cat_cl_debat']?></a>
                </div>
                <br>

                <input id="forum_type_jeu" name="forum_type_jeu" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'jeu');"><?=$trad['cat_cl_jeu']?></a>
                </div>
                <br>

                <br>

                <label class="texte_noir forum_nouveau_sujet_option forum_nouveau_sujet_label"><?=$trad['cat_categorie']?></label>

                <input id="forum_categorie_aucune" name="forum_categorie_aucune" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'aucune');"><?=$trad['cat_cat_aucun']?></a>
                </div>
                <br>

                <input id="forum_categorie_politique" name="forum_categorie_politique" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'politique');"><?=$trad['cat_cat_pol']?></a>
                </div>
                <br>

                <input id="forum_categorie_informatique" name="forum_categorie_informatique" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'informatique');"><?=$trad['cat_cat_info']?></a>
                </div>
                <br>

                <input id="forum_categorie_nobleme" name="forum_categorie_nobleme" type="checkbox">
                <div class="pointeur label-inline gras forum_nouveau_sujet_option">
                  <a onclick="forum_ouvrir_sujet_explications('<?=$chemin?>', 'nobleme');"><?=$trad['cat_cat_nobleme']?></a>
                </div>
                <br>

                <br>

                <button type="button"><?=$trad['cat_composer']?></button>

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

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';