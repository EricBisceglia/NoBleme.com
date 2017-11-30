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
$js   = array('dynamique');




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
  $trad['titre']      = "Forum NoBleme";
  $trad['soustitre']  = "Ouvrir un nouveau sujet de discussion";
  $trad['desc']       = <<<EOD
<p>
  Avant de composer le contenu du sujet que vous souhaitez poster sur le <a class="gras" href="{$chemin}pages/forum/index">forum NoBleme</a>, vous devez commencer par spécifier de quel type de sujet il s'agit. Plusieurs options d'apparence, classification, et catégorisation de sujet vous serons proposés, et vous devrez impérativement sélectionner un de chaque. Une fois que vous aurez sélectionné les trois, un bouton apparaitra qui vous permettra de composer le contenu de votre sujet. <span class="gras">Si vous hésitez ou voulez créer un sujet de forum linéaire classique, sélectionnez tout simplement la première option dans les trois catégories.</span>
</p>
<p>
  Afin de vous aider à comprendre ce que chacune des options signifie, vous pouvez cliquer sur le nom d'une option, et une description illustrée de l'option choisie apparaitra dans l'encadré à droite. Assurez-vous de faire le bon choix car il s'agit d'un choix définitif : <span class="gras">Vous ne pourrez plus modifier ces options une fois votre sujet de discussion publié sur le forum.</span>
</p>
EOD;
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

                <label class="texte_noir forum_nouveau_sujet_option">Apparence de votre sujet de discussion:</label>

                <input id="forum_presentation_fil" name="forum_presentation_fil" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Fil de discussion</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Sujet de discussion linéaire classique,<br>
                    dans lequel les messages se suivent dans l'ordre.<br>
                    <span class="texte_positif">Idéal pour la majorité des conversations.</span>
                  </span>
                </div>
                <br>

                <input id="forum_presentation_anonyme" name="forum_presentation_anonyme" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Fil anonyme</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Sujet de discussion linéaire classique,<br>
                    dans lequel les messages se suivent dans l'ordre,<br>
                    où tous les messages sont postés anonymement<br>
                    (les messages n'ont pas d'auteur visible)<br>
                    <span class="texte_positif">Idéal pour les conversations non sérieuses.</span>
                  </span>
                </div>
                <br>

                <br>

                <label class="texte_noir forum_nouveau_sujet_option forum_nouveau_sujet_label">Classification de votre sujet :</label>

                <input id="forum_type_standard" name="forum_type_standard" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Sujet standard</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Sélectionnez ceci si votre sujet ne correspond<br>
                    à aucune des autres options ci-dessous<br>
                    <span class="texte_positif">Idéal pour la majorité des conversations.</span>
                  </span>
                </div>
                <br>

                <input id="forum_type_serieux" name="forum_type_serieux" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Sujet sérieux</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Vous désirez que les conversations autour de votre sujet restent sérieuses.<br>
                    L'équipe administrative modèrera ce sujet avec plus de sévérité<br>
                    et supprimera les réponses qui ne sont pas sérieuses.<br>
                    <span class="texte_positif">Idéal pour parler de sujets personnels dont vous ne souhaitez pas débattre.</span>
                  </span>
                </div>
                <br>

                <input id="forum_type_debat" name="forum_type_debat" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Débat d'opinion</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Votre sujet est fait pour discuter de façon constructive,<br>
                    pour débattre d'un sujet tout en restant ouvert aux opinions des autres.<br>
                    L'équipe administrative modèrera ce sujet avec plus de sévérité<br>
                    et supprimera les réponses hors sujet, les trolls, et les attaques personnelles.<br>
                    <span class="texte_positif">Idéal pour les débats constructifs.</span>
                  </span>
                </div>
                <br>

                <br>

                <label class="texte_noir forum_nouveau_sujet_option forum_nouveau_sujet_label">Catégorisation de votre sujet :</label>

                <input id="forum_categorie_aucune" name="forum_categorie_aucune" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Aucune catégorie</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Sélectionnez ceci si votre sujet ne correspond<br>
                    à aucune des autres catégories ci-dessous<br>
                  </span>
                </div>
                <br>

                <input id="forum_categorie_politique" name="forum_categorie_politique" type="checkbox">
                <div class="tooltip-container label-inline gras forum_nouveau_sujet_option">
                  <a>Politique</a>
                  <span class="tooltip forum_nouveau_sujet_tooltip">
                    Sujet parlant d'un sujet politique, ou parlant d'actualités chargées de politique.
                  </span>
                </div>
                <br>

                <br>

                <button type="button">Composer mon sujet de discussion</button>

              </fieldset>
            </form>

          </div>
          <div class="forum_nouveau_sujet_cadre" style="flex:3">
            <div class="indiv forum_nouveau_sujet_valignhack_1">
             <div class="indiv forum_nouveau_sujet_valignhack_2">
               <div class="indiv align_center">
                 Cliquez sur le nom d'une option à gauche et une explication illustrée de leur fonctionnement apparaitra dans ce cadre.
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