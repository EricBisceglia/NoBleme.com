<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumIndex';

// Identification
$page_nom = "Forum : [titre du sujet]";
$page_url = "pages/forum/sujet?id=";

// Lien court
$shorturl = "f=";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Forum" : "Forum";
$page_desc  = "Sujet de discussion sur le forum NoBleme";




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

      <div class="texte3">

        <h1 class="align_center">
          <a href="<?=$chemin?>pages/forum/index"><?=$trad['titre']?></a>
          <img class="pointeur" src="<?=$chemin?>img/icones/modifier.png" alt="M">
          <img class="pointeur" src="<?=$chemin?>img/icones/supprimer.png" alt="M">
        </h1>

        <br>
        <br>

        <table style="border: 2px solid #37536B;">
          <tbody>
            <tr style="border-top: 3px solid #37536B;">

              <td rowspan="3" class="align_center valign_top nowrap" style="width: 15em; border-right: 2px solid #37536B; border-bottom: none;padding-left: 10px; padding-right: 10px;">
                <fieldset>

                  <?php if(!rand(0,1)) { ?>
                  <label for="form_dropdown" class="texte_noir" style="font-size:0.9em">50/171 réponses affichées</label>
                  <select id="form_dropdown" name="form_dropdown" class="indiv" style="margin-bottom:10px">
                    <option value="1">Page 1 (0-50)</option>
                    <option value="2">Page 2 (51-100)</option>
                    <option value="3">Page 3 (101-150)</option>
                    <option value="4">Page 4 (150-171)</option>
                    <option value="0">Afficher tous les messages (0-171)</option>
                  </select><br>

                  <?php } else { ?>
                  <label for="form_dropdown" class="texte_noir">11 réponses au sujet</label>
                  <?php } ?>

                  <a class="gras" style="font-size:0.85em;" href="sujet#reponse_<?=rand(0,14)?>">Aller au message le plus récent</a>

                </fieldset>
              </td>

              <td class="valign_middle align_center" style="padding: 10px;">
                <span class="texte_noir gras" style="font-size: 1.35em"><?=['Titre court', 'Titre de message un peu long qui se fait couper mais pas ici donc ça va', 'Discutons politique', 'Je suis ouvert à faire un débat les amis', 'The spoiling adventure version deux point zéro virgule cinq'][rand(0,4)];?></span>
                <img src="<?=$chemin?>img/icones/lang_<?=['fr', 'fr', 'fr', 'fr', 'en'][rand(0,4)];?>_clear.png" alt="FR" class="valign_middle" height="18" style="margin-bottom: 7px; padding-left: 5px;">
              </td>

            </tr>

            <tr>
              <?php $rand = rand(0,3); if(!$rand) { ?>
              <td class="hidden" style="border-top: 2px solid #37536B;">
                &nbsp;
              </td>

              <?php } else if($rand == 1) { ?>
              <td class="align_center texte_noir gras" style="border-top: 2px solid #37536B; padding: 10px;">
                Ce sujet de discussion est un débat, évitez de troller ou d'attaquer les autres pour des désaccords d'opinion
              </td>

              <?php } else if($rand == 2) { ?>
              <td class="align_center texte_negatif gras" style="border-top: 2px solid #37536B; padding: 10px;">
                Ce sujet est marqué comme étant sérieux, merci de ne pas troller et de rester dans le cadre du sujet
              </td>

              <?php } else if($rand == 3) { ?>
              <td class="align_center" style="border-top: 2px solid #37536B; padding: 10px;">
                Ce sujet est un jeu de forum, les messages postés ici n'augmenteront pas votre compte de messages postés
              </td>
              <?php } ?>
            </tr>

            <tr>
              <?php $rand = rand(0,3); if($rand <= 1) { ?>
              <td class="hidden" style="border-top: 2px solid #37536B;">
                &nbsp;
              </td>

              <?php } else if($rand == 2) { ?>
              <td class="align_center texte_negatif moinsgros gras" style="border-top: 2px solid #37536B; padding: 10px;">
                Ce sujet est privé, seul les admins, sysops, et modérateurs du forum peuvent le voir
              </td>

              <?php } else if($rand == 3) { ?>
              <td class="align_center texte_negatif gras" style="border-top: 2px solid #37536B; padding: 10px;">
                Ce sujet a été fermé par un membre de l'équipe administrative, il n'est plus possible d'y poster de réponse
              </td>
              <?php } ?>
            </tr>

          </tbody>
        </table>

        <?php for($i=0;$i<15;$i++) { ?>

        <br id="reponse_<?=$i?>">

        <table style="border: 2px solid #CACACA;">
          <tbody>
            <tr style="border-top: 3px solid #78A1BC;">

              <td class="align_center valign_top nowrap" style="width: 15em; border-right: 2px solid #CACACA; border-bottom: none; padding-bottom: 0px; padding-left: 10px; padding-right: 10px; margin-bottom: 0px;">

                <a class="gras pointeur<?=['', '', '', ' texte_negatif', ' texte_neutre', ' texte_neutre', ''][rand(0,6)];?>"><?=['Bad', 'Planeshift', 'Pseudonyme long', 'Shalena', 'Bad', 'Trucy', 'Bruce'][rand(0,6)];?></a><br>
                <?=rand(1,1000)?> messages<br>

              </td>

              <td rowspan="2" class="valign_top" style="text-align: justify; padding: 10px;">

                <?=['"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"', bbcode('Ok :)'), 'Haha oui'][rand(0,3)];?>

              </td>

            </tr>
            <tr>
              <td rowspan="2" class="align_center valign_bottom nowrap" style="border-right: 2px solid #CACACA; padding-top: 0px; padding-left: 10px; padding-right: 10px; margin-top: 0px;">

                <a class="pointeur" style="font-size:0.75em">Posté le <?=jourfr(rand(2016,2017).'-'.rand(1,11).'-'.rand(1,29))?> à <?=rand(0,24).':'.rand(10,59)?></a><br>

                <?php if(!rand(0,3)) { ?>
                <span class="texte_noir" style="font-size:0.75em">Édité le <?=jourfr(rand(2016,2017).'-'.rand(1,11).'-'.rand(1,29))?> à <?=rand(0,24).':'.rand(10,59)?></span><br>
                <?php } ?>

                <img class="pointeur" src="<?=$chemin?>img/icones/modifier.png" alt="M" height="18" style="margin-top:4px;">
                <img class="pointeur" src="<?=$chemin?>img/icones/supprimer.png" alt="M" height="18" style="margin-top:4px;"><br>

              </td>
            </tr>

            <?php if(!rand(0,3)) { ?>
            <tr>
              <td style="border-top: 2px solid #CACACA; padding-top: 7px; padding-bottom: 7px; padding-left: 15px;"><a class="pointeur">Modifier ce message</a> - <a class="pointeur">Supprimer ce message</a></td>
            </tr>

            <?php } else { ?>
            <tr>
              <td class="hidden">&nbsp;</td>
            </tr>
            <?php } ?>

          </tbody>
        </table>

        <?php } ?>

      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';