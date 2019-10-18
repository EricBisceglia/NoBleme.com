<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/activity.inc.php'; // Traitement de l'activité recente
include './../../inc/functions_time.inc.php';
include './../../inc/bbcodes.inc.php';

// Permissions
if(isset($_GET['mod']))
  user_restrict_to_global_moderators($lang);

// Menus du header
$header_menu      = (!isset($_GET['mod'])) ? 'NoBleme' : 'Admin';
$header_sidemenu  = (!isset($_GET['mod'])) ? 'ActiviteRecente' : 'ModLogs';

// Identification
$page_nom = "Consulte l'activité récente";
$page_url = "pages/nobleme/activite";

// Lien court
$shorturl = "a";

// Langues disponibles
$langue_page = array('FR','EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Activité récente" : "Recent activity";
$page_titre = (isset($_GET['mod'])) ? "Logs de modération" : $page_titre;
$page_desc  = "Liste chronologique des évènements qui ont eu lieu récemment";

// CSS & JS
$js  = array('dynamique', 'toggle');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation de l'URL dynamique selon si c'est les logs de modération ou la liste des tâches
$activite_dynamique_url = (!isset($_GET['mod'])) ? "activite" : "activite?mod";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une entrée dans la liste

if(isset($_POST['activite_delete']) && $est_admin)
{
  $activite_delete = postdata($_POST['activite_delete']);
  query(" DELETE FROM activite      WHERE activite.id               = '$activite_delete' ");
  query(" DELETE FROM activite_diff WHERE activite_diff.FKactivite  = '$activite_delete' ");
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Préparation du tableau, dans les variables suivantes :
// $nactrec                         - Nombre de lignes au tableau renvoyé
// $activite_id[$nactrec]           - ID dans la table activite
// $activite_date[$nactrec]         - Ancienneté de l'activité (format texte)
// $activite_desc[$nactrec][$lang]  - Description de l'activité dans la langue spécifiée
// $activite_href[$nactrec]         - Lien vers lequel l'activité pointe
// $activite_css[$nactrec]          - CSS à appliquer à l'activité
// $activite_raison[$nactrec]       - (optionnel) Justification du log
// $activite_diff[$nactrec]         - (optionnel) Différences stockées dans le log

// On commence par aller chercher toute l'activité récente
$qactrec = "    SELECT    logs_activity.id                ,
                          logs_activity.happened_at       ,
                          logs_activity.nickname          ,
                          logs_activity.fk_users          ,
                          logs_activity.activity_type     ,
                          logs_activity.activity_id       ,
                          logs_activity.activity_summary  ,
                          logs_activity.activity_parent   ,
                          logs_activity.moderation_reason
                FROM      logs_activity              ";

// Activité récente ou log de modération
if(isset($_GET['mod']) && $is_global_moderator)
  $qactrec .= " WHERE     logs_activity.is_administrators_only = 1 ";
else
  $qactrec .= " WHERE     logs_activity.is_administrators_only = 0 ";

// On rajoute la recherche si y'en a une
if(isset($_POST['activite_type']))
{
  $activite_type = postdata($_POST['activite_type']);
  if($activite_type == 'membres')
    $qactrec .= " AND     ( logs_activity.activity_type LIKE 'register'
                  OR        logs_activity.activity_type LIKE 'profil'
                  OR        logs_activity.activity_type LIKE 'profil_%'
                  OR        logs_activity.activity_type LIKE 'droits_%'
                  OR        logs_activity.activity_type LIKE 'ban'
                  OR        logs_activity.activity_type LIKE 'deban'
                  OR        logs_activity.activity_type LIKE 'editpass' ) ";
  else if($activite_type == 'forum')
    $qactrec .= " AND       logs_activity.activity_type LIKE 'forum_%' ";
  else if($activite_type == 'irl')
    $qactrec .= " AND       logs_activity.activity_type LIKE 'irl_%' ";
  else if($activite_type == 'ecrivains')
    $qactrec .= " AND       logs_activity.activity_type LIKE 'ecrivains_%' ";
  else if($activite_type == 'dev')
    $qactrec .= " AND     ( logs_activity.activity_type LIKE 'version'
                  OR        logs_activity.activity_type LIKE 'devblog'
                  OR        logs_activity.activity_type LIKE 'todo_%' )";
  else if($activite_type == 'misc')
    $qactrec .= " AND       logs_activity.activity_type LIKE 'quote_%' ";
  else if($activite_type == 'nbdb')
    $qactrec .= " AND       logs_activity.activity_type LIKE 'nbdb_%' ";
}

// On trie
$qactrec .= "   ORDER BY  logs_activity.happened_at DESC ";

