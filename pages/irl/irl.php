<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'IRL';

// Identification
$page_nom = "Observe l'IRL du ";
$page_url = "pages/irl/irl?id=";

// Lien court
$shorturl = "irl=";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "IRL du " : "";
$page_desc  = "Organisation de rencontres en personne entre les NoBlemeux";

// CSS & JS
$css  = array('meetups');
$js   = array('toggle', 'dynamique', 'irl/editer_irl');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Assainissement du postdata

// On récupère l'ID de l'irl, ou on dégage
if(!isset($_GET['id']))
  exit(header("Location: ".$chemin."pages/irl/index"));
else
  $irl_id = postdata($_GET['id'], 'int', 0);

// On va vérifier que l'irl existe
$qcheckirl = mysqli_fetch_array(query(" SELECT irl.id, irl.date FROM irl WHERE irl.id = '$irl_id' "));
if($qcheckirl == NULL)
  exit(header("Location: ".$chemin."pages/irl/index"));

// On en profite pour fixer les infos internes de la page
$page_nom   .= jourfr($qcheckirl['date']);
$page_url   .= $irl_id;
$shorturl   .= $irl_id;
$page_titre .= ($lang == 'FR') ? jourfr($qcheckirl['date'], 'FR') : jourfr($qcheckirl['date'], 'EN').' meetup';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajout d'un participant à l'IRL

