<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Permissions
if(isset($_GET['mod']))
  sysoponly($lang);

// Menus du header
$header_menu      = (!isset($_GET['mod'])) ? 'NoBleme' : 'Admin';
$header_sidemenu  = (!isset($_GET['mod'])) ? 'ActiviteRecente' : 'ModLogs';

// Identification
$page_nom = "Consulte l'activité récente";
$page_url = "pages/nobleme/activite";

// Langages disponibles
$langage_page = (!isset($_GET['mod'])) ? array('FR','EN') : array('FR');

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
$activite_dynamique_url = (!isset($_GET['mod'])) ? "activite?dynamique" : "activite?dynamique&amp;mod";




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Suppression d'une entrée dans la liste

if(isset($_POST['activite_delete']) && getadmin())
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
// $activite_desc[$nactrec][$lang]  - Description de l'activité dans le langage spécifié
// $activite_href[$nactrec]         - Lien vers lequel l'activité pointe
// $activite_css[$nactrec]          - CSS à appliquer à l'activité
// $activite_raison[$nactrec]       - (optionnel) Justification du log
// $activite_diff[$nactrec]         - (optionnel) Différences stockées dans le log

// On commence par aller chercher toute l'activité récente
$qactrec = "    SELECT    activite.id           ,
                          activite.timestamp    ,
                          activite.pseudonyme   ,
                          activite.FKmembres    ,
                          activite.action_type  ,
                          activite.action_id    ,
                          activite.action_titre ,
                          activite.parent_id    ,
                          activite.parent_titre ,
                          activite.justification
                FROM      activite              ";

// Activité récente ou log de modération
if(isset($_GET['mod']) && getsysop())
  $qactrec .= " WHERE     activite.log_moderation = 1 ";
else
  $qactrec .= " WHERE     activite.log_moderation = 0 ";

// On rajoute la recherche si y'en a une
if(isset($_POST['activite_type']))
{
  $activite_type = postdata($_POST['activite_type']);
  if($activite_type == 'membres')
    $qactrec .= " AND     ( activite.action_type LIKE 'register'
                  OR        activite.action_type LIKE 'profil%'
                  OR        activite.action_type LIKE 'ban'
                  OR        activite.action_type LIKE 'deban'
                  OR        activite.action_type LIKE 'editpass' ) ";
  else if($activite_type == 'irl')
    $qactrec .= " AND     ( activite.action_type LIKE '%irl_%'
                  OR        activite.action_type LIKE '%_irl%' ) ";
  else if($activite_type == 'dev')
    $qactrec .= " AND     ( activite.action_type LIKE 'version'
                  OR        activite.action_type LIKE '%devblog%'
                  OR        activite.action_type LIKE '%todo_%'
                  OR        activite.action_type LIKE '%_todo%' ) ";
  else if($activite_type == 'misc')
    $qactrec .= " AND       activite.action_type LIKE '%quote_%' ";
}

