<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/forum.inc.php';

// Menus du header
$header_menu      = 'Discuter';
$header_sidemenu  = 'ForumIndex';

// Identification
$page_nom = "Forum";
$page_url = "pages/forum/sujet?id=";

// Lien court
$shorturl = "f=";

// Langages disponibles
$langage_page = array('FR','EN');

// Titre et description
$page_titre = "Forum";
$page_desc  = "Sujet de discussion sur le forum NoBleme";

// CSS & JS
$css  = array('forum');
$js   = array('dynamique', 'forum/sujet');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Identification du sujet et informations communes

// Si on a pas d'id, on dégage
$temp_erreur = ($lang == 'FR') ? "Sujet inexistant" : "Topic does not exist";
if(!isset($_GET['id']))
  erreur($temp_erreur);

// On récupère l'id du sujet
$sujet_id = postdata($_GET['id'], 'int', 0);

// On va chercher si le sujet existe, et on en profite pour récupérer des infos pour le header et sur l'apparence de sujet
$qverifsujet = mysqli_fetch_array(query(" SELECT    forum_sujet.apparence       AS 's_apparence'      ,
                                                    forum_sujet.classification  AS 's_classification' ,
                                                    forum_sujet.categorie       AS 's_categorie'      ,
                                                    forum_sujet.public          AS 's_public'         ,
                                                    forum_sujet.ouvert          AS 's_ouvert'         ,
                                                    forum_sujet.epingle         AS 's_epingle'        ,
                                                    forum_sujet.langage         AS 's_langage'        ,
                                                    forum_sujet.nombre_reponses AS 's_reponses'       ,
                                                    forum_sujet.titre           AS 's_titre'
                                          FROM      forum_sujet
                                          WHERE     forum_sujet.id = '$sujet_id' "));

// S'il existe pas, on dégage
if($qverifsujet['s_titre'] === NULL)
  erreur($temp_erreur);

// On récupère les infos sur le sujet
$sujet_apparence      = $qverifsujet['s_apparence'];
$sujet_classification = $qverifsujet['s_classification'];
$sujet_categorie      = $qverifsujet['s_categorie'];
$sujet_public         = $qverifsujet['s_public'];
$sujet_ouvert         = $qverifsujet['s_ouvert'];
$sujet_epingle        = $qverifsujet['s_epingle'];
$sujet_langage        = changer_casse($qverifsujet['s_langage'], 'min');
$sujet_langage_caps   = $qverifsujet['s_langage'];
$sujet_reponses       = $qverifsujet['s_reponses'];
$sujet_titre          = predata($qverifsujet['s_titre']);
$sujet_titre_raw      = $qverifsujet['s_titre'];

// On a besoin de calculer le nombre de lignes que doit faire la case à gauche du bloc de titre
$rowspan_titre = 1;
if($sujet_apparence == 'Anonyme')
  $rowspan_titre++;
if($sujet_classification != 'Standard')
  $rowspan_titre++;
if(!$sujet_public)
  $rowspan_titre++;
if(!$sujet_ouvert)
  $rowspan_titre++;
if($sujet_epingle)
  $rowspan_titre++;

// On met à jour les infos du header
$temp_lang  = ($lang == 'FR') ? 'Forum : Lit un sujet privé' : 'Forum : Reading a private topic';
$page_nom   = ($qverifsujet['s_public']) ? 'Forum : '.predata(tronquer_chaine($qverifsujet['s_titre'], 35, '...')) : $temp_lang;
$page_url   = ($qverifsujet['s_public']) ? 'pages/forum/sujet?id='.$sujet_id : 'pages/forum/index';
$shorturl  .= $sujet_id;
$page_titre = predata($qverifsujet['s_titre']);
$page_desc  = "Forum NoBleme : ".$qverifsujet['s_titre'];

// Ça nous serait également utile de savoir si on a des permissions sur le forum ou non
$moderateur_forum = getmod('forum');
$administrateur_forum = getadmin();




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Poster une réponse au sujet

if(isset($_POST['forum_ecrire_reponse']))
{
  // Assainissement du postdata
  $add_reponse  = postdata_vide('forum_ecrire_reponse', 'string', '');

  // On poste le message
  $add_userid   = postdata($_SESSION['user'], 'int');
  $timestamp    = time();
  query(" INSERT INTO forum_message
          SET         forum_message.FKforum_sujet           = '$sujet_id'     ,
                      forum_message.FKforum_message_parent  = 0               ,
                      forum_message.FKmembres               = '$add_userid'   ,
                      forum_message.timestamp_creation      = '$timestamp'    ,
                      forum_message.timestamp_modification  = 0               ,
                      forum_message.message_supprime        = 0               ,
                      forum_message.contenu                 = '$add_reponse'  ");

  // Si nécessaire, on augmente le post count de l'user et du sujet
  $message_id = mysqli_insert_id($db);
  forum_recompter_messages_membre($add_userid);
  forum_recompter_messages_sujet($sujet_id);

  // On met à jour les infos du sujet
  query(" UPDATE  forum_sujet
          SET     forum_sujet.FKmembres_dernier_message = '$add_userid' ,
                  forum_sujet.timestamp_dernier_message = '$timestamp'
          WHERE   forum_sujet.id                        = '$sujet_id' ");

  // Activité récente
  $temp_lang  = ($sujet_langage_caps == 'FR') ? 'Anonyme' : 'Anonymous';
  $add_pseudo = ($sujet_apparence == 'Anonyme') ? $temp_lang : postdata(getpseudo(), 'string');
  $add_modlog = ($sujet_public) ? 0 : 1;
  $add_titre  = postdata($sujet_titre_raw);
  query(" INSERT INTO activite
          SET         activite.timestamp      = '$timestamp'        ,
                      activite.log_moderation = '$add_modlog'       ,
                      activite.pseudonyme     = '$add_pseudo'       ,
                      activite.action_type    = 'forum_new_message' ,
                      activite.action_id      = '$message_id'       ,
                      activite.action_titre   = '$add_titre'        ,
                      activite.parent         = '$sujet_id'         ");

  // Redirection vers le nouveau message
  exit(header("Location: ".$chemin."pages/forum/sujet?id=".$sujet_id."#".$message_id));
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fil de discussion / Fil anonyme

if($sujet_apparence == 'Fil' || $sujet_apparence == 'Anonyme')
{
  // On va chercher les réponses au sujet
  $qreponses = query("  SELECT    forum_message.id                      AS 'r_id'       ,
                                  membres.id                            AS 'm_id'       ,
                                  membres.pseudonyme                    AS 'm_pseudo'   ,
                                  membres.admin                         AS 'm_admin'    ,
                                  membres.sysop                         AS 'm_sysop'    ,
                                  membres.moderateur                    AS 'm_mod'      ,
                                  membres.forum_messages                AS 'm_messages' ,
                                  forum_message.timestamp_creation      AS 'r_creation' ,
                                  forum_message.timestamp_modification  AS 'r_edit'     ,
                                  forum_message.message_supprime        AS 'r_supprime' ,
                                  forum_message.contenu                 AS 'r_contenu'
                        FROM      forum_message
                        LEFT JOIN membres ON forum_message.FKmembres  = membres.id
                        WHERE     forum_message.FKforum_sujet         = '$sujet_id'
                        ORDER BY  forum_message.timestamp_creation    ASC ,
                                  forum_message.id                    ASC ");

  // On les prépare pour l'affichage
  for($nreponses = 0; $dreponses = mysqli_fetch_array($qreponses); $nreponses++)
  {
    $reponse_id[$nreponses]         = $dreponses['r_id'];
    $reponse_rowspan[$nreponses]    = (loggedin() && $dreponses['m_id'] == $_SESSION['user']) ? 2 : 1;
    $reponse_auteur_id[$nreponses]  = $dreponses['m_id'];
    $reponse_auteur[$nreponses]     = predata($dreponses['m_pseudo']);
    $temp_css                       = ($dreponses['m_mod']) ? ' texte_positif' : '';
    $temp_css                       = ($dreponses['m_sysop']) ? ' texte_neutre' : $temp_css;
    $reponse_auteur_css[$nreponses] = ($dreponses['m_admin']) ? ' texte_negatif' : $temp_css;
    $reponse_auteur_nb[$nreponses]  = ($dreponses['m_messages'] == 1) ? $dreponses['m_messages'].' message' : $dreponses['m_messages'].' messages';
    $temp_lang                      = ($lang == 'FR') ? ' à ' : ' at ';
    $reponse_creation[$nreponses]   = predata(jourfr(date('Y-m-d', $dreponses['r_creation']), $lang).$temp_lang.date('H:i', $dreponses['r_creation']));
    $reponse_edit[$nreponses]       = ($dreponses['r_edit']) ? predata(jourfr(date('Y-m-d', $dreponses['r_edit']), $lang).$temp_lang.date('H:i', $dreponses['r_edit'])) : 0;
    $reponse_supprime[$nreponses]   = $dreponses['r_supprime'];
    $reponse_contenu[$nreponses]    = bbcode(predata($dreponses['r_contenu'], 1));
    $reponse_peut_edit[$nreponses]  = ((time() - $dreponses['r_creation']) < 2592000) ? 1 : 0;
  }

  // On vérifie si on a une citation de remplie
  if(isset($_GET['quote']))
  {
    // Si oui, on assainit le postdata
    $quote_id = postdata($_GET['quote'], 'int', 0);

    // On va chercher le message correspondant
    $qquote = mysqli_fetch_array(query("  SELECT    membres.pseudonyme    AS 'm_pseudo' ,
                                                    forum_message.contenu AS 'f_contenu'
                                          FROM      forum_message
                                          LEFT JOIN membres ON forum_message.FKmembres = membres.id
                                          WHERE     forum_message.id            = '$quote_id'
                                          AND       forum_message.FKforum_sujet = '$sujet_id' "));

    // Si il existe, on prépare la citation
    if($qquote['f_contenu'] !== NULL)
    {
      $reponse_quote_raw  = "[quote=".$qquote['m_pseudo']."]".$qquote['f_contenu']."[/quote]".PHP_EOL;
      $reponse_quote      = bbcode("[quote=".predata($qquote['m_pseudo'])."]".predata($qquote['f_contenu'], 1)."[/quote]");
      $reponse_hidden     = "";
      $onload             = "var textarea = document.getElementById('forum_ecrire_reponse'); textarea.focus(); var temp = textarea.value; textarea.value = ''; textarea.value = temp;";
    }
  }

  // Sinon, on cache la section
  if(!isset($reponse_quote))
  {
    $reponse_quote_raw  = "";
    $reponse_quote      = "&nbsp;";
    $reponse_hidden     = ' class="hidden"';
  }
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si l'apparence du sujet est inconnue, on dégage

else
{
  $temp_erreur = ($lang == 'FR') ? "Type de sujet inconnu" : "Unknown topic type";
  erreur($temp_erreur);
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']        = "Forum NoBleme";

  // Bloc de titre
  $trad['reponses']     = ($sujet_reponses == 1) ? "réponse au sujet" : "réponses au sujet";
  $trad['gotolast']     = "Aller au message le plus récent";
  $trad['warn_epingle'] = "Ce sujet est épinglé en haut de la liste des sujets, il y apparaitra toujours parmi les premiers sujets";
  $trad['warn_ferme']   = "Ce sujet a été fermé par un membre de l'équipe administrative, il n'est plus possible d'y poster de réponse";
  $trad['warn_prive']   = "Ce sujet est privé, seul les administrateurs, sysops, et modérateurs du forum peuvent le voir";
  $trad['warn_anonyme'] = "Ce sujet est anonyme, les pseudonymes sont cachés et les messages n'augmentent pas votre compte de messages";
  $trad['warn_serieux'] = "Ce sujet est marqué comme étant sérieux, merci de rester dans le cadre du sujet";
  $trad['warn_debat']   = "Ce sujet est un débat, les attaques personnelles et les messages hors sujets seront supprimés sans avertissement";
  $trad['warn_jeu']     = "Ce sujet est un jeu de forum, les messages postés ici n'augmenteront pas votre compte de messages postés";

  // Messages
  $trad['mess_poste']   = "Posté le";
  $trad['mess_edite']   = "Édité le";
  $trad['mess_anon']    = "Anonyme";
  $trad['mess_edit']    = "Modifier mon message";
  $trad['mess_supp']    = "Supprimer mon message";
  $trad['mess_nocando'] = "Vous ne pouvez pas modifier ou supprimer un message vieux de plus d'un mois";

  // Répondre
  $trad['reply_label']  = <<<EOD
Écrire une réponse au sujet de discussion (vous pouvez utiliser des <a class="gras" href="{$chemin}pages/doc/emotes">émoticônes</a> et des <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['reply_prev']   = "Prévisualisation du message";
  $trad['reply_go']     = "ENVOYER MA RÉPONSE";
  $trad['reply_guest']  = <<<EOD
VOUS DEVEZ ÊTRE CONNECTÉ À VOTRE COMPTE POUR POSTER SUR LE FORUM NOBLEME<br>
<a class="texte_nobleme_clair" href="{$chemin}pages/user/login">CLIQUEZ ICI</a> POUR VOUS CONNECTER À VOTRE COMPTE, OU <a class="texte_nobleme_clair" href="{$chemin}pages/user/login">CLIQUEZ ICI</a> POUR VOUS INSCRIRE SUR NOBLEME
EOD;
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']        = "NoBleme forum";

  // Bloc de titre
  $trad['reponses']     = ($sujet_reponses == 1) ? "reply to this topic" : "replies to this topic";
  $trad['gotolast']     = "Jump to the latest reply";
  $trad['warn_epingle'] = "This topic is pinned on top of the topic list, it will always appear as one of the first topics";
  $trad['warn_ferme']   = "This topic has been closed by a member of the administrative team, you can not post any replies to it";
  $trad['warn_prive']   = "This topic is private, only administrators, sysops, and forum moderators can see it";
  $trad['warn_anonyme'] = "This topic is anonymous, nicknames are hidden and messages posted in it do not increase your post count";
  $trad['warn_serieux'] = "Ce sujet est marqué comme étant sérieux, merci de rester dans le cadre du sujet";
  $trad['warn_debat']   = "This topic is a debate, personal attacks and off topic messages will be deleted without warning";
  $trad['warn_jeu']     = "This topic is a forum game, messages posted here will not increase your post count";

  // Messages
  $trad['mess_poste']   = "Posted";
  $trad['mess_edite']   = "Édited";
  $trad['mess_anon']    = "Anonymous";
  $trad['mess_edit']    = "Edit my post";
  $trad['mess_supp']    = "Delete my post";
  $trad['mess_nocando'] = "You can not edit or delete your messages if they are older than a month";

  // Répondre
  $trad['reply_label']  = <<<EOD
Write a reply to the topic (you can format your message with <a class="gras" href="{$chemin}pages/doc/emotes">emotes</a> and <a class="gras" href="{$chemin}pages/doc/bbcodes">BBCodes</a>)
EOD;
  $trad['reply_go']     = "POST MY REPLY";
  $trad['reply_prev']   = "Formatted message preview";
  $trad['reply_guest']  = <<<EOD
YOU MUST BE LOGGED INTO YOUR ACCOUNT BEFORE YOU CAN POST MESSAGES ON NOBLEME'S FORUM<br>
<a class="texte_nobleme_clair" href="{$chemin}pages/user/login">CLICK HERE</a> TO LOG INTO YOUR ACCOUNT, OR <a class="texte_nobleme_clair" href="{$chemin}pages/user/login">CLICK HERE</a> TO REGISTER AN ACCOUNT ON NOBLEME
EOD;
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte3">

        <h1 class="align_center">
          <a href="<?=$chemin?>pages/forum/index"><?=$trad['titre']?></a>
        </h1>

        <br>
        <br>

        <table class="forum_sujet_entete">
          <tbody>
            <tr class="forum_sujet_entete">

              <td rowspan="<?=$rowspan_titre?>" class="align_center valign_top nowrap forum_sujet_entete_gauche">
                <fieldset>

                  <label class="texte_noir"><?=$sujet_reponses?> <?=$trad['reponses']?></label>

                  <a class="gras forum_sujet_entete_recent" href="#<?=$reponse_id[$nreponses-1]?>"><?=$trad['gotolast']?></a><br>

                  <?php if($moderateur_forum) { ?>
                  <a href="<?=$chemin?>pages/forum/sujet_modifier?id=<?=$sujet_id?>">
                    <img class="pointeur forum_sujet_entete_actions" src="<?=$chemin?>img/icones/modifier.png" alt="M" height="25">
                  </a>
                  <a href="<?=$chemin?>pages/forum/sujet_supprimer?id=<?=$sujet_id?>">
                    <img class="pointeur forum_sujet_entete_actions" src="<?=$chemin?>img/icones/supprimer.png" alt="X" height="25">
                  </a>
                  <?php } ?>

                </fieldset>
              </td>

              <td class="valign_middle align_center forum_sujet_entete_titre">
                <span class="texte_noir gras forum_sujet_entete_titre"><?=$sujet_titre?></span>
                <img src="<?=$chemin?>img/icones/lang_<?=$sujet_langage?>_clear.png" alt="<?=$sujet_langage_caps?>" class="valign_middle forum_sujet_entete_lang" height="18">
              </td>

            </tr>

            <?php if($sujet_epingle) { ?>
            <tr>
              <td class="align_center texte_positif gras forum_sujet_entete_description">
                <?=$trad['warn_epingle']?>
              </td>
            </tr>
            <?php } if(!$sujet_ouvert) { ?>
            <tr>
              <td class="align_center texte_negatif gras forum_sujet_entete_description">
                <?=$trad['warn_ferme']?>
              </td>
            </tr>
            <?php } if(!$sujet_public) { ?>
            <tr>
              <td class="align_center texte_neutre gras forum_sujet_entete_description">
                <?=$trad['warn_prive']?>
              </td>
            </tr>
            <?php } if($sujet_apparence == 'Anonyme') { ?>
            <tr>
              <td class="align_center texte_noir forum_sujet_entete_description">
                <?=$trad['warn_anonyme']?>
              </td>
            </tr>
            <?php } if($sujet_classification == 'Sérieux') { ?>
            <tr>
              <td class="align_center texte_noir forum_sujet_entete_description">
                <?=$trad['warn_serieux']?>
              </td>
            </tr>
            <?php } if($sujet_classification == 'Débat') { ?>
            <tr>
              <td class="align_center texte_noir forum_sujet_entete_description">
                <?=$trad['warn_debat']?>
              </td>
            </tr>
            <?php } if($sujet_classification == 'Jeu') { ?>
            <tr>
              <td class="align_center forum_sujet_entete_description">
                <?=$trad['warn_jeu']?>
              </td>
            </tr>
            <?php } ?>

          </tbody>
        </table>




        <?php if($sujet_apparence == 'Fil' || $sujet_apparence == 'Anonyme') { ?>

        <?php for($i=0;$i<$nreponses;$i++) { ?>

        <br id="<?=$reponse_id[$i]?>">

        <table class="forum_sujet_message">
          <tbody>
            <tr class="forum_sujet_message">

              <td class="align_center valign_top nowrap forum_sujet_message_gauche">

                <?php if($sujet_apparence == 'Anonyme' && !$administrateur_forum) { ?>
                <?=$trad['mess_anon']?>
                <?php } else if($sujet_apparence == 'Anonyme' && $administrateur_forum) { ?>
                Anon (<a class="gras<?=$reponse_auteur_css[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$reponse_auteur_id[$i]?>"><?=$reponse_auteur[$i]?></a>)
                <?php } else { ?>
                <a class="gras<?=$reponse_auteur_css[$i]?>" href="<?=$chemin?>pages/user/user?id=<?=$reponse_auteur_id[$i]?>"><?=$reponse_auteur[$i]?></a><br>
                <?=$reponse_auteur_nb[$i]?><br>
                <?php } ?>

              </td>

              <td rowspan="2" class="valign_top forum_sujet_message_contenu">
                <?=$reponse_contenu[$i]?>
              </td>

            </tr>
            <tr>
              <td rowspan="<?=$reponse_rowspan[$i]?>" class="align_center valign_bottom nowrap forum_sujet_message_gauche">

                <a class="forum_sujet_message_info" href="<?=$chemin?>pages/forum/sujet?id=<?=$sujet_id?>#<?=$reponse_id[$i]?>"><?=$trad['mess_poste']?> <?=$reponse_creation[$i]?></a><br>

                <?php if($reponse_edit[$i]) { ?>
                <span class="texte_noir forum_sujet_message_info"><?=$trad['mess_edite']?> <?=$reponse_edit[$i]?></span><br>
                <?php } ?>

                <?php if(loggedin()) { ?>
                <a href="<?=$chemin?>pages/forum/sujet?id=<?=$sujet_id?>&amp;quote=<?=$reponse_id[$i]?>#sujet_repondre">
                  <img class="pointeur forum_sujet_message_actions" src="<?=$chemin?>img/icones/quote.png" alt="Q" height="18" title="Citer le message">
                </a>
                <?php } ?>
                <?php if($moderateur_forum) { ?>
                <img class="pointeur forum_sujet_message_actions" src="<?=$chemin?>img/icones/modifier.png" alt="M" height="18">
                <?php if($i) { ?>
                <img class="pointeur forum_sujet_message_actions" src="<?=$chemin?>img/icones/supprimer.png" alt="X" height="18">
                <?php } ?>
                <?php } ?>

              </td>
            </tr>

            <?php if(loggedin() && $reponse_auteur_id[$i] == $_SESSION['user']) { ?>
            <?php if($reponse_peut_edit[$i]) { ?>
            <tr>
              <td class="forum_sujet_message_actions">
                <a class="pointeur"><?=$trad['mess_edit']?></a> - <a class="pointeur"><?=$trad['mess_supp']?></a>
              </td>
            </tr>
            <?php } else { ?>
            <tr>
              <td class="forum_sujet_message_actions italique">
                <?=$trad['mess_nocando']?>
              </td>
            </tr>
            <?php } ?>
            <?php } ?>

          </tbody>
        </table>

        <?php } ?>

        <br id="sujet_repondre">

        <table class="forum_sujet_message">
          <tbody>
            <tr class="forum_sujet_message">

              <?php if(loggedin()) { ?>

              <td class="forum_sujet_message_contenu">

                <form method="POST" id="forum_poster_reponse">
                  <fieldset>

                    <label for="forum_ecrire_reponse" id="forum_ecrire_reponse_label"><?=$trad['reply_label']?></label>
                    <textarea id="forum_ecrire_reponse" name="forum_ecrire_reponse" class="indiv forum_ecrire_reponse_composition" onkeyup="forum_ecrire_reponse_previsualisation('<?=$chemin?>');"><?=$reponse_quote_raw?></textarea><br>
                    <br>

                    <button type="button" onclick="forum_ecrire_reponse_envoyer();"><?=$trad['reply_go']?></button>

                    <div id="forum_ecrire_reponse_container"<?=$reponse_hidden?>>
                      <br>
                      <label><?=$trad['reply_prev']?></label>
                      <div class="vscrollbar forum_ecrire_reponse_previsualisation" id="forum_ecrire_reponse_previsualisation">
                        <?=$reponse_quote?>
                      </div>
                      <br>
                    </div>

                  </fieldset>
                </form>

              </td>

              <?php } else { ?>

              <td class="nobleme_fonce texte_blanc align_center gras">
                <?=$trad['reply_guest']?>
              </td>

              <?php } ?>

            </tr>
          </tbody>
        </table>





        <?php } ?>


      </div>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';