if(isset($_POST['irl_add_pseudo']) && $_POST['irl_add_pseudo'] && getmod('irl'))
{
  // Nettoyage du postdata
  $irl_add_pseudo     = postdata_vide('irl_add_pseudo', 'string', '');
  $irl_add_details_fr = postdata_vide('irl_add_details_fr', 'string', '');
  $irl_add_details_en = postdata_vide('irl_add_details_en', 'string', '');
  $irl_add_confirme   = ($_POST['irl_add_confirme'] == 'true') ? 1 : 0;

  // On va chercher si le membre existe, si oui on récupère son ID et on insère pas de pseudo
  $qcheckmembre = mysqli_fetch_array(query("  SELECT  membres.id
                                              FROM    membres
                                              WHERE   membres.pseudonyme LIKE BINARY '$irl_add_pseudo' "));
  $irl_add_FKmembres  = ($qcheckmembre['id']) ? $qcheckmembre['id'] : 0;
  $irl_add_pseudo     = ($qcheckmembre['id']) ? '' : $irl_add_pseudo;

  // Ajout de l'entrée
  query(" INSERT INTO irl_participants
          SET         FKirl       = '$irl_id'             ,
                      FKmembres   = '$irl_add_FKmembres'  ,
                      pseudonyme  = '$irl_add_pseudo'     ,
                      confirme    = '$irl_add_confirme'   ,
                      details_fr  = '$irl_add_details_fr' ,
                      details_en  = '$irl_add_details_en' ");

  // Activité récente
  $pseudonyme       = postdata_vide('irl_add_pseudo', 'string', '');
  $action_titre     = postdata(jourfr($qcheckirl['date']), 'string', '');
  $action_titre_en  = postdata(jourfr($qcheckirl['date'], 'EN'), 'string', '');
  activite_nouveau('irl_add_participant', 0, 0, $pseudonyme, $irl_id, $action_titre);

  // Log de modération
  $sysop = postdata(getpseudo(), 'string');
  activite_nouveau('irl_add_participant', 1, 0, $pseudonyme, $irl_id, $action_titre, $sysop);

  // Bot IRC
  ircbot($chemin, $_POST["irl_add_pseudo"]." a rejoint l'IRL du ".$action_titre.": ".$GLOBALS['url_site']."pages/irl/irl?id=".$irl_id, "#NoBleme");
  ircbot($chemin, $_POST["irl_add_pseudo"]." will attend the ".$action_titre_en." real life meetup: ".$GLOBALS['url_site']."pages/irl/irl?id=".$irl_id, "#english");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Modification d'un participant à l'IRL

if(isset($_POST['irl_edit_id']) && $_POST['irl_edit_id'] && getmod('irl'))
{
  // Nettoyage du postdata
  $irl_edit_id          = postdata_vide('irl_edit_id', 'int', 0);
  $irl_edit_pseudo      = postdata_vide('irl_edit_pseudo', 'string', '');
  $irl_edit_details_fr  = postdata_vide('irl_edit_details_fr', 'string', '');
  $irl_edit_details_en  = postdata_vide('irl_edit_details_en', 'string', '');
  $irl_edit_confirme    = ($_POST['irl_edit_confirme'] == 'true') ? 1 : 0;

  // On va chercher des infos sur le participant
  $qcheckirlp = mysqli_fetch_array(query("  SELECT    irl_participants.id         AS 'irlp_id'          ,
                                                      irl_participants.pseudonyme AS 'irlp_pseudo'      ,
                                                      membres.pseudonyme          AS 'u_pseudo'         ,
                                                      irl.date                    AS 'irl_date'         ,
                                                      irl_participants.details_fr AS 'irlp_details_fr'  ,
                                                      irl_participants.details_en AS 'irlp_details_en'  ,
                                                      irl_participants.confirme   AS 'irlp_confirme'
                                            FROM      irl_participants
                                            LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                                            LEFT JOIN irl     ON irl_participants.FKirl     = irl.id
                                            WHERE     irl_participants.id = '$irl_edit_id' "));

  // S'il existe pas, on s'arrête là
  if(!$qcheckirlp['irlp_id'])
    exit('Impossible de supprimer un participant inexistant');

  // On va chercher si le membre existe, si oui on récupère son ID et on insère pas de pseudo
  $qcheckmembre = mysqli_fetch_array(query("  SELECT  membres.id
                                              FROM    membres
                                              WHERE   membres.pseudonyme LIKE BINARY '$irl_edit_pseudo' "));
  $edit_irl_FKmembres  = ($qcheckmembre['id']) ? $qcheckmembre['id'] : 0;
  $edit_irl_pseudo     = ($qcheckmembre['id']) ? '' : $irl_edit_pseudo;

  // On va chercher les infos sur le participant pour le diff
  $edit_irl_date        = postdata(jourfr($qcheckirlp['irl_date']));
  $edit_meetups_details_fr  = postdata($qcheckirlp['irlp_details_fr']);
  $edit_meetups_details_en  = postdata($qcheckirlp['irlp_details_en']);
  $edit_irl_confirme    = ($qcheckirlp['irlp_confirme']) ? 'Oui' : 'Non';

  // Modification de l'entrée
  query(" UPDATE  irl_participants
          SET     FKmembres   = '$edit_irl_FKmembres'   ,
                  pseudonyme  = '$edit_irl_pseudo'      ,
                  confirme    = '$irl_edit_confirme'    ,
                  details_fr  = '$irl_edit_details_fr'  ,
                  details_en  = '$irl_edit_details_en'
          WHERE   id          = '$irl_edit_id'          ");

  // Log de modération
  $pseudonyme   = postdata_vide('irl_edit_pseudo', 'string', '');
  $sysop        = postdata(getpseudo(), 'string');
  $activite_id  = activite_nouveau('irl_edit_participant', 1, 0, $pseudonyme, $irl_id, $edit_irl_date, $sysop);

  // Diff
  $irl_edit_confirme  = ($irl_edit_confirme) ? 'Oui' : 'Non';
  activite_diff($activite_id, 'Détails (français)'  , $edit_meetups_details_fr  , $irl_edit_details_fr  , 1);
  activite_diff($activite_id, 'Détails (anglais)'   , $edit_meetups_details_en  , $irl_edit_details_en  , 1);
  activite_diff($activite_id, 'Présence confirmée'  , $edit_irl_confirme    , $irl_edit_confirme    , 1);
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'un participant à l'IRL

if(isset($_POST['irl_supprimer_participant']) && $_POST['irl_supprimer_participant'] && getmod('irl'))
{
  // Nettoyage du postdata
  $irl_supprimer_participant  = postdata_vide('irl_supprimer_participant', 'int', 0);

  // On va chercher des infos sur le participant
  $qcheckirlp = mysqli_fetch_array(query("  SELECT    irl_participants.id         AS 'irlp_id'          ,
                                                      irl_participants.pseudonyme AS 'irlp_pseudo'      ,
                                                      membres.pseudonyme          AS 'u_pseudo'         ,
                                                      irl.date                    AS 'irl_date'         ,
                                                      irl_participants.details_fr AS 'irlp_details_fr'  ,
                                                      irl_participants.details_en AS 'irlp_details_en'
                                            FROM      irl_participants
                                            LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                                            LEFT JOIN irl     ON irl_participants.FKirl     = irl.id
                                            WHERE     irl_participants.id = '$irl_supprimer_participant' "));

  // S'il existe pas, on s'arrête là
  if(!$qcheckirlp['irlp_id'])
    exit('Impossible de supprimer un participant inexistant');

  // On va chercher les infos sur le participant pour le diff
  $del_irl_pseudo   = ($qcheckirlp['irlp_pseudo']) ? $qcheckirlp['irlp_pseudo'] : $qcheckirlp['u_pseudo'];
  $del_irl_date     = jourfr($qcheckirlp['irl_date']);
  $del_irl_date_en  = jourfr($qcheckirlp['irl_date'], 'EN');
  $del_details_fr   = postdata($qcheckirlp['irlp_details_fr']);
  $del_details_en   = postdata($qcheckirlp['irlp_details_en']);

  // Suppression de l'entrée
  query(" DELETE FROM irl_participants
          WHERE       id = '$irl_supprimer_participant' ");

  // Activité récente
  $pseudonyme   = postdata($del_irl_pseudo, 'string');
  $action_titre = postdata($del_irl_date, 'string');
  activite_nouveau('irl_del_participant', 0, 0, $pseudonyme, $irl_id, $action_titre);

  // Log de modération
  $sysop        = postdata(getpseudo(), 'string');
  $activite_id  = activite_nouveau('irl_del_participant', 1, 0, $pseudonyme, $irl_id, $action_titre, $sysop);

  // Diff
  activite_diff($activite_id, 'Détails (français)', $del_details_fr);
  activite_diff($activite_id, 'Détails (anglais)' , $del_details_en);

  // Bot IRC
  ircbot($chemin, $del_irl_pseudo." a quitté l'IRL du ".$del_irl_date, "#NoBleme");
  ircbot($chemin, $del_irl_pseudo." will no longer attend the ".$del_irl_date_en." meetup", "#english");
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression de l'IRL

if(isset($_POST['irl_supprimer']) && getmod('irl'))
{
  // On va chercher les infos liées à l'IRL
  $qdelirl = mysqli_fetch_array(query(" SELECT  irl.date        ,
                                                irl.lieu        ,
                                                irl.raison_fr   ,
                                                irl.raison_en   ,
                                                irl.details_fr  ,
                                                irl.details_en
                                        FROM    irl
                                        WHERE   irl.id = '$irl_id' "));

  // On prépare ces infos pour le diff
  $irl_del_date_raw   = jourfr($qdelirl['date']);
  $irl_del_date       = postdata(jourfr($qdelirl['date']), 'string');
  $irl_del_lieu       = postdata($qdelirl['lieu'], 'string');
  $irl_del_raison_fr  = postdata($qdelirl['raison_fr'], 'string');
  $irl_del_raison_en  = postdata($qdelirl['raison_en'], 'string');
  $irl_del_details_fr = postdata($qdelirl['details_fr'], 'string');
  $irl_del_details_en = postdata($qdelirl['details_en'], 'string');

  // On va chercher les infos liées aux participants de l'IRL
  $qdelirlp = query(" SELECT    irl_participants.pseudonyme AS 'irlp_pseudo'      ,
                                membres.pseudonyme          AS 'u_pseudo'         ,
                                irl_participants.details_fr AS 'irlp_details_fr'  ,
                                irl_participants.details_en AS 'irlp_details_en'
                      FROM      irl_participants
                      LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                      WHERE     irl_participants.FKirl = '$irl_id' ");

  // On prépare ces infos pour le diff
  for($ndelirlp = 0; $ddelirlp = mysqli_fetch_array($qdelirlp); $ndelirlp++)
  {
    $delirlp_pseudo[$ndelirlp]    = ($ddelirlp['u_pseudo']) ? postdata($ddelirlp['u_pseudo'], 'string') : postdata($ddelirlp['irlp_pseudo'], 'string');
    $delirlp_deets_fr[$ndelirlp]  = postdata($ddelirlp['irlp_details_fr'], 'string');
    $delirlp_deets_en[$ndelirlp]  = postdata($ddelirlp['irlp_details_en'], 'string');
  }

  // On supprime l'IRL
  query(" DELETE FROM irl
          WHERE       irl.id = '$irl_id' ");

  // On supprime tous les participants à l'IRL
  query(" DELETE FROM irl_participants
          WHERE       irl_participants.FKirl = '$irl_id' ");

  // On supprime toutes les entrées liées à l'IRL dans l'activité récente
  activite_supprimer('irl_', 0, 0, NULL, $irl_id, 1);

  // On supprime les pageviews
  $page_url = predata($page_url);
  query(" DELETE FROM pageviews
          WHERE       url_page LIKE '$page_url' ");

  // Log de modération
  $sysop        = postdata(getpseudo(), 'string');
  $activite_id  = activite_nouveau('irl_delete', 1, 0, $sysop, 0, $irl_del_date);

  // Diff
  activite_diff($activite_id, 'Lieu'          , $irl_del_lieu);
  activite_diff($activite_id, 'Raison (fr)'   , $irl_del_raison_fr);
  activite_diff($activite_id, 'Raison (en)'   , $irl_del_raison_en);
  activite_diff($activite_id, 'Détails (fr)'  , $irl_del_details_fr);
  activite_diff($activite_id, 'Détails (en)'  , $irl_del_details_en);

  // Diff des participants
  for($i=0;$i<$ndelirlp;$i++)
  {
    $temp_pseudo    = $delirlp_pseudo[$i];
    $temp_deets_fr  = $delirlp_deets_fr[$i];
    $temp_deets_en  = $delirlp_deets_en[$i];
    activite_diff($activite_id, 'Participant'               , $temp_pseudo);
    if($temp_deets_fr)
      activite_diff($activite_id, 'Détails participant (fr)'  , $temp_deets_fr);
    if($temp_deets_en)
      activite_diff($activite_id, 'Détails participant (en)'  , $temp_deets_en);
  }

  // Bot IRC
  ircbot($chemin, getpseudo()." a supprimé l'IRL du ".$irl_del_date_raw, "#sysop");

  // Message de réussite
  echo '<span class="texte_blanc negatif">L\'IRL a bien été supprimée</span>';
}






/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Informations générales sur l'IRL

// On récupère les infos de l'irl
$qirl = mysqli_fetch_array(query("  SELECT  irl.date        ,
                                            irl.details_fr  ,
                                            irl.details_en
                                    FROM    irl
                                    WHERE   irl.id = '$irl_id' "));

// Et on les prépare pour l'affichage
$irl_mod      = getmod('irl');
$irl_futur    = (strtotime($qcheckirl['date']) >= strtotime(date('Y-m-d'))) ? 1 : 0;
$irl_colspan  = ($irl_futur) ? 5 : 4;
$irl_dans     = changer_casse(dans(strtotime($qcheckirl['date']), $lang), 'min');
$irl_date     = datefr($qcheckirl['date'], $lang);
$meetups_details  = ($lang == 'FR') ? bbcode(predata($qirl['details_fr'], 1)) : bbcode(predata($qirl['details_en'], 1));




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Liste des participants à l'IRL

// On va chercher la liste des participants
$details_lang   = ($lang == 'FR') ? 'details_fr' : 'details_en';
$qparticipants  = query(" SELECT    irl_participants.id             AS 'irlp_id'          ,
                                    irl_participants.pseudonyme     AS 'irlp_pseudo'      ,
                                    membres.id                      AS 'u_id'             ,
                                    membres.pseudonyme              AS 'u_pseudo'         ,
                                    irl_participants.confirme       AS 'irlp_confirme'    ,
                                    irl_participants.$details_lang  AS 'irlp_details'     ,
                                    irl_participants.details_fr     AS 'irlp_details_fr'  ,
                                    irl_participants.details_en     AS 'irlp_details_en'
                          FROM      irl_participants
                          LEFT JOIN membres ON irl_participants.FKmembres = membres.id
                          WHERE     irl_participants.FKirl = '$irl_id'
                          ORDER BY  irl_participants.confirme                                                       DESC  ,
                                    IF(membres.pseudonyme IS NULL, irl_participants.pseudonyme, membres.pseudonyme) ASC   ");

// Et on les prépare pour l'affichage
for($nparticipants = 0; $dparticipants = mysqli_fetch_array($qparticipants); $nparticipants++)
{
  $irlp_id[$nparticipants]      = $dparticipants['irlp_id'];
  $irlp_uid[$nparticipants]     = $dparticipants['u_id'];
  $irlp_pseudo[$nparticipants]  = ($dparticipants['u_id']) ? predata($dparticipants['u_pseudo']) : predata($dparticipants['irlp_pseudo']);
  $irlp_confirm[$nparticipants] = ($dparticipants['irlp_confirme']) ? '&check;' : '';
  $irlp_details[$nparticipants] = predata($dparticipants['irlp_details']);
  $irlp_deetsfr[$nparticipants] = predata($dparticipants['irlp_details_fr']);
  $irlp_deetsen[$nparticipants] = predata($dparticipants['irlp_details_en']);
  $irlp_checked[$nparticipants] = ($dparticipants['irlp_confirme']) ? ' checked' : '';
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']              = "IRL du ".$irl_date;
  $trad['soustitre']          = "Quand internet se glisse dans la vie réelle";
  $trad['desc_passe']         = <<<EOD
Cette page contient des informations sur une <a class="gras" href="{$chemin}pages/irl/index">rencontre IRL</a> entre NoBlemeux. L'IRL en question est dans le passé, elle est conservée ici purement pour des raisons d'archivage et de préservation des souvenirs.
EOD;
  $trad['desc_futur']         = <<<EOD
Cette page contient des informations sur une future <a class="gras" href="{$chemin}pages/irl/index">rencontre IRL</a> entre NoBlemeux qui aura lieu <span class="gras">{$irl_dans}</span>. Si vous êtes intéressé par cette IRL et décidez de nous rejoindre, ce serait avec plaisir que nous vous y accueillerons, les IRL NoBlemeuses sont ouvertes à tous et nous sommes toujours heureux de découvrir de nouvelles personnes.<br>
<br>
Si vous comptez venir à cette IRL, il est <span class="souligne">impératif</span> de prévenir à l'avance un membre de <a class="gras" href="{$chemin}pages/nobleme/admins">l'équipe administrative</a> du site, de préférence via <a class="gras" href="{$chemin}pages/irc/index">le serveur de discussion IRC</a> (ou sinon par message privé).
EOD;
  $trad['meetups_details']        = "Organisation de l'IRL";

  // Participants
  $trad['irlp_membres_zero']  = "Aucun NoBlemeux n'est inscrit à cette IRL pour le moment";
  $trad['irlp_membres_passe'] = "Liste des ".$nparticipants." NoBlemeux ayant participé à cette IRL";
  $trad['irlp_membres_futur'] = "Liste des ".$nparticipants." NoBlemeux comptant participer à cette IRL";
  $trad['irlp_pseudo']        = "PSEUDONYME";
  $trad['irlp_confirm']       = "CONFIRMÉ";
  $trad['irlp_details']       = "DÉTAILS PARTICULIERS";
  $trad['irlp_modifier']      = "MODIFIER";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']              = $irl_date." meetup";
  $trad['soustitre']          = "When the internet spills into the real world";
  $trad['desc_passe']         = <<<EOD
This page contains information on a <a class="gras" href="{$chemin}pages/irl/index">real life meetup</a> between NoBleme members. The meetup in question already happened, it is archived here purely for memory preservation reasons.
EOD;
  $trad['desc_futur']         = <<<EOD
This page contains information on a future <a class="gras" href="{$chemin}pages/irl/index">real life meetup</a> between NoBleme members which will happen <span class="gras">{$irl_dans}</span>. If you are interested in this meetup, you would be welcome to join. NoBleme meetups are open to everyone, and we are always happy to meet new pople. Don't be afraid of the language barrier, a lot of us speak english, and we've had plenty of non-french people take part in our meetups in the past. <br>
<br>
If you intend to join this meetup, it is <span class="souligne">mandatory</span> to warn a member of NoBleme's <a class="gras" href="{$chemin}pages/nobleme/admins">administrative team</a> in advance, if possible through our <a class="gras" href="{$chemin}pages/irc/index">IRC chat server</a> (otherwise by private message).
EOD;
  $trad['meetups_details']        = "Meetup details";

  // Participants
  $trad['irlp_membres_zero']  = "Nobody is attending this meetup so far";
  $trad['irlp_membres_passe'] = "List of the ".$nparticipants." people who attended this meetup";
  $trad['irlp_membres_futur'] = "List of the ".$nparticipants." people who intend to attend this meetup";
  $trad['irlp_pseudo']        = "NICKNAME";
  $trad['irlp_confirm']       = "CONFIRMED";
  $trad['irlp_details']       = "EXTRA INFORMATION";
  $trad['irlp_modifier']      = "EDIT";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h3 id="irl_titre">
          <?=$trad['titre']?>
          <?php if($irl_mod) { ?>
          <a href="<?=$chemin?>pages/irl/irl_modifier?id=<?=$irl_id?>">
            <img class="pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
          </a>
          <img class="pointeur" src="<?=$chemin?>img/icones/supprimer.svg" alt="X" onclick="irl_supprimer('<?=$chemin?>', <?=$irl_id?>);" height="30">
          <?php } ?>
        </h3>

        <h5><?=$trad['soustitre']?></h5>

        <?php if($irl_futur) { ?>
        <p><?=$trad['desc_futur']?></p>
        <?php } else { ?>
        <p><?=$trad['desc_passe']?></p>
        <?php } ?>

        <br>
        <br>

        <h5><?=$trad['meetups_details']?></h5>

        <p><?=$meetups_details?></p>

        <br>
        <br>

        <h5>
          <?php if(!$nparticipants) { ?>
          <?=$trad['irlp_membres_zero']?>
          <?php } else if($irl_futur) { ?>
          <?=$trad['irlp_membres_futur']?>
          <?php } else { ?>
          <?=$trad['irlp_membres_passe']?>
          <?php } if($irl_mod) { ?>
          &nbsp;&nbsp;<img class="valign_middle pointeur meetups_add_user" src="<?=$chemin?>img/icones/ajouter_personne.svg" alt="+" height="30" onclick="toggle_row('irl_ajouter_participant');">
          <?php } ?>
        </h5>

        <br>

        <?php if($irl_mod) { ?>
        <div class="hidden" id="irl_ajouter_participant">
          <fieldset>
            <label for="irl_add_pseudo">Pseudonyme</label>
            <input id="irl_add_pseudo" name="irl_add_pseudo" class="indiv" type="text"><br>
            <br>
            <label for="irl_add_details_fr">Détails particuliers en français (optionnel, rester court/concis)</label>
            <input id="irl_add_details_fr" name="irl_add_details_fr" class="indiv" type="text"><br>
            <br>
            <label for="irl_add_details_en">Détails particuliers en anglais (optionnel, rester court/concis)</label>
            <input id="irl_add_details_en" name="irl_add_details_en" class="indiv" type="text"><br>
            <br>
            <input id="irl_add_confirme" name="irl_add_confirme" type="checkbox">
            <label class="label-inline gras" for="irl_add_confirme">Présence confirmée</label><br>
            <br>
            <input value="AJOUTER LE PARTICIPANT À L'IRL" type="submit" onclick="irl_ajouter_participant('<?=$chemin?>', <?=$irl_id?>);">
          </fieldset>
          <br>
          <br>
        </div>
        <?php } ?>

        <table class="grid titresnoirs hiddenaltc2">
          <?php if($nparticipants) { ?>
          <thead>
            <tr>
              <th>
                <?=$trad['irlp_pseudo']?>
              </th>
              <?php if($irl_futur) { ?>
              <th>
                <?=$trad['irlp_confirm']?>
              </th>
              <?php } ?>
              <th>
                <?=$trad['irlp_details']?>
              </th>
              <?php if($irl_mod) { ?>
              <th class="maigre" colspan="2">
                <?=$trad['irlp_modifier']?>
              </th>
              <?php } ?>
            </tr>
          </thead>
          <?php } ?>
          <tbody class="align_center nowrap" id="irl_participants_tbody">
            <?php } if(!isset($_POST['irl_supprimer'])) { ?>
            <tr class="hidden">
              <td colspan="<?=$irl_colspan?>" class="noir texte_blanc gras">
                ?_? COULD THIS BE AN EASTER EGG YOU JUST SPOTTED RIGHT NOW ?_?
              </td>
            </tr>
            <?php } for($i=0;$i<$nparticipants;$i++) { ?>
            <tr>
              <td class="gras">
                <?php if($irlp_uid[$i]) { ?>
                <a href="<?=$chemin?>pages/user/user?id=<?=$irlp_uid[$i]?>"><?=$irlp_pseudo[$i]?></a>
                <?php } else { ?>
                <?=$irlp_pseudo[$i]?>
                <?php } ?>
              </td>
              <?php if($irl_futur) { ?>
              <td>
                <?=$irlp_confirm[$i]?>
              </td>
              <?php } ?>
              <td>
                <?=$irlp_details[$i]?>
              </td>
              <?php if($irl_mod) { ?>
              <td>
                <img class="valign_table pointeur" src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="18" onclick="toggle_row('irl_edition_<?=$irlp_id[$i]?>', 1);">
              </td>
              <td>
                <img class="valign_table pointeur" src="<?=$chemin?>img/icones/supprimer_personne.svg" alt="X" height="18" onclick="irl_supprimer_participant('<?=$chemin?>', <?=$irl_id?>, <?=$irlp_id[$i]?>);">
              </td>
              <?php } ?>
            </tr>
            <tr class="hidden" id="irl_edition_<?=$irlp_id[$i]?>">
              <td colspan="<?=$irl_colspan?>">
                <br>
                <div class="align_left minitexte2">
                  <fieldset>
                    <label for="irl_edit_pseudo_<?=$irlp_id[$i]?>">Pseudonyme</label>
                    <input id="irl_edit_pseudo_<?=$irlp_id[$i]?>" name="irl_edit_pseudo_<?=$irlp_id[$i]?>" class="indiv" type="text" value="<?=$irlp_pseudo[$i]?>"><br>
                    <br>
                    <label for="irl_edit_details_fr_<?=$irlp_id[$i]?>">Détails particuliers en français (optionnel, rester court/concis)</label>
                    <input id="irl_edit_details_fr_<?=$irlp_id[$i]?>" name="irl_edit_details_fr_<?=$irlp_id[$i]?>" class="indiv" type="text" value="<?=$irlp_deetsfr[$i]?>"><br>
                    <br>
                    <label for="irl_edit_details_en_<?=$irlp_id[$i]?>">Détails particuliers en anglais (optionnel, rester court/concis)</label>
                    <input id="irl_edit_details_en_<?=$irlp_id[$i]?>" name="irl_edit_details_en_<?=$irlp_id[$i]?>" class="indiv" type="text" value="<?=$irlp_deetsen[$i]?>"><br>
                    <br>
                    <input id="irl_edit_confirme_<?=$irlp_id[$i]?>" name="irl_edit_confirme_<?=$irlp_id[$i]?>" type="checkbox"<?=$irlp_checked[$i]?>>
                    <label class="label-inline gras" for="irl_edit_confirme_<?=$irlp_id[$i]?>">Présence confirmée</label><br>
                    <br>
                    <div class="flexcontainer">
                      <div style="flex:auto">
                        <input value="MODIFIER LES INFOS" type="submit" onclick="irl_modifier_participant('<?=$chemin?>', <?=$irl_id?>, <?=$irlp_id[$i]?>);">
                      </div>
                      <div style="flex:auto" class="align_right">
                        <button class="buton button-clear" onclick="toggle_row('irl_edition_<?=$irlp_id[$i]?>', 1);">MASQUER LE FORMULAIRE</button>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <br>
              </td>
            </tr>
            <?php } ?>
            <?php if(!getxhr()) { ?>
          </tbody>
        </table>


      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }