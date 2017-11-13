<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                             CETTE PAGE NE PEUT S'OUVRIR QUE SI ELLE EST APPELÉE DYNAMIQUEMENT PAR DU XHR                              */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../../inc/includes.inc.php'; // Inclusions communes

// Permissions
xhronly();




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On vérifie qu'on ait un ID
if(!isset($_POST['todo_id']))
  exit();

// On vérifie qu'on ait un chemin
if(!isset($_POST['todo_chemin']))
  exit();

// On récupère l'id et le chemin
$todo_id      = postdata_vide('todo_id', 'int', 0);
$todo_chemin  = postdata_vide('todo_chemin', 'string', $chemin);




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

// On va chercher les infos sur le ticket
$qtodo = mysqli_fetch_array(query(" SELECT    todo.titre          AS 't_titre'    ,
                                              todo.timestamp      AS 't_soumis'   ,
                                              todo.timestamp_fini AS 't_resolu'   ,
                                              todo.source         AS 't_source'   ,
                                              todo.contenu        AS 't_contenu'  ,
                                              todo.valide_admin   AS 't_valide'   ,
                                              membres.id          AS 'm_id'       ,
                                              membres.pseudonyme  AS 'm_pseudo'
                                    FROM      todo
                                    LEFT JOIN membres ON todo.FKmembres = membres.id
                                    WHERE     todo.id = '$todo_id' "));

// Si le ticket existe pas, on dégage
if($qtodo['t_titre'] === NULL)
  exit();

// On prépare les données pour l'affichage
$todo_titre       = predata($qtodo['t_titre']);
$todo_soumis_le   = predata(jourfr(date('Y-m-d', $qtodo['t_soumis'])));
$todo_soumis_id   = $qtodo['m_id'];
$todo_soumis_par  = predata($qtodo['m_pseudo']);
$todo_resolu      = ($qtodo['t_resolu']) ? 1 : 0;
$todo_resolu_le   = predata(jourfr(date('Y-m-d', $qtodo['t_resolu'])));
$todo_source      = ($qtodo['t_source']) ? predata($qtodo['t_source']) : 0;
$todo_contenu     = bbcode(predata($qtodo['t_contenu'], 1), 1);
$todo_modifier    = ($qtodo['t_valide']) ? 'MODIFIER' : 'APPROUVER';
$todo_supprimer   = ($qtodo['t_valide']) ? 'SUPPRIMER' : 'REJETER';




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
/***************************************************************************************************************************************/?>

<div class="alinea">
  <br>

  <span class="moinsgros gras">
    <a href="<?=$todo_chemin?>pages/todo/index?id=<?=$todo_id?>">Tâche #<?=$todo_id?></a> : <?=$todo_titre?>
  </span><br>

  <span class="italique">
    Tâche proposée le <?=$todo_soumis_le?> par <a class="gras" href="<?=$todo_chemin?>pages/user/user?id=<?=$todo_soumis_id?>"><?=$todo_soumis_par?></a><br>
    <?php if($todo_resolu) { ?>
    Tâche résolue le <?=$todo_resolu_le?>
    <?php if($todo_source) { ?>
    : <a href="<?=$todo_source?>">code source du patch</a>
    <?php } ?>
    <br>
    <?php } ?>
  </span>

</div>

<br>
  <hr>
  <br>
  <div class="alinea">

    <?=$todo_contenu?><br>

    <?php if(getadmin()) { ?>

    <br>
    <br>

    <?php if(!$todo_resolu) { ?>
    <a class="spaced" href="<?=$todo_chemin?>pages/todo/resolu?id=<?=$todo_id?>">
      <button class="button button-outline">RÉSOLU</button>
    </a>
    &nbsp;

    <?php } ?>
    <a class="spaced" href="<?=$todo_chemin?>pages/todo/edit?id=<?=$todo_id?>">
      <button class="button button-outline"><?=$todo_modifier?></button>
    </a>
    &nbsp;

    <a class="spaced" href="<?=$todo_chemin?>pages/todo/delete?id=<?=$todo_id?>">
      <button class="button button-outline"><?=$todo_supprimer?></button>
    </a>
    <br>

    <?php } ?>

    <br>

    <button class="button button-clear" onclick="toggle_row('todolist_ligne_'+<?=$todo_id?>, 1)">MASQUER LES DÉTAILS DE LA TÂCHE</button><br>

  </div>