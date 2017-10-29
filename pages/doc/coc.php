<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Coc';

// Identification
$page_nom = "Respecte le code de conduite";
$page_url = "pages/doc/coc";

// Lien court
$shorturl = "coc";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Code de conduite" : "Code of conduct";
$page_desc  = "Code de conduite à respecter au sein de la communauté NoBleme";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <?php if($lang == 'FR') { ?>

      <div class="texte2">

        <h1>Code de conduite</h1>

        <h5>Règles à suivre au sein de la communauté NoBleme</h5>

        <p>
          NoBleme est un site cool où les gens sont relax. Il n'y a pas de restriction d'âge, et peu de restrictions de contenu. Il y a juste un code de conduite minimaliste à respecter, afin de tous cohabiter paisiblement.
        </p>
        <br>
        <ul>
          <li>
            Vu qu'il n'y a pas de restriction d'âge, les <span class="gras">images pornographiques</span> ou suggestives <span class="gras">sont interdites</span>.
          </li>
          <li>
            Les <span class="gras">images gores</span> ou à tendance dégueulasse sont <span class="gras">également interdites</span>. NoBleme n'est pas le lieu pour ça.
          </li>
          <li>
            Tout <span class="gras">contenu illégal</span> sera immédiatement <span class="gras">envoyé à la police</span>. Ne jouez pas avec le feu, ce n'est pas le bon site pour en discuter.
          </li>
          <li>
            Si vous pouvez régler une situation tendue en privé plutôt qu'en public, faites l'effort, sinon vous finirez tous les deux bannis.
          </li>
          <li>
            Les trolls, provocateurs gratuits, et emmerdeurs de service pourront être bannis sans sommation s'ils abusent trop.
          </li>
          <li>
            L'écriture SMS et la grammaire sans effort sont à éviter autant que possible. Prenez le temps de bien écrire, ça sera apprécié.
          </li>
        </ul>
        <br>
        On est avant tout sur NoBleme pour passer du bon temps. Si vos actions ou votre langage empêchent d'autres personnes de passer du bon temps, c'est un peu nul, non ? Essayez de rester tolérants, ce n'est pas un grand effort, et tout le monde en bénéficie.<br>
        <br>
        <br>

      </div>

      <?php } else { ?>

      <div class="texte2">

        <h1>Code of conduct</h1>

        <h5>Rules to follow during your stay on NoBleme</h5>

        <p>
          NoBleme is a chill community where people are relaxed. There is no restriction on age or content. However, in order to all coexist peacefully, there is a minimalistic code of conduct that everyone should respect.
        </p>
        <br>
        <ul>
          <li>
            Since there is no age restriction <span class="gras">pornography</span> or suggestive content <span class="gras">is forbidden</span>.
          </li>
          <li>
            All <span class="gras">gore images</span> and other disgusting things are <span class="gras">also forbidden</span>. NoBleme is not the right place for it.
          </li>
          <li>
            Obviously, <span class="gras">illegal content</span> will immediately be <span class="gras">sent to the police</span>. Don't play with fire, there are other websites for that.
          </li>
          <li>
            If you have to argue with someone or must solve a tense situation, do it privately. If done publicly, you will end up banned.
          </li>
          <li>
            Trolls and other kinds of purposeful agitators will be banned without a warning if they try to test boundaries.
          </li>
        </ul>
        <br>
        We are first and foremost on NoBleme to have a good time together. If your actions or your language prevent other people from having a good time, it's a bit silly, isn't it? Try to stay respectful of others and we'll all benefit from it.<br>
        <br>

      </div>

      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';