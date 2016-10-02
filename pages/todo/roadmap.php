<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes

// Menus du header
$header_menu      = '';
$header_submenu   = 'dev';
$header_sidemenu  = 'roadmap';

// Titre et description
$page_titre = "Plan de route";
$page_desc  = "Historique et futur du développement de Nobleme";

// Identification
$page_nom = "todo";
$page_id  = "roadmap";

// CSS & JS
$css = array('todo');
$js  = array('popup');


/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On commence par aller chercher les plans de route
$qroadmaps = query(" SELECT id, version, description FROM todo_roadmap ORDER BY id_classement DESC ");

// Et on les parcourt
for($nroadmaps = 0 ; $droadmaps = mysqli_fetch_array($qroadmaps) ; $nroadmaps++)
{
  // Assignation des données pour l'affichage
  $roadmap_version[$nroadmaps]      = $droadmaps['version'];
  $roadmap_description[$nroadmaps]  = bbcode(nl2br_fixed($droadmaps['description']));

  // Et maintenant, on va chercher les tickets liés à la version
  $roadmapid  = $droadmaps['id'];
  $qtodo      = " SELECT    todo.id                   ,
                            todo.timestamp            ,
                            todo.importance           ,
                            todo.titre                ,
                            todo_categorie.categorie  ,
                            todo.timestamp_fini       ,
                            COUNT(todo_commentaire.id) AS 'commentaires'
                  FROM      todo
                  LEFT JOIN todo_categorie    ON todo.FKtodo_categorie  = todo_categorie.id
                  LEFT JOIN todo_commentaire  ON todo.id                = todo_commentaire.FKtodo
                  WHERE     todo.FKtodo_roadmap = '$roadmapid'
                  AND       todo.valide_admin   = 1   ";
  if(!getadmin())
    $qtodo   .= " AND       todo.public         = 1   ";
  $qtodo     .= " GROUP BY  todo.id
                  ORDER BY  todo.timestamp_fini   DESC  ,
                            todo.importance       DESC  ,
                            todo.titre            ASC   ";
  $qtodo = query($qtodo);

  // On parcourt les tickets
  for($i = 0 ; $dtodo = mysqli_fetch_array($qtodo) ; $i++)
  {
    // Reste qu'à assigner les données des tickets
    $todo_id[$nroadmaps][$i]            = $dtodo['id'];
    $todo_css[$nroadmaps][$i]           = (!$dtodo['timestamp_fini']) ? 'todo_importance_'.$dtodo['importance'] : 'todo_resolu';
    $todo_titre[$nroadmaps][$i]         = (strlen(html_entity_decode($dtodo['titre'])) > 39) ? substr(html_entity_decode($dtodo['titre']),0,36).'...' : $dtodo['titre'];
    $todo_ouvert[$nroadmaps][$i]        = ilya($dtodo['timestamp']);
    $todo_resolu[$nroadmaps][$i]        = ($dtodo['timestamp_fini']) ? ilya($dtodo['timestamp_fini']) : '';
    $todo_importance[$nroadmaps][$i]    = todo_importance($dtodo['importance'],1);
    $todo_projet[$nroadmaps][$i]        = $dtodo['categorie'];
    $todo_commentaires[$nroadmaps][$i]  = ($dtodo['commentaires']) ? $dtodo['commentaires'] : '';
  }

  // On récupère le nombre de tickets dans le roadmap
  $num_todo[$nroadmaps] = $i;
}



/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

    <br>
    <br>
    <div class="indiv align_center">
      <img src="<?=$chemin?>img/logos/roadmap.png" alt="PLAN DE ROUTE">
    </div>
    <br>

    <div class="body_main midsize">
      <span class="titre">Historique et futur du développement de NoBleme</span><br>
      <br>
      Cette page contient le « plan de route » de NoBleme : Une liste des versions passées et futures du site.<br>
      Pour chacune de ces versions, il y a une liste des tâches accomplies ou à accomplir qui y sont liées.<br>
      <br>
      La page est présentée antéchronologiquement : Les versions futures en haut, passées en bas.<br>
      Pour les versions futures, les tâches sont sur fond <span class="todo_importance_5 texte_blanc gras">&nbsp;rouge </span>. Il s'agit uniquement de projets, qui sont listés à titre indicatif.<br>
      Si aucune tâche rouge n'apparait sur la page, c'est que le développement est en pause ou qu'il ne reste plus rien de planifié à faire.<br>
      Pour les versions passées, les tâches sont sur fond <span class="todo_resolu texte_blanc gras">&nbsp;vert </span>. Ce sont des tâches déjà résolues.<br>
      <br>
      <script type="text/javascript">
        document.write('Vous pouvez voir les détails, la description, et les commentaires d\'un ticket en cliquant dessus.<br>');
      </script>
      <noscript>
        <div class="gros gras align_center erreur texte_blanc intable">
          <br>
          Le JavaScript est désactivé sur votre navigateur.<br>
          <br>
          Le JavaScript est requis pour pouvoir utiliser toutes les fonctionnalités la page !<br>
          <br>
        </div>
      </noscript>
      <br>
      Certains tickets ne sont assignés à aucune version et n'apparaissent pas ici. Vous pouvez voir tous les tickets sur la <a href="<?=$chemin?>pages/todo/index?recent">liste des tâches</a>.<br>
      Si vous avez une bonne idée à proposer pour une version future du site, n'hésitez pas à <a href="<?=$chemin?>pages/todo/add">ouvrir un ticket</a>.
    </div>

    <br>

    <?php for($i=0;$i<$nroadmaps;$i++) { ?>
    <div class="body_main midsize">
      <?php if(loggedin() && getadmin()) { ?>
      <table class="cadre_gris indiv" onClick="lienpopup('<?=$chemin?>pages/todo/roadmaps?popup',800)">
      <?php } else { ?>
      <table class="cadre_gris indiv">
      <?php } ?>
        <tr>
          <td class="align_center gras">
            <span class="moinsgros">Version <?=$roadmap_version[$i]?></span><br>
            <?php if($roadmap_description[$i]) { ?>
            <br>
            <?=$roadmap_description[$i]?><br>
            <br>
            <?php } ?>
          </td>
        </tr>
      </table>
      <?php if($num_todo[$i]) { ?>
      <table class="cadre_gris indiv">
        <tr>
          <td class="cadre_gris gras spaced align_center">
            Titre
          </td>
          <td class="cadre_gris gras spaced align_center">
            Ouvert
          </td>
          <td class="cadre_gris gras spaced align_center">
            Résolu
          </td>
          <td class="cadre_gris gras spaced align_center">
            Importance
          </td>
          <td class="cadre_gris gras spaced align_center">
            Catégorie
          </td>
          <td class="cadre_gris gras spaced align_center">
            Réponses
          </td>
        </tr>
        <?php for($j=0;$j<$num_todo[$i];$j++) { ?>
        <tr class="pointeur" onClick="window.location.href = '<?=$chemin?>pages/todo/index?id=<?=$todo_id[$i][$j]?>';">
          <td class="cadre_gris align_center spaced gras <?=$todo_css[$i][$j]?>">
            <a class="blank" href="<?=$chemin?>pages/todo/index?id=<?=$todo_id[$i][$j]?>"><?=$todo_titre[$i][$j]?></a>
          </td>
          <td class="cadre_gris align_center spaced <?=$todo_css[$i][$j]?>">
            <?=$todo_ouvert[$i][$j]?>
          </td>
          <td class="cadre_gris align_center spaced <?=$todo_css[$i][$j]?>">
            <?=$todo_resolu[$i][$j]?>
          </td>
          <td class="cadre_gris align_center spaced <?=$todo_css[$i][$j]?>">
            <?=$todo_importance[$i][$j]?>
          </td>
          <td class="cadre_gris align_center spaced <?=$todo_css[$i][$j]?>">
            <?=$todo_projet[$i][$j]?>
          </td>
          <td class="cadre_gris align_center spaced gras <?=$todo_css[$i][$j]?>">
            <?=$todo_commentaires[$i][$j]?>
          </td>
        </tr>
        <?php } ?>
      </table>
      <?php } ?>
    </div>
    <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';