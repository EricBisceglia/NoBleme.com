<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Doc';

// Identification
$page_nom = "Se renseigne dans la documentation";
$page_url = "pages/doc/index";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = "Documentation";
$page_desc  = "Informations sur divers aspects de NoBleme.com";

// CSS
$css = array('doc');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['soustitre']      = "Aide &amp; informations sur divers aspects de NoBleme";
  $trad['description']    = "NoBleme contient diverses pages de documentation portant sur des sujets variés, qui sont toutes regroupées ici. Vous pouvez cliquer sur une des pages de documentation décrites ci-dessous pour y accéder.";

  // Pages de documentation
  $trad['doct_nobleme']   = "Qu'est-ce que NoBleme ?";
  $trad['docd_nobleme']   = "Pourquoi NoBleme existe ? À quoi sert NoBleme ?<br>Qui a crée NoBleme ? Quelle est l'histoire de NoBleme ?";
  $trad['doct_coc']       = "Code de conduite";
  $trad['docd_coc']       = "Quelques règles de savoir vivre à respecter lors de vos intéractions avec la communauté NoBlemeuse";
  $trad['doct_rss']       = "Flux RSS";
  $trad['docd_rss']       = "Système d'abonnement permettant d'être informé en direct lorsqu'il se passe des choses sur le site";
  $trad['doct_emotes']    = "Émoticônes";
  $trad['docd_emotes']    = "Petites images amusantes permettant de donner de la vie à vos messages";
  $trad['doct_bbcodes']   = "BBCodes";
  $trad['docd_bbcodes']   = "Système de mots-clés permettant de formatter le contenu de vos messages";
  $trad['doct_shorturl']  = "URLs raccourcies";
  $trad['docd_shorturl']  = "Vous trouvez que les adresses des pages de NoBleme sont trop longues ? Dans ce cas, cette page est pour vous";
  $trad['doct_admin']     = "Contacter l'administration";
  $trad['docd_admin']     = "Vous avez un problème ou une situation qui nécessite l'intervention d'un administrateur ? Cliquez ici";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['soustitre']      = "Help &amp; informations about varied aspects of NoBleme";
  $trad['description']    = "NoBleme contains various documentation pages, pertaining to various topics, which are all listed below. Click on any of the documentation pages in the list to be redirected to that page.";

  // Pages de documentation
  $trad['doct_nobleme']   = "What is NoBleme?";
  $trad['docd_nobleme']   = "Why does NoBleme exist? What is NoBleme's purpose?<br>Who created NoBleme? What is NoBleme's history?";
  $trad['doct_coc']       = "Code of conduct";
  $trad['docd_coc']       = "A few rules that everyone should know and follow when interacting with eachother on NoBleme";
  $trad['doct_rss']       = "RSS feeds";
  $trad['docd_rss']       = "Subscription system which allows you to know right away whenever something happens on the website";
  $trad['doct_emotes']    = "Emotes";
  $trad['docd_emotes']    = "Funny little images which allow you to make your message more lively";
  $trad['doct_bbcodes']   = "BBCodes";
  $trad['docd_bbcodes']   = "Keyword system which allows you to format the messages you post";
  $trad['doct_shorturl']  = "Short URLs";
  $trad['docd_shorturl']  = "Have you ever wanted to link a page on NoBleme but thought that the URL was too long? Then this page is for you";
  $trad['doct_admin']     = "Contact the administrative staff";
  $trad['docd_admin']     = "Do you have an issue or a situation which requires the intervention of an administrator? Click here";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>Documentation</h1>

        <h5><?=$trad['soustitre']?></h5>

        <p><?=$trad['description']?></p>

      </div>

      <br>
      <br>

      <div class="minitexte2">

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/nobleme';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_nobleme']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_nobleme']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/coc';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_coc']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_coc']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/rss';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_rss']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_rss']?>
            </span>
          </div>
        </div>

        <br>

        <div class="flexcontainer">
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/emotes';">
              <div class="align_center doc_minibordure">
                <h5 class="doc_minipadding_bot doc_minibordure_bot">
                  <?=$trad['doct_emotes']?>
                </h5>
                <span class="doc_minipadding">
                  <?=$trad['docd_emotes']?>
                </span>
              </div>
            </div>
          </div>
          <div style="flex:1;">
            &nbsp;
          </div>
          <div style="flex:10;">
            <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/bbcodes';">
              <div class="align_center doc_minibordure">
                <h5 class="doc_minipadding_bot doc_minibordure_bot">
                  <?=$trad['doct_bbcodes']?>
                </h5>
                <span class="doc_minipadding">
                  <?=$trad['docd_bbcodes']?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/doc/raccourcis';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_shorturl']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_shorturl']?>
            </span>
          </div>
        </div>

        <br>

        <div class="doc_minipadding doc_minibordure pointeur" onclick="window.location.href = '<?=$chemin?>pages/nobleme/admins';">
          <div class="align_center doc_minibordure">
            <h5 class="doc_minipadding_bot doc_minibordure_bot">
              <?=$trad['doct_admin']?>
            </h5>
            <span class="doc_minipadding">
              <?=$trad['docd_admin']?>
            </span>
          </div>
        </div>


      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';