// On décide combien on en select
if(isset($_POST['activite_num']))
{
  $activite_limit = postdata($_POST['activite_num']);
  $activite_limit = ($activite_limit > 1000) ? 1000 : $activite_limit;
  $qactrec .= " LIMIT     ".$activite_limit;
}
else
  $qactrec .= " LIMIT     100 ";

// On balance la requête
$qactrec = query($qactrec);

// Et on prépare les données comme il se doit
for($nactrec = 0 ; $dactrec = mysqli_fetch_array($qactrec) ; $nactrec++)
{
  // On va avoir besoin de l'ID pour la suppression, ainsi que de la date de l'action
  $activite_id[$nactrec]      = $dactrec['id'];
  $activite_date[$nactrec]    = time_since($dactrec['happened_at'], $lang);

  // On prépare le contenu à afficher
  $temp_activite                  = log_activity_parse($path, isset($_GET['mod']), $dactrec['activity_type'], $dactrec['fk_users'], $dactrec['nickname'], $dactrec['activity_id'], $dactrec['activity_summary'], $dactrec['activity_parent']);
  $activite_css[$nactrec]         = $temp_activite['css'];
  $activite_href[$nactrec]        = $temp_activite['href'];
  $activite_desc[$nactrec]['FR']  = $temp_activite['FR'];
  $activite_desc[$nactrec]['EN']  = $temp_activite['EN'];
  $activite_raison[$nactrec]      = ($dactrec['moderation_reason']) ? sanitize($dactrec['moderation_reason']) : "";

  // On va chercher les diffs s'il y en a
  $activite_diff[$nactrec]  = "";
  $qdiff                    = query(" SELECT    logs_activity_details.content_description ,
                                                logs_activity_details.content_before      ,
                                                logs_activity_details.content_after
                                      FROM      logs_activity_details
                                      WHERE     logs_activity_details.fk_logs_activity = '".$dactrec['id']."'
                                      ORDER BY  logs_activity_details.id ASC ");

  // On parcourt les diffs pour les préparer pour l'affichage
  while($ddiff = mysqli_fetch_array($qdiff))
  {
    if($ddiff['content_description'])
    {
      if($ddiff['content_after'])
        $activite_diff[$nactrec] .= '<span class="gras">'.sanitize($ddiff['content_description']).' :</span> '.bbcodes(diff_strings(sanitize($ddiff['content_before'], 1), sanitize($ddiff['content_after'], 1))).'<br><br>';
      else
        $activite_diff[$nactrec] .= '<span class="gras">'.sanitize($ddiff['content_description']).' :</span> '.bbcodes(sanitize($ddiff['content_before'], 1)).'<br><br>';
    }
    else
      $activite_diff[$nactrec] .= bbcodes(sanitize($ddiff['content_before'])).'<br><br>';
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']      = "Activité récente";
  $trad['soustitre']  = "Pour ceux qui ne veulent rien rater et tout traquer";
  $trad['titre_mod']  = "Logs de modération";

  // Sélecteurs
  $trad['titretable'] = "DERNIÈRES ACTIONS";
  $trad['ar_tout']    = "Voir tout";
  $trad['ar_user']    = "Membres";
  $trad['ar_forum']   = "Forum";
  $trad['ar_irl']     = "IRL";
  $trad['ar_dev']     = "Développement";
  $trad['ar_nbdb']    = "NBDB";

  // Détails
  $trad['d_justif']   = "Justification de l'action :";
  $trad['d_diff']     = "Différence(s) avant/après l'action :";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']      = "Recent activity";
  $trad['soustitre']  = "For those of us who don't want to miss a thing";
  $trad['titre_mod']  = "Mod logs";

  // Sélecteurs
  $trad['titretable'] = "LATEST ACTIONS";
  $trad['ar_tout']    = "Everything";
  $trad['ar_user']    = "Users";
  $trad['ar_forum']   = "Forum";
  $trad['ar_irl']     = "Meetups";
  $trad['ar_dev']     = "Internals";
  $trad['ar_nbdb']    = "NBDB";

  // Détails
  $trad['d_justif']   = "Reason for this action:";
  $trad['d_diff']     = "Différence(s) before/after this action:";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!page_is_xhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte2">

        <?php if(!isset($_GET['mod'])) { ?>
        <h1 class="indiv align_center"><?=$trad['titre']?></h1>
        <h6 class="indiv align_center texte_nobleme_clair"><?=$trad['soustitre']?></h6>
        <?php } else { ?>
        <h1 class="indiv align_center"><?=$trad['titre_mod']?></h1>
        <br>
        <p>
          Certains logs de modération ont des icônes à droite de la ligne ( <img class="valign_middle" src="<?=$path?>img/icones/info.svg" alt="i" height="18"> et <img class="valign_middle" src="<?=$path?>img/icones/help.svg" alt="?" height="18"> ).<br>
          Vous pouvez cliquer dessus pour afficher la justification de l'action et/ou le contenu qui a été modifié/supprimé.
        </p>
        <?php } ?>

        <br>

        <p class="indiv align_center">
          <select id="activite_num"
                  onchange="dynamique('<?=$path?>', '<?=$activite_dynamique_url?>', 'activite_table',
                  'activite_num='+dynamique_prepare('activite_num')+
                  '&activite_type='+dynamique_prepare('activite_type'), 1);">
            <option value="100">100</option>
            <option value="250">250</option>
            <option value="1000">1000</option>
          </select>
          <span class="gros gras spaced valign_bottom"><?=$trad['titretable']?></span>
          <select id="activite_type"
                  onchange="dynamique('<?=$path?>', '<?=$activite_dynamique_url?>', 'activite_table',
                  'activite_num='+dynamique_prepare('activite_num')+
                  '&activite_type='+dynamique_prepare('activite_type'), 1);">
            <option value="tout"><?=$trad['ar_tout']?></option>
            <option value="membres"><?=$trad['ar_user']?></option>
            <option value="forum"><?=$trad['ar_forum']?></option>
            <option value="irl"><?=$trad['ar_irl']?></option>
            <option value="nbdb"><?=$trad['ar_nbdb']?></option>
            <?php if($lang == 'FR') { ?>
            <option value="ecrivains">Coin des écrivains</option>
            <option value="misc">Miscellanées</option>
            <?php } ?>
            <option value="dev"><?=$trad['ar_dev']?></option>
          </select>
        </p>

        <br>

        <table class="titresnoirs" id="activite_table">
          <?php } ?>
          <thead>
            <tr>
              <th colspan="3">
                &nbsp;
              </th>
            </tr>
          </thead>
          <tbody class="align_center">
            <?php for($i=0;$i<$nactrec;$i++) { ?>
            <?php if($activite_desc[$i][$lang]) { ?>
            <tr>
              <?php if($activite_href[$i]) { ?>
              <td class="pointeur nowrap <?=$activite_css[$i]?>" onclick="window.open('<?=$activite_href[$i]?>','_blank');">
              <?php } else { ?>
              <td class="nowrap <?=$activite_css[$i]?>">
              <?php } ?>
                <?=$activite_date[$i]?>
              </td>
              <?php if($activite_href[$i]) { ?>
              <td class="pointeur nowrap <?=$activite_css[$i]?>" onclick="window.open('<?=$activite_href[$i]?>','_blank');">
              <?php } else { ?>
              <td class="nowrap <?=$activite_css[$i]?>">
              <?php } ?>
                <?=$activite_desc[$i][$lang]?>
              </td>
              <td class="pointeur nowrap <?=$activite_css[$i]?>">
                <?php if(isset($_GET['mod']) && $activite_raison[$i]) { ?>
                <img class="valign_center" src="<?=$path?>img/icones/help.svg" alt="?"
                      onclick="toggle_row('activite_hidden<?=$i?>',1);">
                <?php } if(isset($_GET['mod']) && $activite_diff[$i]) { ?>
                <img class="valign_center" src="<?=$path?>img/icones/info.svg" alt="i"
                      onclick="toggle_row('activite_hidden<?=$i?>',1);">
                <?php } if($est_admin) { ?>
                <img class="valign_center" src="<?=$path?>img/icones/supprimer.svg" alt="X"
                      onclick="var ok = confirm('Confirmation'); if(ok == true) {
                      dynamique('<?=$path?>', '<?=$activite_dynamique_url?>', 'activite_table',
                      'activite_num='+dynamique_prepare('activite_num')+
                      '&activite_type='+dynamique_prepare('activite_type')+
                      '&activite_delete='+<?=$activite_id[$i]?>, 1); }">
                <?php } ?>
              </td>
            </tr>
            <?php if(isset($_GET['mod'])) { ?>
            <tr class="hidden texte_noir" id="activite_hidden<?=$i?>">
              <td colspan="3" class="align_left">
                <?php if($activite_raison[$i]) { ?>
                <span class="alinea gras souligne"><?=$trad['d_justif']?></span> <?=$activite_raison[$i]?><br>
                <br>
                <?php } if($activite_raison[$i] && $activite_diff[$i]) { ?>
                <hr>
                <br>
                <?php } if($activite_diff[$i]) { ?>
                <span class="alinea gras souligne"><?=$trad['d_diff']?></span><br>
                <br>
                <?=$activite_diff[$i]?><br>
                <br>
                <?php } ?>
              </td>
            </tr>
            <?php } } } ?>
          </tbody>
          <?php if(!getxhr()) { ?>
        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }