<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                             INITIALISATION                                                            */
/*                                                                                                                                       */
// Inclusions /***************************************************************************************************************************/
include './../../inc/includes.inc.php'; // Inclusions communes
include './../../inc/todo.inc.php';     // Fonctions liées à la liste des tâches

// Menus du header
$header_menu      = 'NoBleme';
$header_sidemenu  = 'Todolist';

// Identification
$page_nom = "Décortique la liste des tâches";
$page_url = "pages/todo/index";

// Langues disponibles
$langue_page = array('FR', 'EN');

// Titre et description
$page_titre = ($lang == 'FR') ? "Liste des tâches" : "To-do list";
$page_desc  = "Liste de tâches accomplies ou à accomplir dans le développement de NoBleme";

// CSS & JS
$css  = array('todo');
$js   = array('toggle', 'dynamique', 'todo/liste_taches');




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        TRAITEMENT DU POST-DATA                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ajouter une nouvelle tâche

if(isset($_POST['todo_add_go']) && $est_admin)
{
  // Permissions
  adminonly($lang);

  // Assainissement du postdata
  $todo_add_titre       = postdata_vide('todo_add_titre', 'string', '');
  $todo_add_description = postdata_vide('todo_add_description', 'string', '');
  $todo_add_categorie   = postdata_vide('todo_add_categorie', 'int', 0);
  $todo_add_objectif    = postdata_vide('todo_add_objectif', 'int', 0);
  $todo_add_importance  = postdata_vide('todo_add_importance', 'int', 0);
  $todo_add_public      = postdata_vide('todo_add_public', 'int', 0);

  // Création de la tâche
  $timestamp = time();
  query(" INSERT INTO todo
          SET         todo.FKmembres        = 1                       ,
                      todo.timestamp        = '$timestamp'            ,
                      todo.importance       = '$todo_add_importance'  ,
                      todo.titre            = '$todo_add_titre'       ,
                      todo.contenu          = '$todo_add_description' ,
                      todo.FKtodo_categorie = '$todo_add_categorie'   ,
                      todo.FKtodo_roadmap   = '$todo_add_objectif'    ,
                      todo.valide_admin     = 1                       ,
                      todo.public           = '$todo_add_public'      ,
                      todo.timestamp_fini   = 0                       ,
                      todo.source           = ''                      ");

  // Si la tâche est publique, on notifie
  if($todo_add_public)
  {
    // Activité récente
    $todo_add_id      = mysqli_insert_id($db);
    $todo_add_pseudo  = postdata(getpseudo(), 'string');
    activite_nouveau('todo_new', 0, 1, $todo_add_pseudo, $todo_add_id, $todo_add_titre);

    // Bot IRC
    $todo_add_pseudo_raw  = getpseudo();
    $todo_add_titre_raw   = $_POST['todo_add_titre'];
    ircbot($chemin, $todo_add_pseudo_raw." a ouvert une tâche : ".$todo_add_titre_raw." - ".$GLOBALS['url_site']."pages/todo/index?id=".$todo_add_id, "#dev");
  }
}






/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                        PRÉPARATION DES DONNÉES                                                        */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tableau des tâches

// On stocke dans un coin si on est admin ou pas
$todo_admin   = getadmin();

// On va chercher la liste des tâches
$qtodo = "    SELECT    todo.id                   AS 't_id'         ,
                        todo.titre                AS 't_titre'      ,
                        todo.timestamp            AS 't_creation'   ,
                        todo.timestamp_fini       AS 't_resolution' ,
                        todo.importance           AS 't_importance' ,
                        todo.valide_admin         AS 't_valide'     ,
                        todo.public               AS 't_public'     ,
                        todo.source               AS 't_source'     ,
                        todo.contenu              AS 't_contenu'    ,
                        todo_categorie.categorie  AS 'c_nom'        ,
                        todo_roadmap.version      AS 'r_nom'        ,
                        membres.pseudonyme        AS 'm_pseudo'     ,
                        membres.id                AS 'm_id'
              FROM      todo
              LEFT JOIN membres         ON todo.FKmembres         = membres.id
              LEFT JOIN todo_categorie  ON todo.FKtodo_categorie  = todo_categorie.id
              LEFT JOIN todo_roadmap    ON todo.FKtodo_roadmap    = todo_roadmap.id
              WHERE     1 = 1 ";
if(!$todo_admin)
  $qtodo .= " AND       todo.valide_admin = 1
              AND       todo.public       = 1 ";

// Assainissement du postdata des recherches
$todo_preset_id           = isset($_GET['id']) ? postdata($_GET['id'], 'int') : 0;
$todo_search_id           = postdata_vide('todo_search_id', 'int', $todo_preset_id);
$todo_preset_id           = ($todo_preset_id) ? $todo_preset_id : '';
$todo_search_prive        = postdata_vide('todo_search_prive', 'int', -1);
$todo_search_importance   = postdata_vide('todo_search_importance', 'int', -1);
$todo_search_creation     = postdata_vide('todo_search_creation', 'int', 0);
$todo_search_createur     = postdata_vide('todo_search_createur', 'string', '');
$todo_search_categorie    = postdata_vide('todo_search_categorie', 'int', -1);
$todo_search_description  = postdata_vide('todo_search_description', 'strin', '');
$todo_search_objectif     = postdata_vide('todo_search_objectif', 'int', -1);
$todo_search_etat         = postdata_vide('todo_search_etat', 'int', -1);
$todo_search_resolution   = postdata_vide('todo_search_resolution', 'int', 0);

// Recherches
if($todo_search_id)
  $qtodo .= " AND       todo.id                                   = '$todo_search_id' ";
if($todo_search_prive >= 0)
  $qtodo .= " AND       todo.public                               = '$todo_search_prive' ";
if($todo_search_importance >= 0)
  $qtodo .= " AND       todo.timestamp_fini                       = 0
              AND       todo.importance                           = '$todo_search_importance' ";
if($todo_search_creation)
  $qtodo .= " AND       YEAR(FROM_UNIXTIME(todo.timestamp))       = '$todo_search_creation' ";
if($todo_search_createur)
  $qtodo .= " AND       membres.pseudonyme                        LIKE '%$todo_search_createur%' ";
if($todo_search_categorie == 0)
  $qtodo .= " AND       todo.FKtodo_categorie                     = 0 ";
if($todo_search_categorie > 0)
  $qtodo .= " AND       todo.FKtodo_categorie                     = '$todo_search_categorie' ";
if($todo_search_description)
  $qtodo .= " AND       todo.titre                                LIKE '%$todo_search_description%' ";
if($todo_search_objectif == 0)
  $qtodo .= " AND       todo.FKtodo_roadmap                       = 0 ";
if($todo_search_objectif > 0)
  $qtodo .= " AND       todo.FKtodo_roadmap                       = '$todo_search_objectif' ";
if($todo_search_etat == 0)
  $qtodo .= " AND       todo.timestamp_fini                       = 0 ";
if($todo_search_etat == 1)
  $qtodo .= " AND       todo.timestamp_fini                       != 0 ";
if($todo_search_resolution)
  $qtodo .= " AND       YEAR(FROM_UNIXTIME(todo.timestamp_fini))  = '$todo_search_resolution' ";

// Tri
$todo_tri = postdata_vide('todo_tri', 'string', '');
if($todo_tri == 'id')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.id                     DESC  ";
else if($todo_tri == 'prive')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.public                 ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'creation')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'createur')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        membres.pseudonyme          ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'categorie')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.FKtodo_categorie = 0)       ,
                        todo_categorie.categorie    ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'description')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        todo.titre                  ASC   ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'objectif')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  DESC  ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        todo.timestamp              DESC  ";
else if($todo_tri == 'resolution')
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.timestamp_fini = 0)         ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";
else
  $qtodo .= " ORDER BY  todo.valide_admin           ASC   ,
                        (todo.timestamp_fini != 0)        ,
                        todo.timestamp_fini         DESC  ,
                        todo.importance             DESC  ,
                        (todo.FKtodo_roadmap = 0)         ,
                        todo_roadmap.id_classement  ASC   ,
                        todo.timestamp              DESC  ";

// On lance la requête
$qtodo = query($qtodo);

// On initialise le compteur de tâches à faire
$todo_a_faire = 0;

// On prépare tout ça pour l'affichage
for($ntodo = 0; $dtodo = mysqli_fetch_array($qtodo); $ntodo++)
{
  $todo_a_faire            += (!$dtodo['t_resolution']) ? 1 : 0;
  $todo_css[$ntodo]         = ($dtodo['t_resolution']) ? 'todo_resolu' : 'todo_importance_'.$dtodo['t_importance'];
  $todo_css[$ntodo]         = (!$dtodo['t_valide']) ? 'negatif texte_blanc' : $todo_css[$ntodo];
  $todo_id[$ntodo]          = $dtodo['t_id'];
  $todo_titre[$ntodo]       = predata(tronquer_chaine($dtodo['t_titre'], 50, '...'));
  $todo_full_titre[$ntodo]  = predata($dtodo['t_titre']);
  $todo_createur[$ntodo]    = predata($dtodo['m_pseudo']);
  $todo_creation[$ntodo]    = predata(ilya($dtodo['t_creation'], $lang));
  $temp_lang_resolution     = ($lang == 'FR') ? 'Non résolu' : 'Unsolved';
  $todo_resolution[$ntodo]  = ($dtodo['t_resolution']) ? predata(ilya($dtodo['t_resolution'], $lang)) : $temp_lang_resolution;
  $todo_importance[$ntodo]  = (!$dtodo['t_resolution']) ? todo_importance($dtodo['t_importance'], $lang, 1) : $temp_lang_resolution;
  $todo_importance[$ntodo]  = (!$dtodo['t_valide']) ? '<span class="gras">NON VALIDÉ !</span>' : $todo_importance[$ntodo];
  $todo_categorie[$ntodo]   = ($dtodo['c_nom']) ? predata($dtodo['c_nom']) : '';
  $todo_objectif[$ntodo]    = ($dtodo['r_nom']) ? predata($dtodo['r_nom']) : '';
  $todo_prive[$ntodo]       = (!$dtodo['t_public']) ? 'ADMIN' : '';
  $todo_approuve[$ntodo]    = ($dtodo['t_valide']) ? 1 : 0;
}

