<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/todo.inc.php';     // Fonctions liées à la liste des tâches

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Roadmap';

// Identification
$page_nom = "Lit le plan de route";
$page_url = "pages/todo/roadmap";

// Langues disponibles
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Plan de route" : "Roadmap";
$page_desc  = "Historique et futur du développement de NoBleme";

// CSS
$css = array('tasks');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les roadmaps
$qroadmaps = query("  SELECT    todo_roadmap.id                 AS 'r_id'       ,
                                todo_roadmap.version_$lang      AS 'r_version'  ,
                                todo_roadmap.description_$lang  AS 'r_desc'
                      FROM      todo_roadmap
                      ORDER BY  todo_roadmap.id_classement DESC ");

// On les prépare pour l'affichage
$temp_admin = getadmin() ? ' ' : ' AND todo.public = 1 ';
for($nroadmaps = 0; $droadmaps = mysqli_fetch_array($qroadmaps); $nroadmaps++)
{
  $roadmap_id[$nroadmaps]           = $droadmaps['r_id'];
  $roadmap_nom[$nroadmaps]          = predata($droadmaps['r_version']);
  $roadmap_description[$nroadmaps]  = bbcode(predata($droadmaps['r_desc'], 1));

  // Pour chaque roadmap, on va chercher les tâches liées
  $temp_roadmap_id          = $droadmaps['r_id'];
  $todo_a_faire[$nroadmaps] = 0;
  $qtodo = query("  SELECT    todo.id                   AS 't_id'           ,
                              todo.importance           AS 't_importance'   ,
                              todo.timestamp            AS 't_creation'     ,
                              todo_categorie.id         AS 'c_id'           ,
                              todo_categorie.titre_fr   AS 'c_titre_fr'     ,
                              todo_categorie.titre_en   AS 'c_titre_en'     ,
                              todo.titre_$lang          AS 't_description'  ,
                              todo.timestamp_fini       AS 't_resolution'   ,
                              todo.public               AS 't_public'
                    FROM      todo
                    LEFT JOIN todo_categorie ON todo.FKtodo_categorie = todo_categorie.id
                    WHERE     todo.valide_admin     = 1
                    AND       todo.titre_$lang     != ''
                    $temp_admin
                    AND       todo.FKtodo_roadmap   = '$temp_roadmap_id'
                    ORDER BY  (todo.timestamp_fini != 0)        ,
                              todo.timestamp_fini         DESC  ,
                              todo.importance             DESC  ,
                              todo.timestamp              DESC  ");

  // Et on prépare les tâches liées pour l'affichage
  for($ntodo[$nroadmaps] = 0; $dtodo = mysqli_fetch_array($qtodo); $ntodo[$nroadmaps]++)
  {
    $todo_a_faire[$nroadmaps]                        += (!$dtodo['t_resolution']) ? 1 : 0;
    $todo_id[$nroadmaps][$ntodo[$nroadmaps]]          = $dtodo['t_id'];
    $todo_css[$nroadmaps][$ntodo[$nroadmaps]]         = ($dtodo['t_resolution']) ? 'todo_solved' : 'todo_importance_'.$dtodo['t_importance'];
    $todo_prive[$nroadmaps][$ntodo[$nroadmaps]]       = (!$dtodo['t_public']) ? 'ADMIN' : '';
    $temp_lang_resolution                             = ($lang == 'FR') ? 'Résolu' : 'Solved';
    $todo_importance[$nroadmaps][$ntodo[$nroadmaps]]  = (!$dtodo['t_resolution']) ? todo_importance($dtodo['t_importance'], $lang, 1) : $temp_lang_resolution;
    $todo_creation[$nroadmaps][$ntodo[$nroadmaps]]    = predata(ilya($dtodo['t_creation'], $lang));
    $temp_lang_categorie                              = ($lang == 'FR') ? $dtodo['c_titre_fr'] : $dtodo['c_titre_en'];
    $todo_categorie[$nroadmaps][$ntodo[$nroadmaps]]   = ($dtodo['c_id']) ? predata($temp_lang_categorie) : '';
    $todo_description[$nroadmaps][$ntodo[$nroadmaps]] = predata(tronquer_chaine($dtodo['t_description'], 50, '...'));
    $temp_lang_resolution                             = ($lang == 'FR') ? 'Non résolu' : 'Unsolved';
    $todo_resolution[$nroadmaps][$ntodo[$nroadmaps]]  = ($dtodo['t_resolution']) ? predata(ilya($dtodo['t_resolution'], $lang)) : $temp_lang_resolution;
  }
  $todo_finies[$nroadmaps]    = $ntodo[$nroadmaps] - $todo_a_faire[$nroadmaps];
  $todo_resolues[$nroadmaps]  = format_nombre(calcul_pourcentage($todo_finies[$nroadmaps], $ntodo[$nroadmaps]),"pourcentage",0);
}
$temp_admin = getadmin();




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']              = "Plan de route";
  $trad['soustitre']          = "Historique et futur du développement de NoBleme";
  $trad['desc1']              = <<<EOD
Cette page vous permet de voir le chemin qu'a parcouru le développement de NoBleme, et le chemin futur qui sera parcouru si les plans ne changent pas. Les tâches (issues de la <a class="gras" href="{$chemin}pages/todo/index">liste des tâches</a>) sont regroupées par version passée du site (ou par objectif futur), et triées par ordre antéchronologique. Les tâches finies apparaissent en <span class="todo_resolu texte_noir spaced gras">vert</span>, les ouvertes <span class="todo_importance_1 texte_noir spaced gras">nuances</span> <span class="todo_importance_3 texte_noir spaced gras">de</span> <span class="todo_importance_5 texte_noir spaced gras">rouge</span> selon leur degré d'importance. Pour voir les détails d'une tâche, cliquez n'importe où sur la ligne contenant la tâche en question.
EOD;

  // Tableaux de tâches : Titres
  $trad['roadmap_prive']      = "ADMIN";
  $trad['roadmap_importance'] = "IMPORTANCE";
  $trad['roadmap_creation']   = "CRÉATION";
  $trad['roadmap_categorie']  = "CATÉGORIE";
  $trad['roadmap_desc']       = "DESCRIPTION";
  $trad['roadmap_resolution'] = "RÉSOLUTION";

  // Tableaux de tâches : Barres d'état
  $trad['roadmap_b_liee']     = "TÂCHE LIÉE À CET OBJECTIF";
  $trad['roadmap_b_liees']    = "TÂCHES LIÉES À CET OBJECTIF";
  $trad['roadmap_b_dont']     = "DONT";
  $trad['roadmap_b_finies']   = "FINIES";
  $trad['roadmap_b_et']       = "ET";
  $trad['roadmap_b_todo']     = "À FAIRE";
  $trad['roadmap_b_soit']     = "SOIT";
  $trad['roadmap_b_nbsolved'] = "RÉSOLUES";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']              = "Roadmap";
  $trad['soustitre']          = "Past and future plans of NoBleme's development";
  $trad['desc1']              = <<<EOD
This page allows you to follow the road taken by NoBleme's development, and the upcoming road which will be followed if plans don't change. The tasks (taken from the <a class="gras" href="{$chemin}pages/todo/index">to-do list</a>) are grouped by version of the website (or by future milestone), and sorted in reverse chronological order. Finished tasks are in <span class="todo_resolu texte_noir spaced gras">green</span>, open tasks in <span class="todo_importance_1 texte_noir spaced gras">shades</span> <span class="todo_importance_3 texte_noir spaced gras">of</span> <span class="todo_importance_5 texte_noir spaced gras">red</span> depending on how important they are. You can click on a task to see its details.
EOD;

  // Tableaux de tâches : Titres
  $trad['roadmap_prive']      = "ADMIN";
  $trad['roadmap_importance'] = "STATUS";
  $trad['roadmap_creation']   = "CREATED";
  $trad['roadmap_categorie']  = "CATEGORY";
  $trad['roadmap_desc']       = "DESCRIPTION";
  $trad['roadmap_resolution'] = "SOLVED";

  // Tableaux de tâches : Barres d'état
  $trad['roadmap_b_liee']     = "TASK LINKED TO THIS MILESTONE";
  $trad['roadmap_b_liees']    = "TASKS LINKED TO THIS MILESTONE";
  $trad['roadmap_b_dont']     = "INCLUDING";
  $trad['roadmap_b_finies']   = "DONE";
  $trad['roadmap_b_et']       = "AND";
  $trad['roadmap_b_todo']     = "STILL OPEN";
  $trad['roadmap_b_soit']     = "TOTAL";
  $trad['roadmap_b_nbsolved'] = "SOLVED";
}




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/************************************************************************************************/ include './../../inc/header.inc.php'; ?>

      <div class="texte">

        <h1>
          <?=$trad['titre']?>
          <?php if($temp_admin) { ?>
          <a href="<?=$chemin?>pages/todo/index?add">
            <img src="<?=$chemin?>img/icones/ajouter.svg" alt="+" height="30">
          </a>
          <a href="<?=$chemin?>pages/todo/edit_roadmaps">
            <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
          </a>
          <?php } ?>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
        </h5>

        <p>
          <?=$trad['desc1']?>
        </p>

      </div>

      <?php for($i=0;$i<$nroadmaps;$i++) { ?>
      <?php if($ntodo[$i]) { ?>

      <br>
      <br>
      <hr class="separateur_contenu">
      <br>

      <div class="texte3">

        <h5 class="align_center"><?=$roadmap_nom[$i]?></h5>

        <?php if($roadmap_description[$i]) { ?>
        <p class="align_center">
          <?=$roadmap_description[$i]?>
        </p>
        <br>
        <?php } ?>

        <br>

        <table class="grid fullgrid texte_noir nowrap">
          <thead>

            <tr class="grisclair gras">
              <?php if($temp_admin) { ?>
              <th>
                ID
              </th>
              <th>
                <?=$trad['roadmap_prive']?>
              </th>
              <?php } ?>
              <th>
                <?=$trad['roadmap_importance']?>
              </th>
              <th>
                <?=$trad['roadmap_creation']?>
              </th>
              <th>
                <?=$trad['roadmap_categorie']?>
              </th>
              <th>
                <?=$trad['roadmap_desc']?>
              </th>
              <th>
                <?=$trad['roadmap_resolution']?>
              </th>
            </tr>

          </thead>
          <tbody>

            <tr>
              <?php if($temp_admin) { ?>
              <td class="align_center noir texte_blanc gras" colspan="7">
              <?php } else { ?>
              <td class="align_center noir texte_blanc gras" colspan="5">
              <?php } ?>
                <?php if($ntodo[$i] > 1) { ?>
                <?=$ntodo[$i]?> <?=$trad['roadmap_b_liees']?>
                <?php } else { ?>
                <?=$ntodo[$i]?> <?=$trad['roadmap_b_liee']?>
                <?php } ?>
                &nbsp;<span class="texte_positif"><?=$trad['roadmap_b_dont']?> <?=$todo_finies[$i]?> <?=$trad['roadmap_b_finies']?></span>
                &nbsp;<span class="texte_negatif"><?=$trad['roadmap_b_et']?> <?=$todo_a_faire[$i]?> <?=$trad['roadmap_b_todo']?></span>
                &nbsp;<span class="texte_neutre"><?=$trad['roadmap_b_soit']?> <?=$todo_resolues[$i]?> <?=$trad['roadmap_b_nbsolved']?></span>
              </td>
            </tr>

            <?php for($j=0;$j<$ntodo[$i];$j++) { ?>

            <tr class="align_center pointeur <?=$todo_css[$i][$j]?>" onclick="window.open('<?=$chemin?>pages/todo/index?id=<?=$todo_id[$i][$j]?>', '_blank');">
              <?php if($temp_admin) { ?>
              <td>
                <?=$todo_id[$i][$j]?>
              </td>
              <td class="gras">
                <?=$todo_prive[$i][$j]?>
              </td>
              <?php } ?>
              <td>
                <?=$todo_importance[$i][$j]?>
              </td>
              <td>
                <?=$todo_creation[$i][$j]?>
              </td>
              <td>
                <?=$todo_categorie[$i][$j]?>
              </td>
              <td>
                <?=$todo_description[$i][$j]?>
              </td>
              <td>
                <?=$todo_resolution[$i][$j]?>
              </td>
            </tr>

            <?php } ?>

          </tbody>
        </table>

      </div>

      <?php } ?>
      <?php } ?>

<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              FIN DU HTML                                                              */
/*                                                                                                                                       */
/***************************************************************************************************/ include './../../inc/footer.inc.php';