// On trie
$qactrec .= "   ORDER BY  activite.timestamp DESC ";

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
  $activite_date[$nactrec]    = ilya($dactrec['timestamp']);

  // Par défaut on met toutes les variables à zéro
  $activite_css[$nactrec]         = "";
  $activite_href[$nactrec]        = "";
  $activite_desc[$nactrec]['FR']  = "";
  $activite_desc[$nactrec]['EN']  = "";
  $activite_raison[$nactrec]      = ($dactrec['justification']) ? predata($dactrec['justification']) : "";
  $activite_diff[$nactrec]        = "";

  // On va chercher les diffs s'il y en a
  $qdiff = query(" SELECT titre_diff, diff FROM activite_diff WHERE FKactivite = '".$dactrec['id']."' ORDER BY id ASC ");
  while($ddiff = mysqli_fetch_array($qdiff))
  {
    if($ddiff['titre_diff'])
      $activite_diff[$nactrec] .= '<span class="gras">'.$ddiff['titre_diff'].' :</span> '.bbcode($ddiff['diff']).'<br>';
    else
      $activite_diff[$nactrec] .= bbcode($ddiff['diff']).'<br>';
  }

  // Puis on passe au traitement au cas par cas des divers types d'activité...


  //*************************************************************************************************************************************//
  //                                                               MEMBRES                                                               //
  //*************************************************************************************************************************************//
  // Nouvel utilisateur

  if($dactrec['action_type'] === 'register')
  {
    $activite_css[$nactrec]         = 'texte_blanc nobleme_clair';
    $activite_href[$nactrec]        = $chemin.'pages/user/user?id='.$dactrec['FKmembres'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme'])." s'est inscrit(e) sur NoBleme !";
    $activite_desc[$nactrec]['EN']  = predata($dactrec['pseudonyme'])." registered on NoBleme!";
  }

  //***************************************************************************************************************************************
  // Utilisateur modifie son profil

  else if($dactrec['action_type'] === 'profil')
  {
    $activite_href[$nactrec]        = $chemin.'pages/user/user?id='.$dactrec['FKmembres'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a modifié son profil public';
    $activite_desc[$nactrec]['EN']  = predata($dactrec['pseudonyme']).' edited his/her public profile';
  }

  //***************************************************************************************************************************************
  // Profil d'un user modifié par un admin

  else if($dactrec['action_type'] === 'profil_edit')
  {
    $activite_css[$nactrec]         = 'neutre texte_blanc';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a modifié le profil public de '.predata($dactrec['pseudonyme']);
    $activite_diff[$nactrec]        = ($activite_diff[$nactrec]) ? $activite_diff[$nactrec] : 'Aucune modification apparente. Il est possible que '.predata($dactrec['parent_titre']).' ait juste appuyé sur Modifer sans rien changer. C\'est pas super malin, parce que '.predata($dactrec['pseudonyme']).' a reçu une notification lui disant que son profil a été changé. Au cas où, on crée quand même un log de modération.';
  }

  //***************************************************************************************************************************************
  // Mot de passe d'un user modifié par un admin

  else if($dactrec['action_type'] === 'editpass')
  {
    $activite_css[$nactrec]         = 'neutre texte_blanc';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a modifié le mot de passe de '.predata($dactrec['pseudonyme']);
  }

  //***************************************************************************************************************************************
  // Utilisateur banni

  else if($dactrec['action_type'] === 'ban' && !isset($_GET['mod']))
  {
    $activite_css[$nactrec]         = 'negatif texte_blanc gras';
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/pilori';
    $temp                           = ($dactrec['action_id'] > 1) ? 's' : '';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a été banni(e) pendant '.$dactrec['action_id'].' jour'.$temp;
    $activite_desc[$nactrec]['EN']  = predata($dactrec['pseudonyme']).' has been banned for '.$dactrec['action_id'].' day'.$temp;
  }
  else if($dactrec['action_type'] == 'ban')
  {
    $activite_css[$nactrec]         = 'negatif texte_blanc gras';
    $temp                           = ($dactrec['action_id'] > 1) ? 's' : '';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a banni '.predata($dactrec['pseudonyme']).' pendant '.$dactrec['action_id'].' jour'.$temp;
  }

  //***************************************************************************************************************************************
  // Utilisateur débanni

  else if($dactrec['action_type'] === 'deban' && !isset($_GET['mod']))
  {
    $activite_css[$nactrec]         = 'positif texte_blanc gras';
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/pilori';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a été débanni(e)';
    $activite_desc[$nactrec]['EN']  = predata($dactrec['pseudonyme']).' has been unbanned';
  }
  else if($dactrec['action_type'] == 'deban')
  {
    $activite_css[$nactrec]         = 'positif texte_blanc gras';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a débanni '.predata($dactrec['pseudonyme']);
  }




  //*************************************************************************************************************************************//
  //                                                                 IRL                                                                 //
  //*************************************************************************************************************************************//
  // Nouvelle IRL

  else if($dactrec['action_type'] === 'new_irl' && !isset($_GET['mod']))
  {
    $activite_css[$nactrec]         = 'texte_noir vert_background_clair';
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = 'Nouvelle rencontre IRL planifiée: '.predata($dactrec['action_titre']);
    $activite_desc[$nactrec]['EN']  = 'New real life meetup planned: '.predata($dactrec['action_titre']);
  }
  else if($dactrec['action_type'] === 'new_irl')
  {
    $activite_css[$nactrec]         = 'texte_noir vert_background_clair';
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a crée une nouvelle IRL: '.predata($dactrec['action_titre']);
  }

  //***************************************************************************************************************************************
  // IRL modifiée

  else if($dactrec['action_type'] === 'edit_irl')
  {
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a modifié une IRL: '.predata($dactrec['action_titre']);
  }

  //***************************************************************************************************************************************
  // Suppression d'une IRL

  else if($dactrec['action_type'] === 'delete_irl')
  {
    $activite_css[$nactrec]         = 'mise_a_jour texte_blanc';
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme'])." a supprimé une IRL: ".predata($dactrec['action_titre']);
  }

  //***************************************************************************************************************************************
  // Nouveau participant à une IRL

  else if($dactrec['action_type'] === 'add_irl_participant' && !isset($_GET['mod']))
  {
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a rejoint l\'IRL du '.predata($dactrec['action_titre']);
    $activite_desc[$nactrec]['EN']  = predata($dactrec['pseudonyme']).' joined the meetup '.predata($dactrec['action_titre']);
  }
  else if($dactrec['action_type'] === 'add_irl_participant')
  {
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a ajouté '.predata($dactrec['pseudonyme']).' à l\'IRL du '.predata($dactrec['action_titre']);
  }

  //***************************************************************************************************************************************
  // Participant modifié dans une IRL

  else if($dactrec['action_type'] === 'edit_irl_participant')
  {
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a modifié les infos de '.predata($dactrec['pseudonyme']).' dans l\'IRL du '.predata($dactrec['action_titre']);
  }

  //***************************************************************************************************************************************
  // Participant supprimé d'une IRL

  else if($dactrec['action_type'] === 'del_irl_participant' && !isset($_GET['mod']))
  {
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme']).' a quitté l\'IRL du '.predata($dactrec['action_titre']);
    $activite_desc[$nactrec]['EN']  = predata($dactrec['pseudonyme']).' left the meetup '.predata($dactrec['action_titre']);
  }
  else if($dactrec['action_type'] === 'del_irl_participant')
  {
    $activite_href[$nactrec]        = $chemin.'pages/nobleme/irl?irl='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['parent_titre']).' a supprimé '.predata($dactrec['pseudonyme']).' de l\'IRL du '.predata($dactrec['action_titre']);
  }




  //*************************************************************************************************************************************//
  //                                                            MISCELLANÉES                                                             //
  //*************************************************************************************************************************************//
  // Nouvelle miscellanée

  else if($dactrec['action_type'] === 'quote_add')
  {
    $activite_css[$nactrec]         = 'texte_noir vert_background_clair';
    $activite_href[$nactrec]        = $chemin.'pages/irc/quotes?id='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = 'Miscellanée #'.$dactrec['action_id'].' ajoutée à la collection';
  }




  //*************************************************************************************************************************************//
  //                                                            DÉVELOPPEMENT                                                            //
  //*************************************************************************************************************************************//
  // Nouvelle version

  else if($dactrec['action_type'] === 'version')
  {
    $activite_css[$nactrec]         = 'gras texte_blanc positif';
    $activite_href[$nactrec]        = $chemin.'pages/todo/roadmap';
    $activite_desc[$nactrec]['FR']  = "Nouvelle version de NoBleme.com: ".predata($dactrec['action_titre']);
    $activite_desc[$nactrec]['EN']  = "New version of NoBleme.com: ".predata($dactrec['action_titre']);
  }

  //***************************************************************************************************************************************
  // Nouveau devblog

  else if($dactrec['action_type'] === 'new_devblog')
  {
    $activite_css[$nactrec]         = 'texte_noir gras vert_background';
    $activite_href[$nactrec]        = $chemin.'pages/devblog/blog?id='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = "Nouveau devblog publié: ".predata(tronquer_chaine($dactrec['action_titre'], 50, '...'));
  }

  //***************************************************************************************************************************************
  // Nouveau ticket

  else if($dactrec['action_type'] === 'new_todo')
  {
    $activite_href[$nactrec]        = $chemin.'pages/todo/index?id='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = predata($dactrec['pseudonyme'])." a ouvert un ticket: ".predata(tronquer_chaine($dactrec['action_titre'], 50, '...'));
  }

  //***************************************************************************************************************************************
  // Ticket fini

  else if($dactrec['action_type'] === 'fini_todo')
  {
    $activite_css[$nactrec]         = 'texte_noir vert_background_clair';
    $activite_href[$nactrec]        = $chemin.'pages/todo/index?id='.$dactrec['action_id'];
    $activite_desc[$nactrec]['FR']  = "Ticket résolu: ".predata(tronquer_chaine($dactrec['action_titre'], 70, '...'));
  }
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUTION DU CONTENU MULTILINGUE                                                    */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

$traduction['titre']      = ($lang == 'FR') ? "Activité récente" : "Recent activity";
$traduction['soustitre']  = ($lang == 'FR') ? "Pour ceux qui ne veulent rien rater et tout traquer" : "For those of us who don't want to miss a thing";
$traduction['titre_mod']  = ($lang == 'FR') ? "Logs de modération" : "Mod logs";
$traduction['titretable'] = ($lang == 'FR') ? "DERNIÈRES ACTIONS" : "LATEST ACTIONS";
$traduction['ar_tout']    = ($lang == 'FR') ? "Voir tout" : "Everything";
$traduction['ar_user']    = ($lang == 'FR') ? "Membres" : "Users";
$traduction['ar_irl']     = ($lang == 'FR') ? "IRL" : "Meetups";
$traduction['ar_dev']     = ($lang == 'FR') ? "Développement" : "Internals";
$traduction['ar_misc']    = ($lang == 'FR') ? "Miscellanées" : "Quotes";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!isset($_GET['dynamique'])){ /* Ne pas afficher toute la page si elle est invoquée par du XHR */ include './../../inc/header.inc.php';?>

      <div class="texte2">

        <?php if(!isset($_GET['mod'])) { ?>
        <h1 class="indiv align_center"><?=$traduction['titre']?></h1>
        <h6 class="indiv align_center texte_nobleme_clair"><?=$traduction['soustitre']?></h6>
        <?php } else { ?>
        <h1 class="indiv align_center"><?=$traduction['titre_mod']?></h1>
        <br>
        <p>
          Certains logs de modération ont des icônes à droite de la ligne ( <img height="20" width="20" class="valign_bottom" src="<?=$chemin?>img/icones/pourquoi.png" alt="?"> et <img height="20" width="20" class="valign_bottom" src="<?=$chemin?>img/icones/details.png" alt="?"> ).<br>
          Vous pouvez cliquer dessus pour afficher la justification de l'action et/ou le contenu qui a été modifié/supprimé.
        </p>
        <?php } ?>

        <br>

        <p class="indiv align_center">
          <select id="activite_num"
                  onchange="dynamique('<?=$chemin?>', '<?=$activite_dynamique_url?>', 'activite_table',
                  'activite_num='+dynamique_prepare('activite_num')+
                  '&activite_type='+dynamique_prepare('activite_type'), 1);">
            <option value="100">100</option>
            <option value="250">250</option>
            <option value="1000">1000</option>
          </select>
          <span class="gros gras spaced valign_bottom"><?=$traduction['titretable']?></span>
          <select id="activite_type"
                  onchange="dynamique('<?=$chemin?>', '<?=$activite_dynamique_url?>', 'activite_table',
                  'activite_num='+dynamique_prepare('activite_num')+
                  '&activite_type='+dynamique_prepare('activite_type'), 1);">
            <option value="tout"><?=$traduction['ar_tout']?></option>
            <option value="membres"><?=$traduction['ar_user']?></option>
            <option value="irl"><?=$traduction['ar_irl']?></option>
            <option value="misc"><?=$traduction['ar_misc']?></option>
            <option value="dev"><?=$traduction['ar_dev']?></option>
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
                <img  height="17" width="17" class="valign_center" src="<?=$chemin?>img/icones/pourquoi.png" alt="?"
                      onclick="toggle_row('activite_hidden<?=$i?>',1);">
                <?php } if(isset($_GET['mod']) && $activite_diff[$i]) { ?>
                <img height="17" width="17" class="valign_center" src="<?=$chemin?>img/icones/details.png" alt="?"
                      onclick="toggle_row('activite_hidden<?=$i?>',1);">
                <?php } if(loggedin()) { ?>
                <img height="17" width="17" class="valign_center" src="<?=$chemin?>img/icones/delete.png" alt="X"
                      onclick="var ok = confirm('Confirmation'); if(ok == true) {
                      dynamique('<?=$chemin?>', '<?=$activite_dynamique_url?>', 'activite_table',
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
                <span class="alinea gras souligne">Justification de l'action:</span> <?=$activite_raison[$i]?><br>
                <br>
                <?php } if($activite_raison[$i] && $activite_diff[$i]) { ?>
                <hr>
                <br>
                <?php } if($activite_diff[$i]) { ?>
                <span class="alinea gras souligne">Différence(s) avant/après l'action:</span><br>
                <br>
                <?=$activite_diff[$i]?><br>
                <br>
                <?php } ?>
              </td>
            </tr>
            <?php } } } ?>
          </tbody>
          <?php if(!isset($_GET['dynamique'])) { ?>
        </table>

      </div>

<?php include './../../inc/footer.inc.php'; /*********************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************************************************/ }