// Si c'est une tâche seule, on prépare le contenu des détails de la tâche
if($todo_search_id && $ntodo == 1)
{
  mysqli_data_seek($qtodo, 0);
  $dtodo            = mysqli_fetch_array($qtodo);
  $shorturl         = "t=".$todo_search_id;
  $todo_titre_full  = predata($dtodo['t_titre']);
  $todo_soumis_le   = predata(jourfr(date('Y-m-d', $dtodo['t_creation']), $lang));
  $todo_soumis_id   = $dtodo['m_id'];
  $todo_resolu      = ($dtodo['t_resolution']) ? 1 : 0;
  $todo_resolu_le   = predata(jourfr(date('Y-m-d', $dtodo['t_resolution']), $lang));
  $todo_source      = ($dtodo['t_source']) ? predata($dtodo['t_source']) : 0;
  $todo_contenu     = bbcode(predata($dtodo['t_contenu'], 1));
  $todo_modifier    = ($dtodo['t_valide']) ? 'MODIFIER' : 'APPROUVER';
  $todo_supprimer   = ($dtodo['t_valide']) ? 'SUPPRIMER' : 'REJETER';
}

// On calcule le nombre de tâches résolues
$todo_finies    = $ntodo - $todo_a_faire;
$todo_resolues  = format_nombre(calcul_pourcentage($todo_finies, $ntodo),"pourcentage",0);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Menus déroulants pour la recherche

// Années depuis 2012
$select_annees = '<option value="0">&nbsp;</option>';
for($i=date('Y');$i>=2012;$i--)
  $select_annees .= '<option value="'.$i.'">'.$i.'</option>';


// Importance
$select_importance = '';
for($i=0;$i<=5;$i++)
  $select_importance .= '<option value="'.$i.'">'.todo_importance($i, $lang).'</option>';


// Catégories
$qcategories = query("  SELECT    todo_categorie.id ,
                                  todo_categorie.categorie
                        FROM      todo_categorie
                        ORDER BY  todo_categorie.categorie ASC ");
$select_categorie = '<option value="0">Aucune catégorie</option>';
while($dcategories = mysqli_fetch_array($qcategories))
  $select_categorie .= '<option value="'.$dcategories['id'].'">'.predata($dcategories['categorie']).'</option>';


// Objectifs
$qobjectifs = query(" SELECT    todo_roadmap.id ,
                                todo_roadmap.version
                      FROM      todo_roadmap
                      ORDER BY  todo_roadmap.id_classement DESC ");
$select_objectif = '<option value="0">Aucun objectif</option>';
while($dobjectifs = mysqli_fetch_array($qobjectifs))
  $select_objectif .= '<option value="'.$dobjectifs['id'].'">'.predata($dobjectifs['version']).'</option>';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on est dans une tâche spécifique, on update les variables du header

if(isset($_GET['id']))
{
  // Si la tâche n'existe pas, on revient sur l'index
  if(!$_GET['id'] || !$todo_id[0])
    exit(header("Location: ".$chemin."pages/todo/index"));

  // Identification
  $page_nom = "Constate l'état de la tâche #".$todo_id[0];
  $page_url = "pages/todo/index?id=".$todo_id[0];

  // Titre et description
  $page_titre = "Tâche #".$todo_id[0]." : ".$todo_full_titre[0];
  $page_desc  = "Tâche liée au développement de NoBleme : ".$todo_full_titre[0];
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On détermine si on est en mode ajout ou lecture

// Selon le mode, on affiche ou non l'ajout de tâche
$todo_add_hidden = (isset($_GET['add'])) ? '' : ' class="hidden"';

// Si on est en mode ajout, on sélectionne le champ d'ajout
if(isset($_GET['add']) && $todo_admin)
  $onload = "document.getElementById('todo_add_titre').focus(); document.getElementById('todo_add_titre').select();";




/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                   TRADUCTION DU CONTENU MULTILINGUE                                                   */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/

if($lang == 'FR')
{
  // Header
  $trad['titre']                  = "Liste des tâches";
  $trad['soustitre']              = "Suivi du développement de NoBleme";
  $trad['desc1']                  = <<<EOD
La liste des tâches regroupe les rapports de bugs et demandes de fonctionnalités liés au développement de NoBleme. Pour voir les détails d'une tâche dans le tableau, cliquez n'importe où sur la ligne contenant la tâche en question. Vous pouvez faire des recherches dans la liste des tâches à l'aide des champs et menus déroulants situés en haut du tableau.
EOD;
  $trad['desc2']                  = <<<EOD
Si vous avez trouvé un bug sur NoBleme, vous pouvez <a class="gras" href="<?=$chemin?>pages/todo/request?bug">soumettre un rapport de bug</a>.<br>
Si vous avez une idée de fonctionnalité qui pourrait être ajoutée au site, vous pouvez <a class="gras" href="<?=$chemin?>pages/todo/request">quémander un feature</a>.
EOD;

  // Tableau : Titres
  $trad['todo_table_prive']       = "ADMIN";
  $trad['todo_table_importance']  = "IMPORTANCE";
  $trad['todo_table_creation']    = "CRÉATION";
  $trad['todo_table_createur']    = "CRÉATEUR";
  $trad['todo_table_categorie']   = "CATÉGORIE";
  $trad['todo_table_desc']        = "DESCRIPTION";
  $trad['todo_table_objectif']    = "OBJECTIF";
  $trad['todo_table_resolution']  = "RÉSOLUTION";

  // Tableau : Recherche
  $trad['todo_table_s_public']    = "Public";
  $trad['todo_table_s_prive']     = "Privé";
  $trad['todo_table_s_solved']    = "Résolu";
  $trad['todo_table_s_unsolved']  = "Non résolu";

  // Tableau : Barre d'état
  $trad['todo_table_b_trouvee']   = "TÂCHE TROUVÉE";
  $trad['todo_table_b_trouvees']  = "TÂCHES TROUVÉES";
  $trad['todo_table_b_dont']      = "DONT";
  $trad['todo_table_b_et']        = "ET";
  $trad['todo_table_b_soit']      = "SOIT";
  $trad['todo_table_b_finies']    = "FINIES";
  $trad['todo_table_b_todo']      = "À FAIRE";
  $trad['todo_table_b_nbsolved']  = "RÉSOLUES";
  $trad['todo_table_b_reset']     = "CLIQUER ICI POUR REMETTRE À ZÉRO LA RECHERCHE";

  // Tâche
  $trad['todo_task_task']         = "Tâche";
  $trad['todo_task_proposee']     = "Tâche proposée le";
  $trad['todo_task_auteur']       = "par";
  $trad['todo_task_solved']       = "Tâche résolue le";
  $trad['todo_task_source']       = "code source du patch";
}


/*****************************************************************************************************************************************/

else if($lang == 'EN')
{
  // Header
  $trad['titre']                  = "To-do list";
  $trad['soustitre']              = "A peek into NoBleme's development";
  $trad['desc1']                  = <<<EOD
This page is used to list all the bugs and functional changes related to NoBleme's evolution, past and future. Click on any task to open its description. You can do searches within the to-do list using the text fields and dropdown menus located right below the top row of the table below.
EOD;
  $trad['desc2']                  = <<<EOD
If you happen tofind a bug on NoBleme, please <a class="gras" href="<?=$chemin?>pages/todo/request?bug">submit a bug report</a>.<br>
If you have an idea for a new feature that could be added to the website, you can <a class="gras" href="<?=$chemin?>pages/todo/request">suggest a new feature</a>.
EOD;

  // Tableau : Titres
  $trad['todo_table_prive']       = "ADMIN";
  $trad['todo_table_importance']  = "STATUS";
  $trad['todo_table_creation']    = "CREATED";
  $trad['todo_table_createur']    = "REPORTER";
  $trad['todo_table_categorie']   = "CATEGORY";
  $trad['todo_table_desc']        = "DESCRIPTION";
  $trad['todo_table_objectif']    = "GOAL";
  $trad['todo_table_resolution']  = "SOLVED";

  // Tableau : Recherche
  $trad['todo_table_s_public']    = "Public";
  $trad['todo_table_s_prive']     = "Private";
  $trad['todo_table_s_solved']    = "Solved";
  $trad['todo_table_s_unsolved']  = "Unsolved";

  // Tableau : Barre d'état
  $trad['todo_table_b_trouvee']   = "TASK FOUND";
  $trad['todo_table_b_trouvees']  = "TASKS FOUND";
  $trad['todo_table_b_dont']      = "INCLUDING";
  $trad['todo_table_b_et']        = "AND";
  $trad['todo_table_b_soit']      = "TOTAL";
  $trad['todo_table_b_finies']    = "FINISHED";
  $trad['todo_table_b_todo']      = "STILL OPEN";
  $trad['todo_table_b_nbsolved']  = "SOLVED";
  $trad['todo_table_b_reset']     = "CLICK HERE TO RESET YOUR SEARCH";

  // Tâche
  $trad['todo_task_task']         = "Task";
  $trad['todo_task_proposee']     = "Task opened on";
  $trad['todo_task_auteur']       = "by";
  $trad['todo_task_solved']       = "Task solved on";
  $trad['todo_task_source']       = "patch source code";
}





/*****************************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                         AFFICHAGE DES DONNÉES                                                         */
/*                                                                                                                                       */
if(!getxhr()) { /*********************************************************************************/ include './../../inc/header.inc.php';?>

      <div class="texte">

        <h1>
          <?php if(isset($_GET['id'])) { ?>
          <a href="<?=$chemin?>pages/todo/index"><?=$trad['titre']?></a>
          <?php } else { ?>
          <?=$trad['titre']?>
          <?php } ?>
          <?php if($todo_admin) { ?>
          <img class="pointeur" src="<?=$chemin?>img/icones/ajouter.svg" alt="+" onclick="todolist_ajouter_tache();" height="30">
          <?php } ?>
          <a href="<?=$chemin?>pages/doc/rss">
            <img class="pointeur" src="<?=$chemin?>img/icones/rss.svg" alt="RSS" height="30">
          </a>
        </h1>

        <h5>
          <?=$trad['soustitre']?>
        </h5>

        <p>
          <?=$trad['desc1']?>
        </p>

        <p>
          <?=$trad['desc2']?>
        </p>

      </div>

      <?php if($todo_admin) { ?>

      <div id="todolist_add"<?=$todo_add_hidden?>>

        <br>
        <hr class="separateur_contenu">
        <br>

        <div class="texte">

          <form method="POST" id="todolist_add_form">
            <fieldset>

              <label for="todo_add_titre">Titre de la tâche</label>
              <input id="todo_add_titre" name="todo_add_titre" class="indiv" type="text"><br>
              <br>

              <label for="todo_add_description">Description</label>
              <textarea id="todo_add_description" name="todo_add_description" class="indiv" style="height:100px"></textarea><br>
              <br>

              <label for="todo_add_categorie">Catégorie</label>
              <div class="flexcontainer">
                <div style="flex:15">
                  <select id="todo_add_categorie" name="todo_add_categorie" class="indiv">
                    <?=$select_categorie?>
                  </select><br>
                </div>
                <div style="flex:1" class="align_right">
                  <a href="<?=$chemin?>pages/todo/edit_categories">
                    <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
                  </a>
                </div>
              </div>
              <br>

              <label for="todo_add_objectif">Objectif</label>
              <div class="flexcontainer">
                <div style="flex:15">
                  <select id="todo_add_objectif" name="todo_add_objectif" class="indiv">
                    <?=$select_objectif?>
                  </select><br>
                </div>
                <div style="flex:1" class="align_right">
                  <a href="<?=$chemin?>pages/todo/edit_roadmaps">
                    <img src="<?=$chemin?>img/icones/modifier.svg" alt="M" height="30">
                  </a>
                </div>
              </div>
              <br>

              <label for="todo_add_importance">Importance</label>
              <select id="todo_add_importance" name="todo_add_importance" class="indiv">
                <?=$select_importance?>
              </select><br>
              <br>

              <label for="todo_add_public">Visibilité</label>
              <select id="todo_add_public" name="todo_add_public" class="indiv">
                <option value="1">Public</option>
                <option value="0">Privé</option>
              </select><br>
              <br>

              <br>
              <input value="CRÉER LA TÂCHE" type="submit" name="todo_add_go"><br>

            </fieldset>
          </form>

        </div>

        <br>
        <hr class="separateur_contenu">

      </div>

      <?php } ?>

      <br>
      <br>

      <div class="tableau2">

        <input type="hidden" value="" id="todo_tri">
        <?php if(!$todo_admin) { ?>
        <input type="hidden" value="-1" id="todo_search_prive">
        <?php } ?>

        <table class="grid fullgrid texte_noir">
          <thead class="nowrap">

            <tr class="grisclair gras pointeur">
              <th onclick="todolist_tableau('<?=$chemin?>', 'id');">
                ID
              </th>
              <?php if($todo_admin) { ?>
              <th onclick="todolist_tableau('<?=$chemin?>', 'prive');">
                <?=$trad['todo_table_prive']?>
              </th>
              <?php } ?>
              <th onclick="todolist_tableau('<?=$chemin?>', 'importance');">
                <?=$trad['todo_table_importance']?>
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'creation');">
                <?=$trad['todo_table_creation']?>
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'createur');">
                <?=$trad['todo_table_createur']?>
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'categorie');">
                <?=$trad['todo_table_categorie']?>
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'description');">
                <?=$trad['todo_table_desc']?>
              </th>
              <th onclick="todolist_tableau('<?=$chemin?>', 'objectif');">
                <?=$trad['todo_table_objectif']?>
              </th>
              <th colspan="2" onclick="todolist_tableau('<?=$chemin?>', 'resolution');">
                <?=$trad['todo_table_resolution']?>
              </th>
            </tr>

            <tr>

              <th>
                <input class="intable" size="1" id="todo_search_id" value="<?=$todo_preset_id?>" onkeyup="todolist_tableau('<?=$chemin?>');">
              </th>

              <?php if($todo_admin) { ?>
              <th>
                <select class="table_search intable" id="todo_search_prive" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <option value="1"><?=$trad['todo_table_s_public']?></option>
                  <option value="0"><?=$trad['todo_table_s_prive']?></option>
                </select>
              </th>
              <?php } ?>

              <th>
                <select class="table_search intable" id="todo_search_importance" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <?=$select_importance?>
                </select>
              </th>

              <th>
                <select class="table_search intable" id="todo_search_creation" onchange="todolist_tableau('<?=$chemin?>');">
                  <?=$select_annees?>
                </select>
              </th>

              <th>
                <input class="intable" size="1" id="todo_search_createur" onkeyup="todolist_tableau('<?=$chemin?>');">
              </th>

              <th>
                <select class="table_search intable" id="todo_search_categorie" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <?=$select_categorie?>
                </select>
              </th>

              <th>
                <input class="intable" size="1" id="todo_search_description" onkeyup="todolist_tableau('<?=$chemin?>');">
              </th>

              <th>
                <select class="table_search intable" id="todo_search_objectif" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <?=$select_objectif?>
                </select>
              </th>

              <th>
                <select class="table_search intable" id="todo_search_etat" onchange="todolist_tableau('<?=$chemin?>');">
                  <option value="-1">&nbsp;</option>
                  <option value="1"><?=$trad['todo_table_s_solved']?></option>
                  <option value="0"><?=$trad['todo_table_s_unsolved']?></option>
                </select>
              </th>
              <th>
                <select class="table_search intable" id="todo_search_resolution" onchange="todolist_tableau('<?=$chemin?>');">
                  <?=$select_annees?>
                </select>
              </th>

            </tr>

          </thead>
          <tbody class="align_center" id="todolist_tbody">

            <?php } ?>

            <tr class="pointeur nowrap" onclick="todolist_tableau('<?=$chemin?>', 'raz');">
              <?php if($todo_admin) { ?>
              <td colspan="10" class="noir texte_blanc gras">
              <?php } else { ?>
              <td colspan="9" class="noir texte_blanc gras">
              <?php } ?>
                <?php if($ntodo > 1) { ?>
                <?=$ntodo?> <?=$trad['todo_table_b_trouvees']?>
                <?php } else { ?>
                <?=$ntodo?> <?=$trad['todo_table_b_trouvee']?>
                <?php } ?>
                &nbsp;<span class="texte_positif"><?=$trad['todo_table_b_dont']?> <?=$todo_finies?> <?=$trad['todo_table_b_finies']?></span>
                &nbsp;<span class="texte_negatif"><?=$trad['todo_table_b_et']?> <?=$todo_a_faire?> <?=$trad['todo_table_b_todo']?></span>
                &nbsp;<span class="texte_neutre"><?=$trad['todo_table_b_soit']?> <?=$todo_resolues?> <?=$trad['todo_table_b_nbsolved']?></span>
                <?php if($todo_preset_id || (getxhr() && $todo_tri != 'raz')) { ?>
                &nbsp;- &nbsp;<span><?=$trad['todo_table_b_reset']?></span>
                <?php } ?>
              </td>
            </tr>

            <?php for($i=0;$i<$ntodo;$i++) { ?>

            <tr class="nowrap <?=$todo_css[$i]?> pointeur" onclick="todolist_afficher_tache('<?=$chemin?>', <?=$todo_id[$i]?>);">
              <td>
                <?=$todo_id[$i]?>
              </td>
              <?php if($todo_admin) { ?>
              <td class="gras">
                <?=$todo_prive[$i]?>
              </td>
              <?php } ?>
              <td>
                <?=$todo_importance[$i]?>
              </td>
              <td>
                <?=$todo_creation[$i]?>
              </td>
              <td>
                <?=$todo_createur[$i]?>
              </td>
              <td>
                <?=$todo_categorie[$i]?>
              </td>
              <td class="gras">
                <?=$todo_titre[$i]?>
              </td>
              <td>
                <?=$todo_objectif[$i]?>
              </td>
              <td colspan="2">
                <?=$todo_resolution[$i]?>
              </td>
            </tr>

            <?php if($todo_search_id && $ntodo == 1) { ?>

            <tr class="grisclair align_left">
              <?php if($todo_admin) { ?>
              <td colspan="10">
              <?php } else { ?>
              <td colspan="9">
              <?php } ?>

                <div class="alinea">
                  <br>

                  <span class="moinsgros gras">
                    <a href="<?=$chemin?>pages/todo/index?id=<?=$todo_id[$i]?>"><?=$trad['todo_task_task']?> #<?=$todo_id[$i]?></a> : <?=$todo_titre_full?>
                  </span><br>

                  <span class="italique">
                    <?=$trad['todo_task_proposee']?> <?=$todo_soumis_le?> <?=$trad['todo_task_auteur']?> <a class="gras" href="<?=$chemin?>pages/user/user?id=<?=$todo_soumis_id?>"><?=$todo_createur[$i]?></a><br>
                    <?php if($todo_resolu) { ?>
                      <?=$trad['todo_task_solved']?> <?=$todo_resolu_le?>
                    <?php if($todo_source) { ?>
                    : <a href="<?=$todo_source?>"><?=$trad['todo_task_source']?></a>
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

                  <?php if($todo_admin) { ?>

                  <br>
                  <br>

                  <?php if($todo_approuve[$i]) { ?>
                  <a class="spaced" href="<?=$chemin?>pages/todo/resolu?id=<?=$todo_id[$i]?>">
                    <button class="button button-outline">RÉSOLU</button>
                  </a>
                  &nbsp;
                  <?php } ?>

                  <a class="spaced" href="<?=$chemin?>pages/todo/edit?id=<?=$todo_id[$i]?>">
                    <button class="button button-outline"><?=$todo_modifier?></button>
                  </a>
                  &nbsp;

                  <a class="spaced" href="<?=$chemin?>pages/todo/delete?id=<?=$todo_id[$i]?>">
                    <button class="button button-outline"><?=$todo_supprimer?></button>
                  </a>
                  <br>

                  <?php } ?>

                  <br>
                </div>

              </td>
            </tr>

            <?php } else { ?>

            <tr class="hidden grisclair align_left" id="todolist_ligne_<?=$todo_id[$i]?>">
              <?php if($todo_admin) { ?>
              <td colspan="10" id="todolist_cellule_<?=$todo_id[$i]?>">
              <?php } else { ?>
              <td colspan="9" id="todolist_cellule_<?=$todo_id[$i]?>">
              <?php } ?>
                &nbsp;
              </td>
            </tr>

            <?php } ?>

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